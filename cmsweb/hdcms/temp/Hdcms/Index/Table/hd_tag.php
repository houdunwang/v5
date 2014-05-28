<?php if(!defined('HDPHP_PATH'))exit;
return array (
  'tid' => 
  array (
    'field' => 'tid',
    'type' => 'int(10) unsigned',
    'null' => 'NO',
    'key' => true,
    'default' => NULL,
    'extra' => 'auto_increment',
  ),
  'tag' => 
  array (
    'field' => 'tag',
    'type' => 'varchar(30)',
    'null' => 'YES',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'total' => 
  array (
    'field' => 'total',
    'type' => 'mediumint(9)',
    'null' => 'YES',
    'key' => false,
    'default' => '1',
    'extra' => '',
  ),
);
?>