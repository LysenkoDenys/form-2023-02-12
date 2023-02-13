<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';

$mail=new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('en', 'phpmailer/language/');

// from whom the letter:
$mail->setForm('lysenkoden@gmail.com', 'freelancer');
// to whom the letter:
$mail->setAddress('lysenkoden@gmail.com');
// subject of the letter:
$mail->Subject('Hello');

// hand:
$hand = 'Right';
if($POST['hand']=='left'){
  $hand='Left';
}

// post body:
$body='<h1>Meet the super letter!</h1>';

if(trim(!empty($_POST['name']))){
  $body.='<p><strong>Name:</strong> '.$POST['name'].'</p>';
}
if(trim(!empty($_POST['email']))){
  $body.='<p><strong>E-mail:</strong> '.$POST['email'].'</p>';
}
if(trim(!empty($_POST['hand']))){
  $body.='<p><strong>Hand:</strong> '.$hand.'</p>';
}
if(trim(!empty($_POST['age']))){
  $body.='<p><strong>Age:</strong> '.$POST['age'].'</p>';
}
if(trim(!empty($_POST['message']))){
  $body.='<p><strong>Message:</strong> '.$POST['message'].'</p>';
}

// attach the file:
if(!empty($_FILES['image']['tmp_name'])){
  // path of uploading file:
$filePath = __DIR__ . '/files/' . $_FILES['image']['name'];
//load the file:
if(copy($_FILES['image']['tmp_name'], $filePath)){
  $fileAttach=$filePath;
  $body.='<p><strong>Photo in attachment</strong></p>';
  $mail->addAttachment($fileAttach);
}
}

$mail->Body = $body;

// send:
if (!$mail->send()){
  $message = 'Error';
} else {
  $message = 'Data has sended!';
}

$response = ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);
?>