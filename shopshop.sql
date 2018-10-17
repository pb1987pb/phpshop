-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018 年 10 月 15 日 18:29
-- 服务器版本: 5.5.53
-- PHP 版本: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `shopshop`
--

-- --------------------------------------------------------

--
-- 表的结构 `pan_address`
--

CREATE TABLE IF NOT EXISTS `pan_address` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `member_id` mediumint(8) unsigned NOT NULL COMMENT '会员id',
  `shr_name` varchar(30) NOT NULL COMMENT '收货人姓名',
  `shr_tel` varchar(30) NOT NULL COMMENT '收货人电话',
  `shr_province` varchar(30) NOT NULL COMMENT '收货人省',
  `shr_city` varchar(30) NOT NULL COMMENT '收货人城市',
  `shr_area` varchar(30) NOT NULL COMMENT '收货人地区',
  `shr_address` varchar(255) NOT NULL DEFAULT '' COMMENT '收货人详细地址',
  `is_default` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否是默认地址',
  `poscode` varchar(30) NOT NULL DEFAULT '000000' COMMENT '邮政编码',
  `addtime` varchar(30) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='收货地址表' AUTO_INCREMENT=23 ;

--
-- 转存表中的数据 `pan_address`
--

INSERT INTO `pan_address` (`id`, `member_id`, `shr_name`, `shr_tel`, `shr_province`, `shr_city`, `shr_area`, `shr_address`, `is_default`, `poscode`, `addtime`) VALUES
(1, 10, '潘波1', '17665238176', '北京市', '市辖区', '东城区', '大河岸镇123', '是', '000000', NULL),
(2, 10, '潘波2', '17665238176', '湖北省', '武汉市', '罗田县', '大河岸镇', '否', '000000', NULL),
(3, 10, '潘波3', '17665238176', '湖北省', '黄石市', '罗田县', '大河岸镇', '否', '000000', NULL),
(15, 10, '得到', '17665238176', '广东省', '深圳市', '福田区', '得到', '否', '000000', '1539500482'),
(16, 10, '点点点', '17665238176', '广东省', '深圳市', '福田区', '顶顶顶顶的', '否', '000000', '1539500674'),
(17, 10, '多少多少多少', '17665238176', '天津市', '市辖区', '和平区', '的是方式否', '是', '000000', '1539503650'),
(18, 10, '否是范德萨范德萨但是方式', '17665238176', '广东省', '深圳市', '福田区', '的范德萨范德萨的地方否', '是', '000000', '1539503765'),
(22, 10, '我是来测试的啦啦啦', '17665238173', '广东省', '深圳市', '福田区', '大萨达是的的多少', '是', '000000', '1539597756');

-- --------------------------------------------------------

--
-- 表的结构 `pan_admin`
--

CREATE TABLE IF NOT EXISTS `pan_admin` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='管理员' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `pan_admin`
--

