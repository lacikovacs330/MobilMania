<div class="nav-phones">
    <?php include "includes/nav.php";
    $conn = connectDatabase($dsn, $pdoOptions);
    ?>
</div>

<?php
$id_user = $_SESSION['id_user'];

$sql1 = "SELECT * FROM orders WHERE id_user = :id_user AND date <= DATE_ADD(CURDATE(), INTERVAL 3 DAY) ORDER BY date DESC";
$stmt1 = $conn->prepare($sql1);
$stmt1->bindValue(':id_user', $id_user, PDO::PARAM_INT);
$stmt1->execute();
$results1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Orders | @MobilMania</title>
</head>
<body>
<div style="width: 100%;">
    <h1 style="text-align: center; padding: 15px">My Orders</h1>
    <?php if (!empty($results1)): ?>
        <div style="width: 100%; display: flex;justify-content: center;align-items: center">
            <table class="table" style="width: 80%; padding: 5px;">
                <thead>
                <tr>
                    <th scope="col">Phone name</th>
                    <th scope="col">Color</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Date of order</th>
                    <th scope="col">Delivery date</th>
                </tr>
                </thead>
                <?php foreach ($results1 as $row1):
                    $id_phone = $row1["id_phone"];

                    $sql2 = "SELECT * FROM phones WHERE id_phone = '$id_phone'";
                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->execute();
                    $results2 = $stmt2->fetchAll(PDO::FETCH_ASSOC); 
                    ?>
                <?php if (date("Y-m-d") <= date('Y-m-d', strtotime($row1["date"] . ' +3 days'))) { ?>
                    <tbody>
                    <tr>
                        <td>
                            <?php if ($stmt2->rowCount() > 0) { ?>
                            <?php foreach ($results2 as $row2) {
                                echo $row2["model"];
                            }
                            }
                            ?>
                        </td>
                        <td style="text-transform: capitalize;"><?php echo $row1["color"];?></td>
                        <td><?php echo $row1["price"];?></td>
                        <td><?php echo $row1["quantity"];?></td>
                        <td><?php echo $row1["date"]; ?></td>
                        <td><?php echo date('Y-m-d', strtotime($row1["date"] . ' +3 days')); ?></td>
                    </tr>
                    </tbody>
                <?php }
                    else
                    {

                    }
                    ?>
                <?php endforeach; ?>
            </table>
        </div>
    <?php else: ?>
        <p style="text-align: center">No orders found for this user.</p>
    <?php endif; ?>
</div>
<?php include "includes/footer.php"?>
</body>
</html>
