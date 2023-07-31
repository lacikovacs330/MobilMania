<?php

include "includes/config.php";
include "includes/db_config.php";

$conn = connectDatabase($dsn, $pdoOptions);

if (isset($_POST["color-btn"]) and ($_FILES["image"]["name"][0] !== "") and isset($_POST["color"]) and !empty($_POST["color"]) and isset($_POST["model_id"]) and !empty($_POST["model_id"]))
{
    $model_id = $_POST["model_id"];
    $color = $_POST["color"];
    echo $model_id;

    $allowed_colors = array("black", "red", "blue", "green", "yellow", "white", "orange", "purple", "pink", "brown", "gray", "cyan", "magenta", "lime", "teal", "olive", "maroon", "navy", "silver", "gold");
    $color_lower = strtolower($color);

    if (!in_array($color_lower, $allowed_colors)) {
        header("Location:add_phones.php?error=42");
        exit;
    }

    $pdoQuery = $conn->prepare("SELECT * FROM colors WHERE id_phone = ? AND color = ?");
    $pdoQuery->execute([$model_id, $color_lower]);
    $existing_color = $pdoQuery->fetch();

    if ($existing_color) {
        header("Location:add_phones.php?error=41");
        exit;
    }

    if (ImgChecK($_FILES) == 1)
    {
        $pdoQuery = $conn->prepare("INSERT INTO colors (id_phone, color) VALUES (?,?)");
        $pdoQuery->execute([$model_id, $color_lower]);

        $sql = "SELECT * FROM phones WHERE id_phone = '$model_id'";
        $res = $conn->query($sql);
        $rows = $res->fetchAll();
        $manufacturer_name2 = "";
        if(count($rows) >= 1)
        {
            foreach($rows as $row)
            {
                $id_manufacturer = $row["id_manufacturer"];

                $sql = "SELECT * FROM manufacturers WHERE id_manufacturer = '$id_manufacturer'";
                $res = $conn->query($sql);
                $rows = $res->fetchAll();
                if(count($rows) >= 1)
                {
                    foreach($rows as $row)
                    {
                        $manufacturer_name2 = $row["manufacturer"];
                    }
                }
            }
        }

        $path = "phone-img/$manufacturer_name2";

        if (!file_exists($path))
        {
            mkdir($path,0777, true);
        }

        if (!file_exists($path."/".$model_id))
        {
            mkdir($path."/".$model_id,0777, true);
        }

        $c = 1;
        for($i = 0; $i<count($_FILES['image']['name']); $i++)
        {
            $fileName = $_FILES['image']['name'][$i];
            $file_tmp = $_FILES["image"]["tmp_name"][$i];

            $fileNameParts = explode('.', $fileName);
            $ext = end($fileNameParts);

            move_uploaded_file($file_tmp, $path."/".$model_id.'/'.$c.'-'.$color_lower.'.'.$ext);
            $c++;
        }
        header("Location:add_phones.php?ok=10");
    }
    else
    {
        header("Location:add_phones.php?error=43");
    }
}
else
{
    header("Location:add_phones.php?error=44");
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
