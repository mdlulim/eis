-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2017 at 09:20 AM
-- Server version: 5.6.11
-- PHP Version: 5.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `greg_uat`
--
CREATE DATABASE IF NOT EXISTS `greg_uat` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `greg_uat`;

-- --------------------------------------------------------

--
-- Table structure for table `oc_team`
--

CREATE TABLE IF NOT EXISTS `oc_team` (
  `team_id` int(6) NOT NULL AUTO_INCREMENT,
  `team_name` varchar(255) NOT NULL,
  `sales_manager` int(11) NOT NULL,
  PRIMARY KEY (`team_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `oc_team`
--

INSERT INTO `oc_team` (`team_id`, `team_name`, `sales_manager`) VALUES
(2, 'test', 6),
(4, 'Safety Team', 5);

-- --------------------------------------------------------

--
-- Table structure for table `oc_team_to_user`
--

CREATE TABLE IF NOT EXISTS `oc_team_to_user` (
  `user_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
