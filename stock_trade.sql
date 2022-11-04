-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2022 at 06:37 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stock_trade`
--

-- --------------------------------------------------------

--
-- Table structure for table `stock_rates`
--

CREATE TABLE `stock_rates` (
  `id` int(11) NOT NULL,
  `stock_name` varchar(250) NOT NULL,
  `stock_price` varchar(250) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock_rates`
--

INSERT INTO `stock_rates` (`id`, `stock_name`, `stock_price`, `date`) VALUES
(2, 'AAPL', '320', '2020-02-11 00:00:00'),
(3, 'GOOGL', '1510', '2020-02-11 00:00:00'),
(4, 'MSFT', '185', '2020-02-11 00:00:00'),
(5, 'GOOGL', '1518', '2020-02-12 00:00:00'),
(6, 'MSFT', '184', '2020-02-12 00:00:00'),
(7, 'AAPL', '324', '2020-02-13 00:00:00'),
(8, 'GOOGL', '1520', '2020-02-14 00:00:00'),
(9, 'AAPL', '319', '2020-02-15 00:00:00'),
(10, 'GOOGL', '1523', '2020-02-15 00:00:00'),
(11, 'MSFT', '189', '2020-02-15 00:00:00'),
(12, 'GOOGL', '1530', '2020-02-16 00:00:00'),
(13, 'AAPL', '319', '2020-02-18 00:00:00'),
(14, 'MSFT', '187', '2020-02-18 00:00:00'),
(15, 'AAPL', '323', '2020-02-19 00:00:00'),
(16, 'AAPL', '313', '2020-02-21 00:00:00'),
(17, 'GOOGL', '1483', '2020-02-21 00:00:00'),
(18, 'MSFT', '178', '2020-02-21 00:00:00'),
(19, 'GOOGL', '1485', '2020-02-22 00:00:00'),
(20, 'MSFT', '180', '2020-02-22 00:00:00'),
(21, 'AAPL', '320', '2020-02-23 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stock_rates`
--
ALTER TABLE `stock_rates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stock_rates`
--
ALTER TABLE `stock_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
