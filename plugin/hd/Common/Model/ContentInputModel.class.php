<?php
/**
 * 添加数据时前期处理
 */
class ContentInputModel {
	//字段缓存
	private $_field;
	private $_mid;
	//不需要处理的字段
	private $_noDealField = array('aid', 'cid', 'mid', 'favorites', 'comment_num', 'read_credits', 'new_window');
	/**
	 * 构造函数
	 * @param int $mid 模型mid
	 */
	public function __construct($mid) {
		$this -> _field = cache($mid, false, FIELD_CACHE_PATH);
		$this -> _mid = $mid;
	}

	/**
	 * 获得入库数据
	 * @param $actionType 1 添加  2 修改
	 */
	public function get(array $InsertData) {
		//作者uid
		$InsertData['uid'] = session('uid');
		//修改时间
		$InsertData['updatetime'] = time();
		//文章模型
		$ContentModel = ContentModel::getInstance($this -> _mid);
		//没有添加内容时初始设置
		if (!isset($InsertData['content'])) {
			$InsertData['content'] = '';
		}
		//自动提取文章描述
		if (isset($InsertData['description']) && empty($InsertData['description'])) {
			$InsertData['description'] = mb_substr(strip_tags($InsertData['content']), 0, 100, 'utf-8');
		}
		//自动提取关键字
		if (isset($InsertData['keywords']) && empty($InsertData['keywords'])) {
			$description = preg_replace("@\s@is", "", $InsertData['description']);
			$words = String::splitWord($description);
			//没有分词不处理
			if (!empty($words)) {
				$i = 0;
				$k = "";
				foreach ($words as $w => $id) {
					$k .= $w . ",";
					$i++;
					if ($i > 8)
						break;
				}
				$InsertData['keywords'] = substr($k, 0, -1);
			}
		}
		foreach ($this->_field as $field => $fieldInfo) {
			$set = $fieldInfo['set'];
			if (in_array($field, $this -> _noDealField)) {
				continue;
			}
			$METHOD = $fieldInfo['field_type'];
			if (method_exists($this, $METHOD) && isset($InsertData[$field])) {
				if ($fieldInfo['table_type'] == 1) {
					$Value = $this -> $METHOD($fieldInfo, $InsertData[$field]);
					$InsertData[$field] = $Value;
				} else {
					$Value = $this -> $METHOD($fieldInfo, $InsertData[$field]);
					$InsertData[$fieldInfo['table_name']][$field] = $Value;
					//删除旧数据
					unset($InsertData[$field]);
				}
			}
			//值唯一验证
			if ((int)$fieldInfo['isunique'] == 1) {
				if ( M($fieldInfo['table_name']) -> where($field . "='$Value'") -> find()) {
					$this -> error = $fieldInfo['title'] . '已经存在';
					return false;
				}
			}
			$validateRule = array();
			//验证时间 1 有这个表单就验证  2 必须验证
			$validateOccasion = (int)$fieldInfo['required'] ? 2 : 3;
			//设置验证规则
			if (isset($set['maxlength']) && !empty($set['maxlength'])) {
				$maxlength = (int)$set['maxlength'];
				$minlength = (int)$set['minlength'];
				if ($maxlength && $maxlength > $minlength) {
					$validateRule[] = array($field, "minlen:$minlength", $fieldInfo['title'] . " 数量不能小于{$minlength}个字", $validateOccasion, 3);
					$validateRule[] = array($field, "maxlen:$maxlength", $fieldInfo['title'] . " 数量不能大于{$maxlength}个字", $validateOccasion, 3);
				}
			}
			//验证规则
			if (isset($fieldInfo['validate']) && !empty($fieldInfo['validate'])) {
				$regexp = $fieldInfo['validate'];
				$error = empty($fieldInfo['error']) ? $fieldInfo['title'] . ' 输入错误' : $set['error'];
				$validateRule[] = array($field, "regexp:$regexp", $error, $validateOccasion, 3);
			}
			//必须输入验证
			if (isset($fieldInfo['required']) && (int)$fieldInfo['required'] == 1) {
				$validateRule[] = array($field, "nonull", $fieldInfo['title'] . ' 不能为空', $validateOccasion, 3);
			}
			if (!empty($validateRule)) {
				foreach ($validateRule as $validate) {
					$ContentModel -> addValidate($validate);
				}
			}
		}

		//如果没有缩略图时，删除图片属性
		if (!isset($InsertData['flag'])) {
			$InsertData['flag'] = '';
		}
		$flag = explode(',', $InsertData['flag']);
		if (empty($InsertData['thumb'])) {
			if (false !== $k = array_search('图片', $flag)) {
				unset($flag[$k]);
			}
		} else {
			$flag[] = '图片';
		}
		$InsertData['flag'] = implode(',', array_unique($flag));
		return $InsertData;
	}

