<?php
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
if (!defined("HDPHP_PATH"))
	exit('No direct script access allowed');

/**
 * 控制器基类
 * @package     core
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
abstract class Control {

	/**
	 * 模板视图对象
	 * @var view
	 * @access private
	 */
	protected $view = null;
	//事件参数
	protected $options = array();

	/**
	 * 构造函数
	 */
	public function __construct() {
		event("CONTROL_START", $this -> options);
		//子类如果存在auto方法，自动运行
		if (method_exists($this, "__init")) {
			$this -> __init();
		}
		if (method_exists($this, "__auto")) {
			$this -> __auto();
		}
	}

	/**
	 * 执行不存在的函数时会自动执行的魔术方法
	 * 编辑器上传时执行php脚本及ispost或_post等都会执行这个方法
	 * @access protected
	 * @param string $method 方法名
	 * @param mixed $args 方法参数
	 * @return mixed
	 */
	public function __call($method, $args) {
		//调用的方法不存在
		if (strcasecmp($method, METHOD) == 0) {
			//执行插件如uploadify|ueditor|keditor
			if (alias_import($method)) {
				require    alias_import($method);
			} elseif (method_exists($this, "__empty")) {
				//执行空方法_empty
				$this -> __empty($args);
			} else {
				//方法不存在时抛出404错误页
				_404('模块中不存在方法' . $method);
			}
		}
	}

	/**
	 * 魔术方法
	 * @param $name
	 * @param $value
	 */
	public function __set($name, $value) {
		$this -> assign($name, $value);
	}

	/**
	 * 获得模型对象与M()方法相同
	 * @access protected
	 * @param string $tableName 表名
	 * @param boolean $full 是否是全表名，如果为TRUE时系统不会自动添加表前缀
	 * @return Object
	 */
	protected function model($tableName = null, $full = null) {
		//获得模型对象
		return M($tableName, $full);
	}

	/**
	 * 获得扩展模型对象
	 * @access protected
	 * @param string $model 扩展模型名称
	 * @return Object
	 */
	protected function kmodel($model) {
		//获得扩展模型对象
		return K($model);
	}

	/**
	 * 获得视图对象
	 * @access private
	 * @return void
	 */
	private function getViewObj() {
		if (is_null($this -> view)) {
			//获得视图驱动含hd模板引擎与smarty引擎
			$this -> view = ViewFactory::factory();
		}
	}

	/**
	 * 显示视图
	 * @access protected
	 * @param string $tplFile 模板文件
	 * @param null $cacheTime 缓存时间
	 * @param string $cachePath 缓存目录
	 * @param bool $stat 是否返回解析结果
	 * @param string $contentType 文件类型
	 * @param string $charset 字符集
	 * @param bool $show 是否显示
	 * @return mixed
	 */
	protected function display($tplFile = null, $cacheTime = null, $cachePath = null, $stat = false, $contentType = "text/html", $charset = "", $show = true) {
		$this -> getViewObj();
		//执行视图对象中的display同名方法
		return $this -> view -> display($tplFile, $cacheTime, $cachePath, $contentType, $charset, $show);
	}

	/**
	 * 获得视图显示内容 用于生成静态或生成缓存文件
	 * @param string $tplFile 模板文件
	 * @param null $cacheTime 缓存时间
	 * @param string $cachePath 缓存目录
	 * @param string $contentType 文件类型
	 * @param string $charset 字符集
	 * @param bool $show 是否显示
	 * @return mixed
	 */
	protected function fetch($tplFile = null, $cacheTime = null, $cachePath = null, $contentType = "text/html", $charset = "", $show = true) {
		$this -> getViewObj();
		return $this -> view -> fetch($tplFile, $cacheTime, $cachePath, $contentType, $charset);
	}

	/**
	 * 模板缓存是否过期
	 * @param string $cachePath 缓存目录
	 * @access protected
	 * @return mixed
	 */
	protected function isCache($cachePath = null) {
		$args = func_get_args();
		$this -> getViewObj();
		return call_user_func_array(array($this -> view, "isCache"), $args);
	}

	/**
	 * 分配变量
	 * @access protected
	 * @param mixed $name 变量名
	 * @param mixed $value 变量值
	 * @return mixed
	 */
	protected function assign($name, $value = null) {
		$this -> getViewObj();
		return $this -> view -> assign($name, $value);
	}

	/**
	 * 错误输出
	 * @param string $msg 提示内容
	 * @param string $url 跳转URL
	 * @param int $time 跳转时间
	 * @param null $tpl 模板文件
	 */
	protected function error($msg = '出错了', $url = NULL, $time = 2, $tpl = null) {
		$url = $url ? "window.location.href='" . U($url) . "'" : "window.history.back(-1);";
		$tpl = $tpl ? $tpl : strstr(C("TPL_ERROR"), '/') ? C("TPL_ERROR") : PUBLIC_PATH . C("TPL_ERROR");
		$this -> assign(array("msg" => $msg, 'url' => $url, 'time' => $time));
		$this -> display($tpl);
		exit ;
	}

	/**
	 * 成功
	 * @param string $msg 提示内容
	 * @param string $url 跳转URL
	 * @param int $time 跳转时间
	 * @param null $tpl 模板文件
	 */
	protected function success($msg = '操作成功', $url = NULL, $time = 2, $tpl = null) {
		$url = $url ? "window.location.href='" . U($url) . "'" : "window.history.back(-1);";
		$tpl = $tpl ? $tpl : strstr(C("TPL_SUCCESS"), '/') ? C("TPL_SUCCESS") : PUBLIC_PATH . C("TPL_SUCCESS");
		$this -> assign(array("msg" => $msg, 'url' => $url, 'time' => $time));
		$this -> display($tpl);
		exit ;
	}

	/**
	 * Ajax输出
	 * @param $data 数据
	 * @param string $type 数据类型 text html xml json
	 */
	protected function ajax($data, $type = "JSON") {
		$type = strtoupper($type);
		switch ($type) {
			case "HTML" :
			case "TEXT" :
				$_data = $data;
				break;
			case "XML" :
				//XML处理
				$_data = Xml::create($data, "root", "UTF-8");
				break;
			default :
				//JSON处理
				$_data = json_encode($data);
		}
		echo $_data;
		exit ;
	}

	/**
	 * 生成静态
	 * @param string $htmlfile 文件名
	 * @param string $htmlpath 目录
	 * @param string $template 模板文件
	 */
	public function createHtml($htmlfile, $htmlpath = '', $template = '') {
		$content = $this -> fetch($template);
		$htmlpath = empty($htmlpath) ? C('HTML_PATH'): $htmlpath;
		$file = $htmlpath . $htmlfile . '.html';
		$Storage = Storage::init();
		return $Storage -> save($file, $content);
	}

	//析构函数
	public function __destruct() {
		event("CONTROL_END", $this -> options);
	}

}
