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
 * 系统核心函数库
 * @category    HDPHP
 * @package     Lib
 * @subpackage  core
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
/**
 * 加载核心模型
 * @param String $table 表名
 * @param Boolean $full 是否为全表名
 * @return Object 返回模型对象
 */
function M($table = null, $full = null) {
	return new Model($table, $full);
}

/**
 * 生成扩展模型
 * @param $class 扩展类名
 * @param array $param __init()方法参数
 * @return mixed
 */
function K($class, $param = array()) {
	$class .= "Model";
	return new $class(null, null, null, $param);
}

/**
 * @param String $tableName 表名
 * @param Boolean $full 是否为全表
 * @return relationModel
 */
function R($tableName = null, $full = null) {
	return new RelationModel($tableName, $full);
}

/**
 * 获得视图模型
 * @param null $tableName 表名
 * @param null $full 带前缀
 * @return ViewModel
 */
function V($tableName = null, $full = null) {
	return new ViewModel($tableName, $full);
}

/**
 * 快速缓存 以文件形式缓存
 * @param String $name 缓存KEY
 * @param bool $value 删除缓存
 * @param string $path 缓存目录
 * @return bool
 */
function F($name, $value = false, $path = CACHE_PATH) {
	$_cache = array();
	$cacheFile = rtrim($path, '/') . '/' . $name . '.php';
	if (is_null($value)) {
		if (is_file($cacheFile)) {
			unlink($cacheFile);
			unset($_cache[$name]);
		}
		return true;
	}
	if ($value === false) {
		if (isset($_cache[$name]))
			return $_cache[$name];
		return is_file($cacheFile) ?
		include $cacheFile : null;
	}
	$data = "<?php if(!defined('HDPHP_PATH'))exit;\nreturn " . compress(var_export($value, true)) . ";\n?>";
	is_dir($path) || dir_create($path);
	if (!file_put_contents($cacheFile, $data)) {
		return false;
	}
	$_cache[$name] = $data;
	return true;
}

/**
 * 缓存处理
 * @param string $name 缓存名称
 * @param bool $value 缓存内容
 * @param null $expire 缓存时间
 * @param array $options 选项
 * <code>
 * array("Driver"=>"file","dir"=>"Cache","Driver"=>"memcache")
 * </code>
 * @return bool
 */
function S($name, $value = false, $expire = null, $options = array()) {
	static $_data = array();
	$cacheObj = Cache::init($options);
	if (is_null($value)) {
		return $cacheObj -> del($name);
	}
	$driver = isset($options['Driver']) ? $options['Driver'] : '';
	$key = $name . $driver;
	if ($value === false) {
		if (isset($_data[$key])) {
			Debug::$cache['read_s']++;
			return $_data[$key];
		} else {
			return $cacheObj -> get($name, $expire);
		}
	}
	$cacheObj -> set($name, $value, $expire);
	$_data[$key] = $value;
	return true;
}

/**
 * 执行控制器中的方法（支持分组）
 * @param $arg 应用/控制器/方法
 * @param array $args 参数
 * @return mixed
 */
function A($arg, $args = array()) {
	$arg = trim($arg, '/');
	$pathArr = explode('/', trim($arg, '/'));
	switch (count($pathArr)) {
		case 1 :
			//当前应用
			$base = CONTROL_PATH . CONTROL;
			$method = $pathArr[0];
			break;
		case 2 :
			//当前应用其他控制器
			$base = CONTROL_PATH . $pathArr[0];
			$method = $pathArr[1];
			break;
		case 3 :
			//其它应用控制器与方法
			$base = APP_PATH . '../' . $pathArr[0] . '/Control/' . $pathArr[1];
			$method = $pathArr[2];
			break;
	}
	//控制器名
	$class = basename($base) . C('CONTROL_FIX');
	if (require_cache($base . C('CONTROL_FIX') . '.class.php')) {
		if (class_exists($class)) {
			$obj = new $class();
			if (method_exists($class, $method)) {
				if (empty($args)) {
					return $obj -> $method();
				} else {
					return call_user_func_array(array(&$obj, $method), $args);
				}
			}
		}
	}
}

/**
 * 类库导入
 * @param null $class 类名
 * @param null $base 目录
 * @param string $ext 扩展名
 * @return bool
 */
