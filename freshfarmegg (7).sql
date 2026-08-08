-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2026 at 08:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `freshfarmegg`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(3, 'Admin', 'admin@freshfarmegg.com', '$2y$10$T5H1u5Zh2fA2Qo8Z1q4E.u5hNYXkNw0bq9B1rH9E6cT/1kYH6KJFi', '2026-02-26 15:14:42');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(10) UNSIGNED NOT NULL,
  `branch_name` varchar(100) NOT NULL,
  `low_stock_threshold` int(10) UNSIGNED NOT NULL DEFAULT 100,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `branch_name`, `low_stock_threshold`, `is_active`, `created_at`, `updated_at`) VALUES
(110, 'Iloilo Supermart Villa', 100, 1, '2026-01-14 00:30:45', '2026-01-14 00:30:45'),
(111, 'Iloilo Supermart Molo', 100, 1, '2026-01-14 00:40:34', '2026-01-14 00:40:34'),
(113, 'Iloilo Supermart Atrium', 100, 1, '2026-01-14 01:25:54', '2026-01-14 01:25:54'),
(114, 'Iloilo Supermart GQ', 100, 1, '2026-01-14 02:05:15', '2026-01-14 02:05:15'),
(115, 'Iloilo Supermart Washington', 100, 1, '2026-01-14 11:34:59', '2026-01-14 11:34:59');

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `id` int(10) UNSIGNED NOT NULL,
  `branch_id` int(10) UNSIGNED NOT NULL,
  `big_trays` int(10) UNSIGNED NOT NULL,
  `small_trays` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `big_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `small_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `delivered_by` varchar(100) NOT NULL,
  `egg_pieces` int(10) UNSIGNED GENERATED ALWAYS AS (`big_trays` * 20 * 12) STORED,
  `delivery_datetime` datetime DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deliveries`
--

INSERT INTO `deliveries` (`id`, `branch_id`, `big_trays`, `small_trays`, `big_price`, `small_price`, `total_amount`, `delivered_by`, `delivery_datetime`, `created_at`) VALUES
(84, 113, 100, 100, 106.00, 56.00, 16200.00, '', '2026-08-05 13:20:34', '2026-08-05 13:20:34'),
(85, 113, 200, 200, 106.00, 56.00, 32400.00, '', '2026-08-05 13:21:26', '2026-08-05 13:21:26'),
(87, 114, 100, 100, 106.00, 56.00, 16200.00, '', '2026-08-05 13:24:54', '2026-08-05 13:24:54'),
(88, 114, 100, 100, 106.00, 56.00, 16200.00, '', '2026-08-05 13:37:42', '2026-08-05 13:37:42'),
(89, 111, 500, 500, 106.00, 56.00, 81000.00, '', '2026-08-06 21:20:55', '2026-08-06 21:20:55'),
(90, 111, 500, 500, 106.00, 56.00, 81000.00, '', '2026-08-06 21:23:29', '2026-08-06 21:23:29');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(10) UNSIGNED NOT NULL,
  `branch_id` int(10) UNSIGNED NOT NULL,
  `big_trays` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `small_trays` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `egg_pieces` int(11) GENERATED ALWAYS AS (`big_trays` * 240 + `small_trays` * 12) STORED,
  `is_confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `branch_id`, `big_trays`, `small_trays`, `is_confirmed`, `is_active`, `created_at`, `updated_at`) VALUES
(10, 110, 0, 0, 0, 1, '2026-01-14 00:31:03', '2026-05-28 22:26:15'),
(11, 111, 600, 600, 0, 1, '2026-01-14 00:40:34', '2026-08-06 21:39:19'),
(12, 113, 330, 330, 0, 1, '2026-01-14 01:25:54', '2026-08-05 22:30:08'),
(14, 115, 0, 0, 0, 1, '2026-01-14 11:46:44', '2026-05-28 22:23:49'),
(15, 114, 40, 40, 0, 1, '2026-06-15 22:31:52', '2026-08-05 14:13:11');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `branch_id` int(10) UNSIGNED NOT NULL,
  `item` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_requests`
--

CREATE TABLE `order_requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `branch_id` int(10) UNSIGNED NOT NULL,
  `trays_requested` int(10) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `reset_code` varchar(100) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `big_trays` int(11) DEFAULT 0,
  `small_trays` int(11) DEFAULT 0,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `branch_id`, `big_trays`, `small_trays`, `created_at`) VALUES
(1, 111, 100, 100, '2026-04-02 11:01:41');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `big_trays` int(11) DEFAULT 0,
  `small_trays` int(11) DEFAULT 0,
  `message` text DEFAULT NULL,
  `admin_reply` text DEFAULT NULL,
  `status` enum('pending','confirmed','rejected') DEFAULT 'pending',
  `request_datetime` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `branch_id`, `big_trays`, `small_trays`, `message`, `admin_reply`, `status`, `request_datetime`) VALUES
(1, 106, 4, 9, 'i want to order these eggs in monday', 'ok, noted', 'confirmed', '2026-01-13 22:52:10'),
(36, 114, 100, 100, 'today', 'ok', 'confirmed', '2026-08-05 13:16:06'),
(37, 111, 500, 500, 'today', 'ok', 'confirmed', '2026-08-06 21:18:55');

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` int(11) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL,
  `return_type` varchar(50) NOT NULL,
  `big_trays` int(11) DEFAULT 0,
  `small_trays` int(11) DEFAULT 0,
  `egg_pieces` int(11) DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `return_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`id`, `branch_id`, `return_type`, `big_trays`, `small_trays`, `egg_pieces`, `remarks`, `return_datetime`) VALUES
