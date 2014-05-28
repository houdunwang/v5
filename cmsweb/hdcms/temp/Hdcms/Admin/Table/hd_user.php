<?php if(!defined('HDPHP_PATH'))exit;
return array (
  'uid' => 
  array (
    'field' => 'uid',
    'type' => 'int(10) unsigned',
    'null' => 'NO',
    'key' => true,
    'default' => NULL,
    'extra' => 'auto_increment',
  ),
  'nickname' => 
  array (
    'field' => 'nickname',
    'type' => 'char(30)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'username' => 
  array (
    'field' => 'username',
    'type' => 'char(30)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'password' => 
  array (
    'field' => 'password',
    'type' => 'char(40)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'code' => 
  array (
    'field' => 'code',
    'type' => 'char(30)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'email' => 
  array (
    'field' => 'email',
    'type' => 'char(30)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'validatecode' => 
  array (
    'field' => 'validatecode',
    'type' => 'char(50)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'regtime' => 
  array (
    'field' => 'regtime',
    'type' => 'int(11)',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'logintime' => 
  array (
    'field' => 'logintime',
    'type' => 'int(10) unsigned',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'regip' => 
  array (
    'field' => 'regip',
    'type' => 'char(255)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'lastip' => 
  array (
    'field' => 'lastip',
    'type' => 'char(15)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'user_state' => 
  array (
    'field' => 'user_state',
    'type' => 'tinyint(1)',
    'null' => 'NO',
    'key' => false,
    'default' => '1',
    'extra' => '',
  ),
  'lock_end_time' => 
  array (
    'field' => 'lock_end_time',
    'type' => 'int(10)',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'qq' => 
  array (
    'field' => 'qq',
    'type' => 'char(20)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'sex' => 
  array (
    'field' => 'sex',
    'type' => 'tinyint(1)',
    'null' => 'NO',
    'key' => false,
    'default' => '1',
    'extra' => '',
  ),
  'favicon' => 
  array (
    'field' => 'favicon',
    'type' => 'varchar(255)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'credits' => 
  array (
    'field' => 'credits',
    'type' => 'int(10) unsigned',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'rid' => 
  array (
    'field' => 'rid',
    'type' => 'smallint(5) unsigned',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'allow_user_set_credits' => 
  array (
    'field' => 'allow_user_set_credits',
    'type' => 'tinyint(1) unsigned',
    'null' => 'NO',
    'key' => false,
    'default' => '1',
    'extra' => '',
  ),
  'signature' => 
  array (
    'field' => 'signature',
    'type' => 'varchar(255)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'domain' => 
  array (
    'field' => 'domain',
    'type' => 'char(20)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'spec_num' => 
  array (
    'field' => 'spec_num',
    'type' => 'mediumint(9) unsigned',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'icon' => 
  array (
    'field' => 'icon',
    'type' => 'varchar(255)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
);
?>