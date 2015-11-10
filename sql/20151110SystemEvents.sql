-- phpMyAdmin SQL Dump
-- version 4.4.15.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 10, 2015 at 03:26 PM
-- Server version: 5.5.44-MariaDB
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `smartMessage`
--

-- --------------------------------------------------------

--
-- Table structure for table `SystemEvents`
--

CREATE TABLE IF NOT EXISTS `SystemEvents` (
  `ID` int(10) unsigned NOT NULL,
  `CustomerID` bigint(20) DEFAULT NULL,
  `ReceivedAt` datetime DEFAULT NULL,
  `DeviceReportedTime` datetime DEFAULT NULL,
  `Facility` smallint(6) DEFAULT NULL,
  `Priority` smallint(6) DEFAULT NULL,
  `FromHost` varchar(60) DEFAULT NULL,
  `ip` varchar(128) NOT NULL,
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
  `SystemID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `SystemEvents`
--
ALTER TABLE `SystemEvents`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `SystemEvents`
--
ALTER TABLE `SystemEvents`
  MODIFY `ID` int(10) unsigned NOT NULL AUTO_INCREMENT;
