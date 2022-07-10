-- ----------------------------
-- 日期：2021-11-05 16:56:00
-- MySQL - 5.6 : Database - fr3d_32110900_z
-- ----------------------------

CREATE DATAbase IF NOT EXISTS `fr3d_32110900_z` DEFAULT CHARACTER SET utf8 ;

USE `fr3d_32110900_z`;

-- ----------------------------
-- Table structure for `blood_glucose_value`
-- ----------------------------

DROP TABLE IF EXISTS `blood_glucose_value`;

CREATE TABLE `blood_glucose_value` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `value` double(3,1) unsigned DEFAULT NULL,
  `uid` int(10) unsigned DEFAULT NULL,
  `measureTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Data for the table `blood_glucose_value`
-- ----------------------------

-- ----------------------------
-- Table structure for `habit_stick_tolt`
-- ----------------------------

DROP TABLE IF EXISTS `habit_stick_tolt`;

CREATE TABLE `habit_stick_tolt` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `startDate` char(8) DEFAULT NULL,
  `endDate` char(8) DEFAULT NULL,
  `uid` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='习惯散点图';

-- ----------------------------
-- Data for the table `habit_stick_tolt`
-- ----------------------------

INSERT INTO `habit_stick_tolt` VALUES ('1', '睡前阅读1页', '20210412', '20210915', '1');
INSERT INTO `habit_stick_tolt` VALUES ('2', '练歌1分钟', '20211028', '20211029', '1');
INSERT INTO `habit_stick_tolt` VALUES ('3', '拳击1分钟', '20211028', '20211029', '1');
INSERT INTO `habit_stick_tolt` VALUES ('4', '11点前睡觉', '20211026', '', '1');
INSERT INTO `habit_stick_tolt` VALUES ('5', '每日一赞', '20211027', '', '1');
INSERT INTO `habit_stick_tolt` VALUES ('10', '俯卧撑1个', '20211028', '', '1');
INSERT INTO `habit_stick_tolt` VALUES ('12', '睡前阅读1页', '20211026', '', '1');
INSERT INTO `habit_stick_tolt` VALUES ('13', '大飞&&佳颖', '20211029', '', '1');
INSERT INTO `habit_stick_tolt` VALUES ('14', '和爱人无吵架', '20211029', '', '1');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `role` tinyint(4) unsigned DEFAULT '1' COMMENT '1前台用户2后台用户3管理员',
  `password` char(32) DEFAULT '',
  `phone` char(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Data for the table `users`
-- ----------------------------

INSERT INTO `users` VALUES ('1', '阿飞', '3', '', '', '');

-- ----------------------------
-- Table structure for `weight`
-- ----------------------------

DROP TABLE IF EXISTS `weight`;

CREATE TABLE `weight` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `value` double(4,1) unsigned DEFAULT NULL,
  `uid` int(10) unsigned DEFAULT NULL,
  `measureTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Data for the table `weight`
-- ----------------------------

INSERT INTO `weight` VALUES ('1', '62.6', '1', '2021-09-26 14:00:00');
INSERT INTO `weight` VALUES ('2', '64.4', '1', '2021-10-28 16:00:00');
INSERT INTO `weight` VALUES ('3', '63.5', '1', '2021-11-03 16:00:00');
INSERT INTO `weight` VALUES ('5', '63.5', '1', '2021-11-05 14:49:06');

