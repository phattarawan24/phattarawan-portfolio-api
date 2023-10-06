-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 06, 2023 at 11:51 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `expericence`
--

CREATE TABLE `expericence` (
  `id` int NOT NULL,
  `date` text NOT NULL,
  `title` text NOT NULL,
  `detail` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `expericence`
--

INSERT INTO `expericence` (`id`, `date`, `title`, `detail`, `type`) VALUES
(7, '2020-ปัจจุบัน', 'Walilak University', 'Computer Enginerring', 1),
(9, '2023', 'Internship Web Developer', 'BFS Company', 0);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `img` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `first_name`, `last_name`, `phone`, `email`, `birthday`, `img`) VALUES
(1, 'p', 'k', '0805231153', 'neneoil08@gmail.com', '2013-10-21', ''),
(3, 'ปาณิสรา', 'อินทรประสิทธิ์', '022745855', 'neneoil08@gmail.com', '2001-12-24', NULL),
(4, 'ปาณิสรา', 'อินทรประสิทธิ์', '022745855', 'neneoil08@gmail.com', '2001-12-24', NULL),
(5, 'ปาณิสรา', 'อินทรประสิทธิ์', '022745855', 'neneoil08@gmail.com', '2001-12-24', NULL),
(6, 'วีรชัย', 'วงศ์เจริญ', '0521463487', 'neneoil08@gmail.com', '2001-12-24', NULL),
(7, 'วีรชัย', 'วงศ์เจริญ', '0521463487', 'neneoil08@gmail.com', '2001-12-24', NULL),
(9, 'Phattarawan', 'Kreetawech', '0805231153', 'phattarawan.k@gmail.com', '2001-12-24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int NOT NULL,
  `title` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `level` varchar(5) NOT NULL,
  `created` timestamp NOT NULL,
  `updated` timestamp NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `title`, `level`, `created`, `updated`, `type`) VALUES
(1, 'CSS', '45', '2023-10-04 05:06:33', '2023-10-05 07:13:55', 0),
(2, 'Javascript', '50', '2023-10-05 02:09:43', '2023-10-05 07:09:45', 0),
(3, 'html', '40', '2023-10-05 02:11:02', '2023-10-05 02:28:50', 0),
(5, 'PHP', '60', '2023-10-05 04:27:52', '2023-10-05 07:10:12', 1),
(6, 'Flutter', '30', '2023-10-05 07:13:27', '2023-10-05 07:13:27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `phone`) VALUES
(3, 'phattarawan', 'kreetawech', '0805231153'),
(4, 'p', 'k', '1'),
(5, '54', '87/95421', '9588888'),
(6, 'p', 'k', '88888'),
(7, 'วีรชัย', 'วงศ์เจริญ', '0521463487');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expericence`
--
ALTER TABLE `expericence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
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
-- AUTO_INCREMENT for table `expericence`
--
ALTER TABLE `expericence`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
