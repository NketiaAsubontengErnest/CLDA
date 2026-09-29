<?php
namespace App\Controllers;

use App\Core\Controller;

class TestController extends Controller {
    public function index() {
        $model = $this->model('Test');
        $search = $_GET['q'] ?? null;
        $tests = $model->getAllActive($search);
        $distinctTags = $model->getDistinctTags();
        $this->view('tests/index', [
            'active_page' => 'tests', 
            'tests' => $tests, 
            'search' => $search,
            'distinct_tags' => $distinctTags
        ]);
    }

    public function take($id = null) {
        if (!$id) {
            header('Location: ' . ROOT . '/tests');
            exit;
        }

        $model = $this->model('Test');
        $test = $model->find($id);
        
        if (!$test) {
            header('Location: ' . ROOT . '/tests');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process submission
            $submission_id = $model->createSubmission([
                'test_id' => $id,
                'user_name' => $_POST['user_name'],
                'user_email' => $_POST['user_email'],
                'user_phone' => $_POST['user_phone'],
                'filing_for' => $_POST['filing_for'],
                'assessed_name' => ($_POST['filing_for'] === 'Self') ? $_POST['user_name'] : (!empty($_POST['assessed_name']) ? $_POST['assessed_name'] : $_POST['user_name']),
                'dob' => $_POST['dob'],
                'age' => $_POST['age'],
                'gender' => $_POST['gender'],
                'school_grade' => $_POST['school_grade'] ?? '',
                'assessment_reason' => $_POST['assessment_reason'],
                'status' => 'pending'
            ]);

            // Save answers
            $questions = $model->getQuestions($id);
            foreach ($questions as $q) {
                $answer_text = '';
                $score = 0;
                
                if ($q['type'] == 'checkbox' && isset($_POST['q_' . $q['id']])) {
                    $selected_options = $_POST['q_' . $q['id']];
                    $answer_text = implode(', ', $selected_options);
                    
                    // Calculate score for checkbox
                    $options = json_decode($q['options'], true);
                    if ($options) {
                        foreach ($options as $opt) {
                            if (is_array($opt)) {
                                if (in_array($opt['text'], $selected_options)) {
                                    $score += $opt['score'];
                                }
                            }
                        }
                    }
                } elseif (isset($_POST['q_' . $q['id']])) {
                    $answer_text = $_POST['q_' . $q['id']];
                    
                    // Calculate score for radio/text
                    $options = json_decode($q['options'], true);
                    if ($options) {
                        foreach ($options as $opt) {
                            if (is_array($opt) && $opt['text'] == $answer_text) {
                                $score = $opt['score'];
                                break;
                            }
                        }
                    }
                }

                $model->saveAnswer([
                    'submission_id' => $submission_id,
                    'question_id' => $q['id'],
                    'answer_text' => $answer_text,
                    'score' => $score
                ]);
            }

            // Send Email to Admin
            $subject = "New Test Submission: " . $test['title'];
            $body = "New submission from " . $_POST['user_name'] . " (" . $_POST['user_email'] . ") for test: " . $test['title'] . ".<br>Status: Pending Payment<br>Phone: " . $_POST['user_phone'];
            $this->sendEmail($subject, $body);

            // Send Payment Notification Email to Client
            $client_subject = "Action Required: Complete Payment for " . $test['title'];
            $payment_url = ROOT . '/tests/complete/' . $submission_id;
            
            $client_body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; color: #333; border: 1px solid #eee; border-radius: 8px; overflow: hidden;'>
                <div style='background-color: #ffffff; padding: 20px; text-align: center; border-bottom: 2px solid #0d6efd;'>
                    <img src='" . ROOT . "/assets/img/logo.png' alt='Center for Learning Disabilities' style='height: 80px; margin-bottom: 10px;'>
                    <h2 style='margin: 0; color: #000; font-size: 20px;'>Center for Learning Disabilities</h2>
                </div>
                <div style='text-align: center; font-weight: bold; margin-top: 20px; font-size: 12px; letter-spacing: 1px; color: #0d6efd;'>
                    PENDING PAYMENT
                </div>
                <div style='padding: 20px 30px;'>
                    <p>Dear " . htmlspecialchars($_POST['user_name']) . ",</p>
                    <p>Thank you for submitting the <strong>" . htmlspecialchars($test['title']) . "</strong>.</p>
                    <p>To receive your comprehensive report and analysis, a payment of GH₵ " . number_format($test['price'], 2) . " is required.</p>
                    <p>Click the button below to complete your payment securely.</p>
                    <div style='text-align: center; margin: 30px 0;'>
                        <a href='" . $payment_url . "' style='background-color: #0d6efd; color: white; text-decoration: none; padding: 14px 30px; border-radius: 50px; font-weight: bold; display: inline-block;'>Complete Payment</a>
                    </div>
                    <hr style='border: none; border-top: 1px solid #eee; margin: 30px 0;'>
                    <p style='font-size: 14px;'>If you have any questions or feedback, our customer success team is eager to assist. Simply reply to this email, and we'll be right with you.</p>
                    <p style='font-size: 14px;'>Kind Regards,<br><strong>The Center for Learning Disabilities Team</strong></p>
                </div>
                <div style='background-color: #f8f9fa; padding: 20px; text-align: center; font-style: italic; color: #666; font-size: 13px;'>
                    Center for Learning Disabilities's mission is to help children with learning differences thrive through comprehensive assessment and support.
                </div>
            </div>
            ";
            
            $this->sendEmailToClient($_POST['user_email'], $_POST['user_name'], $client_subject, $client_body);

            // Redirect to completion page
            header('Location: ' . ROOT . '/tests/complete/' . $submission_id);
            exit;
        }

        $questions = $model->getQuestions($id);
        $this->view('tests/take', ['active_page' => 'tests', 'test' => $test, 'questions' => $questions]);
    }

