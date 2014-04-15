<?php
if (!defined("HDPHP_PATH"))exit('No direct script access allowed');
//更多配置请查看hdphp/Config/config.php
$config =  array(
    'DB_BACKUP'                 => ROOT_PATH . 'backup/'.time(), //数据库备份目录
    'DEFAULT_APP'		=> 'Index',			//默认访问应用 
     'TPL_ERROR'                     => GROUP_TEMPLATE.'error.html',     //错误信息模板
    'TPL_SUCCESS'                   => GROUP_TEMPLATE.'success.html',   //正确信息模板
    'ROUTE'=>array(
            //栏目列表页url地址
            '/^list(\d+).html$/'    =>'Index/Index/Channel/cid/#1',
            '/^(\d+)_(\d+).html$/'    => 'Index/Index/Article/cid/#1/id/#2'
    ),
);
return array_merge($config,require 'data/config/config.inc.php',
    require 'data/config/db.inc.php');
?>