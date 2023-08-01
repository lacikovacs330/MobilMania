<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact | @MobilMania </title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>
<body>
<div class="nav-phones">
    <?php include "includes/nav.php"; ?>
</div>

<div class="contact">
    <div class="contact-left">
       <div class="contact-left-title">
           <img src="img/customer-service-agent.png" width="45" height="45">
           <h3>Contact</h3>
       </div>
        <hr style="width: 80%">

        <br>
        <p>We strive to respond to inquiries as quickly as possible and have compiled a practical list of frequently asked questions along with their corresponding answers.</p>
        <div class="contact-questions"  id="question1">
            <ion-icon class="icon-questions" name="cube-outline"></ion-icon>
            <b>How can I return a product? Prepare the package.</b>
        </div>
        <ul class="contact-list" style="margin-top: 1rem">
            <a id="answer2" class="hidden">
                <b>Prepare the package.</b> Remove the old labels from the box. Fill out the Return Form attached to your order or download it from here. Place the items and the Return Form inside the box. Please send back only the items from a single order in one package. The consumer is responsible for any decrease in value resulting from use beyond what is necessary to establish the nature, characteristics, and functioning of the product.
            </a>
            <hr>
        </ul>

        <div class="contact-questions"  id="question2">
            <ion-icon class="icon-questions" name="time-outline"></ion-icon>
            <b>Delivery time</b>
        </div>
        <ul class="contact-list" style="margin-top: 1rem">
            <a id="answer3" class="hidden">
                1. <b>The preparation of the order for delivery</b> - usually within 24 hours,<br>
                2. <b>Delivery time</b> - 2-3 business days from the date of package dispatch.<br><br>
                <b>Please</b> note that the transit and delivery times do not include Saturdays, Sundays, and public holidays. The delivery time may take longer in individual cases.<br><br>
                We will inform you via email about each stage of your order, including any delays.
            </a>
            <hr>
        </ul>

        <div class="contact-questions"  id="question3">
            <ion-icon class="icon-questions" name="wallet-outline"></ion-icon>
            <b>Refund</b>
        </div>
        <ul class="contact-list" style="margin-top: 1rem">
            <a id="answer4" class="hidden">
                We will refund the purchase price within 14 business days after the arrival of the product and successful verification.<br><br>
                We will refund the purchase price using the same method of payment that was used for the order.<br><br>
                <b>Payment:</b><br><br>
                <b>PayPal / Credit Card</b> - You will receive the money through the same payment system.<br><br>
                <b>Cash on delivery</b> - We will send the refund to the IBAN bank account provided in the return form.
            </a>
            <hr>
        </ul>

        <div class="contact-questions"  id="question4">
            <ion-icon class="icon-questions" name="close-outline"></ion-icon>
            <b>Cancel order</b>
        </div>
        <ul class="contact-list" style="margin-top: 1rem">
            <a id="answer5" class="hidden">
                Please contact our customer service team. You can choose between chat, phone, or email. We will notify you via email about the processing of your request. The products from the canceled order will be returned to our website within 24 hours.
            </a>
            <hr>
        </ul>

        <div class="under-questions">
            <h4>Corporate data</h4>
            <p>MODIVO S.A.</p>
            <p>ul. Nowy Kisielin - Nowa 9</p>
            <p>66-002 Zielona Góra</p><br>
            <p>NIP 929-13-53-356</p>
            <p>BDO 000031285</p>
            <p>REGON 970569861</p><br>
            <p>Zielona Góra District Court</p>
            <p>8th Economic Division" or "Economic Division VIII</p>
            <p>National Court Register, under registration number KRS 0000541722</p><br>
            <p>Capital: 2,008,001 PLN</p>
            <p>fully paid</p><br>
            <p>Customer service:</p>
            <p style="color:#6A5ACD">info@mobilmania.hu</p><br>
            <p>Data Protection Officer</p>
            <p>Łukasz Griesman e-mail: iod@modivo.com</p>
        </div>

    </div>



    <div class="contact-right">

        <div class="contact-email">
            <div class="contact-text">
                <h4 style="margin-bottom: 15px">Contact</h4>
                <form method="post" action="contact_checker.php">

                <div class="input-with-icon">
                    <input type="email" placeholder="Email" id="email" name="email" style="width: 100%; margin-bottom: 2rem; font-size: 13px;">
                </div>

                <div class="input-with-icon">
                    <input type="number" placeholder="Mobile number" id="mobile" name="mobile" style="width: 100%; margin-bottom: 2rem; font-size: 13px;">
                </div>

                <div class="input-with-icon">
                    <textarea rows="4" cols="50" style="resize: none; width: 100%; font-size: 13px;" placeholder="Message" id="message" name="message"></textarea>
                </div>

                    <?php
                    if (isset($_GET["ok"]) and $_GET["ok"] == 1)
                    {
                        echo '<div class="success-message2" style="width: 100%">Success!</div>';
                    }

                    if (isset($_GET["error"]) and $_GET["error"] == 1)
                    {
                        echo '<div class="error-message2" style="width: 100%">Enter normal email format!</div>';
                    }

                    if (isset($_GET["error"]) and $_GET["error"] == 2)
                    {
                        echo '<div class="error-message2" style="width: 100%">Enter normal mobile format!</div>';
                    }

                    if (isset($_GET["error"]) and $_GET["error"] == 3)
                    {
                        echo '<div class="error-message2" style="width: 100%">Fill in all fields!</div>';
                    }

                    if (isset($_GET["error"]) and $_GET["error"] == 4)
                    {
                        echo '<div class="error-message2" style="width: 100%">Fill in all fields!</div>';
                    }

                    ?>

                <button type="submit" class="btn" id="contact-btn" name="contact-btn" style="background-color:#6A5ACD; color: white; width: 100%; margin-top: 1rem;">Send</button>
                </form>
            </div>
        </div>

    </div>

</div>

<script>
    document.getElementById("question1").addEventListener("click", function() {
        var answer2 = document.getElementById("answer2");
        if (answer2.classList.contains("hidden")) {
            answer2.classList.remove("hidden");
        } else {
            answer2.classList.add("hidden");
        }
    });

    document.getElementById("question2").addEventListener("click", function() {
        var answer2 = document.getElementById("answer3");
        if (answer2.classList.contains("hidden")) {
            answer2.classList.remove("hidden");
        } else {
            answer2.classList.add("hidden");
        }
    });

    document.getElementById("question3").addEventListener("click", function() {
        var answer2 = document.getElementById("answer4");
        if (answer2.classList.contains("hidden")) {
            answer2.classList.remove("hidden");
        } else {
            answer2.classList.add("hidden");
        }
    });

    document.getElementById("question4").addEventListener("click", function() {
        var answer2 = document.getElementById("answer5");
        if (answer2.classList.contains("hidden")) {
            answer2.classList.remove("hidden");
        } else {
            answer2.classList.add("hidden");
        }
    });
</script>

<?php include "includes/footer.php"; ?>


</body>
</html>


