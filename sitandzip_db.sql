/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 10.1.37-MariaDB : Database - sitandzipfinal
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `sitandzipfinal`;

/*Table structure for table `customersaccount_tbl` */

DROP TABLE IF EXISTS `customersaccount_tbl`;

CREATE TABLE `customersaccount_tbl` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_fullname` varchar(255) NOT NULL,
  `customer_contactnumber` varchar(255) NOT NULL,
  `customer_username` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_password` varchar(255) NOT NULL,
  `customer_token` varchar(255) DEFAULT NULL,
  `customer_status` varchar(255) NOT NULL,
  `customer_role` int(11) NOT NULL,
  `customer_datecreated` datetime NOT NULL,
  `customer_datedeactivated` datetime DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `customersaccount_tbl` */

insert  into `customersaccount_tbl`(`customer_id`,`customer_fullname`,`customer_contactnumber`,`customer_username`,`customer_email`,`customer_password`,`customer_token`,`customer_status`,`customer_role`,`customer_datecreated`,`customer_datedeactivated`) values 
(1,'Bryan Balaga','09070680221','bryan','bry@gmail.com','$2y$10$KmLyXmxP9kio6GoRbwidT.pkyJFqMo9vOuALtZlfZZGVMkR8BGQ4G',NULL,'Active',0,'2019-04-21 06:04:30',NULL),
(2,'','','bryan1','bry1@gmail.com','$2y$10$ze9/0e8BU6Vxf9/RqMl92.hlMa5yGaLT5Vta/eRvwGAOVDU3Dp9nm',NULL,'Active',0,'2019-04-21 06:07:47',NULL),
(3,'','','bryan1','bry1@gmail.com','$2y$10$eGo0M0WiaUQZxAz/Bc8dmOKBdGe2qrfAoT3mGxVgZb0Ffa7y4bZR6',NULL,'Active',0,'2019-04-21 06:07:47',NULL),
(4,'','','bryan2','bryan2@gmail.com','$2y$10$qUhskalgVwUJdsZfHKp4n.Q1FYCT8PAJ0w1V5RVvw//Vz2CRcHDN6',NULL,'Active',0,'2019-04-22 04:21:56',NULL);

/*Table structure for table `employeesaccount_tbl` */

DROP TABLE IF EXISTS `employeesaccount_tbl`;

