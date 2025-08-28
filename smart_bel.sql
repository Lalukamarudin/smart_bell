-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2025 at 02:26 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_bel`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `user_id`, `username`, `action`, `created_at`) VALUES
(1, 1, 'wali', 'Membunyikan bel manual: \'Bel Masuk\'', '2025-07-28 16:01:23'),
(2, 1, 'wali', 'Membunyikan bel manual: \'Bel Istirahat\'', '2025-07-28 16:01:26'),
(3, 1, 'wali', 'Menambah jadwal baru: \'bel keluar\'', '2025-07-28 16:17:00'),
(4, 3, 'zuli', 'Memperbarui profil (nama & email).', '2025-07-28 16:38:37'),
(5, 1, 'wali', 'Membunyikan bel manual: \'Bel Masuk\'', '2025-07-28 16:39:19'),
(6, 1, 'wali', 'Membunyikan bel manual: \'Bel Masuk\'', '2025-07-28 16:39:24'),
(7, 1, 'wali', 'Menghapus pengguna dengan ID: 3', '2025-07-28 16:39:36'),
(8, 11, 'akila012', 'Menambah jadwal baru: \'masuk\'', '2025-08-01 10:35:08'),
(9, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-03 11:13:36'),
(10, 10, 'admin', 'Menghapus SEMUA jadwal bel.', '2025-08-03 11:29:54'),
(11, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 11:30:28'),
(12, 10, 'admin', 'Membunyikan bel manual: \'Bel Masuk\'', '2025-08-03 11:33:14'),
(13, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 11:34:13'),
(14, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 11:38:44'),
(15, 10, 'admin', 'Menghapus jadwal dengan ID: 2', '2025-08-03 11:38:49'),
(16, 10, 'admin', 'Menghapus jadwal dengan ID: 1', '2025-08-03 11:38:52'),
(17, 10, 'admin', 'Menghapus SEMUA jadwal bel.', '2025-08-03 11:40:39'),
(18, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 11:45:23'),
(19, 10, 'admin', 'Menghapus SEMUA jadwal bel.', '2025-08-03 11:47:24'),
(20, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 11:47:37'),
(21, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 11:48:23'),
(22, 10, 'admin', 'Menghapus SEMUA jadwal bel.', '2025-08-03 11:48:30'),
(23, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 11:48:51'),
(24, 10, 'admin', 'Menghapus jadwal dengan ID: 1', '2025-08-03 11:49:27'),
(25, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 12:02:07'),
(26, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 12:04:35'),
(27, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 12:07:11'),
(28, 10, 'admin', 'Menghapus SEMUA jadwal bel.', '2025-08-03 12:13:44'),
(29, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 12:14:05'),
(30, 10, 'admin', 'Menghapus jadwal dengan ID: 1', '2025-08-03 12:32:43'),
(31, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 12:33:13'),
(32, 10, 'admin', 'Menghapus jadwal dengan ID: 2', '2025-08-03 12:38:39'),
(33, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 12:39:28'),
(34, 10, 'admin', 'Menghapus jadwal dengan ID: 3', '2025-08-03 12:44:03'),
(35, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 12:44:23'),
(36, 10, 'admin', 'Menghapus jadwal dengan ID: 4', '2025-08-03 12:47:07'),
(37, 10, 'admin', 'Menambah jadwal baru: \'m\'', '2025-08-03 12:47:27'),
(38, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-03 12:52:29'),
(39, 10, 'admin', 'Menghapus jadwal dengan ID: 5', '2025-08-03 12:52:35'),
(40, 10, 'admin', 'Menghapus jadwal dengan ID: 6', '2025-08-03 12:54:11'),
(41, 10, 'admin', 'Menambah jadwal baru: \'g\'', '2025-08-03 12:54:26'),
(42, 10, 'admin', 'Menghapus jadwal dengan ID: 7', '2025-08-03 12:57:24'),
(43, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-03 12:57:44'),
(44, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 13:02:35'),
(45, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 13:10:19'),
(46, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 13:17:11'),
(47, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 13:19:37'),
(48, 10, 'admin', 'Menghapus SEMUA jadwal bel.', '2025-08-03 13:20:17'),
(49, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 13:20:27'),
(50, 10, 'admin', 'Menghapus jadwal dengan ID: 1', '2025-08-03 13:27:47'),
(51, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 13:28:05'),
(52, 10, 'admin', 'Membunyikan bel manual: \'Bel Masuk\'', '2025-08-03 13:39:33'),
(53, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 13:40:13'),
(54, 10, 'admin', 'Menambah jadwal baru: \'k\'', '2025-08-03 13:44:56'),
(55, 10, 'admin', 'Membunyikan bel manual: \'Bel Istirahat\'', '2025-08-03 13:44:59'),
(56, 10, 'admin', 'Menambah jadwal baru: \'keluar main\'', '2025-08-03 14:18:39'),
(57, 10, 'admin', 'Menambah jadwal baru: \'masyk\'', '2025-08-03 14:47:39'),
(58, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-03 14:52:47'),
(59, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-03 14:53:17'),
(60, 10, 'admin', 'Menghapus SEMUA jadwal bel.', '2025-08-03 14:54:42'),
(61, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 14:54:57'),
(62, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-03 14:57:34'),
(63, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-03 14:59:32'),
(64, 10, 'admin', 'Menghapus SEMUA jadwal bel.', '2025-08-05 04:02:37'),
(65, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-05 04:03:16'),
(66, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:11:08'),
(67, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:11:08'),
(68, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:11:09'),
(69, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:11:27'),
(70, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:15:13'),
(71, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:15:25'),
(72, 10, 'admin', 'Menghapus SEMUA jadwal bel.', '2025-08-05 04:15:31'),
(73, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:15:33'),
(74, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:15:39'),
(75, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:18:36'),
(76, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:18:56'),
(77, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:19:09'),
(78, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-05 04:31:10'),
(79, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:32:38'),
(80, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:32:56'),
(81, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:37:36'),
(82, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:37:38'),
(83, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:37:38'),
(84, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:37:39'),
(85, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:37:39'),
(86, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:37:39'),
(87, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:37:39'),
(88, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:37:39'),
(89, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:41:27'),
(90, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:43:51'),
(91, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:44:25'),
(92, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:46:28'),
(93, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:46:40'),
(94, 10, 'admin', 'Memicu bel manual: \'Bel Masuk\'', '2025-08-05 04:46:55'),
(95, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-05 04:51:02'),
(96, 10, 'admin', 'Menghapus SEMUA jadwal bel.', '2025-08-05 04:51:13'),
(97, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-05 04:51:27'),
(98, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-05 04:53:12'),
(99, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-05 04:53:39'),
(100, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-05 04:53:50'),
(101, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-05 04:53:50'),
(102, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-05 04:54:21'),
(103, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-05 04:55:50'),
(104, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-05 04:57:48'),
(105, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-05 04:59:18'),
(106, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-05 04:59:19'),
(107, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-05 04:59:36'),
(108, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-05 04:59:48'),
(109, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-05 05:01:48'),
(110, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 02:21:49'),
(111, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 02:21:55'),
(112, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 02:22:00'),
(113, 10, 'admin', 'Menambah jadwal baru: \'pulang\'', '2025-08-08 03:03:50'),
(114, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 03:06:06'),
(115, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 03:06:11'),
(116, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 03:06:16'),
(117, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 03:06:21'),
(118, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 03:06:26'),
(119, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 03:06:31'),
(120, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 03:06:36'),
(121, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 03:06:45'),
(122, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 03:06:50'),
(123, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 03:07:20'),
(124, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 03:08:34'),
(125, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 03:08:47'),
(126, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 03:08:52'),
(127, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 03:08:57'),
(128, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 03:09:30'),
(129, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 03:09:35'),
(130, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 03:09:45'),
(131, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 03:09:50'),
(132, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 03:10:22'),
(133, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-08 03:11:02'),
(134, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-08 03:17:08'),
(135, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-12 14:53:04'),
(136, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-12 14:53:09'),
(137, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-12 14:53:23'),
(138, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-12 14:53:46'),
(139, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-12 15:02:33'),
(140, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-12 15:03:53'),
(141, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-12 15:07:28'),
(142, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-12 15:25:31'),
(143, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-12 15:25:56'),
(144, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-12 15:28:10'),
(145, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-12 15:28:10'),
(146, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-12 15:28:10'),
(147, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-13 15:29:15'),
(148, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-13 15:33:35'),
(149, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-13 16:41:25'),
(150, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-13 16:41:46'),
(151, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-13 16:42:10'),
(152, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-13 16:44:45'),
(153, 10, 'admin', 'Menghapus SEMUA jadwal bel.', '2025-08-13 17:12:58'),
(154, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-13 17:45:54'),
(155, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-13 17:46:21'),
(156, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-13 17:47:47'),
(157, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-13 17:51:48'),
(158, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-13 17:52:12'),
(159, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-13 17:52:45'),
(160, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-13 17:53:48'),
(161, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-13 17:55:13'),
(162, 10, 'admin', 'Menghapus jadwal dengan ID: 1', '2025-08-13 17:56:09'),
(163, 10, 'admin', 'Menghapus jadwal dengan ID: 2', '2025-08-13 17:56:11'),
(164, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-13 17:56:22'),
(165, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-13 17:56:32'),
(166, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-13 17:57:13'),
(167, 10, 'admin', 'Menambah jadwal baru: \'Masuk\'', '2025-08-14 01:09:11'),
(168, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-14 01:13:05'),
(169, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-14 01:38:54'),
(170, 10, 'admin', 'Menambah jadwal baru: \'h\'', '2025-08-14 01:48:15'),
(171, 10, 'admin', 'Menambah jadwal baru: \'r\'', '2025-08-14 01:50:03'),
(172, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-14 01:54:37'),
(173, 10, 'admin', 'Menambah jadwal baru: \'m\'', '2025-08-14 01:56:20'),
(174, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-14 01:59:17'),
(175, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-14 02:00:27'),
(176, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-14 02:24:14'),
(177, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-14 02:25:29'),
(178, 10, 'admin', 'Menghapus SEMUA jadwal bel.', '2025-08-19 15:06:29'),
(179, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-19 15:06:55'),
(180, 10, 'admin', 'Menambah jadwal baru: \'pergantian jam\'', '2025-08-19 15:11:49'),
(181, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-19 15:17:00'),
(182, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-19 15:20:54'),
(183, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-19 15:25:25'),
(184, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-19 15:31:21'),
(185, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-19 15:34:20'),
(186, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-19 15:36:47'),
(187, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-19 15:40:53'),
(188, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-19 15:46:48'),
(189, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-19 15:50:57'),
(190, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-19 16:03:41'),
(191, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-19 16:07:36'),
(192, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-19 16:13:15'),
(193, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-19 16:14:45'),
(194, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-19 16:16:38'),
(195, 10, 'admin', 'Menghapus SEMUA jadwal bel.', '2025-08-19 16:18:07'),
(196, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-19 16:22:01'),
(197, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-19 16:23:37'),
(198, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-19 16:26:58'),
(199, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-19 16:28:39'),
(200, 10, 'admin', 'Menambah jadwal baru: \'pulang\'', '2025-08-19 16:31:28'),
(201, 10, 'admin', 'Menghapus SEMUA jadwal bel.', '2025-08-22 00:24:56'),
(202, 10, 'admin', 'Menambah jadwal baru: \'jam masuk\'', '2025-08-22 02:15:26'),
(203, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 02:16:52'),
(204, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 02:17:04'),
(205, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 02:17:13'),
(206, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-22 02:17:35'),
(207, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 02:21:10'),
(208, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 02:21:28'),
(209, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 02:21:42'),
(210, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 02:21:45'),
(211, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 02:21:48'),
(212, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-22 06:29:24'),
(213, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-22 06:33:18'),
(214, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 06:45:17'),
(215, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 06:45:32'),
(216, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 06:45:36'),
(217, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 06:45:58'),
(218, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 06:46:02'),
(219, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 06:46:58'),
(220, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-22 06:47:17'),
(221, 10, 'admin', 'Menghapus jadwal dengan ID: 4', '2025-08-22 06:47:28'),
(222, 10, 'admin', 'Menghapus jadwal dengan ID: 3', '2025-08-22 06:47:32'),
(223, 10, 'admin', 'Menghapus jadwal dengan ID: 2', '2025-08-22 06:47:36'),
(224, 10, 'admin', 'Menghapus jadwal dengan ID: 1', '2025-08-22 06:47:42'),
(225, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 06:48:01'),
(226, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-22 06:49:58'),
(227, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 06:51:14'),
(228, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 06:51:27'),
(229, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 06:51:39'),
(230, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 06:51:43'),
(231, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 06:51:43'),
(232, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 06:51:43'),
(233, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 06:51:43'),
(234, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 06:51:43'),
(235, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 06:51:55'),
(236, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 06:51:58'),
(237, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 06:52:06'),
(238, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 06:55:12'),
(239, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-22 06:55:24'),
(240, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-22 06:56:34'),
(241, 10, 'admin', 'Menghapus SEMUA jadwal bel.', '2025-08-23 00:28:45'),
(242, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-23 00:29:04'),
(243, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-23 00:43:36'),
(244, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-23 00:47:55'),
(245, 10, 'admin', 'Memicu bel manual: \'Manual\'', '2025-08-23 00:49:55'),
(246, 10, 'admin', 'Menambah jadwal baru: \'masuk\'', '2025-08-23 00:50:59'),
(247, 10, 'admin', 'Menghapus SEMUA jadwal bel.', '2025-08-28 11:57:47'),
(248, 10, 'admin', 'Memicu bel manual (via DB): \'Bel Masuk\'', '2025-08-28 12:05:02'),
(249, 10, 'admin', 'Memicu bel manual (via DB): \'Bel Masuk\'', '2025-08-28 12:05:32'),
(250, 10, 'admin', 'Memicu bel manual (via DB): \'Bel Masuk\'', '2025-08-28 12:07:04'),
(251, 10, 'admin', 'Memicu bel manual (via DB): \'Bel Masuk\'', '2025-08-28 12:07:08');

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `graduation_year` int(4) NOT NULL,
  `story` text NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`id`, `name`, `graduation_year`, `story`, `photo_url`) VALUES
(1, 'Rizky Pratama', 2020, 'Lulusan RPL yang kini bekerja sebagai Software Engineer di perusahaan ternama. Keahlian yang didapat di SMK NWDI Pancor sangat relevan dengan industri.', 'https://i.pravatar.cc/150?img=12'),
(2, 'Annisa Fitriani', 2021, 'Setelah lulus dari Tata Boga, saya berhasil membuka usaha katering sendiri. Dasar-dasar bisnis dan kuliner dari sekolah sangat membantu.', 'https://i.pravatar.cc/150?img=32'),
(3, 'David Maulana', 2019, 'Bekerja sebagai Front Office Manager di hotel bintang lima berkat ilmu dari jurusan Perhotelan. Pengalaman praktik kerja dari sekolah sangat berharga.', 'https://i.pravatar.cc/150?img=68');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `excerpt` text NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `excerpt`, `image_url`, `created_at`) VALUES
(1, 'SMK NWDI Pancor Raih Juara 2 Lomba Kompetensi Siswa Tingkat Nasional', 'Siswa dari jurusan kuliner berhasil mengharumkan nama sekolah di kancah nasional...', 'https://smknwdipancor.sch.id/wp-content/uploads/2022/10/WhatsApp-Image-2022-10-09-at-21.59.33-600x450.jpeg', '2025-07-28 16:32:12'),
(2, 'Workshop Kewirausahaan Digital untuk Jurusan Tata Busana', 'Bekerja sama dengan desainer ternama, siswa dibekali ilmu bisnis fesyen di era digital...', 'https://smknwdipancor.sch.id/wp-content/uploads/2022/02/Brown-Baking-Utensils-Pamphlet-Tri-fold-Brochure-4-1-300x232.png', '2025-07-28 16:32:12'),
(3, 'Kunjungan Industri Jurusan Perhotelan ke Hotel Bintang Lima', 'Siswa mendapatkan pengalaman langsung melihat operasional hotel bertaraf internasional...', 'https://smknwdipancor.sch.id/wp-content/uploads/2022/02/20211122_101441-300x225.jpg', '2025-07-28 16:32:12');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `event_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `event_date`) VALUES
(1, 'Ujian Akhir Semester', '2025-12-15 08:00:00'),
(2, 'Penerimaan Siswa Baru Dibuka', '2026-01-10 08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `title` varchar(100) NOT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `image_url`, `title`, `category`) VALUES
(1, 'https://smknwdipancor.sch.id/wp-content/uploads/2022/10/WhatsApp-Image-2022-10-09-at-21.59.33-600x450.jpeg', 'Cooking competition di BLK (Balai Latihan Kerja) Lenek Lombok Timur', 'Fasilitas'),
(2, 'https://smknwdipancor.sch.id/wp-content/uploads/2022/05/WhatsApp-Image-2022-05-15-at-3.44.52-PM-225x300.jpeg', 'Kegiatan Hiking Ambalan Jendral Sudirman-R.A. Kartini 2022 SMK NWDI Pancor', 'Kegiatan'),
(3, 'https://smknwdipancor.sch.id/wp-content/uploads/2022/02/WhatsApp-Image-2022-02-15-at-15.40.35-300x135.jpeg', 'kegiatan Hizizban', 'Kegiatan'),
(4, 'https://youtu.be/2MYWc7_2fS4', 'Reporter Desa Sade', 'Fasilitas'),
(5, 'https://smknwdipancor.sch.id/wp-content/uploads/2022/09/WhatsApp-Image-2022-09-16-at-10.21.17-169x300.jpeg', 'Lomba Pra Hultah NWDI Ke-87', 'Jurusan'),
(6, 'https://images.unsplash.com/photo-1629117651034-11d9f8f2f45c', 'Kreasi Tata Boga', 'Jurusan');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_bel`
--

CREATE TABLE `jadwal_bel` (
  `id` int(11) NOT NULL,
  `nama_bel` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu` time NOT NULL,
  `hari` enum('monday','tuesday','wednesday','thursday','friday','saturday','sunday') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_bel` enum('bel_masuk','bel_istirahat','bel_kelas','bel_pulang') COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwal_bel`
--

INSERT INTO `jadwal_bel` (`id`, `nama_bel`, `waktu`, `hari`, `jenis_bel`, `aktif`) VALUES
(1, 'Bel Masuk Pagi', '07:00:00', 'monday', 'bel_masuk', 1),
(2, 'Bel Istirahat Pertama', '09:30:00', 'monday', 'bel_istirahat', 1),
(3, 'Bel Masuk Siang', '10:00:00', 'monday', 'bel_masuk', 1),
(4, 'Bel Istirahat Kedua', '12:00:00', 'monday', 'bel_istirahat', 1),
(5, 'Bel Pulang', '15:00:00', 'monday', 'bel_pulang', 1),
(6, 'Bel Masuk Pagi', '07:00:00', 'tuesday', 'bel_masuk', 1),
(7, 'Bel Istirahat', '10:30:00', 'tuesday', 'bel_istirahat', 1),
(8, 'Bel Pulang', '14:00:00', 'tuesday', 'bel_pulang', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kontrol_bel`
--

CREATE TABLE `kontrol_bel` (
  `id` int(11) NOT NULL,
  `nama_jadwal` varchar(100) NOT NULL,
  `time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `senin` tinyint(1) NOT NULL DEFAULT 0,
  `selasa` tinyint(1) NOT NULL DEFAULT 0,
  `rabu` tinyint(1) NOT NULL DEFAULT 0,
  `kamis` tinyint(1) NOT NULL DEFAULT 0,
  `jumat` tinyint(1) NOT NULL DEFAULT 0,
  `sabtu` tinyint(1) NOT NULL DEFAULT 0,
  `minggu` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `log_bel`
--

CREATE TABLE `log_bel` (
  `id` int(11) NOT NULL,
  `jadwal_id` int(11) NOT NULL,
  `trigger_time` datetime NOT NULL DEFAULT current_timestamp(),
  `trigger_type` enum('auto','manual') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `log_bel`
--

INSERT INTO `log_bel` (`id`, `jadwal_id`, `trigger_time`, `trigger_type`) VALUES
(1, 1, '2025-07-26 21:37:25', 'auto'),
(2, 2, '2025-07-26 22:07:25', 'auto'),
(3, 5, '2025-07-26 22:37:25', 'manual');

-- --------------------------------------------------------

--
-- Table structure for table `manual_control`
--

CREATE TABLE `manual_control` (
  `id` int(11) NOT NULL,
  `bell_name` varchar(100) NOT NULL,
  `status` enum('pending','executed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manual_control`
--

INSERT INTO `manual_control` (`id`, `bell_name`, `status`, `created_at`) VALUES
(1, 'Bel Masuk', 'executed', '2025-08-28 12:05:02'),
(2, 'Bel Masuk', 'executed', '2025-08-28 12:05:32'),
(3, 'Bel Masuk', 'executed', '2025-08-28 12:07:04'),
(4, 'Bel Masuk', 'executed', '2025-08-28 12:07:08');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gender` enum('Laki-laki','Perempuan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `gender`) VALUES
(1, 'Ahmad', 'Laki-laki'),
(2, 'Bagus', 'Laki-laki'),
(3, 'Citra', 'Perempuan'),
(4, 'Dewi', 'Perempuan'),
(5, 'Eka', 'Laki-laki'),
(6, 'Fitri', 'Perempuan'),
(7, 'Gilang', 'Laki-laki'),
(8, 'Hana', 'Perempuan'),
(9, 'Indah', 'Perempuan');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `subject`) VALUES
(1, 'Dr. Budi Santoso', 'Kepala Sekolah'),
(2, 'Aisyah, S.Pd.', 'Guru RPL'),
(3, 'Putu Wijaya, S.Par.', 'Guru Perhotelan'),
(4, 'Sri Rahayu, S.Pd.', 'Guru Tata Busana');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `role` enum('user','admin','petugas') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `fullname`, `role`, `created_at`) VALUES
(1, 'wali', '$2y$10$KBJWBttpv7qA.yA7zvhJjuqotFL5El45p93JOvLLYsT55QFju8ORi', 'wali@gmail.com', 'wali', 'admin', '2025-07-28 15:05:35'),
(2, 'amar', '$2y$10$hffuwQM.ldie6AhtoWwE0ODzf4b91RtA1QFMMcUF9WSMMlfbJ0QkG', 'amar@gmail.com', 'amar', 'user', '2025-07-28 15:23:17'),
(4, 'ary1', '$2y$10$I7C8KpaavvZ3ine11JFaL.2n2n9cZFYIQsnQEQa.yKV.2jY21YRIm', 'ari@gmail.com', 'ramdan', 'user', '2025-07-29 07:05:05'),
(5, 'arya', '$2y$10$XTq0vbF5Mh.L/lmn6HP5BeWCiw.2NdxtrV3jw0IF8I.4P5aGA.exe', 'arai@gmail.com', 'ary', 'admin', '2025-07-29 07:06:24'),
(6, 'amin54', '$2y$10$AbPrgd9kkg4wVnYaEZ65eeXt6/SroDtPs0teKYY5XowoPwKlo5F8W', 'amin27@gmail.com', 'amin', 'admin', '2025-07-30 00:26:21'),
(7, 'laeli', '$2y$10$gRJyFWQK763DMvL3ibC9ZeIA/w/RyHHmr1CroembS9REpQ/PSi6cG', 'laeli@gmail.com', 'laeli', 'user', '2025-07-30 05:19:45'),
(8, 'udini', '$2y$10$R728wDtRuyue8Ve3J6NJJeuzdn69WQphcTS3b3Y37/hzUifD5bJZO', 'kamarlalu07@gmail.com', 'udin', 'admin', '2025-07-30 05:58:11'),
(9, 'taupik', '$2y$10$4TaqenvFqS/w2TcDADJgh.YCzrlb.ugr/aX3FpLYnLfB7PBWwN.iW', 'taupikramdan968@gmail.com', 'taupik', 'user', '2025-07-31 05:51:18'),
(10, 'admin', '$2y$10$BWv3Zg1IGbt0lL7CXo1vvun0BBnWz/o4nxvYRKS8B836XpG3EkXBW', 'admin@gmal.com', 'admin', 'admin', '2025-07-31 05:52:55'),
(11, 'akila012', '$2y$10$1Ps0NiADseydvNvJ.jTl5.mL6nzGU1eXYA6t5/WJhsWjhjJ7tXWZy', 'sufi12@gmail.com', 'sufi', 'admin', '2025-08-01 10:34:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal_bel`
--
ALTER TABLE `jadwal_bel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hari_waktu` (`hari`,`waktu`);

--
-- Indexes for table `kontrol_bel`
--
ALTER TABLE `kontrol_bel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_bel`
--
ALTER TABLE `log_bel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_id` (`jadwal_id`),
  ADD KEY `trigger_time` (`trigger_time`);

--
-- Indexes for table `manual_control`
--
ALTER TABLE `manual_control`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jadwal_bel`
--
ALTER TABLE `jadwal_bel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kontrol_bel`
--
ALTER TABLE `kontrol_bel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_bel`
--
ALTER TABLE `log_bel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `manual_control`
--
ALTER TABLE `manual_control`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `log_bel`
--
ALTER TABLE `log_bel`
  ADD CONSTRAINT `log_bel_ibfk_1` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal_bel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
