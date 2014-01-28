/*
SQLyog Ultimate v8.5 
MySQL - 5.5.24-log : Database - shoppinghub
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`shoppinghub` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `shoppinghub`;

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `descr` varchar(250) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name`,`descr`,`image`) values (22,'Flowers','beautiful flowers in different packings','Data_153.jpg'),(23,'Cars','High end technology and cultural cars','Data_128.jpg'),(24,'Jewellery','Your beauty essentials!!','Data_139.jpg'),(25,'Fans','fans of all types','Data_149.jpg'),(26,'Books','Books in a large number','Data_163.jpg'),(27,'Beauty Stones','Stones for rings','Data_186.jpg'),(28,'Glasses','many colors','Data_399.jpg'),(29,'TVs and Monitors','also tv cards etc','Data_422.jpg'),(30,'Music Instruments','many new..','Data_396.jpg'),(31,'Fancy Bags and Purse','many colors','Data_167.jpg'),(32,'Ladies Shoes','Shoes','Data_239.jpg'),(33,'Grocery','many items','Data_330.jpg'),(34,'Table Watches','watches','Data_134.jpg'),(35,'Games Instruments','cricket, too','Data_246.jpg');

/*Table structure for table `messages` */

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `topic` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `message` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `messages` */

insert  into `messages`(`id`,`name`,`topic`,`email`,`message`) values (10,'asdfsdaf','asdfds','asdfdsaf@sdfsdf','fdsafds'),(11,'Ahmad','ahmasdfdslf','ahmadalibaloch@gmail.com','sfdsf');

/*Table structure for table `orderdetails` */

DROP TABLE IF EXISTS `orderdetails`;

CREATE TABLE `orderdetails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orderId` int(10) unsigned NOT NULL,
  `productId` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `price` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

/*Data for the table `orderdetails` */

insert  into `orderdetails`(`id`,`orderId`,`productId`,`quantity`,`price`) values (40,12,28,4,100),(41,13,29,1,NULL),(42,14,31,3,500),(43,14,32,6,120),(44,15,33,4,50),(45,15,57,1,200000),(46,15,58,6,3000000),(47,15,59,2,1000),(48,16,33,2,50),(49,16,60,2,3000),(50,16,32,2,120);

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customerId` int(11) NOT NULL,
  `orderType` varchar(30) DEFAULT NULL,
  `orderDate` datetime NOT NULL,
  `shippingAddress` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `orders` */

insert  into `orders`(`id`,`customerId`,`orderType`,`orderDate`,`shippingAddress`,`status`,`image`) values (15,5,'check','2013-01-15 10:39:10','pindi address etc ','Processing',NULL),(16,5,'check','2013-01-15 10:39:10','','cart',NULL);

/*Table structure for table `owners` */

DROP TABLE IF EXISTS `owners`;

CREATE TABLE `owners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `business` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `owners` */

insert  into `owners`(`id`,`userId`,`rating`,`business`) values (1,3,3,'business of arms'),(2,4,5,'business of cars'),(9,21,NULL,'many');

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `ownerId` int(10) unsigned NOT NULL,
  `quantity` int(10) NOT NULL,
  `categoryId` int(10) NOT NULL,
  `price` decimal(10,0) unsigned NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;

/*Data for the table `products` */

insert  into `products`(`id`,`name`,`ownerId`,`quantity`,`categoryId`,`price`,`image`) values (29,'Blue Flower',2,19,22,'80','a1 (48).JPG'),(30,'White Red Flower',2,10,22,'200','01 (8).jpg'),(32,'Rose',1,7,22,'120','ph-10081.jpg'),(33,'Gift',1,14,22,'50','ph-10086.jpg'),(49,'Flowers',2,1,22,'1','Daisy.jpg'),(51,'Asad',2,1,22,'1','images.jpg'),(52,'Asad',2,1,22,'1','A [ROSE03.jpg'),(57,'BMW',2,0,23,'200000','Data_220.jpg'),(58,'BMW1',2,3,23,'3000000','Data_212.jpg'),(59,'Ring',2,13,24,'1000','Data_405.jpg'),(60,'Wall Fan',2,18,25,'3000','Data_149.jpg'),(61,'Pedestia Fan',9,2,25,'200','Data_149.jpg');

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `descr` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`descr`) values (1,'guest','can explore'),(2,'admin','admin rights'),(3,'owner','can add products and explore'),(4,'customer','can view and buy');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `joinDate` datetime DEFAULT NULL,
  `leaveDate` datetime DEFAULT NULL,
  `lastLogin` datetime DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `roleId` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`name`,`password`,`email`,`phone`,`address`,`joinDate`,`leaveDate`,`lastLogin`,`image`,`roleId`) values (1,'guest','Guest','123','guest','123','city',NULL,NULL,NULL,'gu.jpg',1),(3,'asad','Asad','123','asad@gmail.com','123','thamewali','2013-01-12 06:58:25','0000-00-00 00:00:00','2013-01-15 10:44:08','as.jpg',3),(4,'tariq','Tariq','123','tariq@gmai.com','123','khusab','2013-01-12 07:02:02','0000-00-00 00:00:00','2013-01-15 10:16:24','ta.jpg',3),(5,'babli','babli','123','babli@gmail.com','123','pindi','2013-01-13 03:46:47','0000-00-00 00:00:00','2013-01-15 10:36:35','ba.jpg',4),(6,'ahmad','Ahmad Ali','123','ahmadalibaloch@gmail.com','123','thamewali','0000-00-00 00:00:00','0000-00-00 00:00:00','2013-01-15 10:34:04','ah.jpg',2),(7,'zul','Zulqernan','123','zul@gmail.com','123213','Thamewali','2013-01-13 07:54:01','0000-00-00 00:00:00','2013-01-15 09:46:25','zu.jpg',4),(19,'Imran','Imran','123','imran@gmail.com','0332323232','','2013-01-15 09:56:12','0000-00-00 00:00:00','2013-01-15 10:00:17','colorofparadise.poster.jpg',3),(20,'saleem','Saleem','123','saleem@gmail.com','123','saleeeme','2013-01-15 10:22:13',NULL,NULL,'Data_158.jpg',4),(21,'zia','Zia','zia','zia@gmail.com','123','mianwali','2013-01-15 10:22:47','0000-00-00 00:00:00','2013-01-15 10:24:02','Data_172.jpg',3);

/*Table structure for table `_products_search` */

DROP TABLE IF EXISTS `_products_search`;

/*!50001 DROP VIEW IF EXISTS `_products_search` */;
/*!50001 DROP TABLE IF EXISTS `_products_search` */;

/*!50001 CREATE TABLE  `_products_search`(
 `id` int(10) unsigned ,
 `name` varchar(50) ,
 `ownerId` int(10) unsigned ,
 `quantity` int(10) ,
 `categoryId` int(10) ,
 `price` decimal(10,0) unsigned ,
 `image` varchar(255) ,
 `search` varchar(101) 
)*/;

/*View structure for view _products_search */

/*!50001 DROP TABLE IF EXISTS `_products_search` */;
/*!50001 DROP VIEW IF EXISTS `_products_search` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `_products_search` AS select `p`.`id` AS `id`,`p`.`name` AS `name`,`p`.`ownerId` AS `ownerId`,`p`.`quantity` AS `quantity`,`p`.`categoryId` AS `categoryId`,`p`.`price` AS `price`,`p`.`image` AS `image`,concat(`p`.`name`,' ',`c`.`name`) AS `search` from (`products` `p` join `categories` `c` on((`p`.`categoryId` = `c`.`id`))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