function import($class = null, $base = null, $ext = ".class.php") {
	$class = str_replace(".", "/", $class);
	if (is_null($base)) {
		$info = explode("/", $class);
		//加载应用
		if ($info[0] == '@' || APP == $info[0]) {
			$base = APP_PATH;
			$class = substr_replace($class, '', 0, strlen($info[0]) + 1);
		} elseif ($info[0] == '@@') {
			$base = GROUP_PATH;
			$class = substr_replace($class, '', 0, strlen($info[0]) + 1);
		} elseif (strtoupper($info[0]) == 'HDPHP') {
			$base = dirname(substr_replace($class, HDPHP_PATH, 0, 6));
			$class = basename($class);
		} elseif (in_array(strtoupper($info[0]), array("LIB", "ORG"))) {
			$base = APP_PATH;
		} else {
			//其它应用
			$base = APP_PATH . '../' . $info[0] . '/';
			$class = substr_replace($class, '', 0, strlen($info[0]) + 1);
		}
	} else {
		$base = str_replace('.', '/', $base);
	}
	if (substr($base, -1) != '/')
		$base .= '/';
	$file = $base . $class . $ext;
	if (!class_exists(basename($class), false)) {
		return require_cache($file);
	}
	return true;
}

/**
 * 生成对象 || 执行方法
 * @param $class 类名
 * @param string $method 方法
 * @param array $args 参数
 * @return mixed
 */
function O($class, $method = null, $args = array()) {
	$path = $class;
	$tmp = explode(".", $class);
	$class = array_pop($tmp);
	if (!class_exists($class)) {
		$path = $tmp ? implode('.', $tmp) : null;
		import($class, $path);
	}
	if (class_exists($class, false)) {
		$obj = new $class();
		if (!is_object($obj))
			return false;
		if ($method && method_exists($obj, $method)) {
			if (empty($args)) {
				$args = array();
			} else if (!is_array($args)) {
				error("O()函数第3个参数必须为数组，你也可以不传");
			}
			return call_user_func_array(array($obj, $method), $args);
		} else {
			return $obj;
		}
	}
}

/**
 * 获得控制器对象
 */
function getControl($Control) {
	return new $Control;
}

/**
 * 实例化控制器并执行方法
 * @param $control 控制器
 * @param null $method 方法
 * @param array $args 参数
 * @return bool|mixed
 */
function control($class, $method = NULl, $args = array()) {
	$class = $class.C('CONTROL_FIX');
	$classfile =$class.'.class.php';
	if (require_array(array(HDPHP_CORE_PATH . $classfile, CONTROL_PATH . $classfile, COMMON_CONTROL_PATH . $classfile))) {
		if (class_exists($class)) {
			$obj = new $class();
			if ($method && method_exists($obj, $method)) {
				return call_user_func_array(array(&$obj, $method), $args);
			}
			return $obj;
		}
	} else {
		return false;
	}
}

/**
 * session处理
 * @param string|array $name 数组为初始session
 * @param string $value 值
 * @return mixed
 */
function session($name = '', $value = '') {
	if (is_array($name)) {
		ini_set('session.auto_start', 0);
		if (isset($name['name']))
			session_name($name['name']);
		if (isset($_REQUEST[session_name()]))
			session_id($_REQUEST[session_name()]);
		if (isset($name['path']))
			session_save_path($name['path']);
		if (isset($name['domain']))
			ini_set('session.cookie_domain', $name['domain']);
		if (isset($name['expire']))
			ini_set('session.gc_maxlifetime', $name['expire']);
		if (isset($name['use_trans_sid']))
			ini_set('session.use_trans_sid', $name['use_trans_sid'] ? 1 : 0);
		if (isset($name['use_cookies']))
			ini_set('session.use_cookies', $name['use_cookies'] ? 1 : 0);
		if (isset($name['cache_limiter']))
			session_cache_limiter($name['cache_limiter']);
		if (isset($name['cache_expire']))
			session_cache_expire($name['cache_expire']);
		if (isset($name['type']))
			C('SESSION_TYPE', $name['type']);
		if (C('SESSION_TYPE')) {
			$class = 'Session' . ucwords(strtolower(C('SESSION_TYPE')));
			require_cache(HDPHP_DRIVER_PATH . '/Session/' . $class . '.class.php');
			$hander = new $class();
			$hander -> run();
		}
		//自动开启SESSION
		if (C("SESSION_AUTO_START"))
			session_start();
	} elseif ($value === '') {
		if ('[pause]' == $name) {// 暂停
			session_write_close();
		} elseif ('[start]' == $name) {//开启
			session_start();
		} elseif ('[destroy]' == $name) {//销毁
			$_SESSION = array();
			session_unset();
			session_destroy();
		} elseif ('[regenerate]' == $name) {//生成id
			session_regenerate_id();
		} elseif (0 === strpos($name, '?')) {// 检查session
			$name = substr($name, 1);
			return isset($_SESSION[$name]);
		} elseif (is_null($name)) {// 清空session
			$_SESSION = array();
		} else {
			return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
		}
	} elseif (is_null($value)) {// 删除session
		if (isset($_SESSION[$name]))
			unset($_SESSION[$name]);
	} elseif (is_null($name)) {
		$_SESSION = array();
		session_unset();
		session_destroy();
	} elseif ($name === '') {
		return $_SESSION;
	} else {//设置session
		$_SESSION[$name] = $value;
	}
}

