<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["id_user"]) || $_SESSION["role"] !== "user") {
    header("Location: index.php");
    exit;
}

session_write_close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Phones | @MobilMania </title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>
<body>
<div class="nav-phones">
    <?php
    include "includes/nav.php";


    $conn = connectDatabase($dsn, $pdoOptions);

    $sql = "SELECT * FROM phones";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $id_user = $_SESSION["id_user"];
    $sql_favorites = "SELECT phones.* FROM phones
                     JOIN favourites ON phones.id_phone = favourites.id_phone
                     WHERE favourites.id_user = ?";
    $stmt_favorites = $conn->prepare($sql_favorites);
    $stmt_favorites->execute([$id_user]);
    $favorite_results = $stmt_favorites->fetchAll(PDO::FETCH_ASSOC);
    ?>
</div>

<div class="searcher-product">
    <h3 style="text-decoration: underline">Favourites</h3>
</div>

<div style="width: 100%; height: auto; display: flex">
    <div class="product-phones" style="width: 100%">
        <?php
        if (!empty($favorite_results)) {
            foreach ($favorite_results as $row) {
                $id_phone = $row["id_phone"];
                $id_manufacturer = $row["id_manufacturer"];

                $sql1 = "SELECT * FROM manufacturers WHERE id_manufacturer = '$id_manufacturer'";
                $res1 = $conn->query($sql1);
                $rows1 = $res1->fetchAll();
                $manufacturer_name2 = "";
                if(count($rows1) >= 1)
                {
                    foreach($rows1 as $row1)
                    {
                        $manufacturer_name2 = $row1["manufacturer"];
                    }
                }

                $sql2 = "SELECT * FROM colors WHERE id_phone = '$id_phone'";
                $res2 = $conn->query($sql2);
                $rows2 = $res2->fetchAll();
                $color = "";

                if (count($rows2) >= 1) {
                    $color = $rows2[0]["color"];
                }

                if (file_exists("phone-img/".$manufacturer_name2."/".$id_phone."/1-".$color.".jpg"))
                {
                    $img_name = "phone-img/".$manufacturer_name2."/".$id_phone."/1-".$color.".jpg";
                }

                if (file_exists("phone-img/".$manufacturer_name2."/".$id_phone."/1-".$color.".jpeg"))
                {
                    $img_name = "phone-img/".$manufacturer_name2."/".$id_phone."/1-".$color.".jpeg";
                }

                if (file_exists("phone-img/".$manufacturer_name2."/".$id_phone."/1-".$color.".png"))
                {
                    $img_name = "phone-img/".$manufacturer_name2."/".$id_phone."/1-".$color.".png";
                }
                ?>
                <div class="kartya">
                    <div class="kepDoboz" >
                        <img src="<?php echo $img_name; ?>" alt="" class="eger">
                    </div>
                    <div class="tartalomDoboz">
                        <h3><?php echo $row["model"];?></h3>
                        <h2 class="ar"><?php echo $row["price"];?>.<small>00</small> €</h2>
                        <a href="product.php?id_phone=<?php echo $id_phone; ?>" class="vasarlas">Watch now</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "You don't have a favorite phone yet!";
        }
        ?>
    </div>
</div>
<?php include "includes/footer.php"; ?>
</body>
</html>
