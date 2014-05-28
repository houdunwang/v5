<?php
/**
 * 添加、删除文章时表单处理
 */
class ContentFormModel extends CommonModel {
	//表
	public $table = "field";
	//模型mid
	private $_mid;
	//字段缓存
	private $_field;
	//模型缓存
	private $_model;
	//表单验证
	public $formValidate = array();
	//旧数据
	private $_data;

	//构造函数
	public function __init() {
		$this -> _mid = Q("mid", NULL, "intval");
		//字段所在表模型信息
		$this -> _model = cache("model", false);
		//字段缓存
		$this -> _field = F($this -> _mid, false, FIELD_CACHE_PATH);
	}

	/**
	 * 编辑与修改动作时根据不同字段类型获取界面
	 * @param array $data 编辑数据时的数据
	 * @return string
	 */
	public function get($data = array()) {
		$this -> _data = $data;
		//当前模型字段缓存
		$fieldCache = cache($this -> _mid, false, FIELD_CACHE_PATH);
		if (!$fieldCache) {
			return array();
		}
		$form = array();
		foreach ($fieldCache as $field) {
			//禁用字段不处理
			if ($field['field_state'] == 0) {
				continue;
			}
			//前台投稿字段过滤
			if ($field['isadd'] == 0 && APP == 'Member') {
				continue;
			}
			//表单值  添加时使用set['default'] 编辑时使用data数据
			$value = isset($data[$field['field_name']]) ? $data[$field['field_name']] : (isset($field['set']['default']) ? $field['set']['default'] : '');
			$value = trim($value);
			//处理函数
			$function = $field['field_type'];
			//是否为基本字段，基本字段在左侧 显示
			$isbase = intval($field['isbase']) ? 'base' : 'nobase';
			$field['form'] = $this -> $function($field, $value);
			//设置验证规则
			$this -> setValidateRule($field, $value);
			//验证规则
			$form[$isbase][] = $field;
		}
		//编辑验证规则为合法的JS格式
		$this -> validateCompileJs();
		return $form;
	}

	//编辑验证规则为合法的JS格式
	protected function validateCompileJs() {
		$va = array();
		foreach ($this -> formValidate as $field => $value) {
			$rule = $error = array();
			foreach ($value['rule'] as $r => $func) {
				$rule[] = $r . ':' . $func;
			}
			foreach ($value['error'] as $e => $msg) {
				$error[] = $e . ":'$msg'";
			}
			$message = empty($value['message']) ? '' : $value['message'];
			$va[] = $field . ':{rule:{' . implode(',', $rule) . '},error:{' . implode(',', $error) . '},message:"' . $message . '"}';
		}
		$this -> formValidate = '{' . implode(',', $va) . '}';
	}

	//设置验证规则
	protected function setValidateRule($field, $value) {
		$set = $field['set'];
		//设置验证规则
		$validate = array('rule' => array(), 'error' => array(), 'message' => '');
		if ((int)$field['required']) {
			$validate['rule']['required'] = 1;
			$validate['error']['required'] = $field['title'] . '不能为空';
		}
		if (!empty($field['validate'])) {
			$validate['rule']['regexp'] = $field['validate'];
			$validate['error']['regexp'] = empty($field['error']) ? '输入错误' : $set['error'];
		}
		//验证长度
		if (!empty($field['minlength'])) {
			$validate['rule']['minlen'] = (int)$field['minlength'];
			$validate['error']['minlen'] = '不能少于' . (int)$field['minlength'] . '个字';
		}
		//验证长度
		if (!empty($field['maxlength'])) {
			$validate['rule']['maxlen'] = (int)$field['maxlength'];
			$validate['error']['maxlen'] = '不能超过' . (int)$field['maxlength'] . '个字';
		}

		if (!empty($field['tips'])) {
			$validate['message'] = $field['tips'];
		}
		$this -> formValidate[$field['field_name']] = $validate;
	}

	//Input字段
	protected function input($field, $value) {
		$set = $field['set'];
		//表单类型
		$type = $set['ispasswd'] == 1 ? "password" : "text";
		return "<input style=\"width:{$set['size']}px\" type=\"{$type}\" class=\"{$field['css']}\" name=\"{$field['field_name']}\" value=\"$value\"/>";
	}

