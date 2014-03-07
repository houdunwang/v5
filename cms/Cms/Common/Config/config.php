<?php
if (!defined("HDPHP_PATH"))exit('No direct script access allowed');
//更多配置请查看hdphp/Config/config.php
$config =  array(
    'DB_DRIVER'                     => 'mysqli',    //数据库驱动
    'DB_CHARSET'                    => 'utf8',     //数据库字符集
    'DB_HOST'                       => '127.0.0.1', //数据库连接主机  如127.0.0.1
    'DB_PORT'                       => 3306,        //数据库连接端口
    'DB_USER'                       => 'root',      //数据库用户名
    'DB_PASSWORD'                   => '',          //数据库密码
    'DB_DATABASE'                   => 'v5cms',          //数据库名称
    'DB_PREFIX'                  => 'v5_',          //表前缀
    'DB_BACKUP'                 => ROOT_PATH . 'backup/'.time(), //数据库备份目录
    'DEFAULT_APP'		=> 'Admin',			//默认访问应用 
     'TPL_ERROR'                     => GROUP_TEMPLATE.'error.html',     //错误信息模板
    'TPL_SUCCESS'                   => GROUP_TEMPLATE.'success.html',   //正确信息模板
);
return array_merge($config,require 'data/config/config.inc.php');
?>