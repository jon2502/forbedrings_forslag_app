<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function automail($type,$name,$email){

//create new instance of mail for phpmailer
$mail = new PHPMailer;

// $mail->SMTPDebug = 3;

//send using smtp to send mail from one user to another 
$mail->isSMTP();
//hots er localhost
$mail->Host = 'localhost';
//disaplels STMP authentication
$mail->SMTPAuth = false;
//set port to the same as mailhog
$mail->Port = 1025;

//send from
$mail->setFrom('from@example.com', 'Mailer');
//send to
$mail->addAddress(htmlentities($email),htmlentities($name));
$mail->addAddress('ellen@example.com', 'testuser');
$mail->addReplyTo('info@example.com', 'Information');
$mail->addCC('cc@example.com');
$mail->addBCC('bcc@example.com');

//set mail to be html
$mail->isHTML(true);

//mail content
switch ($type){
    case 0;
        $mail->Subject = 'forslag genovervejet';
        $mail->Body = 'hej '.htmlentities($name).' vi har valgt at tag et kig mere på dit forslag';
        //This is the body in plain text for non-HTML mail clients
        $mail->AltBody = 'hej '.htmlentities($name).' vi har valgt at tag et kig mere på dit forslag';
        break;
    case 1;
        $mail->Subject = 'forslag rejectet';
        $mail->Body = 'hej '.$name.' vi har valgt ikke at gå videre med dit forbedrings forslag';
        //This is the body in plain text for non-HTML mail clients
        $mail->AltBody = 'hej '.$name.' vi har valgt ikke at gå videre med dit forbedrings forslag';
    break;
    case 2;
        $mail->Subject = 'forslag acepteret';
        $mail->Body = 'hej '.$name.' vi har valgt at gå videre med dit forbedrings forslag';
        //This is the body in plain text for non-HTML mail clients
        $mail->AltBody = 'hej '.$name.' vi har valgt at gå videre med dit forbedrings forslag';
        break;
    case 3;
        $mail->Subject = 'forslag modtaget';
        $mail->Body = 'hej '.$name.' vi har modtaget dit forbedrings forslag';
        //This is the body in plain text for non-HTML mail clients
        $mail->AltBody = 'hej '.$name.' vi har modtaget dit forbedrings forslag';
        break;
}

//error for if the mail could not be send
if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
}
?>