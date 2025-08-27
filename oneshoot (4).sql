-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2025 at 05:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oneshoot`
--

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `matches_id` int(11) NOT NULL,
  `team1` varchar(100) NOT NULL,
  `team2` varchar(100) NOT NULL,
  `match_date` datetime NOT NULL,
  `video_link` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `match_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`matches_id`, `team1`, `team2`, `match_date`, `video_link`, `thumbnail`, `match_title`) VALUES
(3, 'chelsea', 'manchester united', '2007-03-18 18:00:00', 'https://youtu.be/ad2xCptHu1c?si=lq8HKBjVd_Wz1AOg', 'https://i.ytimg.com/vi/ad2xCptHu1c/maxresdefault.jpg', 'Chelsea vs Manchester United\r\n18/3/2007'),
(6, 'Juventus', 'Ac Milan', '2008-12-14 20:30:00', 'https://youtu.be/bQ4xdBlBQPs?si=G-gW68ybaigAzuzt', 'https://i.ytimg.com/vi/heDgR6FaPFs/maxresdefault.jpg', 'Juventus vs Ac milan  \r\n14/12/2008'),
(9, 'Real Madrid ', 'Barcelona', '2009-05-02 21:45:00', 'https://youtu.be/glAZua9ZQKE?si=bsjhVY59SUOZE6ZR', 'https://tse2.mm.bing.net/th?id=OIP.ZKrkcE5c6BRsSdjMNgx7WAAAAA&pid=Api&P=0&h=220', 'Real Madrid vs Barcelona \r\n2/5/2009'),
(12, 'Brazil', 'Germany', '2014-07-08 22:00:00', 'https://youtu.be/QCVk4LBhINY?si=RBlVFzHla2JjKCz8', 'https://tse3.mm.bing.net/th?id=OIP.O0Q-dt6qeN47641mLtsISAAAAA&pid=Api&P=0&h=220', 'Brazil vs Germany'),
(13, 'Tottenham Hotspurs', 'Chelsea', '2006-11-05 18:30:00', 'https://youtu.be/E1BOyG81Bhc?si=BT96pYVfQa-PhwtW', 'https://www.spurscommunity.co.uk/index.php?matches/spurs-vs-chelsea-day-11.130/cover-image', 'Tottenham Hotspurs vs Chelsea'),
(14, 'Manchester United', 'Arsenal', '2004-10-24 18:05:00', 'https://youtu.be/EdjDBCKZI7U?si=pV3lo6EIiBc_diNF', 'https://tse3.mm.bing.net/th?id=OIP.YyUpVtM7riABWV3_e2RXmQHaD2&pid=Api&P=0&h=220', 'Manchester United vs Arsenal    24/10/2004'),
(15, 'Chelsea', 'Manchester United', '2016-10-23 18:00:00', 'https://youtu.be/QP25ucU8vfI?si=svSCPAAQEwX5OzD2', 'https://i2-prod.football.london/incoming/article17763827.ece/ALTERNATES/s1200/0_chelseablog.jpg', 'Chelsea vs Manchester United     23/10/2016'),
(16, 'Real Madrid ', 'Ac Milan', '2003-03-12 22:00:00', 'https://youtu.be/8hyi60zWiXQ?si=8euTnIiiqZSvhrZC', 'https://www.footitalia.com/wp-content/uploads/2024/11/Real-Madrid-v-Milan.png', 'Real Madrid vs Ac Milan     12/3/2003'),
(17, 'Barcelona', 'Real Madrid', '2010-11-29 22:00:00', 'https://youtu.be/bcCBOt2c1AI?si=GSWrhPk3qmoT9bKf', 'https://i.ytimg.com/vi/uWY5m5zS2R4/maxresdefault.jpg', 'Barcelona vs Real Madrid   29/11/2010'),
(18, 'Borussia Dortmund', 'Bayern Munich', '2013-07-27 21:30:00', 'https://youtu.be/wTN82hUkhWk?si=3GkO__nUHa4UzOB0', 'https://i.ytimg.com/vi/N4YHUhAXSsk/maxresdefault.jpg', 'Borussia Dortmund vs Bayern Munich       27/7/2013'),
(19, 'Real Madrid ', 'Barcelona', '2017-12-23 21:00:00', 'https://www.youtube.com/live/GyYYYhprhYQ?si=BSZGiB9xvtCq-qdN', 'https://i.ytimg.com/vi/GyYYYhprhYQ/maxresdefault.jpg', 'Real Madrid vs Barcelona   23/12/2017'),
(20, 'Germany', 'Argentina', '2014-07-13 22:00:00', 'https://youtu.be/pVIAx16odCs?si=gKuYQD_CDXesmsVv', 'https://www.sialtv.pk/wp-content/uploads/2014/07/Germany-vs-Argentina-2014-FIFA-World-Cup-Final-Match-Live-Streaming.jpg', 'Germany vs Argentina');

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `players_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(50) NOT NULL,
  `teams_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`players_id`, `name`, `position`, `teams_id`) VALUES
