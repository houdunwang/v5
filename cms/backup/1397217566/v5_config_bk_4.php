<?php if(!defined('HDPHP_PATH'))EXIT;
$db->exe("REPLACE INTO ".$db_prefix."config (`id`,`title`,`name`,`value`,`show_type`,`message`,`option`) VALUES('1','网站名称','webname','后盾网V5课堂-每周五晚7：30与你在一起','1','网站名称','')");
$db->exe("REPLACE INTO ".$db_prefix."config (`id`,`title`,`name`,`value`,`show_type`,`message`,`option`) VALUES('2','ICP','icp','京ICP备12048441号-3','1','ICP','')");
$db->exe("REPLACE INTO ".$db_prefix."config (`id`,`title`,`name`,`value`,`show_type`,`message`,`option`) VALUES('3','QQ','qq','1455067020','1','QQ','')");
$db->exe("REPLACE INTO ".$db_prefix."config (`id`,`title`,`name`,`value`,`show_type`,`message`,`option`) VALUES('4','站长邮箱','email','houdunwangxj@gmail.com','1','站长邮箱','')");
$db->exe("REPLACE INTO ".$db_prefix."config (`id`,`title`,`name`,`value`,`show_type`,`message`,`option`) VALUES('5','网站开头','web_status','1','2','网站开头','1|开启,0|关闭')");
$db->exe("REPLACE INTO ".$db_prefix."config (`id`,`title`,`name`,`value`,`show_type`,`message`,`option`) VALUES('6','网站关闭提示','close_message','网站升级中...，请1小时后访问，感谢您的支持，你的支持是我们前进的动力！！！！','3','网站关闭提示','')");
