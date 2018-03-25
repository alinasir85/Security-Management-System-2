/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.13-MariaDB : Database - sms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sms` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `sms`;

/*Table structure for table `city` */

DROP TABLE IF EXISTS `city`;

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `countryid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `countryid` (`countryid`),
  CONSTRAINT `city_ibfk_1` FOREIGN KEY (`countryid`) REFERENCES `country` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `city` */

insert  into `city`(`id`,`name`,`countryid`) values (1,'Lahore',1),(2,'Islamabad',1),(3,'Delhi',2),(4,'Mumbai',2),(5,'Shengai',3),(6,'Hongi',3),(7,'hawa',5),(8,'oki',4);

/*Table structure for table `country` */

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `country` */

insert  into `country`(`id`,`name`) values (1,'Pakistan'),(2,'India'),(3,'China'),(4,'USA'),(5,'Turkey');

/*Table structure for table `loginhistory` */

DROP TABLE IF EXISTS `loginhistory`;

CREATE TABLE `loginhistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  `logintime` datetime DEFAULT NULL,
  `machineip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;

/*Data for the table `loginhistory` */

insert  into `loginhistory`(`id`,`userid`,`login`,`logintime`,`machineip`) values (65,10,'bilal','2018-03-25 18:12:56','::1'),(66,65,'usama','2018-03-25 18:14:12','::1'),(67,10,'bilal','2018-03-25 18:14:23','::1'),(68,10,'bilal','2018-03-25 18:15:12','::1'),(69,1,'admin','2018-03-25 18:15:32','::1'),(70,1,'admin','2018-03-25 18:26:56','::1'),(71,10,'bilal','2018-03-25 18:27:07','::1'),(72,1,'admin','2018-03-25 18:28:15','::1'),(73,1,'admin','2018-03-25 18:32:59','::1'),(74,10,'bilal','2018-03-25 18:33:26','::1'),(75,1,'admin','2018-03-25 18:40:18','::1'),(76,1,'admin','2018-03-25 18:40:50','::1'),(77,10,'bilal','2018-03-25 18:41:05','::1');

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `permissionid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  PRIMARY KEY (`permissionid`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `permissions` */

insert  into `permissions`(`permissionid`,`name`,`description`,`createdon`,`createdby`) values (1,'perm1','perm1 jk','2018-03-16 17:11:52',1),(6,'perm4','perm4','2018-03-16 23:35:29',1),(7,'perm5','perm5','2018-03-17 00:11:48',1),(9,'perm10','ygjhnkm','2018-03-25 13:24:34',10);

/*Table structure for table `role_permission` */

DROP TABLE IF EXISTS `role_permission`;

CREATE TABLE `role_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roleid` int(11) DEFAULT NULL,
  `permissionid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `roleid` (`roleid`),
  KEY `permissionid` (`permissionid`),
  CONSTRAINT `role_permission_ibfk_1` FOREIGN KEY (`roleid`) REFERENCES `roles` (`roleid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_permission_ibfk_2` FOREIGN KEY (`permissionid`) REFERENCES `permissions` (`permissionid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

/*Data for the table `role_permission` */

insert  into `role_permission`(`id`,`roleid`,`permissionid`) values (12,6,7),(13,1,9),(19,6,7),(21,6,7),(22,6,9);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `roleid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  PRIMARY KEY (`roleid`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `roles` */

insert  into `roles`(`roleid`,`name`,`description`,`createdon`,`createdby`) values (1,'manager','manages','2018-03-16 16:22:43',1),(6,'employee','tasking','2018-03-16 16:58:46',1),(13,'leader','leads the world','2018-03-25 13:05:48',1),(15,'sweeper','sweeps','2018-03-25 13:11:44',10),(16,'master','teach','2018-03-25 15:17:38',1);

/*Table structure for table `user_role` */

DROP TABLE IF EXISTS `user_role`;

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `roleid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `roleid` (`roleid`),
  CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`roleid`) REFERENCES `roles` (`roleid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

/*Data for the table `user_role` */

insert  into `user_role`(`id`,`userid`,`roleid`) values (19,10,1),(25,10,13),(26,10,15),(27,65,13);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `countryid` int(11) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `isadmin` int(1) DEFAULT NULL,
  `cityid` int(11) DEFAULT NULL,
  PRIMARY KEY (`userid`),
  KEY `cityid` (`cityid`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`cityid`) REFERENCES `city` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`userid`,`login`,`password`,`name`,`email`,`countryid`,`createdon`,`createdby`,`isadmin`,`cityid`) values (1,'admin','admin','admin','admin',1,'2018-03-16 23:23:22',0,1,1),(10,'bilal','123','bilal','bilal@live.com',3,'2018-03-20 23:23:25',10,0,5),(65,'usama','123','usama','usama@yahoo.com',1,'2018-03-25 13:14:20',10,0,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
