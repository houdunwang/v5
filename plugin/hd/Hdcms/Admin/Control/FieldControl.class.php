<?php

/**
 * 模型字段管理
 * Class ModelControl
 */
class FieldControl extends AuthControl {
	//模型mid
	private $_mid;
	//模型缓存
	private $_model;

	//构造函数
	public function __init() {
		//模型mid
		$this -> _mid = Q("mid", 0, "intval");
		//验证模型mid
		if (!$this -> _mid) {
			$this -> error("模型不存在！");
		}
		//模型缓存
		$this -> _model = cache("model");
	}

	//字段列表
	public function index() {
		//不允许删除字段
		$this -> assign('noallowdelete', ModelFieldModel::$NoAllowDelete);
		//不允许禁用字段
		$this -> assign('noallowforbidden', ModelFieldModel::$NoAllowForbidden);
		$fieldCache = cache($this -> _mid, false, FIELD_CACHE_PATH);
		$this -> field = $fieldCache;
		$this -> display();
	}

	//更新字段排序
	public function updateSort() {
		$orders = Q("fieldsort");
		if ($orders) {
			$model =new ModelFieldModel($this->_mid);
			foreach ($orders as $k => $v) {
				$model -> join(null) -> save(array("fid" => $k, "fieldsort" => $v));
			}
			$model -> updateCache(intval($_GET['mid']));
			$this -> _ajax(1, "排序成功");
		} else {
			$this -> _ajax(0, $model -> error);
		}
	}

	//添加字段
	public function add() {
		if (IS_POST) {
			$post = $_POST;
			if (empty($post)) {
				$this -> error('参数错误');
			}
			$fieldModel = new ModelFieldModel($this->_mid);
			if ($fieldModel -> addField($post)) {
				$this -> success('添加字段成功');
			}
		} else {
			//不允许删除字段
			$this -> assign('noallowhide', ModelFieldModel::$NoAllowHide);
			$this -> model = $this -> _model[$this -> _mid];
			$this -> display();
		}
	}

	/**
	 * 修改字段
	 */
	public function edit() {
		$fieldModel =new ModelFieldModel($this->_mid);
		$mid = Q('mid', 0, 'intval');
		$fid = Q('fid', 0, 'intval');
		if (!$fid) {
			$this -> error('参数错误');
		}
		if (IS_POST) {
			$post = $_POST;
			if (empty($post)) {
				$this -> error('参数错误');
			}
			if ($fieldModel -> editField($post)) {
				$this -> success('修改成功');
			}
		} else {
			$fieldCache = cache($mid, false, FIELD_CACHE_PATH);
			$modelCache = cache('model');
			$field_name = M('field') -> where(array('fid' => $fid)) -> getField('field_name');
			$field = $fieldCache[$field_name];
			$this -> field = $field;
			$this -> model_name = $modelCache[$mid]['model_name'];
			//不允许删除字段
			$this -> assign('noallowhide', ModelFieldModel::$NoAllowHide);
			$this -> display();
		}
	}

	//验证字段是否已经存在
	public function field_is_exists() {
		$field_name = Q('field_name');
		$table = $this -> _model[Q('mid')]['table_name'];
		$state = M() -> fieldExists($field_name, $table) ? 0 : 1;
		if ($state) {
			$state = M() -> fieldExists($field_name, $table . '_data') ? 0 : 1;
		}
		$this -> ajax($state);
	}

	//选择字段类型模板
	public function get_field_tpl() {
		//模板类型如add edit
		$tpl_type = Q("post.tpl_type");
		//字段类型如input textarea
		$field_type = Q("post.field_type");
		$this -> field_type = $field_type;
		$this -> display(APP_PATH . "Data/Field/{$field_type}/form_{$tpl_type}.inc.php");
	}

	/**
	 * 删除字段
	 */
	public function del() {
		$fid = Q('fid');
		if ($fid) {
			$fieldModel = new ModelFieldModel($this->_mid);
			if ($fieldModel -> delField())
				$this -> _ajax(1, '字段删除成功');
		} else {
			$this -> _ajax(0, $this -> _db -> error);
		}
	}

	//更新字段缓存
	public function updateCache() {
		$mid = Q('mid', 0, 'intval');
		if (!$mid) {
			$this -> _ajax(0, '参数错误');
		}
		$fieldModel = new ModelFieldModel($this->_mid);
		if ($fieldModel -> updateCache($mid)) {
			$this -> _ajax(1, '更新成功');
		} else {
			$this -> _ajax(0, $fieldModel -> error);
		}
	}

	//禁用字段
	public function forbidden() {
		$field_state = Q('field_state', 1, 'intval');
		$fid = Q('fid', 1, 'intval');
		$db = M('field');
		$db -> save(array('fid' => $fid, 'field_state' => $field_state));
		$this->updateCache();
		$this -> success('设置成功');
	}

}
