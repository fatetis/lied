/*
Navicat MySQL Data Transfer

Source Server         : my
Source Server Version : 50723
Source Host           : localhost:3306
Source Database       : lied1

Target Server Type    : MYSQL
Target Server Version : 50723
File Encoding         : 65001

Date: 2020-01-15 18:31:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `lied_admin_menu`
-- ----------------------------
DROP TABLE IF EXISTS `lied_admin_menu`;
CREATE TABLE `lied_admin_menu`
(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permission` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lied_admin_menu
-- ----------------------------
INSERT INTO `lied_admin_menu`
VALUES ('1', '0', '1', 'Index', 'fa-bar-chart', 'dashboard', null, null, '2019-12-10 15:27:18');
INSERT INTO `lied_admin_menu` VALUES ('2', '0', '2', 'Admin', 'fa-tasks', '', null, null, null);
INSERT INTO `lied_admin_menu` VALUES ('3', '2', '3', 'Users', 'fa-users', 'auth/users', null, null, null);
INSERT INTO `lied_admin_menu` VALUES ('4', '2', '4', 'Roles', 'fa-user', 'auth/roles', null, null, null);
INSERT INTO `lied_admin_menu` VALUES ('5', '2', '5', 'Permission', 'fa-ban', 'auth/permissions', null, null, null);
INSERT INTO `lied_admin_menu` VALUES ('6', '2', '6', 'Menu', 'fa-bars', 'auth/menu', null, null, null);
INSERT INTO `lied_admin_menu` VALUES ('7', '2', '7', 'Operation log', 'fa-history', 'auth/logs', null, null, null);
INSERT INTO `lied_admin_menu`
VALUES ('8', '0', '16', '产品管理', 'fa-bars', 'product', null, '2018-12-19 09:59:17', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('9', '8', '17', '产品列表', 'fa-bars', 'product', null, '2018-12-19 10:21:12', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('10', '8', '19', '产品规格分类列表', 'fa-bars', 'product/sku/category', null, '2018-12-24 09:16:15',
        '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('11', '0', '13', '品牌管理', 'fa-bars', null, null, '2018-12-25 03:24:49', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('12', '11', '14', '品牌列表', 'fa-bars', 'brand', null, '2018-12-25 03:25:21', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('13', '11', '15', '品牌分类', 'fa-bars', 'brand/category', null, '2018-12-25 03:25:57', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('14', '8', '18', '产品分类', 'fa-bars', 'product/category', null, '2018-12-25 04:00:55', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('15', '8', '20', '秒杀管理', 'fa-align-left', 'product/seckill', null, '2019-01-24 09:24:16',
        '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('16', '0', '11', '用户管理', 'fa-bars', 'user', null, '2019-02-16 14:10:10', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('17', '16', '12', '用户列表', 'fa-bars', 'user', null, '2019-02-16 14:10:28', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('20', '8', '21', '订单管理', 'fa-bars', 'product/order', null, '2019-02-18 14:57:08', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('21', '0', '26', '地域管理', 'fa-bars', null, null, '2019-02-18 15:25:13', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('22', '21', '27', '地域列表', 'fa-bars', 'region', null, '2019-02-18 15:25:31', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('23', '0', '29', '广告管理', 'fa-bars', null, null, '2019-02-19 09:23:06', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('24', '23', '30', '广告位置列表', 'fa-bars', 'adv/position', null, '2019-02-19 09:23:30', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('25', '23', '31', '广告列表', 'fa-bars', 'adv', null, '2019-02-19 09:44:55', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('26', '0', '32', '文章管理', 'fa-bars', null, null, '2019-02-19 16:12:18', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('27', '26', '33', '文章分类', 'fa-bars', 'artical/category', null, '2019-02-19 16:12:37', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('28', '26', '34', '文章列表', 'fa-bars', 'artical', null, '2019-02-19 16:12:54', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('29', '21', '28', '地域开通', 'fa-bars', 'region/open', null, '2019-05-21 15:50:21', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('30', '0', '22', '优惠券管理', 'fa-bars', null, null, '2019-06-17 10:09:19', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('31', '30', '23', '优惠券列表', 'fa-bars', 'coupon', null, '2019-06-17 10:09:57', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('32', '30', '24', '线下券列表', 'fa-bars', 'coupon/batch', null, '2019-06-26 11:08:59', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu`
VALUES ('33', '30', '25', '线下券码列表', 'fa-bars', 'coupon/offline', null, '2019-07-10 13:54:04', '2019-12-20 14:45:45');
INSERT INTO `lied_admin_menu` VALUES ('34', '2', '8', 'Log viewer', 'fa-database', 'logs', null, '2019-10-09 11:41:08', '2019-10-09 11:42:46');
INSERT INTO `lied_admin_menu`
VALUES ('35', '2', '9', '定时任务', 'fa-hourglass-1', '/crontabs', null, '2019-12-20 14:44:49', '2019-12-20 14:45:54');
INSERT INTO `lied_admin_menu`
VALUES ('36', '2', '10', '定时任务日志', 'fa-bars', '/crontabLogs', null, '2019-12-20 14:45:34', '2019-12-20 14:45:45');

-- ----------------------------
-- Table structure for `lied_admin_operation_log`
-- ----------------------------
DROP TABLE IF EXISTS `lied_admin_operation_log`;
CREATE TABLE `lied_admin_operation_log`
(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lied_admin_operation_log_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6394 DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lied_admin_operation_log
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_admin_permissions`
-- ----------------------------
DROP TABLE IF EXISTS `lied_admin_permissions`;
CREATE TABLE `lied_admin_permissions`
(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `http_path` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lied_admin_permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lied_admin_permissions
-- ----------------------------
INSERT INTO `lied_admin_permissions` VALUES ('1', 'All permission', '*', '', '*', null, null);
INSERT INTO `lied_admin_permissions` VALUES ('2', 'Dashboard', 'dashboard', 'GET', '/', null, null);
INSERT INTO `lied_admin_permissions` VALUES ('3', 'Login', 'auth.login', '', '/auth/login\r\n/auth/logout', null, null);
INSERT INTO `lied_admin_permissions` VALUES ('4', 'User setting', 'auth.setting', 'GET,PUT', '/auth/setting', null, null);
INSERT INTO `lied_admin_permissions` VALUES ('5', 'Auth management', 'auth.management', '', '/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs', null, null);
INSERT INTO `lied_admin_permissions` VALUES ('6', 'Logs', 'ext.log-viewer', null, '/logs*', '2019-10-09 11:41:08', '2019-10-09 11:41:08');
INSERT INTO `lied_admin_permissions`
VALUES ('7', 'Tab-dashboard', 'tabs.dashboard', '', '/dashboard', '2019-12-10 15:27:18', '2019-12-10 15:27:18');

-- ----------------------------
-- Table structure for `lied_admin_roles`
-- ----------------------------
DROP TABLE IF EXISTS `lied_admin_roles`;
CREATE TABLE `lied_admin_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lied_admin_roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lied_admin_roles
-- ----------------------------
INSERT INTO `lied_admin_roles` VALUES ('1', 'Administrator', 'administrator', '2018-12-19 09:35:18', '2018-12-19 09:35:18');

-- ----------------------------
-- Table structure for `lied_admin_role_menu`
-- ----------------------------
DROP TABLE IF EXISTS `lied_admin_role_menu`;
CREATE TABLE `lied_admin_role_menu` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  KEY `lied_admin_role_menu_role_id_menu_id_index` (`role_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lied_admin_role_menu
-- ----------------------------
INSERT INTO `lied_admin_role_menu` VALUES ('1', '2', null, null);
INSERT INTO `lied_admin_role_menu`
VALUES ('1', '35', null, null);
INSERT INTO `lied_admin_role_menu`
VALUES ('1', '36', null, null);

-- ----------------------------
-- Table structure for `lied_admin_role_permissions`
-- ----------------------------
DROP TABLE IF EXISTS `lied_admin_role_permissions`;
CREATE TABLE `lied_admin_role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  KEY `lied_admin_role_permissions_role_id_permission_id_index` (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lied_admin_role_permissions
-- ----------------------------
INSERT INTO `lied_admin_role_permissions` VALUES ('1', '1', null, null);

-- ----------------------------
-- Table structure for `lied_admin_role_users`
-- ----------------------------
DROP TABLE IF EXISTS `lied_admin_role_users`;
CREATE TABLE `lied_admin_role_users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  KEY `lied_admin_role_users_role_id_user_id_index` (`role_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lied_admin_role_users
-- ----------------------------
INSERT INTO `lied_admin_role_users` VALUES ('1', '1', null, null);

-- ----------------------------
-- Table structure for `lied_admin_users`
-- ----------------------------
DROP TABLE IF EXISTS `lied_admin_users`;
CREATE TABLE `lied_admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lied_admin_users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lied_admin_users
-- ----------------------------
INSERT INTO `lied_admin_users`
VALUES ('1', 'admin', '$2y$10$7QvNbNNMgfrh8UmBcnhfdOJExSbF6jayvpFmBxf1JYWX/snjwc5Qi', 'Administrator', null,
        'vhsnCXo1NJJGcQ5gERzZFHVJZ3lo3mhih2yqMBMydYA1fIWeJTgAgv07ZqCF', '2018-12-19 09:35:18', '2018-12-19 09:35:18');

-- ----------------------------
-- Table structure for `lied_admin_user_permissions`
-- ----------------------------
DROP TABLE IF EXISTS `lied_admin_user_permissions`;
CREATE TABLE `lied_admin_user_permissions` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  KEY `lied_admin_user_permissions_user_id_permission_id_index` (`user_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lied_admin_user_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_adv`
-- ----------------------------
DROP TABLE IF EXISTS `lied_adv`;
CREATE TABLE `lied_adv` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT '名称',
  `url` varchar(255) DEFAULT NULL COMMENT '广告链接',
  `thumb` int(16) NOT NULL COMMENT '广告图片',
  `position_id` int(16) unsigned NOT NULL COMMENT '广告位置ID',
  `region_city_id` varchar(64) NOT NULL COMMENT '展示城市ID',
  `start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始时间',
  `end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  `click_num` int(16) DEFAULT '0' COMMENT '点击数量',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示 1-显示 0-不显示',
  `sort_order` int(4) DEFAULT NULL COMMENT '排序',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `position_id` (`position_id`),
  CONSTRAINT `adv-position_id` FOREIGN KEY (`position_id`) REFERENCES `lied_adv_position` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='广告展示表';

-- ----------------------------
-- Records of lied_adv
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_adv_position`
-- ----------------------------
DROP TABLE IF EXISTS `lied_adv_position`;
CREATE TABLE `lied_adv_position` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT '名称',
  `width` int(8) NOT NULL COMMENT '宽度',
  `height` int(8) NOT NULL COMMENT '高度',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示 1-显示 0-不显示',
  `sort_order` int(4) DEFAULT NULL COMMENT '排序',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='广告位置表';

-- ----------------------------
-- Records of lied_adv_position
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_artical`
-- ----------------------------
DROP TABLE IF EXISTS `lied_artical`;
CREATE TABLE `lied_artical` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章自增id',
  `category_id` int(16) unsigned NOT NULL COMMENT '分类id',
  `user_id` int(32) unsigned NOT NULL COMMENT '创建者id',
  `title` varchar(128) NOT NULL COMMENT '文章标题',
  `thumb` int(16) NOT NULL COMMENT '文章缩略图',
  `description` text COMMENT '简介',
  `content` text NOT NULL COMMENT '内容',
  `is_hot` tinyint(1) unsigned DEFAULT NULL COMMENT '热门文章',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `sort_order` int(4) unsigned DEFAULT NULL COMMENT '排序',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of lied_artical
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_artical_category`
-- ----------------------------
DROP TABLE IF EXISTS `lied_artical_category`;
CREATE TABLE `lied_artical_category` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` varchar(64) NOT NULL COMMENT '分类名称',
  `description` text COMMENT '分类描述',
  `pid` int(16) unsigned NOT NULL COMMENT '父级id',
  `sort_order` int(1) unsigned DEFAULT NULL COMMENT '排序',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='文章分类表';

-- ----------------------------
-- Records of lied_artical_category
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_brand`
-- ----------------------------
DROP TABLE IF EXISTS `lied_brand`;
CREATE TABLE `lied_brand` (
                            `id`          int(16) unsigned NOT NULL AUTO_INCREMENT,
                            `name`        varchar(64)  NOT NULL COMMENT '品牌名称',
                            `category_id` int(16) unsigned DEFAULT '0' COMMENT '品牌分类id',
                            `thumb`       int(16) unsigned NOT NULL COMMENT '品牌logo',
                            `description` text         NOT NULL COMMENT '品牌描述',
                            `site_url`    varchar(255) NOT NULL COMMENT '品牌的网址',
                            `sort_order`  tinyint(4) NOT NULL,
                            `is_audit`    tinyint(1) NOT NULL,
                            `is_show`     tinyint(1) NOT NULL COMMENT '是否显示',
                            `created_at`  datetime DEFAULT NULL,
                            `updated_at`  datetime DEFAULT NULL,
                            `deleted_at`  datetime DEFAULT NULL,
                            PRIMARY KEY (`id`),
                            KEY           `brand-category_id` (`category_id`),
                            KEY           `brand-thumb` (`thumb`),
                            CONSTRAINT `brand-category_id` FOREIGN KEY (`category_id`) REFERENCES `lied_brand_category` (`id`) ON UPDATE CASCADE,
                            CONSTRAINT `brand-thumb` FOREIGN KEY (`thumb`) REFERENCES `lied_media` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lied_brand
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_brand_category`
-- ----------------------------
DROP TABLE IF EXISTS `lied_brand_category`;
CREATE TABLE `lied_brand_category` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(16) unsigned NOT NULL,
  `name` varchar(64) NOT NULL COMMENT '名称',
  `sort_order` int(4) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lied_brand_category
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_cart`
-- ----------------------------
DROP TABLE IF EXISTS `lied_cart`;
CREATE TABLE `lied_cart` (
  `id` int(16) NOT NULL,
  `user_id` int(16) unsigned NOT NULL COMMENT '用户id',
  `product_id` int(16) unsigned NOT NULL COMMENT '产品id',
  `attr_id` int(16) unsigned NOT NULL COMMENT '属性id',
  `brand_id` int(16) unsigned NOT NULL COMMENT '品牌id',
  `number` int(4) unsigned NOT NULL COMMENT '产品书数量',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart-usre_id` (`user_id`),
  KEY `cart-product_id` (`product_id`),
  KEY `cart-brand_id` (`brand_id`),
  CONSTRAINT `cart-brand_id` FOREIGN KEY (`brand_id`) REFERENCES `lied_brand` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `cart-product_id` FOREIGN KEY (`product_id`) REFERENCES `lied_product` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `cart-usre_id` FOREIGN KEY (`user_id`) REFERENCES `lied_users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购物车';

-- ----------------------------
-- Records of lied_cart
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_coupons`
-- ----------------------------
DROP TABLE IF EXISTS `lied_coupons`;
CREATE TABLE `lied_coupons` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL COMMENT '优惠券名称',
  `reveive_limit` int(4) unsigned NOT NULL COMMENT '限领取数量',
  `use_start_time` datetime NOT NULL COMMENT '使用开始时间',
  `use_end_time` datetime NOT NULL COMMENT '使用结束时间',
  `receive_start_time` datetime NOT NULL COMMENT '领取开始时间',
  `receive_end_time` datetime NOT NULL COMMENT '领取结束时间',
  `thumb` int(16) unsigned NOT NULL COMMENT '缩略图',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `is_online` tinyint(1) unsigned NOT NULL COMMENT '核销方式 1-线上 0-线下',
  `is_show` tinyint(1) unsigned DEFAULT '0' COMMENT '显示 1-是 0-否',
  `sort_order` int(4) unsigned DEFAULT '0' COMMENT '排序',
  `created_id` int(16) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='优惠券基本表';

-- ----------------------------
-- Records of lied_coupons
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_coupons_batch`
-- ----------------------------
DROP TABLE IF EXISTS `lied_coupons_batch`;
CREATE TABLE `lied_coupons_batch` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL COMMENT '批次名称',
  `num` int(4) unsigned NOT NULL COMMENT '生成数量',
  `coupon_id` int(16) unsigned NOT NULL COMMENT '优惠券id',
  `coupon_limit_id` int(16) unsigned NOT NULL COMMENT '优惠券限领表id',
  `created_id` int(16) unsigned NOT NULL COMMENT '创建者id',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `coupons_batch-coupon_limit_id` (`coupon_limit_id`),
  KEY `coupons_batch-coupon_id` (`coupon_id`),
  CONSTRAINT `coupons_batch-coupon_id` FOREIGN KEY (`coupon_id`) REFERENCES `lied_coupons` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `coupons_batch-coupon_limit_id` FOREIGN KEY (`coupon_limit_id`) REFERENCES `lied_coupons_limit` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='优惠券线下券生成批次设置表';

-- ----------------------------
-- Records of lied_coupons_batch
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_coupons_discount`
-- ----------------------------
DROP TABLE IF EXISTS `lied_coupons_discount`;
CREATE TABLE `lied_coupons_discount` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_id` int(16) unsigned NOT NULL COMMENT '优惠券id',
  `discount` int(8) unsigned NOT NULL COMMENT '折扣',
  `stock_number` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '库存数量',
  `min_product_number` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '最小购买产品数量',
  `max_discount_price` decimal(8,2) unsigned DEFAULT '0.00' COMMENT '最大优惠金额',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `coupons_discount-coupon_id` (`coupon_id`),
  CONSTRAINT `coupons_discount-coupon_id` FOREIGN KEY (`coupon_id`) REFERENCES `lied_coupons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='优惠券折扣表';

-- ----------------------------
-- Records of lied_coupons_discount
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_coupons_limit`
-- ----------------------------
DROP TABLE IF EXISTS `lied_coupons_limit`;
CREATE TABLE `lied_coupons_limit` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_id` int(16) unsigned NOT NULL COMMENT '优惠券id',
  `brand_id` int(16) unsigned NOT NULL COMMENT '品牌id',
  `product_id` int(16) unsigned DEFAULT NULL COMMENT '产品id',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `coupons_limit-coupon_id` (`coupon_id`),
  CONSTRAINT `coupons_limit-coupon_id` FOREIGN KEY (`coupon_id`) REFERENCES `lied_coupons` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='优惠券限领表';

-- ----------------------------
-- Records of lied_coupons_limit
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_coupons_offline`
-- ----------------------------
DROP TABLE IF EXISTS `lied_coupons_offline`;
CREATE TABLE `lied_coupons_offline` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_batch_id` int(16) unsigned NOT NULL COMMENT '优惠券线下券生成批次设置表id',
  `code` varchar(16) NOT NULL COMMENT '券码',
  `is_use` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否使用 1-使用 0-未使用',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `coupons_offline-coupon_batch_id` (`coupon_batch_id`),
  CONSTRAINT `coupons_offline-coupon_batch_id` FOREIGN KEY (`coupon_batch_id`) REFERENCES `lied_coupons_batch` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='优惠券线下券生成码记录表';

-- ----------------------------
-- Records of lied_coupons_offline
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_coupons_price`
-- ----------------------------
DROP TABLE IF EXISTS `lied_coupons_price`;
CREATE TABLE `lied_coupons_price` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_id` int(16) unsigned NOT NULL COMMENT '优惠券id',
  `stock_number` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '库存数量',
  `price` decimal(8,2) unsigned NOT NULL COMMENT '优惠金额',
  `min_consume_price` decimal(8,2) unsigned DEFAULT '0.00' COMMENT '最低消费金额',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `coupons_price-coupon_id` (`coupon_id`),
  CONSTRAINT `coupons_price-coupon_id` FOREIGN KEY (`coupon_id`) REFERENCES `lied_coupons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='优惠券满减表';

-- ----------------------------
-- Records of lied_coupons_price
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_crontab`
-- ----------------------------
DROP TABLE IF EXISTS `lied_crontab`;
CREATE TABLE `lied_crontab`
(
  `id`         int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type`       varchar(10) COLLATE utf8mb4_unicode_ci  NOT NULL COMMENT '类型',
  `title`      varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `contents`   text COLLATE utf8mb4_unicode_ci         NOT NULL COMMENT '内容',
  `schedule`   varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Cron表达式',
  `sleep`      tinyint(4) NOT NULL DEFAULT '0' COMMENT '延迟秒数执行',
  `maximums`   int(11) NOT NULL DEFAULT '0' COMMENT '最大执行次数 0为不限',
  `executes`   int(11) DEFAULT '0' COMMENT '已经执行的次数',
  `begin_at`   datetime                                NOT NULL COMMENT '开始时间',
  `end_at`     datetime                                NOT NULL COMMENT '结束时间',
  `execute_at` datetime DEFAULT NULL COMMENT '最后执行时间',
  `weigh`      int(11) NOT NULL DEFAULT '0' COMMENT '权重',
  `status`     enum('completed','expired','disable','normal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal' COMMENT '状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lied_crontab
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_crontab_log`
-- ----------------------------
DROP TABLE IF EXISTS `lied_crontab_log`;
CREATE TABLE `lied_crontab_log`
(
  `id`         int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type`       varchar(10) COLLATE utf8mb4_unicode_ci  NOT NULL COMMENT '类型',
  `cid`        int(11) NOT NULL COMMENT '任务的ID',
  `title`      varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `remark`     mediumtext COLLATE utf8mb4_unicode_ci   NOT NULL COMMENT '备注',
  `status`     tinyint(4) NOT NULL COMMENT '状态 0:失败 1:成功',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lied_crontab_log
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_log_error`
-- ----------------------------
DROP TABLE IF EXISTS `lied_log_error`;
CREATE TABLE `lied_log_error` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `input` text NOT NULL COMMENT '请求参数',
  `ip` varchar(64) NOT NULL COMMENT '请求ip',
  `path` varchar(255) DEFAULT NULL COMMENT '请求路径',
  `method` varchar(16) DEFAULT NULL COMMENT '请求方法',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='错误日志';

-- ----------------------------
-- Records of lied_log_error
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_media`
-- ----------------------------
DROP TABLE IF EXISTS `lied_media`;
CREATE TABLE `lied_media`
(
  `id`         int(16) unsigned NOT NULL AUTO_INCREMENT,
  `type`       tinyint(1) unsigned DEFAULT '1' COMMENT '媒体类型 1-图片 2-文件 3-多媒体',
  `link`       varchar(255) DEFAULT '0',
  `size`       smallint(6) unsigned DEFAULT '0' COMMENT '文件大小 以kb为单位',
  `file_ext`   char(6)      DEFAULT '0' COMMENT '文件后缀',
  `file_name`  varchar(128) DEFAULT '0' COMMENT '文件名称',
  `is_lock`    tinyint(1) unsigned DEFAULT '0' COMMENT '是否上锁 0-否 1-是',
  `is_show`    tinyint(1) unsigned DEFAULT '1' COMMENT '显示',
  `created_at` datetime     DEFAULT NULL,
  `updated_at` datetime     DEFAULT NULL,
  `deleted_at` datetime     DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=276 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lied_media
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_migrations`
-- ----------------------------
DROP TABLE IF EXISTS `lied_migrations`;
CREATE TABLE `lied_migrations`
(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lied_migrations
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_order`
-- ----------------------------
DROP TABLE IF EXISTS `lied_order`;
CREATE TABLE `lied_order` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `temp_id` varchar(32) NOT NULL COMMENT '区别订单多商家产生的唯一标识',
  `temp_sid` varchar(32) NOT NULL COMMENT '区别订单单一商家多产品的唯一标识',
  `order_id` varchar(32) NOT NULL COMMENT '订单生成唯一编号',
  `order_num` varchar(64) DEFAULT NULL COMMENT '订单流水支付号',
  `user_id` int(16) unsigned NOT NULL,
  `order_status` tinyint(1) NOT NULL COMMENT '订单的状态;,0关闭,1正常,2完成,',
  `shipping_status` tinyint(1) NOT NULL COMMENT '商品配送情况;0未发货,1已发货,2已收货,3退货',
  `pay_status` tinyint(1) NOT NULL COMMENT '支付状态;0未付款;1已付款',
  `brand_id` int(16) unsigned NOT NULL COMMENT '商家id',
  `product_id` int(16) unsigned NOT NULL COMMENT '产品id',
  `attr_id` int(16) NOT NULL,
  `product_num` int(4) NOT NULL COMMENT '产品数量',
  `product_price` decimal(8,2) NOT NULL COMMENT '产品价格',
  `product_intergral` decimal(8,2) NOT NULL COMMENT '产品积分',
  `total_price` decimal(8,2) unsigned NOT NULL COMMENT '订单总金额',
  `total_intergral` decimal(8,2) unsigned NOT NULL COMMENT '订单总积分',
  `pay_price` decimal(8,2) NOT NULL COMMENT '已支付价格',
  `pay_intergral` decimal(8,2) NOT NULL COMMENT '已支付的积分',
  `discount_price` decimal(8,2) NOT NULL COMMENT '优惠价格',
  `shipping_fee` decimal(8,2) NOT NULL COMMENT '配送费用',
  `region_province_id` int(16) unsigned NOT NULL COMMENT '第一级省id',
  `region_city_id` int(16) unsigned NOT NULL COMMENT '第二级市id',
  `region_area_id` int(16) unsigned NOT NULL COMMENT '第三级区id',
  `address` varchar(255) NOT NULL COMMENT '收货地址',
  `mobile` varchar(32) NOT NULL COMMENT '收货人手机号',
  `postscript` varchar(255) DEFAULT NULL COMMENT '订单留言，由用户提交填写',
  `pay_id` int(16) DEFAULT NULL,
  `pay_time` datetime DEFAULT NULL,
  `to_buyer` varchar(255) DEFAULT NULL COMMENT '商家给用户留言',
  `type` varchar(16) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order-product_id` (`product_id`),
  KEY `order-user_id` (`user_id`),
  CONSTRAINT `order-product_id` FOREIGN KEY (`product_id`) REFERENCES `lied_product` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `order-user_id` FOREIGN KEY (`user_id`) REFERENCES `lied_users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lied_order
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `lied_password_resets`;
CREATE TABLE `lied_password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  KEY `lied_password_resets_email_index` (`email`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lied_password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_product`
-- ----------------------------
DROP TABLE IF EXISTS `lied_product`;
CREATE TABLE `lied_product` (
                              `id`               int(16) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品ID',
                              `name`             varchar(64)  NOT NULL DEFAULT '' COMMENT '商品名称',
                              `brand_id`         int(16) NOT NULL COMMENT '商家品牌ID',
                              `category_id`      int(16) unsigned NOT NULL COMMENT '商品类别ID',
                              `virtual_quantity` int(8) DEFAULT '0' COMMENT '虚拟购买量',
                              `line_price`       decimal(8,2) unsigned DEFAULT '0.00' COMMENT '市场价格',
                              `price`            decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '销售价格',
                              `picture`          varchar(255) NOT NULL COMMENT '图库ID',
                              `description`      text COMMENT '商品描述',
                              `content`          text COMMENT '内容',
                              `is_real`          tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否实物，1为是',
                              `is_audit`         tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核，1为审核',
                              `is_on_sale`       tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示，1为显示',
                              `created_id`       int(11) unsigned NOT NULL COMMENT '创建者id',
                              `sort_order`       int(4) unsigned DEFAULT '0' COMMENT '排序',
                              `created_at`       datetime              DEFAULT NULL,
                              `updated_at`       datetime              DEFAULT NULL,
                              `deleted_at`       datetime              DEFAULT NULL,
                              PRIMARY KEY (`id`),
                              KEY                `product-category_id` (`category_id`),
                              CONSTRAINT `product-category_id` FOREIGN KEY (`category_id`) REFERENCES `lied_product_category` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='商品基本表';

-- ----------------------------
-- Records of lied_product
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_product_attr`
-- ----------------------------
DROP TABLE IF EXISTS `lied_product_attr`;
CREATE TABLE `lied_product_attr` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL COMMENT '规格名称',
  `sort` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lied_product_attr
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_product_attr_map`
-- ----------------------------
DROP TABLE IF EXISTS `lied_product_attr_map`;
CREATE TABLE `lied_product_attr_map`
(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) unsigned NOT NULL COMMENT '产品id',
  `product_attr_id` int(11) unsigned NOT NULL COMMENT '产品规格id',
  `sort_order` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_attr_map-product_id` (`product_id`),
  KEY `product_attr_map_product_attr_id` (`product_attr_id`),
  CONSTRAINT `product_attr_map-product_id` FOREIGN KEY (`product_id`) REFERENCES `lied_product` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `product_attr_map_product_attr_id` FOREIGN KEY (`product_attr_id`) REFERENCES `lied_product_attr` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='产品与规格关系表';

-- ----------------------------
-- Records of lied_product_attr_map
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_product_attr_values`
-- ----------------------------
DROP TABLE IF EXISTS `lied_product_attr_values`;
CREATE TABLE `lied_product_attr_values`
(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_attr_id` int(11) unsigned NOT NULL COMMENT '产品规格表id',
  `name` varchar(64) NOT NULL COMMENT '规格名称',
  `sort` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_attr_values-product_attr_id` (`product_attr_id`),
  CONSTRAINT `product_attr_values-product_attr_id` FOREIGN KEY (`product_attr_id`) REFERENCES `lied_product_attr` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='产品规格值表';

-- ----------------------------
-- Records of lied_product_attr_values
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_product_attr_value_map`
-- ----------------------------
DROP TABLE IF EXISTS `lied_product_attr_value_map`;
CREATE TABLE `lied_product_attr_value_map`
(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) unsigned NOT NULL COMMENT '产品id',
  `product_attr_id` int(11) unsigned NOT NULL COMMENT '产品规格id',
  `product_attr_map_id` int(11) unsigned NOT NULL COMMENT '产品与规格关系表id',
  `product_attr_value_id` int(11) unsigned NOT NULL COMMENT '产品规格值表id',
  `sort_order` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_attr_value_map-product_id` (`product_id`),
  KEY `product_attr_value_map-product_attr_id` (`product_attr_id`),
  KEY `product_attr_value_map-product_attr_map_id` (`product_attr_map_id`),
  KEY `product_attr_value_map-product_attr_value_id` (`product_attr_value_id`),
  CONSTRAINT `product_attr_value_map-product_attr_id` FOREIGN KEY (`product_attr_id`) REFERENCES `lied_product_attr` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `product_attr_value_map-product_attr_map_id` FOREIGN KEY (`product_attr_map_id`) REFERENCES `lied_product_attr_map` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `product_attr_value_map-product_attr_value_id` FOREIGN KEY (`product_attr_value_id`) REFERENCES `lied_product_attr_values` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `product_attr_value_map-product_id` FOREIGN KEY (`product_id`) REFERENCES `lied_product` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='产品与产品规格值关系表';

-- ----------------------------
-- Records of lied_product_attr_value_map
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_product_category`
-- ----------------------------
DROP TABLE IF EXISTS `lied_product_category`;
CREATE TABLE `lied_product_category`
(
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(16) unsigned DEFAULT NULL,
  `name` varchar(64) NOT NULL COMMENT '名称',
  `sort_order` int(4) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lied_product_category
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_product_seckill`
-- ----------------------------
DROP TABLE IF EXISTS `lied_product_seckill`;
CREATE TABLE `lied_product_seckill` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(16) unsigned NOT NULL COMMENT '产品id',
  `stock_number` int(4) unsigned NOT NULL COMMENT '秒杀库存',
  `limit_user` varchar(128) DEFAULT '0' COMMENT '限定用户',
  `limit_buy_num` int(4) unsigned DEFAULT '0' COMMENT '限定用户购买次数',
  `start_time` datetime NOT NULL COMMENT '开始时间',
  `end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  `is_show` tinyint(1) NOT NULL COMMENT '是否显示 1为显示',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `seckill-product_id` (`product_id`),
  CONSTRAINT `seckill-product_id` FOREIGN KEY (`product_id`) REFERENCES `lied_product` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='秒杀产品管理';

-- ----------------------------
-- Records of lied_product_seckill
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_product_sku`
-- ----------------------------
DROP TABLE IF EXISTS `lied_product_sku`;
CREATE TABLE `lied_product_sku` (
                                  `id`         int(11) unsigned NOT NULL AUTO_INCREMENT,
                                  `product_id` int(11) unsigned NOT NULL COMMENT '产品id',
                                  `attr_key`   varchar(64) NOT NULL COMMENT '销售属性标识 - 链接，按小到大排序',
                                  `media_id`   int(11) unsigned NOT NULL COMMENT '缩略图',
                                  `price`      decimal(8,2) unsigned NOT NULL COMMENT '价格',
                                  `cost_price` decimal(8,2) unsigned NOT NULL COMMENT '成本价格',
                                  `sold_num`   int(11) unsigned NOT NULL DEFAULT '0' COMMENT '销量',
                                  `code`       varchar(64) DEFAULT '' COMMENT '编码',
                                  `created_at` datetime    DEFAULT NULL,
                                  `updated_at` datetime    DEFAULT NULL,
                                  `deleted_at` datetime    DEFAULT NULL,
                                  PRIMARY KEY (`id`),
                                  KEY          `product_sku-product_id` (`product_id`),
                                  CONSTRAINT `product_sku-product_id` FOREIGN KEY (`product_id`) REFERENCES `lied_product` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品sku表';

-- ----------------------------
-- Records of lied_product_sku
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_product_sku_stock`
-- ----------------------------
DROP TABLE IF EXISTS `lied_product_sku_stock`;
CREATE TABLE `lied_product_sku_stock` (
                                        `id`          int(11) unsigned NOT NULL AUTO_INCREMENT,
                                        `product_id`  int(11) unsigned NOT NULL COMMENT '产品id',
                                        `sku_id`      int(11) unsigned NOT NULL COMMENT '产品sku表id',
                                        `quantity`    int(11) unsigned NOT NULL COMMENT '数量',
                                        `warn_number` int(11) unsigned DEFAULT NULL COMMENT '报警数量',
                                        `created_at`  datetime DEFAULT NULL,
                                        `updated_at`  datetime DEFAULT NULL,
                                        `deleted_at`  datetime DEFAULT NULL,
                                        PRIMARY KEY (`id`),
                                        KEY           `product_sku_stock-product_id` (`product_id`),
                                        KEY           `product_sku_stock-product_sku_id` (`sku_id`),
                                        CONSTRAINT `product_sku_stock-product_id` FOREIGN KEY (`product_id`) REFERENCES `lied_product` (`id`) ON UPDATE CASCADE,
                                        CONSTRAINT `product_sku_stock-product_sku_id` FOREIGN KEY (`sku_id`) REFERENCES `lied_product_sku` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品sku库存表';

-- ----------------------------
-- Records of lied_product_sku_stock
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_regions`
-- ----------------------------
DROP TABLE IF EXISTS `lied_regions`;
CREATE TABLE `lied_regions` (
  `region_id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `region_path` varchar(20) DEFAULT NULL,
  `region_grade` mediumint(8) unsigned DEFAULT NULL,
  `region_name` varchar(50) NOT NULL,
  `sort_order` int(4) unsigned DEFAULT NULL COMMENT '排序',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`region_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3300 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of lied_regions
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_regions_open`
-- ----------------------------
DROP TABLE IF EXISTS `lied_regions_open`;
CREATE TABLE `lied_regions_open` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `region_id` int(16) unsigned NOT NULL COMMENT '开通城市regions表id',
  `is_show` tinyint(1) unsigned DEFAULT '0' COMMENT '显示',
  `sort_order` int(4) unsigned DEFAULT NULL COMMENT '排序',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='城市开通表';

-- ----------------------------
-- Records of lied_regions_open
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_users`
-- ----------------------------
DROP TABLE IF EXISTS `lied_users`;
CREATE TABLE `lied_users` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 NOT NULL COMMENT '用户名',
  `nick_name` varchar(64) CHARACTER SET utf8 DEFAULT '0' COMMENT '真实姓名',
  `mobile` char(11) CHARACTER SET utf8 NOT NULL COMMENT '手机号码',
  `email` varchar(255) CHARACTER SET utf8 DEFAULT '0' COMMENT '邮箱',
  `email_verified_at` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '邮箱验证时间',
  `password` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '密码',
  `remember_token` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '记住我的token',
  `register_ip` varchar(64) CHARACTER SET utf8 NOT NULL COMMENT '注册ip',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users-mobile` (`mobile`) USING BTREE,
  UNIQUE KEY `users-email` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of lied_users
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_users_collect`
-- ----------------------------
DROP TABLE IF EXISTS `lied_users_collect`;
CREATE TABLE `lied_users_collect` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(16) unsigned NOT NULL COMMENT '用户id',
  `type` tinyint(1) unsigned NOT NULL COMMENT '收藏类型 0-商品 1-文章 2-商家',
  `id_value` int(16) unsigned NOT NULL COMMENT '所属类型的id',
  `is_attention` tinyint(1) unsigned DEFAULT '0' COMMENT '是否关注该收藏品0-现未关注 1-已关注',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户收藏表';

-- ----------------------------
-- Records of lied_users_collect
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_users_comment`
-- ----------------------------
DROP TABLE IF EXISTS `lied_users_comment`;
CREATE TABLE `lied_users_comment` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(16) unsigned NOT NULL COMMENT '评论的父节点',
  `type` tinyint(3) unsigned NOT NULL COMMENT '类型 0-产品 1-文章',
  `id_value` int(16) unsigned NOT NULL COMMENT '所属类型表的id',
  `user_id` int(16) unsigned NOT NULL COMMENT '用户id',
  `content` text NOT NULL COMMENT '评论内容',
  `rank` tinyint(1) unsigned NOT NULL COMMENT '评论的星星数 1~5星',
  `is_show` tinyint(1) unsigned NOT NULL COMMENT '是否显示',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户评论表';

-- ----------------------------
-- Records of lied_users_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_users_coupon`
-- ----------------------------
DROP TABLE IF EXISTS `lied_users_coupon`;
CREATE TABLE `lied_users_coupon` (
  `id` int(16) unsigned NOT NULL,
  `coupon_id` int(16) unsigned NOT NULL COMMENT '优惠券id',
  `coupon_limit_id` int(16) unsigned NOT NULL COMMENT '优惠券限领取表id',
  `user_id` int(16) unsigned NOT NULL COMMENT '用户id',
  `use_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '使用时间',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_coupon-coupon_id` (`coupon_id`),
  CONSTRAINT `users_coupon-coupon_id` FOREIGN KEY (`coupon_id`) REFERENCES `lied_coupons` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户优惠券表';

-- ----------------------------
-- Records of lied_users_coupon
-- ----------------------------

-- ----------------------------
-- Table structure for `lied_users_oauth`
-- ----------------------------
DROP TABLE IF EXISTS `lied_users_oauth`;
CREATE TABLE `lied_users_oauth` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(16) unsigned DEFAULT '0',
  `unionid` varchar(128) DEFAULT '0' COMMENT '多公众号下联合id',
  `openid` varchar(128) NOT NULL COMMENT '唯一授权id',
  `sex` tinyint(1) unsigned DEFAULT '0' COMMENT '性别1-男 2-女',
  `name` varchar(64) DEFAULT '0' COMMENT '姓名',
  `thumb` int(16) unsigned DEFAULT '0' COMMENT '图片id',
  `type` tinyint(1) unsigned NOT NULL COMMENT '授权类型1-wechat',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lied_users_oauth
-- ----------------------------
