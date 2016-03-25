/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : sql5109534

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-03-22 20:18:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for evento
-- ----------------------------
DROP TABLE IF EXISTS `evento`;
CREATE TABLE `evento` (
  `idevento` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(15) NOT NULL,
  `titulo` varchar(45) DEFAULT 'Alerta',
  `detalle` varchar(255) DEFAULT '',
  `foto` longblob,
  `idubicacion` int(11) DEFAULT NULL,
  `fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estatus` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`idevento`),
  KEY `ub` (`idubicacion`),
  KEY `usu` (`usuario`),
  CONSTRAINT `ub` FOREIGN KEY (`idubicacion`) REFERENCES `ubicacion` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `usu` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`usuario`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of evento
-- ----------------------------
INSERT INTO `evento` VALUES ('23', 'aaponte', 'Alerta', 'Robo', '', '3', '2016-03-22 15:43:22', '1');
INSERT INTO `evento` VALUES ('24', 'apenaloza605', 'Alerta', 'Sospechoso', '', '4', '2016-03-22 15:44:31', '1');

-- ----------------------------
-- Table structure for permisos
-- ----------------------------
DROP TABLE IF EXISTS `permisos`;
CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  ` ver_noticias` tinyint(1) DEFAULT '0',
  `enviar_noticias` tinyint(1) DEFAULT '0',
  `boton_panico` tinyint(1) DEFAULT '0',
  `crear_usuarios` tinyint(1) DEFAULT '0',
  `permisos` tinyint(1) DEFAULT '0',
  `descripcion` varchar(20) DEFAULT NULL,
  `estatus` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of permisos
-- ----------------------------
INSERT INTO `permisos` VALUES ('1', '1', '1', '1', '1', '1', 'Administrador', '1');
INSERT INTO `permisos` VALUES ('2', '1', '1', '1', '0', '0', 'Estudiante', '1');

-- ----------------------------
-- Table structure for ubicacion
-- ----------------------------
DROP TABLE IF EXISTS `ubicacion`;
CREATE TABLE `ubicacion` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(30) NOT NULL,
  `coordenadas` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ubicacion
-- ----------------------------
INSERT INTO `ubicacion` VALUES ('1', 'Comedor   Atlantico', '', null);
INSERT INTO `ubicacion` VALUES ('2', 'Comedor Villa Asia', null, null);
INSERT INTO `ubicacion` VALUES ('3', 'Estacionamiento Mod1', null, null);
INSERT INTO `ubicacion` VALUES ('4', 'Estacionamiento Alde', null, null);
INSERT INTO `ubicacion` VALUES ('5', 'Pasillo PB Mod2', null, null);

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `pass` varchar(30) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `id_permiso` int(11) DEFAULT NULL,
  PRIMARY KEY (`usuario`),
  KEY `permiso` (`id_permiso`),
  CONSTRAINT `permiso` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES ('admin', 'aaponte', '2016-03-07 14:26:50', 'Antonio', 'Aponte', '1');
INSERT INTO `usuarios` VALUES ('12345', 'apenaloza605', '2016-03-06 03:44:29', 'Adrian', 'Peñaloza', '1');
INSERT INTO `usuarios` VALUES ('00000', 'mcarvajal', '2016-03-13 19:15:26', 'Manuel', 'Carvajal', '2');
INSERT INTO `usuarios` VALUES ('00000', 'rrojas', '2016-03-13 19:15:46', 'Rendall', 'Rojas', '2');

-- ----------------------------
-- Procedure structure for iniciar_sesion
-- ----------------------------
DROP PROCEDURE IF EXISTS `iniciar_sesion`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `iniciar_sesion`(mail VARCHAR(15), clave VARCHAR(30))
BEGIN
IF NOT EXISTS (SELECT usuario FROM usuarios WHERE usuario=mail LIMIT 1) then
   SELECT 'nr' AS R;
else IF NOT EXISTS (SELECT usuario FROM usuarios WHERE usuario=mail and pass=clave limit 1) then
  select 'ci' AS R;
else select *, 'si' AS R FROM usuarios where usuario=mail;
end if;
end if;
END
;;
DELIMITER ;
