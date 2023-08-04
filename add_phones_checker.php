<?php

include "includes/config.php";
include "includes/db_config.php";

$conn = connectDatabase($dsn, $pdoOptions);

if(isset($_POST["add-phone-btn"])
    and isset($_POST["manufacturer"])
    and !empty($_POST["manufacturer"])
    and isset($_POST["model"])
    and !empty($_POST["model"])
    and isset($_POST["price"])
    and !empty($_POST["price"])
    and ($_FILES["image"]["name"][0] !== "")
    and isset($_POST["color"])
    and !empty($_POST["color"])
    and isset($_POST["os"])
    and !empty($_POST["os"])
    and isset($_POST["processor"])
    and !empty($_POST["processor"])
    and isset($_POST["osversion"])
    and !empty($_POST["osversion"])
    and isset($_POST["sim"])
    and !empty($_POST["sim"])
    and isset($_POST["screensize"])
    and !empty($_POST["screensize"])
    and isset($_POST["capcaity"])
    and !empty($_POST["capcaity"])
    and isset($_POST["fmradio"])
    and !empty($_POST["fmradio"])
    and isset($_POST["ram"])
    and !empty($_POST["ram"])
    and isset($_POST["external"])
    and !empty($_POST["external"])
    and isset($_POST["internal"])
    and !empty($_POST["internal"])
    and isset($_POST["primarycamera"])
    and !empty($_POST["primarycamera"])
    and isset($_POST["flash1"])
    and !empty($_POST["flash1"])
    and isset($_POST["videorecording1"])
    and !empty($_POST["videorecording1"])
    and isset($_POST["facedetection"])
    and !empty($_POST["facedetection"])
    and isset($_POST["autofocus"])
    and !empty($_POST["autofocus"])
    and isset($_POST["ledflash1"])
    and !empty($_POST["ledflash1"])
    and isset($_POST["secondary"])
    and !empty($_POST["secondary"])
    and isset($_POST["smiledetection"])
    and !empty($_POST["smiledetection"])
    and isset($_POST["videorecording2"])
    and !empty($_POST["videorecording2"])
    and isset($_POST["ledflash2"])
    and !empty($_POST["ledflash2"])
    and isset($_POST["flash2"])
    and !empty($_POST["flash2"])
    and isset($_POST["autofocus2"])
    and !empty($_POST["autofocus2"])
    and isset($_POST["wifi"])
    and !empty($_POST["wifi"])
    and isset($_POST["bluetooth"])
    and !empty($_POST["bluetooth"])
    and isset($_POST["usb"])
    and !empty($_POST["usb"])
    and isset($_POST["nfc"])
    and !empty($_POST["nfc"])
    and isset($_POST["gps"])
    and !empty($_POST["gps"])
    and isset($_POST["mobilenetwork"])
    and !empty($_POST["mobilenetwork"])
    and isset($_POST["2g"])
    and !empty($_POST["2g"])
    and isset($_POST["3g"])
    and !empty($_POST["3g"])
    and isset($_POST["4g"])
    and !empty($_POST["4g"])
    and isset($_POST["5g"])
    and !empty($_POST["5g"])
    and isset($_POST["weight"])
    and !empty($_POST["weight"])
    and isset($_POST["sms"])
    and !empty($_POST["sms"])
    and isset($_POST["email"])
    and !empty($_POST["email"])
    and isset($_POST["height"])
    and !empty($_POST["height"])
    and isset($_POST["width"])
    and !empty($_POST["width"])
    and isset($_POST["length"])
    and !empty($_POST["length"])
)
{
    $manufacturer_name = $_POST["manufacturer"];
    $model = $_POST["model"];
    $price = $_POST["price"];
    $operating_system = $_POST["os"];
    $processor = $_POST["processor"];
    $operating_system_v = $_POST["osversion"];
    $sim = $_POST["sim"];
    $screen_size = $_POST["screensize"];
    $capacity = $_POST["capcaity"];
    $fm_radio = $_POST["fmradio"];
    $ram = $_POST["ram"];
    $external = $_POST["external"];
    $internal = $_POST["internal"];
    $main_primary_camera = $_POST["primarycamera"];
    $main_flash = $_POST["flash1"];
    $main_video_record = $_POST["videorecording1"];
    $main_face_detect = $_POST["facedetection"];
    $main_autofocus = $_POST["autofocus"];
    $main_led_flash = $_POST["ledflash1"];
    $secondary_second = $_POST["secondary"];
    $second_smile_detection = $_POST["smiledetection"];
    $second_video = $_POST["videorecording2"];
    $second_led_flash = $_POST["ledflash2"];
    $second_flash = $_POST["flash2"];
    $second_autofocus = $_POST["autofocus2"];
    $wifi = $_POST["wifi"];
    $bluetooth = $_POST["bluetooth"];
    $usb = $_POST["usb"];
    $nfc = $_POST["nfc"];
    $gps = $_POST["gps"];
    $mobile_network = $_POST["mobilenetwork"];
    $g2 = $_POST["2g"];
    $g3 = $_POST["3g"];
    $g4 = $_POST["4g"];
    $g5 =$_POST["5g"];
    $weight = $_POST["weight"];
    $sms = $_POST["sms"];
    $email = $_POST["email"];
    $height = $_POST["height"];
    $width = $_POST["width"];
    $length = $_POST["length"];

    $color = $_POST["color"];

    $allowed_colors = array("black", "red", "blue", "green", "yellow", "white", "orange", "purple", "pink", "brown", "gray", "cyan", "magenta", "lime", "teal", "olive", "maroon", "navy", "silver", "gold");
    $color_lower = strtolower($color);

    if (!is_numeric($price) and !is_numeric($operating_system_v) and !is_numeric($screen_size) and !is_numeric($capacity) and !is_numeric($ram) and !is_numeric($internal) and !is_numeric($main_primary_camera) and !is_numeric($secondary_second) and !is_numeric($weight) and !is_numeric($height) and !is_numeric($width) and !is_numeric($length)){
        header("Location:add_phones.php?error=4");
        exit;
    }

    if (!in_array($color_lower, $allowed_colors)) {
        header("Location:add_phones.php?error=31");
        exit;
    }

    if ($email !== "Yes" && $email !== "No" && $fm_radio !== "Yes" && $fm_radio !== "No" && $external !== "Yes" && $external !== "No" && $main_flash !== "Yes" && $main_flash !== "No" && $main_video_record !== "Yes" && $main_video_record !== "No" && $main_face_detect !== "Yes" && $main_face_detect !== "No" && $main_autofocus !== "Yes" && $main_autofocus !== "No" && $main_led_flash !== "Yes" && $main_led_flash !== "No" && $second_smile_detection !== "Yes" && $second_smile_detection !== "No" && $second_video !== "Yes" && $second_video !== "No" && $second_led_flash !== "Yes" && $second_led_flash !== "No" && $second_flash !== "Yes" && $second_flash !== "No" && $second_autofocus !== "Yes" && $second_autofocus !== "No" && $wifi !== "Yes" && $wifi !== "No" && $bluetooth !== "Yes" && $bluetooth !== "No" && $usb !== "Yes" && $usb !== "No" && $nfc !== "Yes" && $nfc !== "No" && $mobile_network !== "Yes" && $mobile_network !== "No" && $g2 !== "Yes" && $g2 !== "No" && $g3 !== "Yes" && $g3 !== "No" && $g4 !== "Yes" && $g4 !== "No" && $g5 !== "Yes" && $g5 !== "No" && $sms !== "Yes" && $sms !== "No") {
        header("Location:add_phones.php?error=5");
        exit;
    }

    if (!is_numeric($price) || $price <= 0) {
        header("Location:add_phones.php?error=7");
        exit;
    }

    if (!is_numeric($height) || $height <= 0 || !is_numeric($width) || $width <= 0 || !is_numeric($length) || $length <= 0 || !is_numeric($weight) || $weight <= 0 || !is_numeric($secondary_second) || $secondary_second <= 0 || !is_numeric($main_primary_camera) || $main_primary_camera <= 0 || !is_numeric($internal) || $internal <= 0 || !is_numeric($ram) || $ram <= 0 || !is_numeric($capacity) || $capacity <= 0 || !is_numeric($screen_size) || $screen_size <= 0 || !is_numeric($operating_system_v) || $operating_system_v <= 0){
        header("Location:add_phones.php?error=8");
        exit;
    }

    $stmt = $conn->query("SELECT * FROM manufacturers WHERE manufacturer = '$manufacturer_name'");
    if ($row = $stmt->fetch()) {
        $id_manufacturer = $row["id_manufacturer"];

        $pdoQuery = $conn->prepare("SELECT * FROM phones WHERE model = ?");
        $pdoQuery->execute([$model]);
        $count = $pdoQuery->fetchColumn();
        if ($count > 0) {
            header("Location:add_phones.php?error=9");
            exit();
        }
        else
        {

            if (ImgChecK($_FILES) == 1)
            {
            $pdoQuery = $conn->prepare("INSERT INTO phones (id_manufacturer, model, price,operating_system, processor, operating_system_v, sim, screen_size, capacity, fm_radio, ram, external, internal, main_primary_camera, main_flash, main_video_record, main_face_detect, main_autofocus, main_led_flash, secondary_second, second_smile_detection, second_video, second_led_flash, second_flash, second_autofocus, wifi, bluetooth, usb, nfc, gps, mobile_network, 2g, 3g, 4g, 5g, weight, sms, email, height, width, length,visible) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $pdoQuery->execute([$id_manufacturer,$model,$price,$operating_system,$processor,$operating_system_v, $sim, $screen_size,$capacity,$fm_radio,$ram,$external,$internal,$main_primary_camera,$main_flash,$main_video_record,$main_face_detect,$main_autofocus,$main_led_flash,$secondary_second,$second_smile_detection,$second_video,$second_led_flash,$second_flash,$second_autofocus,$wifi,$bluetooth,$usb,$nfc,$gps,$mobile_network,$g2,$g3,$g4,$g5,$weight,$sms,$email,$height,$width,$length, "1"]);

            $lastId = $conn->lastInsertId();

            $pdoQuery = $conn->prepare("INSERT INTO colors (id_phone, color, quantity) VALUES (?,?,?)");
            $pdoQuery->execute([$lastId, $color_lower,0]);

            $sql = "SELECT * FROM manufacturers WHERE id_manufacturer = '$id_manufacturer'";
            $res = $conn->query($sql);
            $rows = $res->fetchAll();
            $manufacturer_name2 = "";
            if(count($rows) >= 1)
            {
                foreach($rows as $row)
                {
                    $manufacturer_name2 = $row["manufacturer"];
                }
            }

            $path = "phone-img/$manufacturer_name2";

            if (!file_exists($path))
            {
                mkdir($path,0777, true);
            }

            if (!file_exists($path."/".$lastId))
            {
                mkdir($path."/".$lastId,0777, true);
            }

            $c = 1;
            for($i = 0; $i<count($_FILES['image']['name']); $i++)
            {
               $fileName = $_FILES['image']['name'][$i];
               $file_tmp = $_FILES["image"]["tmp_name"][$i];

               $fileNameParts = explode('.', $fileName);
               $ext = end($fileNameParts);

               move_uploaded_file($file_tmp, $path."/".$lastId.'/'.$c.'-'.$color_lower.'.'.$ext);
               $c++;
            }
                header("Location:add_phones.php?ok=2");
            }
            else
            {
                header("Location:add_phones.php?error=10");
            }

        }
    }
}
else
{
    header("Location:add_phones.php?error=6");
}


function ImgChecK($files){

    $size = 0;
    foreach($files['image']['size'] as $s)
    {
        $size += $s;
    }

    if($size < 11000000)
    {
        $actualext = array();
        $allowed = array('jpg', 'jpeg', 'png');

        foreach($files['image']['name'] as $imageName)
        {
            $ext = explode('.', $imageName);
            array_push($actualext, strtolower(end($ext)));
        }

        $is_ok = true;

        foreach($actualext as $a)
        {
            if(!in_array($a, $allowed))
            {
                $is_ok = false;
                break;
            }
        }

        if($is_ok == true)
        {
            return 1;
        }
        else{
            return 3; //nem jó kép formátum
        }

    }
    else{
        return 2; //max 10MB
    }
}

