-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2023 at 12:41 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bdms`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `msg` text NOT NULL,
  `sent_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `username`, `email`, `mobile`, `msg`, `sent_at`) VALUES
(1, 'Adil', 'adcheema85@gmail.com', '03486717316', 'Hello. This is Adil.', '2023-09-14 15:37:27');

-- --------------------------------------------------------

--
-- Table structure for table `donate_blood`
--

CREATE TABLE `donate_blood` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `age` int(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `blood_quantity` int(255) NOT NULL,
  `blood_group` varchar(255) NOT NULL,
  `sent_at` datetime NOT NULL DEFAULT current_timestamp(),
  `request_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donate_blood`
--

INSERT INTO `donate_blood` (`id`, `username`, `age`, `gender`, `blood_quantity`, `blood_group`, `sent_at`, `request_type`) VALUES
(1, 'Ali', 25, 'Male', 23, 'AB+', '2023-09-13 12:30:01', ''),
(2, 'Ali', 25, 'Male', 12, 'A+', '2023-09-13 12:36:43', ''),
(3, 'Ali', 25, 'Male', 100, 'B-', '2023-09-13 12:42:25', 'Donation Request'),
(4, 'Hamza', 67, 'Male', 12, 'A+', '2023-09-13 12:56:13', 'Donation Request');

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

CREATE TABLE `donors` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `gender` varchar(255) NOT NULL,
  `cnic` varchar(255) NOT NULL,
  `age` int(255) NOT NULL,
  `blood_group` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`id`, `username`, `password`, `email`, `mobile`, `address`, `gender`, `cnic`, `age`, `blood_group`, `created_at`) VALUES
(1, 'Ad', '$2y$10$nuEu23Ps5r5WJODEVfQlmunqydjorFGpzlrah/ntKNAHFY8jf85iy', '3460404333643', '03486717316', 'Sialkot', 'Male', 'adcheema@live.com', 23, 'A+', '2023-09-13 12:16:06'),
(2, 'Ha', '$2y$10$oLc7CkTNu5WpGRF3LIoWieR7SiibUXQfAjew9HZjAVfvBWQSO0vp2', '3460404333643', '03456669683', 'Sialkot', 'Male', 'hamza@hamza.com', 25, 'A+', '2023-09-13 12:20:13'),
(3, 'Ali', '$2y$10$cP35Ojn7jkY4hjnWD7KubO7on/9zd9qAn3th/bfYresyrvZ2BsYnG', 'ad@ad.com', '03486717316', 'Arifwala', 'Male', '3460404333643', 25, 'A+', '2023-09-13 12:27:05'),
(4, 'Hamza', '$2y$10$LW30iJ6QkMgbw9Y5XLcaCeiX4gkYvy2cAxgS1ldFiZpWd3l5Y5uoC', 'hamza@hamza.com', '03333333333', 'Attock', 'Male', '3460000000000', 67, 'A+', '2023-09-13 12:55:40');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `age` int(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `feedback` text NOT NULL,
  `sent_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `username`, `age`, `gender`, `feedback`, `sent_at`) VALUES
(1, 'Hamza', 67, 'Male', 'This is my feedback', '2023-09-13 14:05:06');

-- --------------------------------------------------------

--
-- Table structure for table `request_blood`
--

CREATE TABLE `request_blood` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `age` int(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `blood_quantity` int(255) NOT NULL,
  `blood_group` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `request_type` varchar(255) NOT NULL,
  `sent_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_blood`
--

INSERT INTO `request_blood` (`id`, `username`, `age`, `gender`, `blood_quantity`, `blood_group`, `reason`, `request_type`, `sent_at`) VALUES
(1, 'Ali', 25, 'Male', 12, 'A-', 'asdasd', 'Blood Request', '2023-09-13 12:37:04'),
(2, 'Hamza', 67, 'Male', 25, 'A-', 'sadasd', 'Blood Request', '2023-09-13 12:56:23'),
(3, 'Adil', 0, '', 12, 'A-', 'asdasdas', 'Blood Request', '2023-09-14 15:34:32');

-- --------------------------------------------------------

--
-- Table structure for table `seekers`
--

CREATE TABLE `seekers` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cnic` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seekers`
--

INSERT INTO `seekers` (`id`, `username`, `password`, `cnic`, `email`, `address`, `mobile`, `gender`, `created_at`) VALUES
(1, 'Adil', '$2y$10$Do9eMWHlpPuc5yMX4jmQ1e6qnKb68MsT4XjpnOC8yPv.B6iJjUvGC', 'adcheema@live.com', '3460404333643', 'Sialkot', '03486717316', 'Male', '2023-09-13 12:12:23'),
(2, 'Hamza', '$2y$10$a4NeaNleLoqnxuuK0GL.F.1X81qgbajJ73qedP2NgvPScUrZ1xBXC', '3460400000000', 'hamza@hamza.com', 'Bhalwal', '03333333333', 'Male', '2023-09-13 14:12:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donate_blood`
--
ALTER TABLE `donate_blood`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_blood`
--
ALTER TABLE `request_blood`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seekers`
--
ALTER TABLE `seekers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `donate_blood`
--
ALTER TABLE `donate_blood`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `request_blood`
--
ALTER TABLE `request_blood`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `seekers`
--
ALTER TABLE `seekers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
