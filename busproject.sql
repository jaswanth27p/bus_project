-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2023 at 07:54 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `busproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminusers`
--

CREATE TABLE `adminusers` (
  `admin_user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminusers`
--

INSERT INTO `adminusers` (`admin_user_id`, `user_name`, `password`) VALUES
(1, 'jaswanth_admin', 'admin'),
(3, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `seats` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`seats`)),
  `contact` bigint(20) NOT NULL,
  `booking_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `route_id`, `seats`, `contact`, `booking_time`) VALUES
(11, 1, 1, '[\"1\",\"6\"]', 1111111111, '2023-04-23 09:12:58'),
(12, 1, 1, '[\"2\",\"7\"]', 1111111111, '2023-04-23 15:41:45'),
(14, 4, 6, '[\"1\",\"6\"]', 1111111111, '2023-04-23 16:06:51'),
(15, 17, 2, '[\"1\",\"6\"]', 8743289053, '2023-04-23 16:14:05'),
(16, 17, 1, '[\"3\"]', 1111111111, '2023-04-23 17:30:03');

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `bus_id` int(11) NOT NULL,
  `bus_number` varchar(10) NOT NULL,
  `bus_driver` varchar(20) NOT NULL,
  `driver_contact` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`bus_id`, `bus_number`, `bus_driver`, `driver_contact`) VALUES
(1, 'ap16aa1234', 'ramesh', 1234567890),
(2, 'ap32bb1245', 'suresh', 1234567890),
(3, 'ap30bb1745', 'raju', 1352057391),
(4, 'ap10zz9457', 'ganesh', 9352057391),
(5, 'ap66aa3449', 'sai', 7495667295);

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `place_id` int(11) NOT NULL,
  `place_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`place_id`, `place_name`) VALUES
(1, 'Vijayawada'),
(2, 'Vizag'),
(3, 'Hyderabad'),
(4, 'Warangal'),
(5, 'Tirupati');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `route_id` int(11) NOT NULL,
  `source` varchar(20) NOT NULL,
  `destination` varchar(20) NOT NULL,
  `price` int(5) NOT NULL,
  `bus_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`route_id`, `source`, `destination`, `price`, `bus_id`, `start_time`, `end_time`) VALUES
(1, 'Vijayawada', 'Hyderabad', 50, 1, '2023-04-23 02:00:00', '2023-04-23 05:00:00'),
(2, 'Vijayawada', 'Hyderabad', 100, 4, '2023-04-23 06:15:00', '2023-04-23 08:15:00'),
(5, 'Vijayawada', 'Warangal', 150, 3, '2023-04-24 20:38:38', '2023-04-24 23:38:45'),
(6, 'Tirupati', 'Warangal', 40, 1, '2023-04-23 21:34:47', '2023-04-23 23:34:50'),
(8, 'Vijayawada', 'Vizag', 1, 4, '2023-04-23 21:41:35', '2023-04-23 22:41:00');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `route_id` int(20) NOT NULL,
  `seat_id` int(3) NOT NULL,
  `available` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`route_id`, `seat_id`, `available`) VALUES
(1, 1, 0),
(1, 2, 0),
(1, 3, 0),
(1, 4, 1),
(1, 5, 1),
(1, 6, 0),
(1, 7, 0),
(1, 8, 1),
(1, 9, 1),
(1, 10, 1),
(1, 11, 1),
(1, 12, 1),
(1, 13, 1),
(1, 14, 1),
(1, 15, 1),
(1, 16, 1),
(1, 17, 1),
(1, 18, 1),
(1, 19, 1),
(1, 20, 1),
(2, 1, 0),
(2, 2, 1),
(2, 3, 1),
(2, 4, 1),
(2, 5, 1),
(2, 6, 0),
(2, 7, 1),
(2, 8, 1),
(2, 9, 1),
(2, 10, 1),
(2, 11, 1),
(2, 12, 1),
(2, 13, 1),
(2, 14, 1),
(2, 15, 1),
(2, 16, 1),
(2, 17, 1),
(2, 18, 1),
(2, 19, 1),
(2, 20, 1),
(5, 1, 1),
(5, 2, 1),
(5, 3, 1),
(5, 4, 1),
(5, 5, 1),
(5, 6, 1),
(5, 7, 1),
(5, 8, 1),
(5, 9, 1),
(5, 10, 1),
(5, 11, 1),
(5, 12, 1),
(5, 13, 1),
(5, 14, 1),
(5, 15, 1),
(5, 16, 1),
(5, 17, 1),
(5, 18, 1),
(5, 19, 1),
(5, 20, 1),
(6, 1, 0),
(6, 2, 1),
(6, 3, 1),
(6, 4, 1),
(6, 5, 1),
(6, 6, 0),
(6, 7, 1),
(6, 8, 1),
(6, 9, 1),
(6, 10, 1),
(6, 11, 1),
(6, 12, 1),
(6, 13, 1),
(6, 14, 1),
(6, 15, 1),
(6, 16, 1),
(6, 17, 1),
(6, 18, 1),
(6, 19, 1),
(6, 20, 1),
(8, 1, 1),
(8, 2, 1),
(8, 3, 1),
(8, 4, 1),
(8, 5, 1),
(8, 6, 1),
(8, 7, 1),
(8, 8, 1),
(8, 9, 1),
(8, 10, 1),
(8, 11, 1),
(8, 12, 1),
(8, 13, 1),
(8, 14, 1),
(8, 15, 1),
(8, 16, 1),
(8, 17, 1),
(8, 18, 1),
(8, 19, 1),
(8, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` bigint(10) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `email`, `phone`, `first_name`, `last_name`, `password`) VALUES
(1, 'jaswanth', 'jaswanth@gmail.com', 1234567890, 'jaswanth', 'pakalapati', 'jaswanth'),
(4, 'john', 'john@gmail.com', 1, 'a', 'a', 'a'),
(7, 'raj', 'raj@gmail.com', 1234567890, 'raj', 'raj', 'raj'),
(12, 'a', 'a@a.a', 1111111111, 'a', 'a', 'aaaaaaaa'),
(13, 'temp', 'temp@gmail.com', 1111111111, 'temp', 'temp', 'temptemp'),
(15, 'johnrgta', 'jnerds@gmail.com', 1234567890, 'trgs', 'thrd', 'qqqqqqqq'),
(17, 'fdjk', 'b@gmail.com', 1111111111, 'john', 'paul', 'aaaaaaaa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminusers`
--
ALTER TABLE `adminusers`
  ADD PRIMARY KEY (`admin_user_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `route_id` (`route_id`);

--
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`bus_id`),
  ADD UNIQUE KEY `bus_number` (`bus_number`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`place_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`route_id`),
  ADD KEY `bus_id` (`bus_id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD KEY `fk_route_id` (`route_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminusers`
--
ALTER TABLE `adminusers`
  MODIFY `admin_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `buses`
--
ALTER TABLE `buses`
  MODIFY `bus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `place_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `route_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`route_id`) REFERENCES `routes` (`route_id`);

--
-- Constraints for table `routes`
--
ALTER TABLE `routes`
  ADD CONSTRAINT `routes_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `buses` (`bus_id`);

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `fk_route_id` FOREIGN KEY (`route_id`) REFERENCES `routes` (`route_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`route_id`) REFERENCES `routes` (`route_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
