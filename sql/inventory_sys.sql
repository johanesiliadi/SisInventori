-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2015 at 07:06 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `inventory_sys`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
`id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `information` text
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `code`, `name`, `address`, `phone`, `information`) VALUES
(1, 'C1', 'Client1', 'Address 1', '000000', 'Info 1'),
(2, 'Client2', 'Client2', 'test address', '93939393', 'test info');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
`id` int(11) NOT NULL,
  `item_code` varchar(10) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `quantity` double NOT NULL,
  `uom_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `item_code`, `item_name`, `quantity`, `uom_id`) VALUES
(1, 'item1', 'item1', 255, 2),
(2, 'item2', 'item2', 12001.666666667, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_mutation`
--

CREATE TABLE IF NOT EXISTS `inventory_mutation` (
`id` int(11) NOT NULL,
  `quantity` double NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` varchar(1) NOT NULL,
  `remarks` text,
  `uom_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory_mutation`
--

INSERT INTO `inventory_mutation` (`id`, `quantity`, `inventory_id`, `update_by`, `update_time`, `type`, `remarks`, `uom_id`) VALUES
(2, 100, 1, 1, '2015-02-28 17:05:29', '0', 'test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
`id` int(11) NOT NULL,
  `invoice_no` varchar(20) NOT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `status` varchar(1) NOT NULL,
  `remarks` text,
  `invoice_date` date NOT NULL,
  `delivery_fee` decimal(10,0) DEFAULT NULL,
  `discount` decimal(10,0) DEFAULT NULL,
  `total` decimal(10,0) DEFAULT NULL,
  `sales` varchar(50) NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `invoice_no`, `payment_id`, `client_id`, `status`, `remarks`, `invoice_date`, `delivery_fee`, `discount`, `total`, `sales`, `update_by`, `update_time`) VALUES
(7, 'INV-20150101', NULL, 1, 'A', '123', '2015-03-01', '1000', '1000', '7000', '123', 1, '2015-03-01 13:10:51');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
`id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `uom_id` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `discount` decimal(10,0) NOT NULL,
  `nett_price` decimal(10,0) NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `status` varchar(1) NOT NULL,
  `invoice_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `inventory_id`, `quantity`, `uom_id`, `price`, `discount`, `nett_price`, `total`, `status`, `invoice_id`) VALUES
(1, 1, 14, 1, '1500', '150', '1350', '18900', 'D', 5),
(4, 1, 5, 1, '1500', '100', '1400', '7000', 'A', 7);

-- --------------------------------------------------------

--
-- Table structure for table `uom`
--

CREATE TABLE IF NOT EXISTS `uom` (
`id` int(11) NOT NULL,
  `long_name` varchar(50) NOT NULL,
  `short_name` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uom`
--

INSERT INTO `uom` (`id`, `long_name`, `short_name`) VALUES
(1, 'uom1', 'uom1'),
(2, 'uom2', 'uom2');

-- --------------------------------------------------------

--
-- Table structure for table `uom_ratio`
--

CREATE TABLE IF NOT EXISTS `uom_ratio` (
`id` int(11) NOT NULL,
  `uom_id1` int(11) NOT NULL,
  `uom_id2` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `ratio1` int(11) NOT NULL,
  `ratio2` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uom_ratio`
--

INSERT INTO `uom_ratio` (`id`, `uom_id1`, `uom_id2`, `name`, `ratio1`, `ratio2`) VALUES
(1, 1, 2, 'uomratio1', 1, 3),
(2, 1, 2, 'uomratio2', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(10) unsigned NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `name`, `password`) VALUES
(1, 'admin', 'admin', '5f4dcc3b5aa765d61d8327deb882cf99'),
(3, 'admin2', 'admin2', '5f4dcc3b5aa765d61d8327deb882cf99');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_mutation`
--
ALTER TABLE `inventory_mutation`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uom`
--
ALTER TABLE `uom`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uom_ratio`
--
ALTER TABLE `uom_ratio`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `inventory_mutation`
--
ALTER TABLE `inventory_mutation`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `uom`
--
ALTER TABLE `uom`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `uom_ratio`
--
ALTER TABLE `uom_ratio`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
