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
 * HDPHP模板引擎
 * @package     Session
 * @subpackage  Driver
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
final class ViewHd extends View
{

    public $vars = array(); //模板变量
    public $const = array(); //系统常量如__WEB__$const['WEB'];
    public $tplFile = null; //模版文件
    public $compileFile = null; //编译文件

    /**
     * 模板显示
     * @param string $tplFile 模板文件
     * @param string $cachePath 缓存目录
     * @param null $cacheTime 缓存时间
     * @param string $contentType 文件类型
     * @param string $charset 字符集
     * @param bool $show 是否显示
     * @return bool|string
     */
    public function display($tplFile = null, $cacheTime = null, $cachePath = null, $contentType = "text/html", $charset = "", $show = true)
    {

        //缓存文件名
        $cacheName = md5($_SERVER['REQUEST_URI']);
        //内容
        $content = null;
        if ($cacheTime >= 0) {
            $content = S($cacheName, false, $cacheTime, array("dir" => $cachePath, 'zip'=>false,"Driver" => "File"));
        }
        //缓存失效
        if (!$content) {
            //获得模板文件
            $this->tplFile = $this->getTemplateFile($tplFile);
            //模板文件不存在
            if (!$this->tplFile) return;
            //编译文件
            $this->compileFile = COMPILE_PATH . basename($this->tplFile, C("TPL_FIX")) . '_' . substr(md5(APP . CONTROL . METHOD), 0, 5) . '.php';
            //记录模板编译文件
            if (DEBUG) {
                Debug::$tpl[] = array(basename($this->tplFile), $this->compileFile);
            }
            //缓存时间
            $cacheTime = is_int($cacheTime) ? $cacheTime : intval(C("CACHE_TPL_TIME"));
            //缓存路径
            $cachePath = $cachePath ? $cachePath : CACHE_PATH;
            //编译文件失效（不存在或过期）
            if ($this->compileInvalid($tplFile)) {
                //执行编译
                $this->compile();
            }
            $_CONFIG = C();
            $_LANGUAGE = L();
            //加载全局变量
            if (!empty($this->vars)) {
                extract($this->vars);
            }
            ob_start();
            include($this->compileFile);
            $content = ob_get_clean();
            //创建缓存
            if ($cacheTime >= 0) {
                //创建缓存目录
                is_dir(CACHE_PATH) || dir_create(CACHE_PATH);
                //写入缓存
                S($cacheName, $content, $cacheTime, array("dir" => $cachePath,'zip'=>false, "Driver" => "File"));
            }
        }
        if ($show) {
            $charset = strtoupper(C("CHARSET")) == 'UTF8' ? "UTF-8" : strtoupper(C("CHARSET"));
            if (!headers_sent()) {
                header("Content-type:" . $contentType . ';charset=' . $charset);
            }
            echo $content;
        } else {
            return $content;
        }
    }

    /**
     * 获得视图内容
     */
    public function fetch($tplFile = null, $cacheTime = null, $cachePath = null, $contentType = "text/html", $charset = "")
    {
        return $this->display($tplFile, $cacheTime, $cachePath, $contentType, $charset, false);
    }

    /**
     * 验证缓存是否过期
     * @param string $cachePath 缓存目录
     * @return bool
     */
    public function isCache($cachePath = null)
    {
        $cachePath = $cachePath ? $cachePath : CACHE_PATH;
        return S($_SERVER['REQUEST_URI'], false, null, array("dir" => $cachePath, "Driver" => "File")) ? true : false;
    }

    /**
     * 编译是否失效
     * @return bool true 失效
     */
    private function compileInvalid()
    {
        $tplFile = $this->tplFile;
        $compileFile = $this->compileFile;
        return DEBUG || !file_exists($compileFile) || //模板不存在
        (filemtime($tplFile) > filemtime($compileFile)); //编板有更新
    }

    /**
     * 编译模板
     */
    public function compile()
    {
        //编译是否失效
        if (!$this->compileInvalid())
            return;
        $compileObj = new ViewCompile($this);
        $compileObj->run();
    }

    /**
     * 获得编译文件内容
     * @return string
     */
    public function getCompileContent()
    {
        return file_get_contents($this->compileFile);
    }

    /**
     * 向模板中传入变量
     * @param string $var 变量名
     * @param mixed $value 变量值
     * @return bool
     */
    public function assign($var, $value)
    {
        if (is_array($var)) {
            foreach ($var as $k => $v) {
                if (is_string($k)) $this->vars[$k] = $v;
            }
        } else {
            $this->vars[$var] = $value;
        }
    }

    /**
     * 设置ASSIGN分配的变量
     * @param string $name 变量名
     * @param mixed $value 值
     */
    function __set($name, $value)
    {
        if (isset($this->vars[$name])) {
            $this->vars[$name] = $value;
        }
    }

}

?>