-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2025 at 02:01 AM
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
-- Database: `real_estate_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `sent_at`) VALUES
(1, 2, 1, 'Hello, there is a new listing for apartment.\r\nCheck it out!', '2025-04-13 23:09:38'),
(2, 1, 2, 'Hii, thank you for informing me.\r\nI\'ll contact you soon.', '2025-04-13 23:11:06');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `seen` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `user_id`, `title`, `description`, `price`, `location`, `image`) VALUES
(1, 2, 'Le RockHill Apartments', 'Step into this stunning 2-bedroom, 2-bathroom apartment nestled in the heart of vibrant Montreal. With 1,000 square feet of thoughtfully designed living space, this apartment boasts an open-concept layout that flows seamlessly from the living area to the kitchen, ideal for entertaining family and friends.', 2199.00, 'Cote-des-neiges, Montreal', '1744587946_R (2).jpeg'),
(2, 6, 'Modern 2-Bedroom Apartment', 'A spacious and fully renovated 2-bedroom apartment located in downtown Montreal. Close to metro, groceries, and schools.', 3500.00, '1200 Saint-Catherine St W, Montreal, QC', '1744587174_R (1).jpeg'),
(3, 6, '3-Bedroom House with Backyard', 'Cozy family home with 3 bedrooms, 2 bathrooms, private parking, and a large backyard. Pet-friendly and ideal for families.', 4500.00, '75 Maplewood Drive, Laval, QC', '1744587247_R.jpeg'),
(4, 2, 'Studio Apartment for Students', 'Small but convenient studio perfect for students. Includes kitchenette, WiFi, and utilities.', 1500.00, '3500 University St, Montreal, QC', '1744587372_454086120.jpg'),
(5, 3, 'Luxury 1-Bedroom Condo with Pool', 'Stylish and upscale 1-bedroom condo with access to a gym, pool, and 24/7 security. Includes washer/dryer and smart appliances.', 5000.00, '1800 Sherbrooke St W, Montreal, QC', '1744587470_OIP.jpeg'),
(6, 3, 'Basement Apartment', 'One-bedroom basement apartment with separate entrance and laundry. Perfect for singles or couples.', 1200.00, '40 Rosewood Crescent, Brossard, QC', '1744587550_rental-8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `rentals`
--

CREATE TABLE `rentals` (
  `id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `document` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rentals`
--

INSERT INTO `rentals` (`id`, `property_id`, `tenant_id`, `start_date`, `end_date`, `document`) VALUES
(1, 1, 1, '2025-04-24', '2025-12-19', '1744586206_Residential-Lease-Agreement-Template.pdf'),
(2, 3, 4, '2025-04-30', '2026-05-31', '1744587878_Residential-Lease-Agreement-Template.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('owner','tenant','agent') DEFAULT 'tenant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Gabriel Thomas Johnson', 'gabriel@outlook.com', '$2y$10$q8KViQE6dYbMqne.h2GnMuwOySOts4jp8tqGx7GYZ2F0O.QOqW8Nq', 'tenant'),
(2, 'Sujal Gandhi', 'sujal@gmail.com', '$2y$10$qLZTWFTALsAATc9P0oo1m.obpo1t0WGOGIlvDNFQ5yZqTnV4njWVe', 'owner'),
(3, 'Jose Mota', 'jose@yahoo.com', '$2y$10$bPKxBOQnNAMDwkUQQXMtued4qq2oIMlveakKyplVIlTKd1feEqfty', 'agent'),
(4, 'Francisco Guzman', 'franc@outlook.com', '$2y$10$ceGWqs6t7zXQQKOAAoELm.HYft.oSrbni85cNt.ZwHKeHx908xHAm', 'tenant'),
(6, 'John Doe', 'john123@gmail.com', '$2y$10$OU/ZLCV7KMJ8SYeXWzR4m.msbBTOKHuYaPh2KG5ICyEfAvw9NRkS2', 'owner');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rentals`
--
ALTER TABLE `rentals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`),
  ADD CONSTRAINT `rentals_ibfk_2` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
