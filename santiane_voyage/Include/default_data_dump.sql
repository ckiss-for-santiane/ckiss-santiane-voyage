-- phpMyAdmin SQL Dump

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `santiane_voyage`
--
CREATE DATABASE IF NOT EXISTS `santiane_voyage` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `santiane_voyage`;

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

DROP TABLE IF EXISTS `destinations`;
CREATE TABLE IF NOT EXISTS `destinations` (
  `_rowid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  PRIMARY KEY (`_rowid`),
  KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `destinations`
--

TRUNCATE TABLE `destinations`;
--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`_rowid`, `title`) VALUES
(1, 'Le Tignet'),
(4, 'Londres'),
(2, 'Nice'),
(3, 'Paris'),
(5, 'Noursoultan');

-- --------------------------------------------------------

--
-- Table structure for table `modalities`
--

DROP TABLE IF EXISTS `modalities`;
CREATE TABLE IF NOT EXISTS `modalities` (
  `_rowid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `icon` varchar(64) NOT NULL,
  PRIMARY KEY (`_rowid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `modalities`
--

TRUNCATE TABLE `modalities`;
--
-- Dumping data for table `modalities`
--

INSERT INTO `modalities` (`_rowid`, `title`, `icon`) VALUES
(1, 'À pied', 'modality_foot.png'),
(2, 'Vélo', 'modality_bike.png'),
(3, 'Autobus', 'modality_bus.png'),
(4, 'Voiture', 'modality_car.png'),
(5, 'Train', 'modality_train.png'),
(6, 'Bateau', 'modality_boat.png'),
(7, 'Avion', 'modality_plane.png');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

DROP TABLE IF EXISTS `trips`;
CREATE TABLE IF NOT EXISTS `trips` (
  `_rowid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  PRIMARY KEY (`_rowid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `trips`
--

TRUNCATE TABLE `trips`;
--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`_rowid`, `title`) VALUES
(1, 'C\'est mon premier voyage à Londres');

-- --------------------------------------------------------

--
-- Table structure for table `trips_stops`
--

DROP TABLE IF EXISTS `trips_stops`;
CREATE TABLE IF NOT EXISTS `trips_stops` (
  `_rowid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `trip_id` int(10) UNSIGNED NOT NULL,
  `destination_id` int(10) UNSIGNED NOT NULL,
  `position` mediumint(8) UNSIGNED NOT NULL,
  `modality_id` int(10) UNSIGNED NOT NULL,
  `transportation_number` varchar(64) NOT NULL,
  PRIMARY KEY (`_rowid`),
  KEY `trip_id` (`trip_id`),
  KEY `destination_id` (`destination_id`),
  KEY `modality_id` (`modality_id`),
  KEY `position` (`position`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `trips_stops`
--

TRUNCATE TABLE `trips_stops`;
--
-- Dumping data for table `trips_stops`
--

INSERT INTO `trips_stops` (`_rowid`, `trip_id`, `destination_id`, `position`, `modality_id`) VALUES
(1, 1, 1, 0, 1),
(2, 1, 2, 1, 3),
(3, 1, 4, 3, 7),
(4, 1, 3, 2, 5);

--
-- Constraints for table `trips_stops`
--
ALTER TABLE `trips_stops`
  ADD CONSTRAINT `trip` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`_rowid`),
  ADD CONSTRAINT `destination` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`_rowid`),
  ADD CONSTRAINT `modality` FOREIGN KEY (`modality_id`) REFERENCES `modalities` (`_rowid`);
COMMIT;

