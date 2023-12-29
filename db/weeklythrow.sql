-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 05, 2022 at 10:16 AM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `weeklythrow`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_banner`
--

DROP TABLE IF EXISTS `tbl_banner`;
CREATE TABLE IF NOT EXISTS `tbl_banner` (
  `B_ID` int(11) NOT NULL AUTO_INCREMENT,
  `IMAGE_NAME` varchar(255) NOT NULL,
  `TEXT` varchar(255) DEFAULT NULL,
  `ACTIVE_STATUS` enum('0','1') NOT NULL COMMENT '''1'' for activated and ''0'' for deactivated ',
  `CREATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UPDATED-AT` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`B_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cms_pages`
--

DROP TABLE IF EXISTS `tbl_cms_pages`;
CREATE TABLE IF NOT EXISTS `tbl_cms_pages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TYPE` int(11) NOT NULL,
  `TITLE` varchar(255) NOT NULL,
  `CONTENT` text NOT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UPDATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `PAGE_TYPE_FK` (`TYPE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contest`
--

DROP TABLE IF EXISTS `tbl_contest`;
CREATE TABLE IF NOT EXISTS `tbl_contest` (
  `C_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CONTEST_BANNER` varchar(255) NOT NULL,
  `CONTEST_NAME` varchar(255) NOT NULL,
  `CONTEST_DESCRIPTION` text NOT NULL,
  `CONTEST_POINTS` int(11) NOT NULL,
  `CONTEST_PDF` varchar(255) NOT NULL,
  `START_DATE` date NOT NULL,
  `END_DATE` date NOT NULL,
  `STATUS` enum('1','0') NOT NULL COMMENT '''1'' for activated and ''0'' for deactivated ',
  `CREATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UPDATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`C_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contest_comments`
--

