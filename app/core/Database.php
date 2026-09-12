<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private $host = 'localhost';
    private $db_name = 'clda_db';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            // If database doesn't exist, try to create it
            if ($e->getCode() == 1049) {
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
