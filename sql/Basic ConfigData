-- phpMyAdmin SQL Dump
-- version 4.4.15.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 03, 2016 at 11:25 PM
-- Server version: 5.5.44-MariaDB
-- PHP Version: 5.5.30

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
-- Dumping data for table `ConfigData`
--

INSERT INTO `ConfigData` (`Config_Key`, `Config_Value`) VALUES
('Duty_Num', '+6591234567'),
('GSM_Baud', '115200'),
('GSM_Port', '/dev/ttyUSB1'),
('IP_Addr', '10.0.0.10'),
('IP_DNS', '8.8.8.8'),
('IP_Gateway', '10.0.0.1'),
('Last_Num', '+6591234567'),
('SIM_PIN', ''),
('SMSC_Num', '+6596845997'),
('SMTP_IP', '12.34.56.78'),
('SMTP_Port', '25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ConfigData`
--
ALTER TABLE `ConfigData`
  ADD PRIMARY KEY (`Config_Key`);
