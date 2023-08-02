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
    <title>Add Phones | @MobilMania </title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>

<style>

    input{
        width:300px;
    }

    .input-wrapper {
        position: relative;
        line-height: 14px;
        margin: 0 10px;
        display: inline-block;
    }

    label {
        color: #bbbbbb;
        font-size: 11px;
        text-transform: uppercase;
        position: absolute;
        z-index: 2;
        left: 20px;
        top: 14px;
        padding: 0 2px;
        pointer-events: none;
        background: #fff;
        -webkit-transition: -webkit-transform 100ms ease;
        -moz-transition: -moz-transform 100ms ease;
        -o-transition: -o-transform 100ms ease;
        -ms-transition: -ms-transform 100ms ease;
        transition: transform 100ms ease;
        -webkit-transform: translateY(-20px);
        -moz-transform: translateY(-20px);
        -o-transform: translateY(-20px);
        -ms-transform: translateY(-20px);
        transform: translateY(-20px);
    }
    input {
        font-size: 13px;
        color: #bbbbbb;
        outline: none;
        border: 1px solid #bbbbbb;
        padding: 3px 20px;
        border-radius: 20px;
        position: relative;
    }
    input:invalid + label {
        -webkit-transform: translateY(0);
        -moz-transform: translateY(0);
        -o-transform: translateY(0);
        -ms-transform: translateY(0);
        transform: translateY(0);
    }
    input:focus {
        border-color: #6A5ACD;
    }
    input:focus + label {
        color: #6A5ACD;
        -webkit-transform: translateY(-20px);
        -moz-transform: translateY(-20px);
        -o-transform: translateY(-20px);
        -ms-transform: translateY(-20px);
        transform: translateY(-20px);
    }

    .select-wrapper {
        position: relative;
        display: inline-block;
    }

    select {
        width: 300px;
        font-size: 13px;
        color: #bbbbbb;
        outline: none;
        border: 1px solid #bbbbbb;
        padding: 3px 20px;
        border-radius: 20px;
    }

    select option {
        color: #bbbbbb;
    }

    select option:checked {
        color: black;
    }



    label {
        color: #bbbbbb;
        font-size: 11px;
        text-transform: uppercase;
        position: absolute;
        z-index: 2;
        left: 20px;
        top: 14px;
        pointer-events: none;
        background: #ffffff;
        transition: transform 100ms ease;
        transform: translateY(-20px);
    }

    select:focus {
        border-color: #6A5ACD;
    }

    select:focus + label {
        color: #6A5ACD;
        transform: translateY(-20px);
    }

    input[type=file]::file-selector-button{
        display: none;
    }

    input::placeholder {
        color: #bbbbbb;
    }
</style>
<body>

<div class="nav-phones">


    <?php

    include "includes/nav.php";



    $conn = connectDatabase($dsn, $pdoOptions);

    $sql = "SELECT * FROM manufacturers";
    $stmt =$conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql1 = "SELECT * FROM phones";
    $stmt1 =$conn->prepare($sql1);
    $stmt1->execute();
    $results1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    $sql7 = "SELECT DISTINCT id_phone, model FROM phones";
    $stmt7 = $conn->query($sql7);
    $results7 = $stmt7->fetchAll(PDO::FETCH_ASSOC);

    ?>
</div>

<div class="add_manufacturer">
    <h2>Add manufacturer</h2>
    <hr style="width: 30%; margin-top: 15px; margin-bottom: 15px;">
    <form action="manufacturer.php" method="post">

    <div class="input-wrapper">
        <input type="text" id="manufacturer" name="manufacturer"  style="padding: 10px">
        <label for="user">Manufacturer</label>
    </div>

        <?php
        if (isset($_GET["error"]) and $_GET["error"] == 1)
        {
            echo '<div class="error-message2">Fill in the field!</div>';
        }

        if (isset($_GET["error"]) and $_GET["error"] == 2)
        {
            echo '<div class="error-message2">Enter normal format!</div>';
        }

        if (isset($_GET["error"]) and $_GET["error"] == 3)
        {
            echo '<div class="error-message2">This already exists!</div>';
        }

        if (isset($_GET["ok"]) and $_GET["ok"] == 1)
        {
            echo '<div class="success-message2">Success!</div>';
        }
        ?>

    <button type="submit" id="manufacturer-btn" name="manufacturer-btn" class="btn" style="background-color:#6A5ACD; color: white; width: 95%; margin-top: 15px;">Add manufacturer</button>
    </form>
