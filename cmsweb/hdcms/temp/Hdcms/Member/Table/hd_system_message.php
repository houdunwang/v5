<?php if(!defined('HDPHP_PATH'))exit;
return array (
  'mid' => 
  array (
    'field' => 'mid',
    'type' => 'int(11) unsigned',
    'null' => 'NO',
    'key' => true,
    'default' => NULL,
    'extra' => 'auto_increment',
  ),
  'uid' => 
  array (
    'field' => 'uid',
    'type' => 'int(10) unsigned',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'message' => 
  array (
    'field' => 'message',
    'type' => 'varchar(200)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'state' => 
  array (
    'field' => 'state',
    'type' => 'tinyint(4) unsigned',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'sendtime' => 
  array (
    'field' => 'sendtime',
    'type' => 'int(11) unsigned',
    'null' => 'NO',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
);
?>