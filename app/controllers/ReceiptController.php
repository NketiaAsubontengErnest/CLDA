<?php
namespace App\Controllers;

use App\Core\Controller;

class ReceiptController extends Controller {
    // Public receipt page: /receipts/{token}
    public function index($token = null) {
        $txn = ($token && preg_match('/^[a-f0-9]{32}$/', $token)) ? $this->model('Transaction')->findByToken($token) : null;
        if (!$txn) {
            http_response_code(404);
            die('Receipt not found.');
        }
        $this->view('receipts/show', ['txn' => $txn]);
    }
}
