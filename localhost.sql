-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 14, 2021 at 06:57 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `om`
--
CREATE DATABASE IF NOT EXISTS `om` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `om`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(500) NOT NULL,
  `address` varchar(500) NOT NULL,
  `phonenumber` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `post_image` varchar(500) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `user_id`, `name`, `address`, `phonenumber`, `email`, `post_image`, `created_on`) VALUES
(20, 1, 'Orange', '12- 0100 Nairobi - Kenya', '0733987987', 'orange@help.com', 'orange.png', '2021-09-04 17:01:48'),
(21, 1, 'Safaricom', '456 - 0100 Nairobi - Kenya', '0700900345', 'saf@help.com', 'saf.png', '2021-09-04 17:01:48'),
(22, 1, 'Telkom', '233 - 0100 Nairobi - Kenya', '0772111100', 'telcom@help.co.ke', 'telcom.png', '2021-09-04 17:01:48'),
(23, 0, 'ling', '456 Tao', '1234567890', 'ling@g.com', '', '2021-10-12 22:19:05'),
(24, 0, 'ling', '456 Tao', '1234567890', 'ling@g.com', '', '2021-10-13 20:59:05'),
(25, NULL, 'ling', '456 Tao', '1234567890', 'ling@g.com', NULL, '2021-10-14 07:39:05'),
(26, NULL, 'ling', '456 Tao', '1234567890', 'ling@g.com', NULL, '2021-10-14 16:29:04');

-- --------------------------------------------------------

--
-- Table structure for table `opportunities`
--

CREATE TABLE `opportunities` (
  `account_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `amount` varchar(250) NOT NULL,
  `stage` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `opportunities`
--

INSERT INTO `opportunities` (`account_id`, `id`, `user_id`, `name`, `amount`, `stage`) VALUES
(21, 18, 1, 'Safaricom Fiber Installation', 'Ksh 100,000', 'Discovery'),
(22, 19, 1, 'Telkom Advertisement', 'Ksh 400,000', 'Discovery'),
(21, 20, 1, 'Kipling', 'Ksh 10,000', 'Discovery');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` text NOT NULL,
  `registered_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `registered_on`) VALUES
(1, 'Kelvin Kiprotich', 'Kipling27', 'ling@icloud.com', 'e10adc3949ba59abbe56e057f20f883e', '2021-09-02 00:48:50'),
(2, 'John Doe', 'Doe123', 'doe@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2021-09-02 11:25:59'),
(3, 'Test Test', 'Test1', 'test@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2021-09-03 15:07:01'),
(4, 'Test Test Test', 'Test2', 'test2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2021-09-03 15:09:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opportunities`
--
ALTER TABLE `opportunities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `opportunities`
--
ALTER TABLE `opportunities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
