<?php

/**
 * 内容模型管理模块
 * Class ModelControl
 * @author 向军 <houdunwangxj@gmail.com>
 */
class ModelControl extends AuthControl {
	/**
	 * 模型列表
	 */
	public function index() {
		$this -> model = cache("model");
		$this -> display();
	}

	/**
	 * 验证模型是否存在
	 */
	public function check_model() {
		$_db = M("model");
		if (isset($_POST['tablename'])) {
			if (!$_db -> find("tablename='{$_POST['tablename']}'")) {
				$this -> ajax(1);
			}
		}
	}

	/**
	 * 更新缓存
	 */
	public function updateCache() {
		$Model = K("Model");
		if ($Model -> updateCache()) {
			$this -> success( '更新缓存成功');
		} else {
			$this -> error($Model -> error);
		}
	}

	/**
	 * 删除模型
	 */
	public function del() {
		$mid = Q('mid', 0, 'intval');
		if (empty($mid)) {
			$this -> error('参数错误');
		}
		//验证栏目
		$categoryModel = M('category');
		if ($categoryModel -> find(array('mid' => $mid))) {
			$this -> error( '先删除模型栏目');
		}
		$ModelDb = K("Model");
		if ($ModelDb -> delModel($mid)) {
			$this -> success('删除模型成功');
		} else {
			$this -> error( $ModelDb -> error);
		}
	}

	/**
	 * 添加模型
	 */
	public function add() {
		if (IS_POST) {
			$post = $_POST;
			if (empty($post)) {
				$this -> _ajax(0, '参数不能为空');
			}
			$Model = K("Model");
			if ($Model -> addModel()) {
				$this -> success( '添加模型成功');
			} else {
				$this -> error( $Model -> error);
			}
		} else {
			$this -> display();
		}
	}

	/**
	 * 编辑模型
	 */
	public function edit() {
		$mid = Q('mid', 0, 'intval');
		if (!$mid) {
			$this -> error( '参数错误');
		}
		if (IS_POST) {
			$post = $_POST;
			if (empty($post)) {
				$this -> error( '参数不能为空');
			}
			$modelDb = K("Model");
			//异步提交返回信息
			if ($modelDb -> editModel($post)) {
				$this -> success( '修改模型成功');
			}else{
				$this->error($modelDb->error);
			}
		} else {
			$ModelCache = cache('model');
			$this -> field = $ModelCache[$mid];
			$this -> display();
		}
	}

	//验证模型名是否存在
	public function check_model_name() {
		$model_name = Q("post.model_name");
		if ($this -> _mid) {
			//编辑时验证模型名
			if (!$this -> _db -> find(array("model_name" => $model_name, "mid" => array("neq" => $this -> _mid)))) {
				$this -> ajax(1);
			}
		} else {
			//添加时验证模型名
			if (!$this -> _db -> find(array("model_name" => $model_name))) {
				$this -> ajax(1);
			}
		}
		$this -> ajax(0);
	}

	//验证模型表名是否已经存在
	public function check_table_name() {
		if (!$this -> _db -> isTable(Q('post.tablename'))) {
			$this -> ajax(1);
		}
		$this -> ajax(0);
	}

}