    public function take_walkin($id = null) {
        if (!$id) {
            header('Location: ' . ROOT . '/tests');
            exit;
        }

        $model = $this->model('Test');
        $test = $model->find($id);
        
        if (!$test) {
            header('Location: ' . ROOT . '/tests');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process submission
            $submission_id = $model->createSubmission([
                'test_id' => $id,
                'user_name' => $_POST['user_name'],
                'user_email' => $_POST['user_email'],
                'user_phone' => $_POST['user_phone'],
                'filing_for' => $_POST['filing_for'],
                'assessed_name' => ($_POST['filing_for'] === 'Self') ? $_POST['user_name'] : (!empty($_POST['assessed_name']) ? $_POST['assessed_name'] : $_POST['user_name']),
                'dob' => $_POST['dob'],
                'age' => $_POST['age'],
                'gender' => $_POST['gender'],
                'school_grade' => $_POST['school_grade'] ?? '',
                'assessment_reason' => $_POST['assessment_reason'],
                'status' => 'paid' // Automatically paid for walk-ins
            ]);

            // Save answers
            $questions = $model->getQuestions($id);
            foreach ($questions as $q) {
                $answer_text = '';
                $score = 0;
                
                if ($q['type'] == 'checkbox' && isset($_POST['q_' . $q['id']])) {
                    $selected_options = $_POST['q_' . $q['id']];
                    $answer_text = implode(', ', $selected_options);
                    
                    $options = json_decode($q['options'], true);
                    if ($options) {
                        foreach ($options as $opt) {
                            if (is_array($opt)) {
                                if (in_array($opt['text'], $selected_options)) {
                                    $score += $opt['score'];
                                }
                            }
                        }
                    }
                } elseif (isset($_POST['q_' . $q['id']])) {
                    $answer_text = $_POST['q_' . $q['id']];
                    
                    $options = json_decode($q['options'], true);
                    if ($options) {
                        foreach ($options as $opt) {
                            if (is_array($opt) && $opt['text'] == $answer_text) {
                                $score = $opt['score'];
                                break;
                            }
                        }
                    }
                }

                $model->saveAnswer([
                    'submission_id' => $submission_id,
                    'question_id' => $q['id'],
                    'answer_text' => $answer_text,
                    'score' => $score
                ]);
            }

            // Send Email to Admin (only)
            $subject = "New Walk-in Test Submission: " . $test['title'];
            $body = "New walk-in submission from " . $_POST['user_name'] . " (" . $_POST['user_email'] . ") for test: " . $test['title'] . ".<br>Status: Paid (Walk-in)<br>Phone: " . $_POST['user_phone'];
            $this->sendEmail($subject, $body);

            // Redirect to completion page
            header('Location: ' . ROOT . '/tests/complete/' . $submission_id);
            exit;
        }

        $questions = $model->getQuestions($id);
        $this->view('tests/take', ['active_page' => 'tests', 'test' => $test, 'questions' => $questions, 'is_walkin' => true]);
    }

