<?php

/**
 * 模型字段
 * @author hdxj <houdunwangxj@gmail.com>
 */
class ModelFieldModel extends Model {
	//表
	public $table = "field";
	//模型mid
	private $_mid;
	//字段缓存
	private $_field;
	//模型缓存
	private $_model;
	//前台投稿不允许隐藏的字段
	static public $NoAllowHide = array('title', 'cid');
	//不允许删除的字段
	static public $NoAllowDelete = array('title', 'cid');
	//不允许禁用的字段
	static public $NoAllowForbidden = array('title', 'cid');
	//自动完成
	public $auto = array( array("set", "serialize", "function", 1, 3), array("table_name", "_table_name", "method", 2, 3));
	public function _table_name($v) {
		$table_type = Q('table_type', 1, 'intval');
		if ($table_type == 1) {
			$table = $this -> _model[$this -> _mid]['table_name'];
		} else {
			$table = $this -> _model[$this -> _mid]['table_name'] . '_data';
		}
		return $table;
	}

	/**
	 * 构造函数
	 */
	public function __construct($mid) {
		parent::__construct();
		$this -> _mid = $mid;
		//字段所在表模型信息
		$this -> _model = cache("model", false);
		//字段缓存
		$this -> _field = cache($this -> _mid, false, FIELD_CACHE_PATH);
	}

	/**
	 * 删除字段
	 * @return mixed
	 */
	public function delField() {
		$fid = Q('fid');
		if (!$fid) {
			$this -> error = '参数错误';
			return false;
		}
		//获得字段信息
		$field = M('field') -> find($fid);
		//检测字段是否存在
		if ($this -> fieldExists($field['field_name'], $field['table_name'])) {
			//删除表字段
			$sql = "ALTER TABLE " . C("DB_PREFIX") . $field['table_name'] . " DROP " . $field['field_name'];
			if (!$this -> exe($sql)) {
				$this -> error = '删除表字段失败';
				return false;
			}
		}
		//删除字段表记录
		$this -> del($fid);
		if ($this -> updateCache()) {
			return true;
		}
	}

	//添加自定义字段
	public function addField($data) {
		$method = $data['field_type'];
		if (!method_exists($this, $method)) {
			$this -> error = '字段类型错误';
			return false;
		}
		$data = $this -> $method($data, null);
		if ($this -> create($data)) {
			//修改表结构
			if ($this -> alterTableField()) {
				if ($this -> add()) {
					$this -> updateCache(Q('mid', 0, 'intval'));
					return true;
				} else {
					$this -> error = '添加字段失败';
				}
			}
		}

	}

	//修改字段
	public function editField($data) {
		$method = $data['field_type'];
		if (!method_exists($this, $method)) {
			$this -> error = '字段类型错误';
			return false;
		}
		$data = $this -> $method($data, null);
		if ($this -> create($data)) {
			//修改表结构
			$state = $this -> save();
			if ($state) {
				$this -> updateCache(Q('mid', 0, 'intval'));
				return true;
			} else {
				$this -> error = '修改字段失败';
			}
		}

	}

