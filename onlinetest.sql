-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 09, 2016 at 04:41 PM
-- Server version: 1.0.110
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `exams`
--

-- --------------------------------------------------------

--
-- Table structure for table `exampaper`
--

CREATE TABLE IF NOT EXISTS `exampaper` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Action` enum('Active','DeActive') NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `exampaper`
--


-- --------------------------------------------------------

--
-- Table structure for table `exam_question`
--

CREATE TABLE IF NOT EXISTS `exam_question` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `EID` int(11) NOT NULL,
  `QID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `exam_question`
--


-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`ID`, `Name`) VALUES
(1, 'Student'),
(2, 'Instructor'),
(4, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `QID` int(11) NOT NULL AUTO_INCREMENT,
  `Question` mediumtext NOT NULL,
  `Points` decimal(10,0) NOT NULL,
  PRIMARY KEY (`QID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `questions`
--


-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE IF NOT EXISTS `quiz` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `EID` int(11) NOT NULL,
  `UID` int(11) NOT NULL,
  `Question` mediumtext NOT NULL,
  `Right_Answer` mediumtext NOT NULL,
  `User_Answer` mediumtext NOT NULL,
  `QID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Points` decimal(10,0) NOT NULL,
  `Status` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `quiz`
--


-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE IF NOT EXISTS `result` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Student_ID` int(11) NOT NULL,
  `Teacher_ID` int(11) NOT NULL,
  `Exam_ID` int(11) NOT NULL,
  `Feedback` mediumtext NOT NULL,
  `Grade` varchar(255) NOT NULL,
  `Points` decimal(10,0) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `result`
--


-- --------------------------------------------------------

--
-- Table structure for table `solutions`
--

CREATE TABLE IF NOT EXISTS `solutions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `QID` int(11) NOT NULL,
  `Solution` mediumtext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `solutions`
--



--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `groupid`, `Name`, `Email`, `Password`) VALUES
(1, 1, 'Student', 'student@gmail.com', 'student'),
(2, 2, 'Instructor', 'instructor@gmail.com', 'instructor'),
(4, 4, 'admin', 'admin@gmail.com', 'Admin');

