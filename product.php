<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products | @MobilMania </title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>

<style>


    .rating {
        display: inline-block;
        font-size: 24px;
    }

    .rating input[type="radio"] {
        display: none;
    }

    .rating label {
        color: gold;
        cursor: pointer;
    }

    .rating label:hover,
    .rating label:hover ~ label {
        color: white;
    }

    .rating input[type="radio"]:checked ~ label {
        color: white;
    }

    #ratingValue {
        font-weight: bold;
    }

    #phone-image-container {
        width: 300px;
        height: 200px;
        overflow: hidden;
    }

    #phone-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        max-width: 100%;
        max-height: 100%;
    }
</style>
<body>
<div class="nav-phones">
    <?php
    include "includes/nav.php";

    $id_phone = $_GET["id_phone"];

    $conn = connectDatabase($dsn, $pdoOptions);

    $sql = "SELECT * FROM phones WHERE id_phone = '$id_phone'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql11 = "SELECT * FROM colors WHERE id_phone = '$id_phone'";
    $stmt11 = $conn->prepare($sql11);
    $stmt11->execute();
    $results11 = $stmt11->fetchAll(PDO::FETCH_ASSOC);

    $sql5 = "SELECT * FROM storage WHERE id_phone = '$id_phone' ORDER BY storage ASC";
    $stmt5 = $conn->prepare($sql5);
    $stmt5->execute();
    $results5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);

    $sql6 = "SELECT COUNT(*) AS total FROM ratings WHERE id_phone = '$id_phone'";
    $stmt6 = $conn->prepare($sql6);
    $stmt6->execute();
    $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);

    $sql12 = "SELECT color FROM colors WHERE id_phone = '$id_phone' ORDER BY id_color ASC LIMIT 1";
    $stmt12 = $conn->prepare($sql12);
    $stmt12->execute();
    $result12 = $stmt12->fetch(PDO::FETCH_ASSOC);

    $defaultColor = $result12['color'];

    ?>
</div>

<?php echo '<form action="purchase.php?id_phone='.$id_phone.'" method="post">'?>

