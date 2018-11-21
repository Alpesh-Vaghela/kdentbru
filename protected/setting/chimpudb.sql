-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2016 at 09:50 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lok_account`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'accounts are like income,other_income,expense,cost_of_good-sold,other_expense,current_asset,non_current_asset,fixed_assets,accounts_receivable,bank,other_non_current_asset,credit_card,other_current_liability,equity,non-current_liability,account_receivable,account_payble',
  `nature` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nature like: Income, Expense, Assets Liability ,  Equity and 6 for COGS',
  `account_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `export_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sub_account_of` int(11) NOT NULL,
  `default_tax_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visibility_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_opening_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ibt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `financial_institute` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_holder_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bsb` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `apca` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `opening_balance` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `current_balance` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `last_reconciliation_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `last_reconciliation_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=40 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_name`, `account_type`, `nature`, `account_code`, `export_code`, `account_description`, `sub_account_of`, `default_tax_code`, `visibility_status`, `account_opening_date`, `ibt`, `created_date`, `ip_address`, `timestamp`, `financial_institute`, `account_holder_name`, `bsb`, `account_number`, `apca`, `opening_balance`, `current_balance`, `last_reconciliation_amount`, `last_reconciliation_date`) VALUES
(1, 'Income', 'income', 'income', '4-0000', '', 'Income', 0, '2', 'active', '', '', '2016-09-01', '182.64.132.9', '2016-09-01 12:16:57', '', '', '', '', '', '0', '0', '0', ''),
(2, 'Consulting Revenue', 'income', 'income', '', '', '', 0, '1', 'active', '', '', '2016-07-04', '122.162.208.124', '2016-08-05 12:20:13', '', '', '', '', '', '0', '0', '0', ''),
(4, 'Other Fees and Charges ', 'income', 'income', '4-4040', '', 'Other Fees and Charges ', 0, '1', 'active', '', '', '2016-07-04', '122.162.208.124', '2016-09-10 12:33:24', '', '', '', '', '', '0', '0', '0', ''),
(5, 'Assets', 'current_asset', 'assets', '1-0000', '', 'Assets', 0, '1', 'active', '', '', '2016-07-04', '122.162.208.124', '2016-08-05 12:20:19', '', '', '', '', '', '0', '0', '0', ''),
(6, 'GST Payable', 'other_current_liability', 'liabilities', '2-1150', '895', 'GST Payable', 0, '2', 'active', '', '', '2016-07-04', '122.162.208.124', '2016-08-05 12:20:21', '', '', '', '', '', '0', '0', '0', ''),
(7, 'Meals', 'expense', 'expense', '', '', 'Meals for work trips', 0, '1', 'active', '', '', '2016-07-04', '122.162.208.124', '2016-08-05 12:20:23', '', '', '', '', '', '0', '0', '0', ''),
(8, 'Current Assets', 'current_asset', 'assets', '1-1100', '', 'Current Assets', 0, '1', 'active', '', '', '2016-07-04', '122.162.208.124', '2016-08-05 12:20:25', '', '', '', '', '', '0', '0', '0', ''),
(10, 'Accounting Fees', 'expense', 'expense', '6-0010', '300', 'Accounting Fees', 0, '1', 'active', '', '', '2016-07-04', '122.162.208.124', '2016-09-01 12:10:58', '', '', '', '', '', '0', '0', '0', ''),
(11, 'Undeposited Funds', 'current_asset', 'assets', '1-1160', '1-1160', 'Undeposited Funds', 0, '1', 'active', '', '', '2016-08-31', '182.64.72.187', '2016-08-31 12:59:00', '', '', '', '', '', '0', '0', '0', ''),
(12, 'Bank - NAB Business Credit Card', 'bank', 'liabilities', '', '', 'System account for bank account ''NAB Business Credit Card''', 0, '1', 'active', '03-08-2016', '', '2016-08-31', '182.64.72.187', '2016-09-10 09:02:14', '', '', '', '', '', '0', '0', '0', ''),
(13, 'Assets Purchased <$5,000', 'expense', 'expense', '6-0040', '', 'Assets Purchased <$5,000', 0, '1', 'active', '', '', '2016-07-04', '122.162.208.124', '2016-08-05 12:20:35', '', '', '', '', '', '0', '0', '0', ''),
(14, 'Current Financial Assets', 'current_asset', 'assets', '1-1200', '', 'Current Financial Assets', 0, '1', 'active', '', '', '2016-07-04', '122.162.208.124', '2016-08-29 09:37:53', '', '', '', '', '', '0', '0', '0', ''),
(15, 'Opening Balance Equity', 'equity', 'equity', '3-0100', '30000', 'Opening Balance Equity', 0, '1', 'active', '', '', '2016-07-04', '122.162.208.124', '2016-08-05 12:20:39', '', '', '', '', '', '0', '0', '0', ''),
(16, 'Bank - ANZ', 'bank', 'assets', '', '680', 'System account for bank account ''ANZ''', 0, '1', 'active', '', 'ibt', '2016-09-02', '182.64.157.57', '2016-09-10 12:06:35', '1', 'durgesh666666', 'BSB-1666666', '6666666', 'apca-6666666', '0', '0', '0', ''),
(17, 'GST Collected', 'other_current_liability', 'liabilities', '2-1155', '895.00', 'GST Collected', 0, '1', 'active', '', '', '2016-07-04', '122.162.208.124', '2016-09-10 12:15:38', '', '', '', '', '', '0', '0', '0', ''),
(18, 'Retained Earnings Surplus/(Accumulated Losses)', 'equity', 'equity', '3-1000', '638', 'Retained Earnings Surplus/(Accumulated Losses)', 0, '1', 'active', '', '', '2016-07-04', '122.162.208.124', '2016-08-05 12:20:45', '', '', '', '', '', '0', '0', '0', ''),
(19, 'Drawings', 'equity', 'equity', '', '', '', 0, '1', 'active', '', '', '2016-07-04', '122.162.208.124', '2016-08-05 12:20:47', '', '', '', '', '', '0', '0', '0', ''),
(20, 'Bank - NAB Business Account', 'bank', 'assets', '', '680', 'System account for bank account ''NAB Business Account''', 0, '1', 'active', '', '', '2016-07-04', '122.162.208.124', '2016-09-10 12:06:39', '', '', '', '', '', '0', '0', '0', ''),
(21, 'GST Paid', 'other_current_liability', 'liabilities', '2-1160', '895.99', 'GST Paid', 0, '1', 'active', '', '', '2016-07-04', '122.162.208.124', '2016-09-10 12:21:07', '', '', '', '', '', '0', '0', '0', ''),
(22, 'Sales', 'income', 'income', '4-4010', '230', 'Sales', 0, '1', 'active', '', '', '2016-07-04', '122.162.208.124', '2016-09-01 12:10:58', '', '', '', '', '', '0', '0', '0', ''),
(23, 'Cost of Goods Sold', 'expense', 'expense', '', '', '', 0, '1', 'active', '', '', '2016-07-04', '122.162.208.124', '2016-09-10 12:21:07', '', '', '', '', '', '0', '0', '0', ''),
(25, 'Other Income', 'income', 'income', '4-5000', '', 'Other Income ', 0, '1', 'active', '', '', '2016-07-05', '182.64.89.222', '2016-08-05 12:21:00', '', '', '', '', '', '0', '0', '0', ''),
(32, 'tea expence', 'expense', 'expense', 'acc202', '', 'tea expence', 0, '1', 'active', '', '', '2016-07-05', '182.64.89.222', '2016-08-05 12:21:02', '', '', '', '', '', '0', '0', '0', ''),
(34, 'anthew check', 'fixed_asset', 'assets', '0001A-A', '0001B-B', 'It is to check account', 0, '4', 'active', '', '', '2016-07-07', '110.227.145.4', '2016-08-05 12:21:05', '', '', '', '', '', '0', '0', '0', ''),
(36, 'Trade debtors', 'current_asset', 'assets', '1-3100', '1-3100', 'Trade debtors', 0, '20', 'active', '', '', '2016-07-08', '182.77.38.240', '2016-09-10 12:24:26', '', '', '', '', '', '0', '0', '0', ''),
(37, 'Trade Creditors', 'other_current_liability', 'liabilities', '2-2100', '2-2100', 'Trade Creditors', 0, '20', 'active', '', '', '2016-07-08', '182.77.38.240', '2016-09-10 12:33:24', '', '', '', '', '', '0', '0', '0', ''),
(38, 'Companinon', 'non-current_liability', 'liabilities', 'asdfasdf', 'asdfasdfasdf', 'asdfasdf', 0, '', 'active', '', '', '2016-08-30', '182.64.177.2', '2016-08-30 08:21:00', '', '', '', '', '', '0', '0', '0', ''),
(39, 'Bank - CDS', 'income', 'income', '03444131000', '', '', 0, '', 'active', '', '', '2016-09-01', '182.64.132.9', '2016-09-01 12:16:34', '', '', '', '', '', '0', '0', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `account_transaction`
--

CREATE TABLE IF NOT EXISTS `account_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tax_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `balance` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'like:debit or creadit',
  `transaction_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reconcile` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no' COMMENT 'reconcile like :yes or no',
  `generated_from` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `generated_from_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event` text COLLATE utf8_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `assign_customer_project`
