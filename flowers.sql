-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2025 at 11:13 PM
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
-- Database: `flowers`
--

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `shipping_address` text NOT NULL,
  `billing_address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `special_notes` text DEFAULT NULL,
  `order_status` enum('pending','confirmed','processing','shipped','delivered','cancelled') DEFAULT 'confirmed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `user_id`, `product_id`, `quantity`, `unit_price`, `total_price`, `shipping_address`, `billing_address`, `payment_method`, `contact_number`, `special_notes`, `order_status`, `created_at`) VALUES
(6, 15, 2, 1, 40.00, 40.00, 'taran', 'taran bld', 'Cash on Delivery', '76874521', 'taran', 'pending', '2025-07-29 21:01:41'),
(7, 15, 12, 2, 45.00, 90.00, 'taran', 'taran bld', 'Cash on Delivery', '76874521', 'taran', 'cancelled', '2025-07-29 21:01:41'),
(9, 15, 15, 1, 41.00, 41.00, 'taran main street st', 'mekhtar bld flor 1', 'Cash on Delivery', '71700905', 'big big 10x', 'cancelled', '2025-07-29 21:04:47'),
(10, 15, 28, 2, 22.00, 44.00, 'taran main street st', 'mekhtar bld flor 1', 'Cash on Delivery', '71700905', 'big big 10x', 'pending', '2025-07-29 21:04:47'),
(11, 15, 46, 3, 112.00, 336.00, 'taran main street st', 'mekhtar bld flor 1', 'Cash on Delivery', '71700905', 'big big 10x', 'processing', '2025-07-29 21:04:47'),
(12, 24, 29, 2, 100.00, 200.00, 'sfire st', 'khaled bld', 'Credit Card', '76874521', 'congrats', 'confirmed', '2025-07-29 22:03:37'),
(13, 24, 21, 1, 25.00, 25.00, 'sfire st', 'khaled bld', 'Credit Card', '76874521', 'congrats', 'confirmed', '2025-07-29 22:03:37'),
(15, 25, 3, 1, 33.00, 33.00, 'bakhoun st', 'samad bld flor 2', 'Cash on Delivery', '78986647', '...', 'shipped', '2025-07-29 22:31:03'),
(16, 25, 41, 2, 45.00, 90.00, 'bakhoun st', 'samad bld flor 2', 'Cash on Delivery', '78986647', '...', 'pending', '2025-07-29 22:31:03'),
(17, 25, 40, 1, 23.00, 23.00, 'bakhoun st', 'samad bld flor 2', 'Cash on Delivery', '78986647', '...', 'confirmed', '2025-07-29 22:31:03'),
(18, 25, 3, 1, 33.00, 33.00, 'daher al ein st', 'liu bld block B flor 1 room 106', 'Credit Card', '71700905', 'thank you ', 'delivered', '2025-07-30 16:49:37'),
(19, 25, 13, 2, 30.00, 60.00, 'al dayaa', '321', 'Credit Card', '34534534', '123321', 'confirmed', '2025-07-30 17:17:17'),
(20, 25, 34, 1, 130.00, 130.00, 'al dayaa', '321', 'Credit Card', '34534534', '123321', 'confirmed', '2025-07-30 17:17:17'),
(25, 26, 2, 1, 40.00, 40.00, 'taran st', 'mohamad bld', 'Credit Card', '71700905', 'thank you', 'delivered', '2025-07-31 07:13:05'),
(26, 26, 20, 1, 25.00, 25.00, 'taran st', 'mohamad bld', 'Credit Card', '71700905', 'thank you', 'delivered', '2025-07-31 07:13:05'),
(27, 26, 27, 1, 40.00, 40.00, 'izal denniyeh st', 'ahmad bld', 'Cash on Delivery', '03655889', 'by ammar', 'confirmed', '2025-08-06 16:20:51'),
(28, 26, 43, 1, 165.00, 165.00, 'izal denniyeh st', 'ahmad bld', 'Cash on Delivery', '03655889', 'by ammar', 'confirmed', '2025-08-06 16:20:51');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `image`, `name`, `unit_price`) VALUES
(1, '7.jpg', 'flora', 22.00),
(2, '9.webp', 'Tokyo', 40.00),
(3, '4.jpg', 'Lavender ', 33.00),
(10, '10.jpg', 'test', 10.00),
(11, '5.webp', 'Lemon Sorbet', 28.00),
(12, '12.webp', ' Larkspur', 45.00),
(13, '8.webp', 'Azalea', 30.00),
(15, '5.webp', 'Calla lily', 41.00),
(20, '24.jpg', 'Gerbera', 25.00),
(21, '25.jpg', 'Tulip', 25.00),
(22, '26.jpg', ' Iris', 80.00),
(23, '27.jpg', 'yellow', 28.00),
(24, '28.jpg', 'Marigold', 66.00),
(25, '29.webp', 'Oxalis', 78.00),
(26, '30.webp', 'Evelyn', 52.00),
(27, '31.webp', 'Wonderful', 40.00),
(28, '32.jpg', 'Vibrant Energy', 22.00),
(29, '33.jpg', 'Marvellous', 100.00),
(30, '34.jpg', 'Solidago', 105.00),
(31, '35.jpg', 'Sunrise', 85.00),
(32, '36.webp', 'Ripple', 37.00),
(33, '37.jpg', 'Heaven Scent', 142.00),
(34, '38.webp', 'Red Roses', 130.00),
(35, '39.jpg', 'Peony', 77.00),
(36, '40.jpg', 'Geranium', 115.00),
(37, '41.webp', 'Blooms', 46.00),
(39, '43.jpg', 'Aster', 70.00),
(40, '45.webp', 'Hibiscus', 23.00),
(41, '46.png', 'Hyssop', 45.00),
(43, '49.jpg', 'Heather', 165.00),
(44, '50.jpg', 'Hydrangea', 42.00),
(45, '51.webp', 'orange', 56.00),
(46, '52.png', 'Wintry Wonder', 112.00),
(47, '53.webp', 'mulwhite', 95.00);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `phone`, `address`, `role_id`) VALUES
(14, 'admin', 'admin', '$2y$10$yMx7G.ov1b8WlCLl3cunmufDutIc0Dd76JH9Bysupb8EreXALdu2y', '71700905', 'taran', 1),
(15, 'user', 'ali', '$2y$10$TbiR3UqmElkkUQt1cXeAbO34aWhrUqrPfOA6Ov7eFGwQCPv2rws3a', '78874561', 'sfire st', 2),
(24, 'nizar', 'nizar', '$2y$10$Idl/1TeNhy3PRthlvgC2RulgbTTEdbPqPMyoIAfR8MzpzCa6WbQGq', '79984410', 'sfire st', 2),
(25, 'user', 'user', '$2y$10$sHRF7kA5uCTY0jSQ2fwhaOaquAeXdjP42ogVrCKct5XENgAjuth16', '03030303', 'bakhoun st', 2),
(26, 'fadi', 'fadi', '$2y$10$PAMsRU2hqNa5s2biNMMAx.C2pX2dS0PELyZa/u6wM7hE9L2pk711W', '71700908', 'taran st', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
