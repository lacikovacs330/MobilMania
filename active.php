<?php

require "includes/functions.php";

$code = "";

$connection = connectDatabase($dsn, $pdoOptions);

$token = $_GET['token'];

if (!empty($token)){

    $sql = "UPDATE users SET status = 1  WHERE token = :token";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        redirection('index.php?r=6');
    }
    else {
        redirection('index.php?r=11');
    }
}
else {
    redirection('index.php?r=0');
}