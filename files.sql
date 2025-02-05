-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2025 at 06:43 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(30) NOT NULL,
  `folder_id` int(30) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_path` text NOT NULL,
  `is_public` tinyint(1) DEFAULT '0',
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `name`, `description`, `user_id`, `folder_id`, `file_type`, `file_path`, `is_public`, `date_updated`) VALUES
(3, 'sample', 'Sample PDF Document', 3, 9, 'pdf', '1600330200_sample.pdf', 0, '2020-09-17 16:10:25'),
(5, 'ajax_tutorialk', 'test2', 4, 10, 'pdf', '1733216520_ajax_tutorial.pdf', 0, '2025-02-03 15:52:34'),
(7, 'Screenshot (3)', '', 4, 11, 'png', '1738055100_Screenshot (3).png', 1, '2025-02-03 13:24:39'),
(11, 'signature', '', 4, 12, 'JPG', '1738562160_signature.JPG', 0, '2025-02-03 13:56:12'),
(12, 'Weekly Journal Guide Questions', '', 4, 10, 'doc', '1738568340_Weekly Journal Guide Questions.doc', 0, '2025-02-03 15:39:03'),
(13, 'Screenshot (4)', '', 1, 1, 'png', '1738655640_Screenshot (4).png', 0, '2025-02-04 15:54:01'),
(14, 'ss_aiko', 'ss', 5, 13, 'png', '1738732620_Screenshot (1) (1).png', 1, '2025-02-05 13:20:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
