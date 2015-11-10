-- phpMyAdmin SQL Dump
-- version 4.4.15.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 10, 2015 at 02:11 PM
-- Server version: 5.5.44-MariaDB
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `smartMessage`
--

-- --------------------------------------------------------

--
-- Table structure for table `OutMessageQueue`
--

CREATE TABLE IF NOT EXISTS `OutMessageQueue` (
  `Job_ID` int(10) unsigned NOT NULL,
  `Job_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Job_Type` enum('SMS','WA','WAGC','Call') NOT NULL,
  `Dest_CtyCode` varchar(4) NOT NULL,
  `Dest_Number` varchar(18) NOT NULL,
  `Dest_Message` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Outgoing message queue';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `OutMessageQueue`
--
ALTER TABLE `OutMessageQueue`
  ADD PRIMARY KEY (`Job_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `OutMessageQueue`
--
ALTER TABLE `OutMessageQueue`
  MODIFY `Job_ID` int(10) unsigned NOT NULL AUTO_INCREMENT;
