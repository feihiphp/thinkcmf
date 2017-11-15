
CREATE TABLE `cmf_dramas` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(125) NOT NULL COMMENT '标题',
  `english_title` varchar(125) NOT NULL COMMENT '英文标题',
  `director` char(15)  NOT NULL  COMMENT '导演',
  `screenwriter` varchar(125)  NOT NULL  COMMENT '编剧',
  `performer` varchar(256)  NOT NULL  COMMENT '演员',

  `air_time` datetime  NOT NULL  COMMENT '开播时间',
  `dramas_introduuction` text  NOT NULL  COMMENT '剧集介绍',
  `dramas_state` tinyint(1)  NOT NULL  COMMENT '剧集状态 0 停播 1在播 2季终',
  `gmt_create` datetime NOT NULL COMMENT '添加时间',
  `gmt_modified` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `dramas_state` (`dramas_state`),
  KEY `title`(`title`),
  KEY `engine_title` (`english_title`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='剧集表';


CREATE TABLE `cmf_seed` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `dramas_id` bigint(10) unsigned NOT NULL  COMMENT '所属剧集',
  `title` varchar(125) NOT NULL COMMENT '标题',
  `bt_url` varchar(256)  NOT NULL  COMMENT 'bt地址',
  `mangnet_url` varchar(256)  NOT NULL  COMMENT '磁力地址',
  `baiduyun_url` varchar(256)  NOT NULL  COMMENT '百度网盘地址',
  `baiduyun_password` varchar(256)  NOT NULL  COMMENT '百度网盘密码',
  `otheryun_url` varchar(256)  NOT NULL  COMMENT '其他网盘',
  `weiyun_url` varchar(256)  NOT NULL  COMMENT '微云地址',
  `ed2k` varchar(256)  NOT NULL  COMMENT 'ed2k',
  `play_url` varchar(256)  NOT NULL  COMMENT '在线播放地址',
  `subtitles_type` char(8)  NOT NULL  COMMENT '字幕类型：中文字幕 英文字幕 中英双语',
  `subtitles_url` varchar(256)  NOT NULL  COMMENT '字幕地址',
  `size_num` int(10) NOT NULL COMMENT '文件大小',
  `size_type` char(1) NOT NULL COMMENT '文件大小单位:M、G',
   `gmt_create` datetime NOT NULL COMMENT '添加时间',
  `gmt_modified` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `title`(`title`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='种子表';