	//tag字段
	protected function tag($field, $value) {
		$set = $field['set'];
		//表单类型
		return "<input style=\"width:{$set['size']}px\" type=\"text\" class=\"{$field['css']}\" name=\"{$field['field_name']}\" value=\"$value\"/>";
	}

	//Input字段
	protected function number($field, $value) {
		$set = $field['set'];
		//表单类型
		return "<input style=\"width:{$set['size']}px\" type=\"text\" class=\"{$field['css']}\" name=\"{$field['field_name']}\" value=\"$value\"/>";
	}

	//Title标题字段
	protected function title($field, $value) {
		$set = $field['set'];
		if (APP != 'Member') {
			$color = isset($this -> _data['color']) ? $this -> _data['color'] : '';
			if (isset($this -> _data['new_window']) && $this -> _data['new_window'] == 1) {
				$new_window = 'checked=""';
			} else {
				$new_window = '';
			}
			return '<input id="title" type="text" name="' . $field['field_name'] . '" style="width:' . $set['size'] . 'px" class="title ' . $field['css'] . '" value="' . $value . '">
                        <label class="checkbox inline">
                            	标题颜色 <input type="text" name="color" class="w60" value="' . $color . '">
                        </label>
                        <button type="button" onclick="selectColor(this,\'color\')" class="hd-cancel">选取颜色</button>
                        <label class="checkbox inline">
                            <input type="checkbox" name="new_window" value="1" ' . $new_window . '> 新窗口打开
                        </label>
                        <span id="hd_' . $field['field_name'] . '"></span>';
		} else {
			return "<input type='text' name='{$field['field_name']}' value='$value' class='w300'/>";
		}
	}

	//文章Flag属性如推荐、置顶等
	protected function flag($field, $value) {
		$flag = cache($this -> _mid, false, FLAG_CACHE_PATH);
		$set = $field['set'];
		if (!empty($value)) {
			$value = explode(',', $value);
		}
		$form = '';
		foreach ($flag as $N => $f) {
			$checked = "";
			if (!empty($value)) {
				if (in_array($f, $value)) {
					$checked = 'checked=""';
				}
			}
			$form .= '<label class="checkbox inline">
					<input type="checkbox" name="flag[]" value="' . $f . '" ' . $checked . '> 
                                	' . $f . '[' . ($N + 1) . ']</label>';
		}
		return $form;
	}

	//栏目cid
	protected function cid($field, $value) {
		$category = cache('category');
		$set = $field['set'];
		$cid = Q('cid', 0, 'intval');
		return $category[Q('cid')]['catname'] . "<input type='hidden' name='cid' value='$cid'/>";
	}

	//栏目文本域
	protected function textarea($field, $value) {
		$set = $field['set'];
		return "<textarea class=\"{$field['css']}\" name=\"{$field['field_name']}\" style=\"width:{$set['width']}px;height:{$set['height']}px\">{$value}</textarea>";
	}

	//模板选择
	protected function template($field, $value) {
		$set = $field['set'];
		return '<input style="width:300px;" type="text" name="' . $field['field_name'] . '" value="' . $value . '" onfocus="select_template(\'' . $field['field_name'] . '\');">
                        <button class="hd-cancel-small" type="button" onclick="select_template(\'' . $field['field_name'] . '\');">选择模板</button>';
	}

	//文章正文
	protected function content($field, $value) {
		if (APP != 'Member') {
			$category = cache('category');
			$set = $field['set'];
			$html = tag('ueditor', array("name" => $field['field_name'], "content" => $value, "height" => 300));
			$html .= '
			<div class="editor_set control-group">
                                <label class="checkbox inline">
                                    <input type="checkbox" name="down_remote_pic" value="1"/>下载远程图片
                                </label>
                                <label class="checkbox inline">
                                    <input type="checkbox" name="auto_desc" value="1"/>截取内容
                                </label>
                                <label class="checkbox inline">
                                    <input type="text" value="200" class="w80" name="auto_desc_length"> 字符至内容摘要
                                </label>
                                &nbsp;&nbsp;&nbsp;
                                <label class="checkbox inline">
                                    <input type="checkbox" name="auto_thumb" value="1"/>获取内容第
                                </label>
                                <label class="checkbox inline">
                                    <input type="text" class="w80" value="1" name="auto_thumb_num">
                                     	张图片作为缩略图
                                </label>
                            </div>';
		} else {
				$html=tag('ueditor', array("name" => $field['field_name'], "content" => $value, "height" => 300));
		}
		return $html;
	}