--

CREATE TABLE IF NOT EXISTS `assign_customer_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `customer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `weighting` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `visibility_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'active or inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `assign_item_project`
--

CREATE TABLE IF NOT EXISTS `assign_item_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `regular_rate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_rate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `assign_supplier_project`
--

CREATE TABLE IF NOT EXISTS `assign_supplier_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `supplier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `weighting` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `visibility_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'active or inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bank_statement`
--

CREATE TABLE IF NOT EXISTS `bank_statement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'like:debit or creadit',
  `withdrawals` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'debit',
  `deposits` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'credit',
  `created_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE IF NOT EXISTS `bills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL,
  `bill_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'status like: draft,approved,overdue,paid',
  `bill_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `due_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reference_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amounts` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Amounts like->Nontaxed,Gross(Tax inclusive),Net(Tax Enclusive)',
  `bill_discount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `item_qty` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `taxcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `visibility_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `balance_remaining` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paid_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gst_registered` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `buying_make_payment`
--

CREATE TABLE IF NOT EXISTS `buying_make_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bank_account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `use_transaction_total` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `allocation_notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visibility_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_qty` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `taxcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_customer` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `is_supplier` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `is_superfund` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `contact_is` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `business_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'first name',
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'last name',
  `company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `branch` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `business_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visibility_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `istpr` int(11) NOT NULL,
  `phone_pre_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_pre_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fax_pre_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fax_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `office_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hp_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal_address_is` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal_address_town` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal_address_suburb` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal_address_state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal_address_postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `physical_address_is` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `physical_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `physical_address_town` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `physical_address_suburb` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `physical_address_state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `physical_address_postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_adjustment_notes`
