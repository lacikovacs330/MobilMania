<?php
include "includes/config.php";
include "includes/db_config.php";

$conn = connectDatabase($dsn, $pdoOptions);

$phoneId = $_GET["id_phone"];

$pdoQuery = $conn->prepare("SELECT AVG(rating) AS averageRating FROM ratings WHERE id_phone = ?");
$pdoQuery->execute([$phoneId]);
$result = $pdoQuery->fetch(PDO::FETCH_ASSOC);

$averageRating = $result['averageRating'];
$formattedRating = number_format($averageRating, 0);
echo json_encode(['rating' => $formattedRating]);
