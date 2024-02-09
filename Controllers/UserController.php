<?php

namespace App\Controllers;

include(__DIR__ . "/../vendor/autoload.php");

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Router;
use App\Database;
use App\Helpers\HTTP;
use App\Controllers\OrderController;

$controller = new UserController;
$router = new Router;

switch ($action) {
    case "signup":
        $controller->signup($router);
        break;
    case "login":
        $controller->login($router);
        break;
    case "setting":
        $controller->setting($router);
        break;
    case "update":
        $controller->update();
        break;
    case "cart":
        $controller->cart($router);
        break;
    case "remove_cart_item":
        $controller->remove_cart_item();
        break;
    case "remove_cart":
        $controller->remove_cart();
        break;
    case "checkout":
        $controller->checkout($router);
        break;
    case "myorders":
        $controller->myorders($router);
        break;
    case "wishlist":
        $controller->wishlist($router);
        break;
    case "logout":
        $controller->logout();
        break;
    default:
        exit("Unknown action -> $action");
}

class UserController
{
    public User $user;
    public Order $order;
    public Product $product;

    public function __construct()
    {
        $this->user = new User(new Database);
        $this->order = new Order(new Database);
        $this->product = new Product(new Database);
    }

    public function signup(Router $router)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = [
                "profile" => $_FILES["profile"],
                "name" => trim($_POST["name"]),
                "email" => trim($_POST["email"]),
                "password" => trim($_POST["password"]),
                "confirm_password" => trim($_POST["confirm_password"]),
            ];
            $result = $this->user->signup($data);
            $result ?
                HTTP::redirect("/users/login") :
                HTTP::redirect("/users/signup");
        } else {
            $router->render("signup", "Sign Up");
        }
    }

    public function login(Router $router)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = [
                "email" => trim($_POST["email"]),
                "password" => trim($_POST["password"]),
            ];

            if ($data["email"] === "admin@unionfashionmall.com" && $data["password"] === "password") {
                session_start();
                $_SESSION["admin_auth"] = true;
                $_SESSION["success"] = "Login successfully.";
                HTTP::redirect("/admin/view_instocks/");
            } else {
                $result = $this->user->login($data);
                $result ?
                    HTTP::redirect("/") :
                    HTTP::redirect("/users/login");
            }
        } else {
            $router->render("login", "Login");
        }
    }

    public function setting(Router $router)
    {
        $router->render("setting", "Setting");
    }

    public function update()
    {
        if (isset($_POST["edit_profile"])) {
            $data = [
                "action" => "edit_profile",
                "profile" => $_FILES["profile"],
                "name" => trim($_POST["name"]),
                "email" => trim($_POST["email"]),
            ];
            $this->user->update($data);
            HTTP::redirect("/users/setting");
        } else if (isset($_POST["change_password"])) {
            $data = [
                "action" => "change_password",
                "password" => trim($_POST["password"]),
                "new_password" => trim($_POST["new_password"]),
                "confirm_password" => trim($_POST["confirm_password"]),
            ];
            $this->user->update($data);
            HTTP::redirect("/users/setting");
        }
    }

    public function cart(Router $router)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = json_decode(file_get_contents('php://input'), true);
            $this->user->cart([
                "id" => $data["id"],
                "qty" => $data["qty"]
            ]);
            $this->product->insertWishlist($data["id"]);
        } else {
            $router->render("cart", "My Cart", [
                "categories" => $this->product->getCategories(),
                "wishlists" => $this->product->getWishlistByUserId()
            ]);
        }
    }

    public function remove_cart_item()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            session_start();

            $_SESSION["cart"] = array_filter($_SESSION["cart"], function ($item) {
                $data = json_decode(file_get_contents('php://input'), true);
                return $item["id"] != $data["id"];
            });
            $data = json_decode(file_get_contents('php://input'), true);
            echo $data["id"];
        }
    }

    public function remove_cart()
    {
        session_start();
        unset($_SESSION["cart"]);
        HTTP::redirect("/users/cart");
    }

    public function checkout(Router $router)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $order_controller = new OrderController;
            $order_controller->create();
        } else {
            $router->render("checkout", "Checkout");
        }
    }

    public function myorders(Router $router)
    {
        if (isset($_GET["status"])) {
            $status = $_GET["status"] ?? "";
            $router->render("myorders", "My Orders", [
                "orders" => $this->order->getAllByStatus($status),
                "categories" => $this->product->getCategories()
            ]);
        } else {
            $router->render("myorders", "My Orders", [
                "orders" => $this->order->getAllById(),
                "categories" => $this->product->getCategories()
            ]);
        }
    }

    public function wishlist(Router $router)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = json_decode(file_get_contents('php://input'), true);
            $this->user->wishlist([
                "user_id" => $data["user_id"],
                "product_id" => $data["product_id"],
                "status" => $data["status"]
            ]);
        } else {
            $router->render("wishlist", "My Wishlist", [
                "products" => $this->user->getWishlistProductByUser(),
                "wishlists" => $this->product->getWishlistByUserId(),
                "categories" => $this->product->getCategories()
            ]);
        }
    }

    public function logout()
    {
        session_start();
        unset($_SESSION["user"]);
        unset($_SESSION["cart"]);
        HTTP::redirect("/");
    }
}