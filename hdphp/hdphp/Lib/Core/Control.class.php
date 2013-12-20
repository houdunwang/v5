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
abstract class Control
{

    /**
     * 模板视图对象
     * @var view
     * @access private
     */
    private $view = null;
    //事件参数
    protected $options = array();

    /**
     * 构造函数
     */
    public function __construct()
    {
        event("CONTROL_START", $this->options);
        //子类如果存在auto方法，自动运行
        if (method_exists($this, "__init")) {
            $this->__init();
        }
        if (method_exists($this, "__auto")) {
            $this->__auto();
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
    public function __call($method, $args)
    {
        //调用的方法不存在
        if (strcasecmp($method, METHOD) == 0) {
            //执行插件如uploadify|ueditor|keditor
            if (alias_import($method)) {
                include alias_import($method);
                //执行空方法_empty
            } elseif (method_exists($this, "__empty")) {
                $this->__empty($args);
                //方法不存在时抛出404错误页
            } else {
                _404("控制器中不存在方法" . $method);
            }
            //调用方法含有Model时，即$this->userModel()
        } else if (substr(ucfirst($method), -5) == "Model") {
            if (strstr($method, '_')) {
                $method = str_replace("_", "/", substr($method, 0, -5));
                return $this->kmodel($method);
            } else {
                return $this->kmodel(substr($method, 0, -5));
            }
        } else {
            switch (strtolower($method)) {
                //检测请求类型ispost等方法
                case 'ispost' :
                case 'isget' :
                case 'ishead' :
                case 'isdelete' :
                case 'isput' :
                    return strtolower($_SERVER['REQUEST_METHOD']) == strtolower(substr($method, 2));
                //获得数据并执行相应的安全处理
                case '_get' :
                    $data = & $_GET;
                    break;
                case '_post' :
                    $data = & $_POST;
                    break;
                case '_request' :
                    $data = & $_REQUEST;
                    break;
                case '_files' :
                    $data = & $_FILES;
                    break;
                case '_session' :
                    $data = & $_SESSION;
                    break;
                case '_cookie' :
                    $data = & $_COOKIE;
                    break;
                case '_server' :
                    $data = & $_SERVER;
                    break;
                case '_globals' :
                    $data = & $GLOBALS;
                    break;
                default:
                    throw_exception($method . '方法不存在');
            }
            //没有执行参数如$this->_get()时返回所有数据
            if (!isset($args[0])) {
                return $data;
                //如果存在数据如$this->_get("page")，$_GET中存在page数据
            } else if (isset($data[$args[0]])) {
                //要获得参数如$this->_get("page")中的page
                $value = $data[$args[0]];
                //如果没有函数时，直接返回值
                if (count($args) > 1 && empty($args[1])) {
                    return $value;
                }
                //对参数进行过滤的函数
                $funcArr = isset($args[1]) && !empty($args[1]) ? $args[1] : C("FILTER_FUNCTION");
                //是否存在过滤函数
                if (!empty($funcArr)) {
                    //参数过滤函数
                    if (!is_array($funcArr)) {
                        $funcArr = explode(",", $funcArr);
                    }
                    //对数据进行过滤处理
                    foreach ($funcArr as $func) {
                        if (!function_exists($func))
                            continue;
                        $value = is_array($value) ? array_map($func, $value) : $func($value);
                    }
                    $data[$args[0]] = $value;
                    return $value;
                }
                return $value;
                //不存在值时返回第2个参数，例：$this->_get("page")当$_GET['page']不存在page时执行
            } else {
                return isset($args[2]) ? $args[2] : NULL;
            }
        }
    }

    /**
     * 获得模型对象与M()方法相同
     * @access protected
     * @param string $tableName 表名
     * @param boolean $full 是否是全表名，如果为TRUE时系统不会自动添加表前缀
     * @return Object
     */
    protected function model($tableName = null, $full = null)
    {
        //获得模型对象
        return M($tableName, $full);
    }

    /**
     * 获得扩展模型对象
     * @access protected
     * @param string $model 扩展模型名称
     * @return Object
     */
    protected function kmodel($model)
    {
        //获得扩展模型对象
        return K($model);
    }

    /**
     * 获得视图对象
     * @access private
     * @return void
     */
    private function getViewObj()
    {
        if (is_null($this->view)) {
            //获得视图驱动含hd模板引擎与smarty引擎
            $this->view = ViewFactory::factory();
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
    protected function display($tplFile = null, $cacheTime = null, $cachePath = null, $stat = false, $contentType = "text/html", $charset = "", $show = true)
    {
        $this->getViewObj();
        //执行视图对象中的display同名方法
        return $this->view->display($tplFile, $cacheTime, $cachePath = null, $contentType, $charset, $show);
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
    protected function fetch($tplFile = null, $cacheTime = null, $cachePath = null, $contentType = "text/html", $charset = "", $show = true)
    {
        $this->getViewObj();
        return $this->view->fetch($tplFile, $cacheTime, $cachePath = null, $contentType, $charset);
    }

    /**
     * 模板缓存是否过期
     * @param string $cachePath 缓存目录
     * @access protected
     * @return mixed
     */
    protected function isCache($cachePath = null)
    {
        $args = func_get_args();
        $this->getViewObj();
        return call_user_func_array(array($this->view, "isCache"), $args);
    }


    /**
     * 分配变量
     * @access protected
     * @param $name 变量名
     * @param $value 变量值
     * @return mixed
     */
    protected function assign($name, $value)
    {
        $this->getViewObj();
        return $this->view->assign($name, $value);
    }

    /**
     * 错误输出
     * @param string $msg 提示内容
     * @param string $url 跳转URL
     * @param int $time 跳转时间
     * @param null $tpl 模板文件
     */
    protected function error($msg = "", $url = "", $time = 2, $tpl = null)
    {
        $msg = $msg ? $msg : L("control_error_msg");
        //模板文件
        $tpl_file = $tpl ? $tpl : C("TPL_ERROR");
        $this->_error_success($msg, $url, $time, $tpl_file);
    }

    /**
     * 成功
     * @param string $msg 提示内容
     * @param string $url 跳转URL
     * @param int $time 跳转时间
     * @param null $tpl 模板文件
     */
    protected function success($msg = NULL, $url = NULL, $time = 2, $tpl = null)
    {
        $msg = $msg ? $msg : L("control_success_msg");
        //模板文件
        $tpl_file = $tpl ? $tpl : C("TPL_SUCCESS");
        $this->_error_success($msg, $url, $time, $tpl_file);
        exit;
    }

    /**
     * 显示错误或正确页面
     * @param $msg 提示内容
     * @param $url 跳转URL
     * @param $time 跳转时间
     * @param $tpl_file 模板文件
     */
    private function _error_success($msg, $url, $time, $tpl_file)
    {
        //跳转时间
        $time = is_numeric($time) ? $time : 3;
        //没有指定url地址时回跳历史记录
        if (empty($url)) {
            $url = "window.history.back(-1);";
        } else {
            $url = "window.location.href='" . U($url) . "'";
        }
        //配置文件的模板风格
        $style_conf = C('TPL_STYLE') ? '/' . C('TPL_STYLE') . '/' : '/';
        //模板目录
        $tpl_dir = strstr(C("TPL_DIR"), '/') ? C("TPL_DIR") . $style_conf : APP_PATH . C("TPL_DIR") . $style_conf . 'Public/';
        //模板文件
        $tpl = strstr($tpl_file, '/') ? $tpl_file : $tpl_dir . $tpl_file;
        //分配提示信息
        $this->assign("msg", $msg);
        //分配URL
        $this->assign("url", $url);
        //分配跳转时间
        $this->assign("time", $time);
        //显示模板
        $this->display($tpl);
        exit;
    }

    /**
     * Ajax输出
     * @param $data 数据
     * @param string $type 数据类型 text html xml json
     */
    protected function _ajax($data, $type = "JSON")
    {
        $type = strtoupper($type);
        switch ($type) {
            case "HTML":
            case "TEXT":
                $_data = $data;
                break;
            case "XML": //XML处理
                $_data = Xml::create($data, "root", "UTF-8");
                break;
            default: //JSON处理
                $_data = json_encode($data);
        }
        echo $_data;
        exit;
    }

    //析构函数
    public function __destruct()
    {
        event("CONTROL_END", $this->options);
    }
}