--

CREATE TABLE IF NOT EXISTS `customer_adjustment_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `adjustment_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'like debit or credit',
  `adjustment_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'status like: draft,approved,overdue,paid',
  `adjustment_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reference_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amounts` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'amounts like:Non taxed,Gross (Tax inclusive),Net (Tax Enclusive)',
  `project_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `item_qty` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `taxcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `visibility_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `balance_remaining` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paid_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gst_registered` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `daytoday_report_settings`
--

CREATE TABLE IF NOT EXISTS `daytoday_report_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `selling_approval` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `estimate_prefix` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `estimate_default_template` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `estimate_expiry` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `estimate_term_condition` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `estimate_payment_notes` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `invoice_prefix` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `invoice_default_template` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `invoice_payment_details` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `can_prefix` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `buying_approval` varchar(255) NOT NULL,
  `bill_prefix` varchar(255) NOT NULL,
  `san_prefix` varchar(255) NOT NULL,
  `report_basis` varchar(255) NOT NULL,
  `ageing_report` varchar(255) NOT NULL,
  `estimate_start_from` int(11) NOT NULL DEFAULT '0',
  `invoice_start_from` int(11) NOT NULL DEFAULT '0',
  `can_start_from` int(11) NOT NULL DEFAULT '0',
  `bill_start_from` int(11) NOT NULL DEFAULT '0',
  `san_start_from` int(11) NOT NULL DEFAULT '0',
  `journal_start_from` int(11) NOT NULL DEFAULT '0',
  `journal_prefix` varchar(255) NOT NULL DEFAULT 'GJ',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `daytoday_report_settings`
--

INSERT INTO `daytoday_report_settings` (`id`, `selling_approval`, `estimate_prefix`, `estimate_default_template`, `estimate_expiry`, `estimate_term_condition`, `estimate_payment_notes`, `invoice_prefix`, `invoice_default_template`, `invoice_payment_details`, `can_prefix`, `buying_approval`, `bill_prefix`, `san_prefix`, `report_basis`, `ageing_report`, `estimate_start_from`, `invoice_start_from`, `can_start_from`, `bill_start_from`, `san_start_from`, `journal_start_from`, `journal_prefix`) VALUES
(1, 'enabled', 'QUOTATION', '', '25', 'I had to agree to the terms and conditions of the site before I joined because there were a lot of policies I had to abide by.\r\n', 'A promissory note is a legal instrument (more particularly, a financial instrument), in which one party (the maker or issuer) promises in writing to pay a determinate sum of money to the other (the payee), either at a fixed or determinable future time or ', 'INV', '', 'A promissory note is a legal instrument (more particularly, a financial instrument), in which one party (the maker or issuer) promises in writing to pay a determinate sum of money to the other (the payee), either at a fixed or determinable future time or ', 'CAN', 'enabled', 'BILL', 'SAN', 'cash_basis', 'transaction_date', 5, 2, 1, 1, 1, 9, 'GJ');

-- --------------------------------------------------------

--
-- Table structure for table `estimates`
--

CREATE TABLE IF NOT EXISTS `estimates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `estimate_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `estimate_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expiry_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reference_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amounts` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'amounts like:Non taxed,Gross (Tax inclusive),Net (Tax Enclusive)',
  `project_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `item_qty` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_total` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `markup` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `taxcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `visibility_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'like:active or inactive',
  `notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gst_registered` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'like:yes or no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'status like: draft,approved,overdue,paid',
  `invoice_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `due_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reference_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amounts` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'amounts like:Non taxed,Gross (Tax inclusive),Net (Tax Enclusive)',
  `invoice_discount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `item_qty` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `taxcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `visibility_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `balance_remaining` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paid_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unpaid' COMMENT 'payment status like paid and unpaid',
  `gst_registered` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'like:yes or no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `iras_gst_codes`
--

