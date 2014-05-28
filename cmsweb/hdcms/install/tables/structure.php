<?php if(!defined('HDPHP_PATH'))EXIT;
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."access`");
$db->exe("CREATE TABLE `".$db_prefix."access` (
  `rid` smallint(5) unsigned NOT NULL,
  `nid` smallint(5) unsigned NOT NULL,
  KEY `gid` (`rid`),
  KEY `nid` (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员权限分配表'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."category`");
$db->exe("CREATE TABLE `".$db_prefix."category` (
  `cid` mediumint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目ID',
  `pid` mediumint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `catname` char(30) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `catdir` varchar(255) DEFAULT NULL,
  `cat_keyworks` varchar(255) NOT NULL DEFAULT '' COMMENT '栏目关键字',
  `cat_description` varchar(255) NOT NULL DEFAULT '' COMMENT '栏目描述',
  `index_tpl` varchar(200) NOT NULL DEFAULT '' COMMENT '封面模板',
  `list_tpl` varchar(200) NOT NULL DEFAULT '' COMMENT '列表页模板',
  `arc_tpl` varchar(200) NOT NULL DEFAULT '' COMMENT '内容页模板',
  `cat_html_url` varchar(200) NOT NULL DEFAULT '' COMMENT '栏目页URL规则\n\n',
  `arc_html_url` varchar(200) NOT NULL DEFAULT '' COMMENT '内容页URL规则',
  `mid` smallint(6) NOT NULL DEFAULT '0' COMMENT '模型ID',
  `cattype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 栏目,2 封面,3 外部链接,4 单文章',
  `arc_url_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '文章访问方式 1 静态访问 2 动态访问',
  `cat_url_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '栏目访问方式 1 静态访问 2 动态访问',
  `cat_redirecturl` varchar(100) NOT NULL DEFAULT '' COMMENT '跳转url',
  `catorder` smallint(5) unsigned NOT NULL DEFAULT '100' COMMENT '栏目排序',
  `cat_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'channel标签调用时是否显示',
  `cat_seo_title` char(100) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `cat_seo_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `add_reward` smallint(5) NOT NULL DEFAULT '0' COMMENT '搞稿奖励',
  `show_credits` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '查看积分',
  `repeat_charge_day` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '重复收费天数',
  `allow_user_set_credits` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许会员投稿设置积分 1 允许 0 不允许',
  `member_send_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '会员投稿状态 1 审核 2 未审核',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='栏目表'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."category_access`");
$db->exe("CREATE TABLE `".$db_prefix."category_access` (
  `rid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `cid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目cid',
  `mid` smallint(1) NOT NULL DEFAULT '0' COMMENT '模型mid',
  `show` tinyint(1) NOT NULL DEFAULT '0' COMMENT '允许访问 1 允许 0 不允许',
  `add` tinyint(1) NOT NULL DEFAULT '0' COMMENT '允许投稿(添加) 1允许 0 不允许',
  `edit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '允许更新 1允许 0 不允许',
  `del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '允许删除 1允许 0 不允许',
  `order` tinyint(1) NOT NULL DEFAULT '0' COMMENT '允许排序 1允许 0 不允许',
  `move` tinyint(1) NOT NULL DEFAULT '0' COMMENT '允许移动 1允许 0 不允许',
  `audit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '允许审核栏目文章 1 允许 0 不允许',
  `admin` tinyint(1) NOT NULL COMMENT '是否为管理员权限 1 管理员 2 前台用户'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='栏目权限表'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."comment`");
$db->exe("CREATE TABLE `".$db_prefix."comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论mid',
  `mid` smallint(5) unsigned NOT NULL,
  `cid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目id\n1 基本配置\n2 ',
  `aid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文章aid',
  `content` text NOT NULL COMMENT '评论内容',
  `uid` int(11) NOT NULL COMMENT '用户名',
  `comment_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示 1 显示  0 不显示',
  `pubtime` int(11) NOT NULL DEFAULT '0' COMMENT '发表时间',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级id',
  `reply_comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复的最顶层评论comment_id',
  PRIMARY KEY (`comment_id`),
  KEY `reply_comment_id` (`reply_comment_id`),
  KEY `cid_aid_state` (`aid`,`cid`,`comment_state`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论表'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."config`");
$db->exe("CREATE TABLE `".$db_prefix."config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL DEFAULT '' COMMENT '配置名称\n',
  `value` text NOT NULL COMMENT '配置值',
  `type` enum('站点配置','高级配置','上传配置','会员配置','邮箱配置','安全配置','水印配置','内容相关','性能优化','伪静态','COOKIE配置','SESSION配置','自定义') NOT NULL DEFAULT '站点配置' COMMENT '配置类型\n1 站点配置\n2 性能设置\n3 上传配置\n4 交互设置\n5 会员设置',
  `title` char(30) NOT NULL DEFAULT '',
  `show_type` enum('文本','数字','布尔(1/0)','多行文本') DEFAULT '文本',
  `message` varchar(255) DEFAULT NULL COMMENT '提示',
  `order_list` smallint(6) unsigned DEFAULT '100' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COMMENT='系统配置'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."content`");
$db->exe("CREATE TABLE `".$db_prefix."content` (
  `aid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `cid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目cid',
  `title` char(100) NOT NULL DEFAULT '' COMMENT '标题',
  `flag` set('热门','置顶','推荐','图片','精华','幻灯片','站长推荐') DEFAULT NULL,
  `new_window` tinyint(1) NOT NULL DEFAULT '0' COMMENT '新窗口打开',
  `seo_title` char(100) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `click` int(6) NOT NULL DEFAULT '0' COMMENT '点击数',
  `source` char(60) NOT NULL DEFAULT '' COMMENT '来源',
  `redirecturl` varchar(255) NOT NULL DEFAULT '' COMMENT '转向链接',
  `html_path` varchar(255) NOT NULL DEFAULT '' COMMENT '自定义生成的静态文件地址',
  `allowreply` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许回复',
  `addtime` int(10) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updatetime` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `color` char(7) NOT NULL DEFAULT '' COMMENT '标题颜色',
  `template` varchar(255) NOT NULL DEFAULT '' COMMENT '模板',
  `url_type` tinyint(80) NOT NULL DEFAULT '3' COMMENT '文章访问方式  1 静态访问  2 动态访问  3 继承栏目',
  `arc_sort` mediumint(6) NOT NULL DEFAULT '0' COMMENT '排序',
  `content_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '文章状态  1 已审核 0 未审核',
  `keywords` varchar(100) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `uid` int(10) unsigned NOT NULL COMMENT '用户uid',
  `favorites` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '收藏数',
  `comment_num` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `tag` varchar(255) NOT NULL DEFAULT '' COMMENT '占位，不用的字段',
  `read_credits` smallint(6) NOT NULL DEFAULT '0' COMMENT '阅读金币',
  PRIMARY KEY (`aid`),
  KEY `uid` (`uid`),
  KEY `cid` (`cid`),
  KEY `flag` (`flag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章表'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."content_data`");
$db->exe("CREATE TABLE `".$db_prefix."content_data` (
  `aid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文章主表ID',
  `content` text COMMENT '内容',
  KEY `aid` (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章正文表'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."content_tag`");
$db->exe("CREATE TABLE `".$db_prefix."content_tag` (
  `mid` smallint(6) NOT NULL DEFAULT '0' COMMENT '模型cid',
  `cid` smallint(6) NOT NULL DEFAULT '0' COMMENT '栏目cid',
  `aid` int(11) NOT NULL DEFAULT '0' COMMENT '文章aid',
  `tid` int(11) NOT NULL DEFAULT '0' COMMENT '标签id',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户uid'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='内容标签表'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."custom_js`");
$db->exe("CREATE TABLE `".$db_prefix."custom_js` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(100) DEFAULT NULL COMMENT '标签名称',
  `description` varchar(255) DEFAULT NULL COMMENT 'js描述',
  `options` text COMMENT 'js属性设置',
  `name` varchar(100) DEFAULT NULL COMMENT 'JS名称',
  `addtime` int(10) DEFAULT NULL COMMENT '添加时间',
  `username` char(30) DEFAULT NULL COMMENT '添加者',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='自定义js'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."favorite`");
$db->exe("CREATE TABLE `".$db_prefix."favorite` (
  `fid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL,
  `cid` smallint(5) unsigned NOT NULL,
  `aid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='收藏夹'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."field`");
$db->exe("CREATE TABLE `".$db_prefix."field` (
  `fid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `field_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1 正常 0 禁用',
  `field_type` varchar(255) NOT NULL DEFAULT '' COMMENT '字段类型 text|textarea|radio|checkbox|image|images|datetime|',
  `table_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '字段所在表 1 主表 2 副表',
  `table_name` varchar(255) NOT NULL DEFAULT '' COMMENT '所在表名',
  `field_name` varchar(255) NOT NULL DEFAULT '' COMMENT '字段name名称',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '字段标题 ',
  `tips` varchar(255) NOT NULL DEFAULT '' COMMENT '字段提示',
  `enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 开启 0 关闭',
  `is_system` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为系统字段',
  `fieldsort` mediumint(9) NOT NULL DEFAULT '100' COMMENT '字段排序',
  `set` text COMMENT '字段设置',
  `css` varchar(255) NOT NULL DEFAULT '' COMMENT 'CSS样式',
  `minlength` char(255) NOT NULL DEFAULT '' COMMENT '最小字数',
  `maxlength` char(255) NOT NULL DEFAULT '' COMMENT '最大字数',
  `validate` char(255) NOT NULL DEFAULT '' COMMENT '正则验证',
  `required` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否必须输入',
  `error` varchar(255) NOT NULL DEFAULT '' COMMENT '错误提示',
  `isunique` tinyint(1) NOT NULL DEFAULT '0' COMMENT '值唯一',
  `isbase` tinyint(1) NOT NULL DEFAULT '1' COMMENT '作为基本信息',
  `issearch` tinyint(1) NOT NULL DEFAULT '1' COMMENT '作为搜索条件',
  `isadd` tinyint(1) NOT NULL DEFAULT '1' COMMENT '在前台投稿中显示',
  PRIMARY KEY (`fid`),
  KEY `mid` (`mid`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='模型字段'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."link`");
$db->exe("CREATE TABLE `".$db_prefix."link` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='友情链接'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."link_config`");
$db->exe("CREATE TABLE `".$db_prefix."link_config` (
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='本网站友情链接信息'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."link_type`");
$db->exe("CREATE TABLE `".$db_prefix."link_type` (
  `tid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` char(50) NOT NULL DEFAULT '' COMMENT '分类名称',
  `system` tinyint(1) NOT NULL DEFAULT '0' COMMENT '系统类型',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='友情链接分类'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."menu_favorite`");
$db->exe("CREATE TABLE `".$db_prefix."menu_favorite` (
  `uid` smallint(5) unsigned NOT NULL,
  `nid` smallint(5) unsigned NOT NULL,
  KEY `gid` (`uid`),
  KEY `nid` (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员权限分配表'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."model`");
$db->exe("CREATE TABLE `".$db_prefix."model` (
  `mid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `model_name` char(255) NOT NULL DEFAULT '' COMMENT '模型名称',
  `table_name` char(255) NOT NULL DEFAULT '' COMMENT '主表名',
  `enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '禁用 1 开启 0 关闭',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '模型描述',
  `is_system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 系统模型  2 普通模型',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='模型表'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."navigation`");
$db->exe("CREATE TABLE `".$db_prefix."navigation` (
  `nid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` char(30) NOT NULL DEFAULT '菜单名称' COMMENT '菜单名',
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `target` enum('_self','_blank') NOT NULL DEFAULT '_self' COMMENT '打开方式',
  `state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1 显示 0 不显示',
  `list_order` mediumint(100) NOT NULL DEFAULT '100' COMMENT '排序',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网站前台导航'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."node`");
$db->exe("CREATE TABLE `".$db_prefix."node` (
  `nid` smallint(6) NOT NULL AUTO_INCREMENT,
  `title` char(30) NOT NULL DEFAULT '' COMMENT '中文标题',
  `app_group` char(30) NOT NULL DEFAULT 'Hdcms' COMMENT '应用组',
  `app` char(30) NOT NULL DEFAULT '' COMMENT '应用',
  `control` char(30) NOT NULL DEFAULT '' COMMENT '控制器',
  `method` char(30) NOT NULL DEFAULT '' COMMENT '方法',
  `param` char(100) NOT NULL DEFAULT '' COMMENT '参数',
  `comment` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1 显示 0 不显示',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '类型 1 权限控制菜单   2 普通菜单 ',
  `pid` smallint(6) NOT NULL DEFAULT '0',
  `list_order` smallint(6) NOT NULL DEFAULT '100' COMMENT '排序',
  `is_system` tinyint(1) NOT NULL DEFAULT '0' COMMENT '系统菜单 1 是  0 不是',
  `favorite` tinyint(1) NOT NULL DEFAULT '0' COMMENT '后台常用菜单   1 是  0 不是',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM AUTO_INCREMENT=201 DEFAULT CHARSET=utf8 COMMENT='节点表（后台菜单也使用）'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."plugin`");
$db->exe("CREATE TABLE `".$db_prefix."plugin` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` char(50) NOT NULL DEFAULT '' COMMENT '插件名称',
  `install_time` date DEFAULT NULL COMMENT '安装时间',
  `version` varchar(100) NOT NULL DEFAULT '' COMMENT '版本号',
  `team` varchar(100) NOT NULL DEFAULT '' COMMENT '团队名称',
  `app` char(50) NOT NULL DEFAULT '' COMMENT '应用名',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `web` varchar(255) NOT NULL DEFAULT '' COMMENT '官方网址',
  `pubdate` date DEFAULT NULL COMMENT '发布时间',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='插件列表'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."role`");
$db->exe("CREATE TABLE `".$db_prefix."role` (
  `rid` smallint(5) NOT NULL AUTO_INCREMENT,
  `rname` char(60) NOT NULL DEFAULT '',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '描述',
  `admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '管理组 1 是 0 不是',
  `system` tinyint(1) NOT NULL DEFAULT '0' COMMENT '系统角色',
  `creditslower` mediumint(9) NOT NULL DEFAULT '0' COMMENT '积分<=时为此会员组',
  `comment_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '评论不需要审核  1 不需要  2 需要',
  `allowsendmessage` tinyint(1) NOT NULL DEFAULT '1' COMMENT '允许发短消息  1 允许  2 不允许',
  PRIMARY KEY (`rid`),
  KEY `gid` (`rid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='角色表'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."search`");
$db->exe("CREATE TABLE `".$db_prefix."search` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'mid',
  `word` char(100) NOT NULL DEFAULT '' COMMENT '搜索关键词',
  `total` mediumint(8) unsigned NOT NULL DEFAULT '1' COMMENT '搜索次数',
  PRIMARY KEY (`sid`),
  UNIQUE KEY `name` (`word`) USING BTREE,
  KEY `total` (`total`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='搜索结果表'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."session`");
$db->exe("CREATE TABLE `".$db_prefix."session` (
  `sessid` char(32) NOT NULL DEFAULT '',
  `data` text,
  `atime` int(10) NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`sessid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='session会话表'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."system_message`");
$db->exe("CREATE TABLE `".$db_prefix."system_message` (
  `mid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收信人',
  `message` varchar(200) NOT NULL DEFAULT '' COMMENT '消息内容',
  `state` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否阅读  1 已经阅读 0 未阅读',
  `sendtime` int(11) unsigned NOT NULL COMMENT '发送时间',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统消息表'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."tag`");
$db->exe("CREATE TABLE `".$db_prefix."tag` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(30) DEFAULT '' COMMENT 'tag字符',
  `total` mediumint(9) DEFAULT '1' COMMENT '次数',
  PRIMARY KEY (`tid`),
  UNIQUE KEY `name` (`tag`),
  KEY `total` (`total`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Tag标签表'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."template_tag`");
$db->exe("CREATE TABLE `".$db_prefix."template_tag` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` mediumint(8) unsigned DEFAULT NULL COMMENT '类型  1 arclist',
  `options` text COMMENT '标签属性',
  `name` varchar(100) DEFAULT NULL COMMENT '标签名称',
  `content` text COMMENT '标签内容',
  `addtime` int(10) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='后台管理员自定义模板标签'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."upload`");
$db->exe("CREATE TABLE `".$db_prefix."upload` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `name` varchar(255) DEFAULT '' COMMENT '原文件名',
  `filename` varchar(100) NOT NULL DEFAULT '' COMMENT '文件名',
  `basename` varchar(100) NOT NULL DEFAULT '' COMMENT '有扩展名的文件名',
  `path` char(200) NOT NULL DEFAULT '' COMMENT '文件路径 ',
  `ext` varchar(45) NOT NULL DEFAULT '' COMMENT '扩展名',
  `image` tinyint(1) NOT NULL DEFAULT '1' COMMENT '图片',
  `size` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `uptime` int(10) NOT NULL DEFAULT '0' COMMENT '上传时间',
  `state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否使用 1 使用 0 未使用',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户uid',
  `mid` smallint(6) NOT NULL DEFAULT '0' COMMENT '模型mid',
  PRIMARY KEY (`id`),
  KEY `basename` (`basename`),
  KEY `id` (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='上传文件'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."user`");
$db->exe("CREATE TABLE `".$db_prefix."user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` char(30) NOT NULL DEFAULT '' COMMENT '昵称',
  `username` char(30) NOT NULL DEFAULT '',
  `password` char(40) NOT NULL DEFAULT '',
  `code` char(30) NOT NULL DEFAULT '' COMMENT '密码key',
  `email` char(30) NOT NULL DEFAULT '' COMMENT '邮箱',
  `validatecode` char(50) NOT NULL DEFAULT '' COMMENT '邮箱验证key',
  `regtime` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `logintime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  `regip` char(255) NOT NULL DEFAULT '' COMMENT '注册IP',
  `lastip` char(15) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `user_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1  正常  0 锁定',
  `lock_end_time` int(10) NOT NULL DEFAULT '0' COMMENT '锁定到期时间',
  `qq` char(20) NOT NULL DEFAULT '' COMMENT 'qq号码',
  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 男 2 女 3 保密',
  `favicon` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `credits` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `rid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `allow_user_set_credits` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '允许前台会员设置投稿积分',
  `signature` varchar(255) NOT NULL DEFAULT '' COMMENT '个性签名',
  `domain` char(20) NOT NULL DEFAULT '' COMMENT '个性域名',
  `spec_num` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '空间访问数',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `nickname` (`nickname`),
  UNIQUE KEY `domain` (`domain`),
  KEY `password` (`password`),
  KEY `credits` (`credits`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='会员表'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."user_deny_ip`");
$db->exe("CREATE TABLE `".$db_prefix."user_deny_ip` (
  `ip` char(15) NOT NULL DEFAULT '' COMMENT '拒绝访问ip',
  UNIQUE KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='拒绝访问ip'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."user_dynamic`");
$db->exe("CREATE TABLE `".$db_prefix."user_dynamic` (
  `did` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户uid',
  `content` text NOT NULL COMMENT '内容',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`did`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员动态'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."user_follow`");
$db->exe("CREATE TABLE `".$db_prefix."user_follow` (
  `uid` int(11) unsigned NOT NULL COMMENT '用户uid',
  `fans_uid` int(11) unsigned DEFAULT NULL COMMENT '粉丝uid'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员关注表'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."user_guest`");
$db->exe("CREATE TABLE `".$db_prefix."user_guest` (
  `gid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `guest_uid` int(11) unsigned NOT NULL COMMENT '访问id',
  `uid` int(11) unsigned NOT NULL COMMENT '被访问空间Uid',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='空间访客表'");
$db->exe("DROP TABLE IF EXISTS `".$db_prefix."user_message`");
$db->exe("CREATE TABLE `".$db_prefix."user_message` (
  `mid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from_uid` int(10) unsigned NOT NULL,
  `to_uid` int(10) unsigned NOT NULL,
  `content` varchar(255) NOT NULL DEFAULT '',
  `user_message_state` tinyint(1) NOT NULL COMMENT '是否查阅  1 已阅读  2 未读',
  `sendtime` int(10) NOT NULL COMMENT '发送时间',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='短消息'");
