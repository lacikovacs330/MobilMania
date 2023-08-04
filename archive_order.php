<?php
include "includes/config.php";
include "includes/db_config.php";

$conn = connectDatabase($dsn, $pdoOptions);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["order_number"])) {
        $orderNumber = $_POST["order_number"];

        $sql_fetch_order = "SELECT * FROM orders WHERE order_number = :order_number";
        $stmt_fetch_order = $conn->prepare($sql_fetch_order);
        $stmt_fetch_order->bindParam(":order_number", $orderNumber, PDO::PARAM_STR);
        $stmt_fetch_order->execute();
        $order = $stmt_fetch_order->fetch(PDO::FETCH_ASSOC);

        if ($order) {
            $sql_insert_archived_order = "INSERT INTO archived_order (id_order, id_phone, order_number, color, quantity, price, storage, id_user, firstname, lastname, phonenumber, delivery_method, city, postOffice, date) 
                VALUES (:id_order, :id_phone, :order_number, :color, :quantity, :price, :storage, :id_user, :firstname, :lastname, :phonenumber, :delivery_method, :city, :postOffice, :date)";

            $stmt_insert_archived_order = $conn->prepare($sql_insert_archived_order);
            $stmt_insert_archived_order->bindParam(":id_order", $order['id_order'], PDO::PARAM_INT);
            $stmt_insert_archived_order->bindParam(":id_phone", $order['id_phone'], PDO::PARAM_INT);
            $stmt_insert_archived_order->bindParam(":order_number", $order['order_number'], PDO::PARAM_STR);
            $stmt_insert_archived_order->bindParam(":color", $order['color'], PDO::PARAM_STR);
            $stmt_insert_archived_order->bindParam(":quantity", $order['quantity'], PDO::PARAM_INT);
            $stmt_insert_archived_order->bindParam(":price", $order['price'], PDO::PARAM_STR);
            $stmt_insert_archived_order->bindParam(":storage", $order['storage'], PDO::PARAM_STR);
            $stmt_insert_archived_order->bindParam(":id_user", $order['id_user'], PDO::PARAM_INT);
            $stmt_insert_archived_order->bindParam(":firstname", $order['firstname'], PDO::PARAM_STR);
            $stmt_insert_archived_order->bindParam(":lastname", $order['lastname'], PDO::PARAM_STR);
            $stmt_insert_archived_order->bindParam(":phonenumber", $order['phonenumber'], PDO::PARAM_STR);
            $stmt_insert_archived_order->bindParam(":delivery_method", $order['delivery_method'], PDO::PARAM_STR);
            $stmt_insert_archived_order->bindParam(":city", $order['city'], PDO::PARAM_STR);
            $stmt_insert_archived_order->bindParam(":postOffice", $order['postOffice'], PDO::PARAM_STR);
            $stmt_insert_archived_order->bindParam(":date", $order['date'], PDO::PARAM_STR);

            if ($stmt_insert_archived_order->execute()) {

                $sql_delete_order = "DELETE FROM orders WHERE order_number = :order_number";
                $stmt_delete_order = $conn->prepare($sql_delete_order);
                $stmt_delete_order->bindParam(":order_number", $orderNumber, PDO::PARAM_STR);
                $stmt_delete_order->execute();

                echo "Order archived successfully!";
            } else {
                echo "Failed to archive order.";
            }
        } else {
            echo "Order not found!";
        }
    } else {
        echo "Invalid request!";
    }
}
?>