/**
 * cookie处理
 * @param $name 名称
 * @param string $value 值
 * @param mixed $option 选项
 * @return mixed
 */
function cookie($name, $value = "", $option = array()) {
	// 默认设置
	$config = array('prefix' => C('COOKIE_PREFIX'), // cookie 名称前缀
	'expire' => C('COOKIE_EXPIRE'), // cookie 保存时间
	'path' => C('COOKIE_PATH'), // cookie 保存路径
	'domain' => C('COOKIE_DOMAIN'), // cookie 有效域名
	);
	// 参数设置(会覆盖黙认设置)
	if (!empty($option)) {
		if (is_numeric($option))
			$option = array('expire' => $option);
		elseif (is_string($option))
			parse_str($option, $option);
		$config = array_merge($config, array_change_key_case($option));
	}
	// 清除指定前缀的所有cookie
	if (is_null($name)) {
		if (empty($_COOKIE))
			return;
		// 要删除的cookie前缀，不指定则删除config设置的指定前缀
		$prefix = empty($value) ? $config['prefix'] : $value;
		if (!empty($prefix)) {// 如果前缀为空字符串将不作处理直接返回
			foreach ($_COOKIE as $key => $val) {
				if (0 === stripos($key, $prefix)) {
					setcookie($key, '', time() - 3600, $config['path'], $config['domain']);
					unset($_COOKIE[$key]);
				}
			}
		}
		return;
	}
	$name = $config['prefix'] . $name;
	if ('' === $value) {
		// 获取指定Cookie
		return isset($_COOKIE[$name]) ? json_decode(MAGIC_QUOTES_GPC ? stripslashes($_COOKIE[$name]) : $_COOKIE[$name]) : null;
	} else {
		if (is_null($value)) {
			setcookie($name, '', time() - 3600, $config['path'], $config['domain']);
			unset($_COOKIE[$name]);
			// 删除指定cookie
		} else {
			// 设置cookie
			$value = json_encode($value);
			$expire = !empty($config['expire']) ? time() + intval($config['expire']) : 0;
			setcookie($name, $value, $expire, $config['path'], $config['domain']);
			$_COOKIE[$name] = $value;
		}
	}
}

/**
 * 获得浏览器版本
 */
function browser_info() {
	$agent = strtolower($_SERVER["HTTP_USER_AGENT"]);
	$browser = null;
	if (strstr($agent, 'msie 9.0')) {
		$browser = 'msie9';
	} else if (strstr($agent, 'msie 8.0')) {
		$browser = 'msie8';
	} else if (strstr($agent, 'msie 7.0')) {
		$browser = 'msie7';
	} else if (strstr($agent, 'msie 6.0')) {
		$browser = 'msie6';
	} else if (strstr($agent, 'firefox')) {
		$browser = 'firefox';
	} else if (strstr($agent, 'chrome')) {
		$browser = 'chrome';
	} else if (strstr($agent, 'safari')) {
		$browser = 'safari';
	} else if (strstr($agent, 'opera')) {
		$browser = 'opera';
	}
	return $browser;
}