    public function complete($submission_id) {
        $model = $this->model('Test');
        $submission = $model->getSubmission($submission_id);

        if (!$submission) {
            header('Location: ' . ROOT . '/tests');
            exit;
        }
        
        // Get Paystack Public Key for frontend
        $settingModel = $this->model('Setting');
        $publicKey = $settingModel->get('paystack_public_key');

        $this->view('tests/complete', ['active_page' => 'tests', 'submission' => $submission, 'paystack_public_key' => $publicKey]);
    }

    public function initialize_payment($submission_id) {
        $model = $this->model('Test');
        $submission = $model->getSubmission($submission_id);

        if (!$submission) {
            header('Location: ' . ROOT . '/tests'); exit;
        }

        $settingModel = $this->model('Setting');
        $secretKey = $settingModel->get('paystack_secret_key');

        if (!$secretKey) {
            die('Paystack Secret Key not configured.');
        }

        $url = "https://api.paystack.co/transaction/initialize";
        $fields = [
            'email' => $submission['user_email'],
            'amount' => ($submission['price'] * 100), // Amount in kobo
            'reference' => 'TEST_' . $submission_id . '_' . time(),
            'callback_url' => ROOT . '/tests/callback/' . $submission_id,
            'metadata' => [
                'submission_id' => $submission_id,
                'test_title' => $submission['test_title']
            ]
        ];

        $fields_string = http_build_query($fields);

        //open connection
        $ch = curl_init();
        
        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer " . $secretKey,
            "Cache-Control: no-cache",
        ));
        
        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        
        //execute post
        $result = curl_exec($ch);
        $response = json_decode($result, true);
        
        if ($response['status']) {
            header('Location: ' . $response['data']['authorization_url']);
            exit;
        } else {
            die('Paystack Initialization Error: ' . $response['message']);
        }
    }

    public function callback($submission_id) {
        $reference = $_GET['reference'];
        if (!$reference) {
            die('No reference supplied');
        }

        $settingModel = $this->model('Setting');
        $secretKey = $settingModel->get('paystack_secret_key');

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $secretKey,
                "Cache-Control: no-cache",
            ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $result = json_decode($response, true);
            if ($result['data']['status'] == 'success') {
                // Payment successful
                $model = $this->model('Test');
                $model->updateSubmissionStatus($submission_id, 'paid');

                // Send Email to Admin
                $submission = $model->getSubmission($submission_id);

                // Record the transaction and send the receipt (skipped if the webhook already did)
                $txn = $this->model('Transaction')->recordOnline($submission, $reference, $result['data']['amount'] / 100);
                if ($txn) \App\Core\Notifier::sendReceipt($txn);

                $subject = "Payment Received: " . $submission['test_title'];
                $body = "Payment received from " . $submission['user_name'] . " (" . $submission['user_email'] . ") for test: " . $submission['test_title'] . ".<br>Amount: " . $submission['price'];
                $this->sendEmail($subject, $body);

                header('Location: ' . ROOT . '/tests/complete/' . $submission_id . '?payment=success');
                exit;
            } else {
                echo "Transaction verification failed: " . $result['message'];
            }
        }
    }

    public function report($submission_id) {
        $model = $this->model('Test');
        $submission = $model->getSubmission($submission_id);

        if (!$submission || $submission['status'] != 'completed') {
            die('Report not found or not yet completed.');
        }

        $answers = $model->getAnswers($submission_id);

        // Render standard print view
        $this->view('admin/tests/submission_print', [
            'submission' => $submission, 
            'answers' => $answers
        ]);
    }
    private function sendEmail($subject, $body) {
        require_once '../public/phpmailer/Exception.php';
        require_once '../public/phpmailer/PHPMailer.php';
        require_once '../public/phpmailer/SMTP.php';

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'cldaghana@gmail.com'; 
            $mail->Password   = 'tcod eiqx fjib gqnq';  
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('cldaghana@gmail.com', 'CLD Website');
            $mail->addAddress('cldaghana@gmail.com'); // Admin email

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (\Exception $e) {
            // Log error or just return false
            return false;
        }
    }

    private function sendEmailToClient($to_email, $to_name, $subject, $body) {
        require_once '../public/phpmailer/Exception.php';
        require_once '../public/phpmailer/PHPMailer.php';
        require_once '../public/phpmailer/SMTP.php';

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'cldaghana@gmail.com'; 
            $mail->Password   = 'tcod eiqx fjib gqnq';  
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('cldaghana@gmail.com', 'Center for Learning Disabilities');
            $mail->addAddress($to_email, $to_name);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
