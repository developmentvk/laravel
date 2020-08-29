/*
SQLyog Ultimate v11.5 (64 bit)
MySQL - 10.3.22-MariaDB-1ubuntu1 : Database - laravel
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`laravel` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `laravel`;

/*Table structure for table `admin_login_logs` */

DROP TABLE IF EXISTS `admin_login_logs`;

CREATE TABLE `admin_login_logs` (
  `id` bigint(50) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` bigint(20) unsigned DEFAULT NULL,
  `login_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logout_at` timestamp NULL DEFAULT NULL,
  `duration` time DEFAULT NULL,
  `device_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`),
  CONSTRAINT `admin_login_logs_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `admin_login_logs` */

insert  into `admin_login_logs`(`id`,`admin_id`,`login_at`,`ip_address`,`browser`,`logout_at`,`duration`,`device_id`,`device_type`,`created_at`,`updated_at`) values (1,2,'2020-08-29 16:14:42','127.0.0.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:79.0) Gecko/20100101 Firefox/79.0',NULL,NULL,NULL,'web','2020-08-29 16:14:42','2020-08-29 16:14:42'),(2,2,'2020-08-29 16:15:09','127.0.0.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:79.0) Gecko/20100101 Firefox/79.0',NULL,NULL,NULL,'web','2020-08-29 16:15:09','2020-08-29 16:15:09'),(3,2,'2020-08-29 16:29:55','127.0.0.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:79.0) Gecko/20100101 Firefox/79.0',NULL,NULL,NULL,'web','2020-08-29 16:29:55','2020-08-29 16:29:55');

/*Table structure for table `admin_permissions` */

DROP TABLE IF EXISTS `admin_permissions`;

CREATE TABLE `admin_permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `navigation_id` bigint(20) unsigned DEFAULT NULL,
  `admin_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `navigation_id` (`navigation_id`),
  KEY `admin_id` (`admin_id`),
  CONSTRAINT `admin_permissions_ibfk_1` FOREIGN KEY (`navigation_id`) REFERENCES `navigations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `admin_permissions_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `admin_permissions` */

/*Table structure for table `admins` */

DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `profile_image` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_id` bigint(20) unsigned DEFAULT NULL,
  `login_log_id` bigint(50) unsigned DEFAULT NULL,
  `en_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dial_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT '91',
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'Active' COMMENT '0.Inactive, 1.Active, 2.Block',
  `locale` enum('en') COLLATE utf8mb4_unicode_ci DEFAULT 'en',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `login_log_id` (`login_log_id`),
  KEY `role_id` (`department_id`),
  CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`login_log_id`) REFERENCES `admin_login_logs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `admins_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `admins` */

insert  into `admins`(`id`,`profile_image`,`department_id`,`login_log_id`,`en_name`,`name`,`username`,`email`,`dial_code`,`mobile`,`password`,`status`,`locale`,`remember_token`,`created_at`,`updated_at`) values (1,NULL,1,NULL,'Laravel','Laravel','admin@demo.com','admin@demo.com','91','9999999999','$2y$10$LnzuC/kTbAvgqFHzDyPcTeez/SPMkg99uKxYxtZCD/tPAEOFw2YxK','Active','','JcjhtayPoKSZtIHHp71ZSppfGVlmyjxfWeosA9QoWTJzxkmPWYxaeO6KbhRy','2020-08-20 08:36:55','2020-08-26 06:53:19'),(2,NULL,1,3,'Virendra','Virendra','virendra','development.vk@hotmail.com','91','9990418225','$2y$10$RhHoID1FpEePNc0SrVshNua5auTCEq49XZaBKQewGgCv1QjYxNXgK','Active','en',NULL,'2020-08-21 11:19:01','2020-08-29 16:29:55');

/*Table structure for table `countries` */

DROP TABLE IF EXISTS `countries`;

CREATE TABLE `countries` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `en_name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dial_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alpha_2` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alpha_3` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax` decimal(5,2) DEFAULT 18.00,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'Active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=226 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `countries` */

