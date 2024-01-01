-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 25, 2023 at 05:23 AM
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
-- Database: `acams_byteshift`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `a_adminID` int(15) NOT NULL,
  `a_username` varchar(20) NOT NULL,
  `a_password` varchar(20) NOT NULL,
  `a_fname` varchar(50) NOT NULL,
  `a_lname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `constructionelectricalitem`
--

CREATE TABLE `constructionelectricalitem` (
  `CEL_ID` int(15) NOT NULL,
  `CEL_name` varchar(20) NOT NULL,
  `CEL_type` varchar(20) NOT NULL,
  `CEL_unit` varchar(10) NOT NULL,
  `CEL_price` double NOT NULL,
  `CEL_date` date NOT NULL,
  `CEL_time` time NOT NULL,
  `CEL_state` varchar(20) NOT NULL,
  `CEL_city` varchar(20) NOT NULL,
  `CEL_distance` double NOT NULL,
  `CEL_percentage` double NOT NULL,
  `CEL_AID` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `constructionengineeringitem`
--

CREATE TABLE `constructionengineeringitem` (
  `CEN_ID` int(15) NOT NULL,
  `CEN_name` varchar(20) NOT NULL,
  `CEN_type` varchar(20) NOT NULL,
  `CEN_unit` varchar(10) NOT NULL,
  `CEN_price` double NOT NULL,
  `CEN_date` date NOT NULL,
  `CEN_time` time NOT NULL,
  `CEN_state` varchar(20) NOT NULL,
  `CEN_city` varchar(20) NOT NULL,
  `CEN_distance` double NOT NULL,
  `CEN_percentage` double NOT NULL,
  `CEN_AID` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custemail`
--

