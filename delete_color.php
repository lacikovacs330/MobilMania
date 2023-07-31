<?php

include "includes/config.php";
include "includes/db_config.php";
$conn = connectDatabase($dsn, $pdoOptions);

if (isset($_POST['phone_id']) && isset($_POST['color'])) {
    $phoneId = $_POST['phone_id'];
    $colorToDelete = $_POST['color'];

    $sql_check_color = "SELECT * FROM colors WHERE id_phone = :phone_id AND color = :color";
    $stmt_check_color = $conn->prepare($sql_check_color);
    $stmt_check_color->bindParam(':phone_id', $phoneId, PDO::PARAM_INT);
    $stmt_check_color->bindParam(':color', $colorToDelete, PDO::PARAM_STR);
    $stmt_check_color->execute();

    if ($stmt_check_color->rowCount() > 0) {
        $sql_delete_color = "DELETE FROM colors WHERE id_phone = :phone_id AND color = :color";
        $stmt_delete_color = $conn->prepare($sql_delete_color);
        $stmt_delete_color->bindParam(':phone_id', $phoneId, PDO::PARAM_INT);
        $stmt_delete_color->bindParam(':color', $colorToDelete, PDO::PARAM_STR);
        $stmt_delete_color->execute();

        echo "A szín sikeresen törölve.";
        header("Location:update_1.php?id_phone=$phoneId&ok=2");
    } else {
        echo "A szín nem található az adott telefonhoz.";
    }
} else {
    echo "Hiányzó vagy érvénytelen adatok.";
}
