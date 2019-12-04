-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2019 at 10:58 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_chalkboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logout` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `login`, `logout`, `teacher_id`, `created_at`, `updated_at`) VALUES
(1, '2019-08-01 12:47:27', '', 1, '2019-08-01 06:47:27', '2019-08-01 06:47:27');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_taken`
--

CREATE TABLE `attendance_taken` (
  `id` int(10) UNSIGNED NOT NULL,
  `section_id` int(10) UNSIGNED NOT NULL,
  `date_taken` date NOT NULL,
  `students_present` int(11) NOT NULL,
  `students_total` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_taken`
--

INSERT INTO `attendance_taken` (`id`, `section_id`, `date_taken`, `students_present`, `students_total`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-08-01', 54, 68, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_grade` int(11) NOT NULL,
  `date` date NOT NULL,
  `subject_id` int(10) UNSIGNED DEFAULT NULL,
  `section_id` int(10) UNSIGNED DEFAULT NULL,
  `quiz` smallint(6) DEFAULT NULL,
  `quiz_topic` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `name`, `max_grade`, `date`, `subject_id`, `section_id`, `quiz`, `quiz_topic`, `created_at`, `updated_at`) VALUES
(1, 'SOC Science - French Revolt', 20, '2019-08-01', 1, 1, 1, 'French Revolution', NULL, NULL),
(2, 'Final 2019', 100, '2019-11-22', NULL, NULL, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `inventory_id` int(10) UNSIGNED NOT NULL,
  `StartQuantity` int(11) NOT NULL,
  `UsedPerDayQuantity` int(11) NOT NULL,
  `CurrentQuantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `id` int(10) UNSIGNED NOT NULL,
  `grade` int(11) DEFAULT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `student_remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exam_id` int(10) UNSIGNED DEFAULT NULL,
  `section_id` int(10) UNSIGNED DEFAULT NULL,
  `subject_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`id`, `grade`, `student_id`, `student_remark`, `exam_id`, `section_id`, `subject_id`, `created_at`, `updated_at`) VALUES