(1, 'Lionel Messi', 'Forward', 2),
(2, 'Cristiano Ronaldo', 'Forward', 1),
(3, 'Robert Lewandowski', 'Forward', 4),
(4, 'Paul Pogba', 'Midfielder', 3),
(5, 'Kaka', 'Midfielder', 5);

-- --------------------------------------------------------

--
-- Table structure for table `player_matches`
--

CREATE TABLE `player_matches` (
  `match_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `player_matches`
--

INSERT INTO `player_matches` (`match_id`, `player_id`) VALUES
(17, 1),
(14, 2);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `teams_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `country` varchar(100) CHARACTER SET armscii8 COLLATE armscii8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`teams_id`, `name`, `country`) VALUES
(1, 'Real Madrid', 'Spain'),
(2, 'Barcelona', 'Spain'),
(3, 'Manchester United', 'England'),
(4, 'Bayern Munich', 'Germany'),
(5, 'Ac Milan', 'Italy'),
(6, 'Juventus', 'Italy'),
(7, 'Inter Milan', 'Italy'),
(8, 'Arsenal', 'England'),
(9, 'Germany ', 'Germany '),
(10, 'Brazil', 'Brazil'),
(11, 'tottenham hotspurs', 'England'),
(12, 'Borussia Dortmund', 'Germany'),
(13, 'Argentina', 'Argentina');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `subscription_status` enum('active','inactive') DEFAULT 'inactive',
  `subscription_end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `email`, `password`, `subscription_status`, `subscription_end_date`) VALUES
(16, 'khaledyoussef2003@gmail.com', 'khaled12', 'inactive', '2025-01-04'),
(28, 'habibsamad@hotmail.com', '$2y$10$zwmqsO6vM26.Ur4hz4qXJerJ5Z2Ura.rgmtZilualp9yHMYIaFwpi', 'inactive', NULL),
(29, 'ky496746@gmail.com', '$2y$10$nEbsb3xxOCKzdAl88DjGgepW8a6iLaNpjv9tyjBF2oMrgtK/BRABa', 'active', '2025-02-03'),
(30, 'khaled@login.com', '$2y$10$A2IxGz0qRnuPlv4j3hnuf.gmna52u2s5hQkwH9/ooViiu92A2w0c2', 'active', '2025-02-03'),
(31, 'sarwat.khalil@hotmail.com', '$2y$10$XvjDRThhIPhx5UC9b2dAi.BOZnVKN6ob4bdSvkcBiyczHYsbbadF2', 'active', '2025-03-05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`matches_id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`players_id`),
  ADD KEY `teams_id` (`teams_id`);

--
-- Indexes for table `player_matches`
--
ALTER TABLE `player_matches`
  ADD KEY `match_id` (`match_id`),
  ADD KEY `player_id` (`player_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`teams_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `matches`
--
ALTER TABLE `matches`
  MODIFY `matches_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `players_ibfk_1` FOREIGN KEY (`teams_id`) REFERENCES `teams` (`teams_id`);

--
-- Constraints for table `player_matches`
--
ALTER TABLE `player_matches`
  ADD CONSTRAINT `player_matches_ibfk_1` FOREIGN KEY (`match_id`) REFERENCES `matches` (`matches_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `player_matches_ibfk_2` FOREIGN KEY (`player_id`) REFERENCES `players` (`players_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
