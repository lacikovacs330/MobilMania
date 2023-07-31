<?php

session_start();

include "includes/config.php";
include "includes/db_config.php";

$conn = connectDatabase($dsn, $pdoOptions);
$currentPage = basename($_SERVER['PHP_SELF']);


?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

            <?php if ($currentPage !== "index.php"): ?>
                <li class="nav-item active">
                    <a href="index.php"><img src="img/MobileMania.png" width="42" height="42"></a>
                </li>
            <?php endif; ?>


            <li class="nav-item">
                <a class="nav-link text-light" href="phones.php">Phones</a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-light" href="contact.php">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="about_us.php">About Us</a>
            </li>


            <?php
            if (isset($_SESSION["id_user"])) {
                $stmt = $conn->query("SELECT * FROM users WHERE id_user = '$_SESSION[id_user]' ");
                if ($row = $stmt->fetch()) {
                    $id_user = $row["id_user"];
                    $_SESSION["id_user"] = $id_user;

                    if ($row["role"] == "admin") {

                        echo '<li class="nav-item">
                                 <a class="nav-link text-light" href="add_phones.php">Add Phones</a>
                              </li>';

                        echo '<li class="nav-item">
                         <a class="nav-link text-light" href="admin.php">Admin</a>
                      </li>';

                        echo '<li class="nav-item">
                         <a class="nav-link text-light" href="update.php">Update Phones</a>
                      </li>';
                    }

                    if ($row["role"] == "user"){
                        echo '<li class="nav-item">
                         <a class="nav-link text-light" href="favourites.php">Favourites</a>
                      </li>';
                        echo '<li class="nav-item">
                         <a class="nav-link text-light" href="my_orders.php">My Orders</a>
                      </li>';
                    }
                }
            }
            ?>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <span class="navbar-text">
            <?php if (isset($_SESSION["id_user"]))
            {
                echo '<a href="profile.php" style="margin-right:15px" class="text-light">' . $_SESSION["un"] . '</a>';
                echo '<button style="margin-right: 10px" class="btn btn-outline-light my-2 my-sm-0" type="submit"><a href="logout.php" style="all: unset;">Logout</a></button>';
            }
            else
            {
                echo '<button style="margin-right: 10px" class="btn btn-outline-light my-2 my-sm-0" type="submit" onclick="showPopup()">Login</button>';
            }
            ?>
            </span>
        </form>
    </div>
</nav>

<div id="overlay" class="overlay" onclick="hidePopup()"></div>

<div id="popup" class="popup">
    <span class="close-btn" onclick="hidePopup()">&times;</span>
    <div class="popup-img-login">
        <img src="img/login.png" width="70" height="70">
        <p>Login</p>
        <hr>

        <form id="loginForm" method="post">
            <div class="input-with-icon">
                <label for="username">Username</label>
                <input type="text" placeholder="Enter username" id="username" name="username" onfocus="hidePlaceholder(this)" onblur="restorePlaceholder(this)">
            </div>

            <div class="input-with-icon" style="padding-top: 20px">
                <label for="password">Password</label>
                <input type="password" placeholder="Enter password" id="password" name="password" onfocus="hidePlaceholder(this)" onblur="restorePlaceholder(this)">
            </div>

            <hr style="padding-top: 15px">

            <div id="error" class="error-message"></div>

            <button type="button" id="login" class="btn" style="background-color:#6A5ACD; color: white;" onclick="submitForm()">Login</button>
        </form>

        <span style="padding-top: 5px">Don't have an account? Register <a href="#" class="register-link">here</a>.</span>
    </div>
</div>

<script>
    function submitForm() {
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;
        var errorElement = document.getElementById("error");

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "login.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.error) {
                    errorElement.textContent = response.error;
                    errorElement.style.display = "block";
                } else {
                    errorElement.textContent = "";
                    errorElement.style.display = "none";
                    window.location.href = "index.php";
                }
            }
        };
        xhr.send("username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password));
    }
</script>



