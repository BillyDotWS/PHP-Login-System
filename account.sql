-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2022 at 11:00 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `account`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'testuser', '$2y$10$64Nh8rZFUrdp3t.G0Mdm1.TQhLGODpLy9kjDvzsyiVJQY2lLdJKii', '2022-05-20 01:50:23', '2022-05-19 22:51:14'),
(2, 'testuser3', '$2y$10$8MqWIJV62zEW4E17HFVr7Osk/gB0nf0KBpKCZz1vPQEdWcEBW9C0a', '2022-05-20 01:53:26', '2022-05-19 22:53:59');

-- --------------------------------------------------------

--
-- Table structure for table `user_password`
--

CREATE TABLE `user_password` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_password`
--

INSERT INTO `user_password` (`id`, `user_id`, `password`) VALUES
(1, 1, '$2y$10$E.Mf0Eao3ChM6.ZaQZK2oOye10m6BcfGJIH/E3vkZzLEYOeL6txzi'),
(2, 1, '$2y$10$64Nh8rZFUrdp3t.G0Mdm1.TQhLGODpLy9kjDvzsyiVJQY2lLdJKii'),
(3, 2, '$2y$10$.PFkOB06qMeLJWqSbX4SuedPNt.4JK4ZDNsY1aiY8DFEv8Cnom6Yy'),
(4, 2, '$2y$10$8MqWIJV62zEW4E17HFVr7Osk/gB0nf0KBpKCZz1vPQEdWcEBW9C0a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_password`
--
ALTER TABLE `user_password`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_password`
--
ALTER TABLE `user_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
