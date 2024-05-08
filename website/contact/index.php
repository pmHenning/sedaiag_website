<?php
require_once __DIR__ . '/../vendor/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../vendor/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Headers ONLY for local development
//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Headers: *');

$env = parse_ini_file(__DIR__ . '../../../.env');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = new PHPMailer(true);

    try {
        //Server settings
//    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
//    $mail->isSMTP();                                            //Send using SMTP
//    $mail->Host       = $env['EMAIL_SMTP_SERVER'];              //Set the SMTP server to send through
//    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
//    $mail->Username   = $env['EMAIL_USERNAME'];                 //SMTP username
//    $mail->Password   = $env['EMAIL_PASSWORD'];                 //SMTP password
//    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
//    $mail->Port       = 465;

        //Recipients
//    $mail->setFrom('from@example.com', 'Mailer');
//    $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
//    $mail->addAddress('ellen@example.com');                     //Name is optional
//    $mail->addReplyTo('info@example.com', 'Information');
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');

        //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
//    $mail->isHTML(true);                                  //Set email format to HTML
//    $mail->Subject = 'Here is the subject';
//    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
//    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

//        $mail->send();

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'status' => true,
            'message' => 'Message has been sent'
        ]);
    } catch (Exception $e) {
        header('Content-Type: application/json; charset=utf-8', true, 400);
        echo json_encode([
            'status' => false,
            'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"
        ]);
    }
} else {
    header("HTTP/1.1 403 Forbidden");
}
