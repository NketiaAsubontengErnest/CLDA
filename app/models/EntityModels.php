<?php
namespace App\Models;

use App\Core\Model;

class Research extends Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM research ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO research (title, description, file_path) VALUES (:title, :description, :file_path)");
        return $stmt->execute($data);
    }
}

class Media extends Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM media ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO media (title, type, file_path) VALUES (:title, :type, :file_path)");
        return $stmt->execute($data);
    }
}

class Download extends Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM downloads ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO downloads (title, description, file_path) VALUES (:title, :description, :file_path)");
        return $stmt->execute($data);
    }
}

class Event extends Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM events ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO events (title, description, event_date, location) VALUES (:title, :description, :event_date, :location)");
        return $stmt->execute($data);
    }
}
