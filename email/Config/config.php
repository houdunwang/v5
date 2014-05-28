<?php
if (!defined("HDPHP_PATH"))exit('No direct script access allowed');
//更多配置请查看hdphp/Config/config.php
return array(
	'EMAIL_USERNAME'                => 'v5@houdunwang.com',          //邮箱用户名
    'EMAIL_PASSWORD'                => 'hdv5123',          //邮箱密码
    'EMAIL_HOST'                    => 'smtp.exmail.qq.com',          //smtp地址如smtp.gmail.com或smtp.126.com建议使用126服务器
    'EMAIL_PORT'                    => 25,          //smtp端口 126为25，gmail为465
    'EMAIL_SSL'                     => 0,           //是否采用SSL,126为false,google必须为true
    'EMAIL_CHARSET'                 => 'utf8',          //字符集设置,中文乱码就是这个没有设置好 如utf8
    'EMAIL_FORMMAIL'                => 'v5@houdunwang.com',          //发送人发件箱显示的邮箱址址
    'EMAIL_FROMNAME'                => '后盾网V5讲堂'      //发送人发件箱显示的用户名
);
?>