INSERT INTO `pan_admin` (`id`, `username`, `password`) VALUES
(1, 'root', '202cb962ac59075b964b07152d234b70'),
(4, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- 表的结构 `pan_admin_role`
--

CREATE TABLE IF NOT EXISTS `pan_admin_role` (
  `admin_id` mediumint(8) unsigned NOT NULL COMMENT '管理员id',
  `role_id` mediumint(8) unsigned NOT NULL COMMENT '角色id',
  KEY `admin_id` (`admin_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员角色';

--
-- 转存表中的数据 `pan_admin_role`
--

INSERT INTO `pan_admin_role` (`admin_id`, `role_id`) VALUES
(4, 4),
(4, 5);

-- --------------------------------------------------------

--
-- 表的结构 `pan_brand`
--

CREATE TABLE IF NOT EXISTS `pan_brand` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `brand_name` varchar(30) NOT NULL COMMENT '品牌名称',
  `site_url` varchar(150) NOT NULL DEFAULT '' COMMENT '官方网址',
  `logo` varchar(150) NOT NULL DEFAULT '' COMMENT '品牌Logo图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='品牌' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `pan_brand`
--

INSERT INTO `pan_brand` (`id`, `brand_name`, `site_url`, `logo`) VALUES
(1, '华为', '', 'logos/2018-06-25/5b30fed8d4e76.png'),
(2, '三星', '', 'logos/2018-06-25/5b30f7835325d.jpeg'),
(4, '大辣椒', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `pan_cart`
--

CREATE TABLE IF NOT EXISTS `pan_cart` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `goods_attr_ids` varchar(150) NOT NULL DEFAULT '' COMMENT '商品属性id',
  `goods_number` mediumint(8) unsigned NOT NULL COMMENT '商品数量',
  `member_id` mediumint(8) unsigned NOT NULL COMMENT '当前登录人id',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='购物车' AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `pan_cart`
--

INSERT INTO `pan_cart` (`id`, `goods_id`, `goods_attr_ids`, `goods_number`, `member_id`) VALUES
(5, 38, '59,64', 21, 10),
(7, 30, '', 7, 10),
(8, 40, '95,99', 7, 10);

-- --------------------------------------------------------

--
-- 表的结构 `pan_goods`
--

CREATE TABLE IF NOT EXISTS `pan_goods` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `goods_name` varchar(150) NOT NULL COMMENT '商品名称',
  `brand_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '所属品牌',
  `category_id` mediumint(8) unsigned NOT NULL COMMENT '所属主分类',
  `type_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '商品类型',
  `market_price` decimal(10,2) NOT NULL COMMENT '市场价格',
  `shop_price` decimal(10,2) NOT NULL COMMENT '本店价格',
  `goods_desc` longtext COMMENT '商品描述',
  `is_on_sale` enum('是','否') NOT NULL DEFAULT '是' COMMENT '是否上架',
  `is_delete` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否放到回收站',
  `addtime` datetime NOT NULL COMMENT '添加时间',
  `logo` varchar(150) NOT NULL DEFAULT '' COMMENT '原图',
  `sm_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '小图',
  `mid_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '中图',
  `big_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '大图',
  `mbig_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '更大图',
  `promote_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `promote_start_date` datetime NOT NULL COMMENT '促销开始时间',
  `promote_end_date` datetime NOT NULL COMMENT '促销结束时间',
  `is_new` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否新品',
  `is_hot` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否热卖',
  `is_best` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否精品',
  `is_floor` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否推荐楼层',
  `sort_num` tinyint(3) unsigned NOT NULL DEFAULT '100' COMMENT '排序的数字',
  PRIMARY KEY (`id`),
  KEY `shop_price` (`shop_price`),
  KEY `addtime` (`addtime`),
  KEY `is_on_sale` (`is_on_sale`),
  KEY `promote_price` (`promote_price`),
  KEY `promote_start_date` (`promote_start_date`),
  KEY `promote_end_date` (`promote_end_date`),
  KEY `is_new` (`is_new`),
  KEY `is_hot` (`is_hot`),
  KEY `is_best` (`is_best`),
  KEY `sort_num` (`sort_num`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='商品' AUTO_INCREMENT=41 ;

--
-- 转存表中的数据 `pan_goods`
--

INSERT INTO `pan_goods` (`id`, `goods_name`, `brand_id`, `category_id`, `type_id`, `market_price`, `shop_price`, `goods_desc`, `is_on_sale`, `is_delete`, `addtime`, `logo`, `sm_logo`, `mid_logo`, `big_logo`, `mbig_logo`, `promote_price`, `promote_start_date`, `promote_end_date`, `is_new`, `is_hot`, `is_best`, `is_floor`, `sort_num`) VALUES
(10, '多少岁', 1, 0, 0, '7485.00', '454.00', '<p><strong><span style="color:#00b050;">发给你给对象 浮点分的个</span></strong></p>', '是', '否', '2018-06-23 19:04:16', 'Goods/2018-06-23/5b2e292fcf5d4.png', 'Goods/2018-06-23/thumb_3_5b2e292fcf5d4.png', 'Goods/2018-06-23/thumb_2_5b2e292fcf5d4.png', 'Goods/2018-06-23/thumb_1_5b2e292fcf5d4.png', 'Goods/2018-06-23/thumb_0_5b2e292fcf5d4.png', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '否', 100),
(11, '但是', 3, 0, 0, '3221.00', '3212.00', '', '是', '否', '2018-06-23 19:04:47', 'Goods/2018-06-23/5b2e294e7cd97.png', 'Goods/2018-06-23/thumb_3_5b2e294e7cd97.png', 'Goods/2018-06-23/thumb_2_5b2e294e7cd97.png', 'Goods/2018-06-23/thumb_1_5b2e294e7cd97.png', 'Goods/2018-06-23/thumb_0_5b2e294e7cd97.png', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '否', 100),
(13, 'dss', 3, 0, 0, '156.00', '254.00', '', '是', '否', '2018-06-24 23:25:59', 'Goods/2018-06-24/5b2fb8072468c.png', 'Goods/2018-06-24/thumb_3_5b2fb8072468c.png', 'Goods/2018-06-24/thumb_2_5b2fb8072468c.png', 'Goods/2018-06-24/thumb_1_5b2fb8072468c.png', 'Goods/2018-06-24/thumb_0_5b2fb8072468c.png', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '否', 100),
(14, '得到撒', 1, 0, 0, '562.00', '52.00', '', '是', '否', '2018-06-25 22:46:26', 'Goods/2018-06-25/5b310041f15f2.png', 'Goods/2018-06-25/thumb_3_5b310041f15f2.png', 'Goods/2018-06-25/thumb_2_5b310041f15f2.png', 'Goods/2018-06-25/thumb_1_5b310041f15f2.png', 'Goods/2018-06-25/thumb_0_5b310041f15f2.png', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '否', 100),
(15, '得到', 1, 24, 2, '345.00', '14.00', '', '是', '否', '2018-06-25 22:50:39', 'Goods/2018-06-28/5b33b5f8cd498.png', 'Goods/2018-06-28/thumb_3_5b33b5f8cd498.png', 'Goods/2018-06-28/thumb_2_5b33b5f8cd498.png', 'Goods/2018-06-28/thumb_1_5b33b5f8cd498.png', 'Goods/2018-06-28/thumb_0_5b33b5f8cd498.png', '0.00', '0100-01-01 00:00:00', '0100-01-01 00:00:00', '否', '否', '否', '否', 100),
(16, '点点点', 2, 0, 0, '334.00', '2333.00', '', '是', '否', '2018-06-26 23:19:03', '', '', '', '', '', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '否', 100),
(17, 'jkkjkjk', 2, 24, 2, '322.00', '2133.00', '', '是', '否', '2018-06-26 23:26:21', 'Goods/2018-09-16/5b9e21a68a582.png', 'Goods/2018-09-16/thumb_3_5b9e21a68a582.png', 'Goods/2018-09-16/thumb_2_5b9e21a68a582.png', 'Goods/2018-09-16/thumb_1_5b9e21a68a582.png', 'Goods/2018-09-16/thumb_0_5b9e21a68a582.png', '0.00', '0100-01-01 00:00:00', '0100-01-01 00:00:00', '否', '否', '否', '否', 100),
(18, '点点点23', 2, 23, 2, '32333.00', '4333.00', '', '是', '否', '2018-06-26 23:28:38', 'Goods/2018-09-16/5b9e2142eda81.png', 'Goods/2018-09-16/thumb_3_5b9e2142eda81.png', 'Goods/2018-09-16/thumb_2_5b9e2142eda81.png', 'Goods/2018-09-16/thumb_1_5b9e2142eda81.png', 'Goods/2018-09-16/thumb_0_5b9e2142eda81.png', '0.00', '0100-01-01 00:00:00', '0100-01-01 00:00:00', '否', '否', '否', '否', 100),
(19, '大多数223', 0, 0, 0, '223.00', '1.00', '', '是', '否', '2018-06-27 23:00:55', '', '', '', '', '', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '否', 100),
(20, '但是的', 1, 0, 0, '0.00', '0.00', '', '是', '否', '2018-08-19 13:43:41', '', '', '', '', '', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '否', 100),
(22, '是速度', 1, 18, 1, '0.00', '0.00', '', '是', '否', '2018-08-19 14:04:57', 'Goods/2018-09-18/5ba0a0c9c8e3e.png', 'Goods/2018-09-18/thumb_3_5ba0a0c9c8e3e.png', 'Goods/2018-09-18/thumb_2_5ba0a0c9c8e3e.png', 'Goods/2018-09-18/thumb_1_5ba0a0c9c8e3e.png', 'Goods/2018-09-18/thumb_0_5ba0a0c9c8e3e.png', '0.00', '0100-01-01 00:00:00', '0100-01-01 00:00:00', '否', '否', '否', '否', 100),
(23, '测试主分类的', 1, 22, 1, '0.00', '0.00', '', '是', '否', '2018-08-29 21:51:51', 'Goods/2018-09-16/5b9def7cd7496.png', 'Goods/2018-09-16/thumb_3_5b9def7cd7496.png', 'Goods/2018-09-16/thumb_2_5b9def7cd7496.png', 'Goods/2018-09-16/thumb_1_5b9def7cd7496.png', 'Goods/2018-09-16/thumb_0_5b9def7cd7496.png', '0.00', '0100-01-01 00:00:00', '0100-01-01 00:00:00', '否', '是', '是', '否', 100),
(25, '得到', 0, 18, 1, '0.00', '0.00', '', '是', '否', '2018-08-29 23:36:17', 'Goods/2018-09-16/5b9df36410f6d.png', 'Goods/2018-09-16/thumb_3_5b9df36410f6d.png', 'Goods/2018-09-16/thumb_2_5b9df36410f6d.png', 'Goods/2018-09-16/thumb_1_5b9df36410f6d.png', 'Goods/2018-09-16/thumb_0_5b9df36410f6d.png', '0.00', '0100-01-01 00:00:00', '0100-01-01 00:00:00', '否', '是', '否', '否', 100),
(29, '得到问问我我我', 1, 17, 1, '0.00', '0.00', '', '是', '否', '2018-08-30 00:00:57', 'Goods/2018-09-16/5b9def44e8f5f.png', 'Goods/2018-09-16/thumb_3_5b9def44e8f5f.png', 'Goods/2018-09-16/thumb_2_5b9def44e8f5f.png', 'Goods/2018-09-16/thumb_1_5b9def44e8f5f.png', 'Goods/2018-09-16/thumb_0_5b9def44e8f5f.png', '0.00', '0100-01-01 00:00:00', '0100-01-01 00:00:00', '是', '否', '否', '否', 100),
(30, '的 地方', 0, 17, 1, '256.00', '250.00', '', '是', '否', '2018-08-30 22:57:40', 'Goods/2018-09-16/5b9dc0ef35984.png', 'Goods/2018-09-16/thumb_3_5b9dc0ef35984.png', 'Goods/2018-09-16/thumb_2_5b9dc0ef35984.png', 'Goods/2018-09-16/thumb_1_5b9dc0ef35984.png', 'Goods/2018-09-16/thumb_0_5b9dc0ef35984.png', '0.00', '0100-01-01 00:00:00', '0100-01-01 00:00:00', '否', '否', '否', '否', 100),
(38, 'iphone', 2, 22, 2, '1500.00', '256.00', '<p><img src="http://www.shop.com/Public/umeditor1_2_2-utf8-php/php/upload/20180922/15376216644555.png" alt="15376216644555.png" /><img src="http://www.shop.com/Public/umeditor1_2_2-utf8-php/php/upload/20180922/15376210883765.png" alt="15376210883765.png" /></p><p><img src="http://www.shop.com/Public/umeditor1_2_2-utf8-php/php/upload/20180922/15376217084177.png" alt="15376217084177.png" /></p><p><img src="http://www.shop.com/Public/umeditor1_2_2-utf8-php/php/upload/20180922/15376217154211.png" alt="15376217154211.png" /></p><p><img src="http://www.shop.com/Public/umeditor1_2_2-utf8-php/php/upload/20180922/15376217192055.png" alt="15376217192055.png" /></p><p><br /></p>', '是', '否', '2018-09-03 00:44:44', 'Goods/2018-09-16/5b9dc0c943045.png', 'Goods/2018-09-16/thumb_3_5b9dc0c943045.png', 'Goods/2018-09-16/thumb_2_5b9dc0c943045.png', 'Goods/2018-09-16/thumb_1_5b9dc0c943045.png', 'Goods/2018-09-16/thumb_0_5b9dc0c943045.png', '150.50', '2018-08-16 13:16:33', '2018-10-26 13:16:18', '否', '否', '否', '否', 255),
(39, '摄像头', 1, 18, 2, '23.00', '44.00', '<p><img src="http://www.shop.com/Public/umeditor1_2_2-utf8-php/php/upload/20180918/15372548116432.png" alt="15372548116432.png" /></p><p><br /></p><p>"&gt;</p>', '是', '否', '2018-09-15 23:48:02', 'Goods/2018-09-18/5ba0a094619af.png', 'Goods/2018-09-18/thumb_3_5ba0a094619af.png', 'Goods/2018-09-18/thumb_2_5ba0a094619af.png', 'Goods/2018-09-18/thumb_1_5ba0a094619af.png', 'Goods/2018-09-18/thumb_0_5ba0a094619af.png', '324.00', '2018-09-12 00:00:00', '2018-10-17 00:00:00', '否', '否', '否', '否', 150),
(40, 'ip', 4, 25, 1, '343.00', '123.00', '', '否', '否', '2018-09-16 00:01:45', 'Goods/2018-09-16/5b9dc0b2af99e.png', 'Goods/2018-09-16/thumb_3_5b9dc0b2af99e.png', 'Goods/2018-09-16/thumb_2_5b9dc0b2af99e.png', 'Goods/2018-09-16/thumb_1_5b9dc0b2af99e.png', 'Goods/2018-09-16/thumb_0_5b9dc0b2af99e.png', '526.00', '2018-09-11 00:00:00', '2018-09-20 11:43:23', '否', '否', '否', '否', 200);

-- --------------------------------------------------------

--
-- 表的结构 `pan_good_attr`
--

CREATE TABLE IF NOT EXISTS `pan_good_attr` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `type_id` mediumint(8) unsigned NOT NULL COMMENT '类型id',
  `attr_name` varchar(150) NOT NULL COMMENT '属性名称',
  `atrr_type` tinyint(3) unsigned NOT NULL COMMENT '属性本身的类型，通常有唯一、单选和多选之分',
  `attr_input_type` tinyint(3) unsigned NOT NULL COMMENT '属性的输入类型，通常有文本框、下拉列表、文本域之分',
  `attr_value` text COMMENT '属性的可选值',
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  KEY `attr_name` (`attr_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='商品属性表' AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `pan_good_attr`
--

INSERT INTO `pan_good_attr` (`id`, `type_id`, `attr_name`, `atrr_type`, `attr_input_type`, `attr_value`) VALUES
(2, 2, '颜色', 2, 2, '黑色\r\n白色\r\n紫色\r\n红色'),
(3, 2, '上市时间', 1, 1, ''),
(4, 2, '生产日期', 1, 1, ''),
(6, 1, '版型款式', 1, 3, ''),
(7, 1, '尺码', 2, 2, '28\r\n29\r\n30\r\n31\r\n32\r\n33\r\n34'),
(8, 2, '尺寸', 2, 2, '180*25   \r\n182*36    \r\n183*45'),
(9, 1, '测试的', 2, 2, '哈哈1      \r\n         哈哈2   \r\n   哈哈3     哈哈  4    哈哈 5');

-- --------------------------------------------------------

--
-- 表的结构 `pan_good_cat`
--

CREATE TABLE IF NOT EXISTS `pan_good_cat` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `good_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `category_id` mediumint(8) unsigned NOT NULL COMMENT '分类id',
  PRIMARY KEY (`id`),
  KEY `good_id` (`good_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='商品扩展分类表' AUTO_INCREMENT=174 ;

--
-- 转存表中的数据 `pan_good_cat`
--

INSERT INTO `pan_good_cat` (`id`, `good_id`, `category_id`) VALUES
(105, 29, 17),
(106, 29, 2),
(107, 29, 3),
(108, 29, 13),
(109, 29, 14),
(114, 25, 2),
(115, 25, 21),
(119, 15, 6),
(128, 39, 2),
(168, 30, 1),
(169, 38, 17),
(173, 40, 22);

-- --------------------------------------------------------

--
-- 表的结构 `pan_good_category`
--

CREATE TABLE IF NOT EXISTS `pan_good_category` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `catename` varchar(30) NOT NULL COMMENT '分类名称',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '父类id',
  `sort_num` tinyint(3) unsigned NOT NULL DEFAULT '100' COMMENT '排序的数字',
  `is_floor` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否推荐楼层',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='商品分类表' AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `pan_good_category`
--

INSERT INTO `pan_good_category` (`id`, `catename`, `parent_id`, `sort_num`, `is_floor`) VALUES
(1, '家用电器', 0, 100, '是'),
(2, '手机、数码、京东通信', 0, 100, '是'),
(3, '电脑、办公', 0, 100, '否'),
(4, '家居、家具、家装、厨具', 0, 100, '否'),
(5, '男装、女装、内衣、珠宝', 0, 100, '否'),
(6, '个护化妆', 0, 100, '否'),
(8, '运动户外', 0, 100, '否'),
(9, '汽车、汽车用品', 0, 100, '否'),
(10, '母婴、玩具乐器', 0, 100, '否'),
(11, '食品、酒类、生鲜、特产', 0, 100, '否'),
(12, '营养保健', 0, 100, '否'),
(13, '图书、音像、电子书', 0, 100, '否'),
(14, '彩票、旅行、充值、票务', 0, 100, '否'),
(17, '生活电器', 1, 100, '是'),
(18, '厨房电器', 1, 100, '否'),
(19, '个护健康', 1, 100, '否'),
(21, 'iphone', 2, 100, '否'),
(22, '哈哈测试的', 17, 100, '否'),
(23, '大屏手机', 2, 100, '是'),
(24, '翻盖手机', 2, 100, '是'),
(25, '大大的家电', 1, 100, '是');

-- --------------------------------------------------------

--
-- 表的结构 `pan_good_number`
--

CREATE TABLE IF NOT EXISTS `pan_good_number` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `good_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `number` mediumint(8) unsigned NOT NULL COMMENT '商品数量',
  `attr_list` char(200) NOT NULL COMMENT '相应属性列表',
  PRIMARY KEY (`id`),
  KEY `good_id` (`good_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='商品库存量表' AUTO_INCREMENT=84 ;

--
-- 转存表中的数据 `pan_good_number`
--

INSERT INTO `pan_good_number` (`id`, `good_id`, `number`, `attr_list`) VALUES
(72, 40, 2321, '93,97'),
(73, 40, 1331, '94,98'),
(74, 40, 233, '95,99'),
(80, 38, 9992, '59,64'),
(81, 38, 9979, '65,68'),
(82, 38, 9999, '66,69'),
(83, 30, 15, '');

-- --------------------------------------------------------

--
-- 表的结构 `pan_good_phone`
--

CREATE TABLE IF NOT EXISTS `pan_good_phone` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `good_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `pic` varchar(150) NOT NULL DEFAULT '' COMMENT '原图',
  `sm_pic` varchar(150) NOT NULL DEFAULT '' COMMENT '小图',
  `mid_pic` varchar(150) NOT NULL DEFAULT '' COMMENT '中图',
  `big_pic` varchar(150) NOT NULL DEFAULT '' COMMENT '大图',
  PRIMARY KEY (`id`),
  KEY `good_id` (`good_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='商品相册表' AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `pan_good_phone`
--

INSERT INTO `pan_good_phone` (`id`, `good_id`, `pic`, `sm_pic`, `mid_pic`, `big_pic`) VALUES
(5, 22, 'Goods/2018-08-19/5b795058effff.png', 'Goods/2018-08-19/thumb_0_5b795058effff.png', 'Goods/2018-08-19/thumb_1_5b795058effff.png', 'Goods/2018-08-19/thumb_2_5b795058effff.png'),
(6, 22, 'Goods/2018-08-19/5b7950592eb6b.png', 'Goods/2018-08-19/thumb_0_5b7950592eb6b.png', 'Goods/2018-08-19/thumb_1_5b7950592eb6b.png', 'Goods/2018-08-19/thumb_2_5b7950592eb6b.png'),
(7, 38, 'Goods/2018-09-17/5b9f755040738.png', 'Goods/2018-09-17/thumb_0_5b9f755040738.png', 'Goods/2018-09-17/thumb_1_5b9f755040738.png', 'Goods/2018-09-17/thumb_2_5b9f755040738.png'),
(8, 38, 'Goods/2018-09-17/5b9f7550756ec.png', 'Goods/2018-09-17/thumb_0_5b9f7550756ec.png', 'Goods/2018-09-17/thumb_1_5b9f7550756ec.png', 'Goods/2018-09-17/thumb_2_5b9f7550756ec.png'),
(9, 38, 'Goods/2018-09-17/5b9f755094edc.png', 'Goods/2018-09-17/thumb_0_5b9f755094edc.png', 'Goods/2018-09-17/thumb_1_5b9f755094edc.png', 'Goods/2018-09-17/thumb_2_5b9f755094edc.png'),
(10, 38, 'Goods/2018-09-17/5b9f7550b7994.png', 'Goods/2018-09-17/thumb_0_5b9f7550b7994.png', 'Goods/2018-09-17/thumb_1_5b9f7550b7994.png', 'Goods/2018-09-17/thumb_2_5b9f7550b7994.png'),
(15, 39, 'Goods/2018-09-18/5ba09f6eb814b.png', 'Goods/2018-09-18/thumb_0_5ba09f6eb814b.png', 'Goods/2018-09-18/thumb_1_5ba09f6eb814b.png', 'Goods/2018-09-18/thumb_2_5ba09f6eb814b.png'),
(16, 39, 'Goods/2018-09-18/5ba09f6eeb5a7.png', 'Goods/2018-09-18/thumb_0_5ba09f6eeb5a7.png', 'Goods/2018-09-18/thumb_1_5ba09f6eeb5a7.png', 'Goods/2018-09-18/thumb_2_5ba09f6eeb5a7.png'),
(17, 39, 'Goods/2018-09-18/5ba09f6f23e4a.png', 'Goods/2018-09-18/thumb_0_5ba09f6f23e4a.png', 'Goods/2018-09-18/thumb_1_5ba09f6f23e4a.png', 'Goods/2018-09-18/thumb_2_5ba09f6f23e4a.png'),
(18, 39, 'Goods/2018-09-18/5ba09f6f50544.png', 'Goods/2018-09-18/thumb_0_5ba09f6f50544.png', 'Goods/2018-09-18/thumb_1_5ba09f6f50544.png', 'Goods/2018-09-18/thumb_2_5ba09f6f50544.png');

-- --------------------------------------------------------

--
-- 表的结构 `pan_good_type`
--

CREATE TABLE IF NOT EXISTS `pan_good_type` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `type_name` varchar(150) NOT NULL COMMENT '类型名称',
  PRIMARY KEY (`id`),
  KEY `type_name` (`type_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='商品类型表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `pan_good_type`
--

INSERT INTO `pan_good_type` (`id`, `type_name`) VALUES
(2, '手机'),
(1, '服装1');

-- --------------------------------------------------------

--
-- 表的结构 `pan_member`
--

CREATE TABLE IF NOT EXISTS `pan_member` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `face` varchar(150) NOT NULL DEFAULT '' COMMENT '头像',
  `jifen` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='会员表' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `pan_member`
--

INSERT INTO `pan_member` (`id`, `username`, `password`, `face`, `jifen`) VALUES
(10, 'pb1987pb', '202cb962ac59075b964b07152d234b70', '', 6000);

-- --------------------------------------------------------

--
-- 表的结构 `pan_member_level`
--

CREATE TABLE IF NOT EXISTS `pan_member_level` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `level_name` varchar(30) NOT NULL COMMENT '级别名称',
  `jifen_bottom` mediumint(8) unsigned NOT NULL COMMENT '积分下限',
  `jifen_top` mediumint(8) unsigned NOT NULL COMMENT '积分上限',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='会员级别' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `pan_member_level`
--

INSERT INTO `pan_member_level` (`id`, `level_name`, `jifen_bottom`, `jifen_top`) VALUES
(2, '初级会员', 5001, 10000),
(3, '高级会员', 10001, 20000),
(4, 'VIP', 20001, 16777215),
(5, '注册会员', 0, 5000);

-- --------------------------------------------------------

--
-- 表的结构 `pan_member_price`
--

CREATE TABLE IF NOT EXISTS `pan_member_price` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `good_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `level_id` mediumint(8) unsigned NOT NULL COMMENT '会员等级id',
  `price` decimal(10,2) NOT NULL COMMENT '价钱',
  PRIMARY KEY (`id`),
  KEY `good_id` (`good_id`),
  KEY `level_id` (`level_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='会员价格表' AUTO_INCREMENT=216 ;

--
-- 转存表中的数据 `pan_member_price`
--

INSERT INTO `pan_member_price` (`id`, `good_id`, `level_id`, `price`) VALUES
(37, 19, 5, '321.00'),
(38, 19, 2, '21.00'),
(39, 19, 3, '322.00'),
(43, 18, 5, '3421.00'),
(44, 18, 2, '3421.00'),
(45, 18, 3, '334444.00'),
(46, 18, 4, '5544.00'),
(53, 17, 5, '1.00'),
(54, 17, 3, '3.00'),
(55, 17, 4, '9.00'),
(80, 39, 5, '123.00'),
(81, 39, 2, '43432.00'),
(82, 39, 3, '65765756.00'),
(83, 39, 4, '9789798.00'),
(212, 38, 5, '56.00'),
(213, 38, 2, '145.00'),
(214, 38, 3, '123.00'),
(215, 38, 4, '123.00');

-- --------------------------------------------------------

--
-- 表的结构 `pan_order`
--

CREATE TABLE IF NOT EXISTS `pan_order` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `member_id` mediumint(8) unsigned NOT NULL COMMENT '会员Id',
  `addtime` int(10) unsigned NOT NULL COMMENT '下单时间',
  `pay_status` enum('是','否') NOT NULL DEFAULT '否' COMMENT '支付状态',
  `pay_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '支付方式，1:支付宝，2:微信',
  `pay_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
  `total_price` decimal(10,2) NOT NULL COMMENT '定单总价',
  `shr_name` varchar(30) NOT NULL COMMENT '收货人姓名',
  `shr_tel` varchar(30) NOT NULL COMMENT '收货人电话',
  `shr_province` varchar(30) NOT NULL COMMENT '收货人省',
  `shr_city` varchar(30) NOT NULL COMMENT '收货人城市',
  `shr_area` varchar(30) NOT NULL COMMENT '收货人地区',
  `shr_address` varchar(30) NOT NULL COMMENT '收货人详细地址',
  `postcode` char(6) NOT NULL DEFAULT '000000' COMMENT '收货人邮编',
  `beizhu` text NOT NULL COMMENT '备注',
  `post_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发货状态,0:未发货,1:已发货2:已收到货',
  `post_number` varchar(30) NOT NULL DEFAULT '' COMMENT '快递号',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `addtime` (`addtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单基本信息' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `pan_order_goods`
--

CREATE TABLE IF NOT EXISTS `pan_order_goods` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `order_id` mediumint(8) unsigned NOT NULL COMMENT '定单Id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品Id',
  `goods_attr_id` varchar(150) NOT NULL DEFAULT '' COMMENT '商品属性id',
  `goods_number` mediumint(8) unsigned NOT NULL COMMENT '购买的数量',
  `price` decimal(10,2) NOT NULL COMMENT '购买的价格',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单商品表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `pan_privilege`
--

CREATE TABLE IF NOT EXISTS `pan_privilege` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `pri_name` varchar(30) NOT NULL COMMENT '权限名称',
  `module_name` varchar(30) NOT NULL DEFAULT '' COMMENT '模块名称',
  `controller_name` varchar(30) NOT NULL DEFAULT '' COMMENT '控制器名称',
  `action_name` varchar(30) NOT NULL DEFAULT '' COMMENT '方法名称',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '上级权限Id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='权限' AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `pan_privilege`
--

INSERT INTO `pan_privilege` (`id`, `pri_name`, `module_name`, `controller_name`, `action_name`, `parent_id`) VALUES
(1, '商品管理', '', '', '', 0),
(2, '商品列表', 'admin', 'goods', 'lst', 1),
(3, '添加商品', 'admin', 'goods', 'add', 2),
(4, '修改商品', 'admin', 'goods', 'edit', 2),
(5, '会员管理', '', '', '', 0),
(6, '会员列表', 'admin', 'memberLevel', 'lst', 5),
(7, '商品分类', 'admin', 'goodCategory', 'lst', 1),
(8, 'RBAC管理', '', '', '', 0),
(11, '权限列表', 'admin', 'Privilege', 'lst', 8),
(12, '角色列表', 'admin', 'Role', 'lst', 8),
(13, '管理员列表', 'admin', 'Admin', 'lst', 8),
(14, '类型分类', 'admin', 'GoodType', 'lst', 1);

-- --------------------------------------------------------

--
-- 表的结构 `pan_role`
--

CREATE TABLE IF NOT EXISTS `pan_role` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `role_name` varchar(30) NOT NULL COMMENT '角色名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='角色' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `pan_role`
--

INSERT INTO `pan_role` (`id`, `role_name`) VALUES
(2, '订单管理员'),
(4, '商品管理员'),
(5, '总经理');

-- --------------------------------------------------------

--
-- 表的结构 `pan_role_pri`
--

CREATE TABLE IF NOT EXISTS `pan_role_pri` (
  `pri_id` mediumint(8) unsigned NOT NULL COMMENT '权限id',
  `role_id` mediumint(8) unsigned NOT NULL COMMENT '角色id',
  KEY `pri_id` (`pri_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限';

--
-- 转存表中的数据 `pan_role_pri`
--

INSERT INTO `pan_role_pri` (`pri_id`, `role_id`) VALUES
(1, 4),
(2, 4),
(3, 4),
(4, 4),
(7, 4),
(1, 5),
(2, 5),
(3, 5),
(4, 5),
(7, 5),
(5, 5),
(6, 5);

-- --------------------------------------------------------

--
-- 表的结构 `pan_shangpin_attr`
--

CREATE TABLE IF NOT EXISTS `pan_shangpin_attr` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `good_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `attr_id` mediumint(8) unsigned NOT NULL COMMENT '属性id',
  `attr_value` varchar(150) NOT NULL COMMENT '属性值',
  PRIMARY KEY (`id`),
  KEY `good_id` (`good_id`),
  KEY `attr_id` (`attr_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='商品所拥有的属性对应表' AUTO_INCREMENT=100 ;

--
-- 转存表中的数据 `pan_shangpin_attr`
--

INSERT INTO `pan_shangpin_attr` (`id`, `good_id`, `attr_id`, `attr_value`) VALUES
(59, 38, 2, '黑色'),
(62, 38, 3, '2015-05-21'),
(63, 38, 4, '2016-07-25'),
(64, 38, 8, '180*25'),
(65, 38, 8, '182*36'),
(66, 38, 8, '183*45'),
(68, 38, 2, '白色'),
(69, 38, 2, '红色'),
(92, 40, 6, '的是是是'),
(93, 40, 7, '28'),
(94, 40, 7, '29'),
(95, 40, 7, '30'),
(96, 40, 7, '32'),
(97, 40, 9, '哈哈1'),
(98, 40, 9, '哈哈2'),
(99, 40, 9, '哈哈3     哈哈  4    哈哈 5');

-- --------------------------------------------------------

--
-- 表的结构 `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `good_id` int(11) NOT NULL DEFAULT '0',
  `goods_number` int(11) NOT NULL DEFAULT '0',
  `attr_list` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='测试的' AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `test`
--

INSERT INTO `test` (`id`, `good_id`, `goods_number`, `attr_list`) VALUES
(1, 11, 132, '3,5'),
(2, 11, 123, '1,5'),
(3, 11, 555, '3,4'),
(4, 12, 123, '14,44'),
(5, 13, 324, '28,31'),
(6, 12, 443, '4,5,6');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
