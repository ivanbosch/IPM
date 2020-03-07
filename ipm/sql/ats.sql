-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2020 at 01:43 AM
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
(6, 444, NULL, NULL, 3032020),
(7, 444, NULL, NULL, 3032020),
(8, 444, NULL, NULL, 3032020),
(9, 444, NULL, NULL, 3032020),
(10, 444, NULL, NULL, 10032020),
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
(8, 3, 1, NULL, 'London', 'Berlin', '23:00:00', '2020-03-13');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `currency_ID` int(10) NOT NULL,
  `currency_Name` varchar(20) NOT NULL,
  `currency_Rate` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_ID` int(10) NOT NULL,
  `customer_Type` varchar(8) DEFAULT NULL,
  `customer_Name` varchar(8) DEFAULT NULL,
  `customer_LP` date DEFAULT NULL,
  `customer_Debt` int(11) DEFAULT NULL,
  `discount_ID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `discount_ID` int(10) NOT NULL,
  `discount_Type` varchar(10) DEFAULT NULL,
  `discount_Amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `sales_charge` decimal(11,0) NOT NULL,
  `payment_Type` varchar(10) NOT NULL,
  `card_Digits` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `staff_Comission` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_ID`, `staff_Type`, `staff_Name`, `staff_Surname`, `staff_Email`, `staff_Comission`) VALUES
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
(85);

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
  MODIFY `coupon_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `currency_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `discount_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_in`
--
ALTER TABLE `log_in`
  MODIFY `staff_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

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
