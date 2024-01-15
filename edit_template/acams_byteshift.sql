-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2024 at 09:51 PM
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
-- Table structure for table `consplace`
--

CREATE TABLE `consplace` (
  `cp_state` varchar(20) NOT NULL,
  `cp_city` varchar(20) NOT NULL,
  `cp_distance` double NOT NULL,
  `cp_percentage` float NOT NULL,
  `cp_category` int(2) NOT NULL,
  `cp_AID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consplace`
--

INSERT INTO `consplace` (`cp_state`, `cp_city`, `cp_distance`, `cp_percentage`, `cp_category`, `cp_AID`) VALUES
('Johor', 'Kluang', 15, 20, 1, '030808012117'),
('Johor', 'Kluang', 30, 20, 1, '030808012117'),
('Melaka', 'Ayer Keroh', 16, 40, 2, '030808012117'),
('Melaka', 'Bemban', 48, 60, 2, '030808012117');

-- --------------------------------------------------------

--
-- Table structure for table `constructionitem`
--

CREATE TABLE `constructionitem` (
  `CI_name` varchar(50) NOT NULL,
  `CI_type` varchar(50) NOT NULL,
  `CI_category` int(2) NOT NULL,
  `CI_unit` varchar(20) NOT NULL,
  `CI_price` double NOT NULL,
  `CI_AID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `constructionitem`
--

INSERT INTO `constructionitem` (`CI_name`, `CI_type`, `CI_category`, `CI_unit`, `CI_price`, `CI_AID`) VALUES
('besi', 'keluli', 2, 'm16', 100, '030808012117'),
('besi', 'tahan karat', 2, 't10', 40, '030808012117'),
('metal', 'stainless steel', 1, 'm16', 30, '030808012117'),
('plastic', 'pvc', 1, '16', 12.6, '030808012117');

-- --------------------------------------------------------

--
-- Table structure for table `cust_cat`
--

CREATE TABLE `cust_cat` (
  `cc_id` int(2) NOT NULL,
  `cc_desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cust_cat`
--

INSERT INTO `cust_cat` (`cc_id`, `cc_desc`) VALUES
(1, 'Walk in'),
(2, 'Online'),
(3, 'Government');

-- --------------------------------------------------------

--
-- Table structure for table `item_cat`
--

CREATE TABLE `item_cat` (
  `cat_id` int(2) NOT NULL,
  `cat_desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_cat`
--

INSERT INTO `item_cat` (`cat_id`, `cat_desc`) VALUES
(1, 'Engineering Item'),
(2, 'Electrical Item');

-- --------------------------------------------------------

--
-- Table structure for table `quotecons`
--

CREATE TABLE `quotecons` (
  `qc_OCID` varchar(20) NOT NULL,
  `qc_issuedate` date NOT NULL,
  `qc_expirydate` date NOT NULL,
  `qc_custname` varchar(20) NOT NULL,
  `qc_custemail` varchar(50) NOT NULL,
  `qc_custphone` varchar(20) NOT NULL,
  `qc_custaddress` text NOT NULL,
  `qc_custcategory` int(2) NOT NULL,
  `qc_name` varchar(20) NOT NULL,
  `qc_type` varchar(20) NOT NULL,
  `qc_quantity` int(5) NOT NULL,
  `qc_unitprice` double NOT NULL,
  `qc_total` double NOT NULL,
  `qc_qstatus` int(2) NOT NULL,
  `qc_state` varchar(20) NOT NULL,
  `qc_city` varchar(20) NOT NULL,
  `qc_distance` double NOT NULL,
  `qc_AID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quote_status`
--

CREATE TABLE `quote_status` (
  `qs_ID` int(2) NOT NULL,
  `qs_desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quote_status`
--

INSERT INTO `quote_status` (`qs_ID`, `qs_desc`) VALUES
(1, 'Not Processed'),
(2, 'Processed');

-- --------------------------------------------------------

--
-- Table structure for table `tb_customer`
--

CREATE TABLE `tb_customer` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `c_email` varchar(255) NOT NULL,
  `c_phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_customer`
--

INSERT INTO `tb_customer` (`c_id`, `c_name`, `c_email`, `c_phone`) VALUES
(1, 'Azhar Sulaiman', 'azhar@gmail.com', '011-1189 0876'),
(2, 'Ammar Zaied', 'ammar22@gmail.com', '011-1189 0833'),
(3, 'Abdul Manaf', 'abdulmanaf@gmail.com', '011-1189 0899'),
(100, 'luqman', 'lqmanh24@gmail.com', '01234');

-- --------------------------------------------------------

--
-- Table structure for table `tb_order`
--

CREATE TABLE `tb_order` (
  `o_id` int(11) NOT NULL,
  `o_cid` int(11) NOT NULL,
  `o_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `grand_total` decimal(10,2) NOT NULL,
  `o_status` int(11) NOT NULL,
  `o_total_price` decimal(10,2) NOT NULL,
  `o_delivery_status` varchar(50) NOT NULL,
  `o_payment_status` varchar(50) NOT NULL,
  `o_payment_proof` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_orderdetails`
--

CREATE TABLE `tb_orderdetails` (
  `od_id` int(11) NOT NULL,
  `od_orderid` int(11) DEFAULT NULL,
  `od_productid` int(11) DEFAULT NULL,
  `od_quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_orderproduct`
--

CREATE TABLE `tb_orderproduct` (
  `op_id` int(11) NOT NULL,
  `op_orderid` int(11) DEFAULT NULL,
  `op_productid` int(11) DEFAULT NULL,
  `op_quantity` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `op_total_price` decimal(10,2) DEFAULT NULL,
  `op_balance` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_payment`
--

CREATE TABLE `tb_payment` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `transaction_type` varchar(20) NOT NULL,
  `transaction_date` date NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `evidence_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_product`
--

CREATE TABLE `tb_product` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(20) NOT NULL,
  `p_quantity` int(5) NOT NULL,
  `p_price` decimal(10,2) NOT NULL,
  `p_markup` decimal(5,2) DEFAULT NULL,
  `p_minimum` int(5) NOT NULL,
  `p_price_after_markup` decimal(10,2) GENERATED ALWAYS AS (`p_price` + `p_price` * `p_markup`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_product`
--

INSERT INTO `tb_product` (`p_id`, `p_name`, `p_quantity`, `p_price`, `p_markup`, `p_minimum`) VALUES
(1, 'Batu Kapur', 150, 5.30, 0.30, 10),
(2, 'Aluminium', 130, 4.50, 0.20, 5),
(3, 'Thermos Bottle ', 200, 20.50, 0.30, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tb_type`
--

CREATE TABLE `tb_type` (
  `t_id` int(2) NOT NULL,
  `t_desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_type`
--

INSERT INTO `tb_type` (`t_id`, `t_desc`) VALUES
(1, 'staff'),
(2, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `u_id` varchar(20) NOT NULL,
  `u_name` varchar(50) NOT NULL,
  `u_phone` varchar(20) NOT NULL,
  `u_email` varchar(50) NOT NULL,
  `u_pwd` varchar(20) NOT NULL,
  `u_type` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`u_id`, `u_name`, `u_phone`, `u_email`, `u_pwd`, `u_type`) VALUES
('030808012117', 'luqman', '013-7342798', 'lqmanh24@gmail.com', '12345678', 2),
('0987654321', 'safwan', '01912345678', 'safwan@gmail.com', '12345678', 2),
('12345678', 'hakim', '0127432887', 'hakim@gmail.com', '12345678', 1),
('A22EF0201', 'ali', '0197887654', 'ali@gmail.com', '123', 2),
('akim730', 'Muhammad Daniel Hakim', '01111840392', 'denbest03@gmail.com', 'iel113355', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consplace`
--
ALTER TABLE `consplace`
  ADD PRIMARY KEY (`cp_state`,`cp_city`,`cp_distance`),
  ADD KEY `cp_category` (`cp_category`),
  ADD KEY `cp_AID` (`cp_AID`);

--
-- Indexes for table `constructionitem`
--
ALTER TABLE `constructionitem`
  ADD PRIMARY KEY (`CI_name`,`CI_type`),
  ADD KEY `CI_category` (`CI_category`),
  ADD KEY `CI_AID` (`CI_AID`);

--
-- Indexes for table `cust_cat`
--
ALTER TABLE `cust_cat`
  ADD PRIMARY KEY (`cc_id`);

--
-- Indexes for table `item_cat`
--
ALTER TABLE `item_cat`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `quotecons`
--
ALTER TABLE `quotecons`
  ADD PRIMARY KEY (`qc_OCID`,`qc_name`,`qc_type`),
  ADD KEY `qc_custcategory` (`qc_custcategory`),
  ADD KEY `qc_qstatus` (`qc_qstatus`),
  ADD KEY `qc_AID` (`qc_AID`),
  ADD KEY `qc_state` (`qc_state`,`qc_city`,`qc_distance`),
  ADD KEY `quotecons_ibfk_2` (`qc_name`);

--
-- Indexes for table `quote_status`
--
ALTER TABLE `quote_status`
  ADD PRIMARY KEY (`qs_ID`);

--
-- Indexes for table `tb_customer`
--
ALTER TABLE `tb_customer`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `tb_order`
--
ALTER TABLE `tb_order`
  ADD PRIMARY KEY (`o_id`),
  ADD KEY `o_cid` (`o_cid`,`o_status`),
  ADD KEY `o_status` (`o_status`);

--
-- Indexes for table `tb_orderdetails`
--
ALTER TABLE `tb_orderdetails`
  ADD PRIMARY KEY (`od_id`),
  ADD KEY `od_orderid` (`od_orderid`,`od_productid`),
  ADD KEY `od_productid` (`od_productid`);

--
-- Indexes for table `tb_orderproduct`
--
ALTER TABLE `tb_orderproduct`
  ADD PRIMARY KEY (`op_id`),
  ADD KEY `op_orderid` (`op_orderid`);

--
-- Indexes for table `tb_payment`
--
ALTER TABLE `tb_payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `tb_product`
--
ALTER TABLE `tb_product`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `I_name` (`p_name`);

--
-- Indexes for table `tb_type`
--
ALTER TABLE `tb_type`
  ADD PRIMARY KEY (`t_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`u_id`),
  ADD KEY `u_type` (`u_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_order`
--
ALTER TABLE `tb_order`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tb_orderdetails`
--
ALTER TABLE `tb_orderdetails`
  MODIFY `od_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_orderproduct`
--
ALTER TABLE `tb_orderproduct`
  MODIFY `op_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consplace`
--
ALTER TABLE `consplace`
  ADD CONSTRAINT `consplace_ibfk_1` FOREIGN KEY (`cp_category`) REFERENCES `item_cat` (`cat_id`),
  ADD CONSTRAINT `consplace_ibfk_2` FOREIGN KEY (`cp_AID`) REFERENCES `tb_user` (`u_id`);

--
-- Constraints for table `constructionitem`
--
ALTER TABLE `constructionitem`
  ADD CONSTRAINT `constructionitem_ibfk_1` FOREIGN KEY (`CI_AID`) REFERENCES `tb_user` (`u_id`),
  ADD CONSTRAINT `constructionitem_ibfk_2` FOREIGN KEY (`CI_category`) REFERENCES `item_cat` (`cat_id`);

--
-- Constraints for table `quotecons`
--
ALTER TABLE `quotecons`
  ADD CONSTRAINT `quotecons_ibfk_1` FOREIGN KEY (`qc_custcategory`) REFERENCES `cust_cat` (`cc_id`),
  ADD CONSTRAINT `quotecons_ibfk_2` FOREIGN KEY (`qc_name`) REFERENCES `constructionitem` (`CI_name`),
  ADD CONSTRAINT `quotecons_ibfk_3` FOREIGN KEY (`qc_qstatus`) REFERENCES `quote_status` (`qs_ID`),
  ADD CONSTRAINT `quotecons_ibfk_4` FOREIGN KEY (`qc_state`) REFERENCES `consplace` (`cp_state`);

--
-- Constraints for table `tb_order`
--
ALTER TABLE `tb_order`
  ADD CONSTRAINT `tb_order_ibfk_2` FOREIGN KEY (`o_cid`) REFERENCES `tb_customer` (`c_id`);

--
-- Constraints for table `tb_orderdetails`
--
ALTER TABLE `tb_orderdetails`
  ADD CONSTRAINT `tb_orderdetails_ibfk_1` FOREIGN KEY (`od_orderid`) REFERENCES `tb_order` (`o_id`),
  ADD CONSTRAINT `tb_orderdetails_ibfk_2` FOREIGN KEY (`od_productid`) REFERENCES `tb_product` (`p_id`);

--
-- Constraints for table `tb_orderproduct`
--
ALTER TABLE `tb_orderproduct`
  ADD CONSTRAINT `tb_orderproduct_ibfk_1` FOREIGN KEY (`op_orderid`) REFERENCES `tb_order` (`o_id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_payment`
--
ALTER TABLE `tb_payment`
  ADD CONSTRAINT `tb_payment_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `tb_order` (`o_id`);

--
-- Constraints for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`u_type`) REFERENCES `tb_type` (`t_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
