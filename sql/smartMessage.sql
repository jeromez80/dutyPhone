-- phpMyAdmin SQL Dump
-- version 4.4.15.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 03, 2016 at 11:23 PM
-- Server version: 5.5.44-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smartMessage`
--

-- --------------------------------------------------------

--
-- Table structure for table `ConfigData`
--

DROP TABLE IF EXISTS `ConfigData`;
CREATE TABLE IF NOT EXISTS `ConfigData` (
  `Config_Key` varchar(32) NOT NULL,
  `Config_Value` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Store configuration data using Key-Value pairs';

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

DROP TABLE IF EXISTS `data`;
CREATE TABLE IF NOT EXISTS `data` (
  `username` text,
  `password` text,
  `nickname` text,
  `login` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `IncomingEmail`
--

DROP TABLE IF EXISTS `IncomingEmail`;
CREATE TABLE IF NOT EXISTS `IncomingEmail` (
  `Email_ID` int(10) unsigned NOT NULL,
  `DBTimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Timestamp` datetime NOT NULL,
  `MsgFrom` varchar(20) NOT NULL,
  `MsgTo` varchar(255) NOT NULL,
  `Dest_CtyCode` varchar(4) NOT NULL,
  `Dest_Number` varchar(15) NOT NULL,
  `Message` varchar(2000) NOT NULL,
  `Processed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Incoming SMS messages.';

-- --------------------------------------------------------

--
-- Table structure for table `IncomingSMS`
--

