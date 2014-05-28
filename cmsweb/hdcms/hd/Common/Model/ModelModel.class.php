<?php
/**
 * 模型管理
 * @author 向军 <houdunwangxj@gmail.com>
 */
class ModelModel extends Model {
	//表名
	public $table = 'model';
	//不允许删除的模型
	public $forbidDelete = array('content');

	/**
	 * 添加模型
	 */
	public function addModel($InsertData) {
		$this -> validate = array( array('model_name', 'nonull', '模型名称不能为空', 2, 1), array('table_name', 'nonull', '表名不能为空', 2, 1));
		$this -> auto = array( array('table_name', 'strtolower', 'function', 2, 1));
		//创建模型表
		if ($this -> create($InsertData)) {
			$data = $this -> data;
			//验证表是否存在
			if ($this -> tableExists($data['table_name'])) {
				$this -> error = '数据表已经存在';
				return false;
			}
			if ($this -> createModelSql($data['table_name'])) {
				//向模型表添加模型信息
				$mid = $this -> add();
				if ($mid) {
					//创建Field表信息
					$db = M();
					$db_prefix = C("DB_PREFIX");
					$table = $data['table_name'];
					require APP_PATH . '/Data/ModelSql/FieldInit.php';
					if ($this -> updateCache()) {
						//更新字段缓存
						$ModelField = new ModelFieldModel($mid);
						$ModelField -> updateCache();
						//更新文章属性缓存
						$FlagModel = new FlagModel($mid);
						$FlagModel -> updateCache();
						return $mid;
					}
				} else {
					return false;
				}
			}
		} else {
			return false;
		}
	}

	//修改模型
	public function editModel($data) {
		$this -> validate = array( array('model_name', 'nonull', '模型名称不能为空', 2, 2));
		if ($this -> create($data)) {
			if (!$this -> save($data)) {
				$this -> error = '更新模型失败';
			} else {
				if (!$this -> updateCache()) {
					return false;
				} else {
					return true;
				}
			}
		}
	}

	/**
	 * 创建模型表
	 */
	public function createModelSql($tableName) {
		$table = strtolower(trim($tableName));
		$zhubiaoSql = file_get_contents(APP_PATH . 'Data/ModelSql/zhubiao.sql');
		$fuBiaoSql = file_get_contents(APP_PATH . 'Data/ModelSql/zhubiao_data.sql');

		$zhubiaoSql = preg_replace(array('/@pre@/', '/@table@/'), array(C("DB_PREFIX"), $tableName), $zhubiaoSql);
		$Model = M();
		if ($Model -> runSql($zhubiaoSql) === false) {
			$this -> error = '创建主表失败';
			return false;
		}
		$fuBiaoSql = preg_replace(array('/@pre@/', '/@table@/'), array(C("DB_PREFIX"), $tableName), $fuBiaoSql);
		if ($Model -> runSql($fuBiaoSql) === false) {
			$this -> error = '创建副表失败';
			return false;
		}
		return true;
	}

	/**
	 * 删除模型
	 */
	public function delModel($mid) {
		//验证栏目信息
		if ( M('category') -> find($mid)) {
			$this -> error = '请先删除当前模型栏目';
		}
		$model = $this -> find($mid);
		if (is_null($model)) {
			$this -> error = "模型不存在";
			return false;
		}
		$table = $model['table_name'];
		$delTable = $this -> delTable(array($table, $table . '_data'));
		if ($delTable === true) {
			//删除表记录
			if ($modelStat = $this -> del($mid)) {
				//删除模型字段信息并更新字段缓存
				if ($delState = $this -> table("field") -> where("mid={$mid}") -> del()) {
					//删除字段缓存文件
					cache($mid, null, FIELD_CACHE_PATH);
					//更新模型缓存
					if (!$this -> updateCache()) {
						return false;
					}
					return $delState;
				} else {
					$this -> error = '删除模型字段失败';
					return false;
				}
				return $modelStat;
			}
		}
	}

	//删除表
	private function delTable(array $tableArr) {
		foreach ($tableArr as $table) {
			if ($this -> tableExists($table)) {
				if (!$this -> dropTable($table)) {
					$this -> error = '删除表失败';
					return false;
				}
			}
		}
		return true;
	}

	//更新模型缓存
	public function updateCache() {
		$modelDb = M('model');
		$modelData = $modelDb -> order(array('mid' => "ASC")) -> all();
		if ($modelData !=false) {
			$CacheData = array();
			foreach ($modelData as $model) {
				$CacheData[$model['mid']] = $model;
			}
			$stat = cache("model", $CacheData);
			if ($stat) {
				return true;
			} else {
				$this -> error = '缓存更新失败';
				return false;
			}
		}
	}

}
