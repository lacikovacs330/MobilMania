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

function purchaseOK($orderNumber, $email, $subject, $id_phone)
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
        $mail->Body = "
                <html>
            <head>
                <style>
                    body {
                        margin: 0;
                        padding: 0;
                        font-family: Arial, sans-serif;
                    }
                    .container {
                        width: 100%;
                        height: 300px;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }
                    .message {
                        font-size: 18px;
                        padding: 20px;
                        border: 2px solid #999;
                        background-color: lavender;
                        border-radius: 10px;
                        text-align: center;
                        max-width: 90%;
                    }
                </style>
            </head>
        <body>
        <div class='container'>
            <div class='message'>
                <p>Thank you for your order.</p>
                <p>Your order number: <span id='orderNumber'><a href='http://localhost/MobilMania/product.php?id_phone=$id_phone'>$orderNumber</a></span></p><br><br>
                
                <p>If you have any questions or an error has occurred, please contact us: <a href='http://localhost/MobilMania/contact.php'>Contact</a></p>
            </div>
        </div>
        </body>
        </html>
        ";

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

