-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2020 at 03:35 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ats`
--

-- --------------------------------------------------------

--
-- Table structure for table `blanks`
--

CREATE TABLE `blanks` (
  `blank_ID` int(10) NOT NULL,
  `blank_Type` int(3) DEFAULT NULL,
  `blank_Advisor_ID` int(10) DEFAULT NULL,
  `blank_Manager_ID` int(10) DEFAULT NULL,
  `blank_Date` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blanks`
--

INSERT INTO `blanks` (`blank_ID`, `blank_Type`, `blank_Advisor_ID`, `blank_Manager_ID`, `blank_Date`) VALUES
(1, 444, NULL, NULL, 3032020),
(2, 101, 200, NULL, 3032020),
(3, 101, 201, NULL, 3032020),
(5, 101, 201, NULL, 3032020),
(6, 101, 201, NULL, 3032020),
(7, 444, 201, NULL, 3032020),
(8, 444, 201, NULL, 3032020),
(9, 444, 201, NULL, 3032020),
(10, 444, 201, NULL, 10032020),
(11, 201, NULL, NULL, 3032020),
(12, 201, NULL, NULL, 3032020),
(13, 201, NULL, NULL, 3032020),
(14, 201, NULL, NULL, 3032020),
(15, 201, NULL, NULL, 3032020);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `coupon_ID` int(10) NOT NULL,
  `blank_ID` int(10) NOT NULL,
  `ticket_ID` int(10) NOT NULL,
  `coupon_Number` int(8) DEFAULT NULL,
  `coupon_Origin` text,
  `coupon_Destination` text,
  `coupon_Time` time DEFAULT NULL,
  `coupon_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`coupon_ID`, `blank_ID`, `ticket_ID`, `coupon_Number`, `coupon_Origin`, `coupon_Destination`, `coupon_Time`, `coupon_Date`) VALUES
(13, 7, 1, 0, 'London', 'Berlin', '23:00:00', '2020-03-15'),
(14, 7, 1, 0, 'Berlin', 'Barcelona', '12:12:00', '2020-03-20'),
(15, 7, 1, 0, 'Azza', 'Azza', '03:32:00', '2020-03-27'),
(16, 7, 1, 0, 'Azza', 'Azza', '03:43:00', '2020-03-29'),
(20, 3, 81, 0, 'Jebnai', 'Mert\'s Ass', '00:59:00', '2020-04-05'),
(23, 8, 82, 0, '', '', '00:00:00', '0000-00-00'),
(36, 5, 83, 0, 'London', 'Berlin', '23:00:00', '2020-03-28'),
(39, 6, 84, 0, 'London', 'Berlin', '23:00:00', '2020-03-19'),
(40, 9, 85, 0, 'London', 'Berlin', '21:00:00', '2020-03-28'),
(41, 10, 86, 0, 'Jebnai', 'Berlin', '00:59:00', '2020-03-28');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `currency_ID` int(10) NOT NULL,
  `currency_Name` varchar(20) NOT NULL,
  `currency_Rate` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`currency_ID`, `currency_Name`, `currency_Rate`) VALUES
(1, 'Dollars', '1'),
(2, 'Argentinean Pesos', '67');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_ID` int(10) NOT NULL,
  `customer_Type` varchar(8) DEFAULT NULL,
  `customer_Name` tinytext,
  `customer_Surname` tinytext,
  `customer_Email` varchar(50) NOT NULL,
  `customer_LP` date DEFAULT NULL,
  `customer_Debt` int(11) DEFAULT NULL,
  `discount_ID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_ID`, `customer_Type`, `customer_Name`, `customer_Surname`, `customer_Email`, `customer_LP`, `customer_Debt`, `discount_ID`) VALUES
