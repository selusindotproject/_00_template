-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 29, 2021 at 11:57 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tamu`
--

-- --------------------------------------------------------

--
-- Table structure for table `t00_package`
--

CREATE TABLE `t00_package` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `s3rates` double NOT NULL,
  `s3reg` double NOT NULL,
  `s3fem` double NOT NULL,
  `s6rates` double NOT NULL,
  `s6reg` double NOT NULL,
  `s6fem` double NOT NULL,
  `s3ext` double NOT NULL,
  `p1nl` double NOT NULL,
  `p1nd` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t85_users`
--

CREATE TABLE `t85_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t85_users`
--

INSERT INTO `t85_users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$10$luNkCgNMZ8YjUHKPTtcKd.6wqJKBaRNFaq9Yac/FueCViXJ5d6Vu6', 'admin@admin.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1632908987, 1, 'Admin', 'istrator', 'ADMIN', '082266778878'),
(2, '::1', NULL, '$2y$10$Gs6SdwqoW5CxvTd3sfpJXep0PXRHJN54hkdUK9XLaP1SHXY/wET9G', 'vcsit@vistacontainer.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1632902312, 1632908972, 1, 'Dodo', 'Ananto', 'VCS', '03199241533');

-- --------------------------------------------------------

--
-- Table structure for table `t86_groups`
--

CREATE TABLE `t86_groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t86_groups`
--

INSERT INTO `t86_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User'),
(3, 'dom', 'Domestik'),
(4, 'eks', 'Ekspor'),
(5, 'mar', 'Marketing'),
(6, 'doc', 'Document Control'),
(7, 'it', 'IT');

-- --------------------------------------------------------

--
-- Table structure for table `t87_users_groups`
--

CREATE TABLE `t87_users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t87_users_groups`
--

INSERT INTO `t87_users_groups` (`id`, `user_id`, `group_id`) VALUES
(11, 1, 1),
(12, 1, 2),
(23, 2, 2),
(24, 2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `t88_login_attempts`
--

CREATE TABLE `t88_login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t88_login_attempts`
--

INSERT INTO `t88_login_attempts` (`id`, `ip_address`, `login`, `time`) VALUES
(2, '::1', 'admin@admin.co.id', 1632842280);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t00_package`
--
ALTER TABLE `t00_package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t85_users`
--
ALTER TABLE `t85_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_email` (`email`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`);

--
-- Indexes for table `t86_groups`
--
ALTER TABLE `t86_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t87_users_groups`
--
ALTER TABLE `t87_users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Indexes for table `t88_login_attempts`
--
ALTER TABLE `t88_login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t00_package`
--
ALTER TABLE `t00_package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t85_users`
--
ALTER TABLE `t85_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t86_groups`
--
ALTER TABLE `t86_groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `t87_users_groups`
--
ALTER TABLE `t87_users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `t88_login_attempts`
--
ALTER TABLE `t88_login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t87_users_groups`
--
ALTER TABLE `t87_users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `t86_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `t85_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
