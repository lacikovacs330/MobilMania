<?php

include "includes/functions.php";

$conn = connectDatabase($dsn, $pdoOptions);

$response = array();

if (isset($_POST["email"], $_POST["password1"], $_POST["password2"])) {
    $email = $_POST["email"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];
    $username = substr($email, 0, strpos($email, "@"));
    $token = bin2hex(random_bytes(16));
    $hashed_password = password_hash($password1, PASSWORD_BCRYPT);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"] = "Invalid email address.";
    } elseif ($password1 !== $password2) {
        $response["error"] = "Passwords do not match.";
    } else {
        $sthandler = $conn->prepare("SELECT email FROM users WHERE email = :email");
        $sthandler->bindParam(':email', $email);
        $sthandler->execute();
        if ($sthandler->rowCount() > 0) {
            $response["error"] = "Email already exists.";
        } else {
            $pdoQuery = $conn->prepare("INSERT INTO users (username, password, email, token, status, role) VALUES (?, ?, ?, ?, ?, ?)");
            $pdoQuery->execute([$username, $hashed_password, $email, $token, '0', 'user']);

            if ($pdoQuery) {
                $response["success"] = "Registration successful! Verify email!";

                if (sendMail($token, $email, "Registration")) {

                } else {
                    $response["error"] = "Failed to send email.";
                }
            } else {
                $response["error"] = "Registration failed.";
            }
        }
    }
} else {
    $response["error"] = "Please fill in all fields.";
}

echo json_encode($response);

?>
