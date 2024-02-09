<?php

include(__DIR__ . "/../../../vendor/autoload.php");

use App\Helpers\Auth;
use App\Helpers\HTTP;

Auth::adminCheck();

$url = substr($_SERVER["REQUEST_URI"], strlen(HTTP::$folder . "/admin"));
$id = $_GET["id"] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="./../../node_modules/@flaticon/flaticon-uicons/css/all/all.css">
    <link rel="stylesheet" href="./../../node_modules/@splidejs/splide/dist/css/splide.min.css">
    <link rel="stylesheet" href="./../../assets/css/custom.css">

    <style>
        .sidebar .nav-link {
            font-size: .875rem;
            font-weight: 500;
        }

        .navbar-brand {
            padding-top: .75rem;
            padding-bottom: .75rem;
            background-color: rgba(0, 0, 0, .25);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
        }

        .responsive-table {
            width: max-content;
        }

        @media screen and (min-width: 768px) {
            .sidebar {
                min-height: 100vh;
            }

            .responsive-table {
                width: fit-content;
            }
        }
    </style>
</head>

<body>
    <header class="navbar sticky-top bg-primary flex-md-nowrap p-0 shadow" data-bs-theme="dark">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white"
            href="<?= HTTP::link("/admin/view_instocks/") ?>">UNION</a>

        <ul class="navbar-nav flex-row d-md-none">
            <li class="nav-item text-nowrap">
                <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </li>
        </ul>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
                <div class="offcanvas-md offcanvas-start bg-body-tertiary" tabindex="-1" id="sidebarMenu"
                    aria-labelledby="sidebarMenuLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="sidebarMenuLabel">UNION</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                            data-bs-target="#sidebarMenu" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a href="<?= HTTP::link("/admin/view_instocks/") ?>"
                                    class="nav-link <?= $url === "/view_instocks/" || str_contains($url, "/search_products/?value=") ? "bg-primary text-white" : "" ?>"
                                    aria-current=" page">
                                    <i class="fa-solid fa-shop me-2"></i>
                                    View In Stocks
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= HTTP::link("/admin/view_soldouts/") ?>"
                                    class="nav-link <?= $url === "/view_soldouts/" || str_contains($url, "/search_soldouts/?value=") ? "bg-primary text-white" : "" ?>">
                                    <i class="fa-solid fa-store-slash me-2"></i>
                                    View Soldouts
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= HTTP::link("/admin/view_orders/") ?>"
                                    class="nav-link <?= $url === "/view_orders/" || $url === "/view_orders/?status=all" || $url === "/view_orders/?status=0" || $url === "/view_orders/?status=1" ? "bg-primary text-white" : "" ?>">
                                    <i class="fa-regular fa-rectangle-list me-2"></i>
                                    View Orders
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= HTTP::link("/admin/view_users/") ?>"
                                    class="nav-link <?= $url === "/view_users/" || $url === "/view_history/$id" || $url === "/view_history/$id?status=all" || $url === "/view_history/$id?status=0" || $url === "/view_history/$id?status=1" || str_contains($url, "/search_users/?value=") ? "bg-primary text-white" : "" ?>">
                                    <i class="fa-regular fa-user me-2"></i>
                                    View Users
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= HTTP::link("/admin/view_feedbacks/") ?>"
                                    class="nav-link <?= $url === "/view_feedbacks/" ? "bg-primary text-white" : "" ?>">
                                    <i class="fa-regular fa-comment me-2"></i>
                                    View Feedbacks
                                </a>
                            </li>
                            <li class="nav-item">
                                <form action="<?= HTTP::link("/admin/logout") ?>" method="post" id="logoutForm">
                                    <a href="#" class="nav-link" onclick="submitForm()">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i>
                                        Logout
                                    </a>
                                </form>
                                <script>
                                    function submitForm() {
                                        document.querySelector("#logoutForm").submit();
                                    }
                                </script>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">