DROP TABLE IF EXISTS `tbl_contest_comments`;
CREATE TABLE IF NOT EXISTS `tbl_contest_comments` (
  `COMMENT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `COMMENT_PARTICIPANT_ID` int(11) NOT NULL,
  `COMMENT_AUTHOR_ID` int(11) NOT NULL,
  `COMMENT_DATE` date NOT NULL,
  `COMMENT_CONTENT` text NOT NULL,
  `PARENT_COMMENT_ID` int(11) DEFAULT NULL,
  `CREATED_AT` timestamp NOT NULL,
  `UPDATED_AT` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`COMMENT_ID`),
  KEY `PARTICIPANT_FK_CMT` (`COMMENT_PARTICIPANT_ID`),
  KEY `COMMENT_AUTHOR_FK` (`COMMENT_AUTHOR_ID`),
  KEY `PARENT_COMMENT_ID` (`PARENT_COMMENT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification`
--

DROP TABLE IF EXISTS `tbl_notification`;
CREATE TABLE IF NOT EXISTS `tbl_notification` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOTIFICATION_TITLE` varchar(255) NOT NULL,
  `NOTIFICATION_DISCRIPTION` text NOT NULL,
  `TYPE` enum('PUSH','SYSTEM') NOT NULL,
  `DEVICE_ID` varchar(255) DEFAULT NULL,
  `DELETE_STATUS` enum('1','0') NOT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UPDATED_AT` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_page_type`
--

DROP TABLE IF EXISTS `tbl_page_type`;
CREATE TABLE IF NOT EXISTS `tbl_page_type` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TYPE` int(11) NOT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UPDATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_participant`
--

DROP TABLE IF EXISTS `tbl_participant`;
CREATE TABLE IF NOT EXISTS `tbl_participant` (
  `P_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CONTEST_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `VIDEO_URL` varchar(255) NOT NULL,
  `SCORE` int(11) NOT NULL,
  `DISQULIFID` enum('1','0') NOT NULL,
  `APPROVED_REJECT` enum('1','0') NOT NULL,
  `REVIEWER_ID` int(11) DEFAULT NULL,
  `LAST_UPDATED_BY` int(11) DEFAULT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UPDATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`P_ID`),
  KEY `PARTICIPANT_FK` (`USER_ID`),
  KEY `REVIEWER_FK` (`REVIEWER_ID`),
  KEY `LAST_REVIEWER_FK` (`LAST_UPDATED_BY`),
  KEY `CONTEST_FK` (`CONTEST_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

DROP TABLE IF EXISTS `tbl_payment`;
CREATE TABLE IF NOT EXISTS `tbl_payment` (
  `PAY_ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER_ID` int(11) NOT NULL,
  `TRANSECTION_ID` varchar(255) NOT NULL,
  `AMOUNT_PAID` float NOT NULL,
  `POINTS` int(11) NOT NULL,
  `PROMOCODE_ID` int(11) DEFAULT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UPDATED_AT` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`PAY_ID`),
  KEY `PROMOCODE_APPLIED` (`PROMOCODE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_promocode`
--

DROP TABLE IF EXISTS `tbl_promocode`;
CREATE TABLE IF NOT EXISTS `tbl_promocode` (
  `PROMO_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TITLE` varchar(255) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `BANNER_IMAGE` varchar(255) NOT NULL,
  `PURCHASE_POINTS` int(11) NOT NULL,
  `EXPIRY_DATE` date NOT NULL,
  `DELETE_STATUS` enum('1','0') NOT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UPDATED_AT` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`PROMO_ID`),
  UNIQUE KEY `TITLE` (`TITLE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role`
--

DROP TABLE IF EXISTS `tbl_role`;
CREATE TABLE IF NOT EXISTS `tbl_role` (
  `R_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ACCESS_MODULE` json DEFAULT NULL COMMENT 'AN ARRAY OF ACCESS',
  `NAME` varchar(255) NOT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UPDATED_AT` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`R_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_role`
--

INSERT INTO `tbl_role` (`R_ID`, `ACCESS_MODULE`, `NAME`, `CREATED_AT`, `UPDATED_AT`) VALUES
(1, NULL, 'ADMIN', '2022-01-05 09:23:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

DROP TABLE IF EXISTS `tbl_settings`;
CREATE TABLE IF NOT EXISTS `tbl_settings` (
  `SETTING_ID` int(11) NOT NULL AUTO_INCREMENT,
  `SETTING_KEY` varchar(255) NOT NULL,
  `SETTING_VALUE` varchar(255) NOT NULL,
  `CREATED_AT` timestamp NOT NULL,
  `UPDATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`SETTING_ID`),
  UNIQUE KEY `SETTING_KEY` (`SETTING_KEY`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_master`
--

DROP TABLE IF EXISTS `tbl_user_master`;
CREATE TABLE IF NOT EXISTS `tbl_user_master` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FIRST_NAME` varchar(255) NOT NULL,
  `LAST_NAME` varchar(255) NOT NULL,
  `USERNAME` varchar(255) NOT NULL,
  `EMAIL_ID` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `PROFILE_IMAGE` varchar(255) DEFAULT NULL,
  `DOB` date NOT NULL,
  `STREET` varchar(255) DEFAULT NULL,
  `CITY` varchar(255) DEFAULT NULL,
  `ZIPCODE` varchar(255) DEFAULT NULL,
  `STATE` varchar(255) DEFAULT NULL,
  `PAYPAL_EMAIL_ID` varchar(255) NOT NULL,
  `ROLE_ID` int(11) NOT NULL,
  `STATUS` enum('1','0') NOT NULL COMMENT '''1'' for activated and ''0'' for deactivated ',
  `DEVICE_TOKON` varchar(255) DEFAULT NULL,
  `DEVICE_TYPE` enum('A','I','ADMIN') NOT NULL COMMENT 'A->Android,I->Iphone, ADMIN ',
  `FORGOT_VERIFYCODE` varchar(255) DEFAULT NULL,
  `LOGIN_KEY` varchar(255) DEFAULT NULL,
  `EMAIL_VERIFICATION_CODE` varchar(255) DEFAULT NULL,
  `CREATED_AT` timestamp NOT NULL,
  `UPDATED_AT` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `USERNAME` (`USERNAME`),
  UNIQUE KEY `EMAIL_ID` (`EMAIL_ID`),
  UNIQUE KEY `PAYPAL_EMAIL_ID` (`PAYPAL_EMAIL_ID`),
  UNIQUE KEY `LOGIN_KEY` (`LOGIN_KEY`),
  KEY `ROLE_CONSTRAINT` (`ROLE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_master`
--

INSERT INTO `tbl_user_master` (`ID`, `FIRST_NAME`, `LAST_NAME`, `USERNAME`, `EMAIL_ID`, `PASSWORD`, `PROFILE_IMAGE`, `DOB`, `STREET`, `CITY`, `ZIPCODE`, `STATE`, `PAYPAL_EMAIL_ID`, `ROLE_ID`, `STATUS`, `DEVICE_TOKON`, `DEVICE_TYPE`, `FORGOT_VERIFYCODE`, `LOGIN_KEY`, `EMAIL_VERIFICATION_CODE`, `CREATED_AT`, `UPDATED_AT`) VALUES
(3, 'ADMIN', 'ADMIN', 'ADMIN', 'potenza@yopmail.com', '89e887999725341def9a4c0915dc7604', NULL, '2022-01-05', NULL, NULL, NULL, NULL, 'potenza@yopmail.com', 1, '1', NULL, 'ADMIN', NULL, NULL, NULL, '2022-01-04 18:30:00', '2022-01-05 09:26:54');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_points`
--

DROP TABLE IF EXISTS `tbl_user_points`;
CREATE TABLE IF NOT EXISTS `tbl_user_points` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER_ID` int(11) NOT NULL,
  `POINTS` int(11) NOT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UPDATED_AT` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `USER_POINT_CONTRAINTS` (`USER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_cms_pages`
--
ALTER TABLE `tbl_cms_pages`
  ADD CONSTRAINT `PAGE_TYPE_FK` FOREIGN KEY (`TYPE`) REFERENCES `tbl_page_type` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_contest_comments`
--
ALTER TABLE `tbl_contest_comments`
  ADD CONSTRAINT `COMMENT_AUTHOR_FK` FOREIGN KEY (`COMMENT_AUTHOR_ID`) REFERENCES `tbl_user_master` (`ID`),
  ADD CONSTRAINT `PARENT_COMMENT_ID` FOREIGN KEY (`PARENT_COMMENT_ID`) REFERENCES `tbl_contest_comments` (`COMMENT_ID`),
  ADD CONSTRAINT `PARTICIPANT_FK_CMT` FOREIGN KEY (`COMMENT_PARTICIPANT_ID`) REFERENCES `tbl_participant` (`P_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_participant`
--
ALTER TABLE `tbl_participant`
  ADD CONSTRAINT `CONTEST_FK` FOREIGN KEY (`CONTEST_ID`) REFERENCES `tbl_contest` (`C_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LAST_REVIEWER_FK` FOREIGN KEY (`LAST_UPDATED_BY`) REFERENCES `tbl_user_master` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `PARTICIPANT_FK` FOREIGN KEY (`USER_ID`) REFERENCES `tbl_user_master` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `REVIEWER_FK` FOREIGN KEY (`REVIEWER_ID`) REFERENCES `tbl_user_master` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD CONSTRAINT `PROMOCODE_APPLIED` FOREIGN KEY (`PROMOCODE_ID`) REFERENCES `tbl_promocode` (`PROMO_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_user_master`
--
ALTER TABLE `tbl_user_master`
  ADD CONSTRAINT `ROLE_CONSTRAINT` FOREIGN KEY (`ROLE_ID`) REFERENCES `tbl_role` (`R_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_user_points`
--
ALTER TABLE `tbl_user_points`
  ADD CONSTRAINT `USER_POINT_CONTRAINTS` FOREIGN KEY (`USER_ID`) REFERENCES `tbl_user_master` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
