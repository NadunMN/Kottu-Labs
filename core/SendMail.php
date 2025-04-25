<?php
namespace app\core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SendMail
{
    public static SendMail $sendmail;

    public function __construct()
    {
        self::$sendmail = $this;
    }

    public function sendMail($email, $name, $randomNumber)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = "thiraniimanya@gmail.com"; // Your email
            $mail->Password = 'abag psvp ipmi fjxd'; // Your password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom("thiraniimanya@gmail.com", "Kottu Labs");
            $mail->addAddress($email, $name);

            // HTML Email Body
            $htmlBody = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reservation Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 20px auto; background-color: #f8f9fa; border-radius: 10px; overflow: hidden;">
        <div style="background-color: #2c3e50; padding: 20px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0;">Kottu Labs</h1>
        </div>

        <div style="padding: 30px 20px;">
            <h2 style="color: #2c3e50; margin-top: 0;">Reservation Confirmation</h2>
            <p style="margin-bottom: 15px;">Hello <strong>{$name}</strong>,</p>
            <p style="margin-bottom: 15px;">Your reservation has been successfully created!</p>
            
            <div style="background-color: #ffffff; padding: 20px; border-radius: 8px; text-align: center; margin: 20px 0;">
                <h3 style="margin: 0 0 10px 0; color: #2c3e50;">Reservation Number</h3>
                <div style="font-size: 24px; font-weight: bold; color: #e74c3c;">{$randomNumber}</div>
            </div>

            <p style="margin-bottom: 15px;">Please present this reservation number when you arrive.</p>
            <p style="margin-bottom: 20px;">If you have any questions or need to modify your reservation, contact us at <a href="mailto:support@kottulabs.com" style="color: #3498db; text-decoration: none;">support@kottulabs.com</a></p>
        </div>

        <div style="background-color: #2c3e50; padding: 15px; text-align: center;">
            <p style="color: #ffffff; margin: 5px 0; font-size: 12px;">
                © " . date('Y') . " Kottu Labs. All rights reserved.<br>
                123 Lab Street, Tech City, TC 12345
            </p>
        </div>
    </div>
</body>
</html>
HTML;

            // Plain text version for non-HTML mail clients
            $textBody = "Hello {$name},\n\nYour reservation number is: {$randomNumber}\n\nPlease present this number when you arrive.\n\nKottu Labs\n123 Lab Street, Tech City, TC 12345";

            $mail->Subject = "Reservation Confirmation - Kottu Labs";
            $mail->Body = $htmlBody;
            $mail->AltBody = $textBody;
            $mail->isHTML(true);

            if ($mail->send()) {
                echo "Mail sent!";
            } else {
                echo "Something went wrong. Please try again." . $mail->ErrorInfo;
            }
        } catch (\Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

// Initialize the SendMail class
new SendMail();
?>