<?php

include "includes/config.php";
include "includes/db_config.php";

session_start();

$conn = connectDatabase($dsn, $pdoOptions);

if (isset($_POST["change-pass-btn"])) {
    if (isset($_SESSION["id_user"])) {
        $userId = $_SESSION["id_user"];

        $currentPassword = $_POST["current_password"];
        $newPassword = $_POST["new_password"];
        $newPasswordConfirm = $_POST["new_password_confirm"];

        if ($newPassword === $newPasswordConfirm) {
            $sql = "SELECT password FROM users WHERE id_user = :userId";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['userId' => $userId]);
            $row = $stmt->fetch();

            if ($row) {
                $storedPassword = $row["password"];

                if (password_verify($currentPassword, $storedPassword)) {
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                    $updateSql = "UPDATE users SET password = :newPassword WHERE id_user = :userId";
                    $stmt = $conn->prepare($updateSql);
                    $stmt->execute(['newPassword' => $hashedPassword, 'userId' => $userId]);

                    header("Location:profile.php?ok=1");
                } else {
                    header("Location:profile.php?error=1");
                }
            } else {
                header("Location:profile.php?error=2");
            }
        } else {
            header("Location:profile.php?error=3");
        }
    } else {
        header("Location:profile.php?error=4");
    }
}

$conn = null;
?>
