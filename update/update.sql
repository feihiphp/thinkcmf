
CREATE TABLE `cmf_portal_dramas` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(125) NOT NULL COMMENT '标题',
  `english_title` varchar(125) NOT NULL COMMENT '英文标题',
  `category` char(6) NOT NULL COMMENT '美剧分类。例如科幻类',
  `director` char(15)  NOT NULL  COMMENT '导演',
  `screenwriter` varchar(125)  NOT NULL  COMMENT '编剧',
  `performer` varchar(256)  NOT NULL  COMMENT '演员',

  `air_time` datetime  NOT NULL  COMMENT '开播时间',
  `dramas_introduction` text  NOT NULL  COMMENT '剧集介绍',
  `dramas_state` tinyint(1)  NOT NULL  COMMENT '剧集状态 0 停播 1在播 2季终',
  `cover` VARCHAR(125) NOT NULL  COMMENT '封面',


  `user_id` bigint (10) unsigned  NOT NULL  COMMENT '添加人的id',

  `status` tinyint(1) NOT NULL  COMMENT  '状态 1为正常 0为删除',
  `gmt_create` datetime NOT NULL COMMENT '添加时间',
  `gmt_modified` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `dramas_state` (`dramas_state`),
  KEY `title`(`title`),
  KEY `engine_title` (`english_title`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='剧集表';


CREATE TABLE `cmf_portal_seed` (
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
  `file_size` int(10) NOT NULL COMMENT '文件大小',
  `down_num` int(10) NOT NULL COMMENT '下载量',
  `season` int(10) NOT NULL COMMENT '季数',
  `episode` int(10) NOT NULL COMMENT '集数',
  `user_id` bigint (10) unsigned  NOT NULL  COMMENT '添加人的id',
  `status` tinyint(1) NOT NULL  COMMENT  '状态 1为正常 0为删除',
   `gmt_create` datetime NOT NULL COMMENT '添加时间',
  `gmt_modified` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `title`(`title`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='种子表';