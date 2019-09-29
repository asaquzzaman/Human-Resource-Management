# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.7.23)
# Database: hrm
# Generation Time: 2019-09-29 05:32:43 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table wp_commentmeta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_commentmeta`;

CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_comments`;

CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_author_email` (`comment_author_email`(10)),
  KEY `woo_idx_comment_type` (`comment_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

LOCK TABLES `wp_comments` WRITE;
/*!40000 ALTER TABLE `wp_comments` DISABLE KEYS */;

INSERT INTO `wp_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`)
VALUES
	(1,1,'A WordPress Commenter','wapuu@wordpress.example','https://wordpress.org/','','2019-07-03 13:32:39','2019-07-03 13:32:39','Hi, this is a comment.\nTo get started with moderating, editing, and deleting comments, please visit the Comments screen in the dashboard.\nCommenter avatars come from <a href=\"https://gravatar.com\">Gravatar</a>.',0,'1','','',0,0);

/*!40000 ALTER TABLE `wp_comments` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_hrm_applications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_applications`;

CREATE TABLE `wp_hrm_applications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recruitment_id` int(10) unsigned NOT NULL,
  `user_id` tinyint(10) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `gender` tinyint(2) DEFAULT NULL,
  `marital_status` tinyint(2) DEFAULT NULL,
  `date_of_birth` datetime DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `profile` varchar(10) DEFAULT NULL,
  `educations` longtext,
  `skills` longtext,
  `experiences` longtext,
  `questions` longtext,
  `resume` longtext,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `recruitment_id` (`recruitment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `wp_hrm_applications` WRITE;
/*!40000 ALTER TABLE `wp_hrm_applications` DISABLE KEYS */;

INSERT INTO `wp_hrm_applications` (`id`, `recruitment_id`, `user_id`, `first_name`, `last_name`, `email`, `gender`, `marital_status`, `date_of_birth`, `address1`, `address2`, `city`, `state`, `zip_code`, `country`, `mobile`, `profile`, `educations`, `skills`, `experiences`, `questions`, `resume`, `created_at`, `updated_at`)
VALUES
	(1,1,NULL,'Asaquzzaman','Mishu','joy.mishu@gmail.com',1,0,'2019-09-30 00:00:00',NULL,'Dhanmondi, Dhaka 1205','Dhaka','Dhaka','1216','a:2:{s:3:\"iso\";s:2:\"BD\";s:7:\"country\";s:10:\"Bangladesh\";}','+8801716644810','29','a:1:{i:0;a:6:{s:5:\"title\";s:5:\"lakfs\";s:9:\"institute\";s:6:\"lkjflk\";s:5:\"start\";s:10:\"2019-09-23\";s:3:\"end\";s:10:\"2019-09-30\";s:5:\"major\";s:4:\"aerg\";s:5:\"score\";s:2:\"23\";}}','a:1:{i:0;a:3:{s:5:\"title\";s:9:\"sefbhaezd\";s:18:\"year_of_experience\";s:1:\"4\";s:7:\"comment\";s:10:\"aefhbzedsf\";}}','a:1:{i:0;a:4:{s:5:\"title\";s:8:\"aefgbazs\";s:4:\"from\";s:10:\"2019-09-01\";s:2:\"to\";s:10:\"2019-09-30\";s:11:\"description\";s:12:\"lkfxjghbnsdf\";}}','a:2:{i:0;a:3:{s:5:\"title\";s:17:\"what is your name\";s:4:\"type\";s:4:\"text\";s:6:\"answer\";s:9:\"s;ekfgjzd\";}i:1;a:3:{s:5:\"title\";s:23:\"tell me about your self\";s:4:\"type\";s:8:\"textarea\";s:6:\"answer\";s:12:\"dfgliuhkjedf\";}}','28','2019-09-23 14:53:52','2019-09-23 14:53:52');

/*!40000 ALTER TABLE `wp_hrm_applications` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_hrm_attendance
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_attendance`;

CREATE TABLE `wp_hrm_attendance` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `punch_in` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `punch_out` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `total` int(11) NOT NULL,
  `shift_id` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `wp_hrm_attendance` WRITE;
/*!40000 ALTER TABLE `wp_hrm_attendance` DISABLE KEYS */;

INSERT INTO `wp_hrm_attendance` (`id`, `user_id`, `date`, `punch_in`, `punch_out`, `total`, `shift_id`, `updated_at`, `created_at`)
VALUES
	(1,2,'2019-07-03 16:34:53','2019-07-03 16:34:53','2019-07-03 16:44:24',571,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(2,3,'2019-08-31 09:32:42','2019-08-31 09:32:42','0000-00-00 00:00:00',0,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(3,5,'2019-08-31 17:01:34','2019-08-31 17:01:34','0000-00-00 00:00:00',0,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(4,2,'2019-08-31 17:01:58','2019-08-31 17:01:58','2019-09-01 04:24:53',40975,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(5,2,'2019-09-01 04:25:03','2019-09-01 04:25:03','2019-09-01 04:25:17',14,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(6,2,'2019-09-01 04:25:32','2019-09-01 04:25:32','2019-09-01 04:27:09',97,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(7,2,'2019-09-01 04:27:12','2019-09-01 04:27:12','0000-00-00 00:00:00',0,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(8,2,'2019-09-23 10:39:58','2019-09-23 10:39:58','2019-09-23 10:40:16',18,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(9,2,'2019-09-23 10:40:24','2019-09-23 10:40:24','2019-09-23 10:40:35',11,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(10,2,'2019-09-23 10:40:59','2019-09-23 10:40:59','2019-09-23 10:43:09',130,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(11,2,'2019-09-23 00:00:00','2019-09-23 10:43:15','2019-09-23 12:30:03',2808,2,'2019-09-23 11:47:31','0000-00-00 00:00:00'),
	(12,2,'2019-09-23 11:31:45','2019-09-23 11:31:45','2019-09-23 11:36:31',286,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(13,2,'2019-09-23 11:43:24','2019-09-23 11:43:24','2019-09-23 11:44:45',81,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(14,2,'2019-09-23 00:00:00','2019-09-23 11:45:45','2019-09-23 11:55:25',580,2,'2019-09-23 11:58:33','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `wp_hrm_attendance` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_hrm_designation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_designation`;

CREATE TABLE `wp_hrm_designation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `department` bigint(20) NOT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `wp_hrm_designation` WRITE;
/*!40000 ALTER TABLE `wp_hrm_designation` DISABLE KEYS */;

INSERT INTO `wp_hrm_designation` (`id`, `title`, `description`, `department`, `created_by`, `updated_by`, `created_at`, `updated_at`)
VALUES
	(2,'Web Developer','A Web Developer is responsible for the coding, design and layout of a website according to a company\\\'s specifications.',2,NULL,NULL,'2019-08-31 18:01:44','2019-08-31 18:01:44'),
	(3,'Accountant update','Prepares asset, liability, and capital account entries by compiling and analyzing account information',3,NULL,NULL,'2019-08-31 18:02:37','2019-09-07 04:11:12');

/*!40000 ALTER TABLE `wp_hrm_designation` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_hrm_financial_year
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_financial_year`;

CREATE TABLE `wp_hrm_financial_year` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `start` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table wp_hrm_formula
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_formula`;

CREATE TABLE `wp_hrm_formula` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `formula` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `wp_hrm_formula` WRITE;
/*!40000 ALTER TABLE `wp_hrm_formula` DISABLE KEYS */;

INSERT INTO `wp_hrm_formula` (`id`, `name`, `description`, `type`, `formula`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`)
VALUES
	(12,'basic','Basic','income','monthly_salary*70%','enable',NULL,NULL,'2019-09-22 09:11:08','2019-09-22 09:11:08'),
	(13,'medical_allowance','Medical Allowance','income','basic*10%','enable',NULL,NULL,'2019-09-22 09:11:49','2019-09-22 09:11:49'),
	(14,'special_allowance','Special Allowance','income','basic*20%','enable',NULL,NULL,'2019-09-22 09:12:29','2019-09-22 09:12:29'),
	(15,'provident_fund','Provident Fund','deduction','basic*5%','enable',NULL,NULL,'2019-09-22 09:13:27','2019-09-22 09:13:27'),
	(16,'professional_tax','Professional Tax','deduction','basic*5%','enable',NULL,NULL,'2019-09-22 09:14:11','2019-09-22 09:14:11'),
	(17,'income_tax','Income Tak','deduction','basic*5%','enable',NULL,NULL,'2019-09-22 09:14:40','2019-09-22 09:14:40');

/*!40000 ALTER TABLE `wp_hrm_formula` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_hrm_holiday
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_holiday`;

CREATE TABLE `wp_hrm_holiday` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `from` datetime DEFAULT NULL,
  `to` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `f_year` int(11) DEFAULT NULL,
  `length` varchar(10) NOT NULL,
  `index_holiday` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `wp_hrm_holiday` WRITE;
/*!40000 ALTER TABLE `wp_hrm_holiday` DISABLE KEYS */;

INSERT INTO `wp_hrm_holiday` (`id`, `name`, `description`, `from`, `to`, `f_year`, `length`, `index_holiday`)
VALUES
	(3,'Summer Vacation','','2019-08-27 00:00:00','2019-08-29 00:00:00',NULL,'','');

/*!40000 ALTER TABLE `wp_hrm_holiday` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_hrm_job_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_job_category`;

CREATE TABLE `wp_hrm_job_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `active` varchar(4) NOT NULL,
  `description` tinytext NOT NULL,
  `parent` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `wp_hrm_job_category` WRITE;
/*!40000 ALTER TABLE `wp_hrm_job_category` DISABLE KEYS */;

INSERT INTO `wp_hrm_job_category` (`id`, `name`, `active`, `description`, `parent`)
VALUES
	(1,'Science','1','The Engineering Department is responsible for planning, analyzing and implementing system',0),
	(2,'Development','1','Development is defined as the process of growth or new information or an event.',0),
	(3,'Accounting','1','The accounting department is responsible for recording and reporting the cash flow transactions of a company.',0);

/*!40000 ALTER TABLE `wp_hrm_job_category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_hrm_job_title
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_job_title`;

CREATE TABLE `wp_hrm_job_title` (
  `id` int(13) NOT NULL AUTO_INCREMENT,
  `job_title` varchar(100) NOT NULL,
  `job_description` varchar(400) DEFAULT NULL,
  `note` varchar(400) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table wp_hrm_language
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_language`;

CREATE TABLE `wp_hrm_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table wp_hrm_leave
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_leave`;

CREATE TABLE `wp_hrm_leave` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` smallint(6) DEFAULT NULL,
  `comments` varchar(256) DEFAULT NULL COMMENT '1 = ''Pending'', 2 = ''Approve'', 3 = ''Cancel''',
  `type` varchar(13) NOT NULL,
  `emp_id` int(7) NOT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `wp_hrm_leave` WRITE;
/*!40000 ALTER TABLE `wp_hrm_leave` DISABLE KEYS */;

INSERT INTO `wp_hrm_leave` (`id`, `status`, `comments`, `type`, `emp_id`, `start_time`, `end_time`, `created_at`, `updated_at`)
VALUES
	(3,2,'','3',2,'2019-08-22 00:00:00','2019-08-22 00:00:00','2019-08-21 15:50:08','2019-08-21 15:50:54'),
	(4,2,'','3',2,'2019-08-23 00:00:00','2019-08-23 00:00:00','2019-08-21 15:50:08','2019-08-21 15:50:57'),
	(12,1,'','4',1,'2019-09-01 00:00:00','2019-09-01 00:00:00','2019-09-10 04:36:07','2019-09-10 04:36:07'),
	(13,1,'','4',1,'2019-09-02 00:00:00','2019-09-02 00:00:00','2019-09-10 04:36:07','2019-09-10 04:36:07'),
	(14,1,'','4',1,'2019-09-03 00:00:00','2019-09-03 00:00:00','2019-09-10 04:36:07','2019-09-10 04:36:07'),
	(15,1,'','4',1,'2019-09-04 00:00:00','2019-09-04 00:00:00','2019-09-10 04:36:07','2019-09-10 04:36:07'),
	(16,1,'','4',1,'2019-09-05 00:00:00','2019-09-05 00:00:00','2019-09-10 04:36:07','2019-09-10 04:36:07'),
	(17,1,'','4',1,'2019-09-06 00:00:00','2019-09-06 00:00:00','2019-09-10 04:36:07','2019-09-10 04:36:07'),
	(18,1,'','4',1,'2019-09-07 00:00:00','2019-09-07 00:00:00','2019-09-10 04:36:07','2019-09-10 04:36:07'),
	(19,1,'','4',2,'2019-09-01 00:00:00','2019-09-01 00:00:00','2019-09-10 04:39:40','2019-09-10 04:39:40'),
	(20,1,'','4',2,'2019-09-02 00:00:00','2019-09-02 00:00:00','2019-09-10 04:39:40','2019-09-10 04:39:40'),
	(21,1,'','4',2,'2019-09-03 00:00:00','2019-09-03 00:00:00','2019-09-10 04:39:40','2019-09-10 04:39:40'),
	(22,1,'','4',2,'2019-09-04 00:00:00','2019-09-04 00:00:00','2019-09-10 04:39:40','2019-09-10 04:39:40'),
	(23,1,'','4',2,'2019-09-05 00:00:00','2019-09-05 00:00:00','2019-09-10 04:39:40','2019-09-10 04:39:40'),
	(24,1,'','4',2,'2019-09-06 00:00:00','2019-09-06 00:00:00','2019-09-10 04:39:40','2019-09-10 04:39:40'),
	(25,1,'','4',2,'2019-09-07 00:00:00','2019-09-07 00:00:00','2019-09-10 04:39:40','2019-09-10 04:39:40');

/*!40000 ALTER TABLE `wp_hrm_leave` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_hrm_leave_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_leave_type`;

CREATE TABLE `wp_hrm_leave_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leave_type_name` varchar(50) DEFAULT NULL,
  `entitlement` smallint(6) DEFAULT '0',
  `entitle_from` timestamp NULL DEFAULT NULL,
  `entitle_to` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `f_year` int(11) DEFAULT NULL,
  `carry` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `wp_hrm_leave_type` WRITE;
/*!40000 ALTER TABLE `wp_hrm_leave_type` DISABLE KEYS */;

INSERT INTO `wp_hrm_leave_type` (`id`, `leave_type_name`, `entitlement`, `entitle_from`, `entitle_to`, `f_year`, `carry`)
VALUES
	(3,'Sick',10,'2019-07-01 00:00:00','2020-06-30 00:00:00',NULL,1),
	(4,'eid',365,'2019-07-01 00:00:00','2020-06-30 00:00:00',0,0);

/*!40000 ALTER TABLE `wp_hrm_leave_type` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_hrm_loan
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_loan`;

CREATE TABLE `wp_hrm_loan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `employee_id` bigint(20) NOT NULL,
  `parent` bigint(20) DEFAULT '0',
  `loan_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `deduct_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `created_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `amount` float DEFAULT NULL,
  `interest_rate` float DEFAULT NULL,
  `interest_type` varchar(255) DEFAULT NULL,
  `installment` int(10) unsigned DEFAULT NULL,
  `monthly_installment` float DEFAULT NULL,
  `principal_balance` float DEFAULT NULL,
  `interest_balance` float DEFAULT NULL,
  `account` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL COMMENT '1:complete, 2:incomplete',
  `created_by` int(10) unsigned DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `wp_hrm_loan` WRITE;
/*!40000 ALTER TABLE `wp_hrm_loan` DISABLE KEYS */;

INSERT INTO `wp_hrm_loan` (`id`, `employee_id`, `parent`, `loan_date`, `deduct_date`, `created_date`, `amount`, `interest_rate`, `interest_type`, `installment`, `monthly_installment`, `principal_balance`, `interest_balance`, `account`, `status`, `created_by`, `updated_by`, `updated_at`, `created_at`)
VALUES
	(3,5,0,'2019-09-01 00:00:00','2019-09-01 00:00:00','0000-00-00 00:00:00',6000,NULL,NULL,3,2000,NULL,NULL,'7587678','2',NULL,NULL,'2019-09-22 09:15:53','2019-09-22 09:15:53'),
	(4,2,0,'2019-09-01 00:00:00','2019-09-01 00:00:00','0000-00-00 00:00:00',6000,NULL,NULL,3,2000,NULL,NULL,'97867','2',NULL,NULL,'2019-09-22 09:20:32','2019-09-22 09:20:32');

/*!40000 ALTER TABLE `wp_hrm_loan` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_hrm_loan_payment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_loan_payment`;

CREATE TABLE `wp_hrm_loan_payment` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `loan_id` bigint(20) DEFAULT '0',
  `type_id` bigint(20) DEFAULT '0' COMMENT 'Exa: Salary_id',
  `amount` float DEFAULT NULL,
  `interest_amount` float DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL COMMENT '1:complete, 2:incomplete',
  `created_by` int(10) unsigned DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `wp_hrm_loan_payment` WRITE;
/*!40000 ALTER TABLE `wp_hrm_loan_payment` DISABLE KEYS */;

INSERT INTO `wp_hrm_loan_payment` (`id`, `loan_id`, `type_id`, `amount`, `interest_amount`, `status`, `created_by`, `updated_by`, `updated_at`, `created_at`)
VALUES
	(2,3,0,2000,NULL,'1',NULL,NULL,'2019-09-22 13:02:42','2019-09-22 13:02:42'),
	(5,3,22,2000,NULL,'1',NULL,NULL,'2019-09-22 16:22:44','2019-09-22 16:22:44');

/*!40000 ALTER TABLE `wp_hrm_loan_payment` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_hrm_location
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_location`;

CREATE TABLE `wp_hrm_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(110) NOT NULL,
  `country_code` varchar(3) NOT NULL,
  `province` varchar(60) DEFAULT NULL,
  `city` varchar(60) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `zip_code` varchar(35) DEFAULT NULL,
  `phone` varchar(35) DEFAULT NULL,
  `fax` varchar(35) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `country_code` (`country_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `wp_hrm_location` WRITE;
/*!40000 ALTER TABLE `wp_hrm_location` DISABLE KEYS */;

INSERT INTO `wp_hrm_location` (`id`, `name`, `country_code`, `province`, `city`, `address`, `zip_code`, `phone`, `fax`, `notes`)
VALUES
	(3,'aegaer','AS','zeds','srhbaerg','egbeds','zegegds','aergwd','ergwg lkjhkj','ergwgds kjhgkjh'),
	(4,'kkkkk kjhkj','AF','lhkjhkj','jhkjhkjh','kjhkjh','kjhkjh','kjhkjh','kjhkjhk','jhkjhkj');

/*!40000 ALTER TABLE `wp_hrm_location` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_hrm_notice
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_notice`;

CREATE TABLE `wp_hrm_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `description` longtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `wp_hrm_notice` WRITE;
/*!40000 ALTER TABLE `wp_hrm_notice` DISABLE KEYS */;

INSERT INTO `wp_hrm_notice` (`id`, `title`, `description`, `user_id`, `date`)
VALUES
	(1,'Public Speaking Contest','On occasion of \\\"CMA Day-2018\\\", the Institute is going to organize “Students’ Summit” for the students of ICMAB on Thursday, the 15th November, 2018 at ICMAB Ruhul Quddus Auditorium, ICMA Bhaban, Dhaka. On that occasion, there will be a Public Speaking contest on the following topics:\n\nSustainable Development Goals of Bangladesh: Role of ICMAB\nTechnological Disruption on CMA profession\nCMA’s role in National Economic Development\nStudents are required to give a speech for 10 minutes before the audiences and jury board on any of the above topics.\nInterested students are advised to register their details (name, registration number, mobile number, email) to Mr. Md. Nayim-Uz-Zaman, Assistant Director (Education), ICMAB. Or send it through e-mail to asd.edu@icmab.org.bd on or before October 31, 2018.',1,'2019-08-31 00:00:00'),
	(2,'Revised notice For special classes','On the occasion of “CMA Day-2018”, the Institute is going to organize “Students’ Summit” for the students of ICMAB on Thursday, the 15th November 2018 at ICMAB Ruhul Quddus Auditorium, ICMA Bhaban, Nilkhet, Dhaka. The Summit will continue from 3:00 p.m. to 9:00 p.m. on that day.\n\nInterested students are advised to register their details (Name, Registration Number, Mobile Number, E-mail and T-Shirt size) to Mr. M. Abdul Mazid, Officer, Education Department of ICMAB from 10:00 a.m. to 06:00 p.m. within November 08, 2018. Registration fee for participating in the Summit is Tk. 300.00 (Three hundred) only. There will be a Gift Box (T-Shirt, Diary & Pen) for each participant.',1,'2019-08-31 00:00:00');

/*!40000 ALTER TABLE `wp_hrm_notice` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_hrm_office_time
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_office_time`;

CREATE TABLE `wp_hrm_office_time` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `is_multi` int(3) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `wp_hrm_office_time` WRITE;
/*!40000 ALTER TABLE `wp_hrm_office_time` DISABLE KEYS */;

INSERT INTO `wp_hrm_office_time` (`id`, `start`, `end`, `is_multi`, `date`, `ip`)
VALUES
	(1,'2019-09-23 09:28:38','2019-09-23 09:28:38',1,'2019-09-23 15:28:38','a:2:{i:0;s:13:\"103.108.147.6\";i:1;s:13:\"103.108.147.6\";}'),
	(2,'2019-09-23 09:29:07','2019-09-23 09:29:07',1,'2019-09-23 15:29:07','a:2:{i:0;s:13:\"103.108.147.6\";i:1;s:13:\"103.108.147.6\";}'),
	(3,'2019-09-23 09:30:04','2019-09-23 09:30:04',1,'2019-09-23 15:30:04','a:2:{i:0;s:13:\"103.108.147.6\";i:1;s:13:\"103.108.147.6\";}'),
	(4,'2019-09-23 09:38:39','2019-09-23 09:38:39',1,'2019-09-23 15:38:39','a:2:{i:0;s:13:\"103.108.147.6\";i:1;s:13:\"103.108.147.6\";}'),
	(5,'2019-09-23 09:38:50','2019-09-23 09:38:50',1,'2019-09-23 15:38:50','a:0:{}');

/*!40000 ALTER TABLE `wp_hrm_office_time` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_hrm_pay_grade
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_pay_grade`;

CREATE TABLE `wp_hrm_pay_grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table wp_hrm_personal_education
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_personal_education`;

CREATE TABLE `wp_hrm_personal_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `education` varchar(255) NOT NULL,
  `institute` varchar(100) DEFAULT NULL,
  `major` varchar(100) DEFAULT NULL,
  `year` timestamp NULL DEFAULT NULL,
  `score` varchar(25) DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table wp_hrm_personal_language
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_personal_language`;

CREATE TABLE `wp_hrm_personal_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(7) NOT NULL,
  `language_id` int(11) NOT NULL,
  `fluency` text NOT NULL,
  `competency` text NOT NULL,
  `comments` varchar(100) DEFAULT NULL,
  KEY `lang_id` (`language_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table wp_hrm_personal_skill
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_personal_skill`;

CREATE TABLE `wp_hrm_personal_skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(7) NOT NULL DEFAULT '0',
  `skill` varchar(255) NOT NULL,
  `years_of_exp` decimal(2,0) DEFAULT NULL,
  `comments` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table wp_hrm_recruitment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_recruitment`;

CREATE TABLE `wp_hrm_recruitment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `position` varchar(255) NOT NULL,
  `description` text,
  `jobtype` tinyint(4) NOT NULL DEFAULT '0',
  `department` int(10) unsigned DEFAULT NULL,
  `designation` int(10) unsigned DEFAULT NULL,
  `location` int(10) unsigned DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `open` timestamp NULL DEFAULT NULL,
  `close` timestamp NULL DEFAULT NULL,
  `questions` text,
  `created_by` int(10) unsigned DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `department_designation` (`department`,`designation`),
  KEY `jobtype` (`jobtype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `wp_hrm_recruitment` WRITE;
/*!40000 ALTER TABLE `wp_hrm_recruitment` DISABLE KEYS */;

INSERT INTO `wp_hrm_recruitment` (`id`, `position`, `description`, `jobtype`, `department`, `designation`, `location`, `status`, `open`, `close`, `questions`, `created_by`, `updated_by`, `created_at`, `updated_at`)
VALUES
	(1,'web developer','about web developer',0,2,2,3,1,'2019-09-01 00:00:00','2019-09-30 00:00:00','a:2:{i:0;a:2:{s:5:\"title\";s:17:\"what is your name\";s:4:\"type\";s:4:\"text\";}i:1;a:2:{s:5:\"title\";s:23:\"tell me about your self\";s:4:\"type\";s:8:\"textarea\";}}',1,1,'2019-09-23 14:51:26','2019-09-23 14:51:26');

/*!40000 ALTER TABLE `wp_hrm_recruitment` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_hrm_relation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_relation`;

CREATE TABLE `wp_hrm_relation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `from` int(11) DEFAULT NULL,
  `to` int(11) DEFAULT NULL,
  `aegfvae` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `wp_hrm_relation` WRITE;
/*!40000 ALTER TABLE `wp_hrm_relation` DISABLE KEYS */;

INSERT INTO `wp_hrm_relation` (`id`, `type`, `from`, `to`, `aegfvae`)
VALUES
	(1,'time_shift_department',1,1,NULL),
	(2,'time_shift_department',2,1,NULL),
	(3,'leave_type',1,1,NULL),
	(4,'leave_type',1,1,NULL),
	(5,'leave_type',2,1,NULL),
	(6,'leave_type',3,1,NULL),
	(7,'leave_type',1,1,NULL),
	(8,'leave_type',2,1,NULL),
	(9,'leave_type',3,1,NULL),
	(10,'leave_type',4,1,NULL),
	(11,'time_shift_department',0,4,NULL),
	(12,'time_shift_department',0,4,NULL),
	(13,'time_shift_department',0,5,NULL),
	(14,'time_shift_department',3,5,NULL),
	(15,'time_shift_department',4,5,NULL),
	(16,'time_shift_department',4,3,NULL);

/*!40000 ALTER TABLE `wp_hrm_relation` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_hrm_salary
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_salary`;

CREATE TABLE `wp_hrm_salary` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `month` timestamp NULL DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL COMMENT 'employee, designation',
  `category_id` int(10) unsigned DEFAULT NULL,
  `employee_id` bigint(20) NOT NULL,
  `group_id` int(10) unsigned DEFAULT NULL,
  `salary_components_id` text,
  `all_components_id` text,
  `info` text,
  `type` varchar(255) DEFAULT NULL COMMENT 'monthly, annual',
  `salary` varchar(255) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `wp_hrm_salary` WRITE;
/*!40000 ALTER TABLE `wp_hrm_salary` DISABLE KEYS */;

INSERT INTO `wp_hrm_salary` (`id`, `month`, `category`, `category_id`, `employee_id`, `group_id`, `salary_components_id`, `all_components_id`, `info`, `type`, `salary`, `created_by`, `updated_by`, `created_at`, `updated_at`)
VALUES
	(18,'2019-09-01 00:00:00','designation',2,1,0,'a:6:{i:0;s:2:\"17\";i:1;s:2:\"16\";i:2;s:2:\"15\";i:3;s:2:\"14\";i:4;s:2:\"13\";i:5;s:2:\"12\";}','a:6:{i:0;s:2:\"17\";i:1;s:2:\"16\";i:2;s:2:\"15\";i:3;s:2:\"14\";i:4;s:2:\"13\";i:5;s:2:\"12\";}','a:2:{s:4:\"data\";a:6:{i:0;a:7:{s:2:\"id\";s:2:\"17\";s:4:\"name\";s:10:\"income_tax\";s:11:\"description\";s:10:\"Income Tak\";s:4:\"type\";s:9:\"deduction\";s:7:\"formula\";s:8:\"basic*5%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:2450;}i:1;a:7:{s:2:\"id\";s:2:\"16\";s:4:\"name\";s:16:\"professional_tax\";s:11:\"description\";s:16:\"Professional Tax\";s:4:\"type\";s:9:\"deduction\";s:7:\"formula\";s:8:\"basic*5%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:2450;}i:2;a:7:{s:2:\"id\";s:2:\"15\";s:4:\"name\";s:14:\"provident_fund\";s:11:\"description\";s:14:\"Provident Fund\";s:4:\"type\";s:9:\"deduction\";s:7:\"formula\";s:8:\"basic*5%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:2450;}i:3;a:7:{s:2:\"id\";s:2:\"14\";s:4:\"name\";s:17:\"special_allowance\";s:11:\"description\";s:17:\"Special Allowance\";s:4:\"type\";s:6:\"income\";s:7:\"formula\";s:9:\"basic*20%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:9800;}i:4;a:7:{s:2:\"id\";s:2:\"13\";s:4:\"name\";s:17:\"medical_allowance\";s:11:\"description\";s:17:\"Medical Allowance\";s:4:\"type\";s:6:\"income\";s:7:\"formula\";s:9:\"basic*10%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:4900;}i:5;a:7:{s:2:\"id\";s:2:\"12\";s:4:\"name\";s:5:\"basic\";s:11:\"description\";s:5:\"Basic\";s:4:\"type\";s:6:\"income\";s:7:\"formula\";s:18:\"monthly_salary*70%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:49000;}}s:4:\"meta\";a:2:{s:10:\"pagination\";a:6:{s:5:\"total\";i:6;s:5:\"count\";i:6;s:8:\"per_page\";i:100000;s:12:\"current_page\";i:1;s:11:\"total_pages\";i:1;s:5:\"links\";a:0:{}}s:10:\"salaryMeta\";a:4:{s:6:\"others\";i:6300;s:11:\"incomeTotal\";s:5:\"70000\";s:14:\"deductionTotal\";i:7350;s:11:\"employeeGet\";i:62650;}}}','monthly','70000',1,1,'2019-09-22 13:11:08','2019-09-22 13:37:03'),
	(20,'2019-09-01 00:00:00','designation',2,6,0,'a:6:{i:0;s:2:\"17\";i:1;s:2:\"16\";i:2;s:2:\"15\";i:3;s:2:\"14\";i:4;s:2:\"13\";i:5;s:2:\"12\";}','a:6:{i:0;s:2:\"17\";i:1;s:2:\"16\";i:2;s:2:\"15\";i:3;s:2:\"14\";i:4;s:2:\"13\";i:5;s:2:\"12\";}','a:2:{s:4:\"data\";a:6:{i:0;a:7:{s:2:\"id\";s:2:\"17\";s:4:\"name\";s:10:\"income_tax\";s:11:\"description\";s:10:\"Income Tak\";s:4:\"type\";s:9:\"deduction\";s:7:\"formula\";s:8:\"basic*5%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:2450;}i:1;a:7:{s:2:\"id\";s:2:\"16\";s:4:\"name\";s:16:\"professional_tax\";s:11:\"description\";s:16:\"Professional Tax\";s:4:\"type\";s:9:\"deduction\";s:7:\"formula\";s:8:\"basic*5%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:2450;}i:2;a:7:{s:2:\"id\";s:2:\"15\";s:4:\"name\";s:14:\"provident_fund\";s:11:\"description\";s:14:\"Provident Fund\";s:4:\"type\";s:9:\"deduction\";s:7:\"formula\";s:8:\"basic*5%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:2450;}i:3;a:7:{s:2:\"id\";s:2:\"14\";s:4:\"name\";s:17:\"special_allowance\";s:11:\"description\";s:17:\"Special Allowance\";s:4:\"type\";s:6:\"income\";s:7:\"formula\";s:9:\"basic*20%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:9800;}i:4;a:7:{s:2:\"id\";s:2:\"13\";s:4:\"name\";s:17:\"medical_allowance\";s:11:\"description\";s:17:\"Medical Allowance\";s:4:\"type\";s:6:\"income\";s:7:\"formula\";s:9:\"basic*10%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:4900;}i:5;a:7:{s:2:\"id\";s:2:\"12\";s:4:\"name\";s:5:\"basic\";s:11:\"description\";s:5:\"Basic\";s:4:\"type\";s:6:\"income\";s:7:\"formula\";s:18:\"monthly_salary*70%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:49000;}}s:4:\"meta\";a:2:{s:10:\"pagination\";a:6:{s:5:\"total\";i:6;s:5:\"count\";i:6;s:8:\"per_page\";i:100000;s:12:\"current_page\";i:1;s:11:\"total_pages\";i:1;s:5:\"links\";a:0:{}}s:10:\"salaryMeta\";a:4:{s:6:\"others\";i:6300;s:11:\"incomeTotal\";s:5:\"70000\";s:14:\"deductionTotal\";i:7350;s:11:\"employeeGet\";i:62650;}}}','monthly','70000',1,1,'2019-09-22 13:11:08','2019-09-22 13:37:03'),
	(21,'2019-09-01 00:00:00','designation',2,7,0,'a:6:{i:0;s:2:\"17\";i:1;s:2:\"16\";i:2;s:2:\"15\";i:3;s:2:\"14\";i:4;s:2:\"13\";i:5;s:2:\"12\";}','a:6:{i:0;s:2:\"17\";i:1;s:2:\"16\";i:2;s:2:\"15\";i:3;s:2:\"14\";i:4;s:2:\"13\";i:5;s:2:\"12\";}','a:2:{s:4:\"data\";a:6:{i:0;a:7:{s:2:\"id\";s:2:\"17\";s:4:\"name\";s:10:\"income_tax\";s:11:\"description\";s:10:\"Income Tak\";s:4:\"type\";s:9:\"deduction\";s:7:\"formula\";s:8:\"basic*5%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:2450;}i:1;a:7:{s:2:\"id\";s:2:\"16\";s:4:\"name\";s:16:\"professional_tax\";s:11:\"description\";s:16:\"Professional Tax\";s:4:\"type\";s:9:\"deduction\";s:7:\"formula\";s:8:\"basic*5%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:2450;}i:2;a:7:{s:2:\"id\";s:2:\"15\";s:4:\"name\";s:14:\"provident_fund\";s:11:\"description\";s:14:\"Provident Fund\";s:4:\"type\";s:9:\"deduction\";s:7:\"formula\";s:8:\"basic*5%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:2450;}i:3;a:7:{s:2:\"id\";s:2:\"14\";s:4:\"name\";s:17:\"special_allowance\";s:11:\"description\";s:17:\"Special Allowance\";s:4:\"type\";s:6:\"income\";s:7:\"formula\";s:9:\"basic*20%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:9800;}i:4;a:7:{s:2:\"id\";s:2:\"13\";s:4:\"name\";s:17:\"medical_allowance\";s:11:\"description\";s:17:\"Medical Allowance\";s:4:\"type\";s:6:\"income\";s:7:\"formula\";s:9:\"basic*10%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:4900;}i:5;a:7:{s:2:\"id\";s:2:\"12\";s:4:\"name\";s:5:\"basic\";s:11:\"description\";s:5:\"Basic\";s:4:\"type\";s:6:\"income\";s:7:\"formula\";s:18:\"monthly_salary*70%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:49000;}}s:4:\"meta\";a:2:{s:10:\"pagination\";a:6:{s:5:\"total\";i:6;s:5:\"count\";i:6;s:8:\"per_page\";i:100000;s:12:\"current_page\";i:1;s:11:\"total_pages\";i:1;s:5:\"links\";a:0:{}}s:10:\"salaryMeta\";a:4:{s:6:\"others\";i:6300;s:11:\"incomeTotal\";s:5:\"70000\";s:14:\"deductionTotal\";i:7350;s:11:\"employeeGet\";i:62650;}}}','monthly','70000',1,1,'2019-09-22 13:11:08','2019-09-22 13:37:03'),
	(22,'2019-09-01 00:00:00','employee',5,5,0,'a:6:{i:0;s:2:\"17\";i:1;s:2:\"16\";i:2;s:2:\"15\";i:3;s:2:\"14\";i:4;s:2:\"13\";i:5;s:2:\"12\";}','a:6:{i:0;s:2:\"17\";i:1;s:2:\"16\";i:2;s:2:\"15\";i:3;s:2:\"14\";i:4;s:2:\"13\";i:5;s:2:\"12\";}','a:2:{s:4:\"data\";a:8:{i:0;a:7:{s:2:\"id\";s:2:\"17\";s:4:\"name\";s:10:\"income_tax\";s:11:\"description\";s:10:\"Income Tak\";s:4:\"type\";s:9:\"deduction\";s:7:\"formula\";s:8:\"basic*5%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:1750;}i:1;a:7:{s:2:\"id\";s:2:\"16\";s:4:\"name\";s:16:\"professional_tax\";s:11:\"description\";s:16:\"Professional Tax\";s:4:\"type\";s:9:\"deduction\";s:7:\"formula\";s:8:\"basic*5%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:1750;}i:2;a:7:{s:2:\"id\";s:2:\"15\";s:4:\"name\";s:14:\"provident_fund\";s:11:\"description\";s:14:\"Provident Fund\";s:4:\"type\";s:9:\"deduction\";s:7:\"formula\";s:8:\"basic*5%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:1750;}i:3;a:7:{s:2:\"id\";s:2:\"14\";s:4:\"name\";s:17:\"special_allowance\";s:11:\"description\";s:17:\"Special Allowance\";s:4:\"type\";s:6:\"income\";s:7:\"formula\";s:9:\"basic*20%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:7000;}i:4;a:7:{s:2:\"id\";s:2:\"13\";s:4:\"name\";s:17:\"medical_allowance\";s:11:\"description\";s:17:\"Medical Allowance\";s:4:\"type\";s:6:\"income\";s:7:\"formula\";s:9:\"basic*10%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:3500;}i:5;a:7:{s:2:\"id\";s:2:\"12\";s:4:\"name\";s:5:\"basic\";s:11:\"description\";s:5:\"Basic\";s:4:\"type\";s:6:\"income\";s:7:\"formula\";s:18:\"monthly_salary*70%\";s:6:\"status\";s:6:\"enable\";s:6:\"amount\";i:35000;}i:6;a:4:{s:4:\"name\";s:4:\"loan\";s:11:\"description\";s:4:\"Loan\";s:4:\"type\";s:9:\"deduction\";s:6:\"amount\";s:4:\"2000\";}i:7;a:4:{s:4:\"name\";s:4:\"loan\";s:11:\"description\";s:4:\"Loan\";s:4:\"type\";s:9:\"deduction\";s:6:\"amount\";i:2000;}}s:4:\"meta\";a:2:{s:10:\"pagination\";a:6:{s:5:\"total\";i:6;s:5:\"count\";i:6;s:8:\"per_page\";i:100000;s:12:\"current_page\";i:1;s:11:\"total_pages\";i:1;s:5:\"links\";a:0:{}}s:10:\"salaryMeta\";a:4:{s:6:\"others\";i:4500;s:11:\"incomeTotal\";s:5:\"50000\";s:14:\"deductionTotal\";i:7250;s:11:\"employeeGet\";i:42750;}}}','monthly','50000',1,1,'2019-09-22 16:22:44','2019-09-22 16:23:22');

/*!40000 ALTER TABLE `wp_hrm_salary` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_hrm_salary_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_salary_group`;

CREATE TABLE `wp_hrm_salary_group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `income` text COLLATE utf8mb4_unicode_ci,
  `deduction` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(10) unsigned DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `wp_hrm_salary_group` WRITE;
/*!40000 ALTER TABLE `wp_hrm_salary_group` DISABLE KEYS */;

INSERT INTO `wp_hrm_salary_group` (`id`, `name`, `income`, `deduction`, `created_by`, `updated_by`, `created_at`, `updated_at`)
VALUES
	(1,'test','a:2:{i:0;s:2:\"14\";i:1;s:2:\"13\";}','a:2:{i:0;s:2:\"15\";i:1;s:2:\"16\";}',NULL,NULL,'2019-09-22 15:41:03','2019-09-22 15:41:03');

/*!40000 ALTER TABLE `wp_hrm_salary_group` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_hrm_time_shift
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_time_shift`;

CREATE TABLE `wp_hrm_time_shift` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `department` int(11) NOT NULL,
  `punch_start` timestamp NULL DEFAULT NULL,
  `times` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `wp_hrm_time_shift` WRITE;
/*!40000 ALTER TABLE `wp_hrm_time_shift` DISABLE KEYS */;

INSERT INTO `wp_hrm_time_shift` (`id`, `name`, `status`, `department`, `punch_start`, `times`, `created_at`, `updated_at`)
VALUES
	(1,'Day ',0,0,'2019-07-06 07:00:00','a:2:{i:0;a:8:{s:5:\"begin\";s:5:\"08:00\";s:3:\"end\";s:5:\"17:00\";s:9:\"workHours\";s:1:\"9\";s:11:\"workMinutes\";s:2:\"00\";s:11:\"breakStatus\";s:4:\"true\";s:11:\"departments\";a:1:{i:0;a:9:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:8:\"Engineer\";s:6:\"active\";s:1:\"1\";s:11:\"description\";s:0:\"\";s:6:\"parent\";s:1:\"0\";s:18:\"number_of_employee\";s:1:\"1\";s:18:\"hierarchical_depth\";s:1:\"0\";s:16:\"hierarchical_pad\";s:0:\"\";s:21:\"hierarchical_free_pad\";s:0:\"\";}}s:6:\"breaks\";a:2:{i:0;a:4:{s:10:\"breakBegin\";s:5:\"13:00\";s:8:\"breakEnd\";s:5:\"13:30\";s:10:\"breakHours\";s:1:\"0\";s:12:\"breakMinutes\";s:2:\"30\";}i:1;a:4:{s:10:\"breakBegin\";s:5:\"16:00\";s:8:\"breakEnd\";s:5:\"16:30\";s:10:\"breakHours\";s:1:\"0\";s:12:\"breakMinutes\";s:2:\"30\";}}s:5:\"popup\";s:5:\"false\";}i:1;a:8:{s:5:\"begin\";s:5:\"18:00\";s:3:\"end\";s:5:\"23:00\";s:9:\"workHours\";s:1:\"5\";s:11:\"workMinutes\";s:2:\"00\";s:11:\"breakStatus\";s:5:\"false\";s:11:\"departments\";a:1:{i:0;a:9:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:8:\"Engineer\";s:6:\"active\";s:1:\"1\";s:11:\"description\";s:0:\"\";s:6:\"parent\";s:1:\"0\";s:18:\"number_of_employee\";s:1:\"1\";s:18:\"hierarchical_depth\";s:1:\"0\";s:16:\"hierarchical_pad\";s:0:\"\";s:21:\"hierarchical_free_pad\";s:0:\"\";}}s:6:\"breaks\";a:1:{i:0;a:4:{s:10:\"breakBegin\";s:0:\"\";s:8:\"breakEnd\";s:0:\"\";s:10:\"breakHours\";s:0:\"\";s:12:\"breakMinutes\";s:0:\"\";}}s:5:\"popup\";s:5:\"false\";}}','2019-07-03 16:15:22','2019-07-06 14:08:05'),
	(2,'Day Shift',1,0,'2019-09-19 08:00:00','a:2:{i:0;a:8:{s:5:\"begin\";s:4:\"9:00\";s:3:\"end\";s:5:\"17:00\";s:9:\"workHours\";s:1:\"7\";s:11:\"workMinutes\";s:2:\"00\";s:11:\"breakStatus\";s:4:\"true\";s:11:\"departments\";a:1:{i:0;a:9:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:8:\"Engineer\";s:6:\"active\";s:1:\"1\";s:11:\"description\";s:0:\"\";s:6:\"parent\";s:1:\"0\";s:18:\"number_of_employee\";s:1:\"1\";s:18:\"hierarchical_depth\";s:1:\"0\";s:16:\"hierarchical_pad\";s:0:\"\";s:21:\"hierarchical_free_pad\";s:0:\"\";}}s:6:\"breaks\";a:1:{i:0;a:4:{s:10:\"breakBegin\";s:5:\"13:00\";s:8:\"breakEnd\";s:5:\"14:00\";s:10:\"breakHours\";s:1:\"1\";s:12:\"breakMinutes\";s:1:\"0\";}}s:5:\"popup\";s:5:\"false\";}i:1;a:8:{s:5:\"begin\";s:5:\"19:00\";s:3:\"end\";s:5:\"23:00\";s:9:\"workHours\";s:1:\"3\";s:11:\"workMinutes\";s:2:\"00\";s:11:\"breakStatus\";s:4:\"true\";s:11:\"departments\";a:1:{i:0;a:9:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:8:\"Engineer\";s:6:\"active\";s:1:\"1\";s:11:\"description\";s:0:\"\";s:6:\"parent\";s:1:\"0\";s:18:\"number_of_employee\";s:1:\"1\";s:18:\"hierarchical_depth\";s:1:\"0\";s:16:\"hierarchical_pad\";s:0:\"\";s:21:\"hierarchical_free_pad\";s:0:\"\";}}s:6:\"breaks\";a:1:{i:0;a:4:{s:10:\"breakBegin\";s:5:\"21:00\";s:8:\"breakEnd\";s:5:\"21:00\";s:10:\"breakHours\";s:1:\"0\";s:12:\"breakMinutes\";s:1:\"0\";}}s:5:\"popup\";s:5:\"false\";}}','2019-07-20 08:25:09','2019-09-19 16:39:05'),
	(3,'aweWE',0,0,'2019-09-19 08:00:00','a:1:{i:0;a:7:{s:5:\"begin\";s:5:\"10:00\";s:3:\"end\";s:5:\"18:00\";s:9:\"workHours\";s:1:\"8\";s:11:\"workMinutes\";s:1:\"0\";s:11:\"breakStatus\";s:4:\"true\";s:11:\"departments\";a:1:{i:0;a:9:{s:2:\"id\";s:1:\"5\";s:4:\"name\";s:10:\"hgbkhjgkjh\";s:6:\"active\";s:1:\"1\";s:11:\"description\";s:0:\"\";s:6:\"parent\";s:1:\"0\";s:18:\"number_of_employee\";s:1:\"0\";s:18:\"hierarchical_depth\";s:1:\"0\";s:16:\"hierarchical_pad\";s:0:\"\";s:21:\"hierarchical_free_pad\";s:0:\"\";}}s:6:\"breaks\";a:1:{i:0;a:4:{s:10:\"breakBegin\";s:5:\"13:00\";s:8:\"breakEnd\";s:5:\"14:00\";s:10:\"breakHours\";s:1:\"1\";s:12:\"breakMinutes\";s:1:\"0\";}}}}','2019-09-19 16:38:23','2019-09-21 08:50:15'),
	(4,'Another Shift',0,0,'2019-09-21 08:00:00','a:2:{i:0;a:8:{s:5:\"begin\";s:5:\"10:00\";s:3:\"end\";s:5:\"18:00\";s:9:\"workHours\";s:1:\"7\";s:11:\"workMinutes\";s:2:\"00\";s:11:\"breakStatus\";s:4:\"true\";s:11:\"departments\";a:1:{i:0;a:9:{s:2:\"id\";s:1:\"5\";s:4:\"name\";s:10:\"hgbkhjgkjh\";s:6:\"active\";s:1:\"1\";s:11:\"description\";s:0:\"\";s:6:\"parent\";s:1:\"0\";s:18:\"number_of_employee\";s:1:\"0\";s:18:\"hierarchical_depth\";s:1:\"0\";s:16:\"hierarchical_pad\";s:0:\"\";s:21:\"hierarchical_free_pad\";s:0:\"\";}}s:6:\"breaks\";a:2:{i:0;a:4:{s:10:\"breakBegin\";s:5:\"13:00\";s:8:\"breakEnd\";s:5:\"13:35\";s:10:\"breakHours\";s:1:\"0\";s:12:\"breakMinutes\";s:2:\"35\";}i:1;a:4:{s:10:\"breakBegin\";s:5:\"15:00\";s:8:\"breakEnd\";s:5:\"15:35\";s:10:\"breakHours\";s:1:\"0\";s:12:\"breakMinutes\";s:2:\"35\";}}s:5:\"popup\";s:5:\"false\";}i:1;a:8:{s:5:\"begin\";s:5:\"19:00\";s:3:\"end\";s:5:\"23:00\";s:9:\"workHours\";s:1:\"3\";s:11:\"workMinutes\";s:1:\"0\";s:11:\"breakStatus\";s:4:\"true\";s:11:\"departments\";a:1:{i:0;a:9:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:10:\"Accounting\";s:6:\"active\";s:1:\"1\";s:11:\"description\";s:109:\"The accounting department is responsible for recording and reporting the cash flow transactions of a company.\";s:6:\"parent\";s:1:\"0\";s:18:\"number_of_employee\";s:1:\"1\";s:18:\"hierarchical_depth\";s:1:\"0\";s:16:\"hierarchical_pad\";s:0:\"\";s:21:\"hierarchical_free_pad\";s:0:\"\";}}s:6:\"breaks\";a:1:{i:0;a:4:{s:10:\"breakBegin\";s:5:\"20:00\";s:8:\"breakEnd\";s:5:\"20:30\";s:10:\"breakHours\";s:1:\"0\";s:12:\"breakMinutes\";s:2:\"30\";}}s:5:\"popup\";s:5:\"false\";}}','2019-09-21 08:53:25','2019-09-21 09:06:28');

/*!40000 ALTER TABLE `wp_hrm_time_shift` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_hrm_work_experience
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_hrm_work_experience`;

CREATE TABLE `wp_hrm_work_experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '0',
  `start` timestamp NULL DEFAULT NULL,
  `end` timestamp NULL DEFAULT NULL,
  `description` tinytext,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table wp_links
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_links`;

CREATE TABLE `wp_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `link_rss` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_options
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_options`;

CREATE TABLE `wp_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `option_value` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `autoload` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

LOCK TABLES `wp_options` WRITE;
/*!40000 ALTER TABLE `wp_options` DISABLE KEYS */;

INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`)
VALUES
	(1,'siteurl','http://localhost/hrm','yes'),
	(2,'home','http://localhost/hrm','yes'),
	(3,'blogname','HRM','yes'),
	(4,'blogdescription','Just another WordPress site','yes'),
	(5,'users_can_register','0','yes'),
	(6,'admin_email','joy.mishu@gmail.com','yes'),
	(7,'start_of_week','1','yes'),
	(8,'use_balanceTags','0','yes'),
	(9,'use_smilies','1','yes'),
	(10,'require_name_email','1','yes'),
	(11,'comments_notify','1','yes'),
	(12,'posts_per_rss','10','yes'),
	(13,'rss_use_excerpt','0','yes'),
	(14,'mailserver_url','mail.example.com','yes'),
	(15,'mailserver_login','login@example.com','yes'),
	(16,'mailserver_pass','password','yes'),
	(17,'mailserver_port','110','yes'),
	(18,'default_category','1','yes'),
	(19,'default_comment_status','open','yes'),
	(20,'default_ping_status','open','yes'),
	(21,'default_pingback_flag','1','yes'),
	(22,'posts_per_page','10','yes'),
	(23,'date_format','F j, Y','yes'),
	(24,'time_format','g:i a','yes'),
	(25,'links_updated_date_format','F j, Y g:i a','yes'),
	(26,'comment_moderation','0','yes'),
	(27,'moderation_notify','1','yes'),
	(28,'permalink_structure','/%postname%/','yes'),
	(29,'rewrite_rules','a:188:{s:11:\"^wp-json/?$\";s:22:\"index.php?rest_route=/\";s:14:\"^wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:21:\"^index.php/wp-json/?$\";s:22:\"index.php?rest_route=/\";s:24:\"^index.php/wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:47:\"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:42:\"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:23:\"category/(.+?)/embed/?$\";s:46:\"index.php?category_name=$matches[1]&embed=true\";s:35:\"category/(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:17:\"category/(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";s:44:\"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:39:\"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:20:\"tag/([^/]+)/embed/?$\";s:36:\"index.php?tag=$matches[1]&embed=true\";s:32:\"tag/([^/]+)/page/?([0-9]{1,})/?$\";s:43:\"index.php?tag=$matches[1]&paged=$matches[2]\";s:14:\"tag/([^/]+)/?$\";s:25:\"index.php?tag=$matches[1]\";s:45:\"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:40:\"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:21:\"type/([^/]+)/embed/?$\";s:44:\"index.php?post_format=$matches[1]&embed=true\";s:33:\"type/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?post_format=$matches[1]&paged=$matches[2]\";s:15:\"type/([^/]+)/?$\";s:33:\"index.php?post_format=$matches[1]\";s:39:\"hrm_project/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:49:\"hrm_project/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:69:\"hrm_project/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:64:\"hrm_project/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:64:\"hrm_project/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:45:\"hrm_project/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:28:\"hrm_project/([^/]+)/embed/?$\";s:44:\"index.php?hrm_project=$matches[1]&embed=true\";s:32:\"hrm_project/([^/]+)/trackback/?$\";s:38:\"index.php?hrm_project=$matches[1]&tb=1\";s:40:\"hrm_project/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?hrm_project=$matches[1]&paged=$matches[2]\";s:47:\"hrm_project/([^/]+)/comment-page-([0-9]{1,})/?$\";s:51:\"index.php?hrm_project=$matches[1]&cpage=$matches[2]\";s:36:\"hrm_project/([^/]+)(?:/([0-9]+))?/?$\";s:50:\"index.php?hrm_project=$matches[1]&page=$matches[2]\";s:28:\"hrm_project/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:38:\"hrm_project/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:58:\"hrm_project/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:53:\"hrm_project/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:53:\"hrm_project/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:34:\"hrm_project/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:36:\"hrm_task/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:46:\"hrm_task/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:66:\"hrm_task/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:61:\"hrm_task/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:61:\"hrm_task/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:42:\"hrm_task/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:25:\"hrm_task/([^/]+)/embed/?$\";s:41:\"index.php?hrm_task=$matches[1]&embed=true\";s:29:\"hrm_task/([^/]+)/trackback/?$\";s:35:\"index.php?hrm_task=$matches[1]&tb=1\";s:37:\"hrm_task/([^/]+)/page/?([0-9]{1,})/?$\";s:48:\"index.php?hrm_task=$matches[1]&paged=$matches[2]\";s:44:\"hrm_task/([^/]+)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?hrm_task=$matches[1]&cpage=$matches[2]\";s:33:\"hrm_task/([^/]+)(?:/([0-9]+))?/?$\";s:47:\"index.php?hrm_task=$matches[1]&page=$matches[2]\";s:25:\"hrm_task/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:35:\"hrm_task/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:55:\"hrm_task/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:50:\"hrm_task/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:50:\"hrm_task/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:31:\"hrm_task/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:36:\"hrm_file/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:46:\"hrm_file/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:66:\"hrm_file/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:61:\"hrm_file/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:61:\"hrm_file/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:42:\"hrm_file/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:25:\"hrm_file/([^/]+)/embed/?$\";s:41:\"index.php?hrm_file=$matches[1]&embed=true\";s:29:\"hrm_file/([^/]+)/trackback/?$\";s:35:\"index.php?hrm_file=$matches[1]&tb=1\";s:37:\"hrm_file/([^/]+)/page/?([0-9]{1,})/?$\";s:48:\"index.php?hrm_file=$matches[1]&paged=$matches[2]\";s:44:\"hrm_file/([^/]+)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?hrm_file=$matches[1]&cpage=$matches[2]\";s:33:\"hrm_file/([^/]+)(?:/([0-9]+))?/?$\";s:47:\"index.php?hrm_file=$matches[1]&page=$matches[2]\";s:25:\"hrm_file/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:35:\"hrm_file/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:55:\"hrm_file/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:50:\"hrm_file/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:50:\"hrm_file/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:31:\"hrm_file/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:37:\"hrm_punch/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:47:\"hrm_punch/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:67:\"hrm_punch/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:62:\"hrm_punch/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:62:\"hrm_punch/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:43:\"hrm_punch/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:26:\"hrm_punch/([^/]+)/embed/?$\";s:42:\"index.php?hrm_punch=$matches[1]&embed=true\";s:30:\"hrm_punch/([^/]+)/trackback/?$\";s:36:\"index.php?hrm_punch=$matches[1]&tb=1\";s:38:\"hrm_punch/([^/]+)/page/?([0-9]{1,})/?$\";s:49:\"index.php?hrm_punch=$matches[1]&paged=$matches[2]\";s:45:\"hrm_punch/([^/]+)/comment-page-([0-9]{1,})/?$\";s:49:\"index.php?hrm_punch=$matches[1]&cpage=$matches[2]\";s:34:\"hrm_punch/([^/]+)(?:/([0-9]+))?/?$\";s:48:\"index.php?hrm_punch=$matches[1]&page=$matches[2]\";s:26:\"hrm_punch/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:36:\"hrm_punch/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:56:\"hrm_punch/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:51:\"hrm_punch/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:51:\"hrm_punch/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:32:\"hrm_punch/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:38:\"hrm_rating/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:48:\"hrm_rating/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:68:\"hrm_rating/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:63:\"hrm_rating/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:63:\"hrm_rating/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:44:\"hrm_rating/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:27:\"hrm_rating/([^/]+)/embed/?$\";s:43:\"index.php?hrm_rating=$matches[1]&embed=true\";s:31:\"hrm_rating/([^/]+)/trackback/?$\";s:37:\"index.php?hrm_rating=$matches[1]&tb=1\";s:39:\"hrm_rating/([^/]+)/page/?([0-9]{1,})/?$\";s:50:\"index.php?hrm_rating=$matches[1]&paged=$matches[2]\";s:46:\"hrm_rating/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?hrm_rating=$matches[1]&cpage=$matches[2]\";s:35:\"hrm_rating/([^/]+)(?:/([0-9]+))?/?$\";s:49:\"index.php?hrm_rating=$matches[1]&page=$matches[2]\";s:27:\"hrm_rating/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\"hrm_rating/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\"hrm_rating/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\"hrm_rating/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\"hrm_rating/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\"hrm_rating/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:45:\"hrm_rating_parent/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:55:\"hrm_rating_parent/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:75:\"hrm_rating_parent/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:70:\"hrm_rating_parent/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:70:\"hrm_rating_parent/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:51:\"hrm_rating_parent/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:34:\"hrm_rating_parent/([^/]+)/embed/?$\";s:50:\"index.php?hrm_rating_parent=$matches[1]&embed=true\";s:38:\"hrm_rating_parent/([^/]+)/trackback/?$\";s:44:\"index.php?hrm_rating_parent=$matches[1]&tb=1\";s:46:\"hrm_rating_parent/([^/]+)/page/?([0-9]{1,})/?$\";s:57:\"index.php?hrm_rating_parent=$matches[1]&paged=$matches[2]\";s:53:\"hrm_rating_parent/([^/]+)/comment-page-([0-9]{1,})/?$\";s:57:\"index.php?hrm_rating_parent=$matches[1]&cpage=$matches[2]\";s:42:\"hrm_rating_parent/([^/]+)(?:/([0-9]+))?/?$\";s:56:\"index.php?hrm_rating_parent=$matches[1]&page=$matches[2]\";s:34:\"hrm_rating_parent/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:44:\"hrm_rating_parent/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:64:\"hrm_rating_parent/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:59:\"hrm_rating_parent/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:59:\"hrm_rating_parent/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:40:\"hrm_rating_parent/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:48:\".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$\";s:18:\"index.php?feed=old\";s:20:\".*wp-app\\.php(/.*)?$\";s:19:\"index.php?error=403\";s:18:\".*wp-register.php$\";s:23:\"index.php?register=true\";s:32:\"feed/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:27:\"(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:8:\"embed/?$\";s:21:\"index.php?&embed=true\";s:20:\"page/?([0-9]{1,})/?$\";s:28:\"index.php?&paged=$matches[1]\";s:41:\"comments/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:36:\"comments/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:17:\"comments/embed/?$\";s:21:\"index.php?&embed=true\";s:44:\"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:39:\"search/(.+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:20:\"search/(.+)/embed/?$\";s:34:\"index.php?s=$matches[1]&embed=true\";s:32:\"search/(.+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?s=$matches[1]&paged=$matches[2]\";s:14:\"search/(.+)/?$\";s:23:\"index.php?s=$matches[1]\";s:47:\"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:42:\"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:23:\"author/([^/]+)/embed/?$\";s:44:\"index.php?author_name=$matches[1]&embed=true\";s:35:\"author/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?author_name=$matches[1]&paged=$matches[2]\";s:17:\"author/([^/]+)/?$\";s:33:\"index.php?author_name=$matches[1]\";s:69:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:45:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$\";s:74:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]\";s:39:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$\";s:63:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]\";s:56:\"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:51:\"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:32:\"([0-9]{4})/([0-9]{1,2})/embed/?$\";s:58:\"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true\";s:44:\"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]\";s:26:\"([0-9]{4})/([0-9]{1,2})/?$\";s:47:\"index.php?year=$matches[1]&monthnum=$matches[2]\";s:43:\"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:38:\"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:19:\"([0-9]{4})/embed/?$\";s:37:\"index.php?year=$matches[1]&embed=true\";s:31:\"([0-9]{4})/page/?([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&paged=$matches[2]\";s:13:\"([0-9]{4})/?$\";s:26:\"index.php?year=$matches[1]\";s:27:\".?.+?/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\".?.+?/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\".?.+?/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"(.?.+?)/embed/?$\";s:41:\"index.php?pagename=$matches[1]&embed=true\";s:20:\"(.?.+?)/trackback/?$\";s:35:\"index.php?pagename=$matches[1]&tb=1\";s:40:\"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:35:\"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:28:\"(.?.+?)/page/?([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&paged=$matches[2]\";s:35:\"(.?.+?)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&cpage=$matches[2]\";s:24:\"(.?.+?)(?:/([0-9]+))?/?$\";s:47:\"index.php?pagename=$matches[1]&page=$matches[2]\";s:27:\"[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\"[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\"[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\"[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\"[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\"[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"([^/]+)/embed/?$\";s:37:\"index.php?name=$matches[1]&embed=true\";s:20:\"([^/]+)/trackback/?$\";s:31:\"index.php?name=$matches[1]&tb=1\";s:40:\"([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?name=$matches[1]&feed=$matches[2]\";s:35:\"([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?name=$matches[1]&feed=$matches[2]\";s:28:\"([^/]+)/page/?([0-9]{1,})/?$\";s:44:\"index.php?name=$matches[1]&paged=$matches[2]\";s:35:\"([^/]+)/comment-page-([0-9]{1,})/?$\";s:44:\"index.php?name=$matches[1]&cpage=$matches[2]\";s:24:\"([^/]+)(?:/([0-9]+))?/?$\";s:43:\"index.php?name=$matches[1]&page=$matches[2]\";s:16:\"[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:26:\"[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:46:\"[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:41:\"[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:41:\"[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:22:\"[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";}','yes'),
	(30,'hack_file','0','yes'),
	(31,'blog_charset','UTF-8','yes'),
	(32,'moderation_keys','','no'),
	(33,'active_plugins','a:6:{i:0;s:39:\"debug-bar-console/debug-bar-console.php\";i:1;s:23:\"debug-bar/debug-bar.php\";i:2;s:25:\"hrm-payroll-loan/loan.php\";i:3;s:35:\"hrm-recruitment/hrm-recruitment.php\";i:4;s:36:\"hrm-time-shift/attendance-report.php\";i:5;s:11:\"hrm/hrm.php\";}','yes'),
	(34,'category_base','','yes'),
	(35,'ping_sites','http://rpc.pingomatic.com/','yes'),
	(36,'comment_max_links','2','yes'),
	(37,'gmt_offset','0','yes'),
	(38,'default_email_category','1','yes'),
	(39,'recently_edited','','no'),
	(40,'template','twentynineteen','yes'),
	(41,'stylesheet','twentynineteen','yes'),
	(42,'comment_whitelist','1','yes'),
	(43,'blacklist_keys','','no'),
	(44,'comment_registration','0','yes'),
	(45,'html_type','text/html','yes'),
	(46,'use_trackback','0','yes'),
	(47,'default_role','subscriber','yes'),
	(48,'db_version','44719','yes'),
	(49,'uploads_use_yearmonth_folders','1','yes'),
	(50,'upload_path','','yes'),
	(51,'blog_public','1','yes'),
	(52,'default_link_category','2','yes'),
	(53,'show_on_front','posts','yes'),
	(54,'tag_base','','yes'),
	(55,'show_avatars','1','yes'),
	(56,'avatar_rating','G','yes'),
	(57,'upload_url_path','','yes'),
	(58,'thumbnail_size_w','150','yes'),
	(59,'thumbnail_size_h','150','yes'),
	(60,'thumbnail_crop','1','yes'),
	(61,'medium_size_w','300','yes'),
	(62,'medium_size_h','300','yes'),
	(63,'avatar_default','mystery','yes'),
	(64,'large_size_w','1024','yes'),
	(65,'large_size_h','1024','yes'),
	(66,'image_default_link_type','none','yes'),
	(67,'image_default_size','','yes'),
	(68,'image_default_align','','yes'),
	(69,'close_comments_for_old_posts','0','yes'),
	(70,'close_comments_days_old','14','yes'),
	(71,'thread_comments','1','yes'),
	(72,'thread_comments_depth','5','yes'),
	(73,'page_comments','0','yes'),
	(74,'comments_per_page','50','yes'),
	(75,'default_comments_page','newest','yes'),
	(76,'comment_order','asc','yes'),
	(77,'sticky_posts','a:0:{}','yes'),
	(78,'widget_categories','a:2:{i:2;a:4:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:12:\"hierarchical\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}','yes'),
	(79,'widget_text','a:0:{}','yes'),
	(80,'widget_rss','a:0:{}','yes'),
	(81,'uninstall_plugins','a:0:{}','no'),
	(82,'timezone_string','','yes'),
	(83,'page_for_posts','0','yes'),
	(84,'page_on_front','0','yes'),
	(85,'default_post_format','0','yes'),
	(86,'link_manager_enabled','0','yes'),
	(87,'finished_splitting_shared_terms','1','yes'),
	(88,'site_icon','0','yes'),
	(89,'medium_large_size_w','768','yes'),
	(90,'medium_large_size_h','0','yes'),
	(91,'wp_page_for_privacy_policy','3','yes'),
	(92,'show_comments_cookies_opt_in','1','yes'),
	(93,'initial_db_version','44719','yes'),
	(94,'wp_user_roles','a:11:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:129:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;s:23:\"manage_employee_profile\";b:1;s:19:\"manage_organization\";b:1;s:15:\"manage_employee\";b:1;s:13:\"edit_employee\";b:1;s:17:\"manage_attendance\";b:1;s:12:\"hrm_employee\";b:1;s:12:\"manage_leave\";b:1;s:15:\"manage_location\";b:1;s:13:\"manage_notice\";b:1;s:17:\"manage_department\";b:1;s:15:\"manage_settings\";b:1;s:18:\"manage_designation\";b:1;s:14:\"manage_payroll\";b:1;s:17:\"payroll_revistion\";b:1;s:11:\"manage_loan\";b:1;s:18:\"manage_woocommerce\";b:1;s:24:\"view_woocommerce_reports\";b:1;s:12:\"edit_product\";b:1;s:12:\"read_product\";b:1;s:14:\"delete_product\";b:1;s:13:\"edit_products\";b:1;s:20:\"edit_others_products\";b:1;s:16:\"publish_products\";b:1;s:21:\"read_private_products\";b:1;s:15:\"delete_products\";b:1;s:23:\"delete_private_products\";b:1;s:25:\"delete_published_products\";b:1;s:22:\"delete_others_products\";b:1;s:21:\"edit_private_products\";b:1;s:23:\"edit_published_products\";b:1;s:20:\"manage_product_terms\";b:1;s:18:\"edit_product_terms\";b:1;s:20:\"delete_product_terms\";b:1;s:20:\"assign_product_terms\";b:1;s:15:\"edit_shop_order\";b:1;s:15:\"read_shop_order\";b:1;s:17:\"delete_shop_order\";b:1;s:16:\"edit_shop_orders\";b:1;s:23:\"edit_others_shop_orders\";b:1;s:19:\"publish_shop_orders\";b:1;s:24:\"read_private_shop_orders\";b:1;s:18:\"delete_shop_orders\";b:1;s:26:\"delete_private_shop_orders\";b:1;s:28:\"delete_published_shop_orders\";b:1;s:25:\"delete_others_shop_orders\";b:1;s:24:\"edit_private_shop_orders\";b:1;s:26:\"edit_published_shop_orders\";b:1;s:23:\"manage_shop_order_terms\";b:1;s:21:\"edit_shop_order_terms\";b:1;s:23:\"delete_shop_order_terms\";b:1;s:23:\"assign_shop_order_terms\";b:1;s:16:\"edit_shop_coupon\";b:1;s:16:\"read_shop_coupon\";b:1;s:18:\"delete_shop_coupon\";b:1;s:17:\"edit_shop_coupons\";b:1;s:24:\"edit_others_shop_coupons\";b:1;s:20:\"publish_shop_coupons\";b:1;s:25:\"read_private_shop_coupons\";b:1;s:19:\"delete_shop_coupons\";b:1;s:27:\"delete_private_shop_coupons\";b:1;s:29:\"delete_published_shop_coupons\";b:1;s:26:\"delete_others_shop_coupons\";b:1;s:25:\"edit_private_shop_coupons\";b:1;s:27:\"edit_published_shop_coupons\";b:1;s:24:\"manage_shop_coupon_terms\";b:1;s:22:\"edit_shop_coupon_terms\";b:1;s:24:\"delete_shop_coupon_terms\";b:1;s:24:\"assign_shop_coupon_terms\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:34:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:10:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}s:12:\"hrm_employee\";a:2:{s:4:\"name\";s:12:\"HRM Employee\";s:12:\"capabilities\";a:4:{s:4:\"read\";b:1;s:13:\"edit_employee\";b:1;s:12:\"hrm_employee\";b:1;s:17:\"payroll_revistion\";b:1;}}s:11:\"hrm_manager\";a:2:{s:4:\"name\";s:11:\"HRM Manager\";s:12:\"capabilities\";a:16:{s:4:\"read\";b:1;s:23:\"manage_employee_profile\";b:1;s:19:\"manage_organization\";b:1;s:15:\"manage_employee\";b:1;s:13:\"edit_employee\";b:1;s:17:\"manage_attendance\";b:1;s:12:\"hrm_employee\";b:1;s:12:\"manage_leave\";b:1;s:15:\"manage_location\";b:1;s:13:\"manage_notice\";b:1;s:17:\"manage_department\";b:1;s:15:\"manage_settings\";b:1;s:18:\"manage_designation\";b:1;s:14:\"manage_payroll\";b:1;s:17:\"payroll_revistion\";b:1;s:11:\"manage_loan\";b:1;}}s:15:\"wphr_hr_manager\";a:2:{s:4:\"name\";s:10:\"HR Manager\";s:12:\"capabilities\";a:23:{s:4:\"read\";b:1;s:12:\"upload_files\";b:1;s:18:\"wphr_list_employee\";b:1;s:20:\"wphr_create_employee\";b:1;s:18:\"wphr_view_employee\";b:1;s:18:\"wphr_edit_employee\";b:1;s:20:\"wphr_delete_employee\";b:1;s:18:\"wphr_create_review\";b:1;s:18:\"wphr_delete_review\";b:1;s:18:\"wphr_manage_review\";b:1;s:24:\"wphr_manage_announcement\";b:1;s:19:\"wphr_manage_jobinfo\";b:1;s:17:\"wphr_view_jobinfo\";b:1;s:22:\"wphr_manage_department\";b:1;s:23:\"wphr_manage_designation\";b:1;s:25:\"wphr_leave_create_request\";b:1;s:17:\"wphr_leave_manage\";b:1;s:16:\"wphr_leave_mails\";b:1;s:23:\"wphr_manage_hr_settings\";b:1;s:20:\"wphr_create_document\";b:1;s:18:\"wphr_edit_document\";b:1;s:18:\"wphr_view_document\";b:1;s:20:\"wphr_delete_document\";b:1;}}s:8:\"employee\";a:2:{s:4:\"name\";s:8:\"Employee\";s:12:\"capabilities\";a:11:{s:4:\"read\";b:1;s:12:\"upload_files\";b:1;s:18:\"wphr_list_employee\";b:1;s:18:\"wphr_view_employee\";b:1;s:18:\"wphr_edit_employee\";b:1;s:17:\"wphr_view_jobinfo\";b:1;s:25:\"wphr_leave_create_request\";b:1;s:20:\"wphr_create_document\";b:1;s:18:\"wphr_edit_document\";b:1;s:18:\"wphr_view_document\";b:1;s:20:\"wphr_delete_document\";b:1;}}s:8:\"customer\";a:2:{s:4:\"name\";s:8:\"Customer\";s:12:\"capabilities\";a:1:{s:4:\"read\";b:1;}}s:12:\"shop_manager\";a:2:{s:4:\"name\";s:12:\"Shop manager\";s:12:\"capabilities\";a:92:{s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:4:\"read\";b:1;s:18:\"read_private_pages\";b:1;s:18:\"read_private_posts\";b:1;s:10:\"edit_posts\";b:1;s:10:\"edit_pages\";b:1;s:20:\"edit_published_posts\";b:1;s:20:\"edit_published_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"edit_private_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:17:\"edit_others_pages\";b:1;s:13:\"publish_posts\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_posts\";b:1;s:12:\"delete_pages\";b:1;s:20:\"delete_private_pages\";b:1;s:20:\"delete_private_posts\";b:1;s:22:\"delete_published_pages\";b:1;s:22:\"delete_published_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:19:\"delete_others_pages\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:17:\"moderate_comments\";b:1;s:12:\"upload_files\";b:1;s:6:\"export\";b:1;s:6:\"import\";b:1;s:10:\"list_users\";b:1;s:18:\"edit_theme_options\";b:1;s:18:\"manage_woocommerce\";b:1;s:24:\"view_woocommerce_reports\";b:1;s:12:\"edit_product\";b:1;s:12:\"read_product\";b:1;s:14:\"delete_product\";b:1;s:13:\"edit_products\";b:1;s:20:\"edit_others_products\";b:1;s:16:\"publish_products\";b:1;s:21:\"read_private_products\";b:1;s:15:\"delete_products\";b:1;s:23:\"delete_private_products\";b:1;s:25:\"delete_published_products\";b:1;s:22:\"delete_others_products\";b:1;s:21:\"edit_private_products\";b:1;s:23:\"edit_published_products\";b:1;s:20:\"manage_product_terms\";b:1;s:18:\"edit_product_terms\";b:1;s:20:\"delete_product_terms\";b:1;s:20:\"assign_product_terms\";b:1;s:15:\"edit_shop_order\";b:1;s:15:\"read_shop_order\";b:1;s:17:\"delete_shop_order\";b:1;s:16:\"edit_shop_orders\";b:1;s:23:\"edit_others_shop_orders\";b:1;s:19:\"publish_shop_orders\";b:1;s:24:\"read_private_shop_orders\";b:1;s:18:\"delete_shop_orders\";b:1;s:26:\"delete_private_shop_orders\";b:1;s:28:\"delete_published_shop_orders\";b:1;s:25:\"delete_others_shop_orders\";b:1;s:24:\"edit_private_shop_orders\";b:1;s:26:\"edit_published_shop_orders\";b:1;s:23:\"manage_shop_order_terms\";b:1;s:21:\"edit_shop_order_terms\";b:1;s:23:\"delete_shop_order_terms\";b:1;s:23:\"assign_shop_order_terms\";b:1;s:16:\"edit_shop_coupon\";b:1;s:16:\"read_shop_coupon\";b:1;s:18:\"delete_shop_coupon\";b:1;s:17:\"edit_shop_coupons\";b:1;s:24:\"edit_others_shop_coupons\";b:1;s:20:\"publish_shop_coupons\";b:1;s:25:\"read_private_shop_coupons\";b:1;s:19:\"delete_shop_coupons\";b:1;s:27:\"delete_private_shop_coupons\";b:1;s:29:\"delete_published_shop_coupons\";b:1;s:26:\"delete_others_shop_coupons\";b:1;s:25:\"edit_private_shop_coupons\";b:1;s:27:\"edit_published_shop_coupons\";b:1;s:24:\"manage_shop_coupon_terms\";b:1;s:22:\"edit_shop_coupon_terms\";b:1;s:24:\"delete_shop_coupon_terms\";b:1;s:24:\"assign_shop_coupon_terms\";b:1;}}}','yes'),
	(95,'fresh_site','0','yes'),
	(96,'widget_search','a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}','yes'),
	(97,'widget_recent-posts','a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}','yes'),
	(98,'widget_recent-comments','a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}','yes'),
	(99,'widget_archives','a:2:{i:2;a:3:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}','yes'),
	(100,'widget_meta','a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}','yes'),
	(101,'sidebars_widgets','a:3:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:13:\"array_version\";i:3;}','yes'),
	(102,'widget_pages','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(103,'widget_calendar','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(104,'widget_media_audio','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(105,'widget_media_image','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(106,'widget_media_gallery','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(107,'widget_media_video','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(108,'widget_tag_cloud','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(109,'widget_nav_menu','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(110,'widget_custom_html','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(111,'cron','a:13:{i:1569605560;a:1:{s:34:\"wp_privacy_delete_old_export_files\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1569626798;a:1:{s:28:\"woocommerce_cleanup_sessions\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1569628800;a:1:{s:27:\"woocommerce_scheduled_sales\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1569634360;a:3:{s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1569644074;a:1:{s:27:\"wphr_daily_scheduled_events\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1569648398;a:1:{s:33:\"woocommerce_cleanup_personal_data\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1569648408;a:1:{s:30:\"woocommerce_tracker_send_event\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1569659198;a:1:{s:24:\"woocommerce_cleanup_logs\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1569677595;a:2:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:25:\"delete_expired_transients\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1569677598;a:1:{s:30:\"wp_scheduled_auto_draft_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1569677722;a:1:{s:32:\"recovery_mode_clean_expired_keys\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1569888000;a:1:{s:25:\"woocommerce_geoip_updater\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:7:\"monthly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:2635200;}}}s:7:\"version\";i:2;}','yes'),
	(112,'theme_mods_twentynineteen','a:1:{s:18:\"custom_css_post_id\";i:-1;}','yes'),
	(127,'can_compress_scripts','1','no'),
	(144,'recovery_keys','a:0:{}','yes'),
	(147,'recently_activated','a:2:{s:24:\"hrm-time-shift/shift.php\";i:1569230226;s:17:\"hrm-lone/loan.php\";i:1569132145;}','yes'),
	(149,'hrm_general_info','a:1:{s:9:\"field_dif\";a:12:{i:0;s:17:\"organization_name\";i:1;s:6:\"tax_id\";i:2;s:19:\"registration_number\";i:3;s:5:\"phone\";i:4;s:3:\"fax\";i:5;s:15:\"addres_street_1\";i:6;s:16:\"address_street_2\";i:7;s:4:\"city\";i:8;s:14:\"state_province\";i:9;s:3:\"zip\";i:10;s:7:\"country\";i:11;s:4:\"note\";}}','yes'),
	(150,'hrm_location_option','a:3:{s:10:\"table_name\";s:12:\"hrm_location\";s:12:\"table_format\";a:9:{i:0;s:2:\"%s\";i:1;s:2:\"%s\";i:2;s:2:\"%s\";i:3;s:2:\"%s\";i:4;s:2:\"%s\";i:5;s:2:\"%s\";i:6;s:2:\"%s\";i:7;s:2:\"%s\";i:8;s:2:\"%s\";}s:12:\"table_option\";a:9:{s:4:\"name\";s:4:\"name\";s:12:\"country_code\";s:7:\"country\";s:8:\"province\";s:8:\"province\";s:4:\"city\";s:4:\"city\";s:7:\"address\";s:7:\"address\";s:8:\"zip_code\";s:7:\"zipcode\";s:5:\"phone\";s:5:\"phone\";s:3:\"fax\";s:3:\"fax\";s:5:\"notes\";s:5:\"notes\";}}','yes'),
	(151,'hrm_notice','a:3:{s:10:\"table_name\";s:10:\"hrm_notice\";s:12:\"table_format\";a:4:{i:0;s:2:\"%s\";i:1;s:2:\"%s\";i:2;s:2:\"%d\";i:3;s:2:\"%s\";}s:12:\"table_option\";a:4:{s:5:\"title\";s:5:\"title\";s:11:\"description\";s:11:\"description\";s:7:\"user_id\";s:7:\"user_id\";s:4:\"date\";s:4:\"date\";}}','yes'),
	(152,'hrm_job_title_option','a:3:{s:10:\"table_name\";s:13:\"hrm_job_title\";s:12:\"table_format\";a:3:{i:0;s:2:\"%s\";i:1;s:2:\"%s\";i:2;s:2:\"%s\";}s:12:\"table_option\";a:3:{s:9:\"job_title\";s:9:\"job_title\";s:15:\"job_description\";s:15:\"job_description\";s:4:\"note\";s:4:\"note\";}}','yes'),
	(153,'hrm_job_category','a:3:{s:10:\"table_name\";s:16:\"hrm_job_category\";s:12:\"table_format\";a:2:{i:0;s:2:\"%s\";i:1;s:2:\"%s\";}s:12:\"table_option\";a:2:{s:4:\"name\";s:12:\"job_category\";s:6:\"active\";s:6:\"active\";}}','yes'),
	(154,'hrm_pay_grade','a:3:{s:10:\"table_name\";s:13:\"hrm_pay_grade\";s:12:\"table_format\";a:1:{i:0;s:2:\"%s\";}s:12:\"table_option\";a:1:{s:4:\"name\";s:4:\"name\";}}','yes'),
	(155,'hrm_language','a:3:{s:10:\"table_name\";s:12:\"hrm_language\";s:12:\"table_format\";a:1:{i:0;s:2:\"%s\";}s:12:\"table_option\";a:1:{s:4:\"name\";s:8:\"language\";}}','yes'),
	(156,'hrm_leave_type','a:3:{s:10:\"table_name\";s:14:\"hrm_leave_type\";s:12:\"table_format\";a:4:{i:0;s:2:\"%s\";i:1;s:2:\"%d\";i:2;s:2:\"%s\";i:3;s:2:\"%s\";}s:12:\"table_option\";a:4:{s:15:\"leave_type_name\";s:10:\"leave_type\";s:11:\"entitlement\";s:11:\"entitlement\";s:12:\"entitle_from\";s:12:\"entitle_from\";s:10:\"entitle_to\";s:10:\"entitle_to\";}}','yes'),
	(157,'hrm_work_week','a:1:{s:9:\"field_dif\";a:7:{i:0;s:8:\"saturday\";i:1;s:6:\"sunday\";i:2;s:6:\"monday\";i:3;s:7:\"tuesday\";i:4;s:9:\"wednesday\";i:5;s:8:\"thursday\";i:6;s:6:\"friday\";}}','yes'),
	(158,'hrm_holiday','a:3:{s:10:\"table_name\";s:11:\"hrm_holiday\";s:12:\"table_format\";a:5:{i:0;s:2:\"%s\";i:1;s:2:\"%s\";i:2;s:2:\"%s\";i:3;s:2:\"%s\";i:4;s:2:\"%s\";}s:12:\"table_option\";a:5:{s:4:\"name\";s:4:\"name\";s:11:\"description\";s:11:\"description\";s:4:\"from\";s:4:\"from\";s:2:\"to\";s:2:\"to\";s:6:\"length\";s:6:\"length\";}}','yes'),
	(159,'hrm_leave','a:3:{s:10:\"table_name\";s:9:\"hrm_leave\";s:12:\"table_format\";a:6:{i:0;s:2:\"%s\";i:1;s:2:\"%s\";i:2;s:2:\"%s\";i:3;s:2:\"%s\";i:4;s:2:\"%s\";i:5;s:2:\"%d\";}s:12:\"table_option\";a:6:{s:10:\"start_time\";s:4:\"from\";s:8:\"end_time\";s:2:\"to\";s:8:\"comments\";s:7:\"comment\";s:4:\"type\";s:7:\"type_id\";s:6:\"emp_id\";s:6:\"emp_id\";s:6:\"status\";s:6:\"status\";}}','yes'),
	(160,'hrm_personal_skill','a:3:{s:10:\"table_name\";s:18:\"hrm_personal_skill\";s:12:\"table_format\";a:4:{i:0;s:2:\"%d\";i:1;s:2:\"%s\";i:2;s:2:\"%s\";i:3;s:2:\"%s\";}s:12:\"table_option\";a:4:{s:6:\"emp_id\";s:6:\"emp_id\";s:5:\"skill\";s:5:\"skill\";s:12:\"years_of_exp\";s:12:\"years_of_exp\";s:8:\"comments\";s:8:\"comments\";}}','yes'),
	(161,'hrm_personal_language','a:3:{s:10:\"table_name\";s:21:\"hrm_personal_language\";s:12:\"table_format\";a:5:{i:0;s:2:\"%d\";i:1;s:2:\"%d\";i:2;s:2:\"%s\";i:3;s:2:\"%s\";i:4;s:2:\"%s\";}s:12:\"table_option\";a:5:{s:6:\"emp_id\";s:6:\"emp_id\";s:11:\"language_id\";s:11:\"language_id\";s:7:\"fluency\";s:7:\"fluency\";s:10:\"competency\";s:10:\"competency\";s:8:\"comments\";s:8:\"comments\";}}','yes'),
	(162,'hrm_admin','1','yes'),
	(163,'hrm_version','2.2.16','yes'),
	(164,'wpSpear_hrm','5','yes'),
	(167,'b1f4f69a13f554a241607c6f2f407879','a:2:{s:7:\"timeout\";i:1568919031;s:5:\"value\";s:348:\"{\"new_version\":\"2.0.1\",\"name\":\"HRM Front-end\",\"slug\":\"hrm-front\",\"url\":\"https:\\/\\/wpspear.com\\/downloads\\/hrm-front-end\\/?changelog=1\",\"last_updated\":\"2019-08-13 11:08:16\",\"homepage\":\"https:\\/\\/wpspear.com\\/downloads\\/hrm-front-end\\/\",\"package\":\"\",\"download_link\":\"\",\"sections\":{\"description\":\"\",\"changelog\":\"\"},\"description\":[\"\"],\"changelog\":[\"\"]}\";}','no'),
	(169,'065765b4a90d8583e97b0bc903e1771e','a:2:{s:7:\"timeout\";i:1569557532;s:5:\"value\";s:366:\"{\"new_version\":\"1.3\",\"name\":\"Attendance Report\",\"slug\":\"attendance-report\",\"url\":\"https:\\/\\/wpspear.com\\/downloads\\/attendance-report\\/?changelog=1\",\"last_updated\":\"2019-09-23 21:06:33\",\"homepage\":\"https:\\/\\/wpspear.com\\/downloads\\/attendance-report\\/\",\"package\":\"\",\"download_link\":\"\",\"sections\":{\"description\":\"\",\"changelog\":\"\"},\"description\":[\"\"],\"changelog\":[\"\"]}\";}','no'),
	(283,'recovery_mode_email_last_sent','1569128157','yes'),
	(347,'wpup_members_page_id','8','yes'),
	(348,'wpup_my_profile_page_id','9','yes'),
	(356,'wpup_members_per_page','2','yes'),
	(480,'hrm_recruitment_settings','a:3:{s:16:\"hide_application\";s:1:\"1\";s:14:\"required_login\";s:1:\"1\";s:4:\"page\";s:2:\"12\";}','yes'),
	(481,'HRM_RECRUITMRNT_VERSION','1.0.0','yes'),
	(482,'HRM_RECRUITMRNT_DB_VERSION','1.0','yes'),
	(485,'161a7e0caa567e0e268a4eab7d9b09d2','a:2:{s:7:\"timeout\";i:1569606079;s:5:\"value\";s:5:\"false\";}','no'),
	(581,'fs_active_plugins','O:8:\"stdClass\":3:{s:7:\"plugins\";a:1:{s:22:\"wp-hr-manager/freemius\";O:8:\"stdClass\":4:{s:7:\"version\";s:5:\"2.3.0\";s:4:\"type\";s:6:\"plugin\";s:9:\"timestamp\";i:1567224870;s:11:\"plugin_path\";s:31:\"wp-hr-manager/wp-hr-manager.php\";}}s:7:\"abspath\";s:35:\"/Users/wedevs/Documents/wedevs/hrm/\";s:6:\"newest\";O:8:\"stdClass\":5:{s:11:\"plugin_path\";s:31:\"wp-hr-manager/wp-hr-manager.php\";s:8:\"sdk_path\";s:22:\"wp-hr-manager/freemius\";s:7:\"version\";s:5:\"2.3.0\";s:13:\"in_activation\";b:0;s:9:\"timestamp\";i:1567224870;}}','yes'),
	(582,'fs_debug_mode','','yes'),
	(583,'fs_accounts','a:7:{s:21:\"id_slug_type_path_map\";a:1:{i:1296;a:3:{s:4:\"slug\";s:13:\"wp-hr-manager\";s:4:\"type\";s:6:\"plugin\";s:4:\"path\";s:31:\"wp-hr-manager/wp-hr-manager.php\";}}s:11:\"plugin_data\";a:1:{s:13:\"wp-hr-manager\";a:17:{s:16:\"plugin_main_file\";O:8:\"stdClass\":1:{s:4:\"path\";s:31:\"wp-hr-manager/wp-hr-manager.php\";}s:20:\"is_network_activated\";b:0;s:17:\"install_timestamp\";i:1567224870;s:16:\"sdk_last_version\";N;s:11:\"sdk_version\";s:5:\"2.3.0\";s:16:\"sdk_upgrade_mode\";b:1;s:18:\"sdk_downgrade_mode\";b:0;s:19:\"plugin_last_version\";N;s:14:\"plugin_version\";s:3:\"2.0\";s:19:\"plugin_upgrade_mode\";b:1;s:21:\"plugin_downgrade_mode\";b:0;s:21:\"is_plugin_new_install\";b:1;s:17:\"connectivity_test\";a:6:{s:12:\"is_connected\";b:1;s:4:\"host\";s:9:\"localhost\";s:9:\"server_ip\";s:3:\"::1\";s:9:\"is_active\";b:1;s:9:\"timestamp\";i:1567224870;s:7:\"version\";s:3:\"2.0\";}s:17:\"was_plugin_loaded\";b:1;s:15:\"prev_is_premium\";b:0;s:12:\"is_anonymous\";a:3:{s:2:\"is\";b:1;s:9:\"timestamp\";i:1567224972;s:7:\"version\";s:3:\"2.0\";}s:21:\"trial_promotion_shown\";i:1567312253;}}s:13:\"file_slug_map\";a:1:{s:31:\"wp-hr-manager/wp-hr-manager.php\";s:13:\"wp-hr-manager\";}s:7:\"plugins\";a:1:{s:13:\"wp-hr-manager\";O:9:\"FS_Plugin\":22:{s:16:\"parent_plugin_id\";N;s:5:\"title\";s:13:\"WP-HR Manager\";s:4:\"slug\";s:13:\"wp-hr-manager\";s:12:\"premium_slug\";s:21:\"wp-hr-manager-premium\";s:4:\"type\";s:6:\"plugin\";s:20:\"affiliate_moderation\";s:3:\"all\";s:19:\"is_wp_org_compliant\";b:1;s:22:\"premium_releases_count\";N;s:4:\"file\";s:31:\"wp-hr-manager/wp-hr-manager.php\";s:7:\"version\";s:3:\"2.0\";s:11:\"auto_update\";N;s:4:\"info\";N;s:10:\"is_premium\";b:0;s:14:\"premium_suffix\";s:7:\"Premium\";s:7:\"is_live\";b:1;s:9:\"bundle_id\";N;s:10:\"public_key\";s:32:\"pk_3dcdd297d8b052f4cc1fa5e68338b\";s:10:\"secret_key\";N;s:2:\"id\";s:4:\"1296\";s:7:\"updated\";N;s:7:\"created\";N;s:22:\"\0FS_Entity\0_is_updated\";b:0;}}s:9:\"unique_id\";s:32:\"92768dd28ee0f862e4970c5b79871e36\";s:13:\"admin_notices\";a:1:{s:13:\"wp-hr-manager\";a:0:{}}s:6:\"addons\";a:1:{i:1296;a:7:{i:0;O:9:\"FS_Plugin\":22:{s:16:\"parent_plugin_id\";s:4:\"1296\";s:5:\"title\";s:17:\"WP-HR Recruitment\";s:4:\"slug\";s:16:\"wphr-recruitment\";s:12:\"premium_slug\";s:24:\"wphr-recruitment-premium\";s:4:\"type\";s:6:\"plugin\";s:20:\"affiliate_moderation\";N;s:19:\"is_wp_org_compliant\";b:0;s:22:\"premium_releases_count\";i:9;s:4:\"file\";N;s:7:\"version\";N;s:11:\"auto_update\";N;s:4:\"info\";O:14:\"FS_Plugin_Info\":13:{s:9:\"plugin_id\";s:4:\"1298\";s:11:\"description\";s:240:\"If you are already using WP-HR Manager and want to smoothly integrate your recruitment process - this is the plugin for you.  \n\nWP-HR Recruitment will enable you to quickly add vacancies and potential recruits into a stream-lined process...\";s:17:\"short_description\";s:116:\"Recruitment made easy: Add vacancies; display on your site; online applications; track interviews; monitor progress.\";s:10:\"banner_url\";s:61:\"//s3-us-west-2.amazonaws.com/freemius/plugins/1298/banner.png\";s:15:\"card_banner_url\";s:66:\"//s3-us-west-2.amazonaws.com/freemius/plugins/1298/card_banner.png\";s:15:\"selling_point_0\";s:37:\"Manage vacancies within WP-HR Manager\";s:15:\"selling_point_1\";s:45:\"Monitor and report on the recruitment process\";s:15:\"selling_point_2\";s:31:\"Advertise roles on your website\";s:11:\"screenshots\";N;s:2:\"id\";s:2:\"88\";s:7:\"updated\";s:19:\"2018-05-05 15:36:43\";s:7:\"created\";s:19:\"2017-08-17 23:46:45\";s:22:\"\0FS_Entity\0_is_updated\";b:0;}s:10:\"is_premium\";b:0;s:14:\"premium_suffix\";s:9:\"(Premium)\";s:7:\"is_live\";b:1;s:9:\"bundle_id\";N;s:10:\"public_key\";s:32:\"pk_1a007c505f1d64c18a2f47ba9e953\";s:10:\"secret_key\";N;s:2:\"id\";s:4:\"1298\";s:7:\"updated\";s:19:\"2019-09-01 08:49:25\";s:7:\"created\";s:19:\"2017-08-17 22:22:59\";s:22:\"\0FS_Entity\0_is_updated\";b:0;}i:1;O:9:\"FS_Plugin\":22:{s:16:\"parent_plugin_id\";s:4:\"1296\";s:5:\"title\";s:16:\"WP-HR Attendance\";s:4:\"slug\";s:15:\"wphr-attendance\";s:12:\"premium_slug\";s:23:\"wphr-attendance-premium\";s:4:\"type\";s:6:\"plugin\";s:20:\"affiliate_moderation\";N;s:19:\"is_wp_org_compliant\";b:0;s:22:\"premium_releases_count\";i:9;s:4:\"file\";N;s:7:\"version\";N;s:11:\"auto_update\";N;s:4:\"info\";O:14:\"FS_Plugin_Info\":13:{s:9:\"plugin_id\";s:4:\"1314\";s:11:\"description\";s:253:\"Enable employees to check in and out, accurately recording their working hours.  The system works directly from the employee\'s profile dashboard or you can import data in CSV format from other apps.  Admins can set office hours and add unlimited shifts.\";s:17:\"short_description\";s:38:\"Track and monitor employee attendance.\";s:10:\"banner_url\";s:61:\"//s3-us-west-2.amazonaws.com/freemius/plugins/1314/banner.png\";s:15:\"card_banner_url\";s:66:\"//s3-us-west-2.amazonaws.com/freemius/plugins/1314/card_banner.png\";s:15:\"selling_point_0\";s:65:\"Enable employees to check in and out - record their working hours\";s:15:\"selling_point_1\";s:31:\"Specify office hours and shifts\";s:15:\"selling_point_2\";s:50:\"View reports on attendance with WP--HR Manager Pro\";s:11:\"screenshots\";N;s:2:\"id\";s:2:\"89\";s:7:\"updated\";s:19:\"2018-12-28 14:31:32\";s:7:\"created\";s:19:\"2017-08-22 20:51:23\";s:22:\"\0FS_Entity\0_is_updated\";b:0;}s:10:\"is_premium\";b:0;s:14:\"premium_suffix\";s:9:\"(Premium)\";s:7:\"is_live\";b:1;s:9:\"bundle_id\";N;s:10:\"public_key\";s:32:\"pk_287705a8d62f3d9852ecdfb47e88d\";s:10:\"secret_key\";N;s:2:\"id\";s:4:\"1314\";s:7:\"updated\";s:19:\"2019-08-30 04:51:30\";s:7:\"created\";s:19:\"2017-08-22 19:59:27\";s:22:\"\0FS_Entity\0_is_updated\";b:0;}i:2;O:9:\"FS_Plugin\":22:{s:16:\"parent_plugin_id\";s:4:\"1296\";s:5:\"title\";s:15:\"WP-HR Documents\";s:4:\"slug\";s:14:\"wphr-documents\";s:12:\"premium_slug\";s:22:\"wphr-documents-premium\";s:4:\"type\";s:6:\"plugin\";s:20:\"affiliate_moderation\";N;s:19:\"is_wp_org_compliant\";b:0;s:22:\"premium_releases_count\";i:2;s:4:\"file\";N;s:7:\"version\";N;s:11:\"auto_update\";N;s:4:\"info\";O:14:\"FS_Plugin_Info\":13:{s:9:\"plugin_id\";s:4:\"2446\";s:11:\"description\";s:759:\"If you need to create a library of files and documents for all employees or simply add a document for a single employee this plugin delivers.  You can create a library, add folders to help manage and locate documents of particular types - for example, add you Health and Safety guidelines in one folder, and your Employee Handbook in another.  You can also add documents to individual employee profiles, for example, a copy of their employment contract.  Finally, employees themselves can upload documents directly so if you need a copy of their ID or drivers licence, for example, you could ask them to add them directly to their profile in the new \'Documents\' section created by this plugin.  You can upload most formats - PDF, Word, Excel, image files etc.\";s:17:\"short_description\";s:57:\"Upload and manage HR files and documents in WP-HR Manager\";s:10:\"banner_url\";s:61:\"//s3-us-west-2.amazonaws.com/freemius/plugins/2446/banner.png\";s:15:\"card_banner_url\";s:66:\"//s3-us-west-2.amazonaws.com/freemius/plugins/2446/card_banner.png\";s:15:\"selling_point_0\";s:42:\"Create a library of HR Documents and Files\";s:15:\"selling_point_1\";s:43:\"Add Folders to Easily Manage your Documents\";s:15:\"selling_point_2\";s:48:\"Upload Documents to Individual Employee Profiles\";s:11:\"screenshots\";N;s:2:\"id\";s:3:\"377\";s:7:\"updated\";s:19:\"2018-08-18 12:30:18\";s:7:\"created\";s:19:\"2018-08-15 14:47:18\";s:22:\"\0FS_Entity\0_is_updated\";b:0;}s:10:\"is_premium\";b:0;s:14:\"premium_suffix\";s:9:\"(Premium)\";s:7:\"is_live\";b:1;s:9:\"bundle_id\";N;s:10:\"public_key\";s:32:\"pk_4c0d0646a94caa7b6d66d2a515b07\";s:10:\"secret_key\";N;s:2:\"id\";s:4:\"2446\";s:7:\"updated\";s:19:\"2019-08-29 05:48:13\";s:7:\"created\";s:19:\"2018-08-15 11:28:31\";s:22:\"\0FS_Entity\0_is_updated\";b:0;}i:3;O:9:\"FS_Plugin\":22:{s:16:\"parent_plugin_id\";s:4:\"1296\";s:5:\"title\";s:16:\"WP-HR Add Fields\";s:4:\"slug\";s:11:\"wphr-fields\";s:12:\"premium_slug\";s:19:\"wphr-fields-premium\";s:4:\"type\";s:6:\"plugin\";s:20:\"affiliate_moderation\";N;s:19:\"is_wp_org_compliant\";b:0;s:22:\"premium_releases_count\";i:2;s:4:\"file\";N;s:7:\"version\";N;s:11:\"auto_update\";N;s:4:\"info\";O:14:\"FS_Plugin_Info\":13:{s:9:\"plugin_id\";s:4:\"2454\";s:11:\"description\";s:257:\"There are already a lot of useful fields in WP-HR Manager for recording employee information - but you may want more!   Now you can easily add many types of field to the employee\'s profile, enabling you to gather and manage exactly the information you need.\";s:17:\"short_description\";s:31:\"Add fields to Employee Profiles\";s:10:\"banner_url\";s:61:\"//s3-us-west-2.amazonaws.com/freemius/plugins/2454/banner.png\";s:15:\"card_banner_url\";s:66:\"//s3-us-west-2.amazonaws.com/freemius/plugins/2454/card_banner.png\";s:15:\"selling_point_0\";s:31:\"Add fields to employee profiles\";s:15:\"selling_point_1\";s:53:\"Multiple field types - text, drop down, tick box etc.\";s:15:\"selling_point_2\";s:39:\"Collect additional employee information\";s:11:\"screenshots\";N;s:2:\"id\";s:3:\"379\";s:7:\"updated\";s:19:\"2018-08-21 19:28:21\";s:7:\"created\";s:19:\"2018-08-18 14:39:32\";s:22:\"\0FS_Entity\0_is_updated\";b:0;}s:10:\"is_premium\";b:0;s:14:\"premium_suffix\";s:9:\"(Premium)\";s:7:\"is_live\";b:1;s:9:\"bundle_id\";N;s:10:\"public_key\";s:32:\"pk_9aa3fe478e0a0b4092a8d046330a5\";s:10:\"secret_key\";N;s:2:\"id\";s:4:\"2454\";s:7:\"updated\";s:19:\"2019-08-29 05:49:10\";s:7:\"created\";s:19:\"2018-08-18 14:07:53\";s:22:\"\0FS_Entity\0_is_updated\";b:0;}i:4;O:9:\"FS_Plugin\":22:{s:16:\"parent_plugin_id\";s:4:\"1296\";s:5:\"title\";s:18:\"WP-HR SMS Messages\";s:4:\"slug\";s:8:\"wphr-sms\";s:12:\"premium_slug\";s:16:\"wphr-sms-premium\";s:4:\"type\";s:6:\"plugin\";s:20:\"affiliate_moderation\";N;s:19:\"is_wp_org_compliant\";b:0;s:22:\"premium_releases_count\";i:2;s:4:\"file\";N;s:7:\"version\";N;s:11:\"auto_update\";N;s:4:\"info\";O:14:\"FS_Plugin_Info\":13:{s:9:\"plugin_id\";s:4:\"2455\";s:11:\"description\";s:230:\"It\'s good to keep in touch with employees and SMS messages are now one of the most common means of communicating in the world - so why not integrate an SMS messaging service with WP-HR Manager to help your employee communications?\";s:17:\"short_description\";s:31:\"Keep in touch with SMS messages\";s:10:\"banner_url\";s:61:\"//s3-us-west-2.amazonaws.com/freemius/plugins/2455/banner.png\";s:15:\"card_banner_url\";s:66:\"//s3-us-west-2.amazonaws.com/freemius/plugins/2455/card_banner.png\";s:15:\"selling_point_0\";s:26:\"SMS message your employees\";s:15:\"selling_point_1\";s:38:\"Integrates with multiple SMS suppliers\";s:15:\"selling_point_2\";N;s:11:\"screenshots\";N;s:2:\"id\";s:3:\"378\";s:7:\"updated\";s:19:\"2018-08-18 14:45:53\";s:7:\"created\";s:19:\"2018-08-18 14:31:46\";s:22:\"\0FS_Entity\0_is_updated\";b:0;}s:10:\"is_premium\";b:0;s:14:\"premium_suffix\";s:9:\"(Premium)\";s:7:\"is_live\";b:1;s:9:\"bundle_id\";N;s:10:\"public_key\";s:32:\"pk_ad12da38db8bce4fd2c753d932e51\";s:10:\"secret_key\";N;s:2:\"id\";s:4:\"2455\";s:7:\"updated\";s:19:\"2019-08-12 16:05:17\";s:7:\"created\";s:19:\"2018-08-18 14:14:31\";s:22:\"\0FS_Entity\0_is_updated\";b:0;}i:5;O:9:\"FS_Plugin\":22:{s:16:\"parent_plugin_id\";s:4:\"1296\";s:5:\"title\";s:21:\"WP-HR Mobile Check In\";s:4:\"slug\";s:12:\"wphr-checkin\";s:12:\"premium_slug\";s:20:\"wphr-checkin-premium\";s:4:\"type\";s:6:\"plugin\";s:20:\"affiliate_moderation\";N;s:19:\"is_wp_org_compliant\";b:0;s:22:\"premium_releases_count\";i:6;s:4:\"file\";N;s:7:\"version\";N;s:11:\"auto_update\";N;s:4:\"info\";O:14:\"FS_Plugin_Info\":13:{s:9:\"plugin_id\";s:4:\"2702\";s:11:\"description\";s:419:\"The addon works with WP-HR Manager and WP-HR Attendance to add the functionality to integrate our two (Apple and Android) phone apps.  Perfect for employees who don\'t have regular access to a PC, or who work remotely.  Ask them to check in when the start work and check out when they finish - you\'ll know who is working at any time.  Ideal for tracking lateness, over time, remote workers, time based projects and more.\";s:17:\"short_description\";s:55:\"Enable employees to check in/out on their mobile phones\";s:10:\"banner_url\";s:61:\"//s3-us-west-2.amazonaws.com/freemius/plugins/2702/banner.png\";s:15:\"card_banner_url\";s:66:\"//s3-us-west-2.amazonaws.com/freemius/plugins/2702/card_banner.png\";s:15:\"selling_point_0\";s:45:\"One tap check in and check out (clock in/out)\";s:15:\"selling_point_1\";s:31:\"Andoid and Apple Apps available\";s:15:\"selling_point_2\";s:41:\"Perfect for tracking lateness and absence\";s:11:\"screenshots\";N;s:2:\"id\";s:3:\"436\";s:7:\"updated\";s:19:\"2018-10-26 12:32:42\";s:7:\"created\";s:19:\"2018-10-12 10:42:10\";s:22:\"\0FS_Entity\0_is_updated\";b:0;}s:10:\"is_premium\";b:0;s:14:\"premium_suffix\";s:9:\"(Premium)\";s:7:\"is_live\";b:1;s:9:\"bundle_id\";N;s:10:\"public_key\";s:32:\"pk_25d48b262650ffbed218efbd3a765\";s:10:\"secret_key\";N;s:2:\"id\";s:4:\"2702\";s:7:\"updated\";s:19:\"2019-08-29 05:50:58\";s:7:\"created\";s:19:\"2018-10-11 20:43:04\";s:22:\"\0FS_Entity\0_is_updated\";b:0;}i:6;O:9:\"FS_Plugin\":22:{s:16:\"parent_plugin_id\";s:4:\"1296\";s:5:\"title\";s:13:\"WPHR Training\";s:4:\"slug\";s:13:\"wphr-training\";s:12:\"premium_slug\";s:21:\"wphr-training-premium\";s:4:\"type\";s:6:\"plugin\";s:20:\"affiliate_moderation\";N;s:19:\"is_wp_org_compliant\";b:1;s:22:\"premium_releases_count\";i:4;s:4:\"file\";N;s:7:\"version\";N;s:11:\"auto_update\";N;s:4:\"info\";O:14:\"FS_Plugin_Info\":13:{s:9:\"plugin_id\";s:4:\"3818\";s:11:\"description\";s:303:\"This addon helps you assign training resources such as videos and documents to employees.  You can also check they read/watched the resource (great for compliance) and check their level of understanding with a simple test.  Employees can be asked to retake the test if they don\'t achieve a minimum mark.\";s:17:\"short_description\";N;s:10:\"banner_url\";s:61:\"//s3-us-west-2.amazonaws.com/freemius/plugins/3818/banner.png\";s:15:\"card_banner_url\";s:66:\"//s3-us-west-2.amazonaws.com/freemius/plugins/3818/card_banner.png\";s:15:\"selling_point_0\";s:92:\"Add training videos or documents to employee profiles.  Bulk assign by job type or location.\";s:15:\"selling_point_1\";s:54:\"Set simple test to ensure understanding and compliance\";s:15:\"selling_point_2\";s:60:\"Get notified that employees have reviewed training materials\";s:11:\"screenshots\";N;s:2:\"id\";s:3:\"894\";s:7:\"updated\";s:19:\"2019-08-12 12:23:20\";s:7:\"created\";s:19:\"2019-06-25 15:47:19\";s:22:\"\0FS_Entity\0_is_updated\";b:0;}s:10:\"is_premium\";b:0;s:14:\"premium_suffix\";s:9:\"(Premium)\";s:7:\"is_live\";b:1;s:9:\"bundle_id\";N;s:10:\"public_key\";s:32:\"pk_b236370bb41af077964c77ec3341b\";s:10:\"secret_key\";N;s:2:\"id\";s:4:\"3818\";s:7:\"updated\";s:19:\"2019-08-31 18:39:59\";s:7:\"created\";s:19:\"2019-05-16 16:18:55\";s:22:\"\0FS_Entity\0_is_updated\";b:0;}}}}','yes'),
	(584,'wphr_modules','a:2:{s:3:\"hrm\";a:5:{s:5:\"title\";s:13:\"HR Management\";s:4:\"slug\";s:8:\"wphr-hrm\";s:11:\"description\";s:25:\"Human Resource Management\";s:8:\"callback\";s:35:\"\\WPHR\\HR_MANAGER\\HRM\\Human_Resource\";s:7:\"modules\";a:0:{}}s:16:\"wphr-hr-frontend\";a:5:{s:5:\"title\";s:11:\"HR Frontend\";s:4:\"slug\";s:16:\"wphr-hr-frontend\";s:11:\"description\";s:23:\"Human Resource Frontend\";s:8:\"callback\";s:46:\"\\WPHR\\HR_MANAGER\\WP_HR_FRONTEND\\Human_Resource\";s:7:\"modules\";a:0:{}}}','yes'),
	(585,'fs_api_cache','a:6:{s:46:\"get:/v1/plugins/1296/addons.json?enriched=true\";O:8:\"stdClass\":3:{s:6:\"result\";O:8:\"stdClass\":1:{s:7:\"plugins\";a:7:{i:0;O:8:\"stdClass\":37:{s:16:\"parent_plugin_id\";s:4:\"1296\";s:12:\"developer_id\";s:3:\"240\";s:10:\"install_id\";s:6:\"771820\";s:4:\"slug\";s:16:\"wphr-recruitment\";s:5:\"title\";s:17:\"WP-HR Recruitment\";s:11:\"environment\";i:0;s:4:\"icon\";s:93:\"//s3-us-west-2.amazonaws.com/freemius/plugins/1298/icons/f30f5146c5da1c5030748f8962573420.png\";s:15:\"default_plan_id\";s:4:\"1827\";s:5:\"plans\";i:1827;s:8:\"features\";N;s:17:\"money_back_period\";i:14;s:13:\"refund_policy\";s:6:\"strict\";s:24:\"annual_renewals_discount\";N;s:22:\"renewals_discount_type\";s:0:\"\";s:11:\"is_released\";b:1;s:18:\"is_pricing_visible\";b:1;s:19:\"is_wp_org_compliant\";b:0;s:6:\"is_off\";b:0;s:24:\"is_only_for_new_installs\";b:0;s:14:\"installs_limit\";N;s:14:\"installs_count\";i:81;s:21:\"active_installs_count\";i:36;s:19:\"free_releases_count\";i:0;s:22:\"premium_releases_count\";i:9;s:15:\"total_purchases\";i:1;s:19:\"total_subscriptions\";i:20;s:14:\"total_renewals\";i:30;s:8:\"earnings\";d:920.9299999999999499777914024889469146728515625;s:10:\"commission\";s:35:\"{\"1000\":0.3,\"5000\":0.2,\"above\":0.1}\";s:17:\"accepted_payments\";i:0;s:7:\"plan_id\";s:1:\"0\";s:4:\"type\";s:6:\"plugin\";s:10:\"public_key\";s:32:\"pk_1a007c505f1d64c18a2f47ba9e953\";s:2:\"id\";s:4:\"1298\";s:7:\"created\";s:19:\"2017-08-17 22:22:59\";s:7:\"updated\";s:19:\"2019-09-01 08:49:25\";s:4:\"info\";O:8:\"stdClass\":13:{s:9:\"plugin_id\";s:4:\"1298\";s:3:\"url\";s:53:\"http://www.wphrmanager.com/plugins/wp-hr-recruitment/\";s:11:\"description\";s:240:\"If you are already using WP-HR Manager and want to smoothly integrate your recruitment process - this is the plugin for you.  \n\nWP-HR Recruitment will enable you to quickly add vacancies and potential recruits into a stream-lined process...\";s:17:\"short_description\";s:116:\"Recruitment made easy: Add vacancies; display on your site; online applications; track interviews; monitor progress.\";s:10:\"banner_url\";s:61:\"//s3-us-west-2.amazonaws.com/freemius/plugins/1298/banner.png\";s:15:\"card_banner_url\";s:66:\"//s3-us-west-2.amazonaws.com/freemius/plugins/1298/card_banner.png\";s:15:\"selling_point_0\";s:37:\"Manage vacancies within WP-HR Manager\";s:15:\"selling_point_1\";s:45:\"Monitor and report on the recruitment process\";s:15:\"selling_point_2\";s:31:\"Advertise roles on your website\";s:11:\"screenshots\";N;s:2:\"id\";s:2:\"88\";s:7:\"created\";s:19:\"2017-08-17 23:46:45\";s:7:\"updated\";s:19:\"2018-05-05 15:36:43\";}}i:1;O:8:\"stdClass\":37:{s:16:\"parent_plugin_id\";s:4:\"1296\";s:12:\"developer_id\";s:3:\"240\";s:10:\"install_id\";s:6:\"783450\";s:4:\"slug\";s:15:\"wphr-attendance\";s:5:\"title\";s:16:\"WP-HR Attendance\";s:11:\"environment\";i:0;s:4:\"icon\";s:93:\"//s3-us-west-2.amazonaws.com/freemius/plugins/1314/icons/4541054639c4b9e0b5045c03a1653286.png\";s:15:\"default_plan_id\";s:4:\"1857\";s:5:\"plans\";i:1857;s:8:\"features\";s:19:\"1534,1535,1655,1656\";s:17:\"money_back_period\";i:14;s:13:\"refund_policy\";s:6:\"strict\";s:24:\"annual_renewals_discount\";N;s:22:\"renewals_discount_type\";s:0:\"\";s:11:\"is_released\";b:1;s:18:\"is_pricing_visible\";b:1;s:19:\"is_wp_org_compliant\";b:0;s:6:\"is_off\";b:0;s:24:\"is_only_for_new_installs\";b:0;s:14:\"installs_limit\";N;s:14:\"installs_count\";i:100;s:21:\"active_installs_count\";i:37;s:19:\"free_releases_count\";i:0;s:22:\"premium_releases_count\";i:9;s:15:\"total_purchases\";i:1;s:19:\"total_subscriptions\";i:24;s:14:\"total_renewals\";i:75;s:8:\"earnings\";d:1015.0900000000000318323145620524883270263671875;s:10:\"commission\";s:35:\"{\"1000\":0.3,\"5000\":0.2,\"above\":0.1}\";s:17:\"accepted_payments\";i:0;s:7:\"plan_id\";s:1:\"0\";s:4:\"type\";s:6:\"plugin\";s:10:\"public_key\";s:32:\"pk_287705a8d62f3d9852ecdfb47e88d\";s:2:\"id\";s:4:\"1314\";s:7:\"created\";s:19:\"2017-08-22 19:59:27\";s:7:\"updated\";s:19:\"2019-08-30 04:51:30\";s:4:\"info\";O:8:\"stdClass\":13:{s:9:\"plugin_id\";s:4:\"1314\";s:3:\"url\";s:52:\"http://www.wphrmanager.com/plugins/wp-hr-attendance/\";s:11:\"description\";s:253:\"Enable employees to check in and out, accurately recording their working hours.  The system works directly from the employee\'s profile dashboard or you can import data in CSV format from other apps.  Admins can set office hours and add unlimited shifts.\";s:17:\"short_description\";s:38:\"Track and monitor employee attendance.\";s:10:\"banner_url\";s:61:\"//s3-us-west-2.amazonaws.com/freemius/plugins/1314/banner.png\";s:15:\"card_banner_url\";s:66:\"//s3-us-west-2.amazonaws.com/freemius/plugins/1314/card_banner.png\";s:15:\"selling_point_0\";s:65:\"Enable employees to check in and out - record their working hours\";s:15:\"selling_point_1\";s:31:\"Specify office hours and shifts\";s:15:\"selling_point_2\";s:50:\"View reports on attendance with WP--HR Manager Pro\";s:11:\"screenshots\";N;s:2:\"id\";s:2:\"89\";s:7:\"created\";s:19:\"2017-08-22 20:51:23\";s:7:\"updated\";s:19:\"2018-12-28 14:31:32\";}}i:2;O:8:\"stdClass\":37:{s:16:\"parent_plugin_id\";s:4:\"1296\";s:12:\"developer_id\";s:3:\"240\";s:10:\"install_id\";s:7:\"1863453\";s:4:\"slug\";s:14:\"wphr-documents\";s:5:\"title\";s:15:\"WP-HR Documents\";s:11:\"environment\";i:0;s:4:\"icon\";s:93:\"//s3-us-west-2.amazonaws.com/freemius/plugins/2446/icons/abfb2f896dd14277634a53dbd0960998.png\";s:15:\"default_plan_id\";s:4:\"3763\";s:5:\"plans\";i:3763;s:8:\"features\";s:19:\"3003,3004,3005,3006\";s:17:\"money_back_period\";N;s:13:\"refund_policy\";N;s:24:\"annual_renewals_discount\";N;s:22:\"renewals_discount_type\";s:0:\"\";s:11:\"is_released\";b:1;s:18:\"is_pricing_visible\";b:1;s:19:\"is_wp_org_compliant\";b:0;s:6:\"is_off\";b:0;s:24:\"is_only_for_new_installs\";b:0;s:14:\"installs_limit\";N;s:14:\"installs_count\";i:62;s:21:\"active_installs_count\";i:31;s:19:\"free_releases_count\";i:0;s:22:\"premium_releases_count\";i:2;s:15:\"total_purchases\";i:2;s:19:\"total_subscriptions\";i:20;s:14:\"total_renewals\";i:39;s:8:\"earnings\";d:803.470000000000027284841053187847137451171875;s:10:\"commission\";s:35:\"{\"1000\":0.3,\"5000\":0.2,\"above\":0.1}\";s:17:\"accepted_payments\";i:0;s:7:\"plan_id\";s:1:\"0\";s:4:\"type\";s:6:\"plugin\";s:10:\"public_key\";s:32:\"pk_4c0d0646a94caa7b6d66d2a515b07\";s:2:\"id\";s:4:\"2446\";s:7:\"created\";s:19:\"2018-08-15 11:28:31\";s:7:\"updated\";s:19:\"2019-08-29 05:48:13\";s:4:\"info\";O:8:\"stdClass\":13:{s:9:\"plugin_id\";s:4:\"2446\";s:3:\"url\";N;s:11:\"description\";s:759:\"If you need to create a library of files and documents for all employees or simply add a document for a single employee this plugin delivers.  You can create a library, add folders to help manage and locate documents of particular types - for example, add you Health and Safety guidelines in one folder, and your Employee Handbook in another.  You can also add documents to individual employee profiles, for example, a copy of their employment contract.  Finally, employees themselves can upload documents directly so if you need a copy of their ID or drivers licence, for example, you could ask them to add them directly to their profile in the new \'Documents\' section created by this plugin.  You can upload most formats - PDF, Word, Excel, image files etc.\";s:17:\"short_description\";s:57:\"Upload and manage HR files and documents in WP-HR Manager\";s:10:\"banner_url\";s:61:\"//s3-us-west-2.amazonaws.com/freemius/plugins/2446/banner.png\";s:15:\"card_banner_url\";s:66:\"//s3-us-west-2.amazonaws.com/freemius/plugins/2446/card_banner.png\";s:15:\"selling_point_0\";s:42:\"Create a library of HR Documents and Files\";s:15:\"selling_point_1\";s:43:\"Add Folders to Easily Manage your Documents\";s:15:\"selling_point_2\";s:48:\"Upload Documents to Individual Employee Profiles\";s:11:\"screenshots\";N;s:2:\"id\";s:3:\"377\";s:7:\"created\";s:19:\"2018-08-15 14:47:18\";s:7:\"updated\";s:19:\"2018-08-18 12:30:18\";}}i:3;O:8:\"stdClass\":37:{s:16:\"parent_plugin_id\";s:4:\"1296\";s:12:\"developer_id\";s:3:\"240\";s:10:\"install_id\";s:7:\"1873052\";s:4:\"slug\";s:11:\"wphr-fields\";s:5:\"title\";s:16:\"WP-HR Add Fields\";s:11:\"environment\";i:0;s:4:\"icon\";s:93:\"//s3-us-west-2.amazonaws.com/freemius/plugins/2454/icons/6aee6c701162b59add87c80cbb3c10c1.png\";s:15:\"default_plan_id\";s:4:\"3777\";s:5:\"plans\";i:3777;s:8:\"features\";N;s:17:\"money_back_period\";N;s:13:\"refund_policy\";N;s:24:\"annual_renewals_discount\";N;s:22:\"renewals_discount_type\";s:0:\"\";s:11:\"is_released\";b:1;s:18:\"is_pricing_visible\";b:1;s:19:\"is_wp_org_compliant\";b:0;s:6:\"is_off\";b:0;s:24:\"is_only_for_new_installs\";b:0;s:14:\"installs_limit\";N;s:14:\"installs_count\";i:39;s:21:\"active_installs_count\";i:24;s:19:\"free_releases_count\";i:0;s:22:\"premium_releases_count\";i:2;s:15:\"total_purchases\";i:2;s:19:\"total_subscriptions\";i:12;s:14:\"total_renewals\";i:17;s:8:\"earnings\";d:359.69999999999998863131622783839702606201171875;s:10:\"commission\";s:35:\"{\"1000\":0.3,\"5000\":0.2,\"above\":0.1}\";s:17:\"accepted_payments\";i:0;s:7:\"plan_id\";s:1:\"0\";s:4:\"type\";s:6:\"plugin\";s:10:\"public_key\";s:32:\"pk_9aa3fe478e0a0b4092a8d046330a5\";s:2:\"id\";s:4:\"2454\";s:7:\"created\";s:19:\"2018-08-18 14:07:53\";s:7:\"updated\";s:19:\"2019-08-29 05:49:10\";s:4:\"info\";O:8:\"stdClass\":13:{s:9:\"plugin_id\";s:4:\"2454\";s:3:\"url\";s:52:\"http://www.wphrmanager.com/product/wp-hr-add-fields/\";s:11:\"description\";s:257:\"There are already a lot of useful fields in WP-HR Manager for recording employee information - but you may want more!   Now you can easily add many types of field to the employee\'s profile, enabling you to gather and manage exactly the information you need.\";s:17:\"short_description\";s:31:\"Add fields to Employee Profiles\";s:10:\"banner_url\";s:61:\"//s3-us-west-2.amazonaws.com/freemius/plugins/2454/banner.png\";s:15:\"card_banner_url\";s:66:\"//s3-us-west-2.amazonaws.com/freemius/plugins/2454/card_banner.png\";s:15:\"selling_point_0\";s:31:\"Add fields to employee profiles\";s:15:\"selling_point_1\";s:53:\"Multiple field types - text, drop down, tick box etc.\";s:15:\"selling_point_2\";s:39:\"Collect additional employee information\";s:11:\"screenshots\";N;s:2:\"id\";s:3:\"379\";s:7:\"created\";s:19:\"2018-08-18 14:39:32\";s:7:\"updated\";s:19:\"2018-08-21 19:28:21\";}}i:4;O:8:\"stdClass\":37:{s:16:\"parent_plugin_id\";s:4:\"1296\";s:12:\"developer_id\";s:3:\"240\";s:10:\"install_id\";s:7:\"1873066\";s:4:\"slug\";s:8:\"wphr-sms\";s:5:\"title\";s:18:\"WP-HR SMS Messages\";s:11:\"environment\";i:0;s:4:\"icon\";s:93:\"//s3-us-west-2.amazonaws.com/freemius/plugins/2455/icons/2ffdd6f41e188491ad718dc2bb65ee7e.png\";s:15:\"default_plan_id\";s:4:\"3778\";s:5:\"plans\";i:3778;s:8:\"features\";i:3953;s:17:\"money_back_period\";N;s:13:\"refund_policy\";N;s:24:\"annual_renewals_discount\";N;s:22:\"renewals_discount_type\";s:0:\"\";s:11:\"is_released\";b:1;s:18:\"is_pricing_visible\";b:1;s:19:\"is_wp_org_compliant\";b:0;s:6:\"is_off\";b:0;s:24:\"is_only_for_new_installs\";b:0;s:14:\"installs_limit\";N;s:14:\"installs_count\";i:9;s:21:\"active_installs_count\";i:7;s:19:\"free_releases_count\";i:0;s:22:\"premium_releases_count\";i:2;s:15:\"total_purchases\";i:0;s:19:\"total_subscriptions\";i:1;s:14:\"total_renewals\";i:0;s:8:\"earnings\";i:0;s:10:\"commission\";s:0:\"\";s:17:\"accepted_payments\";i:0;s:7:\"plan_id\";s:1:\"0\";s:4:\"type\";s:6:\"plugin\";s:10:\"public_key\";s:32:\"pk_ad12da38db8bce4fd2c753d932e51\";s:2:\"id\";s:4:\"2455\";s:7:\"created\";s:19:\"2018-08-18 14:14:31\";s:7:\"updated\";s:19:\"2019-08-12 16:05:17\";s:4:\"info\";O:8:\"stdClass\":13:{s:9:\"plugin_id\";s:4:\"2455\";s:3:\"url\";s:54:\"http://www.wphrmanager.com/product/wp-hr-sms-messages/\";s:11:\"description\";s:230:\"It\'s good to keep in touch with employees and SMS messages are now one of the most common means of communicating in the world - so why not integrate an SMS messaging service with WP-HR Manager to help your employee communications?\";s:17:\"short_description\";s:31:\"Keep in touch with SMS messages\";s:10:\"banner_url\";s:61:\"//s3-us-west-2.amazonaws.com/freemius/plugins/2455/banner.png\";s:15:\"card_banner_url\";s:66:\"//s3-us-west-2.amazonaws.com/freemius/plugins/2455/card_banner.png\";s:15:\"selling_point_0\";s:26:\"SMS message your employees\";s:15:\"selling_point_1\";s:38:\"Integrates with multiple SMS suppliers\";s:15:\"selling_point_2\";N;s:11:\"screenshots\";N;s:2:\"id\";s:3:\"378\";s:7:\"created\";s:19:\"2018-08-18 14:31:46\";s:7:\"updated\";s:19:\"2018-08-18 14:45:53\";}}i:5;O:8:\"stdClass\":37:{s:16:\"parent_plugin_id\";s:4:\"1296\";s:12:\"developer_id\";s:3:\"240\";s:10:\"install_id\";s:7:\"2032042\";s:4:\"slug\";s:12:\"wphr-checkin\";s:5:\"title\";s:21:\"WP-HR Mobile Check In\";s:11:\"environment\";i:0;s:4:\"icon\";s:93:\"//s3-us-west-2.amazonaws.com/freemius/plugins/2702/icons/74419ef999421cb24384dfd5675b751b.png\";s:15:\"default_plan_id\";s:4:\"4216\";s:5:\"plans\";i:4216;s:8:\"features\";s:14:\"3219,3220,3221\";s:17:\"money_back_period\";N;s:13:\"refund_policy\";N;s:24:\"annual_renewals_discount\";N;s:22:\"renewals_discount_type\";s:0:\"\";s:11:\"is_released\";b:1;s:18:\"is_pricing_visible\";b:1;s:19:\"is_wp_org_compliant\";b:0;s:6:\"is_off\";b:0;s:24:\"is_only_for_new_installs\";b:0;s:14:\"installs_limit\";N;s:14:\"installs_count\";i:169;s:21:\"active_installs_count\";i:149;s:19:\"free_releases_count\";i:0;s:22:\"premium_releases_count\";i:6;s:15:\"total_purchases\";i:1;s:19:\"total_subscriptions\";i:10;s:14:\"total_renewals\";i:16;s:8:\"earnings\";d:739.76999999999998181010596454143524169921875;s:10:\"commission\";s:35:\"{\"1000\":0.3,\"5000\":0.2,\"above\":0.1}\";s:17:\"accepted_payments\";i:0;s:7:\"plan_id\";s:1:\"0\";s:4:\"type\";s:6:\"plugin\";s:10:\"public_key\";s:32:\"pk_25d48b262650ffbed218efbd3a765\";s:2:\"id\";s:4:\"2702\";s:7:\"created\";s:19:\"2018-10-11 20:43:04\";s:7:\"updated\";s:19:\"2019-08-29 05:50:58\";s:4:\"info\";O:8:\"stdClass\":13:{s:9:\"plugin_id\";s:4:\"2702\";s:3:\"url\";N;s:11:\"description\";s:419:\"The addon works with WP-HR Manager and WP-HR Attendance to add the functionality to integrate our two (Apple and Android) phone apps.  Perfect for employees who don\'t have regular access to a PC, or who work remotely.  Ask them to check in when the start work and check out when they finish - you\'ll know who is working at any time.  Ideal for tracking lateness, over time, remote workers, time based projects and more.\";s:17:\"short_description\";s:55:\"Enable employees to check in/out on their mobile phones\";s:10:\"banner_url\";s:61:\"//s3-us-west-2.amazonaws.com/freemius/plugins/2702/banner.png\";s:15:\"card_banner_url\";s:66:\"//s3-us-west-2.amazonaws.com/freemius/plugins/2702/card_banner.png\";s:15:\"selling_point_0\";s:45:\"One tap check in and check out (clock in/out)\";s:15:\"selling_point_1\";s:31:\"Andoid and Apple Apps available\";s:15:\"selling_point_2\";s:41:\"Perfect for tracking lateness and absence\";s:11:\"screenshots\";N;s:2:\"id\";s:3:\"436\";s:7:\"created\";s:19:\"2018-10-12 10:42:10\";s:7:\"updated\";s:19:\"2018-10-26 12:32:42\";}}i:6;O:8:\"stdClass\":38:{s:16:\"parent_plugin_id\";s:4:\"1296\";s:12:\"developer_id\";s:3:\"240\";s:10:\"install_id\";s:7:\"2656575\";s:4:\"slug\";s:13:\"wphr-training\";s:5:\"title\";s:13:\"WPHR Training\";s:11:\"environment\";i:0;s:4:\"icon\";s:93:\"//s3-us-west-2.amazonaws.com/freemius/plugins/3818/icons/815b260ec5f076e2c71401c05ad79ad2.png\";s:15:\"default_plan_id\";s:4:\"6457\";s:5:\"plans\";i:6457;s:8:\"features\";s:24:\"4895,5166,4896,4897,4898\";s:17:\"money_back_period\";N;s:13:\"refund_policy\";N;s:24:\"annual_renewals_discount\";N;s:22:\"renewals_discount_type\";s:0:\"\";s:11:\"is_released\";b:1;s:18:\"is_pricing_visible\";b:1;s:19:\"is_wp_org_compliant\";b:1;s:6:\"is_off\";b:0;s:24:\"is_only_for_new_installs\";b:0;s:14:\"installs_limit\";N;s:14:\"installs_count\";i:3;s:21:\"active_installs_count\";i:3;s:19:\"free_releases_count\";i:0;s:22:\"premium_releases_count\";i:4;s:15:\"total_purchases\";i:1;s:19:\"total_subscriptions\";i:0;s:14:\"total_renewals\";i:0;s:8:\"earnings\";i:0;s:10:\"commission\";s:0:\"\";s:17:\"accepted_payments\";i:0;s:7:\"plan_id\";s:1:\"0\";s:4:\"type\";s:6:\"plugin\";s:10:\"public_key\";s:32:\"pk_b236370bb41af077964c77ec3341b\";s:2:\"id\";s:4:\"3818\";s:7:\"created\";s:19:\"2019-05-16 16:18:55\";s:7:\"updated\";s:19:\"2019-08-31 18:39:59\";s:4:\"info\";O:8:\"stdClass\":13:{s:9:\"plugin_id\";s:4:\"3818\";s:3:\"url\";s:50:\"http://www.wphrmanager.com/product/wp-hr-training/\";s:11:\"description\";s:303:\"This addon helps you assign training resources such as videos and documents to employees.  You can also check they read/watched the resource (great for compliance) and check their level of understanding with a simple test.  Employees can be asked to retake the test if they don\'t achieve a minimum mark.\";s:17:\"short_description\";N;s:10:\"banner_url\";s:61:\"//s3-us-west-2.amazonaws.com/freemius/plugins/3818/banner.png\";s:15:\"card_banner_url\";s:66:\"//s3-us-west-2.amazonaws.com/freemius/plugins/3818/card_banner.png\";s:15:\"selling_point_0\";s:92:\"Add training videos or documents to employee profiles.  Bulk assign by job type or location.\";s:15:\"selling_point_1\";s:54:\"Set simple test to ensure understanding and compliance\";s:15:\"selling_point_2\";s:60:\"Get notified that employees have reviewed training materials\";s:11:\"screenshots\";N;s:2:\"id\";s:3:\"894\";s:7:\"created\";s:19:\"2019-06-25 15:47:19\";s:7:\"updated\";s:19:\"2019-08-12 12:23:20\";}s:12:\"premium_slug\";s:21:\"wphr-training-premium\";}}}s:7:\"created\";i:1567339712;s:9:\"timestamp\";i:1567426112;}s:53:\"get:/v1/plugins/1296/addons/pricing.json?type=visible\";O:8:\"stdClass\":3:{s:6:\"result\";O:8:\"stdClass\":1:{s:6:\"addons\";a:7:{i:0;O:8:\"stdClass\":2:{s:2:\"id\";i:1298;s:5:\"plans\";a:1:{i:0;O:8:\"stdClass\":23:{s:9:\"plugin_id\";s:4:\"1298\";s:4:\"name\";s:15:\"wphrrecruitment\";s:5:\"title\";s:17:\"WP-HR Recruitment\";s:11:\"description\";s:63:\"All you need to get started with recruiting using WP-HR Manager\";s:17:\"is_free_localhost\";b:1;s:17:\"is_block_features\";b:1;s:25:\"is_block_features_monthly\";b:1;s:12:\"license_type\";i:0;s:16:\"is_https_support\";b:0;s:12:\"trial_period\";i:14;s:23:\"is_require_subscription\";b:1;s:10:\"support_kb\";s:46:\"http://www.wphrmanager.com/help/documentation/\";s:13:\"support_forum\";s:52:\"http://www.wphrmanager.com/submit-a-support-request/\";s:13:\"support_email\";N;s:13:\"support_phone\";N;s:13:\"support_skype\";N;s:18:\"is_success_manager\";b:0;s:11:\"is_featured\";b:1;s:9:\"is_hidden\";b:0;s:2:\"id\";s:4:\"1827\";s:7:\"created\";s:19:\"2017-08-17 23:48:52\";s:7:\"updated\";s:19:\"2019-01-31 11:45:36\";s:7:\"pricing\";a:1:{i:0;O:8:\"stdClass\":10:{s:7:\"plan_id\";s:4:\"1827\";s:8:\"licenses\";i:1;s:13:\"monthly_price\";d:7.9900000000000002131628207280300557613372802734375;s:12:\"annual_price\";d:79.9899999999999948840923025272786617279052734375;s:14:\"lifetime_price\";d:239.990000000000009094947017729282379150390625;s:9:\"is_hidden\";b:0;s:2:\"id\";s:4:\"1228\";s:7:\"created\";s:19:\"2017-08-17 23:49:29\";s:7:\"updated\";s:19:\"2017-10-16 12:25:53\";s:8:\"currency\";s:3:\"usd\";}}}}}i:1;O:8:\"stdClass\":2:{s:2:\"id\";i:1314;s:5:\"plans\";a:1:{i:0;O:8:\"stdClass\":23:{s:9:\"plugin_id\";s:4:\"1314\";s:4:\"name\";s:10:\"attendance\";s:5:\"title\";s:16:\"WP-HR Attendance\";s:11:\"description\";s:17:\"Track work hours \";s:17:\"is_free_localhost\";b:1;s:17:\"is_block_features\";b:1;s:25:\"is_block_features_monthly\";b:1;s:12:\"license_type\";i:0;s:16:\"is_https_support\";b:0;s:12:\"trial_period\";i:14;s:23:\"is_require_subscription\";b:1;s:10:\"support_kb\";s:46:\"http://www.wphrmanager.com/help/documentation/\";s:13:\"support_forum\";s:52:\"http://www.wphrmanager.com/submit-a-support-request/\";s:13:\"support_email\";N;s:13:\"support_phone\";N;s:13:\"support_skype\";N;s:18:\"is_success_manager\";b:0;s:11:\"is_featured\";b:1;s:9:\"is_hidden\";b:0;s:2:\"id\";s:4:\"1857\";s:7:\"created\";s:19:\"2017-08-22 21:15:23\";s:7:\"updated\";s:19:\"2019-01-31 11:44:54\";s:7:\"pricing\";a:1:{i:0;O:8:\"stdClass\":10:{s:7:\"plan_id\";s:4:\"1857\";s:8:\"licenses\";i:1;s:13:\"monthly_price\";d:7.9900000000000002131628207280300557613372802734375;s:12:\"annual_price\";d:79.9899999999999948840923025272786617279052734375;s:14:\"lifetime_price\";d:239.990000000000009094947017729282379150390625;s:9:\"is_hidden\";b:0;s:2:\"id\";s:4:\"1260\";s:7:\"created\";s:19:\"2017-08-22 21:15:33\";s:7:\"updated\";s:19:\"2017-10-06 11:05:27\";s:8:\"currency\";s:3:\"usd\";}}}}}i:2;O:8:\"stdClass\":2:{s:2:\"id\";i:2446;s:5:\"plans\";a:1:{i:0;O:8:\"stdClass\":23:{s:9:\"plugin_id\";s:4:\"2446\";s:4:\"name\";s:9:\"documents\";s:5:\"title\";s:15:\"WP-HR Documents\";s:11:\"description\";s:36:\"Upload and manage employee documents\";s:17:\"is_free_localhost\";b:1;s:17:\"is_block_features\";b:1;s:25:\"is_block_features_monthly\";b:1;s:12:\"license_type\";i:0;s:16:\"is_https_support\";b:0;s:12:\"trial_period\";i:14;s:23:\"is_require_subscription\";b:1;s:10:\"support_kb\";s:48:\"http://www.wphrmanager.com/docs/wp-hr-documents/\";s:13:\"support_forum\";s:52:\"http://www.wphrmanager.com/submit-a-support-request/\";s:13:\"support_email\";N;s:13:\"support_phone\";N;s:13:\"support_skype\";N;s:18:\"is_success_manager\";b:0;s:11:\"is_featured\";b:1;s:9:\"is_hidden\";b:0;s:2:\"id\";s:4:\"3763\";s:7:\"created\";s:19:\"2018-08-15 15:27:28\";s:7:\"updated\";s:19:\"2019-01-31 11:45:14\";s:7:\"pricing\";a:1:{i:0;O:8:\"stdClass\":10:{s:7:\"plan_id\";s:4:\"3763\";s:8:\"licenses\";i:1;s:13:\"monthly_price\";d:5.9900000000000002131628207280300557613372802734375;s:12:\"annual_price\";d:59.99000000000000198951966012828052043914794921875;s:14:\"lifetime_price\";d:179.969999999999998863131622783839702606201171875;s:9:\"is_hidden\";b:0;s:2:\"id\";s:4:\"2907\";s:7:\"created\";s:19:\"2018-08-15 15:28:03\";s:7:\"updated\";s:19:\"2018-08-15 15:29:04\";s:8:\"currency\";s:3:\"usd\";}}}}}i:3;O:8:\"stdClass\":2:{s:2:\"id\";i:2454;s:5:\"plans\";a:1:{i:0;O:8:\"stdClass\":23:{s:9:\"plugin_id\";s:4:\"2454\";s:4:\"name\";s:6:\"fields\";s:5:\"title\";s:16:\"WP-HR Add Fields\";s:11:\"description\";N;s:17:\"is_free_localhost\";b:1;s:17:\"is_block_features\";b:1;s:25:\"is_block_features_monthly\";b:1;s:12:\"license_type\";i:0;s:16:\"is_https_support\";b:0;s:12:\"trial_period\";i:14;s:23:\"is_require_subscription\";b:1;s:10:\"support_kb\";s:49:\"http://www.wphrmanager.com/docs/wp-hr-add-fields/\";s:13:\"support_forum\";s:52:\"http://www.wphrmanager.com/submit-a-support-request/\";s:13:\"support_email\";N;s:13:\"support_phone\";N;s:13:\"support_skype\";N;s:18:\"is_success_manager\";b:0;s:11:\"is_featured\";b:1;s:9:\"is_hidden\";b:0;s:2:\"id\";s:4:\"3777\";s:7:\"created\";s:19:\"2018-08-18 14:19:18\";s:7:\"updated\";s:19:\"2019-01-31 11:45:27\";s:7:\"pricing\";a:1:{i:0;O:8:\"stdClass\":10:{s:7:\"plan_id\";s:4:\"3777\";s:8:\"licenses\";i:1;s:13:\"monthly_price\";d:2.9900000000000002131628207280300557613372802734375;s:12:\"annual_price\";d:29.989999999999998436805981327779591083526611328125;s:14:\"lifetime_price\";d:89.969999999999998863131622783839702606201171875;s:9:\"is_hidden\";b:0;s:2:\"id\";s:4:\"2913\";s:7:\"created\";s:19:\"2018-08-18 14:21:11\";s:7:\"updated\";s:19:\"2018-08-18 14:22:08\";s:8:\"currency\";s:3:\"usd\";}}}}}i:4;O:8:\"stdClass\":2:{s:2:\"id\";i:2455;s:5:\"plans\";a:1:{i:0;O:8:\"stdClass\":23:{s:9:\"plugin_id\";s:4:\"2455\";s:4:\"name\";s:3:\"sms\";s:5:\"title\";s:18:\"WP-HR SMS Messages\";s:11:\"description\";s:54:\"Send SMS messages to employees from with WP-HR Manager\";s:17:\"is_free_localhost\";b:1;s:17:\"is_block_features\";b:1;s:25:\"is_block_features_monthly\";b:1;s:12:\"license_type\";i:0;s:16:\"is_https_support\";b:0;s:12:\"trial_period\";i:14;s:23:\"is_require_subscription\";b:1;s:10:\"support_kb\";s:51:\"http://www.wphrmanager.com/docs/wp-hr-sms-messages/\";s:13:\"support_forum\";s:52:\"http://www.wphrmanager.com/submit-a-support-request/\";s:13:\"support_email\";N;s:13:\"support_phone\";N;s:13:\"support_skype\";N;s:18:\"is_success_manager\";b:0;s:11:\"is_featured\";b:1;s:9:\"is_hidden\";b:0;s:2:\"id\";s:4:\"3778\";s:7:\"created\";s:19:\"2018-08-18 14:27:27\";s:7:\"updated\";s:19:\"2019-01-31 11:45:45\";s:7:\"pricing\";a:1:{i:0;O:8:\"stdClass\":10:{s:7:\"plan_id\";s:4:\"3778\";s:8:\"licenses\";i:1;s:13:\"monthly_price\";d:6.9900000000000002131628207280300557613372802734375;s:12:\"annual_price\";d:69.9899999999999948840923025272786617279052734375;s:14:\"lifetime_price\";d:209.990000000000009094947017729282379150390625;s:9:\"is_hidden\";b:0;s:2:\"id\";s:4:\"2914\";s:7:\"created\";s:19:\"2018-08-18 14:28:09\";s:7:\"updated\";s:19:\"2018-08-19 11:21:03\";s:8:\"currency\";s:3:\"usd\";}}}}}i:5;O:8:\"stdClass\":2:{s:2:\"id\";i:2702;s:5:\"plans\";a:1:{i:0;O:8:\"stdClass\":23:{s:9:\"plugin_id\";s:4:\"2702\";s:4:\"name\";s:11:\"wphrcheckin\";s:5:\"title\";s:21:\"WP-HR Mobile Check In\";s:11:\"description\";s:63:\"Enable employees to check in and check out using a mobile phone\";s:17:\"is_free_localhost\";b:1;s:17:\"is_block_features\";b:1;s:25:\"is_block_features_monthly\";b:1;s:12:\"license_type\";i:0;s:16:\"is_https_support\";b:0;s:12:\"trial_period\";i:14;s:23:\"is_require_subscription\";b:1;s:10:\"support_kb\";s:46:\"http://www.wphrmanager.com/help/documentation/\";s:13:\"support_forum\";s:52:\"http://www.wphrmanager.com/submit-a-support-request/\";s:13:\"support_email\";N;s:13:\"support_phone\";N;s:13:\"support_skype\";N;s:18:\"is_success_manager\";b:0;s:11:\"is_featured\";b:1;s:9:\"is_hidden\";b:0;s:2:\"id\";s:4:\"4216\";s:7:\"created\";s:19:\"2018-10-11 20:49:45\";s:7:\"updated\";s:19:\"2019-01-31 11:45:04\";s:7:\"pricing\";a:1:{i:0;O:8:\"stdClass\":10:{s:7:\"plan_id\";s:4:\"4216\";s:8:\"licenses\";i:1;s:13:\"monthly_price\";d:9.9900000000000002131628207280300557613372802734375;s:12:\"annual_price\";d:79.9899999999999948840923025272786617279052734375;s:14:\"lifetime_price\";d:239.990000000000009094947017729282379150390625;s:9:\"is_hidden\";b:0;s:2:\"id\";s:4:\"3357\";s:7:\"created\";s:19:\"2018-10-11 20:50:16\";s:7:\"updated\";s:19:\"2018-10-11 20:50:55\";s:8:\"currency\";s:3:\"usd\";}}}}}i:6;O:8:\"stdClass\":2:{s:2:\"id\";i:3818;s:5:\"plans\";a:1:{i:0;O:8:\"stdClass\":23:{s:9:\"plugin_id\";s:4:\"3818\";s:4:\"name\";s:8:\"training\";s:5:\"title\";s:14:\"WP-HR Training\";s:11:\"description\";s:60:\"Add training resources (links) to employee profiles and test\";s:17:\"is_free_localhost\";b:1;s:17:\"is_block_features\";b:1;s:25:\"is_block_features_monthly\";b:1;s:12:\"license_type\";i:0;s:16:\"is_https_support\";b:0;s:12:\"trial_period\";i:14;s:23:\"is_require_subscription\";b:1;s:10:\"support_kb\";s:46:\"http://www.wphrmanager.com/help/documentation/\";s:13:\"support_forum\";s:52:\"http://www.wphrmanager.com/submit-a-support-request/\";s:13:\"support_email\";N;s:13:\"support_phone\";N;s:13:\"support_skype\";N;s:18:\"is_success_manager\";b:0;s:11:\"is_featured\";b:1;s:9:\"is_hidden\";b:0;s:2:\"id\";s:4:\"6457\";s:7:\"created\";s:19:\"2019-06-25 16:10:37\";s:7:\"updated\";s:19:\"2019-06-30 07:48:07\";s:7:\"pricing\";a:1:{i:0;O:8:\"stdClass\":10:{s:7:\"plan_id\";s:4:\"6457\";s:8:\"licenses\";i:1;s:13:\"monthly_price\";d:6.9900000000000002131628207280300557613372802734375;s:12:\"annual_price\";d:69.9899999999999948840923025272786617279052734375;s:14:\"lifetime_price\";d:209.990000000000009094947017729282379150390625;s:9:\"is_hidden\";b:0;s:2:\"id\";s:4:\"5811\";s:7:\"created\";s:19:\"2019-06-25 16:11:25\";s:7:\"updated\";s:19:\"2019-06-25 16:12:17\";s:8:\"currency\";s:3:\"usd\";}}}}}}}s:7:\"created\";i:1567339712;s:9:\"timestamp\";i:1567426112;}s:58:\"get:/v1/plugins/1296/addons/1298/pricing.json?type=visible\";O:8:\"stdClass\":3:{s:6:\"result\";O:8:\"stdClass\":1:{s:5:\"plans\";a:1:{i:0;O:8:\"stdClass\":23:{s:9:\"plugin_id\";s:4:\"1298\";s:4:\"name\";s:15:\"wphrrecruitment\";s:5:\"title\";s:17:\"WP-HR Recruitment\";s:11:\"description\";s:63:\"All you need to get started with recruiting using WP-HR Manager\";s:17:\"is_free_localhost\";b:1;s:17:\"is_block_features\";b:1;s:25:\"is_block_features_monthly\";b:1;s:12:\"license_type\";i:0;s:16:\"is_https_support\";b:0;s:12:\"trial_period\";i:14;s:23:\"is_require_subscription\";b:1;s:10:\"support_kb\";s:46:\"http://www.wphrmanager.com/help/documentation/\";s:13:\"support_forum\";s:52:\"http://www.wphrmanager.com/submit-a-support-request/\";s:13:\"support_email\";N;s:13:\"support_phone\";N;s:13:\"support_skype\";N;s:18:\"is_success_manager\";b:0;s:11:\"is_featured\";b:1;s:9:\"is_hidden\";b:0;s:2:\"id\";s:4:\"1827\";s:7:\"created\";s:19:\"2017-08-17 23:48:52\";s:7:\"updated\";s:19:\"2019-01-31 11:45:36\";s:7:\"pricing\";a:1:{i:0;O:8:\"stdClass\":10:{s:7:\"plan_id\";s:4:\"1827\";s:8:\"licenses\";i:1;s:13:\"monthly_price\";d:7.9900000000000002131628207280300557613372802734375;s:12:\"annual_price\";d:79.9899999999999948840923025272786617279052734375;s:14:\"lifetime_price\";d:239.990000000000009094947017729282379150390625;s:9:\"is_hidden\";b:0;s:2:\"id\";s:4:\"1228\";s:7:\"created\";s:19:\"2017-08-17 23:49:29\";s:7:\"updated\";s:19:\"2017-10-16 12:25:53\";s:8:\"currency\";s:3:\"usd\";}}}}}s:7:\"created\";i:1567339742;s:9:\"timestamp\";i:1567426142;}s:64:\"get:/v1/plugins/1296/addons/1298/updates/latest.json?readme=true\";O:8:\"stdClass\":3:{s:6:\"result\";O:8:\"stdClass\":16:{s:9:\"plugin_id\";s:4:\"1298\";s:12:\"developer_id\";s:3:\"240\";s:4:\"slug\";N;s:12:\"premium_slug\";s:24:\"wphr-recruitment-premium\";s:7:\"version\";s:7:\"0.1.5.3\";s:11:\"sdk_version\";s:5:\"2.2.4\";s:25:\"requires_platform_version\";s:3:\"4.4\";s:20:\"tested_up_to_version\";s:3:\"5.1\";s:10:\"downloaded\";i:41;s:8:\"has_free\";b:0;s:11:\"has_premium\";b:1;s:12:\"release_mode\";s:8:\"released\";s:2:\"id\";s:4:\"6790\";s:7:\"created\";s:19:\"2019-03-01 12:04:59\";s:7:\"updated\";s:19:\"2019-09-01 08:35:50\";s:11:\"is_released\";b:1;}s:7:\"created\";i:1567339742;s:9:\"timestamp\";i:1567426142;}s:58:\"get:/v1/plugins/1296/addons/2455/pricing.json?type=visible\";O:8:\"stdClass\":3:{s:6:\"result\";O:8:\"stdClass\":1:{s:5:\"plans\";a:1:{i:0;O:8:\"stdClass\":24:{s:9:\"plugin_id\";s:4:\"2455\";s:4:\"name\";s:3:\"sms\";s:5:\"title\";s:18:\"WP-HR SMS Messages\";s:11:\"description\";s:54:\"Send SMS messages to employees from with WP-HR Manager\";s:17:\"is_free_localhost\";b:1;s:17:\"is_block_features\";b:1;s:25:\"is_block_features_monthly\";b:1;s:12:\"license_type\";i:0;s:16:\"is_https_support\";b:0;s:12:\"trial_period\";i:14;s:23:\"is_require_subscription\";b:1;s:10:\"support_kb\";s:51:\"http://www.wphrmanager.com/docs/wp-hr-sms-messages/\";s:13:\"support_forum\";s:52:\"http://www.wphrmanager.com/submit-a-support-request/\";s:13:\"support_email\";N;s:13:\"support_phone\";N;s:13:\"support_skype\";N;s:18:\"is_success_manager\";b:0;s:11:\"is_featured\";b:1;s:9:\"is_hidden\";b:0;s:2:\"id\";s:4:\"3778\";s:7:\"created\";s:19:\"2018-08-18 14:27:27\";s:7:\"updated\";s:19:\"2019-01-31 11:45:45\";s:7:\"pricing\";a:1:{i:0;O:8:\"stdClass\":10:{s:7:\"plan_id\";s:4:\"3778\";s:8:\"licenses\";i:1;s:13:\"monthly_price\";d:6.9900000000000002131628207280300557613372802734375;s:12:\"annual_price\";d:69.9899999999999948840923025272786617279052734375;s:14:\"lifetime_price\";d:209.990000000000009094947017729282379150390625;s:9:\"is_hidden\";b:0;s:2:\"id\";s:4:\"2914\";s:7:\"created\";s:19:\"2018-08-18 14:28:09\";s:7:\"updated\";s:19:\"2018-08-19 11:21:03\";s:8:\"currency\";s:3:\"usd\";}}s:8:\"features\";a:1:{i:0;O:8:\"stdClass\":9:{s:5:\"value\";N;s:7:\"plan_id\";s:4:\"3778\";s:9:\"plugin_id\";s:4:\"2455\";s:5:\"title\";s:56:\"Send SMS Messages to employees from within WP-HR Manager\";s:11:\"description\";N;s:11:\"is_featured\";b:1;s:2:\"id\";s:4:\"3953\";s:7:\"created\";s:19:\"2019-01-31 11:36:13\";s:7:\"updated\";N;}}}}}s:7:\"created\";i:1567339791;s:9:\"timestamp\";i:1567426191;}s:64:\"get:/v1/plugins/1296/addons/2455/updates/latest.json?readme=true\";O:8:\"stdClass\":3:{s:6:\"result\";O:8:\"stdClass\":16:{s:9:\"plugin_id\";s:4:\"2455\";s:12:\"developer_id\";s:3:\"240\";s:4:\"slug\";N;s:12:\"premium_slug\";s:16:\"wphr-sms-premium\";s:7:\"version\";s:3:\"0.2\";s:11:\"sdk_version\";s:5:\"2.2.4\";s:25:\"requires_platform_version\";s:3:\"4.4\";s:20:\"tested_up_to_version\";s:3:\"5.1\";s:10:\"downloaded\";i:20;s:8:\"has_free\";b:0;s:11:\"has_premium\";b:1;s:12:\"release_mode\";s:8:\"released\";s:2:\"id\";s:4:\"6791\";s:7:\"created\";s:19:\"2019-03-01 12:05:30\";s:7:\"updated\";s:19:\"2019-08-29 05:35:54\";s:11:\"is_released\";b:1;}s:7:\"created\";i:1567339791;s:9:\"timestamp\";i:1567426191;}}','yes'),
	(586,'fs_gdpr','a:1:{s:2:\"u1\";a:1:{s:8:\"required\";b:0;}}','yes'),
	(589,'wphr_settings_wphr-crm_subscription','a:8:{s:10:\"is_enabled\";s:3:\"yes\";s:13:\"email_subject\";s:32:\"Confirm your subscription to HRM\";s:13:\"email_content\";s:266:\"Hello!\n\nThanks so much for signing up for our newsletter.\nWe need you to activate your subscription to the list(s): [contact_groups_to_confirm] by clicking the link below: \n\n[activation_link]Click here to confirm your subscription.[/activation_link]\n\nThank you,\n\nHRM\";s:7:\"page_id\";i:14;s:18:\"confirm_page_title\";s:23:\"You are now subscribed!\";s:20:\"confirm_page_content\";s:63:\"We\'ve added you to our email list. You\'ll hear from us shortly.\";s:17:\"unsubs_page_title\";s:24:\"You are now unsubscribed\";s:19:\"unsubs_page_content\";s:47:\"You are successfully unsubscribed from list(s):\";}','yes'),
	(590,'wphr_email_settings_employee-welcome','a:3:{s:7:\"subject\";s:37:\"Welcome {full_name} to {company_name}\";s:7:\"heading\";s:29:\"Welcome Onboard {first_name}!\";s:4:\"body\";s:1029:\"Dear {full_name},\r\n\r\nWelcome aboard as a <strong>{job_title}</strong> in our <strong>{dept_title}</strong> team at <strong>{company_name}</strong>! I am pleased to have you working with us. You were selected for employment due to the attributes that you displayed that appear to match the qualities I look for in an employee.\r\n\r\nI’m looking forward to seeing you grow and develop into an outstanding employee that exhibits a high level of care, concern, and compassion for others. I hope that you will find your work to be rewarding, challenging, and meaningful.\r\n\r\nYour <strong>{type}</strong> employment will start from <strong>{joined_date}</strong> and you will be reporting to <strong>{reporting_to}</strong>.\r\n\r\nPlease take your time and review our yearly goals so that you can know what is expected and make a positive contribution. Again, I look forward to seeing you grow as a professional while enhancing the lives of the clients entrusted in your care.\r\n\r\nSincerely,\r\nManager Name\r\nCEO, Company Name\r\n\r\n{login_info}\";}','yes'),
	(591,'wphr_email_settings_new-leave-request','a:3:{s:7:\"subject\";s:47:\"New leave request received from {employee_name}\";s:7:\"heading\";s:17:\"New Leave Request\";s:4:\"body\";s:333:\"Hello,\r\n\r\nA new leave request has been received from {employee_url}.\r\n\r\n<strong>Leave type:</strong> {leave_type}\r\n<strong>Date:</strong> {date_from} to {date_to}\r\n<strong>Duration:</strong> {no_days}\r\n<strong>Reason:</strong> {reason}\r\n\r\nPlease approve/reject this leave application by going following:\r\n\r\n{requests_url}\r\n\r\nThanks.\";}','yes'),
	(592,'wphr_email_settings_approved-leave-request','a:3:{s:7:\"subject\";s:36:\"Your leave request has been approved\";s:7:\"heading\";s:22:\"Leave Request Approved\";s:4:\"body\";s:193:\"Hello {employee_name},\r\n\r\nYour <strong>{leave_type}</strong> type leave request for <strong>{no_days}</strong> from {date_from} to {date_to} has been approved.\r\n\r\nRegards\r\nManager Name\r\nCompany\";}','yes'),
	(593,'wphr_email_settings_rejected-leave-request','a:3:{s:7:\"subject\";s:36:\"Your leave request has been rejected\";s:7:\"heading\";s:22:\"Leave Request Rejected\";s:4:\"body\";s:240:\"Hello {employee_name},\r\n\r\nYour <strong>{leave_type}</strong> type leave request for <strong>{no_days}</strong> from {date_from} to {date_to} has been rejected.\r\n\r\nThe reason of rejection is: {reject_reason}\r\n\r\nRegards\r\nManager Name\r\nCompany\";}','yes'),
	(594,'wphr_email_settings_new-task-assigned','a:3:{s:7:\"subject\";s:33:\"New task has been assigned to you\";s:7:\"heading\";s:17:\"New Task Assigned\";s:4:\"body\";s:164:\"Hello {employee_name},\r\n\r\nA new task <strong>{task_title}</strong> has been assigned to you by {created_by}.\r\nDue Date: {due_date}\r\n\r\nRegards\r\nManager Name\r\nCompany\";}','yes'),
	(597,'wp_wphr_version','0.1','yes'),
	(598,'wp_wphr_db_version','0.1','yes'),
	(600,'wphr_settings_hr-frontend-page','a:4:{s:8:\"emp_list\";i:15;s:11:\"emp_profile\";i:16;s:11:\"hr_dshboard\";i:17;s:10:\"my_profile\";i:18;}','yes'),
	(601,'wphr_setup_wizard_ran','1','yes'),
	(602,'wphr_settings_general','a:4:{s:19:\"gen_financial_month\";s:1:\"1\";s:13:\"gen_com_start\";s:0:\"\";s:11:\"date_format\";s:5:\"d-m-Y\";s:15:\"wphr_debug_mode\";i:0;}','yes'),
	(603,'wphr_settings_accounting','a:1:{s:13:\"base_currency\";s:3:\"USD\";}','yes'),
	(605,'mon','8','yes'),
	(606,'tue','8','yes'),
	(607,'wed','8','yes'),
	(608,'thu','8','yes'),
	(609,'fri','8','yes'),
	(610,'sat','0','yes'),
	(611,'sun','0','yes'),
	(744,'organization_name','mishu udpate','yes'),
	(745,'tax_id','uasdf','yes'),
	(746,'registration_number','a;sdkfa sd','yes'),
	(747,'phone','aksdflkjsd','yes'),
	(748,'fax','jksfdn nlkj','yes'),
	(749,'addres_street_1','nlsdkjfn','yes'),
	(750,'address_street_2','lkjasfdn lkj','yes'),
	(751,'city','lkjsdf','yes'),
	(752,'state_province','mishu awfhk','yes'),
	(753,'zip','kjaf jsdfk','yes'),
	(754,'country','AS','yes'),
	(755,'note','mishu arwedfQAs','yes'),
	(767,'_site_transient_update_core','O:8:\"stdClass\":4:{s:7:\"updates\";a:1:{i:0;O:8:\"stdClass\":10:{s:8:\"response\";s:6:\"latest\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.2.3.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.2.3.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-5.2.3-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-5.2.3-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"5.2.3\";s:7:\"version\";s:5:\"5.2.3\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.0\";s:15:\"partial_version\";s:0:\"\";}}s:12:\"last_checked\";i:1569602479;s:15:\"version_checked\";s:5:\"5.2.3\";s:12:\"translations\";a:0:{}}','no'),
	(770,'auto_core_update_notified','a:4:{s:4:\"type\";s:7:\"success\";s:5:\"email\";s:19:\"joy.mishu@gmail.com\";s:7:\"version\";s:5:\"5.2.3\";s:9:\"timestamp\";i:1567652076;}','no'),
	(787,'woocommerce_store_address','','yes'),
	(788,'woocommerce_store_address_2','','yes'),
	(789,'woocommerce_store_city','','yes'),
	(790,'woocommerce_default_country','GB','yes'),
	(791,'woocommerce_store_postcode','','yes'),
	(792,'woocommerce_allowed_countries','all','yes'),
	(793,'woocommerce_all_except_countries','','yes'),
	(794,'woocommerce_specific_allowed_countries','','yes'),
	(795,'woocommerce_ship_to_countries','','yes'),
	(796,'woocommerce_specific_ship_to_countries','','yes'),
	(797,'woocommerce_default_customer_address','geolocation','yes'),
	(798,'woocommerce_calc_taxes','no','yes'),
	(799,'woocommerce_enable_coupons','yes','yes'),
	(800,'woocommerce_calc_discounts_sequentially','no','no'),
	(801,'woocommerce_currency','GBP','yes'),
	(802,'woocommerce_currency_pos','left','yes'),
	(803,'woocommerce_price_thousand_sep',',','yes'),
	(804,'woocommerce_price_decimal_sep','.','yes'),
	(805,'woocommerce_price_num_decimals','2','yes'),
	(806,'woocommerce_shop_page_id','','yes'),
	(807,'woocommerce_cart_redirect_after_add','no','yes'),
	(808,'woocommerce_enable_ajax_add_to_cart','yes','yes'),
	(809,'woocommerce_placeholder_image','','yes'),
	(810,'woocommerce_weight_unit','kg','yes'),
	(811,'woocommerce_dimension_unit','cm','yes'),
	(812,'woocommerce_enable_reviews','yes','yes'),
	(813,'woocommerce_review_rating_verification_label','yes','no'),
	(814,'woocommerce_review_rating_verification_required','no','no'),
	(815,'woocommerce_enable_review_rating','yes','yes'),
	(816,'woocommerce_review_rating_required','yes','no'),
	(817,'woocommerce_manage_stock','yes','yes'),
	(818,'woocommerce_hold_stock_minutes','60','no'),
	(819,'woocommerce_notify_low_stock','yes','no'),
	(820,'woocommerce_notify_no_stock','yes','no'),
	(821,'woocommerce_stock_email_recipient','joy.mishu@gmail.com','no'),
	(822,'woocommerce_notify_low_stock_amount','2','no'),
	(823,'woocommerce_notify_no_stock_amount','0','yes'),
	(824,'woocommerce_hide_out_of_stock_items','no','yes'),
	(825,'woocommerce_stock_format','','yes'),
	(826,'woocommerce_file_download_method','force','no'),
	(827,'woocommerce_downloads_require_login','no','no'),
	(828,'woocommerce_downloads_grant_access_after_payment','yes','no'),
	(829,'woocommerce_prices_include_tax','no','yes'),
	(830,'woocommerce_tax_based_on','shipping','yes'),
	(831,'woocommerce_shipping_tax_class','inherit','yes'),
	(832,'woocommerce_tax_round_at_subtotal','no','yes'),
	(833,'woocommerce_tax_classes','Reduced rate\nZero rate','yes'),
	(834,'woocommerce_tax_display_shop','excl','yes'),
	(835,'woocommerce_tax_display_cart','excl','yes'),
	(836,'woocommerce_price_display_suffix','','yes'),
	(837,'woocommerce_tax_total_display','itemized','no'),
	(838,'woocommerce_enable_shipping_calc','yes','no'),
	(839,'woocommerce_shipping_cost_requires_address','no','yes'),
	(840,'woocommerce_ship_to_destination','billing','no'),
	(841,'woocommerce_shipping_debug_mode','no','yes'),
	(842,'woocommerce_enable_guest_checkout','yes','no'),
	(843,'woocommerce_enable_checkout_login_reminder','no','no'),
	(844,'woocommerce_enable_signup_and_login_from_checkout','no','no'),
	(845,'woocommerce_enable_myaccount_registration','no','no'),
	(846,'woocommerce_registration_generate_username','yes','no'),
	(847,'woocommerce_registration_generate_password','yes','no'),
	(848,'woocommerce_erasure_request_removes_order_data','no','no'),
	(849,'woocommerce_erasure_request_removes_download_data','no','no'),
	(850,'woocommerce_registration_privacy_policy_text','Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our [privacy_policy].','yes'),
	(851,'woocommerce_checkout_privacy_policy_text','Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our [privacy_policy].','yes'),
	(852,'woocommerce_delete_inactive_accounts','a:2:{s:6:\"number\";s:0:\"\";s:4:\"unit\";s:6:\"months\";}','no'),
	(853,'woocommerce_trash_pending_orders','','no'),
	(854,'woocommerce_trash_failed_orders','','no'),
	(855,'woocommerce_trash_cancelled_orders','','no'),
	(856,'woocommerce_anonymize_completed_orders','a:2:{s:6:\"number\";s:0:\"\";s:4:\"unit\";s:6:\"months\";}','no'),
	(857,'woocommerce_email_from_name','HRM','no'),
	(858,'woocommerce_email_from_address','joy.mishu@gmail.com','no'),
	(859,'woocommerce_email_header_image','','no'),
	(860,'woocommerce_email_footer_text','{site_title}<br/>Built with <a href=\"https://woocommerce.com/\">WooCommerce</a>','no'),
	(861,'woocommerce_email_base_color','#96588a','no'),
	(862,'woocommerce_email_background_color','#f7f7f7','no'),
	(863,'woocommerce_email_body_background_color','#ffffff','no'),
	(864,'woocommerce_email_text_color','#3c3c3c','no'),
	(865,'woocommerce_cart_page_id','','yes'),
	(866,'woocommerce_checkout_page_id','','yes'),
	(867,'woocommerce_myaccount_page_id','','yes'),
	(868,'woocommerce_terms_page_id','','no'),
	(869,'woocommerce_force_ssl_checkout','no','yes'),
	(870,'woocommerce_unforce_ssl_checkout','no','yes'),
	(871,'woocommerce_checkout_pay_endpoint','order-pay','yes'),
	(872,'woocommerce_checkout_order_received_endpoint','order-received','yes'),
	(873,'woocommerce_myaccount_add_payment_method_endpoint','add-payment-method','yes'),
	(874,'woocommerce_myaccount_delete_payment_method_endpoint','delete-payment-method','yes'),
	(875,'woocommerce_myaccount_set_default_payment_method_endpoint','set-default-payment-method','yes'),
	(876,'woocommerce_myaccount_orders_endpoint','orders','yes'),
	(877,'woocommerce_myaccount_view_order_endpoint','view-order','yes'),
	(878,'woocommerce_myaccount_downloads_endpoint','downloads','yes'),
	(879,'woocommerce_myaccount_edit_account_endpoint','edit-account','yes'),
	(880,'woocommerce_myaccount_edit_address_endpoint','edit-address','yes'),
	(881,'woocommerce_myaccount_payment_methods_endpoint','payment-methods','yes'),
	(882,'woocommerce_myaccount_lost_password_endpoint','lost-password','yes'),
	(883,'woocommerce_logout_endpoint','customer-logout','yes'),
	(884,'woocommerce_api_enabled','no','yes'),
	(885,'woocommerce_single_image_width','600','yes'),
	(886,'woocommerce_thumbnail_image_width','300','yes'),
	(887,'woocommerce_checkout_highlight_required_fields','yes','yes'),
	(888,'woocommerce_demo_store','no','no'),
	(889,'woocommerce_permalinks','a:5:{s:12:\"product_base\";s:7:\"product\";s:13:\"category_base\";s:16:\"product-category\";s:8:\"tag_base\";s:11:\"product-tag\";s:14:\"attribute_base\";s:0:\"\";s:22:\"use_verbose_page_rules\";b:0;}','yes'),
	(890,'current_theme_supports_woocommerce','yes','yes'),
	(891,'woocommerce_queue_flush_rewrite_rules','no','yes'),
	(892,'_transient_wc_attribute_taxonomies','a:0:{}','yes'),
	(893,'product_cat_children','a:0:{}','yes'),
	(894,'default_product_cat','15','yes'),
	(897,'woocommerce_version','3.5.7','yes'),
	(898,'woocommerce_db_version','3.5.7','yes'),
	(899,'woocommerce_admin_notices','a:0:{}','yes'),
	(902,'_transient_woocommerce_webhook_ids','a:0:{}','yes'),
	(903,'widget_woocommerce_widget_cart','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(904,'widget_woocommerce_layered_nav_filters','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(905,'widget_woocommerce_layered_nav','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(906,'widget_woocommerce_price_filter','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(907,'widget_woocommerce_product_categories','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(908,'widget_woocommerce_product_search','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(909,'widget_woocommerce_product_tag_cloud','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(910,'widget_woocommerce_products','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(911,'widget_woocommerce_recently_viewed_products','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(912,'widget_woocommerce_top_rated_products','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(913,'widget_woocommerce_recent_reviews','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(914,'widget_woocommerce_rating_filter','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
	(919,'woocommerce_meta_box_errors','a:0:{}','yes'),
	(920,'_transient_wc_count_comments','O:8:\"stdClass\":7:{s:14:\"total_comments\";i:1;s:3:\"all\";i:1;s:8:\"approved\";s:1:\"1\";s:9:\"moderated\";i:0;s:4:\"spam\";i:0;s:5:\"trash\";i:0;s:12:\"post-trashed\";i:0;}','yes'),
	(921,'_transient_as_comment_count','O:8:\"stdClass\":7:{s:8:\"approved\";s:1:\"1\";s:14:\"total_comments\";i:1;s:3:\"all\";i:1;s:9:\"moderated\";i:0;s:4:\"spam\";i:0;s:5:\"trash\";i:0;s:12:\"post-trashed\";i:0;}','yes'),
	(927,'_transient_timeout_wc_low_stock_count','1570253822','no'),
	(928,'_transient_wc_low_stock_count','0','no'),
	(929,'_transient_timeout_wc_outofstock_count','1570253822','no'),
	(930,'_transient_wc_outofstock_count','0','no'),
	(1043,'_site_transient_update_themes','O:8:\"stdClass\":4:{s:12:\"last_checked\";i:1569602479;s:7:\"checked\";a:3:{s:14:\"twentynineteen\";s:3:\"1.4\";s:15:\"twentyseventeen\";s:3:\"2.2\";s:13:\"twentysixteen\";s:3:\"2.0\";}s:8:\"response\";a:0:{}s:12:\"translations\";a:0:{}}','no'),
	(1097,'0df30ebf373897ef8aacd70acf97eb4b','a:2:{s:7:\"timeout\";i:1569564731;s:5:\"value\";s:328:\"{\"new_version\":\"1.2.0\",\"name\":\"HRM Loan\",\"slug\":\"loan\",\"url\":\"https:\\/\\/wpspear.com\\/downloads\\/hrm-loan\\/?changelog=1\",\"last_updated\":\"2019-09-23 21:05:13\",\"homepage\":\"https:\\/\\/wpspear.com\\/downloads\\/hrm-loan\\/\",\"package\":\"\",\"download_link\":\"\",\"sections\":{\"description\":\"\",\"changelog\":\"\"},\"description\":[\"\"],\"changelog\":[\"\"]}\";}','no'),
	(1098,'edd_api_request_0df30ebf373897ef8aacd70acf97eb4b','a:2:{s:7:\"timeout\";i:1569142268;s:5:\"value\";s:328:\"{\"new_version\":\"1.0.0\",\"name\":\"HRM Loan\",\"slug\":\"loan\",\"url\":\"https:\\/\\/wpspear.com\\/downloads\\/hrm-loan\\/?changelog=1\",\"last_updated\":\"2019-08-13 11:08:29\",\"homepage\":\"https:\\/\\/wpspear.com\\/downloads\\/hrm-loan\\/\",\"package\":\"\",\"download_link\":\"\",\"sections\":{\"description\":\"\",\"changelog\":\"\"},\"description\":[\"\"],\"changelog\":[\"\"]}\";}','no'),
	(1141,'_site_transient_timeout_browser_f44c9dc63430374544afa8db89aa5dd9','1570072763','no'),
	(1142,'_site_transient_browser_f44c9dc63430374544afa8db89aa5dd9','a:10:{s:4:\"name\";s:6:\"Chrome\";s:7:\"version\";s:12:\"77.0.3865.90\";s:8:\"platform\";s:9:\"Macintosh\";s:10:\"update_url\";s:29:\"https://www.google.com/chrome\";s:7:\"img_src\";s:43:\"http://s.w.org/images/browsers/chrome.png?1\";s:11:\"img_src_ssl\";s:44:\"https://s.w.org/images/browsers/chrome.png?1\";s:15:\"current_version\";s:2:\"18\";s:7:\"upgrade\";b:0;s:8:\"insecure\";b:0;s:6:\"mobile\";b:0;}','no'),
	(1164,'_site_transient_update_plugins','O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1569602479;s:7:\"checked\";a:10:{s:19:\"akismet/akismet.php\";s:5:\"4.1.2\";s:23:\"debug-bar/debug-bar.php\";s:3:\"1.0\";s:39:\"debug-bar-console/debug-bar-console.php\";s:3:\"0.3\";s:9:\"hello.php\";s:5:\"1.7.2\";s:36:\"hrm-time-shift/attendance-report.php\";s:3:\"1.0\";s:17:\"hrm-lone/loan.php\";s:3:\"1.0\";s:25:\"hrm-payroll-loan/loan.php\";s:3:\"1.2\";s:11:\"hrm/hrm.php\";s:6:\"2.2.16\";s:35:\"hrm-recruitment/hrm-recruitment.php\";s:5:\"1.0.0\";s:23:\"hrm-front/hrm-front.php\";s:5:\"2.0.1\";}s:8:\"response\";a:2:{s:25:\"hrm-payroll-loan/loan.php\";O:8:\"stdClass\":11:{s:11:\"new_version\";s:5:\"1.2.0\";s:4:\"name\";s:8:\"HRM Loan\";s:4:\"slug\";s:4:\"loan\";s:3:\"url\";s:51:\"https://wpspear.com/downloads/hrm-loan/?changelog=1\";s:12:\"last_updated\";s:19:\"2019-09-23 21:05:13\";s:8:\"homepage\";s:39:\"https://wpspear.com/downloads/hrm-loan/\";s:7:\"package\";s:0:\"\";s:13:\"download_link\";s:0:\"\";s:8:\"sections\";O:8:\"stdClass\":2:{s:11:\"description\";s:0:\"\";s:9:\"changelog\";s:0:\"\";}s:11:\"description\";a:1:{i:0;s:0:\"\";}s:9:\"changelog\";a:1:{i:0;s:0:\"\";}}s:36:\"hrm-time-shift/attendance-report.php\";O:8:\"stdClass\":11:{s:11:\"new_version\";s:3:\"1.3\";s:4:\"name\";s:17:\"Attendance Report\";s:4:\"slug\";s:17:\"attendance-report\";s:3:\"url\";s:60:\"https://wpspear.com/downloads/attendance-report/?changelog=1\";s:12:\"last_updated\";s:19:\"2019-09-23 21:06:33\";s:8:\"homepage\";s:48:\"https://wpspear.com/downloads/attendance-report/\";s:7:\"package\";s:0:\"\";s:13:\"download_link\";s:0:\"\";s:8:\"sections\";O:8:\"stdClass\":2:{s:11:\"description\";s:0:\"\";s:9:\"changelog\";s:0:\"\";}s:11:\"description\";a:1:{i:0;s:0:\"\";}s:9:\"changelog\";a:1:{i:0;s:0:\"\";}}}s:12:\"translations\";a:0:{}s:9:\"no_update\";a:5:{s:19:\"akismet/akismet.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:21:\"w.org/plugins/akismet\";s:4:\"slug\";s:7:\"akismet\";s:6:\"plugin\";s:19:\"akismet/akismet.php\";s:11:\"new_version\";s:5:\"4.1.2\";s:3:\"url\";s:38:\"https://wordpress.org/plugins/akismet/\";s:7:\"package\";s:56:\"https://downloads.wordpress.org/plugin/akismet.4.1.2.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:59:\"https://ps.w.org/akismet/assets/icon-256x256.png?rev=969272\";s:2:\"1x\";s:59:\"https://ps.w.org/akismet/assets/icon-128x128.png?rev=969272\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:61:\"https://ps.w.org/akismet/assets/banner-772x250.jpg?rev=479904\";}s:11:\"banners_rtl\";a:0:{}}s:23:\"debug-bar/debug-bar.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:23:\"w.org/plugins/debug-bar\";s:4:\"slug\";s:9:\"debug-bar\";s:6:\"plugin\";s:23:\"debug-bar/debug-bar.php\";s:11:\"new_version\";s:3:\"1.0\";s:3:\"url\";s:40:\"https://wordpress.org/plugins/debug-bar/\";s:7:\"package\";s:56:\"https://downloads.wordpress.org/plugin/debug-bar.1.0.zip\";s:5:\"icons\";a:3:{s:2:\"2x\";s:62:\"https://ps.w.org/debug-bar/assets/icon-256x256.png?rev=1908362\";s:2:\"1x\";s:54:\"https://ps.w.org/debug-bar/assets/icon.svg?rev=1908362\";s:3:\"svg\";s:54:\"https://ps.w.org/debug-bar/assets/icon.svg?rev=1908362\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:65:\"https://ps.w.org/debug-bar/assets/banner-1544x500.png?rev=1365496\";s:2:\"1x\";s:64:\"https://ps.w.org/debug-bar/assets/banner-772x250.png?rev=1365496\";}s:11:\"banners_rtl\";a:0:{}}s:39:\"debug-bar-console/debug-bar-console.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:31:\"w.org/plugins/debug-bar-console\";s:4:\"slug\";s:17:\"debug-bar-console\";s:6:\"plugin\";s:39:\"debug-bar-console/debug-bar-console.php\";s:11:\"new_version\";s:3:\"0.3\";s:3:\"url\";s:48:\"https://wordpress.org/plugins/debug-bar-console/\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/plugin/debug-bar-console.0.3.zip\";s:5:\"icons\";a:1:{s:7:\"default\";s:61:\"https://s.w.org/plugins/geopattern-icon/debug-bar-console.svg\";}s:7:\"banners\";a:0:{}s:11:\"banners_rtl\";a:0:{}}s:9:\"hello.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:25:\"w.org/plugins/hello-dolly\";s:4:\"slug\";s:11:\"hello-dolly\";s:6:\"plugin\";s:9:\"hello.php\";s:11:\"new_version\";s:5:\"1.7.2\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/hello-dolly/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/hello-dolly.1.7.2.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-256x256.jpg?rev=2052855\";s:2:\"1x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-128x128.jpg?rev=2052855\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:66:\"https://ps.w.org/hello-dolly/assets/banner-772x250.jpg?rev=2052855\";}s:11:\"banners_rtl\";a:0:{}}s:11:\"hrm/hrm.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:17:\"w.org/plugins/hrm\";s:4:\"slug\";s:3:\"hrm\";s:6:\"plugin\";s:11:\"hrm/hrm.php\";s:11:\"new_version\";s:6:\"2.2.16\";s:3:\"url\";s:34:\"https://wordpress.org/plugins/hrm/\";s:7:\"package\";s:53:\"https://downloads.wordpress.org/plugin/hrm.2.2.16.zip\";s:5:\"icons\";a:1:{s:7:\"default\";s:54:\"https://s.w.org/plugins/geopattern-icon/hrm_9ac9da.svg\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:58:\"https://ps.w.org/hrm/assets/banner-772x250.png?rev=1847228\";}s:11:\"banners_rtl\";a:0:{}}}}','no'),
	(1166,'_site_transient_timeout_theme_roots','1569604279','no'),
	(1167,'_site_transient_theme_roots','a:3:{s:14:\"twentynineteen\";s:7:\"/themes\";s:15:\"twentyseventeen\";s:7:\"/themes\";s:13:\"twentysixteen\";s:7:\"/themes\";}','no');

/*!40000 ALTER TABLE `wp_options` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_postmeta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_postmeta`;

CREATE TABLE `wp_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

LOCK TABLES `wp_postmeta` WRITE;
/*!40000 ALTER TABLE `wp_postmeta` DISABLE KEYS */;

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`)
VALUES
	(1,2,'_wp_page_template','default'),
	(2,3,'_wp_page_template','default'),
	(3,5,'_edit_lock','1567655049:1'),
	(4,6,'_wp_attached_file','2019/07/rakib.jpg'),
	(5,6,'_wp_attachment_metadata','a:5:{s:5:\"width\";i:300;s:6:\"height\";i:300;s:4:\"file\";s:17:\"2019/07/rakib.jpg\";s:5:\"sizes\";a:1:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:17:\"rakib-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
	(6,10,'_rows','a:1:{i:0;a:2:{s:2:\"id\";i:6305;s:6:\"r_cols\";a:1:{i:0;i:7477;}}}'),
	(7,10,'_cols','a:1:{i:0;a:4:{s:2:\"id\";i:7477;s:4:\"span\";i:4;s:6:\"c_cols\";a:0:{}s:3:\"els\";a:13:{i:0;i:7681;i:1;i:7309;i:2;i:9774;i:3;i:258;i:4;i:603;i:5;i:1150;i:6;i:2588;i:7;i:6876;i:8;i:7324;i:9;i:1841;i:10;i:5621;i:11;i:8282;i:12;i:1623;}}}'),
	(8,10,'_els','a:13:{i:0;a:11:{s:2:\"id\";i:7681;s:4:\"span\";i:4;s:10:\"visibility\";b:1;s:4:\"type\";s:13:\"section_field\";s:5:\"label\";s:5:\"Label\";s:7:\"content\";s:7:\"Content\";s:9:\"field_val\";s:0:\"\";s:10:\"group_type\";s:15:\"profile_details\";s:9:\"group_key\";s:3:\"sec\";s:22:\"ele_settings_field_val\";a:6:{s:5:\"label\";s:15:\"Profile Details\";s:7:\"content\";s:7:\"Content\";s:4:\"name\";s:15:\"wpup_label_7681\";s:11:\"placeholder\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"disabled\";b:0;}s:18:\"ele_settings_field\";a:6:{s:5:\"label\";b:1;s:7:\"content\";b:0;s:4:\"name\";b:0;s:11:\"placeholder\";b:0;s:11:\"description\";b:0;s:8:\"disabled\";b:0;}}i:1;a:11:{s:2:\"id\";i:7309;s:4:\"span\";i:4;s:10:\"visibility\";b:1;s:4:\"type\";s:10:\"text_field\";s:5:\"label\";s:5:\"Label\";s:7:\"content\";s:7:\"Content\";s:9:\"field_val\";s:5:\"admin\";s:10:\"group_type\";s:15:\"profile_details\";s:9:\"group_key\";s:4:\"user\";s:22:\"ele_settings_field_val\";a:6:{s:5:\"label\";s:8:\"Username\";s:7:\"content\";s:5:\"admin\";s:4:\"name\";s:15:\"wpup_label_7309\";s:11:\"placeholder\";s:0:\"\";s:11:\"description\";s:28:\"Usernames cannot be changed.\";s:8:\"disabled\";b:1;}s:18:\"ele_settings_field\";a:6:{s:5:\"label\";b:0;s:7:\"content\";b:0;s:4:\"name\";b:0;s:11:\"placeholder\";b:0;s:11:\"description\";b:1;s:8:\"disabled\";b:0;}}i:2;a:11:{s:2:\"id\";i:9774;s:4:\"span\";i:4;s:10:\"visibility\";b:1;s:4:\"type\";s:10:\"text_field\";s:5:\"label\";s:5:\"Label\";s:7:\"content\";s:7:\"Content\";s:9:\"field_val\";s:0:\"\";s:10:\"group_type\";s:15:\"profile_details\";s:9:\"group_key\";s:3:\"fst\";s:22:\"ele_settings_field_val\";a:6:{s:5:\"label\";s:10:\"First Name\";s:7:\"content\";s:22:\"Insert your first name\";s:4:\"name\";s:10:\"first_name\";s:11:\"placeholder\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"disabled\";b:0;}s:18:\"ele_settings_field\";a:6:{s:5:\"label\";b:1;s:7:\"content\";b:1;s:4:\"name\";b:0;s:11:\"placeholder\";b:1;s:11:\"description\";b:1;s:8:\"disabled\";b:1;}}i:3;a:11:{s:2:\"id\";i:258;s:4:\"span\";i:4;s:10:\"visibility\";b:1;s:4:\"type\";s:10:\"text_field\";s:5:\"label\";s:5:\"Label\";s:7:\"content\";s:7:\"Content\";s:9:\"field_val\";s:0:\"\";s:10:\"group_type\";s:15:\"profile_details\";s:9:\"group_key\";s:3:\"lst\";s:22:\"ele_settings_field_val\";a:6:{s:5:\"label\";s:9:\"Last Name\";s:7:\"content\";s:21:\"Insert your last name\";s:4:\"name\";s:9:\"last_name\";s:11:\"placeholder\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"disabled\";b:0;}s:18:\"ele_settings_field\";a:6:{s:5:\"label\";b:1;s:7:\"content\";b:1;s:4:\"name\";b:0;s:11:\"placeholder\";b:1;s:11:\"description\";b:1;s:8:\"disabled\";b:1;}}i:4;a:11:{s:2:\"id\";i:603;s:4:\"span\";i:4;s:10:\"visibility\";b:1;s:4:\"type\";s:10:\"text_field\";s:5:\"label\";s:5:\"Label\";s:7:\"content\";s:7:\"Content\";s:9:\"field_val\";s:5:\"admin\";s:10:\"group_type\";s:15:\"profile_details\";s:9:\"group_key\";s:8:\"nickname\";s:22:\"ele_settings_field_val\";a:6:{s:5:\"label\";s:19:\"Nickname (required)\";s:7:\"content\";s:25:\"Insert your nickname name\";s:4:\"name\";s:8:\"nickname\";s:11:\"placeholder\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"disabled\";b:0;}s:18:\"ele_settings_field\";a:6:{s:5:\"label\";b:1;s:7:\"content\";b:1;s:4:\"name\";b:0;s:11:\"placeholder\";b:1;s:11:\"description\";b:1;s:8:\"disabled\";b:1;}}i:5;a:12:{s:2:\"id\";i:1150;s:4:\"span\";i:4;s:10:\"visibility\";b:1;s:4:\"type\";s:12:\"select_field\";s:5:\"label\";s:5:\"Label\";s:7:\"content\";s:7:\"Content\";s:9:\"field_val\";s:16:\"display_nickname\";s:10:\"group_type\";s:15:\"profile_details\";s:9:\"group_key\";s:12:\"display_name\";s:22:\"ele_settings_field_val\";a:6:{s:5:\"label\";s:24:\"Display name publicly as\";s:7:\"content\";s:24:\"Display name publicly as\";s:4:\"name\";s:12:\"display_name\";s:11:\"placeholder\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"disabled\";b:0;}s:18:\"ele_settings_field\";a:6:{s:5:\"label\";b:1;s:7:\"content\";b:1;s:4:\"name\";b:0;s:11:\"placeholder\";b:0;s:11:\"description\";b:1;s:8:\"disabled\";b:1;}s:14:\"select_options\";a:1:{s:16:\"display_nickname\";s:5:\"admin\";}}i:6;a:12:{s:2:\"id\";i:2588;s:4:\"span\";i:4;s:10:\"visibility\";b:1;s:4:\"type\";s:11:\"email_field\";s:5:\"label\";s:5:\"Label\";s:7:\"content\";s:7:\"Content\";s:9:\"field_val\";s:19:\"joy.mishu@gmail.com\";s:10:\"group_type\";s:15:\"profile_details\";s:9:\"group_key\";s:5:\"email\";s:22:\"ele_settings_field_val\";a:6:{s:5:\"label\";s:16:\"Email (required)\";s:7:\"content\";s:17:\"Insert your email\";s:4:\"name\";s:5:\"email\";s:11:\"placeholder\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"disabled\";b:0;}s:18:\"ele_settings_field\";a:6:{s:5:\"label\";b:1;s:7:\"content\";b:1;s:4:\"name\";b:0;s:11:\"placeholder\";b:0;s:11:\"description\";b:0;s:8:\"disabled\";b:0;}s:8:\"required\";b:1;}i:7;a:11:{s:2:\"id\";i:6876;s:4:\"span\";i:4;s:10:\"visibility\";b:1;s:4:\"type\";s:9:\"url_field\";s:5:\"label\";s:5:\"Label\";s:7:\"content\";s:7:\"Content\";s:9:\"field_val\";s:0:\"\";s:10:\"group_type\";s:15:\"profile_details\";s:9:\"group_key\";s:3:\"web\";s:22:\"ele_settings_field_val\";a:6:{s:5:\"label\";s:7:\"Website\";s:7:\"content\";s:19:\"Insert your web URL\";s:4:\"name\";s:3:\"url\";s:11:\"placeholder\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"disabled\";b:0;}s:18:\"ele_settings_field\";a:6:{s:5:\"label\";b:1;s:7:\"content\";b:1;s:4:\"name\";b:0;s:11:\"placeholder\";b:0;s:11:\"description\";b:0;s:8:\"disabled\";b:0;}}i:8;a:11:{s:2:\"id\";i:7324;s:4:\"span\";i:4;s:10:\"visibility\";b:1;s:4:\"type\";s:14:\"password_field\";s:5:\"label\";s:5:\"Label\";s:7:\"content\";s:7:\"Content\";s:9:\"field_val\";s:0:\"\";s:10:\"group_type\";s:15:\"profile_details\";s:9:\"group_key\";s:4:\"pass\";s:22:\"ele_settings_field_val\";a:6:{s:5:\"label\";s:12:\"New Password\";s:7:\"content\";s:24:\"Insert your new password\";s:4:\"name\";s:5:\"pass1\";s:11:\"placeholder\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"disabled\";b:0;}s:18:\"ele_settings_field\";a:6:{s:5:\"label\";b:1;s:7:\"content\";b:1;s:4:\"name\";b:0;s:11:\"placeholder\";b:1;s:11:\"description\";b:1;s:8:\"disabled\";b:1;}}i:9;a:12:{s:2:\"id\";i:1841;s:4:\"span\";i:4;s:10:\"visibility\";b:1;s:4:\"type\";s:11:\"radio_field\";s:5:\"label\";s:5:\"Label\";s:7:\"content\";s:7:\"Content\";s:9:\"field_val\";i:1;s:10:\"group_type\";s:15:\"profile_details\";s:9:\"group_key\";s:3:\"gnd\";s:22:\"ele_settings_field_val\";a:6:{s:5:\"label\";s:6:\"Gender\";s:7:\"content\";s:18:\"Insert your gender\";s:4:\"name\";s:6:\"gender\";s:11:\"placeholder\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"disabled\";b:0;}s:18:\"ele_settings_field\";a:6:{s:5:\"label\";b:1;s:7:\"content\";b:1;s:4:\"name\";b:1;s:11:\"placeholder\";b:0;s:11:\"description\";b:0;s:8:\"disabled\";b:0;}s:13:\"radio_options\";a:2:{i:1;s:4:\"Male\";i:2;s:6:\"Female\";}}i:10;a:11:{s:2:\"id\";i:5621;s:4:\"span\";i:4;s:10:\"visibility\";b:1;s:4:\"type\";s:10:\"text_field\";s:5:\"label\";s:5:\"Label\";s:7:\"content\";s:7:\"Content\";s:9:\"field_val\";s:0:\"\";s:10:\"group_type\";s:15:\"profile_details\";s:9:\"group_key\";s:3:\"bio\";s:22:\"ele_settings_field_val\";a:6:{s:5:\"label\";s:17:\"Biographical Info\";s:7:\"content\";s:29:\"Insert your biographical info\";s:4:\"name\";s:11:\"description\";s:11:\"placeholder\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"disabled\";b:0;}s:18:\"ele_settings_field\";a:6:{s:5:\"label\";b:1;s:7:\"content\";b:1;s:4:\"name\";b:0;s:11:\"placeholder\";b:1;s:11:\"description\";b:1;s:8:\"disabled\";b:1;}}i:11;a:11:{s:2:\"id\";i:8282;s:4:\"span\";i:4;s:10:\"visibility\";b:1;s:4:\"type\";s:10:\"text_field\";s:5:\"label\";s:5:\"Label\";s:7:\"content\";s:7:\"Content\";s:9:\"field_val\";s:0:\"\";s:10:\"group_type\";s:15:\"profile_details\";s:9:\"group_key\";s:3:\"add\";s:22:\"ele_settings_field_val\";a:6:{s:5:\"label\";s:7:\"Address\";s:7:\"content\";s:19:\"Insert your address\";s:4:\"name\";s:7:\"address\";s:11:\"placeholder\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"disabled\";b:0;}s:18:\"ele_settings_field\";a:6:{s:5:\"label\";b:1;s:7:\"content\";b:1;s:4:\"name\";b:1;s:11:\"placeholder\";b:1;s:11:\"description\";b:1;s:8:\"disabled\";b:1;}}i:12;a:12:{s:2:\"id\";i:1623;s:4:\"span\";i:4;s:10:\"visibility\";b:1;s:4:\"type\";s:12:\"select_field\";s:5:\"label\";s:5:\"Label\";s:7:\"content\";s:7:\"Content\";s:9:\"field_val\";s:2:\"BD\";s:10:\"group_type\";s:15:\"profile_details\";s:9:\"group_key\";s:3:\"con\";s:22:\"ele_settings_field_val\";a:6:{s:5:\"label\";s:7:\"Country\";s:7:\"content\";s:19:\"Insert your country\";s:4:\"name\";s:6:\"contry\";s:11:\"placeholder\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"disabled\";b:0;}s:18:\"ele_settings_field\";a:6:{s:5:\"label\";b:1;s:7:\"content\";b:1;s:4:\"name\";b:1;s:11:\"placeholder\";b:0;s:11:\"description\";b:1;s:8:\"disabled\";b:1;}s:14:\"select_options\";a:250:{s:2:\"AF\";s:11:\"Afghanistan\";s:2:\"AX\";s:7:\"Islands\";s:2:\"AL\";s:7:\"Albania\";s:2:\"DZ\";s:7:\"Algeria\";s:2:\"AS\";s:14:\"American Samoa\";s:2:\"AD\";s:7:\"Andorra\";s:2:\"AO\";s:6:\"Angola\";s:2:\"AI\";s:8:\"Anguilla\";s:2:\"AQ\";s:10:\"Antarctica\";s:2:\"AG\";s:19:\"Antigua and Barbuda\";s:2:\"AR\";s:9:\"Argentina\";s:2:\"AM\";s:7:\"Armenia\";s:2:\"AW\";s:5:\"Aruba\";s:2:\"AU\";s:9:\"Australia\";s:2:\"AT\";s:7:\"Austria\";s:2:\"AZ\";s:10:\"Azerbaijan\";s:2:\"BS\";s:7:\"Bahamas\";s:2:\"BH\";s:7:\"Bahrain\";s:2:\"BD\";s:10:\"Bangladesh\";s:2:\"BB\";s:8:\"Barbados\";s:2:\"BY\";s:7:\"Belarus\";s:2:\"BE\";s:7:\"Belgium\";s:2:\"PW\";s:5:\"Belau\";s:2:\"BZ\";s:6:\"Belize\";s:2:\"BJ\";s:5:\"Benin\";s:2:\"BM\";s:7:\"Bermuda\";s:2:\"BT\";s:6:\"Bhutan\";s:2:\"BO\";s:7:\"Bolivia\";s:2:\"BQ\";s:33:\"Bonaire, Saint Eustatius and Saba\";s:2:\"BA\";s:22:\"Bosnia and Herzegovina\";s:2:\"BW\";s:8:\"Botswana\";s:2:\"BV\";s:13:\"Bouvet Island\";s:2:\"BR\";s:6:\"Brazil\";s:2:\"IO\";s:30:\"British Indian Ocean Territory\";s:2:\"VG\";s:22:\"British Virgin Islands\";s:2:\"BN\";s:6:\"Brunei\";s:2:\"BG\";s:8:\"Bulgaria\";s:2:\"BF\";s:12:\"Burkina Faso\";s:2:\"BI\";s:7:\"Burundi\";s:2:\"KH\";s:8:\"Cambodia\";s:2:\"CM\";s:8:\"Cameroon\";s:2:\"CA\";s:6:\"Canada\";s:2:\"CV\";s:10:\"Cape Verde\";s:2:\"KY\";s:14:\"Cayman Islands\";s:2:\"CF\";s:24:\"Central African Republic\";s:2:\"TD\";s:4:\"Chad\";s:2:\"CL\";s:5:\"Chile\";s:2:\"CN\";s:5:\"China\";s:2:\"CX\";s:16:\"Christmas Island\";s:2:\"CC\";s:23:\"Cocos (Keeling) Islands\";s:2:\"CO\";s:8:\"Colombia\";s:2:\"KM\";s:7:\"Comoros\";s:2:\"CG\";s:19:\"Congo (Brazzaville)\";s:2:\"CD\";s:16:\"Congo (Kinshasa)\";s:2:\"CK\";s:12:\"Cook Islands\";s:2:\"CR\";s:10:\"Costa Rica\";s:2:\"HR\";s:7:\"Croatia\";s:2:\"CU\";s:4:\"Cuba\";s:2:\"CW\";s:14:\"Cura&ccedil;ao\";s:2:\"CY\";s:6:\"Cyprus\";s:2:\"CZ\";s:14:\"Czech Republic\";s:2:\"DK\";s:7:\"Denmark\";s:2:\"DJ\";s:8:\"Djibouti\";s:2:\"DM\";s:8:\"Dominica\";s:2:\"DO\";s:18:\"Dominican Republic\";s:2:\"EC\";s:7:\"Ecuador\";s:2:\"EG\";s:5:\"Egypt\";s:2:\"SV\";s:11:\"El Salvador\";s:2:\"GQ\";s:17:\"Equatorial Guinea\";s:2:\"ER\";s:7:\"Eritrea\";s:2:\"EE\";s:7:\"Estonia\";s:2:\"ET\";s:8:\"Ethiopia\";s:2:\"FK\";s:16:\"Falkland Islands\";s:2:\"FO\";s:13:\"Faroe Islands\";s:2:\"FJ\";s:4:\"Fiji\";s:2:\"FI\";s:7:\"Finland\";s:2:\"FR\";s:6:\"France\";s:2:\"GF\";s:13:\"French Guiana\";s:2:\"PF\";s:16:\"French Polynesia\";s:2:\"TF\";s:27:\"French Southern Territories\";s:2:\"GA\";s:5:\"Gabon\";s:2:\"GM\";s:6:\"Gambia\";s:2:\"GE\";s:7:\"Georgia\";s:2:\"DE\";s:7:\"Germany\";s:2:\"GH\";s:5:\"Ghana\";s:2:\"GI\";s:9:\"Gibraltar\";s:2:\"GR\";s:6:\"Greece\";s:2:\"GL\";s:9:\"Greenland\";s:2:\"GD\";s:7:\"Grenada\";s:2:\"GP\";s:10:\"Guadeloupe\";s:2:\"GU\";s:4:\"Guam\";s:2:\"GT\";s:9:\"Guatemala\";s:2:\"GG\";s:8:\"Guernsey\";s:2:\"GN\";s:6:\"Guinea\";s:2:\"GW\";s:13:\"Guinea-Bissau\";s:2:\"GY\";s:6:\"Guyana\";s:2:\"HT\";s:5:\"Haiti\";s:2:\"HM\";s:33:\"Heard Island and McDonald Islands\";s:2:\"HN\";s:8:\"Honduras\";s:2:\"HK\";s:9:\"Hong Kong\";s:2:\"HU\";s:7:\"Hungary\";s:2:\"IS\";s:7:\"Iceland\";s:2:\"IN\";s:5:\"India\";s:2:\"ID\";s:9:\"Indonesia\";s:2:\"IR\";s:4:\"Iran\";s:2:\"IQ\";s:4:\"Iraq\";s:2:\"IE\";s:19:\"Republic of Ireland\";s:2:\"IM\";s:11:\"Isle of Man\";s:2:\"IL\";s:6:\"Israel\";s:2:\"IT\";s:5:\"Italy\";s:2:\"CI\";s:11:\"Ivory Coast\";s:2:\"JM\";s:7:\"Jamaica\";s:2:\"JP\";s:5:\"Japan\";s:2:\"JE\";s:6:\"Jersey\";s:2:\"JO\";s:6:\"Jordan\";s:2:\"KZ\";s:10:\"Kazakhstan\";s:2:\"KE\";s:5:\"Kenya\";s:2:\"KI\";s:8:\"Kiribati\";s:2:\"KW\";s:6:\"Kuwait\";s:2:\"KG\";s:10:\"Kyrgyzstan\";s:2:\"LA\";s:4:\"Laos\";s:2:\"LV\";s:6:\"Latvia\";s:2:\"LB\";s:7:\"Lebanon\";s:2:\"LS\";s:7:\"Lesotho\";s:2:\"LR\";s:7:\"Liberia\";s:2:\"LY\";s:5:\"Libya\";s:2:\"LI\";s:13:\"Liechtenstein\";s:2:\"LT\";s:9:\"Lithuania\";s:2:\"LU\";s:10:\"Luxembourg\";s:2:\"MO\";s:19:\"Macao S.A.R., China\";s:2:\"MK\";s:9:\"Macedonia\";s:2:\"MG\";s:10:\"Madagascar\";s:2:\"MW\";s:6:\"Malawi\";s:2:\"MY\";s:8:\"Malaysia\";s:2:\"MV\";s:8:\"Maldives\";s:2:\"ML\";s:4:\"Mali\";s:2:\"MT\";s:5:\"Malta\";s:2:\"MH\";s:16:\"Marshall Islands\";s:2:\"MQ\";s:10:\"Martinique\";s:2:\"MR\";s:10:\"Mauritania\";s:2:\"MU\";s:9:\"Mauritius\";s:2:\"YT\";s:7:\"Mayotte\";s:2:\"MX\";s:6:\"Mexico\";s:2:\"FM\";s:10:\"Micronesia\";s:2:\"MD\";s:7:\"Moldova\";s:2:\"MC\";s:6:\"Monaco\";s:2:\"MN\";s:8:\"Mongolia\";s:2:\"ME\";s:10:\"Montenegro\";s:2:\"MS\";s:10:\"Montserrat\";s:2:\"MA\";s:7:\"Morocco\";s:2:\"MZ\";s:10:\"Mozambique\";s:2:\"MM\";s:7:\"Myanmar\";s:2:\"NA\";s:7:\"Namibia\";s:2:\"NR\";s:5:\"Nauru\";s:2:\"NP\";s:5:\"Nepal\";s:2:\"NL\";s:11:\"Netherlands\";s:2:\"AN\";s:20:\"Netherlands Antilles\";s:2:\"NC\";s:13:\"New Caledonia\";s:2:\"NZ\";s:11:\"New Zealand\";s:2:\"NI\";s:9:\"Nicaragua\";s:2:\"NE\";s:5:\"Niger\";s:2:\"NG\";s:7:\"Nigeria\";s:2:\"NU\";s:4:\"Niue\";s:2:\"NF\";s:14:\"Norfolk Island\";s:2:\"MP\";s:24:\"Northern Mariana Islands\";s:2:\"KP\";s:11:\"North Korea\";s:2:\"NO\";s:6:\"Norway\";s:2:\"OM\";s:4:\"Oman\";s:2:\"PK\";s:8:\"Pakistan\";s:2:\"PS\";s:21:\"Palestinian Territory\";s:2:\"PA\";s:6:\"Panama\";s:2:\"PG\";s:16:\"Papua New Guinea\";s:2:\"PY\";s:8:\"Paraguay\";s:2:\"PE\";s:4:\"Peru\";s:2:\"PH\";s:11:\"Philippines\";s:2:\"PN\";s:8:\"Pitcairn\";s:2:\"PL\";s:6:\"Poland\";s:2:\"PT\";s:8:\"Portugal\";s:2:\"PR\";s:11:\"Puerto Rico\";s:2:\"QA\";s:5:\"Qatar\";s:2:\"RE\";s:7:\"Reunion\";s:2:\"RO\";s:7:\"Romania\";s:2:\"RU\";s:6:\"Russia\";s:2:\"RW\";s:6:\"Rwanda\";s:2:\"BL\";s:23:\"Saint Barth&eacute;lemy\";s:2:\"SH\";s:12:\"Saint Helena\";s:2:\"KN\";s:21:\"Saint Kitts and Nevis\";s:2:\"LC\";s:11:\"Saint Lucia\";s:2:\"MF\";s:26:\"Saint Martin (French part)\";s:2:\"SX\";s:25:\"Saint Martin (Dutch part)\";s:2:\"PM\";s:25:\"Saint Pierre and Miquelon\";s:2:\"VC\";s:32:\"Saint Vincent and the Grenadines\";s:2:\"SM\";s:10:\"San Marino\";s:2:\"ST\";s:42:\"S&atilde;o Tom&eacute; and Pr&iacute;ncipe\";s:2:\"SA\";s:12:\"Saudi Arabia\";s:2:\"SN\";s:7:\"Senegal\";s:2:\"RS\";s:6:\"Serbia\";s:2:\"SC\";s:10:\"Seychelles\";s:2:\"SL\";s:12:\"Sierra Leone\";s:2:\"SG\";s:9:\"Singapore\";s:2:\"SK\";s:8:\"Slovakia\";s:2:\"SI\";s:8:\"Slovenia\";s:2:\"SB\";s:15:\"Solomon Islands\";s:2:\"SO\";s:7:\"Somalia\";s:2:\"ZA\";s:12:\"South Africa\";s:2:\"GS\";s:30:\"South Georgia/Sandwich Islands\";s:2:\"KR\";s:11:\"South Korea\";s:2:\"SS\";s:11:\"South Sudan\";s:2:\"ES\";s:5:\"Spain\";s:2:\"LK\";s:9:\"Sri Lanka\";s:2:\"SD\";s:5:\"Sudan\";s:2:\"SR\";s:8:\"Suriname\";s:2:\"SJ\";s:22:\"Svalbard and Jan Mayen\";s:2:\"SZ\";s:9:\"Swaziland\";s:2:\"SE\";s:6:\"Sweden\";s:2:\"CH\";s:11:\"Switzerland\";s:2:\"SY\";s:5:\"Syria\";s:2:\"TW\";s:6:\"Taiwan\";s:2:\"TJ\";s:10:\"Tajikistan\";s:2:\"TZ\";s:8:\"Tanzania\";s:2:\"TH\";s:8:\"Thailand\";s:2:\"TL\";s:11:\"Timor-Leste\";s:2:\"TG\";s:4:\"Togo\";s:2:\"TK\";s:7:\"Tokelau\";s:2:\"TO\";s:5:\"Tonga\";s:2:\"TT\";s:19:\"Trinidad and Tobago\";s:2:\"TN\";s:7:\"Tunisia\";s:2:\"TR\";s:6:\"Turkey\";s:2:\"TM\";s:12:\"Turkmenistan\";s:2:\"TC\";s:24:\"Turks and Caicos Islands\";s:2:\"TV\";s:6:\"Tuvalu\";s:2:\"UG\";s:6:\"Uganda\";s:2:\"UA\";s:7:\"Ukraine\";s:2:\"AE\";s:20:\"United Arab Emirates\";s:2:\"GB\";s:19:\"United Kingdom (UK)\";s:2:\"US\";s:18:\"United States (US)\";s:2:\"UM\";s:41:\"United States (US) Minor Outlying Islands\";s:2:\"VI\";s:33:\"United States (US) Virgin Islands\";s:2:\"UY\";s:7:\"Uruguay\";s:2:\"UZ\";s:10:\"Uzbekistan\";s:2:\"VU\";s:7:\"Vanuatu\";s:2:\"VA\";s:7:\"Vatican\";s:2:\"VE\";s:9:\"Venezuela\";s:2:\"VN\";s:7:\"Vietnam\";s:2:\"WF\";s:17:\"Wallis and Futuna\";s:2:\"EH\";s:14:\"Western Sahara\";s:2:\"WS\";s:5:\"Samoa\";s:2:\"YE\";s:5:\"Yemen\";s:2:\"ZM\";s:6:\"Zambia\";s:2:\"ZW\";s:8:\"Zimbabwe\";}}}'),
	(9,10,'_header','a:6:{i:0;a:8:{s:4:\"type\";s:12:\"display_name\";s:5:\"title\";s:10:\"My name is\";s:7:\"content\";s:5:\"admin\";s:4:\"icon\";s:7:\"fa-user\";s:10:\"visibility\";i:1;s:6:\"enable\";b:1;s:13:\"content_field\";b:0;s:4:\"name\";b:0;}i:1;a:8:{s:4:\"type\";s:5:\"email\";s:5:\"title\";s:11:\"My email is\";s:7:\"content\";s:19:\"joy.mishu@gmail.com\";s:4:\"icon\";s:11:\"fa-envelope\";s:10:\"visibility\";i:0;s:6:\"enable\";b:1;s:13:\"content_field\";b:0;s:4:\"name\";b:0;}i:2;a:9:{s:4:\"type\";s:8:\"birthday\";s:5:\"title\";s:14:\"My birthday is\";s:7:\"content\";s:0:\"\";s:4:\"icon\";s:11:\"fa-calendar\";s:10:\"visibility\";i:0;s:6:\"enable\";b:1;s:10:\"date_field\";b:1;s:13:\"content_field\";b:0;s:4:\"name\";s:13:\"wpup_birthday\";}i:3;a:7:{s:4:\"type\";s:8:\"location\";s:5:\"title\";s:14:\"My location is\";s:7:\"content\";s:0:\"\";s:4:\"icon\";s:13:\"fa-map-marker\";s:10:\"visibility\";i:0;s:6:\"enable\";b:1;s:4:\"name\";s:13:\"wpup_location\";}i:4;a:7:{s:4:\"type\";s:5:\"phone\";s:5:\"title\";s:18:\"My phone number is\";s:7:\"content\";s:0:\"\";s:4:\"icon\";s:8:\"fa-phone\";s:10:\"visibility\";i:0;s:6:\"enable\";b:1;s:4:\"name\";s:10:\"wpup_phone\";}i:5;a:8:{s:4:\"type\";s:6:\"logout\";s:5:\"title\";s:6:\"Logout\";s:7:\"content\";s:28:\"Terminating a login session.\";s:4:\"icon\";s:11:\"fa-sign-out\";s:10:\"logout_url\";s:116:\"http://localhost/hrm/wp-login.php?action=logout&amp;redirect_to=http%3A%2F%2Flocalhost%2Fhrm&amp;_wpnonce=d48a7a8b34\";s:10:\"visibility\";i:0;s:6:\"enable\";b:1;s:4:\"name\";b:0;}}'),
	(10,10,'_content_width','600'),
	(11,10,'_content_width_unit','='),
	(12,19,'_edit_lock','1567227355:1'),
	(13,19,'_oembed_bf6964af303ed7ed4297755ba99a9f33','<iframe title=\"The Mountain\" src=\"https://player.vimeo.com/video/22439234?dnt=1&amp;app_id=122963\" width=\"640\" height=\"360\" frameborder=\"0\" allow=\"autoplay; fullscreen\" allowfullscreen></iframe>'),
	(14,19,'_oembed_time_bf6964af303ed7ed4297755ba99a9f33','1567225820'),
	(15,21,'_wp_attached_file','2019/08/images.jpeg'),
	(16,21,'_wp_attachment_metadata','a:5:{s:5:\"width\";i:225;s:6:\"height\";i:225;s:4:\"file\";s:19:\"2019/08/images.jpeg\";s:5:\"sizes\";a:1:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:19:\"images-150x150.jpeg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
	(17,22,'_wp_attached_file','2019/08/girl-311628_640.png'),
	(18,22,'_wp_attachment_metadata','a:5:{s:5:\"width\";i:605;s:6:\"height\";i:640;s:4:\"file\";s:27:\"2019/08/girl-311628_640.png\";s:5:\"sizes\";a:2:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:27:\"girl-311628_640-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}s:6:\"medium\";a:4:{s:4:\"file\";s:27:\"girl-311628_640-284x300.png\";s:5:\"width\";i:284;s:6:\"height\";i:300;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
	(19,23,'_wp_attached_file','2019/08/thumb-photostock-vector-portrait-of-a-curious-woman-surprised-face-vector-illustration.jpg'),
	(20,23,'_wp_attachment_metadata','a:5:{s:5:\"width\";i:300;s:6:\"height\";i:300;s:4:\"file\";s:98:\"2019/08/thumb-photostock-vector-portrait-of-a-curious-woman-surprised-face-vector-illustration.jpg\";s:5:\"sizes\";a:1:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:98:\"thumb-photostock-vector-portrait-of-a-curious-woman-surprised-face-vector-illustration-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
	(21,24,'_wp_attached_file','2019/08/man-814171_960_720.jpg'),
	(22,24,'_wp_attachment_metadata','a:5:{s:5:\"width\";i:479;s:6:\"height\";i:720;s:4:\"file\";s:30:\"2019/08/man-814171_960_720.jpg\";s:5:\"sizes\";a:2:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:30:\"man-814171_960_720-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:6:\"medium\";a:4:{s:4:\"file\";s:30:\"man-814171_960_720-200x300.jpg\";s:5:\"width\";i:200;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
	(23,25,'_wp_attached_file','2019/08/denny3.jpg'),
	(24,25,'_wp_attachment_metadata','a:5:{s:5:\"width\";i:650;s:6:\"height\";i:651;s:4:\"file\";s:18:\"2019/08/denny3.jpg\";s:5:\"sizes\";a:2:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:18:\"denny3-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:6:\"medium\";a:4:{s:4:\"file\";s:18:\"denny3-300x300.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
	(25,12,'_edit_lock','1567654823:1'),
	(26,27,'_wp_attached_file','2019/09/images.jpeg'),
	(27,27,'_wp_attachment_metadata','a:5:{s:5:\"width\";i:225;s:6:\"height\";i:225;s:4:\"file\";s:19:\"2019/09/images.jpeg\";s:5:\"sizes\";a:1:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:19:\"images-150x150.jpeg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
	(28,28,'_wp_attached_file','2019/09/coverletter-asaquzzaman.docx'),
	(29,29,'_wp_attached_file','2019/09/ASAQUZZAMAN.jpg'),
	(30,29,'_wp_attachment_metadata','a:5:{s:5:\"width\";i:350;s:6:\"height\";i:439;s:4:\"file\";s:23:\"2019/09/ASAQUZZAMAN.jpg\";s:5:\"sizes\";a:2:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:23:\"ASAQUZZAMAN-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:6:\"medium\";a:4:{s:4:\"file\";s:23:\"ASAQUZZAMAN-239x300.jpg\";s:5:\"width\";i:239;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:2:\"10\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:15:\"Canon EOS 1100D\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:10:\"1540647458\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:2:\"50\";s:3:\"iso\";s:3:\"100\";s:13:\"shutter_speed\";s:6:\"0.0125\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"1\";s:8:\"keywords\";a:0:{}}}');

/*!40000 ALTER TABLE `wp_postmeta` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_posts`;

CREATE TABLE `wp_posts` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_title` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_excerpt` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `to_ping` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `pinged` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`(191)),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

LOCK TABLES `wp_posts` WRITE;
/*!40000 ALTER TABLE `wp_posts` DISABLE KEYS */;

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`)
VALUES
	(1,1,'2019-07-03 13:32:39','2019-07-03 13:32:39','<!-- wp:paragraph -->\n<p>Welcome to WordPress. This is your first post. Edit or delete it, then start writing!</p>\n<!-- /wp:paragraph -->','Hello world!','','publish','open','open','','hello-world','','','2019-07-03 13:32:39','2019-07-03 13:32:39','',0,'http://localhost/hrm/?p=1',0,'post','',1),
	(2,1,'2019-07-03 13:32:39','2019-07-03 13:32:39','<!-- wp:paragraph -->\n<p>This is an example page. It\'s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>Hi there! I\'m a bike messenger by day, aspiring actor by night, and this is my website. I live in Los Angeles, have a great dog named Jack, and I like pi&#241;a coladas. (And gettin\' caught in the rain.)</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>...or something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>As a new WordPress user, you should go to <a href=\"http://localhost/hrm/wp-admin/\">your dashboard</a> to delete this page and create new pages for your content. Have fun!</p>\n<!-- /wp:paragraph -->','Sample Page','','publish','closed','open','','sample-page','','','2019-07-03 13:32:39','2019-07-03 13:32:39','',0,'http://localhost/hrm/?page_id=2',0,'page','',0),
	(3,1,'2019-07-03 13:32:39','2019-07-03 13:32:39','<!-- wp:heading --><h2>Who we are</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Our website address is: http://localhost/hrm.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>What personal data we collect and why we collect it</h2><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>Comments</h3><!-- /wp:heading --><!-- wp:paragraph --><p>When visitors leave comments on the site we collect the data shown in the comments form, and also the visitor&#8217;s IP address and browser user agent string to help spam detection.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>An anonymized string created from your email address (also called a hash) may be provided to the Gravatar service to see if you are using it. The Gravatar service privacy policy is available here: https://automattic.com/privacy/. After approval of your comment, your profile picture is visible to the public in the context of your comment.</p><!-- /wp:paragraph --><!-- wp:heading {\"level\":3} --><h3>Media</h3><!-- /wp:heading --><!-- wp:paragraph --><p>If you upload images to the website, you should avoid uploading images with embedded location data (EXIF GPS) included. Visitors to the website can download and extract any location data from images on the website.</p><!-- /wp:paragraph --><!-- wp:heading {\"level\":3} --><h3>Contact forms</h3><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>Cookies</h3><!-- /wp:heading --><!-- wp:paragraph --><p>If you leave a comment on our site you may opt-in to saving your name, email address and website in cookies. These are for your convenience so that you do not have to fill in your details again when you leave another comment. These cookies will last for one year.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>If you have an account and you log in to this site, we will set a temporary cookie to determine if your browser accepts cookies. This cookie contains no personal data and is discarded when you close your browser.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>When you log in, we will also set up several cookies to save your login information and your screen display choices. Login cookies last for two days, and screen options cookies last for a year. If you select &quot;Remember Me&quot;, your login will persist for two weeks. If you log out of your account, the login cookies will be removed.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>If you edit or publish an article, an additional cookie will be saved in your browser. This cookie includes no personal data and simply indicates the post ID of the article you just edited. It expires after 1 day.</p><!-- /wp:paragraph --><!-- wp:heading {\"level\":3} --><h3>Embedded content from other websites</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Articles on this site may include embedded content (e.g. videos, images, articles, etc.). Embedded content from other websites behaves in the exact same way as if the visitor has visited the other website.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>These websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with that embedded content, including tracking your interaction with the embedded content if you have an account and are logged in to that website.</p><!-- /wp:paragraph --><!-- wp:heading {\"level\":3} --><h3>Analytics</h3><!-- /wp:heading --><!-- wp:heading --><h2>Who we share your data with</h2><!-- /wp:heading --><!-- wp:heading --><h2>How long we retain your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p>If you leave a comment, the comment and its metadata are retained indefinitely. This is so we can recognize and approve any follow-up comments automatically instead of holding them in a moderation queue.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>For users that register on our website (if any), we also store the personal information they provide in their user profile. All users can see, edit, or delete their personal information at any time (except they cannot change their username). Website administrators can also see and edit that information.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>What rights you have over your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p>If you have an account on this site, or have left comments, you can request to receive an exported file of the personal data we hold about you, including any data you have provided to us. You can also request that we erase any personal data we hold about you. This does not include any data we are obliged to keep for administrative, legal, or security purposes.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Where we send your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Visitor comments may be checked through an automated spam detection service.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Your contact information</h2><!-- /wp:heading --><!-- wp:heading --><h2>Additional information</h2><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>How we protect your data</h3><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>What data breach procedures we have in place</h3><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>What third parties we receive data from</h3><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>What automated decision making and/or profiling we do with user data</h3><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>Industry regulatory disclosure requirements</h3><!-- /wp:heading -->','Privacy Policy','','draft','closed','open','','privacy-policy','','','2019-07-03 13:32:39','2019-07-03 13:32:39','',0,'http://localhost/hrm/?page_id=3',0,'page','',0),
	(5,1,'2019-07-03 15:26:44','2019-07-03 15:26:44','[wpSpear_hrm]','HRM','','publish','closed','closed','','hrm','','','2019-07-03 15:26:44','2019-07-03 15:26:44','',0,'http://localhost/hrm/hrm/',0,'page','',0),
	(6,1,'2019-07-03 16:01:32','2019-07-03 16:01:32','','rakib','','inherit','open','closed','','rakib','','','2019-07-03 16:01:32','2019-07-03 16:01:32','',0,'http://localhost/hrm/rakib/',0,'attachment','image/jpeg',0),
	(8,1,'2019-07-27 13:53:37','2019-07-27 13:53:37','[wpup_members]','User Lists','','publish','closed','closed','','members','','','2019-07-27 13:53:37','2019-07-27 13:53:37','',0,'http://localhost/hrm/members/',0,'page','',0),
	(9,1,'2019-07-27 13:53:37','2019-07-27 13:53:37','[wpup_my_profile]','My Profile','','publish','closed','closed','','my-profile','','','2019-07-27 13:53:37','2019-07-27 13:53:37','',0,'http://localhost/hrm/my-profile/',0,'page','',0),
	(10,1,'2019-07-27 14:19:04','2019-07-27 14:19:04','Description','User Profile','','publish','open','closed','','user-profile','','','2019-07-27 14:19:04','2019-07-27 14:19:04','',0,'http://localhost/hrm/wpup_user_profile/user-profile/',0,'wpup_user_profile','',0),
	(12,1,'2019-08-13 05:19:34','2019-08-13 05:19:34','[hrm-recruitment]','Recruitment','','publish','close','close','','recruitment','','','2019-08-13 05:19:34','2019-08-13 05:19:34','',0,'http://localhost/hrm/recruitment/',0,'page','',0),
	(14,1,'2019-08-31 04:14:34','2019-08-31 04:14:34','','wphr Subscription','','publish','closed','closed','','wphr-subscription','','','2019-08-31 04:14:34','2019-08-31 04:14:34','',0,'http://localhost/hrm/wphr-subscription/',0,'page','',0),
	(15,1,'2019-08-31 04:14:35','2019-08-31 04:14:35','[wp-hr-employee-list]','Employee List','','publish','closed','closed','','employee-list','','','2019-08-31 04:14:35','2019-08-31 04:14:35','',0,'http://localhost/hrm/employee-list/',0,'page','',0),
	(16,1,'2019-08-31 04:14:35','2019-08-31 04:14:35','[wp-hr-employee-profile]','Employee profile','','publish','closed','closed','','employee-profile','','','2019-08-31 04:14:35','2019-08-31 04:14:35','',0,'http://localhost/hrm/employee-profile/',0,'page','',0),
	(17,1,'2019-08-31 04:14:35','2019-08-31 04:14:35','[wp-hr-dashboard]','Dashboard','','publish','closed','closed','','dashboard','','','2019-08-31 04:14:35','2019-08-31 04:14:35','',0,'http://localhost/hrm/dashboard/',0,'page','',0),
	(18,1,'2019-08-31 04:14:35','2019-08-31 04:14:35','[wp-hr-my-profile]','My Profile','','publish','closed','closed','','my-profile-2','','','2019-08-31 04:14:35','2019-08-31 04:14:35','',0,'http://localhost/hrm/my-profile-2/',0,'page','',0),
	(19,1,'2019-08-31 04:30:19','0000-00-00 00:00:00','<!-- wp:cover {\"url\":\"https://cldup.com/Fz-ASbo2s3.jpg\",\"className\":\"alignwide\"} -->\n<div class=\"wp-block-cover has-background-dim alignwide\" style=\"background-image:url(https://cldup.com/Fz-ASbo2s3.jpg)\"><div class=\"wp-block-cover__inner-container\"><!-- wp:paragraph {\"align\":\"center\",\"placeholder\":\"Write title…\",\"fontSize\":\"large\"} -->\n<p style=\"text-align:center\" class=\"has-large-font-size\">Of Mountains &amp; Printing Presses</p>\n<!-- /wp:paragraph --></div></div>\n<!-- /wp:cover -->\n\n<!-- wp:paragraph -->\n<p>The goal of this new editor is to make adding rich content to WordPress simple and enjoyable. This whole post is composed of <em>pieces of content</em>—somewhat similar to LEGO bricks—that you can move around and interact with. Move your cursor around and you’ll notice the different blocks light up with outlines and arrows. Press the arrows to reposition blocks quickly, without fearing about losing things in the process of copying and pasting.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>What you are reading now is a <strong>text block</strong> the most basic block of all. The text block has its own controls to be moved freely around the post...</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph {\"align\":\"right\"} -->\n<p style=\"text-align:right\">... like this one, which is right aligned.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Headings are separate blocks as well, which helps with the outline and organization of your content.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading -->\n<h2>A Picture is Worth a Thousand Words</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Handling images and media with the utmost care is a primary focus of the new editor. Hopefully, you’ll find aspects of adding captions or going full-width with your pictures much easier and robust than before.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image {\"align\":\"center\"} -->\n<div class=\"wp-block-image\"><figure class=\"aligncenter\"><img src=\"https://cldup.com/cXyG__fTLN.jpg\" alt=\"Beautiful landscape\"/><figcaption>If your theme supports it, you’ll see the \"wide\" button on the image toolbar. Give it a try.</figcaption></figure></div>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Try selecting and removing or editing the caption, now you don’t have to be careful about selecting the image or other text by mistake and ruining the presentation.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading -->\n<h2>The <em>Inserter</em> Tool</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Imagine everything that WordPress can do is available to you quickly and in the same place on the interface. No need to figure out HTML tags, classes, or remember complicated shortcode syntax. That’s the spirit behind the inserter—the <code>(+)</code> button you’ll see around the editor—which allows you to browse all available content blocks and add them into your post. Plugins and themes are able to register their own, opening up all sort of possibilities for rich editing and publishing.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Go give it a try, you may discover things WordPress can already add into your posts that you didn’t know about. Here’s a short list of what you can currently find there:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:group -->\n<div class=\"wp-block-group\"><div class=\"wp-block-group__inner-container\"><!-- wp:paragraph {\"align\":\"left\"} -->\n<p style=\"text-align:left\">A huge benefit of blocks is that you can edit them in place and manipulate your content directly. Instead of having fields for editing things like the source of a quote, or the text of a button, you can directly change the content. Try editing the following quote:</p>\n<!-- /wp:paragraph --></div></div>\n<!-- /wp:group -->\n\n<!-- wp:heading -->\n<h2>Visual Editing</h2>\n<!-- /wp:heading -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>The editor will endeavor to create a new page and post building experience that makes writing rich posts effortless, and has “blocks” to make it easy what today might take shortcodes, custom HTML, or “mystery meat” embed discovery.</p><cite>Matt Mullenweg, 2017</cite></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>The information corresponding to the source of the quote is a separate text field, similar to captions under images, so the structure of the quote is protected even if you select, modify, or remove the source. It’s always easy to add it back.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Blocks can be anything you need. For instance, you may want to add a subdued quote as part of the composition of your text, or you may prefer to display a giant stylized one. All of these options are available in the inserter.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:gallery {\"ids\":[null,null,null],\"columns\":2} -->\n<ul class=\"wp-block-gallery columns-2 is-cropped\"><li class=\"blocks-gallery-item\"><figure><img src=\"https://cldup.com/n0g6ME5VKC.jpg\" alt=\"\"/></figure></li><li class=\"blocks-gallery-item\"><figure><img src=\"https://cldup.com/ZjESfxPI3R.jpg\" alt=\"\"/></figure></li><li class=\"blocks-gallery-item\"><figure><img src=\"https://cldup.com/EKNF8xD2UM.jpg\" alt=\"\"/></figure></li></ul>\n<!-- /wp:gallery -->\n\n<!-- wp:paragraph -->\n<p>You can change the amount of columns in your galleries by dragging a slider in the block inspector in the sidebar.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading -->\n<h2>Media Rich</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>If you combine the new <strong>wide</strong> and <strong>full-wide</strong> alignments with galleries, you can create a very media rich layout, very quickly:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image {\"align\":\"full\"} -->\n<figure class=\"wp-block-image alignfull\"><img src=\"https://cldup.com/8lhI-gKnI2.jpg\" alt=\"Accessibility is important — don’t forget image alt attribute\"/></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Sure, the full-wide image can be pretty big. But sometimes the image is worth it.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:gallery {\"ids\":[null,null],\"className\":\"alignwide\"} -->\n<ul class=\"wp-block-gallery columns-2 is-cropped alignwide\"><li class=\"blocks-gallery-item\"><figure><img src=\"https://cldup.com/_rSwtEeDGD.jpg\" alt=\"\"/></figure></li><li class=\"blocks-gallery-item\"><figure><img src=\"https://cldup.com/L-cC3qX2DN.jpg\" alt=\"\"/></figure></li></ul>\n<!-- /wp:gallery -->\n\n<!-- wp:paragraph -->\n<p>The above is a gallery with just two images. It’s an easier way to create visually appealing layouts, without having to deal with floats. You can also easily convert the gallery back to individual images again, by using the block switcher.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Any block can opt into these alignments. The embed block has them also, and is responsive out of the box:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:core-embed/vimeo {\"url\":\"https://vimeo.com/22439234\",\"type\":\"video\",\"providerNameSlug\":\"vimeo\",\"align\":\"wide\",\"className\":\"wp-has-aspect-ratio wp-embed-aspect-16-9\"} -->\n<figure class=\"wp-block-embed-vimeo alignwide wp-block-embed is-type-video is-provider-vimeo wp-has-aspect-ratio wp-embed-aspect-16-9\"><div class=\"wp-block-embed__wrapper\">\nhttps://vimeo.com/22439234\n</div></figure>\n<!-- /wp:core-embed/vimeo -->\n\n<!-- wp:paragraph -->\n<p>You can build any block you like, static or dynamic, decorative or plain. Here’s a pullquote block:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:pullquote -->\n<figure class=\"wp-block-pullquote\"><blockquote><p>Code is Poetry</p><cite>The WordPress community</cite></blockquote></figure>\n<!-- /wp:pullquote -->\n\n<!-- wp:paragraph {\"align\":\"center\"} -->\n<p style=\"text-align:center\">\n	<em>\n		If you want to learn more about how to build additional blocks, or if you are interested in helping with the project, head over to the <a href=\"https://github.com/WordPress/gutenberg\">GitHub repository</a>.	</em>\n</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:button {\"align\":\"center\"} -->\n<div class=\"wp-block-button aligncenter\"><a class=\"wp-block-button__link\" href=\"https://github.com/WordPress/gutenberg\">Help build Gutenberg</a></div>\n<!-- /wp:button -->\n\n<!-- wp:separator -->\n<hr class=\"wp-block-separator\"/>\n<!-- /wp:separator -->\n\n<!-- wp:paragraph {\"align\":\"center\"} -->\n<p style=\"text-align:center\">Thanks for testing Gutenberg!</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph {\"align\":\"center\"} -->\n<p style=\"text-align:center\">?</p>\n<!-- /wp:paragraph -->','Welcome to the Gutenberg Editor','','draft','open','open','','','','','2019-08-31 04:30:19','2019-08-31 04:30:19','',0,'http://localhost/hrm/?p=19',0,'post','',0),
	(21,1,'2019-08-31 08:35:08','2019-08-31 08:35:08','','images','','inherit','open','closed','','images','','','2019-08-31 08:35:08','2019-08-31 08:35:08','',0,'http://localhost/hrm/images/',0,'attachment','image/jpeg',0),
	(22,1,'2019-08-31 16:52:17','2019-08-31 16:52:17','','girl-311628_640','','inherit','open','closed','','girl-311628_640','','','2019-08-31 16:52:17','2019-08-31 16:52:17','',0,'http://localhost/hrm/girl-311628_640/',0,'attachment','image/png',0),
	(23,1,'2019-08-31 16:53:22','2019-08-31 16:53:22','','thumb-photostock-vector-portrait-of-a-curious-woman-surprised-face-vector-illustration','','inherit','open','closed','','thumb-photostock-vector-portrait-of-a-curious-woman-surprised-face-vector-illustration','','','2019-08-31 16:53:22','2019-08-31 16:53:22','',0,'http://localhost/hrm/thumb-photostock-vector-portrait-of-a-curious-woman-surprised-face-vector-illustration/',0,'attachment','image/jpeg',0),
	(24,1,'2019-08-31 16:55:58','2019-08-31 16:55:58','','man-814171_960_720','','inherit','open','closed','','man-814171_960_720','','','2019-08-31 16:55:58','2019-08-31 16:55:58','',0,'http://localhost/hrm/man-814171_960_720/',0,'attachment','image/jpeg',0),
	(25,1,'2019-08-31 17:15:17','2019-08-31 17:15:17','','denny3','','inherit','open','closed','','denny3','','','2019-08-31 17:15:17','2019-08-31 17:15:17','',0,'http://localhost/hrm/denny3/',0,'attachment','image/jpeg',0),
	(26,1,'2019-09-21 05:29:22','0000-00-00 00:00:00','','Auto Draft','','auto-draft','open','open','','','','','2019-09-21 05:29:22','0000-00-00 00:00:00','',0,'http://localhost/hrm/?p=26',0,'post','',0),
	(27,1,'2019-09-21 09:20:12','2019-09-21 09:20:12','','images','','inherit','open','closed','','images-2','','','2019-09-21 09:20:12','2019-09-21 09:20:12','',0,'http://localhost/hrm/images-2/',0,'attachment','image/jpeg',0),
	(28,1,'2019-09-23 14:53:52','2019-09-23 14:53:52','','coverletter-asaquzzaman','','inherit','open','closed','','coverletter-asaquzzaman','','','2019-09-23 14:53:52','2019-09-23 14:53:52','',0,'http://localhost/hrm/coverletter-asaquzzaman/',0,'attachment','application/vnd.openxmlformats-officedocument.wordprocessingml.document',0),
	(29,1,'2019-09-23 14:53:52','2019-09-23 14:53:52','','ASAQUZZAMAN','','inherit','open','closed','','asaquzzaman','','','2019-09-23 14:53:52','2019-09-23 14:53:52','',0,'http://localhost/hrm/asaquzzaman/',0,'attachment','image/jpeg',0);

/*!40000 ALTER TABLE `wp_posts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_term_relationships
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_term_relationships`;

CREATE TABLE `wp_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

LOCK TABLES `wp_term_relationships` WRITE;
/*!40000 ALTER TABLE `wp_term_relationships` DISABLE KEYS */;

INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`)
VALUES
	(1,1,0),
	(19,1,0);

/*!40000 ALTER TABLE `wp_term_relationships` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_term_taxonomy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_term_taxonomy`;

CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

LOCK TABLES `wp_term_taxonomy` WRITE;
/*!40000 ALTER TABLE `wp_term_taxonomy` DISABLE KEYS */;

INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`)
VALUES
	(1,1,'category','',0,1),
	(2,2,'product_type','',0,0),
	(3,3,'product_type','',0,0),
	(4,4,'product_type','',0,0),
	(5,5,'product_type','',0,0),
	(6,6,'product_visibility','',0,0),
	(7,7,'product_visibility','',0,0),
	(8,8,'product_visibility','',0,0),
	(9,9,'product_visibility','',0,0),
	(10,10,'product_visibility','',0,0),
	(11,11,'product_visibility','',0,0),
	(12,12,'product_visibility','',0,0),
	(13,13,'product_visibility','',0,0),
	(14,14,'product_visibility','',0,0),
	(15,15,'product_cat','',0,0);

/*!40000 ALTER TABLE `wp_term_taxonomy` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_termmeta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_termmeta`;

CREATE TABLE `wp_termmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `term_id` (`term_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_terms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_terms`;

CREATE TABLE `wp_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  KEY `slug` (`slug`(191)),
  KEY `name` (`name`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

LOCK TABLES `wp_terms` WRITE;
/*!40000 ALTER TABLE `wp_terms` DISABLE KEYS */;

INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`)
VALUES
	(1,'Uncategorized','uncategorized',0),
	(2,'simple','simple',0),
	(3,'grouped','grouped',0),
	(4,'variable','variable',0),
	(5,'external','external',0),
	(6,'exclude-from-search','exclude-from-search',0),
	(7,'exclude-from-catalog','exclude-from-catalog',0),
	(8,'featured','featured',0),
	(9,'outofstock','outofstock',0),
	(10,'rated-1','rated-1',0),
	(11,'rated-2','rated-2',0),
	(12,'rated-3','rated-3',0),
	(13,'rated-4','rated-4',0),
	(14,'rated-5','rated-5',0),
	(15,'Uncategorized','uncategorized',0);

/*!40000 ALTER TABLE `wp_terms` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_usermeta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_usermeta`;

CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

LOCK TABLES `wp_usermeta` WRITE;
/*!40000 ALTER TABLE `wp_usermeta` DISABLE KEYS */;

INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`)
VALUES
	(1,1,'nickname','admin'),
	(2,1,'first_name','Asaquzzaman'),
	(3,1,'last_name','Mishu'),
	(4,1,'description',''),
	(5,1,'rich_editing','true'),
	(6,1,'syntax_highlighting','true'),
	(7,1,'comment_shortcuts','false'),
	(8,1,'admin_color','fresh'),
	(9,1,'use_ssl','0'),
	(10,1,'show_admin_bar_front','true'),
	(11,1,'locale',''),
	(12,1,'wp_capabilities','a:2:{s:13:\"administrator\";b:1;s:11:\"hrm_manager\";b:1;}'),
	(13,1,'wp_user_level','10'),
	(14,1,'dismissed_wp_pointers','wp496_privacy'),
	(15,1,'show_welcome_panel','1'),
	(17,1,'wp_dashboard_quick_press_last_post_id','26'),
	(18,2,'nickname','Employee'),
	(19,2,'first_name','Employee'),
	(20,2,'last_name','Employee'),
	(21,2,'description',''),
	(22,2,'rich_editing','true'),
	(23,2,'syntax_highlighting','true'),
	(24,2,'comment_shortcuts','false'),
	(25,2,'admin_color','fresh'),
	(26,2,'use_ssl','0'),
	(27,2,'show_admin_bar_front','true'),
	(28,2,'locale',''),
	(29,2,'wp_capabilities','a:1:{s:12:\"hrm_employee\";b:1;}'),
	(30,2,'wp_user_level','0'),
	(31,2,'dismissed_wp_pointers',''),
	(32,2,'hrm_job_category','1'),
	(33,2,'hrm_location','1'),
	(34,2,'hrm_job_desc',''),
	(35,2,'hrm_status','1'),
	(36,2,'hrm_mob_number','+8801716644810'),
	(37,2,'hrm_joined_date','2019-07-01 00:00:00'),
	(38,2,'hrm_gender','1'),
	(39,2,'hrm_role','hrm_employee'),
	(40,2,'hrm_designation','4'),
	(41,2,'hrm_user_image_id','6'),
	(108,5,'nickname','female'),
	(109,5,'first_name','W. Zapata'),
	(110,5,'last_name','Rosalinda'),
	(111,5,'description',''),
	(112,5,'rich_editing','true'),
	(113,5,'syntax_highlighting','true'),
	(114,5,'comment_shortcuts','false'),
	(115,5,'admin_color','fresh'),
	(116,5,'use_ssl','0'),
	(117,5,'show_admin_bar_front','true'),
	(118,5,'locale',''),
	(119,5,'wp_capabilities','a:1:{s:12:\"hrm_employee\";b:1;}'),
	(120,5,'wp_user_level','0'),
	(121,5,'dismissed_wp_pointers',''),
	(122,5,'hrm_job_category','1'),
	(123,5,'hrm_location',''),
	(124,5,'hrm_job_desc',''),
	(125,5,'hrm_status','1'),
	(126,5,'hrm_mob_number',''),
	(127,5,'hrm_joined_date','2019-08-31 00:00:00'),
	(128,5,'hrm_gender','2'),
	(129,5,'hrm_role','hrm_employee'),
	(130,5,'hrm_designation','2'),
	(131,5,'hrm_user_image_id','22'),
	(132,6,'nickname','female2'),
	(133,6,'first_name','H. Ring'),
	(134,6,'last_name','Mary'),
	(135,6,'description',''),
	(136,6,'rich_editing','true'),
	(137,6,'syntax_highlighting','true'),
	(138,6,'comment_shortcuts','false'),
	(139,6,'admin_color','fresh'),
	(140,6,'use_ssl','0'),
	(141,6,'show_admin_bar_front','true'),
	(142,6,'locale',''),
	(143,6,'wp_capabilities','a:1:{s:12:\"hrm_employee\";b:1;}'),
	(144,6,'wp_user_level','0'),
	(145,6,'dismissed_wp_pointers',''),
	(146,6,'hrm_job_category','2'),
	(147,6,'hrm_location','1'),
	(148,6,'hrm_job_desc',''),
	(149,6,'hrm_status','1'),
	(150,6,'hrm_mob_number',''),
	(151,6,'hrm_joined_date','2019-08-31 00:00:00'),
	(152,6,'hrm_gender','2'),
	(153,6,'hrm_role','hrm_employee'),
	(154,6,'hrm_designation','2'),
	(155,6,'hrm_user_image_id','23'),
	(178,6,'_marital_status',''),
	(179,6,'_national_code',''),
	(180,6,'_birthday','2019-08-31'),
	(181,6,'_street1',''),
	(182,6,'_street2',''),
	(183,6,'_city_code',''),
	(184,6,'_state',''),
	(185,6,'_zip',''),
	(186,6,'_work_mobile',''),
	(187,6,'_country_code',''),
	(188,6,'user_id','6'),
	(189,6,'action',NULL),
	(190,6,'deleted_files',NULL),
	(191,6,'is_multiple_file',''),
	(192,6,'_wpnonce',NULL),
	(197,1,'_woocommerce_persistent_cart_1','a:1:{s:4:\"cart\";a:0:{}}'),
	(198,1,'wc_last_active','1567987200'),
	(200,1,'billing_first_name',''),
	(201,1,'billing_last_name',''),
	(202,1,'billing_company',''),
	(203,1,'billing_address_1',''),
	(204,1,'billing_address_2',''),
	(205,1,'billing_city',''),
	(206,1,'billing_postcode',''),
	(207,1,'billing_country',''),
	(208,1,'billing_state',''),
	(209,1,'billing_phone',''),
	(210,1,'billing_email','joy.mishu@gmail.com'),
	(211,1,'shipping_first_name',''),
	(212,1,'shipping_last_name',''),
	(213,1,'shipping_company',''),
	(214,1,'shipping_address_1',''),
	(215,1,'shipping_address_2',''),
	(216,1,'shipping_city',''),
	(217,1,'shipping_postcode',''),
	(218,1,'shipping_country',''),
	(219,1,'shipping_state',''),
	(220,1,'last_update','1568069021'),
	(221,1,'dismissed_wootenberg_notice','1'),
	(222,1,'dismissed_no_secure_connection_notice','1'),
	(223,1,'dismissed_install_notice','1'),
	(224,2,'session_tokens','a:1:{s:64:\"240ef0c3942405743677de876c1362af83ada7400d6272d1662e9782fcc6454e\";a:4:{s:10:\"expiration\";i:1569407987;s:2:\"ip\";s:3:\"::1\";s:2:\"ua\";s:121:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36\";s:5:\"login\";i:1569235187;}}'),
	(225,2,'wc_last_active','1568073600'),
	(227,2,'_woocommerce_persistent_cart_1','a:1:{s:4:\"cart\";a:0:{}}'),
	(228,1,'session_tokens','a:1:{s:64:\"bbaafdb985edf4448ee6767674a7d019e14976bebcb737834bff8f9e94f0c43f\";a:4:{s:10:\"expiration\";i:1569640759;s:2:\"ip\";s:3:\"::1\";s:2:\"ua\";s:120:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36\";s:5:\"login\";i:1569467959;}}'),
	(229,1,'hrm_job_category','3'),
	(230,1,'hrm_location','3'),
	(231,1,'hrm_job_desc','kjhkjhjk'),
	(232,1,'hrm_status','1'),
	(233,1,'hrm_mob_number','+8801716644810'),
	(234,1,'hrm_joined_date','2019-09-21 00:00:00'),
	(235,1,'hrm_gender','1'),
	(236,1,'hrm_role','hrm_manager'),
	(237,1,'hrm_designation','2'),
	(238,7,'nickname','rakib'),
	(239,7,'first_name','Rakibul'),
	(240,7,'last_name','Hassan'),
	(241,7,'description',''),
	(242,7,'rich_editing','true'),
	(243,7,'syntax_highlighting','true'),
	(244,7,'comment_shortcuts','false'),
	(245,7,'admin_color','fresh'),
	(246,7,'use_ssl','0'),
	(247,7,'show_admin_bar_front','true'),
	(248,7,'locale',''),
	(249,7,'wp_capabilities','a:1:{s:12:\"hrm_employee\";b:1;}'),
	(250,7,'wp_user_level','0'),
	(251,7,'dismissed_wp_pointers',''),
	(252,7,'hrm_job_category','2'),
	(253,7,'hrm_location','3'),
	(254,7,'hrm_job_desc','asdfasdf'),
	(255,7,'hrm_status','1'),
	(256,7,'hrm_mob_number','+8801716644810'),
	(257,7,'hrm_joined_date','2019-09-21 00:00:00'),
	(258,7,'hrm_gender','1'),
	(259,7,'hrm_role','hrm_employee'),
	(260,7,'hrm_designation','2'),
	(261,7,'hrm_user_image_id','27'),
	(262,1,'is_multiple_file',''),
	(263,1,'deleted_files',NULL);

/*!40000 ALTER TABLE `wp_usermeta` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_users`;

CREATE TABLE `wp_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`),
  KEY `user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

LOCK TABLES `wp_users` WRITE;
/*!40000 ALTER TABLE `wp_users` DISABLE KEYS */;

INSERT INTO `wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`)
VALUES
	(1,'admin','$P$BdZMB4ra0eNx7Dmdg6GKRuKOFbXq2Z1','admin','joy.mishu@gmail.com','','2019-07-03 13:32:39','',0,'Asaquzzaman Mishu'),
	(2,'employee','$P$BCE9iIOBojg8IJ9Q21wQClgoRfS1hZ/','employee','mishu@gmail.com','','2019-07-03 16:01:32','1562169692:$P$BSvsUgVuhunZWu2cbBCIzTju8TP5Xs.',0,'Employee Employee'),
	(5,'female','$P$BRYeytTiARuzkuQhhDU0G5kwsru01D0','female','female@mihubd.com','','2019-08-31 16:52:17','1567270338:$P$BUd/g3.1D9YNGxZEjyW6VgesZZmqdY0',0,'W. Zapata Rosalinda'),
	(6,'female2','$P$BoVJSLL9vQwNzD7Od4jnW4cZX8DBZk/','female2','female2@mishubd.com','','2019-08-31 16:53:22','1567270402:$P$BvJ7lpLsbHyJtMtybJrZGNmF.ZTTM..',0,'H. Ring Mary'),
	(7,'rakib','$P$BB3x510m5835SdGD3ixz2E26vrdibW/','rakib','rakib@gmail.com','','2019-09-21 09:20:12','1569057612:$P$BUtruo16Jvr.LqXMLSZxFGS/Zefae60',0,'Rakibul Hassan');

/*!40000 ALTER TABLE `wp_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_wc_download_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wc_download_log`;

CREATE TABLE `wp_wc_download_log` (
  `download_log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` datetime NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `user_ip_address` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT '',
  PRIMARY KEY (`download_log_id`),
  KEY `permission_id` (`permission_id`),
  KEY `timestamp` (`timestamp`),
  CONSTRAINT `fk_wp_wc_download_log_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `wp_woocommerce_downloadable_product_permissions` (`permission_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_wc_webhooks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wc_webhooks`;

CREATE TABLE `wp_wc_webhooks` (
  `webhook_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `name` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `delivery_url` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `secret` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `topic` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_created_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `api_version` smallint(4) NOT NULL,
  `failure_count` smallint(10) NOT NULL DEFAULT '0',
  `pending_delivery` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`webhook_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_woocommerce_api_keys
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_woocommerce_api_keys`;

CREATE TABLE `wp_woocommerce_api_keys` (
  `key_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `permissions` varchar(10) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `consumer_key` char(64) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `consumer_secret` char(43) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `nonces` longtext COLLATE utf8mb4_unicode_520_ci,
  `truncated_key` char(7) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `last_access` datetime DEFAULT NULL,
  PRIMARY KEY (`key_id`),
  KEY `consumer_key` (`consumer_key`),
  KEY `consumer_secret` (`consumer_secret`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_woocommerce_attribute_taxonomies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_woocommerce_attribute_taxonomies`;

CREATE TABLE `wp_woocommerce_attribute_taxonomies` (
  `attribute_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `attribute_label` varchar(200) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `attribute_type` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `attribute_orderby` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `attribute_public` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`attribute_id`),
  KEY `attribute_name` (`attribute_name`(20))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_woocommerce_downloadable_product_permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_woocommerce_downloadable_product_permissions`;

CREATE TABLE `wp_woocommerce_downloadable_product_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `download_id` varchar(36) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `order_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `order_key` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `user_email` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `downloads_remaining` varchar(9) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `access_granted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access_expires` datetime DEFAULT NULL,
  `download_count` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`permission_id`),
  KEY `download_order_key_product` (`product_id`,`order_id`,`order_key`(16),`download_id`),
  KEY `download_order_product` (`download_id`,`order_id`,`product_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_woocommerce_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_woocommerce_log`;

CREATE TABLE `wp_woocommerce_log` (
  `log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` datetime NOT NULL,
  `level` smallint(4) NOT NULL,
  `source` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `context` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`log_id`),
  KEY `level` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_woocommerce_order_itemmeta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_woocommerce_order_itemmeta`;

CREATE TABLE `wp_woocommerce_order_itemmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_item_id` bigint(20) unsigned NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `order_item_id` (`order_item_id`),
  KEY `meta_key` (`meta_key`(32))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_woocommerce_order_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_woocommerce_order_items`;

CREATE TABLE `wp_woocommerce_order_items` (
  `order_item_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_item_name` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `order_item_type` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `order_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`order_item_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_woocommerce_payment_tokenmeta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_woocommerce_payment_tokenmeta`;

CREATE TABLE `wp_woocommerce_payment_tokenmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `payment_token_id` bigint(20) unsigned NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `payment_token_id` (`payment_token_id`),
  KEY `meta_key` (`meta_key`(32))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_woocommerce_payment_tokens
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_woocommerce_payment_tokens`;

CREATE TABLE `wp_woocommerce_payment_tokens` (
  `token_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gateway_id` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `token` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `type` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`token_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_woocommerce_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_woocommerce_sessions`;

CREATE TABLE `wp_woocommerce_sessions` (
  `session_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `session_key` char(32) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `session_value` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `session_expiry` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`session_id`),
  UNIQUE KEY `session_key` (`session_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

LOCK TABLES `wp_woocommerce_sessions` WRITE;
/*!40000 ALTER TABLE `wp_woocommerce_sessions` DISABLE KEYS */;

INSERT INTO `wp_woocommerce_sessions` (`session_id`, `session_key`, `session_value`, `session_expiry`)
VALUES
	(4,'1','a:1:{s:8:\"customer\";s:733:\"a:26:{s:2:\"id\";s:1:\"1\";s:13:\"date_modified\";s:25:\"2019-09-09T22:43:41+00:00\";s:8:\"postcode\";s:0:\"\";s:4:\"city\";s:0:\"\";s:9:\"address_1\";s:0:\"\";s:7:\"address\";s:0:\"\";s:9:\"address_2\";s:0:\"\";s:5:\"state\";s:0:\"\";s:7:\"country\";s:2:\"BD\";s:17:\"shipping_postcode\";s:0:\"\";s:13:\"shipping_city\";s:0:\"\";s:18:\"shipping_address_1\";s:0:\"\";s:16:\"shipping_address\";s:0:\"\";s:18:\"shipping_address_2\";s:0:\"\";s:14:\"shipping_state\";s:0:\"\";s:16:\"shipping_country\";s:2:\"BD\";s:13:\"is_vat_exempt\";s:0:\"\";s:19:\"calculated_shipping\";s:0:\"\";s:10:\"first_name\";s:0:\"\";s:9:\"last_name\";s:0:\"\";s:7:\"company\";s:0:\"\";s:5:\"phone\";s:0:\"\";s:5:\"email\";s:19:\"joy.mishu@gmail.com\";s:19:\"shipping_first_name\";s:0:\"\";s:18:\"shipping_last_name\";s:0:\"\";s:16:\"shipping_company\";s:0:\"\";}\";}',1568263091),
	(5,'2','a:7:{s:4:\"cart\";s:6:\"a:0:{}\";s:11:\"cart_totals\";s:367:\"a:15:{s:8:\"subtotal\";i:0;s:12:\"subtotal_tax\";i:0;s:14:\"shipping_total\";i:0;s:12:\"shipping_tax\";i:0;s:14:\"shipping_taxes\";a:0:{}s:14:\"discount_total\";i:0;s:12:\"discount_tax\";i:0;s:19:\"cart_contents_total\";i:0;s:17:\"cart_contents_tax\";i:0;s:19:\"cart_contents_taxes\";a:0:{}s:9:\"fee_total\";i:0;s:7:\"fee_tax\";i:0;s:9:\"fee_taxes\";a:0:{}s:5:\"total\";i:0;s:9:\"total_tax\";i:0;}\";s:15:\"applied_coupons\";s:6:\"a:0:{}\";s:22:\"coupon_discount_totals\";s:6:\"a:0:{}\";s:26:\"coupon_discount_tax_totals\";s:6:\"a:0:{}\";s:21:\"removed_cart_contents\";s:6:\"a:0:{}\";s:8:\"customer\";s:703:\"a:26:{s:2:\"id\";s:1:\"2\";s:13:\"date_modified\";s:0:\"\";s:8:\"postcode\";s:0:\"\";s:4:\"city\";s:0:\"\";s:9:\"address_1\";s:0:\"\";s:7:\"address\";s:0:\"\";s:9:\"address_2\";s:0:\"\";s:5:\"state\";s:0:\"\";s:7:\"country\";s:2:\"BD\";s:17:\"shipping_postcode\";s:0:\"\";s:13:\"shipping_city\";s:0:\"\";s:18:\"shipping_address_1\";s:0:\"\";s:16:\"shipping_address\";s:0:\"\";s:18:\"shipping_address_2\";s:0:\"\";s:14:\"shipping_state\";s:0:\"\";s:16:\"shipping_country\";s:2:\"BD\";s:13:\"is_vat_exempt\";s:0:\"\";s:19:\"calculated_shipping\";s:0:\"\";s:10:\"first_name\";s:0:\"\";s:9:\"last_name\";s:0:\"\";s:7:\"company\";s:0:\"\";s:5:\"phone\";s:0:\"\";s:5:\"email\";s:15:\"mishu@gmail.com\";s:19:\"shipping_first_name\";s:0:\"\";s:18:\"shipping_last_name\";s:0:\"\";s:16:\"shipping_company\";s:0:\"\";}\";}',1568263099);

/*!40000 ALTER TABLE `wp_woocommerce_sessions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_woocommerce_shipping_zone_locations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_woocommerce_shipping_zone_locations`;

CREATE TABLE `wp_woocommerce_shipping_zone_locations` (
  `location_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `zone_id` bigint(20) unsigned NOT NULL,
  `location_code` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `location_type` varchar(40) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`location_id`),
  KEY `location_id` (`location_id`),
  KEY `location_type_code` (`location_type`(10),`location_code`(20))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_woocommerce_shipping_zone_methods
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_woocommerce_shipping_zone_methods`;

CREATE TABLE `wp_woocommerce_shipping_zone_methods` (
  `zone_id` bigint(20) unsigned NOT NULL,
  `instance_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `method_id` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `method_order` bigint(20) unsigned NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`instance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_woocommerce_shipping_zones
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_woocommerce_shipping_zones`;

CREATE TABLE `wp_woocommerce_shipping_zones` (
  `zone_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `zone_name` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `zone_order` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_woocommerce_tax_rate_locations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_woocommerce_tax_rate_locations`;

CREATE TABLE `wp_woocommerce_tax_rate_locations` (
  `location_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_code` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `tax_rate_id` bigint(20) unsigned NOT NULL,
  `location_type` varchar(40) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`location_id`),
  KEY `tax_rate_id` (`tax_rate_id`),
  KEY `location_type_code` (`location_type`(10),`location_code`(20))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_woocommerce_tax_rates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_woocommerce_tax_rates`;

CREATE TABLE `wp_woocommerce_tax_rates` (
  `tax_rate_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tax_rate_country` varchar(2) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `tax_rate_state` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `tax_rate` varchar(8) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `tax_rate_name` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `tax_rate_priority` bigint(20) unsigned NOT NULL,
  `tax_rate_compound` int(1) NOT NULL DEFAULT '0',
  `tax_rate_shipping` int(1) NOT NULL DEFAULT '1',
  `tax_rate_order` bigint(20) unsigned NOT NULL,
  `tax_rate_class` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`tax_rate_id`),
  KEY `tax_rate_country` (`tax_rate_country`),
  KEY `tax_rate_state` (`tax_rate_state`(2)),
  KEY `tax_rate_class` (`tax_rate_class`(10)),
  KEY `tax_rate_priority` (`tax_rate_priority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_wphr_audit_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_audit_log`;

CREATE TABLE `wp_wphr_audit_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `component` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `sub_component` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `data_id` bigint(20) DEFAULT NULL,
  `old_value` longtext COLLATE utf8mb4_unicode_520_ci,
  `new_value` longtext COLLATE utf8mb4_unicode_520_ci,
  `message` longtext COLLATE utf8mb4_unicode_520_ci,
  `changetype` varchar(10) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

LOCK TABLES `wp_wphr_audit_log` WRITE;
/*!40000 ALTER TABLE `wp_wphr_audit_log` DISABLE KEYS */;

INSERT INTO `wp_wphr_audit_log` (`id`, `component`, `sub_component`, `data_id`, `old_value`, `new_value`, `message`, `changetype`, `created_by`, `created_at`, `updated_at`)
VALUES
	(1,'HRM','department',NULL,'','','<strong>Engineer</strong> department has been created','add',1,'2019-08-31 04:15:27',NULL),
	(2,'HRM','department',NULL,'','','<strong>Support</strong> department has been created','add',1,'2019-08-31 04:15:27',NULL),
	(3,'HRM','designation',NULL,'','','<strong>manager</strong> designation has been created','add',1,'2019-08-31 04:15:42',NULL),
	(4,'HRM','designation',NULL,'','','<strong>developer</strong> designation has been created','add',1,'2019-08-31 04:15:42',NULL);

/*!40000 ALTER TABLE `wp_wphr_audit_log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_wphr_company_locations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_company_locations`;

CREATE TABLE `wp_wphr_company_locations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `address_1` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `address_2` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `country` varchar(5) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `fax` varchar(20) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `office_timezone` varchar(10) COLLATE utf8mb4_unicode_520_ci DEFAULT '0',
  `office_start_time` time DEFAULT NULL,
  `office_end_time` time DEFAULT NULL,
  `office_working_hours` int(2) DEFAULT '9',
  `office_financial_day_start` int(2) DEFAULT '1',
  `office_financial_year_start` int(2) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_wphr_hr_announcement
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_hr_announcement`;

CREATE TABLE `wp_wphr_hr_announcement` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `post_id` bigint(11) NOT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `email_status` varchar(30) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_wphr_hr_dependents
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_hr_dependents`;

CREATE TABLE `wp_wphr_hr_dependents` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `relation` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_wphr_hr_depts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_hr_depts`;

CREATE TABLE `wp_wphr_hr_depts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8mb4_unicode_520_ci,
  `lead` int(11) unsigned DEFAULT '0',
  `parent` int(11) unsigned DEFAULT '0',
  `status` tinyint(1) unsigned DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

LOCK TABLES `wp_wphr_hr_depts` WRITE;
/*!40000 ALTER TABLE `wp_wphr_hr_depts` DISABLE KEYS */;

INSERT INTO `wp_wphr_hr_depts` (`id`, `title`, `description`, `lead`, `parent`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'Engineer','',0,0,1,'2019-08-31 04:15:27','2019-08-31 04:15:27'),
	(2,'Support','',0,0,1,'2019-08-31 04:15:27','2019-08-31 04:15:27');

/*!40000 ALTER TABLE `wp_wphr_hr_depts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_wphr_hr_designations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_hr_designations`;

CREATE TABLE `wp_wphr_hr_designations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8mb4_unicode_520_ci,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

LOCK TABLES `wp_wphr_hr_designations` WRITE;
/*!40000 ALTER TABLE `wp_wphr_hr_designations` DISABLE KEYS */;

INSERT INTO `wp_wphr_hr_designations` (`id`, `title`, `description`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'manager','',1,'2019-08-31 04:15:42','2019-08-31 04:15:42'),
	(2,'developer','',1,'2019-08-31 04:15:42','2019-08-31 04:15:42');

/*!40000 ALTER TABLE `wp_wphr_hr_designations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_wphr_hr_education
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_hr_education`;

CREATE TABLE `wp_wphr_hr_education` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) unsigned DEFAULT NULL,
  `school` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `degree` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `field` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `finished` int(4) unsigned DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_520_ci,
  `interest` text COLLATE utf8mb4_unicode_520_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_wphr_hr_employee_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_hr_employee_history`;

CREATE TABLE `wp_wphr_hr_employee_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `module` varchar(20) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `category` varchar(20) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_520_ci,
  `data` longtext COLLATE utf8mb4_unicode_520_ci,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `module` (`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_wphr_hr_employee_notes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_hr_employee_notes`;

CREATE TABLE `wp_wphr_hr_employee_notes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_by` bigint(20) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_wphr_hr_employee_performance
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_hr_employee_performance`;

CREATE TABLE `wp_wphr_hr_employee_performance` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) unsigned DEFAULT NULL,
  `reporting_to` int(11) unsigned DEFAULT NULL,
  `job_knowledge` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `work_quality` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `attendance` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `communication` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `dependablity` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `reviewer` int(11) unsigned DEFAULT NULL,
  `comments` text COLLATE utf8mb4_unicode_520_ci,
  `completion_date` datetime DEFAULT NULL,
  `goal_description` text COLLATE utf8mb4_unicode_520_ci,
  `employee_assessment` text COLLATE utf8mb4_unicode_520_ci,
  `supervisor` int(11) unsigned DEFAULT NULL,
  `supervisor_assessment` text COLLATE utf8mb4_unicode_520_ci,
  `type` text COLLATE utf8mb4_unicode_520_ci,
  `performance_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_wphr_hr_employees
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_hr_employees`;

CREATE TABLE `wp_wphr_hr_employees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `employee_id` varchar(20) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `designation` int(11) unsigned NOT NULL DEFAULT '0',
  `job_title_detail` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `department` int(11) unsigned NOT NULL DEFAULT '0',
  `location` int(10) unsigned NOT NULL DEFAULT '0',
  `hiring_source` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `hiring_date` date NOT NULL,
  `termination_date` date NOT NULL,
  `date_of_birth` date NOT NULL,
  `reporting_to` bigint(20) unsigned NOT NULL DEFAULT '0',
  `send_mail_to_reporter` varchar(2) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `manage_leave_by_reporter` varchar(2) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `pay_rate` int(11) unsigned NOT NULL DEFAULT '0',
  `pay_type` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `type` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `deleted_at` datetime DEFAULT NULL,
  `leave_year` int(2) DEFAULT '1',
  `apply_leave_year` varchar(2) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_wphr_hr_holiday
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_hr_holiday`;

CREATE TABLE `wp_wphr_hr_holiday` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `range_status` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `location_id` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_wphr_hr_leave_entitlements
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_hr_leave_entitlements`;

CREATE TABLE `wp_wphr_hr_leave_entitlements` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `policy_id` int(11) unsigned DEFAULT NULL,
  `days` mediumint(4) DEFAULT NULL,
  `from_date` datetime NOT NULL,
  `to_date` datetime NOT NULL,
  `comments` text COLLATE utf8mb4_unicode_520_ci,
  `status` tinyint(2) unsigned NOT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_wphr_hr_leave_policies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_hr_leave_policies`;

CREATE TABLE `wp_wphr_hr_leave_policies` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `value` mediumint(5) DEFAULT NULL,
  `color` varchar(7) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `department` int(11) NOT NULL,
  `designation` int(11) NOT NULL,
  `gender` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `marital` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `location` int(3) NOT NULL,
  `effective_date` timestamp NOT NULL,
  `activate` int(2) NOT NULL,
  `execute_day` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_wphr_hr_leave_requests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_hr_leave_requests`;

CREATE TABLE `wp_wphr_hr_leave_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `policy_id` int(11) unsigned NOT NULL,
  `days` tinyint(3) unsigned DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `comments` text COLLATE utf8mb4_unicode_520_ci,
  `reason` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `status` tinyint(2) unsigned DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `last_date` datetime DEFAULT NULL,
  `is_archived` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `policy_id` (`policy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_wphr_hr_leaves
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_hr_leaves`;

CREATE TABLE `wp_wphr_hr_leaves` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `request_id` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `length_hours` decimal(6,2) unsigned NOT NULL,
  `length_days` decimal(6,2) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `duration_type` tinyint(4) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `request_id` (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_wphr_hr_work_exp
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_hr_work_exp`;

CREATE TABLE `wp_wphr_hr_work_exp` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `company_name` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `job_title` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `from` date DEFAULT NULL,
  `to` date DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_520_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_wphr_people_type_relations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_people_type_relations`;

CREATE TABLE `wp_wphr_people_type_relations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `people_id` bigint(20) unsigned DEFAULT NULL,
  `people_types_id` int(11) unsigned DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `people_id` (`people_id`),
  KEY `people_types_id` (`people_types_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_wphr_people_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_people_types`;

CREATE TABLE `wp_wphr_people_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

LOCK TABLES `wp_wphr_people_types` WRITE;
/*!40000 ALTER TABLE `wp_wphr_people_types` DISABLE KEYS */;

INSERT INTO `wp_wphr_people_types` (`id`, `name`)
VALUES
	(2,'company'),
	(1,'contact'),
	(3,'customer'),
	(4,'vendor');

/*!40000 ALTER TABLE `wp_wphr_people_types` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wp_wphr_peoplemeta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_peoplemeta`;

CREATE TABLE `wp_wphr_peoplemeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `wphr_people_id` bigint(20) DEFAULT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `wphr_people_id` (`wphr_people_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



# Dump of table wp_wphr_peoples
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wp_wphr_peoples`;

CREATE TABLE `wp_wphr_peoples` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT '0',
  `first_name` varchar(60) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `last_name` varchar(60) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `company` varchar(60) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `other` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `website` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `fax` varchar(20) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_520_ci,
  `street_1` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `street_2` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `city` varchar(80) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `state` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `postal_code` varchar(10) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `country` varchar(20) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `currency` varchar(5) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
