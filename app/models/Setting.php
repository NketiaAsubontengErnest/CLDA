<?php
namespace App\Models;

use App\Core\Model;

class Setting extends Model {
    public function get($key) {
        $stmt = $this->db->prepare("SELECT setting_value FROM settings WHERE setting_key = :key");
        $stmt->execute(['key' => $key]);
        $result = $stmt->fetch();
        return $result ? $result['setting_value'] : null;
    }

    public function set($key, $value) {
        $stmt = $this->db->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:key, :value) ON DUPLICATE KEY UPDATE setting_value = :value");
        return $stmt->execute(['key' => $key, 'value' => $value]);
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM settings");
        return $stmt->fetchAll();
    }
}
