DROP TABLE IF EXISTS `hd_mood`;
CREATE TABLE `hd_mood` (
  `aid` int(11) unsigned NOT NULL COMMENT '文章id',
  `mid` int(11) unsigned NOT NULL COMMENT '模型mid',
  `mood_id` tinyint(4) NOT NULL COMMENT '顶或踩      1 顶    2 踩  ',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '会员id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;