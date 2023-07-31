<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase | @MobilMania </title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>
<body>
<div class="nav-phones">
    <?php include "includes/nav.php";
    $conn = connectDatabase($dsn, $pdoOptions);
    ?>
</div>



<div class="purchase-ok">
    <div class="purchase-img">
        <img src="img/check.png" width="90" height="90">
    </div>
</div>
<h3 style="text-align: center">Successful shopping!</h3>

<?php
if ($_GET["delivery_method"] == "Home delivery")
{
    $id_phone = $_GET["id_phone"];
    $fname = $_GET["fname"];
    $lname = $_GET["lname"];
    $city = $_GET["city"];
    $sanda = $_GET["sanda"];
    $phonenumber = $_GET["phonenumber"];
    $delivery_method = $_GET["delivery_method"];

    $color = $_GET["color"];
    $price = $_GET["price"];
    $quantity = $_GET["quantity"];

    $sql = "SELECT * FROM phones WHERE id_phone = '$id_phone'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div style="width: 100%; height: 300px; display: flex; justify-content: center; align-items: center">
    <table class="table" style="width: 80%;">
        <thead>
        <tr>
            <th scope="col">Phone name</th>
            <th scope="col">Color</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">First name</th>
            <th scope="col">Last name</th>
            <th scope="col">City</th>
            <th scope="col">Street and Address</th>
            <th scope="col">Phone number</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php if ($stmt->rowCount() > 0) { ?>
            <?php foreach ($results as $row) { ?>
            <td><?php echo $row["model"];?></td>
            <?php } ?>
            <?php  } ?>
            <td style="text-transform: capitalize;"><?php echo $color;?></td>
            <td><?php echo $price;?>.<small>00 €</small></td>
            <td><?php echo $quantity;?></td>
            <td><?php echo $fname;?></td>
            <td><?php echo $lname;?></td>
            <td><?php echo $city;?></td>
            <td><?php echo $sanda;?></td>
            <td><?php echo $phonenumber;?></td>
        </tr>
        </tbody>
    </table>
</div>
<?php } ?>

<?php


if ($_GET["delivery_method"] == "Postal recording")
{
    $id_phone = $_GET["id_phone"];
    $id_user = $_GET["id_user"];
    $fname = $_GET["fname"];
    $lname = $_GET["lname"];
    $city = $_GET["city"];
    $sanda = $_GET["sanda"];
    $phonenumber = $_GET["phonenumber"];
    $delivery_method = $_GET["delivery_method"];
    $postOffice = $_GET["postOffice"];

    $color = $_GET["color"];
    $price = $_GET["price"];
    $quantity = $_GET["quantity"];

    $sql = "SELECT * FROM phones WHERE id_phone = '$id_phone'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
    <div style="width: 100%; height: 200px; display: flex; justify-content: center; align-items: center">
        <table class="table" style="width: 80%;">
            <thead>
            <tr>
                <th scope="col">Phone name</th>
                <th scope="col">First name</th>
                <th scope="col">Last name</th>
                <th scope="col">City</th>
                <th scope="col">Phone number</th>
                <th scope="col">Post Office</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php if ($stmt->rowCount() > 0) { ?>
                    <?php foreach ($results as $row) { ?>
                        <td><?php echo $row["model"];?></td>
                    <?php } ?>
                <?php  } ?>
                <td><?php echo $fname;?></td>
                <td><?php echo $lname;?></td>
                <td><?php echo $city;?></td>
                <td><?php echo $phonenumber;?></td>
                <td><?php echo $postOffice;?></td>
            </tr>
            </tbody>
        </table>
    </div>

<?php } ?>

<?php include "includes/footer.php"; ?>

</body>
</html>


