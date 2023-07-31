<?php

include "includes/config.php";
include "includes/db_config.php";

$conn = connectDatabase($dsn, $pdoOptions);

$allowedStorages = array("64 GB", "128 GB", "256 GB");


if (isset($_POST["storage-btn"]) and isset($_POST["model_id"]) and !empty($_POST["model_id"]) and isset($_POST["storage"]) and !empty($_POST["storage"]))
{
    $model_id = $_POST["model_id"];
    $storage = $_POST["storage"];
    if (!is_numeric($_POST["model_id"])) {
        header("Location:add_phones.php?error=12");
        exit();
    }

    if (!in_array($_POST["storage"], $allowedStorages)) {
        header("Location:add_phones.php?error=12");
        exit();
    }

    $pdoQuery = $conn->prepare("SELECT * FROM storage WHERE id_phone = ? AND storage = ?");
    $pdoQuery->execute([$model_id, $storage]);
    $count = $pdoQuery->fetchColumn();
    if ($count > 0) {
        header("Location:add_phones.php?error=13");
        exit();
    } else {
            $pdoQuery = $conn->prepare("INSERT INTO storage (id_phone, storage) VALUES (?,?)");
            $pdoQuery->execute([$model_id, $storage]);
            header("Location:add_phones.php?ok=3");
    }

}
else
{
    header("Location:add_phones.php?error=11");
}