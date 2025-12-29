-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2025 at 05:24 PM
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
-- Database: `hotel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `checkin` datetime DEFAULT NULL,
  `checkout` datetime DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(20) DEFAULT NULL,
  `card_name` varchar(100) DEFAULT NULL,
  `card_number` varchar(30) DEFAULT NULL,
  `cvv` varchar(3) DEFAULT NULL,
  `exp_date` varchar(10) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `room_id`, `full_name`, `phone`, `checkin`, `checkout`, `total_price`, `payment_method`, `card_name`, `card_number`, `cvv`, `exp_date`, `status`, `created_at`) VALUES
(1, 1, 1, 'نور ', '0910221593', '2025-12-24 00:06:00', '2025-12-31 00:06:00', 840.00, 'cash', NULL, NULL, NULL, NULL, 'cancelled', '2025-12-23 00:06:44'),
(2, 1, 2, 'نور ', '0910221593', '2025-12-08 10:06:00', '2025-12-28 10:06:00', 1260.00, 'online', 'Nour ', '1478523698523674985', '145', '2026-12', 'confirmed', '2025-12-23 10:06:49'),
(3, 1, 2, 'نور ', '0910221593', '2025-12-26 21:26:00', '2025-12-28 21:26:00', 1260.00, 'cash', NULL, NULL, NULL, NULL, 'cancelled', '2025-12-23 21:26:49'),
(4, 4, 3, 'منان', '0925874786', '2025-12-28 21:24:00', '2026-01-04 21:24:00', 2240.00, 'cash', NULL, NULL, NULL, NULL, 'confirmed', '2025-12-26 21:24:51'),
(5, 1, 4, 'منان', '0925874786', '2025-12-27 21:30:00', '2026-01-01 21:30:00', 1500.00, 'cash', NULL, NULL, NULL, NULL, 'confirmed', '2025-12-26 21:30:14'),
(6, 6, 4, 'أسيل ', '0928569874', '2026-01-01 22:27:00', '2026-01-08 22:27:00', 1750.00, 'online', 'Aseel ', '1487596328978523697', '257', '2026-11', 'cancelled', '2025-12-26 22:28:32'),
(7, 2, 3, 'منان', '0925874786', '2026-01-06 10:27:00', '2026-01-10 10:27:00', 1280.00, 'cash', NULL, NULL, NULL, NULL, 'cancelled', '2025-12-28 10:28:02'),
(8, 2, 5, 'منان', '0910221592', '2025-12-28 10:28:00', '2026-01-04 10:28:00', 3150.00, 'cash', NULL, NULL, NULL, NULL, 'cancelled', '2025-12-28 10:28:52'),
(9, 2, 2, 'منان', '0925874786', '2025-12-28 11:56:00', '2026-01-04 11:56:00', 1260.00, 'cash', NULL, NULL, NULL, NULL, 'cancelled', '2025-12-28 11:56:51');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_14_192533_create_rooms_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_number` varchar(3) NOT NULL,
  `type` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('available','booked') NOT NULL DEFAULT 'available',
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_number`, `type`, `price`, `status`, `image`, `created_at`, `updated_at`) VALUES
(1, '101', 'غرفة قياسية مزدوجة', 160.00, 'available', 'room.jpeg', NULL, '2025-12-28 07:10:42'),
(2, '102', 'غرفة ديلوكس بإطلالة المدينة', 180.00, 'available', 'room1.jpeg', NULL, NULL),
(3, '103', 'جناح تنفيذي', 320.00, 'available', 'room2.jpeg', NULL, NULL),
(4, '104', 'غرفة عائلية متصلة', 250.00, 'available', 'room3.jpeg', NULL, NULL),
(5, '105', 'جناح جونيور بمسبح خاص', 450.00, 'available', 'room4.jpeg', NULL, NULL),
(6, '106', 'غرفة سوبيريور بإطلالة بحرية', 220.00, 'available', 'room5.jpeg', NULL, NULL),
(7, '107', 'غرفة عائلية ', 380.00, 'available', 'room6.jpeg', NULL, NULL),
(8, '108', 'غرفة بطزار حديث', 250.00, 'available', '1766759818_4754b33c3eb6df8612e0.jpg', '2025-12-26 12:36:58', '2025-12-26 12:36:58');

-- --------------------------------------------------------

--
-- Table structure for table `room_waitlist`
--

CREATE TABLE `room_waitlist` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `checkin` datetime NOT NULL,
  `checkout` datetime NOT NULL,
  `notified` tinyint(4) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_waitlist`
--

