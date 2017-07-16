-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2017 at 11:53 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.0.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bms`
--

-- --------------------------------------------------------

--
-- Table structure for table `boats`
--

CREATE TABLE `boats` (
  `id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `length` decimal(6,3) NOT NULL,
  `propulsion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `boats`
--

INSERT INTO `boats` (`id`, `type_id`, `length`, `propulsion_id`) VALUES
(18, 10, '52.250', 2),
(20, 1, '50.000', 2),
(21, 6, '89.000', 1),
(22, 1, '52.000', 2),
(23, 1, '52.000', 2),
(27, 1, '26.000', 4),
(28, 1, '20.000', 2),
(29, 4, '20.000', 1),
(30, 1, '25.000', 3),
(31, 8, '25.000', 1),
(33, 1, '45.000', 2),
(34, 1, '65.000', 2);

-- --------------------------------------------------------

--
-- Table structure for table `boat_propulsion`
--

CREATE TABLE `boat_propulsion` (
  `id` int(11) NOT NULL,
  `propulsion_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `boat_propulsion`
--

INSERT INTO `boat_propulsion` (`id`, `propulsion_name`) VALUES
(2, 'Inboard engine'),
(6, 'Jet Propulsion'),
(4, 'Man power'),
(1, 'Outboard engine'),
(3, 'Sail power'),
(5, 'Sterndrive Engine');

-- --------------------------------------------------------

--
-- Table structure for table `boat_types`
--

CREATE TABLE `boat_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `boat_types`
--

INSERT INTO `boat_types` (`id`, `type_name`) VALUES
(1, 'Bowriders'),
(2, 'Cruisers'),
(3, 'Freshwater Fishing Boats'),
(8, 'Pontoon Boats'),
(4, 'Runabouts'),
(5, 'Sailboats'),
(6, 'Saltwater Fishing Boats'),
(7, 'Speed Boats'),
(9, 'Trawlers'),
(10, 'Watersports Boats');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(45) NOT NULL,
  `usr_name` varchar(15) NOT NULL,
  `usr_pass_hash` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `usr_name`, `usr_pass_hash`) VALUES
(1, 'Mohammad', 'Tahawi', 'mhd.tahawi', '$2y$10$px9FxYEXZJGDty0UMVMYjeWArSMGuyIgteTJD6AlhAbwY.ZuGzgBC'),
(3, 'Bjarne ', 'Strostrup', 'b.s', '$2y$10$LnR3sTIXPTCiek89oBHYTOziCPpyy.IJujO036baEVAANrbZgPaTi'),
(4, 'Sara', 'Sahli', 'saras', '$2y$10$56V7w6c0Kk9DDFf1o.1Yeu.fy1b6SGpvY26BSDFh8HN6sEmWWzyZ2');

-- --------------------------------------------------------

--
-- Table structure for table `users_boats`
--

CREATE TABLE `users_boats` (
  `user_id` int(11) NOT NULL,
  `boat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_boats`
--

INSERT INTO `users_boats` (`user_id`, `boat_id`) VALUES
(1, 18),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 33),
(1, 34),
(3, 31);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boats`
--
ALTER TABLE `boats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_FK_idx` (`type_id`),
  ADD KEY `propulsion_FK_idx` (`propulsion_id`);

--
-- Indexes for table `boat_propulsion`
--
ALTER TABLE `boat_propulsion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `propulsion_name_UNIQUE` (`propulsion_name`);

--
-- Indexes for table `boat_types`
--
ALTER TABLE `boat_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_name_UNIQUE` (`type_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usr_name_UNIQUE` (`usr_name`);

--
-- Indexes for table `users_boats`
--
ALTER TABLE `users_boats`
  ADD PRIMARY KEY (`user_id`,`boat_id`),
  ADD UNIQUE KEY `boat_id_UNIQUE` (`boat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boats`
--
ALTER TABLE `boats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `boat_propulsion`
--
ALTER TABLE `boat_propulsion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `boat_types`
--
ALTER TABLE `boat_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `boats`
--
ALTER TABLE `boats`
  ADD CONSTRAINT `propulsion_FK` FOREIGN KEY (`propulsion_id`) REFERENCES `boat_propulsion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `type_FK` FOREIGN KEY (`type_id`) REFERENCES `boat_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users_boats`
--
ALTER TABLE `users_boats`
  ADD CONSTRAINT `boat_FK` FOREIGN KEY (`boat_id`) REFERENCES `boats` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
