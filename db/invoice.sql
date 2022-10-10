-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2022 at 07:22 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `invoice`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(3) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `customer_address` varchar(50) NOT NULL,
  `customer_mobile` varchar(50) NOT NULL,
  `customer_brn` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_address`, `customer_mobile`, `customer_brn`) VALUES
(1, 'Salman', 'Port Louis', '57895632', '12345678'),
(2, 'Kabir', 'Curepipe', '52124335', '355484356');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `invoice_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(6) NOT NULL,
  `qty` int(6) NOT NULL,
  `total_price` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`invoice_id`, `order_id`, `product_id`, `qty`, `total_price`) VALUES
(1, 1, 0, 0, 0),
(2, 7, 1, 5, 625),
(3, 8, 1, 15, 1875),
(4, 8, 1, 1, 125),
(5, 8, 6, 20, 13000),
(6, 8, 4, 10, 350),
(7, 9, 1, 10, 1250),
(8, 9, 1, 0, 0),
(9, 10, 7, 0, 0),
(10, 11, 1, 10, 1250),
(11, 11, 1, 20, 2500),
(12, 12, 1, 10, 1250),
(13, 12, 5, 30, 1050),
(14, 12, 5, 0, 0),
(15, 13, 1, 15, 1875),
(16, 13, 6, 20, 13000);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(3) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_ref` varchar(50) NOT NULL,
  `product_barcode` varchar(50) NOT NULL,
  `product_price` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_ref`, `product_barcode`, `product_price`) VALUES
(1, 'Juice Sunquick ', '500ml', '243253525335', '125'),
(2, 'Juice orange ', '100 ml', '36653547554', '55'),
(3, 'Pepsi 1ltr', '1 ltr', '21424133434', '60'),
(4, 'Pepsi 0.5', '0.5 ml', '6787767769', '35'),
(5, 'Coca 0.5', '0.5 ml', '786787869876956', '35'),
(6, 'Rice Basmati', 'Raja   5 kg', '76960979', '650'),
(7, 'Bottle Water 1 lt pack', 'Pack 12', '632562547647', '600');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
