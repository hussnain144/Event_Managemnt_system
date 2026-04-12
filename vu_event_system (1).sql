-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2026 at 05:13 PM
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
-- Database: `vu_event_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `Event_ID` int(11) NOT NULL,
  `Title` varchar(100) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Time` time DEFAULT NULL,
  `Venue` varchar(100) DEFAULT NULL,
  `Capacity` int(11) DEFAULT NULL,
  `Status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `Organizer_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`Event_ID`, `Title`, `Description`, `Date`, `Time`, `Venue`, `Capacity`, `Status`, `Organizer_ID`) VALUES
(14, 'Annual Dinner', 'vdahfvasjcvdhjk', '2026-02-14', '16:22:00', 'uni', 4000, 'Approved', 2),
(15, 'Bonfire', 'pyara bhai', '2026-02-27', '19:45:00', 'University', 200, 'Approved', 5);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `Feedback_ID` int(11) NOT NULL,
  `Event_ID` int(11) DEFAULT NULL,
  `Student_ID` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL CHECK (`Rating` >= 1 and `Rating` <= 5),
  `Comments` text DEFAULT NULL,
  `Submission_Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`Feedback_ID`, `Event_ID`, `Student_ID`, `Rating`, `Comments`, `Submission_Date`) VALUES
(3, 14, 1, 4, 'nyc', '2026-02-14 11:34:44'),
(4, 14, 1, 5, 'good', '2026-02-14 12:28:49'),
(5, 14, 1, 5, 'zabardast', '2026-02-14 12:49:14'),
(6, 14, 1, 4, 'very good', '2026-02-14 14:38:38'),
(7, 15, 1, 3, 'maza  aya', '2026-02-14 14:45:21');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `Reg_ID` int(11) NOT NULL,
  `Event_ID` int(11) DEFAULT NULL,
  `Student_ID` int(11) DEFAULT NULL,
  `Reg_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Reminder_Status` int(11) DEFAULT 0,
  `Attendance_Status` enum('Pending','Present','Absent') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`Reg_ID`, `Event_ID`, `Student_ID`, `Reg_Date`, `Reminder_Status`, `Attendance_Status`) VALUES
(4, 14, 1, '2026-02-14 12:28:37', 0, 'Pending'),
(5, 15, 1, '2026-02-14 14:45:08', 0, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Role` enum('Admin','Organizer','Student') DEFAULT NULL,
  `Department` varchar(100) DEFAULT NULL,
  `Contact_No` varchar(20) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `Name`, `Email`, `Password`, `Role`, `Department`, `Contact_No`, `reset_token`) VALUES
(1, 'Muhammad Hussnain', 'husnainfareed535@gmail.com', '$2y$10$3.CD4lvS4HnRKR2p/ihWnOqzg3vqvyFwVHrQD0j31s/THDon.9gWC', 'Student', 'CS', '03011496619', NULL),
(2, 'Husnain Fareed', 'husnainkhanj535@gmail.com', '$2y$10$H8kRnDS.ClcNo4ehouDIROdecptOQk81ocZBlTcpOqfnFMs3ze.GG', 'Organizer', 'CS', '098654433333', NULL),
(3, 'Main Admin', 'admin@vu.edu.pk', '$2y$10$8v8Wz.B4G9o7YhE7R/vYvO.o7hG7XyZzZzZzZzZzZzZzZzZzZz', 'Admin', 'Administration', '03001234567', NULL),
(4, 'Muhammad Hussnain', 'husnainfareed@gmail.com', '$2y$10$29/Y3DmuLypHPLdhu8yTJ.RIurSM9HTCAdOxHhIEV4tYXRTMsekKe', 'Admin', 'CS', '03011496619', NULL),
(5, 'Muhamma Umar', 'chumarkwl@gmail.com', '$2y$10$CcXTXZ0Snb48Se6lYomZmuBEMelqbZyVh3QFOLASLFOu5zZ1cNexm', 'Organizer', 'CS', '03011496619', '584986');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`Event_ID`),
  ADD KEY `Organizer_ID` (`Organizer_ID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`Feedback_ID`),
  ADD KEY `Event_ID` (`Event_ID`),
  ADD KEY `Student_ID` (`Student_ID`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`Reg_ID`),
  ADD KEY `Event_ID` (`Event_ID`),
  ADD KEY `Student_ID` (`Student_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `Event_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `Feedback_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `Reg_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`Organizer_ID`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`Event_ID`) REFERENCES `events` (`Event_ID`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`Student_ID`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`Event_ID`) REFERENCES `events` (`Event_ID`),
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`Student_ID`) REFERENCES `users` (`User_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