	//修改表字段
	public function alterTableField() {
		$set = Q('set');
		$table_type = Q('table_type', 1, 'intval');
		if ($table_type == 1) {
			$table = $this -> _model[$this -> _mid]['table_name'];
		} else {
			$table = $this -> _model[$this -> _mid]['table_name'] . '_data';
		}
		$field_name = Q('field_name', null, 'strtolower');
		if (!$field_name) {
			$this -> error = '字段名不能为空';
			return false;
		}
		//SQL
		switch ($_POST['field_type']) {
			case "title" :
				//标题
				$_field = $field_name . " char(100) NOT NULL DEFAULT ''";
				break;
			case "flag" :
				$flag = cache('flag');
				//标题
				$_field = $field_name . " set('" . implode("','", $flag) . "') DEFAULT NULL";
				break;
			case "tag" :
				//tag
				$_field = $field_name . " VARCHAR(255) NOT NULL DEFAULT ''";
				break;
			case "cid" :
				$_field = $field_name . " smallint(5) unsigned NOT NULL DEFAULT '0'";
				break;
			case "content" :
				//正文
				$_field = '`' . $field_name . '`' . " TEXT";
				break;
			case "template" :
				//选择模板
				$_field = '`' . $field_name . '`' . " VARCHAR(255) NOT NULL DEFAULT ''";
				break;
			case "thumb" :
				//缩略图
				$_field = '`' . $field_name . '`' . " VARCHAR(255) NOT NULL DEFAULT ''";
				break;
			case "input" :
				$_field = $field_name . " VARCHAR(255) NOT NULL DEFAULT ''";
				break;
			case "number" :
				if ($set['field_type'] == 'decimal') {
					$e = isset($set['num_decimal']) ? $set['num_decimal'] : 0;
					$_field = $field_name . " DECIMAL({$set['num_integer']},{$e}) NOT NULL DEFAULT 0";
				} else {
					$_field = $field_name . " {$set['field_type']}({$set['num_integer']}) NOT NULL DEFAULT 0";
				}
				break;
			case "textarea" :
				$_field = '`' . $field_name . '`' . " TEXT";
				break;
			case "editor" :
				$_field = '`' . $field_name . '`' . " TEXT";
				break;
			case "image" :
				$_field = '`' . $field_name . '`' . " VARCHAR(255) NOT NULL DEFAULT ''";
				break;
			case "images" :
				$_field = '`' . $field_name . '`' . " MEDIUMTEXT";
				break;
			case "files" :
				$_field = '`' . $field_name . '`' . " MEDIUMTEXT";
				break;
			case "box" :
				//checkbox radio select
				$_field = '`' . $field_name . '`' . " CHAR(80) NOT NULL DEFAULT ''";
				break;
			case "datetime" :
				$_field = '`' . $field_name . '`' . " int(10) NOT NULL DEFAULT 0";
				break;
		}
		//修改或添加字段
		$sql = "ALTER TABLE " . C("DB_PREFIX") . $table . " ADD " . $_field;
		if ( M() -> exe($sql)) {
			return true;
		} else {
			$this -> error = '修改表结构失败';
			return false;
		}
	}

	//更新字段缓存
	public function updateCache($mid=null) {
		$mid = $mid?$mid:intval($this -> _mid);
		if (!isset($this -> _model[$mid])) {
			$this -> error = '模型不存在';
			return false;
		}
		//查找当模型所有字段信息
		$ModelField = M("field");
		$fieldData = $ModelField -> where("mid=$mid") -> order('fieldsort ASC') -> all();
		$cacheData = array();
		if (!empty($fieldData)) {
			foreach ($fieldData as $field) {
				$field['set'] = unserialize($field['set']);
				$cacheData[$field['field_name']] = $field;
			}
		}
		if (!cache($mid, $cacheData, FIELD_CACHE_PATH)) {
			$this -> error = '更新字段缓存失败';
			return false;
		} else {
			$this -> updateTableFieldCache();
			return true;
		}
	}

	//更新Content表字段缓存
	public function updateTableFieldCache() {
		$dirArr = array('temp/Hdcms/Content/Table', 'temp/Hdcms/Index/Table');
		foreach ($dirArr as $dir) {
			if (is_dir($dir)) {
				if (!is_writable($dir)) {
					$this -> error = '表字段缓存目录删除失败';
					return false;
				} else {
					if (Dir::del($dir)) {
						$this -> error = '表字段缓存目录删除失败';
						return false;
					}
				}
			}
		}
		return true;
	}

	//标题字段
	private function title($fieldInfo, $value) {
		return $value;
	}

	//缩略图
	private function thumb($fieldInfo, $value) {
		return $fieldInfo;
	}

	//模板
	private function template($fieldInfo, $value) {
		return $fieldInfo;
	}

	//栏目选择
	private function cid($fieldInfo, $value) {
		return $fieldInfo;
	}

	//文章内容
	private function content($fieldInfo, $value) {
		return $fieldInfo;
	}

	//Flag文章属性
	private function flag($fieldInfo, $value) {
		return $fieldInfo;
	}

	//文本字段
	private function input($fieldInfo, $value) {
		return $fieldInfo;
	}

	//多行文本
	private function textarea($fieldInfo, $value) {
		return $fieldInfo;
	}

	//数字
	private function number($fieldInfo, $value) {
		return $fieldInfo;
	}

	//选项
	private function box($fieldInfo, $value) {
		$options = String::toSemiangle($fieldInfo['set']['options']);
		$fieldInfo['set']['options'] = str_replace(' ', '', $options);
		return $fieldInfo;
	}

	//编辑器
	private function editor($fieldInfo, $value) {
		return $fieldInfo;
	}

	//单图上传
	private function image($fieldInfo, $value) {
		return $fieldInfo;
	}

	//多图上传
	private function images($fieldInfo, $value) {
		return $fieldInfo;
	}

	//日期时间
	private function datetime($fieldInfo, $value) {
		return $fieldInfo;
	}

	//文件上传
	private function files($fieldInfo, $value) {
		return $fieldInfo;
	}

}
