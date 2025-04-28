/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.7.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: pnglobal
-- ------------------------------------------------------
-- Server version	11.7.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `refcode` varchar(20) DEFAULT NULL,
  `id_referral` int(11) DEFAULT NULL,
  `status` enum('new','active','disabled','referral') NOT NULL DEFAULT 'new',
  `timezone` varchar(50) NOT NULL,
  `otp` char(4) DEFAULT NULL,
  `role` enum('member','admin','referral','manager','superadmin') NOT NULL DEFAULT 'member',
  `ip_addr` varchar(45) DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `api_key` varchar(255) DEFAULT NULL,
  `api_secret` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `refcode` (`refcode`),
  KEY `id_referral` (`id_referral`),
  CONSTRAINT `member_ibfk_1` FOREIGN KEY (`id_referral`) REFERENCES `member` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member`
--

LOCK TABLES `member` WRITE;
/*!40000 ALTER TABLE `member` DISABLE KEYS */;
INSERT INTO `member` VALUES
(12,'a@a.a','40bd001563085fc35165329ea1ff5c5ecbdbbeef','2025-02-17 08:26:58','2025-04-28 02:33:11','xxxxxx',43,'active','Asia/Jakarta','5919','superadmin','127.0.0.1',0,'7VmlkBY8gtWIXl421uEXp65wXtIi7gaKsHwI2d00mRFleRdOA3dzIjjXxOrwRox8','IneWnn5Szy8mIxFuXoNLxWSRJGzKufHE3Cp07wOAvYozjBk2eTpSQsE0tbVfDuIk'),
(13,'user@gmail.com','xyzxyzbca','2025-02-11 23:09:10','2025-04-16 04:09:12',NULL,NULL,'active','',NULL,'member',NULL,0,'7VmlkBY8gtWIXl421uEXp65wXtIi7gaKsHwI2d00mRFleRdOA3dzIjjXxOrwRox8','IneWnn5Szy8mIxFuXoNLxWSRJGzKufHE3Cp07wOAvYozjBk2eTpSQsE0tbVfDuIk'),
(23,'user1@gmail.com','xyz','2025-02-11 23:28:27','2025-03-06 04:38:50',NULL,NULL,'new','Asia/Jakarta',NULL,'member',NULL,0,'7VmlkBY8gtWIXl421uEXp65wXtIi7gaKsHwI2d00mRFleRdOA3dzIjjXxOrwRox8','IneWnn5Szy8mIxFuXoNLxWSRJGzKufHE3Cp07wOAvYozjBk2eTpSQsE0tbVfDuIk'),
(43,'miftahus@gmail.com','7b902e6ff1db9f560443f2048974fd7d386975b0','2025-02-12 21:33:56','2025-03-16 07:50:20','slotgcr',79,'active','Asia/Jakarta','5040','member',NULL,0,'7VmlkBY8gtWIXl421uEXp65wXtIi7gaKsHwI2d00mRFleRdOA3dzIjjXxOrwRox8','IneWnn5Szy8mIxFuXoNLxWSRJGzKufHE3Cp07wOAvYozjBk2eTpSQsE0tbVfDuIk'),
(46,'user99@gmail.com','user1234','2025-02-13 01:58:59','2025-04-16 04:11:13',NULL,12,'active','Asia/Jakarta',NULL,'member','127.0.0.1',0,'7VmlkBY8gtWIXl421uEXp65wXtIi7gaKsHwI2d00mRFleRdOA3dzIjjXxOrwRox8','IneWnn5Szy8mIxFuXoNLxWSRJGzKufHE3Cp07wOAvYozjBk2eTpSQsE0tbVfDuIk'),
(57,'miftahus@my.id_2025-02-16','','2025-02-14 10:22:04','2025-03-06 04:38:50',NULL,43,'disabled','',NULL,'member',NULL,1,'7VmlkBY8gtWIXl421uEXp65wXtIi7gaKsHwI2d00mRFleRdOA3dzIjjXxOrwRox8','IneWnn5Szy8mIxFuXoNLxWSRJGzKufHE3Cp07wOAvYozjBk2eTpSQsE0tbVfDuIk'),
(78,'kucing@gmail.com','7b902e6ff1db9f560443f2048974fd7d386975b0','2025-02-20 02:19:58','2025-03-06 04:38:50','7wmuz5pl',43,'active','',NULL,'admin',NULL,0,'7VmlkBY8gtWIXl421uEXp65wXtIi7gaKsHwI2d00mRFleRdOA3dzIjjXxOrwRox8','IneWnn5Szy8mIxFuXoNLxWSRJGzKufHE3Cp07wOAvYozjBk2eTpSQsE0tbVfDuIk'),
(79,'harimaumalaya@gmail.com','7b902e6ff1db9f560443f2048974fd7d386975b0','2025-02-20 02:33:43','2025-03-06 04:38:50','20psk4no',43,'active','Asia/Jakarta',NULL,'member','127.0.0.1',0,'7VmlkBY8gtWIXl421uEXp65wXtIi7gaKsHwI2d00mRFleRdOA3dzIjjXxOrwRox8','IneWnn5Szy8mIxFuXoNLxWSRJGzKufHE3Cp07wOAvYozjBk2eTpSQsE0tbVfDuIk'),
(125,'XCV@gmail.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','2025-02-25 05:23:00','2025-03-06 04:38:50',NULL,NULL,'active','Asia/Jakarta',NULL,'admin','127.0.0.1',0,'7VmlkBY8gtWIXl421uEXp65wXtIi7gaKsHwI2d00mRFleRdOA3dzIjjXxOrwRox8','IneWnn5Szy8mIxFuXoNLxWSRJGzKufHE3Cp07wOAvYozjBk2eTpSQsE0tbVfDuIk'),
(141,'andi@gmail.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','2025-02-27 09:51:35','2025-04-09 04:28:07',NULL,NULL,'referral','Asia/Jakarta',NULL,'member','127.0.0.1',0,'7VmlkBY8gtWIXl421uEXp65wXtIi7gaKsHwI2d00mRFleRdOA3dzIjjXxOrwRox8','IneWnn5Szy8mIxFuXoNLxWSRJGzKufHE3Cp07wOAvYozjBk2eTpSQsE0tbVfDuIk'),
(146,'b@b.b','40bd001563085fc35165329ea1ff5c5ecbdbbeef','2025-02-17 08:26:58','2025-04-27 23:40:19','yyyyyy',43,'active','Asia/Jakarta','7928','member','127.0.0.1',0,'7VmlkBY8gtWIXl421uEXp65wXtIi7gaKsHwI2d00mRFleRdOA3dzIjjXxOrwRox8','IneWnn5Szy8mIxFuXoNLxWSRJGzKufHE3Cp07wOAvYozjBk2eTpSQsE0tbVfDuIk');
/*!40000 ALTER TABLE `member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_role`
--

DROP TABLE IF EXISTS `member_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `member_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `access` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`access`)),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_member_id` (`member_id`),
  UNIQUE KEY `unique_alias` (`alias`),
  CONSTRAINT `member_role_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_role`
