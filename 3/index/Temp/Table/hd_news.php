<?php if(!defined('HDPHP_PATH'))exit;
return array (
  'id' => 
  array (
    'field' => 'id',
    'type' => 'int(11)',
    'null' => 'NO',
    'key' => true,
    'default' => NULL,
    'extra' => 'auto_increment',
  ),
  'title' => 
  array (
    'field' => 'title',
    'type' => 'char(100)',
    'null' => 'YES',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'content' => 
  array (
    'field' => 'content',
    'type' => 'text',
    'null' => 'YES',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
);
?>