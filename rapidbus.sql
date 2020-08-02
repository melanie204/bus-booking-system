-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2020 at 05:32 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rapidbus`
--

-- --------------------------------------------------------

--
-- Table structure for table `bus`
--

CREATE TABLE `bus` (
  `busID` varchar(35) NOT NULL,
  `busType` varchar(35) NOT NULL,
  `ticketPrice` float(7,2) NOT NULL,
  `totalTicketPerBus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bus`
--

INSERT INTO `bus` (`busID`, `busType`, `ticketPrice`, `totalTicketPerBus`) VALUES
('b01', 'Premium', 15.00, 45),
('b02', 'Normal', 10.00, 50),
('b03', 'Rapid', 18.00, 50);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderNumber` int(11) NOT NULL,
  `orderTotalPrice` float(11,2) NOT NULL,
  `userID` varchar(35) NOT NULL,
  `busID` varchar(35) NOT NULL,
  `busType` varchar(35) NOT NULL,
  `depLocation` varchar(255) NOT NULL,
  `arrLocation` varchar(255) NOT NULL,
  `depTime` varchar(5) NOT NULL,
  `arrTime` varchar(5) NOT NULL,
  `depDate` varchar(10) NOT NULL,
  `arrDate` varchar(10) NOT NULL,
  `childrenTickets` int(11) DEFAULT NULL,
  `adultTickets` int(11) DEFAULT NULL,
  `seniorTickets` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderNumber`, `orderTotalPrice`, `userID`, `busID`, `busType`, `depLocation`, `arrLocation`, `depTime`, `arrTime`, `depDate`, `arrDate`, `childrenTickets`, `adultTickets`, `seniorTickets`) VALUES
(1, 15.00, 'johnson11188', 'b01', 'Premium', 'Klang', 'Penang', '11:00', '19:00', '25-07-20', '25-07-2020', 0, 1, 0),
(2, 15.00, 'djghsoiqw', 'b01', 'Premium', 'Kuala Lumpur', 'Johor Bahru', '11:00', '19:00', '02-08-2020', '02-08-2020', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `scheduleID` varchar(35) NOT NULL,
  `depLocation` varchar(255) NOT NULL,
  `arrLocation` varchar(255) NOT NULL,
  `depTime` varchar(5) NOT NULL,
  `arrTime` varchar(5) NOT NULL,
  `depDate` varchar(10) NOT NULL,
  `arrDate` varchar(10) NOT NULL,
  `ticketLeft` int(11) DEFAULT NULL,
  `busID` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`scheduleID`, `depLocation`, `arrLocation`, `depTime`, `arrTime`, `depDate`, `arrDate`, `ticketLeft`, `busID`) VALUES
('s01', 'Klang', 'Penang', '11:00', '19:00', '25-07-2020', '25-07-2020', 44, 'b01'),
('s02', 'Kuala Lumpur', 'Johor Bahru', '11:00', '19:00', '02-08-2020', '02-08-2020', 44, 'b01'),
('s03', 'Johor Bahru', 'Klang', '09:00', '15:00', '05-08-2020', '05-08-2020', 50, 'b02');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` varchar(35) NOT NULL,
  `staffPassword` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `staffPassword`) VALUES
('s190181', 'hibye999');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` varchar(35) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `userBirthday` varchar(10) DEFAULT NULL,
  `userPassword` varchar(32) NOT NULL,
  `userPNumber` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userName`, `userBirthday`, `userPassword`, `userPNumber`) VALUES
('djghsoiqw', 'Tan One', '01-01-2001', 'Jason123', '01987654322'),
('johnson11188', 'Johnson Shampoo', '10-11-1999', 'js1111p0', '0102345677'),
('lim1234', 'abcd', '12-12-2001', 'Lim12345', '0104102998'),
('nsaho122', 'dga', '01-01-2001', 'Dga123!@', '0104103333');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bus`
--
ALTER TABLE `bus`
  ADD PRIMARY KEY (`busID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderNumber`),
  ADD KEY `userID` (`userID`),
  ADD KEY `busID` (`busID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`scheduleID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`busID`) REFERENCES `bus` (`busID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
