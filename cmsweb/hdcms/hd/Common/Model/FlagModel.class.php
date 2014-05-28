<?php

/**
 * 属性flag
 * Class FlagModel
 * @author hdxj
 */
class FlagModel extends Model {
	public $table;
	private $_mid;
	private $_contentTable;
	//缓存
	public $_flag;

	//构造函数
	public function __construct($mid) {
		parent::__construct();
		$model = cache('model');
		if (!isset($model[$mid])) {
			$this -> error = '模型不存在';
			return false;
		}
		$this -> _mid = $mid;
		$this -> _flag = cache($mid, false, FLAG_CACHE_PATH);
		$this -> _contentTable = $table = $model[$mid]['table_name'];
	}

	//删除属性
	public function delFlag($index) {
		$flag = $this->_flag;
		unset($flag[$index]);
		$sql = "ALTER TABLE " . C('DB_PREFIX') . $this->_contentTable." MODIFY flag set('" . implode("','", $flag) . "')";
		if (!$this -> exe($sql)) {
			$this -> error = '修改表失败';
			return false;
		}
		return $this -> updateCache();
	}

	/**
	 * 修改属性
	 */
	public function editFlag($mid, $data) {
		if (!empty($data)) {
			$sql = "ALTER TABLE " . C('DB_PREFIX') . "$table MODIFY flag set('" . implode("','", $data) . "')";
			if (!$this -> exe($sql)) {
				$this -> error = '修改表失败';
				return false;
			}
		}
		$this -> updateCache($mid);
		return true;
	}

	/**
	 * 添加属性
	 */
	public function addFlag($flag) {
		$this -> _flag[] = $flag;
		$sql = "ALTER TABLE " . C('DB_PREFIX') . $this -> _contentTable . " MODIFY flag set('" . implode("','", $this -> _flag) . "')";
		if (!$this -> exe($sql)) {
			$this -> error = '修改表失败';
			return false;
		}
		$this -> updateCache();
		return true;
	}

	/**
	 * 更新缓存
	 */
	public function updateCache($mid=null) {
		$mid = $mid?$mid:$this->_mid;
		$result = M() -> query('DESC ' . C('DB_PREFIX') . $this -> _contentTable);
		$flag = array();
		foreach ($result as $field) {
			if ($field['Field'] == 'flag') {
				$tmp = substr($field['Type'], 4, -2);
				$flag = explode(',', str_replace("'", '', $tmp));
				break;
			}
		}
		return cache($mid, $flag, FLAG_CACHE_PATH);
	}

}
