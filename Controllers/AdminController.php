<?php

namespace App\Controllers;

include(__DIR__ . "/../vendor/autoload.php");

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Feedback;
use App\Helpers\HTTP;
use App\Router;
use App\Database;

$admin_controller = new AdminController;
$router = new Router;

switch ($action) {
    case "view_instocks":
        $admin_controller->view_instocks($router);
        break;
    case "create_product":
        $admin_controller->create_product($router);
        break;
    case "update_product":
        $admin_controller->update_product($router);
        break;
    case "delete_product":
        $admin_controller->delete_product();
        break;
    case "view_soldouts":
        $admin_controller->view_soldouts($router);
        break;
    case "view_orders":
        $admin_controller->view_orders($router);
        break;
    case "change_progressing":
        $admin_controller->change_progressing();
        break;
    case "change_shipped":
        $admin_controller->change_shipped();
        break;
    case "view_users":
        $admin_controller->view_users($router);
        break;
    case "view_history":
        $admin_controller->view_history($router);
        break;
    case "view_feedbacks":
        $admin_controller->view_feedbacks($router);
        break;
    case "search_users":
        $admin_controller->search_users($router);
        break;
    case "search_products":
        $admin_controller->search_products($router);
        break;
    case "search_soldouts":
        $admin_controller->search_soldouts($router);
        break;
    case "logout":
        $admin_controller->logout();
        break;
    default:
        exit("Unknown action -> $action");
}

class AdminController
{
    public Product $product;
    public Order $order;
    public User $user;
    public Feedback $feedback;

    public function __construct()
    {
        $this->product = new Product(new Database);
        $this->order = new Order(new Database);
        $this->user = new User(new Database);
        $this->feedback = new Feedback(new Database);
    }

    public function view_instocks(Router $router)
    {
        $router->render("view_instocks", "Available Products", [
            "products" => $this->product->getAvailableProducts(),
            "categories" => $this->product->getCategories(),
        ]);
    }

    public function create_product(Router $router)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = [
                "code" => trim($_POST["code"]),
                "image" => $_FILES["image"],
                "name" => trim($_POST["name"]),
                "details" => trim($_POST["details"]),
                "price" => trim($_POST["price"]),
                "stock" => trim($_POST["stock"]),
                "category_id" => trim($_POST["category_id"]),
            ];
            $result = $this->product->create($data);
            $result ?
                HTTP::redirect("/admin/view_instocks/") :
                HTTP::redirect("/admin/create_product/");
        } else {
            $router->render("create_product", "Create Product", [
                "categories" => $this->product->getCategories()
            ]);
        }
    }

    public function update_product(Router $router)
    {
        $id = $_GET["id"] ?? null;

        if ($id) {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $data = [
                    "code" => trim($_POST["code"]),
                    "image" => $_FILES["image"],
                    "name" => trim($_POST["name"]),
                    "details" => trim($_POST["details"]),
                    "price" => trim($_POST["price"]),
                    "stock" => trim($_POST["stock"]),
                    "category_id" => trim($_POST["category_id"]),
                ];
                $result = $this->product->update([...$data, "id" => $id]);
                $result ?
                    HTTP::redirect("/admin/view_instocks/") :
                    HTTP::redirect("/admin/update_product/$id");
            } else {
                $router->render("update_product", "Edit Product", [
                    "product" => $this->product->update($id),
                    "categories" => $this->product->getCategories()
                ]);
            }
        } else {
            HTTP::redirect("/admin/view_instocks/");
        }
    }

    public function delete_product()
    {
        $id = $_POST["id"] ?? null;
        $this->product->delete($id);
        HTTP::redirect("/admin/view_instocks/");
    }

    public function view_soldouts(Router $router)
    {
        $router->render("view_soldouts", "Soldout Products", [
            "soldouts" => $this->product->getSoldoutProducts(),
            "categories" => $this->product->getCategories(),
        ]);
    }

    public function view_orders(Router $router)
    {
        if (isset($_GET["status"])) {
            $status = $_GET["status"] ?? "";
            $router->render("view_orders", "Orders", [
                "orders" => $this->order->getAllByStatusAdmin($status),
                "categories" => $this->product->getCategories()
            ]);
        } else {
            $router->render("view_orders", "All Orders", [
                "orders" => $this->order->getAllByIdAdmin(),
                "categories" => $this->product->getCategories()
            ]);
        }
    }

    public function change_progressing()
    {
        $id = $_POST["id"] ?? null;
        $this->order->change_progressing($id);
        HTTP::redirect("/admin/view_orders/");
    }

    public function change_shipped()
    {
        $id = $_POST["id"] ?? null;
        $this->order->change_shipped($id);
        HTTP::redirect("/admin/view_orders/");
    }

    public function view_users(Router $router)
    {
        $router->render("view_users", "All Users", [
            "users" => $this->user->getAll(),
        ]);
    }

    public function view_history(Router $router)
    {
        $id = $_GET["id"] ?? null;

        if (isset($_GET["status"])) {
            $status = $_GET["status"] ?? "";
            $router->render("view_history", "Order History", [
                "orders" => $this->order->getHistoryByStatusAdmin([
                    "user_id" => $id,
                    "status" => $status,
                ]),
                "categories" => $this->product->getCategories(),
                "users" => $this->user->getAll(),
            ]);
        } else {
            $router->render("view_history", "Order History", [
                "orders" => $this->order->getHistoryByUserAdmin($id),
                "categories" => $this->product->getCategories(),
                "users" => $this->user->getAll(),
            ]);
        }
    }

    public function view_feedbacks(Router $router)
    {
        $router->render("view_feedbacks", "All Feedbacks", [
            "feedbacks" => $this->feedback->getAll(),
        ]);
    }

    public function search_users(Router $router)
    {
        $value = $_GET["value"] ?? "";

        $router->render("view_users", "All Users", [
            "users" => $this->user->getFilteredUsers($value),
        ]);
    }

    public function search_products(Router $router)
    {
        $value = $_GET["value"] ?? "";

        $router->render("view_instocks", "Available Products", [
            "products" => $this->product->getFilteredAvailableProductsAdmin($value),
            "categories" => $this->product->getCategories(),
        ]);
    }

    public function search_soldouts(Router $router)
    {
        $value = $_GET["value"] ?? "";

        $router->render("view_soldouts", "Soldout Products", [
            "soldouts" => $this->product->getFilteredSoldoutProductsAdmin($value),
            "categories" => $this->product->getCategories(),
        ]);
    }

    public function logout()
    {
        session_start();
        unset($_SESSION["admin_auth"]);
        HTTP::redirect("/");
    }
}