</div>

<form action="add_phones_checker.php" method="post" enctype="multipart/form-data">

<div class="add_manufacturer" style="margin-bottom: 25px">
    <hr style="width: 30%; margin-top: 15px; margin-bottom: 15px;">
    <h3>Add phone</h3>


        <div class="select-wrapper">
            <select id="manufacturer" name="manufacturer" style="padding: 10px">
                <option value="" selected disabled>Select manufacturer</option>
                <?php
                if ($stmt->rowCount() > 0) {
                    foreach ($results as $row) {
                        $manufacturerName = $row['manufacturer'];
                        echo '<option value="' . $manufacturerName . '" id="' . $manufacturerName . '" name="manufacturer">' . $manufacturerName . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="input-wrapper" style="margin-top: 25px">
            <input type="text" id="model" name="model" style="padding: 10px;" placeholder="Example: Galaxy A51">
            <label for="user">Model</label>
        </div>

        <div class="input-wrapper" style="margin-top: 25px">
            <input type="number" id="price" name="price" style="padding: 10px;" placeholder="Example: 1500" min="1">
            <label for="user">Price</label>
        </div>

        <div class="input-wrapper" style="margin-top: 25px">
            <input type="file" id="image" name="image[]" style="padding: 25px;" multiple>
            <label for="image">Image Upload</label>
        </div>

        <div class="input-wrapper" style="margin-top: 25px">
            <input type="text" id="color" name="color" style="padding: 10px;" placeholder="Example: Black">
            <label for="user">color</label>
        </div>
</div>




<div class="specification-table">
<form>
    <div class="specification-row">
        <div class="specification-title"><ion-icon name="document-outline" class="icon-large"></ion-icon>Basic characteristics</div>
        <div class="specification-label">
            <p>Operating system</p>
            <p>Processor</p>
            <p>Operating system version</p>
            <p style="padding-bottom: 10px">Type of SIM card.</p>
        </div>
        <div class="specification-value">
            <div class="input-wrapper">
                <input type="text" id="os" name="os" placeholder="Example: iOS 15">
            </div>
            <div class="input-wrapper" style="margin-top: 5px">
                <input type="text" id="processor" name="processor" placeholder="Example: Apple A15 Bionic">
            </div>
            <div class="input-wrapper" style="margin-top: 5px">
                <input type="number" id="osversion" name="osversion" placeholder="Example: 15" min="1">
            </div>
            <div class="input-wrapper" style="margin-top: 5px">
                <input type="text" id="sim" name="sim" placeholder="Example: Dual SIM">
            </div>
        </div>
    </div>

    <div class="specification-row">
        <div class="specification-title"><ion-icon name="tablet-landscape-outline" class="icon-large"></ion-icon>Screen</div>
        <div class="specification-label">
            <p>Screen size</p>
        </div>
        <div class="specification-value">
            <div class="input-wrapper" style="margin-top: 5px">
                <input type="text" id="screensize" name="screensize" placeholder="Example: 6.1 (inch)">
            </div>
        </div>
    </div>

    <div class="specification-row">
        <div class="specification-title"><ion-icon name="battery-full-outline" class="icon-large"></ion-icon>Battery</div>
        <div class="specification-label">
            <p style="padding-bottom: 10px">Capacity</p>
        </div>
        <div class="specification-value">
            <div class="input-wrapper" style="margin-top: 5px">
                <input type="number" id="capcaity" name="capcaity" placeholder="Example: 3240 (mAh)" min="1">
            </div>
        </div>
    </div>

    <div class="specification-row">
        <div class="specification-title"><ion-icon name="volume-medium-outline" class="icon-large"></ion-icon>Audio</div>
        <div class="specification-label">
            <p style="padding-bottom: 10px">FM radio</p>
        </div>
        <div class="specification-value">
            <div class="select-wrapper" style="margin-top: 5px; margin-left: 10px">
                <select id="fmradio" name="fmradio">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
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
            <div class="input-wrapper">
                <input type="number" id="ram" name="ram" placeholder="Example: 4 (GB)" min="1">
            </div>
            <div class="select-wrapper" style="margin-top: 5px; margin-left: 10px">
                <select id="external" name="external">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="input-wrapper" style="margin-top: 5px">
                <input type="number" id="internal" name="internal" placeholder="Example: 128 (GB)" min="1">
            </div>
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
            <div class="input-wrapper">
                <input type="number" id="primarycamera" name="primarycamera" placeholder="Example: 12 (MP)" min="1">
            </div>
            <div class="select-wrapper" style="margin-top: 5px; margin-left: 10px">
                <select id="flash1" name="flash1">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="select-wrapper" style="margin-top: 5px; margin-left: 10px">
                <select id="videorecording1" name="videorecording1">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="select-wrapper" style="margin-top: 5px; margin-left: 10px">
                <select id="facedetection" name="facedetection">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="select-wrapper" style="margin-top: 5px; margin-left: 10px">
                <select id="autofocus" name="autofocus">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="select-wrapper" style="margin-top: 5px; margin-left: 10px;">
                <select id="ledflash1" name="ledflash1">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
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
            <div class="input-wrapper">
                <input type="number" id="secondary" name="secondary" placeholder="Example: 12 (MP)" min="1">
            </div>
            <div class="select-wrapper" style="margin-top: 5px; margin-left: 10px;">
                <select id="smiledetection" name="smiledetection">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="select-wrapper" style="margin-top: 5px; margin-left: 10px;">
                <select id="videorecording2" name="videorecording2">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="select-wrapper" style="margin-top: 5px; margin-left: 10px;">
                <select id="ledflash2" name="ledflash2">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="select-wrapper" style="margin-top: 5px; margin-left: 10px;">
                <select id="flash2" name="flash2">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="select-wrapper" style="margin-top: 5px; margin-left: 10px;">
                <select id="autofocus2" name="autofocus2">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
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
            <div class="select-wrapper" style=" margin-left: 10px;">
                <select id="wifi" name="wifi">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="select-wrapper" style="margin-top: 5px; margin-left: 10px;">
                <select id="bluetooth" name="bluetooth">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="select-wrapper" style="margin-top: 5px; margin-left: 10px;">
                <select id="usb" name="usb">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="select-wrapper" style="margin-top: 5px; margin-left: 10px;">
                <select id="nfc" name="nfc">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="input-wrapper" style="margin-top: 5px">
                <input type="text" id="gps" name="gps" placeholder="Example: A-GPS">
            </div>
            <div class="select-wrapper" style="margin-top: 5px; margin-left: 10px;">
                <select id="mobilenetwork" name="mobilenetwork">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
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
            <div class="select-wrapper" style="margin-left: 10px;">
                <select id="2g" name="2g">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="select-wrapper" style="margin-top: 7px; margin-left: 10px;">
                <select id="3g" name="3g">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="select-wrapper" style="margin-top: 7px; margin-left: 10px;">
                <select id="4g" name="4g">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="select-wrapper" style="margin-top: 7px; margin-left: 10px;">
                <select id="5g" name="5g">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
        </div>
    </div>

    <div class="specification-row">
        <div class="specification-title"><ion-icon name="barbell-outline" class="icon-large"></ion-icon>Weight</div>
        <div class="specification-label">
            <p style="padding-bottom: 10px">Weight</p>
        </div>
        <div class="specification-value">
            <div class="input-wrapper">
                <input type="number" id="weight" name="weight" placeholder="Example: 174 (g)" min="1">
            </div>
        </div>
    </div>

    <div class="specification-row">
        <div class="specification-title"><ion-icon name="document-text-outline" class="icon-large"></ion-icon>Other</div>
        <div class="specification-label">
            <p>SMS</p>
            <p style="padding-bottom: 10px">Email</p>
        </div>
        <div class="specification-value">
            <div class="select-wrapper" style="margin-top:5px;margin-left: 10px;">
                <select id="sms" name="sms">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="select-wrapper" style="margin-top: 7px; margin-left: 10px;">
                <select id="email" name="email">
                    <option value="" selected disabled>Option</option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
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
            <div class="input-wrapper" style="margin-top: 5px">
                <input type="text" id="height" name="height" placeholder="Example: 146.70 (mm)">
            </div>
            <div class="input-wrapper" style="margin-top: 5px">
                <input type="text" id="width" name="width" placeholder="Example: 7.65 (mm)">
            </div>
            <div class="input-wrapper" style="margin-top: 5px">
                <input type="text" id="length" name="length" placeholder="Example: 71.50 (mm)">
            </div>
        </div>
    </div>

    <?php
    if (isset($_GET["error"]) and $_GET["error"] == 4)
    {
        echo '<div class="error-message2" style="width: 100%">Fill in the fields properly!</div>';
    }

    if (isset($_GET["error"]) and $_GET["error"] == 5)
    {
        echo '<div class="error-message2" style="width: 100%">Only yes or no can appear in the listing!</div>';
    }

    if (isset($_GET["error"]) and $_GET["error"] == 6)
    {
        echo '<div class="error-message2" style="width: 100%">Fill in all the fields!</div>';
    }

    if (isset($_GET["error"]) and $_GET["error"] == 7)
    {
        echo '<div class="error-message2" style="width: 100%">Enter a normal price!</div>';
    }

    if (isset($_GET["error"]) and $_GET["error"] == 8)
    {
        echo '<div class="error-message2" style="width: 100%">The numbers cannot go into <b>(-)</b> value</div>';
    }

    if (isset($_GET["error"]) and $_GET["error"] == 9)
    {
        echo '<div class="error-message2" style="width: 100%">This already exists!</div>';
    }

    if (isset($_GET["error"]) and $_GET["error"] == 10)
    {
        echo '<div class="error-message2" style="width: 100%">Enter a normal image format!</div>';
    }

    if (isset($_GET["error"]) and $_GET["error"] == 31)
    {
        echo '<div class="error-message2" style="width: 100%">Enter a normal color!</div>';
    }

    if (isset($_GET["ok"]) and $_GET["ok"] == 2)
    {
        echo '<div class="success-message2" style="width: 100%;">Success!</div>';
    }
    ?>
    <button type="submit" id="add-phone-btn" name="add-phone-btn" class="btn" style="background-color:#6A5ACD; color: white; width: 100%; margin-top: 15px; margin-bottom: 25px">Add phone</button>
</div>
</form>

<div class="add_manufacturer">
    <h2>Add storage</h2>
    <hr style="width: 30%; margin-top: 15px; margin-bottom: 15px;">
    <form action="storage.php" method="post">

        <div class="select-wrapper">
            <select id="model_id" name="model_id" style="padding: 10px">
                <option value="" selected disabled>Select phone</option>
                <?php
                if ($stmt1->rowCount() > 0) {
                    foreach ($results1 as $row1) {
                        $model = $row1['model'];
                        $model_id = $row1["id_phone"];
                        echo '<option value="' . $model_id . '" id="' . $model_id . '" name="model">' . $model . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <br>

        <div class="select-wrapper">
            <select id="storage" name="storage" style="padding: 10px">
                <option value="" selected disabled>Select storage</option>
                <option>64 GB</option>
                <option>128 GB</option>
                <option>256 GB</option>
                <option>512 GB</option>
                <option>1024 GB</option>
            </select>
        </div>
        <?php
        if (isset($_GET["error"]) and $_GET["error"] == 11)
        {
            echo '<div class="error-message2">Fill in all the fields!</div>';
        }

        if (isset($_GET["error"]) and $_GET["error"] == 12)
        {
            echo '<div class="error-message2">Add normal format!</div>';
        }

        if (isset($_GET["error"]) and $_GET["error"] == 13)
        {
            echo '<div class="error-message2">This already exists!</div>';
        }

        if (isset($_GET["ok"]) and $_GET["ok"] == 3)
        {
            echo '<div class="success-message2" style="width: 100%;">Success!</div>';
        }
        ?>
        <button type="submit" id="storage-btn" name="storage-btn" class="btn" style="background-color:#6A5ACD; color: white; width: 95%; margin-top: 15px;">Add storage</button>
    </form>
</div>
<br>

<div class="add_manufacturer">
    <h2>Add color</h2>
    <hr style="width: 30%; margin-top: 15px; margin-bottom: 15px;">
    <form action="color.php" method="post" enctype="multipart/form-data">

        <div class="select-wrapper">
            <select id="model_id" name="model_id" style="padding: 10px">
                <option value="" selected disabled>Select phone</option>
                <?php
                if ($stmt7->rowCount() > 0) {
                    foreach ($results7 as $row7) {
                        $model = $row7['model'];
                        $model_id = $row7["id_phone"];
                        echo '<option value="' . $model_id . '" id="' . $model_id . '" name="model">' . $model . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="input-wrapper" style="margin-top: 25px">
            <input type="file" id="image" name="image[]" style="padding: 25px;" multiple>
            <label for="image">Image Upload</label>
        </div>
        <br>

        <div class="input-wrapper">
            <input type="text" id="color" name="color"  style="padding: 10px">
            <label for="user">Color</label>
        </div>

        <?php
        if (isset($_GET["error"]) and $_GET["error"] == 41)
        {
            echo '<div class="error-message2">This color already exists!</div>';
        }

        if (isset($_GET["error"]) and $_GET["error"] == 42)
        {
            echo '<div class="error-message2">There is no such color!</div>';
        }

        if (isset($_GET["error"]) and $_GET["error"] == 43)
        {
            echo '<div class="error-message2" style="width: 90%">Enter a normal image format!</div>';
        }

        if (isset($_GET["error"]) and $_GET["error"] == 44)
        {
            echo '<div class="error-message2" style="width: 90%"> Fill in the fields!</div>';
        }

        if (isset($_GET["ok"]) and $_GET["ok"] == 10)
        {
            echo '<div class="success-message2" style="width: 90%;">Success!</div>';
        }
        ?>

        <button type="submit" id="color-btn" name="color-btn" class="btn" style="background-color:#6A5ACD; color: white; width: 95%; margin-top: 15px;">Add color</button>
    </form>
</div>
<br>


<div class="add_manufacturer"  style="display: none">
    <h2>Add quantity</h2>
    <hr style="width: 30%; margin-top: 15px; margin-bottom: 15px;">
    <form action="quantity.php" method="post" enctype="multipart/form-data">

        <div class="select-wrapper" style="display: none">
            <select id="model_id" name="model_id" style="padding: 10px">
                <option value="" selected disabled>Select phone</option>
                <?php
                if ($stmt7->rowCount() > 0) {
                    foreach ($results7 as $row7) {
                        $model = $row7['model'];
                        $model_id = $row7["id_phone"];
                        echo '<option value="' . $model_id . '" id="' . $model_id . '" name="model">' . $model . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <br>
        <div class="input-wrapper">
            <input type="number" id="quantity_number" name="quantity_number"  style="padding: 10px">
            <label for="user">Add number</label>
        </div>

        <?php
        if (isset($_GET["error"]) and $_GET["error"] == 1000)
        {
            echo '<div class="success-message2">Success!</div>';
        }

        if (isset($_GET["error"]) and $_GET["error"] == 1001)
        {
            echo '<div class="error-message2">You can only enter a number!</div>';
        }

        if (isset($_GET["error"]) and $_GET["error"] == 1002)
        {
            echo '<div class="error-message2">Fill in all fields!</div>';
        }

        if (isset($_GET["error"]) and $_GET["error"] == 1003)
        {
            echo '<div class="error-message2">Enter normal format!</div>';
        }

        if (isset($_GET["error"]) and $_GET["error"] == 1004)
        {
            echo '<div class="error-message2">This phone has already been ordered quantity!</div>';
        }

        ?>

        <button type="submit" id="quantity-btn" name="quantity-btn" class="btn" style="background-color:#6A5ACD; color: white; width: 95%; margin-top: 15px;">Add quantity!</button>
    </form>
</div>
<br>


<?php include "includes/footer.php"; ?>

</body>
</html>


