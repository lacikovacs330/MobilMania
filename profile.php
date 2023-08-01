<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile | @MobilMania</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="nav-phones">
    <?php include "includes/nav.php"; ?>
</div>
<div class="profile">
    <div class="profile-settings">
        <img src="img/profile.png" width="85" height="85">
        <p>Profile settings</p>
        <hr style="width: 80%; margin-top: 10px; margin-bottom: 10px;">

        <form action="change_password.php" method="post">
            <div class="input-with-icon" style="padding-top: 10px">
                <label for="current_password">Current password</label>
                <input type="password" placeholder="Current password" id="current_password" name="current_password" onfocus="hidePlaceholder(this)" onblur="restorePlaceholder(this)">
            </div>

            <div class="input-with-icon" style="padding-top: 20px">
                <label for="new_password">New password</label>
                <input type="password" placeholder="New password" id="new_password" name="new_password" onfocus="hidePlaceholder(this)" onblur="restorePlaceholder(this)">
            </div>

            <div class="input-with-icon" style="padding-top: 20px">
                <label for="new_password_confirm">New password again</label>
                <input type="password" placeholder="New password again" id="new_password_confirm" name="new_password_confirm" onfocus="hidePlaceholder(this)" onblur="restorePlaceholder(this)">
            </div>

            <hr style="margin-bottom: 1.3rem; margin-top: 1.3rem">


            <?php
                if (isset($_GET["ok"]) and $_GET["ok"] == 1)
                {
                    echo '<div class="success-message2" style="width: 100%; margin-bottom: 1rem;">You have successfully changed your password!</div>';
                }

                if (isset($_GET["error"]) and $_GET["error"] == 1)
                {
                    echo '<div class="error-message2" style="width: 100%; margin-bottom: 1rem;">Current password is incorrect!</div>';
                }

                if (isset($_GET["error"]) and $_GET["error"] == 2)
                {
                    echo '<div class="error-message2" style="width: 100%; margin-bottom: 1rem;">Wrong user ID!</div>';
                }

                if (isset($_GET["error"]) and $_GET["error"] == 3)
                {
                    echo '<div class="error-message2" style="width: 100%; margin-bottom:1rem;">The new passwords do not match</div>';
                }

                if (isset($_GET["error"]) and $_GET["error"] == 4)
                {
                    echo '<div class="error-message2" style="width: 100%; margin-bottom: 1rem;">There are no logged in users!</div>';
                }

            ?>
            <button id="change-pass-btn" name="change-pass-btn" type="submit" class="btn" style="background-color:#6A5ACD; color: white; width: 100%;">Change</button>
        </form>
    </div>
</div>

<?php include "includes/footer.php"; ?>

<script src="scripts.js"></script>
</body>
</html>
