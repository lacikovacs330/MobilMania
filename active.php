<?php

require "includes/functions.php";

session_start();

$conn = connectDatabase($dsn, $pdoOptions);

if (isset($_SESSION["id_user"])) {
    $sql = "SELECT * FROM users WHERE id_user = '$_SESSION[id_user]'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        foreach ($results as $row) {
            if ($row["role"] != "admin") {
                header("Location:index.php");
            }
        }
    }
} else {
    header("Location:index.php");
}


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