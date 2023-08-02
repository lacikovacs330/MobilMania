<?php
include "includes/config.php";
include "includes/db_config.php";

$conn = connectDatabase($dsn, $pdoOptions);


if (isset($_POST["phone_id"]) && isset($_POST["quantity_number"])) {
    $phone_id = $_POST["phone_id"];
    $quantity_number = $_POST["quantity_number"];

    if (!is_numeric($quantity_number)) {
        header("Location: update_1.php?id_phone=$phone_id&error=5000");
        exit;
    }

    if ($quantity_number < 5) {
        header("Location:update_1.php?id_phone=$phone_id&error=5002");
        exit;
    }

    $sql_check_phone = "SELECT COUNT(*) as count FROM quantity WHERE id_phone = :phone_id";
    $stmt = $conn->prepare($sql_check_phone);
    $stmt->bindParam(':phone_id', $phone_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] === '0') {
        $sql_insert_quantity = "INSERT INTO quantity (id_phone, number) VALUES (:phone_id, :quantity_number)";
        $stmt = $conn->prepare($sql_insert_quantity);
        $stmt->bindParam(':phone_id', $phone_id);
        $stmt->bindParam(':quantity_number', $quantity_number);
        $stmt->execute();

        header("Location: update_1.php?id_phone=$phone_id&error=5001");
        exit;
    }
    else
    {
        $sql_update_quantity = "UPDATE quantity SET number = :quantity_number WHERE id_phone = :phone_id";
        $stmt = $conn->prepare($sql_update_quantity);
        $stmt->bindParam(':quantity_number', $quantity_number);
        $stmt->bindParam(':phone_id', $phone_id);
        $stmt->execute();

        header("Location: add_phones.php?id_phone=$phone_id&ok=5");
        exit;
    }
} else {
    if (isset($_POST["phone_id"])) {
        $phone_id = $_POST["phone_id"];
        header("Location: update_1.php?id_phone=$phone_id&error=missing_fields");
        exit;
    } else {
        header("Location: update_1.php?error=missing_fields");
        exit;
    }
}

