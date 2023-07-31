<?php
session_start();

include "includes/config.php";
include "includes/db_config.php";

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

    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    $color = $_POST["color"];



    $id_phone = $_GET["id_phone"];

    echo $delivery_method;
    echo $quantity;
    echo $price;
    echo $color;



    if ($delivery_method == "Home delivery" and isset($_POST["fname"]) and !empty($_POST["fname"]) and isset($_POST["lname"]) and !empty($_POST["lname"]) and isset($_POST["sanda"]) and !empty($_POST["sanda"]) and isset($_POST["phonenumber"]) and !empty($_POST["phonenumber"]) and isset($_POST["city1"]) and !empty($_POST["city1"]))
    {
        if ($price <= 1000)
        {
            $price += 20;
            $pdoQuery = $conn->prepare("INSERT INTO orders (id_phone, id_user,color,quantity,price, firstname, lastname, phonenumber, delivery_method, city, postOffice) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            $pdoQuery->execute([$id_phone, $id_user, $color,$quantity,$price, $fname,$lname,$phonenumber,$delivery_method,$city2,""]);
            header("Location:purchase_ok.php?id_phone=$id_phone&id_user=$id_user&fname=$fname&lname=$lname&city=$city2&sanda=$sanda&phonenumber=$phonenumber&delivery_method=$delivery_method&color=$color&price=$price&quantity=$quantity");
        }
        else
        {
            $pdoQuery = $conn->prepare("INSERT INTO orders (id_phone, id_user,color,quantity,price, firstname, lastname, phonenumber, delivery_method, city, postOffice) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            $pdoQuery->execute([$id_phone, $id_user, $color,$quantity,$price, $fname,$lname,$phonenumber,$delivery_method,$city2,""]);
            header("Location:purchase_ok.php?id_phone=$id_phone&id_user=$id_user&fname=$fname&lname=$lname&city=$city2&sanda=$sanda&phonenumber=$phonenumber&delivery_method=$delivery_method&color=$color&price=$price&quantity=$quantity");
        }
    }
    else
    {
        if ($delivery_method == "Postal recording" and isset($_POST["fname"]) and !empty($_POST["fname"]) and isset($_POST["lname"]) and !empty($_POST["lname"]) and isset($_POST["phonenumber"]) and !empty($_POST["phonenumber"]) and isset($_POST["city"]) and !empty($_POST["city"]) and isset($_POST["postOffice"]) and !empty($_POST["postOffice"]))
        {
            if ($price <= 1000)
            {
                $price += 10;
                $pdoQuery = $conn->prepare("INSERT INTO orders (id_phone, id_user,color,quantity,price, firstname, lastname, phonenumber, delivery_method, city, postOffice) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                $pdoQuery->execute([$id_phone, $id_user,$color,$quantity,$price ,$fname,$lname,$phonenumber,$delivery_method, $city, $postOffice]);
                header("Location:purchase_ok.php?id_phone=$id_phone&id_user=$id_user&fname=$fname&lname=$lname&city=$city&sanda=$sanda&phonenumber=$phonenumber&delivery_method=$delivery_method&postOffice=$postOffice&color=$color&price=$price&quantity=$quantity");
            }
            else
            {
                $pdoQuery = $conn->prepare("INSERT INTO orders (id_phone, id_user,color,quantity,price, firstname, lastname, phonenumber, delivery_method, city, postOffice) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                $pdoQuery->execute([$id_phone, $id_user,$color,$quantity,$price ,$fname,$lname,$phonenumber,$delivery_method, $city, $postOffice]);
                header("Location:purchase_ok.php?id_phone=$id_phone&id_user=$id_user&fname=$fname&lname=$lname&city=$city&sanda=$sanda&phonenumber=$phonenumber&delivery_method=$delivery_method&postOffice=$postOffice&color=$color&price=$price&quantity=$quantity");
            }

        }
        else
        {
            header("Location:product.php?id_phone=66&error=501");
        }

    }



}