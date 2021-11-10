-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2021 at 03:08 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `souq`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` tinyint(4) NOT NULL,
  `NAME` varchar(255) CHARACTER SET utf8 NOT NULL,
  `DESCRIPTION` text CHARACTER SET utf8 NOT NULL,
  `ORDERING` int(11) DEFAULT NULL,
  `ALLOWCOMM` tinyint(4) NOT NULL DEFAULT 0,
  `ALLOWADS` int(11) NOT NULL DEFAULT 0,
  `VISIBILTY` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `NAME`, `DESCRIPTION`, `ORDERING`, `ALLOWCOMM`, `ALLOWADS`, `VISIBILTY`) VALUES
(1, 'Phones', 'This is Phones', 0, 1, 1, 1),
(2, 'Computers', 'This is Computers', 0, 0, 0, 0),
(3, 'Tv', 'This is Tv', 0, 1, 0, 1),
(7, 'Bottles', 'This is For Bottles Like Water Bottle And Blastic', 0, 0, 1, 1),
(9, 'Homemade', 'This is Home Made Items', 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comm_id` int(11) NOT NULL,
  `comment` text CHARACTER SET utf8 NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `country` varchar(255) NOT NULL,
  `approved` tinyint(4) NOT NULL DEFAULT 0,
  `image` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `cat_id` tinyint(4) NOT NULL,
  `photo` varchar(2555) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `name`, `description`, `price`, `status`, `country`, `approved`, `image`, `user_id`, `cat_id`, `photo`) VALUES
(3, 'Huawei Laptop', 'This is A Laptop From Huawei', '700', 0, 'China', 1, NULL, 1, 2, 'admin/uploads/items/laptop.jpg-9241'),
(6, 'Laptop', 'Huawei Laptop', '900', 0, 'China', 1, NULL, 3, 2, 'admin/uploads/items/laptop.jpg-9570'),
(7, 'Iphone 12 Pro', 'This is Apple', '500', 1, 'Dubai', 1, NULL, 1, 1, 'admin/uploads/items/7106-Iphone.png-7342');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `USERID` int(11) NOT NULL,
  `USERNAME` varchar(255) CHARACTER SET utf8 NOT NULL,
  `PASSWORD` varchar(255) CHARACTER SET utf8 NOT NULL,
  `EMAIL` varchar(255) CHARACTER SET utf8 NOT NULL,
  `FULLNAME` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `GROUPID` int(11) NOT NULL DEFAULT 0,
  `TRUSTSTATUS` int(11) NOT NULL DEFAULT 0,
  `REGSTATUS` int(11) NOT NULL DEFAULT 0,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`USERID`, `USERNAME`, `PASSWORD`, `EMAIL`, `FULLNAME`, `GROUPID`, `TRUSTSTATUS`, `REGSTATUS`, `avatar`) VALUES
(1, 'Azzam', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'amrazzm@gmail.com', 'Amr Azzam', 1, 1, 1, 'admin/uploads/avatars/admin.jpg-490'),
(2, 'Ayman', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ayman@gmail.com', 'AymanGamal', 0, 0, 1, 'uploads/avatars/4031-'),
(3, 'Amgad', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'amgad@gmail.com', 'Amgad Salem', 0, 0, 0, 'admin/uploads/avatars/photo_2021-05-28_17-16-05.jpg-3975'),
(4, 'Emad', '601f1889667efaebb33b8c12572835da3f027f78', 'e@gmail.com', NULL, 1, 1, 1, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `uniname` (`NAME`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comm_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`USERID`),
  ADD UNIQUE KEY `USERNAME` (`USERNAME`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `USERID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `itemcomment` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usercomment` FOREIGN KEY (`user_id`) REFERENCES `users` (`USERID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`USERID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