insert  into `countries`(`id`,`name`,`en_name`,`dial_code`,`alpha_2`,`alpha_3`,`currency`,`flag`,`tax`,`status`,`created_at`,`updated_at`) values (1,'Afghanistan','Afghanistan','93','AF','AFG','AFN','AFG_s.png','0.00','Active','2019-03-05 14:13:05','2019-03-05 14:13:05'),(2,'Albania','Albania','355','AL','ALB','ALL','ALB_s.png','0.00','Active','2019-03-05 14:13:05','2019-03-05 14:13:05'),(3,'Algeria','Algeria','213','DZ','DZA','DZD','DZA_s.png','0.00','Active','2019-03-05 14:13:05','2019-03-05 14:13:05'),(4,'American Samoa','American Samoa','1','AS','ASM','USD','ASM_s.png','0.00','Active','2019-03-05 14:13:05','2019-03-05 14:13:05'),(5,'Andorra','Andorra','376','AD','AND','EUR','AND_s.png','0.00','Active','2019-03-05 14:13:06','2019-03-05 14:13:06'),(6,'Angola','Angola','244','AO','AGO','AOA','AGO_s.png','0.00','Active','2019-03-05 14:13:06','2019-03-05 14:13:06'),(7,'Anguilla','Anguilla','1','AI','AIA','XCD','AIA_s.png','0.00','Active','2019-03-05 14:13:06','2019-03-05 14:13:06'),(8,'Antarctica','Antarctica','672','AQ','ATA','AUD','ATA_s.png','0.00','Active','2019-03-05 14:13:06','2019-03-05 14:13:06'),(9,'Argentina','Argentina','54','AR','ARG','ARS','ARG_s.png','0.00','Active','2019-03-05 14:13:06','2019-03-05 14:13:06'),(10,'Armenia','Armenia','374','AM','ARM','AMD','ARM_s.png','0.00','Active','2019-03-05 14:13:06','2019-03-05 14:13:06'),(11,'Aruba','Aruba','297','AW','ABW','AWG','ABW_s.png','0.00','Active','2019-03-05 14:13:06','2019-03-28 05:20:08'),(12,'Australia','Australia','61','AU','AUS','AUD','AUS_s.png','0.00','Active','2019-03-05 14:13:06','2019-03-05 14:13:06'),(13,'Austria','Austria','43','AT','AUT','EUR','AUT_s.png','0.00','Active','2019-03-05 14:13:06','2019-03-05 14:13:06'),(14,'Azerbaijan','Azerbaijan','994','AZ','AZE','AZN','AZE_s.png','0.00','Active','2019-03-05 14:13:06','2019-03-05 14:13:06'),(15,'Bahamas','Bahamas','1','BS','BHS','BSD','BHS_s.png','0.00','Active','2019-03-05 14:13:06','2019-03-05 14:13:06'),(16,'Bahrain','Bahrain','973','BH','BHR','BHD','BHR_s.png','0.00','Active','2019-03-05 14:13:06','2019-03-05 14:13:06'),(17,'Bangladesh','Bangladesh','880','BD','BGD','BDT','BGD_s.png','0.00','Active','2019-03-05 14:13:07','2019-03-05 14:13:07'),(18,'Barbados','Barbados','1','BB','BRB','BBD','BRB_s.png','0.00','Active','2019-03-05 14:13:07','2019-03-05 14:13:07'),(19,'Belarus','Belarus','375','BY','BLR','BYR','BLR_s.png','0.00','Active','2019-03-05 14:13:07','2019-03-05 14:13:07'),(20,'Belgium','Belgium','32','BE','BEL','EUR','BEL_s.png','0.00','Active','2019-03-05 14:13:07','2019-03-05 14:13:07'),(21,'Belize','Belize','501','BZ','BLZ','BZD','BLZ_s.png','0.00','Active','2019-03-05 14:13:07','2019-03-05 14:13:07'),(22,'Benin','Benin','229','BJ','BEN','XOF','BEN_s.png','0.00','Active','2019-03-05 14:13:07','2019-03-05 14:13:07'),(23,'Bermuda','Bermuda','1','BM','BMU','BMD','BMU_s.png','0.00','Active','2019-03-05 14:13:07','2019-03-05 14:13:07'),(24,'Bhutan','Bhutan','975','BT','BTN','BTN','BTN_s.png','0.00','Active','2019-03-05 14:13:07','2019-03-05 14:13:07'),(25,'Bolivia','Bolivia','591','BO','BOL','BOB','BOL_s.png','0.00','Active','2019-03-05 14:13:07','2019-03-05 14:13:07'),(26,'Bosnia and Herzegovina','Bosnia and Herzegovina','387','BA','BIH','BAM','BIH_s.png','0.00','Active','2019-03-05 14:13:07','2019-03-05 14:13:07'),(27,'Botswana','Botswana','267','BW','BWA','BWP','BWA_s.png','0.00','Active','2019-03-05 14:13:07','2019-03-05 14:13:07'),(28,'Brazil','Brazil','55','BR','BRA','BRL','BRA_s.png','0.00','Active','2019-03-05 14:13:07','2019-03-05 14:13:07'),(29,'British Virgin Islands','British Virgin Islands','1','VG','VGB','USD','VGB_s.png','0.00','Active','2019-03-05 14:13:07','2019-03-05 14:13:07'),(30,'Brunei','Brunei','673','BN','BRN','BND','BRN_s.png','0.00','Active','2019-03-05 14:13:07','2019-03-05 14:13:07'),(31,'Bulgaria','Bulgaria','359','BG','BGR','BGN','BGR_s.png','0.00','Active','2019-03-05 14:13:08','2019-03-05 14:13:08'),(32,'Burkina Faso','Burkina Faso','226','BF','BFA','XOF','BFA_s.png','0.00','Active','2019-03-05 14:13:08','2019-03-05 14:13:08'),(33,'Burundi','Burundi','257','BI','BDI','BIF','BDI_s.png','0.00','Active','2019-03-05 14:13:08','2019-03-05 14:13:08'),(34,'Cambodia','Cambodia','855','KH','KHM','KHR','KHM_s.png','0.00','Active','2019-03-05 14:13:08','2019-03-05 14:13:08'),(35,'Cameroon','Cameroon','237','CM','CMR','XAF','CMR_s.png','0.00','Active','2019-03-05 14:13:08','2019-03-05 14:13:08'),(36,'Canada','Canada','1','CA','CAN','CAD','CAN_s.png','0.00','Active','2019-03-05 14:13:08','2019-03-05 14:13:08'),(37,'Cape Verde','Cape Verde','238','CV','CPV','CVE','CPV_s.png','0.00','Active','2019-03-05 14:13:08','2019-03-05 14:13:08'),(38,'Cayman Islands','Cayman Islands','1345','KY','CYM','KYD','CYM_s.png','0.00','Active','2019-03-05 14:13:08','2019-03-05 14:13:08'),(39,'Central African Republic','Central African Republic','236','CF','CAF','XAF','CAF_s.png','0.00','Active','2019-03-05 14:13:08','2019-03-05 14:13:08'),(40,'Chile','Chile','56','CL','CHL','CLP','CHL_s.png','0.00','Active','2019-03-05 14:13:08','2019-03-05 14:13:08'),(41,'China','China','86','CN','CHN','CNY','CHN_s.png','0.00','Active','2019-03-05 14:13:08','2019-03-05 14:13:08'),(42,'Colombia','Colombia','57','CO','COL','COP','COL_s.png','0.00','Active','2019-03-05 14:13:08','2019-03-05 14:13:08'),(43,'Comoros','Comoros','269','KM','COM','KMF','COM_s.png','0.00','Active','2019-03-05 14:13:08','2019-03-05 14:13:08'),(44,'Cook Islands','Cook Islands','682','CK','COK','NZD','COK_s.png','0.00','Active','2019-03-05 14:13:08','2019-03-05 14:13:08'),(45,'Costa Rica','Costa Rica','506','CR','CRI','CRC','CRI_s.png','0.00','Active','2019-03-05 14:13:08','2019-03-05 14:13:08'),(46,'Croatia','Croatia','385','HR','HRV','HRK','HRV_s.png','0.00','Active','2019-03-05 14:13:08','2019-03-05 14:13:08'),(47,'Cuba','Cuba','53','CU','CUB','CUP','CUB_s.png','0.00','Active','2019-03-05 14:13:09','2019-03-05 14:13:09'),(48,'Curacao','Curacao','599','CW','CUW','ANG','CUW_s.png','0.00','Active','2019-03-05 14:13:09','2019-03-05 14:13:09'),(49,'Cyprus','Cyprus','357','CY','CYP','EUR','CYP_s.png','0.00','Active','2019-03-05 14:13:09','2019-03-05 14:13:09'),(50,'Czech Republic','Czech Republic','420','CZ','CZE','CZK','CZE_s.png','0.00','Active','2019-03-05 14:13:09','2019-03-05 14:13:09'),(51,'Democratic Republic of Congo','Democratic Republic of Congo','243','CD','COD','CDF','COD_s.png','0.00','Active','2019-03-05 14:13:09','2019-03-05 14:13:09'),(52,'Denmark','Denmark','45','DK','DNK','DKK','DNK_s.png','0.00','Active','2019-03-05 14:13:09','2019-03-05 14:13:09'),(53,'Djibouti','Djibouti','253','DJ','DJI','DJF','DJI_s.png','0.00','Active','2019-03-05 14:13:09','2019-03-05 14:13:09'),(54,'Dominica','Dominica','1','DM','DMA','XCD','DMA_s.png','0.00','Active','2019-03-05 14:13:09','2019-03-05 14:13:09'),(55,'Dominican Republic','Dominican Republic','1','DO','DOM','DOP','DOM_s.png','0.00','Active','2019-03-05 14:13:09','2019-03-05 14:13:09'),(56,'East Timor','East Timor','670','TL','TLS','IDR','TLS_s.png','0.00','Active','2019-03-05 14:13:09','2019-03-05 14:13:09'),(57,'Ecuador','Ecuador','593','EC','ECU','USD','ECU_s.png','0.00','Active','2019-03-05 14:13:09','2019-03-05 14:13:09'),(58,'Egypt','Egypt','20','EG','EGY','EGP','EGY_s.png','0.00','Active','2019-03-05 14:13:09','2019-03-05 14:13:09'),(59,'El Salvador','El Salvador','503','SV','SLV','SVC','SLV_s.png','0.00','Active','2019-03-05 14:13:09','2019-03-05 14:13:09'),(60,'Equatorial Guinea','Equatorial Guinea','240','GQ','GNQ','XAF','GNQ_s.png','0.00','Active','2019-03-05 14:13:10','2019-03-05 14:13:10'),(61,'Eritrea','Eritrea','291','ER','ERI','ETB','ERI_s.png','0.00','Active','2019-03-05 14:13:10','2019-03-05 14:13:10'),(62,'Estonia','Estonia','372','EE','EST','EUR','EST_s.png','0.00','Active','2019-03-05 14:13:10','2019-03-05 14:13:10'),(63,'Ethiopia','Ethiopia','251','ET','ETH','ETB','ETH_s.png','0.00','Active','2019-03-05 14:13:10','2019-03-05 14:13:10'),(64,'Falkland Islands','Falkland Islands','500','FK','FLK','FKP','FLK_s.png','0.00','Active','2019-03-05 14:13:10','2019-03-05 14:13:10'),(65,'Faroe Islands','Faroe Islands','298','FO','FRO','DKK','FRO_s.png','0.00','Active','2019-03-05 14:13:10','2019-03-05 14:13:10'),(66,'Fiji','Fiji','679','FJ','FJI','FJD','FJI_s.png','0.00','Active','2019-03-05 14:13:10','2019-03-05 14:13:10'),(67,'Finland','Finland','358','FI','FIN','EUR','FIN_s.png','0.00','Active','2019-03-05 14:13:10','2019-03-05 14:13:10'),(68,'France','France','33','FR','FRA','EUR','FRA_s.png','0.00','Active','2019-03-05 14:13:10','2019-03-05 14:13:10'),(69,'French Polynesia','French Polynesia','689','PF','PYF','XPF','PYF_s.png','0.00','Active','2019-03-05 14:13:10','2019-03-05 14:13:10'),(70,'Gabon','Gabon','241','GA','GAB','XAF','GAB_s.png','0.00','Active','2019-03-05 14:13:10','2019-03-05 14:13:10'),(71,'Gambia','Gambia','220','GM','GMB','GMD','GMB_s.png','0.00','Active','2019-03-05 14:13:10','2019-03-05 14:13:10'),(72,'Georgia','Georgia','995','GE','GEO','GEL','GEO_s.png','0.00','Active','2019-03-05 14:13:11','2019-03-05 14:13:11'),(73,'Germany','Germany','49','DE','DEU','EUR','DEU_s.png','0.00','Active','2019-03-05 14:13:11','2019-03-05 14:13:11'),(74,'Ghana','Ghana','233','GH','GHA','GHS','GHA_s.png','0.00','Active','2019-03-05 14:13:11','2019-03-05 14:13:11'),(75,'Gibraltar','Gibraltar','350','GI','GIB','GIP','GIB_s.png','0.00','Active','2019-03-05 14:13:11','2019-03-05 14:13:11'),(76,'Greece','Greece','30','GR','GRC','EUR','GRC_s.png','0.00','Active','2019-03-05 14:13:11','2019-03-05 14:13:11'),(77,'Greenland','Greenland','299','GL','GRL','DKK','GRL_s.png','0.00','Active','2019-03-05 14:13:11','2019-03-05 14:13:11'),(78,'Guadeloupe','Guadeloupe','590','GP','GLP','EUR','GLP_s.png','0.00','Active','2019-03-05 14:13:11','2019-03-05 14:13:11'),(79,'Guam','Guam','1','GU','GUM','USD','GUM_s.png','0.00','Active','2019-03-05 14:13:11','2019-03-05 14:13:11'),(80,'Guatemala','Guatemala','502','GT','GTM','GTQ','GTM_s.png','0.00','Active','2019-03-05 14:13:11','2019-03-05 14:13:11'),(81,'Guinea','Guinea','224','GN','GIN','GNF','GIN_s.png','0.00','Active','2019-03-05 14:13:11','2019-03-05 14:13:11'),(82,'Guinea-Bissau','Guinea-Bissau','245','GW','GNB','XOF','GNB_s.png','0.00','Active','2019-03-05 14:13:11','2019-03-05 14:13:11'),(83,'Guyana','Guyana','592','GY','GUY','GYD','GUY_s.png','0.00','Active','2019-03-05 14:13:11','2019-03-05 14:13:11'),(84,'Haiti','Haiti','509','HT','HTI','HTG','HTI_s.png','0.00','Active','2019-03-05 14:13:11','2019-03-05 14:13:11'),(85,'Honduras','Honduras','504','HN','HND','HNL','HND_s.png','0.00','Active','2019-03-05 14:13:11','2019-03-05 14:13:11'),(86,'Hong Kong','Hong Kong','852','HK','HKG','HKD','HKG_s.png','0.00','Active','2019-03-05 14:13:12','2019-03-05 14:13:12'),(87,'Hungary','Hungary','36','HU','HUN','HUF','HUN_s.png','0.00','Active','2019-03-05 14:13:12','2019-03-05 14:13:12'),(88,'Iceland','Iceland','354','IS','ISL','ISK','ISL_s.png','0.00','Active','2019-03-05 14:13:12','2019-03-05 14:13:12'),(89,'India','India','91','IN','IND','INR','IND_s.png','0.00','Active','2019-03-05 14:13:12','2019-03-05 12:28:09'),(90,'Indonesia','Indonesia','62','ID','IDN','IDR','IDN_s.png','0.00','Active','2019-03-05 14:13:12','2019-03-05 14:13:12'),(91,'Iran','Iran','98','IR','IRN','IRR','IRN_s.png','0.00','Active','2019-03-05 14:13:12','2019-03-05 14:13:12'),(92,'Iraq','Iraq','964','IQ','IRQ','IQD','IRQ_s.png','0.00','Active','2019-03-05 14:13:12','2019-03-05 14:13:12'),(93,'Ireland','Ireland','353','IE','IRL','EUR','IRL_s.png','0.00','Active','2019-03-05 14:13:12','2019-03-05 14:13:12'),(94,'Isle of Man','Isle of Man','44','IM','IMN','IMP','IMN_s.png','0.00','Active','2019-03-05 14:13:12','2019-03-05 14:13:12'),(95,'Israel','Israel','972','IL','ISR','ILS','ISR_s.png','0.00','Active','2019-03-05 14:13:12','2019-03-05 14:13:12'),(96,'Italy','Italy','39','IT','ITA','EUR','ITA_s.png','0.00','Active','2019-03-05 14:13:12','2019-03-05 14:13:12'),(97,'Ivory Coast','Ivory Coast','225','CI','CIV','XOF','CIV_s.png','0.00','Active','2019-03-05 14:13:12','2019-03-05 14:13:12'),(98,'Jamaica','Jamaica','1','JM','JAM','JMD','JAM_s.png','0.00','Active','2019-03-05 14:13:12','2019-03-05 14:13:12'),(99,'Japan','Japan','81','JP','JPN','JPY','JPN_s.png','0.00','Active','2019-03-05 14:13:13','2019-03-05 14:13:13'),(100,'Jordan','Jordan','962','JO','JOR','JOD','JOR_s.png','0.00','Active','2019-03-05 14:13:13','2019-03-05 14:13:13'),(101,'Kazakhstan','Kazakhstan','7','KZ','KAZ','KZT','KAZ_s.png','0.00','Active','2019-03-05 14:13:13','2019-03-05 14:13:13'),(102,'Kenya','Kenya','254','KE','KEN','KES','KEN_s.png','0.00','Active','2019-03-05 14:13:13','2019-03-05 14:13:13'),(103,'Kiribati','Kiribati','686','KI','KIR','AUD','KIR_s.png','0.00','Active','2019-03-05 14:13:13','2019-03-05 14:13:13'),(104,'Kosovo','Kosovo','381','XK','XKX','Euro','XKX_s.png','0.00','Active','2019-03-05 14:13:13','2019-03-05 14:13:13'),(105,'Kuwait','Kuwait','965','KW','KWT','KWD','KWT_s.png','0.00','Active','2019-03-05 14:13:13','2019-06-27 11:51:36'),(106,'Kyrgyzstan','Kyrgyzstan','996','KG','KGZ','KGS','KGZ_s.png','0.00','Active','2019-03-05 14:13:13','2019-03-05 14:13:13'),(107,'Laos','Laos','856','LA','LAO','LAK','LAO_s.png','0.00','Active','2019-03-05 14:13:13','2019-03-05 14:13:13'),(108,'Latvia','Latvia','371','LV','LVA','EUR','LVA_s.png','0.00','Active','2019-03-05 14:13:13','2019-03-05 14:13:13'),(109,'Lebanon','Lebanon','961','LB','LBN','LBP','LBN_s.png','0.00','Active','2019-03-05 14:13:13','2019-03-05 14:13:13'),(110,'Lesotho','Lesotho','266','LS','LSO','LSL','LSO_s.png','0.00','Active','2019-03-05 14:13:13','2019-03-05 14:13:13'),(111,'Liberia','Liberia','231','LR','LBR','LRD','LBR_s.png','0.00','Active','2019-03-05 14:13:13','2019-03-05 14:13:13'),(112,'Libya','Libya','218','LY','LBY','LYD','LBY_s.png','0.00','Active','2019-03-05 14:13:13','2019-03-05 14:13:13'),(113,'Liechtenstein','Liechtenstein','423','LI','LIE','CHF','LIE_s.png','0.00','Active','2019-03-05 14:13:14','2019-03-05 14:13:14'),(114,'Lithuania','Lithuania','370','LT','LTU','LTL','LTU_s.png','0.00','Active','2019-03-05 14:13:14','2019-03-05 14:13:14'),(115,'Luxembourg','Luxembourg','352','LU','LUX','EUR','LUX_s.png','0.00','Active','2019-03-05 14:13:14','2019-03-05 14:13:14'),(116,'Macau','Macau','853','MO','MAC','MOP','MAC_s.png','0.00','Active','2019-03-05 14:13:14','2019-03-05 14:13:14'),(117,'Macedonia','Macedonia','389','MK','MKD','MKD','MKD_s.png','0.00','Active','2019-03-05 14:13:14','2019-03-05 14:13:14'),(118,'Madagascar','Madagascar','261','MG','MDG','MGA','MDG_s.png','0.00','Active','2019-03-05 14:13:14','2019-03-05 14:13:14'),(119,'Malawi','Malawi','265','MW','MWI','MWK','MWI_s.png','0.00','Active','2019-03-05 14:13:14','2019-03-05 14:13:14'),(120,'Malaysia','Malaysia','60','MY','MYS','MYR','MYS_s.png','0.00','Active','2019-03-05 14:13:14','2019-03-05 14:13:14'),(121,'Maldives','Maldives','960','MV','MDV','MVR','MDV_s.png','0.00','Active','2019-03-05 14:13:14','2019-03-05 14:13:14'),(122,'Mali','Mali','223','ML','MLI','XOF','MLI_s.png','0.00','Active','2019-03-05 14:13:14','2019-03-05 14:13:14'),(123,'Malta','Malta','356','MT','MLT','EUR','MLT_s.png','0.00','Active','2019-03-05 14:13:14','2019-03-05 14:13:14'),(124,'Marshall Islands','Marshall Islands','692','MH','MHL','USD','MHL_s.png','0.00','Active','2019-03-05 14:13:14','2019-03-05 14:13:14'),(125,'Mauritania','Mauritania','222','MR','MRT','MRO','MRT_s.png','0.00','Active','2019-03-05 14:13:14','2019-03-05 14:13:14'),(126,'Mauritius','Mauritius','230','MU','MUS','MUR','MUS_s.png','0.00','Active','2019-03-05 14:13:14','2019-03-05 14:13:14'),(127,'Mexico','Mexico','52','MX','MEX','MXN','MEX_s.png','0.00','Active','2019-03-05 14:13:14','2019-03-05 14:13:14'),(128,'Micronesia','Micronesia','691','FM','FSM','USD','FSM_s.png','0.00','Active','2019-03-05 14:13:14','2019-03-05 14:13:14'),(129,'Moldova','Moldova','373','MD','MDA','MDL','MDA_s.png','0.00','Active','2019-03-05 14:13:15','2019-03-05 14:13:15'),(130,'Monaco','Monaco','377','MC','MCO','EUR','MCO_s.png','0.00','Active','2019-03-05 14:13:15','2019-03-05 14:13:15'),(131,'Mongolia','Mongolia','976','MN','MNG','MNT','MNG_s.png','0.00','Active','2019-03-05 14:13:15','2019-03-05 14:13:15'),(132,'Montenegro','Montenegro','382','ME','MNE','EUR','MNE_s.png','0.00','Active','2019-03-05 14:13:15','2019-03-05 14:13:15'),(133,'Montserrat','Montserrat','1','MS','MSR','XCD','MSR_s.png','0.00','Active','2019-03-05 14:13:15','2019-03-05 14:13:15'),(134,'Morocco','Morocco','212','MA','MAR','MAD','MAR_s.png','0.00','Active','2019-03-05 14:13:15','2019-03-05 14:13:15'),(135,'Mozambique','Mozambique','258','MZ','MOZ','MZN','MOZ_s.png','0.00','Active','2019-03-05 14:13:15','2019-03-05 14:13:15'),(136,'Myanmar [Burma]','Myanmar [Burma]','95','MM','MMR','MMK','MMR_s.png','0.00','Active','2019-03-05 14:13:15','2019-03-05 14:13:15'),(137,'Namibia','Namibia','264','NA','NAM','NAD','NAM_s.png','0.00','Active','2019-03-05 14:13:15','2019-03-05 14:13:15'),(138,'Nauru','Nauru','674','NR','NRU','AUD','NRU_s.png','0.00','Active','2019-03-05 14:13:15','2019-03-05 14:13:15'),(139,'Nepal','Nepal','977','NP','NPL','NPR','NPL_s.png','0.00','Active','2019-03-05 14:13:15','2019-03-05 14:13:15'),(140,'Netherlands','Netherlands','31','NL','NLD','EUR','NLD_s.png','0.00','Active','2019-03-05 14:13:15','2019-03-05 14:13:15'),(141,'New Caledonia','New Caledonia','687','NC','NCL','XPF','NCL_s.png','0.00','Active','2019-03-05 14:13:15','2019-03-05 14:13:15'),(142,'New Zealand','New Zealand','64','NZ','NZL','NZD','NZL_s.png','0.00','Active','2019-03-05 14:13:15','2019-03-05 14:13:15'),(143,'Nicaragua','Nicaragua','505','NI','NIC','NIO','NIC_s.png','0.00','Active','2019-03-05 14:13:16','2019-03-05 14:13:16'),(144,'Niger','Niger','227','NE','NER','XOF','NER_s.png','0.00','Active','2019-03-05 14:13:16','2019-03-05 14:13:16'),(145,'Nigeria','Nigeria','234','NG','NGA','NGN','NGA_s.png','0.00','Active','2019-03-05 14:13:16','2019-03-05 14:13:16'),(146,'Niue','Niue','683','NU','NIU','NZD','NIU_s.png','0.00','Active','2019-03-05 14:13:16','2019-03-05 14:13:16'),(147,'Norfolk Island','Norfolk Island','672','NF','NFK','AUD','NFK_s.png','0.00','Active','2019-03-05 14:13:16','2019-03-05 14:13:16'),(148,'North Korea','North Korea','850','KP','PRK','KPW','PRK_s.png','0.00','Active','2019-03-05 14:13:16','2019-03-05 14:13:16'),(149,'Northern Mariana Islands','Northern Mariana Islands','1','MP','MNP','USD','MNP_s.png','0.00','Active','2019-03-05 14:13:16','2019-03-05 14:13:16'),(150,'Norway','Norway','47','NO','NOR','NOK','NOR_s.png','0.00','Active','2019-03-05 14:13:16','2019-03-05 14:13:16'),(151,'Oman','Oman','968','OM','OMN','OMR','OMN_s.png','0.00','Active','2019-03-05 14:13:16','2019-03-05 14:13:16'),(152,'Pakistan','Pakistan','92','PK','PAK','PKR','PAK_s.png','0.00','Active','2019-03-05 14:13:16','2019-03-05 14:13:16'),(153,'Palau','Palau','680','PW','PLW','USD','PLW_s.png','0.00','Active','2019-03-05 14:13:16','2019-03-05 14:13:16'),(154,'Panama','Panama','507','PA','PAN','PAB','PAN_s.png','0.00','Active','2019-03-05 14:13:16','2019-03-05 14:13:16'),(155,'Papua New Guinea','Papua New Guinea','675','PG','PNG','PGK','PNG_s.png','0.00','Active','2019-03-05 14:13:16','2019-03-05 14:13:16'),(156,'Paraguay','Paraguay','595','PY','PRY','PYG','PRY_s.png','0.00','Active','2019-03-05 14:13:17','2019-03-05 14:13:17'),(157,'Peru','Peru','51','PE','PER','PEN','PER_s.png','0.00','Active','2019-03-05 14:13:17','2019-03-05 14:13:17'),(158,'Philippines','Philippines','63','PH','PHL','PHP','PHL_s.png','0.00','Active','2019-03-05 14:13:17','2019-03-05 14:13:17'),(159,'Pitcairn Islands','Pitcairn Islands','870','PN','PCN','NZD','PCN_s.png','0.00','Active','2019-03-05 14:13:17','2019-03-05 14:13:17'),(160,'Poland','Poland','48','PL','POL','PLN','POL_s.png','0.00','Active','2019-03-05 14:13:17','2019-03-05 14:13:17'),(161,'Portugal','Portugal','351','PT','PRT','EUR','PRT_s.png','0.00','Active','2019-03-05 14:13:17','2019-03-05 14:13:17'),(162,'Puerto Rico','Puerto Rico','1','PR','PRI','USD','PRI_s.png','0.00','Active','2019-03-05 14:13:17','2019-03-05 14:13:17'),(163,'Qatar','Qatar','974','QA','QAT','QAR','QAT_s.png','0.00','Active','2019-03-05 14:13:17','2019-03-05 14:13:17'),(164,'Republic of the Congo','Republic of the Congo','242','CG','COG','XAF','COG_s.png','0.00','Active','2019-03-05 14:13:17','2019-03-05 14:13:17'),(165,'Reunion','Reunion','262','RE','REU','EUR','REU_s.png','0.00','Active','2019-03-05 14:13:17','2019-03-05 14:13:17'),(166,'Romania','Romania','40','RO','ROU','RON','ROU_s.png','0.00','Active','2019-03-05 14:13:17','2019-03-05 14:13:17'),(167,'Russia','Russia','7','RU','RUS','RUB','RUS_s.png','0.00','Active','2019-03-05 14:13:17','2019-03-05 14:13:17'),(168,'Rwanda','Rwanda','250','RW','RWA','RWF','RWA_s.png','0.00','Active','2019-03-05 14:13:17','2019-03-05 14:13:17'),(169,'Saint Barthélemy','Saint Barthélemy','590','BL','BLM','EUR','BLM_s.png','0.00','Active','2019-03-05 14:13:17','2019-03-05 14:13:17'),(170,'Saint Helena','Saint Helena','290','SH','SHN','SHP','SHN_s.png','0.00','Active','2019-03-05 14:13:18','2019-03-05 14:13:18'),(171,'Saint Kitts and Nevis','Saint Kitts and Nevis','1','KN','KNA','XCD','KNA_s.png','0.00','Active','2019-03-05 14:13:18','2019-03-05 14:13:18'),(172,'Saint Lucia','Saint Lucia','1','LC','LCA','XCD','LCA_s.png','0.00','Active','2019-03-05 14:13:18','2019-03-05 14:13:18'),(173,'Saint Martin','Saint Martin','1','MF','MAF','EUR','MAF_s.png','0.00','Active','2019-03-05 14:13:18','2019-03-05 14:13:18'),(174,'Saint Pierre and Miquelon','Saint Pierre and Miquelon','508','PM','SPM','EUR','SPM_s.png','0.00','Active','2019-03-05 14:13:18','2019-03-05 14:13:18'),(175,'Saint Vincent and the Grenadines','Saint Vincent and the Grenadines','1','VC','VCT','XCD','VCT_s.png','0.00','Active','2019-03-05 14:13:18','2019-03-05 14:13:18'),(176,'Samoa','Samoa','685','WS','WSM','WST','WSM_s.png','0.00','Active','2019-03-05 14:13:18','2019-03-05 14:13:18'),(177,'San Marino','San Marino','378','SM','SMR','EUR','SMR_s.png','0.00','Active','2019-03-05 14:13:18','2019-03-05 14:13:18'),(178,'Sao Tome and Principe','Sao Tome and Principe','239','ST','STP','STD','STP_s.png','0.00','Active','2019-03-05 14:13:18','2019-03-05 14:13:18'),(179,'Saudi Arabia','Saudi Arabia','966','SA','SAU','SAR','SAU_s.png','0.00','Active','2019-03-05 14:13:18','2019-03-29 05:56:23'),(180,'Senegal','Senegal','221','SN','SEN','XOF','SEN_s.png','0.00','Active','2019-03-05 14:13:19','2019-03-05 14:13:19'),(181,'Serbia','Serbia','381','RS','SRB','RSD','SRB_s.png','0.00','Active','2019-03-05 14:13:19','2019-03-05 14:13:19'),(182,'Seychelles','Seychelles','248','SC','SYC','SCR','SYC_s.png','0.00','Active','2019-03-05 14:13:19','2019-03-05 14:13:19'),(183,'Sierra Leone','Sierra Leone','232','SL','SLE','SLL','SLE_s.png','0.00','Active','2019-03-05 14:13:19','2019-03-05 14:13:19'),(184,'Singapore','Singapore','65','SG','SGP','SGD','SGP_s.png','0.00','Active','2019-03-05 14:13:19','2019-03-05 14:13:19'),(185,'Slovakia','Slovakia','421','SK','SVK','SKK','SVK_s.png','0.00','Active','2019-03-05 14:13:19','2019-03-05 14:13:19'),(186,'Slovenia','Slovenia','386','SI','SVN','EUR','SVN_s.png','0.00','Active','2019-03-05 14:13:19','2019-03-05 14:13:19'),(187,'Solomon Islands','Solomon Islands','677','SB','SLB','SBD','SLB_s.png','0.00','Active','2019-03-05 14:13:19','2019-03-05 14:13:19'),(188,'Somalia','Somalia','252','SO','SOM','SOS','SOM_s.png','0.00','Active','2019-03-05 14:13:19','2019-03-05 14:13:19'),(189,'South Africa','South Africa','27','ZA','ZAF','ZAR','ZAF_s.png','0.00','Active','2019-03-05 14:13:19','2019-03-05 14:13:19'),(190,'South Korea','South Korea','82','KR','KOR','KRW','KOR_s.png','0.00','Active','2019-03-05 14:13:19','2019-03-05 14:13:19'),(191,'South Sudan','South Sudan','211','SS','SSD','SSP','SSD_s.png','0.00','Active','2019-03-05 14:13:19','2019-03-05 14:13:19'),(192,'Spain','Spain','34','ES','ESP','EUR','ESP_s.png','0.00','Active','2019-03-05 14:13:19','2019-03-05 14:13:19'),(193,'Sri Lanka','Sri Lanka','94','LK','LKA','LKR','LKA_s.png','0.00','Active','2019-03-05 14:13:20','2019-03-05 14:13:20'),(194,'Sudan','Sudan','249','SD','SDN','SDG','SDN_s.png','0.00','Active','2019-03-05 14:13:20','2019-03-05 14:13:20'),(195,'Suriname','Suriname','597','SR','SUR','SRD','SUR_s.png','0.00','Active','2019-03-05 14:13:20','2019-03-05 14:13:20'),(196,'Swaziland','Swaziland','268','SZ','SWZ','CHF','SWZ_s.png','0.00','Active','2019-03-05 14:13:20','2019-03-05 14:13:20'),(197,'Sweden','Sweden','46','SE','SWE','SEK','SWE_s.png','0.00','Active','2019-03-05 14:13:20','2019-03-05 14:13:20'),(198,'Switzerland','Switzerland','41','CH','CHE','CHF','CHE_s.png','0.00','Active','2019-03-05 14:13:20','2019-03-05 14:13:20'),(199,'Syria','Syria','963','SY','SYR','SYP','SYR_s.png','0.00','Active','2019-03-05 14:13:20','2019-03-05 14:13:20'),(200,'Taiwan','Taiwan','886','TW','TWN','TWD','TWN_s.png','0.00','Active','2019-03-05 14:13:20','2019-03-05 14:13:20'),(201,'Tajikistan','Tajikistan','992','TJ','TJK','TJS','TJK_s.png','0.00','Active','2019-03-05 14:13:20','2019-03-05 14:13:20'),(202,'Tanzania','Tanzania','255','TZ','TZA','TZS','TZA_s.png','0.00','Active','2019-03-05 14:13:20','2019-03-05 14:13:20'),(203,'Thailand','Thailand','66','TH','THA','THB','THA_s.png','0.00','Active','2019-03-05 14:13:21','2019-03-05 14:13:21'),(204,'Togo','Togo','228','TG','TGO','XOF','TGO_s.png','0.00','Active','2019-03-05 14:13:21','2019-03-05 14:13:21'),(205,'Tokelau','Tokelau','690','TK','TKL','NZD','TKL_s.png','0.00','Active','2019-03-05 14:13:21','2019-03-05 14:13:21'),(206,'Trinidad and Tobago','Trinidad and Tobago','1','TT','TTO','TTD','TTO_s.png','0.00','Active','2019-03-05 14:13:21','2019-03-05 14:13:21'),(207,'Tunisia','Tunisia','216','TN','TUN','TND','TUN_s.png','0.00','Active','2019-03-05 14:13:21','2019-03-05 14:13:21'),(208,'Turkey','Turkey','90','TR','TUR','TRY','TUR_s.png','0.00','Active','2019-03-05 14:13:21','2019-03-05 14:13:21'),(209,'Turkmenistan','Turkmenistan','993','TM','TKM','TMM','TKM_s.png','0.00','Active','2019-03-05 14:13:21','2019-03-05 14:13:21'),(210,'Tuvalu','Tuvalu','688','TV','TUV','TVD','TUV_s.png','0.00','Active','2019-03-05 14:13:21','2019-03-05 14:13:21'),(211,'Uganda','Uganda','256','UG','UGA','UGX','UGA_s.png','0.00','Active','2019-03-05 14:13:21','2019-03-05 14:13:21'),(212,'Ukraine','Ukraine','380','UA','UKR','UAH','UKR_s.png','0.00','Active','2019-03-05 14:13:21','2019-03-05 14:13:21'),(213,'United Arab Emirates','United Arab Emirates','971','AE','ARE','AED','ARE_s.png','0.00','Active','2019-03-05 14:13:21','2019-03-05 14:13:21'),(214,'United Kingdom','United Kingdom','44','GB','GBR','GBP','GBR_s.png','0.00','Active','2019-03-05 14:13:21','2019-03-05 14:13:21'),(215,'United States','United States','1','US','USA','USD','USA_s.png','0.00','Active','2019-03-05 14:13:21','2019-03-05 14:13:21'),(216,'Uruguay','Uruguay','598','UY','URY','UYU','URY_s.png','0.00','Active','2019-03-05 14:13:21','2019-03-05 14:13:21'),(217,'Uzbekistan','Uzbekistan','998','UZ','UZB','UZS','UZB_s.png','0.00','Active','2019-03-05 14:13:21','2019-03-05 14:13:21'),(218,'Vanuatu','Vanuatu','678','VU','VUT','VUV','VUT_s.png','0.00','Active','2019-03-05 14:13:22','2019-03-05 14:13:22'),(219,'Vatican','Vatican','39','VA','VAT','EUR','VAT_s.png','0.00','Active','2019-03-05 14:13:22','2019-03-05 14:13:22'),(220,'Venezuela','Venezuela','58','VE','VEN','VEF','VEN_s.png','0.00','Active','2019-03-05 14:13:22','2019-03-05 14:13:22'),(221,'Vietnam','Vietnam','84','VN','VNM','VND','VNM_s.png','0.00','Active','2019-03-05 14:13:22','2019-03-05 14:13:22'),(222,'Western Sahara','Western Sahara','212','EH','ESH','MAD','ESH_s.png','0.00','Active','2019-03-05 14:13:22','2019-03-05 14:13:22'),(223,'Yemen','Yemen','967','YE','YEM','YER','YEM_s.png','0.00','Active','2019-03-05 14:13:22','2019-03-05 14:13:22'),(224,'Zambia','Zambia','260','ZM','ZMB','ZMW','ZMB_s.png','0.00','Active','2019-03-05 14:13:22','2019-03-05 14:13:22'),(225,'Zimbabwe','Zimbabwe','263','ZW','ZWE','ZWD','ZWE_s.png','0.00','Active','2019-03-05 14:13:22','2019-03-05 14:13:22');