	//选项radio,select,checkbox
	protected function box($field, $value) {
		$set = $field['set'];
		//表单值
		$_v = explode(",", $set['options']);
		$options = array();
		foreach ($_v as $n => $p) {
			$p = explode("|", $p);
			$options[$p[0]] = $p[1];
		}
		$h = '';
		//select添加select
		if ($set['form_type'] == 'select') {
			$h .= "<select name='{$f['field_name']}'>";
		}
		foreach ($options as $v => $text) {
			switch ($set['form_type']) {
				case "radio" :
					$checked = $value == $v ? 'checked=""' : '';
					$h .= "<label><input type='radio' name=\"{$field['field_name']}\" value=\"{$v}\" {$checked}/>{$text}</label>&nbsp;&nbsp;";
					break;
				case "checkbox" :
					$s = explode(",", $value);
					$checked = in_array($v, $s) ? "checked='checked'" : "";
					$h .= "<label><input type='checkbox' name=\"{$field['field_name']}[]\" value=\"{$v}\" {$checked}/> {$text}</label> ";
					break;
				case "select" :
					$selected = $value == $v ? "selected='selected'" : "";
					$h .= "<option name=\"{$field['field_name']}\" value=\"{$v}\" {$selected}> {$text}</option>";
					break;
			}
		}
		if ($set['form_type'] == 'select') {
			$h .= "</select>";
		}
		return $h;
	}

	//缩略图
	protected function thumb($field, $value) {
		$src = empty($value) ? __ROOT__ . '/hd/Common/static/img/upload-pic.png' : __ROOT__ . '/' . $value;
		$fieldName = $field['field_name'];
		return '  <img id="' . $fieldName . '" src="' . $src . '" style="cursor: pointer;width:145px;height:123px;margin-bottom:5px;" onclick="file_upload({id:\'' . $fieldName . '\',type:\'thumb\',num:1,name:\'' . $fieldName . '\'})">
                        <input type="hidden" name="' . $fieldName . '" value="' . $value . '"/>
                        <button type="button" class="hd-cancel-small" onclick="file_upload({id:\'' . $fieldName . '\',type:\'thumb\',num:1,name:\'' . $fieldName . '\'})">上传图片</button>
                        &nbsp;&nbsp;
                        <button type="button" class="hd-cancel-small" onclick="remove_thumb(this)">取消上传</button>';
	}

	//日期Date
	protected function datetime($field, $value) {
		$set = $field['set'];
		$format = array("Y-m-d", "Y/m/d H:i:s", "H:i:s");
		$value = empty($value) ? "" : date($format[$set['format']], $value);
		//默认值
		$h = "<input type='text' id='{$field['field_name']}' name='{$field['field_name']}' value='$value' class='w150'/>";
		$format = array("yyyy-MM-dd", "yyyy/MM/dd HH:mm:ss", "HH:mm:ss");
		$h .= "<script>$('#{$field['field_name']}').calendar({format: '" . $format[$set['format']] . "'});</script>";
		return $h;
	}

	//多图上传
	protected function images($field, $value) {
		$set = $field['set'];
		$id = "img_" . $field['field_name'];
		//允许上传数量
		$num = $set['num'];
		//已经上传图片
		if (!empty($value)) {
			$img = unserialize($value);
			$num = $num - count($img['path']);
		}
		$h = "<fieldset class='img_list'>
<legend style='color:#666;font-size: 12px;line-height: 25px;padding: 0px 10px; text-align:center;margin: 0px;'>图片列表</legend>
<center>
<div style='color:#666;font-size:12px;margin-bottom: 5px;'>
您最多可以同时上传
<span style='color:red' id='hd_up_{$id}'>$num</span>
张图片
</div>
</center>
<div id='$id' class='picList'>";
		if (!empty($value)) {
			$img = unserialize($value);
			if (!empty($img) && is_array($img)) {
				$h .= '<ul>';
				foreach ($img['path'] as $N => $path) {
					$alt = $img['alt'][$N];
					$h .= "<li><div class='img'><img src='" . __ROOT__ . "/" . $path . "' style='width:135px;height:135px;'/>";
					$h .= "<a href='javascript:;' onclick='remove_upload(this,\"{$id}\")'>X</a>";
					$h .= "</div>";
					$h .= "<input type='hidden' name='" . $field['field_name'] . "[path][]'  value='" . $path . "' src='" . __ROOT__ . '/' . $path . "' class='w400 images'/> ";
					$h .= "<input type='text' name='" . $field['field_name'] . "[alt][]' value='" . $alt . "' placeholder='图片描述...'/>";
					$h .= "</li>";
				}
				$h .= '</ul>';
			}
		}
		$options = json_encode(array('id' => $id, 'type' => 'images', 'num' => $num, 'name' => $field['field_name'], 'filetype' => 'jpg,png,gif,jpeg', 'upload_img_max_width' => $set['upload_img_max_width'], 'upload_img_max_height' => $set['upload_img_max_height']));
		$h .= "</div>
</fieldset>
<button class='hd-cancel-small' onclick='file_upload({$options})' type='button'>上传图片</button>";
		$h .= " <span class='{$field['field_name']} validate-message'>" . $field['tips'] . "</span>";
		return $h;
	}

