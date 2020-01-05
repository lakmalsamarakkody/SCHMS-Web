-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 05, 2020 at 12:11 AM
-- Server version: 10.1.41-MariaDB-0+deb9u1
-- PHP Version: 7.3.9-1+0~20190902.44+debian9~1.gbpf8534c

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
(1, 1, NULL, 'A', '2019-12-11 05:30:20', '2019-12-11 05:30:20', NULL),
(2, 1, NULL, 'B', '2019-12-14 21:43:14', '2019-12-14 21:43:14', NULL),
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
(1, 1, '2019-12-11 05:29:05', '2019-12-11 05:29:05', NULL),
(2, 2, '2019-12-11 05:29:10', '2019-12-11 05:29:10', NULL),
(3, 3, '2019-12-11 05:29:16', '2019-12-11 05:29:16', NULL),
(4, 4, '2019-12-11 05:29:21', '2019-12-11 05:29:21', NULL),
(5, 5, '2019-12-11 05:29:26', '2019-12-11 05:29:26', NULL),
(6, 6, '2019-12-11 05:29:31', '2019-12-11 05:29:31', NULL),
(7, 7, '2019-12-11 05:29:40', '2019-12-11 05:29:40', NULL),
(8, 8, '2019-12-11 05:29:45', '2019-12-11 05:29:45', NULL),
(9, 9, '2019-12-11 05:29:50', '2019-12-11 05:29:50', NULL),
(10, 10, '2019-12-11 05:29:55', '2019-12-11 05:29:55', NULL),
(11, 11, '2019-12-11 05:30:00', '2019-12-11 05:30:00', NULL);

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
(14, 14, 4, '2016-02-16', '198643516723', 'Narangoda Arachchige Dhammika Narangoda', 'N A D', 'Narangoda', '1986-06-15', 'Female', 'narangoda90@gmail.com', NULL, '0778520133', '182/27, Kotugoda road', 'Minuwangoda', 1, 1, '2020-01-04 20:51:38', '2020-01-04 20:51:38', NULL),
(15, 15, 5, '2016-08-13', '198926341566', 'Withana Arachcilage Kanishka Sampath Withanage', 'W A K S', 'Withanage', '1989-01-24', 'Male', 'sampathwithanage@gmail.com', '339856314', '0712058630', '128/5, Temple road', 'Gampaha', 1, 1, '2020-01-04 20:55:39', '2020-01-04 20:55:39', NULL),
(16, 16, 6, '2014-05-12', '198632497641', 'Madusinghe Arachchige Thanuja Lakmali Madusinghe', 'M A T L', 'Madusinghe', '1986-06-13', 'Female', 'thanujalakali@gmail.com', NULL, '0774569863', '155/5, Siyane road', 'Yatiyana', 1, 1, '2020-01-04 21:12:27', '2020-01-04 21:12:27', NULL),
(17, 17, 8, '2015-12-03', '198723184221', 'Ranasighe Arachchige Sampath Ranasinghe', 'R A S', 'Ranasinghe', '1987-04-17', 'Male', NULL, NULL, '0704569631', '963/12, Gurugoda road', 'Balummahara', 1, 1, '2020-01-04 21:14:36', '2020-01-04 21:14:36', NULL),
(18, 18, 7, '2016-04-05', '198210865234', 'Yawadana Dewage Nihal Samarasighe', 'Y D N', 'Samarasighe', '1982-02-20', 'Male', NULL, NULL, '0758521305', '119/6, Sanhida Mawatha', 'Minuwangoda', 1, 1, '2020-01-04 21:17:15', '2020-01-04 21:17:15', NULL);

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
(9, 'Security Officer', 3, '2020-01-04 19:37:10', '2020-01-04 19:37:10', NULL);

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
(1, 1, '2019-01-07', 1, 'Ruwanpathirana Arachchige Abhishma Ruwanpathirana', 'R A A', 'Ruwanpathirana', '2013-12-02', 'female', NULL, NULL, '267/10, Nagahakotuwa road', 'Gampaha', NULL, 1, 1, '2019-12-14 14:15:29', '2019-12-14 14:15:29', NULL),
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
(239, 110, '2020-01-03', '2020-01-03 06:53:27', '2020-01-03 06:53:27', NULL);

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
(1, 1, 1, 1, '2019-12-14 14:15:29', '2019-12-14 14:15:29', NULL),
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
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `ref_id`, `user_type`, `username`, `password`, `theme`, `role_id`, `status`, `created_on`, `updated_on`, `deleted_on`) VALUES
(1, 1, 'student', 'admin', '$2y$10$M6vZ2RswJ/OthfJMTRQoruycfUr.ehD4kq5G8rC08FfVg3eGZUHTK', 'Default', 1, 'Active', '2019-02-20 00:00:00', '2020-01-03 07:01:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

CREATE TABLE `user_permission` (
  `id` int(3) NOT NULL,
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_grade_has_schedule`
--
ALTER TABLE `exam_grade_has_schedule`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_has_grade`
--
ALTER TABLE `exam_has_grade`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_type`
--
ALTER TABLE `exam_type`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_category`
--
ALTER TABLE `staff_category`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff_has_subject`
--
ALTER TABLE `staff_has_subject`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_type`
--
ALTER TABLE `staff_type`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `student_has_class`
--
ALTER TABLE `student_has_class`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `student_has_exam_schedule`
--
ALTER TABLE `student_has_exam_schedule`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_has_parent`
--
ALTER TABLE `student_has_parent`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

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
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_role_has_permission`
--
ALTER TABLE `user_role_has_permission`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `user_role_has_permission_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `user_permission` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_role_has_permission_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