CREATE TABLE IF NOT EXISTS `iras_gst_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `purpose` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `iras_gst_codes`
--

INSERT INTO `iras_gst_codes` (`id`, `code`, `purpose`, `description`, `create_date`, `ip_address`, `timestamp`) VALUES
(1, 'BL', 'purchase', 'GST incurred( not claimable -REG-26/27)', '2016-07-07', '110.227.145.4', '2016-07-07 09:22:11'),
(2, 'DS', 'supply', 'Deemed supplier(Supplies to be reported under the GST legislation)', '2016-07-07', '110.227.145.4', '2016-07-13 08:39:22'),
(3, 'EP', 'purchase', 'Purchase exempted from GST', '2016-07-07', '110.227.145.4', '2016-07-07 09:23:31'),
(4, 'ES33', 'supply', 'Regulation 33 Exempt Supplier', '2016-07-07', '110.227.145.4', '2016-07-07 09:24:34'),
(5, 'ESN33', 'supply', 'Non  Regulation 33 Exempt Supplies', '2016-07-07', '110.227.145.4', '2016-07-07 09:25:19'),
(6, 'IGDS', 'purchase', 'Import under the import GST deferment scheme', '2016-07-07', '110.227.145.4', '2016-07-07 09:26:30'),
(7, 'IM', 'purchase', 'GST incurred for import of goods', '2016-07-07', '110.227.145.4', '2016-07-07 09:27:38'),
(8, 'ME', 'purchase', 'Import under under special scheme(no GST incurred)', '2016-07-07', '110.227.145.4', '2016-07-07 09:29:26'),
(10, 'NR', 'purchase', 'purchase from Non GST-registed supplier', '2016-07-07', '110.227.145.4', '2016-07-07 09:32:56'),
(11, 'OP', 'purchase', 'Out of the scope of GST legislation(Purchases outside the scope of the GST Act)', '2016-07-07', '110.227.145.4', '2016-07-13 08:41:15'),
(12, 'OS', 'supply', 'Out-of-scope supplier(Supplies outside the scope of the GST Act)', '2016-07-07', '110.227.145.4', '2016-07-13 08:40:38'),
(13, 'SR', 'supply', 'Standard-rated supplies with GST charged(local supply of goods and services)', '2016-07-07', '110.227.145.4', '2016-07-13 08:37:34'),
(14, 'TX-ESS', 'purchase', 'GST incurred(Reg-33 exempt supplies)', '2016-07-07', '110.227.145.4', '2016-07-16 12:15:29'),
(15, 'TX-N33', 'purchase', 'GST incurred(Non-Reg-33 exempt supplies)', '2016-07-07', '110.227.145.4', '2016-07-08 08:39:50'),
(16, 'TX-RE', 'purchase', 'GST not attributable to taxable or exempt supplies', '2016-07-07', '110.227.145.4', '2016-07-07 09:38:42'),
(17, 'TX', 'purchase', 'Purchases with GST 7%(Standard-rated purchase)', '2016-07-08', '182.77.38.240', '2016-07-16 12:16:35'),
(18, 'ZP', 'purchase', 'Zero rated purchases', '2016-07-08', '182.77.38.240', '2016-07-08 08:32:29'),
(19, 'ZR ', 'supply', 'Zero rated supplies', '2016-07-08', '182.77.38.240', '2016-07-08 08:32:58');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sub_item` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visibility_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'like:active or inactive',
  `item_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'item to like: sell,buy and both',
  `net_sell_item_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gross_sell_item_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sell_item_account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sell_item_tax_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sell_item_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `net_buy_item_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `gross_buy_item_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `buy_item_account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `buy_item_tax_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `buy_item_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `selling_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `buying_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `journal`
--

CREATE TABLE IF NOT EXISTS `journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `journal_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `journal_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'journal or opening_balance',
  `journal_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amounts` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'reference code related to invoice , bills,can, san, transfer money',
  `summary` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `debit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `credit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `narration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trans_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visibility_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ladger_generate` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'like: yes, no',
  `generated_from` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'generated from like:Receipts,invoices,bills',
  `generated_from_id` int(11) NOT NULL,
  `gst_registered` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `linked_accounts`
--

CREATE TABLE IF NOT EXISTS `linked_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banking_eafce` int(11) NOT NULL COMMENT 'Equity Account for Current Earnings:',
  `banking_eafre` int(11) NOT NULL COMMENT 'Equity Account for Retained Earnings:',
  `banking_eafhb` int(11) NOT NULL COMMENT 'Equity Account for Historical Balancing:',
  `banking_bafuf` int(11) NOT NULL COMMENT 'Bank Account for Undeposited Funds:',
  `banking_gcafbd` int(11) NOT NULL COMMENT 'GST Claimed Account for Bad Debts:',
  `banking_tgrca` int(11) NOT NULL COMMENT 'Tourist GST Refund Claimed Account:',
  `sale_aaftr` int(11) NOT NULL COMMENT 'Asset Account for Tracking Receivables:',
  `sale_bafcr` int(11) NOT NULL COMMENT 'Bank Account for Customer Receipts:',
  `sale_iaff` int(11) NOT NULL COMMENT 'Income Account for Freight:',
  `sale_lafcd` int(11) NOT NULL COMMENT 'Liability Account for Customer Deposits:',
  `sale_ecosafd` int(11) NOT NULL COMMENT 'Expense or Cost of Sales Account for Discounts:',
  `purchase_bafpb` int(11) NOT NULL COMMENT 'Bank Account for Paying Bills:',
  `purchase_lafir` int(11) NOT NULL COMMENT 'Liability Account for Item Receipts:',
  `purchase_ecosaff` int(11) NOT NULL COMMENT 'Expense or Cost of Sales Account for Freight:',
  `purchase_aafsd` int(11) NOT NULL COMMENT 'Asset Account for Supplier Deposits:',
  `purchase_eafd` int(11) NOT NULL COMMENT 'Expense(or Contra) Account for Discounts:',
  `purchase_eaflc` int(11) NOT NULL COMMENT 'Expense Account for Late Charges:',
  `account_tax_collect` int(11) NOT NULL,
  `account_tax_paid` int(11) NOT NULL,
  `created_date` varchar(255) CHARACTER SET latin1 NOT NULL,
  `ip_address` varchar(255) CHARACTER SET latin1 NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `linked_accounts`
