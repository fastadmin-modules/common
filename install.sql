CREATE TABLE IF NOT EXISTS `__PREFIX__common_slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '标题',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `link` varchar(100) NOT NULL DEFAULT '' COMMENT '链接',
  `status` enum('1','2') NOT NULL DEFAULT '1' COMMENT '状态:1=显示,2=隐藏',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `update_time` int(10) NOT NULL COMMENT '修改时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `__PREFIX__common_slide` (`title`, `image`, `link`, `status`, `weigh`, `create_time`, `update_time`, `delete_time`) VALUES ('轮播图1', '', '', '1', 1, 1635238671, 1655432004, NULL);
