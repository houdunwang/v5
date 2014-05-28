<?php
/**
 * 主要用于文章SELECT
 * Class ContentModel
 */
class ContentViewModel extends ViewModel {
	//模型缓存
	private $_model;
	//模型mid
	private $_mid;
	//模型对象
	static private $_instance = array();

	//实例化模型对象
	static public function getInstance($mid) {
		if (!isset(self::$_instance[$mid])) {
			$modelCache = cache('model');
			$table = $modelCache[$mid]['table_name'];
			$model = new self($table);
			//副表
			$model -> view[$table.'_data'] = array('type' => LEFT_JOIN, 'on' => $table.".aid={$table}_data.aid");
			//栏目表
			$model -> view['category'] = array('type' => INNER_JOIN, 'on' => "category.cid=$table.cid");
			//会员表
			$model -> view['user'] = array('type' => INNER_JOIN, 'on' => "user.uid=$table.uid");
			self::$_instance[$mid] = $model;
			return $model;
		} else {
			return self::$_instance[$mid];
		}
	}

}
