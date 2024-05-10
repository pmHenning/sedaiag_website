<?php
require_once __DIR__ . '/vendor/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/vendor/phpmailer/src/Exception.php';
require_once __DIR__ . '/vendor/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Headers ONLY for local development
//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Headers: *');

$env = parse_ini_file(__DIR__ . '/../.env');
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = new PHPMailer(true);

    try {
        //Server settings
//    $mail->SMTPDebug = SMTP::DEBUG_CONNECTION;                  //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $env['EMAIL_SMTP_SERVER'];              //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $env['EMAIL_USERNAME'];                 //SMTP username
    $mail->Password   = $env['EMAIL_PASSWORD'];                 //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption
    $mail->Port       = (int)$env['EMAIL_SMTP_PORT'];

        //Recipients
    $mail->setFrom($env['EMAIL_USERNAME'], 'SedaiAG Website');
    $mail->addAddress('investorrelations@sedai.ag');     //Add a recipient
//    $mail->addAddress('ellen@example.com');               //Name is optional
//    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('henning.kurella@sedai-now.com');
//    $mail->addBCC('bcc@example.com');

        //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
    $formData = json_decode(file_get_contents("php://input"), true);
    $template = file_get_contents(__DIR__ . '/contact_email.html');
    $content = str_replace([
        '{name}',
        '{email}',
        '{phone}',
        '{investment_amount}',
        '{message}',
        '{data_protection}',
    ], [
        $formData['name'] . ' ' . $formData['surname'],
        $formData['email'],
        $formData['phone'],
        $formData['investment_amount'],
        $formData['message'],
        $formData['data_protection'] === 'on' ? 'yes' : 'no',
    ], $template);

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Contact request from website';
    $mail->Body    = $content;
//    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();

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