--

LOCK TABLES `member_role` WRITE;
/*!40000 ALTER TABLE `member_role` DISABLE KEYS */;
INSERT INTO `member_role` VALUES
(13,43,'Bram',NULL);
/*!40000 ALTER TABLE `member_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_sinyal`
--

DROP TABLE IF EXISTS `member_sinyal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `member_sinyal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) DEFAULT NULL,
  `amount_btc` decimal(16,6) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `sinyal_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_member_sinyal_member` (`member_id`),
  KEY `fk_member_sinyal_sinyal` (`sinyal_id`),
  CONSTRAINT `fk_member_sinyal_member` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_sinyal`
--

LOCK TABLES `member_sinyal` WRITE;
/*!40000 ALTER TABLE `member_sinyal` DISABLE KEYS */;
INSERT INTO `member_sinyal` VALUES
(58,4090873,0.000290,43,199,'2025-04-17 03:02:57','2025-04-17 03:02:57'),
(59,4091434,0.053230,43,200,'2025-04-17 03:05:16','2025-04-17 03:05:35');
/*!40000 ALTER TABLE `member_sinyal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletter`
--

DROP TABLE IF EXISTS `newsletter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletter`
--

LOCK TABLES `newsletter` WRITE;
/*!40000 ALTER TABLE `newsletter` DISABLE KEYS */;
INSERT INTO `newsletter` VALUES
(1,'okidoki@onion.com','2025-03-18 07:50:20');
/*!40000 ALTER TABLE `newsletter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proxies`
--

DROP TABLE IF EXISTS `proxies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `proxies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `port` int(11) NOT NULL CHECK (`port` between 1 and 65535),
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proxies`
--

LOCK TABLES `proxies` WRITE;
/*!40000 ALTER TABLE `proxies` DISABLE KEYS */;
INSERT INTO `proxies` VALUES
(1,'38.154.227.167',5868,'brwbdrjy','4mqmjsgb0t3i',NULL),
(2,'38.153.152.244',9594,'brwbdrjy','4mqmjsgb0t3i',NULL),
(3,'173.211.0.148',6641,'brwbdrjy','4mqmjsgb0t3i',NULL),
(4,'86.38.234.176',6630,'brwbdrjy','4mqmjsgb0t3i',NULL),
(5,'161.123.152.115',6360,'brwbdrjy','4mqmjsgb0t3i',NULL),
(6,'23.94.138.75',6349,'brwbdrjy','4mqmjsgb0t3i',NULL),
(7,'64.64.118.149',6732,'brwbdrjy','4mqmjsgb0t3i',NULL),
(8,'198.105.101.92',5721,'brwbdrjy','4mqmjsgb0t3i',NULL),
(9,'166.88.58.10',5735,'brwbdrjy','4mqmjsgb0t3i',NULL),
(10,'45.151.162.198',6600,'brwbdrjy','4mqmjsgb0t3i',NULL);
/*!40000 ALTER TABLE `proxies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES
(3,'price','5000'),
(4,'commission','0.7'),
(5,'referral_fee','0.1');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sinyal`
--

DROP TABLE IF EXISTS `sinyal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sinyal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('Buy A','Buy B','Buy C','Buy D','Sell A','Sell B','Sell C','Sell D') NOT NULL DEFAULT 'Buy A',
  `entry_price` decimal(10,2) NOT NULL,
  `pair_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `ip_addr` varchar(45) DEFAULT NULL,
  `is_deleted` enum('no','yes') NOT NULL DEFAULT 'no',
  `status` enum('pending','filled','canceled') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_admin` (`admin_id`),
  CONSTRAINT `fk_admin` FOREIGN KEY (`admin_id`) REFERENCES `member` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sinyal`
--

LOCK TABLES `sinyal` WRITE;
/*!40000 ALTER TABLE `sinyal` DISABLE KEYS */;
/*!40000 ALTER TABLE `sinyal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscription`
--

DROP TABLE IF EXISTS `subscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` enum('active','expired','free','pending') NOT NULL,
  `is_admin_granted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `initial_capital` int(11) NOT NULL,
  `commission` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscription_ibfk_1` (`member_id`),
  CONSTRAINT `subscription_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=193 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscription`
--

LOCK TABLES `subscription` WRITE;
/*!40000 ALTER TABLE `subscription` DISABLE KEYS */;
INSERT INTO `subscription` VALUES
(161,46,'2025-02-14 06:27:15','2025-03-16 06:27:15','pending',0,'2025-02-14 06:27:15','2025-03-10 13:47:31',3500.00,500,350.00),
(166,57,'2025-02-14 10:22:04','2025-11-01 00:00:00','pending',0,'2025-02-14 10:22:04','2025-02-17 15:35:52',350000.00,500000,35000.00),
(174,43,'2025-02-17 11:34:18','2025-03-17 11:34:18','pending',0,'2025-02-17 11:34:18','2025-02-25 07:26:30',49.00,70,4.90),
(175,12,'2025-02-17 15:28:31','2025-03-17 15:28:31','pending',0,'2025-02-17 15:28:31','2025-04-16 04:11:23',6300000.00,9000000,630000.00),
(182,43,'2025-02-18 11:34:18','2025-03-17 11:34:18','active',0,'2025-02-18 11:34:18','2025-03-14 07:42:03',49.00,100,4.90),
(191,78,'2025-02-20 02:19:58','2025-11-01 00:00:00','pending',0,'2025-02-20 02:19:58','2025-03-10 13:47:31',NULL,200,NULL);
/*!40000 ALTER TABLE `subscription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_course`
--

DROP TABLE IF EXISTS `user_course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` enum('new','active','disabled') NOT NULL DEFAULT 'new',
  `otp` char(4) DEFAULT NULL,
  `role` varchar(50) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_type` enum('banktransfer','stripe','usdt','usdc') DEFAULT NULL,
  `payment_details` text DEFAULT NULL,
  `payment_status` enum('unpaid','pending','completed') NOT NULL DEFAULT 'unpaid',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_course`
--

LOCK TABLES `user_course` WRITE;
/*!40000 ALTER TABLE `user_course` DISABLE KEYS */;
INSERT INTO `user_course` VALUES
(8,'a@a.a','7c222fb2927d828af22f592134e8932480637c0d','active','1111','mentor',0.00,NULL,NULL,'unpaid'),
(13,'b@b.b','40bd001563085fc35165329ea1ff5c5ecbdbbeef','new','2325','member',5000.00,NULL,NULL,'pending'),
(14,'b@b.c',NULL,'active','5100','member',1000.00,NULL,NULL,'unpaid');
/*!40000 ALTER TABLE `user_course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `withdraw`
--

DROP TABLE IF EXISTS `withdraw`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `withdraw_type` enum('fiat','usdt') NOT NULL DEFAULT 'fiat',
  `amount` decimal(18,2) NOT NULL,
  `payment_details` text DEFAULT NULL,
  `wallet_address` varchar(255) DEFAULT NULL,
  `status` enum('pending','rejected','completed') NOT NULL DEFAULT 'pending',
  `requested_at` datetime NOT NULL DEFAULT current_timestamp(),
  `processed_at` datetime DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  CONSTRAINT `withdraw_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `withdraw`
--

LOCK TABLES `withdraw` WRITE;
/*!40000 ALTER TABLE `withdraw` DISABLE KEYS */;
INSERT INTO `withdraw` VALUES
(31,43,'fiat',66500.00,'[]',NULL,'completed','2025-02-18 16:12:08',NULL,NULL),
(40,43,'usdt',598500.00,'{\"connection\":\"trc20\",\"recipient\":\"miftahus\",\"account_number\":\"12344\",\"swift_code\":\"BCAAJA\"}','xyz','pending','2025-03-03 14:13:18',NULL,NULL);
/*!40000 ALTER TABLE `withdraw` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2025-04-28 19:35:16
