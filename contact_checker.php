<?php

session_start();

include "includes/config.php";
include "includes/db_config.php";

$conn = connectDatabase($dsn, $pdoOptions);

if (isset($_POST["contact-btn"]) and isset($_POST["email"]) and !empty($_POST["email"])  and isset($_POST["mobile"]) and !empty($_POST["mobile"])  and isset($_POST["message"]) and !empty($_POST["message"])) {
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $message = $_POST["message"];
    $id_user = $_SESSION["id_user"];

    if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
        header("Location: contact.php?error=1");
        exit;
    }

    if (!preg_match('/^\d{1,15}$/', $mobile)) {
        // Redirect back to contact form with an error message
        header("Location: contact.php?error=2");
        exit;
    }

    if (empty($message)) {
        header("Location: contact.php?error=3");
        exit;
    }

    $pdoQuery = $conn->prepare("INSERT INTO contact (id_user, email, mobile, message) VALUES (?,?,?,?)");
    $pdoQuery->execute([$id_user, $email, $mobile, $message]);

    header("Location: contact.php?ok=1");
}
else
{
    header("Location: contact.php?error=4");
}
