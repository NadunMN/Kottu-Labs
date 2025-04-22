<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Check for AJAX request or form submission
if(isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['body'])){

    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];
    
    // Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 0; // Set to 0 for production
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ranugalecamwasam2002@gmail.com';
        
        // IMPORTANT: Store this in a configuration file or use environment variables
        $mail->Password = 'vlunrmdywjygjdps'; // Use Gmail App Password, not your regular password
        
        // Use STARTTLS for port 587
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('ranugalecamwasam2002@gmail.com', 'Kottu Labs');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'KOTTU-LABS: ' . $subject;
        $mail->Body = "Thank you for your message on " . $subject . ":" . $body ."<br><br><p>We will get back to you soon.</p>";
        $mail->AltBody = "Thank you for your message on " . $subject . ":" . $body .". We will get back to you soon.";

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
else
{
    echo "Missing required parameters";
}
?>