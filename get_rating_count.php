<?php
include "includes/config.php";
include "includes/db_config.php";

$conn = connectDatabase($dsn, $pdoOptions);

$phoneId = $_GET["id_phone"];

$pdoQuery = $conn->prepare("SELECT COUNT(*) AS numberOfRatings FROM ratings WHERE id_phone = ?");
$pdoQuery->execute([$phoneId]);
$result = $pdoQuery->fetch(PDO::FETCH_ASSOC);

$numberOfRatings = $result['numberOfRatings'];
echo json_encode(['numberOfRatings' => $numberOfRatings]);

$_SESSION["numberOfRatings"] = $numberOfRatings;
?>