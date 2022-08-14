-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 12, 2022 at 07:17 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esenceweb_cart_task_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `MTCartProduct`
--

CREATE TABLE `MTCartProduct` (
  `uidPK` char(32) CHARACTER SET ascii NOT NULL,
  `uidSalt` char(32) CHARACTER SET ascii NOT NULL,
  `uidCartFK` char(32) CHARACTER SET ascii NOT NULL,
  `uidProductFK` char(32) CHARACTER SET ascii NOT NULL,
  `rPrice` decimal(5,2) UNSIGNED NOT NULL,
  `nQuantity` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `MTCartProduct`:
--   `uidCartFK`
--       `TCart` -> `uidPK`
--   `uidProductFK`
--       `TProduct` -> `uidPK`
--

-- --------------------------------------------------------

--
-- Table structure for table `TCart`
--

CREATE TABLE `TCart` (
  `uidPK` char(32) CHARACTER SET ascii NOT NULL,
  `uidSalt` char(32) CHARACTER SET ascii NOT NULL,
  `bStatus` smallint(6) NOT NULL,
  `uidSessionFK` char(32) CHARACTER SET ascii NOT NULL,
  `dtCreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `TCart`:
--   `uidSessionFK`
--       `TSession` -> `uidPK`
--

-- --------------------------------------------------------

--
-- Table structure for table `TProduct`
--

CREATE TABLE `TProduct` (
  `uidPK` char(32) CHARACTER SET ascii NOT NULL,
  `uidSalt` char(32) CHARACTER SET ascii NOT NULL,
  `bStatus` smallint(6) NOT NULL,
  `sName` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `rPrice` decimal(5,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `TProduct`:
--

-- --------------------------------------------------------

--
-- Table structure for table `TSession`
--

CREATE TABLE `TSession` (
  `uidPK` char(32) CHARACTER SET ascii NOT NULL,
  `uidSalt` char(32) CHARACTER SET ascii NOT NULL,
  `bStatus` smallint(6) NOT NULL,
  `sUserName` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `dtSessionStart` datetime NOT NULL,
  `dtSessionValidTill` datetime NOT NULL,
  `sClientInfo` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `TSession`:
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `MTCartProduct`
--
ALTER TABLE `MTCartProduct`
  ADD PRIMARY KEY (`uidPK`),
  ADD UNIQUE KEY `uidSalt` (`uidSalt`),
  ADD KEY `MTCartProduct_TCart` (`uidCartFK`),
  ADD KEY `MTCartProduct_TProduct` (`uidProductFK`);

--
-- Indexes for table `TCart`
--
ALTER TABLE `TCart`
  ADD PRIMARY KEY (`uidPK`),
  ADD UNIQUE KEY `uidSalt` (`uidSalt`),
  ADD KEY `TCart_TSession` (`uidSessionFK`);

--
-- Indexes for table `TProduct`
--
ALTER TABLE `TProduct`
  ADD PRIMARY KEY (`uidPK`),
  ADD UNIQUE KEY `uidSalt` (`uidSalt`),
  ADD KEY `sName` (`sName`);

--
-- Indexes for table `TSession`
--
ALTER TABLE `TSession`
  ADD PRIMARY KEY (`uidPK`),
  ADD UNIQUE KEY `uidSalt` (`uidSalt`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `MTCartProduct`
--
ALTER TABLE `MTCartProduct`
  ADD CONSTRAINT `MTCartProduct_TCart` FOREIGN KEY (`uidCartFK`) REFERENCES `TCart` (`uidPK`),
  ADD CONSTRAINT `MTCartProduct_TProduct` FOREIGN KEY (`uidProductFK`) REFERENCES `TProduct` (`uidPK`);

--
-- Constraints for table `TCart`
--
ALTER TABLE `TCart`
  ADD CONSTRAINT `TCart_TSession` FOREIGN KEY (`uidSessionFK`) REFERENCES `TSession` (`uidPK`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