--

INSERT INTO `linked_accounts` (`id`, `banking_eafce`, `banking_eafre`, `banking_eafhb`, `banking_bafuf`, `banking_gcafbd`, `banking_tgrca`, `sale_aaftr`, `sale_bafcr`, `sale_iaff`, `sale_lafcd`, `sale_ecosafd`, `purchase_bafpb`, `purchase_lafir`, `purchase_ecosaff`, `purchase_aafsd`, `purchase_eafd`, `purchase_eaflc`, `account_tax_collect`, `account_tax_paid`, `created_date`, `ip_address`, `timestamp`) VALUES
(1, 4, 5, 5, 11, 17, 17, 36, 16, 6, 16, 16, 12, 37, 4, 19, 19, 17, 17, 21, '', '', '2016-08-24 15:03:44');

-- --------------------------------------------------------

--
-- Table structure for table `make_payment`
--

CREATE TABLE IF NOT EXISTS `make_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bank_account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `use_transaction_total` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reconcile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `allocation_notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_for` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'payment for invoice or bill',
  `payment_for_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `visibility_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payment_terms`
--

CREATE TABLE IF NOT EXISTS `payment_terms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `term_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `net_due` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visibility_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visibility_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `end_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'project status can be running,completed',
  `subproject_of` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customers` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `suppliers` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `receive_money`
--

