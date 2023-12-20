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
-- Table structure for table `movie_bookings`
--

CREATE TABLE `movie_bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `movie_title` varchar(255) NOT NULL,
  `booking_date` date NOT NULL,
  `selected_movie_date` varchar(255) DEFAULT NULL,
  `selected_time` time NOT NULL,
  `selected_seats` varchar(20) NOT NULL,
  `tickets_quantity` int(11) NOT NULL DEFAULT 1,
  `total_price` decimal(8,2) NOT NULL,
  `selected_payment_method` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie_bookings`
--

INSERT INTO `movie_bookings` (`booking_id`, `user_id`, `movie_id`, `movie_title`, `booking_date`, `selected_movie_date`, `selected_time`, `selected_seats`, `tickets_quantity`, `total_price`, `selected_payment_method`) VALUES
(298, 1, 1, 'Plane (2023)', '2023-12-06', '20 Nov', '15:00:00', '[\"A1\",\"A2\"]', 2, 9.00, 'Paypal'),
(299, 1, 1, 'Plane (2023)', '2023-12-06', '20 Nov', '15:00:00', '[\"A1\",\"A2\"]', 2, 9.00, 'Paypal'),
(312, 1, 4, 'Spy Kids: Armageddon(2023)', '2023-12-08', '21 Nov', '15:30:00', '[\"A1\",\"A2\"]', 2, 9.00, 'Creditcard'),
(313, 1, 4, 'Spy Kids: Armageddon(2023)', '2023-12-08', '21 Nov', '15:30:00', '[\"A1\",\"A2\"]', 2, 9.00, 'Creditcard'),
(314, 1, 7, 'Gen V (2023)', '2023-12-08', '19 Dec', '17:30:00', '[\"A6\",\"A7\"]', 2, 9.00, 'Creditcard'),
(315, 2, 3, 'The Equalizer 3 (2023)', '2023-12-08', '21 Nov', '15:30:00', '[\"B4\",\"B5\"]', 2, 9.00, 'Creditcard'),
(316, 2, 5, 'Ahsoka (2023)', '2023-12-08', '11 Dec', '19:00:00', '[\"C7\",\"C6\"]', 2, 9.00, 'Paypal'),
(317, 2, 8, 'The Black Book (2023)', '2023-12-08', '19 Dec', '16:30:00', '[\"A6\",\"A7\",\"A8\"]', 3, 13.50, 'Paypal'),
(318, 1, 1, 'Plane (2023)', '2023-12-13', '20 Nov', '17:30:00', '[\"A2\",\"A3\"]', 2, 9.00, 'Paypal'),
(319, 1, 2, 'Overhaul (2023)', '2023-12-13', '20 Nov', '16:50:00', '[\"A7\",\"A8\"]', 2, 9.00, 'Creditcard'),
(320, 1, 2, 'Overhaul (2023)', '2023-12-13', '23 Nov', '16:50:00', '[\"B4\"]', 1, 4.50, 'Creditcard');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movie_bookings`
--
ALTER TABLE `movie_bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movie_bookings`
--
ALTER TABLE `movie_bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `movie_bookings`
--
ALTER TABLE `movie_bookings`
  ADD CONSTRAINT `movie_bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `movie_bookings_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
