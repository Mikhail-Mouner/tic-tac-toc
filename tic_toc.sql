-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2021 at 02:00 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tic_toc`
--

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `game_id` int(20) NOT NULL,
  `player_one` int(20) DEFAULT NULL,
  `player_two` int(20) DEFAULT NULL,
  `win_one` int(10) DEFAULT '0',
  `win_two` int(10) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`game_id`, `player_one`, `player_two`, `win_one`, `win_two`) VALUES
(1, 1, 2, 0, 1),
(2, 3, 4, 0, 0),
(3, 5, 6, 0, 0),
(4, 8, 9, 3, 1),
(5, 10, 11, 0, 0),
(6, 13, 14, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `in_game`
--

CREATE TABLE `in_game` (
  `in_game_id` int(20) NOT NULL,
  `user_id` int(20) DEFAULT NULL,
  `slot` int(11) DEFAULT NULL,
  `game_id` int(20) DEFAULT NULL,
  `type_tic` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `in_game`
--

INSERT INTO `in_game` (`in_game_id`, `user_id`, `slot`, `game_id`, `type_tic`) VALUES
(7, 3, 0, 2, 1),
(8, 4, 4, 2, 0),
(9, 3, 6, 2, 1),
(10, 4, 3, 2, 0),
(11, 3, 5, 2, 1),
(12, 4, 1, 2, 0),
(13, 3, 7, 2, 1),
(14, 4, 8, 2, 0),
(15, 3, 2, 2, 1),
(25, 5, 4, 3, 1),
(26, 6, 0, 3, 0),
(27, 5, 6, 3, 1),
(28, 6, 2, 3, 0),
(29, 5, 1, 3, 1),
(30, 7, 7, 3, 0),
(31, 5, 5, 3, 1),
(32, 7, 3, 3, 0),
(33, 5, 8, 3, 1),
(63, 8, 8, 4, 1),
(64, 9, 4, 4, 0),
(65, 8, 7, 4, 1),
(66, 9, 6, 4, 0),
(67, 8, 2, 4, 1),
(68, 9, 0, 4, 0),
(69, 8, 5, 4, 1),
(70, 11, 4, 5, 1),
(71, 10, 8, 5, 0),
(72, 11, 2, 5, 1),
(73, 10, 6, 5, 0),
(74, 11, 7, 5, 1),
(75, 10, 1, 5, 0),
(76, 11, 3, 5, 1),
(77, 10, 5, 5, 0),
(78, 11, 0, 5, 1),
(95, 13, 0, 6, 1),
(96, 14, 4, 6, 0),
(97, 13, 8, 6, 1),
(98, 14, 1, 6, 0),
(99, 13, 7, 6, 1),
(100, 14, 6, 6, 0),
(101, 13, 2, 6, 1),
(102, 14, 5, 6, 0),
(103, 13, 3, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(20) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `type_tic` int(1) NOT NULL DEFAULT '1',
  `played` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `type_tic`, `played`) VALUES
(1, 'koko', 1, 1),
(2, 'joe', 0, 1),
(3, 'koko', 1, 1),
(4, 'Mi5a', 0, 1),
(5, 'koko', 1, 1),
(6, 'Mi5a', 0, 1),
(7, 'Mi5a', 0, 0),
(8, 'mi5a', 1, 1),
(9, 'koko', 0, 1),
(10, 'mi5a', 0, 1),
(11, 'michael', 1, 1),
(12, 'michael', 0, 0),
(13, 'mi5a', 1, 1),
(14, 'michael', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`game_id`),
  ADD KEY `user_one` (`player_one`),
  ADD KEY `user_two` (`player_two`);

--
-- Indexes for table `in_game`
--
ALTER TABLE `in_game`
  ADD PRIMARY KEY (`in_game_id`),
  ADD KEY `game` (`game_id`),
  ADD KEY `user` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `game_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `in_game`
--
ALTER TABLE `in_game`
  MODIFY `in_game_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `user_one` FOREIGN KEY (`player_one`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_two` FOREIGN KEY (`player_two`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `in_game`
--
ALTER TABLE `in_game`
  ADD CONSTRAINT `game` FOREIGN KEY (`game_id`) REFERENCES `game` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