<div class="product-image-buttons">

    <div class="product-image">
     <?php
     $sql2 = "SELECT * FROM colors WHERE id_phone = '$id_phone' ORDER BY id_color DESC";
     $res2 = $conn->query($sql2);
     $rows2 = $res2->fetchAll();
     $color = "";
     ?>
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
                foreach ($rows2 as $row2)
                {
                    $color = $row2["color"];
                    $colorOptions[] = $row2["color"];
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

                $directory = "phone-img/".$manufacturer_name2."/".$id_phone."/";
                $filecount = count(glob($directory . "*"));

                $count = 0;

                for ($j = 1; $j <= $filecount; $j++)
                {

                    if (file_exists($directory."$j-$color.jpg"))
                    {
                        $count++;
                    }

                    if (file_exists($directory."$j-$color.jpeg"))
                    {
                        $count++;
                    }

                    if (file_exists($directory."$j-$color.png"))
                    {
                        $count++;
                    }
                }
        ?>
                <div id="smallImageContainer">
                    <?php
                    for ($i = 2; $i <= $count; $i++) {
                        $img_path = "";
                        if (file_exists($directory . "$i-$color.jpg")) {
                            $img_path = $directory . "$i-$color.jpg";
                        } elseif (file_exists($directory . "$i-$color.jpeg")) {
                            $img_path = $directory . "$i-$color.jpeg";
                        } elseif (file_exists($directory . "$i-$color.png")) {
                            $img_path = $directory . "$i-$color.png";
                        }



                        if (!empty($img_path)) {
                            ?>
                            <img id="small-image-<?= $i . '-' . $color ?>" class="small-image" src="<?= $img_path ?>" data-color="<?= $color ?>" onclick="switchImage('small-image-<?= $i . '-' . $color ?>', 'phone-image')">
                            <?php
                        }
                    }

                    ?>
                </div>
                <?php
            }
        ?>
                <div id="phone-image-container">
                    <img id="phone-image" src="<?= $img_name ?>" >
                </div>
            </div>

            <script>
                function switchImage(smallImageId, bigImageId) {
                    var smallImage = document.getElementById(smallImageId);
                    var bigImage = document.getElementById(bigImageId);
                    var smallImageSrc = smallImage.src;
                    var bigImageSrc = bigImage.src;
                    smallImage.src = bigImageSrc;
                    bigImage.src = smallImageSrc;
                }
            </script>

            <div class="product-text">

                <?php if ($stmt1->rowCount() > 0) { ?>
                    <?php foreach ($results1 as $row1) { ?>
                        <p><?php echo $row1["manufacturer"];?></p>
                    <?php }?>
                <?php }?>
                <h3 ><?php echo $row["model"];?></h3>

                <div id="colorPalette">
                    <?php if ($stmt11->rowCount() > 0) { ?>
                        <?php foreach ($results11 as $row11) { ?>
                            <label class="color" >
                                <input type="radio" name="color" value="<?= $row11["color"]; ?>" data-color="<?= $row11["color"]; ?>" onclick="changeImageByColor('<?= $row11["color"] ?>')" >
                                <div class="color-circle" style="background-color: <?= $row11["color"]; ?>" ></div>
                                <span class="checkmark"></span>
                            </label>
                        <?php } ?>
                    <?php } ?>
                </div>

                <?php
                if (isset($_GET["error"]) and $_GET["error"] == 101)
                {
                    echo '<div class="error-message2" style="width: 50%; "> Choose a color!</div>';
                }
                ?>

                <script>
                    function switchImage1(smallImageId, bigImageId) {
                        var smallImage = document.getElementById(smallImageId);
                        var bigImage = document.getElementById(bigImageId);
                        var smallImageSrc = smallImage.src;

                        var tempBigImageSrc = bigImage.src;

                        smallImage.src = tempBigImageSrc;
                        bigImage.src = smallImageSrc;
                    }

                    function changeImageByColor(color) {
                        var imageContainer = document.getElementById("smallImageContainer");
                        imageContainer.innerHTML = "";

                        var directory = "phone-img/<?= $manufacturer_name2 ?>/<?= $id_phone ?>/";
                        var filecount = <?= $filecount ?>;

                        var results11 = <?= json_encode($results11) ?>;

                        results11.forEach(function (row11, index) {
                            var imagePath = directory + (index + 2) + "-" + color + ".png";

                            var img = new Image();
                            img.src = imagePath;

                            img.onload = function () {
                                var newImage = document.createElement("img");
                                newImage.src = this.src;
                                newImage.classList.add("small-image");
                                newImage.setAttribute("data-color", color);

                                newImage.setAttribute("onclick", "switchImage1('phone-image', 'smallImage" + (index + 2) + "')");
                                newImage.id = "smallImage" + (index + 2);
                                imageContainer.appendChild(newImage);
                            };
                        });

                        var phoneImage = document.getElementById("phone-image");
                        phoneImage.src = directory + "1-" + color + ".png";
                    }
                </script>





                <?php
                if (isset($_SESSION["id_user"])) {
                    echo '<div class="rating">';
                    for ($i = 1; $i <= 5; $i++) {
                        $checked = (isset($_SESSION['storedRating']) && $_SESSION['storedRating'] == $i) ? 'checked' : '';
                        echo '<input type="radio" id="star' . $i . '" name="rating" value="' . $i . '" onclick="submitRating(' . $i . ')" ' . $checked . '>';
                        echo '<label for="star' . $i . '" onmouseover="handleStarHover(' . $i . ')" onmouseout="resetStars()">&#9733;</label>';
                    }
                    echo '</div>';

                    if ($stmt6->rowCount() > 0) {
                        echo '<p>Rating: <span id="ratingValue"></span> (<span id="numberOfRatings"></span> people)</p>';
                    }
                } else {
                    echo '<div class="rating" style="pointer-events: none; opacity: 0.5;">
                <input type="radio" id="star1" name="rating" value="1" disabled>
                <label for="star1" onmouseover="handleStarHover(1)" onmouseout="resetStars()">&#9733;</label>
                <input type="radio" id="star2" name="rating" value="2" disabled>
                <label for="star2" onmouseover="handleStarHover(2)" onmouseout="resetStars()">&#9733;</label>
                <input type="radio" id="star3" name="rating" value="3" disabled>
                <label for="star3" onmouseover="handleStarHover(3)" onmouseout="resetStars()">&#9733;</label>
                <input type="radio" id="star4" name="rating" value="4" disabled>
                <label for="star4" onmouseover="handleStarHover(4)" onmouseout="resetStars()">&#9733;</label>
                <input type="radio" id="star5" name="rating" value="5" disabled>
                <label for="star5" onmouseover="handleStarHover(5)" onmouseout="resetStars()">&#9733;</label>
            </div>';

                    if ($stmt6->rowCount() > 0) {
                        echo '<p>Rating: <span id="ratingValue"></span> (<span id="numberOfRatings"></span> people)</p>';
                    }
                }
                ?>
                <div class="checkbox-wrapper">
                    <?php if ($stmt5->rowCount() > 0) {
                        foreach ($results5 as $row5) {
                        if (isset($_SESSION["id_user"]))
                        {
                            echo '       
                            <label class="checkbox"  style="margin-left: 2px">
                            <input type="radio" name="storage" id="storage" value="'.$row5["storage"].'">
                            <span class="checkmark" ></span>
                            <span class="checkbox-text">'.$row5["storage"].' GB</span>
                            </label>
                             ';
                        }
                        else
                        {
                            echo '       
                            <label class="checkbox"  style="margin-left: 2px">
                            <input type="radio" name="storage" id="storage" value="'.$row5["storage"].'" disabled>
                            <span class="checkmark" ></span>
                            <span class="checkbox-text">'.$row5["storage"].' GB</span>
                            </label>
                             ';
                        }
                        }
                    }?>
                </div>

                <?php
                if (isset($_GET["error"]) and $_GET["error"] == 999)
                {
                    echo '<div class="error-message2" style="width: 50%; "> Choose a storage!</div>';
                }
                ?>

                <?php if (isset($_SESSION["id_user"])) { ?>
                <div class="product-number">
                    <a>Quantity:</a>
                    <input type="number" name="quantity" id="quantity" min="1" max="5" value="1" style="width: 10%; text-align: center; border: 1px solid black; border-radius: 20px; margin-top: 2.5rem">
                </div>

                <?php
                if (isset($_GET["error"]) and $_GET["error"] == 102)
                {
                    echo '<div class="error-message2" style="width: 50%; "> Enter a value between 1-5!</div>';
                }
                ?>
                <?php
                }
                else
                {

                }
                ?>

                <h2 class="ar" style="margin-top: 30px; margin-bottom: 0px"><?php echo $row["price"];?><small style="font-size: 22px">.00</small> €</h2>
                <br>

                <div class="image-and-button">
                    <?php
                    if (isset($_SESSION["id_user"]))
                    {
                        echo'<button type="submit" class="btn" id="purchase-btn" name="purchase-btn">Purchase</button>';
                    }
                    else
                    {
                        echo'<button class="btn" style="border: 1px solid #ff0000; background-color: #ff9898; color: #000000; cursor: not-allowed;" disabled>Sign in to make a purchase.</button>';
                    }
                    ?>

                    <?php if (isset($_SESSION["id_user"])) {

                        $pdoQuery = $conn->prepare("SELECT * FROM favourites WHERE id_phone = ? AND id_user = ?");
                        $pdoQuery->execute([$id_phone, $_SESSION["id_user"]]);
                        $alreadyExists = $pdoQuery->fetch();
                    ?>

                    <form id="favorite-form" data-id="<?php echo $id_phone; ?>">
                        <button type="button" id="heart-button" style="background: none; border: none; cursor: pointer; outline: none;">
                            <ion-icon name="<?php echo $alreadyExists ? 'heart' : 'heart-outline'; ?>" style="font-size: 35px;"></ion-icon>
                        </button>
                    </form>



                    <?php  } ?>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const heartButton = document.getElementById("heart-button");
                            const idPhone = <?php echo $id_phone; ?>;
                            const favoritesCheckerAjaxUrl = "favourites_checker_ajax.php";

                            heartButton.addEventListener("click", function() {
                                const xhr = new XMLHttpRequest();
                                const formData = new FormData();
                                formData.append("id_phone", idPhone);

                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState === XMLHttpRequest.DONE) {
                                        if (xhr.status === 200) {
                                            const response = xhr.responseText;
                                            if (response === "added") {
                                                heartButton.innerHTML = '<ion-icon name="heart" style="font-size: 35px;"></ion-icon>';
                                            } else if (response === "removed") {
                                                heartButton.innerHTML = '<ion-icon name="heart-outline" style="font-size: 35px;"></ion-icon>';
                                            }
                                        } else {
                                            console.error("Hiba történt az Ajax kérés során.");
                                        }
                                    }
                                };

                                xhr.open("POST", favoritesCheckerAjaxUrl, true);
                                xhr.send(formData);
                            });
                        });
                    </script>





                </div>
                <?php
                if (isset($_GET["error"]) and $_GET["error"] == 501)
                {
                    echo '<div class="error-message2" style="width: 100%">Fill in the fields correctly!</div>';
                }
                ?>
            </div>
        <?php } ?>
    <?php } ?>
