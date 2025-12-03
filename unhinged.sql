-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: unhinged
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accounts`
--


CREATE DATABASE IF NOT EXISTS unhinged;
USE unhinged;


DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (3,'Root','$2y$10$nvLkWOJdTORU7XKzDsXegugExMDmW1TMzLY1hjFvlQ6F2OjwSmTYi','2025-04-15 20:25:04','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agenda`
--

DROP TABLE IF EXISTS `agenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `venue_name` varchar(255) NOT NULL,
  `venue_city` varchar(255) NOT NULL,
  `show_date` date NOT NULL,
  `show_time` varchar(255) NOT NULL DEFAULT 'TBA',
  `ticket_link` text DEFAULT NULL,
  `info_link` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agenda`
--

LOCK TABLES `agenda` WRITE;
/*!40000 ALTER TABLE `agenda` DISABLE KEYS */;
INSERT INTO `agenda` VALUES (1,'De Bunker','Gemert','2025-04-22','TBA','test','0test','2025-04-15 18:37:58','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'O Sheas','Eindhoven','2025-08-01','20:00','test','','2025-04-15 18:37:58','0000-00-00 00:00:00','2025-04-18 19:42:11'),(3,'Soos Plock','Volkel','2025-12-01','21:00','','test','2025-04-15 18:37:58','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'Soos Plock','Volkel','2025-04-01','21:00','','','2025-04-15 18:37:58','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,'afdafdstestest','tests','2025-04-16','','','','2025-04-15 20:45:30','0000-00-00 00:00:00','2025-04-15 21:30:52'),(6,'afdsdafs','testsetset','2025-04-16','','afds','','2025-04-15 20:47:22','0000-00-00 00:00:00','2025-04-15 21:41:38'),(7,'test123','test','2025-05-01','TBA','http://unhinged.local/Admin/edit_show/7','','2025-04-18 19:41:57','2025-04-18 19:42:05','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `agenda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mails`
--

DROP TABLE IF EXISTS `mails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 = new, 2 = in progress, 3 finished',
  `in_progress_by` int(11) DEFAULT NULL,
  `completed_by` int(11) DEFAULT NULL COMMENT 'account_id',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `completed_by` (`completed_by`),
  KEY `in_progress_by` (`in_progress_by`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mails`
--

LOCK TABLES `mails` WRITE;
/*!40000 ALTER TABLE `mails` DISABLE KEYS */;
INSERT INTO `mails` VALUES (1,'Justvanthiel@gmail.com','afdsadsfdsaf','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vulputate semper nisi non semper. Curabitur odio nibh, vehicula nec congue et, pellentesque at nulla. Aenean nisl nunc, aliquet at augue et, feugiat consectetur ipsum. Proin id est vitae sapien auctor commodo. Morbi quam felis, mollis vitae eleifend pharetra, lobortis et velit. Integer eget nulla quis ante tincidunt vehicula vel pellentesque tortor. Fusce eget lacus vitae mauris tempor mollis vitae at augue. Etiam tempus facilisis finibus. Etiam quis euismod lorem. Integer efficitur malesuada leo, id lobortis sem consectetur eu. Integer sit amet diam congue, mattis nisl eget, volutpat nisl. Morbi porttitor magna a ante interdum suscipit. Vestibulum vitae mattis lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis at semper eros.\n\nMaecenas ac auctor felis, nec dictum justo. Sed commodo ante quis quam egestas, sit amet sagittis enim scelerisque. Donec a tristique leo. Nulla eget nunc finibus, consequat ex et, viverra arcu. Vivamus vehicula rhoncus nisi quis ornare. Nam nulla justo, congue sit amet rutrum nec, blandit quis tellus. Nulla nec dui varius, tempor mauris non, ultrices neque. Sed lobortis, arcu a convallis auctor, tellus orci bibendum enim, id fermentum libero tortor consequat nisl. Vivamus mollis dui tincidunt tincidunt tincidunt. Pellentesque elementum orci vitae purus lacinia, quis feugiat justo vulputate. Etiam fermentum velit sit amet velit maximus porta.\n\nMaecenas in est nisi. Morbi congue placerat augue, in vulputate neque vehicula sit amet. Vestibulum ac pretium libero. Sed a luctus turpis. Vestibulum dapibus molestie quam, id finibus augue consectetur et. Integer eget finibus ante, non semper ipsum. Maecenas varius nibh efficitur mi egestas, ac imperdiet massa tristique. Quisque condimentum ex eros, quis pretium odio vestibulum ut. Interdum et malesuada fames ac ante ipsum primis in faucibus. Phasellus libero nibh, elementum ut vestibulum et, faucibus sit amet urna.\n\nUt tincidunt porttitor dictum. Maecenas id porta ipsum, non bibendum mi. In imperdiet semper cursus. Cras in lacinia tortor, interdum ultrices libero. Duis vestibulum, enim ut varius posuere, velit orci tincidunt arcu, at auctor leo quam sed tortor. Donec ultricies faucibus ante eget tempor. Donec vel ligula gravida, maximus orci non, interdum neque. Maecenas tristique in lorem sed accumsan. In hac habitasse platea dictumst. In eleifend quam quis risus dictum, ac egestas erat semper. Cras vel luctus est, eu aliquet nibh. Nunc convallis felis vitae placerat semper. Maecenas ultricies tortor et accumsan vulputate.\n\nSed volutpat mi eget metus varius, ac auctor ante tempus. Mauris porta finibus leo, quis rhoncus nulla interdum in. Fusce semper pellentesque dictum. Sed posuere tellus eu ante ultrices molestie. Donec venenatis faucibus neque sit amet euismod. Quisque a neque eget diam sodales consequat. Praesent tincidunt malesuada libero, vel consequat mi finibus quis.\n\nUt vitae ante nibh. Maecenas posuere neque quis purus aliquet molestie. Nam id nisi quis nibh egestas semper. Integer eget sollicitudin massa. Cras vitae orci erat. In iaculis massa sed malesuada lacinia. Phasellus tristique ligula in ante accumsan, sit amet blandit magna bibendum. Nulla sit amet pellentesque lorem. Nam egestas gravida nulla sit amet pulvinar. Nullam varius molestie gravida. Donec egestas consequat quam, sed aliquet ex porta sed. Phasellus efficitur mi vel nulla eleifend, fringilla bibendum felis maximus.\n\nNam nec est ex. Sed posuere ornare mattis. Nulla iaculis posuere velit et suscipit. Proin imperdiet arcu vehicula, consequat tortor ac, placerat lectus. Morbi in ipsum nisl. Nam a risus eget neque consectetur imperdiet quis in dolor. Fusce eleifend scelerisque erat, quis consequat sapien facilisis et.\n\nSed in nisi orci. Curabitur justo odio, semper ornare nulla ut, vestibulum semper velit. Fusce semper, erat a elementum mattis, diam magna tempus erat, a hendrerit nisl nulla at mauris. Suspendisse et dolor ut est luctus malesuada. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Ut auctor, nisi a condimentum condimentum, eros nulla dapibus ligula, ut commodo sem libero et nibh. Maecenas vulputate nisl vel nisl varius lobortis.\n\nVestibulum sed nulla ut ex dapibus laoreet. Quisque neque magna, vehicula eu diam lacinia, facilisis rutrum lacus. Donec volutpat sagittis quam, quis mattis urna consectetur non. Etiam pellentesque, arcu et semper sollicitudin, ligula elit porta erat, at dictum velit elit quis dolor. Aliquam nec ligula at ex egestas lobortis. Aenean ante sapien, eleifend vitae magna sit amet, dignissim fermentum ligula. Vestibulum ac nulla arcu. Quisque at ultricies ipsum. Morbi sodales, nisi et eleifend egestas, dui nisi vestibulum nibh, id fringilla neque leo a purus. Suspendisse potenti. Donec vulputate dolor ut rhoncus posuere. Integer ut faucibus diam. Ut in ipsum quis nunc aliquet molestie. Proin ut turpis sollicitudin, laoreet ante sed, consectetur ante.','http://localhost/phpmyadmin/index.php?route=/sql&db=unhinged&table=mails&pos=0',1,3,3,'2025-04-15 23:09:07','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'justvanthiel@gmail.com','kjafdskdasfklkasdfj','dsfklajlkasdfjlkasdfadsf',NULL,3,NULL,2,'2025-04-15 23:21:06','0000-00-00 00:00:00','2025-04-20 02:24:18'),(3,'test123@gmail.test','testestsetestetsetset','testsetestsetsetest',NULL,1,NULL,0,'2025-04-15 23:25:26','0000-00-00 00:00:00','2025-04-20 02:24:40');
/*!40000 ALTER TABLE `mails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setlist`
--

DROP TABLE IF EXISTS `setlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spotify_link` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setlist`
--

LOCK TABLES `setlist` WRITE;
/*!40000 ALTER TABLE `setlist` DISABLE KEYS */;
INSERT INTO `setlist` VALUES (1,'https://web.whatsapp.com/','test','2025-04-15 22:08:25','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'https://getbootstrap.com/docs/5.3/forms/overview/#overview','fafds','2025-04-15 22:09:52','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'https://getbootstrap.com/docs/5.3/forms/overview/#overview','testestest','2025-04-15 22:23:46','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'http://unhinged.local/index.php/setlist','test','2025-04-15 22:26:38','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `setlist` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-20 16:18:16
