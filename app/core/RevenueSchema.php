<?php
namespace App\Core;

/**
 * Creates the transactions table if it is missing.
 * CREATE TABLE IF NOT EXISTS only: never drops, alters or deletes anything.
 */
class RevenueSchema {
    private static $done = false;

    public static function ensure($db) {
        if (self::$done) return;
        self::$done = true;
        try {
            $db->exec("CREATE TABLE IF NOT EXISTS `transactions` (
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        } catch (\PDOException $e) {
            error_log('Revenue schema setup failed: ' . $e->getMessage());
        }
    }
}
