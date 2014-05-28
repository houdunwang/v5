<?php if(!defined('HDPHP_PATH'))exit;
return array (
  'mid' => 
  array (
    'field' => 'mid',
    'type' => 'int(10) unsigned',
    'null' => 'NO',
    'key' => true,
    'default' => NULL,
    'extra' => 'auto_increment',
  ),
  'from_uid' => 
  array (
    'field' => 'from_uid',
    'type' => 'int(10) unsigned',
    'null' => 'NO',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'to_uid' => 
  array (
    'field' => 'to_uid',
    'type' => 'int(10) unsigned',
    'null' => 'NO',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'content' => 
  array (
    'field' => 'content',
    'type' => 'varchar(255)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'user_message_state' => 
  array (
    'field' => 'user_message_state',
    'type' => 'tinyint(1)',
    'null' => 'NO',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'sendtime' => 
  array (
    'field' => 'sendtime',
    'type' => 'int(10)',
    'null' => 'NO',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
);
?>