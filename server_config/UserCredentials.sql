-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 24, 2018 at 07:36 PM
-- Server version: 5.7.21-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

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
-- Table structure for table `tbl_user_cred`
--

CREATE TABLE `tbl_user_cred` (
  `atr_credid` int(11) NOT NULL,
  `atr_username` varchar(50) COLLATE utf8_bin NOT NULL,
  `atr_password` varchar(50) COLLATE utf8_bin NOT NULL,
  `atr_type` enum('admin','normal','locked') COLLATE utf8_bin NOT NULL DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_user_cred`
--

INSERT INTO `tbl_user_cred` (`atr_credid`, `atr_username`, `atr_password`, `atr_type`) VALUES
(5, 'gheqimi', 'temp12345', 'normal'),
(13, 'test2', 'Testpass1', 'locked'),
(14, 'cole', 'g', 'normal'),
(17, 'cwelland', 'Password1', 'normal');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_info`
--

CREATE TABLE `tbl_user_info` (
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
-- Dumping data for table `tbl_user_info`
--

INSERT INTO `tbl_user_info` (`atr_username`, `atr_first_name`, `atr_last_name`, `atr_email`, `atr_phone`, `atr_street_address`, `atr_city`, `atr_state`, `atr_zip`, `atr_user_key`) VALUES
('cole', 'cole', 'pillars', 'pillarscole@gmail.com', '', '', '', '', '', 'U8d2gjKYPfiyctMAUBt7'),
('cwelland', 'Carl', 'Welland', 'cwelland@oakland.edu', '', '', '', '', '', 'JcHXv5iisi2cha6juCf8'),
('gheqimi', 'Gjergji', 'Heqimi', 'gheqimi@oakland.edu', '', '', '', '', '', 'qFlIQuLiAq8q24fdReYE'),
('test2', 'testname', 'testname', 'testemail@google.com', '', '', '', '', '', 'UxARQjdyVaq37cU5ecEh');

--
-- Indexes for dumped tables
--

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
  ADD UNIQUE KEY `atr_email` (`atr_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_user_cred`
--
ALTER TABLE `tbl_user_cred`
  MODIFY `atr_credid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
