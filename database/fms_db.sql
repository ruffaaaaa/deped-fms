/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : fms_db

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2024-12-03 17:14:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `files`
-- ----------------------------
DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(30) NOT NULL,
  `folder_id` int(30) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_path` text NOT NULL,
  `is_public` tinyint(1) DEFAULT '0',
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of files
-- ----------------------------
INSERT INTO `files` VALUES ('1', 'sample pdf file', 'Sample file uploaded', '1', '1', 'pdf', '1600320360_1600314660_sample.pdf', '1', '2020-09-17 16:22:26');
INSERT INTO `files` VALUES ('3', 'sample', 'Sample PDF Document', '3', '9', 'pdf', '1600330200_sample.pdf', '0', '2020-09-17 16:10:25');
INSERT INTO `files` VALUES ('4', 'ajax_tutorial', 'test', '4', '0', 'pdf', '1733215380_ajax_tutorial.pdf', '0', '2024-12-03 16:43:09');
INSERT INTO `files` VALUES ('5', 'ajax_tutorial', 'test2', '4', '10', 'pdf', '1733216520_ajax_tutorial.pdf', '0', '2024-12-03 17:02:30');

-- ----------------------------
-- Table structure for `folders`
-- ----------------------------
DROP TABLE IF EXISTS `folders`;
CREATE TABLE `folders` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `user_id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `parent_id` int(30) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of folders
-- ----------------------------
INSERT INTO `folders` VALUES ('1', '1', 'Sample Folder', '0');
INSERT INTO `folders` VALUES ('3', '1', 'Sample Folder 3', '0');
INSERT INTO `folders` VALUES ('5', '1', 'Sample Folder 4', '0');
INSERT INTO `folders` VALUES ('6', '1', 'New Folder', '1');
INSERT INTO `folders` VALUES ('7', '1', 'Folder 1', '1');
INSERT INTO `folders` VALUES ('8', '1', 'test folder', '7');
INSERT INTO `folders` VALUES ('9', '3', 'My Folder 1', '0');
INSERT INTO `folders` VALUES ('10', '4', 'My Files', '0');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1+admin , 2 = users',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Administrator', 'admin', '1q2w3e4r5t', '1');
INSERT INTO `users` VALUES ('4', 'gavino tan', 'gavinootan', '1q2w3e4r5t', '2');
INSERT INTO `users` VALUES ('5', 'aiko lara', 'aikoelara', '1q2w3e4r5t', '2');
