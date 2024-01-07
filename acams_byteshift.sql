-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2024 at 05:40 PM
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
-- Table structure for table `delivery_status`
--

CREATE TABLE `delivery_status` (
  `ds_ID` int(2) NOT NULL,
  `ds_desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_status`
--

INSERT INTO `delivery_status` (`ds_ID`, `ds_desc`) VALUES
(1, 'Not Delivered'),
(2, 'Delivered');

-- --------------------------------------------------------

--
-- Table structure for table `inventoryitem`
--

CREATE TABLE `inventoryitem` (
  `I_ID` int(11) NOT NULL,
  `I_name` varchar(20) NOT NULL,
  `I_type` varchar(20) NOT NULL,
  `I_quantity` int(5) NOT NULL,
  `I_unitprice` double NOT NULL,
  `I_markup` double NOT NULL,
  `I_minimum` int(5) NOT NULL,
  `I_AID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventoryitem`
--

INSERT INTO `inventoryitem` (`I_ID`, `I_name`, `I_type`, `I_quantity`, `I_unitprice`, `I_markup`, `I_minimum`, `I_AID`) VALUES
(1, 'besi', '32mm', 10, 25, 5, 0, ''),
(2, 'besi', '10m', 10, 12, 2, 0, ''),
(3, 'Kayu', '50cm', 34, 5, 2, 0, ''),
(4, 'kain', 'nylom', 10, 10, 5, 0, ''),
(6, 'Besi', '32mm', 100, 50, 6, 0, '');

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
-- Table structure for table `payment_status`
--

CREATE TABLE `payment_status` (
  `ps_ID` int(2) NOT NULL,
  `ps_desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_status`
--

INSERT INTO `payment_status` (`ps_ID`, `ps_desc`) VALUES
(1, 'No Payment'),
(2, 'Down Payment'),
(3, 'Full Payment');

-- --------------------------------------------------------

--
-- Table structure for table `payment_type`
--

CREATE TABLE `payment_type` (
  `pt_ID` int(2) NOT NULL,
  `pt_desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_type`
--

INSERT INTO `payment_type` (`pt_ID`, `pt_desc`) VALUES
(1, 'Online Transaction'),
(2, 'ATM'),
(3, 'Cash');

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

--
-- Dumping data for table `quotecons`
--

INSERT INTO `quotecons` (`qc_OCID`, `qc_issuedate`, `qc_expirydate`, `qc_custname`, `qc_custemail`, `qc_custphone`, `qc_custaddress`, `qc_custcategory`, `qc_name`, `qc_type`, `qc_quantity`, `qc_unitprice`, `qc_total`, `qc_qstatus`, `qc_state`, `qc_city`, `qc_distance`, `qc_AID`) VALUES
('1', '2024-01-06', '2024-02-06', 'KKM', 'kkm@moh.gov.my', '03-8883 3499', 'Aras 13, Blok E7, Kompleks E\r\nPusat Pentadbiran Kerajaan Persekutuan', 3, 'besi', '80cm', 10, 19, 190, 2, 'Johor', 'Muar', 10, '030808012117'),
('1', '2024-01-06', '2024-02-06', 'KKM', 'kkm@moh.gov.my', '03-8883 3499', 'Aras 13, Blok E7, Kompleks E\r\nPusat Pentadbiran Kerajaan Persekutuan', 3, 'metal', '18cm', 50, 100, 5000, 2, 'Johor', 'Muar', 10, '030808012117'),
('1', '2024-01-06', '2024-02-06', 'KKM', 'kkm@moh.gov.my', '03-8883 3499', 'Aras 13, Blok E7, Kompleks E\r\nPusat Pentadbiran Kerajaan Persekutuan', 3, 'plastic', '30cm', 20, 20, 40, 2, 'Johor', 'Muar', 10, '030808012117'),
('2', '2024-01-07', '2024-02-07', 'KPM', ' adukpm@moe.gov.my', '+603 8884 6456', 'Kementerian Pendidikan Malaysia,\r\nBlok E8, Kompleks E,\r\nPusat Pentadbiran Kerajaan Persekutuan,\r\n62604 W.P. Putrajaya, Malaysia.', 3, 'metal', '23cm', 250, 5.6, 1400, 2, 'Johor', 'Pasir Gudang', 50, '0987654321'),
('2', '2024-01-07', '2024-02-07', 'KPM', ' adukpm@moe.gov.my', '+603 8884 6456', 'Kementerian Pendidikan Malaysia,\r\nBlok E8, Kompleks E,\r\nPusat Pentadbiran Kerajaan Persekutuan,\r\n62604 W.P. Putrajaya, Malaysia.', 3, 'plastic', '23cm', 100, 8.3, 830, 2, 'Johor', 'Pasir Gudang', 50, '0987654321'),
('3', '2024-01-01', '2024-02-01', 'KPT', '80008000@mygcc.gov.my', '+603 8000 8000', 'Kementerian Pendidikan Tinggi\r\nNo. 2, Menara 2,\r\nJalan P5/6, Presint 5,\r\n62200 Putrajaya, Malaysia\r\n\r\n', 3, 'besi', '18cm', 50, 25.6, 1280, 2, 'Melaka', 'Jasin', 80, '12345678'),
('3', '2024-01-01', '2024-02-01', 'KPT', '80008000@mygcc.gov.my', '+603 8000 8000', 'Kementerian Pendidikan Tinggi\r\nNo. 2, Menara 2,\r\nJalan P5/6, Presint 5,\r\n62200 Putrajaya, Malaysia\r\n\r\n', 3, 'metal', '18cm', 100, 23.4, 2340, 2, 'Melaka', 'Jasin', 80, '12345678'),
('3', '2024-01-01', '2024-02-01', 'KPT', '80008000@mygcc.gov.my', '+603 8000 8000', 'Kementerian Pendidikan Tinggi\r\nNo. 2, Menara 2,\r\nJalan P5/6, Presint 5,\r\n62200 Putrajaya, Malaysia\r\n\r\n', 3, 'plastic', '18cm', 50, 16.9, 845, 2, 'Melaka', 'Jasin', 80, '12345678');

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
(2, 'Ammar Zaied', 'ammar22@gmail.com', '011-1189 0833');

-- --------------------------------------------------------

--
-- Table structure for table `tb_order`
--

CREATE TABLE `tb_order` (
  `o_id` int(11) NOT NULL,
  `o_cid` int(11) NOT NULL,
  `o_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `grand_total` decimal(10,2) NOT NULL,
  `o_status` int(11) NOT NULL,
  `o_total_price` decimal(10,2) NOT NULL,
  `o_delivery_status` varchar(50) NOT NULL,
  `o_payment_status` varchar(50) NOT NULL,
  `o_payment_proof` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_order`
--

INSERT INTO `tb_order` (`o_id`, `o_cid`, `o_date`, `grand_total`, `o_status`, `o_total_price`, `o_delivery_status`, `o_payment_status`, `o_payment_proof`) VALUES
(2, 1, '2024-01-07 15:59:46', 10.00, 2, 100.00, 'Complete', 'Paid', ''),
(3, 2, '2024-01-07 15:59:46', 10.00, 2, 100.00, 'Complete', 'Paid', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_orderdetails`
--

CREATE TABLE `tb_orderdetails` (
  `od_id` int(11) NOT NULL,
  `od_orderid` int(11) NOT NULL,
  `od_productid` int(11) NOT NULL,
  `od_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_orderproduct`
--

CREATE TABLE `tb_orderproduct` (
  `op_id` int(11) NOT NULL,
  `op_orderid` int(11) NOT NULL,
  `op_productid` int(11) NOT NULL,
  `op_quantity` int(11) NOT NULL,
  `op_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_orderstatus`
--

CREATE TABLE `tb_orderstatus` (
  `os_id` int(11) NOT NULL,
  `os_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_orderstatus`
--

INSERT INTO `tb_orderstatus` (`os_id`, `os_name`) VALUES
(1, 'Complete'),
(2, 'Incomplete');

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
('12345678', 'hakim', '0127432887', 'hakim@gmail.com', '12345678', 1);

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
-- Indexes for table `delivery_status`
--
ALTER TABLE `delivery_status`
  ADD PRIMARY KEY (`ds_ID`);

--
-- Indexes for table `inventoryitem`
--
ALTER TABLE `inventoryitem`
  ADD PRIMARY KEY (`I_ID`),
  ADD KEY `I_AID` (`I_AID`),
  ADD KEY `I_name` (`I_name`);

--
-- Indexes for table `item_cat`
--
ALTER TABLE `item_cat`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `payment_status`
--
ALTER TABLE `payment_status`
  ADD PRIMARY KEY (`ps_ID`);

--
-- Indexes for table `payment_type`
--
ALTER TABLE `payment_type`
  ADD PRIMARY KEY (`pt_ID`);

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
  ADD KEY `op_orderid` (`op_orderid`),
  ADD KEY `op_productid` (`op_productid`);

--
-- Indexes for table `tb_orderstatus`
--
ALTER TABLE `tb_orderstatus`
  ADD PRIMARY KEY (`os_id`);

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
-- AUTO_INCREMENT for table `tb_customer`
--
ALTER TABLE `tb_customer`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_order`
--
ALTER TABLE `tb_order`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_orderdetails`
--
ALTER TABLE `tb_orderdetails`
  MODIFY `od_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_orderproduct`
--
ALTER TABLE `tb_orderproduct`
  MODIFY `op_id` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `quotecons_ibfk_4` FOREIGN KEY (`qc_state`) REFERENCES `consplace` (`cp_state`),
  ADD CONSTRAINT `quotecons_ibfk_5` FOREIGN KEY (`qc_AID`) REFERENCES `tb_user` (`u_id`);

--
-- Constraints for table `tb_order`
--
ALTER TABLE `tb_order`
  ADD CONSTRAINT `tb_order_ibfk_2` FOREIGN KEY (`o_cid`) REFERENCES `tb_customer` (`c_id`),
  ADD CONSTRAINT `tb_order_ibfk_3` FOREIGN KEY (`o_status`) REFERENCES `tb_orderstatus` (`os_id`);

--
-- Constraints for table `tb_orderdetails`
--
ALTER TABLE `tb_orderdetails`
  ADD CONSTRAINT `tb_orderdetails_ibfk_1` FOREIGN KEY (`od_orderid`) REFERENCES `tb_order` (`o_id`),
  ADD CONSTRAINT `tb_orderdetails_ibfk_2` FOREIGN KEY (`od_productid`) REFERENCES `inventoryitem` (`I_ID`);

--
-- Constraints for table `tb_orderproduct`
--
ALTER TABLE `tb_orderproduct`
  ADD CONSTRAINT `tb_orderproduct_ibfk_1` FOREIGN KEY (`op_orderid`) REFERENCES `tb_order` (`o_id`),
  ADD CONSTRAINT `tb_orderproduct_ibfk_2` FOREIGN KEY (`op_productid`) REFERENCES `inventoryitem` (`I_ID`);

--
-- Constraints for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`u_type`) REFERENCES `tb_type` (`t_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
