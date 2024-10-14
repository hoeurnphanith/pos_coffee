-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 13, 2023 at 05:21 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_coffee`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `Sd_DeleteSale`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sd_DeleteSale` (IN `id` INT)  BEGIN
	DELETE FROM tbl_sale WHERE tbl_sale.sale_id = id;
    DELETE FROM tbl_sale_detail WHERE tbl_sale_detail.sale_id = id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

DROP TABLE IF EXISTS `tbl_category`;
CREATE TABLE IF NOT EXISTS `tbl_category` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `des` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`cate_id`, `cate_name`, `des`, `status`) VALUES
(1, 'Coffee', '<p>Coffee</p>\r\n', 'Enable'),
(2, 'Tea', '<p>Tea</p>\r\n', 'Enable');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

DROP TABLE IF EXISTS `tbl_customer`;
CREATE TABLE IF NOT EXISTS `tbl_customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `des` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`customer_id`, `customer_name`, `gender`, `phone`, `des`) VALUES
(1, 'ទូទៅ', 'Female', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

DROP TABLE IF EXISTS `tbl_product`;
CREATE TABLE IF NOT EXISTS `tbl_product` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) NOT NULL,
  `pro_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `purchase_price` float NOT NULL,
  `sale_price` float NOT NULL,
  `des` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`pro_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`pro_id`, `cate_id`, `pro_name`, `qty`, `purchase_price`, `sale_price`, `des`, `photo`, `date`, `status`) VALUES
(1, 1, 'Mocha', 20, 1, 1.6, 'descritption', '64888bcfa2df0.png', '2023/06/13', 'Enable'),
(2, 1, 'Latte', 10, 1, 1.6, 'des Latte', '64888c5cc8f57.png', '2023/06/13', 'Enable'),
(3, 1, 'Chocolate', 26, 1, 1.25, 'des', '64888ce877fa5.jpg', '2023/06/13', 'Enable'),
(4, 1, 'Americano', 17, 2, 3, 'des', '64888d79b6cff.jpg', '2023/06/13', 'Enable'),
(5, 1, 'Vanila', 2, 2, 3, 'des', '64888de36eeb8.jpg', '2023/06/13', 'Enable'),
(6, 2, 'Backbery', 0, 2, 3, 'des', '64888f391fa67.jpg', '2023/06/13', 'Enable'),
(7, 2, 'LemonTea', 20, 1, 2, 'Honey Lamon Tea', '64888fcd6c46b.jpg', '2023/06/13', 'Enable'),
(8, 1, 'Flat White', 18, 1, 2, 'coffee Flat White', '6488903ba4f5a.png', '2023/06/13', 'Enable'),
(9, 1, 'Iced Coffee', 20, 1, 1.5, 'Iced Coffee', '6488907629a3b.png', '2023/06/13', 'Enable'),
(10, 1, 'corner', 29, 2, 2.5, 'corner', '6488911db79ab.jpg', '2023/06/13', 'Enable'),
(11, 2, 'MatchaGeenTea', 20, 1, 2, 'Matcha Geen Tea', '648891b763044.jpg', '2023/06/13', 'Enable'),
(12, 1, 'Cappuccino', 19, 2, 2.3, 'Cappuccino', '648891ff85308.jpg', '2023/06/13', 'Enable');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sale`
--

