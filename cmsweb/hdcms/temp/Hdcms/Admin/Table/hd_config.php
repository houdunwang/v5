<?php if(!defined('HDPHP_PATH'))exit;
return array (
  'id' => 
  array (
    'field' => 'id',
    'type' => 'int(10) unsigned',
    'null' => 'NO',
    'key' => true,
    'default' => NULL,
    'extra' => 'auto_increment',
  ),
  'name' => 
  array (
    'field' => 'name',
    'type' => 'varchar(45)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'value' => 
  array (
    'field' => 'value',
    'type' => 'text',
    'null' => 'NO',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'type' => 
  array (
    'field' => 'type',
    'type' => 'enum(\'站点配置\',\'高级配置\',\'上传配置\',\'会员配置\',\'邮箱配置\',\'安全配置\',\'水印配置\',\'内容相关\',\'性能优化\',\'伪静态\',\'COOKIE配置\',\'SESSION配置\',\'自定义\')',
    'null' => 'NO',
    'key' => false,
    'default' => '站点配置',
    'extra' => '',
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
  'show_type' => 
  array (
    'field' => 'show_type',
    'type' => 'enum(\'文本\',\'数字\',\'布尔(1/0)\',\'多行文本\')',
    'null' => 'YES',
    'key' => false,
    'default' => '文本',
    'extra' => '',
  ),
  'message' => 
  array (
    'field' => 'message',
    'type' => 'varchar(255)',
    'null' => 'YES',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'order_list' => 
  array (
    'field' => 'order_list',
    'type' => 'smallint(6) unsigned',
    'null' => 'YES',
    'key' => false,
    'default' => '100',
    'extra' => '',
  ),
);
?>