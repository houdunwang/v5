<?php if(!defined('HDPHP_PATH'))exit;
return array (
  'tid' => 
  array (
    'field' => 'tid',
    'type' => 'smallint(5) unsigned',
    'null' => 'NO',
    'key' => true,
    'default' => NULL,
    'extra' => 'auto_increment',
  ),
  'type_name' => 
  array (
    'field' => 'type_name',
    'type' => 'char(50)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'system' => 
  array (
    'field' => 'system',
    'type' => 'tinyint(1)',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
);
?>