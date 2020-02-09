# ************************************************************
# Sequel Pro SQL dump
# Versión 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: desarrollos.webdeprueba.com (MySQL 5.1.73)
# Base de datos: artigniter
# Tiempo de Generación: 2020-02-02 16:25:21 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Volcado de tabla area_profesional
# ------------------------------------------------------------

DROP TABLE IF EXISTS `area_profesional`;

CREATE TABLE `area_profesional` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `area` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `area_profesional` WRITE;
/*!40000 ALTER TABLE `area_profesional` DISABLE KEYS */;

INSERT INTO `area_profesional` (`id`, `area`)
VALUES
	(1,'Gráfico'),
	(2,'Marketing');

/*!40000 ALTER TABLE `area_profesional` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla configuracion
# ------------------------------------------------------------

DROP TABLE IF EXISTS `configuracion`;

CREATE TABLE `configuracion` (
  `id` int(1) NOT NULL DEFAULT '1',
  `ultima_factura` int(11) NOT NULL DEFAULT '0',
  `ultimo_abono` int(11) NOT NULL DEFAULT '0',
  `anno` int(11) NOT NULL,
  `email_emisor` varchar(255) NOT NULL DEFAULT '',
  `smtp` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `puerto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `configuracion` WRITE;
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;

INSERT INTO `configuracion` (`id`, `ultima_factura`, `ultimo_abono`, `anno`, `email_emisor`, `smtp`, `password`, `puerto`)
VALUES
	(1,205,22,2019,'623b23a7db8212c6b48a13da614585a124d9d61b74833d0708205bd9dd6bed85b9815624a92b485fcc75169c2e88011b90fed5ba758ff61d42b67b43bf07f1e6yL4DPnVGRIaShhXYbqOpb7NleQH189Hf8S7wXtbKl2OCumbbjZtngnoNfrEFnzAa','f4f0ec6645c41d905f2d229da854c97556b9fb875c354def691511b01fe768dd72d1cdf01fc7d90781b12a7685eeb7a7c2f3ddb8035fe31db515c8e8f68835f4W39VE55edqKzv2D7dfFipyiM88tajsh055bgxDwYVkhABRc3DiXgeiLmbBmhQ+AY','5eec1a506b00cf966bbf665088458d9cb2e168e05cc559b2a6fa26917eff00f422064ae06f5139b9022a58b11e7111d6db1331c49f305da95655f62b328a314dfnH7kh9Wk3wvRzx5xieSbr3uRiaqww8cmJ8mfeTIWWY=',NULL);

/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla estatus
# ------------------------------------------------------------

DROP TABLE IF EXISTS `estatus`;

CREATE TABLE `estatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estatus` varchar(255) DEFAULT NULL,
  `cuota` double(6,2) DEFAULT '0.00',
  `periodicidad` tinyint(3) DEFAULT '1',
  `activo` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `estatus` WRITE;
/*!40000 ALTER TABLE `estatus` DISABLE KEYS */;

INSERT INTO `estatus` (`id`, `estatus`, `cuota`, `periodicidad`, `activo`)
VALUES
	(1,'Estudiante',40.25,3,1);

/*!40000 ALTER TABLE `estatus` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla periodicidad
# ------------------------------------------------------------

DROP TABLE IF EXISTS `periodicidad`;

CREATE TABLE `periodicidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periodicidad` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `periodicidad` WRITE;
/*!40000 ALTER TABLE `periodicidad` DISABLE KEYS */;

INSERT INTO `periodicidad` (`id`, `periodicidad`)
VALUES
	(1,'Anual'),
	(2,'Trimestral'),
	(3,'Mensual');

/*!40000 ALTER TABLE `periodicidad` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla socio
# ------------------------------------------------------------

DROP TABLE IF EXISTS `socio`;

CREATE TABLE `socio` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido1` varchar(255) DEFAULT NULL,
  `apellido2` varchar(255) DEFAULT NULL,
  `dni` varchar(10) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `cp` varchar(10) DEFAULT NULL,
  `provincia` tinyint(4) DEFAULT NULL,
  `localidad` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `estatus` tinyint(4) DEFAULT NULL,
  `area_profesional` tinyint(4) DEFAULT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `web` varchar(255) DEFAULT NULL,
  `iban` varchar(24) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `pinterest` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `eliminado` tinyint(4) DEFAULT '0',
  `fecha_alta` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dni` (`dni`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `socio` WRITE;
/*!40000 ALTER TABLE `socio` DISABLE KEYS */;

INSERT INTO `socio` (`id`, `nombre`, `apellido1`, `apellido2`, `dni`, `direccion`, `cp`, `provincia`, `localidad`, `email`, `telefono`, `estatus`, `area_profesional`, `marca`, `web`, `iban`, `twitter`, `facebook`, `pinterest`, `linkedin`, `eliminado`, `fecha_alta`)
VALUES
	(1,'Jose','Garcia','Ibañes','48485775G','Ruben dario nº4 Esc Izq 4ºC','30011',NULL,NULL,'lopepe.dev@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'2019-05-23 13:29:05'),
	(21,'Fernando','Marín','Ceballos','48485775f','asdf asdf','30003',1,'Murcia','fernando@artsolut.es','55555555',NULL,0,'Marca','web','IBAN','twiiter','facebook','pinterest','linkedin',0,'2019-05-27 18:10:12'),
	(22,'Fernando','Ceballos','Ceballos','52811801Y','c/ Intendente Patiño, 4 - 2º B','30007',1,'Murcia','paco@artsolut.es','629690373',1,2,'','','ES13 2085 8342 50 033007','','','','',0,'2019-10-08 20:50:25'),
	(23,'prueba','prueba','prueba','123456789Y','fjafjasl','43433',1,'Murcia','fernando@trorali.es','968967719',1,1,'','','ES13 2085 8342 50 033007','','','','',0,'2019-10-19 11:07:20');

/*!40000 ALTER TABLE `socio` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla usuario
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `id_socio` int(11) NOT NULL DEFAULT '0',
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `nivel` tinyint(4) DEFAULT '3',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_deleted` timestamp NULL DEFAULT NULL,
  `eliminado` int(4) NOT NULL DEFAULT '0',
  `activado` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id_socio`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;

INSERT INTO `usuario` (`id_socio`, `username`, `password`, `nivel`, `date_created`, `date_deleted`, `eliminado`, `activado`)
VALUES
	(1,'lopepe.dev@gmail.com','$2y$10$j0F2ueL/NiAYd56IQIbbO.ujXULN9GSKW4sugcTz9UxVUOPMg7yIq',1,'2019-05-22 17:27:17',NULL,0,0),
	(21,'fernando@artsolut.es','$2y$10$Acnoqc7PV1F7nFHan.tWVuBPyfUeTZiMvJqtm1mF1ng9xETUbClBi',1,'2019-05-27 18:10:12',NULL,0,0),
	(22,'paco@artsolut.es','$2y$10$eQZFtL9gGIohy9zDsXd1hufFKEd//Sb3IDAvoSTd66h3BB9fFDK0a',3,'2019-10-08 20:50:25',NULL,0,0),
	(23,'fernando@trorali.es','$2y$10$vKNu7pfVZ0hYH0VoCnBv2uNqzJz2492pIbibhbMf02XPErbcGHpBu',3,'2019-10-19 11:07:20',NULL,0,0);

/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
