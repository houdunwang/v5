<?php
/**
 * 文章管理模型
 * Class ContentModel
 */
class ContentModel extends RelationModel {
	//模型缓存
	private $_model;
	//栏目缓存
	private $_category;
	//模型mid
	private $_mid;
	//模型对象
	static private $_instance = array();

	//实例化模型对象
	static public function getInstance($mid) {
		if (empty(self::$_instance) || !isset(self::$_instance[$mid])) {
			$modelCache = cache('model');
			$table = $modelCache[$mid]['table_name'];
			$model = new self($table);
			//副表
			$model -> join[$table . '_data'] = array('type' => HAS_ONE, 'foreign_key' => 'aid', 'parent_key' => 'aid');
			self::$_instance[$mid] = $model;
			return $model;
		} else {
			return self::$_instance[$mid];
		}
	}
	//添加验证规则
	public function addValidate($validate) {
		$this -> validate[] = $validate;
	}

}
