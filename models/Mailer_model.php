<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../models/PHPMailer/src/Exception.php';
require '../../models/PHPMailer/src/PHPMailer.php';
require '../../models/PHPMailer/src/SMTP.php';

function sendMail($email, $name, $sub, $mess)
{
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    //Server settings           
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
    $mail->Username = 'baokhuong6996@gmail.com';                     //SMTP username
    $mail->Password = 'dxgt gaka osov wmmm';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('baokhuong6996@gamil.com', 'Bao Ngoc');
    $mail->addAddress($email, $name);     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $sub;
    $mail->Body = $mess;

    $mail->send();
}

