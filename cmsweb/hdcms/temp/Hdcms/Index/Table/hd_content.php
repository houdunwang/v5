<?php if(!defined('HDPHP_PATH'))exit;
return array (
  'aid' => 
  array (
    'field' => 'aid',
    'type' => 'int(10) unsigned',
    'null' => 'NO',
    'key' => true,
    'default' => NULL,
    'extra' => 'auto_increment',
  ),
  'cid' => 
  array (
    'field' => 'cid',
    'type' => 'smallint(5) unsigned',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'title' => 
  array (
    'field' => 'title',
    'type' => 'char(100)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'flag' => 
  array (
    'field' => 'flag',
    'type' => 'set(\'热门\',\'置顶\',\'推荐\',\'图片\',\'精华\',\'幻灯片\',\'站长推荐\')',
    'null' => 'YES',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'new_window' => 
  array (
    'field' => 'new_window',
    'type' => 'tinyint(1)',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'seo_title' => 
  array (
    'field' => 'seo_title',
    'type' => 'char(100)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'thumb' => 
  array (
    'field' => 'thumb',
    'type' => 'varchar(255)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'click' => 
  array (
    'field' => 'click',
    'type' => 'int(6)',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'source' => 
  array (
    'field' => 'source',
    'type' => 'char(60)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'redirecturl' => 
  array (
    'field' => 'redirecturl',
    'type' => 'varchar(255)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'html_path' => 
  array (
    'field' => 'html_path',
    'type' => 'varchar(255)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'allowreply' => 
  array (
    'field' => 'allowreply',
    'type' => 'tinyint(1)',
    'null' => 'NO',
    'key' => false,
    'default' => '1',
    'extra' => '',
  ),
  'addtime' => 
  array (
    'field' => 'addtime',
    'type' => 'int(10)',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'updatetime' => 
  array (
    'field' => 'updatetime',
    'type' => 'int(10)',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'color' => 
  array (
    'field' => 'color',
    'type' => 'char(7)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'template' => 
  array (
    'field' => 'template',
    'type' => 'varchar(255)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'url_type' => 
  array (
    'field' => 'url_type',
    'type' => 'tinyint(80)',
    'null' => 'NO',
    'key' => false,
    'default' => '3',
    'extra' => '',
  ),
  'arc_sort' => 
  array (
    'field' => 'arc_sort',
    'type' => 'mediumint(6)',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'content_state' => 
  array (
    'field' => 'content_state',
    'type' => 'tinyint(1)',
    'null' => 'NO',
    'key' => false,
    'default' => '1',
    'extra' => '',
  ),
  'keywords' => 
  array (
    'field' => 'keywords',
    'type' => 'varchar(100)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'description' => 
  array (
    'field' => 'description',
    'type' => 'varchar(255)',
    'null' => 'YES',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'uid' => 
  array (
    'field' => 'uid',
    'type' => 'int(10) unsigned',
    'null' => 'NO',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'favorites' => 
  array (
    'field' => 'favorites',
    'type' => 'mediumint(8) unsigned',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'comment_num' => 
  array (
    'field' => 'comment_num',
    'type' => 'mediumint(8) unsigned',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'tag' => 
  array (
    'field' => 'tag',
    'type' => 'varchar(255)',
    'null' => 'NO',
    'key' => false,
    'default' => '',
    'extra' => '',
  ),
  'read_credits' => 
  array (
    'field' => 'read_credits',
    'type' => 'smallint(6)',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
);
?>