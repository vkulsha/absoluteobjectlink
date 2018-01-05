/*
Navicat MySQL Data Transfer

Source Server         : _localhost
Source Server Version : 50720
Source Host           : localhost:3306
Source Database       : absoluteobjectlink

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2018-01-05 16:41:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for object
-- ----------------------------
DROP TABLE IF EXISTS `object`;
CREATE TABLE `object` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `n` varchar(255) DEFAULT NULL,
  `d` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `c` int(20) DEFAULT '1',
  `u` int(20) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `in` (`n`) USING BTREE,
  KEY `id` (`d`) USING BTREE,
  KEY `ic` (`c`) USING BTREE,
  KEY `iu` (`u`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of object
-- ----------------------------
INSERT INTO `object` VALUES ('1', 'Класс', '2018-01-01 19:18:46', '1', '0');
INSERT INTO `object` VALUES ('2', 'Роли системы', '2018-01-01 19:38:52', '1', '1');
INSERT INTO `object` VALUES ('3', 'роль администратор', '2018-01-01 19:40:07', '1', '1');
INSERT INTO `object` VALUES ('4', 'роль гость', '2018-01-01 19:40:14', '1', '1');
INSERT INTO `object` VALUES ('5', 'Правила системы', '2018-01-01 19:40:25', '1', '1');
INSERT INTO `object` VALUES ('6', 'выполнение разрешено', '2018-01-01 19:40:46', '1', '1');
INSERT INTO `object` VALUES ('7', 'выполнение запрещено', '2018-01-01 19:40:53', '1', '1');
INSERT INTO `object` VALUES ('8', 'Правила группы функций системы', '2018-01-01 19:41:55', '1', '1');
INSERT INTO `object` VALUES ('9', 'разрешено выполнение всех функций системы', '2018-01-01 19:42:49', '1', '1');
INSERT INTO `object` VALUES ('10', 'разрешено выполнение просмотра', '2018-01-01 19:43:18', '1', '1');
INSERT INTO `object` VALUES ('11', 'Функции системы', '2018-01-01 19:44:01', '1', '1');
INSERT INTO `object` VALUES ('12', 'gO', '2018-01-01 19:44:16', '1', '1');
INSERT INTO `object` VALUES ('13', 'gL', '2018-01-01 19:44:18', '1', '1');
INSERT INTO `object` VALUES ('14', 'gN', '2018-01-01 19:44:23', '1', '1');
INSERT INTO `object` VALUES ('15', 'cO', '2018-01-01 19:44:29', '1', '1');
INSERT INTO `object` VALUES ('16', 'cL', '2018-01-01 19:44:33', '1', '1');
INSERT INTO `object` VALUES ('17', 'eO', '2018-01-01 19:44:38', '1', '1');
INSERT INTO `object` VALUES ('18', 'eL', '2018-01-01 19:44:40', '1', '1');
INSERT INTO `object` VALUES ('19', 'uO', '2018-01-01 19:44:46', '1', '1');
INSERT INTO `object` VALUES ('20', 'uL', '2018-01-01 19:44:48', '1', '1');
INSERT INTO `object` VALUES ('21', 'gT2', '2018-01-01 19:45:00', '1', '1');
INSERT INTO `object` VALUES ('22', 'gAnd', '2018-01-01 19:45:07', '1', '1');
INSERT INTO `object` VALUES ('23', 'gLogin', '2018-01-01 19:45:11', '1', '1');
INSERT INTO `object` VALUES ('24', 'police', '2018-01-01 19:45:16', '1', '1');
INSERT INTO `object` VALUES ('25', 'Пользователи системы', '2018-01-01 19:50:32', '1', '1');
INSERT INTO `object` VALUES ('26', 'администратор', '2018-01-01 19:51:20', '1', '1');
INSERT INTO `object` VALUES ('27', 'гость', '2018-01-01 19:51:32', '1', '1');
INSERT INTO `object` VALUES ('28', 'Логин пользователя системы', '2018-01-01 20:00:19', '1', '1');
INSERT INTO `object` VALUES ('29', 'admin', '2018-01-01 19:54:50', '1', '1');
INSERT INTO `object` VALUES ('30', 'guest', '2018-01-01 19:56:06', '1', '1');
INSERT INTO `object` VALUES ('31', 'Пароль пользователя системы', '2018-01-01 20:00:12', '1', '1');
INSERT INTO `object` VALUES ('32', '0192023a7bbd73250516f069df18b500', '2018-01-05 11:12:10', '1', '1');
INSERT INTO `object` VALUES ('33', 'fcf41657f02f88137a1bcf068a32c0a3', '2018-01-05 11:12:25', '1', '1');
INSERT INTO `object` VALUES ('34', 'Данные', '2018-01-01 20:04:04', '1', '1');
INSERT INTO `object` VALUES ('35', 'база данных', '2018-01-01 20:04:38', '1', '1');
INSERT INTO `object` VALUES ('36', 'Корневой класс роли системы', '2018-01-01 20:06:22', '1', '1');
INSERT INTO `object` VALUES ('37', 'корневой класс роли администратор', '2018-01-01 20:06:54', '1', '1');
INSERT INTO `object` VALUES ('38', 'корневой класс роли гость', '2018-01-01 20:08:18', '1', '1');
