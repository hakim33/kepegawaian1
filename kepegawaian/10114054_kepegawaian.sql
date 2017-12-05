/*
SQLyog Ultimate v10.42 
MySQL - 5.5.5-10.1.21-MariaDB : Database - 10114054_kepegawaian
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`10114054_kepegawaian` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `10114054_kepegawaian`;

/*Table structure for table `absences` */

DROP TABLE IF EXISTS `absences`;

CREATE TABLE `absences` (
  `tanggal` date NOT NULL,
  `nip` varchar(6) NOT NULL,
  `status` char(1) DEFAULT 'N',
  KEY `nip` (`nip`),
  CONSTRAINT `absences_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `employees` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `absences` */

insert  into `absences`(`tanggal`,`nip`,`status`) values ('2017-06-26','116001','N'),('2017-06-26','116002','N'),('2017-06-26','216002','N'),('2017-06-26','216003','N'),('2017-06-26','316001','h'),('2017-06-26','316002','N'),('2017-06-26','416001','N'),('2017-06-25','116001','N'),('2017-06-25','116002','N'),('2017-06-25','216002','N'),('2017-06-25','216003','N'),('2017-06-25','316001','i'),('2017-06-25','316002','N'),('2017-06-25','416001','N'),('2017-07-24','116001','h'),('2017-07-24','116002','s'),('2017-07-24','216002','i'),('2017-07-24','216003','a'),('2017-07-24','316001','a'),('2017-07-24','316002','i'),('2017-07-24','416001','s');

/*Table structure for table `accounts` */

DROP TABLE IF EXISTS `accounts`;

CREATE TABLE `accounts` (
  `nip` varchar(6) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`username`),
  KEY `nip` (`nip`),
  CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `employees` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `accounts` */

insert  into `accounts`(`nip`,`username`,`password`) values ('116001','samplea','$2y$10$ZXYws5w4jFjHiuZJtD6hNO1DamQvuxfxT9bShno1rxrErceVhItFG'),('316001','samplee','$2y$10$Z1ipFNCPme2sypgLuN4Vl.YKEClI0uUx7Xajwmzfv6G8nQJBCiMru');

/*Table structure for table `employees` */

DROP TABLE IF EXISTS `employees`;

CREATE TABLE `employees` (
  `nip` varchar(6) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `kelamin` enum('P','W') NOT NULL,
  `jabatan` varchar(25) DEFAULT NULL,
  `gaji` int(11) DEFAULT '0',
  `tgl_masuk` date DEFAULT NULL,
  `telepon` text,
  `alamat` text,
  `status` tinyint(3) unsigned DEFAULT '1',
  PRIMARY KEY (`nip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `employees` */

insert  into `employees`(`nip`,`nama`,`kelamin`,`jabatan`,`gaji`,`tgl_masuk`,`telepon`,`alamat`,`status`) values ('116001','sample a','W','manager',8000000,'2017-07-03','','',1),('116002','sample b','P','manager',1000000,NULL,'','',1),('216002','sample c','P','manager',100000,NULL,'','',1),('216003','sample d','P','desainer',7000000,NULL,'','',1),('316001','sample e','P','programmer',7000000,'2017-06-15','sdfsd','fdsfdsfdsfdsfsss',1),('316002','sample f','P','manager',7000000,NULL,'','',1),('416001','sample g','W','jurnalis',5000000,NULL,'','',1);

/*Table structure for table `project_details` */

DROP TABLE IF EXISTS `project_details`;

CREATE TABLE `project_details` (
  `nip` varchar(6) NOT NULL,
  `no` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned DEFAULT '1',
  KEY `nip` (`nip`),
  KEY `no` (`no`),
  CONSTRAINT `project_details_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `employees` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `project_details_ibfk_2` FOREIGN KEY (`no`) REFERENCES `projects` (`no`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `project_details` */

insert  into `project_details`(`nip`,`no`,`status`) values ('316001',1,2),('316001',2,2),('316001',6,2),('316001',7,2),('316001',8,2);

/*Table structure for table `projects` */

DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
  `no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_proyek` text NOT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `status` tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `projects` */

insert  into `projects`(`no`,`nama_proyek`,`tgl_mulai`,`tgl_selesai`,`status`) values (1,'asdasd','2017-06-21','2017-06-28',1),(2,'fsfdsf','2017-06-06','2017-06-29',1),(6,'dsfsddfs','2017-06-28','2017-06-30',1),(7,'asdasd','2017-06-06','2017-06-15',1),(8,'Percobaan Pertama','2017-06-05','2017-06-30',0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
