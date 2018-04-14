-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 14, 2018 at 06:09 PM
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
-- Table structure for table `tbl_stock_subs`
--

CREATE TABLE `tbl_stock_subs` (
  `atr_stocksubid` varchar(50) COLLATE utf8_bin NOT NULL,
  `atr_username` varchar(50) COLLATE utf8_bin NOT NULL,
  `atr_stock_id` varchar(8) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_stock_subs`
--

INSERT INTO `tbl_stock_subs` (`atr_stocksubid`, `atr_username`, `atr_stock_id`) VALUES
('Cole_AA', 'Cole', 'AA'),
('Cole_AAC', 'Cole', 'AAC'),
('Cole_APA', 'Cole', 'APA'),
('Cole_F', 'Cole', 'F'),
('Cole_HGH', 'Cole', 'HGH'),
('Cole_JONE', 'Cole', 'JONE'),
('Cole_NTEST', 'Cole', 'NTEST'),
('Cole_ZYME', 'Cole', 'ZYME'),
('Edle_AA', 'Edle', 'AA'),
('Edle_ACC', 'Edle', 'ACC'),
('Edle_F', 'Edle', 'F'),
('testing_AAN', 'testing', 'AAN'),
('testing_ABBV', 'testing', 'ABBV'),
('testing_ABM', 'testing', 'ABM'),
('testing_ACCO', 'testing', 'ACCO'),
('testing_ACN', 'testing', 'ACN'),
('testing_ACP', 'testing', 'ACP'),
('testing_ADX', 'testing', 'ADX'),
('testing_AEK', 'testing', 'AEK'),
('testing_AEM', 'testing', 'AEM'),
('testing_AHP^B', 'testing', 'AHP^B'),
('testing_AHT^I', 'testing', 'AHT^I'),
('testing_ALEX', 'testing', 'ALEX'),
('testing_ATEN', 'testing', 'ATEN'),
('testing_BA', 'testing', 'BA'),
('testing_BB', 'testing', 'BB'),
('testing_CRD.A', 'testing', 'CRD.A'),
('testing_DDD', 'testing', 'DDD'),
('testing_F', 'testing', 'F'),
('testing_FIT', 'testing', 'FIT'),
('testing_HPE', 'testing', 'HPE'),
('testing_ORCL', 'testing', 'ORCL'),
('testing_RHT', 'testing', 'RHT'),
('testing_TWTR', 'testing', 'TWTR');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_stock_subs`
--
ALTER TABLE `tbl_stock_subs`
  ADD PRIMARY KEY (`atr_stocksubid`),
  ADD UNIQUE KEY `atr_stocksubid` (`atr_stocksubid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
