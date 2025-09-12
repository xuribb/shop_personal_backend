-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        8.0.31 - MySQL Community Server - GPL
-- 服务器操作系统:                      Win64
-- HeidiSQL 版本:                  12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- 导出  表 shop_personal.article 结构
DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `pid` int unsigned DEFAULT NULL COMMENT '父id：null没有父级',
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT '文章名称',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_article_article` (`pid`),
  CONSTRAINT `FK_article_article` FOREIGN KEY (`pid`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='文章列表';

-- 正在导出表  shop_personal.article 的数据：~16 rows (大约)
INSERT INTO `article` (`id`, `pid`, `name`, `create_time`) VALUES
	(14, NULL, '帮助中心', '2025-07-30 05:38:33'),
	(15, 14, '支付方式', '2025-07-30 05:38:41'),
	(18, 14, '订单查询', '2025-07-30 05:39:15'),
	(19, 14, '发票制度', '2025-07-30 05:39:22'),
	(20, NULL, '配送方式', '2025-07-30 05:50:26'),
	(21, 20, '验货与签收', '2025-07-30 05:50:42'),
	(22, 20, '配送时间及运费', '2025-07-30 05:50:51'),
	(23, 20, '物流政策', '2025-07-30 05:51:00'),
	(24, NULL, '售后服务', '2025-07-30 05:51:08'),
	(25, 24, '取消订单', '2025-07-30 05:51:16'),
	(26, 24, '退货政策', '2025-07-30 05:51:24'),
	(27, 24, '退货说明', '2025-07-30 05:51:31'),
	(28, NULL, '客服中心', '2025-07-30 05:51:39'),
	(29, 28, '购物流程', '2025-07-30 05:51:47'),
	(30, 28, '常见问题', '2025-07-30 05:51:54'),
	(31, 28, '服务协议', '2025-07-30 05:52:02');

-- 导出  表 shop_personal.article_detail 结构
DROP TABLE IF EXISTS `article_detail`;
CREATE TABLE IF NOT EXISTS `article_detail` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `aid` int unsigned DEFAULT NULL COMMENT '文章id',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `content` text COLLATE utf8mb4_general_ci COMMENT '文章内容',
  PRIMARY KEY (`id`),
  KEY `FK__article` (`aid`),
  CONSTRAINT `FK__article` FOREIGN KEY (`aid`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='文章详情';

-- 正在导出表  shop_personal.article_detail 的数据：~6 rows (大约)
INSERT INTO `article_detail` (`id`, `aid`, `update_time`, `content`) VALUES
	(2, 15, '2025-08-06 13:45:42', '<p>支付方式</p>'),
	(3, 18, '2025-08-06 13:45:42', '<p>订单查询</p>'),
	(4, 19, '2025-08-06 13:45:42', '<p>发票制度</p>'),
	(5, 21, '2025-08-06 13:45:42', '<p>验证与签收</p>'),
	(6, 25, '2025-08-06 13:52:46', NULL),
	(7, 23, '2025-08-06 14:21:33', NULL);

-- 导出  表 shop_personal.base_config 结构
DROP TABLE IF EXISTS `base_config`;
CREATE TABLE IF NOT EXISTS `base_config` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `site_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '网站名称',
  `site_logo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '网站LOGO',
  `beian` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '域名备案号',
  `com_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '公司名称',
  `com_loc` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '公司地址',
  `kefu_tel` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '客服电话',
  `kefu_qq` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '客服QQ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='网站基础配置表';

-- 正在导出表  shop_personal.base_config 的数据：~1 rows (大约)
INSERT INTO `base_config` (`id`, `site_name`, `site_logo`, `beian`, `com_name`, `com_loc`, `kefu_tel`, `kefu_qq`) VALUES
	(1, '四方心怡111', '/upload/687e10b0667d0.png', 'ICP备234234', '四方心意有限公司111', '欧冠覅偶尔', '132423542345', '234234234');

-- 导出  表 shop_personal.delivery 结构
DROP TABLE IF EXISTS `delivery`;
CREATE TABLE IF NOT EXISTS `delivery` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `way` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT '配送方式',
  `order` int unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='配送方式';

