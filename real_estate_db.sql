-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 28-04-2025 a las 00:14:53
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `real_estate_db`
--
CREATE DATABASE IF NOT EXISTS `real_estate_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `real_estate_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int DEFAULT NULL,
  `receiver_id` int DEFAULT NULL,
  `message` text COLLATE utf8mb4_general_ci,
  `sent_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `sent_at`) VALUES
(1, 2, 1, 'Hello, there is a new listing for apartment.\r\nCheck it out!', '2025-04-13 23:09:38'),
(2, 1, 2, 'Hii, thank you for informing me.\r\nI\'ll contact you soon.', '2025-04-13 23:11:06'),
(3, 2, 3, 'Hello! Im testing', '2025-04-21 01:17:42'),
(4, 4, 6, 'Hello!', '2025-04-25 01:48:20'),
(5, 3, 4, 'YOOOO, hows going?', '2025-04-25 01:49:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `message` text COLLATE utf8mb4_general_ci,
  `seen` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `properties`
--

DROP TABLE IF EXISTS `properties`;
CREATE TABLE IF NOT EXISTS `properties` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `price` decimal(10,2) DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `properties`
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
-- Estructura de tabla para la tabla `rentals`
--

DROP TABLE IF EXISTS `rentals`;
CREATE TABLE IF NOT EXISTS `rentals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `property_id` int DEFAULT NULL,
  `tenant_id` int DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `document` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PaymentState` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `property_id` (`property_id`),
  KEY `tenant_id` (`tenant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rentals`
--

INSERT INTO `rentals` (`id`, `property_id`, `tenant_id`, `start_date`, `end_date`, `document`, `PaymentState`) VALUES
(1, 1, 1, '2025-04-24', '2025-12-19', '1744586206_Residential-Lease-Agreement-Template.pdf', 0),
(2, 3, 4, '2025-04-30', '2026-05-31', '1744587878_Residential-Lease-Agreement-Template.pdf', 0),
(4, 1, 7, '2026-01-23', '2026-06-10', '1745550863_Nuevo documento de texto.PDF', 0),
(5, 2, 7, '2025-04-26', '2025-04-30', '1745691496_CoverLetter.pdf', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('owner','tenant','agent') COLLATE utf8mb4_general_ci DEFAULT 'tenant',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Gabriel Thomas Johnson', 'gabriel@outlook.com', '$2y$10$q8KViQE6dYbMqne.h2GnMuwOySOts4jp8tqGx7GYZ2F0O.QOqW8Nq', 'tenant'),
(2, 'Sujal Gandhi', 'sujal@gmail.com', '$2y$10$qLZTWFTALsAATc9P0oo1m.obpo1t0WGOGIlvDNFQ5yZqTnV4njWVe', 'owner'),
(3, 'Jose Mota', 'jose@yahoo.com', '$2y$10$bPKxBOQnNAMDwkUQQXMtued4qq2oIMlveakKyplVIlTKd1feEqfty', 'agent'),
(4, 'Francisco Guzman', 'franc@outlook.com', '$2y$10$ceGWqs6t7zXQQKOAAoELm.HYft.oSrbni85cNt.ZwHKeHx908xHAm', 'tenant'),
(6, 'John Doe', 'john123@gmail.com', '$2y$10$OU/ZLCV7KMJ8SYeXWzR4m.msbBTOKHuYaPh2KG5ICyEfAvw9NRkS2', 'owner'),
(7, 'Test', 'test123@gmail.com', '$2y$10$pJwcw696Qry9Mg6/L5p/4uurgkjzKVDo3Jc7I2IZY9bXEVqKyn3Ee', 'tenant');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`),
  ADD CONSTRAINT `rentals_ibfk_2` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