<div id="register-popup" class="popup">
    <span class="close-button" onclick="hidePopup()">&times;</span>
    <div class="popup-img-login">
        <img src="img/register.png" width="70" height="70">
        <p>Register</p>
        <hr>

        <form action="register.php" method="post">
            <div class="input-with-icon">
                <label for="username">Email</label>
                <input type="text" placeholder="Enter email" id="email" name="email" onfocus="hidePlaceholder(this)" onblur="restorePlaceholder(this)">
            </div>

            <div class="input-with-icon" style="padding-top: 0px">
                <label for="password">Password</label>
                <input type="password" placeholder="Enter password" id="password1" name="password1" onfocus="hidePlaceholder(this)" onblur="restorePlaceholder(this)">
            </div>

            <div class="input-with-icon" style="padding-top: 0px">
                <label for="password">Second Password</label>
                <input type="password" placeholder="Enter second password" id="password2" name="password2" onfocus="hidePlaceholder(this)" onblur="restorePlaceholder(this)">
            </div>


            <div id="register-error" class="error-message"></div>
            <div id="register-success" class="success-message"></div>

            <button type="button" id="register" name="register" class="btn" style="background-color:#6A5ACD; color: white;" onclick="registerUser()">Register</button>
        </form>
    </div>
</div>

<script>
    function registerUser() {
        var email = document.getElementById("email").value;
        var password1 = document.getElementById("password1").value;
        var password2 = document.getElementById("password2").value;
        var registerErrorElement = document.getElementById("register-error");
        var registerSuccessElement = document.getElementById("register-success");

        if (email === '' || password1 === '' || password2 === '') {
            registerErrorElement.textContent = "Please fill in all fields.";
            registerErrorElement.style.display = "block";
            registerSuccessElement.style.display = "none";
            return;
        }

        if (password1 !== password2) {
            registerErrorElement.textContent = "Passwords do not match.";
            registerErrorElement.style.display = "block";
            registerSuccessElement.style.display = "none";
            return;
        }


        var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if (!email.match(emailRegex)) {
            registerErrorElement.textContent = "Invalid email address.";
            registerErrorElement.style.display = "block";
            registerSuccessElement.style.display = "none";
            return;
        }

        registerErrorElement.style.display = "none";
        registerSuccessElement.innerHTML = "Registration successful! Verify email!";
        registerSuccessElement.style.display = "block";

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "register.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.hasOwnProperty("error")) {
                    registerSuccessElement.style.display = "none";
                    registerErrorElement.innerHTML = response.error;
                    registerErrorElement.style.display = "block";
                }
            }
        };
        xhr.send("email=" + encodeURIComponent(email) + "&password1=" + encodeURIComponent(password1) + "&password2=" + encodeURIComponent(password2));
    }
</script>







<script>
    function hidePlaceholder(element) {
        element.setAttribute('data-placeholder', element.getAttribute('placeholder'));
        element.removeAttribute('placeholder');
        element.style.backgroundColor = 'lavender';
        element.style.borderColor = 'black';
    }

    function restorePlaceholder(element) {
        element.setAttribute('placeholder', element.getAttribute('data-placeholder'));
        element.style.backgroundColor = 'transparent';
        element.style.borderColor = 'black';
    }

    function showPopup() {
        var overlay = document.getElementById("overlay");
        var popup = document.getElementById("popup");
        overlay.style.display = "block";
        popup.style.display = "block";
    }

    function hidePopup() {
        var overlay = document.getElementById("overlay");
        var popup = document.getElementById("popup");
        overlay.style.display = "none";
        popup.style.display = "none";
    }

    document.addEventListener("DOMContentLoaded", function() {
        var link = document.querySelector(".register-link");
        var registerPopup = document.getElementById("register-popup");
        var closeButton = document.querySelector(".close-button");
        var overlay = document.getElementById("overlay");

        link.addEventListener("click", function(e) {
            e.preventDefault();
            showPopup();
            registerPopup.style.display = "block";
        });

        closeButton.addEventListener("click", function() {
            registerPopup.style.display = "none";
            hidePopup();
        });

        overlay.addEventListener("click", function() {
            registerPopup.style.display = "none";
            hidePopup();
        });
    });
</script>



<script>
    function showPopup() {
        event.preventDefault();

        var overlay = document.getElementById("overlay");
        var popup = document.getElementById("popup");
        overlay.style.display = "block";
        popup.style.display = "block";

    }

    function hidePopup() {
        var overlay = document.getElementById("overlay");
        var popup = document.getElementById("popup");
        overlay.style.display = "none";
        popup.style.display = "none";
    }
</script>

<script>
    function toggleNavbar() {
        var navbar = document.getElementById("navbarSupportedContent");
        navbar.classList.toggle("show");

    }

    document.addEventListener("DOMContentLoaded", function() {
        var navbarToggler = document.querySelector(".navbar-toggler");
        navbarToggler.addEventListener("click", toggleNavbar);
    });
</script>
</body>
</html>
