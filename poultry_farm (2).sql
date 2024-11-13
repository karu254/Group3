-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2024 at 09:26 PM
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
-- Database: `poultry_farm`
--

-- --------------------------------------------------------

--
-- Table structure for table `chicks_data`
--

CREATE TABLE `chicks_data` (
  `id` int(11) NOT NULL,
  `group_number` int(11) NOT NULL,
  `hatch_date` date NOT NULL,
  `feed_consumed` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chicks_data`
--

INSERT INTO `chicks_data` (`id`, `group_number`, `hatch_date`, `feed_consumed`) VALUES
(1, 101, '2024-10-01', 50.75),
(2, 102, '2024-10-05', 60.30),
(3, 103, '2024-10-10', 55.20),
(4, 104, '2024-10-15', 70.00),
(5, 105, '2024-10-20', 65.80);

-- --------------------------------------------------------

--
-- Table structure for table `egg_production`
--

CREATE TABLE `egg_production` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `total_eggs` int(11) NOT NULL,
  `spoiled_eggs` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `spoiled` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `egg_production`
--

INSERT INTO `egg_production` (`id`, `date`, `total_eggs`, `spoiled_eggs`, `quantity`, `spoiled`) VALUES
(1, '2024-11-01', 200, 10, 190, 10),
(2, '2024-11-02', 210, 15, 195, 15),
(3, '2024-11-03', 220, 12, 208, 12),
(4, '2024-11-04', 215, 8, 207, 8),
(5, '2024-11-05', 225, 20, 205, 20);

-- --------------------------------------------------------

--
-- Table structure for table `feed_consumption`
--

CREATE TABLE `feed_consumption` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `layer_feed` decimal(10,2) NOT NULL,
  `chick_feed` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feed_consumption`
--

INSERT INTO `feed_consumption` (`id`, `date`, `layer_feed`, `chick_feed`) VALUES
(1, '2024-11-01', 120.50, 80.75),
(2, '2024-11-02', 125.00, 85.50),
(3, '2024-11-03', 130.25, 90.00),
(4, '2024-11-04', 135.10, 95.20),
(5, '2024-11-05', 140.00, 100.00),
(6, '2024-11-13', 30.00, 25.00);

-- --------------------------------------------------------

--
-- Table structure for table `layers_data`
--

CREATE TABLE `layers_data` (
  `id` int(11) NOT NULL,
  `group_number` int(11) NOT NULL,
  `age_in_weeks` int(11) NOT NULL,
  `total_eggs` int(11) NOT NULL,
  `spoiled_eggs` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layers_data`
--

INSERT INTO `layers_data` (`id`, `group_number`, `age_in_weeks`, `total_eggs`, `spoiled_eggs`, `date`) VALUES
(1, 201, 20, 180, 5, '2024-11-01'),
(2, 202, 22, 190, 8, '2024-11-02'),
(3, 203, 24, 200, 10, '2024-11-03'),
(4, 204, 26, 210, 12, '2024-11-04'),
(5, 205, 28, 220, 15, '2024-11-05');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `item` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) GENERATED ALWAYS AS (`quantity` * `unit_price`) STORED,
  `layer_feed_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `chick_feed_price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `date`, `item`, `quantity`, `unit_price`, `layer_feed_price`, `chick_feed_price`) VALUES
(1, '2024-11-01', 'Eggs', 200, 12.50, 70.00, 50.00),
(2, '2024-11-02', 'Chick Feed', 150, 30.00, 70.00, 50.00),
(3, '2024-11-03', 'Layer Feed', 100, 45.00, 70.00, 50.00),
(4, '2024-11-04', 'Eggs', 250, 12.50, 70.00, 50.00),
(5, '2024-11-05', 'Eggs', 180, 12.50, 70.00, 50.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chicks_data`
--
ALTER TABLE `chicks_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `egg_production`
--
ALTER TABLE `egg_production`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feed_consumption`
--
ALTER TABLE `feed_consumption`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layers_data`
--
ALTER TABLE `layers_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chicks_data`
--
ALTER TABLE `chicks_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `egg_production`
--
ALTER TABLE `egg_production`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `feed_consumption`
--
ALTER TABLE `feed_consumption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `layers_data`
--
ALTER TABLE `layers_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
