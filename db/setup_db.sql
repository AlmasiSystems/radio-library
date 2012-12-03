-- MySQL dump 10.11
--
-- Host: localhost    Database: radio_archives
-- ------------------------------------------------------
-- Server version	5.0.95

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
-- Table structure for table `auth`
--

DROP TABLE IF EXISTS `auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth` (
  `id` int(11) NOT NULL auto_increment,
  `role` varchar(100) NOT NULL default '',
  `admin_users` tinyint(1) NOT NULL default '0',
  `music_albums` tinyint(1) NOT NULL default '0',
  `music_addalbum` tinyint(1) NOT NULL default '0',
  `music_editalbum` tinyint(1) NOT NULL default '0',
  `music_artists` tinyint(1) NOT NULL default '0',
  `music_labels` tinyint(1) NOT NULL default '0',
  `music_addlabel` tinyint(1) NOT NULL default '0',
  `music_editlabel` tinyint(1) NOT NULL default '0',
  `music_browselabels` tinyint(1) NOT NULL default '0',
  `music_audit` tinyint(1) NOT NULL default '0',
  `music_recent` tinyint(1) NOT NULL default '0',
  `music_spins` tinyint(1) NOT NULL default '0',
  `music_topspins` tinyint(1) NOT NULL default '0',
  `schedule` tinyint(1) NOT NULL default '0',
  `schedule_seasons` tinyint(1) NOT NULL default '0',
  `schedule_addseason` tinyint(1) NOT NULL default '0',
  `schedule_editseason` tinyint(1) NOT NULL default '0',
  `schedule_shows` tinyint(1) NOT NULL default '0',
  `schedule_addshow` tinyint(1) NOT NULL default '0',
  `schedule_editshow` tinyint(1) NOT NULL default '0',
  `schedule_browseshows` tinyint(1) NOT NULL default '0',
  `schedule_schedule` tinyint(1) NOT NULL default '0',
  `schedule_editevent` tinyint(1) NOT NULL default '0',
  `playlists` tinyint(1) NOT NULL default '0',
  `playlists_manage` tinyint(1) NOT NULL default '0',
  `playlists_tracks` tinyint(1) NOT NULL default '0',
  `playlists_create` tinyint(1) NOT NULL default '0',
  `search` tinyint(1) NOT NULL default '0',
  `search_albums` tinyint(1) NOT NULL default '0',
  `search_labels` tinyint(1) NOT NULL default '0',
  `shows` tinyint(1) NOT NULL default '0',
  `shows_browse` tinyint(4) NOT NULL default '1',
  `shows_edit` tinyint(4) NOT NULL default '0',
  `shows_add` tinyint(4) NOT NULL default '0',
  `shows_delete` tinyint(1) NOT NULL default '0',
  `shows_selectseason` tinyint(1) NOT NULL default '0',
  `shows_view` tinyint(1) NOT NULL default '0',
  `shows_link` tinyint(1) NOT NULL default '0',
  `shows_past` tinyint(1) NOT NULL default '0',
  `shows_future` tinyint(1) NOT NULL default '0',
  `premiums` tinyint(1) NOT NULL default '0',
  `premiums_edit` tinyint(1) NOT NULL default '0',
  `premiums_tshirtedit` tinyint(1) NOT NULL default '0',
  `premiums_all` tinyint(1) NOT NULL default '0',
  `premiums_music` tinyint(1) NOT NULL default '0',
  `premiums_books` tinyint(1) NOT NULL default '0',
  `premiums_other` tinyint(1) NOT NULL default '0',
  `premiums_tshirts` tinyint(1) NOT NULL default '0',
  `premiums_view` tinyint(1) NOT NULL default '0',
  `premiums_search` tinyint(1) NOT NULL default '0',
  `pledges` tinyint(1) NOT NULL default '0',
  `pledges_edit` tinyint(1) NOT NULL default '0',
  `pledges_editdetails` tinyint(1) NOT NULL default '0',
  `pledges_editpayment` tinyint(1) NOT NULL default '0',
  `pledges_editshipping` tinyint(1) NOT NULL default '0',
  `pledges_editpremiums` tinyint(1) NOT NULL default '0',
  `pledges_removepremium` tinyint(1) NOT NULL default '0',
  `pledges_search` tinyint(1) NOT NULL default '0',
  `pledges_view` tinyint(1) NOT NULL default '0',
  `pledges_browse` tinyint(1) NOT NULL default '0',
  `pledges_disable` tinyint(1) NOT NULL default '0',
  `featured` tinyint(1) NOT NULL default '0',
  `featured_manage` tinyint(1) NOT NULL default '0',
  `featured_add` tinyint(1) NOT NULL default '0',
  `featured_delete` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COMMENT='Defines what parts of the library can be accessed';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth`
--

LOCK TABLES `auth` WRITE;
/*!40000 ALTER TABLE `auth` DISABLE KEYS */;
INSERT INTO `auth` VALUES (1,'SuperAdmin',1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(2,'Admin',1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(3,'Adder',0,1,1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,0,0,0,0,0,0,1,1,1,0,1,1,1,1),(4,'DJ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,1,1),(10,'Disabled',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(11,'Programming',1,0,0,0,0,0,0,0,0,0,0,0,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,0,0,1,1,0,1,1,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,1,1),(13,'Fundraiser',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,0,0,0,0,0,0,1,1,1,0,1,1,1,1);
/*!40000 ALTER TABLE `auth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `library_albums`
--

DROP TABLE IF EXISTS `library_albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `library_albums` (
  `id` int(11) NOT NULL auto_increment,
  `artist` varchar(255) NOT NULL default '',
  `artist_display` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `format_id` int(11) NOT NULL default '0',
  `disc_count` int(11) NOT NULL default '0',
  `genre_id` int(11) NOT NULL default '0',
  `label_id` int(11) NOT NULL default '0',
  `promoter_id` int(11) default NULL,
  `release_day` int(11) default NULL,
  `release_month` int(11) default NULL,
  `release_year` int(11) default NULL,
  `add_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `track_con` tinyint(1) NOT NULL default '0',
  `trackend_date` date default NULL,
  `upc` int(11) default NULL,
  `review` text,
  `review_source` varchar(255) default NULL,
  `artist_website` varchar(255) default NULL,
  `artist_email` varchar(255) default NULL,
  `comments` text,
  `adders` text,
  `legacy_label` varchar(250) default NULL,
  `legacy_label_old` varchar(250) default NULL,
  `legacy_label_website` varchar(250) default NULL,
  `legacy_label_email` varchar(250) default NULL,
  `legacy_readerware_rowkey` varchar(250) default NULL,
  `legacy_going_for` varchar(250) default NULL,
  `legacy_commit` int(11) default NULL,
  `legacy_promoter` varchar(250) default NULL,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `artist` (`artist`,`artist_display`,`title`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `library_albums`
--

LOCK TABLES `library_albums` WRITE;
/*!40000 ALTER TABLE `library_albums` DISABLE KEYS */;
/*!40000 ALTER TABLE `library_albums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `library_artists`
--

DROP TABLE IF EXISTS `library_artists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `library_artists` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `website` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `library_artists`
--

LOCK TABLES `library_artists` WRITE;
/*!40000 ALTER TABLE `library_artists` DISABLE KEYS */;
/*!40000 ALTER TABLE `library_artists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `library_formats`
--

DROP TABLE IF EXISTS `library_formats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `library_formats` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `library_formats`
--

LOCK TABLES `library_formats` WRITE;
/*!40000 ALTER TABLE `library_formats` DISABLE KEYS */;
INSERT INTO `library_formats` VALUES (1,'CD'),(2,'MCD'),(3,'DVD'),(4,'DAT'),(5,'Minidisk'),(6,'VHS'),(7,'12\" Vinyl'),(8,'TAPE'),(9,'OTHER'),(10,'7\" Vinyl'),(11,'3\" CD'),(12,'CDR'),(13,'10\" Vinyl'),(18,'Picture Disc/Multicolor Vinyl'),(19,'Box Set'),(20,'Reel-to-Reel'),(21,'Clipboard Record'),(22,'From Home');
/*!40000 ALTER TABLE `library_formats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `library_genres`
--

DROP TABLE IF EXISTS `library_genres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `library_genres` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=284 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `library_genres`
--

LOCK TABLES `library_genres` WRITE;
/*!40000 ALTER TABLE `library_genres` DISABLE KEYS */;
INSERT INTO `library_genres` VALUES (4,'Blues'),(121,'African'),(241,'Brazilian'),(101,'Children\'s'),(141,'Christmas'),(281,'Classical'),(13,'Electronic/Techno'),(14,'Experimental'),(61,'Gospel'),(202,'Hawaiian'),(5,'HipHop'),(11,'Industrial'),(10,'International'),(3,'Jazz'),(8,'Latino'),(201,'Latino Rock'),(12,'Mainstream'),(7,'Metal'),(161,'Modern Composition'),(15,'Public Affairs'),(9,'Punk'),(6,'Reggae/Ska'),(62,'Religious'),(1,'Rock'),(221,'Soul/Funk'),(203,'Sound Effects'),(181,'Soundtrack'),(81,'Spoken Word'),(2,'Folk'),(282,'Comedy'),(283,'New Age');
/*!40000 ALTER TABLE `library_genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `library_labels`
--

DROP TABLE IF EXISTS `library_labels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `library_labels` (
  `id` int(11) NOT NULL auto_increment,
  `label_name` varchar(128) NOT NULL default '',
  `label_website` text,
  `label_email` text,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `label_name` (`label_name`,`label_website`,`label_email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `library_labels`
--

LOCK TABLES `library_labels` WRITE;
/*!40000 ALTER TABLE `library_labels` DISABLE KEYS */;
/*!40000 ALTER TABLE `library_labels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `library_promoters`
--

DROP TABLE IF EXISTS `library_promoters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `library_promoters` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `website` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `library_promoters`
--

LOCK TABLES `library_promoters` WRITE;
/*!40000 ALTER TABLE `library_promoters` DISABLE KEYS */;
/*!40000 ALTER TABLE `library_promoters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `library_songs`
--

DROP TABLE IF EXISTS `library_songs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `library_songs` (
  `id` int(11) NOT NULL auto_increment,
  `album_id` int(11) NOT NULL default '0',
  `title` text NOT NULL,
  `track_num` int(11) NOT NULL default '0',
  `legacy_duration` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `album_id` (`album_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `library_songs`
--

LOCK TABLES `library_songs` WRITE;
/*!40000 ALTER TABLE `library_songs` DISABLE KEYS */;
/*!40000 ALTER TABLE `library_songs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oldschool_playlists`
--

DROP TABLE IF EXISTS `oldschool_playlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oldschool_playlists` (
  `id` int(11) NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  `start_time` time NOT NULL default '00:00:00',
  `end_time` time NOT NULL default '00:00:00',
  `dj_names` varchar(250) NOT NULL default '',
  `show_name` varchar(250) NOT NULL default '',
  `show_id` int(11) NOT NULL default '0',
  `comments` text NOT NULL,
  `description` text NOT NULL,
  `website` varchar(250) NOT NULL default '',
  `genre_other` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oldschool_playlists`
--

LOCK TABLES `oldschool_playlists` WRITE;
/*!40000 ALTER TABLE `oldschool_playlists` DISABLE KEYS */;
/*!40000 ALTER TABLE `oldschool_playlists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oldschool_shows`
--

DROP TABLE IF EXISTS `oldschool_shows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oldschool_shows` (
  `id` varchar(11) NOT NULL default '',
  `show_name` varchar(250) NOT NULL default '',
  `dj_names` varchar(250) NOT NULL default '',
  `genre_other` varchar(250) NOT NULL default '',
  `description` text NOT NULL,
  `website` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oldschool_shows`
--

LOCK TABLES `oldschool_shows` WRITE;
/*!40000 ALTER TABLE `oldschool_shows` DISABLE KEYS */;
/*!40000 ALTER TABLE `oldschool_shows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oldschool_streams`
--

DROP TABLE IF EXISTS `oldschool_streams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oldschool_streams` (
  `id` int(11) NOT NULL auto_increment,
  `dj_name` varchar(250) NOT NULL default '',
  `show_name` varchar(250) NOT NULL default '',
  `start_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `end_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `dow` varchar(10) NOT NULL default '',
  `description` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oldschool_streams`
--

LOCK TABLES `oldschool_streams` WRITE;
/*!40000 ALTER TABLE `oldschool_streams` DISABLE KEYS */;
/*!40000 ALTER TABLE `oldschool_streams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oldschool_tracks`
--

DROP TABLE IF EXISTS `oldschool_tracks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oldschool_tracks` (
  `id` int(11) NOT NULL auto_increment,
  `album_id` int(11) default NULL,
  `track_num` int(11) default NULL,
  `artist_name` varchar(250) default NULL,
  `song_name` varchar(250) default NULL,
  `album_name` varchar(250) default NULL,
  `label_name` varchar(250) default NULL,
  `comments` varchar(250) default NULL,
  `request` tinyint(1) default NULL,
  `from_home` tinyint(1) default NULL,
  `airbreak_after` tinyint(1) default NULL,
  `playlist_id` int(11) NOT NULL default '0',
  `position` int(11) default '6669',
  `current` tinyint(1) default NULL,
  PRIMARY KEY  (`id`),
  KEY `playlist_id` (`playlist_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oldschool_tracks`
--

LOCK TABLES `oldschool_tracks` WRITE;
/*!40000 ALTER TABLE `oldschool_tracks` DISABLE KEYS */;
/*!40000 ALTER TABLE `oldschool_tracks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playlists`
--

DROP TABLE IF EXISTS `playlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `playlists` (
  `id` int(11) NOT NULL auto_increment,
  `show_id` int(11) NOT NULL default '0',
  `event_id` int(11) NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  `start_time` time default NULL,
  `end_time` time default NULL,
  `comments` text,
  `sub_dj1_id` int(11) default NULL,
  `sub_dj2_id` int(11) default NULL,
  `picture` tinyint(1) default '0',
  `opt_live` tinyint(1) default '0',
  `opt_sports` tinyint(1) default '0',
  `opt_guest` tinyint(1) default '0',
  `opt_theme` tinyint(1) default '0',
  `opt_tickets` tinyint(1) default '0',
  `image_url` text,
  PRIMARY KEY  (`id`),
  KEY `timestamp` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playlists`
--

LOCK TABLES `playlists` WRITE;
/*!40000 ALTER TABLE `playlists` DISABLE KEYS */;
/*!40000 ALTER TABLE `playlists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule` (
  `id` int(11) NOT NULL auto_increment,
  `show_id` int(11) default '0',
  `alt_show_id` int(11) default NULL,
  `dotw` int(11) default '0',
  `start_time` time default '00:00:00',
  `end_time` time default '00:00:00',
  `season_id` int(11) default '0',
  PRIMARY KEY  (`id`),
  KEY `dotw` (`dotw`),
  KEY `season` (`season_id`),
  KEY `show_id` (`show_id`),
  KEY `alt_show_id` (`alt_show_id`),
  KEY `start_time` (`start_time`),
  KEY `end_time` (`end_time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule`
--

LOCK TABLES `schedule` WRITE;
/*!40000 ALTER TABLE `schedule` DISABLE KEYS */;
/*!40000 ALTER TABLE `schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seasons`
--

DROP TABLE IF EXISTS `seasons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seasons` (
  `id` int(11) NOT NULL auto_increment,
  `start_date` date NOT NULL default '0000-00-00',
  `end_date` date NOT NULL default '0000-00-00',
  `title` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seasons`
--

LOCK TABLES `seasons` WRITE;
/*!40000 ALTER TABLE `seasons` DISABLE KEYS */;
/*!40000 ALTER TABLE `seasons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `show_types`
--

DROP TABLE IF EXISTS `show_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `show_types` (
  `id` int(11) NOT NULL auto_increment,
  `description` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `show_types`
--

LOCK TABLES `show_types` WRITE;
/*!40000 ALTER TABLE `show_types` DISABLE KEYS */;
INSERT INTO `show_types` VALUES (1,'Music Show'),(2,'Public Affairs Show'),(3,'Syndicated Show');
/*!40000 ALTER TABLE `show_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shows`
--

DROP TABLE IF EXISTS `shows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shows` (
  `id` int(11) NOT NULL auto_increment,
  `show_name` text NOT NULL,
  `dj1_id` int(11) NOT NULL default '0',
  `dj2_id` int(11) NOT NULL default '0',
  `dj3_id` int(11) NOT NULL default '0',
  `show_type` int(11) NOT NULL default '0',
  `genre_other` text,
  `genre_metal` tinyint(1) NOT NULL default '0',
  `genre_international` tinyint(1) NOT NULL default '0',
  `genre_reggae` tinyint(1) NOT NULL default '0',
  `genre_classical` tinyint(1) NOT NULL default '0',
  `genre_eclectic` tinyint(1) NOT NULL default '0',
  `genre_electronic` tinyint(1) NOT NULL default '0',
  `genre_hardcore` tinyint(1) NOT NULL default '0',
  `genre_jazz` tinyint(1) NOT NULL default '0',
  `genre_folk` tinyint(1) NOT NULL default '0',
  `genre_rock` tinyint(1) NOT NULL default '0',
  `genre_indie` tinyint(1) NOT NULL default '0',
  `genre_blues` tinyint(1) NOT NULL default '0',
  `genre_industrial` tinyint(1) NOT NULL default '0',
  `genre_punk` tinyint(1) NOT NULL default '0',
  `genre_hiphop` tinyint(1) NOT NULL default '0',
  `genre_latin` tinyint(1) NOT NULL default '0',
  `genre_noise` tinyint(1) NOT NULL default '0',
  `genre_experimental` tinyint(1) NOT NULL default '0',
  `description` text NOT NULL,
  `website` varchar(250) default NULL,
  `email` varchar(250) default NULL,
  `season_id` int(11) NOT NULL default '0',
  `past_show_id` int(11) default NULL,
  `oldschool_show_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `dj1_id` (`dj1_id`),
  KEY `dj2_id` (`dj2_id`),
  KEY `dj3_id` (`dj3_id`),
  KEY `season_id` (`season_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shows`
--

LOCK TABLES `shows` WRITE;
/*!40000 ALTER TABLE `shows` DISABLE KEYS */;
/*!40000 ALTER TABLE `shows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tops`
--

DROP TABLE IF EXISTS `tops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tops` (
  `id` int(11) NOT NULL auto_increment,
  `post_date` date NOT NULL default '0000-00-00',
  `top_30` text NOT NULL,
  `top_5` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tops`
--

LOCK TABLES `tops` WRITE;
/*!40000 ALTER TABLE `tops` DISABLE KEYS */;
/*!40000 ALTER TABLE `tops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tracks`
--

DROP TABLE IF EXISTS `tracks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tracks` (
  `id` int(11) NOT NULL auto_increment,
  `album_id` int(11) default NULL,
  `track_num` int(11) default NULL,
  `artist_name` varchar(250) default NULL,
  `song_name` varchar(250) default NULL,
  `album_name` varchar(250) default NULL,
  `label_name` varchar(250) default NULL,
  `comments` varchar(250) default NULL,
  `request` tinyint(1) default NULL,
  `from_home` tinyint(1) default NULL,
  `airbreak_after` tinyint(1) default NULL,
  `playlist_id` int(11) NOT NULL default '0',
  `position` int(11) default '6669',
  `current` tinyint(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tracks`
--

LOCK TABLES `tracks` WRITE;
/*!40000 ALTER TABLE `tracks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tracks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(50) NOT NULL default '',
  `password` text NOT NULL,
  `email` varchar(100) NOT NULL default '',
  `name_first` varchar(100) NOT NULL default '',
  `name_last` varchar(100) default NULL,
  `dj_name` varchar(100) default NULL,
  `dj_email` varchar(100) default NULL,
  `auth_id` int(11) NOT NULL default '0',
  `primary_phone` varchar(20) NOT NULL default '',
  `secondary_phone` varchar(20) default NULL,
  `address_street` varchar(200) NOT NULL default '',
  `address_city` varchar(100) NOT NULL default '',
  `address_state` char(2) NOT NULL default '',
  `address_zip` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `username` (`username`,`email`,`name_first`,`name_last`,`dj_name`,`dj_email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3','','',NULL,NULL,NULL,1,'',NULL,'','','',0);
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

-- Dump completed on 2012-12-02 20:16:51
