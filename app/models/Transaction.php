<?php
namespace App\Models;

use App\Core\Model;

class Transaction extends Model {
    public function __construct() {
        parent::__construct();
        \App\Core\RevenueSchema::ensure($this->db);
    }

    /** Ghana numbers to E.164 (+233XXXXXXXXX). Other numbers are only cleaned. */
    public static function normalizePhone($phone) {
        $p = preg_replace('/[^\d+]/', '', (string)$phone);
        if ($p === '') return null;
        if (strpos($p, '+') === 0) return $p;
        if (strpos($p, '00') === 0) return '+' . substr($p, 2);
        if (strpos($p, '233') === 0 && strlen($p) >= 12) return '+' . $p;
        if (strpos($p, '0') === 0) return '+233' . substr($p, 1);
        return '+233' . $p;
    }

    private function insert($d) {
        $d['receipt_token'] = bin2hex(random_bytes(16));
        $stmt = $this->db->prepare("INSERT INTO transactions (receipt_token, reference, submission_id, client_name, mobile_number, email, description, amount, payment_source, payment_status) VALUES (:receipt_token, :reference, :submission_id, :client_name, :mobile_number, :email, :description, :amount, :payment_source, :payment_status)");
        $stmt->execute($d);
        return $this->find($this->db->lastInsertId());
    }

    public function createWalkIn($data) {
        return $this->insert([
            'reference' => null,
            'submission_id' => null,
            'client_name' => trim($data['client_name']),
            'mobile_number' => self::normalizePhone($data['mobile_number'] ?? ''),
            'email' => trim($data['email'] ?? '') ?: null,
            'description' => trim($data['description'] ?? ''),
            'amount' => (float)$data['amount'],
            'payment_source' => 'walk_in',
            'payment_status' => 'paid',
        ]);
    }

    /** Idempotent: returns the new row, or null if this gateway reference was already recorded. */
    public function recordOnline($submission, $reference, $amount) {
        if ($this->findByReference($reference)) return null;
        try {
            return $this->insert([
                'reference' => $reference,
                'submission_id' => $submission['id'],
                'client_name' => $submission['user_name'],
                'mobile_number' => self::normalizePhone($submission['user_phone'] ?? ''),
                'email' => $submission['user_email'] ?: null,
                'description' => 'Online Assessment - ' . ($submission['test_title'] ?? 'Test'),
                'amount' => (float)$amount,
                'payment_source' => 'online',
                'payment_status' => 'paid',
            ]);
        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) return null; // raced with the webhook/callback
            throw $e;
        }
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM transactions WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function findByToken($token) {
        $stmt = $this->db->prepare("SELECT * FROM transactions WHERE receipt_token = :t");
        $stmt->execute(['t' => $token]);
        return $stmt->fetch();
    }

    public function findByReference($ref) {
        $stmt = $this->db->prepare("SELECT * FROM transactions WHERE reference = :r");
        $stmt->execute(['r' => $ref]);
        return $stmt->fetch();
    }

    public function updateReceiptStatus($id, $receipt, $sms, $email) {
        return $this->db->prepare("UPDATE transactions SET receipt_status = :r, sms_status = :s, email_status = :e WHERE id = :id")
            ->execute(['r' => $receipt, 's' => $sms, 'e' => $email, 'id' => $id]);
    }

    private function where($search, $source, &$params) {
        $w = [];
        if ($search) {
            $w[] = "(client_name LIKE :search OR mobile_number LIKE :search OR email LIKE :search OR description LIKE :search OR reference LIKE :search)";
            $params['search'] = '%' . $search . '%';
        }
        if (in_array($source, ['walk_in', 'online'], true)) {
            $w[] = "payment_source = :source";
            $params['source'] = $source;
        }
        return $w ? ' WHERE ' . implode(' AND ', $w) : '';
    }

    public function count($search = null, $source = null) {
        $params = [];
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM transactions" . $this->where($search, $source, $params));
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    public function getAll($search, $source, $limit, $offset) {
        $params = [];
        $sql = "SELECT * FROM transactions" . $this->where($search, $source, $params) . " ORDER BY created_at DESC, id DESC LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function totals() {
        return $this->db->query("SELECT COALESCE(SUM(amount),0) total, COALESCE(SUM(CASE WHEN payment_source='walk_in' THEN amount END),0) walk_in, COALESCE(SUM(CASE WHEN payment_source='online' THEN amount END),0) online FROM transactions WHERE payment_status = 'paid'")->fetch();
    }
}
