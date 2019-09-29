-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 29, 2019 at 08:55 AM
-- Server version: 10.4.7-MariaDB
-- PHP Version: 7.3.9

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
  `date_time` datetime NOT NULL,
  `file_size` int(11) NOT NULL,
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
(15, 1, NULL, 'A', '2019-09-23 01:37:15', '2019-09-23 01:37:15', NULL),
(16, 3, 1, 'A', '2019-09-23 01:40:39', '2019-09-23 01:40:39', NULL),
(17, 5, NULL, 'A', '2019-09-23 05:12:49', '2019-09-23 05:12:49', NULL),
(18, 4, NULL, 'A', '2019-09-23 05:15:05', '2019-09-23 05:15:05', NULL),
(19, 1, 3, 'B', '2019-09-28 16:10:23', '2019-09-28 16:10:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `class_timetable`
--

CREATE TABLE `class_timetable` (
  `id` int(6) NOT NULL,
  `class_id` int(3) NOT NULL,
  `day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') COLLATE utf8mb4_unicode_ci NOT NULL,
  `period_1` int(3) NOT NULL,
  `period_2` int(3) NOT NULL,
  `period_3` int(3) NOT NULL,
  `period_4` int(3) NOT NULL,
  `period_5` int(3) NOT NULL,
  `period_6` int(3) NOT NULL,
  `period_7` int(3) NOT NULL,
  `period_8` int(3) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coach`
--

CREATE TABLE `coach` (
  `id` int(6) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nic` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_home` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_mobile` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coach_has_sport`
--

CREATE TABLE `coach_has_sport` (
  `id` int(4) NOT NULL,
  `sport_id` int(3) NOT NULL,
  `coach_id` int(6) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 2, 'Ampara', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(2, 3, 'Anuradhapura', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(3, 8, 'Badulla', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(4, 2, 'Batticaloa', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(5, 9, 'Colombo', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(6, 7, 'Galle', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(7, 9, 'Gampaha', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(8, 7, 'Hambantota', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(9, 5, 'Jaffna', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(10, 9, 'Kalutara', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(11, 1, 'Kandy', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(12, 6, 'Kegalle', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(13, 5, 'Kilinochchi', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(14, 4, 'Kurunegala', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(15, 5, 'Mannar', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(16, 1, 'Matale', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(17, 7, 'Matara', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(18, 8, 'Monaragala', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(19, 5, 'Mullaitivu', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(20, 1, 'Nuwara Eliya', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(21, 3, 'Polonnaruwa', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(22, 4, 'Puttalam', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(23, 6, 'Ratnapura', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(24, 2, 'Trincomalee', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(25, 5, 'Vavuniya', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `id` int(4) NOT NULL,
  `type_id` int(2) NOT NULL,
  `year` year(4) NOT NULL,
  `venue` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instructions` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`id`, `type_id`, `year`, `venue`, `instructions`, `created_on`, `updated_on`, `deleted_on`) VALUES
(6, 1, 2019, NULL, NULL, '2019-09-24 22:33:03', '2019-09-24 22:33:03', NULL),
(7, 3, 2019, NULL, NULL, '2019-09-28 21:27:06', '2019-09-28 21:27:06', NULL),
(10, 1, 2020, NULL, NULL, '2019-09-29 03:35:16', '2019-09-29 03:35:16', NULL);

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
  `venue` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instructions` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_grade_has_schedule`
--

INSERT INTO `exam_grade_has_schedule` (`id`, `exam_grade_id`, `subject_id`, `date`, `start_time`, `end_time`, `venue`, `instructions`, `created_on`, `updated_on`, `deleted_on`) VALUES
(15, 14, 1, '2019-09-25', '08:00:00', '10:00:00', NULL, NULL, '2019-09-24 22:34:20', '2019-09-24 22:34:20', NULL),
(20, 14, 5, '2019-09-25', '11:00:00', '13:00:00', NULL, NULL, '2019-09-25 02:13:13', '2019-09-25 02:13:13', NULL),
(21, 15, 1, '2019-09-25', '08:00:00', '10:00:00', NULL, NULL, '2019-09-25 02:14:51', '2019-09-25 02:14:51', NULL),
(22, 15, 5, '2019-09-25', '11:00:00', '13:00:00', NULL, NULL, '2019-09-25 02:15:53', '2019-09-25 02:15:53', NULL),
(23, 16, 1, '2019-09-28', '09:00:00', '12:00:00', NULL, NULL, '2019-09-28 21:27:35', '2019-09-28 21:27:35', NULL),
(24, 17, 1, '2019-09-29', '08:00:00', '10:00:00', NULL, NULL, '2019-09-29 04:46:33', '2019-09-29 04:46:33', NULL);

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
(14, 6, 1, '2019-09-24 22:34:20', '2019-09-24 22:34:20', NULL),
(15, 6, 3, '2019-09-25 02:14:51', '2019-09-25 02:14:51', NULL),
(16, 7, 1, '2019-09-28 21:27:35', '2019-09-28 21:27:35', NULL),
(17, 10, 1, '2019-09-29 04:46:33', '2019-09-29 04:46:33', NULL);

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
(1, 'First Semester', '2019-09-21 05:44:36', '2019-09-21 05:44:36', NULL),
(2, 'Second Semester', '2019-09-21 05:45:16', '2019-09-21 05:45:16', NULL),
(3, 'Third Semester', '2019-09-21 05:45:27', '2019-09-21 05:45:27', NULL),
(4, 'Mid First Semester', '2019-09-22 23:52:20', '2019-09-22 23:52:20', NULL),
(5, 'Mid Second Semester', '2019-09-22 23:58:16', '2019-09-22 23:58:16', NULL);

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
(1, 6, '2019-09-16 00:00:00', '2019-09-16 00:00:00', NULL),
(3, 7, '2019-09-21 02:07:46', '2019-09-21 02:07:46', NULL),
(4, 8, '2019-09-21 03:53:16', '2019-09-21 03:53:16', NULL),
(5, 1, '2019-09-21 23:49:46', '2019-09-21 23:49:46', NULL),
(6, 9, '2019-09-28 16:11:22', '2019-09-28 16:11:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `health`
--

CREATE TABLE `health` (
  `id` int(8) NOT NULL,
  `student_id` int(6) NOT NULL,
  `blood_group` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Specialities` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Surgeries` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` bigint(20) NOT NULL,
  `sender_id` int(6) NOT NULL,
  `sender_type` enum('Administrator','Staff','Student','Parent') COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver_id` int(6) NOT NULL,
  `receiver_type` enum('Administrator','Staff','Student','Parent') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_time` datetime NOT NULL,
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
  `sender_type` enum('Administrator','Staff','Student','Parent') COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver_id` int(6) NOT NULL,
  `receiver_type` enum('Administrator','Staff','Student','Parent') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_time` datetime NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(4, '677660198V', 'Warnakulasooriya Mahawaduge Mallika Peiris', 'W M M', 'Peiris', '1967-09-22', 'Female', NULL, NULL, NULL, 'None', NULL, NULL, '144/5A, 3rd Lane, Palmgrove Estate', 'Veyangoda', NULL, '2019-09-23 09:33:17', '2019-09-23 09:33:17', NULL),
(5, '591231408V', 'Samarakkodi Arachchige lakshman samarakkodi', 'S A L', 'Samarakkodi', '1959-02-28', 'Male', NULL, NULL, NULL, 'karate instructor', NULL, NULL, '144/5A 3rd lane', 'Veyangoda', 7, '2019-09-26 23:54:13', '2019-09-26 23:54:13', NULL);

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
(1, 'Central', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(2, 'Eastern', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(3, 'North Central', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(4, 'North Western', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(5, 'Northern', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(6, 'Sabaragamuwa', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(7, 'Southern', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(8, 'Uva', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(9, 'Western', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL);

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
(1, 'Father', '2019-09-21 04:56:27', '2019-09-21 04:56:27', NULL),
(2, 'Mother', '2019-09-21 04:56:33', '2019-09-21 04:56:33', NULL),
(3, 'Guardian 1', '2019-09-21 04:57:13', '2019-09-21 04:57:13', NULL),
(4, 'Guardian 2', '2019-09-21 04:57:45', '2019-09-21 04:57:45', NULL);

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
(1, 'Buddhist', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(2, 'Christian', '2019-09-18 00:00:00', '2019-09-18 00:00:00', NULL),
(3, 'Buddhism', '2019-09-21 04:17:00', '2019-09-21 04:17:00', NULL);

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
(1, 'Cricket', '2019-09-23 04:22:38', '2019-09-23 04:22:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(6) NOT NULL,
  `employee_number` int(6) NOT NULL,
  `category_id` int(2) NOT NULL,
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

INSERT INTO `staff` (`id`, `employee_number`, `category_id`, `type_id`, `admission_date`, `nic`, `full_name`, `initials`, `surname`, `dob`, `gender`, `email`, `phone_home`, `phone_mobile`, `address`, `city`, `district_id`, `religion_id`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 1, 1, 1, '2019-09-16', '953651408V', 'Samarakkody Arachchige Lakmal Samarakkody', 'S A L', 'Samarakkody', '1995-12-30', 'Male', 'lakmalsamarakkody@gmail.com', '0332296548', '0774924351', '144/5A', 'Veyangoda', 7, 1, '2019-09-16 00:00:00', '2019-09-16 00:00:00', NULL),
(3, 3, 1, 1, '2019-09-03', '943651408V', 'SAMARAKKODY ARACHCHIGE LAKMAL SAMARAKKODY', 'SAL', 'SAMARAKKODY', '1995-12-30', 'Male', '', '', '', '267/10, Nagahakotuwa Road', 'Balummahara', NULL, NULL, '2019-09-21 19:07:50', '2019-09-21 19:07:50', NULL),
(4, 4, 1, 1, '2019-09-20', '953611408V', 'Samarakkody Arachchige Lakmal Samarakkody', 'S A L', 'Samarakkody', '1995-12-30', 'Male', '', '', '', '144/5a, 3rd lane, Palmgrove Estate', 'Veyangoda', NULL, 1, '2019-09-21 19:15:34', '2019-09-21 19:15:34', NULL);

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
(1, 1, '2019-09-27', '2019-09-27 00:00:00', '2019-09-27 00:00:00', NULL),
(2, 1, '2019-09-26', '2019-09-27 22:43:48', '2019-09-27 22:43:48', NULL),
(3, 3, '2019-09-26', '2019-09-27 22:44:08', '2019-09-27 22:44:08', NULL),
(6, 3, '2019-09-27', '2019-09-27 23:24:06', '2019-09-27 23:24:06', NULL),
(9, 3, '2019-09-20', '2019-09-27 23:26:47', '2019-09-27 23:26:47', NULL),
(10, 4, '2019-09-26', '2019-09-28 14:58:44', '2019-09-28 14:58:44', NULL);

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
(1, 'Academic', '2019-09-16 00:00:00', '2019-09-16 00:00:00', NULL),
(2, 'Non-Academic', '2019-09-16 00:00:00', '2019-09-16 00:00:00', NULL);

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

-- --------------------------------------------------------

--
-- Table structure for table `staff_timetable`
--

CREATE TABLE `staff_timetable` (
  `id` int(6) NOT NULL,
  `staff_id` int(6) NOT NULL,
  `day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') COLLATE utf8mb4_unicode_ci NOT NULL,
  `period_1` int(3) NOT NULL,
  `period_2` int(3) NOT NULL,
  `period_3` int(3) NOT NULL,
  `period_4` int(3) NOT NULL,
  `period_5` int(3) NOT NULL,
  `period_6` int(3) NOT NULL,
  `period_7` int(3) NOT NULL,
  `period_8` int(3) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'Principal', 1, '2019-09-16 00:00:00', '2019-09-16 00:00:00', NULL);

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
  `surname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female') COLLATE utf8mb4_unicode_ci NOT NULL,
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
(52, 1, '2019-09-19', 15, 'Samarakkody Arachchige Lakmal Samarakkody', 'S A L', 'Samarakkody', '1995-12-30', 'Male', NULL, NULL, '144/5A, 3rd Lane, Palmgrove Estate', 'Veyangoda', NULL, NULL, NULL, '2019-09-23 09:33:17', '2019-09-23 09:33:17', NULL),
(53, 13, '2019-09-19', 16, 'Shyamin Ayesh Fernando', 'S A', 'Fernando', '1995-01-09', 'Male', NULL, NULL, 'no 10 gorakadeniya', 'Attanagalla', NULL, NULL, NULL, '2019-09-26 18:36:24', '2019-09-26 18:36:24', NULL);

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
(1, 52, '2019-09-26', '2019-09-27 00:00:00', '2019-09-27 00:00:00', NULL),
(2, 52, '2019-09-27', '2019-09-27 00:00:00', '2019-09-27 00:00:00', NULL),
(8, 52, '2019-09-28', '2019-09-28 20:49:50', '2019-09-28 20:49:50', NULL),
(9, 53, '2019-09-28', '2019-09-28 20:51:52', '2019-09-28 20:51:52', NULL),
(10, 53, '2019-09-29', '2019-09-29 04:43:55', '2019-09-29 04:43:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_exam_results`
--

CREATE TABLE `student_exam_results` (
  `id` int(8) NOT NULL,
  `student_exam_schedule_id` int(8) NOT NULL,
  `marks` decimal(5,2) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_has_class`
--

CREATE TABLE `student_has_class` (
  `id` int(3) NOT NULL,
  `stu_id` int(6) NOT NULL,
  `class_id` int(3) NOT NULL,
  `index_no` int(2) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_has_class`
--

INSERT INTO `student_has_class` (`id`, `stu_id`, `class_id`, `index_no`, `created_on`, `updated_on`, `deleted_on`) VALUES
(12, 52, 15, 1, '2019-09-23 09:33:17', '2019-09-23 09:33:17', NULL),
(13, 53, 16, 1, '2019-09-26 18:36:24', '2019-09-26 18:36:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_has_exam_schedule`
--

CREATE TABLE `student_has_exam_schedule` (
  `id` int(8) NOT NULL,
  `student_id` int(6) NOT NULL,
  `exam_schedule_id` int(4) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_has_parent`
--

CREATE TABLE `student_has_parent` (
  `id` int(8) NOT NULL,
  `stu_id` int(6) NOT NULL,
  `parent_id` int(7) NOT NULL,
  `relation_id` int(2) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_has_parent`
--

INSERT INTO `student_has_parent` (`id`, `stu_id`, `parent_id`, `relation_id`, `created_on`, `updated_on`, `deleted_on`) VALUES
(47, 52, 4, 2, '2019-09-23 09:33:17', '2019-09-23 09:33:17', NULL),
(48, 53, 4, 2, '2019-09-26 18:36:24', '2019-09-26 18:36:24', NULL),
(49, 52, 5, 1, '2019-09-26 23:54:13', '2019-09-26 23:54:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_has_sport`
--

CREATE TABLE `student_has_sport` (
  `id` int(8) NOT NULL,
  `sport_id` int(3) NOT NULL,
  `student_id` int(6) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `stu_id` int(6) NOT NULL,
  `subject_id` int(3) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_health`
--

CREATE TABLE `student_health` (
  `id` int(11) NOT NULL,
  `student_id` int(6) NOT NULL,
  `height` int(3) DEFAULT NULL,
  `weight` int(3) DEFAULT NULL,
  `date` date NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(3) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `si_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `name`, `si_name`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 'English', '', '2019-09-21 04:28:43', '2019-09-21 04:28:43', NULL),
(2, 'Sinhala', '', '2019-09-21 04:32:43', '2019-09-21 04:32:43', NULL),
(3, 'vrev', 'ස්ස්ව්ස්ද්බ්ස්බ්', '2019-09-21 04:53:19', '2019-09-21 04:53:19', NULL),
(4, 'Tamil', NULL, '2019-09-22 00:22:56', '2019-09-22 00:22:56', NULL),
(5, 'Maths', NULL, '2019-09-22 00:23:31', '2019-09-22 00:23:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(7) NOT NULL,
  `staff_id` int(6) DEFAULT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(2) NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `staff_id`, `username`, `password`, `email`, `role_id`, `status`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, NULL, 'lakmal', '$2y$10$0eN9so5Lv903qDKASkGarO9gfmxjZYbD1ejbfnh.aV0fEveidJbBi', NULL, 1, 'Active', '2019-09-02 00:00:00', '2019-09-02 00:00:00', NULL),
(2, NULL, 'shyamin', '$2y$10$ytMjTxGVq98xm26dXEHk5uctnqLP2.43NXbxGOsPXBattZ//S8hcG', 'me@shyamin.com', 1, 'Active', '2019-09-18 08:57:14', '2019-09-18 08:57:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

CREATE TABLE `user_permission` (
  `id` int(2) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(2) NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 'System Administrator', '2019-09-02 00:00:00', '2019-09-02 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_role_has_permission`
--

CREATE TABLE `user_role_has_permission` (
  `id` int(4) NOT NULL,
  `role_id` int(2) NOT NULL,
  `permission_id` int(2) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  ADD UNIQUE KEY `class_id` (`class_id`,`day`),
  ADD KEY `day_id` (`day`);

--
-- Indexes for table `coach`
--
ALTER TABLE `coach`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nic` (`nic`);

--
-- Indexes for table `coach_has_sport`
--
ALTER TABLE `coach_has_sport`
  ADD PRIMARY KEY (`id`),
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
-- Indexes for table `health`
--
ALTER TABLE `health`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `staff_religion_id_fk` (`religion_id`),
  ADD KEY `staff_ibfk_3` (`category_id`);

--
-- Indexes for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`staff_id`,`date`);

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
-- Indexes for table `staff_timetable`
--
ALTER TABLE `staff_timetable`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_id` (`staff_id`,`day`),
  ADD KEY `day_id` (`day`);

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
  ADD KEY `student_ibfk_2` (`class_id`);

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
-- Indexes for table `student_exam_results`
--
ALTER TABLE `student_exam_results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_exam_schedule_id` (`student_exam_schedule_id`);

--
-- Indexes for table `student_has_class`
--
ALTER TABLE `student_has_class`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stu_id` (`stu_id`,`class_id`),
  ADD UNIQUE KEY `class_id` (`class_id`,`index_no`);

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
  ADD UNIQUE KEY `stu_id` (`stu_id`,`parent_id`),
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
  ADD UNIQUE KEY `stu_id` (`stu_id`,`subject_id`),
  ADD KEY `student_has_subject_ibfk_2` (`subject_id`);

--
-- Indexes for table `student_health`
--
ALTER TABLE `student_health`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stu_id` (`student_id`,`date`);

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
  ADD UNIQUE KEY `stu_staff_parent_id` (`staff_id`,`role_id`),
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
  ADD UNIQUE KEY `role` (`role`);

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
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `class_timetable`
--
ALTER TABLE `class_timetable`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coach`
--
ALTER TABLE `coach`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coach_has_sport`
--
ALTER TABLE `coach_has_sport`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `exam_grade_has_schedule`
--
ALTER TABLE `exam_grade_has_schedule`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `exam_has_grade`
--
ALTER TABLE `exam_has_grade`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `exam_type`
--
ALTER TABLE `exam_type`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `health`
--
ALTER TABLE `health`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parent`
--
ALTER TABLE `parent`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `relation_type`
--
ALTER TABLE `relation_type`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `religion`
--
ALTER TABLE `religion`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sport`
--
ALTER TABLE `sport`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `staff_category`
--
ALTER TABLE `staff_category`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staff_has_subject`
--
ALTER TABLE `staff_has_subject`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_timetable`
--
ALTER TABLE `staff_timetable`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_type`
--
ALTER TABLE `staff_type`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `student_achievement`
--
ALTER TABLE `student_achievement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_attendance`
--
ALTER TABLE `student_attendance`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `student_exam_results`
--
ALTER TABLE `student_exam_results`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_has_class`
--
ALTER TABLE `student_has_class`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `student_has_exam_schedule`
--
ALTER TABLE `student_has_exam_schedule`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_has_parent`
--
ALTER TABLE `student_has_parent`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `student_has_sport`
--
ALTER TABLE `student_has_sport`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_has_sport_achievement`
--
ALTER TABLE `student_has_sport_achievement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_has_subject`
--
ALTER TABLE `student_has_subject`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_health`
--
ALTER TABLE `student_health`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_role_has_permission`
--
ALTER TABLE `user_role_has_permission`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `class_timetable_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `exam_has_grade_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_has_grade_ibfk_2` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `health`
--
ALTER TABLE `health`
  ADD CONSTRAINT `health_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `parent`
--
ALTER TABLE `parent`
  ADD CONSTRAINT `parent_district_id_fk` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_district_id_fk` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`religion_id`) REFERENCES `religion` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `staff_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `staff_type` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `staff_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `staff_category` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  ADD CONSTRAINT `staff_attendance_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `staff_has_subject`
--
ALTER TABLE `staff_has_subject`
  ADD CONSTRAINT `staff_has_subject_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `staff_has_subject_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff_timetable`
--
ALTER TABLE `staff_timetable`
  ADD CONSTRAINT `staff_timetable_staff_id_fk` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `student_achievement_student_id_fk` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_attendance`
--
ALTER TABLE `student_attendance`
  ADD CONSTRAINT `student_attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_exam_results`
--
ALTER TABLE `student_exam_results`
  ADD CONSTRAINT `student_exam_results_ibfk_1` FOREIGN KEY (`student_exam_schedule_id`) REFERENCES `student_has_exam_schedule` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `student_has_class`
--
ALTER TABLE `student_has_class`
  ADD CONSTRAINT `student_has_class_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_has_class_ibfk_2` FOREIGN KEY (`stu_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_has_exam_schedule`
--
ALTER TABLE `student_has_exam_schedule`
  ADD CONSTRAINT `student_has_exam_schedule_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_has_exam_schedule_ibfk_2` FOREIGN KEY (`exam_schedule_id`) REFERENCES `exam_grade_has_schedule` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `student_has_parent`
--
ALTER TABLE `student_has_parent`
  ADD CONSTRAINT `student_has_parent_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `parent` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_has_parent_ibfk_2` FOREIGN KEY (`stu_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_has_parent_ibfk_3` FOREIGN KEY (`relation_id`) REFERENCES `relation_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `student_has_subject_ibfk_1` FOREIGN KEY (`stu_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_has_subject_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `student_health`
--
ALTER TABLE `student_health`
  ADD CONSTRAINT `student_health_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_staff_id_fk` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_role_has_permission`
--
ALTER TABLE `user_role_has_permission`
  ADD CONSTRAINT `user_role_has_permission_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `user_permission` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_role_has_permission_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
