-- Host: localhost
-- Database: `StockInfo`
--
CREATE DATABASE IF NOT EXISTS `StockInfo` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `StockInfo`;
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
  `Volume` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Time_Series_Daily_Adjusted`
--

CREATE TABLE `Time_Series_Daily_Adjusted` (
  `atr_stock_id` varchar(6) COLLATE utf8_bin NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Open` decimal(10,3) NOT NULL,
  `High` decimal(10,3) NOT NULL,
  `Low` decimal(10,3) NOT NULL,
  `Close` decimal(10,3) NOT NULL,
  `Volume` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Time_Series_Intradaily`
--

CREATE TABLE `Time_Series_Intradaily` (
  `atr_stock_id` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Open` decimal(10,3) NOT NULL,
  `High` decimal(10,3) NOT NULL,
  `Low` decimal(10,3) NOT NULL,
  `Close` decimal(10,3) NOT NULL,
  `Volume` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
--------------------------------------------------------

--
-- Table structure for table `Time_Series_Weeky`
--

CREATE TABLE `Time_Series_Weeky` (
  `atr_stock_id` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Open` decimal(10,3) NOT NULL,
  `High` decimal(10,3) NOT NULL,
  `Low` decimal(10,3) NOT NULL,
  `Close` decimal(10,3) NOT NULL,
  `Volume` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;