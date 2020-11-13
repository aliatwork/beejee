/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50723
Source Host           : localhost:3306
Source Database       : beejee

Target Server Type    : MYSQL
Target Server Version : 50723
File Encoding         : 65001

Date: 2020-11-13 16:58:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tasks`
-- ----------------------------
DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `text` text,
  `state` enum('completed','not_completed','') DEFAULT 'not_completed',
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `check_state` enum('checked','not_checked') DEFAULT 'not_checked',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

