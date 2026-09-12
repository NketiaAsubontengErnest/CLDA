<?php
namespace App\Models;

use App\Core\Model;

class Media extends Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM media ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO media (title, type, file_path) VALUES (:title, :type, :file_path)");
        return $stmt->execute($data);
    }
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM media WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE media SET title = :title, type = :type, file_path = :file_path WHERE id = :id");
        $data['id'] = $id;
        return $stmt->execute($data);
    }
}
