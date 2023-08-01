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
    <title>Purchase | @MobilMania </title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>

<style>
    .specification-title {
        display: flex;
        align-items: center;
        padding: 10px;
        background-color: #f0f0f0;
        border-radius: 5px;
        font-size: 16px;
    }

    .specification-title ion-icon {
        margin-right: 10px;
        font-size: 24px;
    }

    .specification-title input[type="radio"] {
        margin-right: 10px;
        display: none;
    }

    .specification-title input[type="radio"]:checked + label {
        font-weight: bold;
    }

</style>
<body>

<?php if(isset($_POST["purchase-btn"])){
    $id_phone = $_GET["id_phone"];
    if (!isset($_POST["color"]))
    {
        header("Location:product.php?id_phone=$id_phone&error=101");
    }

    if (!isset($_POST["storage"]))
    {
        header("Location:product.php?id_phone=$id_phone&error=999");
    }

    if (isset($_POST["quantity"]) >5 and isset($_POST["quantity"]) < 1)
    {
        header("Location:product.php?id_phone=$id_phone&error=102");
    }
    ?>



<div class="nav-phones">
    <?php include "includes/nav.php";



    $conn = connectDatabase($dsn, $pdoOptions);

    $sql = "SELECT * FROM phones WHERE id_phone = '$id_phone'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql2 = "SELECT * FROM colors WHERE id_phone = '$id_phone' ORDER BY id_color DESC";
    $res2 = $conn->query($sql2);
    $rows2 = $res2->fetchAll();
    $color = "";

    ?>

</div>

    <?php echo '<form  action="purchase_checker.php?id_phone='.$id_phone.'" method="post">'; ?>
<div class="purchase-container">

    <?php if ($stmt->rowCount() > 0) { ?>
    <?php foreach ($results as $row) {
    $id_manufacturer = $row["id_manufacturer"];

    $sql1 = "SELECT * FROM manufacturers WHERE id_manufacturer = '$id_manufacturer'";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute();
     $results1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    $manufacturer_name2 = "";
    if ($stmt1->rowCount() > 0) {
        foreach ($results1 as $row1) {

        $manufacturer_name2 = $row1["manufacturer"];

        }
    }

        if (count($rows2) >= 1) {
            foreach ($rows2 as $row2) {
                $color = $_POST["color"];
                $colorOptions[] = $_POST["color"];
            }


            if (file_exists("phone-img/" . $manufacturer_name2 . "/" . $id_phone . "/1-" . $color . ".jpg")) {
                $img_name = "phone-img/" . $manufacturer_name2 . "/" . $id_phone . "/1-" . $color . ".jpg";
            }

            if (file_exists("phone-img/" . $manufacturer_name2 . "/" . $id_phone . "/1-" . $color . ".jpeg")) {
                $img_name = "phone-img/" . $manufacturer_name2 . "/" . $id_phone . "/1-" . $color . ".jpeg";
            }

            if (file_exists("phone-img/" . $manufacturer_name2 . "/" . $id_phone . "/1-" . $color . ".png")) {
                $img_name = "phone-img/" . $manufacturer_name2 . "/" . $id_phone . "/1-" . $color . ".png";
            }
        }
        ?>
    <div class="purchase-item">
        <div class="purchase-item-phone">
            <img src="<?= $img_name ?>" width="140" height="180">
        </div>
        <div class="purchase-title">
            <div class="title-row">
                <span>MANUFACTURER:</span>
                <p><?php echo $manufacturer_name2;?></p>
            </div>
            <div class="title-row">
                <span>MODEL:</span>
                <p><?php echo $row["model"];?></p>
            </div>
            <div class="title-row">
                <span>COLOR:</span>
                <p><?php echo $_POST["color"]; ?></p>
                <input type="hidden" value="<?php echo $_POST["color"]; ?>" name="color" id="color">
            </div>

            <div class="title-row">
                <span>STORAGE:</span>
                <p><?php echo $_POST["storage"] . " GB"; ?></p>
                <input type="hidden" value="<?php echo $_POST["storage"]; ?>" name="storage" id="storage">
            </div>
            <div class="title-row">
                <span>QUANTITY:</span>
                <p><?php echo $_POST["quantity"]; ?></p>
                <input type="hidden" value="<?php echo $_POST["quantity"]; ?>" name="quantity" id="quantity">
            </div>
            <div class="title-row">
                <span>PRICE:</span>
                <p><?php echo $row["price"] * $_POST["quantity"];?><small style="font-size: 10px">.00</small> €</p>
                <input type="hidden" value="<?php echo $row["price"] * $_POST["quantity"]; ?>" name="price" id="price">
            </div>
        </div>
    </div>

    <?php } ?>
    <?php } ?>


    <div class="purchase">
        <div class="input-with-icon" style="padding-top: 10px">
            <label for="password">First name</label>
            <input type="text" placeholder="Enter first name" id="fname" name="fname" onfocus="hidePlaceholder(this)" onblur="restorePlaceholder(this)">
        </div>

        <div class="input-with-icon" style="padding-top: 10px">
            <label for="password">Last name</label>
            <input type="text" placeholder="Enter last name" id="lname" name="lname" onfocus="hidePlaceholder(this)" onblur="restorePlaceholder(this)">
        </div>

        <div class="input-with-icon" style="padding-top: 10px">
            <label for="sanda">Street and Address</label>
            <input type="text" placeholder="Enter City and Street and Address" id="sanda" name="sanda" onfocus="hidePlaceholder(this)" onblur="restorePlaceholder(this)">
        </div>

        <div class="input-with-icon" style="padding-top: 10px">
            <label for="city1">City</label>
            <input type="text" placeholder="Enter City" id="city1" name="city1" onfocus="hidePlaceholder(this)" onblur="restorePlaceholder(this)">
        </div>

        <div class="input-with-icon" id="phonenumber">
            <label for="password">Phone number</label>
            <input type="tel" placeholder="Phone number" id="phonenumber" name="phonenumber" onfocus="hidePlaceholder(this)" onblur="restorePlaceholder(this)">
        </div>

        <div class="specification-title" style="padding: 0; width: 100%; justify-content: center;text-align: center;align-items: center">
            <ion-icon name="home" class="icon-large"></ion-icon>
            <input type="radio" value="Home delivery" id="hazhozszallitas" name="delivery_method" onclick="toggleStreetAndAddress()" checked>
            <label for="hazhozszallitas">Home delivery <small>+ 20 €</small></label>
        </div>

        <div class="specification-title" style="padding: 0; padding-bottom: 15px; width: 100%; justify-content: center;text-align: center;align-items: center">
            <ion-icon name="cube" class="icon-large"></ion-icon>
            <input type="radio" value="Postal recording" id="posta" name="delivery_method" onclick="toggleStreetAndAddress()">
            <label for="posta">Postal recording <small>+ 10 €</small></label>
        </div>

        <div id="cities" style="display: none;">
            <label for="city">Város:</label>
            <select id="city" name="city" onchange="showPostOffices()" style=" background-color: lavender; border-radius: 15px">
                <option value="Budapest">Budapest</option>
                <option value="Debrecen">Debrecen</option>
                <option value="Szeged">Szeged</option>
                <option value="Győr">Győr</option>
            </select>
        </div>

        <div id="postOffices" style="display: none; padding-bottom: 15px;">
            <label for="postOffice" >Posta:</label>
            <select id="postOffice" style=" background-color: lavender; border-radius: 15px" name="postOffice">
            </select>
        </div>

    </div>

    <script>
        function toggleStreetAndAddress() {
            const postaRadio = document.getElementById("posta");
            const sandaInput = document.getElementById("sanda");
            const sandaLabel = document.querySelector("label[for='sanda']");
            const cityInput = document.getElementById("city1");
            const cityLabel = document.querySelector("label[for='city1']");
            const firstNameInput = document.getElementById("fname");
            const phoneNumberInput = document.getElementById("phonenumber");
            const phoneNumberDiv = document.querySelector(".input-with-icon");

            if (postaRadio.checked) {
                sandaInput.style.display = "none";
                sandaLabel.style.display = "none";
                cityInput.style.display = "none";
                cityLabel.style.display = "none";
                phoneNumberDiv.style.paddingTop = "0";
                phoneNumberInput.style.paddingTop = "0";
                firstNameInput.style.paddingTop = "0";
            } else {
                sandaInput.style.display = "block";
                sandaLabel.style.display = "block";
                cityInput.style.display = "block";
                cityLabel.style.display = "block";
                phoneNumberDiv.style.paddingTop = "20px";
                phoneNumberInput.style.paddingTop = "20px";
            }
        }




    function showPostOffices() {
            const citySelect = document.getElementById("city");
            const postOfficeSelect = document.getElementById("postOffice");
            const selectedCity = citySelect.value;

            postOfficeSelect.innerHTML = "";

            if (selectedCity === "Budapest") {
                addPostOfficeOption("1011 Budapest");
                addPostOfficeOption("1122 Budapest");
                addPostOfficeOption("1133 Budapest");
            } else if (selectedCity === "Debrecen") {
                addPostOfficeOption("4024 Debrecen");
                addPostOfficeOption("4032 Debrecen");
                addPostOfficeOption("4043 Debrecen");
            } else if (selectedCity === "Szeged") {
                addPostOfficeOption("6721 Szeged");
                addPostOfficeOption("6722 Szeged");
                addPostOfficeOption("6723 Szeged");
            } else if (selectedCity === "Győr") {
                addPostOfficeOption("9028 Győr");
                addPostOfficeOption("9029 Győr");
                addPostOfficeOption("9030 Győr");
            }

            document.getElementById("postOffices").style.display = "block";
        }

        function addPostOfficeOption(postOffice) {
            const postOfficeSelect = document.getElementById("postOffice");
            const option = document.createElement("option");
            option.text = postOffice;
            postOfficeSelect.add(option);
        }

        const postaRadio = document.getElementById("posta");
        postaRadio.addEventListener("click", function() {
            document.getElementById("cities").style.display = "block";
            showPostOffices();
        });

        const hazhozszallitasRadio = document.getElementById("hazhozszallitas");
        hazhozszallitasRadio.addEventListener("click", function() {
            document.getElementById("cities").style.display = "none";
            document.getElementById("postOffices").style.display = "none";
        });
    </script>

    <script>
        function updateSpecificationTitle(radio) {
            const specificationTitle = radio.closest(".specification-title");
            const deliveryMethod = radio.value;
            specificationTitle.textContent = deliveryMethod;
            specificationTitle.prepend(radio);
            specificationTitle.prepend(document.createElement("ion-icon"));
            specificationTitle.firstChild.setAttribute("name", "home");
            specificationTitle.firstChild.classList.add("icon-large");
        }
    </script>

</div>

<?php
if (isset($_GET["error"]) and $_GET["error"] == 201)
{
    echo '<div class="error-message2" style="width: 100%">This already exists!</div>';
}
?>

<div style="width: 100%; display: flex; justify-content: center; align-items: center; height: auto">
<button type="submit" id="purchase-btn" name="purchase-btn" class="btn" style="background-color:#6A5ACD; margin-bottom: 15px; color: white; width: 50%; margin-top: 30px">Purchase</button>
</div>
</form>
<?php }?>

<?php include "includes/footer.php"; ?>

</body>
</html>


