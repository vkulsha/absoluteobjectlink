SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for link
-- ----------------------------
DROP TABLE IF EXISTS `link`;
CREATE TABLE `link` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `o1` int(20) DEFAULT NULL,
  `o2` int(20) DEFAULT NULL,
  `c` int(20) DEFAULT '1',
  `d` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `u` int(20) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `io1` (`o1`) USING BTREE,
  KEY `io2` (`o2`) USING BTREE,
  KEY `ic` (`c`) USING BTREE,
  KEY `id` (`d`) USING BTREE,
  KEY `iu` (`u`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of link
-- ----------------------------
INSERT INTO `link` VALUES ('1', '1', '1', '1', '2018-01-01 19:19:12', '0');
INSERT INTO `link` VALUES ('2', '2', '1', '1', '2018-01-01 19:38:52', '1');
INSERT INTO `link` VALUES ('3', '3', '2', '1', '2018-01-01 19:40:07', '1');
INSERT INTO `link` VALUES ('4', '4', '2', '1', '2018-01-01 19:40:14', '1');
INSERT INTO `link` VALUES ('5', '5', '1', '1', '2018-01-01 19:40:25', '1');
INSERT INTO `link` VALUES ('6', '6', '5', '1', '2018-01-01 19:40:46', '1');
INSERT INTO `link` VALUES ('7', '7', '5', '1', '2018-01-01 19:40:53', '1');
INSERT INTO `link` VALUES ('8', '8', '1', '1', '2018-01-01 19:41:55', '1');
INSERT INTO `link` VALUES ('9', '8', '2', '1', '2018-01-01 19:41:55', '1');
INSERT INTO `link` VALUES ('10', '8', '5', '1', '2018-01-01 19:42:21', '1');
INSERT INTO `link` VALUES ('11', '9', '8', '1', '2018-01-01 19:42:49', '1');
INSERT INTO `link` VALUES ('12', '10', '8', '1', '2018-01-01 19:43:18', '1');
INSERT INTO `link` VALUES ('13', '11', '1', '1', '2018-01-01 19:44:01', '1');
INSERT INTO `link` VALUES ('14', '11', '8', '1', '2018-01-01 19:44:01', '1');
INSERT INTO `link` VALUES ('15', '12', '11', '1', '2018-01-01 19:44:16', '1');
INSERT INTO `link` VALUES ('16', '13', '11', '1', '2018-01-01 19:44:18', '1');
INSERT INTO `link` VALUES ('17', '14', '11', '1', '2018-01-01 19:44:23', '1');
INSERT INTO `link` VALUES ('18', '15', '11', '1', '2018-01-01 19:44:30', '1');
INSERT INTO `link` VALUES ('19', '16', '11', '1', '2018-01-01 19:44:33', '1');
INSERT INTO `link` VALUES ('20', '17', '11', '1', '2018-01-01 19:44:38', '1');
INSERT INTO `link` VALUES ('21', '18', '11', '1', '2018-01-01 19:44:40', '1');
INSERT INTO `link` VALUES ('22', '19', '11', '1', '2018-01-01 19:44:46', '1');
INSERT INTO `link` VALUES ('23', '20', '11', '1', '2018-01-01 19:44:48', '1');
INSERT INTO `link` VALUES ('24', '21', '11', '1', '2018-01-01 19:44:52', '1');
INSERT INTO `link` VALUES ('25', '22', '11', '1', '2018-01-01 19:45:07', '1');
INSERT INTO `link` VALUES ('26', '23', '11', '1', '2018-01-01 19:45:11', '1');
INSERT INTO `link` VALUES ('27', '24', '11', '1', '2018-01-01 19:45:16', '1');
INSERT INTO `link` VALUES ('28', '24', '9', '1', '2018-01-01 19:45:52', '1');
INSERT INTO `link` VALUES ('29', '23', '9', '1', '2018-01-01 19:45:57', '1');
INSERT INTO `link` VALUES ('30', '22', '9', '1', '2018-01-01 19:46:02', '1');
INSERT INTO `link` VALUES ('31', '21', '9', '1', '2018-01-01 19:46:08', '1');
INSERT INTO `link` VALUES ('32', '20', '9', '1', '2018-01-01 19:46:14', '1');
INSERT INTO `link` VALUES ('33', '19', '9', '1', '2018-01-01 19:46:24', '1');
INSERT INTO `link` VALUES ('34', '18', '9', '1', '2018-01-01 19:46:30', '1');
INSERT INTO `link` VALUES ('35', '17', '9', '1', '2018-01-01 19:46:35', '1');
INSERT INTO `link` VALUES ('36', '16', '9', '1', '2018-01-01 19:46:40', '1');
INSERT INTO `link` VALUES ('37', '15', '9', '1', '2018-01-01 19:46:45', '1');
INSERT INTO `link` VALUES ('38', '14', '9', '1', '2018-01-01 19:46:51', '1');
INSERT INTO `link` VALUES ('39', '13', '9', '1', '2018-01-01 19:46:57', '1');
INSERT INTO `link` VALUES ('40', '12', '9', '1', '2018-01-01 19:47:09', '1');
INSERT INTO `link` VALUES ('41', '12', '10', '1', '2018-01-01 19:47:27', '1');
INSERT INTO `link` VALUES ('42', '13', '10', '1', '2018-01-01 19:47:31', '1');
INSERT INTO `link` VALUES ('43', '14', '10', '1', '2018-01-01 19:47:38', '1');
INSERT INTO `link` VALUES ('44', '21', '10', '1', '2018-01-01 19:47:42', '1');
INSERT INTO `link` VALUES ('45', '22', '10', '1', '2018-01-01 19:47:47', '1');
INSERT INTO `link` VALUES ('46', '23', '10', '1', '2018-01-01 19:47:51', '1');
INSERT INTO `link` VALUES ('47', '24', '10', '1', '2018-01-01 19:47:55', '1');
INSERT INTO `link` VALUES ('48', '9', '3', '1', '2018-01-01 19:48:34', '1');
INSERT INTO `link` VALUES ('49', '10', '4', '1', '2018-01-01 19:48:46', '1');
INSERT INTO `link` VALUES ('50', '25', '1', '1', '2018-01-01 19:50:20', '1');
INSERT INTO `link` VALUES ('51', '25', '2', '1', '2018-01-01 19:50:20', '1');
INSERT INTO `link` VALUES ('52', '26', '25', '1', '2018-01-01 19:51:21', '1');
INSERT INTO `link` VALUES ('53', '27', '25', '1', '2018-01-01 19:51:32', '1');
INSERT INTO `link` VALUES ('54', '26', '3', '1', '2018-01-01 19:51:50', '1');
INSERT INTO `link` VALUES ('55', '27', '4', '1', '2018-01-01 19:51:56', '1');
INSERT INTO `link` VALUES ('56', '28', '1', '1', '2018-01-01 19:54:32', '1');
INSERT INTO `link` VALUES ('57', '28', '25', '1', '2018-01-01 19:54:32', '1');
INSERT INTO `link` VALUES ('58', '29', '28', '1', '2018-01-01 19:54:50', '1');
INSERT INTO `link` VALUES ('59', '29', '26', '1', '2018-01-01 19:55:17', '1');
INSERT INTO `link` VALUES ('60', '30', '28', '1', '2018-01-01 19:56:06', '1');
INSERT INTO `link` VALUES ('61', '30', '27', '1', '2018-01-01 19:56:20', '1');
INSERT INTO `link` VALUES ('62', '31', '1', '1', '2018-01-01 20:00:12', '1');
INSERT INTO `link` VALUES ('63', '31', '25', '1', '2018-01-01 20:00:13', '1');
INSERT INTO `link` VALUES ('64', '32', '31', '1', '2018-01-01 20:02:33', '1');
INSERT INTO `link` VALUES ('65', '33', '31', '1', '2018-01-01 20:02:40', '1');
INSERT INTO `link` VALUES ('66', '32', '26', '1', '2018-01-01 20:02:50', '1');
INSERT INTO `link` VALUES ('67', '33', '30', '0', '2018-01-01 20:03:36', '1');
INSERT INTO `link` VALUES ('68', '33', '27', '1', '2018-01-01 20:03:39', '1');
INSERT INTO `link` VALUES ('69', '34', '1', '1', '2018-01-01 20:04:04', '1');
INSERT INTO `link` VALUES ('70', '35', '34', '1', '2018-01-01 20:04:38', '1');
INSERT INTO `link` VALUES ('71', '36', '1', '1', '2018-01-01 20:06:22', '1');
INSERT INTO `link` VALUES ('72', '36', '2', '1', '2018-01-01 20:06:43', '1');
INSERT INTO `link` VALUES ('73', '37', '36', '1', '2018-01-01 20:06:54', '1');
INSERT INTO `link` VALUES ('74', '1', '37', '0', '2018-01-01 20:07:49', '1');
INSERT INTO `link` VALUES ('75', '38', '36', '1', '2018-01-01 20:08:10', '1');
INSERT INTO `link` VALUES ('76', '38', '34', '0', '2018-01-01 20:09:50', '1');
INSERT INTO `link` VALUES ('77', '37', '3', '1', '2018-01-01 20:20:57', '1');
INSERT INTO `link` VALUES ('78', '38', '4', '1', '2018-01-01 20:21:02', '1');
INSERT INTO `link` VALUES ('79', '35', '38', '1', '2018-01-01 20:21:11', '1');
