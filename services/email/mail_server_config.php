<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . "/vendor/autoload.php";

function setUpMailServer() {
    try {
        $mail = new PHPMailer(true);

        // Server settings
        $mail->isSMTP();                                      // Use SMTP
        $mail->Host       = 'smtp.gmail.com';                 // SMTP server
        $mail->SMTPAuth   = true;                             // Enable authentication
        $mail->Username   = 'thebangrg@gmail.com';           // Your Gmail address
        $mail->Password   = 'gqkn vdsu pszw yobx';              // Gmail App Password (not your login password!)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Encryption
        $mail->Port       = 587;                              // TCP port for TLS

        // Recipients
        $mail->setFrom('thebangrg@gmail.com', 'PTB Blog');
        
        return $mail;
    } catch (Exception $e) {
        throw new Exception("Mail Server Error: {$mail->ErrorInfo}") ;
    }
}

?>