<?php

include "includes/config.php";
include "includes/db_config.php";

$conn = connectDatabase($dsn, $pdoOptions);

if (isset($_POST["manufacturer-btn"]) and isset($_POST["manufacturer"]) and !empty($_POST["manufacturer"]))
{
    $manufacturer = $_POST["manufacturer"];
    $manufacturer_name = strtoupper($manufacturer);

    if (!ctype_alpha($manufacturer)) {
        header("Location:add_phones.php?error=2");
        exit();
    }

    $pdoQuery = $conn->prepare("SELECT * FROM manufacturers WHERE manufacturer = ?");
    $pdoQuery->execute([$manufacturer_name]);
    $count = $pdoQuery->fetchColumn();
    if ($count > 0) {
        header("Location:add_phones.php?error=3");
        exit();
    }
    else
    {
        $pdoQuery = $conn->prepare("INSERT INTO manufacturers (manufacturer) VALUES (?)");
        $pdoQuery->execute([$manufacturer_name]);
        header("Location:add_phones.php?ok=1");
    }

}
else
{
    header("Location:add_phones.php?error=1");
}

