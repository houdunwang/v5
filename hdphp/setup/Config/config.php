<?php

if (!defined('HDPHP_PATH'))exit;
$config = array(
    //系统调试
    "DEBUG_MENU" =>0, //显示debug菜单
    "SHOW_NOTICE" => 0, //提示性错误显示
    "SHOW_SYSTEM" => 0, //显示系统信息
    "SHOW_INCLUDE" => 0, //显示加载文件信息
    "SHOW_SQL" => 0, //显示执行的SQL语句
    "SHOW_TPL_COMPILE" => 0, //显示模板编译文件
);
return array_merge($config, include CONFIG_PATH . 'config.db.php');
?>