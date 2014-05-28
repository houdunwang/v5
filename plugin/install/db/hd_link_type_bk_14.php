<?php if(!defined('HDPHP_PATH'))EXIT;
$db->exe("REPLACE INTO ".$db_prefix."link_type (`tid`,`type_name`,`system`) VALUES('1','友情链接','1')");
$db->exe("REPLACE INTO ".$db_prefix."link_type (`tid`,`type_name`,`system`) VALUES('2','合作伙伴','1')");
