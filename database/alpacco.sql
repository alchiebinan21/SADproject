-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2016 at 11:57 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `alpacco`
--

-- --------------------------------------------------------

--
-- Table structure for table `deletedmember`
--

CREATE TABLE IF NOT EXISTS `deletedmember` (
  `mrNo` int(30) NOT NULL,
  `fName` varchar(30) NOT NULL,
  `Lname` varchar(30) NOT NULL,
  `mBirthPlace` varchar(30) NOT NULL,
  `mAdd` varchar(30) NOT NULL,
  `mCivilStatus` varchar(30) NOT NULL,
  `mOccupation` varchar(30) NOT NULL,
  `mDateBirth` date NOT NULL,
  `mIncome` varchar(30) NOT NULL,
  `mPresentEmployer` varchar(30) NOT NULL,
  `mOtherSourceIncome` varchar(30) NOT NULL,
  `mContactNo` varchar(30) NOT NULL,
  `mEducationalBack` varchar(30) NOT NULL,
  `mRelative` varchar(30) NOT NULL,
  `mSSS` varchar(30) DEFAULT NULL,
  `mPhealth` varchar(30) NOT NULL,
  `deleted_by` varchar(42) NOT NULL,
  `date_deleted` date NOT NULL,
  `dateAdded` date NOT NULL,
  PRIMARY KEY (`mrNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deletedmember`
--

INSERT INTO `deletedmember` (`mrNo`, `fName`, `Lname`, `mBirthPlace`, `mAdd`, `mCivilStatus`, `mOccupation`, `mDateBirth`, `mIncome`, `mPresentEmployer`, `mOtherSourceIncome`, `mContactNo`, `mEducationalBack`, `mRelative`, `mSSS`, `mPhealth`, `deleted_by`, `date_deleted`, `dateAdded`) VALUES
(108, 'Altsi', 'Binan', 'Quezon City', 'Blk 20 Lot 3 Roseville Subd La', 'Single', 'Student', '2016-03-17', '4', '4', '4', '4', '4', '4', '4', '4', 'Alchie Binan', '2016-03-18', '0000-00-00'),
(109, 'Shir', 'Andrew', 'Davao City', 'Toril', 'Single', 'Student', '2016-03-01', '1000', 'NYK', 'Freelance', '122', 'College Graduate', 'Vicenta L Binan', '122', '222', 'Alchie Binan', '2016-03-19', '0000-00-00'),
(110, 'Alchie', 'Binan', 'Davao City', 'Bangkal, Davao City', 'Single', 'Student', '1990-03-20', '3000', 'NYK', 'Selling Drugs', '09322112590', 'College Graduate', 'Vicenta L Binan', '1234556', '123455', 'Alchie Binan', '2016-03-19', '2016-03-19'),
(111, 'asdfjkasdf', 'asgasdf', 'asdfasg', 'asdfasdg', 'Single', 'asdgasg', '2016-03-18', '2351235', 'asgasdf', 'sdfasdf', '123124', 'asdgasga', 'asgasdg', '131441', '1451515', 'Alchie Binan', '2016-03-19', '0000-00-00'),
(112, 'Shir', 'Binan', 'Quezon City', 'Bangkal, Davao City', 'Single', 'Student', '2016-03-15', '10000', 'NYK', 'Selling Drugs', '09322112590', 'College Graduate', 'Vicenta L Binan', '1221', '123455', 'Alchie Binan', '2016-03-19', '2016-03-19'),
(138, 'Alchie', 'Binan', 'Davao City', '\\', 'Single', 'Student', '2003-12-31', '3000', 'NYK', 'Selling Drugs', '09322112590', 'College Graduate', 'Vicenta L Binan', '1221', '123455', 'Alchie Binan', '2016-03-19', '2016-03-19');

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE IF NOT EXISTS `loan` (
  `ApplicationNo` int(30) NOT NULL AUTO_INCREMENT,
  `loanAmount` double DEFAULT NULL,
  `loanDate` date DEFAULT NULL,
  `loanPurpose` varchar(30) DEFAULT NULL,
  `loanType` varchar(30) DEFAULT NULL,
  `modeType` varchar(30) DEFAULT NULL,
  `approvalID` int(30) DEFAULT NULL,
  `loanTerm` int(30) DEFAULT NULL,
  `loanRepayment` varchar(45) DEFAULT NULL,
  `loanPaymentStart` date DEFAULT NULL,
  `coMakerID` int(30) DEFAULT NULL,
  `promNo` int(30) DEFAULT NULL,
  `mrNo` int(11) DEFAULT NULL,
  `loanInstallNo` int(11) DEFAULT NULL,
  `approval` int(11) DEFAULT '0',
  `reason` varchar(45) DEFAULT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'For Approval',
  `ReleasedBy` varchar(32) NOT NULL,
  `CertifiedBy` varchar(42) NOT NULL,
  `paidDate` date DEFAULT NULL,
  PRIMARY KEY (`ApplicationNo`),
  UNIQUE KEY `idMember` (`loanType`,`modeType`,`approvalID`,`coMakerID`,`promNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=187 ;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`ApplicationNo`, `loanAmount`, `loanDate`, `loanPurpose`, `loanType`, `modeType`, `approvalID`, `loanTerm`, `loanRepayment`, `loanPaymentStart`, `coMakerID`, `promNo`, `mrNo`, `loanInstallNo`, `approval`, `reason`, `status`, `ReleasedBy`, `CertifiedBy`, `paidDate`) VALUES
(183, 10000, '2016-03-19', NULL, 'Level Loan', 'Monthly', NULL, 10, 'Check', '2016-03-19', NULL, NULL, 132, NULL, 4, NULL, 'Paid', 'James Oliver Labor', 'Alchie Binan', '2016-03-19'),
(184, 1000, '2016-05-19', NULL, 'Level Loan', 'Monthly', NULL, 2, 'Check', '2016-05-19', NULL, NULL, 134, NULL, 4, NULL, 'Paid', 'James Oliver Labor', 'James Oliver Labor', '2016-03-19'),
(185, 2000, '2016-05-19', NULL, 'Productive Loan', 'Monthly', NULL, 2, 'Check', '2016-05-19', NULL, NULL, 132, NULL, 4, NULL, 'Paid', 'James Oliver Labor', 'James Oliver Labor', '2016-03-19'),
(186, 10000, '2016-03-19', NULL, 'Provincial', 'Monthly', NULL, 3, 'Check', '2016-03-19', NULL, NULL, 132, NULL, 4, NULL, 'On Going', 'James Oliver Labor', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loanp`
--

CREATE TABLE IF NOT EXISTS `loanp` (
  `paymentNo` int(11) NOT NULL AUTO_INCREMENT,
  `ApplicationNo` int(11) NOT NULL,
  `paymentDate` date NOT NULL,
  `paidOn` date DEFAULT NULL,
  `penalty` float DEFAULT NULL,
  `certifiedBy` varchar(32) DEFAULT NULL,
  `status` varchar(32) DEFAULT 'Pending',
  PRIMARY KEY (`paymentNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6189 ;

--
-- Dumping data for table `loanp`
--

INSERT INTO `loanp` (`paymentNo`, `ApplicationNo`, `paymentDate`, `paidOn`, `penalty`, `certifiedBy`, `status`) VALUES
(6172, 183, '2016-04-19', NULL, 0.01, NULL, 'Paid'),
(6173, 183, '2016-05-19', NULL, 0.01, NULL, 'Paid Advance'),
(6174, 183, '2016-06-19', NULL, 0.01, NULL, 'Paid Advance'),
(6175, 183, '2016-07-19', NULL, 0.01, NULL, 'Paid Advance'),
(6176, 183, '2016-08-19', NULL, 0.01, NULL, 'Paid Advance'),
(6177, 183, '2016-09-19', NULL, 0.01, NULL, 'Paid Advance'),
(6178, 183, '2016-10-19', NULL, NULL, NULL, 'Paid Advance'),
(6179, 183, '2016-11-19', NULL, NULL, NULL, 'Paid Advance'),
(6180, 183, '2016-12-19', NULL, NULL, NULL, 'Paid Advance'),
(6181, 183, '2017-01-19', NULL, NULL, NULL, 'Paid Advance'),
(6182, 184, '2016-06-19', NULL, NULL, NULL, 'Pending'),
(6183, 184, '2016-07-19', NULL, NULL, NULL, 'Pending'),
(6184, 185, '2016-06-19', NULL, NULL, NULL, 'Pending'),
(6185, 185, '2016-07-19', NULL, NULL, NULL, 'Pending'),
(6186, 186, '2016-04-19', NULL, 0.01, NULL, 'Pending'),
(6187, 186, '2016-05-19', NULL, NULL, NULL, 'Can be Paid Advance'),
(6188, 186, '2016-06-19', NULL, NULL, NULL, 'Can be Paid Advance');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `LogID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `Time_In` date NOT NULL,
  `Time_Out` date NOT NULL,
  `Date` date NOT NULL,
  PRIMARY KEY (`LogID`),
  UNIQUE KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `mrNo` int(30) NOT NULL AUTO_INCREMENT,
  `fName` varchar(30) NOT NULL,
  `Lname` varchar(30) NOT NULL,
  `mBirthPlace` varchar(30) NOT NULL,
  `mAdd` varchar(60) NOT NULL,
  `mCivilStatus` varchar(30) NOT NULL,
  `mOccupation` varchar(30) NOT NULL,
  `mDateBirth` date NOT NULL,
  `mIncome` varchar(30) NOT NULL,
  `mPresentEmployer` varchar(30) NOT NULL,
  `mOtherSourceIncome` varchar(30) NOT NULL,
  `mContactNo` varchar(30) NOT NULL,
  `mEducationalBack` varchar(30) NOT NULL,
  `mRelative` varchar(30) NOT NULL,
  `mSSS` varchar(30) DEFAULT NULL,
  `mPhealth` varchar(30) NOT NULL,
  `dateAdded` date NOT NULL,
  PRIMARY KEY (`mrNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=143 ;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`mrNo`, `fName`, `Lname`, `mBirthPlace`, `mAdd`, `mCivilStatus`, `mOccupation`, `mDateBirth`, `mIncome`, `mPresentEmployer`, `mOtherSourceIncome`, `mContactNo`, `mEducationalBack`, `mRelative`, `mSSS`, `mPhealth`, `dateAdded`) VALUES
(132, 'James', 'Labor', 'Davao City', 'Southvilla davao city', 'Single', 'Student', '2016-03-01', '2000', 'Addu', '2000', '09198295120', 'College', 'Brix', '12121', '1111', '0000-00-00'),
(139, '1', '1', '8', '8', 'Single', '9', '2016-03-06', '9', '9', '9', '9', '99', '0', '0', '0', '2016-03-19'),
(140, '1', '2', '9', '9', 'Single', '9', '1990-03-18', '0', '0', '0', '0', '0', '0', '0', '0', '2016-03-19'),
(141, 'Shri', 'Reyes', '7', '7', 'Single', 'i', '1990-03-29', '7', '7', '7', '7', '7', '7', '7', '7', '2016-03-19'),
(142, 'James', 'Reyes', '8', '9', 'Single', '9', '1990-03-17', '0', '0', '0', '0', '0', '0', '0', '0', '2016-03-19');

-- --------------------------------------------------------

--
-- Table structure for table `receiptp`
--

CREATE TABLE IF NOT EXISTS `receiptp` (
  `receiptpNo` int(11) NOT NULL AUTO_INCREMENT,
  `datePaid` date NOT NULL,
  `receivedBy` varchar(32) NOT NULL,
  `Amount` float NOT NULL,
  `paymentNo` int(11) NOT NULL,
  PRIMARY KEY (`receiptpNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `receiptp`
--

INSERT INTO `receiptp` (`receiptpNo`, `datePaid`, `receivedBy`, `Amount`, `paymentNo`) VALUES
(15, '2016-05-19', 'James Oliver Labor', 1212, 6172),
(16, '2016-05-19', 'James Oliver Labor', 1200, 6173),
(17, '2016-05-19', 'James Oliver Labor', 1200, 6174),
(18, '2016-05-19', 'James Oliver Labor', 1000, 6175),
(19, '2016-05-19', 'James Oliver Labor', 1000, 6176),
(20, '2016-05-19', 'James Oliver Labor', 1000, 6177),
(21, '2016-05-19', 'James Oliver Labor', 1000, 6178),
(22, '2016-05-19', 'James Oliver Labor', 1000, 6179),
(23, '2016-05-19', 'James Oliver Labor', 1000, 6180),
(24, '2016-05-19', 'James Oliver Labor', 1000, 6181),
(25, '2016-05-19', 'James Oliver Labor', 520, 6182),
(26, '2016-05-19', 'James Oliver Labor', 500, 6183),
(27, '2016-05-19', 'James Oliver Labor', 1040, 6184),
(28, '2016-05-19', 'James Oliver Labor', 1000, 6185);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `TransactionID` int(30) NOT NULL AUTO_INCREMENT,
  `TransactionDate` date DEFAULT NULL,
  `TransactionType` varchar(45) DEFAULT NULL,
  `Amount` int(11) DEFAULT NULL,
  `mrNo` int(11) DEFAULT NULL,
  `numOfShares` int(255) NOT NULL,
  PRIMARY KEY (`TransactionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`TransactionID`, `TransactionDate`, `TransactionType`, `Amount`, `mrNo`, `numOfShares`) VALUES
(12, '2016-03-18', NULL, 10000, 132, 4),
(13, '2016-05-19', NULL, 1000, 132, 2),
(14, '2016-03-19', NULL, 100, 137, 5),
(15, '2016-03-19', NULL, 111, 138, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `user` varchar(30) NOT NULL,
  `pass` varchar(30) NOT NULL,
  `position` varchar(45) NOT NULL,
  `fname` varchar(32) NOT NULL,
  `lname` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user`, `pass`, `position`, `fname`, `lname`) VALUES
(1, 'Alchie', 'alchie', 'Manager', 'Alchie', 'Binan'),
(2, 'Labor', 'labor', 'Treasurer', 'James Oliver', 'Labor'),
(3, 'Dara', 'dara', 'Board Chairman', '', ''),
(4, 'Edward', 'edward', 'Credit Committee', '', ''),
(5, 'Brix', 'brix', 'Manager', 'Brix', 'Ortiz'),
(6, 'tsial', 'tsial', 'Board Chairman', 'Tsial', 'altsi');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawreceipt`
--

CREATE TABLE IF NOT EXISTS `withdrawreceipt` (
  `withdrawNo` int(42) NOT NULL AUTO_INCREMENT,
  `mrNo` int(11) NOT NULL,
  `dateWithdraw` date NOT NULL,
  `Amount` double NOT NULL,
  `CertifiedBy` varchar(42) NOT NULL,
  PRIMARY KEY (`withdrawNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `withdrawreceipt`
--

INSERT INTO `withdrawreceipt` (`withdrawNo`, `mrNo`, `dateWithdraw`, `Amount`, `CertifiedBy`) VALUES
(34, 138, '2016-03-19', 555, 'Alchie Binan'),
(35, 138, '2016-03-19', 555, 'Alchie Binan'),
(36, 138, '2016-03-19', 555, 'Alchie Binan'),
(37, 138, '2016-03-19', 555, 'Alchie Binan'),
(38, 138, '2016-03-19', 555, 'Alchie Binan'),
(39, 138, '2016-03-19', 555, 'Alchie Binan'),
(40, 138, '2016-03-19', 555, 'Alchie Binan');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