/*Table structure for table `department_permissions` */

DROP TABLE IF EXISTS `department_permissions`;

CREATE TABLE `department_permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `navigation_id` bigint(20) unsigned DEFAULT NULL,
  `department_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `navigation_id` (`navigation_id`),
  KEY `role_id` (`department_id`),
  CONSTRAINT `department_permissions_ibfk_1` FOREIGN KEY (`navigation_id`) REFERENCES `navigations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `department_permissions_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `department_permissions` */

/*Table structure for table `departments` */

DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `en_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `departments` */

insert  into `departments`(`id`,`name`,`en_name`,`status`,`created_at`,`updated_at`) values (1,'Administrator','Administrator','Active','2020-08-20 08:36:55','2020-08-20 08:36:55'),(2,'Staff','Staff','Active','2020-08-21 11:18:35','2020-08-21 11:18:35');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jobs` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2020_06_25_111613_create_media_table',1),(2,'2020_06_25_124509_create_hashtags_table',2),(3,'2020_06_25_124522_create_posts_table',2),(4,'2020_06_25_124656_create_post_comments_table',2),(5,'2020_06_25_124716_create_post_likes_table',2),(6,'2020_06_25_124839_create_post_shares_table',2),(7,'2020_06_25_135210_create_chat_histories_table',3),(8,'2020_06_25_135421_create_friend_requests_table',3),(9,'2020_06_25_135429_create_friends_table',3),(10,'2020_06_25_135518_create_followers_table',3),(11,'2020_06_26_112747_create_post_reports_table',4),(12,'2020_06_29_073543_create_post_views_table',5),(13,'2020_07_02_080725_create_profile_views_table',6),(14,'2020_07_03_121416_create_report_lists_table',7),(15,'2020_07_03_123933_create_user_blockeds_table',8);

