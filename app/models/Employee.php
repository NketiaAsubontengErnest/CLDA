<?php
namespace App\Models;

use App\Core\Model;

class Employee extends Model {
    public function __construct() {
        parent::__construct();
        \App\Core\PayrollSchema::ensure($this->db);
    }

    private $fields = ['employee_code', 'full_name', 'email', 'phone', 'position', 'department', 'date_hired', 'basic_salary', 'allowances', 'bank_name', 'bank_account', 'ssnit_number', 'tin_number', 'status'];

    private function clean($data) {
        $out = [];
        foreach ($this->fields as $f) {
            $v = isset($data[$f]) ? trim($data[$f]) : null;
            $out[$f] = ($v === '') ? null : $v;
        }
        $out['basic_salary'] = (float)($data['basic_salary'] ?? 0);
        $out['allowances'] = (float)($data['allowances'] ?? 0);
        $out['status'] = ($data['status'] ?? 'active') === 'inactive' ? 'inactive' : 'active';
        return $out;
    }

    public function getAll($search = null) {
        $sql = "SELECT * FROM employees";
        $params = [];
        if ($search) {
            $sql .= " WHERE full_name LIKE :search OR employee_code LIKE :search OR position LIKE :search OR department LIKE :search OR email LIKE :search";
            $params['search'] = '%' . $search . '%';
        }
        $sql .= " ORDER BY full_name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getActive() {
        return $this->db->query("SELECT * FROM employees WHERE status = 'active' ORDER BY full_name ASC")->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM employees WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $d = $this->clean($data);
        $cols = implode(', ', array_keys($d));
        $ph = ':' . implode(', :', array_keys($d));
        return $this->db->prepare("INSERT INTO employees ($cols) VALUES ($ph)")->execute($d);
    }

    public function update($id, $data) {
        $d = $this->clean($data);
        $set = implode(', ', array_map(function ($k) { return "$k = :$k"; }, array_keys($d)));
        $d['id'] = $id;
        return $this->db->prepare("UPDATE employees SET $set WHERE id = :id")->execute($d);
    }

    public function delete($id) {
        return $this->db->prepare("DELETE FROM employees WHERE id = :id")->execute(['id' => $id]);
    }
}