/**
 * 载入或设置配置顶
 * @param string $name 配置名
 * @param string $value 配置值
 * @return bool|null
 */
function C($name = null, $value = null) {
	static $config = array();
	if (is_null($name)) {
		return $config;
	}
	if (is_array($value)) {
		$value = array_change_key_case_d($value);
	}
	if (is_string($name)) {
		$name = strtolower($name);
		if (!strstr($name, '.')) {
			//获得配置
			if (is_null($value)) {
				if (isset($config[$name]) && !is_array($config[$name])) {
					$config[$name] = trim($config[$name]);
				}
				return isset($config[$name]) ? $config[$name] : null;
			}
			//加载语言包
			if ($name == 'language') {
				is_file(COMMON_LANGUAGE_PATH . $value . '.php') and L(
				require COMMON_LANGUAGE_PATH . $value . '.php');
				//加载应用语言包
				is_file(LANGUAGE_PATH . $value . '.php') and L(
				require LANGUAGE_PATH . $value . '.php');
			}
			$config[$name] = isset($config[$name]) && is_array($config[$name]) && is_array($value) ? array_merge($config[$name], $value) : $value;
			return $config[$name];
		}
		//二维数组
		$name = array_change_key_case_d(explode(".", $name), 0);
		if (is_null($value)) {
			return isset($config[$name[0]][$name[1]]) ? $config[$name[0]][$name[1]] : null;
		}
		$config[$name[0]][$name[1]] = $value;
	}
	if (is_array($name)) {
		$config = array_merge($config, array_change_key_case_d($name, 0));
		return true;
	}
}

//加载语言处理
function L($name = null, $value = null) {
	static $languge = array();
	if (is_null($name)) {
		return $languge;
	}
	if (is_string($name)) {
		$name = strtolower($name);
		if (!strstr($name, '.')) {
			if (is_null($value))
				return isset($languge[$name]) ? $languge[$name] : null;
			$languge[$name] = $value;
			return $languge[$name];
		}
		//二维数组
		$name = array_change_key_case_d(explode(".", $name), 0);
		if (is_null($value)) {
			return isset($languge[$name[0]][$name[1]]) ? $languge[$name[0]][$name[1]] : null;
		}
		$languge[$name[0]][$name[1]] = $value;
	}
	if (is_array($name)) {
		$languge = array_merge($languge, array_change_key_case_d($name));
		return true;
	}
}

/**
 * 执行事件中的所有处理程序
 * @param $name 事件名称
 * @param array $param 参数
 * return void
 */
function event($name, &$param = array()) {
	//框架核心事件
	$core = C("CORE_EVENT." . $name);
	//应用组事件
	$group = C("GROUP_EVENT." . $name);
	//应用事件
	$event = C("APP_EVENT." . $name);
	if (is_array($group)) {
		if ($core) {
			$group = array_merge($core, $group);
		}
	} else {
		$group = $core;
	}
	if (is_array($group)) {
		if ($event) {
			$event = array_merge($group, $event);
		} else {
			$event = $group;
		}
	}
	if (is_array($event) && !empty($event)) {
		foreach ($event as $e) {
			E($e, $param);
		}
	}

}

/**
 * 执行单一事件处理程序
 * @param string $name 事件名称
 * @param null $params 事件参数
 */
function E($name, &$params = null) {
	$class = $name . "Event";
	$event = new $class;
	$event -> run($params);
}

/**
 * 获取与设置请求参数
 * @param $var 参数如 Q("cid) Q("get.cid") Q("get.")
 * @param null $default 默认值 当变量不存在时的值
 * @param null $filter 过滤函数
 * @return array|null
 */