/*Table structure for table `navigations` */

DROP TABLE IF EXISTS `navigations`;

CREATE TABLE `navigations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `en_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `priority` int(5) DEFAULT NULL,
  `action_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'Active',
  `show_in_menu` enum('Yes','No') COLLATE utf8mb4_unicode_ci DEFAULT 'Yes',
  `show_in_permission` enum('Yes','No') COLLATE utf8mb4_unicode_ci DEFAULT 'Yes',
  `is_visible` enum('Yes','No') COLLATE utf8mb4_unicode_ci DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `navigations_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `navigations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `navigations` */

insert  into `navigations`(`id`,`en_name`,`name`,`icon`,`parent_id`,`priority`,`action_path`,`status`,`show_in_menu`,`show_in_permission`,`is_visible`,`created_at`,`updated_at`) values (1,'Dashboard','لوحة التحكم','fa fa-dashboard',NULL,1,'dashboard','Active','Yes','Yes','Yes','2020-01-29 13:41:09','2020-01-29 13:41:09'),(2,'Delete Navigation','حذف القائمة',NULL,3,6,'navigation/delete','Active','No','Yes','Yes','2020-01-29 13:41:09','2020-01-29 13:41:09'),(3,'Navigations','القائمة الجانبية','fa fa-cogs',NULL,12,'navigation','Active','Yes','Yes','Yes','2020-01-29 13:41:09','2020-03-17 16:21:17'),(4,'Create Navigation','إنشاء قائمة',NULL,3,1,'navigation/create','Active','No','Yes','Yes','2020-01-29 13:41:09','2020-01-29 13:41:09'),(5,'Update Navigation','تحديث القائمة',NULL,3,2,'navigation/update','Active','No','Yes','Yes','2020-01-29 13:41:09','2020-01-29 13:41:09'),(6,'Create Account','إنشاء حساب',NULL,7,2,'admin/create','Active','No','Yes','Yes','2020-01-29 13:41:09','2020-01-29 13:41:09'),(7,'Admin Accounts','Admin Accounts','fa fa-group',NULL,13,'admin','Active','Yes','Yes','Yes','2020-01-29 13:41:09','2020-08-27 13:17:56'),(8,'Update Account','تحديث الحساب',NULL,7,3,'admin/update','Active','No','Yes','Yes','2020-01-29 13:41:09','2020-01-29 13:41:09'),(9,'Delete Account','حذف الحساب',NULL,7,4,'admin/delete','Active','No','Yes','Yes','2020-01-29 13:41:09','2020-01-29 13:41:09'),(10,'Account Change Password','تغيير كلمة مرور الحساب',NULL,7,5,'admin/change-password','Active','No','Yes','Yes','2020-01-29 13:41:09','2020-01-29 13:41:09'),(11,'Account Permission','صلاحيات الحساب',NULL,7,6,'admin/permission','Active','No','Yes','Yes','2020-01-29 13:41:09','2020-01-29 13:41:09'),(12,'Create Department','إنشاء قسم',NULL,14,2,'department/create','Active','No','Yes','Yes','2020-01-29 13:41:09','2020-01-29 13:41:09'),(13,'Update Department','تحديث القسم',NULL,14,3,'department/update','Active','No','Yes','Yes','2020-01-29 13:41:09','2020-01-29 13:41:09'),(14,'Departments','العيادات','fa fa-universal-access',NULL,14,'departments','Active','Yes','Yes','Yes','2020-01-29 13:41:09','2020-03-02 12:34:03'),(15,'Delete Department','حذف القسم',NULL,14,5,'department/delete','Active','No','Yes','Yes','2020-01-29 13:41:09','2020-01-29 13:41:09'),(16,'Department Permission','صلاحية القسم',NULL,14,6,'department/permission','Active','No','Yes','Yes','2020-01-29 13:41:09','2020-01-29 13:41:09'),(17,'Countries','Countries','fa-flag',NULL,8,'country','Active','Yes','Yes','Yes','2020-08-21 11:48:09','2020-08-27 13:23:04'),(18,'Create Country','Create Country',NULL,17,1,'country/create','Active','No','Yes','Yes','2020-08-21 11:48:32','2020-08-21 11:48:32'),(19,'Update Country','Update Country',NULL,17,2,'country/update','Active','No','Yes','Yes','2020-08-21 11:48:55','2020-08-21 11:48:55'),(20,'Delete Country','Delete Country',NULL,17,3,'country/delete','Active','No','Yes','Yes','2020-08-21 11:49:20','2020-08-21 11:49:20'),(21,'Report Lists','Report Lists','fa-list',NULL,5,'report-list','Active','Yes','Yes','Yes','2020-08-27 12:33:59','2020-08-27 12:33:59'),(22,'Create Report List','Create Report List',NULL,21,1,'report-list/create','Active','No','Yes','Yes','2020-08-27 12:34:33','2020-08-27 12:34:33'),(23,'Update Report List','Update Report List',NULL,21,2,'report-list/update','Active','No','Yes','Yes','2020-08-27 12:34:56','2020-08-27 12:34:56'),(24,'Delete Report List','Delete Report List',NULL,21,3,'report-list/delete','Active','No','Yes','Yes','2020-08-27 12:35:18','2020-08-27 12:35:18'),(25,'Settings','Settings','fa-cogs',NULL,5,'setting','Active','Yes','Yes','Yes','2020-08-27 13:34:46','2020-08-27 13:35:06'),(26,'Update Setting','Update Setting',NULL,25,1,'setting/update','Active','No','Yes','Yes','2020-08-27 13:35:30','2020-08-27 13:35:30'),(27,'Users','Users','fa-users',NULL,1,'user','Active','Yes','Yes','Yes','2020-08-27 13:53:04','2020-08-27 13:53:04'),(28,'Create User','Create User',NULL,27,1,'user/create','Active','No','Yes','Yes','2020-08-27 13:53:41','2020-08-27 13:53:41'),(29,'Update User','Update User',NULL,27,2,'user/update','Active','No','Yes','Yes','2020-08-27 13:53:59','2020-08-27 13:53:59'),(30,'Delete User','Delete User',NULL,27,3,'user/delete','Active','No','Yes','Yes','2020-08-27 13:54:21','2020-08-27 13:54:21'),(31,'User Change Password','User Change Password',NULL,27,4,'user/change-password','Active','No','Yes','Yes','2020-08-27 13:55:05','2020-08-27 13:55:05'),(32,'View User','View User',NULL,27,5,'user/view','Active','No','Yes','Yes','2020-08-27 13:55:22','2020-08-27 13:55:22');

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` bigint(50) unsigned NOT NULL AUTO_INCREMENT,
  `from_user_id` bigint(50) unsigned DEFAULT NULL,
  `to_user_id` bigint(50) unsigned DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `notification_type` enum('shared','post','like','report','comment','general','video','youtube','image') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `en_title` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `en_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attribute` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `from_user_id` (`from_user_id`),
  KEY `to_user_id` (`to_user_id`),
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `notifications` */

