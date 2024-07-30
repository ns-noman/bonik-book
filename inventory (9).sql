-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2022 at 07:24 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_ledger`
--

CREATE TABLE `bank_ledger` (
  `id` int(11) NOT NULL,
  `bank_transaction_id` varchar(50) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `bank_id` varchar(50) NOT NULL,
  `bank_transaction_date` date NOT NULL,
  `bank_transaction_type` varchar(250) NOT NULL,
  `withdraw_deposit_id` varchar(250) NOT NULL,
  `bank_transaction_amount` varchar(250) NOT NULL,
  `bank_transaction_description` varchar(250) NOT NULL,
  `bank_transaction_entry_by` varchar(100) NOT NULL,
  `bank_transaction_entry_date` date NOT NULL,
  `bank_transaction_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `bank_transaction_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `bank_transaction_updated_by` varchar(50) NOT NULL,
  `bank_transaction_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bank_ledger`
--

INSERT INTO `bank_ledger` (`id`, `bank_transaction_id`, `client_id`, `bank_id`, `bank_transaction_date`, `bank_transaction_type`, `withdraw_deposit_id`, `bank_transaction_amount`, `bank_transaction_description`, `bank_transaction_entry_by`, `bank_transaction_entry_date`, `bank_transaction_created_at`, `bank_transaction_updated_at`, `bank_transaction_updated_by`, `bank_transaction_status`) VALUES
(1, 'BTI-61b9c37e7a4f0', 'CLT-6177cd6a673c3', 'BNK-61b99903b30d6', '2021-12-15', 'Debit(+)', '5252', '1000', 'test', 'CID-6177cd6a673c3', '2021-12-15', '2021-12-14 22:29:18', '2021-12-15 10:29:18', '', 1),
(2, 'BTI-61b9c3c0b2564', 'CLT-6177cd6a673c3', 'BNK-61b99903b30d6', '2021-12-15', 'Credit(-)', '456', '100', 'w', 'CID-6177cd6a673c3', '2021-12-15', '2021-12-14 22:30:24', '2021-12-15 10:30:24', '', 1),
(3, 'BTI-61f526a195400', 'CLT-6177cd6a673c3', 'BNK-61b99903b30d6', '2022-01-29', 'Debit(+)', '11', '1000', '1', 'CID-6177cd6a673c3', '2022-01-29', '2022-01-28 23:36:01', '2022-01-29 11:36:01', '', 1),
(4, 'BTI-61f526b5cc532', 'CLT-6177cd6a673c3', 'BNK-61b99903b30d6', '2022-01-29', 'Credit(-)', '11', '50', '1', 'CID-6177cd6a673c3', '2022-01-29', '2022-01-28 23:36:21', '2022-01-29 11:36:21', '', 1),
(5, 'BTI-61fe28b0d060b', 'CLT-6177cd6a673c3', 'BNK-61b99903b30d6', '2022-02-05', 'Debit(+)', '5252', '11111', '', 'CID-6177cd6a673c3', '2022-02-05', '2022-02-04 19:35:12', '2022-02-05 07:35:12', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `client_id` varchar(30) NOT NULL,
  `client_code` varchar(50) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `business_name` varchar(120) NOT NULL,
  `client_email` varchar(80) NOT NULL,
  `client_mobile` varchar(15) NOT NULL,
  `client_address` tinytext NOT NULL,
  `package_id` varchar(40) NOT NULL,
  `registration_date` date NOT NULL,
  `header_image` varchar(200) NOT NULL,
  `client_entry_by` varchar(100) NOT NULL,
  `client_entry_date` date NOT NULL,
  `client_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `client_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `client_updated_by` varchar(50) NOT NULL,
  `client_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `client_id`, `client_code`, `client_name`, `business_name`, `client_email`, `client_mobile`, `client_address`, `package_id`, `registration_date`, `header_image`, `client_entry_by`, `client_entry_date`, `client_created_at`, `client_updated_at`, `client_updated_by`, `client_status`) VALUES