function Q($var, $default = null, $filter = null) {
	//拆分，支持get.id  或 id
	$var = explode(".", $var);
	if (count($var) == 1) {
		array_unshift($var, 'request');
	}
	$var[0] = strtolower($var[0]);
	//获得数据并执行相应的安全处理
	switch (strtolower($var[0])) {
		case 'get' :
			$data = &$_GET;
			break;
		case 'post' :
			$data = &$_POST;
			break;
		case 'request' :
			$data = &$_REQUEST;
			break;
		case 'files' :
			$data = &$_FILES;
			break;
		case 'session' :
			$data = &$_SESSION;
			break;
		case 'cookie' :
			$data = &$_COOKIE;
			break;
		case 'server' :
			$data = &$_SERVER;
			break;
		case 'globals' :
			$data = &$GLOBALS;
			break;
		default :
			throw_exception($var[0] . 'Q方法参数错误');
	}
	//没有执行参数如q("post.")时返回所有数据
	if (empty($var[1])) {
		return $data;
		//如果存在数据如$this->_get("page")，$_GET中存在page数据
	} else if (isset($data[$var[1]])) {
		//要获得参数如$this->_get("page")中的page
		$value = $data[$var[1]];
		//对参数进行过滤的函数
		$funcArr = is_null($filter) ? C("FILTER_FUNCTION") : $filter;
		//参数过滤函数
		if (is_string($funcArr) && !empty($funcArr)) {
			$funcArr = explode(",", $funcArr);
		}
		//是否存在过滤函数
		if (!empty($funcArr) && is_array($funcArr)) {
			//对数据进行过滤处理
			foreach ($funcArr as $func) {
				if (!function_exists($func))
					continue;
				$value = is_array($value) ? array_map($func, $value) : $func($value);
			}
			$data[$var[1]] = $value;
			return $value;
		}
		return $value;
		//不存在值时返回第2个参数，例：$this->_get("page")当$_GET['page']不存在page时执行
	} else {
		$data[$var[1]] = $default;
		return $default;
	}
}

/**
 * 打印输出数据
 * @param void $var
 */
function show($var) {
	if (is_bool($var)) {
		var_dump($var);
	} else if (is_null($var)) {
		var_dump(NULL);
	} else {
		echo "<pre style='padding:10px;border-radius:5px;background:#F5F5F5;border:1px solid #aaa;font-size:14px;line-height:18px;'>" . print_r($var, true) . "</pre>";
	}
}

/**
 * 打印输出数据|show的别名
 * @param void $var
 */
function p($var) {
	show($var);
}

/**
 * 打印输出数据|show的别名
 * @param void $var
 */
function dump($var) {
	show($var);
}

/**
 * 跳转网址
 * @param string $url 跳转urlg
 * @param int $time 跳转时间
 * @param string $msg
 */
function go($url, $time = 0, $msg = '') {
	$url = U($url);
	if (!headers_sent()) {
		$time == 0 ? header("Location:" . $url) : header("refresh:{$time};url={$url}");
		exit($msg);
	} else {
		echo "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
		if ($time)
			exit($msg);
	}
}

/**
 * 获得客户端IP地址
 * @param int $type 类型
 * @return int
 */
function ip_get_client($type = 0) {
	$type = intval($type);
	$ip = '';
	//保存客户端IP地址
	if (isset($_SERVER)) {
		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		} else {
			$ip = $_SERVER["REMOTE_ADDR"];
		}
	} else {
		if (getenv("HTTP_X_FORWARDED_FOR")) {
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		} else if (getenv("HTTP_CLIENT_IP")) {
			$ip = getenv("HTTP_CLIENT_IP");
		} else {
			$ip = getenv("REMOTE_ADDR");
		}
	}
	$long = ip2long($ip);
	$clientIp = $long ? array($ip, $long) : array("0.0.0.0", 0);
	return $clientIp[$type];
}

/**
 * 是否为AJAX提交
 * @return boolean
 */
function ajax_request() {
	if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		return true;
	return false;
}

/**
 * 对数组或字符串进行转义处理，数据可以是字符串或数组及对象
 * @param void $data
 * @return type
 */
function addslashes_d($data) {
	if (is_string($data)) {
		return addslashes($data);
	}
	if (is_numeric($data)) {
		return $data;
	}
	if (is_array($data)) {
		$var = array();
		foreach ($data as $k => $v) {
			if (is_array($v)) {
				$var[$k] = addslashes_d($v);
				continue;
			} else {
				$var[$k] = addslashes($v);
			}
		}
		return $var;
	}
}

/**
 * 去除转义
 * @param type $data
 * @return type
 */
function stripslashes_d($data) {
	if (empty($data)) {
		return $data;
	} elseif (is_string($data)) {
		return stripslashes($data);
	} elseif (is_array($data)) {
		$var = array();
		foreach ($data as $k => $v) {
			if (is_array($v)) {
				$var[$k] = stripslashes_d($v);
				continue;
			} else {
				$var[$k] = stripslashes($v);
			}
		}
		return $var;
	}
}

