-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2024 at 04:39 PM
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
-- Database: `hoss`
--

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
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2023_05_23_140436_user_table', 1),
(3, '2023_05_23_164347_room_table', 2),
(4, '2023_05_24_141241_reservation_table', 3),
(5, '2023_05_24_142244_reservation_table', 4),
(6, '2023_05_25_071056_reason_decline_table', 5),
(7, '2023_05_25_095057_reason_back_out_table', 6),
(8, '2023_12_31_033638_create_payments_table', 7),
(12, '2024_01_02_200411_payments_table', 8),
(13, '2024_05_23_033222_add_deactivation_remark_to_room_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reasonbackouttable`
--

CREATE TABLE `reasonbackouttable` (
  `reasonBackOut_id` bigint(20) UNSIGNED NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `set_by_admin` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reasonbackouttable`
--

INSERT INTO `reasonbackouttable` (`reasonBackOut_id`, `reservation_id`, `user_id`, `reason`, `set_by_admin`, `created_at`, `updated_at`) VALUES
(38, 162, 76, 'sample', 0, '2024-01-15 08:00:45', '2024-01-15 08:00:45');

-- --------------------------------------------------------

--
-- Table structure for table `reasondeclinetable`
--

CREATE TABLE `reasondeclinetable` (
  `reasonDecline_id` bigint(20) UNSIGNED NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservationtable`
--

CREATE TABLE `reservationtable` (
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `book_code` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `start_dataTime` datetime NOT NULL,
  `end_dateTime` datetime NOT NULL,
  `status` varchar(255) NOT NULL,
  `is_archived` int(11) NOT NULL,
  `is_noted` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservationtable`
--

INSERT INTO `reservationtable` (`reservation_id`, `book_code`, `user_id`, `room_id`, `start_dataTime`, `end_dateTime`, `status`, `is_archived`, `is_noted`, `created_at`, `updated_at`) VALUES
(162, '20240115155352183', 76, 1, '2024-01-16 14:00:00', '2024-01-17 12:00:00', 'Cancel', 0, 1, '2024-01-15 07:53:52', '2024-01-15 08:01:23');

-- --------------------------------------------------------

--
-- Table structure for table `roomtable`
--

CREATE TABLE `roomtable` (
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `photos` varchar(255) NOT NULL,
  `room_number` varchar(255) NOT NULL,
  `floor` varchar(255) NOT NULL,
  `type_of_room` varchar(255) NOT NULL,
  `number_of_bed` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL,
  `max_person` varchar(255) NOT NULL,
  `price_per_hour` float NOT NULL,
  `is_available` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roomtable`
--

INSERT INTO `roomtable` (`room_id`, `photos`, `room_number`, `floor`, `type_of_room`, `number_of_bed`, `details`, `max_person`, `price_per_hour`, `is_available`, `created_at`, `updated_at`, `status`) VALUES
(1, '/storage/roomPhotos/1704362281167444946.jpg', '101', 'First Floor', 'Standard Room', '1', '- Single bed\r\n- 20 square meters\r\n- Free Wi-fi\r\n- Flat-screen TV with cable channels\r\n- Air conditioning\r\n- Work desk\r\n- Wardrobe/closet\r\n- In-room safe\r\n- Coffee/tea maker\r\n- Complimentary bottled water\r\n- Private bathroom with shower', '2', 1000, 1, '2023-05-24 03:20:22', '2024-05-24 14:14:19', 'Available'),
(2, '/storage/roomPhotos/1704367874781818863.jpg', '102', 'First Floor', 'Standard Room', '2', '- Single bed\r\n- 20 square meters\r\n- Free Wi-fi\r\n- Flat-screen TV with cable channels\r\n- Air conditioning\r\n- Work desk\r\n- Wardrobe/closet\r\n- In-room safe\r\n- Coffee/tea maker\r\n- Complimentary bottled water\r\n- Private bathroom with shower', '4', 2000, 1, '2023-05-25 09:47:26', '2024-05-24 14:14:35', 'Available'),
(3, '/storage/roomPhotos/1704367951140275770.jpg', '201', 'Second Floor', 'Single Deluxe Room', '2', '- Twin bed\r\n- 25 square meters\r\n- All Standard Room amenities plus: \r\n- Upgraded toiletries\r\n- Mini-fridge\r\n- Slippers and bathrobe\r\n- Iron and ironing board (on request)\r\n- Enhanced room decor\r\n- Sitting are with armchair', '2', 2000, 1, '2023-05-25 09:52:49', '2024-05-24 14:28:47', 'Available'),
(4, '/storage/roomPhotos/17043679631371131266.jpg', '202', 'Second Floor', 'Single Deluxe Room', '2', '- Twin bed\r\n- 25 square meters\r\n- All Standard Room amenities plus: \r\n- Upgraded toiletries\r\n- Mini-fridge\r\n- Slippers and bathrobe\r\n- Iron and ironing board (on request)\r\n- Enhanced room decor\r\n- Sitting are with armchair', '4', 4000, 1, '2023-05-25 13:10:53', '2024-05-24 14:28:59', 'Available'),
(5, '/storage/roomPhotos/17043625921303164638.jpg', '203', 'Second Floor', 'Single Deluxe Room', '3', '- Twin bed\r\n- 25 square meters\r\n- All Standard Room amenities plus: \r\n- Upgraded toiletries\r\n- Mini-fridge\r\n- Slippers and bathrobe\r\n- Iron and ironing board (on request)\r\n- Enhanced room decor\r\n- Sitting are with armchair', '3', 3000, 1, '2023-05-26 04:23:36', '2024-05-24 14:29:08', 'Available'),
(6, '/storage/roomPhotos/1704362944792920187.jpg', '301', 'Third Floor', 'Superior Double Room', '1', '- Queen bed\r\n- 30 square meters\r\n- All Single Deluxe Room amenities plus\r\n- Larger room space\r\n- Enhanced bathroom with bathtub and separate shower\r\n- 24-hour room service\r\n- Turndown service\r\n- In-room espresso machine', '1', 4000, 1, '2023-05-27 03:32:03', '2024-05-24 14:27:56', 'Available'),
(7, '/storage/roomPhotos/1704368012742006340.jpg', '302', 'Third Floor', 'Superior Double Room', '2', '- Queen bed\r\n- 30 square meters\r\n- All Single Deluxe Room amenities plus\r\n- Larger room space\r\n- Enhanced bathroom with bathtub and separate shower\r\n- 24-hour room service\r\n- Turndown service\r\n- In-room espresso machine', '4', 6000, 1, '2024-01-03 12:55:35', '2024-05-24 14:28:13', 'Available'),
(8, '/storage/roomPhotos/17043680651223766861.jpg', '401', 'Fourth Floor', 'Executive Deluxe King Room', '1', '- King bed\r\n- 35 square meters\r\n- All Superior Deluxe Room amenities plus:\r\n- Access to executive lounge (with complimentary breakfast, snacks, and drinks)\r\n- Personalized check-in/check-out service\r\n- Complimentary pressing of one suit per stay', '1', 8000, 1, '2024-01-04 10:09:19', '2024-05-24 14:33:15', 'Available'),
(9, '/storage/roomPhotos/17043680981467980676.jpg', '402', 'Fourth Floor', 'Executive Deluxe King Room', '2', '- King bed\r\n- 35 square meters\r\n- All Superior Deluxe Room amenities plus:\r\n- Access to executive lounge (with complimentary breakfast, snacks, and drinks)\r\n- Personalized check-in/check-out service\r\n- Complimentary pressing of one suit per stay', '4', 16000, 1, '2024-01-04 10:12:06', '2024-05-24 14:33:28', 'Available'),
(10, '/storage/roomPhotos/1704363272114855854.jpg', '403', 'Fourth Floor', 'Executive Deluxe King Room', '4', '- King bed\r\n- 35 square meters\r\n- All Superior Deluxe Room amenities plus:\r\n- Access to executive lounge (with complimentary breakfast, snacks, and drinks)\r\n- Personalized check-in/check-out service\r\n- Complimentary pressing of one suit per stay', '4', 24000, 1, '2024-01-04 10:14:32', '2024-05-24 14:33:37', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `users_verify`
--

CREATE TABLE `users_verify` (
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_verify`
--

INSERT INTO `users_verify` (`user_id`, `token`, `created_at`, `updated_at`) VALUES
(40, 'LCp7h8jGkEDiyuKlajeJJ0YiyP7KTwPazhihQFP2hf1ZZLG0P8bhgtufWTh41IAw', '2023-12-25 01:50:20', '2023-12-25 01:50:20'),
(41, 'V4DWySR09ICpT347FxQqz5W6tMOYJxuWu1nldWHg1wCZz13tTJPpWXhmc0ncDsmb', '2023-12-25 01:52:20', '2023-12-25 01:52:20'),
(42, 'KUFbn1OHR9cn2CXzva5J9chyW1MPezYcPh0MTQCHhKTo5xaRy180eGmDn2dKk14i', '2023-12-25 02:08:40', '2023-12-25 02:08:40'),
(43, 'Pm3O5ZBLw6cGimRzNXQob83qRftE1IcmXQ3Qr1QrxyxQB1bRvxqltz0oRxLyQ6uU', '2023-12-25 02:11:21', '2023-12-25 02:11:21'),
(44, 'nKN8O53Y6NSNIAbI2AgvpZidLUuwlgnnyWNM8aMXPof5yW4FLFfmFEEfbvPG3KQI', '2023-12-25 02:14:05', '2023-12-25 02:14:05'),
(45, 'yo6vbquJY4xmv3BkFlzHRo35paMhCV5vaDQo16UO41F3e97ZmMi5aYLU2V5D7UCP', '2023-12-25 02:15:24', '2023-12-25 02:15:24'),
(46, 'JX44PGGjmRdewHWPGjtBT2JPZ8EPJPo9jdyFe1P0DYnjB6hTXDw1szYrwaNkktOZ', '2023-12-25 02:23:04', '2023-12-25 02:23:04'),
(47, 'CvF1dGmSsbJYcAC7ULiMNBTZ2osrWByhImtSy4tlPFI0r6puuwk00NXE2ZtyCGzE', '2023-12-25 02:27:29', '2023-12-25 02:27:29'),
(48, 'lc30ybF2jRrtndtqvY5wgZCgxqGom2YxXH284v97MuHqNkxOCgDSIFiAX48eDWBL', '2023-12-25 02:28:06', '2023-12-25 02:28:06'),
(49, 'ly71biJuwW05k5AUfaj2zaxwUrUDzNekeKqdO3rAYgWGhXs9vlcLNcx6vumXaiTo', '2023-12-25 02:29:03', '2023-12-25 02:29:03'),
(50, 'uFZDVkNBKEndxgCpEFI0p53mYzyQxR5hApaRuACyPMaariIHmCXmcPniZFcjRs88', '2023-12-25 02:31:57', '2023-12-25 02:31:57'),
(51, 'SqlxfrNZX7TB4xMfwl59PhV4bhGttqNaoUQvLtRe6ctLJrg5K7XDnFIMdyQjmwBi', '2023-12-25 02:32:16', '2023-12-25 02:32:16'),
(52, 'jFfWsdlyKomwETvkvadyeATR8ayQng7WjYjpNdstQPkwSPg7CcgT8CsC7zqWEGuG', '2023-12-25 02:48:08', '2023-12-25 02:48:08'),
(53, 'YGopzQj2ZdPnG0DllNEp9FQmjpKT2OYHBfMVcciEFjHTeRYJe0onXQZeXjN1tiiK', '2023-12-25 02:50:15', '2023-12-25 02:50:15'),
(54, 'i6ojvYsnOIxseRfUrZA5rD9UOPCsYvIseL6m09cRuLtoArEMhkXGgnKZnC951YXK', '2023-12-25 02:53:33', '2023-12-25 02:53:33'),
(55, 'JXKT3rZQIL61KSPrNflzdI4NUjcCi4O5e83VyhIvzes8CqGIS11PwqBeLobHW5oG', '2023-12-25 02:55:24', '2023-12-25 02:55:24'),
(56, 'AzYnv3RWSn6xDRK36TifRNH9ZutCl7lw0bQpvRIvi5fAMFOW3Jh0p40VJzC9Dthh', '2023-12-25 03:00:18', '2023-12-25 03:00:18'),
(57, '8qQttQ1mY1szZYdmFa1sy7ILkOec10EwL2F23SXEUe6GIRPsRTHwHfqQ1lZ7Hg7R', '2023-12-25 03:01:01', '2023-12-25 03:01:01'),
(58, '1MI6Q8lbHkO5V4TbiD6Ji0xwjhtxpoPpkRwJvt35Cn2BVCoEPH15xDpR0ESn2lbk', '2023-12-25 03:08:33', '2023-12-25 03:08:33'),
(59, 'cxkfUownBlN6qMfh9w2LsfCUPk44mGcxqrRXebKg9ZuupiRKxlau9YlaLfyIY5Dy', '2023-12-25 03:11:13', '2023-12-25 03:11:13'),
(60, '4avavh0t9UW76wySq5kBPpcEhMn8eDaDBLvPMZhpmWBxRIgE3k0eXu92bTkfOvyB', '2023-12-25 03:18:09', '2023-12-25 03:18:09'),
(61, 'e8bY7TgxaiTL3ay2c9cgHiG3R3mMyu213ayylXYGKep4G3dMEXNYeNf7vPevyJK3', '2023-12-29 17:31:07', '2023-12-29 17:31:07'),
(62, 'lPNyL11LtONoy33I6FPKmRNrkC0Plq3jBpObBskC4rJ8cbYNnoqHPnCyZ4tA9nPM', '2023-12-29 17:35:08', '2023-12-29 17:35:08'),
(63, 'siP6mA5iWkmpDCssXvlrW6bndK1lPq40P5PkLe7ochVTXORSib7TJZRfon3cTqZh', '2023-12-29 17:38:05', '2023-12-29 17:38:05'),
(64, 'Q6XOEobSs3OPynsUCfoXLIg7rZaJFJPjhSSUXyWybXwA4vWNRQNk2LX3LwKYzPwS', '2023-12-29 18:01:54', '2023-12-29 18:01:54'),
(65, 'MpSkmAtj965z1vGHy0M9fieCGL2tymVf41MuGhZM6hKbrczR7hTj27wInK072hT2', '2023-12-30 04:00:11', '2023-12-30 04:00:11'),
(66, 'iQSra9u8czOtZY5WDj60s9FxLUnusIOEbEiRsjqliJmDK34Fg7xJNFI969jU8pXR', '2023-12-30 04:15:27', '2023-12-30 04:15:27'),
(67, 'bR8YKQYr3xzkDCRjacvjhlHyMsXcZWQPcKm1AF32TjzdIY14ml3m0EL0AhxlO3f4', '2023-12-30 04:19:26', '2023-12-30 04:19:26'),
(68, '8tmKNZ6Jlf46jGInXqOViz91Bm3UPRpUbubMDcZvRyGjbySZIwyQ4nbHh3QZadYD', '2023-12-30 04:21:09', '2023-12-30 04:21:09'),
(69, 'VuSHdOOrA4F18iPwMzhUWD5Du9FU1FtkWQRwCNJHSFbabSxnAisSUCCzwKcgeYtm', '2023-12-30 04:22:55', '2023-12-30 04:22:55'),
(70, 'wODemSEzVwJrMXwg2CbnCSVr1u074ZCCse1UXPLhwUtzwoaXG1dOOCE4UDIK4CP2', '2023-12-30 04:24:01', '2023-12-30 04:24:01'),
(71, 'o2Q39YigwPzhlZ6m9XUEphrrfumAXQCmT5mTk0hn8BN6AKal96QSlHSlxwa0N9HX', '2023-12-30 18:58:26', '2023-12-30 18:58:26'),
(72, 'egh3bVFq8rYNzQXYjpLFgQNN4jTSPheTSvHIsiolKKygl2VmYZO4lYB05vK7fes3', '2024-01-03 10:25:21', '2024-01-03 10:25:21'),
(73, 'vvUGcAp1T3OLCTzPgek5mDZRuKMdstjSaBFL1ZRY6lJG91KJ36RM1NgNUtOi0WkQ', '2024-01-03 12:43:31', '2024-01-03 12:43:31'),
(74, '7LifMfObi2HoI64qFJJ2eXHd1IunmFPB3UxBEKnCzz3DQtpgoF7lAwtSE6opRPRt', '2024-01-04 06:07:10', '2024-01-04 06:07:10'),
(75, 'iTvsKXxz5ptBW7klH7ODcEDHyFEnz5OoWMLRewyAW3uvwLhss0ALcl0JKyTGTCgK', '2024-01-15 07:41:22', '2024-01-15 07:41:22'),
(76, 'lCyJGdQWM8zUyIWx0cDxK1KLGvA0tljO4FSzvt4r8S6v2AJV5Pyyz89y1ofIpsQ4', '2024-01-15 07:44:55', '2024-01-15 07:44:55'),
(77, 'h6iKXx9bd03FpbEJ08NOb636D2lu27DXuBoWSSLQAkTgWjocrkDecgNw4XKaAKcG', '2024-05-22 18:34:53', '2024-05-22 18:34:53');

-- --------------------------------------------------------

--
-- Table structure for table `usertable`
--

CREATE TABLE `usertable` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `photos` varchar(255) NOT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `extention` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phoneNumber` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `age` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_admin` int(11) NOT NULL,
  `email_verified` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usertable`
--

INSERT INTO `usertable` (`user_id`, `photos`, `lastname`, `firstname`, `middlename`, `extention`, `email`, `phoneNumber`, `birthday`, `age`, `password`, `is_active`, `is_admin`, `email_verified`, `created_at`, `updated_at`) VALUES
(77, '/storage/userPhotos/defaultImage.jpg', 'Luzon', 'Alexis', 'Ecaldre', NULL, 'b@gmail.com', '09517436670', '2001-02-12', '23', '$2y$10$MVWnjK7uo7O1Wb0lC4UycePA9XWc1O1YhkIbOrDlgtG55FbWBidnC', 1, 1, 1, '2024-05-22 18:34:53', '2024-05-23 15:48:16'),
(78, '/storage/userPhotos/defaultImage.jpg', 'Luzon', 'Alexis', 'Ecaldre', NULL, 'a@gmail.com', '09517436670', '2001-02-12', '23', '$2y$10$MVWnjK7uo7O1Wb0lC4UycePA9XWc1O1YhkIbOrDlgtG55FbWBidnC', 1, 0, 1, '2024-05-22 18:34:53', '2024-05-22 19:44:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `reasonbackouttable`
--
ALTER TABLE `reasonbackouttable`
  ADD PRIMARY KEY (`reasonBackOut_id`);

--
-- Indexes for table `reasondeclinetable`
--
ALTER TABLE `reasondeclinetable`
  ADD PRIMARY KEY (`reasonDecline_id`);

--
-- Indexes for table `reservationtable`
--
ALTER TABLE `reservationtable`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `roomtable`
--
ALTER TABLE `roomtable`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `usertable`
--
ALTER TABLE `usertable`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reasonbackouttable`
--
ALTER TABLE `reasonbackouttable`
  MODIFY `reasonBackOut_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `reasondeclinetable`
--
ALTER TABLE `reasondeclinetable`
  MODIFY `reasonDecline_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reservationtable`
--
ALTER TABLE `reservationtable`
  MODIFY `reservation_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `roomtable`
--
ALTER TABLE `roomtable`
  MODIFY `room_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `usertable`
--
ALTER TABLE `usertable`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
