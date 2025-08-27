-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2025 at 12:13 PM
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
-- Database: `kycell`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_bundles`
--

CREATE TABLE `data_bundles` (
  `id` int(11) NOT NULL,
  `operator` varchar(50) NOT NULL,
  `bundle_name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `validity` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_bundles`
--

INSERT INTO `data_bundles` (`id`, `operator`, `bundle_name`, `image`, `price`, `validity`, `created_at`) VALUES
(1, 'ALFA', 'ushare 5 gega ', NULL, 7.00, '30 Day', '2025-08-24 09:08:20'),
(3, 'Alfa', 'ushare 10 gega ', NULL, 11.00, '30', '2025-08-24 09:32:45');

-- --------------------------------------------------------

--
-- Table structure for table `gift_cards`
--

CREATE TABLE `gift_cards` (
  `id` int(11) NOT NULL,
  `operator` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `status` enum('available','sold') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gift_cards`
--

INSERT INTO `gift_cards` (`id`, `operator`, `name`, `image`, `amount`, `price`, `code`, `status`, `created_at`) VALUES
(1, 'Playstation ', '', 'https://pisces.bbystatic.com/image2/BestBuy_US/images/products/9394/9394265_sd.jpg', 10.00, 10.00, 'FT5OM78NDS39', 'available', '2025-08-24 09:13:42'),
(2, 'Amazon', '', 'https://tse4.mm.bing.net/th/id/OIP.n3cO57rliMmceqzHCEy_9gHaEp?pid=Api&P=0&h=220', 50.00, 50.00, 'K0O5J47H6F6U', 'available', '2025-08-24 09:55:00'),
(3, 'playstation', '', NULL, 20.00, 20.00, 'HT6OL042D9BM', 'available', '2025-08-25 10:10:47');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_type` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `mobile_number` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `email`, `phone`, `product_name`, `product_type`, `amount`, `mobile_number`, `status`, `created_at`) VALUES
(1, '', '', '', '', '', 0.00, '', 'pending', '2025-08-25 10:06:25');

-- --------------------------------------------------------

--
-- Stand-in structure for view `product_search_view`
-- (See below for the actual view)
--
CREATE TABLE `product_search_view` (
`id` int(11)
,`name` varchar(100)
,`price` decimal(10,2)
,`value` varchar(50)
,`type` varchar(8)
,`created_at` timestamp
);

-- --------------------------------------------------------

--
-- Table structure for table `recharge_cards`
--

CREATE TABLE `recharge_cards` (
  `id` int(11) NOT NULL,
  `operator` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `status` enum('available','sold') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recharge_cards`
--

INSERT INTO `recharge_cards` (`id`, `operator`, `amount`, `image`, `price`, `code`, `status`, `created_at`) VALUES
(1, 'ALFA', 4.50, 'https://tse3.mm.bing.net/th/id/OIP.S0PG7pH6qFCg9WmmcRnqsgAAAA?pid=Api&P=0&h=220', 5.22, 'HKHSL8W9KSJ9', 'available', '2025-08-24 09:08:21'),
(2, 'ALFA', 7.58, 'https://tse3.mm.bing.net/th/id/OIP.S0PG7pH6qFCg9WmmcRnqsgAAAA?pid=Api&P=0&h=220', 8.64, 'M7D708H94GMT', 'available', '2025-08-24 09:08:21'),
(3, 'TOUCH', 4.50, 'https://www.touch.com.lb/autoforms/attachments/view/D63FE4A2B7E8EE922A33252997BD90B3%7Cen%7C1/image/4.5USD%20Recharge%20Voucher.png?form=page', 5.22, 'G4P0YG7T32BF', 'available', '2025-08-24 09:08:21'),
(4, 'TOUCH', 7.58, 'https://tse1.mm.bing.net/th/id/OIP.FsKi0nj0thSrQAGoYqWY_QAAAA?pid=Api&P=0&h=220', 8.64, 'A2P9KJ8JG7BR', 'available', '2025-08-24 09:08:21'),
(5, 'Alfa', 10.00, 'https://tse3.mm.bing.net/th/id/OIP.S0PG7pH6qFCg9WmmcRnqsgAAAA?pid=Api&P=0&h=220', 11.33, 'JJ84FU9856FB', 'available', '2025-08-24 20:51:05');

-- --------------------------------------------------------

--
-- Structure for view `product_search_view`
--
DROP TABLE IF EXISTS `product_search_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `product_search_view`  AS SELECT `recharge_cards`.`id` AS `id`, `recharge_cards`.`operator` AS `name`, `recharge_cards`.`price` AS `price`, `recharge_cards`.`amount` AS `value`, 'recharge' AS `type`, `recharge_cards`.`created_at` AS `created_at` FROM `recharge_cards` WHERE `recharge_cards`.`status` = 'available'union all select `data_bundles`.`id` AS `id`,`data_bundles`.`bundle_name` AS `name`,`data_bundles`.`price` AS `price`,`data_bundles`.`validity` AS `value`,'data' AS `type`,`data_bundles`.`created_at` AS `created_at` from `data_bundles` union all select `gift_cards`.`id` AS `id`,`gift_cards`.`operator` AS `name`,`gift_cards`.`price` AS `price`,`gift_cards`.`amount` AS `value`,'gift' AS `type`,`gift_cards`.`created_at` AS `created_at` from `gift_cards` where `gift_cards`.`status` = 'available'  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_bundles`
--
ALTER TABLE `data_bundles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_op_price` (`operator`,`price`);

--
-- Indexes for table `gift_cards`
--
ALTER TABLE `gift_cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `idx_op_amount` (`operator`,`amount`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recharge_cards`
--
ALTER TABLE `recharge_cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `idx_op_amount` (`operator`,`amount`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_bundles`
--
ALTER TABLE `data_bundles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gift_cards`
--
ALTER TABLE `gift_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `recharge_cards`
--
ALTER TABLE `recharge_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
