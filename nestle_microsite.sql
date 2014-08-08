-- MySQL dump 10.13  Distrib 5.5.37, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: nestle_microsite
-- ------------------------------------------------------
-- Server version	5.5.37-0ubuntu0.14.04.1

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
-- Table structure for table `activity_log`
--

DROP TABLE IF EXISTS `activity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `activityId` int(11) NOT NULL,
  `activityDesc` text NOT NULL,
  `source` varchar(20) NOT NULL,
  `datetimes` datetime NOT NULL,
  `n_status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_log`
--

LOCK TABLES `activity_log` WRITE;
/*!40000 ALTER TABLE `activity_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nestle_category`
--

DROP TABLE IF EXISTS `nestle_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nestle_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(200) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `relation` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `n_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nestle_category`
--

LOCK TABLES `nestle_category` WRITE;
/*!40000 ALTER TABLE `nestle_category` DISABLE KEYS */;
INSERT INTO `nestle_category` VALUES (1,'IT','Dunia teknologi',NULL,NULL,'2014-07-25 12:23:11',1),(2,'Ekonomi','Dunia Ekonomi',NULL,NULL,'2014-07-25 12:23:11',1);
/*!40000 ALTER TABLE `nestle_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nestle_member_interest`
--

DROP TABLE IF EXISTS `nestle_member_interest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nestle_member_interest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `category_id` varchar(100) DEFAULT NULL,
  `date_join` varchar(300) NOT NULL,
  `n_status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nestle_member_interest`
--

LOCK TABLES `nestle_member_interest` WRITE;
/*!40000 ALTER TABLE `nestle_member_interest` DISABLE KEYS */;
INSERT INTO `nestle_member_interest` VALUES (1,10043,'1,2','2014-07-25 17:59:14',1);
/*!40000 ALTER TABLE `nestle_member_interest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nestle_news_content`
--

DROP TABLE IF EXISTS `nestle_news_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nestle_news_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `brief` text NOT NULL,
  `content` text NOT NULL,
  `image` varchar(200) NOT NULL,
  `thumbnail_image` varchar(200) NOT NULL,
  `slider_image` varchar(200) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `articleType` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `sourceurl` varchar(100) NOT NULL,
  `file` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `expired_date` datetime NOT NULL,
  `posted_date` datetime NOT NULL,
  `fromwho` int(11) NOT NULL DEFAULT '0' COMMENT '0:web or admin ;1:user ;2:pages',
  `filesize` int(11) NOT NULL,
  `can_save` int(11) NOT NULL,
  `tags` text NOT NULL COMMENT 'format serialize tags',
  `authorid` int(11) NOT NULL,
  `n_status` int(11) NOT NULL DEFAULT '0',
  `topcontent` int(11) NOT NULL DEFAULT '0' COMMENT '0;standart;1:featured;2:review;3:interview',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `categoryid` (`categoryid`),
  KEY `created_date` (`created_date`),
  KEY `posted_date` (`posted_date`),
  KEY `n_status` (`n_status`),
  KEY `articleTypeID` (`articleType`),
  KEY `image` (`image`),
  KEY `parentID` (`parentid`),
  KEY `lid` (`lid`),
  KEY `online` (`fromwho`),
  KEY `expired_date` (`expired_date`),
  KEY `url` (`url`),
  KEY `aid` (`authorid`),
  KEY `file` (`file`),
  KEY `slider_image` (`slider_image`),
  KEY `sourceurl` (`filesize`),
  KEY `thumbnail_image` (`thumbnail_image`),
  KEY `topcontent` (`topcontent`),
  KEY `sourceurl_2` (`sourceurl`),
  KEY `can_save` (`can_save`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nestle_news_content`
--

LOCK TABLES `nestle_news_content` WRITE;
/*!40000 ALTER TABLE `nestle_news_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `nestle_news_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nestle_news_content_comment`
--

DROP TABLE IF EXISTS `nestle_news_content_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nestle_news_content_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `contentid` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` datetime NOT NULL,
  `n_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `date` (`date`),
  KEY `userid` (`userid`),
  KEY `contentid` (`contentid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nestle_news_content_comment`
--

LOCK TABLES `nestle_news_content_comment` WRITE;
/*!40000 ALTER TABLE `nestle_news_content_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `nestle_news_content_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nestle_news_content_repo`
--

DROP TABLE IF EXISTS `nestle_news_content_repo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nestle_news_content_repo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `brief` text NOT NULL,
  `content` text NOT NULL,
  `typealbum` int(11) NOT NULL COMMENT '1:song;2:images;3:video',
  `gallerytype` int(11) NOT NULL COMMENT '0:content,1:contest',
  `files` varchar(200) NOT NULL COMMENT 'can be image or song',
  `thumbnail` varchar(200) NOT NULL,
  `fromwho` int(11) NOT NULL COMMENT '0;admin;1:user;2:pages',
  `otherid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `n_status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `otherid` (`otherid`),
  KEY `IDX_typeAlbum` (`typealbum`),
  KEY `IDX_Album_ID` (`gallerytype`),
  KEY `IDX_FROM_WHO` (`fromwho`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nestle_news_content_repo`
--

LOCK TABLES `nestle_news_content_repo` WRITE;
/*!40000 ALTER TABLE `nestle_news_content_repo` DISABLE KEYS */;
/*!40000 ALTER TABLE `nestle_news_content_repo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_member`
--

DROP TABLE IF EXISTS `social_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_member` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `sosmed_id` varchar(50) NOT NULL,
  `name` varchar(46) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `verified_date` datetime NOT NULL,
  `img` varchar(200) DEFAULT NULL COMMENT 'GIID Image',
  `image_profile` varchar(200) NOT NULL,
  `small_img` varchar(200) DEFAULT NULL,
  `username` varchar(46) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `zipcode` int(10) NOT NULL,
  `sex` varchar(11) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `description` text,
  `link` text,
  `middle_name` varchar(46) DEFAULT NULL,
  `last_name` varchar(46) DEFAULT NULL,
  `StreetName` varchar(150) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `n_status` int(3) NOT NULL DEFAULT '0' COMMENT ' pending , approved, verified, rejected , deleted ( 7 day ), deactivated ( kill my self )',
  `login_count` int(11) NOT NULL DEFAULT '0',
  `verified` tinyint(3) DEFAULT '0' COMMENT '0->no hp blm verified, 1->sudah verified.',
  `usertype` int(11) NOT NULL COMMENT '0:online;1:offline;2;existing',
  `email_token` varchar(50) DEFAULT NULL,
  `photo_moderation` int(11) NOT NULL,
  `salt` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sosmed_id` (`sosmed_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10052 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_member`
--

LOCK TABLES `social_member` WRITE;
/*!40000 ALTER TABLE `social_member` DISABLE KEYS */;
INSERT INTO `social_member` VALUES (10043,'','ovan',NULL,'ovan89@gmail.com','2014-07-16 07:53:04','0000-00-00 00:00:00',NULL,'',NULL,NULL,'2014-07-30 19:49:08',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,3,0,1,NULL,0,'1nf0k0mun1t4s','9bcb563205b4ef20731a05d9d00c178955f0d8e3'),(10044,'10202304338879140','Ovan',NULL,'o.pulu@yahoo.com','2014-08-06 15:37:29','0000-00-00 00:00:00',NULL,'',NULL,NULL,NULL,NULL,0,'male',NULL,'https://www.facebook.com/app_scoped_user_id/10202304338879140/',NULL,'Sunarto','Pulu',NULL,NULL,1,0,0,1,NULL,0,NULL,NULL),(10046,'594315585','Ovan Sunarto P.',NULL,NULL,'2014-08-06 15:50:00','0000-00-00 00:00:00',NULL,'',NULL,'ovancop',NULL,0,0,NULL,NULL,'Kesehatan lebih penting','http://t.co/jePSH4BIdP',NULL,NULL,NULL,NULL,1,0,0,1,NULL,0,NULL,NULL),(10048,'878655875497290','Kompi',NULL,'pukiscuy@gmail.com','2014-08-07 03:39:05','0000-00-00 00:00:00',NULL,'',NULL,NULL,NULL,NULL,0,'male',NULL,NULL,'https://www.facebook.com/app_scoped_user_id/878655875497290/','','Lemot',NULL,NULL,1,0,0,1,NULL,0,NULL,NULL),(10050,'10202566952037559','Albertus',NULL,'andreass_bayu@yahoo.com','2014-08-07 04:46:27','0000-00-00 00:00:00',NULL,'',NULL,NULL,NULL,NULL,0,'male',NULL,NULL,'https://www.facebook.com/app_scoped_user_id/10202566952037559/','Andreass Bayu','Aji',NULL,NULL,1,0,0,1,NULL,0,NULL,NULL);
/*!40000 ALTER TABLE `social_member` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-08-07 14:42:12
