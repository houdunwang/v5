<?php
// .-----------------------------------------------------------------------------------
// |  Software: [HDPHP framework]
// |   Version: 2013.01
// |      Site: http://www.hdphp.com
// |-----------------------------------------------------------------------------------
// |    Author: 向军 <houdunwangxj@gmail.com>
// | Copyright (c) 2012-2013, http://www.houdunwang.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
// |   License: http://www.apache.org/licenses/LICENSE-2.0
// '-----------------------------------------------------------------------------------
/**
 * HDPHP框架入口文件
 * 在应用入口引入hdphp.php即可运行框架
 * @package hdphp
 * @supackage core
 * @author hdxj <houdunwangxj@gmail.com>
 */
//对旧框架的使用建议
if (defined("APP")) {
    header("Content-type:text/html;charset=utf-8");
    _error_msg("必须使用APP_NAME定义应用名");
}
if (defined("APP_PATH") && substr(APP_PATH, -1) !== '/') {
    header("Content-type:text/html;charset=utf-8");
    _error_msg("APP_PATH常量必须以/结尾");
}
if (defined("GROUP_PATH") && substr(GROUP_PATH, -1) !== '/') {
    header("Content-type:text/html;charset=utf-8");
    _error_msg("GROUP_PATH常量必须以/结尾");
}

//框架版本
define('HDPHP_VERSION', '2013.12.18');
//框架目录
define('HDPHP_PATH', str_replace('\\', '/', dirname(__FILE__)) . '/');
//根目录
define('ROOT_PATH', dirname(str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME'])) . '/');
//debug
defined("DEBUG") or define("DEBUG", FALSE);
//应用组
if (defined('GROUP_NAME') or defined('GROUP_PATH')) {
    defined('GROUP_NAME') or define('GROUP_NAME', basename(dirname($_SERVER['SCRIPT_NAME'])));
    defined('GROUP_PATH') or define('GROUP_PATH', './' . GROUP_NAME . '/');
} else {
//应用
    defined('APP_NAME') or define('APP_NAME', basename(dirname($_SERVER['SCRIPT_NAME'])));
    defined('APP_PATH') or define('APP_PATH', './' . APP_NAME . '/');
}
//应用组判断常量
define('IS_GROUP', defined("GROUP_NAME") or defined("GROUP_PATH"));
//临时目录
defined('TEMP_PATH') or define('TEMP_PATH', (defined('APP_PATH') ? APP_PATH : GROUP_PATH) . 'Temp/');
//核心编译文件
defined('TEMP_FILE') or define('TEMP_FILE', 'Boot.php');
//加载核心编译文件
//考虑使用C()函数动态开启debug，所以在hdphp.class.php类中进行处理
//考虑单一性原则通过C()函数动态开启debug功能会删除掉
if (!DEBUG and is_file(TEMP_PATH . TEMP_FILE)) {
    require TEMP_PATH . TEMP_FILE;
} else {
    //编译文件
    require HDPHP_PATH . '/Lib/Core/Boot.class.php';
    Boot::run();
}
function _error_msg($msg)
{
    echo "<div style='font-size:18px;padding:20px;background:#FFD896;font-family: 微软雅黑;'>$msg</div>";
    exit;
}

?>