CREATE TABLE IF NOT EXISTS `receive_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `receive_money_for` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `receive_money_for_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'id for which invoice or bill is generated',
  `receivable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bank_account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `use_transaction_total` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `allocation_notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visibility_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reconcile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dtd_bank_account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dtd_transfer_money` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dtd_bank_payment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dtd_estimate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dtd_invoice` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dtd_adjustment_notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dtd_receipt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dtd_bills` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dtd_supplier_adjustment_notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dtd_payment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dtd_projects` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dtd_items` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dtd_timesheets` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dtd_expense_claims` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rp_budgets` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fr_profit_and_loss` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fr_balance_sheet` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fr_trial_balance` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fr_account_enquary` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tr_gst_summery` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tr_tax_code_transaction` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cr_aged_debtors` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cr_aged_debtor_transaction` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cr_invoice_list` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cr_customer_transaction` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sr_aged_creditors` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sr_aged_creditors_transaction` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sr_bill_list` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sr_supplier_transaction` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ar_aged_debtor_summery` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ar_aged_creditor_summery` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ar_top_ten_customers` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ar_top_ten_suppliers` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ar_top_ten_income_accounts` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ar_top_ten_expense_accounts` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ar_budget` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lr_account_list` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lr_bank_account_list` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lr_item_list` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lr_project_list` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lr_customer_list` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lr_supplier_list` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lr_employee_list` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lr_tax_code_list` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `advr_journal_list` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `advr_payment_and_receipt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `advr_bank_account_reconcilation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adv_journal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adv_activity_statement` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adv_tpar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `con_cintact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `con_payroll_employee_details` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `con_superfunds` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adm_accounts` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adm_users` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adm_roles` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adm_book_settings` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adm_selling_settigs` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adm_payment_terms` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adm_buying_settings` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adm_time_and_expense_settings` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adm_email_settings` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adm_email_history` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adm_report_settings` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adm_tax_settings` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adm_payroll_items` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adm_payroll_settings` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `dtd_bank_account`, `dtd_transfer_money`, `dtd_bank_payment`, `dtd_estimate`, `dtd_invoice`, `dtd_adjustment_notes`, `dtd_receipt`, `dtd_bills`, `dtd_supplier_adjustment_notes`, `dtd_payment`, `dtd_projects`, `dtd_items`, `dtd_timesheets`, `dtd_expense_claims`, `rp_budgets`, `fr_profit_and_loss`, `fr_balance_sheet`, `fr_trial_balance`, `fr_account_enquary`, `tr_gst_summery`, `tr_tax_code_transaction`, `cr_aged_debtors`, `cr_aged_debtor_transaction`, `cr_invoice_list`, `cr_customer_transaction`, `sr_aged_creditors`, `sr_aged_creditors_transaction`, `sr_bill_list`, `sr_supplier_transaction`, `ar_aged_debtor_summery`, `ar_aged_creditor_summery`, `ar_top_ten_customers`, `ar_top_ten_suppliers`, `ar_top_ten_income_accounts`, `ar_top_ten_expense_accounts`, `ar_budget`, `lr_account_list`, `lr_bank_account_list`, `lr_item_list`, `lr_project_list`, `lr_customer_list`, `lr_supplier_list`, `lr_employee_list`, `lr_tax_code_list`, `advr_journal_list`, `advr_payment_and_receipt`, `advr_bank_account_reconcilation`, `adv_journal`, `adv_activity_statement`, `adv_tpar`, `con_cintact`, `con_payroll_employee_details`, `con_superfunds`, `adm_accounts`, `adm_users`, `adm_roles`, `adm_book_settings`, `adm_selling_settigs`, `adm_payment_terms`, `adm_buying_settings`, `adm_time_and_expense_settings`, `adm_email_settings`, `adm_email_history`, `adm_report_settings`, `adm_tax_settings`, `adm_payroll_items`, `adm_payroll_settings`, `create_date`, `ip_address`, `timestamp`, `role`, `description`) VALUES
(1, 'a:5:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:6:"import";i:4;s:26:"perform_bank_reconcilation";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:4:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:15:"print_and_email";}', 'a:5:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:7:"approve";i:4;s:15:"print_and_email";}', 'a:5:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:7:"approve";i:4;s:15:"print_and_email";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:5:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:7:"approve";i:4;s:15:"print_and_email";}', 'a:5:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:7:"approve";i:4;s:5:"print";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'N;', 'N;', 'N;', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'N;', 'N;', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'N;', 'N;', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'N;', 'N;', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'N;', 'N;', 'N;', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', '', 'N;', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:4:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:7:"approve";}', 'N;', 'a:5:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:15:"print_and_email";i:4;s:10:"lodge_tpar";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:4:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:32:"edit_other_user_personal_details";i:3;s:6:"delete";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:2:{i:0;s:4:"view";i:1;s:4:"edit";}', 'a:2:{i:0;s:4:"view";i:1;s:4:"edit";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:2:{i:0;s:4:"view";i:1;s:4:"edit";}', 'a:2:{i:0;s:4:"view";i:1;s:4:"edit";}', 'a:2:{i:0;s:4:"view";i:1;s:4:"edit";}', 'a:2:{i:0;s:4:"view";i:1;s:4:"edit";}', 'a:2:{i:0;s:4:"view";i:1;s:4:"edit";}', 'a:3:{i:0;s:4:"view";i:1;s:4:"edit";i:2;s:25:"delete_tax_code_and_group";}', 'a:2:{i:0;s:4:"view";i:1;s:15:"create_and_edit";}', 'a:2:{i:0;s:4:"view";i:1;s:15:"create_and_edit";}', '2016-09-01', '182.64.132.9', '2016-09-01 11:32:04', 'Administrator', 'RELATED TO Administrator'),
(2, 'a:5:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:6:"import";i:4;s:26:"perform_bank_reconcilation";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:4:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:15:"print_and_email";}', 'a:5:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:7:"approve";i:4;s:15:"print_and_email";}', 'a:5:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:7:"approve";i:4;s:15:"print_and_email";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:5:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:7:"approve";i:4;s:15:"print_and_email";}', 'a:5:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:7:"approve";i:4;s:5:"print";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'N;', 'N;', 'N;', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'N;', 'N;', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'N;', 'N;', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'N;', 'N;', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'N;', 'N;', 'N;', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', '', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:4:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:7:"approve";}', 'a:5:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:15:"print_and_email";i:4;s:24:"lodge_activity_statement";}', 'a:5:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:15:"print_and_email";i:4;s:10:"lodge_tpar";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:4:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:32:"edit_other_user_personal_details";i:3;s:6:"delete";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:2:{i:0;s:4:"view";i:1;s:4:"edit";}', 'a:2:{i:0;s:4:"view";i:1;s:4:"edit";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:2:{i:0;s:4:"view";i:1;s:4:"edit";}', 'a:2:{i:0;s:4:"view";i:1;s:4:"edit";}', 'a:2:{i:0;s:4:"view";i:1;s:4:"edit";}', 'a:2:{i:0;s:4:"view";i:1;s:4:"edit";}', 'a:2:{i:0;s:4:"view";i:1;s:4:"edit";}', 'a:3:{i:0;s:4:"view";i:1;s:4:"edit";i:2;s:25:"delete_tax_code_and_group";}', 'a:2:{i:0;s:4:"view";i:1;s:15:"create_and_edit";}', 'a:2:{i:0;s:4:"view";i:1;s:15:"create_and_edit";}', '2016-08-29', '182.64.178.154', '2016-08-29 15:07:01', 'Manager', 'Manager'),
(4, 'a:5:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:6:"import";i:4;s:26:"perform_bank_reconcilation";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:4:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:15:"print_and_email";}', 'a:5:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:7:"approve";i:4;s:15:"print_and_email";}', 'a:5:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:7:"approve";i:4;s:15:"print_and_email";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:5:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:7:"approve";i:4;s:15:"print_and_email";}', 'a:5:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:7:"approve";i:4;s:5:"print";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', '', '', 'N;', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', '', '', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', '', '', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', '', '', '', '', '', '', '', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', '', 'N;', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:2:{i:0;s:4:"view";i:1;s:6:"export";}', 'a:4:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";i:3;s:7:"approve";}', 'N;', '', 'a:3:{i:0;s:4:"view";i:1;s:15:"create_and_edit";i:2;s:6:"delete";}', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2016-09-01', '182.64.132.9', '2016-09-01 11:25:29', 'Teacher', 'teaC');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'name of company',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telephone1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telephone2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timezone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `currency_symbol` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cookie_expire` int(10) NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pdflogo` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'logo for pdf and print',
  `date_format` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '1 is for dd/mm/yy 2 is for mm/dd/yy 3 is for full date',
  `create_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `com_uen_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `com_uen_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_gst_registered` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `com_gst_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start_date_financial_year` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start_month_financial_year` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gst_reporting_period` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fax_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `email`, `website`, `address`, `country`, `city`, `state`, `zip`, `telephone1`, `telephone2`, `timezone`, `currency_symbol`, `cookie_expire`, `logo`, `pdflogo`, `date_format`, `create_date`, `ip_address`, `time_stamp`, `com_uen_no`, `com_uen_type`, `is_gst_registered`, `com_gst_no`, `start_date_financial_year`, `start_month_financial_year`, `gst_reporting_period`, `fax_number`) VALUES
(1, 'OTTODESK SINGAPORE PTE LTD ', 'nicholas.tan@ottodesk.com.sg', 'www.nicdata.com.sg', '12                                                                                                                                                                                                                                                                                        ', 'SG', 'Singapore', 'Singapore', '457909', '91901075', '91901075', 'Asia/Singapore', '$', 0, '1473184460.png', '1467615087.png', 'd-M-Y', '', '', '2016-09-06 17:54:20', 'SG-123456789', 'UF', 'yes', 'yes', '1', 'Apr', '3', 'fax-452365');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_adjustment_notes`
--

