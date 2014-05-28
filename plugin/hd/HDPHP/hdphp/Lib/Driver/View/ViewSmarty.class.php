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
 * SMARTY模板引擎
 * @package     Session
 * @subpackage  Driver
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
class ViewSmarty extends View {

    public $cacheTime; //缓存时间
    private $smarty; //SMARTY对象资源

    //构造函数

    public function __construct() {
        $this->smarty = new Smarty();
        $this->smarty->template_dir = PATH_TPL; //模板目录
        $this->smarty->compile_dir = PATH_TEMP_COMPILE; //编译目录
        $this->smarty->cache_dir = PATH_TEMP_CACHE; //缓存目录
        $this->smarty->left_delimiter = C("TPL_TAG_LEFT");
        $this->smarty->right_delimiter = C("TPL_TAG_RIGHT");
        is_dir(PATH_TPL) || dir_create(PATH_TPL);
        is_dir(PATH_TEMP_COMPILE) || dir_create(PATH_TEMP_COMPILE);
        is_dir(PATH_TEMP_CACHE) || dir_create(PATH_TEMP_CACHE);
    }

    //显示视图
    public function display($resource_name, $cacheTime = null) {
        $resource_name = $this->getTemplateFile($resource_name);
        //缓存时间设置
        $_cacheTime = is_null($cacheTime) ? C("CACHE_TPL_TIME") : $cacheTime;
        $cacheTime = is_int($_cacheTime) ? $_cacheTime : Null;
        $content = false;
        if ($cacheTime) {
            $content = S($_SERVER['REQUEST_URI'], false, null, array("dir" => PATH_TEMP_TPL_CACHE, "Driver" => "File"));
        }
        if (!$content) {
            $content = $this->smarty->fetch($resource_name);
            //创建缓存
            if ($cacheTime) {
                is_dir(PATH_TEMP_TPL_CACHE) || dir_create(PATH_TEMP_CACHE); //创建缓存目录
                S($_SERVER['REQUEST_URI'], $content, $cacheTime, array("dir" => PATH_TEMP_TPL_CACHE, "Driver" => "File")); //写入缓存
            }
        }
    }

    //分配变量
    public function assign($name, $value) {
        $this->smarty->assign($name, $value);
    }

    //缓存处理
    public function isCache() {
         return S($_SERVER['REQUEST_URI'], false, null, array("dir" => PATH_TEMP_TPL_CACHE, "Driver" => "File")) ? true : false;
    }

}

?>