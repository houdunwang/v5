<?php if(!defined('HDPHP_PATH'))exit;
return array (
  'nid' => 
  array (
    'field' => 'nid',
    'type' => 'smallint(6)',
    'null' => 'NO',
    'key' => true,
    'default' => NULL,
    'extra' => 'auto_increment',
  ),
  'title' => 
  array (
    'field' => 'title',
    'type' => 'char(30)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'app_group' => 
  array (
    'field' => 'app_group',
    'type' => 'char(30)',
    'null' => 'NO',
    'key' => false,
    'default' => 'Hdcms',
    'extra' => '',
  ),
  'app' => 
  array (
    'field' => 'app',
    'type' => 'char(30)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'control' => 
  array (
    'field' => 'control',
    'type' => 'char(30)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'method' => 
  array (
    'field' => 'method',
    'type' => 'char(30)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'param' => 
  array (
    'field' => 'param',
    'type' => 'char(100)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'comment' => 
  array (
    'field' => 'comment',
    'type' => 'varchar(255)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'state' => 
  array (
    'field' => 'state',
    'type' => 'tinyint(1)',
    'null' => 'NO',
    'key' => false,
    'default' => '1',
    'extra' => '',
  ),
  'type' => 
  array (
    'field' => 'type',
    'type' => 'tinyint(1) unsigned',
    'null' => 'NO',
    'key' => false,
    'default' => '2',
    'extra' => '',
  ),
  'pid' => 
  array (
    'field' => 'pid',
    'type' => 'smallint(6)',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'list_order' => 
  array (
    'field' => 'list_order',
    'type' => 'smallint(6)',
    'null' => 'NO',
    'key' => false,
    'default' => '100',
    'extra' => '',
  ),
  'is_system' => 
  array (
    'field' => 'is_system',
    'type' => 'tinyint(1)',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'favorite' => 
  array (
    'field' => 'favorite',
    'type' => 'tinyint(1)',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
);
?>