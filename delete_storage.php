<?php

include "includes/config.php";
include "includes/db_config.php";
$conn = connectDatabase($dsn, $pdoOptions);

if (isset($_POST['phone_id']) && isset($_POST['storage'])) {
    $phoneId = $_POST['phone_id'];
    echo $phoneId;
    $storageToDelete = $_POST['storage'];

    $sql_check_storage = "SELECT * FROM storage WHERE id_phone = :phone_id AND storage = :storage";
    $stmt_check_storage = $conn->prepare($sql_check_storage);
    $stmt_check_storage->bindParam(':phone_id', $phoneId, PDO::PARAM_INT);
    $stmt_check_storage->bindParam(':storage', $storageToDelete, PDO::PARAM_STR);
    $stmt_check_storage->execute();

    if ($stmt_check_storage->rowCount() > 0) {
        $sql_delete_storage = "DELETE FROM storage WHERE id_phone = :phone_id AND storage = :storage";
        $stmt_delete_storage = $conn->prepare($sql_delete_storage);
        $stmt_delete_storage->bindParam(':phone_id', $phoneId, PDO::PARAM_INT);
        $stmt_delete_storage->bindParam(':storage', $storageToDelete, PDO::PARAM_STR);
        $stmt_delete_storage->execute();

        echo "A tárhely sikeresen törölve.";
        header("Location:update_1.php?id_phone=$phoneId&ok=1");
    } else {
        echo "A tárhely nem található az adott telefonhoz.";
    }
} else {
    echo "Hiányzó vagy érvénytelen adatok.";
}
