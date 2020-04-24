-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2020 at 12:13 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `njofa_market`
--

-- --------------------------------------------------------

--
-- Table structure for table `nj_mp_banners`
--

CREATE TABLE `nj_mp_banners` (
  `id` int(11) NOT NULL,
  `usid` varchar(25) NOT NULL,
  `avatar` text NOT NULL,
  `link` text NOT NULL,
  `description` text NOT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '1',
  `type` enum('user','page','advert') NOT NULL DEFAULT 'user' COMMENT 'U = User, P = page, a = Advert',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `nj_mp_contacts`
--

CREATE TABLE `nj_mp_contacts` (
  `id` int(11) NOT NULL,
  `usid` varchar(25) NOT NULL,
  `title` varchar(100) DEFAULT 'Default',
  `code` varchar(4) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `country` varchar(20) DEFAULT NULL,
  `state` varchar(25) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `nj_mp_images`
--

CREATE TABLE `nj_mp_images` (
  `id` int(11) NOT NULL,
  `usid` varchar(25) NOT NULL,
  `original` text DEFAULT NULL,
  `medium` text DEFAULT NULL,
  `small` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `file_type` varchar(25) NOT NULL,
  `file_size` varchar(25) NOT NULL,
  `file_dimensions` varchar(50) DEFAULT NULL,
  `user_type` enum('1','2','3','4') NOT NULL DEFAULT '1' COMMENT '1 = user, 2 = page, 3 = visitor',
  `file_log` text NOT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `nj_mp_pages`
--

CREATE TABLE `nj_mp_pages` (
  `id` int(11) NOT NULL,
  `npid` varchar(25) NOT NULL COMMENT 'nsid = Njofa shop identifier',
  `name` varchar(255) NOT NULL,
  `slurp` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `excerpt` text NOT NULL,
  `logo` int(11) NOT NULL,
  `type` varchar(11) NOT NULL,
  `creator` varchar(25) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `nj_mp_page_admins`
--

CREATE TABLE `nj_mp_page_admins` (
  `id` int(11) NOT NULL,
  `page` varchar(25) NOT NULL,
  `user` varchar(25) NOT NULL,
  `role` enum('manager','keeper','relation') NOT NULL DEFAULT 'relation',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('0','1','2','3') NOT NULL DEFAULT '1' COMMENT '0 = not accepted 1 accepted, 2 suspended, 3 user deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `nj_mp_page_admin_activities`
--

CREATE TABLE `nj_mp_page_admin_activities` (
  `id` int(11) NOT NULL,
  `user` varchar(25) NOT NULL,
  `action` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `page` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `nj_mp_page_badges`
--

CREATE TABLE `nj_mp_page_badges` (
  `id` int(11) NOT NULL,
  `page` varchar(25) NOT NULL,
  `badge` enum('verify','location','phone','email','affiliate') NOT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `nj_mp_page_galleries`
--

CREATE TABLE `nj_mp_page_galleries` (
  `id` int(11) NOT NULL,
  `page` int(11) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT 'Default',
  `description` mediumtext DEFAULT NULL,
  `cover` int(11) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `nj_mp_page_gallery_photos`
--

CREATE TABLE `nj_mp_page_gallery_photos` (
  `id` int(11) NOT NULL,
  `gid` varchar(25) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `nj_mp_page_social_media`
--

CREATE TABLE `nj_mp_page_social_media` (
  `id` int(11) NOT NULL,
  `page` varchar(24) NOT NULL,
  `website` varchar(12) NOT NULL,
  `link` text NOT NULL,
  `type` enum('social','shop') NOT NULL DEFAULT 'social',
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `nj_mp_page_types`
--

CREATE TABLE `nj_mp_page_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `avatar` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nj_mp_banners`
--
ALTER TABLE `nj_mp_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nj_mp_contacts`
--
ALTER TABLE `nj_mp_contacts`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `nj_mp_contacts` ADD FULLTEXT KEY `email` (`email`);
ALTER TABLE `nj_mp_contacts` ADD FULLTEXT KEY `country` (`country`,`state`,`city`,`address`);

--
-- Indexes for table `nj_mp_images`
--
ALTER TABLE `nj_mp_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nj_mp_pages`
--
ALTER TABLE `nj_mp_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nsid` (`npid`);
ALTER TABLE `nj_mp_pages` ADD FULLTEXT KEY `nsid_2` (`npid`);

--
-- Indexes for table `nj_mp_page_admins`
--
ALTER TABLE `nj_mp_page_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nj_mp_page_admin_activities`
--
ALTER TABLE `nj_mp_page_admin_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nj_mp_page_badges`
--
ALTER TABLE `nj_mp_page_badges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nj_mp_page_galleries`
--
ALTER TABLE `nj_mp_page_galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nj_mp_page_gallery_photos`
--
ALTER TABLE `nj_mp_page_gallery_photos`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `nj_mp_page_gallery_photos` ADD FULLTEXT KEY `description` (`description`);

--
-- Indexes for table `nj_mp_page_social_media`
--
ALTER TABLE `nj_mp_page_social_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nj_mp_page_types`
--
ALTER TABLE `nj_mp_page_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nj_mp_banners`
--
ALTER TABLE `nj_mp_banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nj_mp_contacts`
--
ALTER TABLE `nj_mp_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nj_mp_images`
--
ALTER TABLE `nj_mp_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nj_mp_pages`
--
ALTER TABLE `nj_mp_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nj_mp_page_admins`
--
ALTER TABLE `nj_mp_page_admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nj_mp_page_admin_activities`
--
ALTER TABLE `nj_mp_page_admin_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nj_mp_page_badges`
--
ALTER TABLE `nj_mp_page_badges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nj_mp_page_galleries`
--
ALTER TABLE `nj_mp_page_galleries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nj_mp_page_gallery_photos`
--
ALTER TABLE `nj_mp_page_gallery_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nj_mp_page_social_media`
--
ALTER TABLE `nj_mp_page_social_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nj_mp_page_types`
--
ALTER TABLE `nj_mp_page_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
