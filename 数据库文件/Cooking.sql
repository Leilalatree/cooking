-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018-04-28 08:25:34
-- 服务器版本： 5.6.38
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Cooking`
--

-- --------------------------------------------------------

--
-- 表的结构 `Diary`
--

CREATE TABLE `Diary` (
  `diaryID` varchar(20) NOT NULL,
  `diarytitle` varchar(10) NOT NULL,
  `diarycontent` text NOT NULL,
  `diarypicture` varchar(500) NOT NULL,
  `diarynumber` int(11) NOT NULL,
  `diarycomment` text NOT NULL,
  `diarytime` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `Food`
--

CREATE TABLE `Food` (
  `foodclassID` int(10) NOT NULL,
  `foodname` varchar(20) NOT NULL,
  `foodintroduce` text NOT NULL,
  `foodingredient` varchar(500) NOT NULL,
  `foodimage` varchar(500) NOT NULL,
  `foodcookingstep` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `News`
--

CREATE TABLE `News` (
  `newsID` int(10) NOT NULL,
  `newstitle` varchar(10) NOT NULL,
  `newscontent` text NOT NULL,
  `newsdate` datetime(6) NOT NULL,
  `newsdescribe` text NOT NULL,
  `newsimage` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `User`
--

CREATE TABLE `User` (
  `userID` int(11) NOT NULL,
  `username` char(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `userimage` varchar(500) NOT NULL,
  `personalintroduction` text NOT NULL,
  `sex` varchar(2) NOT NULL,
  `job` varchar(10) NOT NULL,
  `age` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `User`
--

INSERT INTO `User` (`userID`, `username`, `password`, `userimage`, `personalintroduction`, `sex`, `job`, `age`) VALUES
(0, '459433186', '123456', '12', '12', '2', '2', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Diary`
--
ALTER TABLE `Diary`
  ADD PRIMARY KEY (`diaryID`);

--
-- Indexes for table `Food`
--
ALTER TABLE `Food`
  ADD PRIMARY KEY (`foodclassID`);

--
-- Indexes for table `News`
--
ALTER TABLE `News`
  ADD PRIMARY KEY (`newsID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
