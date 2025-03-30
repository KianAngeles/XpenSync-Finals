-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2025 at 09:11 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xpensync`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Food & Dining'),
(2, 'Transportation'),
(3, 'Housing & Utilities'),
(4, 'Entertainment'),
(5, 'Shopping'),
(6, 'Health & Fitness'),
(7, 'Bills & Subscriptions'),
(8, 'Miscellaneous');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `category` enum('Food & Dining','Transportation','Housing & Utilities','Entertainment','Shopping','Health & Fitness','Bills & Subscriptions','Miscellaneous') NOT NULL,
  `type` enum('Expense','Income') NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `user_id`, `date`, `category`, `type`, `description`, `amount`) VALUES
(15, 74, '2025-03-08', 'Transportation', 'Expense', 'Lambo', 5000000.00),
(17, 74, '2025-02-04', 'Miscellaneous', 'Income', 'Pi Network', 50000.00),
(18, 74, '2025-03-21', 'Food & Dining', 'Income', 'Birthday', 5000.00),
(19, 74, '2025-03-15', 'Transportation', 'Expense', 'Bus Fee', 120.00),
(20, 74, '2025-03-09', 'Housing & Utilities', 'Expense', 'Vacum', 7500.00),
(21, 74, '2025-03-04', 'Entertainment', 'Expense', 'PS5 ', 35000.00),
(22, 74, '2025-03-27', 'Food & Dining', 'Income', 'COVID Vaccine', 1000.00),
(23, 74, '2025-03-09', 'Bills & Subscriptions', 'Expense', 'Electric Bill', 8800.00),
(24, 74, '2025-03-07', 'Miscellaneous', 'Expense', 'Cat', 7300.00),
(25, 74, '2025-03-23', 'Shopping', 'Expense', 'shopee', 250.00),
(26, 74, '2025-03-10', 'Food & Dining', 'Expense', 'Lunch', 250.00),
(27, 74, '2025-03-11', 'Shopping', 'Expense', 'New Shoes', 4000.00),
(28, 74, '2025-03-12', 'Transportation', 'Expense', 'Taxi Fare', 300.00),
(29, 74, '2025-03-14', 'Housing & Utilities', 'Expense', 'Water Bill', 1200.00),
(30, 74, '2025-03-16', 'Entertainment', 'Expense', 'Movie Tickets', 600.00),
(31, 74, '2025-03-18', 'Bills & Subscriptions', 'Expense', 'Netflix', 550.00),
(32, 74, '2025-03-19', 'Miscellaneous', 'Expense', 'Gift', 2000.00),
(33, 74, '2025-03-20', 'Food & Dining', 'Income', 'Freelance Work', 12000.00),
(34, 74, '2025-03-22', 'Transportation', 'Expense', 'Gas', 1500.00),
(35, 74, '2025-03-24', 'Bills & Subscriptions', 'Expense', 'Internet Bill', 2000.00),
(36, 74, '2025-03-25', 'Shopping', 'Expense', 'Groceries', 3500.00),
(37, 74, '2025-03-26', 'Housing & Utilities', 'Expense', 'Electricity Bill', 5000.00),
(38, 74, '2025-03-28', 'Miscellaneous', 'Income', 'Side Business', 8000.00),
(39, 74, '2025-03-29', 'Entertainment', 'Expense', 'Concert Ticket', 4500.00),
(40, 74, '2025-03-30', 'Food & Dining', 'Expense', 'Dinner Date', 2000.00),
(41, 74, '2025-03-07', 'Health & Fitness', 'Expense', 'Gym Membership', 2500.00),
(42, 74, '2025-03-13', 'Health & Fitness', 'Expense', 'Protein Supplements', 1800.00),
(43, 74, '2025-03-21', 'Health & Fitness', 'Expense', 'Doctor Consultation', 3000.00),
(44, 74, '2025-03-24', 'Food & Dining', 'Expense', 'Food', 100.00),
(46, 74, '2025-03-14', 'Bills & Subscriptions', 'Expense', 'mansion', 99999999.99);

-- --------------------------------------------------------

--
-- Table structure for table `lending`
--

CREATE TABLE `lending` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `borrower` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date_lent` date NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('Pending','Paid') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lending`
--

INSERT INTO `lending` (`id`, `user_id`, `borrower`, `description`, `amount`, `date_lent`, `due_date`, `status`, `created_at`) VALUES
(1, 74, 'Kris', 'sugal', 5000.00, '2025-03-01', '2025-03-28', 'Pending', '2025-03-23 16:13:55'),
(2, 74, 'maca', 'alfonso', 8502.00, '2025-03-08', '2025-04-25', 'Paid', '2025-03-23 16:38:58'),
(4, 74, 'yao', 'lambo', 5000000.00, '2025-02-27', '2025-03-28', 'Paid', '2025-03-23 17:25:18');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `user_id` int(11) NOT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`user_id`, `reset_token`, `reset_expires`) VALUES
(68, NULL, NULL),
(75, NULL, NULL),
(76, NULL, NULL),
(77, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `verification_code` varchar(6) NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `created_at`, `verification_code`, `is_verified`) VALUES
(68, 'User', 'user@gmail.com', '9245657856', '$2y$10$JkvQ00olAxMBVQBUJ6kZp.rNtv0v5K7OChUeVvR04uAq8ZEFWDC2.', '2023-04-12 10:31:16', '', 1),
(74, 'kians', 'loljoblol30@gmail.com', '929 641 8227', '$2y$10$uaUUjo3WeZyjhjIhfCY6ZOYaEq1Bj0uDZjCMZRIW33HH6kOFXZOV2', '2025-03-20 02:00:56', '654321', 1),
(75, 'Kian Charles', 'loljoblol20@gmail.com', '929 641 8227', '$2y$10$edQb.TLLdmq7rez7dsVNE.XHLpG55Nb2IIuyP4aDs1Ac5ijDCXaiO', '2025-03-23 00:31:18', '', 1),
(76, 'testuser', 'loljoblol10@gmail.com', '9296418232', '$2y$10$SbzwiTi50OS88xddIZZylOgNyhQvE7LxUqicdYbYUe3U3LXoBwj4S', '2025-03-24 02:46:17', '211276', 1),
(77, 'test1', 'angeleskian09@gmail.com', '9296418227', '$2y$10$6rF7BooxftZ8y6KhPfES6OoMkJ9RkXcgGRzwAxjjHq0DGRyFYhKB2', '2025-03-26 00:04:44', '788735', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `user_id` int(11) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`user_id`, `profile_picture`, `first_name`, `last_name`, `gender`, `bio`) VALUES
(68, NULL, NULL, NULL, NULL, NULL),
(74, 'uploads/1743149260_wallpaper.jpg', 'Kian Charles', 'Angeles', 'male', 'lakers in 5'),
(75, NULL, NULL, NULL, NULL, NULL),
(76, NULL, NULL, NULL, NULL, NULL),
(77, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lending`
--
ALTER TABLE `lending`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`name`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `lending`
--
ALTER TABLE `lending`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lending`
--
ALTER TABLE `lending`
  ADD CONSTRAINT `lending_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
