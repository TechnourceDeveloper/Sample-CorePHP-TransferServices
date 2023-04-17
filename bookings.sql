-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2023 at 06:17 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookings`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `full_address` text NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `full_address`, `latitude`, `longitude`, `created_at`) VALUES
(1, '50670 Cologne, Hansaring 115', '50.949582', '6.9531442', '2023-04-13 10:38:08'),
(2, 'Airport Cologne/Bonn ', '50.8663947', '7.1380308', '2023-04-13 10:38:08'),
(3, 'Airport Düsseldorf', '51.2806966', '6.7551818', '2023-04-13 10:38:08'),
(4, '53332 Bornheim, Hauptweg 2', '50.7617936', '6.8229766', '2023-04-13 10:38:08'),
(5, 'Cologne Main Station', '50.9432141', '6.956413', '2023-04-13 10:38:08'),
(6, 'Düsseldorf Main Station ', '51.220041', '6.7915495', '2023-04-13 10:38:08');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `from_address_id` int(11) NOT NULL,
  `to_address_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `no_of_passengers` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `booking_customer_details`
--

CREATE TABLE `booking_customer_details` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `booking_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `driving_license_no` varchar(50) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `address_id`, `driving_license_no`, `phone`, `fullname`, `email`, `created_at`) VALUES
(1, 3, 'DT234457568', '123456789', 'Komal Thakkar', 'komalt@mailinator.com', '2023-04-13 10:59:47'),
(2, 6, '56464654UT', '345357259', 'Chetan Patel', 'chetan@mailinator.com', '2023-04-13 10:59:47'),
(3, 1, '353534', '34534534535', 'Harsh Patel', 'harsh@mailinator.com', '2023-04-15 21:34:50'),
(4, 2, '353534', '34534534535', 'Karan Patel', 'karan@mailinator.com', '2023-04-15 21:35:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `type` enum('individual','agency') NOT NULL,
  `password` varchar(32) DEFAULT NULL,
  `agency_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `class_id` int(11) NOT NULL,
  `price` varchar(50) NOT NULL,
  `offer_price` varchar(50) NOT NULL,
  `no_of_passengers` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `name`, `class_id`, `price`, `offer_price`, `no_of_passengers`, `created_at`) VALUES
(1, 'Tesla', 2, '300', '260', 4, '2023-04-13 11:03:12'),
(2, 'BMW', 1, '290', '140', 3, '2023-04-13 11:03:12'),
(3, 'Hyundai ', 2, '345', '200', 5, '2023-04-15 21:33:47'),
(4, 'Mahindra ', 1, '255', '234', 6, '2023-04-15 21:33:47'),
(5, 'Toyota ', 2, '233', '144', 7, '2023-04-15 21:33:47'),
(6, 'mercedes', 1, '345', '324', 5, '2023-04-15 21:36:24'),
(7, 'lamborghini ', 1, '345', '324', 6, '2023-04-15 21:36:56');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_classes`
--

CREATE TABLE `vehicle_classes` (
  `id` int(11) NOT NULL,
  `class_name` varchar(30) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vehicle_classes`
--

INSERT INTO `vehicle_classes` (`id`, `class_name`, `created_at`) VALUES
(1, 'Economy, Sedan or Van', '2023-04-13 10:39:36'),
(2, 'Business, Sedan or Van', '2023-04-13 10:39:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_address_id` (`from_address_id`),
  ADD KEY `to_address_id` (`to_address_id`),
  ADD KEY `vehicle_id` (`vehicle_id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `booking_customer_details`
--
ALTER TABLE `booking_customer_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `vehicle_classes`
--
ALTER TABLE `vehicle_classes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `booking_customer_details`
--
ALTER TABLE `booking_customer_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vehicle_classes`
--
ALTER TABLE `vehicle_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `driver_id` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `from_address_id` FOREIGN KEY (`from_address_id`) REFERENCES `addresses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `to_address_id` FOREIGN KEY (`to_address_id`) REFERENCES `addresses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vehicle_id` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `booking_customer_details`
--
ALTER TABLE `booking_customer_details`
  ADD CONSTRAINT `booking_id` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customer_id` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `drivers`
--
ALTER TABLE `drivers`
  ADD CONSTRAINT `address_id` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `class_id` FOREIGN KEY (`class_id`) REFERENCES `vehicle_classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
