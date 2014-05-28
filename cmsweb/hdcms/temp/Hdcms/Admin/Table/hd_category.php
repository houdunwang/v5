<?php if(!defined('HDPHP_PATH'))exit;
return array (
  'cid' => 
  array (
    'field' => 'cid',
    'type' => 'mediumint(5) unsigned',
    'null' => 'NO',
    'key' => true,
    'default' => NULL,
    'extra' => 'auto_increment',
  ),
  'pid' => 
  array (
    'field' => 'pid',
    'type' => 'mediumint(5) unsigned',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'catname' => 
  array (
    'field' => 'catname',
    'type' => 'char(30)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'catdir' => 
  array (
    'field' => 'catdir',
    'type' => 'varchar(255)',
    'null' => 'YES',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'cat_keyworks' => 
  array (
    'field' => 'cat_keyworks',
    'type' => 'varchar(255)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'cat_description' => 
  array (
    'field' => 'cat_description',
    'type' => 'varchar(255)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'index_tpl' => 
  array (
    'field' => 'index_tpl',
    'type' => 'varchar(200)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'list_tpl' => 
  array (
    'field' => 'list_tpl',
    'type' => 'varchar(200)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'arc_tpl' => 
  array (
    'field' => 'arc_tpl',
    'type' => 'varchar(200)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'cat_html_url' => 
  array (
    'field' => 'cat_html_url',
    'type' => 'varchar(200)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'arc_html_url' => 
  array (
    'field' => 'arc_html_url',
    'type' => 'varchar(200)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'mid' => 
  array (
    'field' => 'mid',
    'type' => 'smallint(6)',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'cattype' => 
  array (
    'field' => 'cattype',
    'type' => 'tinyint(1)',
    'null' => 'NO',
    'key' => false,
    'default' => '1',
    'extra' => '',
  ),
  'arc_url_type' => 
  array (
    'field' => 'arc_url_type',
    'type' => 'tinyint(1)',
    'null' => 'NO',
    'key' => false,
    'default' => '1',
    'extra' => '',
  ),
  'cat_url_type' => 
  array (
    'field' => 'cat_url_type',
    'type' => 'tinyint(1)',
    'null' => 'NO',
    'key' => false,
    'default' => '1',
    'extra' => '',
  ),
  'cat_redirecturl' => 
  array (
    'field' => 'cat_redirecturl',
    'type' => 'varchar(100)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'catorder' => 
  array (
    'field' => 'catorder',
    'type' => 'smallint(5) unsigned',
    'null' => 'NO',
    'key' => false,
    'default' => '100',
    'extra' => '',
  ),
  'cat_show' => 
  array (
    'field' => 'cat_show',
    'type' => 'tinyint(1)',
    'null' => 'NO',
    'key' => false,
    'default' => '1',
    'extra' => '',
  ),
  'cat_seo_title' => 
  array (
    'field' => 'cat_seo_title',
    'type' => 'char(100)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'cat_seo_description' => 
  array (
    'field' => 'cat_seo_description',
    'type' => 'varchar(255)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'add_reward' => 
  array (
    'field' => 'add_reward',
    'type' => 'smallint(5)',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'show_credits' => 
  array (
    'field' => 'show_credits',
    'type' => 'smallint(5) unsigned',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'repeat_charge_day' => 
  array (
    'field' => 'repeat_charge_day',
    'type' => 'smallint(5) unsigned',
    'null' => 'NO',
    'key' => false,
    'default' => '1',
    'extra' => '',
  ),
  'allow_user_set_credits' => 
  array (
    'field' => 'allow_user_set_credits',
    'type' => 'tinyint(1)',
    'null' => 'NO',
    'key' => false,
    'default' => '1',
    'extra' => '',
  ),
  'member_send_state' => 
  array (
    'field' => 'member_send_state',
    'type' => 'tinyint(1)',
    'null' => 'NO',
    'key' => false,
    'default' => '1',
    'extra' => '',
  ),
);
?>