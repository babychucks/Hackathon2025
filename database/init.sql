-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Sep 14, 2025 at 07:50 AM
-- Server version: 5.7.44
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Hackathon2025`
--

-- --------------------------------------------------------

--
-- Table structure for table `Expense_Category`
--

CREATE TABLE `Expense_Category` (
  `id` int(8) NOT NULL,
  `user_id` int(13) NOT NULL,
  `category_name` varchar(20) NOT NULL,
  `category_budget` decimal(12,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Income_Category`
--

CREATE TABLE `Income_Category` (
  `id` int(8) NOT NULL,
  `user_id` int(13) NOT NULL,
  `category_name` varchar(20) NOT NULL,
  `category_budget` decimal(12,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Points`
--

CREATE TABLE `Points` (
  `point_id` int(5) NOT NULL,
  `point_num` int(3) NOT NULL,
  `tier` enum('1','2','3','4') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Transactions`
--

CREATE TABLE `Transactions` (
  `id` int(13) NOT NULL,
  `transaction_id` int(8) NOT NULL,
  `transaction_type` enum('income','expense') DEFAULT NULL,
  `category` varchar(20) NOT NULL,
  `transaction_amount` decimal(12,0) DEFAULT '0',
  `current_budget` decimal(12,0) DEFAULT NULL,
  `date` date NOT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Transactions`
--

INSERT INTO `Transactions` (`id`, `transaction_id`, `transaction_type`, `category`, `transaction_amount`, `current_budget`, `date`, `description`) VALUES
(1234567890, 3, 'income', 'grocery', 500, -500, '2025-09-14', 'money for groceries for the month'),
(1234567890, 4, 'income', 'grocery', 500, -500, '2025-09-14', 'money for groceries for the month'),
(1234567890, 5, 'income', 'grocery', 500, -500, '2025-09-14', 'money for groceries for the month'),
(1234567890, 6, 'income', 'grocery', 500, -500, '2025-09-14', 'money for groceries for the month'),
(1234567890, 7, 'income', 'grocery', 500, -500, '2025-09-14', 'money for groceries for the month'),
(1234567890, 8, 'income', 'grocery', 500, -500, '2025-09-14', 'money for groceries for the month'),
(1234567890, 9, 'income', 'grocery', 500, -500, '2025-09-14', 'money for groceries for the month'),
(1234567890, 10, 'income', 'grocery', 500, -500, '2025-09-14', 'money for groceries for the month'),
(1234567890, 11, 'income', 'grocery', 500, -500, '2025-09-14', 'money for groceries for the month'),
(1234567890, 12, 'income', 'grocery', 500, -500, '2025-09-14', 'money for groceries for the month'),
(1234567890, 13, 'income', 'grocery', 500, -500, '2025-09-14', 'money for groceries for the month'),
(1234567890, 14, 'income', 'grocery', 500, 0, '2025-09-14', 'money for groceries for the month'),
(1234567890, 15, 'income', 'grocery', 500, 0, '2025-09-14', 'money for groceries for the month'),
(1234567890, 16, 'income', 'grocery', 500, 0, '2025-09-14', 'money for groceries for the month'),
(1234567890, 17, 'income', 'grocery', 500, 0, '2025-09-14', 'money for groceries for the month'),
(1234567890, 18, 'income', 'grocery', 500, 0, '2025-09-14', 'money for groceries for the month'),
(1234567890, 19, 'income', 'grocery', 500, 0, '2025-09-14', 'money for groceries for the month'),
(1234567890, 20, 'income', 'grocery', 500, 0, '2025-09-14', 'money for groceries for the month'),
(1234567890, 21, 'income', 'grocery', 500, 0, '2025-09-14', 'money for groceries for the month'),
(1234567890, 22, 'income', 'grocery', 500, 0, '2025-09-14', 'money for groceries for the month'),
(1234567890, 23, 'income', 'grocery', 500, 0, '2025-09-14', 'money for groceries for the month'),
(1234567890, 24, 'income', 'grocery', 500, 0, '2025-09-14', 'money for groceries for the month'),
(1234567890, 25, 'income', 'grocery', 500, 0, '2025-09-14', 'money for groceries for the month'),
(1234567890, 26, 'income', 'grocery', 500, 0, '2025-09-14', 'money for groceries for the month'),
(1234567890, 27, 'income', 'grocery', 500, 0, '2025-09-14', 'money for groceries for the month'),
(1234567890, 28, 'income', 'grocery', 500, 0, '2025-09-14', 'money for groceries for the month'),
(1234567890, 29, 'income', 'grocery', 500, 0, '2025-09-14', 'money for groceries for the month'),
(1234567890, 30, 'income', 'grocery', 500, 0, '2025-09-14', 'money for groceries for the month'),
(1234567890, 31, 'income', 'grocery', 500, 0, '2025-09-14', 'money for groceries for the month'),
(1234567890, 32, 'income', 'grocery', 500, 0, '2025-09-14', 'money for groceries for the month'),
(1234567890, 33, 'income', 'grocery', 500, -1000, '2025-09-14', 'money for groceries for the month');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int(13) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `D.O.B` date NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` char(12) NOT NULL,
  `api_key` char(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `name`, `surname`, `D.O.B`, `email`, `password`, `salt`, `api_key`) VALUES
(1234567587, 'name1', 'surname1', '2005-01-01', 'name12@email.com', 'd1f9878b726d46c2a114e32275a08b02c6b3679169a901bc6f96318f9e6340b9', 'f7c5c308', 'b38a5765ffc3514af776dcfad414d6da'),
(1234567890, 'name1', 'surname1', '2005-01-01', 'name1@gmail.com', 'qqqqqqqqqqqq', 'uehfff', 'ljefijfjfjwkejfiwuhfiuwhj');

-- --------------------------------------------------------

--
-- Table structure for table `User_Points`
--

CREATE TABLE `User_Points` (
  `user_id` int(13) NOT NULL,
  `id` int(5) NOT NULL,
  `total_points` int(5) NOT NULL DEFAULT '0',
  `user_tier` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Expense_Category`
--
ALTER TABLE `Expense_Category`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `fk_expense_user` (`user_id`);

--
-- Indexes for table `Income_Category`
--
ALTER TABLE `Income_Category`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `fk_income_user` (`user_id`);

--
-- Indexes for table `Points`
--
ALTER TABLE `Points`
  ADD PRIMARY KEY (`point_id`);

--
-- Indexes for table `Transactions`
--
ALTER TABLE `Transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `fk_trans_user` (`id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `User_Points`
--
ALTER TABLE `User_Points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_points` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Expense_Category`
--
ALTER TABLE `Expense_Category`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Income_Category`
--
ALTER TABLE `Income_Category`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Transactions`
--
ALTER TABLE `Transactions`
  MODIFY `transaction_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `User_Points`
--
ALTER TABLE `User_Points`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Expense_Category`
--
ALTER TABLE `Expense_Category`
  ADD CONSTRAINT `fk_expense_user` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Income_Category`
--
ALTER TABLE `Income_Category`
  ADD CONSTRAINT `fk_income_user` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Transactions`
--
ALTER TABLE `Transactions`
  ADD CONSTRAINT `fk_trans_user` FOREIGN KEY (`id`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `User_Points`
--
ALTER TABLE `User_Points`
  ADD CONSTRAINT `fk_user_points` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
