<?php

include(__DIR__ . "/../../vendor/autoload.php");
use App\Helpers\HTTP;
use App\Helpers\Auth;

$auth = Auth::check();
$url = substr($_SERVER["REQUEST_URI"], strlen(HTTP::$folder));

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?= HTTP::link("/") ?>">UNION</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav text-center me-auto mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $url === "/" ? "active" : "" ?>" aria-current="page"
                        href="<?= HTTP::link("/") ?>">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= (str_contains($url, "/products/")) ? "active" : "" ?>"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= HTTP::link("/products/") ?>">All Products</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="<?= isset($_GET["category"]) && $_GET["category"] === "1" ? "bg-primary" : "" ?>">
                            <a class="dropdown-item"
                                href="<?= HTTP::link("/products/filter?category=1&sortby=default") ?>">Women
                                Clothing</a>
                        </li>
                        <li class="<?= isset($_GET["category"]) && $_GET["category"] === "2" ? "bg-primary" : "" ?>">
                            <a class="dropdown-item"
                                href="<?= HTTP::link("/products/filter?category=2&sortby=default") ?>">Men
                                Clothing
                            </a>
                        </li>
                        <li class="<?= isset($_GET["category"]) && $_GET["category"] === "3" ? "bg-primary" : "" ?>">
                            <a class="dropdown-item"
                                href="<?= HTTP::link("/products/filter?category=3&sortby=default") ?>">Women
                                Shoes &
                                Sandals
                            </a>
                        </li>
                        <li class="<?= isset($_GET["category"]) && $_GET["category"] === "4" ? "bg-primary" : "" ?>">
                            <a class="dropdown-item"
                                href="<?= HTTP::link("/products/filter?category=4&sortby=default") ?>">Men
                                Shoes &
                                Sandals
                            </a>
                        </li>
                        <li class="<?= isset($_GET["category"]) && $_GET["category"] === "5" ? "bg-primary" : "" ?>">
                            <a class="dropdown-item"
                                href="<?= HTTP::link("/products/filter?category=5&sortby=default") ?>">Back
                                Bags
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $url === "/aboutus" ? "active" : "" ?>"
                        href="<?= HTTP::link("/aboutus") ?>">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $url === "/contactus" ? "active" : "" ?>"
                        href="<?= HTTP::link("/contactus") ?>">Contact Us</a>
                </li>
            </ul>
            <div class="d-flex flex-column flex-lg-row">
                <form action="<?= HTTP::link("/products/filter") ?>" class="d-flex me-2 mb-3 mb-lg-0 order-2 order-lg-1"
                    role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"
                        name="search">
                    <button class="btn text-primary" style="background-color: #fff;" type="submit"><i
                            class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                <ul
                    class="navbar-nav flex-row justify-content-center gap-3 gap-lg-0 text-center mb-2 mb-lg-0 order-1 order-lg-2">
                    <li class="nav-item">
                        <a class="nav-link <?= $url === "/users/favorite" ? "active" : "" ?>"
                            href="<?= $auth ? HTTP::link("/users/wishlist") : HTTP::link("/users/login") ?>"
                            onclick="<?= !$auth ? "alert('To do this action, you need to login!')" : '' ?>"><i
                                class="fa-regular fa-heart"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative <?= $url === "/users/cart" ? "active" : "" ?>"
                            href="<?= HTTP::link("/users/cart") ?>">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <?php
                            $total_items = 0;
                            if (isset($_SESSION["cart"]) && count($_SESSION["cart"]) != 0):
                                foreach ($_SESSION["cart"] as $cart) {
                                    $total_items += (int) $cart["qty"];
                                }
                                ?>
                            <span
                                class="position-absolute top-10 translate-middle badge rounded-circle bg-light text-primary"
                                style="font-size: 10px">
                                <span style="font-size: 12px; display: inline-block; margin-top: -10px">
                                    <?= $total_items ?>
                                </span>
                            </span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <?php if ($auth): ?>
                    <li class="nav-item dropdown d-lg-none">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-regular fa-user"></i>
                        </a>
                        <ul class="dropdown-menu" style="position:absolute; left: -95px">
                            <li><a class="dropdown-item" href="<?= HTTP::link("/users/myorders") ?>">My Orders</a>
                            </li>
                            <li><a class="dropdown-item" href="<?= HTTP::link("/users/setting") ?>">Setting</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= HTTP::link("/users/logout") ?>">Logout</a></li>
                        </ul>
                    </li>
                    <li class="nav-item d-none d-lg-block">
                        <div class="btn-group">
                            <a class="nav-link dropdown-toggle" href="" data-bs-toggle="dropdown"
                                aria-expanded="false"><i class="fa-regular fa-user"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li class="<?= $url === "/users/myorders" ? "bg-primary" : "" ?>"><a
                                        class="dropdown-item" href="<?= HTTP::link("/users/myorders") ?>">My Orders</a>
                                </li>
                                <li class="<?= $url === "/users/setting" ? "bg-primary" : "" ?>"><a
                                        class="dropdown-item" href="<?= HTTP::link("/users/setting") ?>">Setting</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="<?= HTTP::link("/users/logout") ?>">Logout</a></li>
                            </ul>
                        </div>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $url === "/users/signup" ? "active" : "" ?>"
                            href="<?= HTTP::link("/users/signup") ?>"><i class="fa-solid fa-user-plus"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $url === "/users/login" ? "active" : "" ?>"
                            href="<?= HTTP::link("/users/login") ?>"><i
                                class="fa-solid fa-arrow-right-to-bracket"></i></a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</nav>