/**
 * 将数组转为字符串表示形式
 * @param array $array 数组
 * @param int $level 等级不要传参数
 * @return string
 */
function array_to_String($array, $level = 0) {
	if (!is_array($array)) {
		return "'" . $array . "'";
	}
	$space = '';
	//空白
	for ($i = 0; $i <= $level; $i++) {
		$space .= "\t";
	}
	$arr = "Array\n$space(\n";
	$c = $space;
	foreach ($array as $k => $v) {
		$k = is_string($k) ? '\'' . addcslashes($k, '\'\\') . '\'' : $k;
		$v = !is_array($v) && (!preg_match("/^\-?[1-9]\d*$/", $v) || strlen($v) > 12) ? '\'' . addcslashes($v, '\'\\') . '\'' : $v;
		if (is_array($v)) {
			$arr .= "$c$k=>" . array_to_String($v, $level + 1);
		} else {
			$arr .= "$c$k=>$v";
		}
		$c = ",\n$space";
	}
	$arr .= "\n$space)";
	return $arr;
}

/**
 *  对变量进行 JSON 编码
 */
if (!function_exists('json_encode')) {

	function json_encode($value) {
		$json = new json();
		return $json -> encode($value);
	}

}
/**
 *  对JSON格式的字符串进行编码
 */
if (!function_exists('json_decode')) {

	function json_decode($json_value, $bool = false) {
		$json = new json();
		return $json -> decode($json_value, $bool);
	}

}

/**
 * 手机号码查询
 * */
function mobile_area($mobile) {
	//导入类库
	require_cache(HDPHP_EXTEND_PATH . "Org/Mobile/Mobile.class.php");
	return Mobile::area($mobile);
}

/**
 * 根据类型获得图像扩展名
 */
if (!function_exists('image_type_to_extension')) {

	function image_type_to_extension($type, $dot = true) {
		$e = array(1 => 'gif', 'jpeg', 'png', 'swf', 'psd', 'bmp', 'tiff', 'tiff', 'jpc', 'jp2', 'jpf', 'jb2', 'swc', 'aiff', 'wbmp', 'xbm');
		$type = (int)$type;
		return ($dot ? '.' : '') . $e[$type];
	}

}

/**
 * 获得随机字符串
 * @param int $len 长度
 * @return string
 */
function rand_str($len = 6) {
	$data = 'abcdefghijklmnopqrstuvwxyz0123456789';
	$str = '';
	while (strlen($str) < $len)
		$str .= substr($data, mt_rand(0, strlen($data) - 1), 1);
	return $str;
}

/**
 * 加密方法
 * @param $data 加密字符串
 * @param null $key 密钥
 * @return mixed|string
 */
function encrypt($data, $key = null) {
	return encry::encrypt($data, $key);
}

/**
 * 解密方法
 * @param string $data 解密字符串
 * @param null $key 密钥
 * @return mixed
 */
function decrypt($data, $key = null) {
	return encry::decrypt($data, $key);
}

/**
 * 数据安全处理
 * @param $data 要处理的数据
 * @param null $func 安全的函数
 * @return array|string
 */
function data_format(&$data, $func = null) {
	$functions = is_null($func) ? C("FILTER_FUNCTION") : $func;
	if (!is_array($functions)) {
		$functions = preg_split("/\s*,\s*/", $functions);
	}
	foreach ($functions as $_func) {
		if (is_string($data)) {//字符串数据
			$data = $_func($data);
		} else if (is_array($data)) {//数组数据
			foreach ($data as $k => $d) {
				$data[$k] = is_array($d) ? data_format($d, $functions) : $_func($d);
			}
		}
	}
	return $data;
}

/**
 * 获得变量值
 * @param string $varName 变量名
 * @param mixed $value 值
 * @return mixed
 */
function _default($varName, $value = "") {
	return isset($varName) && !empty($varName) ? $varName : $value;
}

/**
 * 请求方式
 * @param string $method 类型
 * @param string $varName 变量名
 * @param bool $html 实体化
 * @return mixed
 */
