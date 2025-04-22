<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'] ?? '';
    $email = $_POST['email'] ?? '';
    $body = $_POST['body'] ?? '';

    if ($subject && $email && $body) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ranugalecamwasam2002@gmail.com';
            $mail->Password = 'izdt tdxt bxqx pcpn'; // App password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom($email);
            $mail->addAddress('ranugalecamwasam2002@gmail.com');

            $mail->isHTML(false);
            $mail->Subject = "Contact Form: $subject";
            $mail->Body = "From: $email\n\nMessage:\n$body";

            $mail->send();
            http_response_code(200);
            echo 'Message has been sent';
        } catch (Exception $e) {
            http_response_code(500);
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    } else {
        http_response_code(400);
        echo 'Missing fields';
    }
} else {
    http_response_code(405);
    echo 'Method Not Allowed';
}


