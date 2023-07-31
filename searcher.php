<?php
include "includes/config.php";
include "includes/db_config.php";

$conn = connectDatabase($dsn, $pdoOptions);

if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];

    $sql = "SELECT phones.*, manufacturers.manufacturer
            FROM phones
            INNER JOIN manufacturers ON phones.id_manufacturer = manufacturers.id_manufacturer
            WHERE model LIKE :searchTerm
            GROUP BY phones.model ORDER BY price ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(':searchTerm' => "%$searchTerm%"));

    $resultsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resultsArray as $key => $row) {
        $id_phone = $row["id_phone"];
        $sql_color = "SELECT color FROM colors WHERE id_phone = :id_phone LIMIT 1";
        $stmt_color = $conn->prepare($sql_color);
        $stmt_color->execute(array(':id_phone' => $id_phone));
        $color = $stmt_color->fetchColumn();

        $resultsArray[$key]['color'] = $color;
    }

    echo json_encode($resultsArray);
}
?>