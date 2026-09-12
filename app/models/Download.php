<?php
namespace App\Models;

use App\Core\Model;

class Download extends Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM downloads ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO downloads (title, description, file_path) VALUES (:title, :description, :file_path)");
        return $stmt->execute($data);
    }
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM downloads WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE downloads SET title = :title, description = :description, file_path = :file_path WHERE id = :id");
        $data['id'] = $id;
        return $stmt->execute($data);
    }
}