-- 正在导出表  shop_personal.delivery 的数据：~2 rows (大约)
INSERT INTO `delivery` (`id`, `way`, `order`) VALUES
	(1, '快递邮寄', 0),
	(4, '无实体货物', 0);

-- 导出  表 shop_personal.location 结构
DROP TABLE IF EXISTS `location`;
CREATE TABLE IF NOT EXISTS `location` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uid` int unsigned NOT NULL COMMENT '用户id',
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` char(11) COLLATE utf8mb4_general_ci NOT NULL,
  `address1` json NOT NULL COMMENT '省市区',
  `address2` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT '详细地址',
  `isDefault` int unsigned NOT NULL DEFAULT '0' COMMENT '0-正常，1-默认',
  `status` int unsigned NOT NULL DEFAULT '1' COMMENT '0-删除，1-正常',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='收货地址';

-- 正在导出表  shop_personal.location 的数据：~3 rows (大约)
INSERT INTO `location` (`id`, `uid`, `username`, `phone`, `address1`, `address2`, `isDefault`, `status`) VALUES
	(4, 23, '1', '1', '"[\\"天津市\\",\\"市辖区\\",\\"和平区\\"]"', '1', 0, 1),
	(5, 23, '芦葭苇', '13234624014', '"[\\"河北省\\",\\"唐山市\\",\\"路南区\\"]"', '加很舒服的', 0, 1),
	(6, 23, '234', '345', '"[\\"山西省\\",\\"大同市\\",\\"新荣区\\"]"', '245435', 1, 1);

-- 导出  表 shop_personal.shopcart 结构
DROP TABLE IF EXISTS `shopcart`;
CREATE TABLE IF NOT EXISTS `shopcart` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL COMMENT '用户id',
  `shop_id` int unsigned NOT NULL COMMENT '商品id',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK__shop_list` (`shop_id`),
  KEY `FK__user` (`user_id`),
  CONSTRAINT `FK__shop_list` FOREIGN KEY (`shop_id`) REFERENCES `shop_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK__user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='购物车';

-- 正在导出表  shop_personal.shopcart 的数据：~2 rows (大约)
INSERT INTO `shopcart` (`id`, `user_id`, `shop_id`, `create_time`) VALUES
	(1, 2, 15, '2025-07-27 10:56:19'),
	(2, 2, 7, '2025-07-27 10:58:44');

-- 导出  表 shop_personal.shop_category 结构
DROP TABLE IF EXISTS `shop_category`;
CREATE TABLE IF NOT EXISTS `shop_category` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT '商品分类名',
  `order_id` int unsigned NOT NULL DEFAULT '0' COMMENT '排序id',
  `status` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '状态：0禁用1正常',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_name` (`category_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='商品分类表';

-- 正在导出表  shop_personal.shop_category 的数据：~5 rows (大约)
INSERT INTO `shop_category` (`id`, `category_name`, `order_id`, `status`, `create_time`) VALUES
	(1, '家用电器', 0, 1, '2025-07-17 03:37:06'),
	(2, '箱包产品', 0, 1, '2025-07-17 03:55:40'),
	(3, '母婴用品', 0, 1, '2025-07-17 03:56:17'),
	(4, '家具纺织品', 0, 1, '2025-07-17 03:56:33'),
	(5, 'test3', 0, 0, '2025-07-17 06:19:08');

