/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.5.5-10.4.32-MariaDB : Database - sherbim_klienti
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sherbim_klienti` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `sherbim_klienti`;

/*Table structure for table `perdorues` */

DROP TABLE IF EXISTS `perdorues`;

CREATE TABLE `perdorues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `emri` varchar(30) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `perdorues` */

insert  into `perdorues`(`id`,`emri`,`username`,`email`) values (1,'perdoruesi 1','perdoruesi_1','perdorues_1@gmail.com'),(2,'perdoruesi 2','perdoruesi_2','perdorues_2@gmail.com'),(3,'perdoruesi 3','perdoruesi_3','perdorues_3@gmail.com'),(4,'perdoruesi 4','perdoruesi_4','perdorues_4@gmail.com'),(5,'perdoruesi 5','perdoruesi_5','perdorues_5@gmail.com');

/*Table structure for table `statistika` */

DROP TABLE IF EXISTS `statistika`;

CREATE TABLE `statistika` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `call_id` int(11) NOT NULL,
  `sherbyer` varchar(5) NOT NULL,
  `emri_klient` varchar(30) NOT NULL,
  `adresa_klient` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `statistika` */

insert  into `statistika`(`id`,`call_id`,`sherbyer`,`emri_klient`,`adresa_klient`) values (1,1,'yes','klient 1','test addres 1'),(2,2,'yes','klient 2','test addres 2'),(3,3,'yes','klient 3','test addres 3'),(4,4,'yes','klient 4','test addres 4'),(5,5,'yes','klient 5','test addres 5');

/*Table structure for table `telefonata` */

DROP TABLE IF EXISTS `telefonata`;

CREATE TABLE `telefonata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `perdorues_id` int(11) NOT NULL,
  `nr_tel` varchar(15) NOT NULL,
  `data` datetime NOT NULL,
  `gjatesia` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `telefonata` */

insert  into `telefonata`(`id`,`perdorues_id`,`nr_tel`,`data`,`gjatesia`) values (1,1,'11111111','2024-01-10 09:11:00',10),(2,1,'22222222','2024-01-10 09:11:00',10),(3,1,'3333333','2024-01-10 09:11:00',10),(4,1,'5234234','2024-01-10 09:11:00',10),(5,2,'5234234','2024-01-10 09:11:00',10),(6,2,'51111','2024-01-10 09:11:00',10),(7,2,'125125123123','2024-01-10 09:11:00',10),(8,2,'123413','2024-01-10 09:11:00',10),(9,3,'123413','2024-01-10 09:11:00',10),(10,3,'12312331213','2024-01-10 09:11:00',10),(11,3,'14123123','2024-01-10 09:11:00',10),(12,3,'1512412','2024-01-10 09:11:00',10);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
