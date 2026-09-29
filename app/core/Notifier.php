<?php
namespace App\Core;

use App\Models\Setting;
use App\Models\Transaction;

/**
 * Sends the receipt link by email and SMS, and records the outcome on the transaction.
 * Email login and SMS key come from Admin > Settings (nothing is hardcoded here).
 */
class Notifier {
    public static function receiptUrl($txn) {
        return ROOT . '/receipts/' . $txn['receipt_token'];
    }

    public static function sendReceipt($txn) {
        $settings = new Setting();
        $email = !empty($txn['email']) ? self::sendEmail($txn, $settings) : 'skipped';
        $sms = !empty($txn['mobile_number']) ? self::sendSms($txn, $settings) : 'skipped';

        $receipt = ($email === 'sent' || $sms === 'sent') ? 'sent' : 'failed';
        (new Transaction())->updateReceiptStatus($txn['id'], $receipt, $sms, $email);
        return $receipt;
    }

    private static function sendEmail($txn, $settings) {
        $user = $settings->get('smtp_username');
        $pass = $settings->get('smtp_password');
        if (!$user || !$pass) return 'not_configured';

        require_once __DIR__ . '/../../public/phpmailer/Exception.php';
        require_once __DIR__ . '/../../public/phpmailer/PHPMailer.php';
        require_once __DIR__ . '/../../public/phpmailer/SMTP.php';

        $url = self::receiptUrl($txn);
        $h = function ($v) { return htmlspecialchars((string)$v); };
        $body = "
            <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;border:1px solid #eee;border-radius:12px;padding:30px;'>
                <h2 style='color:#0d6efd;margin-top:0;'>Payment Receipt</h2>
                <p>Dear " . $h($txn['client_name']) . ",</p>
                <p>Thank you for your payment to Center for Learning Disabilities.</p>
                <table style='width:100%;border-collapse:collapse;font-size:14px;'>
                    <tr><td style='padding:6px 0;color:#666;'>Service</td><td style='padding:6px 0;text-align:right;'>" . $h($txn['description']) . "</td></tr>
                    <tr><td style='padding:6px 0;color:#666;'>Amount Paid</td><td style='padding:6px 0;text-align:right;'><strong>GH₵ " . number_format($txn['amount'], 2) . "</strong></td></tr>
                    <tr><td style='padding:6px 0;color:#666;'>Date</td><td style='padding:6px 0;text-align:right;'>" . date('M d, Y h:i A', strtotime($txn['created_at'])) . "</td></tr>
                    <tr><td style='padding:6px 0;color:#666;'>Transaction ID</td><td style='padding:6px 0;text-align:right;'>#" . str_pad($txn['id'], 6, '0', STR_PAD_LEFT) . "</td></tr>
                </table>
                <p style='text-align:center;margin:30px 0;'>
                    <a href='" . $h($url) . "' style='background:#0d6efd;color:#fff;text-decoration:none;padding:14px 30px;border-radius:50px;font-weight:bold;display:inline-block;'>View / Download Receipt</a>
                </p>
            </div>";

        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = $settings->get('smtp_host') ?: 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $user;
            $mail->Password   = $pass;
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = (int)($settings->get('smtp_port') ?: 587);
            $mail->setFrom($user, 'Center for Learning Disabilities');
            $mail->addAddress($txn['email'], $txn['client_name']);
            $mail->isHTML(true);
            $mail->Subject = 'Payment Receipt - Center for Learning Disabilities';
            $mail->Body = $body;
            $mail->send();
            return 'sent';
        } catch (\Exception $e) {
            error_log('Receipt email failed: ' . $e->getMessage());
            return 'failed';
        }
    }

    /** SMS via Arkesel (Ghana). */
    private static function sendSms($txn, $settings) {
        $apiKey = $settings->get('sms_api_key');
        $sender = $settings->get('sms_sender_id') ?: 'CLD';
        if (!$apiKey) return 'not_configured';

        $msg = 'Dear ' . $txn['client_name'] . ', thank you for your payment of GHS ' . number_format($txn['amount'], 2)
            . ' for ' . $txn['description'] . ' at Center for Learning Disabilities. View receipt: ' . self::receiptUrl($txn);

        $url = 'https://sms.arkesel.com/sms/api?' . http_build_query([
            'action' => 'send-sms',
            'api_key' => $apiKey,
            'to' => ltrim($txn['mobile_number'], '+'),
            'from' => substr($sender, 0, 11),
            'sms' => $msg,
        ]);

        $ch = curl_init($url);
        curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 20]);
        $res = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        $json = json_decode((string)$res, true);
        if (!$err && isset($json['code']) && strtolower((string)$json['code']) === 'ok') return 'sent';
        error_log('Receipt SMS failed: ' . ($err ?: $res));
        return 'failed';
    }
}
