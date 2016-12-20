/*
Navicat MySQL Data Transfer

Source Server         : localhost【3306】
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : yii2cms

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2016-12-20 11:27:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `yii2_auth_assignment`
-- ----------------------------
DROP TABLE IF EXISTS `yii2_auth_assignment`;
CREATE TABLE `yii2_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '角色',
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户Id',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `yii2_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `yii2_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='角色表';

-- ----------------------------
-- Records of yii2_auth_assignment
-- ----------------------------

-- ----------------------------
-- Table structure for `yii2_auth_item`
-- ----------------------------
DROP TABLE IF EXISTS `yii2_auth_item`;
CREATE TABLE `yii2_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '权限名称',
  `type` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '权限类型',
  `description` text COLLATE utf8_unicode_ci NOT NULL COMMENT '权限描述',
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '规则名称',
  `data` text COLLATE utf8_unicode_ci NOT NULL COMMENT '权限明细',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `yii2_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `yii2_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='权限表';

-- ----------------------------
-- Records of yii2_auth_item
-- ----------------------------

-- ----------------------------
-- Table structure for `yii2_auth_item_child`
-- ----------------------------
DROP TABLE IF EXISTS `yii2_auth_item_child`;
CREATE TABLE `yii2_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '父级权限',
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '子权限',
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `yii2_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `yii2_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yii2_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `yii2_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='权限层级关系表';

-- ----------------------------
-- Records of yii2_auth_item_child
-- ----------------------------

-- ----------------------------
-- Table structure for `yii2_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `yii2_auth_rule`;
CREATE TABLE `yii2_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '规则名称',
  `data` text COLLATE utf8_unicode_ci NOT NULL COMMENT '规则数据',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='权限规则表';

-- ----------------------------
-- Records of yii2_auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for `yii2_category`
-- ----------------------------
DROP TABLE IF EXISTS `yii2_category`;
CREATE TABLE `yii2_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级分类',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '分类状态 1 - 正常 2-已删除',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='分类管理表';

-- ----------------------------
-- Records of yii2_category
-- ----------------------------
INSERT INTO `yii2_category` VALUES ('1', '0', '1', 'App', '0', '1', '1472546664', '1472546664');
INSERT INTO `yii2_category` VALUES ('2', '0', '1', 'PC', '0', '1', '1473131623', '1473131623');
INSERT INTO `yii2_category` VALUES ('3', '1', '1', '订单', '0', '1', '1473131652', '1473131652');

-- ----------------------------
-- Table structure for `yii2_migration`
-- ----------------------------
DROP TABLE IF EXISTS `yii2_migration`;
CREATE TABLE `yii2_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='数据迁移记录表';

-- ----------------------------
-- Records of yii2_migration
-- ----------------------------
INSERT INTO `yii2_migration` VALUES ('m000000_000000_base', '1464579405');
INSERT INTO `yii2_migration` VALUES ('m130524_201442_init', '1464579437');
INSERT INTO `yii2_migration` VALUES ('m140506_102106_rbac_init', '1473150753');

-- ----------------------------
-- Table structure for `yii2_post`
-- ----------------------------
DROP TABLE IF EXISTS `yii2_post`;
CREATE TABLE `yii2_post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '内容编号',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `title` varchar(50) COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '标题',
  `alias` varchar(30) COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '别名',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '内容状态 1 - 正常 2-删除',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='内容基本表';

-- ----------------------------
-- Records of yii2_post
-- ----------------------------

-- ----------------------------
-- Table structure for `yii2_post_content`
-- ----------------------------
DROP TABLE IF EXISTS `yii2_post_content`;
CREATE TABLE `yii2_post_content` (
  `post_id` int(10) unsigned NOT NULL COMMENT '内容id',
  `content` mediumtext COLLATE utf8mb4_bin NOT NULL COMMENT '内容',
  `images` varchar(2000) COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '图片',
  `tags` varchar(100) COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '标签',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览次数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- ----------------------------
-- Records of yii2_post_content
-- ----------------------------

-- ----------------------------
-- Table structure for `yii2_user`
-- ----------------------------
DROP TABLE IF EXISTS `yii2_user`;
CREATE TABLE `yii2_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '用户编号',
  `group_id` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '用户组',
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '验证key',
  `password_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '密码',
  `password_reset_token` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '重置密码token',
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `position` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '职位',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态 1- 正常 2-锁定 3-已删除',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`),
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户表';

-- ----------------------------
-- Records of yii2_user
-- ----------------------------
INSERT INTO `yii2_user` VALUES ('1', '1', 'admin', 'd41d8cd98f00b204e9800998ecf8427e', '$2y$10$U6UtAUqp2aqo5ynsHr231OKvFzzwHTGSlPCR5Mj3skKVojDkiQ7Yu', 'cce37dbf8548da855e9fd7eaf769b004', 'admin@qq.com', 'CEO', '1', '1465375999', '1482204417');
INSERT INTO `yii2_user` VALUES ('4', '1', 'asdf', 'd41d8cd98f00b204e9800998ecf8427e', '$2y$10$7pvCHZ2KaX4pgqCPUQRw/e8Kxk2FjS7n2NosrqxsiMlu4dyvxH2jq', 'bbe37dbf8548da855e9fd7eaf769b004', 'asdf@qq.com', '', '3', '1465375999', '1465699985');
INSERT INTO `yii2_user` VALUES ('5', '1', 'test', 'd41d8cd98f00b204e9800998ecf8427e', '$2y$10$TN2ODGyEI1zOrqdS5h6jQuNdgOVili4xUzqdjAIV8aYng/nAqBut2', '7e1720ce91461f995398be853fe1ee5c', 'test@test.com', '测试工程师', '1', '1471313318', '1472540115');

-- ----------------------------
-- Table structure for `yii2_user_group`
-- ----------------------------
DROP TABLE IF EXISTS `yii2_user_group`;
CREATE TABLE `yii2_user_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组编号',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '用户组名称',
  `introduce` varchar(2000) NOT NULL DEFAULT '' COMMENT '用户组描述',
  `icon` varchar(100) NOT NULL DEFAULT '' COMMENT '图标',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '用户组状态 1-正常 2-已删除',
  `sort_order` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yii2_user_group
-- ----------------------------
INSERT INTO `yii2_user_group` VALUES ('1', '管理员', '最高用户权限组', '/upload/20160830/83c3fd37aa.png', '1', '0', '1472096052', '1473144837');
INSERT INTO `yii2_user_group` VALUES ('2', '普通用户组', '普通用户组', '', '1', '0', '1472096757', '1472096757');
INSERT INTO `yii2_user_group` VALUES ('3', '网络编辑', '网络编辑', '', '1', '0', '1482129055', '1482132041');
