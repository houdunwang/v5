<?php
// .-----------------------------------------------------------------------------------
// |  Software: [HDPHP framework]
// |   Version: 2013.12
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
define('HDPHP_VERSION', '2014-2-9');
defined("DEBUG")        or define("DEBUG", FALSE);
if (!defined('GROUP_PATH'))
    defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']).'/');
defined('TEMP_PATH')    or define('TEMP_PATH', (defined('APP_PATH') ? APP_PATH : GROUP_PATH) . 'Temp/');
defined("TEMP_NAME")    or define("TEMP_NAME",'~boot.php');
defined('TEMP_FILE')    or define('TEMP_FILE',TEMP_PATH.TEMP_NAME);
//加载核心编译文件
if (!DEBUG and is_file(TEMP_FILE)) {
    require TEMP_FILE;
} else {
    //编译文件
    define('HDPHP_PATH', str_replace('\\','/',dirname(__FILE__)) . '/');
    require HDPHP_PATH . 'Lib/Core/Boot.class.php';
    Boot::run();
}

?>