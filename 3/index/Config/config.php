<?php
if (!defined("HDPHP_PATH"))exit('No direct script access allowed');
//更多配置请查看hdphp/Config/config.php
return array(
   'DB_DRIVER'                     => 'mysqli',    //数据库驱动
    'DB_CHARSET'                    => 'utf8',     //数据库字符集
    'DB_HOST'                       => '127.0.0.1', //数据库连接主机  如127.0.0.1
    'DB_PORT'                       => 3306,        //数据库连接端口
    'DB_USER'                       => 'root',      //数据库用户名
    'DB_PASSWORD'                   => '',          //数据库密码
    'DB_DATABASE'                   => 'v5',          //数据库名称
    'DB_PREFIX'                     => 'hd_',          //表前缀
    //路由定义
    'route'=>array(
  		'/^(\d+).html$/'=>'News/content/id/#1'
	)
    //1.html 2.html 1211111111.html
    //localhost/v5/3/index.php/1.html
    //localhost/v5/3/index.php/News/content/id/1
    //localhost/v5/3/index.php/2.html
);
?>