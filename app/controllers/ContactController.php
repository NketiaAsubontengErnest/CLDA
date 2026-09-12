<?php
namespace App\Controllers;

use App\Core\Controller;

class ContactController extends Controller {
    public function index() {
        $data = [
            'active_page' => 'contact',
            'page_title' => 'Contact Us - Book an Assessment at CLD'
        ];
        $this->view('contact', $data);
    }

    public function process() {
        // Logic from process_contact.php will go here or call a model
        require_once '../public/phpmailer/Exception.php';
        require_once '../public/phpmailer/PHPMailer.php';
        require_once '../public/phpmailer/SMTP.php';

        header('Content-Type: application/json');
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = strip_tags(trim($_POST["name"] ?? ""));
            $email = filter_var(trim($_POST["email"] ?? ""), FILTER_SANITIZE_EMAIL);
            $phone = strip_tags(trim($_POST["phone"] ?? ""));
            $message = trim($_POST["message"] ?? "");

            if (empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                echo json_encode(["status" => "error", "message" => "Please complete the form and provide a valid email address."]);
                exit;
            }

            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'nketiaernest18@gmail.com'; 
                $mail->Password   = 'YOUR_GMAIL_APP_PASSWORD';  
                $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom('info@cldghana.com', 'CLD Website');
                $mail->addAddress('nketiaernest18@gmail.com');
                $mail->addReplyTo($email, $name);

                $mail->isHTML(false);
                $mail->Subject = "New Contact from $name via CLD Website";
                $mail->Body    = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";

                $mail->send();
                echo json_encode(["status" => "success", "message" => "Thank you! Your message has been sent."]);
            } catch (\Exception $e) {
                echo json_encode(["status" => "error", "message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
            }
        } else {
            http_response_code(403);
            echo json_encode(["status" => "error", "message" => "Access denied."]);
        }
        exit;
    }
}
