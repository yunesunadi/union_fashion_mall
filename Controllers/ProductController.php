<?php

namespace App\Controllers;

include(__DIR__ . "/../vendor/autoload.php");

use App\Models\Product;
use App\Router;
use App\Database;

$product_controller = new ProductController;
$router = new Router;

if ($action) {
    switch ($action) {
        case "detail":
            $product_controller->detail($router);
            break;
        case "filter":
            $product_controller->filter($router);
            break;
        default:
            exit("Unknown action -> $action");
    }
} else {
    $product_controller->index($router);
}

class ProductController
{
    public Product $product;

    public function __construct()
    {
        $this->product = new Product(new Database);
    }

    public function index(Router $router)
    {
        $router->render("index", "Products", [
            "products" => $this->product->getAll(),
            "wishlists" => $this->product->getWishlistByUserId()
        ]);
    }

    public function detail(Router $router)
    {
        $id = $_GET["id"] ?? null;
        $router->render("detail", "Product Detail", [
            "product" => $this->product->getProductById($id),
            "categories" => $this->product->getCategories(),
            "products" => $this->product->getAll(),
            "wishlists" => $this->product->getWishlistByUserId(),
        ]);
        $this->product->insertWishlist($id);
    }

    public function filter(Router $router)
    {
        $category = $_GET["category"] ?? "";
        $gender = $_GET["gender"] ?? "";
        $sortby = $_GET["sortby"] ?? "";
        $search = $_GET["search"] ?? "";

        $router->render("index", "Products", [
            "products" => $this->product->getFilteredProducts([
                "category_id" => (string) $category,
                "gender" => $gender,
                "sortby" => $sortby,
                "search" => $search
            ]),
            "wishlists" => $this->product->getWishlistByUserId()
        ]);
    }
}