/*Table structure for table `report_lists` */

DROP TABLE IF EXISTS `report_lists`;

CREATE TABLE `report_lists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `report_list` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `en_report_list` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_remarks` enum('Yes','No') COLLATE utf8mb4_unicode_ci DEFAULT 'No',
  `display_order` int(10) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `report_lists` */

insert  into `report_lists`(`id`,`report_list`,`en_report_list`,`show_remarks`,`display_order`,`created_at`,`updated_at`) values (1,'Nudity','Nudity','No',1,'2020-07-03 17:57:07','2020-07-03 17:57:07'),(2,'Violence','Violence','No',2,'2020-07-03 17:57:07','2020-07-03 17:57:07'),(3,'Harassment','Harassment','No',3,'2020-07-03 17:57:07','2020-07-03 17:57:07'),(4,'Suicide or self-injury','Suicide or self-injury','No',4,'2020-07-03 17:57:07','2020-07-03 17:57:07'),(5,'False News','False News','No',5,'2020-07-03 17:57:07','2020-07-03 17:57:07'),(6,'Spam','Spam','No',6,'2020-07-03 17:57:07','2020-07-03 17:57:07'),(7,'Unauthorized sales','Unauthorized sales','No',7,'2020-07-03 17:57:07','2020-07-03 17:57:07'),(8,'Hate speech','Hate speech','No',8,'2020-07-03 17:57:07','2020-07-03 17:57:07'),(9,'Terrorism','Terrorism','No',9,'2020-07-03 17:57:07','2020-07-03 17:57:07'),(10,'Something else','Something else','Yes',10,'2020-07-03 17:57:07','2020-07-03 17:57:07');

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `attribute` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_textarea` tinyint(1) DEFAULT 0,
  `is_simple` tinyint(1) DEFAULT 0,
  `display_order` int(10) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `settings` */

insert  into `settings`(`id`,`attribute`,`value`,`is_textarea`,`is_simple`,`display_order`,`created_at`,`updated_at`) values (1,'iOSVersion','1',0,0,1,'2020-06-25 12:32:19','2020-06-25 12:32:19'),(2,'androidVersion','1',0,0,2,'2020-06-25 12:32:19','2020-06-25 12:32:19');

/*Table structure for table `user_fcm_tokens` */

DROP TABLE IF EXISTS `user_fcm_tokens`;

CREATE TABLE `user_fcm_tokens` (
  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(50) unsigned DEFAULT NULL,
  `fcm_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_type` enum('android','ios') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_fcm_tokens_user_id` (`user_id`),
  CONSTRAINT `user_fcm_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_fcm_tokens` */

