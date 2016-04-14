<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'phpmailer/PHPMailerAutoload.php';

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['message'])) {

    //check if any of the inputs are empty
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message'])) {
        $data = array('success' => false, 'message' => 'Please fill out the form completely.');
        echo json_encode($data);
        exit;
    }

    //create an instance of PHPMailer
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPDebug = 2;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";// Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->Port = 465;
    $mail->Username = 'gabriel.escobar@airmatek.com';                 // SMTP username
    $mail->Password = 'gruntykite17';                           // SMTP password
    $mail->SetFrom = $_POST['email'];
    $mail->FromName = $_POST['name'];
    $mail->AddAddress('info@airmatek.com',"Info"); //recipient
    $mail->Subject = $_POST['subject'];
    $mail->Body = "email: " . $_POST['email'] . "\r\n\r\nName: " . $_POST['name'] . "\r\n\r\nMessage: " . stripslashes($_POST['message']);



    if (isset($_POST['ref'])) {
        $mail->Body .= "\r\n\r\nRef: " . $_POST['ref'];
    }

    if(!$mail->send()) {
        $data = array('success' => false, 'message' => 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
        echo json_encode($data);
        exit;
    }
    $data = array('success' => true, 'message' => 'Thanks! We have received your message.');
    echo json_encode($data);

} else {
    $data = array('success' => false, 'message' => 'Please fill out the form completely.');
    echo json_encode($data);

}