(18, 114, 'Cracked', 10, 10, 0, 'big cracked', '2026-08-05 14:13:11'),
(19, 113, 'Cracked', 10, 10, 0, '', '2026-08-05 22:14:00'),
(20, 113, 'Cracked', 10, 10, 0, '', '2026-08-05 22:30:08');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `branch_id` int(10) UNSIGNED NOT NULL,
  `big_trays_sold` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `small_trays_sold` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `egg_pieces_sold` int(10) UNSIGNED GENERATED ALWAYS AS (`big_trays_sold` * 30 + `small_trays_sold` * 12) STORED,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sale_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `big_tray_price` decimal(10,2) DEFAULT NULL,
  `small_tray_price` decimal(10,2) DEFAULT NULL,
  `big_price` decimal(10,2) DEFAULT NULL,
  `small_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `branch_id`, `big_trays_sold`, `small_trays_sold`, `total_amount`, `sale_datetime`, `big_tray_price`, `small_tray_price`, `big_price`, `small_price`) VALUES
(72, 113, 50, 50, 9000.00, '2026-08-05 13:13:14', NULL, NULL, 120.00, 60.00),
(75, 113, 100, 100, 20000.00, '2026-08-05 13:37:30', NULL, NULL, 130.00, 70.00),
(76, 114, 50, 50, 9700.00, '2026-08-05 13:39:58', NULL, NULL, 125.00, 69.00),
(77, 114, 100, 100, 20000.00, '2026-08-05 14:08:03', NULL, NULL, 130.00, 70.00),
(78, 111, 200, 200, 46000.00, '2026-08-06 21:23:16', NULL, NULL, 170.00, 60.00),
(79, 111, 200, 200, 46000.00, '2026-08-06 21:39:19', NULL, NULL, 170.00, 60.00);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `egg_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `big_tray_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `small_tray_price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `egg_price`, `big_tray_price`, `small_tray_price`) VALUES
(1, 7.00, 210.00, 180.00);

-- --------------------------------------------------------

--
-- Table structure for table `sms_logs`
--

CREATE TABLE `sms_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `branch_id` int(10) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `recipient_number` varchar(20) NOT NULL,
  `status` enum('sent','failed') DEFAULT 'sent',
  `sent_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `month` varchar(7) NOT NULL,
  `big_trays` int(11) NOT NULL DEFAULT 300,
  `small_trays` int(11) NOT NULL DEFAULT 300,
  `loose_eggs` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `month`, `big_trays`, `small_trays`, `loose_eggs`, `created_at`) VALUES
(1, '2026-01', 188, 163, 0, '2026-01-14 02:40:42'),
(2, '2026-02', 150, 146, 0, '2026-02-01 12:57:53'),
(3, '2026-03', 1200, 1200, 5400, '2026-03-03 01:15:12'),
(4, '2026-04', 487, 485, 0, '2026-04-01 12:02:31'),
(5, '2026-05', 0, 0, 0, '2026-05-04 02:41:55'),
(6, '2026-06', 10, 10, 0, '2026-06-01 05:11:02'),
(7, '2026-07', 0, 0, 0, '2026-07-22 04:30:08'),
(8, '2026-08', 800, 800, 0, '2026-08-05 04:56:39');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `branch` varchar(100) NOT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `fullname`, `email`, `contact`, `photo`, `password`, `created_at`, `branch`, `branch_id`) VALUES
(33, 'Joan', NULL, 'joan@gmail.com', NULL, NULL, '$2y$10$Rz/tEnkFk7yIJvZ2ypLpou2VR8qBTuFGRZNi9Tv/tklsUqm3BsmyO', '2026-06-01 05:09:57', '', 113),
(36, 'Aira', NULL, 'aira@gmail.com', NULL, NULL, '$2y$10$FkS7IDgaUGcZgSI47LGVYuoYfGraqXEw9FGKTxEfz5gpOzC.lGzYO', '2026-08-05 05:15:10', '', 114),
(37, 'Giah', NULL, 'giah@gmail.com', NULL, NULL, '$2y$10$2tobDCLnbcLc0VOiDfYC1O41Qizq3WWVuWOpwwMwHFeB2HphHrmdO', '2026-08-06 13:17:14', '', 111);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','client') NOT NULL,
  `branch_id` int(10) UNSIGNED DEFAULT NULL,
  `is_confirmed` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `profile_pic` varchar(255) NOT NULL DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branch_name` (`branch_name`),
  ADD UNIQUE KEY `unique_branch_name` (`branch_name`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_deliveries_branch` (`branch_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_inventory_branch` (`branch_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `order_requests`
--
ALTER TABLE `order_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sales_branch` (`branch_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sms_branch` (`branch_id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD KEY `fk_branch` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_requests`
--
ALTER TABLE `order_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sms_logs`
--
ALTER TABLE `sms_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD CONSTRAINT `fk_deliveries_branch` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `fk_inventory_branch` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`);

--
-- Constraints for table `order_requests`
--
ALTER TABLE `order_requests`
  ADD CONSTRAINT `order_requests_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `fk_sales_branch` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD CONSTRAINT `fk_sms_branch` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_branch` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_branch` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
