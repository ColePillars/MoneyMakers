-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 06, 2018 at 12:36 AM
-- Server version: 5.7.21-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

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

--
-- Table structure for table `Time_Series_Crypto_Intraday`
--

CREATE TABLE `Time_Series_Crypto_Intraday` (
  `atr_stock_id` varchar(6) COLLATE utf8_bin NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Price_Market` decimal(20,6) NOT NULL,
  `Price_USD` decimal(20,6) NOT NULL,
  `Volume` decimal(20,6) NOT NULL,
  `Market_Cap_USD` decimal(20,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Table structure for table `Time_Series_Crypto_Monthly`
--

CREATE TABLE `Time_Series_Crypto_Monthly` (
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

--
-- Table structure for table `Time_Series_Crypto_Weekly`
--

CREATE TABLE `Time_Series_Crypto_Weekly` (
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

--
-- Table structure for table `Time_Series_Monthly`
--

CREATE TABLE `Time_Series_Monthly` (
  `atr_stock_id` varchar(6) COLLATE utf8_bin NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Open` decimal(10,3) NOT NULL,
  `High` decimal(10,3) NOT NULL,
  `Low` decimal(10,3) NOT NULL,
  `Close` decimal(10,3) NOT NULL,
  `Volume` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Table structure for table `Time_Series_Monthly_Adjusted`
--

CREATE TABLE `Time_Series_Monthly_Adjusted` (
  `atr_stock_id` varchar(6) COLLATE utf8_bin NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Open` decimal(10,3) NOT NULL,
  `High` decimal(10,3) NOT NULL,
  `Low` decimal(10,3) NOT NULL,
  `Close` decimal(10,3) NOT NULL,
  `Adjusted_Close` decimal(10,3) NOT NULL,
  `Volume` int(11) NOT NULL,
  `Dividend_Amount` decimal(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Table structure for table `Technical_Analysis_RSI`
--

CREATE TABLE `Technical_Analysis_RSI` (
  `atr_stock_id` varchar(6) COLLATE utf8_bin NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `RSI` decimal(20,6) NOT NULL,
  `Composite_Key` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Table structure for table `Buy_Sell_Hold`
--

CREATE TABLE `Buy_Sell_Hold` (
  `Symbol` varchar(6) COLLATE utf8_bin NOT NULL,
  `Two_Period_RSI` enum('Buy','Sell','Hold') COLLATE utf8_bin NOT NULL,
  `Heikin_Ashi` enum('Buy','Sell','Hold') COLLATE utf8_bin NOT NULL,
  `other_method` enum('Buy','Sell','Hold') COLLATE utf8_bin NOT NULL,
  `Final_Decision` enum('Buy','Sell','Hold') COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Table structure for table `Simulation`
--

CREATE TABLE `Simulation` (
  `Symbol` varchar(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Close` decimal(10,3) NOT NULL,
  `Final_Decision` enum('Buy','Sell','Hold') COLLATE utf8_bin NOT NULL,
  `Composite_Key` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


