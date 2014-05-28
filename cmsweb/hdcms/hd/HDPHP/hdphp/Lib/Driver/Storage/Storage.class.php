<?php
/**
 * 储存工厂类
 * @author hdxj <houdunwangxj@gmail.com>
 */
final class Storage {
	//处理程序
	static private $handler = null;
	static public function init($Driver = 'File') {
		if (is_null(self::$handler)) {
			self::connect($Driver);
		}
		return self::$handler;
	}

	//驱动连接
	static public function connect($Driver = '') {
		$Driver = empty($Driver) ? C('STORAGE_DRIVER') : $Driver;
		$class = $Driver . 'Storage';
		self::$handler = new $class;
	}

	//调用驱动方法
	public function __call($method, $args) {echo 232323;
		if (method_exists(self::$handler, $method)) {
			return call_user_func_array(array(self::$handler, $method), $args);
		}
	}

}
