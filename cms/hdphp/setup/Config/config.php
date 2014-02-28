<?php

if (!defined('HDPHP_PATH'))exit;
$config = array(
    'URL_TYPE'                      => 2,           //类型 1:PATHINFO模式 2:普通模式 3:兼容模式
    'TPL_FIX'                       => '.php',     //模版文件扩展名
    'TPL_ERROR'                     => 'error.html',     //错误信息模板
    'TPL_SUCCESS'                   => 'success.html',   //正确信息模板
);
return array_merge($config, require CONFIG_PATH . 'config.db.php');
?>