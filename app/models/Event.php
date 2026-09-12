<?php
namespace App\Models;

use App\Core\Model;

class Event extends Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM events ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO events (title, description, event_date, location) VALUES (:title, :description, :event_date, :location)");
        return $stmt->execute($data);
    }
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM events WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE events SET title = :title, description = :description, event_date = :event_date, location = :location WHERE id = :id");
        $data['id'] = $id;
        return $stmt->execute($data);
    }
}
