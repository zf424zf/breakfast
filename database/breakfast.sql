/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 50718
 Source Host           : 127.0.0.1
 Source Database       : breakfast

 Target Server Type    : MySQL
 Target Server Version : 50718
 File Encoding         : utf-8

 Date: 06/27/2017 00:53:55 AM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `bk_admin_menu`
-- ----------------------------
DROP TABLE IF EXISTS `bk_admin_menu`;
CREATE TABLE `bk_admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Records of `bk_admin_menu`
-- ----------------------------
BEGIN;
INSERT INTO `bk_admin_menu` VALUES ('1', '0', '1', '控制台', 'fa-bar-chart', '/', null, '2017-06-02 15:08:02'), ('2', '0', '12', '系统', 'fa-tasks', '', null, '2017-06-09 19:14:57'), ('3', '2', '15', '管理员', 'fa-users', 'auth/users', null, '2017-06-09 19:18:23'), ('4', '2', '16', '角色', 'fa-user', 'auth/roles', null, '2017-06-09 19:18:23'), ('5', '2', '17', '权限', 'fa-user', 'auth/permissions', null, '2017-06-09 19:18:23'), ('6', '2', '18', '菜单', 'fa-bars', 'auth/menu', null, '2017-06-09 19:18:23'), ('7', '2', '19', '日志', 'fa-history', 'auth/logs', null, '2017-06-09 19:18:23'), ('8', '0', '20', '助手', 'fa-gears', '', null, '2017-06-09 19:18:23'), ('9', '8', '21', 'Scaffold', 'fa-keyboard-o', 'helpers/scaffold', null, '2017-06-09 19:18:23'), ('10', '8', '22', 'Database terminal', 'fa-database', 'helpers/terminal/database', null, '2017-06-09 19:18:23'), ('11', '8', '23', 'Laravel artisan', 'fa-terminal', 'helpers/terminal/artisan', null, '2017-06-09 19:18:23'), ('12', '0', '2', '地点', 'fa-ambulance', 'metro', '2017-06-04 22:38:59', '2017-06-04 22:39:21'), ('13', '12', '3', '地铁线路', 'fa-train', 'metro', '2017-06-04 22:40:54', '2017-06-04 22:42:55'), ('14', '12', '4', '地铁站点', 'fa-bus', 'station', '2017-06-04 22:41:48', '2017-06-04 22:42:55'), ('15', '12', '5', '取餐地点', 'fa-hand-stop-o', 'place', '2017-06-04 22:42:43', '2017-06-04 22:42:55'), ('16', '0', '6', '商品', 'fa-shopping-bag', '/', '2017-06-07 18:06:06', '2017-06-07 18:06:20'), ('17', '16', '7', '商品', 'fa-shopping-bag', 'products', '2017-06-07 18:07:15', '2017-06-08 16:22:56'), ('18', '16', '8', '取货时间段', 'fa-calendar-times-o', 'pickuptime', '2017-06-07 18:08:03', '2017-06-08 16:22:56'), ('19', '0', '9', '文章', 'fa-pencil-square-o', '/', '2017-06-08 16:22:49', '2017-06-08 16:24:53'), ('20', '19', '10', '分类', 'fa-copy', 'category', '2017-06-08 16:23:50', '2017-06-08 16:24:53'), ('21', '19', '11', '内容', 'fa-list-alt', 'post', '2017-06-08 16:24:29', '2017-06-08 16:24:53'), ('22', '2', '13', '设置', 'fa-send', 'setting', '2017-06-09 11:36:30', '2017-06-09 19:14:57'), ('23', '2', '14', '用户', 'fa-users', 'users', '2017-06-09 19:18:10', '2017-06-09 19:18:23');
COMMIT;

-- ----------------------------
--  Table structure for `bk_admin_operation_log`
-- ----------------------------
DROP TABLE IF EXISTS `bk_admin_operation_log`;
CREATE TABLE `bk_admin_operation_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_operation_log_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Records of `bk_admin_operation_log`
-- ----------------------------
BEGIN;
INSERT INTO `bk_admin_operation_log` VALUES ('1', '2', 'admin/products', 'GET', '127.0.0.1', '[]', '2017-06-27 00:53:43', '2017-06-27 00:53:43'), ('2', '2', 'admin/products', 'GET', '127.0.0.1', '[]', '2017-06-27 00:53:44', '2017-06-27 00:53:44'), ('3', '2', 'admin/metro', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2017-06-27 00:53:46', '2017-06-27 00:53:46');
COMMIT;

-- ----------------------------
--  Table structure for `bk_admin_permissions`
-- ----------------------------
DROP TABLE IF EXISTS `bk_admin_permissions`;
CREATE TABLE `bk_admin_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_permissions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `bk_admin_role_menu`
-- ----------------------------
DROP TABLE IF EXISTS `bk_admin_role_menu`;
CREATE TABLE `bk_admin_role_menu` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_menu_role_id_menu_id_index` (`role_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Records of `bk_admin_role_menu`
-- ----------------------------
BEGIN;
INSERT INTO `bk_admin_role_menu` VALUES ('1', '2', null, null), ('1', '8', null, null), ('1', '9', null, null), ('1', '3', null, null), ('1', '1', null, null), ('2', '1', null, null), ('1', '12', null, null), ('2', '12', null, null), ('1', '14', null, null), ('2', '14', null, null), ('1', '13', null, null), ('2', '13', null, null), ('1', '15', null, null), ('2', '15', null, null), ('1', '16', null, null), ('2', '16', null, null), ('1', '17', null, null), ('2', '17', null, null), ('1', '19', null, null), ('2', '19', null, null), ('1', '20', null, null), ('2', '20', null, null), ('1', '21', null, null), ('2', '21', null, null), ('1', '22', null, null), ('2', '22', null, null), ('2', '2', null, null), ('1', '7', null, null), ('1', '6', null, null), ('1', '5', null, null), ('1', '4', null, null), ('1', '23', null, null), ('2', '23', null, null);
COMMIT;

-- ----------------------------
--  Table structure for `bk_admin_role_permissions`
-- ----------------------------
DROP TABLE IF EXISTS `bk_admin_role_permissions`;
CREATE TABLE `bk_admin_role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_permissions_role_id_permission_id_index` (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `bk_admin_role_users`
-- ----------------------------
DROP TABLE IF EXISTS `bk_admin_role_users`;
CREATE TABLE `bk_admin_role_users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_users_role_id_user_id_index` (`role_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Records of `bk_admin_role_users`
-- ----------------------------
BEGIN;
INSERT INTO `bk_admin_role_users` VALUES ('1', '2', null, null), ('2', '1', null, null);
COMMIT;

-- ----------------------------
--  Table structure for `bk_admin_roles`
-- ----------------------------
DROP TABLE IF EXISTS `bk_admin_roles`;
CREATE TABLE `bk_admin_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Records of `bk_admin_roles`
-- ----------------------------
BEGIN;
INSERT INTO `bk_admin_roles` VALUES ('1', 'Administrator', 'administrator', '2017-06-02 15:03:05', '2017-06-02 15:03:05'), ('2', 'admin', 'admin', '2017-06-03 15:39:33', '2017-06-03 15:39:33');
COMMIT;

-- ----------------------------
--  Table structure for `bk_admin_user_permissions`
-- ----------------------------
DROP TABLE IF EXISTS `bk_admin_user_permissions`;
CREATE TABLE `bk_admin_user_permissions` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_user_permissions_user_id_permission_id_index` (`user_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `bk_admin_users`
-- ----------------------------
DROP TABLE IF EXISTS `bk_admin_users`;
CREATE TABLE `bk_admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Records of `bk_admin_users`
-- ----------------------------
BEGIN;
INSERT INTO `bk_admin_users` VALUES ('1', 'admin', '$2y$10$f45DlOUN.DXS9tXw67t3nO9qLk6B2y7Dd.bD0u26X3ScBuzY0qKI.', 'Administrator', null, 'C6jvtRLFkgwlSYhrO0fWoatoPKHa9cOqrA24lDa9bs3HJsRQgX84VNKhpr67', '2017-06-02 15:03:05', '2017-06-02 15:03:05'), ('2', 'skiden', '$2y$10$V2un8iVmNd9z9QKx9JCvl.S52lzg9AxYF/owa.UttwFQqp9dk9OZa', 'skiden', null, 'tpZh46Kk6KkEboPBqymnqQzjhUSZog1RlXm18J4A82P6wcXYIaS4aopGQe3Y', '2017-06-03 15:40:32', '2017-06-03 15:40:32');
COMMIT;

-- ----------------------------
--  Table structure for `bk_category`
-- ----------------------------
DROP TABLE IF EXISTS `bk_category`;
CREATE TABLE `bk_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='文章分类表';

-- ----------------------------
--  Records of `bk_category`
-- ----------------------------
BEGIN;
INSERT INTO `bk_category` VALUES ('2', '首页资讯', '1496911990', '1497145113');
COMMIT;

-- ----------------------------
--  Table structure for `bk_coupon_card`
-- ----------------------------
DROP TABLE IF EXISTS `bk_coupon_card`;
CREATE TABLE `bk_coupon_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0' COMMENT '优惠券所属用户',
  `name` varchar(255) NOT NULL COMMENT '优惠券名称',
  `amount` decimal(8,2) NOT NULL COMMENT '优惠金额',
  `expire` int(10) DEFAULT NULL COMMENT '过期时间',
  `status` varchar(255) NOT NULL DEFAULT '0' COMMENT '状态 0 未使用 1 已使用',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Records of `bk_coupon_card`
-- ----------------------------
BEGIN;
INSERT INTO `bk_coupon_card` VALUES ('1', '1', '新用户优惠', '5.00', '1498924800', '0', '1498404531', '1498404531'), ('2', '7', '新用户优惠', '5.00', '1498924800', '1', '1498404909', '1498405312'), ('3', '7', '新用户优惠', '2.00', '1498924800', '0', '1498404909', '1498404909');
COMMIT;

-- ----------------------------
--  Table structure for `bk_metro`
-- ----------------------------
DROP TABLE IF EXISTS `bk_metro`;
CREATE TABLE `bk_metro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) DEFAULT '0' COMMENT '城市ID',
  `name` varchar(255) DEFAULT NULL COMMENT '线路名称',
  `created_at` int(10) NOT NULL,
  `updated_at` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='地铁线路';

-- ----------------------------
--  Records of `bk_metro`
-- ----------------------------
BEGIN;
INSERT INTO `bk_metro` VALUES ('5', '0', '1号线', '1496806727', '1496806727'), ('6', '0', '2号线', '1496806733', '1496806733'), ('7', '0', '3号线', '1496806740', '1496806740');
COMMIT;

-- ----------------------------
--  Table structure for `bk_metro_place`
-- ----------------------------
DROP TABLE IF EXISTS `bk_metro_place`;
CREATE TABLE `bk_metro_place` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COMMENT='取货地点表';

-- ----------------------------
--  Records of `bk_metro_place`
-- ----------------------------
BEGIN;
INSERT INTO `bk_metro_place` VALUES ('7', '中央商场', '32.02363182147064', '118.78338575363159', '大洋负一楼110', '1496807461', '1497174379'), ('8', '大洋百货', '32.041095', '118.783246', '石鼓路南100米', '1496808077', '1496819465');
COMMIT;

-- ----------------------------
--  Table structure for `bk_metro_place_pickuptime`
-- ----------------------------
DROP TABLE IF EXISTS `bk_metro_place_pickuptime`;
CREATE TABLE `bk_metro_place_pickuptime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pickuptime_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `station_id` (`pickuptime_id`),
  KEY `place_id` (`place_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COMMENT='取货地点地铁站关联关系';

-- ----------------------------
--  Records of `bk_metro_place_pickuptime`
-- ----------------------------
BEGIN;
INSERT INTO `bk_metro_place_pickuptime` VALUES ('15', '1', '8'), ('17', '1', '7'), ('18', '2', '7');
COMMIT;

-- ----------------------------
--  Table structure for `bk_metro_place_relation`
-- ----------------------------
DROP TABLE IF EXISTS `bk_metro_place_relation`;
CREATE TABLE `bk_metro_place_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `station_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `station_id` (`station_id`),
  KEY `place_id` (`place_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COMMENT='取货地点地铁站关联关系';

-- ----------------------------
--  Records of `bk_metro_place_relation`
-- ----------------------------
BEGIN;
INSERT INTO `bk_metro_place_relation` VALUES ('10', '6', '7'), ('12', '7', '7'), ('13', '6', '8');
COMMIT;

-- ----------------------------
--  Table structure for `bk_metro_station`
-- ----------------------------
DROP TABLE IF EXISTS `bk_metro_station`;
CREATE TABLE `bk_metro_station` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='地铁站';

-- ----------------------------
--  Records of `bk_metro_station`
-- ----------------------------
BEGIN;
INSERT INTO `bk_metro_station` VALUES ('6', '新街口', '1496806753', '1496934970'), ('7', '大行宫', '1496806761', '1496806761');
COMMIT;

-- ----------------------------
--  Table structure for `bk_metro_station_relation`
-- ----------------------------
DROP TABLE IF EXISTS `bk_metro_station_relation`;
CREATE TABLE `bk_metro_station_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `metro_id` int(255) NOT NULL,
  `station_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `metro_id` (`metro_id`),
  KEY `station_id` (`station_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COMMENT='地铁站线路关联表';

-- ----------------------------
--  Records of `bk_metro_station_relation`
-- ----------------------------
BEGIN;
INSERT INTO `bk_metro_station_relation` VALUES ('15', '5', '6'), ('16', '6', '6'), ('17', '6', '7'), ('18', '7', '7');
COMMIT;

-- ----------------------------
--  Table structure for `bk_migrations`
-- ----------------------------
DROP TABLE IF EXISTS `bk_migrations`;
CREATE TABLE `bk_migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Records of `bk_migrations`
-- ----------------------------
BEGIN;
INSERT INTO `bk_migrations` VALUES ('1', '2016_01_04_173148_create_admin_tables', '1');
COMMIT;

-- ----------------------------
--  Table structure for `bk_orders`
-- ----------------------------
DROP TABLE IF EXISTS `bk_orders`;
CREATE TABLE `bk_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `order_id` char(30) NOT NULL,
  `date` char(10) NOT NULL,
  `place_id` int(11) NOT NULL,
  `pickuptime_id` tinyint(4) NOT NULL COMMENT '取餐时间段',
  `amount` decimal(8,2) NOT NULL,
  `pay_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '支付方式,当前只有微信公众号支付',
  `pay_time` int(11) NOT NULL DEFAULT '0' COMMENT '支付时间',
  `pay_flow` varchar(50) NOT NULL DEFAULT '0' COMMENT '支付流水号',
  `phone` varchar(255) DEFAULT NULL COMMENT '订单联系电话',
  `name` varchar(255) DEFAULT NULL COMMENT '订单联系人',
  `company` varchar(255) DEFAULT NULL COMMENT '所在公司',
  `status` varchar(255) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Records of `bk_orders`
-- ----------------------------
BEGIN;
INSERT INTO `bk_orders` VALUES ('7', '7', '0627595134f1cc2ba1836', '20170627', '7', '2', '12.00', '1', '0', '0', '13800138000', 'skiden', 'aaa', '0', '1498494193', '1498494193'), ('8', '7', '0627595134f1cf03d6886', '20170628', '7', '1', '32.00', '1', '0', '0', '13800138000', 'skiden', 'aaa', '0', '1498494193', '1498494193'), ('9', '7', '0627595134f1d377a3089', '20170628', '7', '2', '6.00', '1', '0', '0', '13800138000', 'skiden', 'aaa', '0', '1498494193', '1498494193');
COMMIT;

-- ----------------------------
--  Table structure for `bk_orders_log`
-- ----------------------------
DROP TABLE IF EXISTS `bk_orders_log`;
CREATE TABLE `bk_orders_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL COMMENT '操作人',
  `order_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '订单号',
  `behavior` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '行为',
  `log_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '日志内容',
  `remark` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '备注',
  `created_at` int(10) NOT NULL COMMENT '添加时间',
  `updated_at` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='订单日志表';

-- ----------------------------
--  Records of `bk_orders_log`
-- ----------------------------
BEGIN;
INSERT INTO `bk_orders_log` VALUES ('1', '7', '06275951323871ee82923', 'CREATE', '订单创建', '', '1498493496', '1498493496'), ('2', '7', '062759513238754609828', 'CREATE', '订单创建', '', '1498493496', '1498493496'), ('3', '7', '062759513238789965630', 'CREATE', '订单创建', '', '1498493496', '1498493496'), ('4', '7', '062759513387296cb3498', 'CREATE', '订单创建', '', '1498493831', '1498493831'), ('5', '7', '0627595133872cde86731', 'CREATE', '订单创建', '', '1498493831', '1498493831'), ('6', '7', '062759513387306431183', 'CREATE', '订单创建', '', '1498493831', '1498493831'), ('7', '7', '0627595134f1cc2ba1836', 'CREATE', '订单创建', '', '1498494193', '1498494193'), ('8', '7', '0627595134f1cf03d6886', 'CREATE', '订单创建', '', '1498494193', '1498494193'), ('9', '7', '0627595134f1d377a3089', 'CREATE', '订单创建', '', '1498494193', '1498494193');
COMMIT;

-- ----------------------------
--  Table structure for `bk_orders_pay`
-- ----------------------------
DROP TABLE IF EXISTS `bk_orders_pay`;
CREATE TABLE `bk_orders_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flow_id` varchar(50) NOT NULL COMMENT '支付流水',
  `uid` int(11) NOT NULL,
  `order_ids` text NOT NULL,
  `amount` varchar(255) NOT NULL COMMENT '实际支付金额(不包含优惠券金额)',
  `status` varchar(255) NOT NULL DEFAULT '0' COMMENT '支付流水状态 0 待支付 1 已支付',
  `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联的优惠券ID',
  `created_at` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `bk_orders_products`
-- ----------------------------
DROP TABLE IF EXISTS `bk_orders_products`;
CREATE TABLE `bk_orders_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `order_id` char(30) NOT NULL,
  `date` char(10) NOT NULL,
  `place_id` int(11) NOT NULL,
  `pickuptime_id` int(11) NOT NULL COMMENT '取餐时间ID',
  `product_id` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL COMMENT '单价',
  `count` int(11) NOT NULL COMMENT '购买数量',
  `amount` decimal(8,2) NOT NULL COMMENT '金额',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `date` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Records of `bk_orders_products`
-- ----------------------------
BEGIN;
INSERT INTO `bk_orders_products` VALUES ('11', '7', '0627595134f1cc2ba1836', '20170627', '7', '2', '5', '4.00', '3', '12.00', '0', '1498494193', '1498494193'), ('12', '7', '0627595134f1cf03d6886', '20170628', '7', '1', '6', '1.00', '2', '2.00', '0', '1498494193', '1498494193'), ('13', '7', '0627595134f1cf03d6886', '20170628', '7', '1', '5', '3.00', '2', '6.00', '0', '1498494193', '1498494193'), ('14', '7', '0627595134f1cf03d6886', '20170628', '7', '1', '4', '8.00', '3', '24.00', '0', '1498494193', '1498494193'), ('15', '7', '0627595134f1d377a3089', '20170628', '7', '2', '5', '3.00', '2', '6.00', '0', '1498494193', '1498494193');
COMMIT;

-- ----------------------------
--  Table structure for `bk_pickup_time`
-- ----------------------------
DROP TABLE IF EXISTS `bk_pickup_time`;
CREATE TABLE `bk_pickup_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start` varchar(10) DEFAULT NULL,
  `end` varchar(10) DEFAULT NULL,
  `purchase_stop` varchar(10) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='取货时间段表';

-- ----------------------------
--  Records of `bk_pickup_time`
-- ----------------------------
BEGIN;
INSERT INTO `bk_pickup_time` VALUES ('1', '07:30', '09:30', '12', '1496831108', '1498400583'), ('2', '16:00', '17:30', '3', '1498317244', '1498399738');
COMMIT;

-- ----------------------------
--  Table structure for `bk_posts`
-- ----------------------------
DROP TABLE IF EXISTS `bk_posts`;
CREATE TABLE `bk_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `summary` varchar(1024) DEFAULT NULL,
  `content` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Records of `bk_posts`
-- ----------------------------
BEGIN;
INSERT INTO `bk_posts` VALUES ('1', 'Eloquent 假设外键应该在父级上有一个与之', '2', 'image/bizhi-1659-15672.jpg', '此外，Eloquent 假设外键应该在父级上有一个与之匹配的id（或者自定义 $primaryKey），换句话说，Eloquent 将会通过 user 表的 id 值去 phone 表中查询 user_id 与之匹配的 Phone 记录。如果你想要关联关系使用其他值而不是 id，可以传递第三个参数到hasOne 来指定自定义的主键：\r\n\r\nreturn $this->hasOne(\'App\\Phone\', \'foreign_key\', \'local_key\');', '<p>此外，Eloquent 假设外键应该在父级上有一个与之匹配的<code>id</code>（或者自定义&nbsp;<code>$primaryKey</code>），换句话说，Eloquent 将会通过&nbsp;<code>user</code>&nbsp;表的&nbsp;<code>id</code>&nbsp;值去&nbsp;<code>phone</code>&nbsp;表中查询&nbsp;<code>user_id</code>&nbsp;与之匹配的&nbsp;<code>Phone</code>&nbsp;记录。如果你想要关联关系使用其他值而不是&nbsp;<code>id</code>，可以传递第三个参数到<code>hasOne</code>&nbsp;来指定自定义的主键：</p>\r\n\r\n<pre>\r\n<code>return $this-&gt;hasOne(&#39;App\\Phone&#39;, &#39;foreign_key&#39;, &#39;local_key&#39;);</code></pre>', '1496912351', '1497147214'), ('2', '楼市大消息！全国已有20家银行停止房贷', '2', 'image/59014a4eaca10.jpg', '目前，全国533家银行中有20家银行已经停贷，未来时间会有新增银行暂停房贷业务。但是在政策框架内，不会出现过大面积停贷，影响到房贷市场的正常秩序。对购房者来说并非利好，可能增加购房者贷款难度。', '<p>目前，全国533家银行中有20家银行已经停贷，未来时间会有新增银行暂停<strong><a href=\"http://news.china.com/baike_5oi_6LS3.html\" target=\"_blank\">房贷</a></strong>业务。但是在政策框架内，不会出现过大面积停贷，影响到房贷市场的正常秩序。对购房者来说并非利好，可能增加购房者贷款难度。</p>\r\n\r\n<p>近来，北上广深等一线城市纷纷上调首套房房贷利率，而且也有二、三线城市不断跟进。</p>', '1497147576', '1497147622'), ('3', '兑现“万亿”承诺是总理给市场的最好预期', '2', 'image/4.jpg', '改革开放初期风起云涌的个体户经济，人有多少、钱有多少，不是没有统计，但恐怕除了专业研究者很少有人还记得住具体数字。然而很多人却直到今天仍能记得住“傻子瓜子”。这个故事鲜明地印在过来人的脑中，鲜活地体现了市场活力与政策取向之间的关联。', '<p>要记住数字总是不太容易的，就像要记住鲜活的故事总是不太难的。</p>\r\n\r\n<p>改革开放初期风起云涌的个体户经济，人有多少、钱有多少，不是没有统计，但恐怕除了专业研究者很少有人还记得住具体数字。然而很多人却直到今天仍能记得住&ldquo;傻子瓜子&rdquo;。这个故事鲜明地印在过来人的脑中，鲜活地体现了市场活力与政策取向之间的关联。</p>\r\n\r\n<p>良政激发活力的一个最新版本，便是国务院自去年起大力实施的减税降费举措。今年&ldquo;两会&rdquo;记者会上，李克强总理掷地有声承诺：全年为企业减税降费力争达到1万亿元。</p>\r\n\r\n<p>据媒体梳理，其后短短3个月，李克强连续5次部署减税降费工作。6月7日的国务院常务会议上，确定在今年已出台4批政策减税降费7180亿元的基础上，从今年7月1日起，再推出一批新的降费措施，预计每年可再减轻企业负担2830亿元，合计全年为企业减负超过1万亿元。</p>\r\n\r\n<p>言必行、行必果。这就是给市场最好的预期。正如当年，邓公一句&ldquo;如果你一动，群众就说政策变了，人心就不安了&rdquo;，救活的不仅是一个&ldquo;傻子瓜子&rdquo;，稳定的更是整个市场和社会对国家发展大方向的预期。</p>\r\n\r\n<p>如果说当年更多是在思想上&ldquo;减压&rdquo;，那么在社会主义市场经济已初步建立、十八届三中全会进一步提出&ldquo;使市场在资源配置中起决定性作用和更好地发挥政府作用&rdquo;后，今天的命题则更多体现在真金白银上&ldquo;减负&rdquo;。</p>\r\n\r\n<p>李克强曾经明确点题：减税降费本身就是积极的财政政策。这阐明了为企业减负的政治经济学新的内涵。在当前全球日趋激烈的竞争中，中国经济要立于不败之地，政府的作用就是应该如是&ldquo;更好地发挥&rdquo;。</p>\r\n\r\n<p>要做好为企业减负这篇大文章，除了国务院常务会接连5个&ldquo;排比句&rdquo;外，还需要把行文&ldquo;规矩&rdquo;固定下来。因此6月7日的常务会决定，国务院主管部门要在7月1日前上网公布中央和地方政府性基金及行政事业性收费目录清单，实现全国&ldquo;一张网&rdquo;动态化管理，从源头上防范乱收费，决不让已&ldquo;瘦身&rdquo;的制度性交易成本反弹。</p>\r\n\r\n<p>这实际上对市场给出了最稳定的预期：不仅要兑现1万亿承诺，更要使减税降费变成制度安排。用总理的话说就是，给企业减负决不搞&ldquo;弯弯绕&rdquo;。</p>\r\n\r\n<p>市场的神奇之处就在于，只要有了好的预期，活力自然就会竞相迸发，&ldquo;好故事&rdquo;就会层出不穷地上演。</p>\r\n\r\n<p>一个饶有意味的巧合是，当年得改革风气之先的&ldquo;傻子瓜子&rdquo;出现在安徽，而今，同样在安徽横空出世一家全国销售规模最大的食品电商企业&ldquo;三只松鼠&rdquo;。同样是坚果炒货起家，三四年间便做得风生水起，成就了业界竞相研究的创新案例和社会竞相传播的创业故事。</p>\r\n\r\n<p>聚焦之处，当然正在于这一波创业创新潮的背景：&ldquo;互联网+&rdquo;这一&ldquo;加&rdquo;和减税降费这一&ldquo;减&rdquo;。</p>', '1497147693', '1497147693'), ('4', '多地暴雨启动应急响应 江南等地仍有强降雨', '2', 'image/139-150604162F5.jpg', '昨日白天，安徽江苏等地出现强降雨。安徽中北部、江苏中南部、湖北西南部等地出现大到暴雨，安徽淮南和滁州、江苏沿江一带出现大暴雨，最大小时雨强有60～88毫米。', '<p>昨日白天，安徽江苏等地出现强降雨。安徽中北部、江苏中南部、湖北西南部等地出现大到暴雨，安徽淮南和滁州、江苏沿江一带出现大暴雨，最大小时雨强有60～88毫米。</p>\r\n\r\n<p>据中央气象台10日18时发布的天气公报，江南北部等地有较强降雨，华北黄淮等地多阵雨或雷阵雨。</p>\r\n\r\n<p>据预报，受低涡切变线影响，10日夜间至12日，江南北部等地有较强降雨。预计，10日20时至11日20时，湖南中北部、贵州西南部和东南部、湖北东南部、江西北部、安徽南部、浙江中北部、云南西部等地有大到暴雨，其中，湖南中部局地有大暴雨；上述部分地区并伴有短时强降水、雷暴大风等强对流天气，最大小时雨强可达30～50毫米，局地超过70毫米。为此，中央气象台发布了暴雨蓝色预警。</p>\r\n\r\n<p>此外，预计10日夜间至13日，内蒙古中部及华北、黄淮北部等地多阵雨或雷阵雨天气，其中，河北东部、山西东北部、天津、山东西北部等地的部分地区有中雨或大雨，河北东部和山东西北部局地有暴雨；上述部分地区并伴有雷雨大风或局地冰雹天气，河北东部、山东北部局地最大小时雨强有20～40毫米。</p>', '1497147737', '1497147737'), ('5', '省会城市的房产是否会迎来大涨？', '2', 'image/54bcc5a17a4f9e73a60254ff6c4c113a.jpg', '根据统计局数据，北京的二手住房价格两月前已停涨，二手房成交量创下2015年2月以来的最低。上海的二手房成交量也是处于下跌势头，上个月同比下跌23.5%，已经十分接近于2012年的楼市低谷期。并且，从一线城市的存量房分布来看，越是地处郊区的二手房，交易量价下跌越快。而深圳的房价预计在2017年下降16%，成交量下跌10%。', '<p><strong>关于房价是涨是跌的问题，最近又有新的争论</strong>。清华大学金融研究院的副院长朱宁提出一个说法是一线城市房价还要涨50%，无独有偶，因为唱多茅台股票而颇受关注的投资人但斌也认为手里的优置房产千万不能卖。</p>\r\n\r\n<p>不过，现实中的一线房价似乎依然低迷。对于之前没有购买北上深房产的人来说，目前既要面对高资金门槛，也要面对严格的限购政策。并且一线的不动产一旦脱手，很可能再也买不回来。这导致了一线城市的不动产成交量普遍下跌。</p>\r\n\r\n<p>根据统计局数据，北京的二手住房价格两月前已停涨，二手房成交量创下2015年2月以来的最低。上海的二手房成交量也是处于下跌势头，上个月同比下跌23.5%，已经十分接近于2012年的楼市低谷期。并且，从一线城市的存量房分布来看，越是地处郊区的二手房，交易量价下跌越快。而深圳的房价预计在2017年下降16%，成交量下跌10%。</p>\r\n\r\n<p>再来看一线城市以外。房产限购政策在40多个城市大面积铺开，冻结了大量购买力和流动性。由于房贷紧缩趋势明显，银行对楼市变相&ldquo;加息&rdquo;，削弱了量价上攻的动力。根据广发证券监测，5月份43个代表城市新房成交面积环比和同比分别下降2.3%和20.4%。</p>\r\n\r\n<p>如此看来，房价继续暴涨的说法根本就不能成立。<strong>限购限卖令之下，目前的房地产市场呈现一种胶着状态，想投资的人没办法投资，有房产的人按兵不动，暂时不急着套现</strong>。因此，我们看到了市场上暂时的冷清。</p>', '1497148137', '1497148137');
COMMIT;

-- ----------------------------
--  Table structure for `bk_products`
-- ----------------------------
DROP TABLE IF EXISTS `bk_products`;
CREATE TABLE `bk_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `material` varchar(255) DEFAULT NULL COMMENT '食材',
  `calori` varchar(255) DEFAULT NULL COMMENT '卡路里',
  `recommend` varchar(255) DEFAULT NULL COMMENT '推荐指数',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 可用 1下架 ',
  `origin_price` decimal(8,2) NOT NULL COMMENT '原价',
  `coupon_price` decimal(8,2) DEFAULT NULL,
  `early_price` decimal(8,2) DEFAULT NULL COMMENT ' 早鸟优惠价',
  `early_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COMMENT='商品表';

-- ----------------------------
--  Records of `bk_products`
-- ----------------------------
BEGIN;
INSERT INTO `bk_products` VALUES ('3', '包子', 'image/ntk-1930-33843.jpg', '9999', 'xxxx', '300', '5', '1496851266', '1498317381', '1', '0.03', '0.02', '0.01', '1.5'), ('4', '豆浆', 'image/bg_index.jpg', '9999', '大豆', '200', '5', '1498096231', '1498236297', '1', '2.00', '1.00', '8.00', null), ('5', '手抓饼', 'image/21422793_144600530000_2.jpg', '888', '休息休息', '100', '5', '1498096291', '1498485872', '1', '5.00', '4.00', '3.00', '24'), ('6', '煎饼', 'image/d6ce65aeca28a47ec4610e7cfa280a4b.jpeg', '9999', '大豆', '900', '4', '1498096339', '1498228463', '1', '10.00', '2.00', '1.00', null);
COMMIT;

-- ----------------------------
--  Table structure for `bk_products_pickup_time`
-- ----------------------------
DROP TABLE IF EXISTS `bk_products_pickup_time`;
CREATE TABLE `bk_products_pickup_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `pickuptime_id` int(11) NOT NULL COMMENT '销售时间 0-6 (周日-周六)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COMMENT='商品销售取餐点';

-- ----------------------------
--  Records of `bk_products_pickup_time`
-- ----------------------------
BEGIN;
INSERT INTO `bk_products_pickup_time` VALUES ('3', '5', '1'), ('4', '6', '1'), ('5', '4', '1'), ('7', '3', '1'), ('8', '5', '2');
COMMIT;

-- ----------------------------
--  Table structure for `bk_products_place`
-- ----------------------------
DROP TABLE IF EXISTS `bk_products_place`;
CREATE TABLE `bk_products_place` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL COMMENT '销售时间 0-6 (周日-周六)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COMMENT='商品销售取餐点';

-- ----------------------------
--  Records of `bk_products_place`
-- ----------------------------
BEGIN;
INSERT INTO `bk_products_place` VALUES ('1', '3', '7'), ('2', '3', '8'), ('3', '4', '7'), ('4', '4', '8'), ('6', '5', '8'), ('7', '6', '7'), ('8', '6', '8'), ('10', '5', '7');
COMMIT;

-- ----------------------------
--  Table structure for `bk_products_saleday`
-- ----------------------------
DROP TABLE IF EXISTS `bk_products_saleday`;
CREATE TABLE `bk_products_saleday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `saleday` tinyint(4) NOT NULL COMMENT '销售时间 0-6 (周日-周六)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COMMENT='商品销售时间';

-- ----------------------------
--  Records of `bk_products_saleday`
-- ----------------------------
BEGIN;
INSERT INTO `bk_products_saleday` VALUES ('10', '3', '1'), ('11', '3', '2'), ('12', '3', '3'), ('13', '3', '4'), ('14', '3', '5'), ('15', '3', '6'), ('16', '3', '7'), ('17', '4', '1'), ('18', '4', '2'), ('19', '4', '3'), ('20', '4', '4'), ('21', '4', '5'), ('22', '4', '6'), ('23', '4', '7'), ('24', '5', '1'), ('25', '5', '2'), ('26', '5', '3'), ('27', '5', '4'), ('28', '5', '5'), ('29', '5', '6'), ('30', '5', '7'), ('31', '6', '1'), ('32', '6', '2'), ('33', '6', '3'), ('34', '6', '4'), ('35', '6', '5'), ('36', '6', '6');
COMMIT;

-- ----------------------------
--  Table structure for `bk_saleday`
-- ----------------------------
DROP TABLE IF EXISTS `bk_saleday`;
CREATE TABLE `bk_saleday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `weekday` tinyint(4) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='销售日期表,商品在周几可销售';

-- ----------------------------
--  Records of `bk_saleday`
-- ----------------------------
BEGIN;
INSERT INTO `bk_saleday` VALUES ('1', '周日', '1', null, null), ('2', '周一', '2', null, null), ('3', '周二', '3', null, null), ('4', '周三', '4', null, null), ('5', '周四', '5', null, null), ('6', '周五', '6', null, null), ('7', '周六', '7', null, null);
COMMIT;

-- ----------------------------
--  Table structure for `bk_settings`
-- ----------------------------
DROP TABLE IF EXISTS `bk_settings`;
CREATE TABLE `bk_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` mediumtext,
  `description` varchar(255) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='系统设置表';

-- ----------------------------
--  Records of `bk_settings`
-- ----------------------------
BEGIN;
INSERT INTO `bk_settings` VALUES ('3', 'test', 'ok', '测试配置', '1496979596', '1496979639'), ('4', 'order_expire_time', '30', '订单过期时间,单位:分钟', '1496979620', '1496979620'), ('5', 'new_user_coupon', '5', '新用户优惠券金额', '1497004975', '1497004975'), ('6', 'title', '一起吃早餐', '网站标题', '1497083891', '1497083891'), ('7', 'stop_refund_hour', '12', '取货之前多少小时禁止退款', '1498410164', '1498410164');
COMMIT;

-- ----------------------------
--  Table structure for `bk_users`
-- ----------------------------
DROP TABLE IF EXISTS `bk_users`;
CREATE TABLE `bk_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` char(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile` mediumtext COLLATE utf8mb4_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户表';

-- ----------------------------
--  Records of `bk_users`
-- ----------------------------
BEGIN;
INSERT INTO `bk_users` VALUES ('7', 'o3-UIwDbB0cWKNAdV51mcm5b6Zf8', 'Skiden', null, null, null, '{\"openid\":\"o3-UIwDbB0cWKNAdV51mcm5b6Zf8\",\"nickname\":\"Skiden\",\"sex\":1,\"language\":\"zh_CN\",\"city\":\"\\u5357\\u4eac\",\"province\":\"\\u6c5f\\u82cf\",\"country\":\"\\u4e2d\\u56fd\",\"headimgurl\":\"http:\\/\\/wx.qlogo.cn\\/mmopen\\/ajNVdqHZLLA3JS8ob7a7LEc4ibcnjnpBnuB2biaHTaro00ia3RFUVL5Hibr3riaaVea3WzS7IegHZPkLV2olFtQ4eicA\\/0\",\"privilege\":[]}', '1498404909', '1498404909');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
