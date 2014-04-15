<?php if(!defined('HDPHP_PATH'))EXIT;
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."admin`");
$db->exe("CREATE TABLE `".$db_prefix."admin` (
  `aid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(30) DEFAULT NULL COMMENT '管理员帐号',
  `password` char(32) DEFAULT NULL COMMENT '密码',
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."article`");
$db->exe("CREATE TABLE `".$db_prefix."article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `catid` smallint(5) unsigned DEFAULT NULL COMMENT '文章所属栏目cid',
  `title` char(100) DEFAULT NULL COMMENT '标题',
  `keywords` varchar(80) DEFAULT NULL COMMENT '关键字',
  `description` varchar(255) DEFAULT NULL COMMENT '摘要',
  `content` text COMMENT '正文',
  `click` int(10) unsigned DEFAULT NULL COMMENT '查看次数',
  `thumb` varchar(255) DEFAULT '' COMMENT '缩略图',
  `admin_id` mediumint(8) unsigned DEFAULT NULL COMMENT '发布才（管理员)id',
  `source` char(60) DEFAULT NULL COMMENT '来源',
  `author` char(30) DEFAULT NULL COMMENT '作者',
  `addtime` int(10) DEFAULT NULL COMMENT '发表时间',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."category`");
$db->exe("CREATE TABLE `".$db_prefix."category` (
  `cid` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目id',
  `cname` char(30) DEFAULT NULL COMMENT '栏目名称',
  `pid` smallint(6) DEFAULT NULL COMMENT '父级栏目id',
  `keywords` varchar(80) DEFAULT NULL COMMENT '关键字',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."config`");
$db->exe("CREATE TABLE `".$db_prefix."config` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `name` char(30) NOT NULL DEFAULT '',
  `value` char(100) NOT NULL DEFAULT '',
  `show_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 文本框    2  单选框',
  `message` varchar(255) NOT NULL DEFAULT '',
  `option` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8");
