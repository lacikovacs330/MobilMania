<?php

require "config.php";
require "db_config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$conn = connectDatabase($dsn, $pdoOptions);

function sendMail($token, $email, $subject)
{
    require 'vendor/autoload.php';
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Username = 'lacikovacs330@gmail.com';
        $mail->Password = 'qawtdwgbfieyptso';

        $mail->setFrom('lacikovacs330@gmail.com', 'MobilMania');
        $mail->addAddress($email, 'User');

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "Erősítsd meg a regisztrációt: <a href='http://localhost/MobilMania/active.php?token=$token'><b>Megerősítés</b></a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}


function redirection($url)
{
    header("Location:$url");
    exit();
}

