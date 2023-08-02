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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
</head>

<style>
    #phoneTable td.text-right {
        text-align: right;
    }
</style>

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

    if (isset($_GET["delete_id"])) {
        $deleteId = $_GET["delete_id"];
        $sql_delete_message = "DELETE FROM contact WHERE id_contact = :delete_id";
        $stmt_delete_message = $conn->prepare($sql_delete_message);
        $stmt_delete_message->bindParam(":delete_id", $deleteId, PDO::PARAM_INT);
        if ($stmt_delete_message->execute()) {
        } else {
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

    $sql = "SELECT order_number,id_phone, color, quantity, price, storage, firstname, lastname, phonenumber, date FROM orders";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql_archived_orders = "SELECT order_number, id_phone, color, quantity, price, storage, firstname, lastname, phonenumber, date FROM archived_order";
    $stmt_archived_orders = $conn->prepare($sql_archived_orders);
    $stmt_archived_orders->execute();
    $archived_orders = $stmt_archived_orders->fetchAll(PDO::FETCH_ASSOC);
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
                    <td class="text-right"><?php echo $phone['price'] . " $"; ?></td>
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
<hr>
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

<hr>
<h3 style="text-align: center; margin-top: 15px;">Orders</h3>
<div style="width: 100%; display: flex;justify-content: center;align-items: center; margin-top: 20px">
    <div class="admin-table" style="width: 80%;">
        <table id="orderTable" class="display">
            <thead>
            <tr>
                <th>Order Number</th>
                <th>Phone Name</th>
                <th>Color</th>
                <th>Quantity</th>
                <th>Storage</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['order_number']; ?></td>
                    <td>
                        <?php
                        $id_phone = $order['id_phone'];

                        $sql2 = "SELECT model FROM phones WHERE id_phone = :id_phone";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->bindParam(":id_phone", $id_phone, PDO::PARAM_INT);
                        $stmt2->execute();
                        $phone = $stmt2->fetch(PDO::FETCH_ASSOC);

                        echo $phone['model'];
                        ?>
                    </td>
                    <td style="text-transform: capitalize; "><?php echo $order['color']; ?></td>
                    <td style="text-transform: capitalize; "><?php echo $order['quantity']; ?></td>
                    <td style="text-transform: capitalize; "><?php echo $order['storage']; ?></td>
                    <td><?php echo $order['firstname'] ." ". $order['lastname']; ?></td>
                    <td><?php echo $order['phonenumber']; ?></td>
                    <td><?php echo $order['date']; ?></td>
                    <td>
                        <button type="button" onclick="archiveOrder('<?php echo $order['order_number']; ?>')">Archive</button>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<script>
    function archiveOrder(orderNumber) {
        if (confirm("Are you sure you want to archive this order?")) {
            $.ajax({
                method: "POST",
                url: "archive_order.php",
                data: { order_number: orderNumber },
                success: function (response) {
                    console.log(response);
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }
    }
</script>

<hr>
<h3 style="text-align: center; margin-top: 15px;">Archived Orders</h3>
<div style="width: 100%; display: flex;justify-content: center;align-items: center; margin-top: 20px">
    <div class="admin-table" style="width: 80%;">
        <table id="archivedOrderTable" class="display">
            <thead>
            <tr>
                <th>Order Number</th>
                <th>Phone Name</th>
                <th>Color</th>
                <th>Quantity</th>
                <th>Storage</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($archived_orders as $archived_order): ?>
                <tr>
                    <td><?php echo $archived_order['order_number']; ?></td>
                    <td>
                        <?php
                        $id_phone = $archived_order['id_phone'];

                        $sql2 = "SELECT model FROM phones WHERE id_phone = :id_phone";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->bindParam(":id_phone", $id_phone, PDO::PARAM_INT);
                        $stmt2->execute();
                        $phone = $stmt2->fetch(PDO::FETCH_ASSOC);

                        echo $phone['model'];
                        ?>
                    </td>
                    <td style="text-transform: capitalize; "><?php echo $archived_order['color']; ?></td>
                    <td style="text-transform: capitalize; "><?php echo $archived_order['quantity']; ?></td>
                    <td style="text-transform: capitalize; "><?php echo $archived_order['storage']; ?></td>
                    <td><?php echo $archived_order['firstname'] . " " . $archived_order['lastname']; ?></td>
                    <td><?php echo $archived_order['phonenumber']; ?></td>
                    <td><?php echo $archived_order['date']; ?></td>
                    <td>
                        <button type="button" onclick="restoreOrder('<?php echo $archived_order['order_number']; ?>')">Restore</button>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<hr>
<h3 style="text-align: center; margin-top: 15px;">Contact Messages</h3>
<div style="width: 100%; display: flex;justify-content: center;align-items: center; margin-top: 20px">
    <div class="admin-table" style="width: 80%;">
        <table id="contactTable" class="display">
            <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Message</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql_contact = "SELECT id_contact, id_user, email, mobile, message FROM contact";
            $stmt_contact = $conn->prepare($sql_contact);
            $stmt_contact->execute();
            $contactMessages = $stmt_contact->fetchAll(PDO::FETCH_ASSOC);

            foreach ($contactMessages as $message) {
                ?>
                <tr>
                    <td><?php echo $message['id_contact']; ?></td>
                    <td><?php echo $message['email']; ?></td>
                    <td><?php echo $message['mobile']; ?></td>
                    <td><?php echo $message['message']; ?></td>
                    <td>
                        <form class="deleteForm" method="GET">
                            <input type="hidden" name="delete_id" value="<?php echo $message['id_contact']; ?>">
                            <button type="button" onclick="deleteMessage(<?php echo $message['id_contact']; ?>)">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function deleteMessage(messageId) {
        if (confirm("Are you sure you want to delete this message?")) {
            window.location.href = "?delete_id=" + messageId;
        }
    }
</script>

<div style="margin-top: 30px"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    function restoreOrder(orderNumber) {
        if (confirm("Are you sure you want to restore this order?")) {
            $.ajax({
                method: "POST",
                url: "restore_order.php",
                data: { order_number: orderNumber },
                success: function (response) {
                    console.log(response);
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }
    }


    $(document).ready(function () {
        $('#orderTable').DataTable();

        $('#archivedOrderTable').DataTable();

        $('#phoneTable').DataTable();

        $('#userTable').DataTable();

        $('#contactTable').DataTable();

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
