CREATE DATABASE  IF NOT EXISTS `mvc` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `mvc`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win64 (x86_64)
--
-- Host: localhost    Database: mvc
-- ------------------------------------------------------
-- Server version	5.6.21-log

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
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (0,'Post 1','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus id velit non tellus feugiat feugiat vitae quis nibh. Pellentesque maximus lectus ut enim tincidunt, a rutrum dui elementum. Vestibulum elit sapien, malesuada sit amet est lacinia, aliquet laoreet arcu. Duis quis velit hendrerit, pretium nibh ut, faucibus odio. Fusce hendrerit nunc urna, vitae varius augue fringilla in. Nunc a ex eget lectus dictum mollis. Proin quis nisl consectetur metus bibendum ultricies eu non orci. Quisque nec efficitur quam. Suspendisse lorem nulla, sollicitudin ac sagittis id, eleifend eget eros. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras neque leo, consectetur nec sem quis, imperdiet viverra quam. Pellentesque ultricies felis a molestie egestas. Aliquam malesuada eget justo condimentum venenatis. Duis mattis ut nisi in suscipit. Phasellus scelerisque, arcu ut sollicitudin sagittis, ex ante posuere neque, et dapibus ex lectus quis libero.'),(1,'Post 2','usto risus, cursus non iaculis a, semper vitae dolor. Nunc pellentesque tempor pretium. Sed sem risus, accumsan ut urna in, sollicitudin sagittis nisi. Integer ullamcorper orci id nisl iaculis, ac congue purus posuere. Vivamus pharetra nibh in arcu vulputate, in feugiat dolor feugiat. Aliquam erat volutpat. Maecenas sodales magna urna, quis faucibus arcu mattis sit amet. Ali. Fusce hendrerit nunc urna, vitae varius augue fringilla in. Nunc a ex eget lectus dictum mollis. Proin quis nisl consectetur metus bibendum ultricies eu non orci. Quisque nec efficitur quam. Suspendisse lorem nulla, sollicitudin ac sagittis id, eleifend eget eros. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras neque leo, consectetur nec sem quis, imperdiet viverra quam. Pellentesque ultricies felis a molestie egestas. Aliquam malesuada eget justo condimentum venenatis. Duis mattis ut nisi in suscipit. Phasellus scelerisque, arcu ut sollicitudin sagittis, ex ante posuere neque, et dapibus ex lectus quis libero.');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-12-20 10:52:12
