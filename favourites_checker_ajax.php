<?php
session_start();

include "includes/config.php";
include "includes/db_config.php";

$conn = connectDatabase($dsn, $pdoOptions);

if (isset($_SESSION["id_user"]) && isset($_POST["id_phone"])) {
    $id_phone = $_POST["id_phone"];
    $id_user = $_SESSION["id_user"];

    $pdoQuery = $conn->prepare("SELECT * FROM favourites WHERE id_phone = ? AND id_user = ?");
    $pdoQuery->execute([$id_phone, $id_user]);
    $alreadyExists = $pdoQuery->fetch();

    if ($alreadyExists) {
        $pdoQuery = $conn->prepare("DELETE FROM favourites WHERE id_phone = ? AND id_user = ?");
        $pdoQuery->execute([$id_phone, $id_user]);
        echo 'removed';
    } else {
        $pdoQuery = $conn->prepare("INSERT INTO favourites (id_phone, id_user) VALUES (?, ?)");
        $pdoQuery->execute([$id_phone, $id_user]);
        echo 'added';
    }
}
?>