</div>
<form>
<h1 style="text-align: center;margin-bottom: 20px; margin-top: 8rem">Specifiactions</h1>



<div class="specification-table">
    <?php if ($stmt->rowCount() > 0) { ?>
        <?php foreach ($results as $row) { ?>
            <div class="specification-row">
                <div class="specification-title"><ion-icon name="document-outline" class="icon-large"></ion-icon>Basic characteristics</div>
                <div class="specification-label">
                    <p>Operating system</p>
                    <p>Processor</p>
                    <p>Operating system version</p>
                    <p style="padding-bottom: 10px">Type of SIM card.</p>
                </div>
                <div class="specification-value">
                    <p><?php echo $row["operating_system"]?></p>
                    <p><?php echo $row["processor"]?></p>
                    <p><?php echo $row["operating_system_v"]?></p>
                    <p style="padding-bottom: 10px"><?php echo $row["sim"]?></p>
                </div>
            </div>

            <div class="specification-row">
                <div class="specification-title"><ion-icon name="tablet-landscape-outline" class="icon-large"></ion-icon>Screen</div>
                <div class="specification-label">
                    <p>Screen size</p>
                </div>
                <div class="specification-value">
                    <p><?php echo $row["screen_size"]?> inch</p>
                </div>
            </div>

            <div class="specification-row">
                <div class="specification-title"><ion-icon name="battery-full-outline" class="icon-large"></ion-icon>Battery</div>
                <div class="specification-label">
                    <p style="padding-bottom: 10px">Capacity</p>
                </div>
                <div class="specification-value">
                    <p style="padding-bottom: 10px"><?php echo $row["capacity"]?>  mAh</p>
                </div>
            </div>

            <div class="specification-row">
                <div class="specification-title"><ion-icon name="volume-medium-outline" class="icon-large"></ion-icon>Audio</div>
                <div class="specification-label">
                    <p style="padding-bottom: 10px">FM radio</p>
                </div>
                <div class="specification-value">
                    <p style="padding-bottom: 10px"><?php echo $row["fm_radio"]?></p>
                </div>
            </div>

            <div class="specification-row">
                <div class="specification-title"><ion-icon name="cloud-circle-outline" class="icon-large"></ion-icon>Memory</div>
                <div class="specification-label">
                    <p>RAM</p>
                    <p>External</p>
                    <p style="padding-bottom: 10px">Internal</p>
                </div>
                <div class="specification-value">
                    <p><?php echo $row["ram"]?> GB</p>
                    <p><?php echo $row["external"]?></p>
                    <p style="padding-bottom: 10px"><?php echo $row["internal"]?> GB</p>
                </div>
            </div>

            <div class="specification-row">
                <div class="specification-title"><ion-icon name="camera-outline" class="icon-large"></ion-icon>Main camera</div>
                <div class="specification-label">
                    <p>Primary camera</p>
                    <p>Flash</p>
                    <p>Video recording</p>
                    <p>Face detection</p>
                    <p>Autofocus</p>
                    <p style="padding-bottom: 10px">LED flash</p>
                </div>
                <div class="specification-value">
                    <p><?php echo $row["main_primary_camera"]?> MP</p>
                    <p><?php echo $row["main_flash"]?></p>
                    <p><?php echo $row["main_video_record"]?></p>
                    <p><?php echo $row["main_face_detect"]?></p>
                    <p><?php echo $row["main_autofocus"]?></p>
                    <p style="padding-bottom: 10px"><?php echo $row["main_led_flash"]?></p>
                </div>
            </div>

            <div class="specification-row">
                <div class="specification-title"><ion-icon name="camera-reverse-outline" class="icon-large"></ion-icon>Secondary camera</div>
                <div class="specification-label">
                    <p style="padding-top: 0;">Secondary</p>
                    <p>Smile detection</p>
                    <p>Video recording</p>
                    <p>LED flash</p>
                    <p>Flash</p>
                    <p style="padding-bottom: 0px">Autofocus</p>
                </div>
                <div class="specification-value">
                    <p style="padding-top: 0;"><?php echo $row["secondary_second"]?> MP</p>
                    <p><?php echo $row["second_smile_detection"]?></p>
                    <p><?php echo $row["second_video"]?></p>
                    <p><?php echo $row["second_led_flash"]?></p>
                    <p><?php echo $row["second_flash"]?></p>
                    <p style="padding-bottom: 0px"><?php echo $row["second_autofocus"]?></p>
                </div>
            </div>

            <div class="specification-row">
                <div class="specification-title"><ion-icon name="git-compare-outline" class="icon-large"></ion-icon>Communication</div>
                <div class="specification-label">
                    <p>Wi-Fi</p>
                    <p>Bluetooth</p>
                    <p>USB</p>
                    <p>NFC</p>
                    <p>GPS</p>
                    <p style="padding-bottom: 10px">Mobile network</p>
                </div>
                <div class="specification-value">
                    <p><?php echo $row["wifi"]?></p>
                    <p><?php echo $row["bluetooth"]?></p>
                    <p><?php echo $row["usb"]?></p>
                    <p><?php echo $row["nfc"]?></p>
                    <p><?php echo $row["gps"]?></p>
                    <p style="padding-bottom: 10px"><?php echo $row["mobile_network"]?></p>
                </div>
            </div>

            <div class="specification-row">
                <div class="specification-title"><ion-icon name="wifi-outline" class="icon-large"></ion-icon>Mobile network</div>
                <div class="specification-label">
                    <p>2G</p>
                    <p>3G</p>
                    <p>4G</p>
                    <p style="padding-bottom: 10px">5G</p>
                </div>
                <div class="specification-value">
                    <p><?php echo $row["2g"]?></p>
                    <p><?php echo $row["3g"]?></p>
                    <p><?php echo $row["4g"]?></p>
                    <p style="padding-bottom: 10px"><?php echo $row["5g"]?></p>
                </div>
            </div>

            <div class="specification-row">
                <div class="specification-title"><ion-icon name="barbell-outline" class="icon-large"></ion-icon>Weight</div>
                <div class="specification-label">
                    <p style="padding-bottom: 10px">Weight</p>
                </div>
                <div class="specification-value">
                    <p style="padding-bottom: 10px"><?php echo $row["weight"]?> g</p>
                </div>
            </div>

            <div class="specification-row">
                <div class="specification-title"><ion-icon name="document-text-outline" class="icon-large"></ion-icon>Other</div>
                <div class="specification-label">
                    <p>SMS</p>
                    <p style="padding-bottom: 10px">Email</p>
                </div>
                <div class="specification-value">
                    <p><?php echo $row["sms"]?></p>
                    <p style="padding-bottom: 10px"><?php echo $row["email"]?></p>
                </div>
            </div>

            <div class="specification-row">
                <div class="specification-title"><ion-icon name="scan-circle-outline" class="icon-large"></ion-icon>Dimensions</div>
                <div class="specification-label">
                    <p>Height</p>
                    <p>Width</p>
                    <p style="padding-bottom: 10px">Length</p>
                </div>
                <div class="specification-value">
                    <p><?php echo $row["height"]?> mm</p>
                    <p><?php echo $row["width"]?> mm</p>
                    <p style="padding-bottom: 10px"><?php echo $row["length"]?> mm</p>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>

<div class="product-help">
    <div class="product-text-help-question">
        <ion-icon name="help-circle-outline" class="icon-help"></ion-icon>
        <h3>Asked Questions</h3>
        <p>Check if there is already an <br>answer to your question.</p>
    </div>

    <div class="product-text-help-email">
        <ion-icon name="mail-outline" class="icon-help"></ion-icon>
        <h3>Ask us</h3>
        <p>Send us an email to Customer Support.</p>
    </div>

    <div class="product-text-help-phone">
        <ion-icon name="call-outline" class="icon-help"></ion-icon>
        <h3>Contact center</h3>
        <p>For customer support, call 0800 100 100. <br>We are here for you 24 hours a day!</p>
    </div>

    <div class="product-text-help-phone">
        <ion-icon name="pin-outline" class="icon-help"></ion-icon>
        <h3>Branch offices.</h3>
        <p>Visit our sales locations and find<br> out everything you're interested in.</p>
    </div>
</div>



<script>
    const stars = document.querySelectorAll('.rating input');
    const labels = document.querySelectorAll('.rating label');
    let currentRating = 0;
    let originalRating = 0;

    function handleStarHover(rating) {
        for (let i = 0; i < stars.length; i++) {
            if (i >= rating) {
                labels[i].style.color = '#fff';
            } else {
                labels[i].style.color = '#ffd700';
            }
        }
    }

    function resetStars() {
        handleStarHover(originalRating);
    }

    function updateRatingUI(rating) {
        var ratingValue = document.getElementById('ratingValue');
        ratingValue.textContent = rating;

        var labels = document.querySelectorAll('.rating label');
        for (var i = 0; i < labels.length; i++) {
            labels[i].style.color = (i < rating) ? 'gold' : 'white';
        }
    }

    function getRating() {
        var phoneId = <?php echo json_encode($_GET["id_phone"]); ?>;
        var xhrRating = new XMLHttpRequest();
        xhrRating.open("GET", "get_rating.php?id_phone=" + phoneId, true);
        xhrRating.onreadystatechange = function() {
            if (xhrRating.readyState === XMLHttpRequest.DONE) {
                if (xhrRating.status === 200) {
                    var responseRating = JSON.parse(xhrRating.responseText);
                    var rating = responseRating.rating;
                    originalRating = rating;
                    updateRatingUI(rating);
                } else {
                    console.error("Hiba történt a rating lekérdezésekor.");
                }
            }
        };
        xhrRating.send();

        var xhrRatingCount = new XMLHttpRequest();
        xhrRatingCount.open("GET", "get_rating_count.php?id_phone=" + phoneId, true);
        xhrRatingCount.onreadystatechange = function() {
            if (xhrRatingCount.readyState === XMLHttpRequest.DONE) {
                if (xhrRatingCount.status === 200) {
                    var responseRatingCount = JSON.parse(xhrRatingCount.responseText);
                    var numberOfRatings = responseRatingCount.numberOfRatings;
                    updateRatingCountUI(numberOfRatings);
                } else {
                    console.error("Hiba történt a rating szám lekérdezésekor.");
                }
            }
        };
        xhrRatingCount.send();
    }

    stars.forEach((star, index) => {
        star.addEventListener('mouseover', () => {
            handleStarHover(index + 1);
        });

        star.addEventListener('mouseout', () => {
            resetStars();
        });

        star.addEventListener('click', () => {
            currentRating = index + 1;
            submitRating(currentRating);
        });
    });

    function submitRating(rating) {
        var phoneId = <?php echo json_encode($_GET["id_phone"]); ?>;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "add_rating.php?id_phone=" + phoneId, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log("A rating sikeresen elküldve!");
                    getRating();
                } else {
                    console.error("Hiba történt a rating elküldésekor.");
                }
            }
        };
        xhr.send("rating=" + rating);
    }

    function updateRatingCountUI(numberOfRatings) {
        var numberOfRatingsElement = document.getElementById('numberOfRatings');
        numberOfRatingsElement.textContent = numberOfRatings;
    }

    window.addEventListener('load', function() {
        getRating();
    });

</script>



<?php include "includes/footer.php"; ?>


</body>
</html>