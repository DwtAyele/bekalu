-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2022 at 10:06 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kal`
--

-- --------------------------------------------------------

--
-- Table structure for table `dictionary`
--

CREATE TABLE `dictionary` (
  `dictionary_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `short_name` varchar(25) NOT NULL,
  `dictionary_language_from` int(11) NOT NULL,
  `dictionary_language_to` int(11) NOT NULL,
  `dictionary_type` varchar(200) NOT NULL,
  `published_date` date NOT NULL,
  `author` varchar(60) NOT NULL,
  `flag` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `language_id` int(11) NOT NULL,
  `language_name` varchar(50) NOT NULL,
  `abbreviation` varchar(5) NOT NULL,
  `flag` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `meaning`
--

CREATE TABLE `meaning` (
  `meaning_id` int(11) NOT NULL,
  `meaning` text NOT NULL,
  `example` text NOT NULL,
  `homonyms` varchar(20) NOT NULL,
  `part_of_speech_id` int(11) NOT NULL,
  `user report` varchar(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `flag` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `page_id` int(11) NOT NULL,
  `page` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  `page_link` text NOT NULL,
  `page_icon` text NOT NULL,
  `page_prefix` text NOT NULL,
  `page_sefix` text NOT NULL,
  `flag` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `page`, `category_id`, `page_link`, `page_icon`, `page_prefix`, `page_sefix`, `flag`) VALUES
(1, 'profile', 1, ' <li class=\"nav-item\">                         <a href=\"profile\" class=\"nav-link\">', ' <i class=\'fa fa-circle nav-icon\'></i><p>', '', '</p></a></li>', 1),
(2, 'General Elements', 2, '<li class=\"nav-item\">\r\n<a href=\"#\" class=\"nav-link\">\r\n', '<i class=\"fa fa-circle nav-icon\"></i>\r\n<p>', '', '</p> \r\n</a> </li>', 1),
(3, 'Advanced Elements', 2, '<li class=\"nav-item\">\r\n<a href=\"#\" class=\"nav-link\">\r\n                            ', '<i class=\"fa fa-circle nav-icon\"></i>\r\n<p>', '', '</p>\r\n</a> \r\n</li>', 1),
(4, 'Editors', 2, '<li class=\"nav-item\">\r\n<a href=\"addmeaning\" class=\"nav-link\">\r\n', '<i class=\"fa fa-plus-square\" aria-hidden=\"true\"></i>\n<p>', '', '</p> \r\n</a> </li>', 1),
(5, 'Validation', 2, '<li class=\"nav-item\">\r\n<a href=\"#\" class=\"nav-link\">\r\n                            ', '<i class=\"fa fa-circle nav-icon\"></i>\r\n<p>', '', '</p>\r\n</a> \r\n</li>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `page_categories`
--

CREATE TABLE `page_categories` (
  `page_category_id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `link` text NOT NULL,
  `icon` text NOT NULL,
  `prefix_html` text NOT NULL,
  `sefix_html` text NOT NULL,
  `flag` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `page_categories`
--

INSERT INTO `page_categories` (`page_category_id`, `category`, `link`, `icon`, `prefix_html`, `sefix_html`, `flag`) VALUES
(1, 'Users', '<li class=\"nav-item\">\r\n<a href=\"#\" class=\"nav-link active\">', '<i class=\"nav-icon fa fa-user\"></i>\n<p>', '<i class=\"right fa fa-angle-left\"></i> </p>\r\n</a>\r\n<ul class=\"nav nav-treeview\">', '</ul>\n</li>', 1),
(2, 'Forms', '<li class=\"nav-item\">\r\n<a href=\"#\" class=\"nav-link\">\r\n', '<i class=\"nav-icon fa fa-edit\"></i>\r\n<p>', '<i class=\"fa fa-angle-left right\"></i>\r\n</p>\r\n</a>\r\n<ul class=\"nav nav-treeview\">', '</ul>\r\n</li>', 1),
(3, 'Calendar', '<li class=\"nav-item\">\r\n<a href=\"#\" class=\"nav-link\">\r\n\r\n', '<i class=\"nav-icon fa fa-calendar\"></i>\r\n<p>', '<span class=\"badge badge-info right\">2</span>\r\n</p>\r\n</a>\r\n</li>', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parts_of_speechs`
--

CREATE TABLE `parts_of_speechs` (
  `part_of_speech_id` int(11) NOT NULL,
  `part_of_speech` int(11) NOT NULL,
  `abbreviation` int(11) NOT NULL,
  `flag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rolepage`
--

CREATE TABLE `rolepage` (
  `rolepage_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rolepage`
--

INSERT INTO `rolepage` (`rolepage_id`, `role_id`, `page_id`, `comment`) VALUES
(1, 1, 1, ''),
(2, 2, 2, ''),
(3, 2, 3, ''),
(4, 2, 4, ''),
(5, 2, 5, '');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `comment` text NOT NULL,
  `role_priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role`, `comment`, `role_priority`) VALUES
(1, 'System Admin', '', 1),
(2, 'Admin', '', 2),
(3, 'Editor', '', 5),
(4, 'Data Entry', '', 6),
(5, 'View', '', 7);

-- --------------------------------------------------------

--
-- Table structure for table `role_actions`
--

CREATE TABLE `role_actions` (
  `role_action_id` int(11) NOT NULL,
  `action` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role_actions`
--

INSERT INTO `role_actions` (`role_action_id`, `action`) VALUES
(3, 'Create'),
(8, 'Delete'),
(1, 'Personal View'),
(5, 'Restricted Edit'),
(7, 'Soft Delete'),
(4, 'Timely View'),
(6, 'Update'),
(2, 'View');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `system_info_id` int(11) NOT NULL,
  `full_name_en` varchar(25) NOT NULL,
  `full_name_am` varchar(25) NOT NULL,
  `short_name_en` varchar(15) NOT NULL,
  `short_name_am` varchar(15) NOT NULL,
  `logo` varchar(60) NOT NULL,
  `address` varchar(60) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `page_tittle` varchar(60) NOT NULL,
  `footer_note` varchar(60) NOT NULL,
  `copyright_note` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`system_info_id`, `full_name_en`, `full_name_am`, `short_name_en`, `short_name_am`, `logo`, `address`, `phone`, `page_tittle`, `footer_note`, `copyright_note`) VALUES
(1, 'Amharic Dictionary', 'የአማርኛ መዝገበ ቃላት', '<b>ET </b> KAL', '<b>ኢቲ </b> ቃል', '', '', '', 'የአማርኛ | ማዝገበ ቃላት', 'Version ፩.፩.0', '፪ ሺ ፲፭');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `last_login` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `flag` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `email`, `password`, `image`, `last_login`, `created_at`, `updated_at`, `flag`) VALUES
(1, 'Dawit', 'Ayele', 'dwtk.ayele@gmail.com', '$2y$10$j4hnkAEldOsXiaJmaGNF1enHAwz0OSzo97pfhFJzISSXg4WcWa9F.', '/public/asset/img/user/1667331468_ae8d9ceef866c4adbf2d.jpg', '2022-11-07 09:19:15', '2022-10-21 11:59:14', '2022-11-07 09:19:15', 1),
(2, 'Abebe', 'Beso', 'dwtk.ayele2@gmail.com', '$2y$10$DOG8DJsCUfv5yGITenWaBOvS/KJCaU7L97j4Yj3qTaeoHAmFy1Y8W', '', '2022-10-21 12:10:13', '2022-10-21 12:10:13', '2022-10-21 12:10:13', 10),
(3, 'Chala', 'Chube', 'chala@gmail.com', '$2y$10$6IOdEUBvxtN9yrLdDKUxv.nBVgJiaPqo2d9x41P9/oekV7y4v26w2', '', '2022-10-21 12:33:27', '2022-10-21 12:33:27', '2022-10-21 12:33:27', 10),
(4, 'Sewunet', 'Beshaw', 'sewunet@gmail.com', '$2y$10$zvnbzZgoGNHfQPdPdsyJhuPsh/XPVZ60Dkc4BqHXZ3UriM72Jkfn6', '', '2022-10-24 11:50:04', '2022-10-24 11:50:04', '2022-10-24 11:57:38', 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_action_id` int(11) NOT NULL COMMENT 'For all granted actions use 100 and 0 for no privilege''s ',
  `role_page_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `expiry_date` datetime DEFAULT NULL,
  `flag` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_role_id`, `user_id`, `role_action_id`, `role_page_id`, `comment`, `created_at`, `updated_at`, `expiry_date`, `flag`) VALUES
(1, 1, 3, 1, '', '2022-10-24 13:38:01', '2022-10-24 13:38:01', NULL, 1),
(2, 1, 3, 2, '', '2022-10-28 14:15:52', '2022-10-28 14:15:52', NULL, 1),
(3, 1, 3, 3, '', '2022-10-28 14:15:52', '2022-10-28 14:15:52', NULL, 1),
(4, 1, 3, 4, '', '2022-10-28 14:25:04', '2022-10-28 14:25:04', NULL, 1),
(5, 1, 3, 5, '', '2022-10-28 14:25:04', '2022-10-28 14:25:04', NULL, 1),
(6, 1, 8, 1, '', '2022-10-28 14:25:20', '2022-10-28 14:25:20', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `words`
--

CREATE TABLE `words` (
  `word_id` int(11) NOT NULL,
  `word` varchar(60) NOT NULL,
  `pronunciation` varchar(60) NOT NULL,
  `accessibility` varchar(20) NOT NULL,
  `Language_id` int(11) NOT NULL,
  `user_report` varchar(30) NOT NULL,
  `flag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `word_meaning`
--

CREATE TABLE `word_meaning` (
  `word_meaning_id` int(11) NOT NULL,
  `word_id` int(11) NOT NULL,
  `meaning_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dictionary_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `flag` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `word_part_of_speech`
--

CREATE TABLE `word_part_of_speech` (
  `word_part_of_speech_id` int(11) NOT NULL,
  `word_id` int(11) NOT NULL,
  `part_of_speech_id` int(11) NOT NULL,
  `new_word_id` int(11) NOT NULL,
  `flag` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dictionary`
--
ALTER TABLE `dictionary`
  ADD PRIMARY KEY (`dictionary_id`),
  ADD UNIQUE KEY `full_name` (`full_name`),
  ADD UNIQUE KEY `short_name` (`short_name`),
  ADD KEY `dictionary_language_from` (`dictionary_language_from`),
  ADD KEY `dictionary_language_to` (`dictionary_language_to`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`language_id`);

--
-- Indexes for table `meaning`
--
ALTER TABLE `meaning`
  ADD PRIMARY KEY (`meaning_id`),
  ADD KEY `part_of_speech_id` (`part_of_speech_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`),
  ADD UNIQUE KEY `page` (`page`),
  ADD KEY `category` (`category_id`);

--
-- Indexes for table `page_categories`
--
ALTER TABLE `page_categories`
  ADD PRIMARY KEY (`page_category_id`),
  ADD UNIQUE KEY `category` (`category`);

--
-- Indexes for table `parts_of_speechs`
--
ALTER TABLE `parts_of_speechs`
  ADD PRIMARY KEY (`part_of_speech_id`),
  ADD UNIQUE KEY `part_of_speech` (`part_of_speech`),
  ADD UNIQUE KEY `abbreviation` (`abbreviation`);

--
-- Indexes for table `rolepage`
--
ALTER TABLE `rolepage`
  ADD PRIMARY KEY (`rolepage_id`),
  ADD UNIQUE KEY `role_id_2` (`role_id`,`page_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `page_id` (`page_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role` (`role`);

--
-- Indexes for table `role_actions`
--
ALTER TABLE `role_actions`
  ADD PRIMARY KEY (`role_action_id`),
  ADD UNIQUE KEY `action` (`action`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`system_info_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_role_id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`,`role_action_id`,`role_page_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `role_action_id` (`role_action_id`),
  ADD KEY `role_page_id` (`role_page_id`);

--
-- Indexes for table `words`
--
ALTER TABLE `words`
  ADD PRIMARY KEY (`word_id`),
  ADD UNIQUE KEY `word` (`word`),
  ADD KEY `Language_id` (`Language_id`);

--
-- Indexes for table `word_meaning`
--
ALTER TABLE `word_meaning`
  ADD PRIMARY KEY (`word_meaning_id`),
  ADD KEY `dictionary_id` (`dictionary_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `meaning_id` (`meaning_id`),
  ADD KEY `word_id` (`word_id`);

--
-- Indexes for table `word_part_of_speech`
--
ALTER TABLE `word_part_of_speech`
  ADD PRIMARY KEY (`word_part_of_speech_id`),
  ADD UNIQUE KEY `word_id_2` (`word_id`,`part_of_speech_id`,`new_word_id`),
  ADD KEY `word_id` (`word_id`),
  ADD KEY `part_of_speech_id` (`part_of_speech_id`),
  ADD KEY `new_word_id` (`new_word_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dictionary`
--
ALTER TABLE `dictionary`
  MODIFY `dictionary_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `language_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meaning`
--
ALTER TABLE `meaning`
  MODIFY `meaning_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `page_categories`
--
ALTER TABLE `page_categories`
  MODIFY `page_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `parts_of_speechs`
--
ALTER TABLE `parts_of_speechs`
  MODIFY `part_of_speech_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rolepage`
--
ALTER TABLE `rolepage`
  MODIFY `rolepage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `role_actions`
--
ALTER TABLE `role_actions`
  MODIFY `role_action_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `system_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `user_role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `words`
--
ALTER TABLE `words`
  MODIFY `word_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `word_meaning`
--
ALTER TABLE `word_meaning`
  MODIFY `word_meaning_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `word_part_of_speech`
--
ALTER TABLE `word_part_of_speech`
  MODIFY `word_part_of_speech_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `page_categories` (`page_category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rolepage`
--
ALTER TABLE `rolepage`
  ADD CONSTRAINT `rolepage_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`page_id`),
  ADD CONSTRAINT `rolepage_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_page_id`) REFERENCES `rolepage` (`rolepage_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_3` FOREIGN KEY (`role_action_id`) REFERENCES `role_actions` (`role_action_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
