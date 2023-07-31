<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile | @MobilMania</title>
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

        <form>

            <div class="input-with-icon" style="padding-top: 10px">
                <label for="password">Current password</label>
                <input type="password" placeholder="Current password" id="password" name="password" onfocus="hidePlaceholder(this)" onblur="restorePlaceholder(this)">
            </div>

            <div class="input-with-icon" style="padding-top: 20px">
                <label for="password">New password</label>
                <input type="password" placeholder="New password" id="password" name="password" onfocus="hidePlaceholder(this)" onblur="restorePlaceholder(this)">
            </div>

            <div class="input-with-icon" style="padding-top: 20px">
                <label for="password">New password again</label>
                <input type="password" placeholder="New password again" id="password" name="password" onfocus="hidePlaceholder(this)" onblur="restorePlaceholder(this)">
            </div>

            <hr style="margin-bottom: 1.3rem; margin-top: 1.3rem">
            <button type="button" class="btn" style="background-color:#6A5ACD; color: white; width: 100%">Change</button>
        </form>
    </div>
</div>

<?php include "includes/footer.php"; ?>
</body>
</html>