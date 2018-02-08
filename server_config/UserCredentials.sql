-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 06, 2018 at 12:38 AM
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
  `atr_password` varchar(255) COLLATE utf8_bin NOT NULL,
  `atr_type` enum('admin','normal','locked') COLLATE utf8_bin NOT NULL DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_user_cred`
--

INSERT INTO `tbl_user_cred` (`atr_credid`, `atr_username`, `atr_password`, `atr_type`) VALUES
(3, 'Test', 'Testpass1', 'locked'),
(4, 'Test2', 'Testpass1', 'locked'),
(5, 'Test3', 'Testpass1', 'normal'),
(6, 'gheqimi', 'TestingMore1', 'normal'),
(7, 'Test4', 'Testpass1', 'normal'),
(8, 'Test5', 'Testpass1', 'locked'),
(10, 'Test6', 'Testpass1', 'locked'),
(12, 'Test7', 'Testpass1', 'locked'),
(14, 'Test8', 'Testpass1', 'locked'),
(17, 'JoJo', 'Testing1', 'normal'),
(18, 'Test87', 'Testpass1', 'locked'),
(19, 'test45', '3d1c3dba245090c2b57e5d5e597c659c94e92997b6586d3218484afd51ac5a1e615fc30c26a15586aa8a6fe4a43dd63ff05886c101dec9ca6e39000503fa6aae', 'locked'),
(37, 'Cole', '$2y$10$Nyb.1BkcQKHElYL5P4iV8e.N9FnoV6c9kic2lKoiY4Or1UbI9Zfda', 'normal');

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
-- Dumping data for table `tbl_user_info`
--

INSERT INTO `tbl_user_info` (`atr_user_infoid`, `atr_username`, `atr_first_name`, `atr_last_name`, `atr_email`, `atr_phone`, `atr_street_address`, `atr_city`, `atr_state`, `atr_zip`, `atr_user_key`) VALUES
(38, 'Cole', 'cole', 'pillars', 'pillarscole@gmail.com', '', '', '', '', '', 'hnUHR111QDWc6nrDtM0S'),
(17, 'JoJo', 'Jonathan', 'Joestar', 'edle@oakland.edu', '', '', '', '', '', 'NVhbmYDA191wY95gThdC'),
(3, 'Test', 'test', 'test', 'testemail@gmail.com', '', '', '', '', '', 'LsWTyAEIwTnliL2FfcPE'),
(4, 'Test2', 'Test', 'Test', 'testemail2@gmail.com', '', '', '', '', '', 'mu9z42OE9YXzGxACnRMA'),
(5, 'Test3', 'Test', 'Test', 'testemail3@gmail.com', '', '', '', '', '', 'oLf9OVp0L403PvCBKGj2'),
(7, 'Test4', 'test', 'test', 'testemail4@gmail.com', '', '', '', '', '', '7Y4pPY31PS4NVGAOfYqN'),
(9, 'Test5', 'test', 'test', 'testemail5@gmail.com', '', '', '', '', '', 'tZfSbjyBMySDAhq22WGs'),
(11, 'Test6', 'test', 'test', 'testemail6@gmail.com', '', '', '', '', '', 'Cls2chRMd6N00jlf2qq5'),
(13, 'Test7', 'test', 'test', 'testemail7@gmail.com', '', '', '', '', '', 'gT9noi07n4KSVtZsqZcO'),
(14, 'Test8', 'test', 'test', 'testemail8@gmail.com', '', '', '', '', '', 'InGhB6txDlNxuaVMb3ag'),
(18, 'Test87', 'test', 'test', 'testemail87@gmail.com', '', '', '', '', '', 'f7TfeAemV8JxODN2wPLZ'),
(6, 'gheqimi', 'Gjergji', 'Heqimi', 'gheqimi@oakland.edu', '', '', '', '', '', 'CClLHWByGOWTgWntInnE'),
(20, 'test45', 'test', 'test', 'testemail45@gmail.com', '', '', '', '', '', 'xelKsXQNqscZYdVTOinm');

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
  ADD UNIQUE KEY `atr_email` (`atr_email`),
  ADD UNIQUE KEY `atr_user_infoid` (`atr_user_infoid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_user_cred`
--
ALTER TABLE `tbl_user_cred`
  MODIFY `atr_credid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `tbl_user_info`
--
ALTER TABLE `tbl_user_info`
  MODIFY `atr_user_infoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
