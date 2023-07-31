<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home | @MobilMania </title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
</head>

<style>

    body{
        overflow: hidden;
    }
    .swiper {
        width: 100%;
        height: 90%;
        border-bottom-left-radius: 50px;
        }

    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #6A5ACD;
        display: flex;
        align-items: center;
    }

</style>

<body>

<div class="firstpage">

<div class="firstpage-text">
    <nav class="navbar navbar-light">
        <a class="navbar-brand" href="#">
            <img src="img/MobileMania.png" width="50" height="50" alt=""> <b>Mania</b>
        </a>
    </nav>
    <div class="firstpage-text-center">
        <div class="text-container">
            <h2>Be part of the community!</h2>
            <p>MobilMania is Hungary's newest and premier mobile phone store that specializes in unique, limited edition, and 100% authentic phones.</p>
            <form class="form-inline my-2 my-lg-0">
                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">News</button>
                <a href="phones.php" class="product-link">All our products</a>
            </form>
        </div>
    </div>
</div>

<div class="firstpage-nav-img">

    <div class="firstpage-nav">
        <?php include "includes/nav.php" ?>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="product-index">
                        <img src="img/Index-Iphone.png" width="650" height="590">
                        <div class="card text-center" style="width: 17rem; border-radius: 15px">
                            <div class="card-body"">
                            <h5 class="card-title">Iphone X</h5>
                            <p class="card-text">150€</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-slide">
                <div class="product-index">
                    <img src="img/s8.png" width="650" height="690">
                    <div class="card text-center" style="width: 17rem; border-radius: 15px">
                        <div class="card-body"">
                        <h5 class="card-title">Samsung Galaxy S8</h5>
                        <p class="card-text">320€</p>
                    </div>
                </div>
            </div>
            </div>
            <div class="swiper-pagination" style="color: white;"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 30,
            centeredSlides: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
        });
    </script>
</div>

</div>

</body>
</html>