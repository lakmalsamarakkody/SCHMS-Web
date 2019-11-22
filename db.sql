-- MariaDB dump 10.17  Distrib 10.4.10-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: schms
-- ------------------------------------------------------
-- Server version	10.4.10-MariaDB

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
-- Table structure for table `backup`
--

DROP TABLE IF EXISTS `backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_time` datetime NOT NULL,
  `file_size` int(5) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup`
--

LOCK TABLES `backup` WRITE;
/*!40000 ALTER TABLE `backup` DISABLE KEYS */;
INSERT INTO `backup` VALUES (1,'first','all data','2019-10-09 06:33:16',NULL,'2019-10-09 06:33:16','2019-10-09 06:33:16',NULL);
/*!40000 ALTER TABLE `backup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `grade_id` int(2) NOT NULL,
  `staff_id` int(6) DEFAULT NULL,
  `name` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `grade_id` (`grade_id`,`name`),
  UNIQUE KEY `staff_id` (`staff_id`),
  CONSTRAINT `class_ibfk_1` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `class_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class`
--

LOCK TABLES `class` WRITE;
/*!40000 ALTER TABLE `class` DISABLE KEYS */;
INSERT INTO `class` VALUES (15,1,NULL,'A','2019-09-23 01:37:15','2019-09-23 01:37:15',NULL),(16,3,1,'A','2019-09-23 01:40:39','2019-09-23 01:40:39',NULL),(17,5,NULL,'A','2019-09-23 05:12:49','2019-09-23 05:12:49',NULL),(18,4,NULL,'A','2019-09-23 05:15:05','2019-09-23 05:15:05',NULL),(21,6,NULL,'A','2019-10-01 19:17:17','2019-10-01 19:17:17',NULL),(22,6,NULL,'B','2019-10-01 19:51:15','2019-10-01 19:51:15',NULL);
/*!40000 ALTER TABLE `class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_timetable`
--

DROP TABLE IF EXISTS `class_timetable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class_timetable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(3) NOT NULL,
  `day` int(1) NOT NULL,
  `period` int(1) NOT NULL,
  `subject_id` int(3) NOT NULL,
  `staff_id` int(6) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `class_id` (`class_id`),
  KEY `staff_id` (`staff_id`),
  KEY `subject_id` (`subject_id`),
  CONSTRAINT `class_timetable_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_timetable_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `class_timetable_ibfk_3` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_timetable`
--

LOCK TABLES `class_timetable` WRITE;
/*!40000 ALTER TABLE `class_timetable` DISABLE KEYS */;
INSERT INTO `class_timetable` VALUES (83,15,1,1,1,1,'2019-10-02 19:27:09','2019-10-03 06:43:29',NULL),(84,16,1,1,1,3,'2019-10-02 19:27:26','2019-10-02 19:27:32',NULL),(85,15,2,1,5,3,'2019-10-02 19:28:29','2019-10-02 19:28:34',NULL),(86,16,2,1,5,4,'2019-10-02 19:28:43','2019-10-02 19:28:47',NULL),(87,15,3,1,2,1,'2019-10-02 20:06:18','2019-10-03 06:53:58',NULL),(88,15,4,1,4,NULL,'2019-10-02 20:06:20','2019-10-02 20:06:20',NULL),(89,15,5,1,1,NULL,'2019-10-02 20:06:21','2019-10-02 20:06:21',NULL),(90,15,2,2,1,3,'2019-10-03 06:54:30','2019-10-03 06:54:36',NULL),(91,15,4,2,4,3,'2019-10-03 06:58:21','2019-10-03 06:58:23',NULL);
/*!40000 ALTER TABLE `class_timetable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coach`
--

DROP TABLE IF EXISTS `coach`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coach` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initials` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nic` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_home` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_mobile` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_id` int(2) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nic` (`nic`),
  UNIQUE KEY `email` (`email`),
  KEY `district_id` (`district_id`),
  CONSTRAINT `coach_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coach`
--

LOCK TABLES `coach` WRITE;
/*!40000 ALTER TABLE `coach` DISABLE KEYS */;
INSERT INTO `coach` VALUES (3,'Madura Sangeeth Gunathilake','H K M S','Gunathilake','951232308V','1995-04-11','male','madura.sangeeth@gmail.com',NULL,NULL,'121, Keenawala road','Kubaloluwa',7,'2019-10-05 08:15:35','2019-10-05 08:15:35',NULL),(4,'Rivindu Wickramarachchi','D B','Wickramarachchi','951423214V','1995-04-26','male',NULL,NULL,NULL,'267/10, Nagahakotuwa Road','Gampaha',NULL,'2019-10-06 02:58:11','2019-10-06 02:58:11',NULL);
/*!40000 ALTER TABLE `coach` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coach_has_sport`
--

DROP TABLE IF EXISTS `coach_has_sport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coach_has_sport` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `coach_id` int(6) NOT NULL,
  `sport_id` int(3) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sport_id` (`sport_id`),
  KEY `coach_id` (`coach_id`),
  CONSTRAINT `coach_has_sport_ibfk_1` FOREIGN KEY (`sport_id`) REFERENCES `sport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `coach_has_sport_ibfk_2` FOREIGN KEY (`coach_id`) REFERENCES `coach` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coach_has_sport`
--

LOCK TABLES `coach_has_sport` WRITE;
/*!40000 ALTER TABLE `coach_has_sport` DISABLE KEYS */;
INSERT INTO `coach_has_sport` VALUES (1,3,4,'2019-10-05 08:15:35','2019-10-05 08:15:35',NULL),(2,3,6,'2019-10-05 08:15:35','2019-10-05 08:15:35',NULL),(3,4,1,'2019-10-06 02:58:11','2019-10-06 02:58:11',NULL);
/*!40000 ALTER TABLE `coach_has_sport` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `district`
--

DROP TABLE IF EXISTS `district`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `district` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `province_id` int(2) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`province_id`),
  KEY `district_province_id_fk` (`province_id`),
  CONSTRAINT `district_province_id_fk` FOREIGN KEY (`province_id`) REFERENCES `province` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `district`
--

LOCK TABLES `district` WRITE;
/*!40000 ALTER TABLE `district` DISABLE KEYS */;
INSERT INTO `district` VALUES (1,2,'Ampara','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(2,3,'Anuradhapura','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(3,8,'Badulla','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(4,2,'Batticaloa','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(5,9,'Colombo','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(6,7,'Galle','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(7,9,'Gampaha','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(8,7,'Hambantota','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(9,5,'Jaffna','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(10,9,'Kalutara','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(11,1,'Kandy','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(12,6,'Kegalle','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(13,5,'Kilinochchi','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(14,4,'Kurunegala','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(15,5,'Mannar','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(16,1,'Matale','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(17,7,'Matara','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(18,8,'Monaragala','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(19,5,'Mullaitivu','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(20,1,'Nuwara Eliya','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(21,3,'Polonnaruwa','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(22,4,'Puttalam','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(23,6,'Ratnapura','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(24,2,'Trincomalee','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(25,5,'Vavuniya','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL);
/*!40000 ALTER TABLE `district` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam`
--

DROP TABLE IF EXISTS `exam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `type_id` int(2) NOT NULL,
  `year` year(4) NOT NULL,
  `venue` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instructions` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type_id`,`year`),
  CONSTRAINT `exam_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `exam_type` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam`
--

LOCK TABLES `exam` WRITE;
/*!40000 ALTER TABLE `exam` DISABLE KEYS */;
INSERT INTO `exam` VALUES (6,1,2019,NULL,NULL,'2019-09-24 22:33:03','2019-09-24 22:33:03',NULL),(7,3,2019,NULL,NULL,'2019-09-28 21:27:06','2019-09-28 21:27:06',NULL),(10,1,2020,NULL,NULL,'2019-09-29 03:35:16','2019-09-29 03:35:16',NULL),(13,4,2019,'test','test','2019-10-03 05:51:55','2019-10-03 05:51:55',NULL),(14,5,2020,'test','test','2019-10-03 06:02:04','2019-10-03 06:02:04',NULL),(16,5,2019,NULL,NULL,'2019-11-22 17:18:14','2019-11-22 17:18:14',NULL);
/*!40000 ALTER TABLE `exam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_grade_has_schedule`
--

DROP TABLE IF EXISTS `exam_grade_has_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_grade_has_schedule` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `exam_grade_id` int(4) NOT NULL,
  `subject_id` int(3) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `venue` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instructions` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `exam_grade_id` (`exam_grade_id`,`subject_id`),
  KEY `exam_schedule_ibfk_2` (`subject_id`),
  CONSTRAINT `exam_grade_has_schedule_ibfk_1` FOREIGN KEY (`exam_grade_id`) REFERENCES `exam_has_grade` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `exam_grade_has_schedule_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_grade_has_schedule`
--

LOCK TABLES `exam_grade_has_schedule` WRITE;
/*!40000 ALTER TABLE `exam_grade_has_schedule` DISABLE KEYS */;
INSERT INTO `exam_grade_has_schedule` VALUES (56,39,1,'2019-10-01','08:00:00','10:00:00',NULL,NULL,'2019-10-01 20:15:16','2019-10-01 20:15:16',NULL),(57,40,1,'2019-10-01','01:00:00','03:00:00',NULL,NULL,'2019-10-01 20:15:47','2019-10-01 20:15:47',NULL),(58,41,4,'2019-10-17','10:10:00','11:11:00',NULL,NULL,'2019-10-02 03:15:35','2019-10-02 03:15:35',NULL),(59,42,1,'2019-10-03','08:00:00','10:00:00',NULL,NULL,'2019-10-03 06:09:19','2019-10-03 06:09:19',NULL),(61,41,5,'2019-10-18','10:00:00','23:00:00','test','test','2019-10-04 02:53:27','2019-10-04 02:53:27',NULL),(62,43,1,'2019-10-11','08:00:00','10:00:00','tet','test','2019-10-04 04:22:38','2019-10-04 04:22:38',NULL),(63,43,5,'2019-10-04','09:00:00','12:00:00',NULL,NULL,'2019-10-04 04:24:01','2019-10-04 04:24:01',NULL),(64,39,5,'2019-10-10','01:00:00','13:00:00',NULL,NULL,'2019-10-07 02:39:23','2019-10-07 02:39:23',NULL),(65,44,1,'2019-10-18','01:00:00','13:00:00',NULL,NULL,'2019-10-07 02:39:39','2019-10-07 02:39:39',NULL),(66,44,2,'2019-10-23','07:00:00','21:00:00',NULL,NULL,'2019-10-07 02:40:30','2019-10-07 02:40:30',NULL),(67,45,5,'2019-10-16','10:00:00','11:00:00',NULL,NULL,'2019-10-07 02:56:57','2019-10-07 02:56:57',NULL);
/*!40000 ALTER TABLE `exam_grade_has_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_has_grade`
--

DROP TABLE IF EXISTS `exam_has_grade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_has_grade` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `exam_id` int(4) NOT NULL,
  `grade_id` int(2) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `exam_id` (`exam_id`,`grade_id`),
  KEY `exam_has_grade_ibfk_2` (`grade_id`),
  CONSTRAINT `exam_has_grade_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `exam_has_grade_ibfk_2` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_has_grade`
--

LOCK TABLES `exam_has_grade` WRITE;
/*!40000 ALTER TABLE `exam_has_grade` DISABLE KEYS */;
INSERT INTO `exam_has_grade` VALUES (39,10,1,'2019-10-01 20:15:16','2019-10-01 20:15:16',NULL),(40,10,6,'2019-10-01 20:15:47','2019-10-01 20:15:47',NULL),(41,6,1,'2019-10-02 03:15:34','2019-10-02 03:15:34',NULL),(42,14,3,'2019-10-03 06:09:18','2019-10-03 06:09:18',NULL),(43,6,3,'2019-10-04 04:22:38','2019-10-04 04:22:38',NULL),(44,10,3,'2019-10-07 02:39:39','2019-10-07 02:39:39',NULL),(45,13,3,'2019-10-07 02:56:57','2019-10-07 02:56:57',NULL);
/*!40000 ALTER TABLE `exam_has_grade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_type`
--

DROP TABLE IF EXISTS `exam_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_type` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_type`
--

LOCK TABLES `exam_type` WRITE;
/*!40000 ALTER TABLE `exam_type` DISABLE KEYS */;
INSERT INTO `exam_type` VALUES (1,'First Semester','2019-09-21 05:44:36','2019-09-21 05:44:36',NULL),(2,'Second Semester','2019-09-21 05:45:16','2019-09-21 05:45:16',NULL),(3,'Third Semester','2019-09-21 05:45:27','2019-09-21 05:45:27',NULL),(4,'Mid First Semester','2019-09-22 23:52:20','2019-09-22 23:52:20',NULL),(5,'Mid Second Semester','2019-09-22 23:58:16','2019-09-22 23:58:16',NULL);
/*!40000 ALTER TABLE `exam_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grade`
--

DROP TABLE IF EXISTS `grade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grade` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` int(2) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grade`
--

LOCK TABLES `grade` WRITE;
/*!40000 ALTER TABLE `grade` DISABLE KEYS */;
INSERT INTO `grade` VALUES (1,1,'2019-09-16 00:00:00','2019-09-16 00:00:00',NULL),(3,3,'2019-09-21 02:07:46','2019-09-21 02:07:46',NULL),(4,4,'2019-09-21 03:53:16','2019-09-21 03:53:16',NULL),(5,5,'2019-09-21 23:49:46','2019-09-21 23:49:46',NULL),(6,6,'2019-09-28 16:11:22','2019-09-28 16:11:22',NULL);
/*!40000 ALTER TABLE `grade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `health`
--

DROP TABLE IF EXISTS `health`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `health` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `student_id` int(6) NOT NULL,
  `blood_group` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Specialities` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Surgeries` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `health_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `health`
--

LOCK TABLES `health` WRITE;
/*!40000 ALTER TABLE `health` DISABLE KEYS */;
/*!40000 ALTER TABLE `health` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sender_id` int(6) NOT NULL,
  `sender_type` enum('Administrator','Staff','Student','Parent') COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver_id` int(6) NOT NULL,
  `receiver_type` enum('Administrator','Staff','Student','Parent') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_time` datetime NOT NULL,
  `body` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sender_id` int(6) NOT NULL,
  `sender_type` enum('Administrator','Staff','Student','Parent') COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver_id` int(6) NOT NULL,
  `receiver_type` enum('Administrator','Staff','Student','Parent') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_time` datetime NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parent`
--

DROP TABLE IF EXISTS `parent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parent` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `nic` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initials` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_home` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_mobile` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `occupation` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `income` int(10) DEFAULT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_id` int(2) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nic` (`nic`),
  KEY `parent_district_id_fk` (`district_id`),
  CONSTRAINT `parent_district_id_fk` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parent`
--

LOCK TABLES `parent` WRITE;
/*!40000 ALTER TABLE `parent` DISABLE KEYS */;
INSERT INTO `parent` VALUES (4,'677660198V','Warnakulasooriya Mahawaduge Mallika Peiris','W M M','Peiris','1967-09-22','Female',NULL,NULL,NULL,'None',NULL,30000,'144/5A, 3rd Lane, Palmgrove Estate','Veyangoda',NULL,'2019-09-23 09:33:17','2019-09-23 09:33:17',NULL),(5,'591231408V','Samarakkodi Arachchige lakshman samarakkodi','S A L','Samarakkodi','1959-02-28','Male',NULL,NULL,NULL,'karate instructor',NULL,25000,'144/5A 3rd lane','Veyangoda',7,'2019-09-26 23:54:13','2019-09-26 23:54:13',NULL),(6,'647845211V','Sanath Mallawarachchi','W S','Mallawarachchi','1964-02-25','Male',NULL,NULL,NULL,'AirLanka officer',NULL,12000,'no 30 malkelum, kalagedihena.','Nittambuwa',NULL,'2019-10-03 06:28:05','2019-10-03 06:28:05',NULL),(11,'536751208V','Heshani Dewage Hashara Munasinghe','Hashara','Munasinghe','1953-05-13','Female','Hashara123@gmail.com',NULL,'0774924351','Nursing','Head of Dept',50000,'144/5A, 3rd Lane, vgeytra','Bambalapitiya',5,'2019-11-22 18:35:43','2019-11-22 18:35:43',NULL);
/*!40000 ALTER TABLE `parent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `province`
--

DROP TABLE IF EXISTS `province`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `province` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `province`
--

LOCK TABLES `province` WRITE;
/*!40000 ALTER TABLE `province` DISABLE KEYS */;
INSERT INTO `province` VALUES (1,'Central','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(2,'Eastern','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(3,'North Central','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(4,'North Western','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(5,'Northern','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(6,'Sabaragamuwa','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(7,'Southern','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(8,'Uva','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(9,'Western','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL);
/*!40000 ALTER TABLE `province` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `relation_type`
--

DROP TABLE IF EXISTS `relation_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `relation_type` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `relation_type`
--

LOCK TABLES `relation_type` WRITE;
/*!40000 ALTER TABLE `relation_type` DISABLE KEYS */;
INSERT INTO `relation_type` VALUES (1,'Father','2019-09-21 04:56:27','2019-09-21 04:56:27',NULL),(2,'Mother','2019-09-21 04:56:33','2019-09-21 04:56:33',NULL),(3,'Guardian 1','2019-09-21 04:57:13','2019-09-21 04:57:13',NULL),(4,'Guardian 2','2019-09-21 04:57:45','2019-09-21 04:57:45',NULL);
/*!40000 ALTER TABLE `relation_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `religion`
--

DROP TABLE IF EXISTS `religion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `religion` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `religion`
--

LOCK TABLES `religion` WRITE;
/*!40000 ALTER TABLE `religion` DISABLE KEYS */;
INSERT INTO `religion` VALUES (1,'Catholic','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(2,'Christian','2019-09-18 00:00:00','2019-09-18 00:00:00',NULL),(3,'Buddhism','2019-09-21 04:17:00','2019-09-21 04:17:00',NULL);
/*!40000 ALTER TABLE `religion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sport`
--

DROP TABLE IF EXISTS `sport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sport` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sport`
--

LOCK TABLES `sport` WRITE;
/*!40000 ALTER TABLE `sport` DISABLE KEYS */;
INSERT INTO `sport` VALUES (1,'Cricket','2019-09-23 04:22:38','2019-09-23 04:22:38',NULL),(2,'Football','2019-10-04 23:51:48','2019-10-04 23:51:48',NULL),(3,'Netball','2019-10-04 23:51:55','2019-10-04 23:51:55',NULL),(4,'Athletics','2019-10-04 23:52:06','2019-10-04 23:52:06',NULL),(5,'Gymnastic','2019-10-04 23:52:20','2019-10-04 23:52:20',NULL),(6,'Swimming','2019-10-05 00:36:02','2019-10-05 00:36:02',NULL);
/*!40000 ALTER TABLE `sport` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `employee_number` int(6) NOT NULL,
  `type_id` int(2) NOT NULL,
  `admission_date` date NOT NULL,
  `nic` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initials` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_home` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_mobile` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_id` int(2) DEFAULT NULL,
  `religion_id` int(2) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `staff_id` (`employee_number`),
  UNIQUE KEY `nic` (`nic`),
  KEY `staff_staff_type_id_fk` (`type_id`),
  KEY `staff_district_id_fk` (`district_id`),
  KEY `staff_religion_id_fk` (`religion_id`),
  CONSTRAINT `staff_district_id_fk` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`religion_id`) REFERENCES `religion` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `staff_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `staff_type` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` VALUES (1,1,3,'2019-09-16','953651408V','Samarakkody Arachchige Lakmal Samarakkody','S A L','Samarakkody','1995-12-30','Male','lakmalsamarakkody@gmail.com','0332296548','0774924351','144/5A','Veyangoda',7,1,'2019-09-16 00:00:00','2019-09-16 00:00:00',NULL),(3,3,1,'2019-09-03','943651408V','SAMARAKKODY ARACHCHIGE LAKMAL SAMARAKKODY','SAL','SAMARAKKODY','1995-12-30','Male','','','','267/10, Nagahakotuwa Road','Balummahara',NULL,NULL,'2019-09-21 19:07:50','2019-09-21 19:07:50',NULL),(4,4,1,'2019-09-20','953611408V','Samarakkody Arachchige Lakmal Samarakkody','S A L','Samarakkody','1995-12-30','Male','','','','144/5a, 3rd lane, Palmgrove Estate','Veyangoda',NULL,1,'2019-09-21 19:15:34','2019-09-21 19:15:34',NULL);
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_attendance`
--

DROP TABLE IF EXISTS `staff_attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_attendance` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `staff_id` int(6) NOT NULL,
  `date` date NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `staff_id` (`staff_id`,`date`),
  CONSTRAINT `staff_attendance_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_attendance`
--

LOCK TABLES `staff_attendance` WRITE;
/*!40000 ALTER TABLE `staff_attendance` DISABLE KEYS */;
INSERT INTO `staff_attendance` VALUES (2,3,'2019-10-03','2019-10-03 06:23:30','2019-10-03 06:23:30',NULL),(3,4,'2019-10-03','2019-10-03 06:23:32','2019-10-03 06:23:32',NULL),(4,3,'2019-11-20','2019-11-20 19:44:19','2019-11-20 19:44:19',NULL),(6,4,'2019-11-21','2019-11-21 00:13:24','2019-11-21 00:13:24',NULL),(8,1,'2019-11-23','2019-11-23 00:44:15','2019-11-23 00:44:15',NULL),(9,3,'2019-11-23','2019-11-23 00:44:16','2019-11-23 00:44:16',NULL);
/*!40000 ALTER TABLE `staff_attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_category`
--

DROP TABLE IF EXISTS `staff_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_category` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_category`
--

LOCK TABLES `staff_category` WRITE;
/*!40000 ALTER TABLE `staff_category` DISABLE KEYS */;
INSERT INTO `staff_category` VALUES (1,'Academic','2019-09-16 00:00:00','2019-09-16 00:00:00',NULL),(2,'Non-Academic','2019-09-16 00:00:00','2019-09-16 00:00:00',NULL),(3,'Minor','2019-10-08 09:12:26','2019-10-08 09:12:26',NULL);
/*!40000 ALTER TABLE `staff_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_has_subject`
--

DROP TABLE IF EXISTS `staff_has_subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_has_subject` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `staff_id` int(6) NOT NULL,
  `subject_id` int(3) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `staff_id` (`staff_id`,`subject_id`),
  KEY `staff_has_subject_ibfk_2` (`subject_id`),
  CONSTRAINT `staff_has_subject_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `staff_has_subject_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_has_subject`
--

LOCK TABLES `staff_has_subject` WRITE;
/*!40000 ALTER TABLE `staff_has_subject` DISABLE KEYS */;
INSERT INTO `staff_has_subject` VALUES (9,1,1,'2019-10-02 19:27:11','2019-10-02 19:27:11',NULL),(10,3,1,'2019-10-02 19:27:32','2019-10-02 19:27:32',NULL),(11,3,5,'2019-10-02 19:28:34','2019-10-02 19:28:34',NULL),(12,4,5,'2019-10-02 19:28:47','2019-10-02 19:28:47',NULL),(13,1,2,'2019-10-03 06:53:58','2019-10-03 06:53:58',NULL),(14,3,4,'2019-10-03 06:58:23','2019-10-03 06:58:23',NULL);
/*!40000 ALTER TABLE `staff_has_subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_type`
--

DROP TABLE IF EXISTS `staff_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_type` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(2) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `staff_type_staff_category_id_fk` (`category_id`),
  CONSTRAINT `staff_type_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `staff_category` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_type`
--

LOCK TABLES `staff_type` WRITE;
/*!40000 ALTER TABLE `staff_type` DISABLE KEYS */;
INSERT INTO `staff_type` VALUES (1,'Principal',1,'2019-09-16 00:00:00','2019-09-16 00:00:00',NULL),(2,'Deputy Principal',1,'2019-10-08 09:18:01','2019-10-08 09:18:01',NULL),(3,'System Administrator',2,'2019-10-09 12:26:39','2019-10-09 12:26:39',NULL);
/*!40000 ALTER TABLE `staff_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `admission_no` int(6) NOT NULL,
  `admission_date` date NOT NULL,
  `class_id` int(3) NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initials` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_mobile` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_place` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district_id` int(2) DEFAULT NULL,
  `religion_id` int(2) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admission_no` (`admission_no`),
  KEY `student_district_id_fk` (`district_id`),
  KEY `student_religion_id_fk` (`religion_id`),
  KEY `student_ibfk_2` (`class_id`),
  KEY `phone_mobile` (`phone_mobile`),
  KEY `city` (`city`),
  CONSTRAINT `student_district_id_fk` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`religion_id`) REFERENCES `religion` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `student_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (52,1,'2019-09-19',15,'Samarakkody Arachchige Lakmal Samarakkody','S A L','Samarakkody','1995-12-30','male',NULL,NULL,'144/5A, 3rd Lane, Palmgrove Estate','Veyangoda',NULL,NULL,NULL,'2019-09-23 09:33:17','2019-09-23 09:33:17',NULL),(53,13,'2019-09-19',16,'Shyamin Ayesh Fernando','S A','Fernando','1995-12-30','male',NULL,NULL,'no 10 gorakadeniya','Attanagalla',NULL,NULL,NULL,'2019-09-26 18:36:24','2019-09-26 18:36:24',NULL),(59,14,'2019-10-03',21,'Heshan nayanajith','M A H N','Mallawarachchi','1995-11-11','male','heshan.nayanajith@gmail.com','0719864563','144/5A, Kalagedihena','Nittambuwa',NULL,7,3,'2019-10-03 05:30:08','2019-10-03 05:30:08',NULL),(64,15,'2019-11-22',21,'Fonseka Appuhamige Lakmali Fonseka','F A L','Fonseka','1995-07-05','female','lakmalsamarakkody@gmail.com','0774924351','144/5A, 3rd Lane, Plamgrove Estate','Veyangoda','Ragama',7,1,'2019-11-22 18:35:43','2019-11-22 18:35:43',NULL);
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_achievement`
--

DROP TABLE IF EXISTS `student_achievement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_achievement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(6) NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` int(200) DEFAULT NULL,
  `achieved_on` date NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_achievement_student_id_fk` (`student_id`),
  CONSTRAINT `student_achievement_student_id_fk` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_achievement`
--

LOCK TABLES `student_achievement` WRITE;
/*!40000 ALTER TABLE `student_achievement` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_achievement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_attendance`
--

DROP TABLE IF EXISTS `student_attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_attendance` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `student_id` int(6) NOT NULL,
  `date` date NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_id` (`student_id`,`date`),
  CONSTRAINT `student_attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_attendance`
--

LOCK TABLES `student_attendance` WRITE;
/*!40000 ALTER TABLE `student_attendance` DISABLE KEYS */;
INSERT INTO `student_attendance` VALUES (1,52,'2019-09-26','2019-09-27 00:00:00','2019-09-27 00:00:00',NULL),(2,52,'2019-09-27','2019-09-27 00:00:00','2019-09-27 00:00:00',NULL),(8,52,'2019-09-28','2019-09-28 20:49:50','2019-09-28 20:49:50',NULL),(9,53,'2019-09-28','2019-09-28 20:51:52','2019-09-28 20:51:52',NULL),(10,53,'2019-09-29','2019-09-29 04:43:55','2019-09-29 04:43:55',NULL),(11,52,'2019-09-30','2019-09-30 19:55:22','2019-09-30 19:55:22',NULL),(12,52,'2019-10-03','2019-10-03 06:21:54','2019-10-03 06:21:54',NULL),(13,52,'2019-10-01','2019-10-04 21:32:00','2019-10-04 21:32:00',NULL),(14,53,'2019-10-01','2019-10-04 21:32:03','2019-10-04 21:32:03',NULL),(15,59,'2019-10-01','2019-10-04 21:32:10','2019-10-04 21:32:10',NULL),(16,59,'2019-10-02','2019-10-04 21:32:18','2019-10-04 21:32:18',NULL),(17,53,'2019-10-02','2019-10-04 21:32:22','2019-10-04 21:32:22',NULL),(18,53,'2019-10-03','2019-10-04 21:32:30','2019-10-04 21:32:30',NULL),(19,52,'2019-10-04','2019-10-04 21:32:50','2019-10-04 21:32:50',NULL),(20,52,'2019-10-15','2019-10-22 23:48:05','2019-10-22 23:48:05',NULL),(21,52,'2019-11-20','2019-11-20 19:12:23','2019-11-20 19:12:23',NULL),(22,53,'2019-11-20','2019-11-20 19:18:07','2019-11-20 19:18:07',NULL),(24,59,'2019-11-21','2019-11-21 00:55:15','2019-11-21 00:55:15',NULL),(25,53,'2019-11-21','2019-11-21 00:55:22','2019-11-21 00:55:22',NULL),(26,52,'2019-11-22','2019-11-22 18:02:52','2019-11-22 18:02:52',NULL),(27,53,'2019-11-22','2019-11-22 18:02:56','2019-11-22 18:02:56',NULL),(28,59,'2019-11-22','2019-11-22 18:03:18','2019-11-22 18:03:18',NULL),(29,64,'2019-11-22','2019-11-22 18:36:24','2019-11-22 18:36:24',NULL),(30,52,'2019-11-23','2019-11-23 00:06:20','2019-11-23 00:06:20',NULL),(31,64,'2019-11-23','2019-11-23 00:06:25','2019-11-23 00:06:25',NULL);
/*!40000 ALTER TABLE `student_attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_has_class`
--

DROP TABLE IF EXISTS `student_has_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_has_class` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `student_id` int(6) NOT NULL,
  `class_id` int(3) NOT NULL,
  `index_no` int(2) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `class_id` (`class_id`,`index_no`),
  UNIQUE KEY `student_id` (`student_id`,`class_id`),
  CONSTRAINT `student_has_class_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `student_has_class_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_has_class`
--

LOCK TABLES `student_has_class` WRITE;
/*!40000 ALTER TABLE `student_has_class` DISABLE KEYS */;
INSERT INTO `student_has_class` VALUES (12,52,15,1,'2019-09-23 09:33:17','2019-09-23 09:33:17',NULL),(13,53,16,1,'2019-09-26 18:36:24','2019-09-26 18:36:24',NULL),(14,59,21,1,'2019-10-03 05:30:08','2019-10-03 05:30:08',NULL),(16,64,21,2,'2019-11-22 18:35:43','2019-11-22 18:35:43',NULL);
/*!40000 ALTER TABLE `student_has_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_has_exam_schedule`
--

DROP TABLE IF EXISTS `student_has_exam_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_has_exam_schedule` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `student_id` int(6) NOT NULL,
  `exam_schedule_id` int(4) NOT NULL,
  `marks` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_id` (`student_id`,`exam_schedule_id`),
  KEY `exam_schedule_id` (`exam_schedule_id`),
  CONSTRAINT `student_has_exam_schedule_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `student_has_exam_schedule_ibfk_2` FOREIGN KEY (`exam_schedule_id`) REFERENCES `exam_grade_has_schedule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_has_exam_schedule`
--

LOCK TABLES `student_has_exam_schedule` WRITE;
/*!40000 ALTER TABLE `student_has_exam_schedule` DISABLE KEYS */;
INSERT INTO `student_has_exam_schedule` VALUES (3,52,56,'100','2019-10-01 20:15:17','2019-10-01 20:15:17',NULL),(4,52,58,NULL,'2019-10-02 03:15:35','2019-10-02 03:15:35',NULL),(5,53,59,NULL,'2019-10-03 06:09:19','2019-10-03 06:09:19',NULL),(6,52,61,NULL,'2019-10-04 02:53:27','2019-10-04 02:53:27',NULL),(7,53,62,NULL,'2019-10-04 04:22:38','2019-10-04 04:22:38',NULL),(8,53,63,NULL,'2019-10-04 04:24:01','2019-10-04 04:24:01',NULL),(9,52,64,NULL,'2019-10-07 02:39:23','2019-10-07 02:39:23',NULL),(10,53,65,NULL,'2019-10-07 02:39:39','2019-10-07 02:39:39',NULL),(11,53,66,NULL,'2019-10-07 02:40:30','2019-10-07 02:40:30',NULL),(12,53,67,NULL,'2019-10-07 02:56:57','2019-10-07 02:56:57',NULL);
/*!40000 ALTER TABLE `student_has_exam_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_has_parent`
--

DROP TABLE IF EXISTS `student_has_parent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_has_parent` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `student_id` int(6) NOT NULL,
  `parent_id` int(7) NOT NULL,
  `relation_id` int(2) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_id` (`student_id`,`parent_id`),
  KEY `parent_id` (`parent_id`),
  KEY `relation_id` (`relation_id`),
  CONSTRAINT `student_has_parent_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `parent` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `student_has_parent_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `student_has_parent_ibfk_3` FOREIGN KEY (`relation_id`) REFERENCES `relation_type` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_has_parent`
--

LOCK TABLES `student_has_parent` WRITE;
/*!40000 ALTER TABLE `student_has_parent` DISABLE KEYS */;
INSERT INTO `student_has_parent` VALUES (47,52,4,2,'2019-09-23 09:33:17','2019-09-23 09:33:17',NULL),(48,53,4,2,'2019-09-26 18:36:24','2019-09-26 18:36:24',NULL),(49,52,5,1,'2019-09-26 23:54:13','2019-09-26 23:54:13',NULL),(51,59,4,2,'2019-10-03 05:30:08','2019-10-03 05:30:08',NULL),(52,59,6,1,'2019-10-03 06:28:06','2019-10-03 06:28:06',NULL),(57,64,11,2,'2019-11-22 18:35:43','2019-11-22 18:35:43',NULL);
/*!40000 ALTER TABLE `student_has_parent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_has_sport`
--

DROP TABLE IF EXISTS `student_has_sport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_has_sport` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `student_id` int(6) NOT NULL,
  `sport_id` int(3) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sport_id` (`sport_id`,`student_id`),
  KEY `student_has_sport_student_id_fk` (`student_id`),
  CONSTRAINT `student_has_sport_sport_id_fk` FOREIGN KEY (`sport_id`) REFERENCES `sport` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `student_has_sport_student_id_fk` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_has_sport`
--

LOCK TABLES `student_has_sport` WRITE;
/*!40000 ALTER TABLE `student_has_sport` DISABLE KEYS */;
INSERT INTO `student_has_sport` VALUES (1,59,1,'2019-10-06 00:00:00','2019-10-06 00:00:00',NULL),(2,52,2,'2019-10-06 00:00:00','2019-10-07 00:00:00',NULL),(4,59,4,'2019-10-07 00:00:00','2019-10-07 00:00:00',NULL),(5,52,3,'2019-10-07 00:00:00','2019-10-07 00:00:00',NULL),(6,64,3,'2019-11-22 00:00:00','2019-11-22 00:00:00',NULL),(8,64,4,'2019-11-22 00:00:00','2019-11-22 00:00:00',NULL);
/*!40000 ALTER TABLE `student_has_sport` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_has_sport_achievement`
--

DROP TABLE IF EXISTS `student_has_sport_achievement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_has_sport_achievement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_sport_id` int(8) NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT 'NULL',
  `achieved_on` date NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_has_sport_achievement_ibfk_1` (`student_sport_id`),
  CONSTRAINT `student_has_sport_achievement_ibfk_1` FOREIGN KEY (`student_sport_id`) REFERENCES `student_has_sport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_has_sport_achievement`
--

LOCK TABLES `student_has_sport_achievement` WRITE;
/*!40000 ALTER TABLE `student_has_sport_achievement` DISABLE KEYS */;
INSERT INTO `student_has_sport_achievement` VALUES (1,1,'Marathon Champion - Sport Meet 2019','Marathon Champion - Sport Meet held on 20th February 2019','2019-02-13','2019-11-22 00:00:00','2019-11-22 00:00:00',NULL);
/*!40000 ALTER TABLE `student_has_sport_achievement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_has_subject`
--

DROP TABLE IF EXISTS `student_has_subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_has_subject` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `student_id` int(6) NOT NULL,
  `subject_id` int(3) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_id` (`student_id`,`subject_id`),
  KEY `student_has_subject_ibfk_2` (`subject_id`),
  CONSTRAINT `student_has_subject_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `student_has_subject_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_has_subject`
--

LOCK TABLES `student_has_subject` WRITE;
/*!40000 ALTER TABLE `student_has_subject` DISABLE KEYS */;
INSERT INTO `student_has_subject` VALUES (18,52,1,'2019-10-02 15:57:50','2019-10-02 15:57:50',NULL),(19,52,5,'2019-10-02 15:57:52','2019-10-02 15:57:52',NULL),(20,53,1,'2019-10-02 17:10:14','2019-10-02 17:10:14',NULL),(21,53,2,'2019-10-02 17:10:27','2019-10-02 17:10:27',NULL),(22,53,5,'2019-10-02 17:10:29','2019-10-02 17:10:29',NULL),(23,52,2,'2019-10-02 18:27:51','2019-10-02 18:27:51',NULL),(24,52,4,'2019-10-02 20:06:20','2019-10-02 20:06:20',NULL);
/*!40000 ALTER TABLE `student_has_subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_health`
--

DROP TABLE IF EXISTS `student_health`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_health` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(6) NOT NULL,
  `heart_rate` int(3) DEFAULT NULL,
  `blood_pressure` int(3) DEFAULT NULL,
  `height` int(3) DEFAULT NULL,
  `weight` int(3) DEFAULT NULL,
  `bmi` float(4,2) DEFAULT NULL,
  `vaccination` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `speciality` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_id` (`student_id`),
  CONSTRAINT `student_health_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_health`
--

LOCK TABLES `student_health` WRITE;
/*!40000 ALTER TABLE `student_health` DISABLE KEYS */;
INSERT INTO `student_health` VALUES (1,52,80,NULL,160,60,23.40,NULL,NULL,'2019-11-22','2019-11-22 00:00:00','2019-11-22 00:00:00',NULL),(3,53,80,NULL,160,60,17.40,NULL,NULL,'2019-11-22','2019-11-22 00:00:00','2019-11-22 00:00:00',NULL),(8,64,NULL,NULL,NULL,NULL,12.45,NULL,NULL,'2019-11-23','2019-11-23 00:00:00','2019-11-23 00:00:00',NULL),(9,59,NULL,NULL,NULL,NULL,28.23,NULL,NULL,'2019-11-23','2019-11-23 00:00:00','2019-11-23 00:00:00',NULL);
/*!40000 ALTER TABLE `student_health` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subject` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `si_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject`
--

LOCK TABLES `subject` WRITE;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
INSERT INTO `subject` VALUES (1,'English','','2019-09-21 04:28:43','2019-09-21 04:28:43',NULL),(2,'Sinhala','','2019-09-21 04:32:43','2019-09-21 04:32:43',NULL),(3,'vrev','ස්ස්ව්ස්ද්බ්ස්බ්','2019-09-21 04:53:19','2019-09-21 04:53:19',NULL),(4,'Tamil',NULL,'2019-09-22 00:22:56','2019-09-22 00:22:56',NULL),(5,'Maths',NULL,'2019-09-22 00:23:31','2019-09-22 00:23:31',NULL);
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `staff_id` int(6) DEFAULT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(2) NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stu_staff_parent_id` (`staff_id`,`role_id`),
  KEY `user_user_role_id_fk` (`role_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `user_staff_id_fk` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (3,1,'lakmal','$2y$10$0eN9so5Lv903qDKASkGarO9gfmxjZYbD1ejbfnh.aV0fEveidJbBi',NULL,1,'Active','2019-10-08 00:00:00','2019-10-08 00:00:00',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_permission`
--

DROP TABLE IF EXISTS `user_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_permission` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_permission`
--

LOCK TABLES `user_permission` WRITE;
/*!40000 ALTER TABLE `user_permission` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (1,'System Administrator',NULL,'2019-09-02 00:00:00','2019-09-02 00:00:00',NULL),(2,'Database Administrator',NULL,'2019-11-23 00:00:00','2019-11-23 00:00:00',NULL),(3,'Principal',NULL,'2019-11-23 00:00:00','2019-11-23 00:00:00',NULL),(4,'Teacher in Charge',NULL,'2019-11-23 00:00:00','2019-11-23 00:00:00',NULL),(5,'Academic Staff',NULL,'2019-11-23 00:00:00','2019-11-23 00:00:00',NULL);
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role_has_permission`
--

DROP TABLE IF EXISTS `user_role_has_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role_has_permission` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `role_id` int(2) NOT NULL,
  `permission_id` int(2) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_id` (`role_id`,`permission_id`),
  KEY `user_role_has_permission_ibfk_1` (`permission_id`),
  CONSTRAINT `user_role_has_permission_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `user_permission` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `user_role_has_permission_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role_has_permission`
--

LOCK TABLES `user_role_has_permission` WRITE;
/*!40000 ALTER TABLE `user_role_has_permission` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_role_has_permission` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-23  1:55:00
