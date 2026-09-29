-- Payroll module tables (safe to run on an existing database)
CREATE TABLE IF NOT EXISTS `employees` (
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

CREATE TABLE IF NOT EXISTS `payroll_records` (
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