function _request($method, $varName = null, $html = true) {
	$method = strtolower($method);
	switch ($method) {
		case 'ispost' :
		case 'isget' :
		case 'ishead' :
		case 'isdelete' :
		case 'isput' :
			return strtolower($_SERVER['REQUEST_METHOD']) == strtolower(substr($method, 2));
		case 'get' :
			$data = &$_GET;
			break;
		case 'post' :
			$data = &$_POST;
			break;
		case 'request' :
			$data = &$_REQUEST;
			break;
		case 'Session' :
			$data = &$_SESSION;
			break;
		case 'cookie' :
			$data = &$_COOKIE;
			break;
		case 'server' :
			$data = &$_SERVER;
			break;
		case 'globals' :
			$data = &$GLOBALS;
			break;
		default :
			throw_exception('abc');
	}
	//获得所有数据
	if (is_null($varName))
		return $data;
	if (isset($data[$varName]) && $html) {
		$data[$varName] = htmlspecialchars($data[$varName]);
	}
	return isset($data[$varName]) ? $data[$varName] : null;
}

/**
 * HTTP状态信息设置
 * @param Number $code 状态码
 */
function set_http_state($code) {
	$state = array(200 => 'OK', // Success 2xx
	// Redirection 3xx
	301 => 'Moved Permanently', 302 => 'Moved Temporarily ',
	// Client Error 4xx
	400 => 'Bad Request', 403 => 'Forbidden', 404 => 'Not Found',
	// Server Error 5xx
	500 => 'Internal Server Error', 503 => 'Service Unavailable', );
	if (isset($state[$code])) {
		header('HTTP/1.1 ' . $code . ' ' . $state[$code]);
		header('Status:' . $code . ' ' . $state[$code]);
		//FastCGI模式
	}
}

/**
 * 是否为SSL协议
 * @return boolean
 */
function is_ssl() {
	if (isset($_SERVER['HTTPS']) && ('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))) {
		return true;
	} elseif (isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'])) {
		return true;
	}
	return false;
}

/**
 * 用户定义常量
 * @param bool $view 是否显示
 * @param bool $tplConst 是否只获取__WEB__这样的常量
 * @return array
 */
function print_const($view = true, $tplConst = false) {
	$define = get_defined_constants(true);
	$const = $define['user'];
	if ($tplConst) {
		$const = array();
		foreach ($define['user'] as $k => $d) {
			if (preg_match('/^__/', $k)) {
				$const[$k] = $d;
			}
		}
	}
	if ($view) {
		p($const);
	} else {
		return $const;
	}
}

/**
 * 获得几天前，几小时前，几月前
 * @param int $time 时间戳
 * @param array $unit 时间单位
 * @return bool|string
 */
function date_before($time, $unit = null) {
	$time = intval($time);
	$unit = is_null($unit) ? array("年", "月", "星期", "天", "小时", "分钟", "秒") : $unit;
	switch (true) {
		case $time < (NOW - 31536000) :
			return floor((NOW - $time) / 31536000) . $unit[0] . '前';
		case $time < (NOW - 2592000) :
			return floor((NOW - $time) / 2592000) . $unit[1] . '前';
		case $time < (NOW - 604800) :
			return floor((NOW - $time) / 604800) . $unit[2] . '前';
		case $time < (NOW - 86400) :
			return floor((NOW - $time) / 86400) . $unit[3] . '前';
		case $time < (NOW - 3600) :
			return floor((NOW - $time) / 3600) . $unit[4] . '前';
		case $time < (NOW - 60) :
			return floor((NOW - $time) / 60) . $unit[5] . '前';
		default :
			return floor(NOW - $time) . $unit[6] . '前';
	}
}

/**
 * 获得唯一uuid值
 * @param string $sep 分隔符
 * @return string
 */
function get_uuid($sep = '') {
	if (function_exists('com_create_guid')) {
		return com_create_guid();
	} else {
		mt_srand((double)microtime() * 10000);
		//optional for php 4.2.0 and up.
		$id = strtoupper(md5(uniqid(rand(), true)));
		$sep = '';
		// "-"
		$uuid = substr($id, 0, 8) . $sep . substr($id, 8, 4) . $sep . substr($id, 12, 4) . $sep . substr($id, 16, 4) . $sep . substr($id, 20, 12);
		return $uuid;
	}
}