(2, 'CID-6177cd6a673c3', 'CLT-6177cd6a673c3', 'A & A Consulting Limited', 'A & A Consulting Limited', 'demo@sysdevltd.com', '+8802 488 12159', 'House: 01 (4th Floor), Road: 20, Block: J, Baridhara, Dhaka- 1212.', 'VPI-6177c9581dcd6', '0000-00-00', 'uploads/client_logo/A_A_Logo.jpg', '001', '2021-10-26', '2021-10-25 21:42:02', '2022-02-22 20:03:24', '001', 1),
(3, 'CID-61b621d225317', 'CLT-61b621d225ab8', 'Demo11', 'Demo11 Ltd.', 'demo11@sysdevltd.com', '1111', '111', 'VPI-61b613a4a9fe1', '0000-00-00', 'uploads/client_logo/bike-with-motor-ios-7-interface-symbol.png', '001', '2021-12-12', '2021-12-12 04:22:42', '2021-12-13 01:53:32', '001', 1),
(4, 'CID-6215eaac6d6f2', 'CLT-6215eaac6dac2', 'Demo2', 'Demo2 Ltd.', 'demo2@sysdevltd.com', '12', '', 'VPI-6177c9581dcd6', '0000-00-00', 'uploads/client_logo/bike-with-motor-ios-7-interface-symbol1.png', '001', '2022-02-23', '2022-02-22 20:05:00', '2022-02-23 08:05:00', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_payment`
--

CREATE TABLE `customer_payment` (
  `id` int(11) NOT NULL,
  `customer_payment_id` varchar(50) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `customer_id` varchar(30) NOT NULL,
  `customer_payment_date` date NOT NULL,
  `customer_payment_amount` varchar(50) NOT NULL,
  `customer_payment_entry_by` varchar(100) NOT NULL,
  `customer_payment_entry_date` date NOT NULL,
  `customer_payment_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_payment_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_payment_updated_by` varchar(50) NOT NULL,
  `customer_payment_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_payment`
--

INSERT INTO `customer_payment` (`id`, `customer_payment_id`, `client_id`, `customer_id`, `customer_payment_date`, `customer_payment_amount`, `customer_payment_entry_by`, `customer_payment_entry_date`, `customer_payment_created_at`, `customer_payment_updated_at`, `customer_payment_updated_by`, `customer_payment_status`) VALUES
(1, 'SPI-620ca8b0cfe6a', 'CLT-6177cd6a673c3', 'CUS-618626aa9e4f5', '2022-02-16', '100.00', 'CID-6177cd6a673c3', '2022-02-16', '2022-02-15 19:33:04', '2022-02-16 07:33:04', '', 1),
(2, 'SPI-620ca8e1b9f76', 'CLT-6177cd6a673c3', 'CUS-618626aa9e4f5', '2022-02-16', '0', 'CID-6177cd6a673c3', '2022-02-16', '2022-02-15 19:33:53', '2022-02-16 07:33:53', '', 1),
(3, 'SPI-620ca927e7812', 'CLT-6177cd6a673c3', 'CUS-61ac68f4240a9', '2022-02-16', '10.00', 'CID-6177cd6a673c3', '2022-02-16', '2022-02-15 19:35:03', '2022-02-16 07:35:03', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `expense_ledger`
--

CREATE TABLE `expense_ledger` (
  `id` int(11) NOT NULL,
  `expense_transaction_id` varchar(50) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `expense_head_id` varchar(50) NOT NULL,
  `expense_transaction_date` date NOT NULL,
  `expense_transaction_amount` varchar(250) NOT NULL,
  `expense_transaction_description` varchar(250) NOT NULL,
  `expense_transaction_entry_by` varchar(100) NOT NULL,
  `expense_transaction_entry_date` date NOT NULL,
  `expense_transaction_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expense_transaction_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expense_transaction_updated_by` varchar(50) NOT NULL,
  `expense_transaction_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `expense_ledger`
--

INSERT INTO `expense_ledger` (`id`, `expense_transaction_id`, `client_id`, `expense_head_id`, `expense_transaction_date`, `expense_transaction_amount`, `expense_transaction_description`, `expense_transaction_entry_by`, `expense_transaction_entry_date`, `expense_transaction_created_at`, `expense_transaction_updated_at`, `expense_transaction_updated_by`, `expense_transaction_status`) VALUES
(1, 'ETI-61c324a477359', 'CLT-6177cd6a673c3', 'BAR-61c2eba23473b', '2021-12-22', '0', '', 'CID-6177cd6a673c3', '2021-12-22', '2021-12-22 01:14:12', '2021-12-22 13:14:12', '', 1),
(2, 'ETI-61c324ae02dc6', 'CLT-6177cd6a673c3', 'BAR-61c2eba83ccbf', '2021-12-22', '1000', '1101', 'CID-6177cd6a673c3', '2021-12-22', '2021-12-22 01:14:22', '2021-12-22 13:14:22', '', 1),
(3, 'ETI-61c324d010736', 'CLT-6177cd6a673c3', 'BAR-61c2eba23473b', '2021-12-22', '1111', '11', 'CID-6177cd6a673c3', '2021-12-22', '2021-12-22 01:14:56', '2021-12-22 13:14:56', '', 1),
(4, 'ETI-61fa7d1573650', 'CLT-6177cd6a673c3', 'BAR-61c2eba23473b', '2022-02-02', '11', '11', 'CID-6177cd6a673c3', '2022-02-02', '2022-02-02 00:46:13', '2022-02-02 12:46:13', '', 1),
(5, 'ETI-620c8b3a5f9b1', 'CLT-6177cd6a673c3', 'BAR-61c2eba23473b', '2022-02-16', '111', '1', 'CID-6177cd6a673c3', '2022-02-16', '2022-02-16 05:27:22', '2022-02-16 05:27:22', '', 1),
(6, 'ETI-62161aa4754d4', 'CLT-6177cd6a673c3', 'BAR-61c2eba83ccbf', '2022-02-23', '111', 'salma', 'CID-6177cd6a673c3', '2022-02-23', '2022-02-22 23:29:40', '2022-02-23 11:29:40', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_stock`
--

CREATE TABLE `inventory_stock` (
  `id` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `product_stock_id` varchar(50) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `product_stock` varchar(50) NOT NULL,
  `unit_price` varchar(100) NOT NULL,
  `stock_entry_by` varchar(50) NOT NULL,
  `stock_entry_date` date NOT NULL,
  `stock_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `stock_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `stock_updated_by` varchar(50) NOT NULL,
  `stock_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inventory_stock`
--

INSERT INTO `inventory_stock` (`id`, `client_id`, `product_stock_id`, `product_id`, `product_stock`, `unit_price`, `stock_entry_by`, `stock_entry_date`, `stock_created_at`, `stock_updated_at`, `stock_updated_by`, `stock_status`) VALUES
(1, 'CLT-6177cd6a673c3', 'stk-61a33db3280de', 'pro-61a33db303197', '59', '', 'CID-6177cd6a673c3', '2021-11-28', '2021-11-27 20:28:35', '2022-02-23 01:08:19', 'CID-6177cd6a673c3', 1),
(2, 'CLT-6177cd6a673c3', 'stk-61a33e7d81761', 'pro-61a33e7d7102a', '0', '', 'CID-6177cd6a673c3', '2021-11-28', '2021-11-27 20:31:57', '2022-01-30 23:03:54', 'CID-6177cd6a673c3', 1),
(3, 'CLT-6177cd6a673c3', 'stk-61a33fe92d4ca', 'pro-61a33fe91e848', '8', '', 'CID-6177cd6a673c3', '2021-11-28', '2021-11-27 20:38:01', '2022-02-16 05:22:07', 'CID-6177cd6a673c3', 1),
(4, 'CLT-6177cd6a673c3', 'stk-61a34d8716694', 'pro-61a34d87040d9', '18', '', 'CID-6177cd6a673c3', '2021-11-28', '2021-11-27 21:36:07', '2022-02-11 23:26:20', 'CID-6177cd6a673c3', 1),
(5, 'CLT-6215eaac6dac2', 'stk-6215faba36d61', 'pro-6215faba2aad4', '0', '', 'CID-6215eaac6d6f2', '2022-02-23', '2022-02-22 21:13:30', '2022-02-23 09:13:30', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_stock_history`
--

CREATE TABLE `inventory_stock_history` (
  `id` int(11) NOT NULL,
  `stk_client_id` varchar(50) NOT NULL,
  `stock_history_id` varchar(50) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `stock_qty` varchar(50) NOT NULL,
  `stock_unit_price` varchar(100) NOT NULL,
  `stock_history_date` date NOT NULL,
  `stock_history_entry_date` date NOT NULL,
  `stock_history_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `stock_history_updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `stock_history_updated_by` varchar(50) NOT NULL,
  `stock_history_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inventory_stock_history`
--

INSERT INTO `inventory_stock_history` (`id`, `stk_client_id`, `stock_history_id`, `product_id`, `stock_qty`, `stock_unit_price`, `stock_history_date`, `stock_history_entry_date`, `stock_history_created_at`, `stock_history_updated_at`, `stock_history_updated_by`, `stock_history_status`) VALUES
(1, 'CLT-6177cd6a673c3', 'SHI-61adee3e30a32', 'pro-61a33db303197', '43', '300', '2021-12-06', '2021-12-06', '2021-12-05 23:04:30', '0000-00-00 00:00:00', '', 1),
(2, 'CLT-6177cd6a673c3', 'SHI-61adee3e39ef8', 'pro-61a33e7d7102a', '9', '120', '2021-12-06', '2021-12-06', '2021-12-05 23:04:30', '0000-00-00 00:00:00', '', 1),
(3, 'CLT-6177cd6a673c3', 'SHI-61adee3e4df67', 'pro-61a33fe91e848', '9', '13000', '2021-12-06', '2021-12-06', '2021-12-05 23:04:30', '0000-00-00 00:00:00', '', 1),
(4, 'CLT-6177cd6a673c3', 'SHI-61adee3e6422c', 'pro-61a34d87040d9', '19', '1000', '2021-12-06', '2021-12-06', '2021-12-05 23:04:30', '0000-00-00 00:00:00', '', 1),
(5, 'CLT-6177cd6a673c3', 'SHI-61adee4ba4453', 'pro-61a33db303197', '50', '300', '2021-12-06', '2021-12-06', '2021-12-05 23:04:43', '0000-00-00 00:00:00', '', 1),
(6, 'CLT-6177cd6a673c3', 'SHI-61adee4bb0e81', 'pro-61a33e7d7102a', '10', '120', '2021-12-06', '2021-12-06', '2021-12-05 23:04:43', '0000-00-00 00:00:00', '', 1),
(7, 'CLT-6177cd6a673c3', 'SHI-61adee4bb8893', 'pro-61a33fe91e848', '10', '13000', '2021-12-06', '2021-12-06', '2021-12-05 23:04:43', '0000-00-00 00:00:00', '', 1),
(8, 'CLT-6177cd6a673c3', 'SHI-61adee4bc0a46', 'pro-61a34d87040d9', '20', '1000', '2021-12-06', '2021-12-06', '2021-12-05 23:04:43', '0000-00-00 00:00:00', '', 1),
(9, 'CLT-6177cd6a673c3', 'SHI-61adee5435a4e', 'pro-61a33db303197', '50', '300', '2021-12-06', '2021-12-06', '2021-12-05 23:04:52', '0000-00-00 00:00:00', '', 1),
(10, 'CLT-6177cd6a673c3', 'SHI-61adee5447868', 'pro-61a33e7d7102a', '10', '120', '2021-12-06', '2021-12-06', '2021-12-05 23:04:52', '0000-00-00 00:00:00', '', 1),
(11, 'CLT-6177cd6a673c3', 'SHI-61adee545c079', 'pro-61a33fe91e848', '', '13000', '2021-12-06', '2021-12-06', '2021-12-05 23:04:52', '0000-00-00 00:00:00', '', 1),
(12, 'CLT-6177cd6a673c3', 'SHI-61adee5463a8b', 'pro-61a34d87040d9', '20', '1000', '2021-12-06', '2021-12-06', '2021-12-05 23:04:52', '0000-00-00 00:00:00', '', 1),
(13, 'CLT-6177cd6a673c3', 'SHI-61adee5eed39f', 'pro-61a33db303197', '50', '300', '2021-12-06', '2021-12-06', '2021-12-05 23:05:02', '0000-00-00 00:00:00', '', 1),
(14, 'CLT-6177cd6a673c3', 'SHI-61adee5f03197', 'pro-61a33e7d7102a', '10', '120', '2021-12-06', '2021-12-06', '2021-12-05 23:05:03', '0000-00-00 00:00:00', '', 1),
(15, 'CLT-6177cd6a673c3', 'SHI-61adee5f0d1ce', 'pro-61a33fe91e848', '10', '13000', '2021-12-06', '2021-12-06', '2021-12-05 23:05:03', '0000-00-00 00:00:00', '', 1),
(16, 'CLT-6177cd6a673c3', 'SHI-61adee5f1945b', 'pro-61a34d87040d9', '20', '1000', '2021-12-06', '2021-12-06', '2021-12-05 23:05:03', '0000-00-00 00:00:00', '', 1),
(17, 'CLT-6177cd6a673c3', 'SHI-61adee62d9ea2', 'pro-61a33db303197', '50', '300', '2021-12-06', '2021-12-06', '2021-12-05 23:05:06', '0000-00-00 00:00:00', '', 1),
(18, 'CLT-6177cd6a673c3', 'SHI-61adee62e3b09', 'pro-61a33e7d7102a', '10', '120', '2021-12-06', '2021-12-06', '2021-12-05 23:05:06', '0000-00-00 00:00:00', '', 1),
(19, 'CLT-6177cd6a673c3', 'SHI-61adee62e9a67', 'pro-61a33fe91e848', '10', '13000', '2021-12-06', '2021-12-06', '2021-12-05 23:05:06', '0000-00-00 00:00:00', '', 1),
(20, 'CLT-6177cd6a673c3', 'SHI-61adee62efd95', 'pro-61a34d87040d9', '20', '1000', '2021-12-06', '2021-12-06', '2021-12-05 23:05:06', '0000-00-00 00:00:00', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `product_name` varchar(110) NOT NULL,
  `manufacturer_id` varchar(100) NOT NULL,
  `category_id` varchar(50) NOT NULL,
  `sub_category_id` varchar(50) NOT NULL,
  `product_sn` varchar(100) NOT NULL,
  `product_model` varchar(100) NOT NULL,
  `product_description` text NOT NULL,
  `product_image` varchar(256) NOT NULL,
  `measurement_unit` varchar(100) NOT NULL,
  `product_profit` varchar(50) NOT NULL,
  `product_vat_per` varchar(50) NOT NULL,
  `product_unit_price` varchar(100) NOT NULL,
  `product_unit_mrp` varchar(100) NOT NULL,
  `product_unit_special_mrp` varchar(100) NOT NULL,
  `product_reorder_level` varchar(100) NOT NULL,
  `product_entry_by` varchar(50) NOT NULL,
  `product_entry_date` date NOT NULL,
  `product_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_updated_by` varchar(50) NOT NULL,
  `product_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `client_id`, `product_id`, `product_code`, `product_name`, `manufacturer_id`, `category_id`, `sub_category_id`, `product_sn`, `product_model`, `product_description`, `product_image`, `measurement_unit`, `product_profit`, `product_vat_per`, `product_unit_price`, `product_unit_mrp`, `product_unit_special_mrp`, `product_reorder_level`, `product_entry_by`, `product_entry_date`, `product_created_at`, `product_updated_at`, `product_updated_by`, `product_status`) VALUES
(3, 'CLT-6177cd6a673c3', 'pro-61a33db303197', '2003', 'Exclusive i12 TWS Bluetooth 5.0 Earbuds with Charging Case', 'MAN-6182646ccd844', 'PCI-61a33df12faf0', '', '', '', 'Connectors:Lightning\r\nControl Button:Yes\r\nActive Noise-Cancellation:Yes\r\nStyle:Ear Hook\r\nCommunication:Wireless\r\nVocalism Principle:Dynamic\r\nWireless Type:Bluetooth\r\nCodecs:None\r\nSupport Memory Card:No\r\nWith Microphone:Yes\r\nModel Number:i12\r\nResistance:32Ω\r\nFrequency Response Range:20-20000Hz\r\nFunction:for Video Game\r\nFunction:Common Headphone\r\nFunction:For Mobile Phone\r\nFunction:For iPod\r\nFunction:Sport\r\nSensitivity:120±5dB\r\nWaterproof:No\r\nIs wireless:Yes\r\nLine Length:None\r\nPlug Type:Wireless\r\nSupport APP:No\r\nBluetooth version:5.0 Earphones\r\nEarphone:Binaural Stereo Bluetooth Business Headset\r\nColor:White Headset with white case\r\nFeature1:Earphones Bluetooth\r\nFeature2:Sport Earphone,Music Earbuds,Hands free Business Headset,Hifi Earbuds\r\nFeature3:With charge warehouse silicone sleeve mini sports headset\r\nFeature4:charging case\r\nFeature5:Bluetooth Auriculares\r\nSupport Apt-x:NO\r\nModel:i12 touch', 'uploads/product/Capture.JPG', 'BAR-61825a94872ee', '', '15', '300', '383', '', '', 'CID-6177cd6a673c3', '2021-11-28', '2021-11-27 20:28:35', '2022-02-09 21:15:31', 'CID-6177cd6a673c3', 1),
(4, 'CLT-6177cd6a673c3', 'pro-61a33e7d7102a', '446', 'Leather Belt Analog Watch for Men', '', 'PCI-61a33e8c6a55a', '', '', '', '', 'uploads/product/Capture1.JPG', 'BAR-61825a94872ee', '', '10', '120', '146', '', '', 'CID-6177cd6a673c3', '2021-11-28', '2021-11-27 20:31:57', '2022-02-09 21:15:46', 'CID-6177cd6a673c3', 1),
(5, 'CLT-6177cd6a673c3', 'pro-61a33fe91e848', '44567', '32 \'\' SONY PLUS SMART TV ', 'MAN-61a34da58c30a', 'PCI-61a33f9e26dcb', '', '', '', '( RAM-1 GB-ROM 8 GB ) ( 4K SUPPORTED )', 'uploads/product/Capture2.JPG', 'BAR-61825a94872ee', '', '', '13000', '13490.5', '', '5', 'CID-6177cd6a673c3', '2021-11-28', '2021-11-27 20:38:01', '2022-02-16 05:20:22', 'CID-6177cd6a673c3', 1),
(6, 'CLT-6177cd6a673c3', 'pro-61a34d87040d9', '3245', 'Tenda F6 300Mbps N300 4 Antenna Wifi Router', 'MAN-61a34d9a0ec82', 'PCI-61a34d18c69a4', '', '', 'Tenda F6 300Mbps N300', '', 'uploads/product/Capture3.JPG', 'BAR-61825a94872ee', '', '5', '1000', '1400', '1200', '10', 'CID-6177cd6a673c3', '2021-11-28', '2021-11-27 21:36:07', '2021-11-27 21:36:31', 'CID-6177cd6a673c3', 1),
(7, 'CLT-6215eaac6dac2', 'pro-6215faba2aad4', '', 'test', '', 'PCI-6215fa2e53354', '', '', '', '', '', 'BAR-6215fa3abe7f1', '', '', '100', '200', '', '', 'CID-6215eaac6d6f2', '2022-02-23', '2022-02-22 21:13:30', '2022-02-23 09:13:30', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_invoice`
--

CREATE TABLE `purchase_invoice` (
  `id` int(11) NOT NULL,
  `purchase_invoice_id` varchar(50) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `supplier_id` varchar(30) NOT NULL,
  `purchase_invoice_date` date NOT NULL,
  `purchase_invoice_no` varchar(50) NOT NULL,
  `purchase_challan_no` varchar(200) NOT NULL,
  `purchase_invoice_barcode` varchar(255) DEFAULT NULL,
  `purchase_total_amount` varchar(50) NOT NULL,
  `purchase_total_vat` varchar(50) NOT NULL,
  `purchase_invoice_discount` varchar(50) NOT NULL,
  `purchase_total_discount` varchar(50) NOT NULL,
  `purchase_invoice_vat` varchar(50) NOT NULL,
  `purchase_amount_paid` varchar(50) NOT NULL,
  `purchase_balance_due` varchar(50) NOT NULL,
  `purchase_invoice_detail` text NOT NULL,
  `purchase_payment_type` varchar(100) NOT NULL,
  `purchase_payment_info` text NOT NULL,
  `purchase_payment_status` tinyint(4) NOT NULL,
  `purchase_invoice_return_total` varchar(100) NOT NULL,
  `purchase_invoice_return_amount` varchar(100) NOT NULL,
  `purchase_invoice_entry_by` varchar(100) NOT NULL,
  `purchase_invoice_entry_date` date NOT NULL,
  `purchase_invoice_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `purchase_invoice_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `purchase_invoice_updated_by` varchar(50) NOT NULL,
  `purchase_invoice_bill_status` tinyint(4) NOT NULL,
  `purchase_invoice_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase_invoice`
--

INSERT INTO `purchase_invoice` (`id`, `purchase_invoice_id`, `client_id`, `supplier_id`, `purchase_invoice_date`, `purchase_invoice_no`, `purchase_challan_no`, `purchase_invoice_barcode`, `purchase_total_amount`, `purchase_total_vat`, `purchase_invoice_discount`, `purchase_total_discount`, `purchase_invoice_vat`, `purchase_amount_paid`, `purchase_balance_due`, `purchase_invoice_detail`, `purchase_payment_type`, `purchase_payment_info`, `purchase_payment_status`, `purchase_invoice_return_total`, `purchase_invoice_return_amount`, `purchase_invoice_entry_by`, `purchase_invoice_entry_date`, `purchase_invoice_created_at`, `purchase_invoice_updated_at`, `purchase_invoice_updated_by`, `purchase_invoice_bill_status`, `purchase_invoice_status`) VALUES
(1, 'PUR-61a779181406f', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-01', '100001', 'c55055', NULL, '3000', '', '10', '10', '', '2882', '', 'q', 'Cash', 'N/A', 0, '298', '200', 'CID-6177cd6a673c3', '2021-12-01', '2021-12-01 01:31:04', '2021-12-04 22:36:33', 'CID-6177cd6a673c3', 0, 1),
(2, 'PUR-61a77941ad178', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-01', '100002', 'c101', NULL, '10000', '', '100', '100', '', '9800', '', '', 'Bank', '22', 0, '980', '980', 'CID-6177cd6a673c3', '2021-12-01', '2021-12-01 01:31:45', '2021-12-04 21:46:54', 'CID-6177cd6a673c3', 0, 1),
(3, 'PUR-61a779986f1a6', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-01', '100003', '111', NULL, '130000', '', '0', '0', '', '127000', '', '11', 'Cash', 'N/A', 0, '13000', '10000', 'CID-6177cd6a673c3', '2021-12-01', '2021-12-01 01:33:12', '2022-02-14 23:37:27', 'CID-6177cd6a673c3', 1, 1),
(4, 'PUR-61ac660f4b615', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-04', '100004', '123', NULL, '3000', '', '0.00', '0', '', '3000', '', '', 'Cash', 'N/A', 0, '', '', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-04 19:11:11', '2021-12-04 22:48:23', 'CID-6177cd6a673c3', 0, 1),
(5, 'PUR-61ac96c075104', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-05', '100005', '11weqe', NULL, '3000', '', '0', '0', '', '3000', '', '', 'Cash', 'N/A', 0, '', '', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-04 22:38:56', '2021-12-04 22:54:05', 'CID-6177cd6a673c3', 1, 1),
(6, 'PUR-61b4bb3f3d831', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-11', '100006', 'qq', NULL, '3000', '', '0', '0', '', '2550', '', '', 'Cash', 'N/A', 0, '300', '0', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 02:52:47', '2022-02-15 19:16:05', 'CID-6177cd6a673c3', 0, 1),
(7, 'PUR-61b4bc4dec08c', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-11', '100007', 's', NULL, '10000', '', '0', '0', '', '9000', '', '', 'Cash', 'N/A', 0, '10000', '9000', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 02:57:18', '2021-12-11 03:06:26', 'CID-6177cd6a673c3', 0, 1),
(8, 'PUR-61d9545fbe050', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2022-01-08', '100008', 'sss', NULL, '3000', '', '0.00', '0', '', '2000', '', 'ssf', 'Mobile', 'sssdfdfqqq', 0, '', '', 'CID-6177cd6a673c3', '2022-01-08', '2022-01-07 21:07:43', '2022-02-15 19:16:05', 'CID-6177cd6a673c3', 0, 1),
(9, 'PUR-61fa8378a38e1', 'CLT-6177cd6a673c3', 'MAN-61f24fd272eaf', '2022-02-02', '100009', '1', NULL, '600', '', '30.00', '20', '', '500', '', '', 'Cash', 'N/A', 0, '275', '270', 'CID-6177cd6a673c3', '2022-02-02', '2022-02-02 01:13:28', '2022-02-02 01:36:31', 'CID-6177cd6a673c3', 0, 1),
(10, 'PUR-621631c362b48', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2022-02-23', '100010', '1', NULL, '1200', '', '0', '0', '', '1000', '', '', 'Cash', 'N/A', 0, '', '', 'CID-6177cd6a673c3', '2022-02-23', '2022-02-23 01:08:19', '2022-02-23 13:08:19', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `supplier_id` varchar(50) NOT NULL,
  `purchase_invoice_id` varchar(50) NOT NULL,
  `purchase_invoice_no` varchar(50) NOT NULL,
  `purchase_item_id` varchar(50) NOT NULL,
  `product_id` varchar(250) NOT NULL,
  `purchase_item_quantity` varchar(50) NOT NULL,
  `purchase_return_item_quantity` varchar(50) NOT NULL,
  `purchase_item_rate` varchar(50) NOT NULL,
  `purchase_item_vat_per` varchar(100) NOT NULL,
  `purchase_item_discount` varchar(50) NOT NULL,
  `purchase_item_amount` varchar(50) NOT NULL,
  `purchase_item_date` date NOT NULL,
  `purchase_item_entry_by` varchar(100) NOT NULL,
  `purchase_item_entry_date` date NOT NULL,
  `purchase_item_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `purchase_item_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `purchase_item_updated_by` varchar(50) NOT NULL,
  `purchase_item_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase_items`
--

INSERT INTO `purchase_items` (`id`, `client_id`, `supplier_id`, `purchase_invoice_id`, `purchase_invoice_no`, `purchase_item_id`, `product_id`, `purchase_item_quantity`, `purchase_return_item_quantity`, `purchase_item_rate`, `purchase_item_vat_per`, `purchase_item_discount`, `purchase_item_amount`, `purchase_item_date`, `purchase_item_entry_by`, `purchase_item_entry_date`, `purchase_item_created_at`, `purchase_item_updated_at`, `purchase_item_updated_by`, `purchase_item_status`) VALUES
(1, 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', 'PUR-61a779181406f', '100001', 'PII-61a779181443f', 'pro-61a33db303197', '10', '1', '300', '', '10', '3000', '2021-12-01', 'CID-6177cd6a673c3', '2021-12-01', '2021-12-01 01:31:04', '2021-12-01 01:34:29', 'CID-6177cd6a673c3', 1),
(2, 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', 'PUR-61a77941ad178', '100002', 'PII-61a77941ad548', 'pro-61a34d87040d9', '10', '1', '1000', '', '100', '10000', '2021-12-01', 'CID-6177cd6a673c3', '2021-12-01', '2021-12-01 01:31:45', '2021-12-01 01:34:03', 'CID-6177cd6a673c3', 1),
(3, 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', 'PUR-61a779986f1a6', '100003', 'PII-61a779986f576', 'pro-61a33fe91e848', '10', '1', '13000', '', '0', '130000', '2021-12-01', 'CID-6177cd6a673c3', '2021-12-01', '2021-12-01 01:33:12', '2021-12-01 01:33:49', 'CID-6177cd6a673c3', 1),
(5, 'CID-6177cd6a673c3', 'MAN-6186292d839b6', 'PUR-61ac660f4b615', '100004', 'PII-61ac663522224', 'pro-61a33db303197', '10', '', '300.00', '', '0.00', '3000', '2021-12-04', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-04 19:11:49', '2021-12-05 07:11:49', '', 1),
(6, 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', 'PUR-61ac96c075104', '100005', 'PII-61ac96c0754d4', 'pro-61a33db303197', '10', '', '300', '', '0', '3000', '2021-12-05', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-04 22:38:56', '2021-12-05 10:38:56', '', 1),
(7, 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', 'PUR-61b4bb3f3d831', '100006', 'PII-61b4bb3f3dc01', 'pro-61a33db303197', '10', '1', '300', '', '0', '3000', '2021-12-11', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 02:52:47', '2021-12-11 02:53:00', 'CID-6177cd6a673c3', 1),
(8, 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', 'PUR-61b4bc4dec08c', '100007', 'PII-61b4bc4dec45d', 'pro-61a34d87040d9', '10', '10', '1000', '', '0', '10000', '2021-12-11', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 02:57:17', '2021-12-11 03:06:26', 'CID-6177cd6a673c3', 1),
(10, 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', 'PUR-61d9545fbe050', '100008', 'PII-61d95470a852d', 'pro-61a33db303197', '10', '', '300.00', '', '0.00', '3000', '2022-01-08', 'CID-6177cd6a673c3', '2022-01-08', '2022-01-07 21:08:00', '2022-01-08 09:08:00', '', 1),
(15, 'CLT-6177cd6a673c3', 'MAN-61f24fd272eaf', 'PUR-61fa8378a38e1', '100009', 'PII-61fa8457d9701', 'pro-61a33db303197', '2', '1', '300.00', '', '20.00', '600', '2022-02-02', 'CID-6177cd6a673c3', '2022-02-02', '2022-02-02 01:17:11', '2022-02-02 01:17:35', 'CID-6177cd6a673c3', 1),
(16, 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', 'PUR-621631c362b48', '100010', 'PII-621631c362f19', 'pro-61a33db303197', '4', '', '300', '', '0', '1200', '2022-02-23', 'CID-6177cd6a673c3', '2022-02-23', '2022-02-23 01:08:19', '2022-02-23 13:08:19', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_payment`
--

CREATE TABLE `purchase_payment` (
  `id` int(11) NOT NULL,
  `purchase_payment_id` varchar(50) NOT NULL,
  `supplier_payment_id` varchar(50) NOT NULL,
  `purchase_invoice_id` varchar(50) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `supplier_id` varchar(30) NOT NULL,
  `purchase_payment_date` date NOT NULL,
  `purchase_invoice_no` varchar(50) NOT NULL,
  `purchase_challan_no` varchar(200) NOT NULL,
  `purchase_payment_amount` varchar(50) NOT NULL,
  `purchase_payment_entry_by` varchar(100) NOT NULL,
  `purchase_payment_entry_date` date NOT NULL,
  `purchase_payment_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `purchase_payment_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `purchase_payment_updated_by` varchar(50) NOT NULL,
  `purchase_payment_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase_payment`
--

INSERT INTO `purchase_payment` (`id`, `purchase_payment_id`, `supplier_payment_id`, `purchase_invoice_id`, `client_id`, `supplier_id`, `purchase_payment_date`, `purchase_invoice_no`, `purchase_challan_no`, `purchase_payment_amount`, `purchase_payment_entry_by`, `purchase_payment_entry_date`, `purchase_payment_created_at`, `purchase_payment_updated_at`, `purchase_payment_updated_by`, `purchase_payment_status`) VALUES
(13, 'PPI-61ac98f7b8893', '', 'PUR-61a779986f1a6', 'CID-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-05', '100003', '111', '1000', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-05 10:48:23', '2021-12-05 10:48:23', '', 1),
(14, 'PPI-61ac98f7e2055', '', 'PUR-61ac660f4b615', 'CID-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-05', '100004', '123', '500', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-05 10:48:23', '2021-12-05 10:48:23', '', 1),
(15, 'PPI-61ac98f806acf', '', 'PUR-61ac96c075104', 'CID-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-05', '100005', '11weqe', '0', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-05 10:48:24', '2021-12-05 10:48:24', '', 1),
(16, 'PPI-61ac99d8eb51b', '', 'PUR-61a779986f1a6', 'CID-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-05', '100003', '111', '0', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-05 10:52:08', '2021-12-05 10:52:08', '', 1),
(17, 'PPI-61ac99d914fb1', '', 'PUR-61ac96c075104', 'CID-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-05', '100005', '11weqe', '500', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-05 10:52:09', '2021-12-05 10:52:09', '', 1),
(18, 'PPI-61ac99f0cc902', '', 'PUR-61a779986f1a6', 'CID-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-05', '100003', '111', '1000', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-05 10:52:32', '2021-12-05 10:52:32', '', 1),
(19, 'PPI-61ac99f0ec45d', '', 'PUR-61ac96c075104', 'CID-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-05', '100005', '11weqe', '200', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-05 10:52:32', '2021-12-05 10:52:32', '', 1),
(20, 'PPI-61ac9a4d45613', '', 'PUR-61a779986f1a6', 'CID-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-05', '100003', '111', '0', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-05 10:54:05', '2021-12-05 10:54:05', '', 1),
(21, 'PPI-61ac9a4d8546a', '', 'PUR-61ac96c075104', 'CID-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-05', '100005', '11weqe', '1300', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-05 10:54:05', '2021-12-05 10:54:05', '', 1),
(22, 'PPI-61ac9b3ee2055', '', 'PUR-61a779986f1a6', 'CID-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-05', '100003', '111', '1000', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-05 10:58:06', '2021-12-05 10:58:06', '', 1),
(23, 'PPI-61acaff015b23', '', 'PUR-61a779986f1a6', 'CID-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-05', '100003', '111', '1000', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-05 12:26:24', '2021-12-05 12:26:24', '', 1),
(24, 'PPI-61b4bb3f5cfbb', '', 'PUR-61b4bb3f3d831', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-11', '100006', 'qq', '0', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 14:52:47', '2021-12-11 14:52:47', '', 1),
(25, 'PPI-61b4bc4e269fb', '', 'PUR-61b4bc4dec08c', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-11', '100007', 's', '9000', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 14:57:18', '2021-12-11 14:57:18', '', 1),
(26, 'PPI-61d9545fd6d0a', '', 'PUR-61d9545fbe050', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2022-01-08', '100008', 'sss', '0.00', 'CID-6177cd6a673c3', '2022-01-08', '2022-01-08 09:07:43', '2022-01-07 21:08:00', 'CID-6177cd6a673c3', 1),
(27, 'PPI-61f52e8f09c67', '', 'PUR-61a779986f1a6', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2022-01-29', '100003', '111', '0', 'CID-6177cd6a673c3', '2022-01-29', '2022-01-29 12:09:51', '2022-01-29 12:09:51', '', 1),
(28, 'PPI-61f52e8f2dc6c', '', 'PUR-61b4bb3f3d831', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2022-01-29', '100006', 'qq', '0', 'CID-6177cd6a673c3', '2022-01-29', '2022-01-29 12:09:51', '2022-01-29 12:09:51', '', 1),
(29, 'PPI-61f52e8f409c8', '', 'PUR-61d9545fbe050', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2022-01-29', '100008', 'sss', '1000', 'CID-6177cd6a673c3', '2022-01-29', '2022-01-29 12:09:51', '2022-01-29 12:09:51', '', 1),
(30, 'PPI-61fa8378bbdfb', '', 'PUR-61fa8378a38e1', 'CLT-6177cd6a673c3', 'MAN-61f24fd272eaf', '2022-02-02', '100009', '1', '300.00', 'CID-6177cd6a673c3', '2022-02-02', '2022-02-02 13:13:28', '2022-02-02 01:17:12', 'CID-6177cd6a673c3', 1),
(31, 'PPI-61fa88df15752', '', 'PUR-61fa8378a38e1', 'CLT-6177cd6a673c3', 'MAN-61f24fd272eaf', '2022-02-02', '100009', '1', '200', 'CID-6177cd6a673c3', '2022-02-02', '2022-02-02 13:36:31', '2022-02-02 13:36:31', '', 1),
(32, 'PPI-620b907745243', '', 'PUR-61a779986f1a6', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2022-02-15', '100003', '111', '18000', 'CID-6177cd6a673c3', '2022-02-15', '2022-02-15 11:37:27', '2022-02-15 11:37:27', '', 1),
(33, 'PPI-620b90775742d', '', 'PUR-61b4bb3f3d831', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2022-02-15', '100006', 'qq', '0', 'CID-6177cd6a673c3', '2022-02-15', '2022-02-15 11:37:27', '2022-02-15 11:37:27', '', 1),
(34, 'PPI-620b907766851', '', 'PUR-61d9545fbe050', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2022-02-15', '100008', 'sss', '0', 'CID-6177cd6a673c3', '2022-02-15', '2022-02-15 11:37:27', '2022-02-15 11:37:27', '', 1),
(35, 'PPI-620c90b6c1d59', '', 'PUR-61b4bb3f3d831', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2022-02-16', '100006', 'qq', '2000', 'CID-6177cd6a673c3', '2022-02-16', '2022-02-16 05:50:46', '2022-02-16 05:50:46', '', 1),
(36, 'PPI-620c90b6ce3b6', '', 'PUR-61d9545fbe050', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2022-02-16', '100008', 'sss', '0', 'CID-6177cd6a673c3', '2022-02-16', '2022-02-16 05:50:46', '2022-02-16 05:50:46', '', 1),
(37, 'PPI-620c9dd015ef3', 'SPI-620c9dd0094c6', 'PUR-61b4bb3f3d831', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2022-02-16', '100006', 'qq', '500', 'CID-6177cd6a673c3', '2022-02-16', '2022-02-16 06:46:40', '2022-02-16 06:46:40', '', 1),
(38, 'PPI-620c9dd025e89', 'SPI-620c9dd0094c6', 'PUR-61d9545fbe050', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2022-02-16', '100008', 'sss', '1000', 'CID-6177cd6a673c3', '2022-02-16', '2022-02-16 06:46:40', '2022-02-16 06:46:40', '', 1),
(39, 'PPI-620ca4b51ff2b', 'SPI-620ca4b50d970', 'PUR-61b4bb3f3d831', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2022-02-16', '100006', 'qq', '50', 'CID-6177cd6a673c3', '2022-02-16', '2022-02-15 19:16:05', '2022-02-16 07:16:05', '', 1),
(40, 'PPI-620ca4b531d45', 'SPI-620ca4b50d970', 'PUR-61d9545fbe050', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2022-02-16', '100008', 'sss', '0', 'CID-6177cd6a673c3', '2022-02-16', '2022-02-15 19:16:05', '2022-02-16 07:16:05', '', 1),
(41, 'PPI-621631c385fdc', '', 'PUR-621631c362b48', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2022-02-23', '100010', '1', '1000', 'CID-6177cd6a673c3', '2022-02-23', '2022-02-23 13:08:19', '2022-02-23 13:08:19', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_invoice`
--

CREATE TABLE `purchase_return_invoice` (
  `id` int(11) NOT NULL,
  `purchase_return_id` varchar(50) NOT NULL,
  `purchase_invoice_id` varchar(50) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `supplier_id` varchar(30) NOT NULL,
  `purchase_return_date` date NOT NULL,
  `purchase_invoice_no` varchar(50) NOT NULL,
  `purchase_return_total` varchar(100) NOT NULL,
  `purchase_return_amount` varchar(100) NOT NULL,
  `purchase_invoice_entry_by` varchar(100) NOT NULL,
  `purchase_invoice_entry_date` date NOT NULL,
  `purchase_invoice_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `purchase_invoice_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `purchase_invoice_updated_by` varchar(50) NOT NULL,
  `purchase_invoice_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase_return_invoice`
--

INSERT INTO `purchase_return_invoice` (`id`, `purchase_return_id`, `purchase_invoice_id`, `client_id`, `supplier_id`, `purchase_return_date`, `purchase_invoice_no`, `purchase_return_total`, `purchase_return_amount`, `purchase_invoice_entry_by`, `purchase_invoice_entry_date`, `purchase_invoice_created_at`, `purchase_invoice_updated_at`, `purchase_invoice_updated_by`, `purchase_invoice_status`) VALUES
(1, 'PRI-61a779bd9d5b3', 'PUR-61a779986f1a6', 'CID-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-01', '100003', '13000', '10000', 'CID-6177cd6a673c3', '2021-12-01', '2021-12-01 01:33:49', '2021-12-01 13:33:49', '', 1),
(2, 'PRI-61a779cbd6d0a', 'PUR-61a77941ad178', 'CID-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-01', '100002', '980', '980', 'CID-6177cd6a673c3', '2021-12-01', '2021-12-01 01:34:04', '2021-12-01 13:34:04', '', 1),
(3, 'PRI-61a779e595400', 'PUR-61a779181406f', 'CID-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-01', '100001', '298', '200', 'CID-6177cd6a673c3', '2021-12-01', '2021-12-01 01:34:29', '2021-12-01 13:34:29', '', 1),
(4, 'PRI-61b4bb4c5b507', 'PUR-61b4bb3f3d831', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-11', '100006', '300', '0.00', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 02:53:00', '2021-12-11 14:53:00', '', 1),
(5, 'PRI-61b4be7266851', 'PUR-61b4bc4dec08c', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2021-12-11', '100007', '10000', '9000.00', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 03:06:26', '2021-12-11 15:06:26', '', 1),
(6, 'PRI-61fa846f4378f', 'PUR-61fa8378a38e1', 'CLT-6177cd6a673c3', 'MAN-61f24fd272eaf', '2022-02-02', '100009', '275', '270', 'CID-6177cd6a673c3', '2022-02-02', '2022-02-02 01:17:35', '2022-02-02 13:17:35', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_item`
--

CREATE TABLE `purchase_return_item` (
  `id` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `supplier_id` varchar(50) NOT NULL,
  `purchase_invoice_id` varchar(50) NOT NULL,
  `purchase_invoice_no` varchar(50) NOT NULL,
  `purchase_item_id` varchar(50) NOT NULL,
  `purchase_return_id` varchar(50) NOT NULL,
  `purchase_return_item_id` varchar(50) NOT NULL,
  `product_id` varchar(250) NOT NULL,
  `purchase_return_quantity` varchar(50) NOT NULL,
  `purchase_return_rate` varchar(50) NOT NULL,
  `purchase_return_amount` varchar(50) NOT NULL,
  `purchase_return_date` date NOT NULL,
  `purchase_return_entry_by` varchar(100) NOT NULL,
  `purchase_return_entry_date` date NOT NULL,
  `purchase_return_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `purchase_return_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `purchase_return_updated_by` varchar(50) NOT NULL,
  `purchase_return_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase_return_item`
--

INSERT INTO `purchase_return_item` (`id`, `client_id`, `supplier_id`, `purchase_invoice_id`, `purchase_invoice_no`, `purchase_item_id`, `purchase_return_id`, `purchase_return_item_id`, `product_id`, `purchase_return_quantity`, `purchase_return_rate`, `purchase_return_amount`, `purchase_return_date`, `purchase_return_entry_by`, `purchase_return_entry_date`, `purchase_return_created_at`, `purchase_return_updated_at`, `purchase_return_updated_by`, `purchase_return_status`) VALUES
(1, 'CID-6177cd6a673c3', 'MAN-6186292d839b6', 'PUR-61a779986f1a6', '100003', 'PII-61a779986f576', 'PRI-61a779bd9d5b3', 'PRII-61a779bdaa3b1', 'pro-61a33fe91e848', '1', '13000.00', '13000', '2021-12-01', 'CID-6177cd6a673c3', '2021-12-01', '2021-12-01 01:33:49', '2021-12-01 13:33:49', '', 1),
(2, 'CID-6177cd6a673c3', 'MAN-6186292d839b6', 'PUR-61a77941ad178', '100002', 'PII-61a77941ad548', 'PRI-61a779cbd6d0a', 'PRII-61a779cbe18b4', 'pro-61a34d87040d9', '1', '990.00', '990', '2021-12-01', 'CID-6177cd6a673c3', '2021-12-01', '2021-12-01 01:34:03', '2021-12-01 13:34:03', '', 1),
(3, 'CID-6177cd6a673c3', 'MAN-6186292d839b6', 'PUR-61a779181406f', '100001', 'PII-61a779181443f', 'PRI-61a779e595400', 'PRII-61a779e59f067', 'pro-61a33db303197', '1', '299.00', '299', '2021-12-01', 'CID-6177cd6a673c3', '2021-12-01', '2021-12-01 01:34:29', '2021-12-01 13:34:29', '', 1),
(4, 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', 'PUR-61b4bb3f3d831', '100006', 'PII-61b4bb3f3dc01', 'PRI-61b4bb4c5b507', 'PRII-61b4bb4c660b0', 'pro-61a33db303197', '1', '300.00', '300', '2021-12-11', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 02:53:00', '2021-12-11 14:53:00', '', 1),
(5, 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', 'PUR-61b4bc4dec08c', '100007', 'PII-61b4bc4dec45d', 'PRI-61b4be7266851', 'PRII-61b4be7281390', 'pro-61a34d87040d9', '10', '1000.00', '10000', '2021-12-11', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 03:06:26', '2021-12-11 15:06:26', '', 1),
(6, 'CLT-6177cd6a673c3', 'MAN-61f24fd272eaf', 'PUR-61fa8378a38e1', '100009', 'PII-61fa8457d9701', 'PRI-61fa846f4378f', 'PRII-61fa846f5c449', 'pro-61a33db303197', '1', '290.00', '290', '2022-02-02', 'CID-6177cd6a673c3', '2022-02-02', '2022-02-02 01:17:35', '2022-02-02 13:17:35', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales_invoice`
--

CREATE TABLE `sales_invoice` (
  `id` int(11) NOT NULL,
  `sales_invoice_id` varchar(50) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `customer_id` varchar(30) NOT NULL,
  `sales_invoice_date` date NOT NULL,
  `sales_invoice_no` varchar(50) NOT NULL,
  `sales_invoice_barcode` varchar(255) DEFAULT NULL,
  `sales_total_amount` varchar(50) NOT NULL,
  `sales_total_vat` varchar(50) NOT NULL,
  `sales_invoice_discount` varchar(50) NOT NULL,
  `sales_total_discount` varchar(50) NOT NULL,
  `sales_invoice_vat` varchar(50) NOT NULL,
  `sales_amount_paid` varchar(50) NOT NULL,
  `sales_balance_due` varchar(50) NOT NULL,
  `sales_invoice_detail` text NOT NULL,
  `sales_payment_type` varchar(100) NOT NULL,
  `sales_payment_info` text NOT NULL,
  `sales_payment_status` tinyint(4) NOT NULL,
  `sales_invoice_return_total` varchar(100) NOT NULL,
  `sales_invoice_return_amount` varchar(100) NOT NULL,
  `sales_invoice_entry_by` varchar(100) NOT NULL,
  `sales_invoice_entry_date` date NOT NULL,
  `sales_invoice_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sales_invoice_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sales_invoice_updated_by` varchar(50) NOT NULL,
  `sales_invoice_bill_status` tinyint(4) NOT NULL,
  `sales_invoice_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales_invoice`
--

INSERT INTO `sales_invoice` (`id`, `sales_invoice_id`, `client_id`, `customer_id`, `sales_invoice_date`, `sales_invoice_no`, `sales_invoice_barcode`, `sales_total_amount`, `sales_total_vat`, `sales_invoice_discount`, `sales_total_discount`, `sales_invoice_vat`, `sales_amount_paid`, `sales_balance_due`, `sales_invoice_detail`, `sales_payment_type`, `sales_payment_info`, `sales_payment_status`, `sales_invoice_return_total`, `sales_invoice_return_amount`, `sales_invoice_entry_by`, `sales_invoice_entry_date`, `sales_invoice_created_at`, `sales_invoice_updated_at`, `sales_invoice_updated_by`, `sales_invoice_bill_status`, `sales_invoice_status`) VALUES
(1, 'SAL-61ac68f423cd8', 'CLT-6177cd6a673c3', 'CUS-61ac68f4240a9', '2021-12-05', '100001', NULL, '383', '', '0.00', '0', '', '363', '', '', 'Cash', 'N/A', 0, '', '', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-04 19:23:32', '2022-02-15 19:35:04', 'CID-6177cd6a673c3', 0, 1),
(2, 'SAL-61aca496d9701', 'CLT-6177cd6a673c3', 'CUS-618626aa9e4f5', '2021-12-05', '100002', NULL, '292', '', '0', '0', '', '146', '', 'a', 'Bank', 'aa', 0, '146', '0', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-04 23:37:59', '2021-12-04 23:44:23', 'CID-6177cd6a673c3', 1, 1),
(3, 'SAL-61b4b7e9a2d70', 'CLT-6177cd6a673c3', 'CUS-61b4b7e9a3140', '2021-12-11', '100003', NULL, '3830', '', '100', '100', '', '3000', '', '', 'Cash', 'N/A', 0, '3630', '300', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 02:38:33', '2021-12-11 02:48:04', 'CID-6177cd6a673c3', 0, 1),
(4, 'SAL-61b4befb52412', 'CLT-6177cd6a673c3', 'CUS-61b4befb527e2', '2021-12-11', '100004', NULL, '766', '', '0', '0', '', '700', '', '', 'Cash', 'N/A', 0, '766', '700', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 03:08:43', '2021-12-11 03:09:01', 'CID-6177cd6a673c3', 0, 1),
(5, 'SAL-61d9483a58740', 'CLT-6177cd6a673c3', 'CUS-61d9483a58b11', '2022-01-08', '100005', NULL, '3830', '', '0', '0', '', '0', '', 'a', 'Bkash', '', 0, '', '', 'CID-6177cd6a673c3', '2022-01-08', '2022-01-07 20:15:54', '2022-01-08 08:15:54', '', 0, 1),
(6, 'SAL-61d9540586f1e', 'CLT-6177cd6a673c3', 'CUS-61d95405872ef', '2022-01-08', '100006', NULL, '383', '', '0.00', '0', '', '0.00', '', '22', 'Mobile', '44444', 0, '', '', 'CID-6177cd6a673c3', '2022-01-08', '2022-01-07 21:06:13', '2022-01-07 21:06:40', 'CID-6177cd6a673c3', 0, 1),
(7, 'SAL-61f7ae45225b6', 'CLT-6177cd6a673c3', 'CUS-61f7ae4522987', '2022-01-31', '100007', NULL, '13873', '', '0', '0', '', '0', '', 'w', 'Cash', 'N/A', 0, '', '', 'CID-6177cd6a673c3', '2022-01-31', '2022-01-30 21:39:17', '2022-01-31 09:39:17', '', 0, 1),
(8, 'SAL-61f7c21a3348e', 'CLT-6177cd6a673c3', 'CUS-618626aa9e4f5', '2022-01-31', '100008', NULL, '1460', '', '100', '100', '', '1000', '', '', 'Cash', 'N/A', 0, '', '', 'CID-6177cd6a673c3', '2022-01-31', '2022-01-30 23:03:54', '2022-02-15 19:33:53', 'CID-6177cd6a673c3', 1, 1),
(9, 'SAL-6204f357f0cd8', 'CLT-6177cd6a673c3', 'CUS-6204f357f10a8', '2022-02-10', '100009', NULL, '1783', '70', '10.00', '12.45', '', '400.00', '', '', 'Cash', 'N/A', 0, '', '', 'CID-6177cd6a673c3', '2022-02-10', '2022-02-09 23:13:28', '2022-02-11 21:29:34', 'CID-6177cd6a673c3', 0, 1),
(10, 'SAL-6207992da9fe1', 'CLT-6177cd6a673c3', 'CUS-6207992daa3b1', '2022-02-12', '100010', NULL, '1783', '127.45', '0.00', '0', '', '0.00', '', '1', 'Cash', 'N/A', 0, '', '', 'CID-6177cd6a673c3', '2022-02-12', '2022-02-11 23:25:33', '2022-02-11 23:26:20', 'CID-6177cd6a673c3', 0, 1),
(11, 'SAL-6208fafa77afa', 'CLT-6177cd6a673c3', 'CUS-6208fafa77ecb', '2022-02-13', '100011', NULL, '13490', '0', '0', '0', '', '0', '', '', 'Cash', 'N/A', 0, '13490', '0', 'CID-6177cd6a673c3', '2022-02-13', '2022-02-13 00:35:06', '2022-02-14 23:13:50', 'CID-6177cd6a673c3', 0, 1),
(12, 'SAL-620c89ff903e4', 'CLT-6177cd6a673c3', 'CUS-620c89ff907b4', '2022-02-16', '100012', NULL, '13490.5', '0', '0', '0', '', '0', '', '', 'Cash', 'N/A', 0, '', '', 'CID-6177cd6a673c3', '2022-02-16', '2022-02-16 05:22:07', '2022-02-16 05:22:07', '', 0, 1),
(13, 'SAL-621631aa2d89b', 'CLT-6177cd6a673c3', 'CUS-621631aa2dc6c', '2022-02-23', '100013', NULL, '383', '57.45', '0', '0', '', '400', '', '', 'Cash', 'N/A', 0, '', '', 'CID-6177cd6a673c3', '2022-02-23', '2022-02-23 01:07:54', '2022-02-23 13:07:54', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales_items`
--

CREATE TABLE `sales_items` (
  `id` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `customer_id` varchar(50) NOT NULL,
  `sales_invoice_id` varchar(50) NOT NULL,
  `sales_invoice_no` varchar(50) NOT NULL,
  `sales_item_id` varchar(50) NOT NULL,
  `product_id` varchar(250) NOT NULL,
  `sales_item_serial` varchar(100) NOT NULL,
  `sales_item_quantity` varchar(50) NOT NULL,
  `sales_return_item_quantity` varchar(50) NOT NULL,
  `sales_item_rate` varchar(100) NOT NULL,
  `sales_item_tp` varchar(100) NOT NULL,
  `sales_item_vat_per` varchar(100) NOT NULL,
  `sales_item_discount` varchar(50) NOT NULL,
  `sales_item_amount` varchar(50) NOT NULL,
  `sales_item_date` date NOT NULL,
  `sales_item_entry_by` varchar(100) NOT NULL,
  `sales_item_entry_date` date NOT NULL,
  `sales_item_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sales_item_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sales_item_updated_by` varchar(50) NOT NULL,
  `sales_item_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales_items`
--

INSERT INTO `sales_items` (`id`, `client_id`, `customer_id`, `sales_invoice_id`, `sales_invoice_no`, `sales_item_id`, `product_id`, `sales_item_serial`, `sales_item_quantity`, `sales_return_item_quantity`, `sales_item_rate`, `sales_item_tp`, `sales_item_vat_per`, `sales_item_discount`, `sales_item_amount`, `sales_item_date`, `sales_item_entry_by`, `sales_item_entry_date`, `sales_item_created_at`, `sales_item_updated_at`, `sales_item_updated_by`, `sales_item_status`) VALUES
(2, '', 'CUS-61ac68f4240a9', 'SAL-61ac68f423cd8', '100001', 'SII-61ac69038f916', 'pro-61a33db303197', '', '1', '', '383.00', '300.00', '', '0.00', '383', '2021-12-05', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-04 19:23:47', '2021-12-05 07:23:47', '', 1),
(3, 'CLT-6177cd6a673c3', 'CUS-618626aa9e4f5', 'SAL-61aca496d9701', '100002', 'SII-61aca496d9ad1', 'pro-61a33e7d7102a', '', '2', '1', '146', '0', '', '0', '292', '2021-12-05', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-04 23:37:58', '2021-12-04 23:39:13', 'CID-6177cd6a673c3', 1),
(4, 'CLT-6177cd6a673c3', 'CUS-61b4b7e9a3140', 'SAL-61b4b7e9a2d70', '100003', 'SII-61b4b7e9ae48b', 'pro-61a33db303197', '', '10', '10', '383', '300', '', '100', '3830', '2021-12-11', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 02:38:33', '2021-12-11 02:48:04', 'CID-6177cd6a673c3', 1),
(5, 'CLT-6177cd6a673c3', 'CUS-61b4befb527e2', 'SAL-61b4befb52412', '100004', 'SII-61b4befb6f947', 'pro-61a33db303197', '', '2', '2', '383', '300', '', '0', '766', '2021-12-11', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 03:08:43', '2021-12-11 03:09:01', 'CID-6177cd6a673c3', 1),
(6, 'CLT-6177cd6a673c3', 'CUS-61d9483a58b11', 'SAL-61d9483a58740', '100005', 'SII-61d9483a872ee', 'pro-61a33db303197', '', '10', '', '383', '300', '', '0', '3830', '2022-01-08', 'CID-6177cd6a673c3', '2022-01-08', '2022-01-07 20:15:54', '2022-01-08 08:15:54', '', 1),
(8, '', 'CUS-61d95405872ef', 'SAL-61d9540586f1e', '100006', 'SII-61d9541fdeaed', 'pro-61a33db303197', '', '1', '', '383.00', '300', '', '0.00', '383', '2022-01-08', 'CID-6177cd6a673c3', '2022-01-08', '2022-01-07 21:06:39', '2022-01-08 09:06:39', '', 1),
(9, 'CLT-6177cd6a673c3', 'CUS-61f7ae4522987', 'SAL-61f7ae45225b6', '100007', 'SII-61f7ae4564291', 'pro-61a33db303197', '', '1', '', '383', '300.00', '', '0', '383', '2022-01-31', 'CID-6177cd6a673c3', '2022-01-31', '2022-01-30 21:39:17', '2022-01-31 09:39:17', '', 1),
(10, 'CLT-6177cd6a673c3', 'CUS-61f7ae4522987', 'SAL-61f7ae45225b6', '100007', 'SII-61f7ae45bb6bf', 'pro-61a33fe91e848', '', '1', '', '13490', '13000', '', '0', '13490', '2022-01-31', 'CID-6177cd6a673c3', '2022-01-31', '2022-01-30 21:39:17', '2022-01-31 09:39:17', '', 1),
(11, 'CLT-6177cd6a673c3', 'CUS-618626aa9e4f5', 'SAL-61f7c21a3348e', '100008', 'SII-61f7c21a3385e', 'pro-61a33e7d7102a', '', '10', '', '146', '0', '', '100', '1460', '2022-01-31', 'CID-6177cd6a673c3', '2022-01-31', '2022-01-30 23:03:54', '2022-01-31 11:03:54', '', 1),
(13, '', 'CUS-6204f357f10a8', 'SAL-6204f357f0cd8', '100009', 'SII-62077dfe872ee', 'pro-61a34d87040d9', '', '1', '', '1400.00', '1000', '', '10.00', '1400', '2022-02-10', 'CID-6177cd6a673c3', '2022-02-12', '2022-02-11 21:29:34', '2022-02-12 09:29:34', '', 1),
(14, '', 'CUS-6204f357f10a8', 'SAL-6204f357f0cd8', '100009', 'SII-62077dfe9f067', 'pro-61a33db303197', '', '1', '', '383', '300.00', '', '2.45', '383', '2022-02-10', 'CID-6177cd6a673c3', '2022-02-12', '2022-02-11 21:29:34', '2022-02-12 09:29:34', '', 1),
(16, '', 'CUS-6207992daa3b1', 'SAL-6207992da9fe1', '100010', 'SII-6207995c4d025', 'pro-61a33db303197', '', '1', '', '383.00', '300.00', '15', '0.00', '383', '2022-02-12', 'CID-6177cd6a673c3', '2022-02-12', '2022-02-11 23:26:20', '2022-02-12 11:26:20', '', 1),
(17, '', 'CUS-6207992daa3b1', 'SAL-6207992da9fe1', '100010', 'SII-6207995c623a7', 'pro-61a34d87040d9', '', '1', '', '1400', '1000', '5', '0', '1400', '2022-02-12', 'CID-6177cd6a673c3', '2022-02-12', '2022-02-11 23:26:20', '2022-02-12 11:26:20', '', 1),
(18, 'CLT-6177cd6a673c3', 'CUS-6208fafa77ecb', 'SAL-6208fafa77afa', '100011', 'SII-6208fafa916f7', 'pro-61a33fe91e848', '', '1', '1', '13490', '13000', '0', '0', '13490', '2022-02-13', 'CID-6177cd6a673c3', '2022-02-13', '2022-02-13 00:35:06', '2022-02-14 23:13:50', 'CID-6177cd6a673c3', 1),
(19, 'CLT-6177cd6a673c3', 'CUS-620c89ff907b4', 'SAL-620c89ff903e4', '100012', 'SII-620c89ff9becf', 'pro-61a33fe91e848', '', '1', '', '13490.5', '13000', '0.00', '0', '13490.5', '2022-02-16', 'CID-6177cd6a673c3', '2022-02-16', '2022-02-16 05:22:07', '2022-02-16 05:22:07', '', 1),
(20, 'CLT-6177cd6a673c3', 'CUS-621631aa2dc6c', 'SAL-621631aa2d89b', '100013', 'SII-621631aa3d090', 'pro-61a33db303197', '', '1', '', '383', '300.00', '15.00', '0', '383', '2022-02-23', 'CID-6177cd6a673c3', '2022-02-23', '2022-02-23 01:07:54', '2022-02-23 13:07:54', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales_payment`
--

CREATE TABLE `sales_payment` (
  `id` int(11) NOT NULL,
  `sales_payment_id` varchar(50) NOT NULL,
  `customer_payment_id` varchar(50) NOT NULL,
  `sales_invoice_id` varchar(50) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `customer_id` varchar(30) NOT NULL,
  `sales_payment_date` date NOT NULL,
  `sales_invoice_no` varchar(50) NOT NULL,
  `sales_payment_amount` varchar(50) NOT NULL,
  `sales_payment_entry_by` varchar(100) NOT NULL,
  `sales_payment_entry_date` date NOT NULL,
  `sales_payment_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sales_payment_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sales_payment_updated_by` varchar(50) NOT NULL,
  `sales_payment_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales_payment`
--

INSERT INTO `sales_payment` (`id`, `sales_payment_id`, `customer_payment_id`, `sales_invoice_id`, `client_id`, `customer_id`, `sales_payment_date`, `sales_invoice_no`, `sales_payment_amount`, `sales_payment_entry_by`, `sales_payment_entry_date`, `sales_payment_created_at`, `sales_payment_updated_at`, `sales_payment_updated_by`, `sales_payment_status`) VALUES
(1, 'SIP-61ac68f443fd4', '', 'SAL-61ac68f423cd8', 'CLT-6177cd6a673c3', 'CUS-61ac68f4240a9', '2021-12-05', '100001', '350.00', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-05 07:23:32', '2021-12-04 19:23:47', 'CID-6177cd6a673c3', 1),
(2, 'SIP-61aca49717206', '', 'SAL-61aca496d9701', 'CLT-6177cd6a673c3', 'CUS-618626aa9e4f5', '2021-12-05', '100002', '0', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-05 11:37:59', '2021-12-05 11:37:59', '', 1),
(3, 'PPI-61aca60c7c375', '', 'SAL-61aca496d9701', 'CID-6177cd6a673c3', 'CUS-618626aa9e4f5', '2021-12-05', '100002', '140', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-05 11:44:12', '2021-12-05 11:44:12', '', 1),
(4, 'PPI-61aca6172bde7', '', 'SAL-61aca496d9701', 'CID-6177cd6a673c3', 'CUS-618626aa9e4f5', '2021-12-05', '100002', '6', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-05 11:44:23', '2021-12-05 11:44:23', '', 1),
(5, 'PPI-61b0560ecdfe6', '', 'SAL-61ac68f423cd8', 'CLT-6177cd6a673c3', 'CUS-61ac68f4240a9', '2021-12-08', '100001', '3', 'CID-6177cd6a673c3', '2021-12-08', '2021-12-08 06:51:58', '2021-12-08 06:51:58', '', 1),
(6, 'SIP-61b4b7e9c8458', '', 'SAL-61b4b7e9a2d70', 'CLT-6177cd6a673c3', 'CUS-61b4b7e9a3140', '2021-12-11', '100003', '3000', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 14:38:33', '2021-12-11 14:38:33', '', 1),
(7, 'SIP-61b4befb9c2a0', '', 'SAL-61b4befb52412', 'CLT-6177cd6a673c3', 'CUS-61b4befb527e2', '2021-12-11', '100004', '700', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 15:08:43', '2021-12-11 15:08:43', '', 1),
(8, 'SIP-61d9483a9abbd', '', 'SAL-61d9483a58740', 'CLT-6177cd6a673c3', 'CUS-61d9483a58b11', '2022-01-08', '100005', '0', 'CID-6177cd6a673c3', '2022-01-08', '2022-01-08 08:15:54', '2022-01-08 08:15:54', '', 1),
(9, 'SIP-61d95405d20bf', '', 'SAL-61d9540586f1e', 'CLT-6177cd6a673c3', 'CUS-61d95405872ef', '2022-01-08', '100006', '0.00', 'CID-6177cd6a673c3', '2022-01-08', '2022-01-08 09:06:13', '2022-01-07 21:06:40', 'CID-6177cd6a673c3', 1),
(10, 'SIP-61f7ae45edf76', '', 'SAL-61f7ae45225b6', 'CLT-6177cd6a673c3', 'CUS-61f7ae4522987', '2022-01-31', '100007', '0', 'CID-6177cd6a673c3', '2022-01-31', '2022-01-31 09:39:17', '2022-01-31 09:39:17', '', 1),
(11, 'SIP-61f7c21a5b93d', '', 'SAL-61f7c21a3348e', 'CLT-6177cd6a673c3', 'CUS-618626aa9e4f5', '2022-01-31', '100008', '1000', 'CID-6177cd6a673c3', '2022-01-31', '2022-01-31 11:03:54', '2022-01-31 11:03:54', '', 1),
(12, 'SIP-6204f3581dcd6', '', 'SAL-6204f357f0cd8', 'CLT-6177cd6a673c3', 'CUS-6204f357f10a8', '2022-02-10', '100009', '400.00', 'CID-6177cd6a673c3', '2022-02-10', '2022-02-10 11:13:28', '2022-02-11 21:29:34', 'CID-6177cd6a673c3', 1),
(13, 'SIP-6207992de05a1', '', 'SAL-6207992da9fe1', 'CLT-6177cd6a673c3', 'CUS-6207992daa3b1', '2022-02-12', '100010', '0.00', 'CID-6177cd6a673c3', '2022-02-12', '2022-02-12 11:25:33', '2022-02-11 23:26:20', 'CID-6177cd6a673c3', 1),
(14, 'SIP-6208fafad693a', '', 'SAL-6208fafa77afa', 'CLT-6177cd6a673c3', 'CUS-6208fafa77ecb', '2022-02-13', '100011', '0', 'CID-6177cd6a673c3', '2022-02-13', '2022-02-13 12:35:06', '2022-02-13 12:35:06', '', 1),
(15, 'SIP-620c89ffb2d05', '', 'SAL-620c89ff903e4', 'CLT-6177cd6a673c3', 'CUS-620c89ff907b4', '2022-02-16', '100012', '0', 'CID-6177cd6a673c3', '2022-02-16', '2022-02-16 05:22:07', '2022-02-16 05:22:07', '', 1),
(16, 'PPI-620ca8e1c8088', 'SPI-620ca8e1b9f76', 'SAL-61f7c21a3348e', 'CLT-6177cd6a673c3', 'CUS-618626aa9e4f5', '2022-02-16', '100008', '0', 'CID-6177cd6a673c3', '2022-02-16', '2022-02-15 19:33:53', '2022-02-16 07:33:53', '', 1),
(17, 'PPI-620ca927f1479', 'SPI-620ca927e7812', 'SAL-61ac68f423cd8', 'CLT-6177cd6a673c3', 'CUS-61ac68f4240a9', '2022-02-16', '100001', '10', 'CID-6177cd6a673c3', '2022-02-16', '2022-02-15 19:35:03', '2022-02-16 07:35:03', '', 1),
(18, 'SIP-621631aa7997e', '', 'SAL-621631aa2d89b', 'CLT-6177cd6a673c3', 'CUS-621631aa2dc6c', '2022-02-23', '100013', '400', 'CID-6177cd6a673c3', '2022-02-23', '2022-02-23 13:07:54', '2022-02-23 13:07:54', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_invoice`
--

CREATE TABLE `sales_return_invoice` (
  `id` int(11) NOT NULL,
  `sales_return_id` varchar(50) NOT NULL,
  `sales_invoice_id` varchar(50) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `customer_id` varchar(30) NOT NULL,
  `sales_return_date` date NOT NULL,
  `sales_invoice_no` varchar(50) NOT NULL,
  `sales_return_total` varchar(50) NOT NULL,
  `sales_return_amount` varchar(50) NOT NULL,
  `sales_return_entry_by` varchar(100) NOT NULL,
  `sales_return_entry_date` date NOT NULL,
  `sales_return_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sales_return_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sales_return_updated_by` varchar(50) NOT NULL,
  `sales_return_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales_return_invoice`
--

INSERT INTO `sales_return_invoice` (`id`, `sales_return_id`, `sales_invoice_id`, `client_id`, `customer_id`, `sales_return_date`, `sales_invoice_no`, `sales_return_total`, `sales_return_amount`, `sales_return_entry_by`, `sales_return_entry_date`, `sales_return_created_at`, `sales_return_updated_at`, `sales_return_updated_by`, `sales_return_status`) VALUES
(1, 'SRI-61aca4e1243d5', 'SAL-61aca496d9701', 'CID-6177cd6a673c3', 'CUS-618626aa9e4f5', '2021-12-05', '100002', '146', '0.00', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-04 23:39:13', '2021-12-05 11:39:13', '', 1),
(2, 'SRI-61b4b81301ab3', 'SAL-61b4b7e9a2d70', 'CLT-6177cd6a673c3', 'CUS-61b4b7e9a3140', '2021-12-11', '100003', '363', '300', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 02:39:15', '2021-12-11 14:39:15', '', 1),
(3, 'SRI-61b4ba24c3fae', 'SAL-61b4b7e9a2d70', 'CLT-6177cd6a673c3', 'CUS-61b4b7e9a3140', '2021-12-11', '100003', '3267', '0.00', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 02:48:05', '2021-12-11 14:48:05', '', 1),
(4, 'SRI-61b4bf0d82a74', 'SAL-61b4befb52412', 'CLT-6177cd6a673c3', 'CUS-61b4befb527e2', '2021-12-11', '100004', '766', '700.00', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 03:09:01', '2021-12-11 15:09:01', '', 1),
(5, 'SRI-620b8aee8ddbe', 'SAL-6208fafa77afa', 'CLT-6177cd6a673c3', 'CUS-6208fafa77ecb', '2022-02-15', '100011', '13490', '0.00', 'CID-6177cd6a673c3', '2022-02-15', '2022-02-14 23:13:50', '2022-02-15 11:13:50', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_items`
--

CREATE TABLE `sales_return_items` (
  `id` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `customer_id` varchar(50) NOT NULL,
  `sales_invoice_id` varchar(50) NOT NULL,
  `sales_invoice_no` varchar(50) NOT NULL,
  `sales_item_id` varchar(50) NOT NULL,
  `sales_return_item_id` varchar(50) NOT NULL,
  `sales_return_id` varchar(50) NOT NULL,
  `product_id` varchar(250) NOT NULL,
  `sales_return_quantity` varchar(50) NOT NULL,
  `sales_return_rate` varchar(100) NOT NULL,
  `sales_return_amount` varchar(50) NOT NULL,
  `sales_return_date` date NOT NULL,
  `sales_return_entry_by` varchar(100) NOT NULL,
  `sales_return_entry_date` date NOT NULL,
  `sales_return_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sales_return_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sales_return_updated_by` varchar(50) NOT NULL,
  `sales_return_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales_return_items`
--

INSERT INTO `sales_return_items` (`id`, `client_id`, `customer_id`, `sales_invoice_id`, `sales_invoice_no`, `sales_item_id`, `sales_return_item_id`, `sales_return_id`, `product_id`, `sales_return_quantity`, `sales_return_rate`, `sales_return_amount`, `sales_return_date`, `sales_return_entry_by`, `sales_return_entry_date`, `sales_return_created_at`, `sales_return_updated_at`, `sales_return_updated_by`, `sales_return_status`) VALUES
(1, 'CID-6177cd6a673c3', 'CUS-618626aa9e4f5', 'SAL-61aca496d9701', '100002', 'SII-61aca496d9ad1', 'PRII-61aca4e130291', 'SRI-61aca4e1243d5', 'pro-61a33e7d7102a', '1', '146.00', '146', '2021-12-05', 'CID-6177cd6a673c3', '2021-12-05', '2021-12-04 23:39:13', '2021-12-05 11:39:13', '', 1),
(2, 'CLT-6177cd6a673c3', 'CUS-61b4b7e9a3140', 'SAL-61b4b7e9a2d70', '100003', 'SII-61b4b7e9ae48b', 'PRII-61b4b8130a7d8', 'SRI-61b4b81301ab3', 'pro-61a33db303197', '1', '373.00', '373', '2021-12-11', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 02:39:15', '2021-12-11 14:39:15', '', 1),
(3, 'CLT-6177cd6a673c3', 'CUS-61b4b7e9a3140', 'SAL-61b4b7e9a2d70', '100003', 'SII-61b4b7e9ae48b', 'PRII-61b4ba24d09dc', 'SRI-61b4ba24c3fae', 'pro-61a33db303197', '9', '373.00', '3357', '2021-12-11', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 02:48:04', '2021-12-11 14:48:04', '', 1),
(4, 'CLT-6177cd6a673c3', 'CUS-61b4befb527e2', 'SAL-61b4befb52412', '100004', 'SII-61b4befb6f947', 'PRII-61b4bf0d8f872', 'SRI-61b4bf0d82a74', 'pro-61a33db303197', '2', '383.00', '766', '2021-12-11', 'CID-6177cd6a673c3', '2021-12-11', '2021-12-11 03:09:01', '2021-12-11 15:09:01', '', 1),
(5, 'CLT-6177cd6a673c3', 'CUS-6208fafa77ecb', 'SAL-6208fafa77afa', '100011', 'SII-6208fafa916f7', 'PRII-620b8aee96eb4', 'SRI-620b8aee8ddbe', 'pro-61a33fe91e848', '1', '13490.00', '13490', '2022-02-15', 'CID-6177cd6a673c3', '2022-02-15', '2022-02-14 23:13:50', '2022-02-15 11:13:50', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `setup_banks`
--

CREATE TABLE `setup_banks` (
  `id` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `bank_id` varchar(50) NOT NULL,
  `bank_name` varchar(250) NOT NULL,
  `bank_ac_name` varchar(250) NOT NULL,
  `bank_ac_number` varchar(250) NOT NULL,
  `bank_branch` varchar(250) NOT NULL,
  `bank_entry_by` varchar(100) NOT NULL,
  `bank_entry_date` date NOT NULL,
  `bank_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `bank_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `bank_updated_by` varchar(50) NOT NULL,
  `bank_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setup_banks`
--

INSERT INTO `setup_banks` (`id`, `client_id`, `bank_id`, `bank_name`, `bank_ac_name`, `bank_ac_number`, `bank_branch`, `bank_entry_by`, `bank_entry_date`, `bank_created_at`, `bank_updated_at`, `bank_updated_by`, `bank_status`) VALUES
(1, 'CLT-6177cd6a673c3', 'BNK-61b99903b30d6', 'DBBL', 'Faisal', '001', 'Malibagh', 'CID-6177cd6a673c3', '2021-12-15', '2021-12-14 19:28:03', '2021-12-14 19:29:43', 'CID-6177cd6a673c3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `setup_category`
--

CREATE TABLE `setup_category` (
  `id` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `product_category_id` varchar(50) NOT NULL,
  `product_category_parent` varchar(200) NOT NULL,
  `product_category_name` varchar(200) NOT NULL,
  `product_category_entry_by` varchar(100) NOT NULL,
  `product_category_entry_date` date NOT NULL,
  `product_category_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_category_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_category_updated_by` varchar(50) NOT NULL,
  `product_category_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setup_category`
--

INSERT INTO `setup_category` (`id`, `client_id`, `product_category_id`, `product_category_parent`, `product_category_name`, `product_category_entry_by`, `product_category_entry_date`, `product_category_created_at`, `product_category_updated_at`, `product_category_updated_by`, `product_category_status`) VALUES
(1, 'CLT-6177cd6a673c3', 'MCI-6182553b9357b', '', 'Car', 'CID-6177cd6a673c3', '2021-11-03', '2021-11-02 21:24:11', '2021-11-02 22:55:38', 'CID-6177cd6a673c3', 1),
(2, 'CLT-6177cd6a673c3', 'MCI-6182796ecc161', '', 'Mobile', 'CID-6177cd6a673c3', '2021-11-03', '2021-11-02 23:58:38', '2021-11-03 11:58:38', '', 1),
(3, 'CLT-6177cd6a673c3', 'PCI-61a33df12faf0', '', 'Earphones', 'CID-6177cd6a673c3', '2021-11-28', '2021-11-27 20:29:37', '2021-11-28 08:29:37', '', 1),
(4, 'CLT-6177cd6a673c3', 'PCI-61a33e8c6a55a', '', 'Watch ', 'CID-6177cd6a673c3', '2021-11-28', '2021-11-27 20:32:12', '2021-11-28 08:32:12', '', 1),
(5, 'CLT-6177cd6a673c3', 'PCI-61a33f9e26dcb', '', 'TV', 'CID-6177cd6a673c3', '2021-11-28', '2021-11-27 20:36:46', '2021-11-28 08:36:46', '', 1),
(6, 'CLT-6177cd6a673c3', 'PCI-61a34d18c69a4', '', 'Router', 'CID-6177cd6a673c3', '2021-11-28', '2021-11-27 21:34:16', '2021-11-28 09:34:16', '', 1),
(7, 'CLT-6215eaac6dac2', 'PCI-6215fa2e53354', '', 'test', 'CID-6215eaac6d6f2', '2022-02-23', '2022-02-22 21:11:10', '2022-02-23 09:11:10', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `setup_customers`
--

CREATE TABLE `setup_customers` (
  `Id` int(10) NOT NULL,
  `customer_id` varchar(30) NOT NULL,
  `customer_code` varchar(100) NOT NULL,
  `client_id` varchar(30) NOT NULL,
  `customer_name` varchar(80) NOT NULL,
  `customer_organization` varchar(100) NOT NULL,
  `customer_email` varchar(80) NOT NULL,
  `customer_address` varchar(100) NOT NULL,
  `customer_mobile` varchar(15) NOT NULL,
  `customer_telephone` varchar(16) NOT NULL,
  `customer_balance` varchar(200) NOT NULL,
  `customer_create_date` date NOT NULL,
  `customer_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_created_by` varchar(30) NOT NULL,
  `customer_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_updated_by` varchar(30) NOT NULL,
  `customer_order_status` tinyint(4) NOT NULL,
  `customer_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setup_customers`
--

INSERT INTO `setup_customers` (`Id`, `customer_id`, `customer_code`, `client_id`, `customer_name`, `customer_organization`, `customer_email`, `customer_address`, `customer_mobile`, `customer_telephone`, `customer_balance`, `customer_create_date`, `customer_updated_at`, `customer_created_by`, `customer_created_at`, `customer_updated_by`, `customer_order_status`, `customer_status`) VALUES
(1, 'CUS-618626aa9e4f5', '', 'CLT-6177cd6a673c3', 'Faisal', '', 'abc@ssdd.com', '', '111', '', '', '2021-11-06', '2021-11-14 22:08:38', 'CID-6177cd6a673c3', '2021-11-06 06:54:34', 'CID-6177cd6a673c3', 0, 1),
(3, 'CUS-618baf0830a32', '', 'CLT-6177cd6a673c3', 'Walking Customer', '', '', '', '016747475174', '', '', '2021-11-10', '2021-11-14 22:07:32', 'CID-6177cd6a673c3', '2021-11-09 23:37:44', 'CID-6177cd6a673c3', 0, 1),
(4, 'CUS-61a778bc4d3f6', '', 'CLT-6177cd6a673c3', 'Walking Customer', '', '', '', '1', '', '', '2021-12-01', '2021-12-01 13:29:32', 'CID-6177cd6a673c3', '2021-12-01 01:29:32', '', 0, 1),
(5, 'CUS-61ac68f4240a9', '', 'CLT-6177cd6a673c3', 'Walking Customer', '', '', '', '11113', '', '', '2021-12-05', '2021-12-04 19:23:47', 'CID-6177cd6a673c3', '2021-12-04 19:23:32', 'CID-6177cd6a673c3', 0, 1),
(6, 'CUS-61b4b7e9a3140', '', 'CLT-6177cd6a673c3', 'Walking Customer', '', '', '', '1', '', '', '2021-12-11', '2021-12-11 14:38:33', 'CID-6177cd6a673c3', '2021-12-11 02:38:33', '', 0, 1),
(7, 'CUS-61b4befb527e2', '', 'CLT-6177cd6a673c3', 'Walking Customer', '', '', '', '3333', '', '', '2021-12-11', '2021-12-11 15:08:43', 'CID-6177cd6a673c3', '2021-12-11 03:08:43', '', 0, 1),
(8, 'CUS-61d9483a58b11', '', 'CLT-6177cd6a673c3', 'Walking Customer', '', '', '', 'a', '', '', '2022-01-08', '2022-01-08 08:15:54', 'CID-6177cd6a673c3', '2022-01-07 20:15:54', '', 0, 1),
(9, 'CUS-61d95405872ef', '', 'CLT-6177cd6a673c3', 'Walking Customer', '', '', '', '222', '', '', '2022-01-08', '2022-01-07 21:06:40', 'CID-6177cd6a673c3', '2022-01-07 21:06:13', 'CID-6177cd6a673c3', 0, 1),
(10, 'CUS-61f7ae4522987', '', 'CLT-6177cd6a673c3', 'Walking Customer', '', '', '', 's', '', '', '2022-01-31', '2022-01-31 09:39:17', 'CID-6177cd6a673c3', '2022-01-30 21:39:17', '', 0, 1),
(11, 'CUS-6204f357f10a8', '', 'CLT-6177cd6a673c3', 'Walking Customer', '', '', '', '123', '', '', '2022-02-10', '2022-02-11 21:29:34', 'CID-6177cd6a673c3', '2022-02-09 23:13:27', 'CID-6177cd6a673c3', 0, 1),
(12, 'CUS-6207992daa3b1', '', 'CLT-6177cd6a673c3', 'Walking Customer', '', '', '', '1', '', '', '2022-02-12', '2022-02-11 23:26:20', 'CID-6177cd6a673c3', '2022-02-11 23:25:33', 'CID-6177cd6a673c3', 0, 1),
(13, 'CUS-6208fafa77ecb', '', 'CLT-6177cd6a673c3', 'Walking Customer', '', '', '', '1', '', '', '2022-02-13', '2022-02-13 12:35:06', 'CID-6177cd6a673c3', '2022-02-13 00:35:06', '', 0, 1),
(14, 'CUS-620c89ff907b4', '', 'CLT-6177cd6a673c3', 'Walking Customer', '', '', '', '1', '', '', '2022-02-16', '2022-02-16 05:22:07', 'CID-6177cd6a673c3', '2022-02-16 05:22:07', '', 0, 1),
(15, 'CUS-621631aa2dc6c', '', 'CLT-6177cd6a673c3', 'Walking Customer', '', '', '', '1', '', '', '2022-02-23', '2022-02-23 13:07:54', 'CID-6177cd6a673c3', '2022-02-23 01:07:54', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `setup_expense_heads`
--

CREATE TABLE `setup_expense_heads` (
  `id` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `expense_head_id` varchar(50) NOT NULL,
  `expense_head_name` varchar(200) NOT NULL,
  `expense_head_entry_by` varchar(100) NOT NULL,
  `expense_head_entry_date` date NOT NULL,
  `expense_head_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expense_head_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expense_head_updated_by` varchar(50) NOT NULL,
  `expense_head_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setup_expense_heads`
--

INSERT INTO `setup_expense_heads` (`id`, `client_id`, `expense_head_id`, `expense_head_name`, `expense_head_entry_by`, `expense_head_entry_date`, `expense_head_created_at`, `expense_head_updated_at`, `expense_head_updated_by`, `expense_head_status`) VALUES
(1, 'CLT-6177cd6a673c3', 'BAR-61c2eba23473b', 'Refreshment1', 'CID-6177cd6a673c3', '2021-12-22', '2021-12-21 21:10:58', '2021-12-21 21:11:15', 'CID-6177cd6a673c3', 1),
(2, 'CLT-6177cd6a673c3', 'BAR-61c2eba83ccbf', 'Salary', 'CID-6177cd6a673c3', '2021-12-22', '2021-12-21 21:11:04', '2021-12-22 09:11:04', '', 1),
(3, 'CLT-6177cd6a673c3', 'BAR-61d943313b5dc', 'Office', 'CID-6177cd6a673c3', '2022-01-08', '2022-01-07 19:54:25', '2022-01-07 19:54:51', 'CID-6177cd6a673c3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `setup_expense_types`
--

CREATE TABLE `setup_expense_types` (
  `id` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `expense_type_id` varchar(50) NOT NULL,
  `expense_type_name` varchar(200) NOT NULL,
  `expense_type_entry_by` varchar(100) NOT NULL,
  `expense_type_entry_date` date NOT NULL,
  `expense_type_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expense_type_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expense_type_updated_by` varchar(50) NOT NULL,
  `expense_type_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `setup_locations`
--

CREATE TABLE `setup_locations` (
  `id` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `location_id` varchar(50) NOT NULL,
  `location_name` varchar(200) NOT NULL,
  `location_entry_by` varchar(100) NOT NULL,
  `location_entry_date` date NOT NULL,
  `location_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `location_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `location_updated_by` varchar(50) NOT NULL,
  `location_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `setup_manufacturer`
--

CREATE TABLE `setup_manufacturer` (
  `id` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `man_id` varchar(50) NOT NULL,
  `man_name` varchar(100) NOT NULL,
  `man_email` varchar(100) NOT NULL,
  `man_mobile` varchar(200) NOT NULL,
  `man_phone` varchar(200) NOT NULL,
  `man_address` varchar(250) NOT NULL,
  `man_entry_by` varchar(100) NOT NULL,
  `man_entry_date` date NOT NULL,
  `man_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `man_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `man_updated_by` varchar(50) NOT NULL,
  `man_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setup_manufacturer`
--

INSERT INTO `setup_manufacturer` (`id`, `client_id`, `man_id`, `man_name`, `man_email`, `man_mobile`, `man_phone`, `man_address`, `man_entry_by`, `man_entry_date`, `man_created_at`, `man_updated_at`, `man_updated_by`, `man_status`) VALUES
(1, 'CLT-6177cd6a673c3', 'MAN-6182646ccd844', 'Samsung', '', '1', '', '', 'CID-6177cd6a673c3', '2021-11-03', '2021-11-02 22:29:00', '2021-11-02 23:01:13', 'CID-6177cd6a673c3', 1),
(2, 'CLT-6177cd6a673c3', 'MAN-61a34d9a0ec82', 'Tenda', '', '', '', '', 'CID-6177cd6a673c3', '2021-11-28', '2021-11-27 21:36:26', '2021-11-28 09:36:26', '', 1),
(3, 'CLT-6177cd6a673c3', 'MAN-61a34da58c30a', 'SONY', '', '', '', '', 'CID-6177cd6a673c3', '2021-11-28', '2021-11-27 21:36:37', '2021-11-27 21:35:54', 'CID-6177cd6a673c3', 1),
(4, 'CLT-6177cd6a673c3', 'MAN-61a34dae58b11', 'Titan', '', '', '', '', 'CID-6177cd6a673c3', '2021-11-28', '2021-11-27 21:36:46', '2021-11-28 09:36:46', '', 1),
(5, 'CLT-6215eaac6dac2', 'MAN-6215fa42bf733', 'test', '', '', '', '', 'CID-6215eaac6d6f2', '2022-02-23', '2022-02-22 21:11:30', '2022-02-23 09:11:30', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `setup_supplier`
--

CREATE TABLE `setup_supplier` (
  `id` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `supplier_id` varchar(50) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `supplier_email` varchar(100) NOT NULL,
  `supplier_mobile` varchar(50) NOT NULL,
  `supplier_address` varchar(250) NOT NULL,
  `supplier_balance` varchar(200) NOT NULL,
  `supplier_entry_by` varchar(100) NOT NULL,
  `supplier_entry_date` date NOT NULL,
  `supplier_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `supplier_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `supplier_updated_by` varchar(50) NOT NULL,
  `supplier_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setup_supplier`
--

INSERT INTO `setup_supplier` (`id`, `client_id`, `supplier_id`, `supplier_name`, `supplier_email`, `supplier_mobile`, `supplier_address`, `supplier_balance`, `supplier_entry_by`, `supplier_entry_date`, `supplier_created_at`, `supplier_updated_at`, `supplier_updated_by`, `supplier_status`) VALUES
(1, 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', 'hasan', '', '12', 'dhaka', '', 'CID-6177cd6a673c3', '2021-11-06', '2021-11-05 19:05:17', '2021-11-05 19:05:32', 'CID-6177cd6a673c3', 1),
(2, 'CLT-6177cd6a673c3', 'MAN-61dc1ef3700e8', 'test', 'a@aa.aa1', '1', 'd', '15000', 'CID-6177cd6a673c3', '2022-01-10', '2022-01-09 23:56:35', '2022-01-10 11:56:35', '', 1),
(3, 'CLT-6177cd6a673c3', 'MAN-61f24dd5352ad', 'a', '', '1', '', '10000', 'CID-6177cd6a673c3', '2022-01-27', '2022-01-26 19:46:29', '2022-01-26 19:54:51', 'CID-6177cd6a673c3', 1),
(4, 'CLT-6177cd6a673c3', 'MAN-61f24fd272eaf', 'b', '', '', '', '', 'CID-6177cd6a673c3', '2022-01-27', '2022-01-26 19:54:58', '2022-01-27 07:54:58', '', 1),
(5, 'CLT-6215eaac6dac2', 'MAN-6215fa5b717cb', 'test', '', '', '', '', 'CID-6215eaac6d6f2', '2022-02-23', '2022-02-22 21:11:55', '2022-02-23 09:11:55', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `setup_units`
--

CREATE TABLE `setup_units` (
  `id` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `unit_id` varchar(50) NOT NULL,
  `unit_name` varchar(200) NOT NULL,
  `unit_entry_by` varchar(100) NOT NULL,
  `unit_entry_date` date NOT NULL,
  `unit_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `unit_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `unit_updated_by` varchar(50) NOT NULL,
  `unit_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setup_units`
--

INSERT INTO `setup_units` (`id`, `client_id`, `unit_id`, `unit_name`, `unit_entry_by`, `unit_entry_date`, `unit_created_at`, `unit_updated_at`, `unit_updated_by`, `unit_status`) VALUES
(1, 'CLT-6177cd6a673c3', 'BAR-61825a94872ee', 'piece', 'CID-6177cd6a673c3', '2021-11-03', '2021-11-02 21:47:00', '2021-11-03 00:44:15', 'CID-6177cd6a673c3', 1),
(2, 'CLT-6177cd6a673c3', 'BAR-61825b4fdc0f7', 'pear', 'CID-6177cd6a673c3', '2021-11-03', '2021-11-02 21:50:07', '2021-11-02 21:54:06', 'CID-6177cd6a673c3', 1),
(3, 'CLT-6177cd6a673c3', 'BAR-61825c21c380d', 'kg', 'CID-6177cd6a673c3', '2021-11-03', '2021-11-02 21:53:37', '2021-11-02 21:53:50', 'CID-6177cd6a673c3', 1),
(4, 'CLT-6177cd6a673c3', 'BAR-61825c48e18b4', 'g', 'CID-6177cd6a673c3', '2021-11-03', '2021-11-02 21:54:16', '2021-11-03 09:54:16', '', 1),
(5, 'CLT-6177cd6a673c3', 'BAR-61825c500e8b2', 'lbs', 'CID-6177cd6a673c3', '2021-11-03', '2021-11-02 21:54:24', '2021-11-03 09:54:24', '', 1),
(6, 'CLT-6177cd6a673c3', 'BAR-61825c550501b', 'oz', 'CID-6177cd6a673c3', '2021-11-03', '2021-11-02 21:54:29', '2021-11-03 09:54:29', '', 1),
(7, 'CLT-6177cd6a673c3', 'BAR-61825c5b32116', 'in', 'CID-6177cd6a673c3', '2021-11-03', '2021-11-02 21:54:35', '2021-11-03 09:54:35', '', 1),
(8, 'CLT-6177cd6a673c3', 'BAR-61825c6089544', 'm', 'CID-6177cd6a673c3', '2021-11-03', '2021-11-02 21:54:40', '2021-11-03 09:54:40', '', 1),
(9, 'CLT-6177cd6a673c3', 'BAR-61825c65e3ed9', 'cm', 'CID-6177cd6a673c3', '2021-11-03', '2021-11-02 21:54:45', '2021-11-03 09:54:45', '', 1),
(10, 'CLT-6177cd6a673c3', 'BAR-61825c6b30a32', 'mm', 'CID-6177cd6a673c3', '2021-11-03', '2021-11-02 21:54:51', '2021-11-03 09:54:51', '', 1),
(11, 'CLT-6177cd6a673c3', 'BAR-61825c711b2e0', 'yd', 'CID-6177cd6a673c3', '2021-11-03', '2021-11-02 21:54:57', '2021-11-03 09:54:57', '', 1),
(12, 'CLT-6177cd6a673c3', 'BAR-61825c83c5691', 'box', 'CID-6177cd6a673c3', '2021-11-03', '2021-11-02 21:55:15', '2021-11-02 22:58:53', 'CID-6177cd6a673c3', 1),
(13, 'CLT-6177cd6a673c3', 'BAR-61825c94e9e37', 'packet', 'CID-6177cd6a673c3', '2021-11-03', '2021-11-02 21:55:32', '2021-11-03 09:55:32', '', 1),
(14, 'CLT-6215eaac6dac2', 'BAR-6215fa3abe7f1', 'test', 'CID-6215eaac6d6f2', '2022-02-23', '2022-02-22 21:11:22', '2022-02-23 09:11:22', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_payment`
--

CREATE TABLE `supplier_payment` (
  `id` int(11) NOT NULL,
  `supplier_payment_id` varchar(50) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `supplier_id` varchar(30) NOT NULL,
  `supplier_payment_date` date NOT NULL,
  `supplier_payment_amount` varchar(50) NOT NULL,
  `supplier_payment_entry_by` varchar(100) NOT NULL,
  `supplier_payment_entry_date` date NOT NULL,
  `supplier_payment_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `supplier_payment_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `supplier_payment_updated_by` varchar(50) NOT NULL,
  `supplier_payment_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplier_payment`
--

INSERT INTO `supplier_payment` (`id`, `supplier_payment_id`, `client_id`, `supplier_id`, `supplier_payment_date`, `supplier_payment_amount`, `supplier_payment_entry_by`, `supplier_payment_entry_date`, `supplier_payment_created_at`, `supplier_payment_updated_at`, `supplier_payment_updated_by`, `supplier_payment_status`) VALUES
(1, 'SPI-620c9dd0094c6', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2022-02-16', '1500.00', 'CID-6177cd6a673c3', '2022-02-16', '2022-02-16 06:46:40', '2022-02-16 06:46:40', '', 1),
(2, 'SPI-620ca4b50d970', 'CLT-6177cd6a673c3', 'MAN-6186292d839b6', '2022-02-16', '50.00', 'CID-6177cd6a673c3', '2022-02-16', '2022-02-15 19:16:05', '2022-02-16 07:16:05', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `client_code` varchar(50) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_designation` varchar(100) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `user_entry_by` varchar(30) NOT NULL,
  `user_entry_date` date NOT NULL,
  `user_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_updated_by` varchar(30) NOT NULL,
  `user_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `client_code`, `user_name`, `user_designation`, `user_email`, `user_password`, `user_type`, `user_entry_by`, `user_entry_date`, `user_created_at`, `user_updated_at`, `user_updated_by`, `user_status`) VALUES
(1, '001', '', 'Md. Asaduzzaman Sikder', 'Administrator', 'superadmin', '35ecdc960ef4241244f51c126675b19e', 'Super Admin', '', '2018-04-18', '2018-04-18 05:30:00', '2021-12-13 13:54:22', '001', 1),
(8, 'CID-6177cd6a673c3', 'CLT-6177cd6a673c3', 'Demo', 'Client', 'demo@sysdevltd.com', '863b7c2add41572e679e556a114ecbea', 'Client', '001', '2021-10-26', '2021-10-25 21:42:02', '2021-10-26 10:49:43', 'CID-6177cd6a673c3', 1),
(9, 'CID-61b621d225317', 'CLT-61b621d225ab8', 'Demo1', 'Client', 'demo11@sysdevltd.com', '8d22d6d498d0105c8fd1dbf87b02d4ab', 'Client', '001', '2021-12-12', '2021-12-12 04:22:42', '2021-12-13 01:59:08', '001', 1),
(10, 'CID-6215eaac6d6f2', 'CLT-6215eaac6dac2', 'Demo2', 'Client', 'demo2@sysdevltd.com', '2de001df54d0c547f8b992f7853e0169', 'Client', '001', '2022-02-23', '2022-02-22 20:05:00', '2022-02-22 20:05:19', '001', 1),
(11, '102', '102', 'Admin', 'Admin', 'adminuser', '4f5cec75c744bd39b5126debbb7cffb8', 'Admin', '', '0000-00-00', '2022-02-23 13:20:10', '2022-02-23 13:20:10', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vendor_package`
--

CREATE TABLE `vendor_package` (
  `id` int(10) NOT NULL,
  `package_id` varchar(30) NOT NULL,
  `package_name` varchar(100) NOT NULL,
  `package_price` text NOT NULL,
  `package_unit` varchar(100) NOT NULL,
  `package_entry_by` varchar(30) NOT NULL,
  `package_entry_date` date NOT NULL,
  `package_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `package_updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `package_updated_by` varchar(30) NOT NULL,
  `package_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vendor_package`
--

INSERT INTO `vendor_package` (`id`, `package_id`, `package_name`, `package_price`, `package_unit`, `package_entry_by`, `package_entry_date`, `package_created_at`, `package_updated_at`, `package_updated_by`, `package_status`) VALUES
(1, 'VPI-6177c9581dcd6', 'Monthly', '2000', 'Bill', '001', '2021-10-26', '2021-10-25 21:24:40', '0000-00-00 00:00:00', '', 1),
(2, 'VPI-61b613a4a9fe1', 'Weekly', '500', 'Bill', '001', '2021-12-12', '2021-12-12 15:22:33', '2021-12-12 03:22:33', '001', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_ledger`
--
ALTER TABLE `bank_ledger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_payment`
--
ALTER TABLE `customer_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_ledger`
--
ALTER TABLE `expense_ledger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_stock`
--
ALTER TABLE `inventory_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_stock_history`
--
ALTER TABLE `inventory_stock_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_invoice`
--
ALTER TABLE `purchase_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_payment`
--
ALTER TABLE `purchase_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_return_invoice`
--
ALTER TABLE `purchase_return_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_return_item`
--
ALTER TABLE `purchase_return_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_invoice`
--
ALTER TABLE `sales_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_items`
--
ALTER TABLE `sales_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_payment`
--
ALTER TABLE `sales_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_return_invoice`
--
ALTER TABLE `sales_return_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_return_items`
--
ALTER TABLE `sales_return_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setup_banks`
--
ALTER TABLE `setup_banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setup_category`
--
ALTER TABLE `setup_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setup_customers`
--
ALTER TABLE `setup_customers`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `setup_expense_heads`
--
ALTER TABLE `setup_expense_heads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setup_expense_types`
--
ALTER TABLE `setup_expense_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setup_locations`
--
ALTER TABLE `setup_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setup_manufacturer`
--
ALTER TABLE `setup_manufacturer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setup_supplier`
--
ALTER TABLE `setup_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setup_units`
--
ALTER TABLE `setup_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_payment`
--
ALTER TABLE `supplier_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_package`
--
ALTER TABLE `vendor_package`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_ledger`
--
ALTER TABLE `bank_ledger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer_payment`
--
ALTER TABLE `customer_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expense_ledger`
--
ALTER TABLE `expense_ledger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inventory_stock`
--
ALTER TABLE `inventory_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inventory_stock_history`
--
ALTER TABLE `inventory_stock_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `purchase_invoice`
--
ALTER TABLE `purchase_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `purchase_payment`
--
ALTER TABLE `purchase_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `purchase_return_invoice`
--
ALTER TABLE `purchase_return_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchase_return_item`
--
ALTER TABLE `purchase_return_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sales_invoice`
--
ALTER TABLE `sales_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sales_items`
--
ALTER TABLE `sales_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sales_payment`
--
ALTER TABLE `sales_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `sales_return_invoice`
--
ALTER TABLE `sales_return_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales_return_items`
--
ALTER TABLE `sales_return_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `setup_banks`
--
ALTER TABLE `setup_banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setup_category`
--
ALTER TABLE `setup_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `setup_customers`
--
ALTER TABLE `setup_customers`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `setup_expense_heads`
--
ALTER TABLE `setup_expense_heads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `setup_expense_types`
--
ALTER TABLE `setup_expense_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setup_locations`
--
ALTER TABLE `setup_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setup_manufacturer`
--
ALTER TABLE `setup_manufacturer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `setup_supplier`
--
ALTER TABLE `setup_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `setup_units`
--
ALTER TABLE `setup_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `supplier_payment`
--
ALTER TABLE `supplier_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vendor_package`
--
ALTER TABLE `vendor_package`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
