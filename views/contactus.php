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
    <title>Contact Us</title>
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

    <main class="pt-5 pb-3 py-md-5">
        <section class="hero">
            <div class="card position-relative">
                <img src="assets/images/contactus.jpg" class="card-img object-fit-cover d-none d-md-block" height="450"
                    alt="Image by unsplash - https://images.unsplash.com/photo-1586769852044-692d6e3703f0?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D">
                <img src="assets/images/contactus.jpg" class="card-img object-fit-cover d-md-none" height="250"
                    alt="Image by unsplash - https://images.unsplash.com/photo-1586769852044-692d6e3703f0?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D">
                <div class="card-img-overlay text-white d-grid justify-content-center align-content-center text-center mt-5 mt-md-0 z-1"
                    id="hero-content">
                    <h1 class="card-title display-6">Contact Us</h1>
                </div>
                <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary opacity-25"></div>
            </div>
        </section>
        <section class="info mt-4 mt-md-5 mb-md-3">
            <div class="container">
                <div class="row justify-content-around g-4">
                    <div class="col-md-6">
                        <?php if (isset($_SESSION["error"]) && count($_SESSION["error"]) !== 0): ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?php echo '<i class="fa-solid fa-circle-info me-2"></i>' . implode('<br><i class="fa-solid fa-circle-info me-2"></i>', $_SESSION["error"]) . "<br>"; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php
                        endif;
                        unset($_SESSION["error"]);
                        ?>
                        <h6 class="text-primary mb-3">Customer Feedback</h6>
                        <form action="<?= HTTP::link("/feedbacks/create") ?>" method="post" id="contactus-form">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="name" id="name" placeholder="">
                                <label for="name">Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="name@example.com">
                                <label for="email">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="phone_no" id="phoneno" placeholder="">
                                <label for="phone_no">Phone Number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="">
                                <label for="subject">Subject</label>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Leave a comment here"
                                        id="detailed-message" style="height: 150px" name="detailed_message"></textarea>
                                    <label for="floatingTextarea2">Detailed Message</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary text-white">Send</button>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center mb-5">
                            <i class="fa-solid fa-map-location-dot fs-1 text-primary"></i>
                            <p>Address</p>
                            <p>3615 Frances Ct</p>
                        </div>
                        <div class="text-center mb-5">
                            <i class="fa-regular fa-envelope fs-1 text-primary"></i>
                            <p>Email</p>
                            <p>info@unionfashionmall.com</p>
                        </div>
                        <div class="text-center">
                            <i class="fa-solid fa-phone fs-1 text-primary"></i>
                            <p>+959123456789, +959987654321</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include(__DIR__ . "/components/footer.php"); ?>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<script>
const contactUsForm = document.querySelector("#contactus-form");
const nameInput = document.querySelector("#name");
const emailInput = document.querySelector("#email");
const phonenoInput = document.querySelector("#phoneno");
const subjectInput = document.querySelector("#subject");
const detailedMessageInput = document.querySelector("#detailed-message");

document.addEventListener("DOMContentLoaded", () => {
    if (performance.navigation.type === 1) {
        sessionStorage.removeItem("contactUsValue");
    }

    contactUsForm.addEventListener("submit", () => {
        sessionStorage.setItem("contactUsValue", JSON.stringify([nameInput.value, emailInput.value,
            phonenoInput.value, subjectInput.value, detailedMessageInput.value
        ]));
    });
    const [nameValue, emailValue, phonenoValue, subjectValue, detailedMessageValue] = JSON.parse(sessionStorage
        .getItem("contactUsValue")) || [];
    nameInput.value = nameValue || "";
    emailInput.value = emailValue || "";
    phonenoInput.value = phonenoValue || "";
    subjectInput.value = subjectValue || "";
    detailedMessageInput.value = detailedMessageValue || "";
});
</script>