(1, 19, 1, 'A*', 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(2, NULL, 2, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(3, NULL, 3, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(4, NULL, 4, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(5, NULL, 5, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(6, NULL, 6, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(7, NULL, 7, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(8, NULL, 8, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(9, NULL, 9, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(10, NULL, 10, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(11, NULL, 11, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(12, NULL, 12, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(13, NULL, 13, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(14, NULL, 14, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(15, NULL, 15, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(16, NULL, 16, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(17, NULL, 17, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(18, NULL, 18, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(19, NULL, 19, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(20, NULL, 20, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(21, NULL, 21, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(22, NULL, 22, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(23, NULL, 23, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(24, NULL, 24, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(25, NULL, 25, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(26, NULL, 26, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(27, NULL, 27, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(28, NULL, 28, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(29, NULL, 29, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(30, NULL, 30, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(31, NULL, 31, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(32, NULL, 32, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(33, NULL, 33, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(34, NULL, 34, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(35, NULL, 35, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(36, NULL, 36, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(37, NULL, 37, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(38, NULL, 38, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(39, NULL, 39, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(40, NULL, 40, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(41, NULL, 41, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(42, NULL, 42, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(43, NULL, 43, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(44, NULL, 44, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(45, NULL, 45, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(46, NULL, 46, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(47, NULL, 47, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(48, NULL, 48, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(49, NULL, 49, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(50, NULL, 50, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(51, NULL, 51, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(52, NULL, 52, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(53, NULL, 53, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(54, NULL, 54, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(55, NULL, 55, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(56, NULL, 56, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(57, NULL, 57, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(58, NULL, 58, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(59, NULL, 59, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(60, NULL, 60, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(61, NULL, 61, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(62, NULL, 62, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(63, NULL, 63, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(64, NULL, 64, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(65, NULL, 65, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(66, NULL, 66, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(67, NULL, 67, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(68, NULL, 68, NULL, 1, 1, 1, '2019-08-01 00:37:34', '2019-08-01 00:37:34'),
(69, 98, 1, 'A*', 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(70, NULL, 2, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(71, NULL, 3, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(72, NULL, 4, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(73, NULL, 5, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(74, NULL, 6, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(75, NULL, 7, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(76, NULL, 8, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(77, NULL, 9, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(78, NULL, 10, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(79, NULL, 11, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(80, NULL, 12, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(81, NULL, 13, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(82, NULL, 14, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(83, NULL, 15, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(84, NULL, 16, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(85, NULL, 17, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(86, NULL, 18, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(87, NULL, 19, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(88, NULL, 20, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(89, NULL, 21, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(90, NULL, 22, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(91, NULL, 23, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(92, NULL, 24, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(93, NULL, 25, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(94, NULL, 26, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(95, NULL, 27, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(96, NULL, 28, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(97, NULL, 29, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(98, NULL, 30, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(99, NULL, 31, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(100, NULL, 32, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(101, NULL, 33, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(102, NULL, 34, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(103, NULL, 35, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(104, NULL, 36, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(105, NULL, 37, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(106, NULL, 38, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(107, NULL, 39, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(108, NULL, 40, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(109, NULL, 41, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(110, NULL, 42, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(111, NULL, 43, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(112, NULL, 44, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(113, NULL, 45, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(114, NULL, 46, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(115, NULL, 47, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(116, NULL, 48, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(117, NULL, 49, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(118, NULL, 50, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(119, NULL, 51, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(120, NULL, 52, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(121, NULL, 53, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(122, NULL, 54, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(123, NULL, 55, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(124, NULL, 56, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(125, NULL, 57, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(126, NULL, 58, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(127, NULL, 59, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(128, NULL, 60, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(129, NULL, 61, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(130, NULL, 62, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(131, NULL, 63, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(132, NULL, 64, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(133, NULL, 65, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(134, NULL, 66, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(135, NULL, 67, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01'),
(136, NULL, 68, NULL, 2, NULL, 1, '2019-08-01 00:38:01', '2019-08-01 00:38:01');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_07_21_102730_create_users_table', 1),
(2, '2019_07_21_102836_create_teachers_table', 1),
(3, '2019_07_21_102932_create_students_table', 1),
(4, '2019_07_21_103153_create_password_resets_table', 1),
(5, '2019_07_21_103328_create_subjects_table', 1),
(6, '2019_07_21_103527_create_sections_table', 1),
(7, '2019_07_21_103703_create_inventories_table', 1),
(8, '2019_07_21_103826_create_exams_table', 1),
(9, '2019_07_21_103854_create_marks_table', 1),
(10, '2019_07_21_103944_create_attendances_table', 1),
(11, '2019_07_21_104034_create_student_attendances_table', 1),
(12, '2019_07_21_104235_create_teacher_has_subjects_table', 1),
(13, '2019_07_21_104254_create_teacher_has_sections_table', 1),
(14, '2019_07_21_104608_create_section_has_students_table', 1),
(15, '2019_07_21_104732_create_exam_dates_table', 1),
(16, '2019_07_21_104841_create_attendance_taken_table', 1),
(17, '2019_07_21_111634_create_section_has_subjects_table', 1),
(18, '2019_07_21_112029_create_remark_category_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `remarks`
--

CREATE TABLE `remarks` (
  `id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED DEFAULT NULL,
  `sender_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `remark_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `remark_category`
--

CREATE TABLE `remark_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `remark_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `class`, `created_at`, `updated_at`) VALUES
(1, '0', 1, '2019-07-31 23:17:49', '2019-07-31 23:17:49');

-- --------------------------------------------------------

--
-- Table structure for table `section_has_students`
--

CREATE TABLE `section_has_students` (
  `id` int(10) UNSIGNED NOT NULL,
  `section_id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `year` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `section_has_students`
--

INSERT INTO `section_has_students` (`id`, `section_id`, `student_id`, `year`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2019', NULL, NULL),
(2, 1, 2, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(3, 1, 3, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(4, 1, 4, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(5, 1, 5, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(6, 1, 6, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(7, 1, 7, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(8, 1, 8, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(9, 1, 9, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(10, 1, 10, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(11, 1, 11, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(12, 1, 12, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(13, 1, 13, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(14, 1, 14, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(15, 1, 15, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(16, 1, 16, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(17, 1, 17, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(18, 1, 18, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(19, 1, 19, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(20, 1, 20, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(21, 1, 21, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(22, 1, 22, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(23, 1, 23, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(24, 1, 24, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(25, 1, 25, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(26, 1, 26, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(27, 1, 27, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(28, 1, 28, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(29, 1, 29, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(30, 1, 30, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(31, 1, 31, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(32, 1, 32, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(33, 1, 33, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(34, 1, 34, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(35, 1, 35, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(36, 1, 36, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(37, 1, 37, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(38, 1, 38, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(39, 1, 39, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(40, 1, 40, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(41, 1, 41, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(42, 1, 42, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(43, 1, 43, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(44, 1, 44, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(45, 1, 45, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(46, 1, 46, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(47, 1, 47, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(48, 1, 48, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(49, 1, 49, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(50, 1, 50, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(51, 1, 51, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(52, 1, 52, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(53, 1, 53, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(54, 1, 54, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(55, 1, 55, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(56, 1, 56, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(57, 1, 57, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(58, 1, 58, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(59, 1, 59, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(60, 1, 60, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(61, 1, 61, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(62, 1, 62, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(63, 1, 63, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(64, 1, 64, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(65, 1, 65, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(66, 1, 66, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(67, 1, 67, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(68, 1, 68, '2019', '2019-07-31 23:44:27', '2019-07-31 23:44:27');

-- --------------------------------------------------------

--
-- Table structure for table `section_has_subjects`
--

CREATE TABLE `section_has_subjects` (
  `id` int(10) UNSIGNED NOT NULL,
  `section_id` int(10) UNSIGNED NOT NULL,
  `subject_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `section_has_subjects`
--

INSERT INTO `section_has_subjects` (`id`, `section_id`, `subject_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fatherName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motherName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DOB` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` int(11) NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bloodGroup` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rollNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthCertificate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `familyIncome` double DEFAULT NULL,
  `father_occupation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_occupation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `height` double DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `is_shown` int(11) NOT NULL DEFAULT '1',
  `no_of_siblings` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `fatherName`, `motherName`, `DOB`, `gender`, `address`, `contact`, `bloodGroup`, `rollNumber`, `birthCertificate`, `familyIncome`, `father_occupation`, `mother_occupation`, `height`, `weight`, `is_shown`, `no_of_siblings`, `created_at`, `updated_at`) VALUES
(1, 'Md. Masum', NULL, NULL, NULL, 1, NULL, '98945665448648', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
(2, 'Will', 'Ford', 'Russ', '2013-09-20', 1, 'peyarabag', '1889160161', 'O+', '1', NULL, 20000, 'Security Guard', 'Housemaid', 3.5, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(3, 'Rejaul Hossain', 'Md. Dulal', 'Sathi Begum', '2013-01-18', 1, 'Bepari Goli', '01951336491', 'B-', '2', NULL, 20000, 'Security Guard', 'Housemaid', 3.8, 21.3, 1, 3, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(4, 'Nadia', 'Md. Sadek', 'Hosne Ara', '2013-06-04', 2, 'peyarabag', '9589238592', 'O+', '3', NULL, 20000, 'Foreign Worker', 'Housewife', 3.8, 21.3, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(5, 'Ayesha Akter', 'Shofiqul Isalm', 'Sathi Akter', '2013-09-05', 2, 'Shonalibag', '1997751697', 'AB+', '4', NULL, 20000, 'Paintmaker', 'Housewife', 3.7, 21.5, 1, 2, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(6, 'Mafuja Akter', 'Abdul Hashim', 'Minara ', '2012-11-09', 2, 'Shonalibag', '01954515426', 'B+', '5', NULL, 20000, 'Foreign Worker', 'Housewife', 3.8, 21.3, 1, 0, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(7, 'Tahmina Akter', 'Mofajjal Hossain', 'Minara Begum', '2013-04-05', 2, 'Shonalibag', '01792590998', 'O+', '6', NULL, 24000, 'Wright', 'Foreign Worker', 3.7, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(8, 'Rahim', 'Karim', 'Lekha', '2014-02-03', 1, 'T&T colony', '1793549077', 'B-', '7', NULL, 18000, 'Electrician', 'Housemaid', 3.8, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(9, 'Azom', 'Thazom', 'Kazom', '2013-02-22', 2, 'Shonalibag', '1760004845', 'O+', '8', NULL, 20000, 'Security Guard', 'Housemaid', 3.8, 21.3, 1, 3, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(10, 'Barley', 'Parley', 'Karley', '2013-04-02', 1, '12 Colony', '01943986183', 'O+', '9', NULL, 20000, 'Paintmaker', 'Housewife', 3.7, 21.5, 1, 4, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(11, 'Anika Akter', 'Kudddus Patuary', 'Kajoli Begum', '2013-05-05', 2, 'Shonalibag', '01851914920', 'O+', '10', NULL, 18000, 'Electrician', 'Housemaid', 3.8, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(12, 'Asif Hossain', 'Karif', 'Latif', '2013-06-04', 2, 'Malibagh', '6784785342', 'O+', '11', NULL, 40000, 'Chef', 'Housemaid', 3.8, 21.5, 1, 2, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(13, 'Romana Akter', 'Ramij Uddin', 'Morjina Begum', '2013-01-01', 2, 'Chan Bekari goli', '01943926183', 'B+', '12', NULL, 20000, 'Paintmaker', 'Housewife', 3.7, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(14, 'Zarif', 'Morif', 'Torif', '2013-01-18', 1, 'Chan Bekari goli', '95839221', 'O+', '13', NULL, 13000, 'Construction Worker', 'Housemaid', 3.6, 21.6, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(15, 'Esham', 'Tesham ', 'Mesham', '2013-10-03', 1, 'Bepari Goli', '01927119878', 'O+', '14', NULL, 20000, 'Foreign Worker', 'Housewife', 3.8, 21.3, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(16, 'Jubaer Hossain', 'Kirab', 'Jirab', '2012-06-08', 1, NULL, '08878723', 'O+', '15', NULL, 16500, 'Shopkeeper', 'Hospital Maid', 3.6, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(17, 'Md. Hasan', 'Md. Alom', 'Johora Begum', '2012-11-09', 1, 'Shonalibag', '1719956942', 'A-', '16', NULL, 24000, 'Wright', 'Foreign Worker', 3.7, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(18, 'Marufa Akter', 'Abdul Hashim', 'Minara Begum', '2013-04-02', 2, 'Shonalibag', '01954515426', 'O+', '17', NULL, 18000, 'Fish Seller', 'Housemaid', 3.8, 21.2, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(19, 'Razu', 'Sazu', 'Gori', '2013-01-01', 2, 'Shonalibag', '01927119878', 'O+', '18', NULL, 18000, 'Electrician', 'Housemaid', 3.8, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(20, 'Saad', 'Baad', 'Sabad', '2013-09-05', 1, 'peyarabag', '01943926183', 'A+', '19', NULL, 12000, 'Driver', 'Housewife', 3.8, 21.7, 1, 0, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(21, 'Israfil Hossain', 'Barek', 'Beauty Begum', '2013-02-23', 1, 'T&T colony', '1760004845', 'O+', '20', NULL, 17000, 'Driver', 'Housemaid', 3.8, 21.5, 1, 4, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(22, 'Rana Hossain', 'Mostafa', 'Ranu Begum', '2013-10-03', 1, 'Shonalibag', '01918466683', 'O+', '21', NULL, 13500, 'Shopkeeper', 'School Maid', 3.9, 21.2, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(23, 'Tanha Islam', 'Babul', 'Aklima', '2013-12-10', 1, 'Majar bari', '1955968497', 'B+', '22', NULL, 16500, 'Shopkeeper', 'Hospital Maid', 3.6, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(24, 'Ridhimoni', 'Najrul Islam', 'habia Begum', '2013-04-16', 1, '12 Colony', '1868106445', 'O-', '23', NULL, 13500, 'Shopkeeper', 'School Maid', 3.9, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(25, 'Lima Akter', 'Gias uddin', 'Julekha Begum', '2013-07-15', 2, 'Shonalibag', '01747210695', 'O+', '24', NULL, 13000, 'Chef', 'Housemaid', 3.8, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(26, 'Mursalina Akter', 'Md. Jamil', 'Fatema', '2013-04-02', 2, 'Pir pagla Goli', '01552388362', 'O+', '25', NULL, 17000, 'Driver', 'Housemaid', 3.8, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(27, 'Rifat', 'Ali Hossain', 'Nipa Begum', '2013-04-05', 1, '12 colony', '1715686002', 'O+', '26', NULL, 10000, 'Rickshaw Manager', 'Housewife', 3.5, 21.2, 1, 3, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(28, 'Rima Akter', 'Anuwar', NULL, '2013-02-23', 2, 'Shonalibag', '1779536982', 'O+', '27', NULL, 13500, 'Shopkeeper', 'School Maid', 3.9, 21.2, 1, 0, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(29, 'Sohana Akter', 'Abul Hossain', 'Ismot Ara', '2013-04-02', 2, 'Chan Bekari goli', '01786295659', 'A+', '28', NULL, 12000, 'Hawker', 'Housemaid', 3.8, 21.3, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(30, 'Shawon Hossain', 'Sujon', 'Ronju kter', '2013-07-16', 1, '12 Colony', '01927119878', 'O+', '29', NULL, 15000, 'Electrician', 'Housemaid', 3.8, 21.6, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(31, 'Najnin Akter', 'Miras Uddin', 'Minara Begum', '2013-09-05', 2, 'Shonalibag', '01954515426', 'B+', '30', NULL, 14000, 'Auto Driver', 'Housemaid', 3.7, 21.1, 1, 4, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(32, 'Suborna Akter', 'Shahid', 'Farida', '2013-09-20', 2, '12 Colony', '01910121513', 'A+', '31', NULL, 13500, 'Shopkeeper', 'School Maid', 3.9, 21.5, 1, 0, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(33, 'Rayhan Hossain', 'Gias uddin', 'Helena begum', '2013-03-14', 1, 'Greenway', '01952383750', 'O+', '32', NULL, 12000, 'Hawker', 'Housemaid', 3.8, 21.3, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(34, 'Sathi Akter', 'Md. Alal', 'Hena Begum', '2013-10-03', 2, 'Bepari Goli', '1763996992', 'B+', '33', NULL, 15000, 'Electrician', 'Housemaid', 3.8, 21.6, 1, 0, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(35, 'Ayan Hossain', 'Md. Harun', ' Jasmin Begum', '2013-02-23', 1, 'Chan Bekari goli', '1611993447', 'O+', '34', NULL, 14000, 'Auto Driver', 'Housemaid', 3.7, 21.1, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(36, 'William', 'Willard', 'Chloe', '2012-06-08', 2, NULL, '1701884230', 'A+', '35', NULL, 14000, 'Rickshaw Puller', 'Housewife', 3.7, 21.4, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(37, 'Osian ', 'Isaiah', 'Jodie', '2013-05-22', 2, 'Shonalibag', '1706216507', 'O+', '36', NULL, 12000, 'Hawker', 'Housemaid', 3.8, 21.3, 1, 0, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(38, 'Patrick', 'Kane', 'Gloria', '2013-04-02', 2, 'Chan Bekari goli', '01927119878', 'O+', '37', NULL, 15000, 'Electrician', 'Housemaid', 3.8, 21.6, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(39, 'Violet', 'Joe', 'Melody', '2013-07-16', 2, 'Shonalibag', '01682074533', 'O+', '38', NULL, 24000, 'Wright', 'Foreign Worker', 3.7, 21.5, 1, 0, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(40, 'Taslima Akter', 'Kader', 'Parvin Begum', '2013-06-04', 2, '12 Colony', '1956802153', 'A-', '39', NULL, 18000, 'Fish Seller', 'Housemaid', 3.8, 21.2, 1, 0, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(41, 'Monica', 'Lloyd', 'Emilia', '2015-05-20', 1, 'peyarabag', '1868106445', 'B+', '40', NULL, 18000, 'Fish Seller', 'Housemaid', 3.8, 21.2, 1, 2, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(42, 'Rony Hossain', 'Ashraf', 'Helena begum', '2013-02-23', 1, 'Chan Bekari goli', '01943986183', 'O+', '41', NULL, 9000, 'Supervisor', 'Housemaid', 3.8, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(43, 'Tayeba Akter', 'nasir Uddin', 'Amena', '2013-08-25', 2, 'peyarabag', '01924763728', 'O+', '42', NULL, 20000, 'Security Guard', 'Housemaid', 3.5, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(44, 'Surjo', 'Shukkur Ali', 'fulton Begum', '2013-01-01', 1, 'peyarabag', '1966687694', 'O+', '43', NULL, 12000, 'Rickshaw Puller', 'Housmaid', 3.9, 21.6, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(45, 'Rose', 'Bruce', 'April', '2013-07-04', 2, 'Chan Bekari goli', '1903542303', 'O+', '44', NULL, 12000, 'Driver', 'Housewife', 3.8, 21.7, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(46, 'Tonya', 'Harley', 'Violet', '2011-02-10', 2, 'Shonalibag', '01786295659', 'B+', '45', NULL, 13500, 'Shopkeeper', 'School Maid', 3.9, 21.2, 1, 4, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(47, 'Rachael', 'Jeremiah', 'Amira', '2012-11-09', 1, 'peyarabag', '01792590998', 'O+', '46', NULL, 16500, 'Shopkeeper', 'Hospital Maid', 3.6, 21.5, 1, 2, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(48, 'Isabella', 'Renee', 'Claudia', '2013-06-04', 2, 'Shonalibag', '01954515426', 'A-', '47', NULL, 14000, 'Auto Driver', 'Housemaid', 3.7, 21.1, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(49, 'Siam Hossain', 'Ujjol', 'Farjana', '2013-07-15', 1, 'Majar bari', '1903542303', 'O+', '48', NULL, 12000, 'Shopkeeper', 'Housemaid', 4.1, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(50, 'Tarek Hossain', 'Mahbub', 'Rabeya', '2013-06-04', 1, 'peyarabag', '01682074533', 'A-', '49', NULL, 15000, 'Driver', 'Housewife', 3.7, 22, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(51, 'Anonna Akter', 'Md. Imam', 'parul', '2013-07-04', 2, 'Shonalibag', '01682074533', 'O+', '50', NULL, 12000, 'Rickshaw Puller', 'Housmaid', 3.9, 21.6, 1, 0, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(52, 'Zihad Hossain', 'Firoj', 'Julekha Banu', '2013-09-15', 1, 'peyarabag', '01747794125', 'O+', '51', NULL, 12000, 'Shopkeeper', 'Housemaid', 4.1, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(53, 'Nusrat Akter', 'Faruk ', 'Sufia', '2013-07-16', 2, 'Shonalibag', '1787540506', 'B+', '52', NULL, 15000, 'Driver', 'Housewife', 3.7, 22, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(54, 'Samia Akter Fatema ', 'Shahin', 'Mukta begum', '2013-08-25', 2, 'Shonalibag', '1787540506', 'AB-', '53', NULL, 12000, 'Shopkeeper', 'Housemaid', 4.1, 21.5, 1, 2, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(55, 'naim hossain Billal', 'Hiru Mia', 'Shahanaj Begum', '2013-02-23', 2, '12 Colony', '01918466683', 'AB+', '54', NULL, 15000, 'Driver', 'Housewife', 3.7, 22, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(56, 'Shuvo Hossain', 'Shopon', 'Shefali', '2013-04-16', 1, 'Shonalibag', '01973664510', 'B+', '55', NULL, 12000, 'Sanitary Wright', 'Housewife', 3.8, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(57, 'Irene', 'Erik', 'Kaitlin', '2013-05-05', 1, 'Shonalibag', '1943428618', 'O+', '56', NULL, 12000, 'Sanitary Wright', 'Housewife', 3.8, 21.5, 1, 4, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(58, 'Yasmin', 'Bruce', 'April', '2013-09-15', 2, 'Shonalibag', '1706216507', 'B+', '57', NULL, 13000, 'Chef', 'Housemaid', 3.8, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(59, 'Sumaiya Akter', 'Amirul Islam', 'Rasheda Begum', '2014-02-03', 2, 'Chan Bekari goli', '01935038686', 'A-', '58', NULL, 12000, 'Driver', 'Housewife', 3.8, 21.7, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(60, 'Arafat Hossain', 'Shofiqul Isalm', 'Monira Begum', '2013-12-10', 1, 'peyarabag', '01787540506', 'AB+', '59', NULL, 10000, 'Rickshaw Manager', 'Housewife', 3.5, 21.2, 1, 2, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(61, 'Tonny Akter', 'Israfil', 'Rehena Begum', '2013-02-22', 2, '12 Colony', '01903942426', 'O+', '60', NULL, 7000, 'Rickshaw Puller', 'Housewife', 3.7, 21.4, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(62, 'Maliha Akter', 'Miraj hossain', 'Minara Begum', '2013-05-22', 2, 'Shonalibag', '01920909529', 'O+', '61', NULL, 13000, 'Construction Worker', 'Housemaid', 3.6, 21.6, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(63, 'Samia Akter', 'Shahin', 'Suma Begum', '2013-04-02', 2, 'T&T colony', '1914892009', 'B+', '62', NULL, 9000, 'Supervisor', 'Housemaid', 3.8, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(64, 'Clairan', 'Mark', 'Paige', '2013-07-15', 2, 'Shonalibag', '1706216507', 'O+', '63', NULL, 9000, 'Supervisor', 'Housemaid', 3.8, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(65, 'Ashley', 'Callum', 'Kyla ', '2013-06-04', 2, 'Greenway', '01954515426', 'B-', '64', NULL, 10000, 'Rickshaw Manager', 'Housewife', 3.5, 21.2, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(66, 'Herman', 'Ahmad', 'Harmony', '2013-03-14', 2, 'Chan Bekari goli', '1795493375', 'A-', '65', NULL, 17000, 'Driver', 'Housemaid', 3.8, 21.5, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(67, 'Bradley', 'Antonio', 'Tamara', '2013-02-23', 2, 'peyarabag', '01954515426', 'B+', '66', NULL, 12000, 'Rickshaw Puller', 'Housmaid', 3.9, 21.6, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27'),
(68, 'Bradley', 'Antonia', 'Tamara', '2013-02-23', 2, 'peyarabag', '01954515426', 'B+', '66', NULL, 12000, 'Rickshaw Puller', 'Housmaid', 3.9, 21.6, 1, 1, '2019-07-31 23:44:27', '2019-07-31 23:44:27');

-- --------------------------------------------------------

--
-- Table structure for table `student_attendances`
--

CREATE TABLE `student_attendances` (
  `id` int(10) UNSIGNED NOT NULL,
  `student_id` int(10) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL,
  `gender` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_attendances`
--

INSERT INTO `student_attendances` (`id`, `student_id`, `status`, `gender`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(2, 2, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(3, 3, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(4, 4, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(5, 5, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(6, 6, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(7, 7, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(8, 8, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(9, 9, 2, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(10, 10, 2, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(11, 11, 2, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(12, 12, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(13, 13, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(14, 14, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(15, 15, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(16, 16, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(17, 17, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(18, 18, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(19, 19, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(20, 20, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(21, 21, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(22, 22, 2, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(23, 23, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(24, 24, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(25, 25, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(26, 26, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(27, 27, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(28, 28, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(29, 29, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(30, 30, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(31, 31, 2, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(32, 32, 2, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(33, 33, 2, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(34, 34, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(35, 35, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(36, 36, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(37, 37, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(38, 38, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(39, 39, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(40, 40, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(41, 41, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(42, 42, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(43, 43, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(44, 44, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(45, 45, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(46, 46, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(47, 47, 2, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(48, 48, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(49, 49, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(50, 50, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(51, 51, 2, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(52, 52, 2, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(53, 53, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(54, 54, 2, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(55, 55, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(56, 56, 2, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(57, 57, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(58, 58, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(59, 59, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(60, 60, 1, 1, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(61, 61, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(62, 62, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(63, 63, 2, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(64, 64, 2, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(65, 65, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(66, 66, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(67, 67, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27'),
(68, 68, 1, 2, '2019-08-01 05:45:27', '2019-08-01 05:45:27');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Social Science', '2019-08-01 00:18:51', '2019-08-01 00:18:51'),
(2, 'Maths', '2019-08-01 00:18:57', '2019-08-01 00:18:57');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(10) UNSIGNED NOT NULL,
  `firstName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` int(11) DEFAULT NULL,
  `salary` int(11) DEFAULT NULL,
  `phoneNumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `firstName`, `lastName`, `gender`, `salary`, `phoneNumber`, `address`, `email`, `password`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, 'Ashfaq', 'Ahmed', 1, 35000, '0125649821564', 'Dhaka', 'teacher@chalkboard.online', '$2y$10$F04yD1YhxaiQev.u/sm9se7i6jJIex4d/iLzm3K9USatslDYZfOKm', '2019-07-31 23:46:48', '2019-07-31 23:46:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_has_sections`
--

CREATE TABLE `teacher_has_sections` (
  `teacher_id` int(10) UNSIGNED NOT NULL,
  `section_id` int(10) UNSIGNED NOT NULL,
  `class_teacher` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_has_sections`
--

INSERT INTO `teacher_has_sections` (`teacher_id`, `section_id`, `class_teacher`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2019-07-31 23:47:36', '2019-07-31 23:47:36');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_has_subjects`
--

CREATE TABLE `teacher_has_subjects` (
  `teacher_id` int(10) UNSIGNED NOT NULL,
  `subject_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `firstName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` int(11) NOT NULL,
  `salary` int(11) NOT NULL,
  `phoneNumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `gender`, `salary`, `phoneNumber`, `address`, `email`, `password`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, 'admin', 'bhai', 1, 96000, '2341234234234', 'dhka', 'admin@chalkboard.com', '$2y$10$SCuxRROtFMZrRyisTgjGeepwcDYpnQ1VyXM7EXXdTB6xEoeBGClFa', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `attendance_taken`
--
ALTER TABLE `attendance_taken`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_taken_section_id_foreign` (`section_id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exams_subject_id_foreign` (`subject_id`),
  ADD KEY `exams_section_id_foreign` (`section_id`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`inventory_id`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marks_section_id_foreign` (`section_id`),
  ADD KEY `marks_exam_id_foreign` (`exam_id`),
  ADD KEY `marks_subject_id_foreign` (`subject_id`),
  ADD KEY `marks_student_id_foreign` (`student_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `remarks`
--
ALTER TABLE `remarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `remarks_student_id_foreign` (`student_id`);

--
-- Indexes for table `remark_category`
--
ALTER TABLE `remark_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section_has_students`
--
ALTER TABLE `section_has_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_has_students_section_id_foreign` (`section_id`),
  ADD KEY `section_has_students_student_id_foreign` (`student_id`);

--
-- Indexes for table `section_has_subjects`
--
ALTER TABLE `section_has_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_attendances`
--
ALTER TABLE `student_attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_attendances_student_id_foreign` (`student_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teachers_email_unique` (`email`);

--
-- Indexes for table `teacher_has_sections`
--
ALTER TABLE `teacher_has_sections`
  ADD PRIMARY KEY (`teacher_id`,`section_id`),
  ADD KEY `teacher_has_sections_section_id_foreign` (`section_id`);

--
-- Indexes for table `teacher_has_subjects`
--
ALTER TABLE `teacher_has_subjects`
  ADD PRIMARY KEY (`teacher_id`,`subject_id`),
  ADD KEY `teacher_has_subjects_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance_taken`
--
ALTER TABLE `attendance_taken`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `remarks`
--
ALTER TABLE `remarks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `remark_category`
--
ALTER TABLE `remark_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `section_has_students`
--
ALTER TABLE `section_has_students`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `section_has_subjects`
--
ALTER TABLE `section_has_subjects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `student_attendances`
--
ALTER TABLE `student_attendances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`);

--
-- Constraints for table `attendance_taken`
--
ALTER TABLE `attendance_taken`
  ADD CONSTRAINT `attendance_taken_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `exams_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `marks_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`),
  ADD CONSTRAINT `marks_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `marks_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `marks_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `remarks`
--
ALTER TABLE `remarks`
  ADD CONSTRAINT `remarks_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `section_has_students`
--
ALTER TABLE `section_has_students`
  ADD CONSTRAINT `section_has_students_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `section_has_students_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `student_attendances`
--
ALTER TABLE `student_attendances`
  ADD CONSTRAINT `student_attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `teacher_has_sections`
--
ALTER TABLE `teacher_has_sections`
  ADD CONSTRAINT `teacher_has_sections_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `teacher_has_sections_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`);

--
-- Constraints for table `teacher_has_subjects`
--
ALTER TABLE `teacher_has_subjects`
  ADD CONSTRAINT `teacher_has_subjects_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `teacher_has_subjects_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
