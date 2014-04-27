-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 23, 2014 at 12:20 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pitchhub`
--
CREATE DATABASE IF NOT EXISTS `pitchhub` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `pitchhub`;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `companyid` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`companyid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE IF NOT EXISTS `job` (
  `jobid` int(11) NOT NULL AUTO_INCREMENT,
  `jobtitle` varchar(200) NOT NULL,
  `description` varchar(400) NOT NULL,
  PRIMARY KEY (`jobid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jobseeker`
--

CREATE TABLE IF NOT EXISTS `jobseeker` (
  `userid` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `job_jobseeker`
--

CREATE TABLE IF NOT EXISTS `job_jobseeker` (
  `userid` int(11) NOT NULL,
  `jobid` int(11) NOT NULL,
  KEY `userid` (`userid`),
  KEY `jobid` (`jobid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `job_keyword`
--

CREATE TABLE IF NOT EXISTS `job_keyword` (
  `jobid` int(11) NOT NULL,
  `keywordid` int(11) NOT NULL,
  KEY `jobid` (`jobid`),
  KEY `keywordid` (`keywordid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `job_recruiter`
--

CREATE TABLE IF NOT EXISTS `job_recruiter` (
  `userid` int(11) NOT NULL,
  `jobid` int(11) NOT NULL,
  KEY `userid` (`userid`),
  KEY `jobid` (`jobid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `keyword`
--

CREATE TABLE IF NOT EXISTS `keyword` (
  `keywordid` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(50) NOT NULL,
  PRIMARY KEY (`keywordid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `keyword_pitches`
--

CREATE TABLE IF NOT EXISTS `keyword_pitches` (
  `pitchid` int(11) NOT NULL,
  `keywordid` int(11) NOT NULL,
  KEY `pitchid` (`pitchid`),
  KEY `keywordid` (`keywordid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pitches`
--

CREATE TABLE IF NOT EXISTS `pitches` (
  `pitchid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  PRIMARY KEY (`pitchid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `recruiter`
--

CREATE TABLE IF NOT EXISTS `recruiter` (
  `userid` int(11) NOT NULL,
  `companyid` int(11) NOT NULL,
  KEY `userid` (`userid`),
  KEY `companyid` (`companyid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `jobseeker_TF` tinyint(1) NOT NULL,
  `recruiter_TF` tinyint(1) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jobseeker`
--
ALTER TABLE `jobseeker`
  ADD CONSTRAINT `jobseeker_user_fk` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`);

--
-- Constraints for table `job_jobseeker`
--
ALTER TABLE `job_jobseeker`
  ADD CONSTRAINT `jobs_user_fk` FOREIGN KEY (`jobid`) REFERENCES `job` (`jobid`),
  ADD CONSTRAINT `user_jobs_fk` FOREIGN KEY (`userid`) REFERENCES `jobseeker` (`userid`);

--
-- Constraints for table `job_keyword`
--
ALTER TABLE `job_keyword`
  ADD CONSTRAINT `keyword_job_fk` FOREIGN KEY (`keywordid`) REFERENCES `keyword` (`keywordid`),
  ADD CONSTRAINT `job_keyword_fk` FOREIGN KEY (`jobid`) REFERENCES `job` (`jobid`);

--
-- Constraints for table `job_recruiter`
--
ALTER TABLE `job_recruiter`
  ADD CONSTRAINT `recuiter_job_fk` FOREIGN KEY (`jobid`) REFERENCES `job` (`jobid`),
  ADD CONSTRAINT `user_job_fk` FOREIGN KEY (`userid`) REFERENCES `recruiter` (`userid`);

--
-- Constraints for table `keyword_pitches`
--
ALTER TABLE `keyword_pitches`
  ADD CONSTRAINT `pitch_keyword_fk` FOREIGN KEY (`keywordid`) REFERENCES `keyword` (`keywordid`),
  ADD CONSTRAINT `keyword_pitch_fk` FOREIGN KEY (`pitchid`) REFERENCES `pitches` (`pitchid`);

--
-- Constraints for table `pitches`
--
ALTER TABLE `pitches`
  ADD CONSTRAINT `jobseeker_pitches_fk` FOREIGN KEY (`userid`) REFERENCES `jobseeker` (`userid`);

--
-- Constraints for table `recruiter`
--
ALTER TABLE `recruiter`
  ADD CONSTRAINT `recruiter_company_fk` FOREIGN KEY (`companyid`) REFERENCES `company` (`companyid`),
  ADD CONSTRAINT `user_recruiter_fk` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