DROP TABLE IF EXISTS `IncomingSMS`;
CREATE TABLE IF NOT EXISTS `IncomingSMS` (
  `SMS_ID` int(10) unsigned NOT NULL,
  `DBTimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Timestamp` datetime NOT NULL,
  `MsgFrom` varchar(20) NOT NULL,
  `MsgTo` varchar(20) NOT NULL DEFAULT 'SMGateway',
  `Message` varchar(200) NOT NULL,
  `Processed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Incoming SMS messages.';

-- --------------------------------------------------------

--
-- Table structure for table `IncomingWA`
--

DROP TABLE IF EXISTS `IncomingWA`;
CREATE TABLE IF NOT EXISTS `IncomingWA` (
  `WA_ID` int(10) unsigned NOT NULL,
  `DBTimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Timestamp` varchar(100) NOT NULL,
  `MsgFrom` varchar(200) NOT NULL,
  `MsgTo` varchar(500) NOT NULL,
  `Message` varchar(2048) NOT NULL,
  `Processed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Incoming SMS messages.';

-- --------------------------------------------------------

--
-- Table structure for table `Keywords`
--

DROP TABLE IF EXISTS `Keywords`;
CREATE TABLE IF NOT EXISTS `Keywords` (
  `Keyword_ID` int(11) unsigned NOT NULL,
  `Source_Type` enum('SMS','Syslog','WA','Email','HTTP','ANY') NOT NULL,
  `Source_ID` varchar(64) NOT NULL,
  `Keyword` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `KeywordsActions`
--

DROP TABLE IF EXISTS `KeywordsActions`;
CREATE TABLE IF NOT EXISTS `KeywordsActions` (
  `Keyword_ID` int(11) unsigned NOT NULL,
  `Action_Type` enum('SMS','WA','WAGC','Call') NOT NULL,
  `Dest_CtyCode` varchar(4) NOT NULL,
  `Dest_Number` varchar(15) NOT NULL,
  `Dest_Message` varchar(1024) NOT NULL,
  `Dest_AppendRaw` tinyint(1) NOT NULL DEFAULT '1',
  `Dest_Parameters` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `sender` varchar(25) NOT NULL,
  `receiver` varchar(25) NOT NULL,
  `message` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Modules`
--

DROP TABLE IF EXISTS `Modules`;
CREATE TABLE IF NOT EXISTS `Modules` (
  `SN` int(11) NOT NULL,
  `Module_Name` varchar(100) NOT NULL,
  `Module_Path` varchar(100) NOT NULL,
  `Module_Enabled` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='List of filter modules and enabled status';

-- --------------------------------------------------------

--
-- Table structure for table `OutMessageCompleted`
--

DROP TABLE IF EXISTS `OutMessageCompleted`;
CREATE TABLE IF NOT EXISTS `OutMessageCompleted` (
  `Job_ID` int(10) unsigned NOT NULL,
  `Job_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Job_Type` enum('SMS','WA','WAGC','Call') NOT NULL,
  `Dest_CtyCode` varchar(4) NOT NULL,
  `Dest_Number` varchar(18) NOT NULL,
  `Dest_Message` varchar(1024) NOT NULL,
  `MsgFrom` varchar(20) NOT NULL DEFAULT 'SMGateway'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Outgoing message queue';

-- --------------------------------------------------------

--
-- Table structure for table `OutMessageQueue`
--

DROP TABLE IF EXISTS `OutMessageQueue`;
CREATE TABLE IF NOT EXISTS `OutMessageQueue` (
  `Job_ID` int(10) unsigned NOT NULL,
  `Job_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Job_Type` enum('SMS','WA','WAGC','Call') NOT NULL,
  `Dest_CtyCode` varchar(4) NOT NULL,
  `Dest_Number` varchar(18) NOT NULL,
  `Dest_Message` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Outgoing message queue';

-- --------------------------------------------------------

--
-- Table structure for table `superviser_number`
--

DROP TABLE IF EXISTS `superviser_number`;
CREATE TABLE IF NOT EXISTS `superviser_number` (
  `id` int(100) NOT NULL,
  `number` varchar(25) NOT NULL,
  `number_type` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `SystemEvents`
--

DROP TABLE IF EXISTS `SystemEvents`;
CREATE TABLE IF NOT EXISTS `SystemEvents` (
  `ID` int(10) unsigned NOT NULL,
  `CustomerID` bigint(20) DEFAULT NULL,
  `ReceivedAt` datetime DEFAULT NULL,
  `DeviceReportedTime` datetime DEFAULT NULL,
  `Facility` smallint(6) DEFAULT NULL,
  `Priority` smallint(6) DEFAULT NULL,
  `FromHost` varchar(60) DEFAULT NULL,
  `IP` varchar(128) NOT NULL,
  `Message` text,
  `NTSeverity` int(11) DEFAULT NULL,
  `Importance` int(11) DEFAULT NULL,
  `EventSource` varchar(60) DEFAULT NULL,
  `EventUser` varchar(60) DEFAULT NULL,
  `EventCategory` int(11) DEFAULT NULL,
  `EventID` int(11) DEFAULT NULL,
  `EventBinaryData` text,
  `MaxAvailable` int(11) DEFAULT NULL,
  `CurrUsage` int(11) DEFAULT NULL,
  `MinUsage` int(11) DEFAULT NULL,
  `MaxUsage` int(11) DEFAULT NULL,
  `InfoUnitID` int(11) DEFAULT NULL,
  `SysLogTag` varchar(60) DEFAULT NULL,
  `EventLogType` varchar(60) DEFAULT NULL,
  `GenericFileName` varchar(60) DEFAULT NULL,
  `SystemID` int(11) DEFAULT NULL,
  `Processed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `SystemEventsProperties`
--

DROP TABLE IF EXISTS `SystemEventsProperties`;
CREATE TABLE IF NOT EXISTS `SystemEventsProperties` (
  `ID` int(10) unsigned NOT NULL,
  `SystemEventID` int(11) DEFAULT NULL,
  `ParamName` varchar(255) DEFAULT NULL,
  `ParamValue` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ul_blocked_ips`
--

DROP TABLE IF EXISTS `ul_blocked_ips`;
CREATE TABLE IF NOT EXISTS `ul_blocked_ips` (
  `ip` varchar(39) CHARACTER SET ascii NOT NULL,
  `block_expires` varchar(26) CHARACTER SET ascii NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ul_log`
--

DROP TABLE IF EXISTS `ul_log`;
CREATE TABLE IF NOT EXISTS `ul_log` (
  `timestamp` varchar(26) CHARACTER SET ascii NOT NULL,
  `action` varchar(20) CHARACTER SET ascii NOT NULL,
  `comment` varchar(255) CHARACTER SET ascii NOT NULL DEFAULT '',
  `user` varchar(400) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(39) CHARACTER SET ascii NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ul_logins`
--

DROP TABLE IF EXISTS `ul_logins`;
CREATE TABLE IF NOT EXISTS `ul_logins` (
  `id` int(11) NOT NULL,
  `username` varchar(400) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(2048) CHARACTER SET ascii NOT NULL,
  `date_created` varchar(26) CHARACTER SET ascii NOT NULL,
  `last_login` varchar(26) CHARACTER SET ascii NOT NULL,
  `block_expires` varchar(26) CHARACTER SET ascii NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ul_nonces`
--

DROP TABLE IF EXISTS `ul_nonces`;
CREATE TABLE IF NOT EXISTS `ul_nonces` (
  `code` varchar(100) CHARACTER SET ascii NOT NULL,
  `action` varchar(850) CHARACTER SET ascii NOT NULL,
  `nonce_expires` varchar(26) CHARACTER SET ascii NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ul_sessions`
--

DROP TABLE IF EXISTS `ul_sessions`;
CREATE TABLE IF NOT EXISTS `ul_sessions` (
  `id` varchar(128) CHARACTER SET ascii NOT NULL DEFAULT '',
  `data` blob NOT NULL,
  `session_expires` varchar(26) CHARACTER SET ascii NOT NULL,
  `lock_expires` varchar(26) CHARACTER SET ascii NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `WAGroupChats`
--

DROP TABLE IF EXISTS `WAGroupChats`;
CREATE TABLE IF NOT EXISTS `WAGroupChats` (
  `id` int(100) NOT NULL,
  `group_names` varchar(100) NOT NULL,
  `group_code` varchar(100) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ConfigData`
--
ALTER TABLE `ConfigData`
  ADD PRIMARY KEY (`Config_Key`);

--
-- Indexes for table `IncomingEmail`
--
ALTER TABLE `IncomingEmail`
  ADD PRIMARY KEY (`Email_ID`);

--
-- Indexes for table `IncomingSMS`
--
ALTER TABLE `IncomingSMS`
  ADD PRIMARY KEY (`SMS_ID`);

--
-- Indexes for table `IncomingWA`
--
ALTER TABLE `IncomingWA`
  ADD PRIMARY KEY (`WA_ID`);

--
-- Indexes for table `Keywords`
--
ALTER TABLE `Keywords`
  ADD PRIMARY KEY (`Keyword_ID`);

--
-- Indexes for table `KeywordsActions`
--
ALTER TABLE `KeywordsActions`
  ADD PRIMARY KEY (`Keyword_ID`,`Action_Type`,`Dest_CtyCode`,`Dest_Number`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Modules`
--
ALTER TABLE `Modules`
  ADD PRIMARY KEY (`SN`);

--
-- Indexes for table `OutMessageCompleted`
--
ALTER TABLE `OutMessageCompleted`
  ADD PRIMARY KEY (`Job_ID`);

--
-- Indexes for table `OutMessageQueue`
--
ALTER TABLE `OutMessageQueue`
  ADD PRIMARY KEY (`Job_ID`);

--
-- Indexes for table `superviser_number`
--
ALTER TABLE `superviser_number`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `SystemEvents`
--
ALTER TABLE `SystemEvents`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `SystemEventsProperties`
--
ALTER TABLE `SystemEventsProperties`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ul_blocked_ips`
--
ALTER TABLE `ul_blocked_ips`
  ADD PRIMARY KEY (`ip`);

--
-- Indexes for table `ul_logins`
--
ALTER TABLE `ul_logins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`(255));

--
-- Indexes for table `ul_nonces`
--
ALTER TABLE `ul_nonces`
  ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `action` (`action`(255));

--
-- Indexes for table `ul_sessions`
--
ALTER TABLE `ul_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `WAGroupChats`
--
ALTER TABLE `WAGroupChats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_code` (`group_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `IncomingEmail`
--
ALTER TABLE `IncomingEmail`
  MODIFY `Email_ID` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `IncomingSMS`
--
ALTER TABLE `IncomingSMS`
  MODIFY `SMS_ID` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `IncomingWA`
--
ALTER TABLE `IncomingWA`
  MODIFY `WA_ID` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Keywords`
--
ALTER TABLE `Keywords`
  MODIFY `Keyword_ID` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Modules`
--
ALTER TABLE `Modules`
  MODIFY `SN` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `OutMessageCompleted`
--
ALTER TABLE `OutMessageCompleted`
  MODIFY `Job_ID` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `OutMessageQueue`
--
ALTER TABLE `OutMessageQueue`
  MODIFY `Job_ID` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `superviser_number`
--
ALTER TABLE `superviser_number`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `SystemEvents`
--
ALTER TABLE `SystemEvents`
  MODIFY `ID` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `SystemEventsProperties`
--
ALTER TABLE `SystemEventsProperties`
  MODIFY `ID` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ul_logins`
--
ALTER TABLE `ul_logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `WAGroupChats`
--
ALTER TABLE `WAGroupChats`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
