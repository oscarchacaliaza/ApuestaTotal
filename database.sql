/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.1.37-MariaDB : Database - apuestatotal
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`apuestatotal` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `apuestatotal`;

/*Table structure for table `banco` */

DROP TABLE IF EXISTS `banco`;

CREATE TABLE `banco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_banco` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `banco` */

insert  into `banco`(`id`,`nombre_banco`,`estado`) values 
(1,'BCP',1),
(2,'BBVA',1),
(3,'SCOTIABANK',1),
(4,'INTERBANK',1);

/*Table structure for table `cliente` */

DROP TABLE IF EXISTS `cliente`;

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_docu_ident` int(11) NOT NULL,
  `num_docu_ident` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `primer_apellido` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `segundo_apellido` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombres` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `cliente` */

insert  into `cliente`(`id`,`id_tipo_docu_ident`,`num_docu_ident`,`primer_apellido`,`segundo_apellido`,`nombres`,`email`,`telefono`,`estado`) values 
(1,1,'73672250','GARCIA','MENDOZA','JORGE','JORGEGARCIA@GMAIL.COM','987654321',1),
(2,1,'73672260','GUERRA','LUNA','RICARDO','RICARDOGUERRA@GMAIL.COM','987654312',1),
(3,2,'A01234567','GATES','MUSK','BILL','BILLGATES@GMAIL.COM','912345678',1);

/*Table structure for table `deposito` */

DROP TABLE IF EXISTS `deposito`;

CREATE TABLE `deposito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `id_tipo_deposito` int(11) NOT NULL,
  `id_tipo_banco` int(11) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_usuario` int(11) NOT NULL,
  `estado` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `deposito` */

insert  into `deposito`(`id`,`id_cliente`,`id_tipo_deposito`,`id_tipo_banco`,`monto`,`fecha`,`id_usuario`,`estado`) values 
(1,1,1,1,101.00,'2021-09-21 17:20:42',1,1),
(2,1,2,NULL,105.00,'2021-09-21 23:05:47',1,1),
(3,1,1,1,11.00,'2021-09-22 10:58:21',1,1),
(4,1,2,0,145.00,'2021-09-22 11:01:50',1,1),
(5,1,2,0,13.42,'2021-09-22 11:03:46',1,1),
(6,1,1,3,890.00,'2021-09-22 11:13:02',1,1),
(7,1,2,0,124.55,'2021-09-22 11:16:55',1,1),
(8,2,1,1,124.00,'2021-09-22 11:23:37',1,1),
(9,2,1,2,134.50,'2021-09-22 15:43:47',2,1),
(10,1,2,0,120.00,'2021-09-22 15:46:54',2,1),
(11,1,2,0,5.00,'2021-09-22 15:54:08',2,1),
(12,1,2,0,1250.00,'2021-09-22 15:54:46',2,1),
(13,1,2,0,1.00,'2021-09-22 15:58:54',2,1),
(14,1,2,0,1500.00,'2021-09-22 16:01:45',2,1),
(15,1,2,0,1350.00,'2021-09-22 16:40:04',2,1),
(16,2,2,0,12.34,'2021-09-22 16:43:00',2,1),
(17,2,2,0,123.00,'2021-09-22 16:45:52',2,1),
(18,2,2,0,120.00,'2021-09-22 16:52:59',2,1),
(19,2,2,0,1234.00,'2021-09-22 16:58:37',2,1),
(20,2,2,0,1.00,'2021-09-22 16:58:56',2,1),
(21,2,2,0,1.01,'2021-09-22 16:59:16',2,1);

/*Table structure for table `tipo_deposito` */

DROP TABLE IF EXISTS `tipo_deposito`;

CREATE TABLE `tipo_deposito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_deposito` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tipo_deposito` */

insert  into `tipo_deposito`(`id`,`tipo_deposito`,`estado`) values 
(1,'Depósito por banco',1),
(2,'Depósito en efectivo',1);

/*Table structure for table `tipo_docu_identidad` */

DROP TABLE IF EXISTS `tipo_docu_identidad`;

CREATE TABLE `tipo_docu_identidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `documento` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `digitos` int(11) NOT NULL,
  `posee_numeros` int(11) DEFAULT NULL COMMENT 'Valor 1, si posee numero',
  `posee_letras` int(11) DEFAULT NULL COMMENT 'Valor 1, si posee letras',
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tipo_docu_identidad` */

insert  into `tipo_docu_identidad`(`id`,`documento`,`digitos`,`posee_numeros`,`posee_letras`,`estado`) values 
(1,'DNI',8,1,NULL,1),
(2,'Pasaporte',9,1,1,1);

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cargo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `usuario` */

insert  into `usuario`(`id`,`usuario`,`password`,`estado`,`nombre`,`cargo`) values 
(1,'admin','123',1,'Johnny Quispe','Jefe de Sistemas'),
(2,'tester','321',1,'Elon Musk','Testeador');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
