-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 05, 2020 at 12:11 AM
-- Server version: 5.7.21
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onfonsimulation`
--

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

DROP TABLE IF EXISTS `details`;
CREATE TABLE IF NOT EXISTS `details` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `edu_level` varchar(10) DEFAULT NULL,
  `profesion` varchar(10) DEFAULT NULL,
  `religion` varchar(10) DEFAULT NULL,
  `tribe` varchar(10) DEFAULT NULL,
  `user_id` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FKdetails967215` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `details`
--

INSERT INTO `details` (`id`, `edu_level`, `profesion`, `religion`, `tribe`, `user_id`) VALUES
(1, 'degree', 'software', 'indigenous', 'samia', '0770691484'),
(2, 'diploma', 'accountant', 'married', 'protestant', '077091238'),
(3, 'diploma', 'accountant', 'single', 'catholic', '0791226712'),
(4, 'bachelor', 'doctor', 'single', 'moslem', '0791226716'),
(5, 'masters', 'doctor', 'single', 'protestant', '0791226710'),
(6, 'bachelor', 'engineer', 'single', 'Mulokole', '0791226719'),
(7, 'bachelor', 'lawyer', 'single', 'christian', '0791226819');

-- --------------------------------------------------------

--
-- Table structure for table `hits`
--

DROP TABLE IF EXISTS `hits`;
CREATE TABLE IF NOT EXISTS `hits` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `searched_by` varchar(15) NOT NULL,
  `interest` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hits`
--

INSERT INTO `hits` (`id`, `searched_by`, `interest`, `created_at`) VALUES
(1, '0770691484', '0791226719', '2020-07-04 21:47:19'),
(2, '0770691484', '0770691484', '2020-07-04 23:35:53'),
(6, '0770691484', '0791226712', '2020-07-04 23:56:06');

-- --------------------------------------------------------

--
-- Table structure for table `system_users`
--

DROP TABLE IF EXISTS `system_users`;
CREATE TABLE IF NOT EXISTS `system_users` (
  `user_id` varchar(15) NOT NULL,
  `user_name` varchar(20) DEFAULT NULL,
  `user_gender` varchar(6) DEFAULT NULL,
  `age` int(2) DEFAULT NULL,
  `pronvince` varchar(10) DEFAULT NULL,
  `town` varchar(10) DEFAULT NULL,
  `last_active` timestamp NULL DEFAULT NULL,
  `account_status` int(1) DEFAULT NULL,
  `description` varchar(160) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_users`
--

INSERT INTO `system_users` (`user_id`, `user_name`, `user_gender`, `age`, `pronvince`, `town`, `last_active`, `account_status`, `description`) VALUES
('0752285142', 'xavio', 'male', 23, 'Kampala', 'Najeera', '2020-07-04 23:25:09', 1, NULL),
('0770691484', 'Atalemwa', 'male', 22, 'kampala', 'kansanga', '2020-07-04 23:56:06', 1, ' inteligent,tall and handsome'),
('077091238', 'Emily', 'female', 40, 'Kampala', 'Bwaise', '2020-07-02 19:09:54', 1, 'MYSELF lovely,light skinned, sexy ,tall,water'),
('0791226710', 'Molly', 'female', 34, 'Wakiso', 'matuga', '2020-07-03 22:59:22', 1, ' jolly,sexy and good in bed'),
('0791226712', 'Shielah', 'female', 26, 'Kampala', 'Seguku', '2020-07-03 22:38:14', 1, 'MYSELF cute,bubbly, make you tick'),
('0791226716', 'Juma', 'male', 25, 'Kampala', 'Bukoto', '2020-07-03 22:47:51', 1, 'MYSELF loyal,Jolly and handsome'),
('0791226719', 'Mirembe', 'female', 26, 'Kampala', 'Kajansi', '2020-07-03 23:03:56', 1, ' brown skined , nice body , good in bed '),
('0791226819', 'Joan', 'female', 26, 'Kampala', 'Kansanga', '2020-07-03 23:08:21', 1, ' open, loyal and beautiful ');

-- --------------------------------------------------------

--
-- Table structure for table `user_messages`
--

DROP TABLE IF EXISTS `user_messages`;
CREATE TABLE IF NOT EXISTS `user_messages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(15) NOT NULL,
  `message` varchar(160) DEFAULT NULL,
  `reply` varchar(160) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `last_updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FKuser_messa299139` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_messages`
--

INSERT INTO `user_messages` (`id`, `user_id`, `message`, `reply`, `created_at`, `last_updated`) VALUES
(1, '0770691484', 'match#22-40#Kampala', NULL, '2020-07-04 09:43:29', '2020-07-04 09:43:29'),
(2, '0770691484', 'match#30-20#Kampala', NULL, '2020-07-04 09:44:56', '2020-07-04 09:44:56'),
(3, '0770691484', 'match#30-20#Kampala', NULL, '2020-07-04 09:51:50', '2020-07-04 09:51:50'),
(5, '0770691484', 'match#20-60#Kampala', NULL, '2020-07-04 12:20:47', '2020-07-04 12:20:47'),
(6, '0752285142', 'match#20-45#Kampala', NULL, '2020-07-04 12:36:43', '2020-07-04 12:36:43'),
(7, '0752285142', 'match#20-50#Kampala', NULL, '2020-07-04 13:30:55', '2020-07-04 13:30:55'),
(8, '0752285142', 'match#20-45#Kampala', NULL, '2020-07-04 23:24:23', '2020-07-04 23:24:23'),
(9, '0770691484', 'match#20-30#Kampala', NULL, '2020-07-04 23:36:37', '2020-07-04 23:36:37'),
(10, '0770691484', 'Match#20-25#Kampala', NULL, '2020-07-04 23:47:10', '2020-07-04 23:47:10'),
(11, '0770691484', 'Match#20-30#Kampala', NULL, '2020-07-04 23:47:29', '2020-07-04 23:47:29');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `details`
--
ALTER TABLE `details`
  ADD CONSTRAINT `FKdetails967215` FOREIGN KEY (`user_id`) REFERENCES `system_users` (`user_id`);

--
-- Constraints for table `user_messages`
--
ALTER TABLE `user_messages`
  ADD CONSTRAINT `FKuser_messa299139` FOREIGN KEY (`user_id`) REFERENCES `system_users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
