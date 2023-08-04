<?php
include "includes/config.php";
include "includes/db_config.php";

$conn = connectDatabase($dsn, $pdoOptions);

if (isset($_POST["phone_id"]) && isset($_POST["quantity_number"]) && !empty($_POST["quantity_number"]) && isset($_POST["color"]) && !empty($_POST["color"])) {
    $phone_id = $_POST["phone_id"];
    $color = $_POST["color"];
    $quantity_number = $_POST["quantity_number"];

    if (!is_numeric($quantity_number)) {
        header("Location: update_1.php?id_phone={$phone_id}&error=5000");
        exit;
    }

    if ($quantity_number < 5) {
        header("Location: update_1.php?id_phone={$phone_id}&error=5002");
        exit;
    }

    $sql_update = "UPDATE colors SET quantity = :quantity WHERE id_phone = :phone_id AND color = :color";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->execute(array(
        ':quantity' => $quantity_number,
        ':phone_id' => $phone_id,
        ':color' => $color
    ));

    header("Location: update_1.php?id_phone={$phone_id}&ok=5");
} else {
    $phone_id = $_POST["phone_id"];
    header("Location: update_1.php?id_phone={$phone_id}&error=5001");
}
?>
