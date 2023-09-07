<?php

include "includes/config.php";
include "includes/db_config.php";
$conn = connectDatabase($dsn, $pdoOptions);

if (isset($_POST['phone_id']) && isset($_POST['color'])) {
    $phoneId = $_POST['phone_id'];
    $colorToDelete = $_POST['color'];
    $id_manufacturer = $_POST["id_manufacturer"];

    $sql_check_colors_count = "SELECT COUNT(*) as color_count FROM colors WHERE id_phone = :phone_id";
    $stmt_check_colors_count = $conn->prepare($sql_check_colors_count);
    $stmt_check_colors_count->bindParam(':phone_id', $phoneId, PDO::PARAM_INT);
    $stmt_check_colors_count->execute();
    $result = $stmt_check_colors_count->fetch(PDO::FETCH_ASSOC);
    $colorCount = $result['color_count'];
    if ($colorCount > 1) {
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

            $sql_check_id_manufacturer = "SELECT * FROM manufacturers WHERE id_manufacturer = :id_manufacturer";
            $stmt_check_id_manufacturer = $conn->prepare($sql_check_id_manufacturer);
            $stmt_check_id_manufacturer->bindParam(':id_manufacturer', $id_manufacturer, PDO::PARAM_INT);
            $stmt_check_id_manufacturer->execute();

            if ($stmt_check_id_manufacturer->rowCount() > 0) {
                $manufacturer_data = $stmt_check_id_manufacturer->fetch(PDO::FETCH_ASSOC);
                $manufacturer_name = $manufacturer_data['manufacturer'];

                $file = "phone-img/".$manufacturer_name."/".$phoneId;
                $count = glob($file."/*");

                foreach ($count as $c)
                {
                    if (str_contains($c, $colorToDelete))
                    {
                        unlink($c);
                    }
                }
                header("Location:update_1.php?id_phone=$phoneId&ok=2");

            } else {
                echo "Nincs ilyen gyártó az adatbázisban.";
            }



            echo "A szín sikeresen törölve.";
            header("Location:update_1.php?id_phone=$phoneId&ok=2");
        } else {
            echo "A szín nem található az adott telefonhoz.";
        }
    } else {
        header("Location:update_1.php?id_phone=$phoneId&error=2");
    }
} else {
    header("Location: index.php");
}
?>
