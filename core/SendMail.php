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
            $mail->Username = "teamkottulabs@gmail.com"; // Your email
            $mail->Password = 'zsgw aekx mtzq ghof'; // Your password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom("teamkottulabs@gmail.com", "Kottu_Labs");
            $mail->addAddress($email, "Nadun Madusanka");

            $mail->Subject = "Reservation Confirmation Number";
            $mail->Body = "Name: $name <br/> Reservation Number: $randomNumber";

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