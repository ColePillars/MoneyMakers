-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 19, 2018 at 10:35 PM
-- Server version: 5.7.21-0ubuntu0.16.04.1
-- PHP Version: 7.0.28-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `UserCredentials`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock_subs`
--

CREATE TABLE `tbl_stock_subs` (
  `atr_stocksubid` varchar(50) COLLATE utf8_bin NOT NULL,
  `atr_username` varchar(50) COLLATE utf8_bin NOT NULL,
  `atr_stock_id` varchar(8) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_cred`
--

CREATE TABLE `tbl_user_cred` (
  `atr_credid` int(11) NOT NULL,
  `atr_username` varchar(50) COLLATE utf8_bin NOT NULL,
  `atr_password` varchar(255) COLLATE utf8_bin NOT NULL,
  `atr_type` enum('admin','normal','locked') COLLATE utf8_bin NOT NULL DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_info`
--

CREATE TABLE `tbl_user_info` (
  `atr_user_infoid` int(11) NOT NULL,
  `atr_username` varchar(50) COLLATE utf8_bin NOT NULL,
  `atr_first_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `atr_last_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `atr_email` varchar(50) COLLATE utf8_bin NOT NULL,
  `atr_phone` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `atr_street_address` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `atr_city` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `atr_state` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `atr_zip` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `atr_user_key` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_stock_subs`
--
ALTER TABLE `tbl_stock_subs`
  ADD PRIMARY KEY (`atr_stocksubid`),
  ADD UNIQUE KEY `atr_stocksubid` (`atr_stocksubid`);

--
-- Indexes for table `tbl_user_cred`
--
ALTER TABLE `tbl_user_cred`
  ADD PRIMARY KEY (`atr_credid`),
  ADD UNIQUE KEY `atr_credid` (`atr_credid`),
  ADD UNIQUE KEY `atr_username` (`atr_username`);

--
-- Indexes for table `tbl_user_info`
--
ALTER TABLE `tbl_user_info`
  ADD PRIMARY KEY (`atr_username`),
  ADD UNIQUE KEY `atr_username` (`atr_username`),
  ADD UNIQUE KEY `atr_email` (`atr_email`),
  ADD UNIQUE KEY `atr_user_infoid` (`atr_user_infoid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_user_cred`
--
ALTER TABLE `tbl_user_cred`
  MODIFY `atr_credid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `tbl_user_info`
--
ALTER TABLE `tbl_user_info`
  MODIFY `atr_user_infoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
