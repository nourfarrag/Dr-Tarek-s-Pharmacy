-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2024 at 06:22 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmacy`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CustomerID` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Contact` int(100) NOT NULL,
  `ProductName` varchar(100) DEFAULT NULL,
  `Total` decimal(10,2) DEFAULT NULL,
  `Note` text DEFAULT NULL,
  `ExpectedDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerID`, `FullName`, `Address`, `Contact`, `ProductName`, `Total`, `Note`, `ExpectedDate`) VALUES
(7, 'Mahmoud Adel Mahmoud Ahmed Salem', 'adafaadf', 2322, '', 0.00, '', '0000-00-00'),
(8, 'Mahmoud Adel Mahmoud Ahmed Salem', 'adafaadf', 2324, '', 0.00, '', '2024-05-30'),
(9, 'kota', 'Haram', 0, '', 17.00, '', '2024-05-29'),
(10, 'kota', 'Haram', 16516161, '', 17.00, '', '0000-00-00'),
(11, 'Mahmoud Adel', '16dsjkhkdshhszdkhk', 0, '', 0.00, '', '0000-00-00'),
(12, 'omran', 'adafaadf', 2147483647, '', 43.00, '', '0000-00-00'),
(13, 'omran', 'adafaadf', 2147483647, '', 43.00, '', '0000-00-00'),
(14, 'omran', 'adafaadf', 2147483647, '', 43.00, '', '0000-00-00'),
(15, 'omran', 'adafaadf', 2147483647, '', 43.00, '', '0000-00-00'),
(18, 'Mahmoud Adel', 'Haram', 1016286486, '', 0.00, '', '0000-00-00'),
(19, 'Mahmoud Adel Mahmoud Ahmed Salem', 'adafaadf', 2147483647, '', 43.00, '', '0000-00-00'),
(20, 'omran', 'Haram', 0, '', 0.00, '', '0000-00-00'),
(21, 'omran', 'Haram', 0, '', 0.00, '', '0000-00-00'),
(22, 'omran', 'Haram', 0, '', 0.00, '', '0000-00-00'),
(23, 'omran', 'Haram', 0, '', 0.00, '', '0000-00-00'),
(24, '7oda', 'asdfas', 234523456, '', 0.00, '', '0000-00-00'),
(25, '7oda', 'asdfas', 0, '', 0.00, '', '0000-00-00'),
(26, 'Mahmoud Adel', 'Haram', 0, '', 0.00, '', '2024-05-31'),
(27, 'omran', 'a4garrr', 2147483647, '', 0.00, '', '0000-00-00'),
(28, 'ahmed', 'banhaa', 161161844, '', 0.00, '', '0000-00-00'),
(30, 'kotaaaa', 'hell', 116, '', 0.00, '', '0000-00-00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
