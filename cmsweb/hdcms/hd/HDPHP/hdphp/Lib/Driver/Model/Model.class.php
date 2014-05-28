<?php
if (!defined("HDPHP_PATH"))
	exit('No direct script access allowed');
// .-----------------------------------------------------------------------------------
// |  Software: [HDPHP framework]
// |   Version: 2013.01
// |      Site: http://www.hdphp.com
// |-----------------------------------------------------------------------------------
// |    Author: 向军 <houdunwangxj@gmail.com>
// | Copyright (c) 2012-2013, http://houdunwang.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
// |   License: http://www.apache.org/licenses/LICENSE-2.0
// '-----------------------------------------------------------------------------------

/**
 * 基本模型处理类
 * @package     Model
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
class Model {

	public $tableFull = NULL;
	//全表名
	public $table = NULL;
	//不带前缀表名
	public $db = NULL;
	//数据库连接驱动
	public $error = NULL;
	//验证不通过的错误信息
	public $trigger = TRUE;
	//触发器,开启时执行__after_delete等方法
	public $joinTable = array();
	//要关联的表
	public $data = array();
	//增、改操作数据
	public $validate = array();
	//验证规则
	public $auto = array();
	//自动完成
	public $map = array();
	//字段映射

	/**
	 * 构造函数
	 * @param null $table 表名
	 * @param bool $full 是否为全表
	 * @param array $param 参数
	 * @param null $driver 驱动
	 */
	public function __construct($table = null, $full = false, $driver = null, $param = array()) {
		if (method_exists($this, "__init")) {
			$this -> __init($param);
		}
		$this -> run($table, $full, $driver);
	}

	//获得连接驱动
	protected function run($table, $full = false, $driver = null) {
		//初始化默认表
		$this -> getTable($table, $full);
		//获得数据库引擎
		$db = DbFactory::factory($driver, $this -> tableFull);
		if ($db) {
			$this -> db = $db;
		} else {//连接异常
			if (DEBUG) {
				error(mysqli_connect_error() . "数据库连接出错了请检查配置文件中的参数", false);
			} else {
				Log::write("数据库连接出错了请检查配置文件中的参数");
			}
		}
	}

	/**
	 * 定义模型错误
	 * @param $error 错误信息
	 */
	public function error($error) {
		$this -> error = $error;
	}

	//设置操作表
	protected function getTable($table = null, $full = false) {
		if (!is_null($this -> tableFull)) {
			$table = $this -> tableFull;
		} elseif (!is_null($this -> table)) {
			$table = C("DB_PREFIX") . $this -> table;
		} else if (is_null($table)) {
			$table = null;
		} elseif (!is_null($table)) {
			if ($full === true) {
				$table = $table;
			} else {
				$table = C("DB_PREFIX") . $table;
			}
		} else {
			$table = C("DB_PREFIX") . CONTROL;
		}
		$this -> tableFull = $table;
		$this -> table = preg_replace('@^\s*' . C("DB_PREFIX") . '@', '', $table);
	}

	/**
	 * 魔术方法  设置模型属性如表名字段名
	 * @param string $var 属性名
	 * @param mixed $value 值
	 */
	public function __set($var, $value) {
		//如果为模型方法时，执行模型方法如$this->where="id=1"
		$_var = strtolower($var);
		$property = array_keys($this -> db -> opt);
		if (in_array($_var, $property)) {
			$this -> $_var($value);
		} else {
			$this -> data[$var] = $value;
		}
	}

	//获得$this->data值
	public function __get($name) {
		return isset($this -> data[$name]) ? $this -> data[$name] : null;
	}

	/**
	 * 获得添加、插入数据
	 * @param array $data void
	 * @return array|null
	 */
	public function data($data = array()) {
		if (is_array($data) && !empty($data)) {
			$this -> data = $data;
		} else if (empty($this -> data)) {
			$this -> data = $_POST;
		}
		foreach ($this->data as $key => $val) {
			if (MAGIC_QUOTES_GPC && is_string($val)) {
				$this -> data[$key] = stripslashes($val);
			}
		}
		return $this;
	}

	/**
	 * 执行自动映射、自动验证、自动完成
	 * @param array $data 如果为空使用$_POST
	 * @return bool
	 */
	public function create($data = array()) {
		//验证令牌
		if (!$this -> token()) {
			return false;
		}
		//获得数据
		$this -> data($data);
		//自动验证
		if (!$this -> validate()) {
			return false;
		}
		//自动完成
		$this -> auto();
		//字段映射
		$this -> map();
		return true;
	}

	/**
	 * 字段映射
	 */
	protected function map() {
		if (empty($this -> map))
			return;
		$this -> data();
		foreach ($this->map as $k => $v) {
			//处理POST
			if (isset($this -> data[$k])) {
				$this -> data[$v] = $this -> data[$k];
				unset($this -> data[$k]);
			}
		}
	}

	//当前操作的方法
	protected function getCurrentMethod() {
		//1 插入  2 更新
		return isset($this -> data[$this -> db -> pri]) ? 2 : 1;
	}

	//设置关联模型
	public function join($table = FALSE) {
		if (!$table) {
			$this -> joinTable = FALSE;
		} else if (is_string($table)) {
			$this -> joinTable = explode(",", $table);
		} else if (is_array($table)) {
			$this -> joinTable = $table;
		}
		return $this;
	}

	//触发器，是否执行__after_delete等魔术方法
	public function trigger($stat = FALSE) {
		$this -> trigger = $stat;
		return $this;
	}

	//字段验证
	public function validate($data = array()) {
		$this -> data($data);
		//当前方法
		$current_method = $this -> getCurrentMethod();
		$_data = &$this -> data;
		if (!is_array($this -> validate) || empty($this -> validate)) {
			return true;
		}
		foreach ($this->validate as $v) {
			//验证的表单名称
			$name = $v[0];
			//验证时机  1 插入时验证  2 更新时验证  3 插入与更新都验证
			$action = isset($v[4]) ? $v[4] : 3;
			//当前时机（插入、更新）不需要验证
			if (!in_array($action, array($current_method, 3))) {
				continue;
			}
			//1 为默认验证方式    有POST这个变量就验证
			$condition = isset($v[3]) ? $v[3] : 1;
			//错误提示
			$msg = $v[2];
			switch ($condition) {
				//有post这个变量就验证
				case 1 :
					if (!isset($_data[$name])) {
						continue 2;
					}
					break;
				// 必须验证
				case 2 :
					if (!isset($_data[$name])) {
						$this -> error = $msg;
						return false;
					}
					break;
				//不为空验证
				case 3 :
					if (!isset($_data[$name]) || empty($_data[$name])) {
						continue 2;
					}
					break;
			}
			if($_pos = strpos($v[1],':')){
				$func = substr($v[1],0,$_pos);
				$args = substr($v[1],$_pos+1);
			}else{
				$func = $v[1];
				$args='';
			}
			if (method_exists($this, $func)) {
				$res = call_user_func_array(array($this, $func), array($name, $_data[$name], $msg, $args));
				if ($res === true) {
					continue;
				}
				$this -> error = $res;
				return false;
			} else if (function_exists($func)) {
				$res = $func($name, $_data[$name], $msg, $args);
				if ($res === true) {
					continue;
				}
				$this -> error = $res;
				return false;
			} else {
				$validate = new Validate();
				$func = '_' . $func;
				if (method_exists($validate, $func)) {
					$res = call_user_func_array(array($validate, $func), array($name, $_data[$name], $msg, $args));
					if ($res === true) {
						continue;
					}
					$this -> error = $res;
					return false;
				}
			}
		}
		return true;
	}

	//自动完成
	public function auto($data = array()) {
		$this -> data($data);
		$_data = &$this -> data;
		$motion = $this -> getCurrentMethod();
		foreach ($this->auto as $v) {
			//1 插入时处理  2 更新时处理  3 插入与更新都处理
			$type = isset($v[4]) ? $v[4] : 3;
			//是否处理  更新或插入
			if ($motion != $type && $type != 3) {
				continue;
			}
			//验证的表单名称
			$name = $v[0];
			//函数或方法
			$action = $v[1];
			//时间：1有这个表单项就处理  2 必须处理的表单项 3 如果表单不为空才处理
			$condition = isset($v[3]) ? $v[3] : 1;
			switch ($condition) {
				//有post这个变量就处理
				case 1 :
					if (!isset($_data[$name])) {
						continue 2;
					}
					break;
				// 必须处理
				case 2 :
					if (!isset($_data[$name]))
						$_data[$name] = '';
					break;
				//不为空验证
				case 3 :
					if (empty($_data[$name])) {
						continue 2;
					}
					break;
			}
			//处理类型 function函数  method模型方法 string字符串
			$handle = isset($v[2]) ? $v[2] : "string";
			$_data[$name] = isset($_data[$name]) ? $_data[$name] : NULL;
			switch (strtolower($handle)) {
				case "function" :
					if (function_exists($action)) {
						$_data[$name] = $action($_data[$name]);
					}
					break;
				case "method" :
					if (method_exists($this, $action)) {
						$_data[$name] = $this -> $action($_data[$name]);
					}
					break;
				case "string" :
					$_data[$name] = $action;
					break;
			}
		}
	}

	/**
	 * __call方法
	 * @param type $func
	 * @param type $args
	 * @return type
	 */
	public function __call($func, $args) {
		//模型中不存在方法
		halt('模型中不存在方法' . $func);
	}

	/**
	 * 临时更改操作表
	 * @param string $table 表名
	 * @param bool $full 是否带表前缀
	 * @return $this
	 */
	public function table($table, $full = FALSE) {
		if ($full !== TRUE) {
			$table = C("DB_PREFIX") . $table;
		}
		$this -> db -> table($table);
		$this -> join(FALSE);
		$this -> trigger(FALSE);
		return $this;
	}

	/**
	 * 设置字段
	 * 示例：$Db->field("username,age")->limit(6)->all();
	 */
	public function field($field = array(), $check = true) {
		if (empty($field))
			return $this;
		$this -> db -> field($field, $check);
		return $this;
	}

	/**
	 * 执行查询操作结果不缓存
	 * 示例：$Db->Cache(30)->all();
	 */
	public function cache($time = -1) {
		$this -> db -> cache($time);
		return $this;
	}

	//SQL中的LIKE规则
	public function like($arg = array()) {
		if (empty($arg))
			return $this;
		$this -> db -> like($arg);
		return $this;
	}

	/**
	 * GROUP语句定义
	 */
	public function group($arg = array()) {
		if (empty($arg))
			return $this;
		$this -> db -> group($arg);
		return $this;
	}

	/**
	 * HAVING语句定义
	 */
	public function having($arg = array()) {
		if (empty($arg))
			return $this;
		$this -> db -> having($arg);
		return $this;
	}

	/**
	 * ORDER 语句定义
	 * 示例：$Db->order("id desc")->all();
	 */
	public function order($arg = array()) {
		if (empty($arg))
			return $this;
		$this -> db -> order($arg);
		return $this;
	}

	/**
	 * IN 语句定义
	 * 示例：$Db->in(1,2,3)->all();
	 */
	public function in($arg = array()) {
		if (empty($arg))
			return $this;
		$this -> db -> in($arg);
		return $this;
	}

	/**
	 * 删除记录
	 * 示例：$Db->del("uid=1");
	 */
	public function del($data = array()) {
		return $this -> delete($data);
	}

	/**
	 * 慎用  会删除表中所有数据
	 * $Db->delall();
	 */
	public function delAll($data = array()) {
		$this -> where("1=1");
		return $this -> delete($data);
	}

	/**
	 * 删除记录
	 * 示例：$Db->delete("uid=1");
	 */
	public function delete($data = array()) {
		$trigger = $this -> trigger;
		$this -> trigger = true;
		$trigger and $this -> __before_delete($data);
		$result = $this -> db -> delete($data);
		$this -> error = $this -> db -> error;
		$trigger and $this -> __after_delete($result);
		return $result;
	}

	/**
	 * 执行一个SQL语句  有返回值
	 * 示例：$Db->query("select title,click,addtime from hd_news where uid=18");
	 */
	public function query($data = array()) {
		return $this -> db -> query($data);
	}

	/**
	 * 执行一个SQL语句  没有有返回值
	 * 示例：$Db->exe("delete from hd_news where id=16");
	 */
	public function exe($sql) {
		return $this -> db -> exe($sql);
	}

	/**
	 * LIMIT 语句定义
	 * 示例：$Db->limit(10)->all("sex=1");
	 */
	public function limit($start = null, $end = null) {
		if (is_null($start)) {
			return $this;
		} else if (!is_null($end)) {
			$limit = $start . "," . $end;
		} else {
			$limit = $start;
		}
		$this -> db -> limit($limit);
		return $this;
	}

	/**
	 * 查找满足条件的一条记录
	 * 示例：$Db->find("id=188")
	 */
	public function find($data = array()) {
		$this -> limit(1);
		$result = $this -> select($data);
		return is_array($result) && isset($result[0]) ? $result[0] : $result;
	}

	/**
	 * 查找满足条件的一条记录
	 * 示例：$Db->one("id=188")
	 */
	public function one($data = array()) {
		return $this -> find($data);
	}

	/**
	 * 查找满足条件的所有记录
	 */
	public function findAll($args = array()) {
		return $this -> select($args);
	}

	/**
	 * 查找满足条件的所有记录
	 * 示例：$Db->all("age>20")
	 */
	public function all($args = array()) {
		return $this -> select($args);
	}

	/**
	 * 查找满足条件的所有记录
	 * 示例：$Db->select("age>20")
	 */
	public function select($args = array()) {
		$trigger = $this -> trigger;
		$this -> trigger = true;
		$trigger and $this -> __before_select($arg);
		$result = $this -> db -> select($args);
		$trigger and $this -> __after_select($result);
		$this -> error = $this -> db -> error;
		return $result;
	}

	/**
	 * SQL中的WHERE规则
	 * 示例：$Db->where("username like '%向军%')->count();
	 */
	public function where($args = array()) {
		if (!empty($args)) {
			$this -> db -> where($args);
		}
		return $this;
	}

	/**
	 * 查找满足条件的所有记录(一维数组)
	 * 示例：$Db->getField("username")
	 */
	public function getField($field, $return_all = false) {
		//设置字段
		$this -> field($field);
		$result = $this -> select();
		if ($result) {
			//字段数组
			$field = explode(',', preg_replace('@\s@', '', $field));
			//如果有多个字段时，返回多维数组并且第一个字段值做为KEY使用
			if (count($field) > 1) {
				$data = array();
				foreach ($result as $v) {
					$data[$v[$field[0]]] = $v;
				}
				return $data;
			} else if ($return_all) {
				//只有一个字段，且返回多条记录
				$data = array();
				foreach ($result as $v) {
					if (isset($v[$field[0]]))
						$data[] = $v[$field[0]];
				}
				return $data;
			} else {
				//只有一个字段，且返回一条记录
				return current($result[0]);
			}
		} else {
			return NULL;
		}
	}

	//添加数据
	public function update($data = array()) {
		$this -> data($data);
		$data = $this -> data;
		$this -> data = array();
		$trigger = $this -> trigger;
		$this -> trigger = true;

		$trigger and $this -> __before_update($data);
		if (empty($data)) {
			$this -> error = "没有任何数据用于UPDATE！";
			return false;
		}
		$this -> error = $this -> db -> error;
		$result = $this -> db -> update($data);
		$trigger and $this -> __after_update($result);
		return $result;
	}

	//更新记录
	public function save($data = array()) {
		return $this -> update($data);
	}

	//插入数据
	public function insert($data = array(), $type = "INSERT") {
		$this -> data($data);
		$data = $this -> data;
		$this -> data = array();
		$trigger = $this -> trigger;
		$this -> trigger = true;
		$trigger and $this -> __before_insert($data);
		$result = $this -> db -> insert($data, $type);
		$this -> error = $this -> db -> error;
		$trigger and $this -> __after_insert($result);
		return $result;
	}

	//批量插入数据
	public function addAll($data, $type = 'INSERT') {
		$id = array();
		if (is_array($data) && !empty($data)) {
			foreach ($data as $d) {
				if (is_array($d))
					$id[] = $this -> insert($d, $type);
			}
		}
		return empty($id) ? NULL : $id;
	}

	//replace方式插入数据
	public function replace($data = array()) {
		return $this -> insert($data, "REPLACE");
	}

	//插入数据
	public function add($data = array(), $type = 'INSERT') {
		return $this -> insert($data, $type);
	}

	/**
	 * 判断表中字段是否在存在
	 * @param string $fieldName 字段名
	 * @param string $table 表名(不带表前缀)
	 * @return bool
	 */
	public function fieldExists($fieldName, $table) {
		$Model = M();
		if (!$Model -> tableExists($table)) {
			$this -> error = '数据表不存在';
		} else {
			$field = $Model -> query("DESC " . C("DB_PREFIX") . $table);
			foreach ($field as $f) {
				if (strtolower($f['Field']) == strtolower($fieldName)) {
					return true;
				}
			}
			return false;
		}
	}

	/* 判断表是否存在
	 * @param string $table 表名
	 * @return bool
	 */
	public function tableExists($tableName) {
		$Model = M();
		$tableArr = $Model -> query("SHOW TABLES");
		foreach ($tableArr as $k => $table) {
			$tableTrue = $table['Tables_in_' . C('DB_DATABASE')];
			if (strtolower($tableTrue) == strtolower(C('DB_PREFIX') . $tableName)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * 删除表
	 * @param string $tableName 表名
	 */
	public function dropTable($tableName) {
		if ($this -> tableExists($tableName)) {
			return $this -> exe("DROP TABLE IF EXISTS `" . C('DB_PREFIX') . $tableName . "`");
		}
	}

	/**
	 * 统计
	 */
	public function count($args = array()) {
		$result = $this -> db -> count($args);
		return $result;
	}

	/**
	 * 求最大值
	 */
	public function max($args = array()) {
		$result = $this -> db -> max($args);
		return $result;
	}

	/**
	 * 求最小值
	 */
	public function min($args = array()) {
		$result = $this -> db -> min($args);
		return $result;
	}

	/**
	 * 求平均值
	 */
	public function avg($args = array()) {
		$result = $this -> db -> avg($args);
		return $result;
	}

	/**
	 * SQL中的SUM计算
	 */
	public function sum($args = array()) {
		$result = $this -> db -> sum($args);
		return $result;
	}

	/**
	 * 字段值增加
	 * 示例：$Db->dec("price","id=20",188)
	 * 将id为20的记录的price字段值增加188
	 * @param $field 字段名
	 * @param $where 条件
	 * @param int $step 增加数
	 * @return mixed
	 */
	public function inc($field, $where, $step = 1) {
		$sql = "UPDATE " . $this -> db -> opt['table'] . " SET " . $field . '=' . $field . '+' . $step . " WHERE " . $where;
		return $this -> exe($sql);
	}

	/**
	 * 过滤字段
	 */
	public function fieldFilter($data = array()) {
		$this -> data($data);
		$data = $this -> data;
		$data = $data ? $data : $_GET;
		return $this -> db -> fieldFilter($data);
	}

	//减少字段值
	public function dec($field, $where, $step = 1) {
		$sql = "UPDATE " . $this -> db -> opt['table'] . " SET " . $field . '=' . $field . '-' . $step . " WHERE " . $where;
		return $this -> exe($sql);
	}

	/**
	 * 验证令牌
	 */
	public function token() {
		if (C("TOKEN_ON") || isset($_POST[C("TOKEN_NAME")]) || isset($_GET[C("TOKEN_NAME")])) {
			if (!Token::check()) {
				$this -> error = '表单令牌错误';
				return false;
			}
		}
		return true;
	}

	/**
	 * 获得表字段
	 * @param $table
	 * @return mixed
	 */
	public function getTableFields($table) {
		$fields = $this -> db -> getTableFields(C("DB_PREFIX") . $table);
		if (!empty($fields)) {
			return implode(',', array_keys($fields['fields']));
		}
	}

	/**
	 * 获得受影响的记录数
	 */
	public function getAffectedRows() {
		return $this -> db -> getAffectedRows();
	}

	/**
	 * 获得最后插入的ID
	 */
	public function getInsertId() {
		return $this -> db -> getInsertId();
	}

	/**
	 * 获得最后一条SQL
	 */
	public function getLastSql() {
		return $this -> db -> getLastSql();
	}

	/**
	 * 获得所有SQL
	 */
	public function getAllSql() {
		return $this -> db -> getAllSql();
	}

	//获得MYSQL版本
	public function getVersion() {
		return $this -> db -> getVersion();
	}

	//创建数据库
	public function createDatabase($database, $charset = "utf8") {
		return $this -> exe("CREATE DATABASE IF NOT EXISTS `$database` CHARSET " . $charset);
	}

	//获得数据库或表大小
	public function getSize($table = '') {
		if (empty($table))
			$table = array($this -> tableFull);
		if (is_string($table))
			$table = array($table);
		return $this -> db -> getSize($table);
	}

	//获得表信息
	public function getTableInfo($table = array()) {
		return $this -> db -> getTableInfo($table);
	}

	//清空表
	public function truncate($table) {
		if (is_array($table) && !empty($table)) {
			foreach ($table as $t) {
				$this -> exe("TRUNCATE TABLE `" . $t . "`");
			}
			return true;
		}
	}

	/**
	 * 优化表解决表碎片问题
	 * @param array $table 表
	 * @return bool
	 */
	public function optimize($table) {
		if (is_array($table) && !empty($table)) {
			foreach ($table as $t) {
				$this -> exe("OPTIMIZE TABLE `" . $t . "`");
			}
			return true;
		}
	}

	//修复数据表
	public function repair($table) {
		if (is_array($table) && !empty($table)) {
			foreach ($table as $t) {
				$this -> exe("REPAIR TABLE `" . $t . "`");
			}
			return true;
		}
	}

	//修改表名
	public function rename($old, $new) {
		$this -> exe("ALTER TABLE `" . $old . "` RENAME " . $new);
	}

	/**
	 * 开启|关闭事务
	 * @param bool $stat true开启事务| false关闭事务
	 * @return mixed
	 */
	public function beginTrans($stat = true) {
		return $this -> db -> beginTrans($stat);
	}

	/**
	 * 执行SQL语句
	 * @param void 传入SQL字符串
	 * @return type
	 */
	public function runSql($sql) {
		return $this -> exe($sql);
	}

	//提供一个事务
	public function commit() {
		return $this -> db -> commit();
	}

	//回滚事务
	public function rollback() {
		return $this -> db -> rollback();
	}

	//添加数据前执行的方法
	public function __before_insert(&$data) {
	}

	//添加数据后执行的方法
	public function __after_insert($data) {
	}

	//删除数据前执行的方法
	public function __before_delete(&$data) {
	}

	//删除数据后执行的方法
	public function __after_delete($data) {
	}

	//更新数据后前执行的方法
	public function __before_update(&$data) {
	}

	//更新数据后执行的方法
	public function __after_update($data) {
	}

	//查询数据前前执行的方法
	public function __before_select(&$data) {
	}

	//查询数据后执行的方法
	public function __after_select($data) {
	}

}
