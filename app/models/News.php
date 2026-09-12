<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class News extends Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM news ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO news (title, content, image_path) VALUES (:title, :content, :image_path)");
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM news WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE news SET title = :title, content = :content, image_path = :image_path WHERE id = :id");
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM news WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
