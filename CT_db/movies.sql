-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2023 at 12:23 PM
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
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `movie_title` varchar(40) NOT NULL,
  `movie_genre` varchar(40) NOT NULL,
  `movie_date1` varchar(255) DEFAULT NULL,
  `movie_date2` varchar(255) DEFAULT NULL,
  `movie_date3` varchar(255) DEFAULT NULL,
  `show1` time DEFAULT NULL,
  `show2` time DEFAULT NULL,
  `show3` time DEFAULT NULL,
  `movie_info` text NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `preview` varchar(255) DEFAULT NULL,
  `movie_price` decimal(10,2) DEFAULT NULL,
  `movie_rating` tinyint(4) DEFAULT NULL,
  `category` enum('Now Playing','Coming Up') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `movie_title`, `movie_genre`, `movie_date1`, `movie_date2`, `movie_date3`, `show1`, `show2`, `show3`, `movie_info`, `img`, `preview`, `movie_price`, `movie_rating`, `category`) VALUES
(1, 'Plane (2023)', 'Action, Adventure, Thriller', '20 Nov', '23 Nov', '25 Nov', '15:00:00', '17:30:00', '20:00:00', 'After a heroic job of successfully landing his storm-damaged aircraft in a war zone, a fearless pilot finds himself between the agendas of multiple militias planning to take the plane and its passengers hostage.', 'plane.jpg', 'https://www.youtube.com/embed/M25zXBIUVr0', 4.50, NULL, 'Now Playing'),
(2, 'Overhaul (2023)', 'Action, Thriller, Drama', '20 Nov', '23 Nov', '25 Nov', '16:50:00', '19:30:00', '22:00:00', 'When truck racer Roger loses everything, he receives a tempting but dangerous offer: to work as the getaway driver for a gang of thieves.', 'overhaul.jpg', 'https://www.youtube.com/embed/6vgLc_Goo4g\r\n', 4.50, NULL, 'Now Playing'),
(3, 'The Equalizer 3 (2023)', 'Action, Thriller, Crime', '21 Nov', '22 Nov', '24 Nov', '15:30:00', '17:50:00', '21:30:00', 'Robert McCall finds himself at home in Southern Italy but he discovers his friends are under the control of local crime bosses. As events turn deadly, McCall knows what he has to do: become his friends protector by taking on the mafia', 'theEqualizer-3.jpg', 'https://www.youtube.com/embed/fQfrzHFmVe8\r\n', 4.50, NULL, 'Now Playing'),
(4, 'Spy Kids: Armageddon(2023)', 'Family, Comedy, Action, Adventure', '21 Nov', '22 Nov', '24 Nov', '15:30:00', '18:50:00', '21:00:00', 'When the children of the world’s greatest secret agents unwittingly help a powerful game developer unleash a computer virus that gives him control of all technology, they must become spies themselves to save their parents and the world.', 'spyKidsArmageddon.jpg', 'https://www.youtube.com/embed/TuiRw0v3bAw', 4.50, NULL, 'Now Playing'),
(5, 'Ahsoka (2023)', 'Sci-Fi & Fantasy, Action & Adventure', '11 Dec', '12 Dec', '15 Dec', '15:50:00', '19:00:00', '22:00:00', 'Former Jedi Knight Ahsoka Tano investigates an emerging threat to a vulnerable galaxy.', 'ashoka.jpg', 'https://www.youtube.com/embed/J_1EXWNETiI', 4.50, NULL, 'Coming Up'),
(6, 'Haunted Mansion(2023)', 'Fantasy, Comedy', '11 Dec', '12 Dec', '15 Dec', '15:30:00', '18:30:00', '21:30:00', 'A woman and her son enlist a motley crew of so-called spiritual experts to help rid their home of supernatural squatters.', 'hauntedMansion.jpg', 'https://www.youtube.com/embed/iB_1o3c19y0', 4.50, NULL, 'Coming Up'),
(7, 'Gen V (2023)', 'Sci-Fi & Fantasy, Action & Adventure', '19 Dec', '20 Dec', '23 Dec', '17:30:00', '20:00:00', '22:30:00', 'At America\"s only college for superheroes, gifted students put their moral boundaries to the test, competing for the university\"s top ranking, and a chance to join The Seven, Vought International\"s elite superhero team. When the school\"s dark secrets come to light, they must decide what kind of heroes they want to become.', 'gen5.jpg', 'https://www.youtube.com/embed/uhjJ5brX-bY', 4.50, NULL, 'Coming Up'),
(8, 'The Black Book (2023)', 'Mystery, Thriller, Action', '19 Dec', '20 Dec', '23 Dec', '16:30:00', '20:00:00', '22:30:00', 'After his son is wrongly accused of kidnapping, a deacon who has just lost his wife takes matters into his own hands and fights a crooked police gang to clear him.', 'theBlackBook.jpg', 'https://www.youtube.com/embed/E_f5GAMFfTM\r\n', 4.50, NULL, 'Coming Up');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
