-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2023 at 05:23 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todolist`
--

-- --------------------------------------------------------

--
-- Table structure for table `pripada`
--
CREATE DATABASE todolist;

CREATE TABLE `pripada` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pripada`
--

INSERT INTO `pripada` (`user_id`, `group_id`) VALUES
(1, 1),
(1, 24870),
(2, 1),
(2, 24870),
(3, 24871),
(4, 24871),
(11699, 24871);

-- --------------------------------------------------------

--
-- Table structure for table `todo`
--

CREATE TABLE `todo` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `todo` varchar(64) NOT NULL,
  `finished` tinyint(1) NOT NULL,
  `deadline` varchar(64) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `todo`
--

INSERT INTO `todo` (`id`, `owner`, `todo`, `finished`, `deadline`, `group_id`) VALUES
(3, 1, 'gdsgsdg', 1, '2023-09-06', 1),
(6, 1, 'testtttttt', 1, '2023-05-20', 1),
(8, 1, 'konči moped', 0, '2023-05-17', 1),
(14, 1, 'agahahahhag', 1, '2023-06-09', 1),
(15, 1, 'ololo', 1, '2023-07-16', 24870),
(16, 2, 'pejdi spat', 1, '2023-05-07', 1),
(22, 1, 'test', 0, '2023-06-08', 24870),
(23, 3, 'uh oh', 1, '2023-05-25', 24871);

-- --------------------------------------------------------

--
-- Table structure for table `todo_group`
--

CREATE TABLE `todo_group` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `todo_group`
--

INSERT INTO `todo_group` (`id`, `owner`, `name`) VALUES
(1, 1, 'jabadabadu'),
(24870, 1, 'testna skupina'),
(24871, 3, 'guest');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`) VALUES
(1, 'bruih', 'bruih@example.com', 'Geslo2023'),
(2, 'supak', 'supak@example.com', 'geslo'),
(3, 'šefe', 'šefe@example.com', 'g'),
(4, 'guest', 'none@mail.domain', 'guest'),
(11699, 'janez_selski', 'selski_janez@example.com', 'g');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pripada`
--
ALTER TABLE `pripada`
  ADD KEY `user_id` (`user_id`,`group_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `todo_group`
--
ALTER TABLE `todo_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `todo`
--
ALTER TABLE `todo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `todo_group`
--
ALTER TABLE `todo_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24872;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11700;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pripada`
--
ALTER TABLE `pripada`
  ADD CONSTRAINT `pripada_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `pripada_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `todo_group` (`id`);

--
-- Constraints for table `todo`
--
ALTER TABLE `todo`
  ADD CONSTRAINT `todo_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `todo_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `todo_group` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
