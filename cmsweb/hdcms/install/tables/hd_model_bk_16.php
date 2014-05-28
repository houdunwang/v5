<?php if(!defined('HDPHP_PATH'))EXIT;
$db->exe("REPLACE INTO ".$db_prefix."model (`mid`,`model_name`,`table_name`,`enable`,`description`,`is_system`) VALUES('1','普通文章','content','1','','1')");
