-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: dallas_rewards
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.29-MariaDB

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
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservations` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `msg` varchar(100) DEFAULT NULL,
  `cf` varchar(100) DEFAULT NULL,
  `iata` varchar(100) DEFAULT NULL,
  `cod_ciudad` varchar(100) DEFAULT NULL,
  `hotel` varchar(100) DEFAULT NULL,
  `pasajero` varchar(100) DEFAULT NULL,
  `status_reservacion` varchar(100) DEFAULT NULL,
  `fecha_inicio` varchar(100) DEFAULT NULL,
  `fecha_fin` varchar(100) DEFAULT NULL,
  `monto_reservacion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_reservations_users` (`user_id`),
  CONSTRAINT `fk_reservations_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
INSERT INTO `reservations` VALUES (1,1,1,'','10392559MX2-','','JFK','','CASTANEDA FLAVIO','HK','2018-03-29T07:00:00','2018-04-01T07:00:00',''),(2,1,1,'','10392559MX2-','','JFK','','CASTANEDA FLAVIO','HK','2018-03-29T07:00:00','2018-04-01T07:00:00',''),(3,1,1,'','10392559MX2-','','JFK','','CASTANEDA FLAVIO','HK','2018-03-29T07:00:00','2018-04-01T07:00:00',''),(4,1,1,'','10392559MX2-','','JFK','','CASTANEDA FLAVIO','HK','2018-03-29T07:00:00','2018-04-01T07:00:00',''),(5,1,1,'','10392559MX2-','','JFK','','CASTANEDA FLAVIO','HK','2018-03-29T07:00:00','2018-04-01T07:00:00',''),(6,1,1,' ','10392559MX2-','','JFK','','CASTANEDA FLAVIO','HK','2018-03-29T07:00:00','2018-04-01T07:00:00',''),(7,1,1,' ','10392559MX2-','','JFK','','CASTANEDA FLAVIO','HK','2018-03-29T07:00:00','2018-04-01T07:00:00',''),(12,1,1,'','10392559MX2-','','JFK','','CASTANEDA FLAVIO','HK','2018-03-29T07:00:00','2018-04-01T07:00:00',''),(13,1,1,'','10392559MX2-','','JFK','','CASTANEDA FLAVIO','HK','2018-03-29T07:00:00','2018-04-01T07:00:00',''),(14,1,1,'','10392559MX2-','','JFK','','CASTANEDA FLAVIO','HK','2018-03-29T07:00:00','2018-04-01T07:00:00',''),(15,1,1,'','10392559MX2-','','JFK','','CASTANEDA FLAVIO','HK','2018-03-29T07:00:00','2018-04-01T07:00:00',''),(16,1,1,'','10392559MX2-','','JFK','','CASTANEDA FLAVIO','HK','2018-03-29T07:00:00','2018-04-01T07:00:00','');
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'luis_mh@outlook.es','$2y$10$GXTteAORwo/6rLOGoMY1p.89ZJXw80zu2nUXJHXvA4dLQBu4/oaOa'),(2,'angel@live.com','$2y$10$hHPbqhL6OsbNMAPPpGQNx.m.2MhIQ4ytCwJQ0ON.NbouJZ3iLgqBS'),(3,'roberto@gmail.com','$2y$10$EbKZ.qSTmHmEXAW3MnP8cOTjZMz5Jvs0oG3FQYrOCkQTWsiWIzYpm');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-12 12:07:39
