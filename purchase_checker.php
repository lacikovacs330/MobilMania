<?php
session_start();

include "includes/functions.php";

$conn = connectDatabase($dsn, $pdoOptions);

if (isset($_POST["purchase-btn"]))
{
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $sanda = $_POST["sanda"];
    $phonenumber = $_POST["phonenumber"];
    $delivery_method = $_POST["delivery_method"];
    $city = $_POST["city"];
    $postOffice = $_POST["postOffice"];
    $id_user = $_SESSION["id_user"];
    $city2 = $_POST["city1"];
    $storage = $_POST["storage"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    $color = $_POST["color"];



    $id_phone = $_GET["id_phone"];

    echo $delivery_method;
    echo $quantity;
    echo $price;
    echo $color;

    function generateOrderNumber($conn)
    {
        $currentTime = time();
        $currentDate = date("Ymd");

        $randomChars = bin2hex(random_bytes(4));

        $orderNumber = $currentDate . "-" . $randomChars;

        $query = "SELECT COUNT(*) as count FROM orders WHERE order_number = :order_number";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':order_number', $orderNumber);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $result['count'];

        while ($count > 0) {
            $randomChars = bin2hex(random_bytes(4));
            $orderNumber = $currentDate . "-" . $randomChars;

            $stmt->bindParam(':order_number', $orderNumber);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $result['count'];
        }

        return $orderNumber;
    }

    $orderNumber = generateOrderNumber($conn);

    if (!is_numeric($phonenumber))
    {
        header("Location:product.php?id_phone=$id_phone&error=501");
        exit;
    }

    if ($delivery_method == "Home delivery" and isset($_POST["fname"]) and !empty($_POST["fname"]) and isset($_POST["lname"]) and !empty($_POST["lname"]) and isset($_POST["sanda"]) and !empty($_POST["sanda"]) and isset($_POST["phonenumber"]) and !empty($_POST["phonenumber"]) and isset($_POST["city1"]) and !empty($_POST["city1"]))
    {
        if ($price <= 1000)
        {
            $price += 20;
            $pdoQuery = $conn->prepare("INSERT INTO orders (id_phone, order_number, id_user,color,quantity,price,storage, firstname, lastname, phonenumber, delivery_method, city, postOffice) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $pdoQuery->execute([$id_phone, $orderNumber, $id_user, $color,$quantity,$price,$storage, $fname,$lname,$phonenumber,$delivery_method,$city2,""]);
            header("Location:purchase_ok.php?id_phone=$id_phone&order_number=$orderNumber&storage=$storage&id_user=$id_user&fname=$fname&lname=$lname&city=$city2&sanda=$sanda&phonenumber=$phonenumber&delivery_method=$delivery_method&color=$color&price=$price&quantity=$quantity");

            $sql_get_current_quantity = "SELECT number FROM quantity WHERE id_phone = :phone_id";
            $stmt = $conn->prepare($sql_get_current_quantity);
            $stmt->bindParam(':phone_id', $id_phone);
            $stmt->execute();
            $current_quantity = $stmt->fetchColumn();

            $remaining_quantity = $current_quantity - $quantity;

            $sql_update_quantity = "UPDATE quantity SET number = :remaining_quantity WHERE id_phone = :phone_id";
            $stmt = $conn->prepare($sql_update_quantity);
            $stmt->bindParam(':remaining_quantity', $remaining_quantity);
            $stmt->bindParam(':phone_id', $id_phone);
            $stmt->execute();

            $sql = "SELECT email FROM users WHERE id_user = :id_user";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['id_user' => $_SESSION["id_user"]]);
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $email = $result["email"];

                purchaseOK($orderNumber, $email, "Order" , $id_phone);
            }

        }
        else
        {
            $pdoQuery = $conn->prepare("INSERT INTO orders (id_phone, order_number, id_user,color,quantity,price,storage, firstname, lastname, phonenumber, delivery_method, city, postOffice) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $pdoQuery->execute([$id_phone, $orderNumber, $id_user, $color,$quantity,$price,$storage, $fname,$lname,$phonenumber,$delivery_method,$city2,""]);
            header("Location:purchase_ok.php?id_phone=$id_phone&order_number=$orderNumber&storage=$storage&id_user=$id_user&fname=$fname&lname=$lname&city=$city2&sanda=$sanda&phonenumber=$phonenumber&delivery_method=$delivery_method&color=$color&price=$price&quantity=$quantity");

            $sql_get_current_quantity = "SELECT number FROM quantity WHERE id_phone = :phone_id";
            $stmt = $conn->prepare($sql_get_current_quantity);
            $stmt->bindParam(':phone_id', $id_phone);
            $stmt->execute();
            $current_quantity = $stmt->fetchColumn();

            $remaining_quantity = $current_quantity - $quantity;

            $sql_update_quantity = "UPDATE quantity SET number = :remaining_quantity WHERE id_phone = :phone_id";
            $stmt = $conn->prepare($sql_update_quantity);
            $stmt->bindParam(':remaining_quantity', $remaining_quantity);
            $stmt->bindParam(':phone_id', $id_phone);
            $stmt->execute();

            $sql = "SELECT email FROM users WHERE id_user = :id_user";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['id_user' => $_SESSION["id_user"]]);
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $email = $result["email"];

                purchaseOK($orderNumber, $email, "Order" , $id_phone);
            }
        }
    }
    else
    {
        if ($delivery_method == "Postal recording" and isset($_POST["fname"]) and !empty($_POST["fname"]) and isset($_POST["lname"]) and !empty($_POST["lname"]) and isset($_POST["phonenumber"]) and !empty($_POST["phonenumber"]) and isset($_POST["city"]) and !empty($_POST["city"]) and isset($_POST["postOffice"]) and !empty($_POST["postOffice"]))
        {
            if ($price <= 1000)
            {
                $price += 10;
                $pdoQuery = $conn->prepare("INSERT INTO orders (id_phone, order_number, id_user,color,quantity,price, storage, firstname, lastname, phonenumber, delivery_method, city, postOffice) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $pdoQuery->execute([$id_phone, $orderNumber, $id_user,$color,$quantity,$price ,$storage,$fname,$lname,$phonenumber,$delivery_method, $city, $postOffice]);
                header("Location:purchase_ok.php?id_phone=$id_phone&order_number=$orderNumber&storage=$storage&id_user=$id_user&fname=$fname&lname=$lname&city=$city&sanda=$sanda&phonenumber=$phonenumber&delivery_method=$delivery_method&postOffice=$postOffice&color=$color&price=$price&quantity=$quantity");

                $sql_get_current_quantity = "SELECT number FROM quantity WHERE id_phone = :phone_id";
                $stmt = $conn->prepare($sql_get_current_quantity);
                $stmt->bindParam(':phone_id', $id_phone);
                $stmt->execute();
                $current_quantity = $stmt->fetchColumn();

                $remaining_quantity = $current_quantity - $quantity;

                $sql_update_quantity = "UPDATE quantity SET number = :remaining_quantity WHERE id_phone = :phone_id";
                $stmt = $conn->prepare($sql_update_quantity);
                $stmt->bindParam(':remaining_quantity', $remaining_quantity);
                $stmt->bindParam(':phone_id', $id_phone);
                $stmt->execute();

                $sql = "SELECT email FROM users WHERE id_user = :id_user";
                $stmt = $conn->prepare($sql);
                $stmt->execute(['id_user' => $_SESSION["id_user"]]);
                if ($stmt->rowCount() > 0) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    $email = $result["email"];

                    purchaseOK($orderNumber, $email, "Order" , $id_phone);
                }
            }
            else
            {
                $pdoQuery = $conn->prepare("INSERT INTO orders (id_phone, order_number, id_user,color,quantity,price, storage, firstname, lastname, phonenumber, delivery_method, city, postOffice) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $pdoQuery->execute([$id_phone, $orderNumber, $id_user,$color,$quantity,$price , $storage,$fname,$lname,$phonenumber,$delivery_method, $city, $postOffice]);
                header("Location:purchase_ok.php?id_phone=$id_phone&order_number=$orderNumber&storage=$storage&id_user=$id_user&fname=$fname&lname=$lname&city=$city&sanda=$sanda&phonenumber=$phonenumber&delivery_method=$delivery_method&postOffice=$postOffice&color=$color&price=$price&quantity=$quantity");

                $sql_get_current_quantity = "SELECT number FROM quantity WHERE id_phone = :phone_id";
                $stmt = $conn->prepare($sql_get_current_quantity);
                $stmt->bindParam(':phone_id', $id_phone);
                $stmt->execute();
                $current_quantity = $stmt->fetchColumn();

                $remaining_quantity = $current_quantity - $quantity;

                $sql_update_quantity = "UPDATE quantity SET number = :remaining_quantity WHERE id_phone = :phone_id";
                $stmt = $conn->prepare($sql_update_quantity);
                $stmt->bindParam(':remaining_quantity', $remaining_quantity);
                $stmt->bindParam(':phone_id', $id_phone);
                $stmt->execute();

                $sql = "SELECT email FROM users WHERE id_user = :id_user";
                $stmt = $conn->prepare($sql);
                $stmt->execute(['id_user' => $_SESSION["id_user"]]);
                if ($stmt->rowCount() > 0) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    $email = $result["email"];

                    purchaseOK($orderNumber, $email, "Order", $id_phone);
                }
            }

        }
        else
        {
            header("Location:product.php?id_phone=$id_phone&error=501");
        }

    }
}