	//单张图
	private function image($field, $value) {
		$set = $field['set'];
		$id = "img_" . $field['field_name'];
		$path = isset($value) ? $value : "";
		$src = !empty($value) ? __ROOT__ . '/' . $value : "";
		$options = json_encode(array('id' => $id, 'type' => 'image', 'num' => 1, 'name' => $field['field_name'], 'filetype' => 'jpg,png,gif,jpeg', 'upload_img_max_width' => $set['upload_img_max_width'], 'upload_img_max_height' => $set['upload_img_max_height']));
		$h = "<input id='$id' type='text' name='" . $field['field_name'] . "'  value='$path' src='$src' class='w300 images' onmouseover='view_image(this)'/> ";
		$h .= "<button class='hd-cancel-small' onclick='file_upload($options)' type='button'>上传图片</button>&nbsp;&nbsp;";
		$h .= "<button class='hd-cancel-small' onclick='remove_upload_one_img(this)' type='button'>移除</button>";
		$h .= " <span class='{$field['field_name']} validate-message'>" . $field['tips'] . "</span>";
		return $h;
	}

	//多文件上传
	private function files($field, $value) {
		$set = $field['set'];
		$id = $field['field_name'];
		//允许上传数量
		$num = $set['num'];
		//已经上传图片
		if (!empty($value)) {
			$img = unserialize($value);
			$num = $num - count($img['path']);
		}
		$h = "<fieldset class='img_list'>
<legend style='color:#666;font-size: 12px;line-height: 25px;padding: 0px 10px; text-align:center;margin: 0px;'>文件列表</legend>
<center>
<div style='color:#666;font-size:12px;margin-bottom: 5px;'>
您最多可以同时上传
<span style='color:red' id='hd_up_{$id}'>$num</span>
个文件
</div>
</center>
<div id='$id' class='fileList'>";
		if (!empty($value)) {
			$file = unserialize($value);
			if (!empty($file) && is_array($file)) {
				$h .= '<ul>';
				foreach ($file['path'] as $N => $path) {
					$h .= "<li style='width:45%'>";
					$h .= "<img src='" . __HDPHP_EXTEND__ . "/Org/Uploadify/default.png' style='width:50px;height:50px;'/>";
					$h .= "<input type='hidden' name='" . $field['field_name'] . "[path][]'  value='" . $path . "'/> ";
					$h .= "描述：<input type='text' name='" . $field['field_name'] . "[alt][]' style='width:200px;' value='" . $file['alt'][$N] . "'/>";
					$h .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					$h .= "下载金币：<input type='text' name='" . $field['field_name'] . "[credits][]' style='width:200px;' value='" . $file['credits'][$N] . "'/>";
					$h .= "&nbsp;&nbsp;&nbsp;<a href='javascript:;' onclick='remove_upload(this,\"{$id}\")'>删除</a>";
					$h .= "</li>";
				}
				$h .= '</ul>';
			}
		}
		$options = json_encode(array('id' => $id, 'type' => 'files', 'num' => $num, 'name' => $field['field_name'], 'filetype' => $set['filetype']));
		$h .= "</div>
</fieldset>
<button class='hd-cancel-small' onclick='file_upload($options)' type='button'>上传文件</button>";
		$h .= " <span class='{$field['field_name']} validate-message'>" . $field['tips'] . "</span>";
		return $h;
	}

}
