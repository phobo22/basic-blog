<?php

require_once __DIR__ . "/mail_server_config.php";

function sendRecoveryEmail($to, $name, $token) {
    try {
        $mailServer = setUpMailServer();

        // Recipients
        $mailServer->addAddress($to, $name);
        $mailServer->addReplyTo('thebangrg@gmail.com', 'RepPTB Blog');

        // Content
        $mailServer->isHTML(true);
        $mailServer->Subject = 'Reset Password';
        $mailServer->Body    = "<h2>Hello, {$name} !</h2><p>Click this <a href=\"http://localhost/my-web/basic-blog/static/page/recovery_pwd.php?token={$token}\">link</a> to reset your password (valid 1 hour from now). If you didn't request this, ignore this email.</p>";
        //$mailServer->AltBody = 'Hello! This is a test email sent using PHPMailer via Gmail SMTP.';

        // Send the email
        $mailServer->send();
    } catch (Exception $e) {
        throw new Exception("Error when sending mail: {$mailServer->ErrorInfo}");
    }
}

?>