<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Notifier;

class ApiController extends Controller {
    // Payment gateway webhook: POST /api/webhooks/payment (Paystack)
    public function webhooks($name = null) {
        if ($name !== 'payment' || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(404); exit;
        }

        $payload = file_get_contents('php://input');
        $secret = $this->model('Setting')->get('paystack_secret_key');
        $signature = $_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] ?? '';

        if (!$secret || !hash_equals(hash_hmac('sha512', $payload, $secret), $signature)) {
            http_response_code(401); exit;
        }

        $event = json_decode($payload, true);
        if (($event['event'] ?? '') === 'charge.success') {
            $data = $event['data'];
            $submissionId = $data['metadata']['submission_id'] ?? null;
            $testModel = $this->model('Test');
            $submission = $submissionId ? $testModel->getSubmission($submissionId) : null;

            if ($submission) {
                $txn = $this->model('Transaction')->recordOnline($submission, $data['reference'], $data['amount'] / 100);
                $testModel->updateSubmissionStatus($submissionId, 'paid');
                if ($txn) Notifier::sendReceipt($txn);
            }
        }

        http_response_code(200);
        echo 'ok';
    }
}