DROP TABLE IF EXISTS `tbl_sale`;
CREATE TABLE IF NOT EXISTS `tbl_sale` (
  `sale_id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sale_date` date NOT NULL,
  `sub_total` double NOT NULL,
  `discount` double NOT NULL,
  `total` double NOT NULL,
  `paid` double NOT NULL,
  `due` double NOT NULL,
  `payment_type` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_status` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`sale_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_sale`
--

INSERT INTO `tbl_sale` (`sale_id`, `userid`, `customer_id`, `sale_date`, `sub_total`, `discount`, `total`, `paid`, `due`, `payment_type`, `s_status`) VALUES
(1, 2, 1, '2023-06-13', 6, 0, 6, 6, 0, 'Cash', 'Enable'),
(4, 15, 1, '2023-06-13', 5.5, 0, 5.5, 6, -0.5, 'Card', 'Disable'),
(5, 2, 1, '2023-06-13', 27, 0, 27, 27, 0, 'Card', 'Enable'),
(6, 2, 1, '2023-06-13', 24, 0, 24, 24, 0, 'Cash', 'Enable'),
(7, 15, 1, '2023-06-13', 2.3, 0, 2.3, 2.3, 0, 'Cash', 'Enable'),
(8, 2, 1, '2023-06-14', 9.5, 0, 9.5, 9.5, 0, 'Cash', 'Enable'),
(9, 15, 1, '2023-06-14', 1.25, 0, 1.25, 1.25, 0, 'Cash', 'Enable'),
(10, 15, 1, '2023-06-14', 1.25, 0, 1.25, 2, -0.75, 'Card', 'Enable');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sale_detail`
--

DROP TABLE IF EXISTS `tbl_sale_detail`;
CREATE TABLE IF NOT EXISTS `tbl_sale_detail` (
  `sale_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`sale_id`,`pro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_sale_detail`
--

INSERT INTO `tbl_sale_detail` (`sale_id`, `pro_id`, `qty`, `price`) VALUES
(1, 4, 1, 3),
(1, 6, 1, 3),
(4, 4, 1, 3),
(4, 10, 1, 2.5),
(5, 6, 9, 3),
(6, 5, 8, 3),
(7, 12, 1, 2.3),
(8, 3, 2, 1.25),
(8, 4, 1, 3),
(8, 8, 2, 2),
(9, 3, 1, 1.25),
(10, 3, 1, 1.25);

--
-- Triggers `tbl_sale_detail`
--
DROP TRIGGER IF EXISTS `UpdateAndInsertStock`;
DELIMITER $$
CREATE TRIGGER `UpdateAndInsertStock` BEFORE UPDATE ON `tbl_sale_detail` FOR EACH ROW BEGIN
DECLARE OldProId varchar(15);
DECLARE OldQty integer;
DECLARE NewProId varchar(15);
DECLARE NewQty integer;

SET OldProId := old.pro_id;
SET OldQty := old.qty;
SET NewProId :=new.pro_id;
SET NewQty := new.qty;

UPDATE tbl_product SET
qty=qty+OldQty WHERE pro_id= OldProId;
UPDATE tbl_product SET
qty=qty-NewQty WHERE pro_id=NewProId;
end
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `UpdateSaleDetailDelete`;
DELIMITER $$
CREATE TRIGGER `UpdateSaleDetailDelete` AFTER DELETE ON `tbl_sale_detail` FOR EACH ROW UPDATE tbl_product SET
qty=qty+OLD.qty
WHERE pro_id=OLD.pro_id
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `UpdateStockSaleDetail`;
DELIMITER $$
CREATE TRIGGER `UpdateStockSaleDetail` AFTER INSERT ON `tbl_sale_detail` FOR EACH ROW update tbl_product
set qty = qty - NEW.qty
where pro_id = NEW.pro_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `useremail` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`userid`, `username`, `useremail`, `password`, `role`, `status`) VALUES
(2, 'chenda', 'rongc5831@gmail.com', '202cb962ac59075b964b07152d234b70', 'Admin', 'Enable'),
(15, 'nary', 'nary@gmail.com', '202cb962ac59075b964b07152d234b70', 'User', 'Enable'),
(10, 'mey', 'mey@gmail.com', '202cb962ac59075b964b07152d234b70', 'User', 'Enable'),
(32, 'nuch', 'nuch@gmail.com', '202cb962ac59075b964b07152d234b70', 'User', 'Disable');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_product_list`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `view_product_list`;
CREATE TABLE IF NOT EXISTS `view_product_list` (
`pro_id` int(11)
,`cate_id` int(11)
,`cate_name` varchar(100)
,`pro_name` varchar(200)
,`qty` int(11)
,`purchase_price` float
,`sale_price` float
,`photo` varchar(300)
,`des` varchar(200)
,`date` varchar(200)
,`status` varchar(200)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_sales`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `view_sales`;
CREATE TABLE IF NOT EXISTS `view_sales` (
`sale_id` int(11)
,`userid` int(11)
,`username` varchar(200)
,`useremail` varchar(200)
,`role` varchar(200)
,`customer_id` int(11)
,`customer_name` varchar(40)
,`sale_date` date
,`sub_total` double
,`discount` double
,`total` double
,`paid` double
,`due` double
,`payment_type` tinytext
,`s_status` varchar(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_sale_byuser`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `view_sale_byuser`;
CREATE TABLE IF NOT EXISTS `view_sale_byuser` (
`sale_id` int(11)
,`customer_name` varchar(40)
,`sale_date` date
,`payment_type` tinytext
,`s_status` varchar(11)
,`pro_id` int(11)
,`pro_name` varchar(200)
,`qty` int(11)
,`price` float
,`userid` int(11)
,`username` varchar(200)
,`useremail` varchar(200)
,`role` varchar(200)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_sale_detail`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `view_sale_detail`;
CREATE TABLE IF NOT EXISTS `view_sale_detail` (
`sale_id` int(11)
,`username` varchar(200)
,`customer_id` int(11)
,`customer_name` varchar(40)
,`sale_date` date
,`total` double
,`paid` double
,`due` double
,`payment_type` tinytext
,`s_status` varchar(11)
,`pro_id` int(11)
,`pro_name` varchar(200)
,`qty` int(11)
,`purchase_price` float
,`q` int(11)
,`price` float
);

-- --------------------------------------------------------

--
-- Structure for view `view_product_list`
--
DROP TABLE IF EXISTS `view_product_list`;

DROP VIEW IF EXISTS `view_product_list`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_product_list`  AS SELECT `p`.`pro_id` AS `pro_id`, `c`.`cate_id` AS `cate_id`, `c`.`cate_name` AS `cate_name`, `p`.`pro_name` AS `pro_name`, `p`.`qty` AS `qty`, `p`.`purchase_price` AS `purchase_price`, `p`.`sale_price` AS `sale_price`, `p`.`photo` AS `photo`, `p`.`des` AS `des`, `p`.`date` AS `date`, `p`.`status` AS `status` FROM (`tbl_category` `c` join `tbl_product` `p` on((`c`.`cate_id` = `p`.`cate_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_sales`
--
DROP TABLE IF EXISTS `view_sales`;

DROP VIEW IF EXISTS `view_sales`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_sales`  AS SELECT `s`.`sale_id` AS `sale_id`, `u`.`userid` AS `userid`, `u`.`username` AS `username`, `u`.`useremail` AS `useremail`, `u`.`role` AS `role`, `cu`.`customer_id` AS `customer_id`, `cu`.`customer_name` AS `customer_name`, `s`.`sale_date` AS `sale_date`, `s`.`sub_total` AS `sub_total`, `s`.`discount` AS `discount`, `s`.`total` AS `total`, `s`.`paid` AS `paid`, `s`.`due` AS `due`, `s`.`payment_type` AS `payment_type`, `s`.`s_status` AS `s_status` FROM ((`tbl_sale` `s` join `tbl_customer` `cu` on((`s`.`customer_id` = `cu`.`customer_id`))) join `tbl_user` `u` on((`u`.`userid` = `s`.`userid`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_sale_byuser`
--
DROP TABLE IF EXISTS `view_sale_byuser`;

DROP VIEW IF EXISTS `view_sale_byuser`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_sale_byuser`  AS SELECT `s`.`sale_id` AS `sale_id`, `c`.`customer_name` AS `customer_name`, `s`.`sale_date` AS `sale_date`, `s`.`payment_type` AS `payment_type`, `s`.`s_status` AS `s_status`, `p`.`pro_id` AS `pro_id`, `p`.`pro_name` AS `pro_name`, `sd`.`qty` AS `qty`, `sd`.`price` AS `price`, `u`.`userid` AS `userid`, `u`.`username` AS `username`, `u`.`useremail` AS `useremail`, `u`.`role` AS `role` FROM ((((`tbl_sale` `s` join `tbl_customer` `c` on((`c`.`customer_id` = `s`.`customer_id`))) join `tbl_user` `u` on((`u`.`userid` = `s`.`userid`))) join `tbl_sale_detail` `sd` on((`s`.`sale_id` = `sd`.`sale_id`))) join `tbl_product` `p` on((`p`.`pro_id` = `sd`.`pro_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_sale_detail`
--
DROP TABLE IF EXISTS `view_sale_detail`;

DROP VIEW IF EXISTS `view_sale_detail`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_sale_detail`  AS SELECT `s`.`sale_id` AS `sale_id`, `u`.`username` AS `username`, `cu`.`customer_id` AS `customer_id`, `cu`.`customer_name` AS `customer_name`, `s`.`sale_date` AS `sale_date`, `s`.`total` AS `total`, `s`.`paid` AS `paid`, `s`.`due` AS `due`, `s`.`payment_type` AS `payment_type`, `s`.`s_status` AS `s_status`, `p`.`pro_id` AS `pro_id`, `p`.`pro_name` AS `pro_name`, `p`.`qty` AS `qty`, `p`.`purchase_price` AS `purchase_price`, `sd`.`qty` AS `q`, `sd`.`price` AS `price` FROM ((((`tbl_sale` `s` join `tbl_user` `u` on((`u`.`userid` = `s`.`userid`))) join `tbl_sale_detail` `sd` on((`s`.`sale_id` = `sd`.`sale_id`))) join `tbl_product` `p` on((`p`.`pro_id` = `sd`.`pro_id`))) join `tbl_customer` `cu` on((`cu`.`customer_id` = `s`.`customer_id`))) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
