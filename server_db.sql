-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 10, 2020 at 05:53 PM
-- Server version: 10.1.41-MariaDB-0+deb9u1
-- PHP Version: 7.3.13-1+0~20191218.50+debian9~1.gbp23c2da

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `schms`
--

-- --------------------------------------------------------

--
-- Table structure for table `backup`
--

CREATE TABLE `backup` (
  `id` int(6) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_time` datetime NOT NULL,
  `file_size` int(5) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(3) NOT NULL,
  `grade_id` int(2) NOT NULL,
  `staff_id` int(6) DEFAULT NULL,
  `name` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `grade_id`, `staff_id`, `name`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 1, 6, 'A', '2019-12-11 05:30:20', '2020-01-10 22:30:54', NULL),
(2, 1, 3, 'B', '2019-12-14 21:43:14', '2020-01-10 22:31:01', NULL),
(3, 2, NULL, 'A', '2019-12-15 09:37:50', '2019-12-15 09:37:50', NULL),
(4, 2, NULL, 'B', '2019-12-15 14:48:19', '2019-12-15 14:48:19', NULL),
(5, 3, NULL, 'A', '2019-12-15 19:52:04', '2019-12-15 19:52:04', NULL),
(6, 3, NULL, 'B', '2019-12-18 20:03:21', '2019-12-18 20:03:21', NULL),
(7, 4, NULL, 'A', '2019-12-22 17:25:24', '2019-12-22 17:25:24', NULL),
(8, 4, NULL, 'B', '2019-12-22 20:22:18', '2019-12-22 20:22:18', NULL),
(9, 5, NULL, 'A', '2019-12-26 19:07:36', '2019-12-26 19:07:36', NULL),
(10, 5, NULL, 'B', '2019-12-29 10:51:04', '2019-12-29 10:51:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `class_timetable`
--

CREATE TABLE `class_timetable` (
  `id` int(11) NOT NULL,
  `class_id` int(3) NOT NULL,
  `day` int(1) NOT NULL,
  `period` int(1) NOT NULL,
  `subject_id` int(3) NOT NULL,
  `staff_id` int(6) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `class_timetable`
--

INSERT INTO `class_timetable` (`id`, `class_id`, `day`, `period`, `subject_id`, `staff_id`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 1, 1, 1, 1, 6, '2020-01-10 22:32:54', '2020-01-10 22:33:36', NULL),
(2, 1, 2, 1, 1, 6, '2020-01-10 22:33:02', '2020-01-10 22:33:39', NULL),
(3, 1, 3, 1, 1, 6, '2020-01-10 22:33:05', '2020-01-10 22:33:42', NULL),
(4, 1, 4, 1, 1, 6, '2020-01-10 22:33:09', '2020-01-10 22:33:45', NULL),
(5, 1, 5, 1, 1, 6, '2020-01-10 22:33:13', '2020-01-10 22:33:48', NULL),
(6, 1, 1, 2, 1, 6, '2020-01-10 23:10:52', '2020-01-10 23:10:56', NULL),
(7, 1, 1, 3, 5, 13, '2020-01-10 23:11:01', '2020-01-10 23:12:01', NULL),
(8, 1, 1, 4, 8, 7, '2020-01-10 23:12:29', '2020-01-10 23:12:34', NULL),
(9, 1, 1, 5, 3, 12, '2020-01-10 23:13:06', '2020-01-10 23:13:10', NULL),
(10, 1, 1, 6, 2, 1, '2020-01-10 23:13:31', '2020-01-10 23:13:40', NULL),
(11, 1, 1, 7, 4, 14, '2020-01-10 23:13:58', '2020-01-10 23:14:04', NULL),
(12, 1, 1, 8, 6, 17, '2020-01-10 23:14:29', '2020-01-10 23:14:32', NULL),
(13, 1, 2, 2, 7, 5, '2020-01-10 23:18:22', '2020-01-10 23:18:28', NULL),
(14, 1, 2, 3, 7, 5, '2020-01-10 23:18:54', '2020-01-10 23:18:58', NULL),
(15, 1, 2, 4, 3, 12, '2020-01-10 23:20:09', '2020-01-10 23:20:18', NULL),
(16, 1, 2, 5, 4, 14, '2020-01-10 23:21:23', '2020-01-10 23:21:29', NULL),
(17, 1, 2, 6, 8, 7, '2020-01-10 23:21:37', '2020-01-10 23:21:47', NULL),
(18, 1, 2, 7, 2, 1, '2020-01-10 23:21:58', '2020-01-10 23:22:05', NULL),
(19, 1, 2, 8, 6, 17, '2020-01-10 23:22:32', '2020-01-10 23:22:41', NULL),
(20, 1, 3, 2, 3, 12, '2020-01-10 23:22:48', '2020-01-10 23:22:55', NULL),
(21, 1, 3, 3, 2, 1, '2020-01-10 23:22:59', '2020-01-10 23:23:11', NULL),
(22, 1, 3, 4, 2, 1, '2020-01-10 23:23:17', '2020-01-10 23:23:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coach`
--

CREATE TABLE `coach` (
  `id` int(6) NOT NULL,
  `admission_date` date NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initials` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nic` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_home` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_mobile` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_id` int(2) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coach`
--

INSERT INTO `coach` (`id`, `admission_date`, `full_name`, `initials`, `surname`, `nic`, `dob`, `gender`, `email`, `phone_home`, `phone_mobile`, `address`, `city`, `district_id`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, '2010-05-22', 'Senanayaka Mudiyanselage Sugath Kanchana Senanayaka', 'S M S K', 'Senanayaka', '1989243658', '1989-07-28', 'male', 'sugathsenanayaka@gmail.com', NULL, '0778544563', '372/5, Guruvidyala road', 'Veyangoda', 1, '2020-01-09 22:39:41', '2020-01-09 22:39:41', NULL),
(2, '2015-08-15', 'Narangoda Arachchige Niluka Sampath Narangoda', 'N A N S', 'Narangoda', '1987365136', '1978-06-15', 'male', 'niluka89@gmil.com', NULL, '0705563124', '154/21, Kothalawala Mawatha', 'Yatiyana', 1, '2020-01-09 22:42:34', '2020-01-09 22:42:34', NULL),
(3, '2016-04-02', 'Hadunneththige Udeshika Thilakasiri', 'H U', 'Thilakasiri', '1988621352', '1986-06-11', 'female', 'udeshikahadunnettige@gmail.com', '0118574612', '0778563416', '122/3, Aruggoda road', 'Udugampola', 1, '2020-01-09 22:46:35', '2020-01-09 22:46:35', NULL),
(4, '2016-09-30', 'Ranasinghe Bandaralage Wishwa Chanaka Bandara', 'R B W C', 'Bandara', '1985364758', '1985-07-18', 'male', 'wishwachanaka@gmail.com', NULL, '0716324515', '342/5B, Sanhida Mawatha', 'Minuwangoda', 1, '2020-01-09 22:49:32', '2020-01-09 22:49:32', NULL),
(5, '2017-07-16', 'Gunasekara Arachchilage Nipuni Wishaka Gunasekara', 'G A N W', 'Gunasekara', '1990586321', '1990-06-22', 'female', 'nipuwishaka@gmail.com', '0336584251', '0718524411', '751/4, Siyane road', 'Gampaha', 1, '2020-01-09 22:52:33', '2020-01-09 22:52:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coach_has_sport`
--

CREATE TABLE `coach_has_sport` (
  `id` int(4) NOT NULL,
  `coach_id` int(6) NOT NULL,
  `sport_id` int(3) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coach_has_sport`
--

INSERT INTO `coach_has_sport` (`id`, `coach_id`, `sport_id`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 1, 1, '2020-01-09 22:39:41', '2020-01-09 22:39:41', NULL),
(2, 2, 2, '2020-01-09 22:42:34', '2020-01-09 22:42:34', NULL),
(3, 3, 4, '2020-01-09 22:46:35', '2020-01-09 22:46:35', NULL),
(4, 4, 3, '2020-01-09 22:49:32', '2020-01-09 22:49:32', NULL),
(5, 5, 5, '2020-01-09 22:52:33', '2020-01-09 22:52:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `id` int(2) NOT NULL,
  `province_id` int(2) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`id`, `province_id`, `name`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 1, 'Gampaha', '2019-02-11 00:00:00', '2019-02-11 00:00:00', NULL),
(2, 1, 'Colombo', '2019-02-11 00:00:00', '2019-02-11 00:00:00', NULL),
(3, 1, 'Kaluthara', '2019-02-11 00:00:00', '2019-02-11 00:00:00', NULL),
(4, 2, 'Kegalle', '2019-02-11 00:00:00', '2019-02-11 00:00:00', NULL),
(5, 2, 'Ratnapura', '2019-02-11 00:00:00', '2019-02-11 00:00:00', NULL),
(6, 3, 'Kurunegala', '2019-02-11 00:00:00', '2019-02-11 00:00:00', NULL),
(7, 3, 'Puttalam', '2019-02-11 00:00:00', '2019-02-11 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `id` int(4) NOT NULL,
  `type_id` int(2) NOT NULL,
  `year` year(4) NOT NULL,
  `venue` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'School premises',
  `instructions` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT 'No instructions',
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`id`, `type_id`, `year`, `venue`, `instructions`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 1, 2020, 'School Premises', 'No instructions', '2020-01-10 22:22:31', '2020-01-10 22:22:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam_grade_has_schedule`
--

CREATE TABLE `exam_grade_has_schedule` (
  `id` int(4) NOT NULL,
  `exam_grade_id` int(4) NOT NULL,
  `subject_id` int(3) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `venue` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'School premises',
  `instructions` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT 'No instructions',
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_grade_has_schedule`
--

INSERT INTO `exam_grade_has_schedule` (`id`, `exam_grade_id`, `subject_id`, `date`, `start_time`, `end_time`, `venue`, `instructions`, `created_on`, `updated_on`, `deleted_on`) VALUES
(2, 1, 3, '2020-03-20', '11:00:00', '13:00:00', 'Ananda Hall', NULL, '2020-01-10 22:43:43', '2020-01-10 22:43:43', NULL),
(3, 1, 8, '2020-03-23', '08:00:00', '10:00:00', 'Ananda Hall', NULL, '2020-01-10 22:45:03', '2020-01-10 22:45:03', NULL),
(4, 1, 6, '2020-03-23', '11:00:00', '13:00:00', 'Ananda Hall', NULL, '2020-01-10 22:45:56', '2020-01-10 22:45:56', NULL),
(5, 1, 7, '2020-03-24', '08:00:00', '10:00:00', 'Ananda Hall', NULL, '2020-01-10 22:47:48', '2020-01-10 22:47:48', NULL),
(6, 1, 1, '2020-03-25', '08:00:00', '10:00:00', 'Ananda Hall', 'Avoid  taking calculators to the exam hall', '2020-01-10 22:51:30', '2020-01-10 22:51:30', NULL),
(7, 1, 2, '2020-03-26', '08:00:00', '10:00:00', 'Ananda Hall', NULL, '2020-01-10 22:52:22', '2020-01-10 22:52:22', NULL),
(8, 1, 4, '2020-03-27', '08:00:00', '10:00:00', 'Ananda Hall', NULL, '2020-01-10 22:53:23', '2020-01-10 22:53:23', NULL),
(10, 2, 3, '2020-03-20', '11:00:00', '13:00:00', 'Main Hall', NULL, '2020-01-10 22:54:48', '2020-01-10 22:54:48', NULL),
(11, 2, 8, '2020-03-23', '08:00:00', '10:00:00', 'Main Hall', NULL, '2020-01-10 22:55:49', '2020-01-10 22:55:49', NULL),
(12, 2, 6, '2020-03-23', '11:00:00', '13:00:00', 'Main Hall', NULL, '2020-01-10 22:56:32', '2020-01-10 22:56:32', NULL),
(13, 2, 7, '2020-03-24', '08:00:00', '10:00:00', 'Main Hall', NULL, '2020-01-10 22:58:23', '2020-01-10 22:58:23', NULL),
(14, 1, 5, '2020-03-20', '08:00:00', '10:00:00', 'Ananda Hall', NULL, '2020-01-10 22:59:58', '2020-01-10 22:59:58', NULL),
(15, 2, 5, '2020-03-20', '08:00:00', '10:00:00', 'Main Hall', NULL, '2020-01-10 23:03:40', '2020-01-10 23:03:40', NULL),
(16, 2, 1, '2020-03-25', '08:00:00', '10:00:00', 'Main Hall', 'Avoid takin calculators to the exam hall', '2020-01-10 23:07:47', '2020-01-10 23:07:47', NULL),
(17, 2, 2, '2020-03-26', '08:00:00', '10:00:00', 'Main Hall', NULL, '2020-01-10 23:08:28', '2020-01-10 23:08:28', NULL),
(18, 2, 4, '2020-03-27', '08:00:00', '10:00:00', 'Main Hall', NULL, '2020-01-10 23:09:02', '2020-01-10 23:09:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam_has_grade`
--

CREATE TABLE `exam_has_grade` (
  `id` int(4) NOT NULL,
  `exam_id` int(4) NOT NULL,
  `grade_id` int(2) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_has_grade`
--

INSERT INTO `exam_has_grade` (`id`, `exam_id`, `grade_id`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 1, 1, '2020-01-10 22:26:27', '2020-01-10 22:26:27', NULL),
(2, 1, 2, '2020-01-10 22:54:15', '2020-01-10 22:54:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam_type`
--

CREATE TABLE `exam_type` (
  `id` int(2) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_type`
--

INSERT INTO `exam_type` (`id`, `name`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 'First Term Test', '2020-01-10 20:34:15', '2020-01-10 20:34:15', NULL),
(2, 'Second Term Test', '2020-01-10 20:34:29', '2020-01-10 20:34:29', NULL),
(3, 'Third Term Test', '2020-01-10 20:34:41', '2020-01-10 20:34:41', NULL),
(4, 'Assignment', '2020-01-10 20:35:08', '2020-01-10 20:35:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `id` int(2) NOT NULL,
  `name` int(2) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`id`, `name`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 6, '2019-12-11 05:29:05', '2020-01-08 18:23:52', NULL),
(2, 7, '2019-12-11 05:29:10', '2020-01-08 18:23:59', NULL),
(3, 8, '2019-12-11 05:29:16', '2020-01-08 18:24:13', NULL),
(4, 9, '2019-12-11 05:29:21', '2020-01-08 18:24:19', NULL),
(5, 10, '2019-12-11 05:29:26', '2020-01-08 18:24:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` bigint(20) NOT NULL,
  `sender_id` int(6) NOT NULL,
  `receiver_id` int(6) NOT NULL,
  `body` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` bigint(20) NOT NULL,
  `sender_id` int(6) NOT NULL,
  `receiver_id` int(6) NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `sender_id`, `receiver_id`, `title`, `body`, `status`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 2, 1, 'Attendance Marked', 'Your are present on 2020-01-06', 0, '2020-01-10 19:10:09', '2020-01-10 19:10:09', NULL),
(2, 2, 2, 'Attendance Marked', 'Your are present on 2020-01-06', 0, '2020-01-10 19:10:34', '2020-01-10 19:10:34', NULL),
(3, 2, 1, 'Attendance Marked', 'Your are present on 2020-01-07', 0, '2020-01-10 19:10:53', '2020-01-10 19:10:53', NULL),
(4, 2, 1, 'Attendance Marked', 'Your are present on 2020-01-08', 0, '2020-01-10 19:11:34', '2020-01-10 19:11:34', NULL),
(5, 2, 1, 'Attendance Marked', 'Your are present on 2020-01-09', 0, '2020-01-10 19:12:18', '2020-01-10 19:12:18', NULL),
(6, 2, 2, 'Attendance Marked', 'Your are present on 2020-01-09', 0, '2020-01-10 19:12:35', '2020-01-10 19:12:35', NULL),
(7, 2, 3, 'Account Activated', 'Your account has been activated by System Administrator', 0, '2020-01-10 20:39:25', '2020-01-10 20:39:25', NULL),
(8, 3, 4, 'Account Activated', 'Your account has been activated by System Administrator', 0, '2020-01-10 23:19:33', '2020-01-10 23:19:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `parent`
--

CREATE TABLE `parent` (
  `id` int(7) NOT NULL,
  `nic` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initials` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_home` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_mobile` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `occupation` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `income` int(10) DEFAULT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_id` int(2) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parent`
--

INSERT INTO `parent` (`id`, `nic`, `full_name`, `initials`, `surname`, `dob`, `gender`, `email`, `phone_home`, `phone_mobile`, `occupation`, `position`, `income`, `address`, `city`, `district_id`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, '198724512345', 'Ruwanpathirana Arachchige Buddhika Ruwanpathirana', 'R A B', 'Ruwanpathirana', '1987-10-15', 'Male', 'buddhika87@gmail.com', '0332544542', '712543654', 'Teacher', NULL, 45000, '267/10, Nagahakotuwa road', 'Gampaha', 1, '2019-12-14 14:15:29', '2019-12-14 14:15:29', NULL),
(2, '197012509876', 'Edirisinghe Dewage Chanaka  Naveen Edirisinghe', 'E D C N', 'Edirisinghe', '1970-12-30', 'Male', 'chanakanaveen@gmail.com', '0117893546', '0772581532', 'Software engineer', NULL, 70000, '144/5A, Palmgrove estate', 'Veyangoda', 1, '2019-12-14 15:54:45', '2019-12-14 15:54:45', NULL),
(3, '198832487654', 'Herath Muduyanselage Janith Chathuranga Herath', 'H M J C', 'Herath', '1988-05-04', 'Male', 'chathuranga12@ymail.com', '0338524639', '0779823516', 'Accountant', NULL, 50000, '234/2, malwaththa road', 'Gampaha', 1, '2019-12-14 16:01:15', '2019-12-14 16:01:15', NULL),
(4, '196928736985', 'Hettiarachchi Gamage Mahesh Kulathunga', 'H G M', 'Kulathunga', '1969-08-24', 'Male', 'maheshkulathunga@gmail.com', NULL, '714563278', 'Businessman', NULL, 40000, '12/2B, Poruthota road', 'Minuwangoda', 1, '2019-12-14 16:08:06', '2019-12-14 16:08:06', NULL),
(5, '198575674125', 'Handugala Dewage Imalsha Sirideva', 'H D I', 'Sirideva', '1985-11-03', 'Female', 'sirideva11@gmail.com', '0119632312', '0774078087', 'Teacher', NULL, 50000, '321/A, Cemetry road', 'Yatiyana', 1, '2019-12-14 16:25:04', '2019-12-14 16:25:04', NULL),
(6, '198712645431', 'Colambage Don Kanchana Weerasinghe', 'C D K', 'Weerasinghe', '1987-09-16', 'Male', 'weerasinghe@gmail.com', '0119874532', '0783219674', 'Accountant Clerk', NULL, 25000, '123/5, Silva Mawatha', 'Dewalapola', 1, '2019-12-14 16:32:37', '2019-12-14 16:32:37', NULL),
(7, '198628925874', 'Rupasinghe Jayawardhana Mudiyanselage Gihan Susantha Rupasinghe', 'R J M G S', 'Rupasinghe', '1986-12-02', 'Male', 'rupasinghe45@gmail.com', '0117963285', '0715469237', 'Doctor', NULL, 85000, '45/2, Ekala Road', 'Minuwangoda', 1, '2019-12-14 16:39:32', '2019-12-14 16:39:32', NULL),
(8, '198865345637', 'Samarasinghe Arachchige Deepthi Samarasinghe', 'S A D', 'Samarasinghe', '1988-04-12', 'Female', 'deepthisam@gmail.com', NULL, '0772549863', 'Custom Tailor', NULL, 25000, '675/8, Pansala Road', 'Udugampola', 1, '2019-12-14 16:45:57', '2019-12-14 16:45:57', NULL),
(9, '198429432976', 'Ranasinghe Bandaralage Sisil Priyankara Ranasinghe', 'R B S P', 'Ranasinghe', '1984-08-03', 'Male', 'sisilpriyankara21@gmail.com', '0336579812', '0713697613', 'Police Officer', NULL, 45000, '314/6, Oruthota Road', 'Gampaha', 1, '2019-12-14 16:55:02', '2019-12-14 16:55:02', NULL),
(10, '198972936497', 'Thenuwara Arachchige Sachini Nisansala Liyanage', 'T A S N', 'Liyanage', '1989-10-31', 'Female', 'sachinisansala93@gmail.com', NULL, '0776483216', 'Teacher', NULL, 50000, '187/2, 2nd lane', 'Bulugahamulla', 1, '2019-12-14 17:02:24', '2019-12-14 17:02:24', NULL),
(11, '199023945693', 'Jayawardhana Arachchige Disal Jayawardhana', 'J A D', 'Jayawardhana', '1990-06-19', 'Male', 'disaljaya90@gmail.com', NULL, '0714569135', 'Accountant', NULL, 55000, '233/6B, Kalawana Road', 'Dewalapola', 1, '2019-12-14 17:08:08', '2019-12-14 17:08:08', NULL),
(12, '198936834692', 'Kariyawasam Mudiyanselage Chalitha Sandaruwan Kariyawasam', 'K M C S', 'Kariyawasam', '1989-05-30', 'Male', 'kariyawasam@gmail.com', '0118523416', '0711239845', 'Businessman', NULL, 35000, '541/10, Senanayake Road', 'Udugampola', 1, '2019-12-14 17:15:17', '2019-12-14 17:15:17', NULL),
(13, '199112936418', 'Denagamage Kasun Madhushanka Ekanayake', 'D K M', 'Ekanayake', '1991-07-12', 'Male', 'kasunmadushanka@gmail.com', NULL, '778943162', 'Technician', NULL, 30000, '65/3, Bandarawatta road', 'Minuwangoda', 1, '2019-12-14 17:21:38', '2019-12-14 17:21:38', NULL),
(14, '198727378960', 'Narangoda Liyanarachchige Nalin Sanjeewa Perera', 'N L N S', 'Perera', '1987-03-28', 'Male', 'sanjeewa25@gmail.com', NULL, '712396413', 'Driver', NULL, 40000, '41/C, Hena road', 'Yatiyana', 1, '2019-12-14 17:28:10', '2019-12-14 17:28:10', NULL),
(15, '198032196328', 'Thennakoon Mohottige Deshan Kavishka Thennakoon', 'T M D K', 'Thennakoon', '1980-06-19', 'Male', 'thennakoonkavishka@gmail.com', '0119873641', '0778631294', 'Engineer', NULL, 90000, '234/5, Samagi Mawatha', 'Udugampola', 1, '2019-12-14 21:49:11', '2019-12-14 21:49:11', NULL),
(16, '199168912385', 'Udagedara Arachchige Iresha Hansamali Rathnayake', 'U A I H', 'Rathnayake', '1991-12-23', 'Female', 'iresha34@gmail.com', NULL, '0714563219', 'Clerk', NULL, 35000, '12/A, Kottegoda road', 'Yatiyana', 1, '2019-12-14 21:54:13', '2019-12-14 21:54:13', NULL),
(17, '198513978932', 'Vithana Arachchilage Hansaka Vithanage', 'V A H', 'Vithanage', '1985-03-08', 'Male', 'vithanage08@gmail.com', NULL, '0778631546', 'Soldier', NULL, 45000, '987/2, Masvila road', 'Wegowwa', 1, '2019-12-14 21:59:41', '2019-12-14 21:59:41', NULL),
(18, '198234645680', 'Navinna Mudiyanselage Thushara Sampath Navinna', 'N M T S', 'Navinna', '1982-01-25', 'Male', 'thusharanavinna@gmail.com', '0118964273', '0714569731', 'Accountant', NULL, 55000, '56/4C, Aluthgama road', 'Nilpanagoda', 1, '2019-12-14 22:04:43', '2019-12-14 22:04:43', NULL),
(19, '198427912398', 'Neththasinghe Dewage Ishara Devinda Neththasinghe', 'N D I D', 'Neththasinghe', '1984-02-27', 'Male', 'neth23ishara@gmail.com', '0113694512', '0714529846', 'Police Officer', NULL, 60000, '511/6, Bamunumulla road', 'Weediyawatta', 1, '2019-12-14 22:10:28', '2019-12-14 22:10:28', NULL),
(20, '198132145672', 'Hewa Kariyawasamlage Nadeesha Gayan Jayawardhane', 'H K N G', 'Jayawardhane', '1981-08-15', 'Male', 'jayawardhane@gmai.com', '0118524316', '0778241463', 'Manager', NULL, 70000, '122/1, Uswatta road', 'Aluthepola', 1, '2019-12-14 22:16:53', '2019-12-14 22:16:53', NULL),
(21, '198672116743', 'Makubura Dewage Nayani Hansika Makubura', 'M D N H', 'Makubura', '1986-06-25', 'Female', 'hansikamakubura27@gmail.com', NULL, '0784216584', 'Nurse', NULL, 65000, '79/B, Kawatayagoda road', 'Yatiyana', 1, '2019-12-14 22:24:23', '2019-12-14 22:24:23', NULL),
(22, '198830170981', 'Wickramasinghe Vidanage Yasitha Wickramasinghe', 'W V Y', 'Wickramasinghe', '1988-03-15', 'Male', 'yasithwickramasinghe@ymail.com', NULL, '0775213201', 'Businesman', NULL, 40000, '654/8, Temple road', 'Minuwangoda', 1, '2019-12-14 22:32:29', '2019-12-14 22:32:29', NULL),
(23, '197901273546', 'Madurasinghe Arachchige Sangeeth Chanaka Alapatha', 'M A S C', 'Alapatha', '1979-03-24', 'Male', 'sangeethcha@gmail.com', '0335624812', '714562184', 'Software Engineer', NULL, 75000, '465/C, Mahinda road', 'Gampaha', 1, '2019-12-15 08:27:49', '2019-12-15 08:27:49', NULL),
(24, '198512545392', 'Jayawardhana Welathanthrige Janith Priyankara Jayawardhane', 'J W J P', 'Jayawardhane', '1985-09-19', 'Male', 'priyankara53@gmail.com', '0115248631', '0774563281', 'Teacher', NULL, 60000, '45/4, Ekala road', 'Minuwangoda', 1, '2019-12-15 08:33:11', '2019-12-15 08:33:11', NULL),
(25, '198916932716', 'Mapalagama Mudalige Udesh Nilantha Mapalagama', 'M M U N', 'Mapalagama', '1989-04-14', 'Male', 'udeshmapalagama09@gmail.com', NULL, '0715413216', 'Manager', NULL, 65000, '213/7, Meda Mawatha', 'Minuwangoda', 1, '2019-12-15 08:38:02', '2019-12-15 08:38:02', NULL),
(26, '199026473168', 'Eldeniya Medagedara Heshan Nayanajith Munaweera', 'E M H N', 'Munaweera', '1990-08-16', 'Male', 'munaweera16@gmail.com', NULL, '0714569821', 'Driver', NULL, 35000, '34/A, Gammana road', 'Nilpanagoda', 1, '2019-12-15 08:43:10', '2019-12-15 08:43:10', NULL),
(27, '197831949135', 'Sandanayake Uyanarachchilage Nadun Chathuranga Sandanayake', 'S U N C', 'Sandanayake', '1978-07-23', 'Male', 'sandanayake@gmail.com', '0119631285', '0724561232', 'Doctor', NULL, 75000, '543/2, Mawatha Kubura road', 'Weediyawatta', 1, '2019-12-15 08:48:21', '2019-12-15 08:48:21', NULL),
(28, '198529643182', 'Kariyawasam Appuhamige Lakmal  Boteju', 'K A L', 'Boteju', '1985-05-06', 'Male', 'lakmalboteju@gmail.com', NULL, '0714531284', 'Teacher', NULL, 55000, '119/12, Sanhida Mawatha', 'Minuwangoda', 1, '2019-12-15 08:53:28', '2019-12-15 08:53:28', NULL),
(29, '199169712943', 'Senanayake Mhottige Ujani Wathsala Senanayake', 'S M U W', 'Senanayake', '1991-12-06', 'Female', 'ujaani06@gmail.com', NULL, '0774561237', 'Library Assistent', NULL, 25000, '134/22, Gonapola road', 'Gampaha', 1, '2019-12-15 08:58:05', '2019-12-15 08:58:05', NULL),
(30, '197904512398', 'Dewasundara Mudiyanselage Anushka Dewasundara', 'D M A', 'Dewasundara', '1979-12-03', 'Male', 'anushkadev@gmail.com', '0331596413', '0775461285', 'Architect', NULL, 50000, '235/1, Mandawala road', 'Gampaha', 1, '2019-12-15 09:43:05', '2019-12-15 09:43:05', NULL),
(31, '198512645813', 'Dasanayake Appuhamige Don Nilan Chamara Dasanayake', 'D A D N C', 'Dasanayake', '1985-05-30', 'Male', 'nilanchamara56@gmail.com', NULL, '0714592413', 'Teacher', NULL, 45000, '321/43, Aruggoda road', 'Yatiyana', 1, '2019-12-15 11:45:38', '2019-12-15 11:45:38', NULL),
(32, '198828416741', 'Udawalawwage Chamara Damith Ramanayake', 'U C D', 'Ramanayake', '1988-12-14', 'Male', 'Ramanayaka@gmail.com', NULL, '714821475', 'Driver', NULL, 30000, '23/1, Hirana road', 'Minuwangoda', 1, '2019-12-15 11:50:07', '2019-12-15 11:50:07', NULL),
(33, '197862149734', 'Abenayaka Arachchige Kasuni Sanjana Abenayaka', 'A A K S', 'Abenayaka', '1978-03-04', 'Female', 'Sanjana78@gmail.com', '0334581275', '0773482567', 'Teacher', NULL, 50000, '521/C, Ganga Bada road', 'Gampaha', 1, '2019-12-15 12:13:05', '2019-12-15 12:13:05', NULL),
(34, '198201436419', 'Hewawasam Kankanamge Pathum Lakmal Hewawasam', 'H K P L', 'Hewawasam', '1982-07-28', 'Male', 'hewawasam@gmail.com', '0114521784', '0784126428', 'Farmer', NULL, 35000, '632/7, Galpoththa road', 'Dewalapola', 1, '2019-12-15 12:27:43', '2019-12-15 12:27:43', NULL),
(35, '198316843128', 'Edirisinghe Mudiyanselage Yasiru Bandara Edirisinghe', 'E M Y B', 'Edirisinghe', '1983-09-01', 'Male', 'yasiruedirisinghe@gmail.com', NULL, '0712483472', 'Account Clerk', NULL, 30000, '49/6, Dharmarama road', 'Veyangoda', 1, '2019-12-15 12:33:00', '2019-12-15 12:33:00', NULL),
(36, '198710532175', 'Balasooriya Mohottige Asela Balasooriya', 'B M A', 'Balasooriya', '1987-06-13', 'Male', 'aselabalasooriya@gmail.com', '0114528764', '0771284312', 'Bank Manager', NULL, 70000, '876/3,Kudapokuna road', 'Wegowwa', 1, '2019-12-15 12:37:33', '2019-12-15 12:37:33', NULL),
(37, '199048532712', 'Dedunu Arachchige Vijini Lakmali Edirimuni', 'D A V L', 'Edirimuni', '1990-05-07', 'Female', 'vijinilakmali@gmail.com', NULL, '0758423149', 'Tailor', NULL, 25000, '34/B, Kothalawala Mawatha', 'Degonna', 1, '2019-12-15 12:41:58', '2019-12-15 12:41:58', NULL),
(38, '198625496374', 'Handugala Dewage Gayan Kanishka Siridewa', 'H D G K', 'Siridewa', '1986-11-25', 'Male', 'siridewagk@gmail.com', NULL, '0771230513', 'Businessman', NULL, 40000, '567/9, Cemetery road', 'Weediyawatta', 1, '2019-12-15 12:46:16', '2019-12-15 12:46:16', NULL),
(39, '197524351137', 'Kankanam Arachchige Lahiru Chamalka Kankanam', 'K A L C', 'Kankanam', '1975-02-15', 'Male', 'kankanam75@gmail.com', '0114568512', '0715247618', 'Accountant', NULL, 50000, '48/17, Mangala Mawatha', 'Minuwangoda', 1, '2019-12-15 12:51:23', '2019-12-15 12:51:23', NULL),
(40, '197512645983', 'Kodithuwakku Arachchige Namal Kodithuwakku', 'K A N', 'Kodithuwakku', '1975-02-25', 'Male', 'kodithuwakku45@gmail.com', '0115469213', '715462315', 'Software Engineer', NULL, 75000, '234/A, Meda Mawatha', 'Yatiyana', 1, '2019-12-15 14:53:33', '2019-12-15 14:53:33', NULL),
(41, '197230285241', 'Alankara Vidanage Wishwa Sampath Alankarage', 'A V W S', 'Alankarage', '1972-09-14', 'Male', 'wishwasampath@gmail.com', '118523445', '772025106', 'Accountant', NULL, 50000, '68/5, Ihala Yagoda road', 'Minuwangoda', 1, '2019-12-15 14:58:51', '2019-12-15 14:58:51', NULL),
(42, '198103645932', 'Herath Mudiyanselage Shehan Sankalpa Udagedara', 'H M S S', 'Udagedara', '1980-11-27', 'Male', 'shehansankalpa@gmail.com', '0335462135', '0724569813', 'Clerk', NULL, 25000, '456/19, Samagi Mawatha', 'Gampaha', 1, '2019-12-15 15:07:31', '2019-12-15 15:07:31', NULL),
(43, '198175246317', 'Yagoda Arachchige Nilani Chandima Perera', 'Y A N C', 'Perera', '1981-01-12', 'Female', 'Chandima12@gmail.com', NULL, '0774824946', 'Teacher', NULL, 55000, '56/16, Gammana road', 'Wegowwa', 1, '2019-12-15 16:06:44', '2019-12-15 16:06:44', NULL),
(44, '197616432461', 'Nagoda Liyanage Amith Yasantha Nagoda', 'N L A Y', 'Nagoda', '1976-03-17', 'Male', 'yasanthamith@gmail.com', NULL, '0778564913', 'Businessman', NULL, 35000, '23/C, Manniyara road', 'Dewelapola', 1, '2019-12-15 16:11:16', '2019-12-15 16:11:16', NULL),
(45, '198331185234', 'Hadunneththige Thiwanka Samaranayake', 'H T', 'Samaranayake', '1983-08-16', 'Male', 'thiwasamaranayake@gmail.com', '0115426748', '0754896421', 'Police Officer', NULL, 30000, '4432/2, Thotupala road', 'Minuwangoda', 1, '2019-12-15 16:16:06', '2019-12-15 16:16:06', NULL),
(46, '198111643185', 'Amarasinghe Dewage Sisil Maduranga Amarasinghe', 'A D S M', 'Amarasinghe', '1981-07-13', 'Male', 'sisilamarasinghe@ymail.com', '0114521876', '0714823719', 'Manager', NULL, 60000, '122/3, Gelanigama road', 'Yatiyana', 1, '2019-12-15 17:34:02', '2019-12-15 17:34:02', NULL),
(47, '199062345916', 'Udupila Liyanage Hansika Sewwandi Liyanage', 'U L H S', 'Liyanage', '1990-03-16', 'Female', 'sewwandiliyanage@gmail.com', NULL, '0775431255', 'Lab Assistant', NULL, 25000, '852/4, Kumbuka road', 'Weediyawatta', 1, '2019-12-15 17:38:14', '2019-12-15 17:38:14', NULL),
(48, '197620642398', 'Ranasinghe Pattikikoralage Nalin Sanjeewa Ranasinghe', 'R P N S', 'Ranasinghe', '1976-05-12', 'Male', 'nalinsanjeewa@gmail.com', NULL, '0714558663', 'Driver', NULL, 30000, '34/A, Moragahahena road', 'Minuwangoda', 1, '2019-12-15 17:42:38', '2019-12-15 17:42:38', NULL),
(49, '198969845213', 'Dasanayake Mohottige Inoka Sayuri Dasanayake', 'D M I S', 'Dasanayake', '1989-06-22', 'Female', 'syuri22@gmail.com', '0115421236', '0714593215', 'Teacher', NULL, 60000, '671/4B, Thalagala road', 'Aluthepola', 1, '2019-12-15 17:47:10', '2019-12-15 17:47:10', NULL),
(50, '196925846982', 'Rajapaksha Mudiyanselage Kanchana Prasad Rajapaksha', 'R M K P', 'Rajapaksha', '1969-05-19', 'Male', 'kanchanaprasad@gmail.com', '0115697215', '777526424', 'Lawyer', NULL, 55000, '257/19, 1st Lane, Yagoda road', 'Yatiyana', 1, '2019-12-15 19:59:13', '2019-12-15 19:59:13', NULL),
(51, '198010478521', 'Raigama Arachchige Chathura Raigamage', 'R A C', 'Raigamage', '1980-09-30', 'Male', 'chathuraigamage23@gmail.com', '115872149', '714569812', 'Teacher', NULL, 60000, '126/2, Welmilla road', 'Aluthepola', 1, '2019-12-15 20:03:35', '2019-12-15 20:03:35', NULL),
(52, '196812345987', 'Samarakkody Walawwage Ajith Maduranga Samarakkody', 'S W A M', 'Samarakkody', '1968-06-12', 'Male', 'ajith12@gmail.com', NULL, '785461287', 'Software Engineer', NULL, 75000, '52/C, Kumbuka road', 'Minuwangoda', 1, '2019-12-15 20:15:56', '2019-12-15 20:15:56', NULL),
(53, '197130145638', 'Siriwardhana Gamage Kanishka Sadaruwan Sriwardhana', 'S G K S', 'Sriwardhana', '1971-03-21', 'Male', 'sirwardana99@gmail.com', '0332584613', '774591348', 'Account clerk', NULL, 35000, '345/19, Moragahahena road', 'Gampaha', 1, '2019-12-15 20:21:11', '2019-12-15 20:21:11', NULL),
(54, '198213725498', 'Udawatta Appuhamilage Thanuja Rangana Udawatta', 'U A T R', 'Udawatta', '1982-12-02', 'Male', 'ranganaudawatta@gmail.com', '0115284617', '0714872254', 'Manager', NULL, 60000, '23/9, Welikala road', 'Wegowwa', 1, '2019-12-15 20:25:40', '2019-12-15 20:25:40', NULL),
(55, '198460742854', 'Amarasinghe Appuhamige Ajani Nimanthika Amarasinghe', 'A A A N', 'Amarasinghe', '1984-04-06', 'Female', 'ajani44@gmail.com', NULL, '715584442', 'Teacher', NULL, 50000, '876/5, Gurugoda road', 'Bulugahamulla', 1, '2019-12-15 20:30:14', '2019-12-15 20:30:14', NULL),
(56, '198910485246', 'Gunathilaka Vidanage Pasidu Methmal Siva', 'G V P M', 'Silva', '1989-07-27', 'Male', 'silvaneth21@gmail.com', NULL, '0774851123', 'Driver', NULL, 25000, '34/A, Nagahakotuwa road', 'Minuwangoda', 1, '2019-12-15 20:35:11', '2019-12-15 20:35:11', NULL),
(57, '198310845632', 'Jayarathna Mudiyanselage Heshan Nayanakanthal Jayarathna', 'J M H N', 'Jayarathna', '1983-10-08', 'Male', 'heshanayana@gmail.com', '0331586431', '0715558422', 'Tailor', NULL, 20000, '522/4, Temple road', 'Gampaha', 1, '2019-12-15 20:40:08', '2019-12-15 20:40:08', NULL),
(58, '198527548631', 'Gamlath Arachchige Harshana Gamlath', 'G A H', 'Gamlath', '1985-08-09', 'Male', 'harshanagamlath@gmail.com', NULL, '0778854126', 'Businessman', NULL, 60000, '267/11, Kothalawala Mawatha', 'Yatiyana', 1, '2019-12-15 20:44:16', '2019-12-15 20:44:16', NULL),
(59, '198745382164', 'Munweera Gamage Harshani Chathurika Munaweera', 'M G H C', 'Munaweera', '1987-07-08', 'Female', 'chathurikaweer@gmail.com', NULL, '0774851344', 'Accountant', NULL, 45000, '344/2C, Thalagahavila road', 'Aluthepola', 1, '2019-12-15 20:48:08', '2019-12-15 20:48:08', NULL),
(60, '196516847534', 'Ranasinghe Arachchige Kamal Arunoda Ranasinghe', 'R A K A', 'Ranasinghe', '1965-02-25', 'Male', 'kamalarun@gmail.com', NULL, '714589632', 'Dentist', NULL, 80000, '21/B, Aruggoda road', 'Minuwangoda', 1, '2019-12-18 20:03:02', '2019-12-18 20:03:02', NULL),
(61, '197105413842', 'Senanayake Muhandiramlage Nipuna Senanayake', 'S M N', 'Senanayake', '1971-08-11', 'Male', 'nipunasena@gmail.com', NULL, '774863219', 'Teacher', NULL, 25000, '431/5, Bandaragama road', 'Yatiyana', 1, '2019-12-18 20:08:00', '2019-12-18 20:08:00', NULL),
(62, '197571230890', 'Udawatta Arachchige Hashani Imalka Udawatta', 'U A H I', 'Udawatta', '1975-03-14', 'Female', 'hashanimalka@gmail.com', NULL, '774897212', 'Nurse', NULL, 65000, '122/12, Moronthuduwa road', 'Nilpanagoda', 1, '2019-12-18 20:15:31', '2019-12-18 20:15:31', NULL),
(63, '197918435768', 'Jayawardhana Weththasinghage Kavidu Sampath Jayawardhana', 'J W K S', 'Jayawardhana', '1979-09-22', 'Male', 'kavidujaye@gmail.com', NULL, '714853219', 'Businessman', NULL, 40000, '267/15, Samagi Mawatha', 'Minuwangoda', 1, '2019-12-18 20:41:44', '2019-12-18 20:41:44', NULL),
(64, '198029846327', 'Kalansooriya Arachchige Charitha Akalanka Kalansooriya', 'K A C A', 'Kalansooriya', '1980-11-02', 'Male', 'akalanka45@gmail.com', NULL, '774853260', 'Police Officer', NULL, 35000, '521/4C, Kothalawala road', 'Yatiyana', 1, '2019-12-18 20:47:33', '2019-12-18 20:47:33', NULL),
(65, '197920136429', 'Mapa Gallage Thusitha Boteju', 'M G T', 'Boteju', '1979-06-08', 'Male', 'boteju23@gmail.com', NULL, '0778543216', 'Accountant', NULL, 50000, '345/16, Gammana road', 'Minuwangoda', 1, '2019-12-19 21:07:31', '2019-12-19 21:07:31', NULL),
(66, '197519325096', 'Kulasekara Mudiyanselage Anushka Bandara Kulasekara', 'K M A B', 'Kulasekara', '1975-12-07', 'Male', 'anushkabandara@gmail.com', NULL, '0714853219', 'Clerk', NULL, 28000, '48/C, Mavilla road', 'Gampaha', 1, '2019-12-19 21:12:07', '2019-12-19 21:12:07', NULL),
(67, '198630284021', 'Hettiarachchi Gamage Shakya Hettiarachchi', 'H G S', 'Hettiarachchi', '1986-04-30', 'Female', 'shakya27@gmal.com', NULL, '714782563', 'Teacher', NULL, 45000, '78/5A, Puwakwatta road', 'Yatiyana', 1, '2019-12-19 21:17:25', '2019-12-19 21:17:25', NULL),
(68, '197113413458', 'Yapathi Mudiyanselage Yasitha Chamara Yapathi', 'Y M Y C', 'Yapathi', '1971-01-22', 'Male', 'yapathige71@gmail.com', NULL, '0774562175', 'Driver', NULL, 35000, '254/2, Yagodamulla road', 'Minuwangoda', 1, '2019-12-22 17:32:02', '2019-12-22 17:32:02', NULL),
(69, '197624185234', 'Dolawattage Dona Wasantha Nilupul Dolawatta', 'D D W N', 'Dolawatta', '1976-09-22', 'Male', 'wasantha@gmail.com', '0115243125', '0714851327', 'Businessman', NULL, 40000, '32/41, Galloluwa road', 'Nilpanagoda', 1, '2019-12-22 18:11:59', '2019-12-22 18:11:59', NULL),
(70, '197932487631', 'Naganandalage Ayanthi Nirmala Nagananda', 'N A N', 'Nagananda', '1979-11-10', 'Female', 'ayanthinir@gmail.com', '0118521137', '0774851694', 'Teacher', NULL, 50000, '214/4B, Katuwellegama', 'Udugampola', 1, '2019-12-22 18:18:07', '2019-12-22 18:18:07', NULL),
(71, '197241790127', 'Jagath Chamila Perera ', 'J C', 'Perera', '1978-03-24', 'Male', NULL, '0118542214', '0770123485', 'Clerk', NULL, 30000, '456/11, Dunagaha Nilpanagoda road', 'Yatiyana', 1, '2019-12-22 18:23:18', '2019-12-22 18:23:18', NULL),
(72, '197017485246', 'Satharasinghe Arachchige Monoj Jeewantha Pinipa', 'S A M J', 'Pinipa', '1970-08-11', 'Male', 'manojeewantha@gmail.com', NULL, '0774569812', 'Pollice Officer', NULL, 40000, '311/2, Nelligahaamula road', 'Weediyawatta', 1, '2019-12-22 18:30:11', '2019-12-22 18:30:11', NULL),
(73, '198632145937', 'Vijesinghage Akash Vijesinghe', 'V A', 'Vijesinghe', '1980-12-09', 'Male', 'akaash@gmail.com', NULL, '0774825463', 'Accountant', NULL, 52000, '21/13, Marapoala road', 'Wegowwa', 1, '2019-12-22 18:56:55', '2019-12-22 18:56:55', NULL),
(74, '198629517643', 'Hewa Fonsekage Chamara Damith Fonseka', 'H F C D', 'Fonseka', '1986-04-11', 'Male', 'chamarafonseka@gmail.com', '0118531244', '0714231852', 'Teacher', NULL, 55000, '123/4, Udugama road', 'Dewalapola', 1, '2019-12-22 19:01:29', '2019-12-22 19:01:29', NULL),
(75, '198330147532', 'Warnakulasooriyage Sameera Warnakulasooriya', 'W S', 'Warnakulasooriya', '1983-06-21', 'Male', 'sammwarna@gmail.com', NULL, '0778524132', 'Clerk', NULL, 25000, '963/3, Medagampitiya road', 'Yatiyana', 1, '2019-12-22 19:06:26', '2019-12-22 19:06:26', NULL),
(76, '197823075361', 'Devid Mudiyanselage Sampath Mevan Thennakoon', 'D M S M', 'Thennakoon', '1978-12-04', 'Male', 'thennakoon98@gmail.com', NULL, '0714562874', 'Businessman', NULL, 50000, '312/2, Temple road', 'Gampaha', 1, '2019-12-22 19:23:49', '2019-12-22 19:23:49', NULL),
(77, '197504287361', 'Amarasinghe Mudalige Kavinga Amarasinghe', 'A M K', 'Amarasinghe', '1975-12-25', 'Male', 'kavingaamarasinghe@gail.com', '0335421946', '0714563218', 'Photographer', NULL, 50000, '201/5, Udugama road', 'Gampaha', 1, '2019-12-22 20:26:12', '2019-12-22 20:26:12', NULL),
(78, '198015247512', 'Jayasundara Mudalige Methmal Srinath Jayasundara', 'J M M S', 'Jayasundara', '1980-03-19', 'Male', NULL, NULL, '0717531295', 'Security', NULL, 35000, '182/27, Kotugoda road', 'Minuwangoda', 1, '2019-12-22 20:30:11', '2019-12-22 20:30:11', NULL),
(79, '197520140012', 'Ranasinghe Arachchige Manoj Ranasinghe', 'R A M', 'Ranasinghe', '1978-07-14', 'Male', NULL, NULL, '0778523974', 'Technician', NULL, 25000, '22/5, Yagodamulla road', 'Nilpanagoda', 1, '2019-12-22 20:34:46', '2019-12-22 20:34:46', NULL),
(80, '197513342561', 'Senanayaka Mudalige Lahiru Jayantha Senanayaka', 'S M L J', 'Senanayaka', '1975-04-23', 'Male', NULL, '0114582135', '0778463012', 'Mechenic', NULL, 55000, '312/1, Nedagamuwa road', 'Minuwangoda', 1, '2019-12-22 21:01:06', '2019-12-22 21:01:06', NULL),
(81, '198027466532', 'Madusinghe Arachchige Charith Sulochana Madusinghe', 'M A C S', 'Madusinghe', '1980-06-14', 'Male', 'lahirujayantha@gmail.com', '0113324287', '0758431245', 'Accountant', NULL, 45000, '511/4C Vijaya Mawatha', 'Yatiyana', 1, '2019-12-22 21:07:50', '2019-12-22 21:07:50', NULL),
(82, '197713588265', 'Narangoda Mudalige Ajith Priyankara Narangoda', 'N M A P', 'Narangoda', '1977-04-13', 'Male', 'narangoda34@gmail.com', NULL, '0771238255', 'Businessman', NULL, 60000, '198/2 Dunagaha road', 'Veyangoda', 1, '2019-12-22 21:12:24', '2019-12-22 21:12:24', NULL),
(83, '196812396542', 'Wanniarachchilage Dilan Awantha Wanniarachchi', 'W D A', 'Wanniarachchi', '1968-08-12', 'Male', 'dila23@gmail.com', NULL, '0715204132', 'Law Clerk', NULL, 35000, '268/12,Seruwila road', 'Minuwangoda', 1, '2019-12-26 19:11:42', '2019-12-26 19:11:42', NULL),
(84, '196308543217', 'Baduraliya Sivage Damith Silva', 'B S D', 'Silva', '1963-11-22', 'Male', 'damithsilva@gmail.com', NULL, '0714582174', 'Manager', NULL, 50000, '133/B, Walawwatta road', 'Nilpanagoda', 1, '2019-12-26 19:16:41', '2019-12-26 19:16:41', NULL),
(85, '197130133247', 'Withana Arachchilage Kasun Akalanka Withanage', 'W A K A', 'Withanage', '1971-07-14', 'Male', 'kasunakalanka212@gmail.com', NULL, '0778523167', 'Accountat', NULL, 45000, '203/2, Hansagiri road', 'Gampaha', 1, '2019-12-26 19:21:51', '2019-12-26 19:21:51', NULL),
(86, '197561245638', 'Senanayake Arachchilage Mudushika Madumali Senanayake', 'S A M M', 'Senanayake', '1975-05-11', 'Female', 'madushikamadu@gmail.com', NULL, '0785236414', 'Teacher', NULL, 55000, '165/6, Samangi Mawatha', 'Wegowwa', 1, '2019-12-26 19:25:40', '2019-12-26 19:25:40', NULL),
(87, '197320782104', 'Chandrapala Mohottige Heshan Chandrapala', 'C M H', 'Chandrapala', '1973-04-16', 'Male', 'heshanchandra@gmail.com', NULL, '0775231041', 'Driver', NULL, 35000, '22/5, Kidagammulla road', 'Udugampoala', 1, '2019-12-26 19:41:32', '2019-12-26 19:41:32', NULL),
(88, '197021135208', 'Warnakula Arachchige Nadun Yapage Warnakula', 'W A N Y', 'Warnakula', '1970-06-12', 'Male', NULL, '0118521043', '0775231046', 'Farmer', NULL, 25000, '512/4, Temple road', 'Dunagaha', 1, '2019-12-26 19:46:58', '2019-12-26 19:46:58', NULL),
(89, '196903132142', 'Ranaweera Mohottige Madushanka Ranaweera', 'R M M', 'Ranaweera', '1969-09-18', 'Male', 'ranaweeramadu@gmail.com', NULL, '0714853167', 'Bank Teller', NULL, 50000, '578/6, Vishaka road', 'Korase', 1, '2019-12-26 19:51:06', '2019-12-26 19:51:06', NULL),
(90, '196414230215', 'Gunarathne Mudalige Janith Chathuranga Gunarathne', 'G M J C', 'Gunarathne', '1964-04-25', 'Male', NULL, '0115012364', '0753124785', 'Laborer', NULL, 30000, '155/12, Siyane road', 'Yatiyana', 1, '2019-12-26 19:55:08', '2019-12-26 19:55:08', NULL),
(91, '196870145266', 'Edirisinghe Dewage Inoka Ayanthi Edirisinghe', 'E D I A', 'Edirisinghe', '1968-02-14', 'Female', 'ayanthiedirisinghe@gmail.com', '0115201432', '0718523145', 'Lawyer', NULL, 65000, '302/5B, Gajaba Mawatha', 'Gampaha', 1, '2019-12-26 19:59:00', '2019-12-26 19:59:00', NULL),
(92, '197216685230', 'Wijesoorialage Chanaka Namal Wijesooriya', 'W C N', 'Wijesooriya', '1972-01-08', 'Male', 'wijesooriya45@gmail.com', NULL, '0778523460', 'Teacher', NULL, 50000, '411/8,Church road', 'Wegowwa', 1, '2019-12-26 20:02:26', '2019-12-26 20:02:26', NULL),
(93, '197625846321', 'Thennakoon Gamage Chamika Priyankara Thennakoon', 'T G C P', 'Thennakoon', '1968-04-30', 'Male', NULL, NULL, '0714586313', 'Technician', NULL, 40000, '246/17, Vijaya Mawatha', 'Nilpanagoda', 1, '2019-12-26 20:06:27', '2019-12-26 20:06:27', NULL),
(94, '197120687743', 'Nanayakkara Walawwage Isuru Nanayakkara', 'N W I', 'Nanayakkara', '1971-05-24', 'Male', 'isurunanayakkara@gmail.com', NULL, '0714598645', 'Accountat', NULL, 50000, '721/9, Pahalagama road', 'Gampaha', 1, '2019-12-26 20:10:11', '2019-12-26 20:10:11', NULL),
(95, '197129632265', 'Vijerathne Vidanage Kavinda Amarasiri Vijerathne', 'V V K A', 'Vijerathne', '1971-07-16', 'Male', NULL, '0115321452', '0712254633', 'Driver', NULL, 45000, '523/8, Katwellagama', 'Udugampola', 1, '2019-12-29 10:55:58', '2019-12-29 10:55:58', NULL),
(96, '196517432541', 'Chandrasiri Balasooriyalage Ajith Priyantha Chandrasiri', 'C B A P', 'Chandrasiri', '1965-03-11', 'Male', 'ajithpriyantha@gmail.com', NULL, '0772036531', 'Businessman', NULL, 55000, '128/51, Wijaya Mawatha', 'Minuwangoda', 1, '2019-12-29 10:59:58', '2019-12-29 10:59:58', NULL),
(97, '197020843284', 'Kahandawala Bandarage Sampath Rodrigo', 'K B S', 'Rodrigo', '1970-12-30', 'Male', NULL, NULL, '0778521385', 'Clerk', NULL, 35000, '20/8, Ambagahamulla road', 'Wegowwa', 1, '2019-12-29 11:03:06', '2019-12-29 11:03:06', NULL),
(98, '196928420397', 'Jayasekara Mudiyanselage Lahiru Jayasekara', 'J M L', 'Jayasekara', '1969-02-14', 'Male', NULL, NULL, '0714563285', 'Accountant', NULL, 50000, '185/4C, Cemetry road', 'Gampaha', 1, '2019-12-29 11:06:52', '2019-12-29 11:06:52', NULL),
(99, '196718530172', 'Weerathunga Arachchilage Sanjeewa Tharaka Weerathunga', 'W A S T', 'Weerathunga', '1967-06-18', 'Male', NULL, '0118564120', '0778534121', 'Driver', NULL, 24000, '542/13, Samarakkody road', 'Veyangoda', 1, '2019-12-29 11:10:35', '2019-12-29 11:10:35', NULL),
(100, '196410385210', 'Liyanarachchi Gamage Nuwan Mahesh Gamage', 'L G N M', 'Gamage', '1964-08-22', 'Male', 'sanjeewaweera@gamail.com', NULL, '0778520041', 'Manager', NULL, 65000, '234/5, Uyana road', 'Minuwangoda', 1, '2019-12-29 11:14:28', '2019-12-29 11:14:28', NULL),
(101, '196724185213', 'Abeysinghe Arachchige Chathura Abeysinghe', 'A A C', 'Abeysinghe', '1967-03-17', 'Male', 'chathuraabeysinghe@gmail.com', '0118520371', '0758531275', 'Accountant', NULL, 45000, '451/2,Uggagala road', 'Nilpanagoda', 1, '2019-12-29 11:22:29', '2019-12-29 11:22:29', NULL),
(102, '196824320145', 'Handugala Dewage Mahesh Perera', 'H D M', 'Perera', '1968-08-12', 'Male', NULL, '0118774646', '0774853377', 'Technician', NULL, 35000, '321/7, Malwatta road', 'Gampaha', 1, '2019-12-29 11:26:53', '2019-12-29 11:26:53', NULL),
(103, '197052175319', 'Samarakkodi Arachchilage Mallika Samarakkodi', 'S A M', 'Samarakkodi', '1970-04-28', 'Female', NULL, NULL, '0778563399', 'Teacher', NULL, 40000, '123/4, Orutota road', 'Gampaha', 1, '2019-12-29 11:30:45', '2019-12-29 11:30:45', NULL),
(104, '196413685201', 'Madurasinghe Arachchige Sangeeth Madurasinghe', 'M A S', 'Madurasinghe', '1964-07-30', 'Male', 'sangeeth67@gmail.com', NULL, '0718521430', 'Businessman', NULL, 60000, '465/C, Mahinda road', 'Gampaha', 1, '2019-12-29 11:34:11', '2019-12-29 11:34:11', NULL),
(105, '197542853026', 'Herath Mudiyanselage Upeksha Lakshmi Herath', 'H M U L', 'Herath', '1975-09-14', 'Female', NULL, '0118874661', '0718850014', 'Nurse', NULL, 48000, '341/3, Vijaya road', 'Nilpanagoda', 1, '2019-12-29 11:37:52', '2019-12-29 11:37:52', NULL),
(106, '196818697423', 'Hettiarachchi Gamage Damith Asanka Hettiarachchi', 'H G D A', 'Hettiarachchi', '1968-07-16', 'Male', NULL, NULL, '0718546254', 'Businessman', NULL, 30000, '268/12, Pahalagama road', 'Gampaha', 1, '2019-12-29 11:41:20', '2019-12-29 11:41:20', NULL),
(107, '196920475394', 'Narangoda Uyanarachchilage Kalhara Narangoda', 'N U K', 'Narangoda', '1969-08-30', 'Male', 'narangoda45@gmail.com', NULL, '774563385', 'Bank Teller', NULL, 50000, '165/6, Samangi Mawatha', 'Wegowwa', 1, '2019-12-29 11:44:57', '2019-12-29 11:44:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `id` int(2) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`id`, `name`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 'Western', '2019-02-11 00:00:00', '2019-02-11 00:00:00', NULL),
(2, 'Sabaragamuwa', '2019-02-11 00:00:00', '2019-02-11 00:00:00', NULL),
(3, 'North Western', '2019-02-11 00:00:00', '2019-02-11 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `relation_type`
--

CREATE TABLE `relation_type` (
  `id` int(2) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `relation_type`
--

INSERT INTO `relation_type` (`id`, `name`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 'Father', '2019-12-11 05:27:27', '2019-12-11 05:27:27', NULL),
(2, 'Mother', '2019-12-11 05:27:33', '2019-12-11 05:27:33', NULL),
(3, 'Guardian 1', '2019-12-11 05:27:42', '2019-12-11 05:27:42', NULL),
(4, 'Guardian 2', '2019-12-11 05:27:49', '2019-12-11 05:27:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `religion`
--

CREATE TABLE `religion` (
  `id` int(2) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `religion`
--

INSERT INTO `religion` (`id`, `name`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 'Buddhist', '2019-12-11 05:28:04', '2019-12-11 05:28:04', NULL),
(2, 'Christian', '2019-12-11 05:28:19', '2019-12-11 05:28:19', NULL),
(3, 'Hindu', '2019-12-11 05:28:30', '2019-12-11 05:28:30', NULL),
(4, 'Islam', '2019-12-11 05:28:47', '2019-12-11 05:28:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `generated_by` int(7) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sport`
--

CREATE TABLE `sport` (
  `id` int(3) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sport`
--

INSERT INTO `sport` (`id`, `name`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 'Cricket', '2020-01-09 18:28:22', '2020-01-09 18:28:22', NULL),
(2, 'Athletics', '2020-01-09 18:28:34', '2020-01-09 18:28:34', NULL),
(3, 'Football', '2020-01-09 18:28:47', '2020-01-09 18:28:47', NULL),
(4, 'Volleyball', '2020-01-09 18:29:22', '2020-01-09 18:29:22', NULL),
(5, 'Chess', '2020-01-09 18:30:02', '2020-01-09 18:30:02', NULL),
(6, 'Wrestling', '2020-01-09 18:30:13', '2020-01-09 18:30:13', NULL),
(7, 'Cadet', '2020-01-09 18:30:52', '2020-01-09 18:30:52', NULL),
(8, 'Swimming', '2020-01-09 18:33:02', '2020-01-09 18:33:02', NULL),
(9, 'Karate', '2020-01-09 18:33:10', '2020-01-09 18:33:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(6) NOT NULL,
  `employee_number` int(6) NOT NULL,
  `type_id` int(2) NOT NULL,
  `admission_date` date NOT NULL,
  `nic` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initials` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_home` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_mobile` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_id` int(2) DEFAULT NULL,
  `religion_id` int(2) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `employee_number`, `type_id`, `admission_date`, `nic`, `full_name`, `initials`, `surname`, `dob`, `gender`, `email`, `phone_home`, `phone_mobile`, `address`, `city`, `district_id`, `religion_id`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 1, 3, '2010-01-10', '196579114551', 'Handugala Dewage Pathmini Siridewa', 'H D P', 'Siridewa', '1965-08-22', 'Female', 'pathminisiridewa@gmail.com', '0332554562', '0774078087', '267/10, Nagahakotuwa road', 'Gampaha', 1, 1, '2020-01-04 19:59:25', '2020-01-04 19:59:25', NULL),
(2, 2, 2, '2010-04-22', '197245114553', 'Sooriyarachchi Mohottilage Sumedha Sooriyarachchi', 'S M S', 'Sooriyarachchi', '1972-02-14', 'Male', 'sumeda14@gmail.com', NULL, '0715469845', '126/2, Welmilla road', 'Aluthepola', 1, 1, '2020-01-04 20:10:18', '2020-01-04 20:10:18', NULL),
(3, 3, 1, '2011-02-12', '198962512434', 'Edirisnghe Dewage Isanka Sheyamini Edirisnghe', 'E D I S', 'Edirisnghe', '1989-01-13', 'Female', 'isankaedirisnghe@gmail.com', '0118524132', '0712587463', '68/12, Ihala Yagoda road', 'Minuwangoda', 1, 1, '2020-01-04 20:13:32', '2020-01-04 20:13:32', NULL),
(4, 4, 3, '2011-09-04', '197835421456', 'Gunasekara Arachchilage Sisil Priyankara Gunasekara', 'G A S P', ' Gunasekara', '1978-05-30', 'Male', 'sisilpriya@gmail.com', '0112584215', '0778541237', '254/5, Uyana road', 'Minuwangoda', 1, 1, '2020-01-04 20:17:08', '2020-01-04 20:17:08', NULL),
(5, 5, 1, '2011-09-04', '198252142121', 'Herath Mudiyanselage Menaka Jeewanthi Herath', 'H M M J', 'Herath', '1982-12-05', 'Female', 'jeewanthiherath@gmail.com', NULL, '0708524012', '522/4, Orutota road', 'Gampaha', 3, 1, '2020-01-04 20:20:12', '2020-01-04 20:20:12', NULL),
(6, 6, 1, '2011-09-05', '198559863638', 'Dasanayaka Arachchilage Nipuni Dasanayaka', 'D A N', 'Dasanayaka', '1985-06-22', 'Female', 'nipudasanayaka@gmail.com', '0118524137', '0718543218', '32/41, Galloluwa road', 'Nilpanagoda', 1, 1, '2020-01-04 20:23:24', '2020-01-04 20:23:24', NULL),
(7, 7, 1, '2012-05-12', '197823120356', 'Jayawardhana Weththasinghelage Ajith Pushpakumara Jayawardhana', 'J W A P', 'Jayawardhana', '1978-05-13', 'Male', 'ajipushpakumara@gmail.com', NULL, '0778563012', '523/2, Katwellagama', 'Udugampola', 1, 1, '2020-01-04 20:26:15', '2020-01-04 20:26:15', NULL),
(8, 8, 1, '2012-08-16', '198563214524', 'Ramanayaka Mudiyanselage Chathuri Nimanthika Ramanayaka', 'R M C N', 'Ramanayaka', '1985-06-11', 'Female', 'chathujaye@gmail.com', '0338531276', '0708534216', '201/3, Ambagahamulla road', 'Gampaha', 1, 1, '2020-01-04 20:29:59', '2020-01-04 20:29:59', NULL),
(9, 9, 1, '2012-11-20', '199065821341', 'Udagedara Mohottilage Chamini Lakmali Udagedara', 'U M C L', 'Udagedara', '1990-12-05', 'Female', 'lakmaludagedara@gmail.com', NULL, '0718524976', '578/6, Vishaka road', 'Korase', 1, 1, '2020-01-04 20:32:50', '2020-01-04 20:32:50', NULL),
(10, 10, 1, '2013-01-28', '198730285216', 'Siriwardhana Gamage Kanchana Siriwardhana', 'S G K', 'Siriwardhana', '1987-04-13', 'Male', 'kanchana13@gmail.com', '0112587964', '0778564132', '211/8, Medagampitiya road', 'Yatiyana', 1, 1, '2020-01-04 20:36:53', '2020-01-04 20:36:53', NULL),
(11, 11, 1, '2014-08-15', '197852213494', 'Raigama Arachchige Naduni Nisansala Raigamage', 'R A N N', 'Raigamage', '1978-03-18', 'Female', 'raigamage78@gmail.com', '0118967542', '0785204100', '308/2B, Aruggoda road', 'Minuwangoda', 1, 1, '2020-01-04 20:40:38', '2020-01-04 20:40:38', NULL),
(12, 12, 1, '2014-11-03', '198213285436', 'Hewa Fonsekalage Gihan Dhananjaya Fonseka', 'H F G D', 'Fonseka', '1982-05-07', 'Male', 'gihanfonseka@gmail.com', NULL, '0778560032', '22/5, Kidagammulla road', 'Udugampola', 1, 2, '2020-01-04 20:43:56', '2020-01-04 20:43:56', NULL),
(13, 13, 1, '2015-08-11', '199049832015', 'Udupila Liyanage Sachini Nisansala Liyanage', 'U L S N', 'Liyanage', '1990-08-30', 'Female', 'nisansalaliyanage@gmail.com', '0114238675', '0718524012', '32/41, Galloluwa road', 'Nilpanagoda', 1, 1, '2020-01-04 20:48:10', '2020-01-04 20:48:10', NULL),
(14, 14, 4, '2016-02-16', '198643516723', 'Narangoda Arachchige Dhammika Narangoda', 'N A D', 'Narangoda', '1986-06-15', 'Female', 'narangoda90@gmail.com', '', '0778520133', '182/27, Kotugoda road', 'Minuwangoda', 1, 1, '2020-01-04 20:51:38', '2020-01-08 04:47:15', NULL),
(15, 15, 5, '2016-08-13', '198926341566', 'Withana Arachcilage Kanishka Sampath Withanage', 'W A K S', 'Withanage', '1989-01-24', 'Male', 'sampathwithanage@gmail.com', '339856314', '0712058630', '128/5, Temple road', 'Gampaha', 1, 1, '2020-01-04 20:55:39', '2020-01-04 20:55:39', NULL),
(16, 16, 6, '2014-05-12', '198632497641', 'Madusinghe Arachchige Thanuja Lakmali Madusinghe', 'M A T L', 'Madusinghe', '1986-06-13', 'Female', 'thanujalakali@gmail.com', NULL, '0774569863', '155/5, Siyane road', 'Yatiyana', 1, 1, '2020-01-04 21:12:27', '2020-01-04 21:12:27', NULL),
(17, 17, 8, '2015-12-03', '198723184221', 'Ranasighe Arachchige Sampath Ranasinghe', 'R A S', 'Ranasinghe', '1987-04-17', 'Male', NULL, NULL, '0704569631', '963/12, Gurugoda road', 'Balummahara', 1, 1, '2020-01-04 21:14:36', '2020-01-04 21:14:36', NULL),
(18, 18, 7, '2016-04-05', '198210865234', 'Yawadana Dewage Nihal Samarasighe', 'Y D N', 'Samarasighe', '1982-02-20', 'Male', NULL, NULL, '0758521305', '119/6, Sanhida Mawatha', 'Minuwangoda', 1, 1, '2020-01-04 21:17:15', '2020-01-04 21:17:15', NULL),
(19, 19, 10, '2019-05-30', '199536514082', 'Samarakkody Arachchige Lakmal Samarakkody', 'S A L', 'Samarakkody', '1995-12-30', 'Male', 'lakmalsamarakkody@gmail.com', '', '0774924351', '144/5A, 3rd Lane, Palmgrove estate', 'Veyangoda', 1, 1, '2020-01-09 05:29:38', '2020-01-10 20:39:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff_attendance`
--

CREATE TABLE `staff_attendance` (
  `id` bigint(20) NOT NULL,
  `staff_id` int(6) NOT NULL,
  `date` date NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_attendance`
--

INSERT INTO `staff_attendance` (`id`, `staff_id`, `date`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 1, '2020-01-02', '2020-01-05 05:47:56', '2020-01-05 05:47:56', NULL),
(2, 2, '2020-01-02', '2020-01-05 05:47:57', '2020-01-05 05:47:57', NULL),
(3, 3, '2020-01-02', '2020-01-05 05:47:57', '2020-01-05 05:47:57', NULL),
(4, 5, '2020-01-02', '2020-01-05 05:47:59', '2020-01-05 05:47:59', NULL),
(5, 4, '2020-01-02', '2020-01-05 05:47:59', '2020-01-05 05:47:59', NULL),
(6, 6, '2020-01-02', '2020-01-05 05:47:59', '2020-01-05 05:47:59', NULL),
(7, 7, '2020-01-02', '2020-01-05 05:48:00', '2020-01-05 05:48:00', NULL),
(8, 8, '2020-01-02', '2020-01-05 05:48:00', '2020-01-05 05:48:00', NULL),
(9, 9, '2020-01-02', '2020-01-05 05:48:01', '2020-01-05 05:48:01', NULL),
(10, 10, '2020-01-02', '2020-01-05 05:48:01', '2020-01-05 05:48:01', NULL),
(11, 11, '2020-01-02', '2020-01-05 05:48:02', '2020-01-05 05:48:02', NULL),
(12, 12, '2020-01-02', '2020-01-05 05:48:02', '2020-01-05 05:48:02', NULL),
(13, 13, '2020-01-02', '2020-01-05 05:48:03', '2020-01-05 05:48:03', NULL),
(14, 14, '2020-01-02', '2020-01-05 05:48:04', '2020-01-05 05:48:04', NULL),
(15, 15, '2020-01-02', '2020-01-05 05:48:04', '2020-01-05 05:48:04', NULL),
(16, 16, '2020-01-02', '2020-01-05 05:48:04', '2020-01-05 05:48:04', NULL),
(17, 17, '2020-01-02', '2020-01-05 05:48:05', '2020-01-05 05:48:05', NULL),
(18, 18, '2020-01-02', '2020-01-05 05:48:05', '2020-01-05 05:48:05', NULL),
(19, 1, '2020-01-03', '2020-01-05 05:48:12', '2020-01-05 05:48:12', NULL),
(20, 3, '2020-01-03', '2020-01-05 05:48:12', '2020-01-05 05:48:12', NULL),
(21, 4, '2020-01-03', '2020-01-05 05:48:13', '2020-01-05 05:48:13', NULL),
(22, 5, '2020-01-03', '2020-01-05 05:48:13', '2020-01-05 05:48:13', NULL),
(23, 6, '2020-01-03', '2020-01-05 05:48:14', '2020-01-05 05:48:14', NULL),
(24, 7, '2020-01-03', '2020-01-05 05:48:15', '2020-01-05 05:48:15', NULL),
(25, 9, '2020-01-03', '2020-01-05 05:48:15', '2020-01-05 05:48:15', NULL),
(26, 10, '2020-01-03', '2020-01-05 05:48:16', '2020-01-05 05:48:16', NULL),
(27, 11, '2020-01-03', '2020-01-05 05:48:17', '2020-01-05 05:48:17', NULL),
(28, 12, '2020-01-03', '2020-01-05 05:48:17', '2020-01-05 05:48:17', NULL),
(29, 13, '2020-01-03', '2020-01-05 05:48:17', '2020-01-05 05:48:17', NULL),
(30, 14, '2020-01-03', '2020-01-05 05:48:18', '2020-01-05 05:48:18', NULL),
(31, 16, '2020-01-03', '2020-01-05 05:48:19', '2020-01-05 05:48:19', NULL),
(32, 17, '2020-01-03', '2020-01-05 05:48:19', '2020-01-05 05:48:19', NULL),
(33, 18, '2020-01-03', '2020-01-05 05:48:20', '2020-01-05 05:48:20', NULL),
(34, 14, '2020-01-08', '2020-01-08 20:34:37', '2020-01-08 20:34:37', NULL),
(36, 1, '2020-01-06', '2020-01-10 19:10:09', '2020-01-10 19:10:09', NULL),
(37, 2, '2020-01-06', '2020-01-10 19:10:11', '2020-01-10 19:10:11', NULL),
(38, 3, '2020-01-06', '2020-01-10 19:10:12', '2020-01-10 19:10:12', NULL),
(39, 4, '2020-01-06', '2020-01-10 19:10:13', '2020-01-10 19:10:13', NULL),
(40, 5, '2020-01-06', '2020-01-10 19:10:16', '2020-01-10 19:10:16', NULL),
(41, 6, '2020-01-06', '2020-01-10 19:10:24', '2020-01-10 19:10:24', NULL),
(42, 7, '2020-01-06', '2020-01-10 19:10:25', '2020-01-10 19:10:25', NULL),
(43, 9, '2020-01-06', '2020-01-10 19:10:27', '2020-01-10 19:10:27', NULL),
(44, 10, '2020-01-06', '2020-01-10 19:10:28', '2020-01-10 19:10:28', NULL),
(45, 11, '2020-01-06', '2020-01-10 19:10:29', '2020-01-10 19:10:29', NULL),
(46, 12, '2020-01-06', '2020-01-10 19:10:30', '2020-01-10 19:10:30', NULL),
(47, 13, '2020-01-06', '2020-01-10 19:10:32', '2020-01-10 19:10:32', NULL),
(48, 14, '2020-01-06', '2020-01-10 19:10:34', '2020-01-10 19:10:34', NULL),
(49, 1, '2020-01-07', '2020-01-10 19:10:53', '2020-01-10 19:10:53', NULL),
(50, 3, '2020-01-07', '2020-01-10 19:10:54', '2020-01-10 19:10:54', NULL),
(51, 4, '2020-01-07', '2020-01-10 19:10:55', '2020-01-10 19:10:55', NULL),
(52, 5, '2020-01-07', '2020-01-10 19:10:56', '2020-01-10 19:10:56', NULL),
(53, 6, '2020-01-07', '2020-01-10 19:11:00', '2020-01-10 19:11:00', NULL),
(54, 7, '2020-01-07', '2020-01-10 19:11:02', '2020-01-10 19:11:02', NULL),
(55, 8, '2020-01-07', '2020-01-10 19:11:03', '2020-01-10 19:11:03', NULL),
(56, 9, '2020-01-07', '2020-01-10 19:11:03', '2020-01-10 19:11:03', NULL),
(57, 10, '2020-01-07', '2020-01-10 19:11:05', '2020-01-10 19:11:05', NULL),
(58, 11, '2020-01-07', '2020-01-10 19:11:05', '2020-01-10 19:11:05', NULL),
(59, 12, '2020-01-07', '2020-01-10 19:11:07', '2020-01-10 19:11:07', NULL),
(60, 13, '2020-01-07', '2020-01-10 19:11:08', '2020-01-10 19:11:08', NULL),
(61, 15, '2020-01-07', '2020-01-10 19:11:09', '2020-01-10 19:11:09', NULL),
(62, 17, '2020-01-07', '2020-01-10 19:11:15', '2020-01-10 19:11:15', NULL),
(63, 18, '2020-01-07', '2020-01-10 19:11:16', '2020-01-10 19:11:16', NULL),
(64, 19, '2020-01-07', '2020-01-10 19:11:17', '2020-01-10 19:11:17', NULL),
(65, 1, '2020-01-08', '2020-01-10 19:11:34', '2020-01-10 19:11:34', NULL),
(66, 2, '2020-01-08', '2020-01-10 19:11:37', '2020-01-10 19:11:37', NULL),
(67, 3, '2020-01-08', '2020-01-10 19:11:38', '2020-01-10 19:11:38', NULL),
(68, 4, '2020-01-08', '2020-01-10 19:11:40', '2020-01-10 19:11:40', NULL),
(69, 5, '2020-01-08', '2020-01-10 19:11:41', '2020-01-10 19:11:41', NULL),
(70, 6, '2020-01-08', '2020-01-10 19:11:45', '2020-01-10 19:11:45', NULL),
(71, 7, '2020-01-08', '2020-01-10 19:11:46', '2020-01-10 19:11:46', NULL),
(72, 8, '2020-01-08', '2020-01-10 19:11:47', '2020-01-10 19:11:47', NULL),
(73, 9, '2020-01-08', '2020-01-10 19:11:49', '2020-01-10 19:11:49', NULL),
(74, 10, '2020-01-08', '2020-01-10 19:11:50', '2020-01-10 19:11:50', NULL),
(75, 12, '2020-01-08', '2020-01-10 19:11:52', '2020-01-10 19:11:52', NULL),
(76, 13, '2020-01-08', '2020-01-10 19:11:54', '2020-01-10 19:11:54', NULL),
(77, 15, '2020-01-08', '2020-01-10 19:11:55', '2020-01-10 19:11:55', NULL),
(78, 16, '2020-01-08', '2020-01-10 19:11:57', '2020-01-10 19:11:57', NULL),
(79, 17, '2020-01-08', '2020-01-10 19:11:58', '2020-01-10 19:11:58', NULL),
(80, 18, '2020-01-08', '2020-01-10 19:11:59', '2020-01-10 19:11:59', NULL),
(81, 19, '2020-01-08', '2020-01-10 19:12:00', '2020-01-10 19:12:00', NULL),
(82, 1, '2020-01-09', '2020-01-10 19:12:18', '2020-01-10 19:12:18', NULL),
(83, 2, '2020-01-09', '2020-01-10 19:12:20', '2020-01-10 19:12:20', NULL),
(84, 3, '2020-01-09', '2020-01-10 19:12:21', '2020-01-10 19:12:21', NULL),
(85, 4, '2020-01-09', '2020-01-10 19:12:23', '2020-01-10 19:12:23', NULL),
(86, 6, '2020-01-09', '2020-01-10 19:12:27', '2020-01-10 19:12:27', NULL),
(87, 7, '2020-01-09', '2020-01-10 19:12:28', '2020-01-10 19:12:28', NULL),
(88, 8, '2020-01-09', '2020-01-10 19:12:29', '2020-01-10 19:12:29', NULL),
(89, 9, '2020-01-09', '2020-01-10 19:12:30', '2020-01-10 19:12:30', NULL),
(90, 10, '2020-01-09', '2020-01-10 19:12:31', '2020-01-10 19:12:31', NULL),
(91, 11, '2020-01-09', '2020-01-10 19:12:32', '2020-01-10 19:12:32', NULL),
(92, 13, '2020-01-09', '2020-01-10 19:12:33', '2020-01-10 19:12:33', NULL),
(93, 14, '2020-01-09', '2020-01-10 19:12:35', '2020-01-10 19:12:35', NULL),
(94, 15, '2020-01-09', '2020-01-10 19:12:36', '2020-01-10 19:12:36', NULL),
(95, 16, '2020-01-09', '2020-01-10 19:12:41', '2020-01-10 19:12:41', NULL),
(96, 17, '2020-01-09', '2020-01-10 19:12:42', '2020-01-10 19:12:42', NULL),
(98, 18, '2020-01-09', '2020-01-10 19:12:44', '2020-01-10 19:12:44', NULL),
(99, 19, '2020-01-09', '2020-01-10 19:12:45', '2020-01-10 19:12:45', NULL),
(100, 17, '2020-01-06', '2020-01-10 19:13:07', '2020-01-10 19:13:07', NULL),
(101, 18, '2020-01-06', '2020-01-10 19:13:08', '2020-01-10 19:13:08', NULL),
(102, 19, '2020-01-06', '2020-01-10 19:13:09', '2020-01-10 19:13:09', NULL),
(103, 16, '2020-01-06', '2020-01-10 19:13:11', '2020-01-10 19:13:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff_category`
--

CREATE TABLE `staff_category` (
  `id` int(2) NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_category`
--

INSERT INTO `staff_category` (`id`, `name`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 'Academic', '2019-12-29 21:53:15', '2019-12-29 21:53:15', NULL),
(2, 'Non-Academic', '2019-12-29 21:53:29', '2019-12-29 21:53:29', NULL),
(3, 'Minor', '2019-12-29 21:53:45', '2019-12-29 21:53:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff_has_subject`
--

CREATE TABLE `staff_has_subject` (
  `id` int(4) NOT NULL,
  `staff_id` int(6) NOT NULL,
  `subject_id` int(3) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_has_subject`
--

INSERT INTO `staff_has_subject` (`id`, `staff_id`, `subject_id`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 6, 1, '2020-01-10 22:33:36', '2020-01-10 22:33:36', NULL),
(2, 13, 5, '2020-01-10 23:12:01', '2020-01-10 23:12:01', NULL),
(3, 7, 8, '2020-01-10 23:12:34', '2020-01-10 23:12:34', NULL),
(4, 12, 3, '2020-01-10 23:13:10', '2020-01-10 23:13:10', NULL),
(5, 1, 2, '2020-01-10 23:13:40', '2020-01-10 23:13:40', NULL),
(6, 14, 4, '2020-01-10 23:14:04', '2020-01-10 23:14:04', NULL),
(7, 17, 6, '2020-01-10 23:14:32', '2020-01-10 23:14:32', NULL),
(8, 5, 7, '2020-01-10 23:18:28', '2020-01-10 23:18:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff_type`
--

CREATE TABLE `staff_type` (
  `id` int(2) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(2) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_type`
--

INSERT INTO `staff_type` (`id`, `name`, `category_id`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 'Teacher', 1, '2019-12-29 21:54:39', '2020-01-04 19:31:38', NULL),
(2, 'Principal', 1, '2020-01-04 19:32:54', '2020-01-04 19:32:54', NULL),
(3, 'Vice Principal', 1, '2020-01-04 19:33:33', '2020-01-04 19:33:33', NULL),
(4, 'Office', 2, '2020-01-04 19:34:42', '2020-01-04 19:34:42', NULL),
(5, 'Librarian', 2, '2020-01-04 19:34:58', '2020-01-04 19:34:58', NULL),
(6, 'Lab Assistant', 2, '2020-01-04 19:35:30', '2020-01-04 19:35:30', NULL),
(7, 'Cleaner', 3, '2020-01-04 19:35:59', '2020-01-04 19:35:59', NULL),
(8, 'Driver', 3, '2020-01-04 19:36:08', '2020-01-04 19:36:08', NULL),
(9, 'Security Officer', 3, '2020-01-04 19:37:10', '2020-01-04 19:37:10', NULL),
(10, 'System Administrator', 2, '2020-01-08 18:21:32', '2020-01-08 18:21:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(6) NOT NULL,
  `admission_no` int(6) NOT NULL,
  `admission_date` date NOT NULL,
  `class_id` int(3) NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initials` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_mobile` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_place` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district_id` int(2) DEFAULT NULL,
  `religion_id` int(2) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `admission_no`, `admission_date`, `class_id`, `full_name`, `initials`, `surname`, `dob`, `gender`, `email`, `phone_mobile`, `address`, `city`, `birth_place`, `district_id`, `religion_id`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 1, '2019-01-07', 1, 'Ruwanpathirana Arachchige Abhishma Ruwanpathirana', 'R A A', 'Ruwanpathirana', '2013-12-02', 'female', '', '0778978541', '267/10, Nagahakotuwa road', 'Gampaha', NULL, 1, 1, '2019-12-14 14:15:29', '2020-01-10 23:19:33', NULL),
(2, 2, '2019-01-07', 1, 'Edirisinghe Dewage Boditha Dimuthu Edirisinghe', 'E D B D', 'Edirisinghe', '2013-05-08', 'male', NULL, NULL, '144/5A, Palmgrove estate', 'Veyangoda', 'Ragama', 1, 1, '2019-12-14 15:54:45', '2019-12-14 15:54:45', NULL),
(3, 3, '2019-01-07', 1, 'Herath Mudiyanselage Senuth Dimsara Herath', 'H M S D', 'Herath', '2014-12-01', 'male', NULL, NULL, '234/2, malwaththa road', 'Gampaha', 'Gampaha', 1, 1, '2019-12-14 16:01:15', '2019-12-14 16:01:15', NULL),
(4, 4, '2019-01-07', 1, 'Hettiarachchi Gamage Lithuli Senulya Kulathunga', 'H G L S', 'Kulathunga', '2013-02-25', 'female', NULL, NULL, '12/2B, Poruthota road', 'Minuwangoda', 'Colombo', 1, 2, '2019-12-14 16:08:06', '2019-12-14 16:08:06', NULL),
(5, 5, '2019-01-07', 1, 'Hettiarachchi Gamage Methuli Dulanya Kulathunga', 'H G M D', 'Kulathunga', '2013-02-25', 'female', NULL, NULL, '12/2B, Poruthota road', 'Minuwangoda', 'Colombo', 1, 2, '2019-12-14 16:18:38', '2019-12-14 16:18:38', NULL),
(6, 6, '2019-01-07', 1, 'Amarasinghe Mudalige Osadi Dahamsa Amarasinghe', 'A M O D', 'Amarasinghe', '2013-10-17', 'female', NULL, NULL, '321/A, Cemetry road', 'Yatiyana', 'Gampaha', 1, 1, '2019-12-14 16:25:04', '2019-12-14 16:25:04', NULL),
(7, 7, '2019-01-07', 1, 'Colomage Don Nethum Wisal Weerasinghe', 'C D N W', 'Weerasinghe', '2013-04-15', 'male', NULL, NULL, '123/5, Silva Mawatha', 'Dewalapola', 'Ragama', 1, 1, '2019-12-14 16:32:37', '2019-12-14 16:32:37', NULL),
(8, 8, '2019-01-08', 1, 'Rupasinghe Jayawardhana Mudiyanselage Kavith Rupasinghe', 'R J M K', 'Rupasinghe', '2013-07-28', 'male', NULL, NULL, '45/2, Ekala road', 'Minuwangoda', 'Colombo', 1, 1, '2019-12-14 16:39:32', '2019-12-14 16:39:32', NULL),
(9, 9, '2019-01-08', 1, 'Handunneththige Shamindi Gayathma Kulasekara', 'H S G', 'Kulasekara', '2013-06-25', 'female', NULL, NULL, '675/8, Pansala Road', 'Udugampola', 'Wathupitiwala', 1, 1, '2019-12-14 16:45:57', '2019-12-14 16:45:57', NULL),
(10, 10, '2019-01-08', 1, 'Ranasinghe Bandaralage Sanura Haseth Ranasinghe', 'R B S H', 'Ranasinghe', '2013-03-14', 'male', NULL, NULL, '314/6, Oruthota Road', 'Gampaha', 'Gampaha', 1, 2, '2019-12-14 16:55:02', '2019-12-14 16:55:02', NULL),
(11, 11, '2019-01-08', 1, 'Udupila Liyanage Umeth Bimsada Liyanage', 'U L U B', 'Liyanage', '2014-01-26', 'male', NULL, NULL, '187/2, 2nd lane', 'Bulugahamulla', 'Colombo', 1, 1, '2019-12-14 17:02:24', '2019-12-14 17:02:24', NULL),
(12, 12, '2019-01-08', 1, 'Jayawardhana Arachchige Isula Menthusa Jayawardhana', 'J A I M', 'Jayawardhana', '2013-12-26', 'male', NULL, NULL, '233/6B, Kalawana Road', 'Dewalapola', 'Colombo', 1, 1, '2019-12-14 17:08:08', '2019-12-14 17:08:08', NULL),
(13, 13, '2019-01-09', 1, 'Kariyawasam Mudiyanselage Minudhi Siyansa Kariyawasam', 'K M M S', 'Kariyawasam', '2013-06-28', 'female', NULL, NULL, '541/10, Senanayake Road', 'Udugampola', 'Ragama', 1, 1, '2019-12-14 17:15:17', '2019-12-14 17:15:17', NULL),
(14, 14, '2019-01-09', 1, 'Denagamage Oneth Bhanuja Ekanayake', 'D O B', 'Ekanayake', '2013-04-07', 'male', NULL, NULL, '65/3, Bandarawatta road', 'Minuwangoda', 'Gampaha', 1, 1, '2019-12-14 17:21:38', '2019-12-14 17:21:38', NULL),
(15, 15, '2019-01-11', 1, 'Narangoda Liyanarachchige Denuka Mandil Perera', 'N L D M', 'Perera', '2013-05-20', 'male', NULL, NULL, '41/C, Hena road', 'Yatiyana', 'Minuwangoda', 1, 1, '2019-12-14 17:28:10', '2019-12-14 17:28:10', NULL),
(16, 16, '2019-01-07', 2, 'Thennakoon Mohottige Menula Gavesh Thennakoon', 'T M M G', 'Thennakoon', '2013-06-16', 'male', NULL, NULL, '234/5, Samagi Mawatha', 'Udugampola', 'Minuwangoda', 1, 1, '2019-12-14 21:49:11', '2019-12-14 21:49:11', NULL),
(17, 17, '2019-01-07', 2, 'Rupasundara Gamage Thevijan Dulmin Gamage', 'R G T D', 'Gamage', '2013-09-23', 'male', NULL, NULL, '12/A, Kottegoda road', 'Yatiyana', 'Colombo', 1, 1, '2019-12-14 21:54:13', '2019-12-14 21:54:13', NULL),
(18, 18, '2019-01-07', 2, 'Vithana Arachchilage Oleema Yuwanthi Vithanage', 'V A O Y', 'Vithanage', '2013-02-24', 'female', NULL, NULL, '987/2, Masvila road', 'Wegowwa', 'Colombo', 1, 2, '2019-12-14 21:59:41', '2019-12-14 21:59:41', NULL),
(19, 19, '2019-01-07', 2, 'Navinna Mudiyanselage Binidi Dulanya Navinna', 'N M B D', 'Navinna', '2013-12-31', 'female', NULL, NULL, '56/4C, Aluthgama road', 'Nilpanagoda', 'Ragama', 1, 1, '2019-12-14 22:04:43', '2019-12-14 22:04:43', NULL),
(20, 20, '2019-01-07', 2, 'Neththasinghe Dewage Sanuth Methsara Neththasinghe', 'N D S M', 'Neththasinghe', '2013-03-13', 'male', NULL, NULL, '511/6, Bamunumulla road', 'Weediyawatta', 'Minuwangoda', 1, 1, '2019-12-14 22:10:28', '2019-12-14 22:10:28', NULL),
(21, 21, '2019-01-07', 2, 'Hewa Kariyawasamlage Sasithi Thisakya Jayawardhane', 'H K S T', 'Jayawardhane', '2014-01-29', 'female', NULL, NULL, '122/1, Uswatta road', 'Aluthepola', 'Gampaha', 1, 1, '2019-12-14 22:16:53', '2019-12-14 22:16:53', NULL),
(22, 22, '2019-01-08', 2, 'Ranasinghe Koralage Imeth Sanumitha Ranasinghe', 'R K I S', 'Ranasinghe', '2013-09-02', 'male', NULL, NULL, '79/B, Kawatayagoda road', 'Yatiyana', 'Gampaha', 1, 1, '2019-12-14 22:24:23', '2019-12-14 22:24:23', NULL),
(23, 23, '2019-01-08', 2, 'Wickramasinghe Vidanage Lithika Thehan Wickramasinghe', 'W V L T', 'Wickramasinghe', '2013-04-22', 'male', NULL, NULL, '654/8, Temple road', 'Minuwangoda', 'Colombo', 1, 2, '2019-12-14 22:32:29', '2019-12-14 22:32:29', NULL),
(24, 24, '2019-01-08', 2, 'Madurasinghe Arachchige Shanuli Devindi Alapatha', 'M A S D', 'Alapatha', '2013-11-19', 'female', NULL, NULL, '465/C, Mahinda road', 'Gampaha', 'Colombo', 1, 1, '2019-12-15 08:27:49', '2019-12-15 08:27:49', NULL),
(25, 25, '2019-01-08', 2, 'Jayawardhana Welathanthrige Sehes Damvidu Jayawardhane', 'J W S D', 'Jayawardhane', '2013-05-20', 'male', NULL, NULL, '45/4, Ekala road', 'Minuwangoda', 'Minuwangoda', 1, 1, '2019-12-15 08:33:11', '2019-12-15 08:33:11', NULL),
(26, 26, '2019-01-08', 2, 'Mapalagama Mudalige Sanuli Tharika Mapalagama', 'M M S T', 'Mapalagama', '2013-02-17', 'female', NULL, NULL, '213/7, Meda Mawatha', 'Minuwangoda', 'Gampaha', 1, 1, '2019-12-15 08:38:02', '2019-12-15 08:38:02', NULL),
(27, 27, '2019-01-08', 2, 'Eldeniya Medagedara Therini Vihansa Munaweera', 'E M T V', 'Munaweera', '2013-10-10', 'female', NULL, NULL, '34/A, Gammana road', 'Nilpanagoda', 'Ragama', 1, 1, '2019-12-15 08:43:10', '2019-12-15 08:43:10', NULL),
(28, 28, '2019-01-09', 2, 'Sandanayake Uyanarachchilage Olitha Sandanayake', 'S U O', 'Sandanayake', '2013-06-12', 'male', NULL, NULL, '543/2, Mawatha Kubura road', 'Weediyawatta', 'Gampaha', 1, 1, '2019-12-15 08:48:21', '2019-12-15 08:48:21', NULL),
(29, 29, '2019-01-09', 2, 'Sandanayake Uyanarachchilage Dilitha Sandanayake', 'S U D', 'Sandanayake', '2013-06-12', 'male', NULL, NULL, '543/2, Mawatha Kubura road', 'Weediyawatta', 'Gampaha', 1, 1, '2019-12-15 08:48:23', '2019-12-15 08:48:23', NULL),
(30, 30, '2019-11-10', 2, 'Kariyawasam Appuhamige Venuja Vonal Boteju', 'K A V V', 'Boteju', '2013-07-24', 'male', NULL, NULL, '119/12, Sanhida Mawatha', 'Minuwangoda', 'Colombo', 1, 2, '2019-12-15 08:53:28', '2019-12-15 08:53:28', NULL),
(31, 31, '2019-01-14', 2, 'Herath Bandaralage Liyansa Thishagi Bandara', 'H B L T', 'Bandara', '2013-05-14', 'female', NULL, NULL, '134/22, Gonapola road', 'Gampaha', 'Gampaha', 1, 1, '2019-12-15 08:58:05', '2019-12-15 08:58:05', NULL),
(32, 32, '2018-01-05', 3, 'Dewasundara Mudiyanselage Anusara Nidew Dewasundara', 'D M A N', 'Dewasundara', '2012-05-12', 'male', NULL, NULL, '235/1, Mandawala road', 'Gampaha', 'Colombo', 1, 1, '2019-12-15 09:43:05', '2019-12-15 09:43:05', NULL),
(33, 33, '2018-01-05', 3, 'Dasanayake Appuhamige Don Duwidi Namoda Dasanayake', 'D A D D N', 'Dasanayake ', '2012-02-23', 'female', NULL, NULL, '321/43, Aruggoda road', 'Yatiyana', 'Ragama', 1, 2, '2019-12-15 11:45:38', '2019-12-15 11:45:38', NULL),
(34, 34, '2018-01-05', 3, 'Udawalawwage Thishagi Dewhiruni Ramanayake', 'U T D', 'Ramanayake', '2012-06-19', 'female', NULL, NULL, '23/1, Hirana road', 'Minuwangoda', 'Minuwangoda', 1, 1, '2019-12-15 11:50:07', '2019-12-15 11:50:07', NULL),
(35, 35, '2018-01-05', 3, 'Kurukulasooriya Arachchige Virun Dinsara Kurukulasooriya', 'K A V D', 'Kurukulasooriya', '2013-01-13', 'male', NULL, NULL, '521/C, Ganga Bada road', 'Gampaha', 'Ragama', 1, 1, '2019-12-15 12:13:05', '2019-12-15 12:13:05', NULL),
(36, 36, '2018-01-05', 3, 'Hewawasam Kankanamge Onadi Imethma Hewawasam', 'H K O I', 'Hewawasam', '2012-10-11', 'female', NULL, NULL, '632/7, Galpoththa road', 'Dewalapola', 'Gampaha', 1, 1, '2019-12-15 12:27:43', '2019-12-15 12:27:43', NULL),
(37, 37, '2018-01-05', 3, 'Edirisinghe Mudiyanselage Shevon Edirisinghe', 'E M S', 'Edirisinghe', '2012-12-31', 'male', NULL, NULL, '49/6, Dharmarama road', 'Veyangoda', 'Watupitiwala', 1, 2, '2019-12-15 12:33:00', '2019-12-15 12:33:00', NULL),
(38, 38, '2018-01-05', 3, 'Balasooriya Mohottige Isali Sahansa Balasooriya', 'B M I S', 'Balasooriya', '2012-03-25', 'female', NULL, NULL, '876/3,Kudapokuna road', 'Wegowwa', 'Colombo', 1, 1, '2019-12-15 12:37:33', '2019-12-15 12:37:33', NULL),
(39, 39, '2018-10-06', 3, 'Weththasinghe Arachchige Janiru Nimsadu Weththasinghe', 'W A J N', 'Weththasinghe', '2012-08-12', 'male', NULL, NULL, '34/B, Kothalawala Mawatha', 'Dagonna', 'Ragama', 1, 1, '2019-12-15 12:41:58', '2019-12-15 12:41:58', NULL),
(40, 40, '2018-01-06', 3, 'Handugala Dewage Ometh Kenuka Siridewa', 'H D O K', 'Siridewa', '2012-05-17', 'male', NULL, NULL, '567/9, Cemetery road', 'Weediyawatta', 'Colombo', 1, 1, '2019-12-15 12:46:16', '2019-12-15 12:46:16', NULL),
(41, 41, '2018-01-06', 3, 'Kankanam Arachchige Chathum Himsara Kankanam', 'K A C H', 'Kankanam', '2012-11-28', 'male', NULL, NULL, '48/17, Mangala Mawatha', 'Minuwangoda', 'Minuwangoda', 1, 1, '2019-12-15 12:51:23', '2019-12-15 12:51:23', NULL),
(42, 42, '2018-01-05', 4, 'Kodithuwakku Arachchige Adithi Praba Kodithuwakku', 'K A A P', 'Kodithuwakku', '2012-09-25', 'female', NULL, NULL, '234/A, Meda Mawatha', 'Yatiyana', 'Gampaha', 1, 1, '2019-12-15 14:53:33', '2019-12-15 14:53:33', NULL),
(43, 43, '2018-01-05', 4, 'Alankara Vidanage Anuja Imasha Alankarage', 'A V A I', 'Alankarage', '2013-01-19', 'male', NULL, NULL, '68/5, Ihala Yagoda road', 'Minuwangoda', 'Minuwangoda', 1, 1, '2019-12-15 14:58:51', '2019-12-15 14:58:51', NULL),
(44, 44, '2018-01-05', 4, 'Herath Mudiyanselage Lakidu Shashin Udagedara', 'H M L S', 'Udagedara', '2012-06-16', 'male', NULL, NULL, '456/19, Samagi Mawatha', 'Gampaha', 'Colombo', 1, 1, '2019-12-15 15:07:31', '2019-12-15 15:07:31', NULL),
(45, 45, '2018-01-05', 4, 'Sapugedara Arachchilage Liyansa Thathsarani Sapugedara', 'S A L T', 'Sapugedara', '2012-11-02', 'female', NULL, NULL, '56/16, Gammana road', 'Wegowwa', 'Colombo', 1, 1, '2019-12-15 16:06:44', '2019-12-15 16:06:44', NULL),
(46, 46, '2018-01-05', 4, 'Nagoda Liyanage Buumi Dilethma Nagoda', 'N L B D', 'Nagoda', '2012-06-23', 'female', NULL, NULL, '23/C, Manniyara road', 'Dewalapola', 'Gampaha', 1, 1, '2019-12-15 16:11:16', '2019-12-15 16:11:16', NULL),
(47, 47, '2018-01-05', 4, 'Hadunneththige Jalitha Damsith Samaranayake', 'H J D', 'Samaranayake', '2012-10-18', 'male', NULL, NULL, '4432/2, Thotupala road', 'Minuwangoda', 'Gampaha', 1, 2, '2019-12-15 16:16:06', '2019-12-15 16:16:06', NULL),
(48, 48, '2018-01-05', 4, 'Amarasinghe Dewage Hesara Sayumdi Amarasinghe', 'A D H S', 'Amarasinghe', '2012-12-29', 'female', NULL, NULL, '122/3, Gelanigama road', 'Yatiana', 'Gampaha', 1, 1, '2019-12-15 17:34:02', '2019-12-15 17:34:02', NULL),
(49, 49, '2018-01-06', 4, 'Senanayake Mudalige Denuka Mandil Senanayake', 'S M D M', 'Senanayake', '2013-01-29', 'male', NULL, NULL, '852/4, Kumbuka road', 'Weediyawatta', 'Colomboo', 1, 1, '2019-12-15 17:38:14', '2019-12-15 17:38:14', NULL),
(50, 50, '2018-01-06', 4, 'Ranasinghe Pattikikoralage Mesadu Dulwan Ranasinghe', 'R P M D', 'Ranasinghe', '2012-05-24', 'male', NULL, NULL, '34/A, Moragahahena road', 'Minuwangoda', 'Gampaha', 1, 1, '2019-12-15 17:42:38', '2019-12-15 17:42:38', NULL),
(51, 51, '2018-01-06', 4, 'Gunawardhana Mudalige Inuki Gayathma Gunawardhana', 'G M I G', 'Gunawardhana', '2012-07-12', 'female', NULL, NULL, '671/4B, Thalagala road', 'Aluthepola', 'Gampaha', 1, 1, '2019-12-15 17:47:10', '2019-12-15 17:47:10', NULL),
(52, 52, '2017-01-04', 5, 'Rajapaksha Mudiyanselage Disal Dineth Rajapaksha', 'R M D D', 'Rajapaksha', '2011-08-27', 'male', NULL, NULL, '257/19, 1st Lane, Yagoda road', 'Yatiyana', 'Colombo', 1, 1, '2019-12-15 19:59:13', '2019-12-15 19:59:13', NULL),
(53, 53, '2017-01-04', 5, 'Raigama Arachchige Oshada Nethmal Raigamage', 'R A O N', 'Raigamage', '2011-11-03', 'male', NULL, NULL, '126/2, Welmilla road', 'Aluthepola', 'Gampaha', 1, 1, '2019-12-15 20:03:35', '2019-12-15 20:03:35', NULL),
(54, 54, '2017-01-04', 5, 'Samarakkody Walawwage Enushi Chamathya Samarakkody', 'S W E C', 'Samarakkody', '2011-05-18', 'female', NULL, NULL, '52/C, Kumbuka road', 'Minuwangoda', 'Minuwangoda', 1, 1, '2019-12-15 20:15:56', '2019-12-15 20:15:56', NULL),
(55, 55, '2017-01-04', 5, 'Siriwardhana Gamage Keshara Kavidu Sriwardhana', 'S G K K', 'Sriwardhana', '2011-03-01', 'male', NULL, NULL, '345/19, Moragahahena road', 'Gampaha', 'Gampaha', 1, 1, '2019-12-15 20:21:11', '2019-12-15 20:21:11', NULL),
(56, 56, '2017-01-04', 5, 'Udawatta Appuhamilage Amoda Sithumini Udawatta', 'U A A S', 'Udawatta', '2011-09-12', 'female', NULL, NULL, '23/9, Welikala road', 'Wegowwa', 'Colombo', 1, 1, '2019-12-15 20:25:40', '2019-12-15 20:25:40', NULL),
(57, 57, '2017-01-04', 5, 'Karunarathne Kankanamge Sanuki Apeksha Karunarathne', 'K K S A', 'Karunarathne', '2011-04-21', 'female', NULL, NULL, '876/5, Gurugoda road', 'Bulugahamulla', 'Gampaha', 1, 2, '2019-12-15 20:30:14', '2019-12-15 20:30:14', NULL),
(58, 58, '2017-01-05', 5, 'Gunathilaka Vidanage Sesadi Dilethma Siva', 'G V S D', 'Siva', '2011-06-05', 'female', NULL, NULL, '34/A, Nagahakotuwa road', 'Minuwangoda', 'Gampaha', 1, 1, '2019-12-15 20:35:11', '2019-12-15 20:35:11', NULL),
(59, 59, '2017-01-05', 5, 'Jayarathna Mudiyanselage Himsara Methmal Jayarathna', 'J M H M', 'Jayarathna', '2011-07-30', 'male', NULL, NULL, '522/4, Temple road', 'Gampaha', 'Gampaha', 1, 2, '2019-12-15 20:40:08', '2019-12-15 20:40:08', NULL),
(60, 60, '2017-01-05', 5, 'Gamlath Arachchige Anuja Iduranga Gamlath', 'G A A I', 'Gamlath', '2011-07-26', 'male', NULL, NULL, '267/11, Kothalawala Mawatha', 'Yatiyana', 'Colombo', 1, 1, '2019-12-15 20:44:16', '2019-12-15 20:44:16', NULL),
(61, 61, '2017-01-05', 5, 'Samarasuria Dewage Umith Bhanuja Samarasuriya', 'S D U B', 'Samarasuriya', '2012-01-25', 'male', NULL, NULL, '344/2C, Thalagahavila road', 'Aluthepola', 'Gampaha', 1, 2, '2019-12-15 20:48:08', '2019-12-15 20:48:08', NULL),
(62, 62, '2017-01-05', 5, 'Ranasinghe Arachchige Vihagi Ama Ranasinghe', 'R A V A', 'Ranasinghe', '2011-12-03', 'female', NULL, NULL, '21/B, Aruggoda road', 'Minuwangoda', 'Gampaha', 1, 1, '2019-12-18 20:03:02', '2019-12-18 20:03:02', NULL),
(63, 63, '2017-01-04', 6, 'Senanayake Muhandiramlage Kavith Shemiyan Senanayake', 'S M K S', 'Senanayake', '2011-08-30', 'male', NULL, NULL, '431/5, Bandaragama road', 'Yatiyana', 'Wataddara', 1, 1, '2019-12-18 20:08:00', '2019-12-18 20:08:00', NULL),
(64, 64, '2017-01-04', 6, 'Warnakulasuriya Patabadige Lavanga Sanahas Warnakulasuriya', 'W P L S', 'Warnakulasuriya', '2011-04-12', 'male', NULL, NULL, '122/12, Moronthuduwa road', 'Nilpanagoda', 'Colombo', 1, 1, '2019-12-18 20:15:31', '2019-12-18 20:15:31', NULL),
(65, 65, '2017-01-04', 6, 'Jayawardhana Weththasinghage Shehara Kavindi Jayawardhana', 'J W S K', 'Jayawardhana', '2011-06-14', 'female', NULL, NULL, '267/15, Samagi Mawatha', 'Minuwangoda', 'Gampaha', 1, 2, '2019-12-18 20:41:44', '2019-12-18 20:41:44', NULL),
(66, 66, '2017-01-04', 6, 'Kalansooriya Arachchige Lithumi Sandupama Kalansooriya', 'K A L S', 'Kalansooriya', '2011-07-11', 'female', NULL, NULL, '521/4C, Kothalawala road', 'Yatiyana', 'Gampaha', 1, 1, '2019-12-18 20:47:33', '2019-12-18 20:47:33', NULL),
(67, 67, '2017-01-04', 6, 'Mapa Gallage Hashen Iduwara Boteju', 'M G H I', 'Boteju', '2011-11-05', 'male', NULL, NULL, '345/16, Gammana road', 'Minuwangoda', 'Gampaha', 1, 2, '2019-12-19 21:07:31', '2019-12-19 21:07:31', NULL),
(68, 68, '2017-01-04', 6, 'Kulasekara Mudiyanselage Virana Sudeepa Kulasekara', 'K M V S', 'Kulasekara', '2011-01-22', 'male', NULL, NULL, '48/C, Mavilla road', 'Gampaha', 'Gampaha', 1, 1, '2019-12-19 21:12:07', '2019-12-19 21:12:07', NULL),
(69, 69, '2017-01-05', 6, 'Hettiarachchi Gamage Sasithi Thisakya Hettiarachchi', 'H G S T', 'Hettiarachchi', '2011-03-08', 'female', NULL, NULL, '78/5A, Puwakwatta road', 'Yatiyana', 'Colombo', 1, 1, '2019-12-19 21:17:25', '2019-12-19 21:17:25', NULL),
(70, 70, '2016-01-16', 7, 'Yapathi Mudiyanselage Githmi Nethara Yapathi', 'Y M G N', 'Yapathi', '2010-12-30', 'female', NULL, NULL, '254/2, Yagodamulla road', 'Minuwangoda', 'Colombo', 1, 1, '2019-12-22 17:32:02', '2019-12-22 17:32:02', NULL),
(71, 71, '2016-01-10', 7, 'Dolawattage Dona Nethum Wisal Dolawatta', 'D D N W', 'Dolawatta', '2011-01-05', 'male', NULL, NULL, '32/41, Galloluwa road', 'Nilpanagoda', 'Gampaha', 1, 1, '2019-12-22 18:11:59', '2019-12-22 18:11:59', NULL),
(72, 72, '2016-01-10', 7, 'Elamulage Don Kawindu Pahasara Elamulage', 'E D K P', 'Elamulage', '2016-06-08', 'male', NULL, NULL, '214/4B, Katuwellegama', 'Udugampola', 'Gampaha', 1, 1, '2019-12-22 18:18:07', '2019-12-22 18:18:07', NULL),
(73, 73, '2016-01-10', 7, 'Kavya Dewmith Perera ', 'K D', 'Perera', '2011-03-22', 'male', NULL, NULL, '456/11, Dunagaha Nilpanagoda road', 'Yatiyana', 'Gampaha', 1, 2, '2019-12-22 18:23:18', '2019-12-22 18:23:18', NULL),
(74, 74, '2016-01-11', 7, 'Satharasinghe Arachchige Dilmi Pinipa', 'S A D', 'Pinipa', '2010-07-19', 'female', NULL, NULL, '311/2, Nelligahaamula road', 'Weediyawatta', 'Colombo', 1, 1, '2019-12-22 18:30:11', '2019-12-22 18:30:11', NULL),
(75, 75, '2016-01-11', 7, 'Vijesinghage Rishini Mokshawi Vijesinghe', 'V R M', 'Vijesinghe', '2010-09-14', 'female', NULL, NULL, '21/13, Marapoala road', 'Wegowwa', 'Colombo', 1, 1, '2019-12-22 18:56:55', '2019-12-22 18:56:55', NULL),
(76, 76, '2016-01-11', 7, 'Hewa Fonsekage Oshada Supun Fonseka', 'H F O S', 'Fonseka', '2010-10-09', 'male', NULL, NULL, '123/4, Udugama road', 'Dewalapoala', 'Colombo', 1, 1, '2019-12-22 19:01:29', '2019-12-22 19:01:29', NULL),
(77, 77, '2016-01-11', 7, 'Warnakulasooriyage Methula Eshan Warnakulasooriya', 'W M E', 'Warnakulasooriya', '2010-11-02', 'male', NULL, NULL, '963/3, Medagampitiya road', 'Yatiyana', 'Gampaha', 1, 1, '2019-12-22 19:06:26', '2019-12-22 19:06:26', NULL),
(78, 78, '2016-01-11', 7, ' Devid Mudiyanselage Thedini Nimsara Thennakoon', 'D M T N', 'Thennakoon', '2010-05-27', 'female', NULL, NULL, '312/2, Temple road', 'Gampaha', 'Colombo', 1, 1, '2019-12-22 19:23:49', '2019-12-22 19:23:49', NULL),
(79, 79, '2016-01-10', 8, 'Amarasinghe Mudalige Binidu Kavinga Amarasinghe', 'A M B K', 'Amarasinghe', '2016-02-11', 'male', NULL, NULL, '201/5, Udugama road', 'Gampaha', 'Colombo', 1, 1, '2019-12-22 20:26:12', '2019-12-22 20:26:12', NULL),
(80, 80, '2016-01-10', 8, 'Jayasundara Mudalige Methushi Danara Jayasundara', 'J M M D', 'Jayasundara', '2010-05-22', 'female', NULL, NULL, '182/27, Kotugoda road', 'Minuwangoda', 'Minuwangoda', 1, 1, '2019-12-22 20:30:11', '2019-12-22 20:30:11', NULL),
(81, 81, '2016-01-10', 8, 'Ranasinghe Arachchige Hasithmi Sanulya Ranasinghe', 'R A H S', 'Ranasinghe', '2010-08-21', 'female', NULL, NULL, '22/5, Yagodamulla road', 'Nilpanagoda', 'Minuwangoda', 1, 1, '2019-12-22 20:34:46', '2019-12-22 20:34:46', NULL),
(82, 82, '2016-01-10', 8, 'Senanayaka Mudalige Lakidu Shashin Senanayaka', 'S M L S', 'Senanayaka', '2010-11-05', 'male', NULL, NULL, '312/1, Nedagamuwa road', 'Minuwangoda', 'Gampaha', 1, 1, '2019-12-22 21:01:06', '2019-12-22 21:01:06', NULL),
(83, 83, '2010-01-10', 8, 'Madusinghe Arachchige Esada Methsilu Madusinghe', 'M A E M', 'Madusinghe', '2010-06-30', 'male', NULL, NULL, '511/4C Vijaya Mawatha', 'Yatiyana', 'Colombo', 1, 1, '2019-12-22 21:07:50', '2019-12-22 21:07:50', NULL),
(84, 84, '2016-11-10', 8, 'Narangoda Mudalige Shanuli Akarsha Narangoda', 'N M S A', 'Narangoda', '2010-07-10', 'female', NULL, NULL, '198/2 Dunagaha road', 'Veyangoda', 'Wathupitiwala', NULL, 1, '2019-12-22 21:12:24', '2019-12-22 21:12:24', NULL),
(85, 85, '2015-04-01', 9, 'Wanniarachchilage Denuthi Senulya Wanniarachchi', 'W D S', 'Wanniarachchi', '2009-05-11', 'female', NULL, NULL, '268/12,Seruwila road', 'Minuwangoda', 'Gampaha', 1, 1, '2019-12-26 19:11:42', '2019-12-26 19:11:42', NULL),
(86, 86, '2015-04-01', 9, 'Baduraliya Sivage Mesadu Sanumitha Silva', 'B S M S', 'Silva', '2009-12-30', 'male', NULL, NULL, '133/B, Walawwatta road', 'Nilpanagoda', 'Colombo', 1, 1, '2019-12-26 19:16:41', '2019-12-26 19:16:41', NULL),
(87, 87, '2015-04-01', 9, 'Withana Arachchilage Vishmika Rukshan Withanage', 'W A V R', 'Withanage', '2009-07-28', 'male', NULL, NULL, '203/2, Hansagiri road', 'Gampaha', 'Gampaha', 3, 1, '2019-12-26 19:21:51', '2019-12-26 19:21:51', NULL),
(88, 88, '2015-04-01', 9, 'Hadunnettige Shalana Iduwara Thilakasiri', 'H S I', 'Thilakasiri', '2010-01-13', 'male', NULL, NULL, '165/6, Samangi Mawatha', 'Wegowwa', 'Colombo', 1, 1, '2019-12-26 19:25:40', '2019-12-26 19:25:40', NULL),
(89, 89, '2015-04-01', 9, 'Chandrapala Mohottige Umeth Abisheka Chandrapala', 'C M U A', 'Chandrapala', '2009-11-02', 'male', NULL, NULL, '22/5, Kidagammulla road', 'Udugampoala', 'Minuwangoda ', 1, 1, '2019-12-26 19:41:32', '2019-12-26 19:41:32', NULL),
(90, 90, '2015-01-04', 9, 'Warnakula Arachchige Vihagi Theeksha Warnakula', 'W A V T', 'Warnakula', '2009-11-03', 'female', NULL, NULL, '512/4, Temple road', 'Dunagaha', 'Gampaha', 1, 2, '2019-12-26 19:46:58', '2019-12-26 19:46:58', NULL),
(91, 91, '2015-01-04', 9, 'Ranaweera Mohottige Teshan Chamod Ranaweera', 'R M T C', 'Ranaweera', '2009-04-23', 'male', NULL, NULL, '578/6, Vishaka road', 'Korase', 'Colombo', 1, 1, '2019-12-26 19:51:06', '2019-12-26 19:51:06', NULL),
(92, 92, '2015-01-05', 9, 'Gunarathne Mudalige Hirun Nethra Gunarathne', 'G M H N', 'Gunarathne', '2009-10-17', 'male', NULL, NULL, '155/12, Siyane road', 'Yatiyana', 'Colombo', 1, 1, '2019-12-26 19:55:08', '2019-12-26 19:55:08', NULL),
(93, 93, '2015-01-05', 9, 'Aththanayake Arahchige Kithmi Yehansa Ahthanayake', 'A A K Y', 'Ahthanayake', '2009-08-14', 'female', NULL, NULL, '302/5B, Gajaba Mawatha', 'Gampaha', 'Colombo', 1, 1, '2019-12-26 19:59:00', '2019-12-26 19:59:00', NULL),
(94, 94, '2015-01-05', 9, 'Wijesoorialage Hesara Sayumadi Wijesooriya', 'W H S', 'Wijesooriya', '2009-06-11', 'female', NULL, NULL, '411/8,Church road', 'Wegowwa', 'Gampaha', 1, 2, '2019-12-26 20:02:26', '2019-12-26 20:02:26', NULL),
(95, 95, '2015-01-05', 9, 'Thennakoon Gamage Inuki Gayathma Thennakoon', 'T G I G', 'Thennakoon', '2009-02-05', 'female', NULL, NULL, '246/17, Vijaya Mawatha', 'Nilpanagoda', 'Gampaha', 1, 1, '2019-12-26 20:06:27', '2019-12-26 20:06:27', NULL),
(96, 96, '2015-01-05', 9, 'Nanayakkara Walawwage Hasanga Guwanidu Nanayakkara', 'N W H G', 'Nanayakkara', '2009-12-25', 'male', NULL, NULL, '721/9, Pahalagama road', 'Gampaha', 'Gampaha', 1, 1, '2019-12-26 20:10:11', '2019-12-26 20:10:11', NULL),
(97, 97, '2015-01-04', 10, 'Vijerathne Vidanage Sasmitha Randinu Vijerathne', 'V V S R', 'Vijerathne', '2009-04-18', 'male', NULL, NULL, '523/8, Katwellagama', 'Udugampola', 'Gampaha', 1, 2, '2019-12-29 10:55:58', '2019-12-29 10:55:58', NULL),
(98, 98, '2015-01-04', 10, 'Chandrasiri Balasooriyalage Janesha Nethuli Chandrasiri', 'C B J N', 'Chandrasiri', '2009-05-13', 'female', NULL, NULL, '128/51, Wijaya Mawatha', 'Minuwangoda', 'Minuwangoda', 1, 1, '2019-12-29 10:59:58', '2019-12-29 10:59:58', NULL),
(99, 99, '2015-01-04', 10, 'Kahandawala Bandarage Lakidu Dhaham Rodrigo', 'K B L D', 'Rodrigo', '2009-08-17', 'male', NULL, NULL, '20/8, Ambagahamulla road', 'Wegowwa', 'Gampaha', 1, 1, '2019-12-29 11:03:06', '2019-12-29 11:03:06', NULL),
(100, 100, '2015-01-04', 10, 'Jayasekara Mudiyanselage Methun Nimsara Jayasekara', 'J M M N', 'Jayasekara', '2010-01-22', 'male', NULL, NULL, '185/4C, Cemetry road', 'Gampaha', 'Colombo', 1, 1, '2019-12-29 11:06:52', '2019-12-29 11:06:52', NULL),
(101, 101, '2015-10-04', 10, 'Weerathunga Arachchilage Ometh Kenuka Weerathunga', 'W A O K', 'Weerathunga', '2009-06-09', 'male', NULL, NULL, '542/13, Samarakkody road', 'Veyangoda', 'Wataddara', 1, 1, '2019-12-29 11:10:35', '2019-12-29 11:10:35', NULL),
(102, 102, '2015-01-04', 10, 'Liyanarachchi Gamage Enushi Liyansa Gamage', 'L G E L', 'Gamage', '2009-10-12', 'female', NULL, NULL, '234/5, Uyana road', 'Minuwangoda', 'Gampaha', 1, 1, '2019-12-29 11:14:28', '2019-12-29 11:14:28', NULL),
(103, 103, '2015-01-04', 10, 'Liyanarachchi Gamage Enuthi Chamathya Gamage', 'L G E C', 'Gamage', '2009-10-12', 'female', NULL, NULL, '234/5, Uyana road', 'Minuwangoda', 'Minuwangoda', 1, 1, '2019-12-29 11:18:21', '2019-12-29 11:18:21', NULL),
(104, 104, '2015-01-04', 10, 'Abeysinghe Arachchige Abhisheka Rajidu Abeysinghe', 'A A A R', 'Abeysinghe', '2009-05-24', 'male', NULL, NULL, '451/2,Uggagala road', 'Nilpanagoda', 'Colombo', 1, 1, '2019-12-29 11:22:29', '2019-12-29 11:22:29', NULL),
(105, 105, '2015-01-04', 10, 'Handugala Dewage Kavija Anusara Perera', 'H D K A', 'Perera', '2009-11-02', 'male', NULL, NULL, '321/7, Malwatta road', 'Gampaha', 'Colombo', 1, 1, '2019-12-29 11:26:53', '2019-12-29 11:26:53', NULL),
(106, 106, '2015-01-05', 10, 'Ramanayake Mudiyanselage Onadi Methma Ramanayake', 'R M O M', 'Ramanayake', '2009-04-13', 'female', NULL, NULL, '123/4, Orutota road', 'Gampaha', 'Gampaha', 1, 1, '2019-12-29 11:30:45', '2019-12-29 11:30:45', NULL),
(107, 107, '2015-01-05', 10, 'Madurasinghe Arachchige Layodya Kinkini Madurasinghe', 'M A L K', 'Madurasinghe', '2009-10-31', 'female', NULL, NULL, '465/C, Mahinda road', 'Gampaha', 'Colombo', 1, 1, '2019-12-29 11:34:11', '2019-12-29 11:34:11', NULL),
(108, 108, '2015-01-05', 10, 'Herath Mudiyanselage Dhenuka Mandil Herath', 'H M D M', 'Herath', '2009-08-19', 'male', NULL, NULL, '341/3, Vijaya road', 'Nilpanagoda', 'Gampaha', 1, 2, '2019-12-29 11:37:52', '2019-12-29 11:37:52', NULL),
(109, 109, '2015-01-06', 10, 'Hettiarachchi Gamage Sadasi Lanka Hettiarachchi', 'H G S L', 'Hettiarachchi', '2009-12-01', 'female', NULL, NULL, '268/12, Pahalagama road', 'Gampaha', 'Gampaha', 1, 1, '2019-12-29 11:41:20', '2019-12-29 11:41:20', NULL),
(110, 110, '2015-01-06', 10, 'Narangoda Uyanarachchilage Udula Yasasvi Narangoda', 'N U U Y', 'Narangoda', '2009-05-24', 'female', NULL, NULL, '165/6, Samangi Mawatha', 'Wegowwa', 'Colombo', 1, 1, '2019-12-29 11:44:57', '2019-12-29 11:44:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_achievement`
--

CREATE TABLE `student_achievement` (
  `id` int(11) NOT NULL,
  `student_id` int(6) NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` int(200) DEFAULT NULL,
  `achieved_on` date NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_attendance`
--

CREATE TABLE `student_attendance` (
  `id` bigint(20) NOT NULL,
  `student_id` int(6) NOT NULL,
  `date` date NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_attendance`
--

INSERT INTO `student_attendance` (`id`, `student_id`, `date`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 1, '2020-01-01', '2020-01-02 03:11:03', '2020-01-02 03:11:03', NULL),
(2, 2, '2020-01-01', '2020-01-02 03:11:03', '2020-01-02 03:11:03', NULL),
(3, 3, '2020-01-01', '2020-01-02 03:11:04', '2020-01-02 03:11:04', NULL),
(4, 5, '2020-01-01', '2020-01-02 03:11:05', '2020-01-02 03:11:05', NULL),
(5, 6, '2020-01-01', '2020-01-02 03:11:05', '2020-01-02 03:11:05', NULL),
(6, 7, '2020-01-01', '2020-01-02 03:11:06', '2020-01-02 03:11:06', NULL),
(7, 8, '2020-01-01', '2020-01-02 03:11:07', '2020-01-02 03:11:07', NULL),
(8, 10, '2020-01-01', '2020-01-02 03:11:07', '2020-01-02 03:11:07', NULL),
(9, 11, '2020-01-01', '2020-01-02 03:11:08', '2020-01-02 03:11:08', NULL),
(10, 13, '2020-01-01', '2020-01-02 03:11:09', '2020-01-02 03:11:09', NULL),
(11, 16, '2020-01-01', '2020-01-02 03:11:16', '2020-01-02 03:11:16', NULL),
(12, 18, '2020-01-01', '2020-01-02 03:11:17', '2020-01-02 03:11:17', NULL),
(13, 20, '2020-01-01', '2020-01-02 03:11:18', '2020-01-02 03:11:18', NULL),
(14, 19, '2020-01-01', '2020-01-02 03:11:19', '2020-01-02 03:11:19', NULL),
(15, 21, '2020-01-01', '2020-01-02 03:11:19', '2020-01-02 03:11:19', NULL),
(16, 24, '2020-01-01', '2020-01-02 03:11:20', '2020-01-02 03:11:20', NULL),
(17, 25, '2020-01-01', '2020-01-02 03:11:21', '2020-01-02 03:11:21', NULL),
(18, 27, '2020-01-01', '2020-01-02 03:11:22', '2020-01-02 03:11:22', NULL),
(19, 29, '2020-01-01', '2020-01-02 03:11:22', '2020-01-02 03:11:22', NULL),
(20, 30, '2020-01-01', '2020-01-02 03:11:23', '2020-01-02 03:11:23', NULL),
(21, 31, '2020-01-01', '2020-01-02 03:11:24', '2020-01-02 03:11:24', NULL),
(22, 32, '2020-01-01', '2020-01-02 03:11:33', '2020-01-02 03:11:33', NULL),
(23, 33, '2020-01-01', '2020-01-02 03:11:33', '2020-01-02 03:11:33', NULL),
(24, 34, '2020-01-01', '2020-01-02 03:11:34', '2020-01-02 03:11:34', NULL),
(25, 35, '2020-01-01', '2020-01-02 03:11:34', '2020-01-02 03:11:34', NULL),
(26, 36, '2020-01-01', '2020-01-02 03:11:35', '2020-01-02 03:11:35', NULL),
(27, 38, '2020-01-01', '2020-01-02 03:11:36', '2020-01-02 03:11:36', NULL),
(28, 39, '2020-01-01', '2020-01-02 03:11:36', '2020-01-02 03:11:36', NULL),
(29, 40, '2020-01-01', '2020-01-02 03:11:37', '2020-01-02 03:11:37', NULL),
(30, 41, '2020-01-01', '2020-01-02 03:11:37', '2020-01-02 03:11:37', NULL),
(31, 42, '2020-01-01', '2020-01-02 03:11:44', '2020-01-02 03:11:44', NULL),
(32, 43, '2020-01-01', '2020-01-02 03:11:44', '2020-01-02 03:11:44', NULL),
(33, 45, '2020-01-01', '2020-01-02 03:11:45', '2020-01-02 03:11:45', NULL),
(34, 46, '2020-01-01', '2020-01-02 03:11:46', '2020-01-02 03:11:46', NULL),
(35, 47, '2020-01-01', '2020-01-02 03:11:46', '2020-01-02 03:11:46', NULL),
(36, 48, '2020-01-01', '2020-01-02 03:11:47', '2020-01-02 03:11:47', NULL),
(37, 50, '2020-01-01', '2020-01-02 03:11:48', '2020-01-02 03:11:48', NULL),
(38, 52, '2020-01-01', '2020-01-02 03:11:55', '2020-01-02 03:11:55', NULL),
(39, 53, '2020-01-01', '2020-01-02 03:11:55', '2020-01-02 03:11:55', NULL),
(40, 55, '2020-01-01', '2020-01-02 03:11:56', '2020-01-02 03:11:56', NULL),
(41, 57, '2020-01-01', '2020-01-02 03:11:57', '2020-01-02 03:11:57', NULL),
(42, 59, '2020-01-01', '2020-01-02 03:11:57', '2020-01-02 03:11:57', NULL),
(43, 60, '2020-01-01', '2020-01-02 03:11:58', '2020-01-02 03:11:58', NULL),
(44, 62, '2020-01-01', '2020-01-02 03:11:59', '2020-01-02 03:11:59', NULL),
(45, 63, '2020-01-01', '2020-01-02 03:12:04', '2020-01-02 03:12:04', NULL),
(46, 65, '2020-01-01', '2020-01-02 03:12:05', '2020-01-02 03:12:05', NULL),
(47, 67, '2020-01-01', '2020-01-02 03:12:06', '2020-01-02 03:12:06', NULL),
(48, 69, '2020-01-01', '2020-01-02 03:12:07', '2020-01-02 03:12:07', NULL),
(49, 68, '2020-01-01', '2020-01-02 03:12:07', '2020-01-02 03:12:07', NULL),
(50, 70, '2020-01-01', '2020-01-02 03:12:13', '2020-01-02 03:12:13', NULL),
(51, 71, '2020-01-01', '2020-01-02 03:12:14', '2020-01-02 03:12:14', NULL),
(52, 72, '2020-01-01', '2020-01-02 03:12:14', '2020-01-02 03:12:14', NULL),
(53, 73, '2020-01-01', '2020-01-02 03:12:15', '2020-01-02 03:12:15', NULL),
(54, 74, '2020-01-01', '2020-01-02 03:12:15', '2020-01-02 03:12:15', NULL),
(55, 75, '2020-01-01', '2020-01-02 03:12:15', '2020-01-02 03:12:15', NULL),
(56, 76, '2020-01-01', '2020-01-02 03:12:16', '2020-01-02 03:12:16', NULL),
(57, 77, '2020-01-01', '2020-01-02 03:12:16', '2020-01-02 03:12:16', NULL),
(58, 78, '2020-01-01', '2020-01-02 03:12:17', '2020-01-02 03:12:17', NULL),
(59, 79, '2020-01-01', '2020-01-02 03:12:20', '2020-01-02 03:12:20', NULL),
(60, 80, '2020-01-01', '2020-01-02 03:12:21', '2020-01-02 03:12:21', NULL),
(61, 82, '2020-01-01', '2020-01-02 03:12:21', '2020-01-02 03:12:21', NULL),
(62, 83, '2020-01-01', '2020-01-02 03:12:24', '2020-01-02 03:12:24', NULL),
(63, 84, '2020-01-01', '2020-01-02 03:12:24', '2020-01-02 03:12:24', NULL),
(64, 85, '2020-01-01', '2020-01-02 03:12:29', '2020-01-02 03:12:29', NULL),
(65, 86, '2020-01-01', '2020-01-02 03:12:30', '2020-01-02 03:12:30', NULL),
(66, 87, '2020-01-01', '2020-01-02 03:12:30', '2020-01-02 03:12:30', NULL),
(67, 89, '2020-01-01', '2020-01-02 03:12:31', '2020-01-02 03:12:31', NULL),
(68, 91, '2020-01-01', '2020-01-02 03:12:32', '2020-01-02 03:12:32', NULL),
(69, 92, '2020-01-01', '2020-01-02 03:12:33', '2020-01-02 03:12:33', NULL),
(70, 93, '2020-01-01', '2020-01-02 03:12:33', '2020-01-02 03:12:33', NULL),
(71, 95, '2020-01-01', '2020-01-02 03:12:34', '2020-01-02 03:12:34', NULL),
(72, 97, '2020-01-01', '2020-01-02 03:12:40', '2020-01-02 03:12:40', NULL),
(73, 98, '2020-01-01', '2020-01-02 03:12:40', '2020-01-02 03:12:40', NULL),
(74, 99, '2020-01-01', '2020-01-02 03:12:40', '2020-01-02 03:12:40', NULL),
(75, 101, '2020-01-01', '2020-01-02 03:12:41', '2020-01-02 03:12:41', NULL),
(76, 102, '2020-01-01', '2020-01-02 03:12:42', '2020-01-02 03:12:42', NULL),
(77, 103, '2020-01-01', '2020-01-02 03:12:42', '2020-01-02 03:12:42', NULL),
(78, 104, '2020-01-01', '2020-01-02 03:12:43', '2020-01-02 03:12:43', NULL),
(79, 105, '2020-01-01', '2020-01-02 03:12:43', '2020-01-02 03:12:43', NULL),
(80, 109, '2020-01-01', '2020-01-02 03:12:44', '2020-01-02 03:12:44', NULL),
(81, 110, '2020-01-01', '2020-01-02 03:12:45', '2020-01-02 03:12:45', NULL),
(82, 1, '2020-01-02', '2020-01-02 03:13:00', '2020-01-02 03:13:00', NULL),
(83, 2, '2020-01-02', '2020-01-02 03:13:01', '2020-01-02 03:13:01', NULL),
(84, 3, '2020-01-02', '2020-01-02 03:13:01', '2020-01-02 03:13:01', NULL),
(85, 4, '2020-01-02', '2020-01-02 03:13:02', '2020-01-02 03:13:02', NULL),
(86, 5, '2020-01-02', '2020-01-02 03:13:03', '2020-01-02 03:13:03', NULL),
(87, 6, '2020-01-02', '2020-01-02 03:13:03', '2020-01-02 03:13:03', NULL),
(88, 7, '2020-01-02', '2020-01-02 03:13:03', '2020-01-02 03:13:03', NULL),
(89, 8, '2020-01-02', '2020-01-02 03:13:04', '2020-01-02 03:13:04', NULL),
(90, 9, '2020-01-02', '2020-01-02 03:13:04', '2020-01-02 03:13:04', NULL),
(91, 10, '2020-01-02', '2020-01-02 03:13:05', '2020-01-02 03:13:05', NULL),
(92, 11, '2020-01-02', '2020-01-02 03:13:06', '2020-01-02 03:13:06', NULL),
(93, 17, '2020-01-02', '2020-01-02 03:13:11', '2020-01-02 03:13:11', NULL),
(94, 19, '2020-01-02', '2020-01-02 03:13:11', '2020-01-02 03:13:11', NULL),
(95, 23, '2020-01-02', '2020-01-02 03:13:12', '2020-01-02 03:13:12', NULL),
(96, 24, '2020-01-02', '2020-01-02 03:13:13', '2020-01-02 03:13:13', NULL),
(97, 26, '2020-01-02', '2020-01-02 03:13:14', '2020-01-02 03:13:14', NULL),
(98, 27, '2020-01-02', '2020-01-02 03:13:14', '2020-01-02 03:13:14', NULL),
(99, 30, '2020-01-02', '2020-01-02 03:13:15', '2020-01-02 03:13:15', NULL),
(100, 29, '2020-01-02', '2020-01-02 03:13:16', '2020-01-02 03:13:16', NULL),
(101, 32, '2020-01-02', '2020-01-02 03:13:31', '2020-01-02 03:13:31', NULL),
(102, 33, '2020-01-02', '2020-01-02 03:13:31', '2020-01-02 03:13:31', NULL),
(103, 35, '2020-01-02', '2020-01-02 03:13:32', '2020-01-02 03:13:32', NULL),
(104, 36, '2020-01-02', '2020-01-02 03:13:33', '2020-01-02 03:13:33', NULL),
(105, 37, '2020-01-02', '2020-01-02 03:13:33', '2020-01-02 03:13:33', NULL),
(106, 39, '2020-01-02', '2020-01-02 03:13:34', '2020-01-02 03:13:34', NULL),
(107, 40, '2020-01-02', '2020-01-02 03:13:34', '2020-01-02 03:13:34', NULL),
(108, 41, '2020-01-02', '2020-01-02 03:13:34', '2020-01-02 03:13:34', NULL),
(109, 42, '2020-01-02', '2020-01-02 03:13:39', '2020-01-02 03:13:39', NULL),
(110, 44, '2020-01-02', '2020-01-02 03:13:39', '2020-01-02 03:13:39', NULL),
(111, 45, '2020-01-02', '2020-01-02 03:13:40', '2020-01-02 03:13:40', NULL),
(112, 46, '2020-01-02', '2020-01-02 03:13:41', '2020-01-02 03:13:41', NULL),
(113, 48, '2020-01-02', '2020-01-02 03:13:41', '2020-01-02 03:13:41', NULL),
(114, 49, '2020-01-02', '2020-01-02 03:13:42', '2020-01-02 03:13:42', NULL),
(115, 51, '2020-01-02', '2020-01-02 03:13:43', '2020-01-02 03:13:43', NULL),
(116, 52, '2020-01-02', '2020-01-02 03:13:47', '2020-01-02 03:13:47', NULL),
(117, 53, '2020-01-02', '2020-01-02 03:13:47', '2020-01-02 03:13:47', NULL),
(118, 54, '2020-01-02', '2020-01-02 03:13:48', '2020-01-02 03:13:48', NULL),
(119, 56, '2020-01-02', '2020-01-02 03:13:48', '2020-01-02 03:13:48', NULL),
(120, 57, '2020-01-02', '2020-01-02 03:13:49', '2020-01-02 03:13:49', NULL),
(121, 58, '2020-01-02', '2020-01-02 03:13:49', '2020-01-02 03:13:49', NULL),
(122, 60, '2020-01-02', '2020-01-02 03:13:50', '2020-01-02 03:13:50', NULL),
(123, 61, '2020-01-02', '2020-01-02 03:13:51', '2020-01-02 03:13:51', NULL),
(124, 62, '2020-01-02', '2020-01-02 03:13:51', '2020-01-02 03:13:51', NULL),
(125, 63, '2020-01-02', '2020-01-02 03:13:56', '2020-01-02 03:13:56', NULL),
(126, 65, '2020-01-02', '2020-01-02 03:13:57', '2020-01-02 03:13:57', NULL),
(127, 67, '2020-01-02', '2020-01-02 03:13:57', '2020-01-02 03:13:57', NULL),
(128, 69, '2020-01-02', '2020-01-02 03:13:58', '2020-01-02 03:13:58', NULL),
(129, 68, '2020-01-02', '2020-01-02 03:13:58', '2020-01-02 03:13:58', NULL),
(130, 70, '2020-01-02', '2020-01-02 03:14:05', '2020-01-02 03:14:05', NULL),
(131, 72, '2020-01-02', '2020-01-02 03:14:06', '2020-01-02 03:14:06', NULL),
(132, 74, '2020-01-02', '2020-01-02 03:14:06', '2020-01-02 03:14:06', NULL),
(133, 75, '2020-01-02', '2020-01-02 03:14:07', '2020-01-02 03:14:07', NULL),
(134, 76, '2020-01-02', '2020-01-02 03:14:08', '2020-01-02 03:14:08', NULL),
(135, 77, '2020-01-02', '2020-01-02 03:14:08', '2020-01-02 03:14:08', NULL),
(136, 78, '2020-01-02', '2020-01-02 03:14:09', '2020-01-02 03:14:09', NULL),
(137, 79, '2020-01-02', '2020-01-02 03:14:13', '2020-01-02 03:14:13', NULL),
(138, 80, '2020-01-02', '2020-01-02 03:14:13', '2020-01-02 03:14:13', NULL),
(139, 82, '2020-01-02', '2020-01-02 03:14:14', '2020-01-02 03:14:14', NULL),
(140, 83, '2020-01-02', '2020-01-02 03:14:14', '2020-01-02 03:14:14', NULL),
(141, 84, '2020-01-02', '2020-01-02 03:14:15', '2020-01-02 03:14:15', NULL),
(142, 85, '2020-01-02', '2020-01-02 03:14:22', '2020-01-02 03:14:22', NULL),
(143, 86, '2020-01-02', '2020-01-02 03:14:23', '2020-01-02 03:14:23', NULL),
(144, 87, '2020-01-02', '2020-01-02 03:14:23', '2020-01-02 03:14:23', NULL),
(145, 88, '2020-01-02', '2020-01-02 03:14:24', '2020-01-02 03:14:24', NULL),
(146, 89, '2020-01-02', '2020-01-02 03:14:24', '2020-01-02 03:14:24', NULL),
(147, 90, '2020-01-02', '2020-01-02 03:14:24', '2020-01-02 03:14:24', NULL),
(148, 91, '2020-01-02', '2020-01-02 03:14:25', '2020-01-02 03:14:25', NULL),
(149, 93, '2020-01-02', '2020-01-02 03:14:26', '2020-01-02 03:14:26', NULL),
(150, 94, '2020-01-02', '2020-01-02 03:14:27', '2020-01-02 03:14:27', NULL),
(151, 95, '2020-01-02', '2020-01-02 03:14:27', '2020-01-02 03:14:27', NULL),
(152, 96, '2020-01-02', '2020-01-02 03:14:28', '2020-01-02 03:14:28', NULL),
(153, 97, '2020-01-02', '2020-01-02 03:14:42', '2020-01-02 03:14:42', NULL),
(154, 99, '2020-01-02', '2020-01-02 03:14:43', '2020-01-02 03:14:43', NULL),
(155, 101, '2020-01-02', '2020-01-02 03:14:44', '2020-01-02 03:14:44', NULL),
(156, 103, '2020-01-02', '2020-01-02 03:14:45', '2020-01-02 03:14:45', NULL),
(157, 105, '2020-01-02', '2020-01-02 03:14:46', '2020-01-02 03:14:46', NULL),
(158, 107, '2020-01-02', '2020-01-02 03:14:46', '2020-01-02 03:14:46', NULL),
(159, 106, '2020-01-02', '2020-01-02 03:14:47', '2020-01-02 03:14:47', NULL),
(160, 108, '2020-01-02', '2020-01-02 03:14:48', '2020-01-02 03:14:48', NULL),
(161, 109, '2020-01-02', '2020-01-02 03:14:48', '2020-01-02 03:14:48', NULL),
(162, 1, '2020-01-03', '2020-01-03 06:51:57', '2020-01-03 06:51:57', NULL),
(163, 2, '2020-01-03', '2020-01-03 06:51:57', '2020-01-03 06:51:57', NULL),
(164, 3, '2020-01-03', '2020-01-03 06:51:58', '2020-01-03 06:51:58', NULL),
(165, 5, '2020-01-03', '2020-01-03 06:51:59', '2020-01-03 06:51:59', NULL),
(166, 7, '2020-01-03', '2020-01-03 06:52:00', '2020-01-03 06:52:00', NULL),
(167, 9, '2020-01-03', '2020-01-03 06:52:01', '2020-01-03 06:52:01', NULL),
(168, 11, '2020-01-03', '2020-01-03 06:52:02', '2020-01-03 06:52:02', NULL),
(169, 12, '2020-01-03', '2020-01-03 06:52:03', '2020-01-03 06:52:03', NULL),
(170, 13, '2020-01-03', '2020-01-03 06:52:04', '2020-01-03 06:52:04', NULL),
(171, 15, '2020-01-03', '2020-01-03 06:52:05', '2020-01-03 06:52:05', NULL),
(172, 16, '2020-01-03', '2020-01-03 06:52:11', '2020-01-03 06:52:11', NULL),
(173, 17, '2020-01-03', '2020-01-03 06:52:12', '2020-01-03 06:52:12', NULL),
(174, 18, '2020-01-03', '2020-01-03 06:52:12', '2020-01-03 06:52:12', NULL),
(175, 19, '2020-01-03', '2020-01-03 06:52:13', '2020-01-03 06:52:13', NULL),
(176, 20, '2020-01-03', '2020-01-03 06:52:13', '2020-01-03 06:52:13', NULL),
(177, 22, '2020-01-03', '2020-01-03 06:52:15', '2020-01-03 06:52:15', NULL),
(178, 23, '2020-01-03', '2020-01-03 06:52:15', '2020-01-03 06:52:15', NULL),
(179, 25, '2020-01-03', '2020-01-03 06:52:16', '2020-01-03 06:52:16', NULL),
(180, 27, '2020-01-03', '2020-01-03 06:52:17', '2020-01-03 06:52:17', NULL),
(181, 28, '2020-01-03', '2020-01-03 06:52:17', '2020-01-03 06:52:17', NULL),
(182, 29, '2020-01-03', '2020-01-03 06:52:18', '2020-01-03 06:52:18', NULL),
(183, 31, '2020-01-03', '2020-01-03 06:52:18', '2020-01-03 06:52:18', NULL),
(184, 32, '2020-01-03', '2020-01-03 06:52:23', '2020-01-03 06:52:23', NULL),
(185, 33, '2020-01-03', '2020-01-03 06:52:24', '2020-01-03 06:52:24', NULL),
(186, 34, '2020-01-03', '2020-01-03 06:52:25', '2020-01-03 06:52:25', NULL),
(187, 36, '2020-01-03', '2020-01-03 06:52:25', '2020-01-03 06:52:25', NULL),
(188, 37, '2020-01-03', '2020-01-03 06:52:26', '2020-01-03 06:52:26', NULL),
(189, 38, '2020-01-03', '2020-01-03 06:52:27', '2020-01-03 06:52:27', NULL),
(190, 40, '2020-01-03', '2020-01-03 06:52:28', '2020-01-03 06:52:28', NULL),
(191, 42, '2020-01-03', '2020-01-03 06:52:32', '2020-01-03 06:52:32', NULL),
(192, 43, '2020-01-03', '2020-01-03 06:52:33', '2020-01-03 06:52:33', NULL),
(193, 45, '2020-01-03', '2020-01-03 06:52:34', '2020-01-03 06:52:34', NULL),
(194, 47, '2020-01-03', '2020-01-03 06:52:34', '2020-01-03 06:52:34', NULL),
(195, 49, '2020-01-03', '2020-01-03 06:52:35', '2020-01-03 06:52:35', NULL),
(196, 51, '2020-01-03', '2020-01-03 06:52:36', '2020-01-03 06:52:36', NULL),
(197, 52, '2020-01-03', '2020-01-03 06:52:40', '2020-01-03 06:52:40', NULL),
(198, 53, '2020-01-03', '2020-01-03 06:52:41', '2020-01-03 06:52:41', NULL),
(199, 55, '2020-01-03', '2020-01-03 06:52:41', '2020-01-03 06:52:41', NULL),
(200, 57, '2020-01-03', '2020-01-03 06:52:42', '2020-01-03 06:52:42', NULL),
(201, 59, '2020-01-03', '2020-01-03 06:52:43', '2020-01-03 06:52:43', NULL),
(202, 61, '2020-01-03', '2020-01-03 06:52:44', '2020-01-03 06:52:44', NULL),
(203, 62, '2020-01-03', '2020-01-03 06:52:44', '2020-01-03 06:52:44', NULL),
(204, 63, '2020-01-03', '2020-01-03 06:52:50', '2020-01-03 06:52:50', NULL),
(205, 64, '2020-01-03', '2020-01-03 06:52:51', '2020-01-03 06:52:51', NULL),
(206, 65, '2020-01-03', '2020-01-03 06:52:51', '2020-01-03 06:52:51', NULL),
(207, 66, '2020-01-03', '2020-01-03 06:52:52', '2020-01-03 06:52:52', NULL),
(208, 68, '2020-01-03', '2020-01-03 06:52:52', '2020-01-03 06:52:52', NULL),
(209, 69, '2020-01-03', '2020-01-03 06:52:53', '2020-01-03 06:52:53', NULL),
(210, 70, '2020-01-03', '2020-01-03 06:52:57', '2020-01-03 06:52:57', NULL),
(211, 71, '2020-01-03', '2020-01-03 06:52:58', '2020-01-03 06:52:58', NULL),
(212, 72, '2020-01-03', '2020-01-03 06:52:58', '2020-01-03 06:52:58', NULL),
(213, 74, '2020-01-03', '2020-01-03 06:52:59', '2020-01-03 06:52:59', NULL),
(214, 76, '2020-01-03', '2020-01-03 06:53:00', '2020-01-03 06:53:00', NULL),
(215, 78, '2020-01-03', '2020-01-03 06:53:01', '2020-01-03 06:53:01', NULL),
(216, 79, '2020-01-03', '2020-01-03 06:53:05', '2020-01-03 06:53:05', NULL),
(217, 80, '2020-01-03', '2020-01-03 06:53:06', '2020-01-03 06:53:06', NULL),
(218, 81, '2020-01-03', '2020-01-03 06:53:06', '2020-01-03 06:53:06', NULL),
(219, 82, '2020-01-03', '2020-01-03 06:53:07', '2020-01-03 06:53:07', NULL),
(220, 83, '2020-01-03', '2020-01-03 06:53:07', '2020-01-03 06:53:07', NULL),
(221, 84, '2020-01-03', '2020-01-03 06:53:08', '2020-01-03 06:53:08', NULL),
(222, 85, '2020-01-03', '2020-01-03 06:53:12', '2020-01-03 06:53:12', NULL),
(223, 86, '2020-01-03', '2020-01-03 06:53:12', '2020-01-03 06:53:12', NULL),
(224, 87, '2020-01-03', '2020-01-03 06:53:13', '2020-01-03 06:53:13', NULL),
(225, 88, '2020-01-03', '2020-01-03 06:53:13', '2020-01-03 06:53:13', NULL),
(226, 90, '2020-01-03', '2020-01-03 06:53:14', '2020-01-03 06:53:14', NULL),
(227, 92, '2020-01-03', '2020-01-03 06:53:15', '2020-01-03 06:53:15', NULL),
(228, 93, '2020-01-03', '2020-01-03 06:53:16', '2020-01-03 06:53:16', NULL),
(229, 94, '2020-01-03', '2020-01-03 06:53:16', '2020-01-03 06:53:16', NULL),
(230, 95, '2020-01-03', '2020-01-03 06:53:17', '2020-01-03 06:53:17', NULL),
(231, 97, '2020-01-03', '2020-01-03 06:53:22', '2020-01-03 06:53:22', NULL),
(232, 98, '2020-01-03', '2020-01-03 06:53:22', '2020-01-03 06:53:22', NULL),
(233, 99, '2020-01-03', '2020-01-03 06:53:23', '2020-01-03 06:53:23', NULL),
(234, 101, '2020-01-03', '2020-01-03 06:53:23', '2020-01-03 06:53:23', NULL),
(235, 103, '2020-01-03', '2020-01-03 06:53:24', '2020-01-03 06:53:24', NULL),
(236, 105, '2020-01-03', '2020-01-03 06:53:25', '2020-01-03 06:53:25', NULL),
(237, 107, '2020-01-03', '2020-01-03 06:53:26', '2020-01-03 06:53:26', NULL),
(238, 109, '2020-01-03', '2020-01-03 06:53:27', '2020-01-03 06:53:27', NULL),
(239, 110, '2020-01-03', '2020-01-03 06:53:27', '2020-01-03 06:53:27', NULL),
(333, 52, '2020-01-08', '2020-01-08 20:33:04', '2020-01-08 20:33:04', NULL),
(334, 1, '2020-01-08', '2020-01-08 21:25:36', '2020-01-08 21:25:36', NULL),
(337, 14, '2020-01-09', '2020-01-09 01:26:15', '2020-01-09 01:26:15', NULL),
(338, 1, '2020-01-09', '2020-01-10 15:30:47', '2020-01-10 15:30:47', NULL),
(339, 2, '2020-01-09', '2020-01-10 15:30:48', '2020-01-10 15:30:48', NULL),
(340, 3, '2020-01-09', '2020-01-10 15:35:55', '2020-01-10 15:35:55', NULL),
(342, 1, '2020-01-06', '2020-01-10 18:42:02', '2020-01-10 18:42:02', NULL),
(343, 2, '2020-01-06', '2020-01-10 18:42:07', '2020-01-10 18:42:07', NULL),
(344, 3, '2020-01-06', '2020-01-10 18:42:08', '2020-01-10 18:42:08', NULL),
(345, 4, '2020-01-06', '2020-01-10 18:42:10', '2020-01-10 18:42:10', NULL),
(346, 6, '2020-01-06', '2020-01-10 18:42:14', '2020-01-10 18:42:14', NULL),
(347, 7, '2020-01-06', '2020-01-10 18:42:15', '2020-01-10 18:42:15', NULL),
(348, 8, '2020-01-06', '2020-01-10 18:42:17', '2020-01-10 18:42:17', NULL),
(349, 9, '2020-01-06', '2020-01-10 18:42:18', '2020-01-10 18:42:18', NULL),
(350, 11, '2020-01-06', '2020-01-10 18:42:19', '2020-01-10 18:42:19', NULL),
(351, 12, '2020-01-06', '2020-01-10 18:42:22', '2020-01-10 18:42:22', NULL),
(352, 13, '2020-01-06', '2020-01-10 18:42:23', '2020-01-10 18:42:23', NULL),
(353, 14, '2020-01-06', '2020-01-10 18:42:25', '2020-01-10 18:42:25', NULL),
(354, 16, '2020-01-06', '2020-01-10 18:43:07', '2020-01-10 18:43:07', NULL),
(355, 18, '2020-01-06', '2020-01-10 18:43:08', '2020-01-10 18:43:08', NULL),
(356, 19, '2020-01-06', '2020-01-10 18:43:09', '2020-01-10 18:43:09', NULL),
(357, 20, '2020-01-06', '2020-01-10 18:43:12', '2020-01-10 18:43:12', NULL),
(358, 21, '2020-01-06', '2020-01-10 18:43:14', '2020-01-10 18:43:14', NULL),
(359, 22, '2020-01-06', '2020-01-10 18:43:15', '2020-01-10 18:43:15', NULL),
(360, 23, '2020-01-06', '2020-01-10 18:43:16', '2020-01-10 18:43:16', NULL),
(361, 25, '2020-01-06', '2020-01-10 18:43:18', '2020-01-10 18:43:18', NULL),
(362, 26, '2020-01-06', '2020-01-10 18:43:19', '2020-01-10 18:43:19', NULL),
(363, 27, '2020-01-06', '2020-01-10 18:43:21', '2020-01-10 18:43:21', NULL),
(365, 30, '2020-01-06', '2020-01-10 18:43:26', '2020-01-10 18:43:26', NULL),
(366, 32, '2020-01-06', '2020-01-10 18:43:43', '2020-01-10 18:43:43', NULL),
(367, 33, '2020-01-06', '2020-01-10 18:43:44', '2020-01-10 18:43:44', NULL),
(368, 34, '2020-01-06', '2020-01-10 18:43:46', '2020-01-10 18:43:46', NULL),
(369, 35, '2020-01-06', '2020-01-10 18:43:47', '2020-01-10 18:43:47', NULL),
(370, 37, '2020-01-06', '2020-01-10 18:43:52', '2020-01-10 18:43:52', NULL),
(371, 38, '2020-01-06', '2020-01-10 18:43:55', '2020-01-10 18:43:55', NULL),
(372, 40, '2020-01-06', '2020-01-10 18:43:56', '2020-01-10 18:43:56', NULL),
(373, 41, '2020-01-06', '2020-01-10 18:43:58', '2020-01-10 18:43:58', NULL),
(374, 43, '2020-01-06', '2020-01-10 18:44:16', '2020-01-10 18:44:16', NULL),
(375, 44, '2020-01-06', '2020-01-10 18:44:18', '2020-01-10 18:44:18', NULL),
(376, 45, '2020-01-06', '2020-01-10 18:44:19', '2020-01-10 18:44:19', NULL),
(377, 47, '2020-01-06', '2020-01-10 18:44:22', '2020-01-10 18:44:22', NULL),
(378, 48, '2020-01-06', '2020-01-10 18:44:23', '2020-01-10 18:44:23', NULL),
(379, 49, '2020-01-06', '2020-01-10 18:44:24', '2020-01-10 18:44:24', NULL),
(380, 51, '2020-01-06', '2020-01-10 18:44:25', '2020-01-10 18:44:25', NULL),
(381, 52, '2020-01-06', '2020-01-10 18:44:39', '2020-01-10 18:44:39', NULL),
(382, 53, '2020-01-06', '2020-01-10 18:44:41', '2020-01-10 18:44:41', NULL),
(383, 54, '2020-01-06', '2020-01-10 18:44:43', '2020-01-10 18:44:43', NULL),
(384, 56, '2020-01-06', '2020-01-10 18:44:48', '2020-01-10 18:44:48', NULL),
(385, 57, '2020-01-06', '2020-01-10 18:44:49', '2020-01-10 18:44:49', NULL),
(386, 58, '2020-01-06', '2020-01-10 18:44:51', '2020-01-10 18:44:51', NULL),
(387, 59, '2020-01-06', '2020-01-10 18:44:52', '2020-01-10 18:44:52', NULL),
(388, 60, '2020-01-06', '2020-01-10 18:44:53', '2020-01-10 18:44:53', NULL),
(389, 61, '2020-01-06', '2020-01-10 18:44:54', '2020-01-10 18:44:54', NULL),
(390, 63, '2020-01-06', '2020-01-10 18:45:08', '2020-01-10 18:45:08', NULL),
(391, 64, '2020-01-06', '2020-01-10 18:45:09', '2020-01-10 18:45:09', NULL),
(392, 65, '2020-01-06', '2020-01-10 18:45:10', '2020-01-10 18:45:10', NULL),
(393, 66, '2020-01-06', '2020-01-10 18:45:14', '2020-01-10 18:45:14', NULL),
(394, 68, '2020-01-06', '2020-01-10 18:45:17', '2020-01-10 18:45:17', NULL),
(395, 69, '2020-01-06', '2020-01-10 18:45:18', '2020-01-10 18:45:18', NULL),
(396, 70, '2020-01-06', '2020-01-10 18:45:29', '2020-01-10 18:45:29', NULL),
(397, 71, '2020-01-06', '2020-01-10 18:45:30', '2020-01-10 18:45:30', NULL),
(398, 73, '2020-01-06', '2020-01-10 18:45:32', '2020-01-10 18:45:32', NULL),
(399, 74, '2020-01-06', '2020-01-10 18:45:35', '2020-01-10 18:45:35', NULL),
(400, 75, '2020-01-06', '2020-01-10 18:45:36', '2020-01-10 18:45:36', NULL),
(401, 76, '2020-01-06', '2020-01-10 18:45:37', '2020-01-10 18:45:37', NULL),
(402, 79, '2020-01-06', '2020-01-10 18:45:51', '2020-01-10 18:45:51', NULL),
(403, 80, '2020-01-06', '2020-01-10 18:45:52', '2020-01-10 18:45:52', NULL),
(404, 81, '2020-01-06', '2020-01-10 18:45:53', '2020-01-10 18:45:53', NULL),
(405, 82, '2020-01-06', '2020-01-10 18:45:54', '2020-01-10 18:45:54', NULL),
(406, 84, '2020-01-06', '2020-01-10 18:45:57', '2020-01-10 18:45:57', NULL),
(407, 85, '2020-01-06', '2020-01-10 18:46:07', '2020-01-10 18:46:07', NULL),
(408, 86, '2020-01-06', '2020-01-10 18:46:07', '2020-01-10 18:46:07', NULL),
(409, 88, '2020-01-06', '2020-01-10 18:46:09', '2020-01-10 18:46:09', NULL),
(410, 89, '2020-01-06', '2020-01-10 18:46:12', '2020-01-10 18:46:12', NULL),
(411, 90, '2020-01-06', '2020-01-10 18:46:13', '2020-01-10 18:46:13', NULL),
(412, 91, '2020-01-06', '2020-01-10 18:46:14', '2020-01-10 18:46:14', NULL),
(413, 92, '2020-01-06', '2020-01-10 18:46:15', '2020-01-10 18:46:15', NULL),
(414, 94, '2020-01-06', '2020-01-10 18:46:17', '2020-01-10 18:46:17', NULL),
(415, 95, '2020-01-06', '2020-01-10 18:46:19', '2020-01-10 18:46:19', NULL),
(416, 96, '2020-01-06', '2020-01-10 18:46:20', '2020-01-10 18:46:20', NULL),
(417, 97, '2020-01-06', '2020-01-10 18:46:33', '2020-01-10 18:46:33', NULL),
(418, 98, '2020-01-06', '2020-01-10 18:46:35', '2020-01-10 18:46:35', NULL),
(419, 99, '2020-01-06', '2020-01-10 18:46:36', '2020-01-10 18:46:36', NULL),
(420, 100, '2020-01-06', '2020-01-10 18:46:37', '2020-01-10 18:46:37', NULL),
(421, 103, '2020-01-06', '2020-01-10 18:46:40', '2020-01-10 18:46:40', NULL),
(422, 104, '2020-01-06', '2020-01-10 18:46:41', '2020-01-10 18:46:41', NULL),
(423, 105, '2020-01-06', '2020-01-10 18:46:42', '2020-01-10 18:46:42', NULL),
(424, 107, '2020-01-06', '2020-01-10 18:46:43', '2020-01-10 18:46:43', NULL),
(425, 108, '2020-01-06', '2020-01-10 18:46:45', '2020-01-10 18:46:45', NULL),
(426, 109, '2020-01-06', '2020-01-10 18:46:46', '2020-01-10 18:46:46', NULL),
(427, 110, '2020-01-06', '2020-01-10 18:46:47', '2020-01-10 18:46:47', NULL),
(428, 1, '2020-01-07', '2020-01-10 18:47:23', '2020-01-10 18:47:23', NULL),
(429, 2, '2020-01-07', '2020-01-10 18:47:25', '2020-01-10 18:47:25', NULL),
(430, 4, '2020-01-07', '2020-01-10 18:47:26', '2020-01-10 18:47:26', NULL),
(431, 5, '2020-01-07', '2020-01-10 18:47:29', '2020-01-10 18:47:29', NULL),
(432, 6, '2020-01-07', '2020-01-10 18:47:30', '2020-01-10 18:47:30', NULL),
(433, 7, '2020-01-07', '2020-01-10 18:47:31', '2020-01-10 18:47:31', NULL),
(434, 8, '2020-01-07', '2020-01-10 18:47:32', '2020-01-10 18:47:32', NULL),
(435, 9, '2020-01-07', '2020-01-10 18:47:35', '2020-01-10 18:47:35', NULL),
(436, 10, '2020-01-07', '2020-01-10 18:47:37', '2020-01-10 18:47:37', NULL),
(437, 12, '2020-01-07', '2020-01-10 18:47:39', '2020-01-10 18:47:39', NULL),
(438, 13, '2020-01-07', '2020-01-10 18:47:40', '2020-01-10 18:47:40', NULL),
(439, 14, '2020-01-07', '2020-01-10 18:47:41', '2020-01-10 18:47:41', NULL),
(440, 16, '2020-01-07', '2020-01-10 18:47:57', '2020-01-10 18:47:57', NULL),
(441, 17, '2020-01-07', '2020-01-10 18:47:58', '2020-01-10 18:47:58', NULL),
(442, 18, '2020-01-07', '2020-01-10 18:48:00', '2020-01-10 18:48:00', NULL),
(443, 19, '2020-01-07', '2020-01-10 18:48:04', '2020-01-10 18:48:04', NULL),
(444, 21, '2020-01-07', '2020-01-10 18:48:06', '2020-01-10 18:48:06', NULL),
(445, 22, '2020-01-07', '2020-01-10 18:48:07', '2020-01-10 18:48:07', NULL),
(446, 23, '2020-01-07', '2020-01-10 18:48:08', '2020-01-10 18:48:08', NULL),
(447, 24, '2020-01-07', '2020-01-10 18:48:10', '2020-01-10 18:48:10', NULL),
(448, 26, '2020-01-07', '2020-01-10 18:48:11', '2020-01-10 18:48:11', NULL),
(449, 27, '2020-01-07', '2020-01-10 18:48:13', '2020-01-10 18:48:13', NULL),
(450, 28, '2020-01-07', '2020-01-10 18:48:14', '2020-01-10 18:48:14', NULL),
(451, 29, '2020-01-07', '2020-01-10 18:48:15', '2020-01-10 18:48:15', NULL),
(452, 30, '2020-01-07', '2020-01-10 18:48:16', '2020-01-10 18:48:16', NULL),
(453, 32, '2020-01-07', '2020-01-10 18:48:28', '2020-01-10 18:48:28', NULL),
(454, 33, '2020-01-07', '2020-01-10 18:48:29', '2020-01-10 18:48:29', NULL),
(455, 34, '2020-01-07', '2020-01-10 18:48:30', '2020-01-10 18:48:30', NULL),
(456, 36, '2020-01-07', '2020-01-10 18:48:32', '2020-01-10 18:48:32', NULL),
(457, 37, '2020-01-07', '2020-01-10 18:48:34', '2020-01-10 18:48:34', NULL),
(458, 38, '2020-01-07', '2020-01-10 18:48:35', '2020-01-10 18:48:35', NULL),
(459, 40, '2020-01-07', '2020-01-10 18:48:36', '2020-01-10 18:48:36', NULL),
(460, 41, '2020-01-07', '2020-01-10 18:48:39', '2020-01-10 18:48:39', NULL),
(461, 42, '2020-01-07', '2020-01-10 18:48:47', '2020-01-10 18:48:47', NULL),
(462, 43, '2020-01-07', '2020-01-10 18:48:48', '2020-01-10 18:48:48', NULL),
(463, 44, '2020-01-07', '2020-01-10 18:48:49', '2020-01-10 18:48:49', NULL),
(464, 45, '2020-01-07', '2020-01-10 18:48:50', '2020-01-10 18:48:50', NULL),
(465, 47, '2020-01-07', '2020-01-10 18:48:52', '2020-01-10 18:48:52', NULL),
(466, 48, '2020-01-07', '2020-01-10 18:48:55', '2020-01-10 18:48:55', NULL),
(467, 50, '2020-01-07', '2020-01-10 18:48:56', '2020-01-10 18:48:56', NULL),
(468, 51, '2020-01-07', '2020-01-10 18:48:57', '2020-01-10 18:48:57', NULL),
(469, 52, '2020-01-07', '2020-01-10 18:49:09', '2020-01-10 18:49:09', NULL),
(470, 53, '2020-01-07', '2020-01-10 18:49:09', '2020-01-10 18:49:09', NULL),
(471, 55, '2020-01-07', '2020-01-10 18:49:11', '2020-01-10 18:49:11', NULL),
(472, 56, '2020-01-07', '2020-01-10 18:49:13', '2020-01-10 18:49:13', NULL),
(473, 57, '2020-01-07', '2020-01-10 18:49:15', '2020-01-10 18:49:15', NULL),
(474, 58, '2020-01-07', '2020-01-10 18:49:16', '2020-01-10 18:49:16', NULL),
(475, 60, '2020-01-07', '2020-01-10 18:49:17', '2020-01-10 18:49:17', NULL),
(476, 61, '2020-01-07', '2020-01-10 18:49:18', '2020-01-10 18:49:18', NULL),
(477, 62, '2020-01-07', '2020-01-10 18:49:20', '2020-01-10 18:49:20', NULL),
(478, 63, '2020-01-07', '2020-01-10 18:49:28', '2020-01-10 18:49:28', NULL),
(479, 65, '2020-01-07', '2020-01-10 18:49:30', '2020-01-10 18:49:30', NULL),
(480, 67, '2020-01-07', '2020-01-10 18:49:32', '2020-01-10 18:49:32', NULL),
(481, 68, '2020-01-07', '2020-01-10 18:49:33', '2020-01-10 18:49:33', NULL),
(482, 69, '2020-01-07', '2020-01-10 18:49:34', '2020-01-10 18:49:34', NULL),
(483, 70, '2020-01-07', '2020-01-10 18:49:45', '2020-01-10 18:49:45', NULL),
(484, 71, '2020-01-07', '2020-01-10 18:49:46', '2020-01-10 18:49:46', NULL),
(485, 73, '2020-01-07', '2020-01-10 18:49:48', '2020-01-10 18:49:48', NULL),
(486, 74, '2020-01-07', '2020-01-10 18:49:50', '2020-01-10 18:49:50', NULL),
(487, 75, '2020-01-07', '2020-01-10 18:49:51', '2020-01-10 18:49:51', NULL),
(488, 76, '2020-01-07', '2020-01-10 18:49:52', '2020-01-10 18:49:52', NULL),
(489, 78, '2020-01-07', '2020-01-10 18:49:54', '2020-01-10 18:49:54', NULL),
(490, 79, '2020-01-07', '2020-01-10 18:50:02', '2020-01-10 18:50:02', NULL),
(492, 81, '2020-01-07', '2020-01-10 18:50:05', '2020-01-10 18:50:05', NULL),
(493, 82, '2020-01-07', '2020-01-10 18:50:07', '2020-01-10 18:50:07', NULL),
(494, 84, '2020-01-07', '2020-01-10 18:50:10', '2020-01-10 18:50:10', NULL),
(495, 85, '2020-01-07', '2020-01-10 18:50:19', '2020-01-10 18:50:19', NULL),
(496, 86, '2020-01-07', '2020-01-10 18:50:21', '2020-01-10 18:50:21', NULL),
(497, 87, '2020-01-07', '2020-01-10 18:50:22', '2020-01-10 18:50:22', NULL),
(498, 88, '2020-01-07', '2020-01-10 18:50:23', '2020-01-10 18:50:23', NULL),
(499, 90, '2020-01-07', '2020-01-10 18:50:27', '2020-01-10 18:50:27', NULL),
(500, 91, '2020-01-07', '2020-01-10 18:50:28', '2020-01-10 18:50:28', NULL),
(501, 93, '2020-01-07', '2020-01-10 18:50:30', '2020-01-10 18:50:30', NULL),
(502, 94, '2020-01-07', '2020-01-10 18:50:31', '2020-01-10 18:50:31', NULL),
(503, 95, '2020-01-07', '2020-01-10 18:50:32', '2020-01-10 18:50:32', NULL),
(504, 96, '2020-01-07', '2020-01-10 18:50:33', '2020-01-10 18:50:33', NULL),
(505, 97, '2020-01-07', '2020-01-10 18:50:42', '2020-01-10 18:50:42', NULL),
(506, 99, '2020-01-07', '2020-01-10 18:50:43', '2020-01-10 18:50:43', NULL),
(507, 100, '2020-01-07', '2020-01-10 18:50:44', '2020-01-10 18:50:44', NULL),
(508, 102, '2020-01-07', '2020-01-10 18:50:47', '2020-01-10 18:50:47', NULL),
(509, 103, '2020-01-07', '2020-01-10 18:50:49', '2020-01-10 18:50:49', NULL),
(510, 104, '2020-01-07', '2020-01-10 18:50:50', '2020-01-10 18:50:50', NULL),
(511, 105, '2020-01-07', '2020-01-10 18:50:51', '2020-01-10 18:50:51', NULL),
(512, 107, '2020-01-07', '2020-01-10 18:50:52', '2020-01-10 18:50:52', NULL),
(513, 108, '2020-01-07', '2020-01-10 18:50:53', '2020-01-10 18:50:53', NULL),
(514, 110, '2020-01-07', '2020-01-10 18:50:54', '2020-01-10 18:50:54', NULL),
(515, 3, '2020-01-08', '2020-01-10 18:51:24', '2020-01-10 18:51:24', NULL),
(516, 4, '2020-01-08', '2020-01-10 18:51:25', '2020-01-10 18:51:25', NULL),
(517, 5, '2020-01-08', '2020-01-10 18:51:29', '2020-01-10 18:51:29', NULL),
(518, 6, '2020-01-08', '2020-01-10 18:51:29', '2020-01-10 18:51:29', NULL),
(519, 7, '2020-01-08', '2020-01-10 18:51:30', '2020-01-10 18:51:30', NULL),
(520, 9, '2020-01-08', '2020-01-10 18:51:31', '2020-01-10 18:51:31', NULL),
(521, 10, '2020-01-08', '2020-01-10 18:51:33', '2020-01-10 18:51:33', NULL),
(522, 11, '2020-01-08', '2020-01-10 18:51:34', '2020-01-10 18:51:34', NULL),
(523, 13, '2020-01-08', '2020-01-10 18:51:36', '2020-01-10 18:51:36', NULL),
(524, 14, '2020-01-08', '2020-01-10 18:51:37', '2020-01-10 18:51:37', NULL),
(525, 15, '2020-01-08', '2020-01-10 18:51:38', '2020-01-10 18:51:38', NULL),
(526, 32, '2020-01-08', '2020-01-10 18:52:29', '2020-01-10 18:52:29', NULL),
(527, 33, '2020-01-08', '2020-01-10 18:52:30', '2020-01-10 18:52:30', NULL),
(528, 34, '2020-01-08', '2020-01-10 18:52:31', '2020-01-10 18:52:31', NULL),
(529, 37, '2020-01-08', '2020-01-10 18:52:34', '2020-01-10 18:52:34', NULL),
(530, 38, '2020-01-08', '2020-01-10 18:52:36', '2020-01-10 18:52:36', NULL),
(531, 40, '2020-01-08', '2020-01-10 18:52:37', '2020-01-10 18:52:37', NULL),
(532, 41, '2020-01-08', '2020-01-10 18:52:37', '2020-01-10 18:52:37', NULL),
(533, 42, '2020-01-08', '2020-01-10 18:54:13', '2020-01-10 18:54:13', NULL),
(534, 43, '2020-01-08', '2020-01-10 18:54:14', '2020-01-10 18:54:14', NULL),
(535, 45, '2020-01-08', '2020-01-10 18:54:15', '2020-01-10 18:54:15', NULL),
(536, 46, '2020-01-08', '2020-01-10 18:54:17', '2020-01-10 18:54:17', NULL),
(537, 48, '2020-01-08', '2020-01-10 18:54:18', '2020-01-10 18:54:18', NULL),
(538, 49, '2020-01-08', '2020-01-10 18:54:20', '2020-01-10 18:54:20', NULL),
(539, 50, '2020-01-08', '2020-01-10 18:54:21', '2020-01-10 18:54:21', NULL),
(540, 53, '2020-01-08', '2020-01-10 18:54:34', '2020-01-10 18:54:34', NULL),
(541, 55, '2020-01-08', '2020-01-10 18:54:36', '2020-01-10 18:54:36', NULL),
(542, 56, '2020-01-08', '2020-01-10 18:54:38', '2020-01-10 18:54:38', NULL),
(543, 57, '2020-01-08', '2020-01-10 18:54:39', '2020-01-10 18:54:39', NULL),
(544, 58, '2020-01-08', '2020-01-10 18:54:40', '2020-01-10 18:54:40', NULL),
(545, 60, '2020-01-08', '2020-01-10 18:54:42', '2020-01-10 18:54:42', NULL),
(546, 61, '2020-01-08', '2020-01-10 18:54:43', '2020-01-10 18:54:43', NULL),
(547, 62, '2020-01-08', '2020-01-10 18:54:44', '2020-01-10 18:54:44', NULL),
(548, 63, '2020-01-08', '2020-01-10 18:55:01', '2020-01-10 18:55:01', NULL),
(549, 64, '2020-01-08', '2020-01-10 18:55:02', '2020-01-10 18:55:02', NULL),
(550, 66, '2020-01-08', '2020-01-10 18:55:04', '2020-01-10 18:55:04', NULL),
(551, 68, '2020-01-08', '2020-01-10 18:55:07', '2020-01-10 18:55:07', NULL),
(552, 69, '2020-01-08', '2020-01-10 18:55:08', '2020-01-10 18:55:08', NULL),
(553, 70, '2020-01-08', '2020-01-10 18:55:24', '2020-01-10 18:55:24', NULL),
(554, 71, '2020-01-08', '2020-01-10 18:55:25', '2020-01-10 18:55:25', NULL),
(555, 73, '2020-01-08', '2020-01-10 18:55:28', '2020-01-10 18:55:28', NULL),
(556, 74, '2020-01-08', '2020-01-10 18:55:31', '2020-01-10 18:55:31', NULL),
(557, 75, '2020-01-08', '2020-01-10 18:55:32', '2020-01-10 18:55:32', NULL),
(558, 76, '2020-01-08', '2020-01-10 18:55:33', '2020-01-10 18:55:33', NULL),
(559, 78, '2020-01-08', '2020-01-10 18:55:34', '2020-01-10 18:55:34', NULL),
(560, 79, '2020-01-08', '2020-01-10 18:55:57', '2020-01-10 18:55:57', NULL),
(561, 81, '2020-01-08', '2020-01-10 18:55:58', '2020-01-10 18:55:58', NULL),
(562, 82, '2020-01-08', '2020-01-10 18:55:59', '2020-01-10 18:55:59', NULL),
(563, 84, '2020-01-08', '2020-01-10 18:56:05', '2020-01-10 18:56:05', NULL),
(564, 85, '2020-01-08', '2020-01-10 18:56:32', '2020-01-10 18:56:32', NULL),
(565, 86, '2020-01-08', '2020-01-10 18:56:33', '2020-01-10 18:56:33', NULL),
(566, 88, '2020-01-08', '2020-01-10 18:56:35', '2020-01-10 18:56:35', NULL),
(567, 89, '2020-01-08', '2020-01-10 18:56:38', '2020-01-10 18:56:38', NULL),
(568, 90, '2020-01-08', '2020-01-10 18:56:39', '2020-01-10 18:56:39', NULL),
(569, 91, '2020-01-08', '2020-01-10 18:56:40', '2020-01-10 18:56:40', NULL),
(570, 93, '2020-01-08', '2020-01-10 18:56:41', '2020-01-10 18:56:41', NULL),
(571, 94, '2020-01-08', '2020-01-10 18:56:42', '2020-01-10 18:56:42', NULL),
(572, 95, '2020-01-08', '2020-01-10 18:56:42', '2020-01-10 18:56:42', NULL),
(573, 96, '2020-01-08', '2020-01-10 18:56:43', '2020-01-10 18:56:43', NULL),
(574, 97, '2020-01-08', '2020-01-10 18:57:00', '2020-01-10 18:57:00', NULL),
(575, 98, '2020-01-08', '2020-01-10 18:57:01', '2020-01-10 18:57:01', NULL),
(576, 99, '2020-01-08', '2020-01-10 18:57:03', '2020-01-10 18:57:03', NULL),
(577, 101, '2020-01-08', '2020-01-10 18:57:09', '2020-01-10 18:57:09', NULL),
(578, 102, '2020-01-08', '2020-01-10 18:57:10', '2020-01-10 18:57:10', NULL),
(579, 103, '2020-01-08', '2020-01-10 18:57:11', '2020-01-10 18:57:11', NULL),
(580, 105, '2020-01-08', '2020-01-10 18:57:12', '2020-01-10 18:57:12', NULL),
(581, 106, '2020-01-08', '2020-01-10 18:57:13', '2020-01-10 18:57:13', NULL),
(582, 107, '2020-01-08', '2020-01-10 18:57:15', '2020-01-10 18:57:15', NULL),
(583, 108, '2020-01-08', '2020-01-10 18:57:17', '2020-01-10 18:57:17', NULL),
(584, 110, '2020-01-08', '2020-01-10 18:57:19', '2020-01-10 18:57:19', NULL),
(585, 5, '2020-01-09', '2020-01-10 18:57:54', '2020-01-10 18:57:54', NULL),
(586, 6, '2020-01-09', '2020-01-10 18:57:55', '2020-01-10 18:57:55', NULL),
(587, 7, '2020-01-09', '2020-01-10 18:57:57', '2020-01-10 18:57:57', NULL),
(588, 9, '2020-01-09', '2020-01-10 18:57:58', '2020-01-10 18:57:58', NULL),
(589, 10, '2020-01-09', '2020-01-10 18:57:59', '2020-01-10 18:57:59', NULL),
(590, 11, '2020-01-09', '2020-01-10 18:58:03', '2020-01-10 18:58:03', NULL),
(591, 12, '2020-01-09', '2020-01-10 18:58:04', '2020-01-10 18:58:04', NULL),
(592, 16, '2020-01-09', '2020-01-10 18:58:19', '2020-01-10 18:58:19', NULL),
(593, 17, '2020-01-09', '2020-01-10 18:58:20', '2020-01-10 18:58:20', NULL),
(594, 19, '2020-01-09', '2020-01-10 18:58:22', '2020-01-10 18:58:22', NULL),
(595, 20, '2020-01-09', '2020-01-10 18:58:25', '2020-01-10 18:58:25', NULL),
(596, 21, '2020-01-09', '2020-01-10 18:58:27', '2020-01-10 18:58:27', NULL),
(597, 22, '2020-01-09', '2020-01-10 18:58:28', '2020-01-10 18:58:28', NULL),
(598, 23, '2020-01-09', '2020-01-10 18:58:29', '2020-01-10 18:58:29', NULL),
(599, 25, '2020-01-09', '2020-01-10 18:58:31', '2020-01-10 18:58:31', NULL),
(600, 26, '2020-01-09', '2020-01-10 18:58:32', '2020-01-10 18:58:32', NULL),
(601, 27, '2020-01-09', '2020-01-10 18:58:33', '2020-01-10 18:58:33', NULL),
(602, 28, '2020-01-09', '2020-01-10 18:58:34', '2020-01-10 18:58:34', NULL),
(603, 29, '2020-01-09', '2020-01-10 18:58:35', '2020-01-10 18:58:35', NULL),
(604, 31, '2020-01-09', '2020-01-10 18:58:37', '2020-01-10 18:58:37', NULL),
(605, 32, '2020-01-09', '2020-01-10 18:58:48', '2020-01-10 18:58:48', NULL),
(606, 33, '2020-01-09', '2020-01-10 18:58:49', '2020-01-10 18:58:49', NULL),
(607, 35, '2020-01-09', '2020-01-10 18:58:51', '2020-01-10 18:58:51', NULL),
(608, 36, '2020-01-09', '2020-01-10 18:58:53', '2020-01-10 18:58:53', NULL),
(609, 37, '2020-01-09', '2020-01-10 18:58:55', '2020-01-10 18:58:55', NULL),
(610, 38, '2020-01-09', '2020-01-10 18:58:56', '2020-01-10 18:58:56', NULL),
(611, 40, '2020-01-09', '2020-01-10 18:58:58', '2020-01-10 18:58:58', NULL),
(612, 41, '2020-01-09', '2020-01-10 18:58:59', '2020-01-10 18:58:59', NULL),
(613, 42, '2020-01-09', '2020-01-10 18:59:22', '2020-01-10 18:59:22', NULL),
(614, 43, '2020-01-09', '2020-01-10 18:59:22', '2020-01-10 18:59:22', NULL),
(615, 45, '2020-01-09', '2020-01-10 18:59:24', '2020-01-10 18:59:24', NULL),
(616, 46, '2020-01-09', '2020-01-10 18:59:27', '2020-01-10 18:59:27', NULL),
(617, 47, '2020-01-09', '2020-01-10 18:59:29', '2020-01-10 18:59:29', NULL),
(618, 48, '2020-01-09', '2020-01-10 18:59:30', '2020-01-10 18:59:30', NULL),
(619, 50, '2020-01-09', '2020-01-10 18:59:31', '2020-01-10 18:59:31', NULL),
(620, 51, '2020-01-09', '2020-01-10 18:59:32', '2020-01-10 18:59:32', NULL),
(621, 52, '2020-01-09', '2020-01-10 18:59:40', '2020-01-10 18:59:40', NULL),
(622, 53, '2020-01-09', '2020-01-10 18:59:41', '2020-01-10 18:59:41', NULL),
(623, 54, '2020-01-09', '2020-01-10 18:59:42', '2020-01-10 18:59:42', NULL),
(624, 55, '2020-01-09', '2020-01-10 18:59:44', '2020-01-10 18:59:44', NULL),
(625, 57, '2020-01-09', '2020-01-10 18:59:47', '2020-01-10 18:59:47', NULL),
(626, 58, '2020-01-09', '2020-01-10 18:59:49', '2020-01-10 18:59:49', NULL),
(627, 59, '2020-01-09', '2020-01-10 18:59:50', '2020-01-10 18:59:50', NULL),
(628, 61, '2020-01-09', '2020-01-10 18:59:51', '2020-01-10 18:59:51', NULL),
(629, 62, '2020-01-09', '2020-01-10 18:59:52', '2020-01-10 18:59:52', NULL),
(630, 63, '2020-01-09', '2020-01-10 19:01:08', '2020-01-10 19:01:08', NULL),
(631, 64, '2020-01-09', '2020-01-10 19:01:09', '2020-01-10 19:01:09', NULL),
(632, 65, '2020-01-09', '2020-01-10 19:01:10', '2020-01-10 19:01:10', NULL),
(633, 67, '2020-01-09', '2020-01-10 19:01:13', '2020-01-10 19:01:13', NULL),
(634, 68, '2020-01-09', '2020-01-10 19:01:14', '2020-01-10 19:01:14', NULL),
(635, 69, '2020-01-09', '2020-01-10 19:01:16', '2020-01-10 19:01:16', NULL),
(636, 70, '2020-01-09', '2020-01-10 19:01:33', '2020-01-10 19:01:33', NULL),
(637, 71, '2020-01-09', '2020-01-10 19:01:34', '2020-01-10 19:01:34', NULL),
(638, 72, '2020-01-09', '2020-01-10 19:01:35', '2020-01-10 19:01:35', NULL),
(639, 73, '2020-01-09', '2020-01-10 19:01:36', '2020-01-10 19:01:36', NULL),
(640, 75, '2020-01-09', '2020-01-10 19:01:39', '2020-01-10 19:01:39', NULL),
(641, 76, '2020-01-09', '2020-01-10 19:01:40', '2020-01-10 19:01:40', NULL),
(642, 78, '2020-01-09', '2020-01-10 19:01:41', '2020-01-10 19:01:41', NULL),
(643, 79, '2020-01-09', '2020-01-10 19:01:56', '2020-01-10 19:01:56', NULL),
(645, 80, '2020-01-09', '2020-01-10 19:01:58', '2020-01-10 19:01:58', NULL),
(646, 81, '2020-01-09', '2020-01-10 19:01:59', '2020-01-10 19:01:59', NULL),
(647, 83, '2020-01-09', '2020-01-10 19:02:02', '2020-01-10 19:02:02', NULL),
(648, 85, '2020-01-09', '2020-01-10 19:02:29', '2020-01-10 19:02:29', NULL),
(649, 87, '2020-01-09', '2020-01-10 19:02:31', '2020-01-10 19:02:31', NULL),
(650, 88, '2020-01-09', '2020-01-10 19:02:32', '2020-01-10 19:02:32', NULL),
(651, 89, '2020-01-09', '2020-01-10 19:02:34', '2020-01-10 19:02:34', NULL),
(652, 90, '2020-01-09', '2020-01-10 19:02:36', '2020-01-10 19:02:36', NULL),
(653, 92, '2020-01-09', '2020-01-10 19:02:38', '2020-01-10 19:02:38', NULL),
(654, 93, '2020-01-09', '2020-01-10 19:02:39', '2020-01-10 19:02:39', NULL),
(655, 94, '2020-01-09', '2020-01-10 19:02:40', '2020-01-10 19:02:40', NULL),
(656, 96, '2020-01-09', '2020-01-10 19:02:41', '2020-01-10 19:02:41', NULL),
(657, 98, '2020-01-09', '2020-01-10 19:02:51', '2020-01-10 19:02:51', NULL),
(658, 100, '2020-01-09', '2020-01-10 19:02:53', '2020-01-10 19:02:53', NULL),
(659, 101, '2020-01-09', '2020-01-10 19:02:56', '2020-01-10 19:02:56', NULL),
(660, 102, '2020-01-09', '2020-01-10 19:02:57', '2020-01-10 19:02:57', NULL),
(661, 103, '2020-01-09', '2020-01-10 19:02:58', '2020-01-10 19:02:58', NULL),
(662, 104, '2020-01-09', '2020-01-10 19:02:59', '2020-01-10 19:02:59', NULL),
(663, 105, '2020-01-09', '2020-01-10 19:03:00', '2020-01-10 19:03:00', NULL),
(664, 107, '2020-01-09', '2020-01-10 19:03:01', '2020-01-10 19:03:01', NULL),
(665, 108, '2020-01-09', '2020-01-10 19:03:04', '2020-01-10 19:03:04', NULL),
(666, 109, '2020-01-09', '2020-01-10 19:03:05', '2020-01-10 19:03:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_has_class`
--

CREATE TABLE `student_has_class` (
  `id` int(3) NOT NULL,
  `student_id` int(6) NOT NULL,
  `class_id` int(3) NOT NULL,
  `index_no` int(2) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_has_class`
--

INSERT INTO `student_has_class` (`id`, `student_id`, `class_id`, `index_no`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 1, 1, 1, '2019-12-14 14:15:29', '2020-01-10 23:19:33', NULL),
(2, 2, 1, 2, '2019-12-14 15:54:45', '2019-12-14 15:54:45', NULL),
(3, 3, 1, 3, '2019-12-14 16:01:15', '2019-12-14 16:01:15', NULL),
(4, 4, 1, 4, '2019-12-14 16:08:06', '2019-12-14 16:08:06', NULL),
(5, 5, 1, 5, '2019-12-14 16:18:38', '2019-12-14 16:18:38', NULL),
(6, 6, 1, 6, '2019-12-14 16:25:04', '2019-12-14 16:25:04', NULL),
(7, 7, 1, 7, '2019-12-14 16:32:37', '2019-12-14 16:32:37', NULL),
(8, 8, 1, 8, '2019-12-14 16:39:32', '2019-12-14 16:39:32', NULL),
(9, 9, 1, 9, '2019-12-14 16:45:57', '2019-12-14 16:45:57', NULL),
(10, 10, 1, 10, '2019-12-14 16:55:02', '2019-12-14 16:55:02', NULL),
(11, 11, 1, 11, '2019-12-14 17:02:24', '2019-12-14 17:02:24', NULL),
(12, 12, 1, 12, '2019-12-14 17:08:08', '2019-12-14 17:08:08', NULL),
(13, 13, 1, 13, '2019-12-14 17:15:17', '2019-12-14 17:15:17', NULL),
(14, 14, 1, 14, '2019-12-14 17:21:38', '2019-12-14 17:21:38', NULL),
(15, 15, 1, 15, '2019-12-14 17:28:10', '2019-12-14 17:28:10', NULL),
(16, 16, 2, 1, '2019-12-14 21:49:11', '2019-12-14 21:49:11', NULL),
(17, 17, 2, 2, '2019-12-14 21:54:13', '2019-12-14 21:54:13', NULL),
(18, 18, 2, 3, '2019-12-14 21:59:41', '2019-12-14 21:59:41', NULL),
(19, 19, 2, 4, '2019-12-14 22:04:43', '2019-12-14 22:04:43', NULL),
(20, 20, 2, 5, '2019-12-14 22:10:28', '2019-12-14 22:10:28', NULL),
(21, 21, 2, 6, '2019-12-14 22:16:53', '2019-12-14 22:16:53', NULL),
(22, 22, 2, 7, '2019-12-14 22:24:23', '2019-12-14 22:24:23', NULL),
(23, 23, 2, 8, '2019-12-14 22:32:29', '2019-12-14 22:32:29', NULL),
(24, 24, 2, 9, '2019-12-15 08:27:49', '2019-12-15 08:27:49', NULL),
(25, 25, 2, 10, '2019-12-15 08:33:11', '2019-12-15 08:33:11', NULL),
(26, 26, 2, 11, '2019-12-15 08:38:02', '2019-12-15 08:38:02', NULL),
(27, 27, 2, 12, '2019-12-15 08:43:10', '2019-12-15 08:43:10', NULL),
(28, 28, 2, 13, '2019-12-15 08:48:21', '2019-12-15 08:48:21', NULL),
(29, 29, 2, 14, '2019-12-15 08:48:23', '2019-12-15 08:48:23', NULL),
(30, 30, 2, 15, '2019-12-15 08:53:28', '2019-12-15 08:53:28', NULL),
(31, 31, 2, 16, '2019-12-15 08:58:05', '2019-12-15 08:58:05', NULL),
(32, 32, 3, 1, '2019-12-15 09:43:05', '2019-12-15 09:43:05', NULL),
(33, 33, 3, 2, '2019-12-15 11:45:38', '2019-12-15 11:45:38', NULL),
(34, 34, 3, 3, '2019-12-15 11:50:07', '2019-12-15 11:50:07', NULL),
(35, 35, 3, 4, '2019-12-15 12:13:05', '2019-12-15 12:13:05', NULL),
(36, 36, 3, 5, '2019-12-15 12:27:43', '2019-12-15 12:27:43', NULL),
(37, 37, 3, 6, '2019-12-15 12:33:00', '2019-12-15 12:33:00', NULL),
(38, 38, 3, 7, '2019-12-15 12:37:33', '2019-12-15 12:37:33', NULL),
(39, 39, 3, 8, '2019-12-15 12:41:58', '2019-12-15 12:41:58', NULL),
(40, 40, 3, 9, '2019-12-15 12:46:16', '2019-12-15 12:46:16', NULL),
(41, 41, 3, 10, '2019-12-15 12:51:23', '2019-12-15 12:51:23', NULL),
(42, 42, 4, 1, '2019-12-15 14:53:33', '2019-12-15 14:53:33', NULL),
(43, 43, 4, 2, '2019-12-15 14:58:51', '2019-12-15 14:58:51', NULL),
(44, 44, 4, 3, '2019-12-15 15:07:31', '2019-12-15 15:07:31', NULL),
(45, 45, 4, 4, '2019-12-15 16:06:44', '2019-12-15 16:06:44', NULL),
(46, 46, 4, 5, '2019-12-15 16:11:16', '2019-12-15 16:11:16', NULL),
(47, 47, 4, 6, '2019-12-15 16:16:06', '2019-12-15 16:16:06', NULL),
(48, 48, 4, 7, '2019-12-15 17:34:02', '2019-12-15 17:34:02', NULL),
(49, 49, 4, 8, '2019-12-15 17:38:14', '2019-12-15 17:38:14', NULL),
(50, 50, 4, 9, '2019-12-15 17:42:38', '2019-12-15 17:42:38', NULL),
(51, 51, 4, 10, '2019-12-15 17:47:10', '2019-12-15 17:47:10', NULL),
(52, 52, 5, 1, '2019-12-15 19:59:13', '2019-12-15 19:59:13', NULL),
(53, 53, 5, 2, '2019-12-15 20:03:35', '2019-12-15 20:03:35', NULL),
(54, 54, 5, 3, '2019-12-15 20:15:56', '2019-12-15 20:15:56', NULL),
(55, 55, 5, 4, '2019-12-15 20:21:11', '2019-12-15 20:21:11', NULL),
(56, 56, 5, 5, '2019-12-15 20:25:40', '2019-12-15 20:25:40', NULL),
(57, 57, 5, 6, '2019-12-15 20:30:14', '2019-12-15 20:30:14', NULL),
(58, 58, 5, 7, '2019-12-15 20:35:11', '2019-12-15 20:35:11', NULL),
(59, 59, 5, 8, '2019-12-15 20:40:08', '2019-12-15 20:40:08', NULL),
(60, 60, 5, 9, '2019-12-15 20:44:16', '2019-12-15 20:44:16', NULL),
(61, 61, 5, 10, '2019-12-15 20:48:08', '2019-12-15 20:48:08', NULL),
(62, 62, 5, 11, '2019-12-18 20:03:02', '2019-12-18 20:03:02', NULL),
(63, 63, 6, 1, '2019-12-18 20:08:00', '2019-12-18 20:08:00', NULL),
(64, 64, 6, 2, '2019-12-18 20:15:31', '2019-12-18 20:15:31', NULL),
(65, 65, 6, 3, '2019-12-18 20:41:44', '2019-12-18 20:41:44', NULL),
(66, 66, 6, 4, '2019-12-18 20:47:33', '2019-12-18 20:47:33', NULL),
(67, 67, 6, 5, '2019-12-19 21:07:31', '2019-12-19 21:07:31', NULL),
(68, 68, 6, 6, '2019-12-19 21:12:07', '2019-12-19 21:12:07', NULL),
(69, 69, 6, 7, '2019-12-19 21:17:25', '2019-12-19 21:17:25', NULL),
(70, 70, 7, 1, '2019-12-22 17:32:02', '2019-12-22 17:32:02', NULL),
(71, 71, 7, 2, '2019-12-22 18:11:59', '2019-12-22 18:11:59', NULL),
(72, 72, 7, 3, '2019-12-22 18:18:07', '2019-12-22 18:18:07', NULL),
(73, 73, 7, 4, '2019-12-22 18:23:18', '2019-12-22 18:23:18', NULL),
(74, 74, 7, 5, '2019-12-22 18:30:11', '2019-12-22 18:30:11', NULL),
(75, 75, 7, 6, '2019-12-22 18:56:55', '2019-12-22 18:56:55', NULL),
(76, 76, 7, 7, '2019-12-22 19:01:29', '2019-12-22 19:01:29', NULL),
(77, 77, 7, 8, '2019-12-22 19:06:26', '2019-12-22 19:06:26', NULL),
(78, 78, 7, 9, '2019-12-22 19:23:49', '2019-12-22 19:23:49', NULL),
(79, 79, 8, 1, '2019-12-22 20:26:12', '2019-12-22 20:26:12', NULL),
(80, 80, 8, 2, '2019-12-22 20:30:11', '2019-12-22 20:30:11', NULL),
(81, 81, 8, 3, '2019-12-22 20:34:46', '2019-12-22 20:34:46', NULL),
(82, 82, 8, 4, '2019-12-22 21:01:06', '2019-12-22 21:01:06', NULL),
(83, 83, 8, 5, '2019-12-22 21:07:50', '2019-12-22 21:07:50', NULL),
(84, 84, 8, 6, '2019-12-22 21:12:24', '2019-12-22 21:12:24', NULL),
(85, 85, 9, 1, '2019-12-26 19:11:42', '2019-12-26 19:11:42', NULL),
(86, 86, 9, 2, '2019-12-26 19:16:41', '2019-12-26 19:16:41', NULL),
(87, 87, 9, 3, '2019-12-26 19:21:51', '2019-12-26 19:21:51', NULL),
(88, 88, 9, 4, '2019-12-26 19:25:40', '2019-12-26 19:25:40', NULL),
(89, 89, 9, 5, '2019-12-26 19:41:32', '2019-12-26 19:41:32', NULL),
(90, 90, 9, 6, '2019-12-26 19:46:58', '2019-12-26 19:46:58', NULL),
(91, 91, 9, 7, '2019-12-26 19:51:06', '2019-12-26 19:51:06', NULL),
(92, 92, 9, 8, '2019-12-26 19:55:08', '2019-12-26 19:55:08', NULL),
(93, 93, 9, 9, '2019-12-26 19:59:00', '2019-12-26 19:59:00', NULL),
(94, 94, 9, 10, '2019-12-26 20:02:26', '2019-12-26 20:02:26', NULL),
(95, 95, 9, 11, '2019-12-26 20:06:27', '2019-12-26 20:06:27', NULL),
(96, 96, 9, 12, '2019-12-26 20:10:11', '2019-12-26 20:10:11', NULL),
(97, 97, 10, 1, '2019-12-29 10:55:58', '2019-12-29 10:55:58', NULL),
(98, 98, 10, 2, '2019-12-29 10:59:58', '2019-12-29 10:59:58', NULL),
(99, 99, 10, 3, '2019-12-29 11:03:06', '2019-12-29 11:03:06', NULL),
(100, 100, 10, 4, '2019-12-29 11:06:52', '2019-12-29 11:06:52', NULL),
(101, 101, 10, 5, '2019-12-29 11:10:35', '2019-12-29 11:10:35', NULL),
(102, 102, 10, 6, '2019-12-29 11:14:28', '2019-12-29 11:14:28', NULL),
(103, 103, 10, 7, '2019-12-29 11:18:21', '2019-12-29 11:18:21', NULL),
(104, 104, 10, 8, '2019-12-29 11:22:29', '2019-12-29 11:22:29', NULL),
(105, 105, 10, 9, '2019-12-29 11:26:53', '2019-12-29 11:26:53', NULL),
(106, 106, 10, 10, '2019-12-29 11:30:45', '2019-12-29 11:30:45', NULL),
(107, 107, 10, 11, '2019-12-29 11:34:11', '2019-12-29 11:34:11', NULL),
(108, 108, 10, 12, '2019-12-29 11:37:52', '2019-12-29 11:37:52', NULL),
(109, 109, 10, 13, '2019-12-29 11:41:20', '2019-12-29 11:41:20', NULL),
(110, 110, 10, 14, '2019-12-29 11:44:57', '2019-12-29 11:44:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_has_exam_schedule`
--

CREATE TABLE `student_has_exam_schedule` (
  `id` int(8) NOT NULL,
  `student_id` int(6) NOT NULL,
  `exam_schedule_id` int(4) NOT NULL,
  `marks` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_has_exam_schedule`
--

INSERT INTO `student_has_exam_schedule` (`id`, `student_id`, `exam_schedule_id`, `marks`, `created_on`, `updated_on`, `deleted_on`) VALUES
(2, 1, 2, NULL, '2020-01-10 22:43:43', '2020-01-10 22:43:43', NULL),
(3, 2, 2, NULL, '2020-01-10 22:43:43', '2020-01-10 22:43:43', NULL),
(4, 3, 2, NULL, '2020-01-10 22:43:43', '2020-01-10 22:43:43', NULL),
(5, 4, 2, NULL, '2020-01-10 22:43:43', '2020-01-10 22:43:43', NULL),
(6, 5, 2, NULL, '2020-01-10 22:43:43', '2020-01-10 22:43:43', NULL),
(7, 6, 2, NULL, '2020-01-10 22:43:43', '2020-01-10 22:43:43', NULL),
(8, 7, 2, NULL, '2020-01-10 22:43:43', '2020-01-10 22:43:43', NULL),
(9, 8, 2, NULL, '2020-01-10 22:43:43', '2020-01-10 22:43:43', NULL),
(10, 9, 2, NULL, '2020-01-10 22:43:43', '2020-01-10 22:43:43', NULL),
(11, 10, 2, NULL, '2020-01-10 22:43:43', '2020-01-10 22:43:43', NULL),
(12, 11, 2, NULL, '2020-01-10 22:43:43', '2020-01-10 22:43:43', NULL),
(13, 12, 2, NULL, '2020-01-10 22:43:43', '2020-01-10 22:43:43', NULL),
(14, 13, 2, NULL, '2020-01-10 22:43:43', '2020-01-10 22:43:43', NULL),
(15, 14, 2, NULL, '2020-01-10 22:43:43', '2020-01-10 22:43:43', NULL),
(16, 15, 2, NULL, '2020-01-10 22:43:43', '2020-01-10 22:43:43', NULL),
(17, 1, 3, NULL, '2020-01-10 22:45:03', '2020-01-10 22:45:03', NULL),
(18, 2, 3, NULL, '2020-01-10 22:45:03', '2020-01-10 22:45:03', NULL),
(19, 3, 3, NULL, '2020-01-10 22:45:03', '2020-01-10 22:45:03', NULL),
(20, 4, 3, NULL, '2020-01-10 22:45:03', '2020-01-10 22:45:03', NULL),
(21, 5, 3, NULL, '2020-01-10 22:45:03', '2020-01-10 22:45:03', NULL),
(22, 6, 3, NULL, '2020-01-10 22:45:03', '2020-01-10 22:45:03', NULL),
(23, 7, 3, NULL, '2020-01-10 22:45:03', '2020-01-10 22:45:03', NULL),
(24, 8, 3, NULL, '2020-01-10 22:45:03', '2020-01-10 22:45:03', NULL),
(25, 9, 3, NULL, '2020-01-10 22:45:03', '2020-01-10 22:45:03', NULL),
(26, 10, 3, NULL, '2020-01-10 22:45:03', '2020-01-10 22:45:03', NULL),
(27, 11, 3, NULL, '2020-01-10 22:45:03', '2020-01-10 22:45:03', NULL),
(28, 12, 3, NULL, '2020-01-10 22:45:03', '2020-01-10 22:45:03', NULL),
(29, 13, 3, NULL, '2020-01-10 22:45:03', '2020-01-10 22:45:03', NULL),
(30, 14, 3, NULL, '2020-01-10 22:45:03', '2020-01-10 22:45:03', NULL),
(31, 15, 3, NULL, '2020-01-10 22:45:03', '2020-01-10 22:45:03', NULL),
(32, 1, 4, NULL, '2020-01-10 22:45:56', '2020-01-10 22:45:56', NULL),
(33, 2, 4, NULL, '2020-01-10 22:45:56', '2020-01-10 22:45:56', NULL),
(34, 3, 4, NULL, '2020-01-10 22:45:56', '2020-01-10 22:45:56', NULL),
(35, 4, 4, NULL, '2020-01-10 22:45:56', '2020-01-10 22:45:56', NULL),
(36, 5, 4, NULL, '2020-01-10 22:45:56', '2020-01-10 22:45:56', NULL),
(37, 6, 4, NULL, '2020-01-10 22:45:56', '2020-01-10 22:45:56', NULL),
(38, 7, 4, NULL, '2020-01-10 22:45:56', '2020-01-10 22:45:56', NULL),
(39, 8, 4, NULL, '2020-01-10 22:45:56', '2020-01-10 22:45:56', NULL),
(40, 9, 4, NULL, '2020-01-10 22:45:56', '2020-01-10 22:45:56', NULL),
(41, 10, 4, NULL, '2020-01-10 22:45:56', '2020-01-10 22:45:56', NULL),
(42, 11, 4, NULL, '2020-01-10 22:45:56', '2020-01-10 22:45:56', NULL),
(43, 12, 4, NULL, '2020-01-10 22:45:56', '2020-01-10 22:45:56', NULL),
(44, 13, 4, NULL, '2020-01-10 22:45:56', '2020-01-10 22:45:56', NULL),
(45, 14, 4, NULL, '2020-01-10 22:45:56', '2020-01-10 22:45:56', NULL),
(46, 15, 4, NULL, '2020-01-10 22:45:56', '2020-01-10 22:45:56', NULL),
(47, 1, 5, NULL, '2020-01-10 22:47:48', '2020-01-10 22:47:48', NULL),
(48, 2, 5, NULL, '2020-01-10 22:47:48', '2020-01-10 22:47:48', NULL),
(49, 3, 5, NULL, '2020-01-10 22:47:48', '2020-01-10 22:47:48', NULL),
(50, 4, 5, NULL, '2020-01-10 22:47:48', '2020-01-10 22:47:48', NULL),
(51, 5, 5, NULL, '2020-01-10 22:47:48', '2020-01-10 22:47:48', NULL),
(52, 6, 5, NULL, '2020-01-10 22:47:48', '2020-01-10 22:47:48', NULL),
(53, 7, 5, NULL, '2020-01-10 22:47:48', '2020-01-10 22:47:48', NULL),
(54, 8, 5, NULL, '2020-01-10 22:47:48', '2020-01-10 22:47:48', NULL),
(55, 9, 5, NULL, '2020-01-10 22:47:48', '2020-01-10 22:47:48', NULL),
(56, 10, 5, NULL, '2020-01-10 22:47:48', '2020-01-10 22:47:48', NULL),
(57, 11, 5, NULL, '2020-01-10 22:47:48', '2020-01-10 22:47:48', NULL),
(58, 12, 5, NULL, '2020-01-10 22:47:48', '2020-01-10 22:47:48', NULL),
(59, 13, 5, NULL, '2020-01-10 22:47:48', '2020-01-10 22:47:48', NULL),
(60, 14, 5, NULL, '2020-01-10 22:47:48', '2020-01-10 22:47:48', NULL),
(61, 15, 5, NULL, '2020-01-10 22:47:48', '2020-01-10 22:47:48', NULL),
(62, 1, 6, NULL, '2020-01-10 22:51:30', '2020-01-10 22:51:30', NULL),
(63, 2, 6, NULL, '2020-01-10 22:51:30', '2020-01-10 22:51:30', NULL),
(64, 3, 6, NULL, '2020-01-10 22:51:30', '2020-01-10 22:51:30', NULL),
(65, 4, 6, NULL, '2020-01-10 22:51:30', '2020-01-10 22:51:30', NULL),
(66, 5, 6, NULL, '2020-01-10 22:51:30', '2020-01-10 22:51:30', NULL),
(67, 6, 6, NULL, '2020-01-10 22:51:30', '2020-01-10 22:51:30', NULL),
(68, 7, 6, NULL, '2020-01-10 22:51:30', '2020-01-10 22:51:30', NULL),
(69, 8, 6, NULL, '2020-01-10 22:51:30', '2020-01-10 22:51:30', NULL),
(70, 9, 6, NULL, '2020-01-10 22:51:30', '2020-01-10 22:51:30', NULL),
(71, 10, 6, NULL, '2020-01-10 22:51:30', '2020-01-10 22:51:30', NULL),
(72, 11, 6, NULL, '2020-01-10 22:51:30', '2020-01-10 22:51:30', NULL),
(73, 12, 6, NULL, '2020-01-10 22:51:30', '2020-01-10 22:51:30', NULL),
(74, 13, 6, NULL, '2020-01-10 22:51:30', '2020-01-10 22:51:30', NULL),
(75, 14, 6, NULL, '2020-01-10 22:51:30', '2020-01-10 22:51:30', NULL),
(76, 15, 6, NULL, '2020-01-10 22:51:30', '2020-01-10 22:51:30', NULL),
(77, 1, 7, NULL, '2020-01-10 22:52:22', '2020-01-10 22:52:22', NULL),
(78, 2, 7, NULL, '2020-01-10 22:52:22', '2020-01-10 22:52:22', NULL),
(79, 3, 7, NULL, '2020-01-10 22:52:22', '2020-01-10 22:52:22', NULL),
(80, 4, 7, NULL, '2020-01-10 22:52:22', '2020-01-10 22:52:22', NULL),
(81, 5, 7, NULL, '2020-01-10 22:52:22', '2020-01-10 22:52:22', NULL),
(82, 6, 7, NULL, '2020-01-10 22:52:22', '2020-01-10 22:52:22', NULL),
(83, 7, 7, NULL, '2020-01-10 22:52:22', '2020-01-10 22:52:22', NULL),
(84, 8, 7, NULL, '2020-01-10 22:52:22', '2020-01-10 22:52:22', NULL),
(85, 9, 7, NULL, '2020-01-10 22:52:22', '2020-01-10 22:52:22', NULL),
(86, 10, 7, NULL, '2020-01-10 22:52:22', '2020-01-10 22:52:22', NULL),
(87, 11, 7, NULL, '2020-01-10 22:52:22', '2020-01-10 22:52:22', NULL),
(88, 12, 7, NULL, '2020-01-10 22:52:22', '2020-01-10 22:52:22', NULL),
(89, 13, 7, NULL, '2020-01-10 22:52:22', '2020-01-10 22:52:22', NULL),
(90, 14, 7, NULL, '2020-01-10 22:52:22', '2020-01-10 22:52:22', NULL),
(91, 15, 7, NULL, '2020-01-10 22:52:22', '2020-01-10 22:52:22', NULL),
(92, 1, 8, NULL, '2020-01-10 22:53:23', '2020-01-10 22:53:23', NULL),
(93, 2, 8, NULL, '2020-01-10 22:53:23', '2020-01-10 22:53:23', NULL),
(94, 3, 8, NULL, '2020-01-10 22:53:23', '2020-01-10 22:53:23', NULL),
(95, 4, 8, NULL, '2020-01-10 22:53:23', '2020-01-10 22:53:23', NULL),
(96, 5, 8, NULL, '2020-01-10 22:53:23', '2020-01-10 22:53:23', NULL),
(97, 6, 8, NULL, '2020-01-10 22:53:23', '2020-01-10 22:53:23', NULL),
(98, 7, 8, NULL, '2020-01-10 22:53:23', '2020-01-10 22:53:23', NULL),
(99, 8, 8, NULL, '2020-01-10 22:53:23', '2020-01-10 22:53:23', NULL),
(100, 9, 8, NULL, '2020-01-10 22:53:23', '2020-01-10 22:53:23', NULL),
(101, 10, 8, NULL, '2020-01-10 22:53:23', '2020-01-10 22:53:23', NULL),
(102, 11, 8, NULL, '2020-01-10 22:53:23', '2020-01-10 22:53:23', NULL),
(103, 12, 8, NULL, '2020-01-10 22:53:23', '2020-01-10 22:53:23', NULL),
(104, 13, 8, NULL, '2020-01-10 22:53:23', '2020-01-10 22:53:23', NULL),
(105, 14, 8, NULL, '2020-01-10 22:53:23', '2020-01-10 22:53:23', NULL),
(106, 15, 8, NULL, '2020-01-10 22:53:23', '2020-01-10 22:53:23', NULL),
(108, 32, 10, NULL, '2020-01-10 22:54:48', '2020-01-10 22:54:48', NULL),
(109, 33, 10, NULL, '2020-01-10 22:54:48', '2020-01-10 22:54:48', NULL),
(110, 34, 10, NULL, '2020-01-10 22:54:48', '2020-01-10 22:54:48', NULL),
(111, 35, 10, NULL, '2020-01-10 22:54:48', '2020-01-10 22:54:48', NULL),
(112, 36, 10, NULL, '2020-01-10 22:54:48', '2020-01-10 22:54:48', NULL),
(113, 37, 10, NULL, '2020-01-10 22:54:48', '2020-01-10 22:54:48', NULL),
(114, 38, 10, NULL, '2020-01-10 22:54:48', '2020-01-10 22:54:48', NULL),
(115, 39, 10, NULL, '2020-01-10 22:54:48', '2020-01-10 22:54:48', NULL),
(116, 40, 10, NULL, '2020-01-10 22:54:48', '2020-01-10 22:54:48', NULL),
(117, 41, 10, NULL, '2020-01-10 22:54:48', '2020-01-10 22:54:48', NULL),
(118, 32, 11, NULL, '2020-01-10 22:55:49', '2020-01-10 22:55:49', NULL),
(119, 33, 11, NULL, '2020-01-10 22:55:49', '2020-01-10 22:55:49', NULL),
(120, 34, 11, NULL, '2020-01-10 22:55:49', '2020-01-10 22:55:49', NULL),
(121, 35, 11, NULL, '2020-01-10 22:55:49', '2020-01-10 22:55:49', NULL),
(122, 36, 11, NULL, '2020-01-10 22:55:49', '2020-01-10 22:55:49', NULL),
(123, 37, 11, NULL, '2020-01-10 22:55:49', '2020-01-10 22:55:49', NULL),
(124, 38, 11, NULL, '2020-01-10 22:55:49', '2020-01-10 22:55:49', NULL),
(125, 39, 11, NULL, '2020-01-10 22:55:49', '2020-01-10 22:55:49', NULL),
(126, 40, 11, NULL, '2020-01-10 22:55:49', '2020-01-10 22:55:49', NULL),
(127, 41, 11, NULL, '2020-01-10 22:55:49', '2020-01-10 22:55:49', NULL),
(128, 32, 12, NULL, '2020-01-10 22:56:32', '2020-01-10 22:56:32', NULL),
(129, 33, 12, NULL, '2020-01-10 22:56:32', '2020-01-10 22:56:32', NULL),
(130, 34, 12, NULL, '2020-01-10 22:56:32', '2020-01-10 22:56:32', NULL),
(131, 35, 12, NULL, '2020-01-10 22:56:32', '2020-01-10 22:56:32', NULL),
(132, 36, 12, NULL, '2020-01-10 22:56:32', '2020-01-10 22:56:32', NULL),
(133, 37, 12, NULL, '2020-01-10 22:56:32', '2020-01-10 22:56:32', NULL),
(134, 38, 12, NULL, '2020-01-10 22:56:32', '2020-01-10 22:56:32', NULL),
(135, 39, 12, NULL, '2020-01-10 22:56:32', '2020-01-10 22:56:32', NULL),
(136, 40, 12, NULL, '2020-01-10 22:56:32', '2020-01-10 22:56:32', NULL),
(137, 41, 12, NULL, '2020-01-10 22:56:32', '2020-01-10 22:56:32', NULL),
(138, 32, 13, NULL, '2020-01-10 22:58:23', '2020-01-10 22:58:23', NULL),
(139, 33, 13, NULL, '2020-01-10 22:58:23', '2020-01-10 22:58:23', NULL),
(140, 34, 13, NULL, '2020-01-10 22:58:23', '2020-01-10 22:58:23', NULL),
(141, 35, 13, NULL, '2020-01-10 22:58:23', '2020-01-10 22:58:23', NULL),
(142, 36, 13, NULL, '2020-01-10 22:58:23', '2020-01-10 22:58:23', NULL),
(143, 37, 13, NULL, '2020-01-10 22:58:23', '2020-01-10 22:58:23', NULL),
(144, 38, 13, NULL, '2020-01-10 22:58:23', '2020-01-10 22:58:23', NULL),
(145, 39, 13, NULL, '2020-01-10 22:58:23', '2020-01-10 22:58:23', NULL),
(146, 40, 13, NULL, '2020-01-10 22:58:23', '2020-01-10 22:58:23', NULL),
(147, 41, 13, NULL, '2020-01-10 22:58:23', '2020-01-10 22:58:23', NULL),
(148, 1, 14, NULL, '2020-01-10 22:59:58', '2020-01-10 22:59:58', NULL),
(149, 2, 14, NULL, '2020-01-10 22:59:58', '2020-01-10 22:59:58', NULL),
(150, 3, 14, NULL, '2020-01-10 22:59:58', '2020-01-10 22:59:58', NULL),
(151, 4, 14, NULL, '2020-01-10 22:59:58', '2020-01-10 22:59:58', NULL),
(152, 5, 14, NULL, '2020-01-10 22:59:58', '2020-01-10 22:59:58', NULL),
(153, 6, 14, NULL, '2020-01-10 22:59:58', '2020-01-10 22:59:58', NULL),
(154, 7, 14, NULL, '2020-01-10 22:59:58', '2020-01-10 22:59:58', NULL),
(155, 8, 14, NULL, '2020-01-10 22:59:58', '2020-01-10 22:59:58', NULL),
(156, 9, 14, NULL, '2020-01-10 22:59:58', '2020-01-10 22:59:58', NULL),
(157, 10, 14, NULL, '2020-01-10 22:59:58', '2020-01-10 22:59:58', NULL),
(158, 11, 14, NULL, '2020-01-10 22:59:58', '2020-01-10 22:59:58', NULL),
(159, 12, 14, NULL, '2020-01-10 22:59:58', '2020-01-10 22:59:58', NULL),
(160, 13, 14, NULL, '2020-01-10 22:59:58', '2020-01-10 22:59:58', NULL),
(161, 14, 14, NULL, '2020-01-10 22:59:58', '2020-01-10 22:59:58', NULL),
(162, 15, 14, NULL, '2020-01-10 22:59:58', '2020-01-10 22:59:58', NULL),
(163, 32, 15, NULL, '2020-01-10 23:03:40', '2020-01-10 23:03:40', NULL),
(164, 33, 15, NULL, '2020-01-10 23:03:40', '2020-01-10 23:03:40', NULL),
(165, 34, 15, NULL, '2020-01-10 23:03:40', '2020-01-10 23:03:40', NULL),
(166, 35, 15, NULL, '2020-01-10 23:03:40', '2020-01-10 23:03:40', NULL),
(167, 36, 15, NULL, '2020-01-10 23:03:40', '2020-01-10 23:03:40', NULL),
(168, 37, 15, NULL, '2020-01-10 23:03:40', '2020-01-10 23:03:40', NULL),
(169, 38, 15, NULL, '2020-01-10 23:03:40', '2020-01-10 23:03:40', NULL),
(170, 39, 15, NULL, '2020-01-10 23:03:40', '2020-01-10 23:03:40', NULL),
(171, 40, 15, NULL, '2020-01-10 23:03:40', '2020-01-10 23:03:40', NULL),
(172, 41, 15, NULL, '2020-01-10 23:03:40', '2020-01-10 23:03:40', NULL),
(173, 32, 16, NULL, '2020-01-10 23:07:47', '2020-01-10 23:07:47', NULL),
(174, 33, 16, NULL, '2020-01-10 23:07:47', '2020-01-10 23:07:47', NULL),
(175, 34, 16, NULL, '2020-01-10 23:07:47', '2020-01-10 23:07:47', NULL),
(176, 35, 16, NULL, '2020-01-10 23:07:47', '2020-01-10 23:07:47', NULL),
(177, 36, 16, NULL, '2020-01-10 23:07:47', '2020-01-10 23:07:47', NULL),
(178, 37, 16, NULL, '2020-01-10 23:07:47', '2020-01-10 23:07:47', NULL),
(179, 38, 16, NULL, '2020-01-10 23:07:47', '2020-01-10 23:07:47', NULL),
(180, 39, 16, NULL, '2020-01-10 23:07:47', '2020-01-10 23:07:47', NULL),
(181, 40, 16, NULL, '2020-01-10 23:07:47', '2020-01-10 23:07:47', NULL),
(182, 41, 16, NULL, '2020-01-10 23:07:47', '2020-01-10 23:07:47', NULL),
(183, 32, 17, NULL, '2020-01-10 23:08:28', '2020-01-10 23:08:28', NULL),
(184, 33, 17, NULL, '2020-01-10 23:08:28', '2020-01-10 23:08:28', NULL),
(185, 34, 17, NULL, '2020-01-10 23:08:28', '2020-01-10 23:08:28', NULL),
(186, 35, 17, NULL, '2020-01-10 23:08:28', '2020-01-10 23:08:28', NULL),
(187, 36, 17, NULL, '2020-01-10 23:08:28', '2020-01-10 23:08:28', NULL),
(188, 37, 17, NULL, '2020-01-10 23:08:28', '2020-01-10 23:08:28', NULL),
(189, 38, 17, NULL, '2020-01-10 23:08:28', '2020-01-10 23:08:28', NULL),
(190, 39, 17, NULL, '2020-01-10 23:08:28', '2020-01-10 23:08:28', NULL),
(191, 40, 17, NULL, '2020-01-10 23:08:28', '2020-01-10 23:08:28', NULL),
(192, 41, 17, NULL, '2020-01-10 23:08:28', '2020-01-10 23:08:28', NULL),
(193, 32, 18, NULL, '2020-01-10 23:09:02', '2020-01-10 23:09:02', NULL),
(194, 33, 18, NULL, '2020-01-10 23:09:02', '2020-01-10 23:09:02', NULL),
(195, 34, 18, NULL, '2020-01-10 23:09:02', '2020-01-10 23:09:02', NULL),
(196, 35, 18, NULL, '2020-01-10 23:09:02', '2020-01-10 23:09:02', NULL),
(197, 36, 18, NULL, '2020-01-10 23:09:02', '2020-01-10 23:09:02', NULL),
(198, 37, 18, NULL, '2020-01-10 23:09:02', '2020-01-10 23:09:02', NULL),
(199, 38, 18, NULL, '2020-01-10 23:09:02', '2020-01-10 23:09:02', NULL),
(200, 39, 18, NULL, '2020-01-10 23:09:02', '2020-01-10 23:09:02', NULL),
(201, 40, 18, NULL, '2020-01-10 23:09:02', '2020-01-10 23:09:02', NULL),
(202, 41, 18, NULL, '2020-01-10 23:09:02', '2020-01-10 23:09:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_has_parent`
--

CREATE TABLE `student_has_parent` (
  `id` int(8) NOT NULL,
  `student_id` int(6) NOT NULL,
  `parent_id` int(7) NOT NULL,
  `relation_id` int(2) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_has_parent`
--

INSERT INTO `student_has_parent` (`id`, `student_id`, `parent_id`, `relation_id`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 1, 1, 1, '2019-12-14 14:15:29', '2019-12-14 14:15:29', NULL),
(2, 2, 2, 1, '2019-12-14 15:54:45', '2019-12-14 15:54:45', NULL),
(3, 3, 3, 1, '2019-12-14 16:01:15', '2019-12-14 16:01:15', NULL),
(4, 4, 4, 1, '2019-12-14 16:08:06', '2019-12-14 16:08:06', NULL),
(5, 5, 4, 1, '2019-12-14 16:18:38', '2019-12-14 16:18:38', NULL),
(6, 6, 5, 2, '2019-12-14 16:25:04', '2019-12-14 16:25:04', NULL),
(7, 7, 6, 1, '2019-12-14 16:32:37', '2019-12-14 16:32:37', NULL),
(8, 8, 7, 1, '2019-12-14 16:39:32', '2019-12-14 16:39:32', NULL),
(9, 9, 8, 2, '2019-12-14 16:45:57', '2019-12-14 16:45:57', NULL),
(10, 10, 9, 1, '2019-12-14 16:55:02', '2019-12-14 16:55:02', NULL),
(11, 11, 10, 2, '2019-12-14 17:02:24', '2019-12-14 17:02:24', NULL),
(12, 12, 11, 1, '2019-12-14 17:08:08', '2019-12-14 17:08:08', NULL),
(13, 13, 12, 1, '2019-12-14 17:15:17', '2019-12-14 17:15:17', NULL),
(14, 14, 13, 1, '2019-12-14 17:21:38', '2019-12-14 17:21:38', NULL),
(15, 15, 14, 1, '2019-12-14 17:28:10', '2019-12-14 17:28:10', NULL),
(16, 16, 15, 1, '2019-12-14 21:49:11', '2019-12-14 21:49:11', NULL),
(17, 17, 16, 2, '2019-12-14 21:54:13', '2019-12-14 21:54:13', NULL),
(18, 18, 17, 1, '2019-12-14 21:59:41', '2019-12-14 21:59:41', NULL),
(19, 19, 18, 1, '2019-12-14 22:04:43', '2019-12-14 22:04:43', NULL),
(20, 20, 19, 1, '2019-12-14 22:10:28', '2019-12-14 22:10:28', NULL),
(21, 21, 20, 1, '2019-12-14 22:16:53', '2019-12-14 22:16:53', NULL),
(22, 22, 21, 2, '2019-12-14 22:24:23', '2019-12-14 22:24:23', NULL),
(23, 23, 22, 1, '2019-12-14 22:32:29', '2019-12-14 22:32:29', NULL),
(24, 24, 23, 1, '2019-12-15 08:27:49', '2019-12-15 08:27:49', NULL),
(25, 25, 24, 1, '2019-12-15 08:33:11', '2019-12-15 08:33:11', NULL),
(26, 26, 25, 1, '2019-12-15 08:38:02', '2019-12-15 08:38:02', NULL),
(27, 27, 26, 1, '2019-12-15 08:43:10', '2019-12-15 08:43:10', NULL),
(28, 28, 27, 1, '2019-12-15 08:48:21', '2019-12-15 08:48:21', NULL),
(29, 29, 27, 1, '2019-12-15 08:48:23', '2019-12-15 08:48:23', NULL),
(30, 30, 28, 1, '2019-12-15 08:53:28', '2019-12-15 08:53:28', NULL),
(31, 31, 29, 2, '2019-12-15 08:58:05', '2019-12-15 08:58:05', NULL),
(32, 32, 30, 1, '2019-12-15 09:43:05', '2019-12-15 09:43:05', NULL),
(33, 33, 31, 1, '2019-12-15 11:45:38', '2019-12-15 11:45:38', NULL),
(34, 34, 32, 1, '2019-12-15 11:50:07', '2019-12-15 11:50:07', NULL),
(35, 35, 33, 2, '2019-12-15 12:13:05', '2019-12-15 12:13:05', NULL),
(36, 36, 34, 1, '2019-12-15 12:27:43', '2019-12-15 12:27:43', NULL),
(37, 37, 35, 1, '2019-12-15 12:33:00', '2019-12-15 12:33:00', NULL),
(38, 38, 36, 1, '2019-12-15 12:37:33', '2019-12-15 12:37:33', NULL),
(39, 39, 37, 2, '2019-12-15 12:41:58', '2019-12-15 12:41:58', NULL),
(40, 40, 38, 1, '2019-12-15 12:46:16', '2019-12-15 12:46:16', NULL),
(41, 41, 39, 1, '2019-12-15 12:51:23', '2019-12-15 12:51:23', NULL),
(42, 42, 40, 1, '2019-12-15 14:53:33', '2019-12-15 14:53:33', NULL),
(43, 43, 41, 1, '2019-12-15 14:58:51', '2019-12-15 14:58:51', NULL),
(44, 44, 42, 1, '2019-12-15 15:07:31', '2019-12-15 15:07:31', NULL),
(45, 45, 43, 2, '2019-12-15 16:06:44', '2019-12-15 16:06:44', NULL),
(46, 46, 44, 1, '2019-12-15 16:11:16', '2019-12-15 16:11:16', NULL),
(47, 47, 45, 1, '2019-12-15 16:16:06', '2019-12-15 16:16:06', NULL),
(48, 48, 46, 1, '2019-12-15 17:34:02', '2019-12-15 17:34:02', NULL),
(49, 49, 47, 2, '2019-12-15 17:38:14', '2019-12-15 17:38:14', NULL),
(50, 50, 48, 1, '2019-12-15 17:42:38', '2019-12-15 17:42:38', NULL),
(51, 51, 49, 2, '2019-12-15 17:47:10', '2019-12-15 17:47:10', NULL),
(52, 52, 50, 1, '2019-12-15 19:59:13', '2019-12-15 19:59:13', NULL),
(53, 53, 51, 1, '2019-12-15 20:03:35', '2019-12-15 20:03:35', NULL),
(54, 54, 52, 1, '2019-12-15 20:15:56', '2019-12-15 20:15:56', NULL),
(55, 55, 53, 1, '2019-12-15 20:21:11', '2019-12-15 20:21:11', NULL),
(56, 56, 54, 1, '2019-12-15 20:25:40', '2019-12-15 20:25:40', NULL),
(57, 57, 55, 2, '2019-12-15 20:30:14', '2019-12-15 20:30:14', NULL),
(58, 58, 56, 1, '2019-12-15 20:35:11', '2019-12-15 20:35:11', NULL),
(59, 59, 57, 1, '2019-12-15 20:40:08', '2019-12-15 20:40:08', NULL),
(60, 60, 58, 1, '2019-12-15 20:44:16', '2019-12-15 20:44:16', NULL),
(61, 61, 59, 2, '2019-12-15 20:48:08', '2019-12-15 20:48:08', NULL),
(62, 62, 60, 1, '2019-12-18 20:03:02', '2019-12-18 20:03:02', NULL),
(63, 63, 61, 1, '2019-12-18 20:08:00', '2019-12-18 20:08:00', NULL),
(64, 64, 62, 2, '2019-12-18 20:15:31', '2019-12-18 20:15:31', NULL),
(65, 65, 63, 1, '2019-12-18 20:41:44', '2019-12-18 20:41:44', NULL),
(66, 66, 64, 1, '2019-12-18 20:47:33', '2019-12-18 20:47:33', NULL),
(67, 67, 65, 1, '2019-12-19 21:07:31', '2019-12-19 21:07:31', NULL),
(68, 68, 66, 1, '2019-12-19 21:12:07', '2019-12-19 21:12:07', NULL),
(69, 69, 67, 2, '2019-12-19 21:17:25', '2019-12-19 21:17:25', NULL),
(70, 70, 68, 1, '2019-12-22 17:32:02', '2019-12-22 17:32:02', NULL),
(71, 71, 69, 1, '2019-12-22 18:11:59', '2019-12-22 18:11:59', NULL),
(72, 72, 70, 2, '2019-12-22 18:18:07', '2019-12-22 18:18:07', NULL),
(73, 73, 71, 1, '2019-12-22 18:23:18', '2019-12-22 18:23:18', NULL),
(74, 74, 72, 1, '2019-12-22 18:30:11', '2019-12-22 18:30:11', NULL),
(75, 75, 73, 1, '2019-12-22 18:56:55', '2019-12-22 18:56:55', NULL),
(76, 76, 74, 1, '2019-12-22 19:01:29', '2019-12-22 19:01:29', NULL),
(77, 77, 75, 1, '2019-12-22 19:06:26', '2019-12-22 19:06:26', NULL),
(78, 78, 76, 1, '2019-12-22 19:23:49', '2019-12-22 19:23:49', NULL),
(79, 79, 77, 1, '2019-12-22 20:26:12', '2019-12-22 20:26:12', NULL),
(80, 80, 78, 1, '2019-12-22 20:30:11', '2019-12-22 20:30:11', NULL),
(81, 81, 79, 1, '2019-12-22 20:34:46', '2019-12-22 20:34:46', NULL),
(82, 82, 80, 1, '2019-12-22 21:01:06', '2019-12-22 21:01:06', NULL),
(83, 83, 81, 1, '2019-12-22 21:07:50', '2019-12-22 21:07:50', NULL),
(84, 84, 82, 1, '2019-12-22 21:12:24', '2019-12-22 21:12:24', NULL),
(85, 85, 83, 1, '2019-12-26 19:11:42', '2019-12-26 19:11:42', NULL),
(86, 86, 84, 1, '2019-12-26 19:16:41', '2019-12-26 19:16:41', NULL),
(87, 87, 85, 1, '2019-12-26 19:21:51', '2019-12-26 19:21:51', NULL),
(88, 88, 86, 2, '2019-12-26 19:25:40', '2019-12-26 19:25:40', NULL),
(89, 89, 87, 1, '2019-12-26 19:41:32', '2019-12-26 19:41:32', NULL),
(90, 90, 88, 1, '2019-12-26 19:46:58', '2019-12-26 19:46:58', NULL),
(91, 91, 89, 1, '2019-12-26 19:51:06', '2019-12-26 19:51:06', NULL),
(92, 92, 90, 1, '2019-12-26 19:55:08', '2019-12-26 19:55:08', NULL),
(93, 93, 91, 2, '2019-12-26 19:59:00', '2019-12-26 19:59:00', NULL),
(94, 94, 92, 1, '2019-12-26 20:02:26', '2019-12-26 20:02:26', NULL),
(95, 95, 93, 1, '2019-12-26 20:06:27', '2019-12-26 20:06:27', NULL),
(96, 96, 94, 1, '2019-12-26 20:10:11', '2019-12-26 20:10:11', NULL),
(97, 97, 95, 1, '2019-12-29 10:55:58', '2019-12-29 10:55:58', NULL),
(98, 98, 96, 1, '2019-12-29 10:59:58', '2019-12-29 10:59:58', NULL),
(99, 99, 97, 1, '2019-12-29 11:03:06', '2019-12-29 11:03:06', NULL),
(100, 100, 98, 1, '2019-12-29 11:06:52', '2019-12-29 11:06:52', NULL),
(101, 101, 99, 1, '2019-12-29 11:10:35', '2019-12-29 11:10:35', NULL),
(102, 102, 100, 1, '2019-12-29 11:14:28', '2019-12-29 11:14:28', NULL),
(103, 103, 100, 1, '2019-12-29 11:18:21', '2019-12-29 11:18:21', NULL),
(104, 104, 101, 1, '2019-12-29 11:22:29', '2019-12-29 11:22:29', NULL),
(105, 105, 102, 1, '2019-12-29 11:26:53', '2019-12-29 11:26:53', NULL),
(106, 106, 103, 2, '2019-12-29 11:30:45', '2019-12-29 11:30:45', NULL),
(107, 107, 104, 1, '2019-12-29 11:34:11', '2019-12-29 11:34:11', NULL),
(108, 108, 105, 2, '2019-12-29 11:37:52', '2019-12-29 11:37:52', NULL),
(109, 109, 106, 1, '2019-12-29 11:41:20', '2019-12-29 11:41:20', NULL),
(110, 110, 107, 1, '2019-12-29 11:44:57', '2019-12-29 11:44:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_has_sport`
--

CREATE TABLE `student_has_sport` (
  `id` int(8) NOT NULL,
  `student_id` int(6) NOT NULL,
  `sport_id` int(3) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_has_sport`
--

INSERT INTO `student_has_sport` (`id`, `student_id`, `sport_id`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 1, 2, '2020-01-10 22:39:48', '2020-01-10 22:39:48', NULL),
(2, 1, 5, '2020-01-10 22:39:48', '2020-01-10 22:39:48', NULL),
(3, 2, 7, '2020-01-10 22:39:55', '2020-01-10 22:39:55', NULL),
(4, 2, 5, '2020-01-10 22:39:55', '2020-01-10 22:39:55', NULL),
(5, 3, 1, '2020-01-10 23:06:22', '2020-01-10 23:06:22', NULL),
(6, 3, 3, '2020-01-10 23:06:22', '2020-01-10 23:06:22', NULL),
(7, 4, 4, '2020-01-10 23:06:28', '2020-01-10 23:06:28', NULL),
(8, 4, 6, '2020-01-10 23:06:28', '2020-01-10 23:06:28', NULL),
(9, 5, 8, '2020-01-10 23:06:35', '2020-01-10 23:06:35', NULL),
(10, 5, 6, '2020-01-10 23:06:35', '2020-01-10 23:06:35', NULL),
(11, 6, 7, '2020-01-10 23:06:42', '2020-01-10 23:06:42', NULL),
(12, 6, 3, '2020-01-10 23:06:42', '2020-01-10 23:06:42', NULL),
(13, 7, 8, '2020-01-10 23:06:48', '2020-01-10 23:06:48', NULL),
(14, 8, 4, '2020-01-10 23:06:54', '2020-01-10 23:06:54', NULL),
(15, 9, 2, '2020-01-10 23:06:59', '2020-01-10 23:06:59', NULL),
(16, 10, 5, '2020-01-10 23:07:06', '2020-01-10 23:07:06', NULL),
(17, 11, 3, '2020-01-10 23:07:12', '2020-01-10 23:07:12', NULL),
(18, 12, 5, '2020-01-10 23:07:24', '2020-01-10 23:07:24', NULL),
(19, 12, 3, '2020-01-10 23:07:24', '2020-01-10 23:07:24', NULL),
(20, 13, 8, '2020-01-10 23:12:01', '2020-01-10 23:12:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_has_sport_achievement`
--

CREATE TABLE `student_has_sport_achievement` (
  `id` int(11) NOT NULL,
  `student_sport_id` int(8) NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT 'NULL',
  `achieved_on` date NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_has_subject`
--

CREATE TABLE `student_has_subject` (
  `id` int(8) NOT NULL,
  `student_id` int(6) NOT NULL,
  `subject_id` int(3) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_has_subject`
--

INSERT INTO `student_has_subject` (`id`, `student_id`, `subject_id`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 1, 1, '2020-01-10 22:32:54', '2020-01-10 22:32:54', NULL),
(2, 2, 1, '2020-01-10 22:32:54', '2020-01-10 22:32:54', NULL),
(3, 3, 1, '2020-01-10 22:32:54', '2020-01-10 22:32:54', NULL),
(4, 4, 1, '2020-01-10 22:32:54', '2020-01-10 22:32:54', NULL),
(5, 5, 1, '2020-01-10 22:32:54', '2020-01-10 22:32:54', NULL),
(6, 6, 1, '2020-01-10 22:32:54', '2020-01-10 22:32:54', NULL),
(7, 7, 1, '2020-01-10 22:32:54', '2020-01-10 22:32:54', NULL),
(8, 8, 1, '2020-01-10 22:32:54', '2020-01-10 22:32:54', NULL),
(9, 9, 1, '2020-01-10 22:32:54', '2020-01-10 22:32:54', NULL),
(10, 10, 1, '2020-01-10 22:32:54', '2020-01-10 22:32:54', NULL),
(11, 11, 1, '2020-01-10 22:32:54', '2020-01-10 22:32:54', NULL),
(12, 12, 1, '2020-01-10 22:32:54', '2020-01-10 22:32:54', NULL),
(13, 13, 1, '2020-01-10 22:32:54', '2020-01-10 22:32:54', NULL),
(14, 14, 1, '2020-01-10 22:32:54', '2020-01-10 22:32:54', NULL),
(15, 15, 1, '2020-01-10 22:32:54', '2020-01-10 22:32:54', NULL),
(16, 1, 5, '2020-01-10 23:11:01', '2020-01-10 23:11:01', NULL),
(17, 2, 5, '2020-01-10 23:11:01', '2020-01-10 23:11:01', NULL),
(18, 3, 5, '2020-01-10 23:11:01', '2020-01-10 23:11:01', NULL),
(19, 4, 5, '2020-01-10 23:11:01', '2020-01-10 23:11:01', NULL),
(20, 5, 5, '2020-01-10 23:11:01', '2020-01-10 23:11:01', NULL),
(21, 6, 5, '2020-01-10 23:11:01', '2020-01-10 23:11:01', NULL),
(22, 7, 5, '2020-01-10 23:11:01', '2020-01-10 23:11:01', NULL),
(23, 8, 5, '2020-01-10 23:11:01', '2020-01-10 23:11:01', NULL),
(24, 9, 5, '2020-01-10 23:11:01', '2020-01-10 23:11:01', NULL),
(25, 10, 5, '2020-01-10 23:11:01', '2020-01-10 23:11:01', NULL),
(26, 11, 5, '2020-01-10 23:11:01', '2020-01-10 23:11:01', NULL),
(27, 12, 5, '2020-01-10 23:11:01', '2020-01-10 23:11:01', NULL),
(28, 13, 5, '2020-01-10 23:11:01', '2020-01-10 23:11:01', NULL),
(29, 14, 5, '2020-01-10 23:11:01', '2020-01-10 23:11:01', NULL),
(30, 15, 5, '2020-01-10 23:11:01', '2020-01-10 23:11:01', NULL),
(31, 1, 8, '2020-01-10 23:12:29', '2020-01-10 23:12:29', NULL),
(32, 2, 8, '2020-01-10 23:12:29', '2020-01-10 23:12:29', NULL),
(33, 3, 8, '2020-01-10 23:12:29', '2020-01-10 23:12:29', NULL),
(34, 4, 8, '2020-01-10 23:12:29', '2020-01-10 23:12:29', NULL),
(35, 5, 8, '2020-01-10 23:12:29', '2020-01-10 23:12:29', NULL),
(36, 6, 8, '2020-01-10 23:12:29', '2020-01-10 23:12:29', NULL),
(37, 7, 8, '2020-01-10 23:12:29', '2020-01-10 23:12:29', NULL),
(38, 8, 8, '2020-01-10 23:12:29', '2020-01-10 23:12:29', NULL),
(39, 9, 8, '2020-01-10 23:12:29', '2020-01-10 23:12:29', NULL),
(40, 10, 8, '2020-01-10 23:12:29', '2020-01-10 23:12:29', NULL),
(41, 11, 8, '2020-01-10 23:12:29', '2020-01-10 23:12:29', NULL),
(42, 12, 8, '2020-01-10 23:12:29', '2020-01-10 23:12:29', NULL),
(43, 13, 8, '2020-01-10 23:12:29', '2020-01-10 23:12:29', NULL),
(44, 14, 8, '2020-01-10 23:12:29', '2020-01-10 23:12:29', NULL),
(45, 15, 8, '2020-01-10 23:12:29', '2020-01-10 23:12:29', NULL),
(46, 1, 3, '2020-01-10 23:13:06', '2020-01-10 23:13:06', NULL),
(47, 2, 3, '2020-01-10 23:13:06', '2020-01-10 23:13:06', NULL),
(48, 3, 3, '2020-01-10 23:13:06', '2020-01-10 23:13:06', NULL),
(49, 4, 3, '2020-01-10 23:13:06', '2020-01-10 23:13:06', NULL),
(50, 5, 3, '2020-01-10 23:13:06', '2020-01-10 23:13:06', NULL),
(51, 6, 3, '2020-01-10 23:13:06', '2020-01-10 23:13:06', NULL),
(52, 7, 3, '2020-01-10 23:13:06', '2020-01-10 23:13:06', NULL),
(53, 8, 3, '2020-01-10 23:13:06', '2020-01-10 23:13:06', NULL),
(54, 9, 3, '2020-01-10 23:13:06', '2020-01-10 23:13:06', NULL),
(55, 10, 3, '2020-01-10 23:13:06', '2020-01-10 23:13:06', NULL),
(56, 11, 3, '2020-01-10 23:13:06', '2020-01-10 23:13:06', NULL),
(57, 12, 3, '2020-01-10 23:13:06', '2020-01-10 23:13:06', NULL),
(58, 13, 3, '2020-01-10 23:13:06', '2020-01-10 23:13:06', NULL),
(59, 14, 3, '2020-01-10 23:13:06', '2020-01-10 23:13:06', NULL),
(60, 15, 3, '2020-01-10 23:13:06', '2020-01-10 23:13:06', NULL),
(61, 1, 2, '2020-01-10 23:13:31', '2020-01-10 23:13:31', NULL),
(62, 2, 2, '2020-01-10 23:13:31', '2020-01-10 23:13:31', NULL),
(63, 3, 2, '2020-01-10 23:13:31', '2020-01-10 23:13:31', NULL),
(64, 4, 2, '2020-01-10 23:13:31', '2020-01-10 23:13:31', NULL),
(65, 5, 2, '2020-01-10 23:13:31', '2020-01-10 23:13:31', NULL),
(66, 6, 2, '2020-01-10 23:13:31', '2020-01-10 23:13:31', NULL),
(67, 7, 2, '2020-01-10 23:13:31', '2020-01-10 23:13:31', NULL),
(68, 8, 2, '2020-01-10 23:13:31', '2020-01-10 23:13:31', NULL),
(69, 9, 2, '2020-01-10 23:13:31', '2020-01-10 23:13:31', NULL),
(70, 10, 2, '2020-01-10 23:13:31', '2020-01-10 23:13:31', NULL),
(71, 11, 2, '2020-01-10 23:13:31', '2020-01-10 23:13:31', NULL),
(72, 12, 2, '2020-01-10 23:13:31', '2020-01-10 23:13:31', NULL),
(73, 13, 2, '2020-01-10 23:13:31', '2020-01-10 23:13:31', NULL),
(74, 14, 2, '2020-01-10 23:13:31', '2020-01-10 23:13:31', NULL),
(75, 15, 2, '2020-01-10 23:13:31', '2020-01-10 23:13:31', NULL),
(76, 1, 4, '2020-01-10 23:13:58', '2020-01-10 23:13:58', NULL),
(77, 2, 4, '2020-01-10 23:13:58', '2020-01-10 23:13:58', NULL),
(78, 3, 4, '2020-01-10 23:13:58', '2020-01-10 23:13:58', NULL),
(79, 4, 4, '2020-01-10 23:13:58', '2020-01-10 23:13:58', NULL),
(80, 5, 4, '2020-01-10 23:13:58', '2020-01-10 23:13:58', NULL),
(81, 6, 4, '2020-01-10 23:13:58', '2020-01-10 23:13:58', NULL),
(82, 7, 4, '2020-01-10 23:13:58', '2020-01-10 23:13:58', NULL),
(83, 8, 4, '2020-01-10 23:13:58', '2020-01-10 23:13:58', NULL),
(84, 9, 4, '2020-01-10 23:13:58', '2020-01-10 23:13:58', NULL),
(85, 10, 4, '2020-01-10 23:13:58', '2020-01-10 23:13:58', NULL),
(86, 11, 4, '2020-01-10 23:13:58', '2020-01-10 23:13:58', NULL),
(87, 12, 4, '2020-01-10 23:13:58', '2020-01-10 23:13:58', NULL),
(88, 13, 4, '2020-01-10 23:13:58', '2020-01-10 23:13:58', NULL),
(89, 14, 4, '2020-01-10 23:13:58', '2020-01-10 23:13:58', NULL),
(90, 15, 4, '2020-01-10 23:13:58', '2020-01-10 23:13:58', NULL),
(91, 1, 6, '2020-01-10 23:14:29', '2020-01-10 23:14:29', NULL),
(92, 2, 6, '2020-01-10 23:14:29', '2020-01-10 23:14:29', NULL),
(93, 3, 6, '2020-01-10 23:14:29', '2020-01-10 23:14:29', NULL),
(94, 4, 6, '2020-01-10 23:14:29', '2020-01-10 23:14:29', NULL),
(95, 5, 6, '2020-01-10 23:14:29', '2020-01-10 23:14:29', NULL),
(96, 6, 6, '2020-01-10 23:14:29', '2020-01-10 23:14:29', NULL),
(97, 7, 6, '2020-01-10 23:14:29', '2020-01-10 23:14:29', NULL),
(98, 8, 6, '2020-01-10 23:14:29', '2020-01-10 23:14:29', NULL),
(99, 9, 6, '2020-01-10 23:14:29', '2020-01-10 23:14:29', NULL),
(100, 10, 6, '2020-01-10 23:14:29', '2020-01-10 23:14:29', NULL),
(101, 11, 6, '2020-01-10 23:14:29', '2020-01-10 23:14:29', NULL),
(102, 12, 6, '2020-01-10 23:14:29', '2020-01-10 23:14:29', NULL),
(103, 13, 6, '2020-01-10 23:14:29', '2020-01-10 23:14:29', NULL),
(104, 14, 6, '2020-01-10 23:14:29', '2020-01-10 23:14:29', NULL),
(105, 15, 6, '2020-01-10 23:14:29', '2020-01-10 23:14:29', NULL),
(106, 1, 7, '2020-01-10 23:18:22', '2020-01-10 23:18:22', NULL),
(107, 2, 7, '2020-01-10 23:18:22', '2020-01-10 23:18:22', NULL),
(108, 3, 7, '2020-01-10 23:18:22', '2020-01-10 23:18:22', NULL),
(109, 4, 7, '2020-01-10 23:18:22', '2020-01-10 23:18:22', NULL),
(110, 5, 7, '2020-01-10 23:18:22', '2020-01-10 23:18:22', NULL),
(111, 6, 7, '2020-01-10 23:18:22', '2020-01-10 23:18:22', NULL),
(112, 7, 7, '2020-01-10 23:18:22', '2020-01-10 23:18:22', NULL),
(113, 8, 7, '2020-01-10 23:18:22', '2020-01-10 23:18:22', NULL),
(114, 9, 7, '2020-01-10 23:18:22', '2020-01-10 23:18:22', NULL),
(115, 10, 7, '2020-01-10 23:18:22', '2020-01-10 23:18:22', NULL),
(116, 11, 7, '2020-01-10 23:18:22', '2020-01-10 23:18:22', NULL),
(117, 12, 7, '2020-01-10 23:18:22', '2020-01-10 23:18:22', NULL),
(118, 13, 7, '2020-01-10 23:18:22', '2020-01-10 23:18:22', NULL),
(119, 14, 7, '2020-01-10 23:18:22', '2020-01-10 23:18:22', NULL),
(120, 15, 7, '2020-01-10 23:18:22', '2020-01-10 23:18:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_health`
--

CREATE TABLE `student_health` (
  `id` int(11) NOT NULL,
  `student_id` int(6) NOT NULL,
  `heart_rate` int(3) DEFAULT NULL,
  `blood_pressure` int(3) DEFAULT NULL,
  `height` int(3) DEFAULT NULL,
  `weight` int(3) DEFAULT NULL,
  `bmi` float(4,2) DEFAULT NULL,
  `vaccination` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `speciality` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `blood_group` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surgeries` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_health`
--

INSERT INTO `student_health` (`id`, `student_id`, `heart_rate`, `blood_pressure`, `height`, `weight`, `bmi`, `vaccination`, `speciality`, `date`, `blood_group`, `surgeries`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 1, 82, 91, 139, 35, 18.12, NULL, 'Low Vision', '2020-01-10', 'A-', NULL, '2020-01-10 19:52:07', '2020-01-10 20:02:46', NULL),
(2, 2, 78, 85, 141, 40, 20.12, NULL, NULL, '2020-01-10', 'B-', NULL, '2020-01-10 19:52:07', '2020-01-10 20:02:46', NULL),
(3, 3, 80, 78, 138, 34, 17.85, 'aTd', NULL, '2020-01-10', 'A+', NULL, '2020-01-10 19:52:07', '2020-01-10 20:02:46', NULL),
(4, 4, 83, 74, 132, 36, 20.66, NULL, NULL, '2020-01-10', 'AB-', NULL, '2020-01-10 19:52:07', '2020-01-10 20:02:46', NULL),
(5, 5, 82, 82, 148, 31, 14.15, 'aTd', NULL, '2020-01-10', 'O+', NULL, '2020-01-10 19:52:07', '2020-01-10 20:02:46', NULL),
(6, 6, 112, 70, 139, 39, 20.19, NULL, NULL, '2020-01-10', 'B-', NULL, '2020-01-10 19:52:07', '2020-01-10 20:02:46', NULL),
(7, 7, 79, 73, 134, 40, 22.28, NULL, 'Low Vision', '2020-01-10', 'AB-', NULL, '2020-01-10 19:52:07', '2020-01-10 20:02:46', NULL),
(8, 8, 83, 81, 140, 37, 18.88, 'aTd', NULL, '2020-01-10', 'A-', NULL, '2020-01-10 19:52:07', '2020-01-10 20:02:46', NULL),
(9, 9, 94, 79, 141, 42, 21.13, NULL, NULL, '2020-01-10', 'A+', NULL, '2020-01-10 19:52:07', '2020-01-10 20:02:46', NULL),
(10, 10, 89, 72, 138, 37, 19.43, NULL, NULL, '2020-01-10', 'O-', NULL, '2020-01-10 19:52:07', '2020-01-10 20:02:46', NULL),
(11, 11, 80, 82, 148, 40, 18.26, NULL, NULL, '2020-01-10', 'O+', NULL, '2020-01-10 20:32:25', '2020-01-10 20:32:51', NULL),
(12, 12, 78, 73, 134, 32, 17.82, 'aTd', NULL, '2020-01-10', 'B+', NULL, '2020-01-10 20:32:25', '2020-01-10 20:32:51', NULL),
(13, 15, 90, 73, 140, 41, 20.92, NULL, NULL, '2020-01-10', 'AB-', NULL, '2020-01-10 20:32:25', '2020-01-10 20:32:51', NULL),
(14, 16, 82, 82, 139, 38, 19.67, NULL, 'Low Vision', '2020-01-10', 'AB+', NULL, '2020-01-10 20:32:25', '2020-01-10 20:32:51', NULL),
(15, 17, 79, 79, 132, 30, 17.22, NULL, NULL, '2020-01-10', 'O+', NULL, '2020-01-10 20:32:25', '2020-01-10 20:32:51', NULL),
(16, 13, 76, 81, 130, 30, 17.75, NULL, NULL, '2020-01-10', 'AB-', NULL, '2020-01-10 20:32:25', '2020-01-10 20:32:51', NULL),
(17, 19, 93, 90, 141, 39, 19.62, NULL, NULL, '2020-01-10', 'A-', NULL, '2020-01-10 20:32:25', '2020-01-10 20:32:51', NULL),
(18, 18, 81, 73, 138, 35, 18.38, 'aTd', NULL, '2020-01-10', 'O-', NULL, '2020-01-10 20:32:25', '2020-01-10 20:32:51', NULL),
(19, 14, 80, 90, 138, 38, 19.95, NULL, NULL, '2020-01-10', 'A-', NULL, '2020-01-10 20:32:25', '2020-01-10 20:32:51', NULL),
(20, 20, 80, 87, 137, 36, 19.18, NULL, NULL, '2020-01-10', 'B+', NULL, '2020-01-10 20:32:25', '2020-01-10 20:32:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(3) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `si_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `name`, `si_name`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 'Maths', NULL, '2020-01-10 20:27:44', '2020-01-10 20:27:44', NULL),
(2, 'Science', NULL, '2020-01-10 20:27:50', '2020-01-10 20:27:50', NULL),
(3, 'English', NULL, '2020-01-10 20:28:03', '2020-01-10 20:28:03', NULL),
(4, 'Sinhala', NULL, '2020-01-10 20:28:10', '2020-01-10 20:28:10', NULL),
(5, 'Buddhism', NULL, '2020-01-10 20:28:17', '2020-01-10 20:28:17', NULL),
(6, 'Health', NULL, '2020-01-10 20:28:29', '2020-01-10 20:28:29', NULL),
(7, 'History', NULL, '2020-01-10 20:28:37', '2020-01-10 20:28:37', NULL),
(8, 'Geography', NULL, '2020-01-10 20:28:56', '2020-01-10 20:28:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(7) NOT NULL,
  `ref_id` int(6) DEFAULT NULL,
  `user_type` enum('staff','student','parent','coach') COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme` enum('Default','Dark') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Default',
  `role_id` int(2) NOT NULL,
  `status` enum('Active','Deactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `ref_id`, `user_type`, `username`, `password`, `theme`, `role_id`, `status`, `remember_token`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 1, 'staff', 'Siridewa', '$2y$10$.KxlajkHK00BrlONfrt2nO0LZ7IqIWrpIUqwlLquiuGIUYJikzQ0e', 'Default', 2, 'Active', NULL, '2019-02-20 00:00:00', '2020-01-08 04:46:45', NULL),
(2, 14, 'staff', 'Narangoda', '$2y$10$ypne5jgEEkrN4YAnX67ZmeyadDsCJR6t1ruU8wP4W9UF.y1dr/8ve', 'Default', 1, 'Active', 'ab7435a924752116511c4305d269510a', '2020-01-08 04:47:16', '2020-01-10 11:14:49', NULL),
(3, 19, 'staff', 'lakmal', '$2y$10$ZqlLwYixGUX7RBynFJ/ZGuBoZsaDzQR/OALx3wm2LwetNy4ddiTlK', 'Default', 1, 'Active', 'e63158462b37fbdf9b202abf22bcc9a1', '2020-01-10 20:39:25', '2020-01-10 22:21:37', NULL),
(4, 1, 'student', 'Ruwanpathirana', '$2y$10$3qEuQz4GGvdLfdtePyQXQOZaxYZ.7eHD7kihaK9MICmmzchbnEedi', 'Default', 3, 'Active', NULL, '2020-01-10 23:19:33', '2020-01-10 23:19:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

CREATE TABLE `user_permission` (
  `id` int(3) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_permission`
--

INSERT INTO `user_permission` (`id`, `name`, `module`, `description`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 'home-index-view', 'home', NULL, '2020-01-09 00:00:00', '2020-01-09 00:00:00', NULL),
(2, 'attendance-index-view', 'attendance', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(3, 'attendance-mark-view', 'attendance', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(4, 'attendance-search-view', 'attendance', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(5, 'backup-index-view', 'backup', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(6, 'exam-index-view', 'exam', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(7, 'exam-create-view', 'exam', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(8, 'exam-search-view', 'exam', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(9, 'health-index-view', 'health', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(10, 'health-add-view', 'health', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(11, 'health-search-view', 'health', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(12, 'messages-index-view', 'messages', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(13, 'messages-single-view', 'messages', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(14, 'parents-index-view', 'parent', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(15, 'parents-add-view', 'parent', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(16, 'parents-profile-view', 'parent', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(17, 'parents-search-view', 'parent', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(18, 'portal-messages-view', 'portal', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(19, 'portal-parent-view', 'portal', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(20, 'portal-single-view', 'portal', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(21, 'portal-student-view', 'portal', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(22, 'report-attendance-view', 'report', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(23, 'report-health-view', 'report', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(24, 'report-result-view', 'report', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(25, 'report-staff-view', 'report', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(26, 'report-student-view', 'report', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(27, 'report-timetable-view', 'report', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(28, 'result-index-view', 'result', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(29, 'result-add-view', 'result', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(30, 'result-search-view', 'result', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(31, 'management-index-view', 'management', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(32, 'sport-index-view', 'sport', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(33, 'sport-add_coach-view', 'sport', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(34, 'sport-assign-view', 'sport', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(35, 'sport-profile_coach-view', 'sport', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(36, 'sport-search_coach-view', 'sport', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(37, 'sport-search_student-view', 'sport', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(38, 'staff-index-view', 'staff', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(39, 'staff-add-view', 'staff', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(40, 'staff-profile-view', 'staff', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(41, 'staff-search-view', 'staff', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(42, 'student-index-view', 'student', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(43, 'student-add-view', 'student', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(44, 'student-profile-view', 'student', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(45, 'student-search-view', 'student', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(46, 'timetable-index-view', 'timetable', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(47, 'timetable-class_timetable-view', 'timetable', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(48, 'timetable-create-view', 'timetable', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(49, 'timetable-staff_timetable-view', 'timetable', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(50, 'user-index-view', 'user', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(51, 'user-permission-view', 'user', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(52, 'user-search-view', 'user', NULL, '2019-01-09 00:00:00', '2019-01-09 00:00:00', NULL),
(53, 'student-profile-edit-propic', 'student', NULL, '2019-01-10 00:00:00', '2019-01-10 00:00:00', NULL),
(54, 'staff-profile-edit-propic', 'staff', NULL, '2019-01-10 00:00:00', '2019-01-10 00:00:00', NULL),
(55, 'coach-profile-edit-propic', 'coach', NULL, '2019-01-10 00:00:00', '2019-01-10 00:00:00', NULL),
(56, 'parents-profile-edit-propic', 'parent', NULL, '2019-01-10 00:00:00', '2019-01-10 00:00:00', NULL),
(57, 'attendance-search-view-student', 'attendance', NULL, '2019-01-10 00:00:00', '2019-01-10 00:00:00', NULL),
(58, 'attendance-search-view-staff', 'attendance', NULL, '2019-01-10 00:00:00', '2019-01-10 00:00:00', NULL),
(59, 'attendance-mark-view-staff', 'attendance', NULL, '2019-01-10 00:00:00', '2019-01-10 00:00:00', NULL),
(60, 'attendance-mark-view-student', 'attendance', NULL, '2019-01-10 00:00:00', '2019-01-10 00:00:00', NULL),
(61, 'exam-search-edit-exam', 'exam', NULL, '2019-01-10 00:00:00', '2019-01-10 00:00:00', NULL),
(62, 'result-search-edit-result', 'result', NULL, '2019-01-10 00:00:00', '2019-01-10 00:00:00', NULL),
(63, 'result-search-delete-result', 'result', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(64, 'exam-search-delete-exam', 'exam', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(65, 'exam-create-edit-exam_type', 'exam', NULL, '2020-01-09 00:00:00', '2020-01-09 00:00:00', NULL),
(66, 'exam-create-add-exam_type', 'exam', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(67, 'student-sport-delete', 'student', NULL, '2020-01-08 00:00:00', '2020-01-08 00:00:00', NULL),
(68, 'coach-profile-view', 'coach', NULL, '2020-01-09 00:00:00', '2020-01-09 00:00:00', NULL),
(69, 'health-search-edit', 'health', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(70, 'health-search-delete', 'health', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(71, 'report-any-generate', 'report', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(72, 'report-any-view', 'report', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(73, 'report-any-delete', 'report', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(74, 'student-profile-edit', 'student', NULL, '2020-01-09 00:00:00', '2020-01-09 00:00:00', NULL),
(75, 'staff-profile-edit', 'staff', NULL, '2020-01-09 00:00:00', '2020-01-09 00:00:00', NULL),
(76, 'coach-profile-edit', 'coach', NULL, '2020-01-09 00:00:00', '2020-01-09 00:00:00', NULL),
(77, 'parents-profile-edit', 'parent', NULL, '2020-01-09 00:00:00', '2020-01-09 00:00:00', NULL),
(78, 'student-profile-delete', 'student', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(79, 'staff-profile-delete', 'staff', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(80, 'coach-profile-delete', 'coach', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(81, 'parents-profile-delete', 'parent', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(82, 'exam-create-delete-exam_type', 'exam', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(83, 'exam-create-add-schedule', 'exam', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(84, 'exam-create-edit-schedule', 'exam', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(85, 'exam-search-delete-schedule', 'exam', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(86, 'messages-create-new', 'messages', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(87, 'messages-conversation-reply', 'messages', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(88, 'notification-read', 'notification', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(89, 'notification-delete', 'notification', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(90, 'user-permission-view-edit', 'user', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(91, 'portal-student-edit', 'portal', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(92, 'portal-parent-edit', 'portal', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(93, 'portal-messages-create-new', 'portal', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(94, 'portal-messages-conversation-reply', 'portal', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(95, 'report-any-create', 'report', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(96, 'management-index-edit-any', 'management', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(97, 'management-index-delete-any', 'management', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(98, 'management-index-add-any', 'management', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(99, 'sport-student-delete', 'sport', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(100, 'sport-student-edit', 'sport', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(101, 'timetable-assign-subject', 'timetable', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(102, 'timetable-assign-staff', 'timetable', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(103, 'user-edit-theme', 'user', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(104, 'mobile-schms-api', 'mobile', NULL, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(2) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `name`, `description`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 'System Administrator', 'This user has full access to this system', '2019-02-20 00:00:00', '2019-02-20 00:00:00', NULL),
(2, 'Ordinary Staff', 'Typical Permissions ', '2020-01-05 04:17:53', '2020-01-05 04:25:35', NULL),
(3, 'Student', 'Only student portal is allowed', '2020-01-05 04:18:40', '2020-01-05 04:19:43', NULL),
(4, 'Parent', 'Only parent portal is allowed', '2020-01-05 04:19:02', '2020-01-05 04:19:36', NULL),
(5, 'Coach', 'Only sport module is allowed', '2020-01-05 04:19:27', '2020-01-05 04:19:27', NULL),
(6, 'Guest Staff', 'Only view the system as a guest', '2020-01-05 04:25:51', '2020-01-05 04:25:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_role_has_permission`
--

CREATE TABLE `user_role_has_permission` (
  `id` int(6) NOT NULL,
  `role_id` int(2) NOT NULL,
  `permission_id` int(3) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_role_has_permission`
--

INSERT INTO `user_role_has_permission` (`id`, `role_id`, `permission_id`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 1, 51, '2020-01-09 00:00:00', '2020-01-09 00:00:00', NULL),
(2, 1, 2, '2020-01-10 14:31:56', '2020-01-10 14:31:56', NULL),
(4, 1, 3, '2020-01-10 14:32:01', '2020-01-10 14:32:01', NULL),
(5, 1, 58, '2020-01-10 14:32:02', '2020-01-10 14:32:02', NULL),
(6, 1, 59, '2020-01-10 14:32:03', '2020-01-10 14:32:03', NULL),
(7, 1, 57, '2020-01-10 14:32:05', '2020-01-10 14:32:05', NULL),
(8, 1, 60, '2020-01-10 14:32:05', '2020-01-10 14:32:05', NULL),
(10, 1, 4, '2020-01-10 14:32:09', '2020-01-10 14:32:09', NULL),
(11, 1, 55, '2020-01-10 14:32:10', '2020-01-10 14:32:10', NULL),
(12, 1, 68, '2020-01-10 14:32:12', '2020-01-10 14:32:12', NULL),
(13, 1, 5, '2020-01-10 14:32:14', '2020-01-10 14:32:14', NULL),
(14, 1, 66, '2020-01-10 14:32:16', '2020-01-10 14:32:16', NULL),
(15, 1, 64, '2020-01-10 14:32:18', '2020-01-10 14:32:18', NULL),
(16, 1, 65, '2020-01-10 14:32:20', '2020-01-10 14:32:20', NULL),
(17, 1, 61, '2020-01-10 14:32:21', '2020-01-10 14:32:21', NULL),
(18, 1, 7, '2020-01-10 14:32:22', '2020-01-10 14:32:22', NULL),
(19, 1, 8, '2020-01-10 14:32:23', '2020-01-10 14:32:23', NULL),
(20, 1, 6, '2020-01-10 14:32:25', '2020-01-10 14:32:25', NULL),
(21, 1, 10, '2020-01-10 14:32:27', '2020-01-10 14:32:27', NULL),
(22, 1, 1, '2020-01-10 14:32:29', '2020-01-10 14:32:29', NULL),
(23, 1, 11, '2020-01-10 14:32:32', '2020-01-10 14:32:32', NULL),
(24, 1, 9, '2020-01-10 14:32:34', '2020-01-10 14:32:34', NULL),
(25, 1, 70, '2020-01-10 14:32:36', '2020-01-10 14:32:36', NULL),
(26, 1, 69, '2020-01-10 14:32:38', '2020-01-10 14:32:38', NULL),
(27, 1, 12, '2020-01-10 14:32:42', '2020-01-10 14:32:42', NULL),
(28, 1, 13, '2020-01-10 14:32:45', '2020-01-10 14:32:45', NULL),
(29, 1, 15, '2020-01-10 14:32:47', '2020-01-10 14:32:47', NULL),
(30, 1, 17, '2020-01-10 14:32:49', '2020-01-10 14:32:49', NULL),
(31, 1, 14, '2020-01-10 14:32:52', '2020-01-10 14:32:52', NULL),
(32, 1, 56, '2020-01-10 14:32:54', '2020-01-10 14:32:54', NULL),
(33, 1, 16, '2020-01-10 14:32:55', '2020-01-10 14:32:55', NULL),
(36, 1, 73, '2020-01-10 14:33:07', '2020-01-10 14:33:07', NULL),
(37, 1, 23, '2020-01-10 14:33:09', '2020-01-10 14:33:09', NULL),
(38, 1, 27, '2020-01-10 14:33:12', '2020-01-10 14:33:12', NULL),
(39, 1, 71, '2020-01-10 14:33:14', '2020-01-10 14:33:14', NULL),
(40, 1, 24, '2020-01-10 14:33:17', '2020-01-10 14:33:17', NULL),
(41, 1, 72, '2020-01-10 14:33:20', '2020-01-10 14:33:20', NULL),
(42, 1, 25, '2020-01-10 14:33:23', '2020-01-10 14:33:23', NULL),
(43, 1, 22, '2020-01-10 14:33:29', '2020-01-10 14:33:29', NULL),
(44, 1, 26, '2020-01-10 14:33:34', '2020-01-10 14:33:34', NULL),
(45, 1, 29, '2020-01-10 14:33:37', '2020-01-10 14:33:37', NULL),
(46, 1, 30, '2020-01-10 14:33:40', '2020-01-10 14:33:40', NULL),
(47, 1, 28, '2020-01-10 14:33:42', '2020-01-10 14:33:42', NULL),
(48, 1, 63, '2020-01-10 14:33:45', '2020-01-10 14:33:45', NULL),
(49, 1, 62, '2020-01-10 14:33:49', '2020-01-10 14:33:49', NULL),
(50, 1, 31, '2020-01-10 14:33:51', '2020-01-10 14:33:51', NULL),
(51, 1, 33, '2020-01-10 14:33:54', '2020-01-10 14:33:54', NULL),
(52, 1, 36, '2020-01-10 14:33:58', '2020-01-10 14:33:58', NULL),
(53, 1, 34, '2020-01-10 14:34:00', '2020-01-10 14:34:00', NULL),
(54, 1, 37, '2020-01-10 14:34:03', '2020-01-10 14:34:03', NULL),
(55, 1, 32, '2020-01-10 14:34:06', '2020-01-10 14:34:06', NULL),
(56, 1, 35, '2020-01-10 14:34:10', '2020-01-10 14:34:10', NULL),
(57, 1, 40, '2020-01-10 14:34:12', '2020-01-10 14:34:12', NULL),
(58, 1, 54, '2020-01-10 14:34:15', '2020-01-10 14:34:15', NULL),
(59, 1, 38, '2020-01-10 14:34:17', '2020-01-10 14:34:17', NULL),
(60, 1, 39, '2020-01-10 14:34:21', '2020-01-10 14:34:21', NULL),
(61, 1, 41, '2020-01-10 14:34:23', '2020-01-10 14:34:23', NULL),
(62, 1, 43, '2020-01-10 14:34:27', '2020-01-10 14:34:27', NULL),
(63, 1, 45, '2020-01-10 14:34:30', '2020-01-10 14:34:30', NULL),
(64, 1, 42, '2020-01-10 14:34:33', '2020-01-10 14:34:33', NULL),
(65, 1, 67, '2020-01-10 14:34:39', '2020-01-10 14:34:39', NULL),
(66, 1, 53, '2020-01-10 14:34:43', '2020-01-10 14:34:43', NULL),
(67, 1, 44, '2020-01-10 14:34:52', '2020-01-10 14:34:52', NULL),
(68, 1, 49, '2020-01-10 14:34:56', '2020-01-10 14:34:56', NULL),
(69, 1, 46, '2020-01-10 14:34:59', '2020-01-10 14:34:59', NULL),
(70, 1, 52, '2020-01-10 14:35:02', '2020-01-10 14:35:02', NULL),
(71, 1, 48, '2020-01-10 14:35:05', '2020-01-10 14:35:05', NULL),
(72, 1, 47, '2020-01-10 14:35:08', '2020-01-10 14:35:08', NULL),
(73, 1, 50, '2020-01-10 14:35:11', '2020-01-10 14:35:11', NULL),
(74, 1, 82, '2020-01-10 16:55:09', '2020-01-10 16:55:09', NULL),
(75, 1, 80, '2020-01-10 16:55:12', '2020-01-10 16:55:12', NULL),
(76, 1, 76, '2020-01-10 16:55:15', '2020-01-10 16:55:15', NULL),
(77, 1, 81, '2020-01-10 16:55:21', '2020-01-10 16:55:21', NULL),
(78, 1, 77, '2020-01-10 16:55:26', '2020-01-10 16:55:26', NULL),
(79, 1, 79, '2020-01-10 16:55:33', '2020-01-10 16:55:33', NULL),
(80, 1, 75, '2020-01-10 16:55:39', '2020-01-10 16:55:39', NULL),
(81, 1, 78, '2020-01-10 16:55:45', '2020-01-10 16:55:45', NULL),
(82, 1, 74, '2020-01-10 16:55:51', '2020-01-10 16:55:51', NULL),
(83, 1, 90, '2020-01-10 00:00:00', '2020-01-10 00:00:00', NULL),
(85, 1, 84, '2020-01-10 20:26:30', '2020-01-10 20:26:30', NULL),
(86, 1, 85, '2020-01-10 20:26:32', '2020-01-10 20:26:32', NULL),
(87, 1, 83, '2020-01-10 20:26:34', '2020-01-10 20:26:34', NULL),
(88, 1, 97, '2020-01-10 20:26:37', '2020-01-10 20:26:37', NULL),
(89, 1, 98, '2020-01-10 20:26:39', '2020-01-10 20:26:39', NULL),
(90, 1, 96, '2020-01-10 20:26:41', '2020-01-10 20:26:41', NULL),
(91, 1, 86, '2020-01-10 20:26:45', '2020-01-10 20:26:45', NULL),
(92, 1, 87, '2020-01-10 20:26:48', '2020-01-10 20:26:48', NULL),
(93, 1, 89, '2020-01-10 20:26:51', '2020-01-10 20:26:51', NULL),
(94, 1, 88, '2020-01-10 20:26:54', '2020-01-10 20:26:54', NULL),
(95, 1, 104, '2020-01-10 20:27:03', '2020-01-10 20:27:03', NULL),
(96, 1, 99, '2020-01-10 20:27:09', '2020-01-10 20:27:09', NULL),
(97, 1, 100, '2020-01-10 20:27:14', '2020-01-10 20:27:14', NULL),
(98, 1, 102, '2020-01-10 20:27:18', '2020-01-10 20:27:18', NULL),
(99, 1, 101, '2020-01-10 20:27:22', '2020-01-10 20:27:22', NULL),
(100, 1, 103, '2020-01-10 20:27:27', '2020-01-10 20:27:27', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backup`
--
ALTER TABLE `backup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `grade_id` (`grade_id`,`name`),
  ADD UNIQUE KEY `staff_id` (`staff_id`);

--
-- Indexes for table `class_timetable`
--
ALTER TABLE `class_timetable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `coach`
--
ALTER TABLE `coach`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nic` (`nic`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `district_id` (`district_id`);

--
-- Indexes for table `coach_has_sport`
--
ALTER TABLE `coach_has_sport`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coach_id_2` (`coach_id`,`sport_id`),
  ADD KEY `sport_id` (`sport_id`),
  ADD KEY `coach_id` (`coach_id`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`,`province_id`),
  ADD KEY `district_province_id_fk` (`province_id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`type_id`,`year`);

--
-- Indexes for table `exam_grade_has_schedule`
--
ALTER TABLE `exam_grade_has_schedule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `exam_grade_id` (`exam_grade_id`,`subject_id`),
  ADD KEY `exam_schedule_ibfk_2` (`subject_id`);

--
-- Indexes for table `exam_has_grade`
--
ALTER TABLE `exam_has_grade`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `exam_id` (`exam_id`,`grade_id`),
  ADD KEY `exam_has_grade_ibfk_2` (`grade_id`);

--
-- Indexes for table `exam_type`
--
ALTER TABLE `exam_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nic` (`nic`),
  ADD KEY `parent_district_id_fk` (`district_id`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `relation_type`
--
ALTER TABLE `relation_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `religion`
--
ALTER TABLE `religion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `generated_by` (`generated_by`);

--
-- Indexes for table `sport`
--
ALTER TABLE `sport`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_id` (`employee_number`),
  ADD UNIQUE KEY `nic` (`nic`),
  ADD KEY `staff_staff_type_id_fk` (`type_id`),
  ADD KEY `staff_district_id_fk` (`district_id`),
  ADD KEY `staff_religion_id_fk` (`religion_id`);

--
-- Indexes for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_id` (`staff_id`,`date`);

--
-- Indexes for table `staff_category`
--
ALTER TABLE `staff_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `staff_has_subject`
--
ALTER TABLE `staff_has_subject`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_id` (`staff_id`,`subject_id`),
  ADD KEY `staff_has_subject_ibfk_2` (`subject_id`);

--
-- Indexes for table `staff_type`
--
ALTER TABLE `staff_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `staff_type_staff_category_id_fk` (`category_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admission_no` (`admission_no`),
  ADD KEY `student_district_id_fk` (`district_id`),
  ADD KEY `student_religion_id_fk` (`religion_id`),
  ADD KEY `student_ibfk_2` (`class_id`),
  ADD KEY `phone_mobile` (`phone_mobile`),
  ADD KEY `city` (`city`);

--
-- Indexes for table `student_achievement`
--
ALTER TABLE `student_achievement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_achievement_student_id_fk` (`student_id`);

--
-- Indexes for table `student_attendance`
--
ALTER TABLE `student_attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`date`);

--
-- Indexes for table `student_has_class`
--
ALTER TABLE `student_has_class`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `class_id` (`class_id`,`index_no`),
  ADD UNIQUE KEY `student_id` (`student_id`,`class_id`);

--
-- Indexes for table `student_has_exam_schedule`
--
ALTER TABLE `student_has_exam_schedule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`exam_schedule_id`),
  ADD KEY `exam_schedule_id` (`exam_schedule_id`);

--
-- Indexes for table `student_has_parent`
--
ALTER TABLE `student_has_parent`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`parent_id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `relation_id` (`relation_id`);

--
-- Indexes for table `student_has_sport`
--
ALTER TABLE `student_has_sport`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sport_id` (`sport_id`,`student_id`),
  ADD KEY `student_has_sport_student_id_fk` (`student_id`);

--
-- Indexes for table `student_has_sport_achievement`
--
ALTER TABLE `student_has_sport_achievement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_has_sport_achievement_ibfk_1` (`student_sport_id`);

--
-- Indexes for table `student_has_subject`
--
ALTER TABLE `student_has_subject`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`subject_id`),
  ADD KEY `student_has_subject_ibfk_2` (`subject_id`);

--
-- Indexes for table `student_health`
--
ALTER TABLE `student_health`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ref_id` (`ref_id`,`user_type`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `user_user_role_id_fk` (`role_id`);

--
-- Indexes for table `user_permission`
--
ALTER TABLE `user_permission`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`name`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role` (`name`);

--
-- Indexes for table `user_role_has_permission`
--
ALTER TABLE `user_role_has_permission`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_id` (`role_id`,`permission_id`),
  ADD KEY `user_role_has_permission_ibfk_1` (`permission_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `backup`
--
ALTER TABLE `backup`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `class_timetable`
--
ALTER TABLE `class_timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `coach`
--
ALTER TABLE `coach`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `coach_has_sport`
--
ALTER TABLE `coach_has_sport`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exam_grade_has_schedule`
--
ALTER TABLE `exam_grade_has_schedule`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `exam_has_grade`
--
ALTER TABLE `exam_has_grade`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `exam_type`
--
ALTER TABLE `exam_type`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `parent`
--
ALTER TABLE `parent`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `relation_type`
--
ALTER TABLE `relation_type`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `religion`
--
ALTER TABLE `religion`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sport`
--
ALTER TABLE `sport`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `staff_category`
--
ALTER TABLE `staff_category`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff_has_subject`
--
ALTER TABLE `staff_has_subject`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `staff_type`
--
ALTER TABLE `staff_type`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `student_achievement`
--
ALTER TABLE `student_achievement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_attendance`
--
ALTER TABLE `student_attendance`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=667;

--
-- AUTO_INCREMENT for table `student_has_class`
--
ALTER TABLE `student_has_class`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `student_has_exam_schedule`
--
ALTER TABLE `student_has_exam_schedule`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT for table `student_has_parent`
--
ALTER TABLE `student_has_parent`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `student_has_sport`
--
ALTER TABLE `student_has_sport`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `student_has_sport_achievement`
--
ALTER TABLE `student_has_sport_achievement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_has_subject`
--
ALTER TABLE `student_has_subject`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `student_health`
--
ALTER TABLE `student_health`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_role_has_permission`
--
ALTER TABLE `user_role_has_permission`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_ibfk_1` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `class_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `class_timetable`
--
ALTER TABLE `class_timetable`
  ADD CONSTRAINT `class_timetable_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `class_timetable_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `class_timetable_ibfk_3` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `coach`
--
ALTER TABLE `coach`
  ADD CONSTRAINT `coach_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `coach_has_sport`
--
ALTER TABLE `coach_has_sport`
  ADD CONSTRAINT `coach_has_sport_ibfk_1` FOREIGN KEY (`sport_id`) REFERENCES `sport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `coach_has_sport_ibfk_2` FOREIGN KEY (`coach_id`) REFERENCES `coach` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `district`
--
ALTER TABLE `district`
  ADD CONSTRAINT `district_province_id_fk` FOREIGN KEY (`province_id`) REFERENCES `province` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `exam_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `exam_type` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `exam_grade_has_schedule`
--
ALTER TABLE `exam_grade_has_schedule`
  ADD CONSTRAINT `exam_grade_has_schedule_ibfk_1` FOREIGN KEY (`exam_grade_id`) REFERENCES `exam_has_grade` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_grade_has_schedule_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `exam_has_grade`
--
ALTER TABLE `exam_has_grade`
  ADD CONSTRAINT `exam_has_grade_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_has_grade_ibfk_2` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parent`
--
ALTER TABLE `parent`
  ADD CONSTRAINT `parent_district_id_fk` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`generated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_district_id_fk` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`religion_id`) REFERENCES `religion` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `staff_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `staff_type` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  ADD CONSTRAINT `staff_attendance_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff_has_subject`
--
ALTER TABLE `staff_has_subject`
  ADD CONSTRAINT `staff_has_subject_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `staff_has_subject_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff_type`
--
ALTER TABLE `staff_type`
  ADD CONSTRAINT `staff_type_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `staff_category` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_district_id_fk` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`religion_id`) REFERENCES `religion` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `student_achievement`
--
ALTER TABLE `student_achievement`
  ADD CONSTRAINT `student_achievement_student_id_fk` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `student_attendance`
--
ALTER TABLE `student_attendance`
  ADD CONSTRAINT `student_attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_has_class`
--
ALTER TABLE `student_has_class`
  ADD CONSTRAINT `student_has_class_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_has_class_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_has_exam_schedule`
--
ALTER TABLE `student_has_exam_schedule`
  ADD CONSTRAINT `student_has_exam_schedule_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `student_has_exam_schedule_ibfk_2` FOREIGN KEY (`exam_schedule_id`) REFERENCES `exam_grade_has_schedule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_has_parent`
--
ALTER TABLE `student_has_parent`
  ADD CONSTRAINT `student_has_parent_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `parent` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_has_parent_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_has_parent_ibfk_3` FOREIGN KEY (`relation_id`) REFERENCES `relation_type` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `student_has_sport`
--
ALTER TABLE `student_has_sport`
  ADD CONSTRAINT `student_has_sport_sport_id_fk` FOREIGN KEY (`sport_id`) REFERENCES `sport` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `student_has_sport_student_id_fk` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_has_sport_achievement`
--
ALTER TABLE `student_has_sport_achievement`
  ADD CONSTRAINT `student_has_sport_achievement_ibfk_1` FOREIGN KEY (`student_sport_id`) REFERENCES `student_has_sport` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_has_subject`
--
ALTER TABLE `student_has_subject`
  ADD CONSTRAINT `student_has_subject_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_has_subject_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `student_health`
--
ALTER TABLE `student_health`
  ADD CONSTRAINT `student_health_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_role_has_permission`
--
ALTER TABLE `user_role_has_permission`
  ADD CONSTRAINT `user_role_has_permission_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `user_permission` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_role_has_permission_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
