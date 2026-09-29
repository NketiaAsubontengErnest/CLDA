-- Comprehensive Database Schema for CLDA Website
-- Generated on: 2026-04-26
-- This script drops existing tables and recreates them.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
SET FOREIGN_KEY_CHECKS = 0;

-- --------------------------------------------------------
-- Drop existing tables
-- --------------------------------------------------------

DROP TABLE IF EXISTS `transactions`;
DROP TABLE IF EXISTS `payroll_records`;
DROP TABLE IF EXISTS `employees`;
DROP TABLE IF EXISTS `answers`;
DROP TABLE IF EXISTS `submissions`;
DROP TABLE IF EXISTS `questions`;
DROP TABLE IF EXISTS `test_subsections`;
DROP TABLE IF EXISTS `test_sections`;
DROP TABLE IF EXISTS `tests`;
DROP TABLE IF EXISTS `events`;
DROP TABLE IF EXISTS `downloads`;
DROP TABLE IF EXISTS `media`;
DROP TABLE IF EXISTS `research`;
DROP TABLE IF EXISTS `news`;
DROP TABLE IF EXISTS `settings`;
DROP TABLE IF EXISTS `users`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(255) NOT NULL UNIQUE,
  `setting_value` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `image_path` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `research`
--

CREATE TABLE `research` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `file_path` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `type` ENUM('image', 'video') DEFAULT 'image',
  `file_path` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `file_path` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `event_date` DATE,
  `location` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `price` DECIMAL(10, 2) DEFAULT 0.00,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `test_sections`
--

CREATE TABLE `test_sections` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `test_id` INT(11) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `sort_order` INT(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`test_id`) REFERENCES `tests`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `test_subsections`
--

CREATE TABLE `test_subsections` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `section_id` INT(11) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `sort_order` INT(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`section_id`) REFERENCES `test_sections`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `test_id` INT(11) NOT NULL,
  `question_text` TEXT NOT NULL,
  `type` ENUM('text', 'radio', 'checkbox') DEFAULT 'text',
  `options` JSON DEFAULT NULL,
  `section` VARCHAR(255) DEFAULT 'General',
  `subsection` VARCHAR(255) DEFAULT '',
  `section_id` INT(11) DEFAULT NULL,
  `subsection_id` INT(11) DEFAULT NULL,
  `sort_order` INT(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`test_id`) REFERENCES `tests`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `test_id` INT(11) NOT NULL,
  `user_name` VARCHAR(255) NOT NULL,
  `user_email` VARCHAR(255) NOT NULL,
  `user_phone` VARCHAR(50),
  `filing_for` VARCHAR(100) DEFAULT 'Self',
  `assessed_name` VARCHAR(255),
  `dob` DATE,
  `age` VARCHAR(20),
  `gender` VARCHAR(20),
  `school_grade` VARCHAR(100),
  `assessment_reason` TEXT,
  `status` ENUM('pending', 'paid', 'completed') DEFAULT 'pending',
  `section_notes` JSON DEFAULT NULL,
  `overall_summary` TEXT,
  `recommendations` TEXT,
  `additional_comments` TEXT,
  `officer_name` VARCHAR(255),
  `officer_signature` TEXT,
  `assessment_date` DATE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`test_id`) REFERENCES `tests`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `submission_id` INT(11) NOT NULL,
  `question_id` INT(11) NOT NULL,
  `answer_text` TEXT,
  `score` INT DEFAULT 0,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`submission_id`) REFERENCES `submissions`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`question_id`) REFERENCES `questions`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Payroll module
CREATE TABLE `employees` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `employee_code` VARCHAR(50) NOT NULL UNIQUE,
  `full_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255),
  `phone` VARCHAR(50),
  `position` VARCHAR(255),
  `department` VARCHAR(255),
  `date_hired` DATE,
  `basic_salary` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `allowances` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `bank_name` VARCHAR(255),
  `bank_account` VARCHAR(100),
  `ssnit_number` VARCHAR(100),
  `tin_number` VARCHAR(100),
  `status` ENUM('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `payroll_records` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `employee_id` INT NOT NULL,
  `pay_month` CHAR(7) NOT NULL COMMENT 'YYYY-MM',
  `basic_salary` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `allowances` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `bonus` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `gross_pay` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `ssnit_employee` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `income_tax` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `other_deductions` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `total_deductions` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `net_pay` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `status` ENUM('pending','paid') NOT NULL DEFAULT 'pending',
  `paid_at` DATE NULL,
  `notes` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `uniq_emp_month` (`employee_id`,`pay_month`),
  FOREIGN KEY (`employee_id`) REFERENCES `employees`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Revenue module
CREATE TABLE `transactions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `receipt_token` CHAR(32) NOT NULL UNIQUE,
  `reference` VARCHAR(100) NULL UNIQUE,
  `submission_id` INT NULL,
  `client_name` VARCHAR(255) NOT NULL,
  `mobile_number` VARCHAR(20),
  `email` VARCHAR(255),
  `description` TEXT,
  `amount` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `payment_source` ENUM('walk_in','online') NOT NULL,
  `payment_status` ENUM('paid','pending','failed') NOT NULL DEFAULT 'paid',
  `receipt_status` ENUM('pending','sent','failed') NOT NULL DEFAULT 'pending',
  `sms_status` VARCHAR(20) NOT NULL DEFAULT 'pending',
  `email_status` VARCHAR(20) NOT NULL DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;