CREATE TABLE `custemail` (
  `c_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custphone`
--

CREATE TABLE `custphone` (
  `c_phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `c_category`
--

CREATE TABLE `c_category` (
  `c_id` int(2) NOT NULL,
  `c_desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `e_content` text NOT NULL,
  `e_ID` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventoryitem`
--

CREATE TABLE `inventoryitem` (
  `I_ID` int(15) NOT NULL,
  `I_name` varchar(20) NOT NULL,
  `I_desc` varchar(50) NOT NULL,
  `I_unitprice` double NOT NULL,
  `I_quantity` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `I_ID` int(15) NOT NULL,
  `I_issuedate` date NOT NULL,
  `I_expirydate` date NOT NULL,
  `I_remains` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `L_inventID` int(10) NOT NULL,
  `L_adminID` int(15) NOT NULL,
  `L_min` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `management`
--

CREATE TABLE `management` (
  `m_AID` int(15) NOT NULL,
  `m_qaOID` int(15) NOT NULL,
  `m_SID` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ordercreation`
--

CREATE TABLE `ordercreation` (
  `OC_ID` int(10) NOT NULL,
  `OC_adminID` int(15) NOT NULL,
  `OC_date` date NOT NULL,
  `OC_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `p_ID` int(5) NOT NULL,
  `p_date` date NOT NULL,
  `p_amount` double NOT NULL,
  `p_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quoteads`
--

CREATE TABLE `quoteads` (
  `qa_OID` int(15) NOT NULL,
  `qa_status` int(2) NOT NULL,
  `qa_cid` int(15) NOT NULL,
  `qa_cadress` text NOT NULL,
  `qa_cname` varchar(50) NOT NULL,
  `qa_ccategory` int(2) NOT NULL,
  `qa_itemType` varchar(20) NOT NULL,
  `qa_itemName` varchar(20) NOT NULL,
  `qa_quantity` int(10) NOT NULL,
  `qa_itemID` int(15) NOT NULL,
  `qa_ID` int(15) NOT NULL,
  `qa_issueDate` date NOT NULL,
  `qa_expiryDate` date NOT NULL,
  `qa_grandTotal` double NOT NULL,
  `qa_cemail` varchar(50) NOT NULL,
  `qa_cphone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotecons`
--

CREATE TABLE `quotecons` (
  `qc_name` varchar(20) NOT NULL,
  `qc_type` varchar(20) NOT NULL,
  `qc_quantity` int(5) NOT NULL,
  `qc_state` varchar(20) NOT NULL,
  `qc_city` varchar(20) NOT NULL,
  `qc_distance` double NOT NULL,
  `qc_AID` int(15) NOT NULL,
  `qc_issuedate` date NOT NULL,
  `qc_expirydate` date NOT NULL,
  `qc_grandtotal` double NOT NULL,
  `qc_OCID` int(15) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `s_staffID` int(15) NOT NULL,
  `s_username` varchar(20) NOT NULL,
  `s_password` varchar(20) NOT NULL,
  `s_fname` varchar(50) NOT NULL,
  `s_lname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `s_ID` int(2) NOT NULL,
  `s_desc` varchar(20) NOT NULL,
  `s_OCID` int(15) NOT NULL,
  `s_OAID` int(15) NOT NULL,
  `s_IID` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `verifiedpay`
--

CREATE TABLE `verifiedpay` (
  `vp_ID` int(15) NOT NULL,
  `vp_PID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`a_adminID`,`a_username`);

--
-- Indexes for table `constructionelectricalitem`
--
ALTER TABLE `constructionelectricalitem`
  ADD PRIMARY KEY (`CEL_ID`,`CEL_percentage`,`CEL_distance`,`CEL_city`,`CEL_state`,`CEL_name`,`CEL_type`),
  ADD UNIQUE KEY `CEL_AID` (`CEL_AID`);

--
-- Indexes for table `constructionengineeringitem`
--
ALTER TABLE `constructionengineeringitem`
  ADD PRIMARY KEY (`CEN_ID`,`CEN_name`,`CEN_type`,`CEN_state`,`CEN_city`,`CEN_distance`,`CEN_percentage`),
  ADD UNIQUE KEY `CEN_AID` (`CEN_AID`);

--
-- Indexes for table `custemail`
--
ALTER TABLE `custemail`
  ADD PRIMARY KEY (`c_email`);

--
-- Indexes for table `custphone`
--
ALTER TABLE `custphone`
  ADD PRIMARY KEY (`c_phone`);

--
-- Indexes for table `c_category`
--
ALTER TABLE `c_category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD UNIQUE KEY `e_ID` (`e_ID`);

--
-- Indexes for table `inventoryitem`
--
ALTER TABLE `inventoryitem`
  ADD PRIMARY KEY (`I_ID`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`I_ID`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD UNIQUE KEY `L_inventID` (`L_inventID`),
  ADD UNIQUE KEY `L_adminID` (`L_adminID`);

--
-- Indexes for table `management`
--
ALTER TABLE `management`
  ADD UNIQUE KEY `m_username` (`m_AID`),
  ADD UNIQUE KEY `m_ID` (`m_qaOID`),
  ADD UNIQUE KEY `m_SID` (`m_SID`),
  ADD UNIQUE KEY `m_qaOID` (`m_qaOID`),
  ADD UNIQUE KEY `m_susername` (`m_SID`),
  ADD UNIQUE KEY `m_ausername` (`m_AID`),
  ADD UNIQUE KEY `m_AID` (`m_AID`);

--
-- Indexes for table `ordercreation`
--
ALTER TABLE `ordercreation`
  ADD PRIMARY KEY (`OC_date`,`OC_time`),
  ADD UNIQUE KEY `OC_ID` (`OC_ID`),
  ADD UNIQUE KEY `OC_adminID` (`OC_adminID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`p_ID`);

--
-- Indexes for table `quoteads`
--
ALTER TABLE `quoteads`
  ADD PRIMARY KEY (`qa_OID`,`qa_cid`,`qa_ID`),
  ADD UNIQUE KEY `qa_ccategory` (`qa_ccategory`),
  ADD UNIQUE KEY `qa_itemID` (`qa_itemID`),
  ADD UNIQUE KEY `qa_cemail` (`qa_cemail`),
  ADD UNIQUE KEY `qa_cphone` (`qa_cphone`);

--
-- Indexes for table `quotecons`
--
ALTER TABLE `quotecons`
  ADD PRIMARY KEY (`qc_OCID`,`qc_qID`),
  ADD UNIQUE KEY `qc_EIID` (`qc_EIID`),
  ADD UNIQUE KEY `qc_ELID` (`qc_ELID`),
  ADD UNIQUE KEY `qc_AID` (`qc_AID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`s_staffID`,`s_username`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`s_ID`),
  ADD UNIQUE KEY `s_OCID` (`s_OCID`),
  ADD UNIQUE KEY `s_OAID` (`s_OAID`),
  ADD UNIQUE KEY `s_IID` (`s_IID`);

--
-- Indexes for table `verifiedpay`
--
ALTER TABLE `verifiedpay`
  ADD UNIQUE KEY `vp_ID` (`vp_ID`),
  ADD UNIQUE KEY `vp_PID` (`vp_PID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `constructionelectricalitem`
--
ALTER TABLE `constructionelectricalitem`
  MODIFY `CEL_ID` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `constructionengineeringitem`
--
ALTER TABLE `constructionengineeringitem`
  MODIFY `CEN_ID` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `I_ID` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `p_ID` int(5) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `constructionelectricalitem`
--
ALTER TABLE `constructionelectricalitem`
  ADD CONSTRAINT `constructionelectricalitem_ibfk_1` FOREIGN KEY (`CEL_AID`) REFERENCES `administrator` (`a_adminID`);

--
-- Constraints for table `constructionengineeringitem`
--
ALTER TABLE `constructionengineeringitem`
  ADD CONSTRAINT `constructionengineeringitem_ibfk_1` FOREIGN KEY (`CEN_AID`) REFERENCES `administrator` (`a_adminID`);

--
-- Constraints for table `email`
--
ALTER TABLE `email`
  ADD CONSTRAINT `email_ibfk_1` FOREIGN KEY (`e_ID`) REFERENCES `quoteads` (`qa_OID`);

--
-- Constraints for table `level`
--
ALTER TABLE `level`
  ADD CONSTRAINT `level_ibfk_1` FOREIGN KEY (`L_adminID`) REFERENCES `administrator` (`a_adminID`),
  ADD CONSTRAINT `level_ibfk_2` FOREIGN KEY (`L_inventID`) REFERENCES `inventoryitem` (`I_ID`);

--
-- Constraints for table `management`
--
ALTER TABLE `management`
  ADD CONSTRAINT `management_ibfk_1` FOREIGN KEY (`m_qaOID`) REFERENCES `quoteads` (`qa_OID`),
  ADD CONSTRAINT `management_ibfk_2` FOREIGN KEY (`m_SID`) REFERENCES `staff` (`s_staffID`),
  ADD CONSTRAINT `management_ibfk_3` FOREIGN KEY (`m_AID`) REFERENCES `administrator` (`a_adminID`);

--
-- Constraints for table `ordercreation`
--
ALTER TABLE `ordercreation`
  ADD CONSTRAINT `ordercreation_ibfk_1` FOREIGN KEY (`OC_adminID`) REFERENCES `administrator` (`a_adminID`),
  ADD CONSTRAINT `ordercreation_ibfk_2` FOREIGN KEY (`OC_ID`) REFERENCES `quotecons` (`qc_OCID`);

--
-- Constraints for table `quoteads`
--
ALTER TABLE `quoteads`
  ADD CONSTRAINT `quoteads_ibfk_1` FOREIGN KEY (`qa_itemID`) REFERENCES `inventoryitem` (`I_ID`),
  ADD CONSTRAINT `quoteads_ibfk_2` FOREIGN KEY (`qa_cemail`) REFERENCES `custemail` (`c_email`),
  ADD CONSTRAINT `quoteads_ibfk_3` FOREIGN KEY (`qa_cphone`) REFERENCES `custphone` (`c_phone`),
  ADD CONSTRAINT `quoteads_ibfk_4` FOREIGN KEY (`qa_ccategory`) REFERENCES `c_category` (`c_id`);

--
-- Constraints for table `quotecons`
--
ALTER TABLE `quotecons`
  ADD CONSTRAINT `quotecons_ibfk_1` FOREIGN KEY (`qc_AID`) REFERENCES `administrator` (`a_adminID`),
  ADD CONSTRAINT `quotecons_ibfk_2` FOREIGN KEY (`qc_EIID`) REFERENCES `constructionengineeringitem` (`CEN_ID`),
  ADD CONSTRAINT `quotecons_ibfk_3` FOREIGN KEY (`qc_ELID`) REFERENCES `constructionelectricalitem` (`CEL_ID`);

--
-- Constraints for table `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `status_ibfk_1` FOREIGN KEY (`s_OAID`) REFERENCES `quoteads` (`qa_OID`),
  ADD CONSTRAINT `status_ibfk_2` FOREIGN KEY (`s_OCID`) REFERENCES `quotecons` (`qc_OCID`),
  ADD CONSTRAINT `status_ibfk_3` FOREIGN KEY (`s_IID`) REFERENCES `invoice` (`I_ID`);

--
-- Constraints for table `verifiedpay`
--
ALTER TABLE `verifiedpay`
  ADD CONSTRAINT `verifiedpay_ibfk_1` FOREIGN KEY (`vp_PID`) REFERENCES `payment` (`p_ID`),
  ADD CONSTRAINT `verifiedpay_ibfk_2` FOREIGN KEY (`vp_ID`) REFERENCES `quoteads` (`qa_OID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
