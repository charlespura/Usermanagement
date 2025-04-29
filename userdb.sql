-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 18, 2025 at 05:44 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `userdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `full_name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'user', 'user', 'user@gmail.com', '$2y$10$76upV15IBjDYtBSefrO3UuMQKXDwHPxgbLrQjJfzCUHZTsBogL4bO', 'user', '2025-04-16 13:59:00', '2025-04-16 14:46:38'),
(2, 'admin', 'admin', 'admin@gmail.com', '$2y$10$MIou3UvBdDEQuxuVqjbIQOvHlfUKQh3kragh1eBhP2IVd7Wp79uyK', 'admin', '2025-04-16 14:07:19', '2025-04-16 14:08:15');

-- --------------------------------------------------------

--
-- Table structure for table `user_changes`
--

CREATE TABLE `user_changes` (
  `change_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `field_changed` varchar(50) DEFAULT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_changes`
--

INSERT INTO `user_changes` (`change_id`, `user_id`, `field_changed`, `old_value`, `new_value`, `changed_at`) VALUES
(1, 1, 'username', 'user', 'userr', '2025-04-16 14:02:34'),
(2, 1, 'username', 'userr', 'user', '2025-04-16 14:02:42'),
(3, 1, 'username', 'user', 'userr', '2025-04-16 14:04:31'),
(4, 1, 'username', 'userr', 'userrr', '2025-04-16 14:05:40'),
(5, 1, 'username', 'userrr', 'user', '2025-04-16 14:05:58');

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_time` datetime DEFAULT current_timestamp(),
  `logout_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_sessions`
--

INSERT INTO `user_sessions` (`session_id`, `user_id`, `login_time`, `logout_time`) VALUES
(1, 1, '2025-04-16 21:59:07', '2025-04-16 22:06:01'),
(2, 2, '2025-04-16 22:07:31', NULL),
(3, 2, '2025-04-16 22:08:18', '2025-04-16 22:11:54'),
(4, 2, '2025-04-16 22:12:00', NULL),
(5, 2, '2025-04-16 22:12:09', NULL),
(6, 2, '2025-04-16 22:12:52', NULL),
(7, 2, '2025-04-16 22:12:57', '2025-04-16 22:12:58'),
(8, 2, '2025-04-16 22:13:06', '2025-04-16 22:13:15'),
(9, 2, '2025-04-16 22:13:31', '2025-04-16 22:47:53'),
(10, 1, '2025-04-16 22:47:59', '2025-04-17 00:08:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_changes`
--
ALTER TABLE `user_changes`
  ADD PRIMARY KEY (`change_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_changes`
--
ALTER TABLE `user_changes`
  MODIFY `change_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_changes`
--
ALTER TABLE `user_changes`
  ADD CONSTRAINT `user_changes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `user_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
