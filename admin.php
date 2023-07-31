<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
</head>
<body>
<div class="nav-phones">
    <?php include "includes/nav.php";

    $conn = connectDatabase($dsn, $pdoOptions);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["phone_id"]) && isset($_POST["visible"])) {
            $phone_id = $_POST["phone_id"];
            $visible = $_POST["visible"];

            $sql_update_visible = "UPDATE phones SET visible = :visible WHERE id_phone = :phone_id";
            $stmt = $conn->prepare($sql_update_visible);
            $stmt->bindParam(":visible", $visible, PDO::PARAM_INT);
            $stmt->bindParam(":phone_id", $phone_id, PDO::PARAM_INT);
            $stmt->execute();
        }

        if (isset($_POST["user_id"]) && isset($_POST["status"])) {
            $user_id = $_POST["user_id"];
            $status = $_POST["status"];

            $sql_update_status = "UPDATE users SET status = :status WHERE id_user = :user_id";
            $stmt = $conn->prepare($sql_update_status);
            $stmt->bindParam(":status", $status, PDO::PARAM_INT);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    $sql = "SELECT id_phone, model, price, visible FROM phones";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $phones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT id_user, username, email, status FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
</div>

<h3 style="text-align: center; margin-top: 15px;">Visibility of phones</h3>
<div style="width: 100%; display: flex;justify-content: center;align-items: center; margin-top: 20px">
    <div class="admin-table" style="width: 80%;">
        <table id="phoneTable" class="display">
            <thead>
            <tr>
                <th>Model</th>
                <th>Price</th>
                <th>Visible</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($phones as $phone): ?>
                <tr>
                    <td><?php echo $phone['model']; ?></td>
                    <td><?php echo $phone['price']; ?></td>
                    <td>
                        <input type="checkbox" class="visibilityCheckbox" data-phone-id="<?php echo $phone['id_phone']; ?>"
                            <?php echo ($phone['visible'] == 1) ? 'checked' : ''; ?>>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<h3 style="text-align: center; margin-top: 15px;">User ban</h3>
<div style="width: 100%; display: flex;justify-content: center;align-items: center; margin-top: 20px;  margin-bottom: 25px;">
    <div class="admin-table" style="width: 80%;">
        <table id="userTable" class="display">
            <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Login</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td>
                        <input type="checkbox" class="statusCheckbox" data-user-id="<?php echo $user['id_user']; ?>"
                            <?php echo ($user['status'] == 1) ? 'checked' : ''; ?>>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#phoneTable').DataTable();

        $('#userTable').DataTable();

        $('.visibilityCheckbox').on('change', function () {
            var phoneId = $(this).data('phone-id');
            var visible = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                method: "POST",
                url: "",
                data: {phone_id: phoneId, visible: visible},
                success: function (response) {
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });

        $('.statusCheckbox').on('change', function () {
            var userId = $(this).data('user-id');
            var status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                method: "POST",
                url: "",
                data: {user_id: userId, status: status},
                success: function (response) {
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>

<?php include "includes/footer.php"; ?>
</body>
</html>
