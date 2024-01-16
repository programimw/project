/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.5.5-10.4.32-MariaDB : Database - delivery
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`delivery` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `delivery`;

/*Table structure for table `korrieri` */

DROP TABLE IF EXISTS `korrieri`;

CREATE TABLE `korrieri` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `emri` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `korrieri` */

insert  into `korrieri`(`id`,`emri`,`username`,`email`) values (1,'test_1','testUsername_1','test@test.com'),(2,'test_2','testUsername_2','test2@test.com'),(3,'test_3','testUsername_3','test3@test.com'),(4,'test_4','testUsername_4','test4@test.com'),(5,'test_5','testUsername_5','test5@test.com');

/*Table structure for table `porosi` */

DROP TABLE IF EXISTS `porosi`;

CREATE TABLE `porosi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `korrier_id` int(10) unsigned NOT NULL,
  `nr_klient` varchar(15) NOT NULL,
  `data` date NOT NULL,
  `adresa` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `porosi` */

insert  into `porosi`(`id`,`korrier_id`,`nr_klient`,`data`,`adresa`) values (1,1,'111111111','2024-01-11','testAddress_1'),(2,1,'222222222','2024-02-22','testAddress_2'),(3,1,'3','2024-03-03','testAddress_3'),(4,1,'4','2024-04-04','testAddress_4'),(5,1,'5','2024-05-05','testAddress_5'),(6,2,'111111111','2024-01-11','testAddress_1'),(7,2,'222222222','2024-02-22','testAddress_2'),(8,2,'3','2024-03-03','testAddress_3'),(9,2,'4','2024-04-04','testAddress_4'),(10,2,'5','2024-05-05','testAddress_5');

/*Table structure for table `statistika` */

DROP TABLE IF EXISTS `statistika`;

CREATE TABLE `statistika` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `porosi_id` int(10) unsigned NOT NULL,
  `derguar` varchar(5) NOT NULL,
  `emri_klient` varchar(20) NOT NULL,
  `adresa_klient` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `statistika` */

insert  into `statistika`(`id`,`porosi_id`,`derguar`,`emri_klient`,`adresa_klient`) values (2,2,'yes','',''),(3,3,'yes','',''),(4,4,'yes','test_4','testAddres4'),(5,5,'yes','test_5','testAddres5'),(6,1,'yes','test pika 1','test pika 1'),(7,6,'yes','test','test');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
