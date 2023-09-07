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
    <title>Update | @MobilMania </title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<div class="nav-phones">
    <?php include "includes/nav.php";

    $conn = connectDatabase($dsn, $pdoOptions);

    $sql = "SELECT * FROM phones ORDER BY price ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>
</div>

<div class="searcher-product">
    <div class="search__container" style="width: 50%">
        <input class="search__input" type="text" id="searchInput" placeholder="Search">
        <div class="search__icon"></div>
    </div>
</div>

<div id="searchResults"></div>

<script>
    $(document).ready(function() {
        $('#searchInput').on('input', function() {
            var searchTerm = $(this).val();
            $.post('searcher.php', { search: searchTerm }, function(response) {
                var productPhonesDiv = $('.product-phones');
                productPhonesDiv.empty();

                if (response.length >= 0) {
                    var modelsDisplayed = [];
                    for (var i = 0; i < response.length; i++) {
                        var model = response[i].model;
                        if (modelsDisplayed.includes(model)) {
                            continue;
                        }
                        modelsDisplayed.push(model);

                        var card = `
                        <div class="kartya">
                            <div class="kepDoboz">
                                <img src="phone-img/${response[i].manufacturer}/${response[i].id_phone}/1-${response[i].color}.png" alt="" class="eger" style="max-height: 300px; height: 100%; object-fit: fill !important;">
                                <img src="phone-img/${response[i].manufacturer}/${response[i].id_phone}/1-${response[i].color}.jpg" alt="" class="eger" style="max-height: 300px; height: 100%; object-fit: fill !important;">
                                <img src="phone-img/${response[i].manufacturer}/${response[i].id_phone}/1-${response[i].color}.jpeg" alt="" class="eger" style="max-height: 300px; height: 100%; object-fit: fill !important;">
                            </div>
                            <div class="tartalomDoboz">
                                <h3>${model}</h3>
                                <h2 class="ar">${response[i].price}.<small>00</small> €</h2>
                                <a href="product.php?id_phone=${response[i].id_phone}" class="vasarlas">Watch now</a>
                            </div>
                        </div>`;
                        productPhonesDiv.append(card);
                    }
                } else {
                    productPhonesDiv.append('<p>No results found.</p>');
                }
            }, 'json');
        });
    });
</script>

<div style="width: 100%; height: auto; display: flex">
    <div class="product-phones" style="width: 100%">
        <?php if ($stmt->rowCount() > 0): ?>
            <?php foreach ($results as $row): ?>
                <div class="kartya" data-manufacturer-id="<?php echo $row['id_manufacturer']; ?>">
                    <?php
                    $id_phone = $row["id_phone"];
                    $id_manufacturer = $row["id_manufacturer"];

                    $sql1 = "SELECT * FROM manufacturers WHERE id_manufacturer = '$id_manufacturer'";
                    $res1 = $conn->query($sql1);
                    $rows1 = $res1->fetchAll();
                    $manufacturer_name2 = "";
                    if (count($rows1) >= 1) {
                        foreach ($rows1 as $row1) {
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

                    if (file_exists("phone-img/" . $manufacturer_name2 . "/" . $id_phone . "/1-" . $color . ".jpg")) {
                        $img_name = "phone-img/" . $manufacturer_name2 . "/" . $id_phone . "/1-" . $color . ".jpg";
                    }

                    if (file_exists("phone-img/" . $manufacturer_name2 . "/" . $id_phone . "/1-" . $color . ".jpeg")) {
                        $img_name = "phone-img/" . $manufacturer_name2 . "/" . $id_phone . "/1-" . $color . ".jpeg";
                    }

                    if (file_exists("phone-img/" . $manufacturer_name2 . "/" . $id_phone . "/1-" . $color . ".png")) {
                        $img_name = "phone-img/" . $manufacturer_name2 . "/" . $id_phone . "/1-" . $color . ".png";
                    }
                    ?>
                    <div class="kepDoboz">
                        <img src="<?php echo $img_name; ?>" alt="" class="eger" style="max-height: 300px; height: 100%; object-fit: fill !important;">
                    </div>
                    <div class="tartalomDoboz">
                        <h3><?php echo $row["model"]; ?></h3>
                        <h2 class="ar"><?php echo $row["price"]; ?>.<small>00</small> €</h2>
                        <a href="update_1.php?id_phone=<?php echo $id_phone; ?>" class="vasarlas">Update</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="width: 100%; height: 350px;display: flex; justify-content: center; align-items: center">
                <p style="text-align: center;">No phone assigned.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include "includes/footer.php"; ?>

<script>
    function filterPhones() {
        const below1500 = document.getElementById('below1500').checked;
        const above1500 = document.getElementById('above1500').checked;

        const phones = document.getElementsByClassName('kartya');
        for (const phone of phones) {
            const price = parseInt(phone.querySelector('.ar').textContent);

            if ((below1500 && price >= 1500) || (above1500 && price < 1500)) {
                phone.style.display = 'none';
            } else {
                phone.style.display = 'block';
            }
        }
    }

    let selectedFilter = null;

    function updateFilter(checkboxId) {
        const below1500 = document.getElementById('below1500');
        const above1500 = document.getElementById('above1500');

        if (selectedFilter === checkboxId) {
            selectedFilter = null;
            below1500.checked = false;
            above1500.checked = false;
        } else {
            selectedFilter = checkboxId;
            if (checkboxId === 'below1500') {
                above1500.checked = false;
            } else if (checkboxId === 'above1500') {
                below1500.checked = false;
            }
        }

        filterPhones();
    }

    function filterManufacturers(manufacturerId) {
        const phones = document.getElementsByClassName('kartya');

        for (const phone of phones) {
            phone.style.display = 'block';
            const id_manufacturer = phone.getAttribute('data-manufacturer-id');

            if (manufacturerId !== 'all' && id_manufacturer !== manufacturerId) {
                phone.style.display = 'none';
            }
        }

        const productPhonesDiv = $('.product-phones');
        const visiblePhones = productPhonesDiv.find('.kartya[style="display: block;"]');
        if (selectedManufacturer !== 'all' && visiblePhones.length === 0) {
            productPhonesDiv.empty();
            productPhonesDiv.append('<p>No phones assigned.</p>');
        }
    }

    let selectedManufacturer = 'all';

    function updateManufacturerFilter(manufacturerId) {
        const below1500 = document.getElementById('below1500');
        const above1500 = document.getElementById('above1500');

        if (below1500.checked) {
            below1500.checked = false;
            selectedFilter = null;
        }

        if (above1500.checked) {
            above1500.checked = false;
            selectedFilter = null;
        }

        selectedManufacturer = manufacturerId;
        filterManufacturers(selectedManufacturer);

    }

    updateManufacturerFilter(selectedManufacturer);
</script>


</body>
</html>
