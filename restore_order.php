<?php
include "includes/config.php";
include "includes/db_config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["order_number"])) {
        $orderNumber = $_POST["order_number"];

        $conn = connectDatabase($dsn, $pdoOptions);

        // Lekérdezzük az archivált rendelést az archived_order táblából
        $sql_fetch_archived_order = "SELECT * FROM archived_order WHERE order_number = :order_number";
        $stmt_fetch_archived_order = $conn->prepare($sql_fetch_archived_order);
        $stmt_fetch_archived_order->bindParam(":order_number", $orderNumber, PDO::PARAM_STR);
        $stmt_fetch_archived_order->execute();
        $archivedOrder = $stmt_fetch_archived_order->fetch(PDO::FETCH_ASSOC);

        if ($archivedOrder) {
            $sql_insert_order = "INSERT INTO orders (id_phone, order_number, color, quantity, price, storage, id_user, firstname, lastname, phonenumber, delivery_method, city, postOffice, date) 
                VALUES (:id_phone, :order_number, :color, :quantity, :price, :storage, :id_user, :firstname, :lastname, :phonenumber, :delivery_method, :city, :postOffice, :date)";

            $stmt_insert_order = $conn->prepare($sql_insert_order);
            $stmt_insert_order->bindParam(":id_phone", $archivedOrder['id_phone'], PDO::PARAM_INT);
            $stmt_insert_order->bindParam(":order_number", $archivedOrder['order_number'], PDO::PARAM_STR);
            $stmt_insert_order->bindParam(":color", $archivedOrder['color'], PDO::PARAM_STR);
            $stmt_insert_order->bindParam(":quantity", $archivedOrder['quantity'], PDO::PARAM_INT);
            $stmt_insert_order->bindParam(":price", $archivedOrder['price'], PDO::PARAM_STR);
            $stmt_insert_order->bindParam(":storage", $archivedOrder['storage'], PDO::PARAM_STR);
            $stmt_insert_order->bindParam(":id_user", $archivedOrder['id_user'], PDO::PARAM_INT);
            $stmt_insert_order->bindParam(":firstname", $archivedOrder['firstname'], PDO::PARAM_STR);
            $stmt_insert_order->bindParam(":lastname", $archivedOrder['lastname'], PDO::PARAM_STR);
            $stmt_insert_order->bindParam(":phonenumber", $archivedOrder['phonenumber'], PDO::PARAM_STR);
            $stmt_insert_order->bindParam(":delivery_method", $archivedOrder['delivery_method'], PDO::PARAM_STR);
            $stmt_insert_order->bindParam(":city", $archivedOrder['city'], PDO::PARAM_STR);
            $stmt_insert_order->bindParam(":postOffice", $archivedOrder['postOffice'], PDO::PARAM_STR);
            $stmt_insert_order->bindParam(":date", $archivedOrder['date'], PDO::PARAM_STR);

            if ($stmt_insert_order->execute()) {
                $sql_delete_archived_order = "DELETE FROM archived_order WHERE order_number = :order_number";
                $stmt_delete_archived_order = $conn->prepare($sql_delete_archived_order);
                $stmt_delete_archived_order->bindParam(":order_number", $orderNumber, PDO::PARAM_STR);
                $stmt_delete_archived_order->execute();

                echo "Order restored successfully!";
            } else {
                echo "Failed to restore order.";
            }
        } else {
            echo "Archived order not found!";
        }
    } else {
        echo "Invalid request!";
    }
}
?>