CREATE TABLE IF NOT EXISTS `supplier_adjustment_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL,
  `adjustment_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adjustment_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'status like: draft,approved,overdue,paid',
  `adjustment_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reference_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amounts` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'amounts like:Non taxed,Gross (Tax inclusive),Net (Tax Enclusive)',
  `project_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `item_qty` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `taxcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `visibility_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `balance_remaining` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paid_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gst_registered` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE IF NOT EXISTS `tax` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `what_trans_is_used` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'like:supply,purchase',
  `tax_account_for_gst_collected` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT 'selected account_id',
  `tax_account_for_gst_paid` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT 'selected account_id',
  `iras_for_gst_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'iras gst code for gst',
  `account_tax_import_duty` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_tax_sale_tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visibility_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_rate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default_tax_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Dumping data for table `tax`
--

INSERT INTO `tax` (`id`, `tax_name`, `tax_type`, `tax_description`, `what_trans_is_used`, `tax_account_for_gst_collected`, `tax_account_for_gst_paid`, `iras_for_gst_code`, `account_tax_import_duty`, `account_tax_sale_tax`, `visibility_status`, `tax_rate`, `tax_code`, `default_tax_code`, `created_date`, `ip_address`, `timestamp`) VALUES
(1, 'BL', 'gst', 'Not claimable GST (Reg.26/27) - Edit', 'purchase', '17', '6', 'BL', '', '', 'active', '10.00', '', '0', '2016-07-29', '182.64.85.30', '2016-08-27 11:33:29'),
(2, 'DS', 'gst', 'Deemed supplies', 'supply', '17', '6', 'DS', '', '', 'active', '10.00', '', '0', '2016-07-04', '122.162.208.124', '2016-07-29 11:41:47'),
(3, 'E33', 'gst', 'Reg. 33 exempt supplies', 'supply', '17', '6', 'TX-ESS', '', '', 'active', '20', '', '0', '2016-07-04', '122.162.208.124', '2016-07-16 12:17:08'),
(4, 'EN3', 'gst', 'Non-Reg. 33 exempt supplies', 'purchase', '17', '6', 'TX-N33', '', '', 'active', '10', '', '0', '2016-07-04', '122.162.208.124', '2016-07-13 09:02:06'),
(5, 'EP', 'gst', 'Purchases exempted from GST', 'purchase', '17', '6', 'EP', '', '', 'active', '30', '', '0', '2016-07-04', '122.162.208.124', '2016-07-13 09:02:21'),
(6, 'ES3', 'gst', 'Reg. 33 exempt supplies', 'supply', '17', '6', 'ES33', '', '', 'active', '10.00', '', '0', '2016-07-04', '122.162.208.124', '2016-07-13 09:02:42'),
(7, 'ESN', 'gst', 'Non-Reg. 33 exempt supplies', 'supply', '17', '6', 'ESN33', '', '', 'active', '11.90', '', '0', '2016-07-04', '122.162.208.124', '2016-07-29 11:44:31'),
(14, 'FRE', 'gst', 'GST Free ', 'supply', '17', '6', 'ZR ', '', '', 'active', '0', '', '0', '2016-07-08', '182.77.38.240', '2016-07-13 09:02:55'),
(15, 'GST', 'gst', 'Goods & Services Tax', 'supply', '17', '6', 'SR', '', '', 'active', '7', '', '0', '2016-07-08', '182.77.38.240', '2016-07-13 09:03:02'),
(16, 'IGD ', 'gst', 'Import under deferment scheme\r\n', 'purchase', '17', '6', 'IGDS', '', '', 'active', '7', '', '0', '2016-07-08', '182.77.38.240', '2016-07-13 09:03:16'),
(17, 'IM', 'gst', 'Imports goods with GST 7%', 'purchase', '17', '6', 'IM', '', '', 'active', '7', '', '0', '2016-07-08', '182.77.38.240', '2016-07-13 09:03:24'),
(18, 'IMP', 'import_duty', 'Import Duty Import Duty\r\n', '', '17', '6', '', '2', '', 'active', '0', '', '0', '2016-07-08', '182.77.38.240', '2016-07-13 09:04:25'),
(19, 'ME', 'gst', 'Imports under special scheme', 'purchase', '17', '6', 'ME', '', '', 'active', '0', '', '0', '2016-07-08', '182.77.38.240', '2016-07-13 09:04:33'),
(20, 'N-T sale', 'sale_tax', 'Non-Taxable Sales Tax\r\n', 'supply', '17', '6', '', '', '10', 'active', '0', '', '1', '2016-08-27', '182.64.93.17', '2016-08-27 11:56:02'),
(21, 'NR', 'gst', 'Non GST-registered supplier\r\n', 'purchase', '17', '6', 'NR', '', '', 'active', '3', '', '0', '2016-07-08', '182.77.38.240', '2016-07-13 09:04:47'),
(22, 'OP', 'gst', 'Purchases (Out-of-scope) ', 'purchase', '17', '6', 'OP', '', '', 'active', '0', '', '0', '2016-07-08', '182.77.38.240', '2016-07-13 09:05:11'),
(23, 'OS', 'gst', ' Supplies (Out-of-scope)', 'supply', '17', '6', 'OS', '', '', 'active', '0', '', '0', '2016-07-08', '182.77.38.240', '2016-07-13 09:05:24'),
(24, 'RE', 'gst', 'GST not direct attributable', 'purchase', '17', '6', 'TX-RE', '', '', 'active', '0', '', '0', '2016-07-08', '182.77.38.240', '2016-07-13 09:05:33'),
(25, 'SR', 'gst', 'Standard-rated supplies(GST7%)', 'supply', '17', '6', 'SR', '', '', 'active', '7', '', '0', '2016-07-08', '182.77.38.240', '2016-07-13 09:05:46'),
(26, 'TX', 'gst', 'Purchases with GST 7%(Standard-rated purchase)', 'purchase', '17', '6', 'TX', '', '', 'active', '7', '', '0', '2016-07-13', '182.64.54.254', '2016-07-16 12:17:15'),
(27, 'ZP', 'input_tax', 'Purchases with no GST incurred', 'purchase', '17', '6', 'ZP', '4', '', 'active', '0', '', '0', '2016-07-08', '182.77.38.240', '2016-07-13 09:06:08'),
(28, 'ZR', 'gst', 'Zero-rated supplies', 'supply', '17', '6', 'ZR ', '', '', 'active', '0', '', '0', '2016-07-08', '182.77.38.240', '2016-07-13 09:06:19');

-- --------------------------------------------------------

--
-- Table structure for table `tax_calculation`
--

CREATE TABLE IF NOT EXISTS `tax_calculation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_rate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_payable_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `generated_from` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `generated_from_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `month` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `year` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `section` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visibility_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tax_setting`
--