INSERT INTO `room_waitlist` (`id`, `room_id`, `user_email`, `checkin`, `checkout`, `notified`, `created_at`) VALUES
(1, 1, 'nour02alhuda@gmail.com', '2025-12-24 00:06:00', '2025-12-31 00:06:00', 1, '2025-12-23 00:07:29'),
(2, 2, 'nour02alhuda@gmail.com', '2025-12-24 10:06:00', '2025-12-31 10:06:00', 1, '2025-12-23 10:08:10'),
(4, 2, 'nour02alhuda@gmail.com', '2025-12-26 21:26:00', '2025-12-28 21:26:00', 1, '2025-12-26 21:31:35'),
(5, 4, 'mananeldeeb4@gmail.com', '2026-01-01 22:27:00', '2026-01-08 22:27:00', 1, '2025-12-27 22:11:32'),
(6, 3, 'nour02alhuda@gmail.com', '2025-12-28 21:24:00', '2026-01-04 21:24:00', 1, '2025-12-28 11:57:37');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `cuisine` varchar(50) DEFAULT NULL,
  `dish_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `category`, `cuisine`, `dish_name`, `image`, `created_at`) VALUES
(1, 'restaurant', 'arabic', 'ورق عنب ', 'arab1.jpeg', '2025-12-19 19:24:34'),
(3, 'restaurant', 'arabic', 'مندي ', 'arab3.jpeg', '2025-12-19 19:24:34'),
(4, 'restaurant', 'arabic', 'برياني ', 'arab4.jpeg', '2025-12-19 19:24:34'),
(5, 'restaurant', 'arabic', 'أرز بالخلطة ', 'arab5.jpeg', '2025-12-19 19:24:34'),
(6, 'restaurant', 'arabic', 'مقلوبة ', 'arab6.jpeg', '2025-12-19 19:24:34'),
(7, 'restaurant', 'arabic', 'بقلاوة بالفستق ', 'arab7.jpeg', '2025-12-19 19:24:34'),
(8, 'restaurant', 'arabic', 'كنافة ', 'arab8.jpeg', '2025-12-19 19:24:34'),
(9, 'restaurant', 'arabic', 'ملوخية ', 'arab9.jpeg', '2025-12-19 19:24:34'),
(10, 'restaurant', 'asian', 'نودلز بالخضار', 'asia1.jpeg', '2025-12-19 19:24:44'),
(11, 'restaurant', 'asian', 'شوربة آسيوية', 'asia2.jpeg', '2025-12-19 19:24:44'),
(12, 'restaurant', 'asian', 'رامن', 'asia3.jpeg', '2025-12-19 19:24:44'),
(13, 'restaurant', 'asian', 'سوشي مشكل', 'asia4.jpeg', '2025-12-19 19:24:44'),
(14, 'restaurant', 'asian', 'نودلز بالصوص', 'asia5.jpeg', '2025-12-19 19:24:44'),
(15, 'restaurant', 'asian', 'سوشي سلمون', 'asia6.jpeg', '2025-12-19 19:24:44'),
(16, 'restaurant', 'french', 'راتاتوري', 'french1.jpeg', '2025-12-19 19:24:55'),
(17, 'restaurant', 'french', 'فطور فرنسي ', 'french2.jpeg', '2025-12-19 19:24:55'),
(18, 'restaurant', 'french', 'ماكرون فرنسي', 'french3.jpeg', '2025-12-19 19:24:55'),
(19, 'restaurant', 'french', 'شوربة ', 'french4.jpeg', '2025-12-19 19:24:55'),
(20, 'restaurant', 'french', 'شوربة بصل فرنسية ', 'french5.jpeg', '2025-12-19 19:24:55'),
(21, 'restaurant', 'french', 'طبق لحم فرنسي ', 'french6.jpeg', '2025-12-19 19:24:55'),
(22, 'restaurant', 'french', 'تارت التفاح ', 'french7.jpeg', '2025-12-19 19:24:55'),
(23, 'restaurant', 'italian', 'معكرونة', 'italia1.jpeg', '2025-12-19 19:25:11'),
(24, 'restaurant', 'italian', 'سباغيتي بفواكه البحر ', 'italia2.jpeg', '2025-12-19 19:25:11'),
(25, 'restaurant', 'italian', 'تيراميسو', 'italia3.jpeg', '2025-12-19 19:25:11'),
(26, 'restaurant', 'italian', 'باستا بالمحار', 'italia4.jpeg', '2025-12-19 19:25:11'),
(27, 'restaurant', 'italian', 'باستا بيني', 'italia5.jpeg', '2025-12-19 19:25:11'),
(28, 'restaurant', 'italian', 'بيتزا مارغريتا', 'italia6.jpeg', '2025-12-19 19:25:11'),
(29, 'restaurant', 'italian', 'سلطة خضار', 'italia7.jpeg', '2025-12-19 19:25:11'),
(30, 'restaurant', 'italian', 'لازانيا', 'italia8.jpeg', '2025-12-19 19:25:11'),
(31, 'restaurant', 'italian', 'شوربة ', 'italia9.jpeg', '2025-12-19 19:25:11'),
(33, 'gym', NULL, 'كمال أجسام', 'sport1.avif', '2025-12-19 19:25:20'),
(34, 'gym', NULL, 'كارديو', 'sport2.avif', '2025-12-19 19:25:20'),
(35, 'gym', NULL, 'رفع أثقال ', 'sport3.avif', '2025-12-19 19:25:20'),
(36, 'gym', NULL, 'تمارين جماعية ', 'sport4.avif', '2025-12-19 19:25:20'),
(37, 'gym', NULL, 'يوغا ', 'sport5.avif', '2025-12-19 19:25:20');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('184enUNo1xPgOo84c7utG2gaucaTavJFBKUHR1V2', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTzV4VnlSRThMcWtTUHM3b2o3Ukl1QWxuWmtMdEk4MzMybEx2ejl2UiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9sb2NhbGhvc3QvaG90ZWwtYXBwL3B1YmxpYyI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765779691),
('70ftatIjSUniZJxtatbzAR0Mt13j1w1DaaIKBKQz', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY3RoT0xROTI0MkhWZ05XU0tFbE94OFJ6MWtTMGJKMEVmbkpWdHlHWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9sb2NhbGhvc3QvaG90ZWwtYXBwL3B1YmxpYyI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765779690),
('9cfewy3dgUl3ObkByYFvd1Fc6KB0trCwIVYaZ9eU', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVlpmNlNWYjNQejVUUmtLUXcyQmNSdGg4cWJZWEFsT2wzV05DUm1VeCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9sb2NhbGhvc3QvaG90ZWwtYXBwL3B1YmxpYyI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765779690),
('DeWkxXbH858AQ628frl9HzMiKzdhSizpGk1A2Qiz', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZzVhamNzT243dXZBb3Z5dFpRdnBHdU4yTkVrd2RoMFF4bW1sQmtjSiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9sb2NhbGhvc3QvaG90ZWwtYXBwL3B1YmxpYyI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765779690),
('Hbi99U2mFdMFZN6RBZzpQsdp8EQTixpKtcuX87OA', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN0ViUXZQVkR6WkZTZzhWWnN5OGhyUWVWejBsY1p2TUNaeGtnOG9qUCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9sb2NhbGhvc3QvaG90ZWwtYXBwL3B1YmxpYyI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765779690),
('KbDRYmTbJytvdvQwErKMEA5NNRmec3C2aAM2mmPb', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM0Nyd3pGUVRYcHowaXBEdTdQdE04WHVQRmhIZ3hFTmYxYUY4YlRFQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ib29raW5nLzIiO3M6NToicm91dGUiO3M6MTQ6ImJvb2tpbmcuY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765753676);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(20) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `phone`, `role`) VALUES
(1, 'nour alhuda adeeb ', 'nour@gmail.com', '$2y$10$DrmS5Qz1W8M9jU5CuDKSte3WVo3npGJy2vwOe6DQau5lA1zimE5ue', '2025-12-22 16:27:36', '0925874786', 'admin'),
(2, 'manan', 'mananeldeeb4@gmail.com', '$2y$10$FKhwAvBMydXmlPvc2KBan./wer3RQNAEvZIICjMNNSCgwin7AXI3S', '2025-12-22 19:09:46', '0926859858', 'user'),
(3, 'Nour Alhuda', 'nour_alhuda@gmail.com', '$2y$10$2/XICJFAyJFMcbtEMs7WD./8GFSctKTrTbpFx3PQevkrhaKfUyjU2', '2025-12-26 20:25:53', '0910221592', 'user'),
(4, 'Aseel', 'Aseel@gmail.com', '$2y$10$CtnvYH/numNceukZ8CMmPu6OlZO450h9zJXq6WWph35oPRjpBJZ0y', '2025-12-26 20:27:21', '0928569874', 'user'),
(5, 'Hannen', 'Hannen@gmail.com', '$2y$10$/H7g/ZvSsUnygHFnues.PODCbPH/v.YhtnUn4VlVVCtirRJve8Jgq', '2025-12-27 20:09:49', '0925874786', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_waitlist`
--
ALTER TABLE `room_waitlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `room_waitlist`
--
ALTER TABLE `room_waitlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
