<?php

include "includes/config.php";
include "includes/db_config.php";
$conn = connectDatabase($dsn, $pdoOptions);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone_id = $_POST['phone_id'];
    $model = $_POST['model'];
    $price = $_POST['price'];

    $sql_update_phone = "UPDATE phones SET price='$price' WHERE id_phone='$phone_id'";

    if ($conn->query($sql_update_phone)) {
        echo "Sikeres árfrissítés!";
        header("Location:update_1.php?id_phone=$phone_id&ok=3");
    } else {
        $errorInfo = $conn->errorInfo();
        echo "Sikertelen árfrissítés: " . $errorInfo[2];
    }
}