CREATE TABLE `employeesaccount_tbl` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_username` varchar(255) NOT NULL,
  `employee_email` varchar(255) NOT NULL,
  `employee_password` varchar(255) NOT NULL,
  `employee_firstname` varchar(255) DEFAULT NULL,
  `employee_lastname` varchar(255) DEFAULT NULL,
  `employee_contactnumber` varchar(255) DEFAULT NULL,
  `employee_position` varchar(255) NOT NULL,
  `employee_role` int(11) NOT NULL,
  `employee_status` varchar(255) NOT NULL,
  `employee_datecreated` datetime NOT NULL,
  `employee_datedeactivated` datetime DEFAULT NULL,
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `employeesaccount_tbl` */

insert  into `employeesaccount_tbl`(`employee_id`,`employee_username`,`employee_email`,`employee_password`,`employee_firstname`,`employee_lastname`,`employee_contactnumber`,`employee_position`,`employee_role`,`employee_status`,`employee_datecreated`,`employee_datedeactivated`) values 
(1,'Admin','admin@gmail.com','$2y$10$uOW10KwmSXSucX1aNk9.n.uMes51w9R.AYdLgq7a2clCXsrF9nEMm','Bryan','Balaga','09070680221','Admin',1,'Active','2019-04-22 04:25:16',NULL),
(5,'Cashier','cashier@gmail.com','$2y$10$pzuu4v3Ud7ykLDj5Nd3rLekaBpcmIOMmvbHox0Ml2R0UjrnvxzvQ2',NULL,NULL,NULL,'Cashier',1,'Active','2019-05-22 14:19:24',NULL),
(6,'Cook1','cook@gmail.com','$2y$10$BNN05zxjnx3S/vP8CO0SC.fBoFXK8ie0klSmBr6xKXA37yvIqhT8a','Jayvie','Malaluan','09123456789','Cook',1,'Active','2019-05-22 14:37:19',NULL),
(7,'Cashier1','cashier1@gmail.com','$2y$10$mzmJ7vXIZXs/tTKsdwYTregg/1daJhMbMvIORODxxBknJLUK1kGI6',NULL,NULL,NULL,'Cashier',1,'Active','2019-05-22 15:48:03',NULL),
(8,'staff','staff@gmail.com','$2y$10$Z1Sibw0IU8aUcPgqQPnt1uRtJ1A6wIGwPHko2NPh1GkzOJ70tBl86',NULL,NULL,NULL,'Staff',1,'Deactivated','2019-05-23 02:23:21','2019-05-23 04:32:38'),
(9,'Cook2','cook2@gmail.com','$2y$10$PGNiOmTDm6P4Y.YsSgXBLOBtP5QKOBZ3Ql5i0L8OI7s1dGyBs4uT2',NULL,NULL,NULL,'Cook',1,'Active','2019-05-23 03:32:22',NULL),
(10,'Staff2','staff2@gmail.com','$2y$10$g6lxAfNoiPs.WSsVG6vnVecdJOCFpJi5xeI5YdSxHlBCkKBF9C3zi',NULL,NULL,NULL,'Staff',1,'Active','2019-05-23 03:33:02',NULL);

/*Table structure for table `expenses_tbl` */

DROP TABLE IF EXISTS `expenses_tbl`;

CREATE TABLE `expenses_tbl` (
  `expenses_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `item_quantity` int(11) NOT NULL,
  `item_total` decimal(10,2) NOT NULL,
  `item_datepurchased` date NOT NULL,
  `expenses_status` varchar(255) NOT NULL,
  PRIMARY KEY (`expenses_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `expenses_tbl` */

insert  into `expenses_tbl`(`expenses_id`,`employee_id`,`item_price`,`item_quantity`,`item_total`,`item_datepurchased`,`expenses_status`) values 
(1,1,230.00,12,2760.00,'2019-05-23','Verified'),
(2,1,140.00,9,1260.00,'2019-05-16','Verified'),
(3,1,9.00,29,261.00,'2019-05-22','Void'),
(4,1,130.00,14,1820.00,'2019-05-26','Verified'),
(5,1,45.00,2,90.00,'2019-05-26','Verified');

/*Table structure for table `inventory_tbl` */

DROP TABLE IF EXISTS `inventory_tbl`;

CREATE TABLE `inventory_tbl` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_description` mediumtext NOT NULL,
  `item_quantity` int(11) NOT NULL,
  `item_status` varchar(255) NOT NULL,
  `item_dateupdated` date NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `inventory_tbl` */

insert  into `inventory_tbl`(`item_id`,`employee_id`,`item_name`,`item_description`,`item_quantity`,`item_status`,`item_dateupdated`) values 
(1,1,'Beef','13 Kilos of Beef',12,'On stock','2019-05-24'),
(2,1,'Chicken','9 Kilos of Chicken',9,'On stock','2019-05-24'),
(3,1,'candy','30 packs of candy',29,'Void','2019-05-25'),
(4,1,'Chicken','14 kilos of Chicken',14,'On stock','0000-00-00'),
(5,1,'Ice','2pcs of 5 kilograms of Ice',0,'Out of stock','2019-05-26');

/*Table structure for table `messages_tbl` */

DROP TABLE IF EXISTS `messages_tbl`;

CREATE TABLE `messages_tbl` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `message_fullname` varchar(255) NOT NULL,
  `message_email` varchar(255) NOT NULL,
  `message_subject` varchar(255) NOT NULL,
  `message_body` mediumtext NOT NULL,
  `message_date` datetime NOT NULL,
  `message_status` varchar(255) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `messages_tbl` */

insert  into `messages_tbl`(`message_id`,`employee_id`,`message_fullname`,`message_email`,`message_subject`,`message_body`,`message_date`,`message_status`) values 
(1,0,'Bryan Balaga','bryan@gmail.com','Inquiry','Open po ba kayo ngayon?','2019-05-24 00:00:00','Unread'),
(2,0,'Apple Rose Gabales','apple@gmail.com','Inquire po','Open po ba kayo bukas?','2019-05-24 00:00:00','Archived'),
(3,0,'Apple Rose Balaga','apple@gmail.com','Inquiry','Hi','2019-05-25 14:07:32','Unread');

/*Table structure for table `orders_tbl` */

DROP TABLE IF EXISTS `orders_tbl`;

CREATE TABLE `orders_tbl` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_transactionid` varchar(255) NOT NULL,
  `order_productname` varchar(255) NOT NULL,
  `order_quantity` int(11) NOT NULL,
  `order_status` varchar(255) NOT NULL,
  `order_preparedby` varchar(255) NOT NULL,
  PRIMARY KEY (`order_id`,`order_transactionid`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*Data for the table `orders_tbl` */

insert  into `orders_tbl`(`order_id`,`order_transactionid`,`order_productname`,`order_quantity`,`order_status`,`order_preparedby`) values 
(1,'20190506163743','Wintermelon',2,'Completed','Admin'),
(2,'20190506163743','Buffalo Wings',1,'Completed','Admin'),
(3,'20190506163743','Matcha Oreo',3,'Completed','Admin'),
(4,'20190506165250','Wintermelon',2,'Completed','Admin'),
(5,'20190506165250','Buffalo Wings',2,'Completed','Admin'),
(6,'20190506165250','Matcha Oreo',1,'Completed','Admin'),
(7,'20190507035921','Breaded Porkchop',1,'Completed','Admin'),
(8,'20190507035921','Tocilog',2,'Completed','Admin'),
(9,'20190507035921','Lechon Paksiw',1,'Completed','Admin'),
(10,'20190507035921','Daing na Bangus with Salted Egg',1,'Completed','Admin'),
(11,'20190507035921','Set C',1,'Completed','Admin'),
(12,'20190507035921','Chicken Nuggets',1,'Completed','Admin'),
(13,'20190507035921','Lumpiang Shanghai',4,'Completed','Admin'),
(14,'20190511153816','Meaty Spaghetti',1,'Completed','Admin'),
(15,'20190511153816','Bolognese',2,'Completed','Admin'),
(16,'20190512060603','Set A',1,'Completed','Admin'),
(17,'20190512060603','Matcha Oreo',1,'Completed','Admin'),
(18,'20190520032415','Winter melon',1,'Completed','Admin'),
(19,'20190520032415','Matcha Oreo',1,'Completed','Admin'),
(20,'20190520133052','Set A',1,'Completed','Admin'),
(21,'20190520133052','Set B',1,'Completed','Admin'),
(22,'20190520133052','Sweet&Sour Fish Fillet',1,'Completed','Admin'),
(23,'20190520133523','Bolognese',2,'Completed','Admin'),
(24,'20190521055309','Fried Chicken',1,'Completed','Admin'),
(25,'20190523145936','Burger Steak',1,'Completed','Admin'),
(26,'20190523145936','Matcha Oreo',1,'Completed','Admin');

/*Table structure for table `productcategories_tbl` */

DROP TABLE IF EXISTS `productcategories_tbl`;

CREATE TABLE `productcategories_tbl` (
  `productcategory_id` int(11) NOT NULL AUTO_INCREMENT,
  `productcategory_name` varchar(255) NOT NULL,
  `productcategory_status` varchar(255) NOT NULL,
  PRIMARY KEY (`productcategory_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `productcategories_tbl` */

insert  into `productcategories_tbl`(`productcategory_id`,`productcategory_name`,`productcategory_status`) values 
(1,'Boodle Fight!','Archived'),
(2,'Silog','Active'),
(3,'Burger','Active'),
(4,'Pasta','Active'),
(5,'Grilled','Active'),
(6,'Frappe','Active'),
(7,'Rice Meal','Active'),
(8,'Milk Tea','Active'),
(9,'Overload','Active'),
(10,'Sandwich','Active'),
(11,'Appetizer','Active'),
(12,'Beverages','Active'),
(13,'Boodle FightX','Active');

/*Table structure for table `products_tbl` */

DROP TABLE IF EXISTS `products_tbl`;

CREATE TABLE `products_tbl` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `productcategory_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_status` varchar(255) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

/*Data for the table `products_tbl` */

insert  into `products_tbl`(`product_id`,`productcategory_id`,`product_name`,`product_price`,`product_description`,`product_status`) values 
(1,6,'Chocolate',99.00,'','Active'),
(2,7,'Buffalo Wings',119.00,'','Active'),
(3,8,'Winter melon',99.00,'','Active'),
(4,6,'Matcha Oreo',125.00,'','Active'),
(5,1,'Set A',599.00,'','Archived'),
(6,1,'Set B',679.00,'','Archived'),
(7,1,'Set C',1249.00,'','Archived'),
(8,7,'Burger Steak',95.00,'','Active'),
(9,7,'Lechon Kawali',95.00,'','Active'),
(10,7,'Fish Fillet',99.00,'','Active'),
(11,7,'Fried Chicken',99.00,'','Active'),
(12,7,'Pork Sisig',99.00,'','Active'),
(13,7,'Sweet&amp;Sour Fish Fillet',99.00,'','Active'),
(14,7,'Daing na Bangus with Salted Egg',99.00,'','Active'),
(15,7,'Chicharon Bulaklak',99.00,'','Active'),
(16,7,'Porkchop',95.00,'','Active'),
(17,7,'Chicken Fillet',99.00,'','Active'),
(18,7,'Lumpiang Shanghai',79.00,'','Active'),
(19,7,'Chicken Nuggets',89.00,'','Active'),
(20,7,'Lechon Paksiw',99.00,'','Active'),
(21,7,'Breaded Porkchop',110.00,'','Active'),
(22,2,'Tapsilog',109.00,'','Active'),
(23,2,'Bangsilog',99.00,'','Active'),
(24,2,'Spamsilog',85.00,'','Active'),
(25,2,'Chixsilog',109.00,'','Active'),
(26,2,'Lechonsilog',99.00,'','Active'),
(27,2,'Longsilog',95.00,'','Active'),
(28,2,'Tocilog',89.00,'','Active'),
(29,2,'Hotsilog',79.00,'','Active'),
(30,2,'Porksilog',99.00,'','Active'),
(31,2,'Cornsilog',79.00,'','Active'),
(32,2,'Shangsilog',85.00,'','Active'),
(33,5,'Inihaw na Liempo',120.00,'','Active'),
(34,5,'Inihaw na Porkchop',100.00,'','Active'),
(35,5,'Inihaw na Pusit',160.00,'','Active'),
(36,5,'Inihaw na Manok',120.00,'','Active'),
(37,5,'Pork Barbeque',100.00,'','Active'),
(38,5,'Inihaw na Tilapia',150.00,'','Active'),
(39,4,'Carbonara',120.00,'','Active'),
(40,4,'Bolognese',120.00,'','Active'),
(41,4,'Meaty Spaghetti',120.00,'','Active');

/*Table structure for table `reservations_tbl` */

DROP TABLE IF EXISTS `reservations_tbl`;

CREATE TABLE `reservations_tbl` (
  `reservation_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `reservation_fullname` varchar(255) NOT NULL,
  `reservation_email` varchar(255) NOT NULL,
  `reservation_contactnumber` varchar(255) NOT NULL,
  `reservation_numberofpeople` int(11) NOT NULL,
  `reservation_date` date NOT NULL,
  `reservation_time` varchar(255) NOT NULL,
  `reservation_message` mediumtext NOT NULL,
  `reservation_status` varchar(255) NOT NULL,
  PRIMARY KEY (`reservation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `reservations_tbl` */

insert  into `reservations_tbl`(`reservation_id`,`customer_id`,`employee_id`,`reservation_fullname`,`reservation_email`,`reservation_contactnumber`,`reservation_numberofpeople`,`reservation_date`,`reservation_time`,`reservation_message`,`reservation_status`) values 
(1,1,1,'Bryan Balaga','bry@gmail.com','01298301293',3,'2019-05-25','6:59 PM','Pa reserve po','Approved'),
(2,1,0,'Bryan Balaga','bry@gmail.com','09070680221',2,'2019-05-26','12:57 PM','Pa reserve oy','Cancelled'),
(3,1,1,'Bryan Balaga','bry@gmail.com','09070680221',5,'2019-05-29','2:00 PM','Wowowin','Rejected');

/*Table structure for table `sales_tbl` */

DROP TABLE IF EXISTS `sales_tbl`;

CREATE TABLE `sales_tbl` (
  `sales_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_transactionid` varchar(255) NOT NULL,
  `sales_totalamount` decimal(10,2) NOT NULL,
  `sales_payment` decimal(10,2) NOT NULL,
  `sales_change` decimal(10,2) NOT NULL,
  `sales_transactby` varchar(255) NOT NULL,
  `sales_date` datetime NOT NULL,
  PRIMARY KEY (`sales_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `sales_tbl` */

insert  into `sales_tbl`(`sales_id`,`order_transactionid`,`sales_totalamount`,`sales_payment`,`sales_change`,`sales_transactby`,`sales_date`) values 
(1,'20190506163743',692.00,700.00,8.00,'Admin','2019-05-06 16:38:58'),
(2,'20190506165250',561.00,600.00,39.00,'Admin','2019-05-06 16:53:46'),
(3,'20190507035921',2140.00,2500.00,360.00,'Admin','2019-05-07 04:00:17'),
(4,'20190511153816',360.00,400.00,40.00,'Admin','2019-05-11 15:38:38'),
(5,'20190512060603',724.00,800.00,76.00,'Admin','2019-05-12 06:06:17'),
(6,'20190520032415',224.00,300.00,76.00,'Admin','2019-05-20 03:25:52'),
(7,'20190520133052',1377.00,1400.00,23.00,'Admin','2019-05-20 13:31:07'),
(8,'20190520133523',240.00,300.00,60.00,'Admin','2019-05-20 13:35:48'),
(9,'20190521055309',99.00,100.00,1.00,'Admin','2019-05-21 05:53:42'),
(10,'20190523145936',220.00,225.50,5.50,'Admin','2019-05-23 15:00:01');

/*Table structure for table `testimonials_tbl` */

DROP TABLE IF EXISTS `testimonials_tbl`;

CREATE TABLE `testimonials_tbl` (
  `testimonials_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `testimonials_message` mediumtext NOT NULL,
  PRIMARY KEY (`testimonials_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `testimonials_tbl` */

insert  into `testimonials_tbl`(`testimonials_id`,`customer_id`,`testimonials_message`) values 
(1,1,'Masarap yung mga food and worth it. Sure babalik kami.');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