-- 导出  表 shop_personal.shop_list 结构
DROP TABLE IF EXISTS `shop_list`;
CREATE TABLE IF NOT EXISTS `shop_list` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int unsigned DEFAULT NULL COMMENT '商品所属分类',
  `shop_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT '商品名称',
  `shop_desc` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT '商品描述',
  `shop_price` decimal(10,2) unsigned NOT NULL COMMENT '商品价格',
  `shop_img` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '商品图片',
  `inventory` int unsigned NOT NULL DEFAULT '0' COMMENT '商品库存',
  `sales` int unsigned NOT NULL DEFAULT '0' COMMENT '销售额',
  `status` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '状态：0禁用1正常',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_shop_list_shop_category` (`category_id`),
  CONSTRAINT `FK_shop_list_shop_category` FOREIGN KEY (`category_id`) REFERENCES `shop_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='商品表';

-- 正在导出表  shop_personal.shop_list 的数据：~15 rows (大约)
INSERT INTO `shop_list` (`id`, `category_id`, `shop_name`, `shop_desc`, `shop_price`, `shop_img`, `inventory`, `sales`, `status`, `create_time`) VALUES
	(1, 1, '1', '1', 1.00, 'http://shop.lujiawei.top/upload/shop_6885d783228e53.11063306.JPG', 0, 0, 1, '2025-07-17 10:09:54'),
	(2, 3, '2', '3', 2.00, 'http://shop.lujiawei.top/upload/shop_6885d783228e53.11063306.JPG', 0, 0, 0, '2025-07-17 10:20:10'),
	(3, 4, '中国测试', '1', 1.00, 'http://shop.lujiawei.top/upload/shop_6885d783228e53.11063306.JPG', 0, 0, 1, '2025-07-17 11:29:36'),
	(4, 4, '中国', '2', 2.00, 'http://shop.lujiawei.top/upload/shop_6885d783228e53.11063306.JPG', 0, 0, 1, '2025-07-17 11:30:29'),
	(5, 4, '测试商品1', '1', 1.00, 'http://shop.lujiawei.top/upload/shop_6885d783228e53.11063306.JPG', 1, 0, 1, '2025-07-17 12:21:11'),
	(6, 4, '测试商品二', '1', 1.00, 'http://shop.lujiawei.top/upload/shop_6885d783228e53.11063306.JPG', 1, 0, 1, '2025-07-17 12:25:28'),
	(7, 2, '1', '1', 1.00, 'http://shop.lujiawei.top/upload/shop_6885d783228e53.11063306.JPG', 12, 1, 1, '2025-07-17 12:28:47'),
	(8, 3, '1', '1', 1.00, 'http://shop.lujiawei.top/upload/shop_6885d783228e53.11063306.JPG', 0, 0, 1, '2025-07-17 12:29:17'),
	(9, 1, '1', '1', 1.00, 'http://shop.lujiawei.top/upload/shop_6885d783228e53.11063306.JPG', 1, 1, 1, '2025-07-17 12:29:25'),
	(10, 1, '1', '1', 1.00, 'http://shop.lujiawei.top/upload/shop_6885d783228e53.11063306.JPG', 1, 1, 1, '2025-07-17 12:29:32'),
	(11, 1, '1', '1', 1.00, 'http://shop.lujiawei.top/upload/shop_6885d783228e53.11063306.JPG', 1, 111, 1, '2025-07-17 12:29:40'),
	(12, 1, '1', '1', 1.00, 'http://shop.lujiawei.top/upload/shop_6885d783228e53.11063306.JPG', 1, 11, 1, '2025-07-17 12:29:57'),
	(13, 1, '特使商品', '特使商品', 100.00, 'http://shop.lujiawei.top/upload/shop_6885d783228e53.11063306.JPG', 100, 2, 1, '2025-07-27 07:26:12'),
	(14, 1, '特使商品', '特使商品', 100.00, 'http://shop.lujiawei.top/upload/shop_6885d783228e53.11063306.JPG', 100, 2, 1, '2025-07-27 07:26:17'),
	(15, 1, '特权商品', '特权商品', 100.99, 'http://shop.lujiawei.top/upload/shop_6885d783228e53.11063306.JPG', 100, 2, 1, '2025-07-27 07:38:43');

-- 导出  表 shop_personal.user 结构
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '头像地址',
  `gender` bit(1) DEFAULT NULL COMMENT '0-女，1-男',
  `phone` char(11) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `type` bit(1) NOT NULL DEFAULT b'0' COMMENT '0-会员，1-管理员',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='用户表';

-- 正在导出表  shop_personal.user 的数据：~2 rows (大约)
INSERT INTO `user` (`id`, `username`, `password`, `avatar`, `gender`, `phone`, `email`, `create_time`, `type`) VALUES
	(2, 'admin', '$2y$10$.r5LjS0EE.KjLRPgbpkUue7CQmchJ8lwsmeeWRCdblsMgxFDkCQm2', NULL, NULL, NULL, NULL, NULL, b'1'),
	(23, 'test0012', '$2y$10$ey4U/pKhvd6VHLvpBe8QYOWPRFJB8Iq1Kb4ZiejZ4bmoUEt4a.JUa', '/images/avatar.png', NULL, NULL, NULL, '2025-07-27 03:40:59', b'0');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
