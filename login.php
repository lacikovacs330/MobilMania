<?php
session_start();

include "includes/config.php";
include "includes/db_config.php";

$conn = connectDatabase($dsn, $pdoOptions);

$response = array();

if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->query("SELECT * FROM users WHERE username = '$username'");
    if ($row = $stmt->fetch()) {
        $username1 = $row["username"];
        $id_user = $row["id_user"];
        $_SESSION["un"] = $username1;
        $_SESSION["id_user"] = $id_user;
        $pass = $row["password"];
        $_SESSION["password1"] = $pass;
        $status = $row["status"];

        if (password_verify($password, $pass)) {
            if ($status === 0) {
                $response["error"] = "Invalid username or password.";
            } else {
                $response["redirect"] = "index.php";
            }
        } else {
            $response["error"] = "Invalid username or password.";
        }
    } else {
        $response["error"] = "Invalid username or password.";
    }
} else {
    $response["error"] = "Please enter a username and password.";
}

echo json_encode($response);
?>
