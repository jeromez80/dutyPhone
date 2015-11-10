-- phpMyAdmin SQL Dump
-- version 4.4.15.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 10, 2015 at 02:16 PM
-- Server version: 5.5.44-MariaDB
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `smartMessage`
--

-- --------------------------------------------------------

--
-- Table structure for table `ConfigData`
--

CREATE TABLE IF NOT EXISTS `ConfigData` (
  `Config_Key` varchar(32) NOT NULL,
  `Config_Value` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Store configuration data using Key-Value pairs';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ConfigData`
--
ALTER TABLE `ConfigData`
  ADD PRIMARY KEY (`Config_Key`);

DROP TABLE `mmg_phone_numbers`;
