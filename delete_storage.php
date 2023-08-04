<?php

include "includes/config.php";
include "includes/db_config.php";
$conn = connectDatabase($dsn, $pdoOptions);

if (isset($_POST['phone_id']) && isset($_POST['storage'])) {
    $phoneId = $_POST['phone_id'];
    $storageToDelete = $_POST['storage'];

    $sql_check_storages_count = "SELECT COUNT(*) as storage_count FROM storage WHERE id_phone = :phone_id";
    $stmt_check_storages_count = $conn->prepare($sql_check_storages_count);
    $stmt_check_storages_count->bindParam(':phone_id', $phoneId, PDO::PARAM_INT);
    $stmt_check_storages_count->execute();
    $result = $stmt_check_storages_count->fetch(PDO::FETCH_ASSOC);
    $storageCount = $result['storage_count'];

    if ($storageCount > 1) {
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
        header("Location:update_1.php?id_phone=$phoneId&error=1");
    }
} else {
    echo "Hiányzó vagy érvénytelen adatok.";
}
?>
