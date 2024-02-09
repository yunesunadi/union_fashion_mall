<?php

include(__DIR__ . "/../vendor/autoload.php");

use App\Helpers\HTTP;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="./node_modules/@flaticon/flaticon-uicons/css/all/all.css">
    <link rel="stylesheet" href="./node_modules/@splidejs/splide/dist/css/splide.min.css">
    <link rel="stylesheet" href="./assets/css/custom.css">
    <title>Home</title>
</head>

<body>
    <?php include(__DIR__ . "/components/nav.php"); ?>

    <button type="button" class="d-none modal-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Launch demo modal
    </button>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="btn-close d-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="alert alert-success text-center">
                <i class="fa-solid fa-circle-check me-1"></i>
                <?= $_SESSION["success"] ?>
            </div>
        </div>
    </div>
    <?php if (isset($_SESSION["success"])): ?>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector(".modal-btn").click();
        setTimeout(() => {
            document.querySelector(".btn-close").click();
        }, 1000);
    })
    </script>
    <?php
    endif;
    unset($_SESSION["success"]);
    ?>

    <section class="hero">
        <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active position-relative">
                    <img src="./assets/images/hero-one.jpg" class="d-none d-md-block w-100 object-fit-cover"
                        height="500"
                        alt="Image by Freepik - https://www.freepik.com/free-photo/full-shot-woman-online-fashion-shopping_44389556.htm#query=ecommerce&position=0&from_view=search&track=sph&uuid=d80bae0e-4fce-416c-943a-de166646e058#position=0&query=ecommerce">
                    <img src="./assets/images/hero-one.jpg" class="img-fluid d-md-none"
                        alt="Image by Freepik - https://www.freepik.com/free-photo/full-shot-woman-online-fashion-shopping_44389556.htm#query=ecommerce&position=0&from_view=search&track=sph&uuid=d80bae0e-4fce-416c-943a-de166646e058#position=0&query=ecommerce">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary opacity-25"></div>
                </div>
                <div class="carousel-item position-relative">
                    <img src="./assets/images/hero-two.jpg" class="d-none d-md-block w-100 object-fit-cover"
                        height="500"
                        alt="Image
                    by Freepik - https://www.freepik.com/free-photo/full-shot-woman-online-fashion-shopping_44389562.htm#query=ecommerce&position=28&from_view=search&track=sph&uuid=b47cb553-beda-4dc2-ba66-54033eff2efb">
                    <img src="./assets/images/hero-two.jpg" class="img-fluid d-md-none"
                        alt="Image
                    by Freepik - https://www.freepik.com/free-photo/full-shot-woman-online-fashion-shopping_44389562.htm#query=ecommerce&position=28&from_view=search&track=sph&uuid=b47cb553-beda-4dc2-ba66-54033eff2efb">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary opacity-25"></div>
                </div>
                <div class="carousel-item position-relative">
                    <img src="./assets/images/hero-three.jpg" class="d-none d-md-block w-100 object-fit-cover"
                        height="500"
                        alt="Image
                    by Freepik - https://www.freepik.com/free-photo/full-shot-woman-online-fashion-shopping_44389566.htm#query=ecommerce&position=34&from_view=search&track=sph&uuid=513111e8-40b5-432b-9273-e2dde86b8e31">
                    <img src="./assets/images/hero-three.jpg" class="img-fluid d-md-none"
                        alt="Image
                    by Freepik - https://www.freepik.com/free-photo/full-shot-woman-online-fashion-shopping_44389566.htm#query=ecommerce&position=34&from_view=search&track=sph&uuid=513111e8-40b5-432b-9273-e2dde86b8e31">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary opacity-25"></div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <section class="promotion">
        <img src="./assets/images/promotion.jpg" class="d-md-none img-fluid"
            alt="Image
        by Freepik - https://www.freepik.com/free-vector/autumn-sale-banners_2659191.htm#page=2&query=promotion%20gift%20banner&position=13&from_view=search&track=ais&uuid=d0fb6c7e-83df-4c2c-9a22-f2a1c3d8764c">
        <img src="./assets/images/promotion.jpg" class="d-none d-md-block w-100" height="150"
            alt="Image
        by Freepik - https://www.freepik.com/free-vector/autumn-sale-banners_2659191.htm#page=2&query=promotion%20gift%20banner&position=13&from_view=search&track=ais&uuid=d0fb6c7e-83df-4c2c-9a22-f2a1c3d8764c">
    </section>

    <section class="shop-by-category p-3">
        <div class="container">
            <h5 class="mb-4 text-primary fw-semibold">Shop by category</h5>
        </div>
        <div class="container row mx-auto text-center g-3 justify-content-evenly justify-content-lg-between">
            <div class="col-sm-5 col-lg-2 bg-light border border-primary rounded p-2">
                <a href="<?= HTTP::link("/products/filter?category=1&sortby=default") ?>">
                    <i class="fi fi-ss-person-dress d-block" style="font-size: 40px;"></i>
                    <p class="text-uppercase category-name">Women Clothing</p>
                </a>
            </div>
            <div
                class="col-sm-5 col-lg-2 bg-light border border-primary rounded p-2 d-flex flex-column justify-content-center">
                <a href="<?= HTTP::link("/products/filter?category=2&sortby=default") ?>">
                    <i class="fi fi-sr-shirt-long-sleeve d-block" style="font-size: 30px;"></i>
                    <p class="text-uppercase category-name">Men Clothing</p>
                </a>
            </div>
            <div class="col-sm-5 col-lg-2 bg-light border border-primary rounded p-2">
                <a href="<?= HTTP::link("/products/filter?category=3&sortby=default") ?>">
                    <i class="fi fi-br-boot d-block" style="font-size: 30px;"></i>
                    <p class="text-uppercase category-name">Women Shoes & Sandals</p>
                </a>
            </div>
            <div class="col-sm-5 col-lg-2 bg-light border border-primary rounded p-2">
                <a href="<?= HTTP::link("/products/filter?category=4&sortby=default") ?>">
                    <i class="fi fi-bs-boot-heeled d-block" style="font-size: 30px;"></i>
                    <p class="text-uppercase category-name">Men Shoes & Sandals</p>
                </a>
            </div>
            <div
                class="col-sm-5 col-lg-2 bg-light border border-primary rounded p-2 d-flex flex-column justify-content-center">
                <a href="<?= HTTP::link("/products/filter?category=5&sortby=default") ?>">
                    <i class="fi fi-br-backpack d-block" style="font-size: 30px;"></i>
                    <p class="text-uppercase category-name">Back Bags</p>
                </a>
            </div>
        </div>
    </section>

    <section class="testimonials p-3">
        <div class="container px-0">
            <div class="splide">
                <h5 class="mb-4 text-primary fw-semibold text-center">Testimonials</h5>
                <div class="splide__track">
                    <ul class="splide__list">
                        <li class="splide__slide">
                            <div class="card" style="width: 20rem;">
                                <div class="card-body">
                                    <div class="d-flex mb-3">
                                        <img src="https://randomuser.me/api/portraits/men/46.jpg" width="50" height="50"
                                            class="rounded-pill">
                                        <div class="customer-info ms-3">
                                            <h6 class="card-title">Byron Lee</h6>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star-half-stroke"></i>
                                        </div>
                                    </div>
                                    <p class="card-text">"I was amazed by the incredible variety and quality of products
                                        on UNION. The ordering process was a breeze, and my
                                        items arrived sooner than expected. The customer service team was friendly and
                                        resolved my inquiry promptly. I highly recommend this site for a fantastic
                                        shopping experience!"</p>
                                </div>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="card" style="width: 20rem;">
                                <div class="card-body">
                                    <div class="d-flex mb-3">
                                        <img src="https://randomuser.me/api/portraits/women/81.jpg" width="50"
                                            height="50" class="rounded-pill">
                                        <div class="customer-info ms-3">
                                            <h6 class="card-title">Zoey Jimenez</h6>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star-half-stroke"></i>
                                        </div>
                                    </div>
                                    <p class="card-text">"Shopping on UNION was a game-changer
                                        for me. The website is easy to navigate, and I found exactly what I needed. The
                                        delivery was lightning-fast, and the product exceeded my expectations. Great
                                        job, UNION!"</p>
                                </div>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="card" style="width: 20rem;">
                                <div class="card-body">
                                    <div class="d-flex mb-3">
                                        <img src="https://randomuser.me/api/portraits/men/94.jpg" width="50" height="50"
                                            class="rounded-pill">
                                        <div class="customer-info ms-3">
                                            <h6 class="card-title">Joe Hansen</h6>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-sharp fa-regular fa-star"></i>
                                        </div>
                                    </div>
                                    <p class="card-text">"I've been a loyal customer of UNION
                                        for years. The quality of their products is unmatched, and their prices are
                                        competitive. Even when I had a minor issue, the customer support team went above
                                        and beyond to assist me. I wouldn't shop anywhere else!"</p>
                                </div>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="card" style="width: 20rem;">
                                <div class="card-body">
                                    <div class="d-flex mb-3">
                                        <img src="https://randomuser.me/api/portraits/men/70.jpg" width="50" height="50"
                                            class="rounded-pill">
                                        <div class="customer-info ms-3">
                                            <h6 class="card-title">Frank Jensen</h6>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star-half-stroke"></i>
                                        </div>
                                    </div>
                                    <p class="card-text">"Impressed by the professionalism of UNION. The website design
                                        is sleek and user-friendly. My order arrived in perfect condition, and the
                                        packaging was eco-friendly. UNION sets the standard for online shopping!"</p>
                                </div>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="card" style="width: 20rem;">
                                <div class="card-body">
                                    <div class="d-flex mb-3">
                                        <img src="https://randomuser.me/api/portraits/men/90.jpg" width="50" height="50"
                                            class="rounded-pill">
                                        <div class="customer-info ms-3">
                                            <h6 class="card-title">Roy Fernandez</h6>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-sharp fa-regular fa-star"></i>
                                        </div>
                                    </div>
                                    <p class="card-text">"I recently discovered UNION, and it's been a delightful
                                        experience. The range of products is extensive, and the prices are reasonable.
                                        The checkout process was smooth, and my package arrived on time. I'm a happy
                                        customer and will definitely be back!"</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="services bg-light px-3 py-4">
        <div class="container">
            <div class="row g-3 justify-content-between text-center fw-semibold">
                <div class="col-sm-6 col-md-3">
                    <i class="fa-regular fa-thumbs-up" style="font-size: 35px"></i>
                    <p class="service-name mt-2">Best Values</p>
                </div>
                <div class="col-sm-6 col-md-3">
                    <i class="fa-solid fa-award" style="font-size: 35px"></i>
                    <p class="service-name mt-2">Brand Guarantee</p>
                </div>
                <div class="col-sm-6 col-md-3">
                    <i class="fa-solid fa-truck" style="font-size: 30px"></i>
                    <p class="service-name mt-2">Fast Delivery</p>
                </div>
                <div class="col-sm-6 col-md-3">
                    <i class="fa-solid fa-shield-halved" style="font-size: 30px"></i>
                    <p class="service-name mt-2">Secure Payment</p>
                </div>
            </div>
        </div>
    </section>

    <section id="faqs" class="p-3">
        <div class="container">
            <h5 class="mb-4 text-primary fw-semibold text-center">FAQs</h5>
            <div class="accordion accordion-flush" id="faqs-accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed lead" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            How do I place an order?
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#faqs-accordion">
                        <div class="accordion-body">
                            It's simple! Just browse our products, select the items you want, and click the "Add to
                            Cart" button. Once you're ready, proceed to checkout and follow the easy steps to complete
                            your purchase.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            Can I modify or cancel my order after placing it?
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            We process orders quickly to ensure prompt delivery. Unfortunately, once an order is
                            confirmed, it cannot be modified or canceled. Please double-check your order before
                            completing the purchase.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseThree" aria-expanded="false"
                            aria-controls="flush-collapseThree">
                            How can I contact customer support?
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            Our customer support team is here to help! You can reach us through our Contact Us page,
                            and we'll respond to your inquiries as quickly as possible.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include(__DIR__ . "/components/footer.php"); ?>

    <script src="node_modules/@splidejs/splide/dist/js/splide.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        new Splide(".splide", {
            type: "loop",
            focus: "center",
            padding: "0rem",
            perPage: 4,
            perMove: 1,
            height: "18rem",
            breakpoints: {
                780: {
                    perPage: 1,
                },
                1200: {
                    perPage: 2,
                },
                1400: {
                    perPage: 3,
                },
            },
        }).mount();
    });

    sessionStorage.clear();
    </script>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>