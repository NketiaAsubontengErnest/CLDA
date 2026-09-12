<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class User extends Model {
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $sql = "UPDATE users SET username = :username";
        $params = ['username' => $data['username'], 'id' => $id];

        if (isset($data['password'])) {
            $sql .= ", password = :password";
            $params['password'] = $data['password'];
        }

        $sql .= " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
}
