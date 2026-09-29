<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;
    private $is_local;

    public function __construct() {
        $host = strtolower(preg_replace('/:\d+$/', '', $_SERVER['HTTP_HOST'] ?? 'localhost'));
        $this->is_local = in_array($host, ['localhost', '127.0.0.1', '[::1]', '::1'], true) || PHP_SAPI === 'cli';

        $all = require __DIR__ . '/../../config/database.php';
        $cfg = $all[$this->is_local ? 'local' : 'production'];

        $this->host = $cfg['host'];
        $this->db_name = $cfg['name'];
        $this->username = $cfg['user'];
        $this->password = $cfg['password'];
    }

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            // If database doesn't exist, try to create it
            if ($e->getCode() == 1049 && $this->is_local) {
                try {
                    $tmp_conn = new PDO('mysql:host=' . $this->host, $this->username, $this->password);
                    $tmp_conn->exec("CREATE DATABASE IF NOT EXISTS " . $this->db_name);
                    $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
                } catch(PDOException $ex) {
                    die('Connection Error: ' . $ex->getMessage());
                }
            } else {
                die('Connection Error: ' . $e->getMessage());
            }
        }

        return $this->conn;
    }
}
