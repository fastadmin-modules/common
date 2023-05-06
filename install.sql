-- ----------------------------
-- 公共管理 - 文章
-- ----------------------------
CREATE TABLE `fzw_common_article`
(
    `id`           int(11) NOT NULL AUTO_INCREMENT,
    `name`         varchar(100) NOT NULL DEFAULT '' COMMENT '变量名',
    `title`        varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
    `author`       varchar(100) NOT NULL DEFAULT '' COMMENT '作者',
    `desc`         varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
    `content`      text         NOT NULL COMMENT '内容',
    `publish_time` int(10) NOT NULL COMMENT '发布时间',
    `create_time`  int(10) NOT NULL COMMENT '创建时间',
    `update_time`  int(10) NOT NULL COMMENT '修改时间',
    `delete_time`  int(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='公共管理 - 文章表';

INSERT INTO `fzw_common_article` (`name`, `title`, `author`, `desc`, `content`, `publish_time`, `create_time`, `update_time`, `delete_time`)
VALUES ( 'about', '关于我们', '作者', '关于我们', '关于我们的内容', 1626260641, 1626260641, 1640594395, NULL);

-- ----------------------------
-- 公共管理 - 意见反馈
-- ----------------------------
CREATE TABLE `fzw_common_opinion`
(
    `id`          int(11) NOT NULL AUTO_INCREMENT,
    `user_id`     int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
    `images`      varchar(1000) NOT NULL DEFAULT '' COMMENT '图片',
    `content`     varchar(300)  NOT NULL DEFAULT '' COMMENT '内容',
    `create_time` int(10) NOT NULL COMMENT '创建时间',
    `update_time` int(10) NOT NULL COMMENT '修改时间',
    `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='公共管理 - 意见反馈';

INSERT INTO `fzw_common_opinion` ( `user_id`, `images`, `content`, `create_time`, `update_time`, `delete_time`)
VALUES (1,'https://fenzhouwang2021.oss-cn-shanghai.aliyuncs.com//uploads/20220109/ff60f103809a266bb437b24841ff8f0e.jpg', '碎了一个，怎么处理', 1641721987, 1649404039, 1649404039);


-- ----------------------------
-- Table structure for fzw_common_problem
-- ----------------------------
DROP TABLE IF EXISTS `fzw_common_problem`;
CREATE TABLE `fzw_common_problem`
(
    `id`          int(11) NOT NULL AUTO_INCREMENT,
    `title`       varchar(255) NOT NULL DEFAULT '' COMMENT '问题名称',
    `description` text         NOT NULL COMMENT '问题内容',
    `create_time` int(11) NOT NULL COMMENT '添加时间',
    `update_time` int(11) NOT NULL COMMENT '修改时间',
    `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='公共管理 - 常见问题';

INSERT INTO `fzw_common_problem` (`title`, `description`, `create_time`, `update_time`, `delete_time`)
VALUES ('地图定位不准', '<p>你好，打开小程序点击右上角【...】-【重新进入小程序】即可定位到您所在的正确位置。</p>', 1640592856,  1640592856, NULL);

-- ----------------------------
-- 公共管理 - 轮播图管理
-- ----------------------------
DROP TABLE IF EXISTS `fzw_common_slide`;
CREATE TABLE `fzw_common_slide`
(
    `id`          int(11) NOT NULL AUTO_INCREMENT,
    `title`       varchar(30)  NOT NULL DEFAULT '' COMMENT '标题',
    `image`       varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
    `link`        varchar(100) NOT NULL DEFAULT '' COMMENT '链接',
    `status`      enum('1','2') NOT NULL DEFAULT '1' COMMENT '状态:1=显示,2=隐藏',
    `weigh`       int(10) NOT NULL DEFAULT '0' COMMENT '排序',
    `create_time` int(10) NOT NULL COMMENT '创建时间',
    `update_time` int(10) NOT NULL COMMENT '修改时间',
    `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='公共管理 - 轮播图管理';

INSERT INTO `fzw_common_slide` (`title`, `image`, `link`, `status`, `weigh`, `create_time`, `update_time`,  `delete_time`)
VALUES ('轮播图2','https://fenzhouwang.oss-cn-hangzhou.aliyuncs.com/uploads/20211229/6f247f85d5eb2bf215ed1675975ecc18.png', '', '1', 2, 1640770893, 1640770924, 1640770924);


-- ----------------------------
-- 公共管理 - 视频管理
-- ----------------------------
DROP TABLE IF EXISTS `fzw_common_video`;
CREATE TABLE `fzw_common_video`
(
    `id`          int(11) NOT NULL AUTO_INCREMENT,
    `title`       varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
    `image`       varchar(255) NOT NULL DEFAULT '' COMMENT '封面图',
    `type`        tinyint(4) NOT NULL DEFAULT '1' COMMENT '地址类型：1=url 2=本地上传 3=云文件',
    `url`         varchar(255) NOT NULL DEFAULT '' COMMENT '网络地址',
    `view_num`    int(11) NOT NULL COMMENT '观看次数',
    `intro`       varchar(255) NOT NULL DEFAULT '' COMMENT '介绍',
    `desc`        text         NOT NULL COMMENT '视频详细介绍',
    `status`      tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1=显示 0=隐藏',
    `file_name`   varchar(255) NOT NULL DEFAULT '' COMMENT '视频上传名',
    `file_size`   varchar(255) NOT NULL DEFAULT '' COMMENT '视频上传大小',
    `creator_id`  int(11) NOT NULL DEFAULT '0' COMMENT '创建者ID',
    `create_time` int(11) NOT NULL COMMENT '添加时间',
    `update_time` int(11) NOT NULL COMMENT '修改时间',
    `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
    `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类ID',
    PRIMARY KEY (`id`),
    KEY           `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='公共管理 - 视频管理';

INSERT INTO `fzw_common_video` (`title`, `image`, `type`, `url`, `view_num`, `intro`, `desc`, `status`,`file_name`, `file_size`, `creator_id`, `create_time`, `update_time`, `delete_time`, `category_id`)
VALUES ('汾州王酒定乾坤', '/uploads/20211208/499d3b4748a9d662480710d7360f38ad.jpg', 2, '/uploads/20220224/6e9076279e61ceea9d6260d321679135.mp4', 628, '', '', 1, '', '', 0, 1645671595, 1645672617,  NULL, 1);

-- ----------------------------
-- 公共管理 - 视频分类表
-- ----------------------------
DROP TABLE IF EXISTS `fzw_common_video_category`;
CREATE TABLE `fzw_common_video_category`
(
    `id`          int(11) NOT NULL AUTO_INCREMENT,
    `name`        varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
    `pid`         int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
    `desc`        text         NOT NULL COMMENT '介绍',
    `status`      tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1=显示 0=隐藏',
    `create_time` int(11) NOT NULL COMMENT '添加时间',
    `update_time` int(11) NOT NULL COMMENT '修改时间',
    `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='公共管理 - 视频分类表';

BEGIN;
INSERT INTO `fzw_common_video_category` (`name`, `pid`, `desc`, `status`, `create_time`, `update_time`, `delete_time`)
VALUES ('分类标题', 0, '分类介绍', 1, 1645670602, 1646017039, NULL);