/*Table structure for table `user_login_logs` */

DROP TABLE IF EXISTS `user_login_logs`;

CREATE TABLE `user_login_logs` (
  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(50) unsigned DEFAULT NULL,
  `device_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_type` enum('ios','android') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_at` timestamp NULL DEFAULT NULL,
  `logout_at` timestamp NULL DEFAULT NULL,
  `duration` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_login_logs_user_id` (`user_id`),
  CONSTRAINT `user_login_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_login_logs` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(50) unsigned NOT NULL AUTO_INCREMENT,
  `login_log_id` bigint(50) unsigned DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dial_code` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'Active',
  `is_returner` tinyint(1) DEFAULT 0,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_status` enum('Online','Offline') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_connected_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `login_log_id` (`login_log_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`login_log_id`) REFERENCES `user_login_logs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`login_log_id`,`username`,`image`,`name`,`dial_code`,`mobile`,`dob`,`gender`,`email`,`otp`,`status`,`is_returner`,`password`,`remember_token`,`last_token`,`last_status`,`last_connected_at`,`is_deleted`,`deleted_at`,`created_at`,`updated_at`) values (1,NULL,NULL,NULL,'Virendra','966',NULL,'2020-08-04','male','development.vk@hotmail.com',NULL,'Active',0,NULL,'42ef45e32fe3d9d7ed6a944485951a8b',NULL,NULL,NULL,0,NULL,'2020-08-29 16:20:39','2020-08-29 16:31:04');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
