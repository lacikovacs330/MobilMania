<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["id_user"]) || $_SESSION["role"] !== "admin") {
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
    <title>Update | @MobilMania</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .nav-phones {
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-wrapper {
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: lavender;
            color: #000000;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        hr {
            margin: 20px 0;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
<div class="nav-phones">
    <?php include "includes/nav.php";

    $id_phone = $_GET["id_phone"];

    $conn = connectDatabase($dsn, $pdoOptions);

    $sql_phones = "SELECT * FROM phones WHERE id_phone = '$id_phone'";
    $result_phones = $conn->query($sql_phones);

    $sql_colors = "SELECT * FROM colors WHERE id_phone = '$id_phone'";
    $result_colors = $conn->query($sql_colors);

    $sql_storages = "SELECT * FROM storage WHERE id_phone = '$id_phone'";
    $result_storages = $conn->query($sql_storages);
    ?>

</div>

<div class="container">
    <?php while($phone = $result_phones->fetch(PDO::FETCH_ASSOC)) { ?>
        <div class="form-wrapper">
            <form action="update_phone.php" method="post">
                <input type="hidden" name="phone_id" value="<?php echo $phone['id_phone']; ?>">
                <label for="model">Model:</label>
                <input type="text" name="model" value="<?php echo $phone['model']; ?>" readonly>
                <label for="price">Price:</label>
                <input type="number" name="price" value="<?php echo $phone['price']; ?>">

                <?php
                $sql_colors_for_phone = "SELECT * FROM colors WHERE id_phone = {$phone['id_phone']}";
                $result_colors_for_phone = $conn->query($sql_colors_for_phone);
                ?>
                <?php
                if (isset($_GET["ok"]) and $_GET["ok"] == 3)
                {
                    echo '<div class="success-message2" style="width: 100%; margin-bottom: 10px; margin-top: 0px;">Success!</div>';
                }

                if (isset($_GET["error"]) and $_GET["error"] == 6001)
                {
                    echo '<div class="error-message2" style="width: 100%; margin-bottom: 10px; margin-top: 0px;">Enter normal format!</div>';
                }
                ?>
                <input type="submit" value="Update">
            </form>

            <form action="delete_color.php" method="post">
                <input type="hidden" name="phone_id" value="<?php echo $phone['id_phone']; ?>">
                <label for="color">Color:</label>
                <select name="color" class="select-wrapper" style="text-transform: capitalize;">
                    <option value="" selected disabled>Select color</option>
                    <?php while($color = $result_colors_for_phone->fetch(PDO::FETCH_ASSOC)) { ?>
                        <option value="<?php echo $color['color']; ?>"><?php echo $color['color']; ?></option>
                    <?php }

                    ?>
                </select>
                <?php
                if (isset($_GET["ok"]) and $_GET["ok"] == 2)
                {
                    echo '<div class="success-message2" style="width: 100%">Success!</div>';
                }

                if (isset($_GET["error"]) and $_GET["error"] == 2)
                {
                    echo '<div class="error-message2" style="width: 100%">It cannot be deleted because it must remain the same color!</div>';
                }
                ?>
                <input type="hidden" value="<?php echo $phone["id_manufacturer"]; ?>" name="id_manufacturer" id="id_manufacturer">
                <input type="submit" value="Delete Color" style="margin-top: 10px">
            </form>

            <?php
            $sql_storages_for_phone = "SELECT * FROM storage WHERE id_phone = {$phone['id_phone']}  ORDER BY storage ASC";
            $result_storages_for_phone = $conn->query($sql_storages_for_phone);
            ?>
            <form action="delete_storage.php" method="post">
                <input type="hidden" name="phone_id" value="<?php echo $phone['id_phone']; ?>">
                <label for="storage">Storage:</label>
                <select name="storage" style="text-transform: capitalize;">
                    <option value="" selected disabled>Select storage</option>
                    <?php while($storage = $result_storages_for_phone->fetch(PDO::FETCH_ASSOC)) { ?>
                        <option value="<?php echo $storage['storage']; ?>"><?php echo $storage['storage']; ?></option>
                    <?php } ?>
                </select>
                <?php
                if (isset($_GET["ok"]) and $_GET["ok"] == 1)
                {
                    echo '<div class="success-message2" style="width: 100%">Success!</div>';
                }

                if (isset($_GET["error"]) and $_GET["error"] == 1)
                {
                    echo '<div class="error-message2" style="width: 100%">It cannot be deleted because it must remain the same storage!</div>';
                }
                ?>
                <input type="submit" value="Delete Storage" style="margin-top: 10px">
            </form>

            <form action="update_quantity.php" method="post" id="quantity-form">
                <input type="hidden" name="phone_id" value="<?php echo $phone['id_phone']; ?>">
                <label for="color">Color:</label>
                <select name="color" style="text-transform: capitalize;" id="color-select" onchange="updateQuantity()">
                    <option value="" disabled selected>Choose a color!</option>
                    <?php
                    $sql_colors = "SELECT DISTINCT color, quantity FROM colors WHERE id_phone = {$phone['id_phone']}";
                    $stmt_colors = $conn->query($sql_colors);
                    $colors_data = $stmt_colors->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($colors_data as $color_data) {
                        $szin = $color_data['color'];
                        echo '<option value="' . $szin . '">' . $szin . '</option>';
                    }
                    ?>
                </select>
                <br>
                <label for="quantity_number">Quantity:</label>
                <input type="number" name="quantity_number" id="quantity-input" value="">

                <?php
                if (isset($_GET["error"]) && $_GET["error"] == 5000) {
                    echo '<div class="error-message2" style="width: 100%">Enter normal format!</div>';
                }

                if (isset($_GET["error"]) && $_GET["error"] == 5001) {
                    echo '<div class="error-message2" style="width: 100%">Error!</div>';
                }

                if (isset($_GET["error"]) && $_GET["error"] == 5002) {
                    echo '<div class="error-message2" style="width: 100%">The number must be greater than 5!</div>';
                }

                if (isset($_GET["ok"]) && $_GET["ok"] == 5) {
                    echo '<div class="success-message2" style="width: 100%">Success!</div>';
                }
                ?>
                <input type="submit" value="Update Quantity" style="margin-top: 10px">
            </form>

            <script>
                function updateQuantity() {
                    var selectedColor = document.getElementById("color-select").value;
                    var colorsData = <?php echo json_encode($colors_data); ?>;
                    var selectedQuantity = 0;

                    for (var i = 0; i < colorsData.length; i++) {
                        if (colorsData[i]['color'] === selectedColor) {
                            selectedQuantity = colorsData[i]['quantity'];
                            break;
                        }
                    }

                    document.getElementById("quantity-input").value = selectedQuantity;
                }
            </script>

        </div>

        <hr>
    <?php } ?>
</div>


<?php include "includes/footer.php"; ?>

</body>
</html>
