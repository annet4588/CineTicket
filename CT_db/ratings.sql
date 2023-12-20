-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2023 at 12:26 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cineticket_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `rating_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `rating_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`rating_id`, `user_id`, `movie_id`, `rating`, `rating_date`) VALUES
(7, 1, 4, 3, '2023-12-08 20:49:13'),
(8, 1, 4, 3, '2023-12-08 20:50:33'),
(9, 1, 7, 2, '2023-12-08 21:08:36'),
(10, 1, 7, 2, '2023-12-08 21:10:36'),
(11, 1, 7, 4, '2023-12-08 21:10:43'),
(12, 1, 7, 4, '2023-12-08 21:17:47'),
(13, 1, 7, 4, '2023-12-08 21:17:53'),
(14, 1, 7, 5, '2023-12-08 21:18:16'),
(15, 1, 3, 5, '2023-12-08 21:21:33'),
(16, 2, 3, 5, '2023-12-08 21:22:22'),
(17, 2, 6, 5, '2023-12-08 21:22:41'),
(18, 2, 5, 4, '2023-12-08 21:23:39'),
(19, 2, 8, 5, '2023-12-08 21:24:35'),
(20, 1, 1, 5, '2023-12-13 16:04:06'),
(21, 1, 2, 3, '2023-12-13 16:14:31'),
(22, 1, 2, 2, '2023-12-13 16:18:24'),
(23, 1, 2, 3, '2023-12-13 16:20:51'),
(24, 1, 2, 4, '2023-12-13 16:21:09'),
(25, 1, 2, 4, '2023-12-13 16:25:40'),
(26, 1, 2, 3, '2023-12-13 16:26:02'),
(27, 1, 2, 5, '2023-12-13 16:33:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
