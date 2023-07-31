<?php
session_start();

include "includes/config.php";
include "includes/db_config.php";

$conn = connectDatabase($dsn, $pdoOptions);

if (isset($_POST["rating"])) {
    $rating = $_POST["rating"];
    $phone_id = $_GET["id_phone"];
    $user_id = $_SESSION["id_user"];

    $pdoQuery = $conn->prepare("SELECT * FROM ratings WHERE id_phone = ? AND id_user = ?");
    $pdoQuery->execute([$phone_id, $user_id]);
    $existingRating = $pdoQuery->fetch(PDO::FETCH_ASSOC);

    if ($existingRating) {
        if ($existingRating['rating'] != $rating) {
            $pdoQuery = $conn->prepare("UPDATE ratings SET rating = ? WHERE id_phone = ? AND id_user = ?");
            $pdoQuery->execute([$rating, $phone_id, $user_id]);
        }
    } else {
        $pdoQuery = $conn->prepare("INSERT INTO ratings (id_phone, rating, id_user) VALUES (?,?,?)");
        $pdoQuery->execute([$phone_id, $rating, $user_id]);
    }
}


$phone_id = $_GET["id_phone"];
$user_id = $_SESSION["id_user"];
$pdoQuery = $conn->prepare("SELECT AVG(rating) AS avg_rating FROM ratings WHERE id_phone = ?");
$pdoQuery->execute([$phone_id]);
$averageRating = $pdoQuery->fetch(PDO::FETCH_ASSOC)['avg_rating'];

$_SESSION['averageRating'] = $averageRating;
