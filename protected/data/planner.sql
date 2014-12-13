/*
SQLyog Ultimate v8.5 
MySQL - 5.5.16-log : Database - planner
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`planner` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `planner`;

/*Table structure for table `authassignment` */

DROP TABLE IF EXISTS `authassignment`;

CREATE TABLE `authassignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` int(11) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  KEY `FK_authassignment_user` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `authassignment` */

insert  into `authassignment`(`itemname`,`userid`,`bizrule`,`data`) values ('Admin',1,NULL,NULL),('Admin',4,NULL,NULL),('Client',2,NULL,NULL),('Client',3,NULL,NULL);

/*Table structure for table `authitem` */

DROP TABLE IF EXISTS `authitem`;

CREATE TABLE `authitem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `authitem` */

insert  into `authitem`(`name`,`type`,`description`,`bizrule`,`data`) values ('Admin',2,'Admin role to access everything',NULL,NULL),('Client',2,'Can work on modules',NULL,'N;');

/*Table structure for table `authitemchild` */

DROP TABLE IF EXISTS `authitemchild`;

CREATE TABLE `authitemchild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `authitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `authitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `authitemchild` */

/*Table structure for table `global_preferences` */

DROP TABLE IF EXISTS `global_preferences`;

CREATE TABLE `global_preferences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

/*Data for the table `global_preferences` */

insert  into `global_preferences`(`id`,`name`,`value`) values (1,'smtp_host','smtp.mandrillapp.com'),(2,'smtp_auth','true'),(3,'smtp_port','587'),(4,'smtp_secure','TLS'),(5,'smtp_username','ravimadan86@gmail.com'),(6,'smtp_password','3Ep8h9wvdNe5mg9Ukkwugw'),(7,'total_notification_emails_sent',''),(8,'total_notification_sms_sent',''),(9,'total_notification_push_sent',''),(10,'admin_email','ravimadan86@gmail.com'),(11,'admin_name','e-Planner - Admin'),(12,'forgot_password_email_template',''),(13,'new_registration_email_template',''),(14,'invitation_email_template',''),(15,'registration_complete_email_template',''),(16,'forgot_password_sms_template',''),(17,'new_registration_sms_template',''),(18,'invitation_sms_template',''),(19,'registration_complete_sms_template',''),(20,'forgot_password_push_template',''),(21,'new_registration_push_template',''),(22,'invitation_push_template',''),(23,'registration_complete_push_template',''),(24,'user_registration_email_template',''),(25,'user_registration_sms_template',''),(26,'user_registration_push_template',''),(27,'account_created','1'),(28,'password_reset','2'),(29,'password_string_length','10'),(30,'release_added','7'),(31,'site_url','localhost/planner'),(32,'secret_prefix','ap'),(33,'secret_suffix','ta'),(34,'mailgroup_subscribe_email','3');

/*Table structure for table `mailgroups` */

DROP TABLE IF EXISTS `mailgroups`;

CREATE TABLE `mailgroups` (
  `mailgroup_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Mail Group ID',
  `user_id` int(11) NOT NULL COMMENT 'User Id Creating Mail Group',
  `mailgroup_name` varchar(255) NOT NULL COMMENT 'Mail Group Name',
  `subscribe_count` int(11) DEFAULT '0' COMMENT 'Mail Subscribe Person Count',
  `unsubscribe_count` int(11) DEFAULT '0' COMMENT 'Mail group Unsubscribe Count',
  `bounced_count` int(11) DEFAULT '0' COMMENT 'Bounced Count',
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created On',
  PRIMARY KEY (`mailgroup_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `mailgroups` */

insert  into `mailgroups`(`mailgroup_id`,`user_id`,`mailgroup_name`,`subscribe_count`,`unsubscribe_count`,`bounced_count`,`created_on`) values (1,1,'Test Ravi',2,1,0,'2014-04-01 00:16:31'),(2,1,'RaviMailGroup In Index',0,0,0,'2014-04-01 23:22:34'),(3,1,'Test With Mail Group Success Message',1,0,0,'2014-04-01 23:24:12'),(4,1,'Message',0,0,0,'2014-04-01 23:26:47'),(5,1,'Clone Mail Group 3',1,0,0,'2014-04-06 05:16:52');

/*Table structure for table `notification_templates` */

DROP TABLE IF EXISTS `notification_templates`;

CREATE TABLE `notification_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT 'e.g email / push / sms',
  `title` varchar(255) NOT NULL,
  `senders_name` varchar(255) DEFAULT NULL,
  `from` text,
  `subject` text,
  `content` text,
  `inactive` enum('0','1') DEFAULT '0' COMMENT '0 = active, 1 = inactive',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_title_type` (`type`,`title`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `notification_templates` */

insert  into `notification_templates`(`id`,`tag`,`type`,`title`,`senders_name`,`from`,`subject`,`content`,`inactive`) values (1,'1380344379','email','Account Created','e-Planner - Admin','ravimadan86@gmail.com','Welcome To e-Planner - Account Created','<p><strong>Hello {{FirstName}}&nbsp;{{LastName}} ,</strong></p>\r\n<p>Welcome to United Vending!!!</p>\r\n<p>An account with below mentioned credentials has been created for you</p>\r\n<p><strong>Website:</strong> {{BaseUrl}} </p>\r\n<p><strong>Login Id:</strong> {{Email}} </p>\r\n<p><strong>Role:</strong> {{Role}} </p>\r\n<p><strong>Password:</strong> {{Password}} </p>\r\n\r\n<br />\r\n<p><strong>\r\nThanks<br />\r\ne-Planner Admin<br /></strong>\r\n</p>','0'),(2,'1381121279','email','Password Reset Link','e-Planner - Admin','ravimadan86@gmail.com','Welcome To e-Planner - Password Reset Link','<p>Hello {{FirstName}}&nbsp;{{LastName}} ,</p>\r\n<p>Please go through the Password Reset Link to regenerate password for the below mentioned credentials</p>\r\n\r\n<p><strong>Login Id:</strong> {{Email}} </p>\r\n<p><strong>Role:</strong> {{Role}} </p>\r\n\r\n<p><strong>New Password Reset Link:</strong> {{NewPasswordURL}}</p>\r\n\r\n<br /><br />\r\n<p>\r\ne-Planner Admin\r\n</p>','0'),(3,'1381322796','email','New Registration Email','e-Planner - Admin','ravimadan86@gmail.com','e-Planner - Mail Group Subscription','<p><strong>Hello {{FirstName}}&nbsp;{{LastName}} ,</strong></p>\r\n<p>You are not subscribed to below mentioned MailGroup</p>\r\n\r\n<p><strong>Mail Group Name:</strong> {{MailGroupName}} </p>\r\n\r\n<p>Contact administrator to get subscribed to this mailgroup</p>\r\n\r\n<p><strong>\r\nThanks <br />\r\ne-Planner Admin</strong>\r\n</p>','0'),(4,'1381828286','email','Forgot Password','e-Planner - Admin','ravimadan86@gmail.com','e-Planner - Password Reset Link','<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td align=\"right\" valign=\"top\" width=\"50%\">&nbsp;</td>\r\n<td valign=\"top\">\r\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td colspan=\"4\" align=\"right\" width=\"600\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td colspan=\"4\" align=\"left\" valign=\"middle\" width=\"600\" height=\"67\"><img src=\"https://dl.dropboxusercontent.com/u/16106822/eventroller-email-header.png\" alt=\"EventRoller Logo Header\" width=\"605\" height=\"67\" /></td>\r\n</tr>\r\n<tr>\r\n<td colspan=\"4\" align=\"right\" valign=\"top\" width=\"600\" height=\"10\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td colspan=\"4\" align=\"right\" valign=\"top\" width=\"600\" height=\"10\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50\">&nbsp;</td>\r\n<td align=\"left\" valign=\"top\" width=\"400\">\r\n<p>{{EventName}}</p>\r\n<p>{{VenueAddress}}</p>\r\n<div>\r\n<p>{{FirstName}}&nbsp;{{LastName}},</p>\r\n<p>Please reset your password by visiting the following URL</p>\r\n<p>{{NewPasswordURL}}</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n</div>\r\n</td>\r\n<td colspan=\"2\" align=\"left\" valign=\"top\" width=\"150\">\r\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td width=\"10\">&nbsp;</td>\r\n<td colspan=\"2\" align=\"left\" valign=\"top\" width=\"150\">Connect with Us</td>\r\n</tr>\r\n<tr>\r\n<td width=\"10\">&nbsp;</td>\r\n<td align=\"left\" width=\"20\" height=\"16\"><a title=\"Blog\" href=\"http://blog.eventday.com\" target=\"_blank\"><img src=\"https://az118040.vo.msecnd.net/assets/832597db77d5495b9b5bb23f711f2bb3/icon_blog.jpg\" alt=\"\" width=\"16\" height=\"16\" border=\"0\" /></a></td>\r\n<td align=\"left\" valign=\"middle\" width=\"130\" height=\"16\"><a title=\"Blog\" href=\"http://blog.eventroller.com\" target=\"_blank\">Blog</a></td>\r\n</tr>\r\n<tr>\r\n<td width=\"10\">&nbsp;</td>\r\n<td align=\"left\" width=\"20\" height=\"16\"><a title=\"Twitter\" href=\"https://twitter.com/eventday\" target=\"_blank\"><img src=\"https://az118040.vo.msecnd.net/assets/832597db77d5495b9b5bb23f711f2bb3/icon_twitter.png\" alt=\"\" width=\"16\" height=\"16\" border=\"0\" /></a></td>\r\n<td align=\"left\" valign=\"middle\" width=\"130\" height=\"16\"><a title=\"Twitter\" href=\"http://twitter.com/eventroller\" target=\"_blank\">Twitter</a></td>\r\n</tr>\r\n<tr>\r\n<td width=\"10\">&nbsp;</td>\r\n<td align=\"left\" width=\"20\" height=\"16\"><a title=\"Facebook\" href=\"https://www.facebook.com/eventday\" target=\"_blank\"><img src=\"https://az118040.vo.msecnd.net/assets/832597db77d5495b9b5bb23f711f2bb3/icon_facebook.png\" alt=\"\" width=\"16\" height=\"16\" border=\"0\" /></a></td>\r\n<td align=\"left\" valign=\"middle\" width=\"130\" height=\"16\"><a title=\"Facebook\" href=\"https://www.facebook.com/eventroller\" target=\"_blank\">Facebook</a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td colspan=\"4\" align=\"right\" valign=\"top\" width=\"600\" height=\"10\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50\">&nbsp;</td>\r\n<td colspan=\"2\" align=\"left\" valign=\"top\" width=\"500\">\r\n<p>Try EventRoller for FREE.<br /><a href=\"http://eventroller.com/try_free\">Click to Setup your Event in 30 Seconds</a></p>\r\n</td>\r\n<td width=\"50\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50\">&nbsp;</td>\r\n<td colspan=\"2\" align=\"left\" valign=\"top\" width=\"500\">&nbsp;</td>\r\n<td width=\"50\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td colspan=\"4\">\r\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td width=\"50\">&nbsp;</td>\r\n<td width=\"550\"><img src=\"https://dl.dropboxusercontent.com/u/16106822/event-roller.png\" alt=\"EventDay Logo\" />&nbsp;<br />Plot 28,29. Electronic City<br />Haryana, Gurgaon<br />India</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n<td align=\"left\" valign=\"top\" width=\"50%\">&nbsp;<br /><br /></td>\r\n</tr>\r\n</tbody>\r\n</table>','0'),(5,'1384172563','email','User Registration','e-Planner - Admin','ravimadan86@gmail.com','Welcome to e-Planner','<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td align=\"right\" valign=\"top\" width=\"50%\">&nbsp;</td>\r\n<td valign=\"top\">\r\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td colspan=\"4\" align=\"right\" width=\"600\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td colspan=\"4\" align=\"left\" valign=\"middle\" width=\"600\" height=\"67\"><img src=\"https://dl.dropboxusercontent.com/u/16106822/eventroller-email-header.png\" alt=\"EventRoller Logo Header\" width=\"605\" height=\"67\" /></td>\r\n</tr>\r\n<tr>\r\n<td colspan=\"4\" align=\"right\" valign=\"top\" width=\"600\" height=\"10\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td colspan=\"4\" align=\"right\" valign=\"top\" width=\"600\" height=\"10\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50\">&nbsp;</td>\r\n<td align=\"left\" valign=\"top\" width=\"400\">\r\n<p>{{EventName}}</p>\r\n<p>{{VenueAddress}}</p>\r\n<div>\r\n<p>{{FirstName}}&nbsp;{{LastName}},<br />You are confirmed, with the following ticket:&nbsp;{{ticket_title}}.</p>\r\n<p>Complete your registration by visiting the following URL</p>\r\n<p>{{RegistrationURL}}</p>\r\n<p>&nbsp;</p>\r\n<p>please login using the following password</p>\r\n<p>{{Password}}</p>\r\n<p>Please bring this QRCode with you to the event, and we will check you in with it. It\'s like your boarding pass to the event. You can print it and bring it with you, or save it on your phone.</p>\r\n<p>{{EventStartDate}}</p>\r\n<p>&nbsp;</p>\r\n</div>\r\n</td>\r\n<td colspan=\"2\" align=\"left\" valign=\"top\" width=\"150\">\r\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td width=\"10\">&nbsp;</td>\r\n<td colspan=\"2\" align=\"left\" valign=\"top\" width=\"150\">Connect with Us</td>\r\n</tr>\r\n<tr>\r\n<td width=\"10\">&nbsp;</td>\r\n<td align=\"left\" width=\"20\" height=\"16\"><a title=\"Blog\" href=\"http://blog.eventday.com\" target=\"_blank\"><img src=\"https://az118040.vo.msecnd.net/assets/832597db77d5495b9b5bb23f711f2bb3/icon_blog.jpg\" alt=\"\" width=\"16\" height=\"16\" border=\"0\" /></a></td>\r\n<td align=\"left\" valign=\"middle\" width=\"130\" height=\"16\"><a title=\"Blog\" href=\"http://blog.eventroller.com\" target=\"_blank\">Blog</a></td>\r\n</tr>\r\n<tr>\r\n<td width=\"10\">&nbsp;</td>\r\n<td align=\"left\" width=\"20\" height=\"16\"><a title=\"Twitter\" href=\"https://twitter.com/eventday\" target=\"_blank\"><img src=\"https://az118040.vo.msecnd.net/assets/832597db77d5495b9b5bb23f711f2bb3/icon_twitter.png\" alt=\"\" width=\"16\" height=\"16\" border=\"0\" /></a></td>\r\n<td align=\"left\" valign=\"middle\" width=\"130\" height=\"16\"><a title=\"Twitter\" href=\"http://twitter.com/eventroller\" target=\"_blank\">Twitter</a></td>\r\n</tr>\r\n<tr>\r\n<td width=\"10\">&nbsp;</td>\r\n<td align=\"left\" width=\"20\" height=\"16\"><a title=\"Facebook\" href=\"https://www.facebook.com/eventday\" target=\"_blank\"><img src=\"https://az118040.vo.msecnd.net/assets/832597db77d5495b9b5bb23f711f2bb3/icon_facebook.png\" alt=\"\" width=\"16\" height=\"16\" border=\"0\" /></a></td>\r\n<td align=\"left\" valign=\"middle\" width=\"130\" height=\"16\"><a title=\"Facebook\" href=\"https://www.facebook.com/eventroller\" target=\"_blank\">Facebook</a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td colspan=\"4\" align=\"right\" valign=\"top\" width=\"600\" height=\"10\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50\">&nbsp;</td>\r\n<td colspan=\"2\" align=\"left\" valign=\"top\" width=\"500\">\r\n<p>Try EventRoller for FREE.<br /><a href=\"http://eventroller.com/try_free\">Click to Setup your Event in 30 Seconds</a></p>\r\n</td>\r\n<td width=\"50\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50\">&nbsp;</td>\r\n<td colspan=\"2\" align=\"left\" valign=\"top\" width=\"500\">EventRoller respects your privacy. You have been individually sent this confirmation, as a ticket holder of this Event.</td>\r\n<td width=\"50\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td colspan=\"4\">\r\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td width=\"50\">&nbsp;</td>\r\n<td width=\"550\"><img src=\"https://dl.dropboxusercontent.com/u/16106822/event-roller.png\" alt=\"EventDay Logo\" />&nbsp;<br />Plot 28,29. Electronic City<br />Haryana, Gurgaon<br />India</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n<td align=\"left\" valign=\"top\" width=\"50%\">&nbsp;<br /><br /></td>\r\n</tr>\r\n</tbody>\r\n</table>','0'),(6,'1384924459','email','Update Profile Reminder','e-Planner - Admin','ravimadan86@gmail.com','e-Planner - Profile Update Reminder','<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td align=\"right\" valign=\"top\" width=\"50%\">&nbsp;</td>\r\n<td valign=\"top\">\r\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td colspan=\"4\" align=\"right\" width=\"600\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td colspan=\"4\" align=\"left\" valign=\"middle\" width=\"600\" height=\"67\"><img src=\"https://dl.dropboxusercontent.com/u/16106822/eventroller-email-header.png\" alt=\"EventRoller Logo Header\" width=\"605\" height=\"67\" /></td>\r\n</tr>\r\n<tr>\r\n<td colspan=\"4\" align=\"right\" valign=\"top\" width=\"600\" height=\"10\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td colspan=\"4\" align=\"right\" valign=\"top\" width=\"600\" height=\"10\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50\">&nbsp;</td>\r\n<td align=\"left\" valign=\"top\" width=\"400\">\r\n<p>Dear {{FirstName}}&nbsp;{{LastName}},</p>\r\n<div>\r\n<p>ICC2013 Program Details and User Profiles can now be accessed through your Mobile and Tablet by downloading the Mobile application.&nbsp;</p>\r\n<p><a href=\"https://play.google.com/store/apps/details?id=com.mds.icc2013&amp;hl=en\"><img src=\"http://indiancancercongress2013.org/wp-content/uploads/google-play.png\" alt=\"ICC2013 - Android Application\" width=\"133\" height=\"43\" /></a>&nbsp;&nbsp;<a href=\"https://itunes.apple.com/us/app/icc-2013/id751079888?ls=1&amp;mt=8\"><img src=\"http://indiancancercongress2013.org/wp-content/uploads/app-store.png\" alt=\"ICC2013 - iPhone Application\" width=\"126\" height=\"44\" /></a></p>\r\n<p>We are sitting at Booth 24 to help you with any technical issues. Kindly visit our stall for any queries.</p>\r\n<p>The Mobile App supports Push Notifications and has full offline support. Access all the information on your mobile and build your itinerary.</p>\r\n<p>If there are any errors in any information regarding individual profiles, or session information please either drop us an email on <a href=\"mailto:contact@eventroller.com\">contact@eventroller.com</a>&nbsp;or visit us on our stall.</p>\r\n<p>To Login - Use your Email Address and \"icc2013\" as password.&nbsp;</p>\r\n<p>You can log in to our interactive web portal to update your profile anytime.</p>\r\n<p><a href=\"/index.php\"><img src=\"http://indiancancercongress2013.org/wp-content/uploads/interactive_logo.png\" alt=\"ICC - Web Portal\" width=\"132\" height=\"42\" /></a></p>\r\n<p>&nbsp;</p>\r\n</div>\r\n</td>\r\n<td colspan=\"2\" align=\"left\" valign=\"top\" width=\"150\">\r\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td width=\"10\">&nbsp;</td>\r\n<td colspan=\"2\" align=\"left\" valign=\"top\" width=\"150\">Connect with Us</td>\r\n</tr>\r\n<tr>\r\n<td width=\"10\">&nbsp;</td>\r\n<td align=\"left\" width=\"20\" height=\"16\"><a title=\"Blog\" href=\"http://blog.eventday.com\" target=\"_blank\"><img src=\"https://az118040.vo.msecnd.net/assets/832597db77d5495b9b5bb23f711f2bb3/icon_blog.jpg\" alt=\"\" width=\"16\" height=\"16\" border=\"0\" /></a></td>\r\n<td align=\"left\" valign=\"middle\" width=\"130\" height=\"16\"><a title=\"Blog\" href=\"http://eventroller.com\" target=\"_blank\">Blog</a></td>\r\n</tr>\r\n<tr>\r\n<td width=\"10\">&nbsp;</td>\r\n<td align=\"left\" width=\"20\" height=\"16\"><a title=\"Twitter\" href=\"https://twitter.com/eventday\" target=\"_blank\"><img src=\"https://az118040.vo.msecnd.net/assets/832597db77d5495b9b5bb23f711f2bb3/icon_twitter.png\" alt=\"\" width=\"16\" height=\"16\" border=\"0\" /></a></td>\r\n<td align=\"left\" valign=\"middle\" width=\"130\" height=\"16\"><a title=\"Twitter\" href=\"http://twitter.com/eventroller\" target=\"_blank\">Twitter</a></td>\r\n</tr>\r\n<tr>\r\n<td width=\"10\">&nbsp;</td>\r\n<td align=\"left\" width=\"20\" height=\"16\"><a title=\"Facebook\" href=\"https://www.facebook.com/eventday\" target=\"_blank\"><img src=\"https://az118040.vo.msecnd.net/assets/832597db77d5495b9b5bb23f711f2bb3/icon_facebook.png\" alt=\"\" width=\"16\" height=\"16\" border=\"0\" /></a></td>\r\n<td align=\"left\" valign=\"middle\" width=\"130\" height=\"16\"><a title=\"Facebook\" href=\"https://www.facebook.com/eventrolleronline\" target=\"_blank\">Facebook</a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td colspan=\"4\" align=\"right\" valign=\"top\" width=\"600\" height=\"10\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50\">&nbsp;</td>\r\n<td colspan=\"2\" align=\"left\" valign=\"top\" width=\"500\">\r\n<p>Try EventRoller for FREE.<br /><a href=\"http://eventroller.com/try_free\">E</a>mail us on <a href=\"mailto:contact@eventroller.com\">contact@eventroller.com</a>&nbsp;for a FREE Trial</p>\r\n</td>\r\n<td width=\"50\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td width=\"50\">&nbsp;</td>\r\n<td colspan=\"2\" align=\"left\" valign=\"top\" width=\"500\"><span>EventRoller respects your privacy. You have been individually sent this confirmation, as a ticket holder of this Event.</span></td>\r\n<td width=\"50\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td colspan=\"4\">\r\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td width=\"50\">&nbsp;</td>\r\n<td width=\"550\"><img src=\"https://dl.dropboxusercontent.com/u/16106822/event-roller.png\" alt=\"EventDay Logo\" />&nbsp;<br />Plot 28,29. Electronic City<br />Haryana, Gurgaon<br />India</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n<td align=\"left\" valign=\"top\" width=\"50%\">&nbsp;<br /><br /></td>\r\n</tr>\r\n</tbody>\r\n</table>','0'),(7,'1391121784','email','Release Added','e-Planner - Admin','ravimadan86@gmail.com','e-Planner - Addition Notification','<p>Hello {{FirstName}}&nbsp;{{LastName}} ,</p>\r\n\r\n<p>A new United Vending has been added to the project with following details:</p>\r\n\r\n<p><strong>Release for Product :</strong> {{ProductName}}</p>\r\n<p><strong>Svn No:</strong> {{SvnNo}}</p>\r\n<p><strong>Svn Url:</strong> {{SvnUrl}}</p>\r\n<p><strong>Release Description:</strong> {{Description}}</p>\r\n<p><strong>Created on:</strong> {{CreatedOn}}</p>\n\r\n\r\nRelease Manager <br />\r\nSupport Team!!\r\n</p>','0');

/*Table structure for table `person_mailgroup_stats` */

DROP TABLE IF EXISTS `person_mailgroup_stats`;

CREATE TABLE `person_mailgroup_stats` (
  `person_mailgroup_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Person''s Mailgroup Id',
  `person_id` int(11) NOT NULL COMMENT 'Person Id',
  `mailgroup_id` int(11) NOT NULL COMMENT 'Mailgroup Id',
  `is_subscribed` enum('1','0') DEFAULT '1' COMMENT '0=Unsubscribed 1=Subscribed',
  `mailgroup_subscribe_stamp` int(11) DEFAULT NULL COMMENT 'Mailgroup Subscribe Stamp',
  `mailgroup_unsubscribe_stamp` int(11) DEFAULT NULL COMMENT 'Mailgroup UnSubscribe Stamp',
  `mailgroup_bounced_stamp` int(11) DEFAULT NULL COMMENT 'Mailgroups Bounced Stamp',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created On',
  PRIMARY KEY (`person_mailgroup_id`),
  KEY `FK_person_mailgroup_stats_mailgroup` (`mailgroup_id`),
  KEY `FK_person_mailgroup_stats_person` (`person_id`),
  CONSTRAINT `FK_person_mailgroup_stats_mailgroup` FOREIGN KEY (`mailgroup_id`) REFERENCES `mailgroups` (`mailgroup_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_person_mailgroup_stats_person` FOREIGN KEY (`person_id`) REFERENCES `persons` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `person_mailgroup_stats` */

insert  into `person_mailgroup_stats`(`person_mailgroup_id`,`person_id`,`mailgroup_id`,`is_subscribed`,`mailgroup_subscribe_stamp`,`mailgroup_unsubscribe_stamp`,`mailgroup_bounced_stamp`,`created_on`) values (1,1,1,'0',NULL,1396988706,NULL,'2014-04-04 00:14:22'),(2,2,1,'1',1396643595,NULL,NULL,'2014-04-05 01:58:32'),(3,3,1,'1',1396643595,NULL,NULL,'2014-04-05 01:58:32'),(4,4,3,'1',1396643595,NULL,NULL,'2014-04-05 01:58:32'),(5,4,5,'1',1396741612,NULL,NULL,'2014-04-06 05:16:52');

/*Table structure for table `persons` */

DROP TABLE IF EXISTS `persons`;

CREATE TABLE `persons` (
  `person_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Person Id',
  `user_id` int(11) DEFAULT NULL COMMENT 'User ID',
  `user_code` varchar(255) DEFAULT NULL COMMENT 'Unique User Code From User Table',
  `person_code` varchar(255) DEFAULT NULL COMMENT 'Person Unique Identifier',
  `person_first_name` varchar(255) NOT NULL COMMENT 'Person First Name',
  `person_last_name` varchar(255) NOT NULL COMMENT 'Person Last Name',
  `person_email` varchar(255) NOT NULL COMMENT 'Person Email Id',
  `person_password` varchar(255) DEFAULT NULL COMMENT 'Person Password',
  `is_subscribed` enum('0','1') DEFAULT '1' COMMENT 'Subscribed to Recieve Publication',
  `unsubscribe_stamp` int(11) DEFAULT NULL COMMENT 'Unsubscribe Stamp from Publication',
  `is_notify_schemes` enum('0','1') DEFAULT '1' COMMENT 'Recieve Offers',
  `unnotify_stamp` int(11) DEFAULT NULL COMMENT 'unsubscribe from Recieve Offers',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created On',
  PRIMARY KEY (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `persons` */

insert  into `persons`(`person_id`,`user_id`,`user_code`,`person_code`,`person_first_name`,`person_last_name`,`person_email`,`person_password`,`is_subscribed`,`unsubscribe_stamp`,`is_notify_schemes`,`unnotify_stamp`,`created_on`) values (1,1,NULL,NULL,'Ravi','Madan','ravimadan86@gmail.com',NULL,'1',NULL,'1',NULL,'2014-04-05 01:57:41'),(2,1,NULL,NULL,'Ravi','Gmail','ravimadan86@gmail.com',NULL,'1',NULL,'1',NULL,'2014-04-05 01:58:31'),(3,1,NULL,NULL,'Ravi','Yahoo','ravimadan86@yahoo.com',NULL,'1',NULL,'1',NULL,'2014-04-05 01:58:32'),(4,1,NULL,NULL,'Ravi','Rediff','ravimadan86@rediff.com',NULL,'1',NULL,'1',NULL,'2014-04-05 01:58:32');

/*Table structure for table `surveys` */

DROP TABLE IF EXISTS `surveys`;

CREATE TABLE `surveys` (
  `survey_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Survey ID',
  `user_id` int(11) NOT NULL COMMENT 'User ID',
  `template_id` int(11) NOT NULL COMMENT 'Survey Template ID ',
  `survey_token` varchar(255) DEFAULT NULL COMMENT 'Survey Token',
  `survey_name` varchar(255) NOT NULL COMMENT 'Survey Name',
  `survey_title` varchar(255) DEFAULT NULL COMMENT 'Survey Title',
  `survey_taglines` varchar(255) DEFAULT NULL COMMENT 'Survey Tag Line',
  `sender_email` varchar(255) DEFAULT NULL COMMENT 'Survey Sender Email Id',
  `survey_start_time` int(11) DEFAULT NULL COMMENT 'Survey Start Time',
  `survey_expiry_time` int(11) DEFAULT NULL COMMENT 'Survey Expiry Time',
  `survey_thankyou_message` text COMMENT 'Survey Thanks You Message',
  `modified_on` datetime DEFAULT '0000-00-00 00:00:00' COMMENT 'Last Modified On',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created On',
  `is_published` enum('0','1') DEFAULT '0' COMMENT '0=Not Published 1=Published',
  `is_active` enum('0','1') DEFAULT '1' COMMENT '0=Inactive 1=Active',
  PRIMARY KEY (`survey_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `surveys` */

/*Table structure for table `templates` */

DROP TABLE IF EXISTS `templates`;

CREATE TABLE `templates` (
  `template_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Template Id',
  `user_id` int(11) NOT NULL COMMENT 'Designer/Templator Id',
  `owner_id` int(11) NOT NULL COMMENT 'User Id who requested this template',
  `template_name` varchar(255) NOT NULL COMMENT 'Template Name',
  `template_body` text NOT NULL COMMENT 'CSS and Body',
  `is_default` enum('0','1') DEFAULT '0' COMMENT '0=No 1=Yes',
  `is_active` enum('0','1') DEFAULT '1' COMMENT '0=Inactive 1=Active',
  `modified_on` datetime DEFAULT '0000-00-00 00:00:00' COMMENT 'last Modified On',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created On',
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `templates` */

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User Id',
  `role` varchar(255) NOT NULL COMMENT 'User Role',
  `email` varchar(255) NOT NULL COMMENT 'User Email ID',
  `password` varchar(255) NOT NULL COMMENT 'User Password',
  `first_name` varchar(255) NOT NULL COMMENT 'User First Name',
  `last_name` varchar(255) NOT NULL COMMENT 'User Last Name',
  `address_line_1` varchar(255) DEFAULT NULL COMMENT 'User Address Line1',
  `address_line_2` varchar(255) DEFAULT NULL COMMENT 'User Address Line 2',
  `city` varchar(255) DEFAULT NULL COMMENT 'User City',
  `state` varchar(255) DEFAULT NULL COMMENT 'Use State',
  `country` varchar(255) DEFAULT NULL COMMENT 'User Country',
  `zip_code` varchar(255) DEFAULT NULL COMMENT 'User Zip Code',
  `company_name` varchar(255) DEFAULT NULL COMMENT 'Customer Company Name',
  `is_active` enum('0','1') DEFAULT '1' COMMENT '1=Active and 0=Inactive',
  `last_modified_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT 'User Modified Time',
  `registration_token` varchar(255) DEFAULT NULL COMMENT 'User registration token',
  `forgot_token` varchar(255) DEFAULT NULL COMMENT 'User Forgot Password Token',
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'User Creation Time',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`user_id`,`role`,`email`,`password`,`first_name`,`last_name`,`address_line_1`,`address_line_2`,`city`,`state`,`country`,`zip_code`,`company_name`,`is_active`,`last_modified_time`,`registration_token`,`forgot_token`,`created_on`) values (1,'Admin','ravi@metadesignsolutions.com','21232f297a57a5a743894a0e4a801fc3','Ravi','Madan','E57, Hartron Complex','Electronic City, Secor 18','Gurgaon','Haryana','India','122001','MetaDesign Solutions','1','2014-03-27 18:32:05',NULL,NULL,'2014-03-26 15:55:00'),(2,'Client','ravimadan86@yahoo.com','21232f297a57a5a743894a0e4a801fc3','Ravi','Vendor','A172','','New Delhi','Delhi','India','110059','MetaDesign Solutions','1','2014-03-28 13:22:37',NULL,NULL,'2014-03-27 19:24:52'),(3,'Client','ravimadan861@gmail.com','21232f297a57a5a743894a0e4a801fc3','Ravi','Vendor1','A172','','New Delhi','Delhi','India','110059','MetaDesign Solutions','1','0000-00-00 00:00:00',NULL,NULL,'2014-03-28 13:23:43'),(4,'Admin','ravimadan86@gmail.com','21232f297a57a5a743894a0e4a801fc3','Ravi','861','A172','','New Delhi','Delhi','India','110060','MDS','1','0000-00-00 00:00:00',NULL,'','2014-04-03 22:01:09');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
