/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.5.5-10.4.17-MariaDB : Database - test_paga
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`test_paga` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `test_paga`;

/*Table structure for table `off_days` */

DROP TABLE IF EXISTS `off_days`;

CREATE TABLE `off_days` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `off_days` */

insert  into `off_days`(`id`,`date`) values (1,'2022-01-01'),(2,'2022-01-02'),(3,'2022-01-12'),(4,'2022-01-13');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `total_paga` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `users` */

insert  into `users`(`id`,`full_name`,`total_paga`,`created_at`) values (1,'Test User1','40000','2022-01-21 15:00:00'),(2,'Test User 2','60000','2022-01-21 15:00:00'),(3,'Test User 3','60000','2022-01-21 15:00:00');

/*Table structure for table `working_days` */

DROP TABLE IF EXISTS `working_days`;

CREATE TABLE `working_days` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `hours` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

/*Data for the table `working_days` */

insert  into `working_days`(`id`,`user_id`,`date`,`hours`) values (1,1,'2022-01-11','9'),(2,2,'2022-01-11','10'),(3,3,'2022-01-11','5'),(4,1,'2022-01-10','9'),(5,2,'2022-01-10','10'),(6,3,'2022-01-10','5'),(7,1,'2022-01-09','4'),(8,2,'2022-01-09','8'),(9,3,'2022-01-09','10'),(10,1,'2022-01-08','10'),(11,2,'2022-01-08','9'),(12,3,'2022-01-08','9');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
