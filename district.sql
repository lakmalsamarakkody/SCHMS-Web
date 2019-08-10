-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 10, 2019 at 01:01 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.7

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
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `id` int(2) NOT NULL,
  `district` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province_id` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`id`, `district`, `province_id`) VALUES
(1, 'Ampara', 0),
(2, 'Anuradhapura', 0),
(3, 'Badulla', 0),
(4, 'Batticaloa', 0),
(5, 'Colombo', 0),
(6, 'Galle', 0),
(7, 'Gampaha', 0),
(8, 'Hambantota', 0),
(9, 'Jaffna', 0),
(10, 'Kalutara', 0),
(11, 'Kandy', 0),
(12, 'Kegalle', 0),
(13, 'Kilinochchi', 0),
(14, 'Kurunegala', 0),
(15, 'Mannar', 0),
(16, 'Matale', 0),
(17, 'Matara', 0),
(18, 'Monaragala', 0),
(19, 'Mullaitivu', 0),
(20, 'Nuwara Eliya', 0),
(21, 'Polonnaruwa', 0),
(22, 'Puttalam', 0),
(23, 'Ratnapura', 0),
(24, 'Trincomalee', 0),
(25, 'Vavuniya', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
