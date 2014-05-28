<?php if(!defined('HDPHP_PATH'))exit;
return array (
  'rid' => 
  array (
    'field' => 'rid',
    'type' => 'smallint(5)',
    'null' => 'NO',
    'key' => true,
    'default' => NULL,
    'extra' => 'auto_increment',
  ),
  'rname' => 
  array (
    'field' => 'rname',
    'type' => 'char(60)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'title' => 
  array (
    'field' => 'title',
    'type' => 'varchar(100)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'admin' => 
  array (
    'field' => 'admin',
    'type' => 'tinyint(1)',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
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
  'creditslower' => 
  array (
    'field' => 'creditslower',
    'type' => 'mediumint(9)',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'comment_state' => 
  array (
    'field' => 'comment_state',
    'type' => 'tinyint(1)',
    'null' => 'NO',
    'key' => false,
    'default' => '1',
    'extra' => '',
  ),
  'allowsendmessage' => 
  array (
    'field' => 'allowsendmessage',
    'type' => 'tinyint(1)',
    'null' => 'NO',
    'key' => false,
    'default' => '1',
    'extra' => '',
  ),
);
?>