(1, 'Regular', 'Jebnai', 'Beyene', '', '2020-02-19', 500, 1),
(2, 'Valued', 'Ivan', 'Bosch', 'bosch.ivan99@gmail.com', '2020-01-15', 9000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `discount_ID` int(10) NOT NULL,
  `discount_Type` varchar(10) DEFAULT NULL,
  `discount_Amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`discount_ID`, `discount_Type`, `discount_Amount`) VALUES
(1, 'Flex', 10);

-- --------------------------------------------------------

--
-- Table structure for table `log_in`
--

CREATE TABLE `log_in` (
  `login_username` smallint(6) NOT NULL,
  `login_password` longtext NOT NULL,
  `staff_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_in`
--

INSERT INTO `log_in` (`login_username`, `login_password`, `staff_ID`) VALUES
(666, '$2y$10$kwabMMsrmxCcYxlXV10alOD09soFKmcJwqOJGn7nahjCEsTFQQu7G', 201);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_ID` int(10) NOT NULL,
  `sales_Type` varchar(10) NOT NULL,
  `staff_ID` int(10) NOT NULL,
  `currency_ID` int(10) NOT NULL,
  `currency_Rate` decimal(10,0) NOT NULL,
  `customer_ID` int(10) NOT NULL,
  `ticket_ID` int(10) NOT NULL,
  `sales_Charge` decimal(11,0) NOT NULL,
  `payment_Type` varchar(10) NOT NULL,
  `card_Digits` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_ID`, `sales_Type`, `staff_ID`, `currency_ID`, `currency_Rate`, `customer_ID`, `ticket_ID`, `sales_Charge`, `payment_Type`, `card_Digits`) VALUES
(1, 'Domestic', 200, 1, '1', 1, 1, '501', 'Card', 3567),
(2, 'Interline', 201, 2, '67', 2, 83, '3', 'Card', 9999),
(3, 'Interline', 201, 1, '1', 2, 85, '1', 'Cash', 0),
(5, 'Interline', 201, 1, '1', 2, 86, '1', 'Cash', 0);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_ID` int(10) NOT NULL,
  `staff_Type` tinytext NOT NULL,
  `staff_Name` tinytext,
  `staff_Surname` tinytext,
  `staff_Email` varchar(100) DEFAULT NULL,
  `staff_Commission` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_ID`, `staff_Type`, `staff_Name`, `staff_Surname`, `staff_Email`, `staff_Commission`) VALUES
(200, 'Advisor', '555', '555', '123@gmail.com', 0),
(201, 'Advisor', '666', '666', 'bosch.ivan99@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_ID`) VALUES
(1),
(81),
(82),
(83),
(84),
(85),
(86),
(87),
(88),
(89),
(90),
(151),
(152),
(153),
(154),
(155);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blanks`
--
ALTER TABLE `blanks`
  ADD PRIMARY KEY (`blank_ID`),
  ADD KEY `blank_Advisor_ID` (`blank_Advisor_ID`),
  ADD KEY `blank_Manager_ID` (`blank_Manager_ID`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`coupon_ID`),
  ADD KEY `ticket_ID` (`ticket_ID`),
  ADD KEY `blank_ID` (`blank_ID`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`currency_ID`),
  ADD UNIQUE KEY `currency_Name` (`currency_Name`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_ID`),
  ADD KEY `discount_ID` (`discount_ID`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`discount_ID`);

--
-- Indexes for table `log_in`
--
ALTER TABLE `log_in`
  ADD PRIMARY KEY (`login_username`),
  ADD UNIQUE KEY `login_username` (`login_username`),
  ADD UNIQUE KEY `staff_ID` (`staff_ID`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_ID`),
  ADD UNIQUE KEY `sales_ID` (`sales_ID`),
  ADD UNIQUE KEY `ticket_ID` (`ticket_ID`),
  ADD KEY `staff_ID` (`staff_ID`),
  ADD KEY `currency_ID` (`currency_ID`),
  ADD KEY `customer_ID` (`customer_ID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_ID`),
  ADD UNIQUE KEY `staff_ID` (`staff_ID`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blanks`
--
ALTER TABLE `blanks`
  MODIFY `blank_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `coupon_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `currency_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `discount_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `log_in`
--
ALTER TABLE `log_in`
  MODIFY `staff_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blanks`
--
ALTER TABLE `blanks`
  ADD CONSTRAINT `blanks_ibfk_1` FOREIGN KEY (`blank_Advisor_ID`) REFERENCES `staff` (`staff_ID`),
  ADD CONSTRAINT `blanks_ibfk_2` FOREIGN KEY (`blank_Manager_ID`) REFERENCES `staff` (`staff_ID`);

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_ibfk_1` FOREIGN KEY (`blank_ID`) REFERENCES `blanks` (`blank_ID`),
  ADD CONSTRAINT `coupons_ibfk_2` FOREIGN KEY (`ticket_ID`) REFERENCES `tickets` (`ticket_ID`),
  ADD CONSTRAINT `coupons_ibfk_3` FOREIGN KEY (`blank_ID`) REFERENCES `blanks` (`blank_ID`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`discount_ID`) REFERENCES `discounts` (`discount_ID`);

--
-- Constraints for table `log_in`
--
ALTER TABLE `log_in`
  ADD CONSTRAINT `log_in_ibfk_1` FOREIGN KEY (`staff_ID`) REFERENCES `staff` (`staff_ID`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`staff_ID`) REFERENCES `staff` (`staff_ID`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`currency_ID`) REFERENCES `currency` (`currency_ID`),
  ADD CONSTRAINT `sales_ibfk_3` FOREIGN KEY (`ticket_ID`) REFERENCES `tickets` (`ticket_ID`),
  ADD CONSTRAINT `sales_ibfk_4` FOREIGN KEY (`customer_ID`) REFERENCES `customers` (`customer_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