CREATE TABLE IF NOT EXISTS `tax_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `register_for_tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'like:- yes, no',
  `reporting_basis` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default_sale_figure` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default_tax_for_sale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default_tax_for_purchase` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `allow_user_edit_tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `allow_user_include_tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tax_setting`
--

INSERT INTO `tax_setting` (`id`, `register_for_tax`, `reporting_basis`, `default_sale_figure`, `default_tax_for_sale`, `default_tax_for_purchase`, `allow_user_edit_tax`, `allow_user_include_tax`, `create_date`, `ip_address`, `timestamp`) VALUES
(1, 'yes', 'accrual', 'net', '28', '26', 'yes', 'yes', '2016-06-30', '182.64.93.17', '2016-08-27 11:57:25');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_rule`
--

CREATE TABLE IF NOT EXISTS `transaction_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rule` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `applies_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description_has` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description_has_other` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `refrence_has` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `refrence_has_other` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_day` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_day_other` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type_has` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type_has_other` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount_is` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount_is_other` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `do_following` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `transaction_rule`
--

INSERT INTO `transaction_rule` (`id`, `rule`, `applies_to`, `description_has`, `description_has_other`, `refrence_has`, `refrence_has_other`, `transaction_day`, `transaction_day_other`, `type_has`, `type_has_other`, `amount_is`, `amount_is_other`, `do_following`, `description`, `contact_to`, `create_date`, `ip_address`, `timestamp`) VALUES
(1, 'rule 1', 'money in', 'Any of these words', '11', 'Any of these words', '22', 'The first day of the month', '33', 'Any of these words', '44', 'More then', '55', 'Create a receipt', 'abc123', '4', '2016-07-04', '122.162.208.124', '2016-07-04 10:38:26'),
(2, 'rule 2', 'money out', 'Any of these words', 'a', 'This exact working', 'b', 'Any date', 'c', 'Any of these words', 'd', 'Equal to or more then', 'e', 'Create a transfer', 'knlk kjkj 151', '5', '2016-07-04', '122.162.208.124', '2016-07-04 10:41:30'),
(3, 'rule 1', 'money in', 'Any of these words', '11', 'This exact working', '22', 'The first day of the month', '33', 'Any of these words', '44', 'More then', '55', 'Create a receipt', 'abc123', '20', '2016-07-05', '182.64.89.222', '2016-07-05 13:28:10'),
(4, 'role test', 'money out', 'All of these words', '11', 'All of these words', '22', 'The following day of the month', '33', 'All of these words', '44', 'Equal to', '55', 'Create a payment', 'abc123', '12', '2016-07-05', '182.64.89.222', '2016-07-05 13:30:19');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_money`
--

CREATE TABLE IF NOT EXISTS `transfer_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transfer_money` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transfer_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bank_fees` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id of user who is login.',
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_photo_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `random` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT 'encrypt id',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
