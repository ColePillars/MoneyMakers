-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 19, 2018 at 10:33 PM
-- Server version: 5.7.21-0ubuntu0.16.04.1
-- PHP Version: 7.0.28-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `StockInfo`
--

-- --------------------------------------------------------

--
-- Table structure for table `Buy_Sell_Hold`
--

CREATE TABLE `Buy_Sell_Hold` (
  `Symbol` varchar(6) COLLATE utf8_bin NOT NULL,
  `Two_Period_RSI` enum('Buy','Sell','Hold') COLLATE utf8_bin NOT NULL DEFAULT 'Hold',
  `Heikin_Ashi` enum('Buy','Sell','Hold') COLLATE utf8_bin NOT NULL DEFAULT 'Hold',
  `Narrow_Range` enum('Buy','Sell','Hold') COLLATE utf8_bin NOT NULL DEFAULT 'Hold',
  `Final_Decision` enum('Buy','Sell','Hold') COLLATE utf8_bin NOT NULL DEFAULT 'Hold'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Simulation`
--

CREATE TABLE `Simulation` (
  `Symbol` varchar(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Close` decimal(10,3) NOT NULL,
  `Final_Decision` enum('Buy','Sell','Hold') COLLATE utf8_bin NOT NULL DEFAULT 'Hold',
  `Composite_Key` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Stock_Symbol_Index`
--

CREATE TABLE `Stock_Symbol_Index` (
  `Symbol` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Sector` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Industry` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Technical_Analysis_RSI`
--

CREATE TABLE `Technical_Analysis_RSI` (
  `atr_stock_id` varchar(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `RSI` decimal(20,6) NOT NULL,
  `Composite_Key` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Time_Series_Crypto_Daily`
--

CREATE TABLE `Time_Series_Crypto_Daily` (
  `atr_stock_id` varchar(6) COLLATE utf8_bin NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Open_Market` decimal(20,6) NOT NULL,
  `Open_USD` decimal(20,6) NOT NULL,
  `High_Market` decimal(20,6) NOT NULL,
  `High_USD` decimal(20,6) NOT NULL,
  `Low_Market` decimal(20,6) NOT NULL,
  `Low_USD` decimal(20,6) NOT NULL,
  `Close_Market` decimal(20,6) NOT NULL,
  `Close_USD` decimal(20,6) NOT NULL,
  `Volume` decimal(20,6) NOT NULL,
  `Market_Cap_USD` decimal(20,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Time_Series_Daily`
--

CREATE TABLE `Time_Series_Daily` (
  `atr_stock_id` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Open` decimal(10,3) NOT NULL,
  `High` decimal(10,3) NOT NULL,
  `Low` decimal(10,3) NOT NULL,
  `Close` decimal(10,3) NOT NULL,
  `Volume` int(11) NOT NULL,
  `Composite_Key` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Buy_Sell_Hold`
--
ALTER TABLE `Buy_Sell_Hold`
  ADD PRIMARY KEY (`Symbol`);

--
-- Indexes for table `Simulation`
--
ALTER TABLE `Simulation`
  ADD PRIMARY KEY (`Composite_Key`);

--
-- Indexes for table `Technical_Analysis_RSI`
--
ALTER TABLE `Technical_Analysis_RSI`
  ADD PRIMARY KEY (`Composite_Key`);

--
-- Indexes for table `Time_Series_Daily`
--
ALTER TABLE `Time_Series_Daily`
  ADD PRIMARY KEY (`Composite_Key`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