	//标题字段
	private function title($fieldInfo, $value) {
		return htmlspecialchars(trim($value));
	}

	//缩略图
	private function thumb($fieldInfo, $value) {
		//提取内容第n张图为缩略图
		if (isset($_POST['auto_thumb']) && $_POST['auto_thumb'] == 1) {
			if (preg_match_all('/(src)=([\'"]?)([^\'">]+\.(jpg|jpeg|png|gif))\2/is', $_POST['content'], $matchData, PREG_PATTERN_ORDER)) {
				$num = (int)$_POST['auto_thumb_num'] - 1;
				if (isset($matchData[0][$num])) {
					$Attachment = new Attachment();
					$value = $Attachment -> download($matchData[0][$num], array('jpg', 'gif', 'jpeg', 'png'), $this -> _mid);
					if ($value) {
						return trim(str_replace(__ROOT__, '', preg_replace('/src=(\'|")|[\'"]|\s/i', '', $value)), '/');
					}
				}
			}
		}
		//没有设置自动提取时的处理
		return trim(str_replace(__ROOT__, '', $value), '/');
	}

	//模板选择
	private function template($fieldInfo, $value) {
		return str_replace(ROOT_PATH, '', trim($value));
	}

	//栏目选择
	private function cid($fieldInfo, $value) {
		return (int)$value;
	}

	//文章内容
	private function content($fieldInfo, $value) {
		if (empty($value)) {
			return $value;
		}
		if (isset($_POST['down_remote_pic']) && $_POST['down_remote_pic'] == 1) {
			$Attachment = new Attachment();
			$value = $Attachment -> download($value, array('jpg', 'gif', 'jpeg', 'png'), $this -> _mid);
		}
		return $value;
	}

	//Flag文章属性
	private function flag($fieldInfo, $value) {
		if (empty($value) || !is_array($value)) {
			return '';
		}
		$flagCache = cache($this->_mid,false,FLAG_CACHE_PATH);
		$data = array();
		foreach ($value as $flag) {
			if (!in_array($flag, $flagCache)) {
				continue;
			}
			$data[] = $flag;
		}
		return implode(',', $data);
	}

	//文本字段
	private function input($fieldInfo, $value) {
		return htmlspecialchars(trim($value));
	}

	//多行文本
	private function textarea($fieldInfo, $value) {
		return htmlspecialchars(trim($value));
	}

	//数字
	private function number($fieldInfo, $value) {
		$set = $fieldInfo['set'];
		$field_type = isset($set['field_type']) ? $set['field_type'] : 'int';
		switch($field_type) {
			case "decimal" :
				return floatval($value);
			default :
				return intval($value);
		}
	}

	//选项
	private function box($fieldInfo, $value) {
		$set = $fieldInfo['set'];
		if ($set['form_type'] == 'checkbox') {
			if (!is_array($value) || empty($value)) {
				return false;
			}
			return implode(',', $value);
		} else {
			return $value;
		}
	}

	//编辑器
	private function editor($fieldInfo, $value) {
		if (isset($_POST['down_remote_pic']) && $_POST['down_remote_pic'] == 1) {
			$Attachment = new Attachment();
			$value = $Attachment -> download($value);
		}
		return $value;
	}

	//单图上传
	private function image($fieldInfo, $value) {
		return $value;
	}

	//多图上传
	private function images($fieldInfo, $value) {
		return serialize($value);
	}

	//日期时间
	private function datetime($fieldInfo, $value) {
		if (empty($value)) {
			$value = time();
		} else {
			$value = strtotime($value);
		}
		return $value;
	}

	//文件上传
	private function files($fieldInfo, $value) {
		return serialize($value);
	}

}
