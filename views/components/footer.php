<?php

include(__DIR__ . "/../../vendor/autoload.php");
use App\Helpers\HTTP;

?>

<section class="cta bg-primary px-3 py-4">
    <div class="container">
        <div class="row g-2 justify-content-center align-items-center fw-semibold">
            <div class="col-md-6 col-lg-5">
                <h5 class="text-white">Subscribe for our newsletter to get best offers</h5>
            </div>
            <div class="col-md-6 col-lg-4">
                <form>
                    <div class="d-flex flex-column flex-sm-row w-100 gap-2">
                        <label for="newsletter1" class="visually-hidden">Email address</label>
                        <input id="newsletter1" type="text" class="form-control" placeholder="Email address">
                        <button class="btn btn-light" type="button">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<footer class="p-3 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center col-lg-2 mb-3">
                <a class="h3 d-block" href="<?= HTTP::link("/") ?>">UNION</a>
                <small>Shop Smart, Shop Simple.</small>
            </div>
            <div class="col-sm-6 col-lg-2 mb-3">
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="<?= HTTP::link("/") ?>" class="nav-link p-0 text-dark">Home</a>
                    </li>
                    <li class="nav-item mb-2"><a href="<?= HTTP::link("/products") ?>"
                            class="nav-link p-0 text-dark">Products</a></li>
                    <li class="nav-item mb-2"><a href="<?= HTTP::link("/aboutus") ?>"
                            class="nav-link p-0 text-dark">About Us</a></li>
                    <li class="nav-item mb-2"><a href="<?= HTTP::link("/contactus") ?>"
                            class="nav-link p-0 text-dark">Contact Us</a>
                    </li>
                </ul>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3">
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-dark">Return & Refund Policy</a>
                    </li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-dark">Terms & Conditions</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-dark">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-lg-4 offset-lg-1 mb-3">
                <h6 class="mb-3">Subscribe for exclusive offers and updates.</h6>
                <form>
                    <div class="d-flex flex-column flex-sm-row w-100 gap-2">
                        <label for="newsletter2" class="visually-hidden">Email address</label>
                        <input id="newsletter2" type="text" class="form-control" placeholder="Email address">
                        <button class="btn btn-primary" type="button">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="d-flex flex-column flex-sm-row justify-content-between pt-2 mt-2 border-top border-dark">
            <p class="text-center">2023 &copy; UNION. All rights reserved.</p>
            <ul class="list-unstyled d-flex justify-content-center">
                <li class="ms-3">
                    <a class="link-body-emphasis" href="#">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                </li>
                <li class="ms-3">
                    <a class="link-body-emphasis" href="#">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </li>
                <li class="ms-3">
                    <a class="link-body-emphasis" href="#">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                </li>
                <li class="ms-3">
                    <a class="link-body-emphasis" href="#">
                        <i class="fa-brands fa-linkedin"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</footer>