DROP TABLE IF EXISTS `hd_link`;
CREATE TABLE `hd_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `webname` char(100) NOT NULL DEFAULT '' COMMENT '网站名称',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '网址',
  `logo` varchar(255) NOT NULL DEFAULT '' COMMENT '网站logo',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱',
  `tid` tinyint(1) NOT NULL DEFAULT '2' COMMENT '友情链接类型',
  `qq` char(15) NOT NULL DEFAULT '' COMMENT '站长qq',
  `comment` text NOT NULL COMMENT '网站介绍',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 ',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='友情链接';

DROP TABLE IF EXISTS `hd_link_config`;
CREATE TABLE `hd_link_config` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `webname` char(100) NOT NULL DEFAULT '' COMMENT '网站名称',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '网址',
  `logo` varchar(255) NOT NULL DEFAULT '' COMMENT 'logo',
  `email` varchar(255) NOT NULL COMMENT '站长邮箱',
  `comment` text NOT NULL COMMENT '申请说明',
  `allow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '开放申请',
  `code` tinyint(1) NOT NULL DEFAULT '1' COMMENT '显示验证码',
  `qq` char(15) NOT NULL DEFAULT '' COMMENT '联系QQ',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='本网站友情链接信息';
INSERT INTO `hd_link_config` VALUES ('1', '后盾网', 'http://localhost/hdcms', 'hd/Plugin/Link/Data/logo.png', 'houdunwang@gmail.com', '1、请先在贵站做好后盾网的友情链接\r\n2、将右侧‘文字链接’或‘图片链接’代码复制到贵站\r\n3、凡开通我站友情链接且内容健康的网站，经管理员审核后，将显示在此友情链接页面\r\n4、首页友情连接，要求pr>=2、alexa < 10000；其他页面连接根据具体页面而定（请具体咨询）\r\n5、贵网站要在百度google都有记录收录，且网站访问速度不能太慢', '1', '1', '2300071698');

DROP TABLE IF EXISTS `hd_link_type`;
CREATE TABLE `hd_link_type` (
  `tid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` char(50) NOT NULL DEFAULT '' COMMENT '分类名称',
  `system` tinyint(1) NOT NULL DEFAULT '0' COMMENT '系统类型',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='友情链接分类';
INSERT INTO `hd_link_type` VALUES ('1', '友情链接', '1'), ('2', '合作伙伴', '1');

