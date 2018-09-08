-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: localhost    Database: bintime
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu0.17.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `country_code_id` smallint(3) unsigned DEFAULT NULL,
  `postcode` varchar(10) NOT NULL,
  `city` varchar(50) NOT NULL,
  `street` varchar(50) NOT NULL,
  `house_number` varchar(12) NOT NULL,
  `apartment_number` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `address_country_id_fk` (`country_code_id`),
  CONSTRAINT `address_country_id_fk` FOREIGN KEY (`country_code_id`) REFERENCES `country` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `address`
--

LOCK TABLES `address` WRITE;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
INSERT INTO `address` VALUES (1,55,'00043400','Kirovograd','Bulgakova','57','423'),(2,56,'3212','Lviv','Ленина','14','5'),(3,220,'54353','Lyon','Peautie','47','56-A'),(4,13,'543534','Лондон','Кингстон','345 A','54'),(5,247,'23434','Марсель','Blaukers','14/56','654'),(7,99,'65476','Нэшвилл','Bingols','135/145 A','123'),(8,1,'54646','Чикаго','Знамения','54',''),(14,8,'9876','Брисбэн','Керченская','3',''),(15,16,'5345','Керч','Волгоградская','1','321'),(16,178,'03151','Бостон','Братская','42',''),(17,235,'645654','Paris','Уолл','43','1231'),(21,25,'05680','Milan','Брайтонская','13',''),(22,29,'00000','Турин','Barrero','78','312'),(23,79,'231245','Манчестер','Broncado','13 Г',''),(24,41,'656546','Запорожье','Станиславская','34','123B'),(25,220,'123','Вильнюс','Клаудская','43',''),(29,220,'543535','Стокгольм','Dentonskaya','76','134GH'),(30,220,'543547','Кливленд','Marrow','176',''),(31,220,'42342','Даллас','Sparrow','5','875R'),(32,220,'213123','Сент-Луис','Nionamy','15','324DF'),(33,220,'13434','Сан-Хосе','Kollingtons','73',''),(38,74,'543543','Ровно','Barritona','55','123'),(39,66,'95484','Lutsk','Posnyakovskaya','156/148 A','345-1');
/*!40000 ALTER TABLE `address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `country_code` char(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `country_code_uindex` (`country_code`)
) ENGINE=InnoDB AUTO_INCREMENT=252 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES (11,'AD'),(153,'AE'),(17,'AF'),(13,'AG'),(9,'AI'),(5,'AL'),(15,'AM'),(10,'AO'),(12,'AQ'),(14,'AR'),(8,'AS'),(2,'AT'),(1,'AU'),(16,'AW'),(4,'AX'),(3,'AZ'),(30,'BA'),(20,'BB'),(19,'BD'),(24,'BE'),(36,'BF'),(27,'BG'),(21,'BH'),(37,'BI'),(25,'BJ'),(186,'BL'),(26,'BM'),(35,'BN'),(28,'BO'),(29,'BQ'),(32,'BR'),(18,'BS'),(38,'BT'),(155,'BV'),(31,'BW'),(23,'BY'),(22,'BZ'),(94,'CA'),(103,'CC'),(72,'CD'),(233,'CF'),(172,'CG'),(238,'CH'),(107,'CI'),(157,'CK'),(237,'CL'),(93,'CM'),(102,'CN'),(104,'CO'),(106,'CR'),(108,'CU'),(89,'CV'),(110,'CW'),(159,'CX'),(97,'CY'),(236,'CZ'),(57,'DE'),(69,'DJ'),(67,'DK'),(70,'DM'),(71,'DO'),(6,'DZ'),(242,'EC'),(245,'EE'),(74,'EG'),(76,'EH'),(244,'ER'),(86,'ES'),(246,'ET'),(73,'EU'),(226,'FI'),(224,'FJ'),(227,'FK'),(135,'FM'),(223,'FO'),(228,'FR'),(47,'GA'),(41,'GB'),(62,'GD'),(65,'GE'),(54,'GF'),(58,'GG'),(51,'GH'),(59,'GI'),(63,'GL'),(50,'GM'),(55,'GN'),(52,'GP'),(243,'GQ'),(64,'GR'),(248,'GS'),(53,'GT'),(66,'GU'),(56,'GW'),(49,'GY'),(61,'HK'),(231,'HM'),(60,'HN'),(232,'HR'),(48,'HT'),(42,'HU'),(80,'ID'),(84,'IE'),(78,'IL'),(156,'IM'),(79,'IN'),(33,'IO'),(82,'IQ'),(83,'IR'),(85,'IS'),(87,'IT'),(68,'JE'),(250,'JM'),(81,'JO'),(251,'JP'),(96,'KE'),(98,'KG'),(92,'KH'),(99,'KI'),(105,'KM'),(191,'KN'),(101,'KP'),(173,'KR'),(109,'KW'),(91,'KY'),(90,'KZ'),(111,'LA'),(115,'LB'),(192,'LC'),(118,'LI'),(241,'LK'),(114,'LR'),(113,'LS'),(117,'LT'),(119,'LU'),(112,'LV'),(116,'LY'),(131,'MA'),(138,'MC'),(137,'MD'),(235,'ME'),(187,'MF'),(122,'MG'),(133,'MH'),(125,'MK'),(128,'ML'),(141,'MM'),(139,'MN'),(124,'MO'),(184,'MP'),(132,'MQ'),(121,'MR'),(140,'MS'),(130,'MT'),(120,'MU'),(129,'MV'),(126,'MW'),(134,'MX'),(127,'MY'),(136,'MZ'),(142,'NA'),(151,'NC'),(145,'NE'),(158,'NF'),(146,'NG'),(148,'NI'),(147,'NL'),(152,'NO'),(144,'NP'),(143,'NR'),(149,'NU'),(150,'NZ'),(154,'OM'),(165,'PA'),(168,'PE'),(229,'PF'),(166,'PG'),(225,'PH'),(162,'PK'),(169,'PL'),(188,'PM'),(160,'PN'),(171,'PR'),(164,'PS'),(170,'PT'),(163,'PW'),(167,'PY'),(95,'QA'),(174,'RE'),(177,'RO'),(193,'RS'),(175,'RU'),(176,'RW'),(182,'SA'),(199,'SB'),(185,'SC'),(201,'SD'),(239,'SE'),(194,'SG'),(161,'SH'),(198,'SI'),(240,'SJ'),(197,'SK'),(205,'SL'),(180,'SM'),(189,'SN'),(200,'SO'),(203,'SR'),(249,'SS'),(181,'ST'),(202,'SU'),(178,'SV'),(195,'SX'),(196,'SY'),(183,'SZ'),(209,'TC'),(234,'TD'),(230,'TF'),(210,'TG'),(207,'TH'),(206,'TJ'),(211,'TK'),(45,'TL'),(216,'TM'),(215,'TN'),(212,'TO'),(217,'TR'),(213,'TT'),(214,'TV'),(100,'TW'),(208,'TZ'),(220,'UA'),(218,'UG'),(44,'UM'),(204,'US'),(222,'UY'),(219,'UZ'),(40,'VA'),(190,'VC'),(43,'VE'),(34,'VG'),(7,'VI'),(46,'VN'),(39,'VU'),(221,'WF'),(179,'WS'),(88,'YE'),(123,'YT'),(247,'ZA'),(75,'ZM'),(77,'ZW');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `password` binary(60) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_login_uindex` (`login`),
  UNIQUE KEY `users_email_uindex` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Mikky-Donk123','$2y$13$PPBS.DIb84.1cQ1pthpQ9Om6Bb3DkXEYZQ7IjwUuR0NCnEYi5XKja','Mikelangello','Browns',2,'2018-09-05 01:56:37','mikes@test.com'),(2,'lordon','$2y$13$ON2aTHZEa78gJd4PnEbQTO32Iq4C8IqV.a2MrQ9XJZJwNPm0MQtHy','Джонни','Блэк',1,'2018-09-05 19:34:28','john@test.com'),(18,'Monk Donk','$2y$13$WvrPM0fHpmsJ4EyFRsLleOtcWnnkpYwCe8oG04450ElhZvNXldgYq','Майки','Пинк',0,'2018-09-06 08:35:32','gally@test.gyg'),(19,'brabos56','$2y$13$otgRD2ySBpx3usUyNpkoMepbHnKONdiI/pvxge1jD9fRr2R0ikfwu','Didier','Trochinski',2,'2018-09-06 08:44:21','sally@test.common'),(21,'danny-woo 76','$2y$13$L2gnWSFACSJYz1M9Fi9VEuBzB0pct2qhy3U.XQg8Bj8D9los0oUYa','Holly','Williams',1,'2018-09-06 10:00:42','gypol@ukr.nest'),(23,'figilly','$2y$13$.pb8/G9d6RtuFRsY/akTL.f7FtEZT2/1WSOvv.r6c8hagLyKSKbmG','Morris','Nillion',0,'2018-09-06 10:03:29','follow76@test.test'),(24,'Marion988','$2y$13$aUxnmEPl7RKb1csF7E26geX3vDWbLjqqSIbbDkjJ2.WvKa2ESTDP.','Иван','Самураев',2,'2018-09-06 10:06:36','gillomano@ukr.netty'),(25,'Вася','$2y$13$8IsFhwx89w0LXoVBT0EPmuoR8hX0YOBzaC11peQX.6rh8cai8xoLK','Аллан','По',1,'2018-09-07 03:41:08','fallan@test.test'),(26,'Кузя','$2y$13$Pf680qTHflwYQoDfnptEkuizwXgrQdm4Y3pvGCFldU5WejFo/6as6','Klyde','White',0,'2018-09-07 03:47:30','fulmino99@gilli.top'),(27,'Брабус Толлис','$2y$13$LBK9/PZEy1VwGTjp4A.ibOKU9YMKdYIbtOocrDFmrzImO9TCB2UpW','Bonny','Johns',2,'2018-09-07 04:04:26','fyllyni@abc.gogo'),(28,'Hugo','$2y$13$qTmWES0fIVfZxVm0LhtgrOWxF0xjjBeTlnPr0OTIYf79Lx78J4fu2','Marrion','Murray',1,'2018-09-07 04:06:21','folitano@gyg.bollo'),(29,'Mannarino76','$2y$13$T5wumJHO0Xr2qRfwv8o2r.Lj3.SdwkHgZoXwnFANMNiFWJGTrmE.S','Don','Salinski',0,'2018-09-07 04:12:21','falloww145@bin.pol');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_to_address`
--

DROP TABLE IF EXISTS `user_to_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_to_address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `address_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_to_address_users_id_fk` (`user_id`),
  KEY `user_to_address_addresses_id_fk` (`address_id`),
  CONSTRAINT `user_to_address_addresses_id_fk` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_to_address_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_to_address`
--

LOCK TABLES `user_to_address` WRITE;
/*!40000 ALTER TABLE `user_to_address` DISABLE KEYS */;
INSERT INTO `user_to_address` VALUES (1,1,1),(2,1,2),(3,2,3),(13,2,2),(16,1,8),(17,1,5),(18,1,7),(24,1,14),(25,18,15),(26,19,16),(27,1,17),(31,23,21),(32,24,22),(33,21,23),(34,1,24),(35,1,25),(39,25,29),(40,26,30),(41,27,31),(42,28,32),(43,29,33),(46,26,25),(47,26,31),(48,29,31),(52,1,33),(55,1,31),(56,19,38),(57,1,39),(62,2,33),(64,2,32);
/*!40000 ALTER TABLE `user_to_address` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-09-09  2:08:15
