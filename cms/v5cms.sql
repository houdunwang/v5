/*
Navicat MySQL Data Transfer

Source Server         : wamp
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : v5cms

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2014-03-07 23:32:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for v5_admin
-- ----------------------------
DROP TABLE IF EXISTS `v5_admin`;
CREATE TABLE `v5_admin` (
  `aid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(30) DEFAULT NULL COMMENT '管理员帐号',
  `password` char(32) DEFAULT NULL COMMENT '密码',
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of v5_admin
-- ----------------------------
INSERT INTO `v5_admin` VALUES ('1', 'admin', '7fef6171469e80d32c0559f88b377245');

-- ----------------------------
-- Table structure for v5_article
-- ----------------------------
DROP TABLE IF EXISTS `v5_article`;
CREATE TABLE `v5_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `catid` smallint(5) unsigned DEFAULT NULL COMMENT '文章所属栏目cid',
  `keywords` varchar(80) DEFAULT NULL COMMENT '关键字',
  `description` varchar(255) DEFAULT NULL COMMENT '摘要',
  `content` text COMMENT '正文',
  `click` int(10) unsigned DEFAULT NULL COMMENT '查看次数',
  `thumb` varchar(255) DEFAULT NULL COMMENT '缩略图',
  `admin_id` mediumint(8) unsigned DEFAULT NULL COMMENT '发布才（管理员)id',
  `source` char(60) DEFAULT NULL COMMENT '来源',
  `author` char(30) DEFAULT NULL COMMENT '作者',
  `addtime` int(10) DEFAULT NULL COMMENT '发表时间',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',
  `title` char(100) DEFAULT NULL COMMENT '标题',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of v5_article
-- ----------------------------
INSERT INTO `v5_article` VALUES ('1', '1', '', '', '<p>吐出了大多数人的心声</p><p>来听听后盾毕业学员对后盾网的真实评价!!!</p><p>来听听后盾毕业学员对后盾网的真实评价!!!</p><p>来听听后盾毕业学员对后盾网的真实评价!!!</p>', '100', 'upload/article/2014/02/28/95851393592559.jpg', '1', '后盾网', 'admin', '1392991549', '1970', '来听听后盾毕业学员对后盾网的真实评价!!!123');
INSERT INTO `v5_article` VALUES ('2', '1', '', '', '<p>这么猛的一个料，必须沙发！</p>', '100', 'upload/article/2014/02/21/21641392991699.jpg', '1', '后盾网', 'admin', '1392991699', '2014', '后盾网中秋香山登高活动视频曝光啦');
INSERT INTO `v5_article` VALUES ('3', '1', '', '', '<p>从头看到尾，就是没看见老孙呀</p>', '100', 'upload/article/2014/02/21/7251392992199.jpg', '1', '后盾网', 'admin', '1392992199', '2014', '从头看到尾，就是没看见老孙呀');
INSERT INTO `v5_article` VALUES ('4', '2', '', '', '<p>今天学习PHP的OOP思想</p>', '100', null, '1', '后盾网', 'admin', '1393590148', '2014', '今天学习PHP的OOP思想');
INSERT INTO `v5_article` VALUES ('8', '1', '', '', '<p>这么猛的一个料，必须沙发！</p>', '100', null, '1', '后盾网', 'admin', '1393591806', '1393591806', '后盾网中秋香山登高活动视频曝光啦');

-- ----------------------------
-- Table structure for v5_category
-- ----------------------------
DROP TABLE IF EXISTS `v5_category`;
CREATE TABLE `v5_category` (
  `cid` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目id',
  `cname` char(30) DEFAULT NULL COMMENT '栏目名称',
  `pid` smallint(6) DEFAULT NULL COMMENT '父级栏目id',
  `keywords` varchar(80) DEFAULT NULL COMMENT '关键字',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of v5_category
-- ----------------------------
INSERT INTO `v5_category` VALUES ('1', 'V5课堂', '0', 'php', 'php');
INSERT INTO `v5_category` VALUES ('2', 'PHP学习', '0', 'PHP学习', 'PHP学习');

-- ----------------------------
-- Table structure for v5_config
-- ----------------------------
DROP TABLE IF EXISTS `v5_config`;
CREATE TABLE `v5_config` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `name` char(30) NOT NULL DEFAULT '',
  `value` char(100) NOT NULL DEFAULT '',
  `show_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 文本框    2  单选框',
  `message` varchar(255) NOT NULL DEFAULT '',
  `option` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of v5_config
-- ----------------------------
INSERT INTO `v5_config` VALUES ('1', '网站名称', 'webname', '后盾网V5课堂-每周五晚7：30与你在一起', '1', '网站名称', '');
INSERT INTO `v5_config` VALUES ('2', 'ICP', 'icp', '京ICP备12048441号-3', '1', 'ICP', '');
INSERT INTO `v5_config` VALUES ('3', 'QQ', 'qq', '1455067020', '1', 'QQ', '');
INSERT INTO `v5_config` VALUES ('4', '站长邮箱', 'email', 'houdunwangxj@gmail.com', '1', '站长邮箱', '');
INSERT INTO `v5_config` VALUES ('5', '网站开头', 'web_status', '1', '2', '网站开头', '1|开启,0|关闭');
INSERT INTO `v5_config` VALUES ('6', '网站关闭提示', 'close_message', '网站升级中...，请1小时后访问，感谢您的支持，你的支持是我们前进的动力！！！！', '3', '网站关闭提示', '');
