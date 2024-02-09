<?php

namespace App\Controllers;

include(__DIR__ . "/../vendor/autoload.php");

use App\Models\Order;
use App\Database;
use App\Helpers\HTTP;

$order_controller = new OrderController;

if ($action) {
    switch ($action) {
        case "create":
            $order_controller->create();
            break;
        default:
            exit("Unknown action -> $action");
    }
}

class OrderController
{
    public Order $order;

    public function __construct()
    {
        $this->order = new Order(new Database);
    }

    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = [
                "first_name" => trim($_POST["first_name"]),
                "last_name" => trim($_POST["last_name"]),
                "email" => trim($_POST["email"]),
                "phone_no" => trim($_POST["phone_no"]),
                "address" => trim($_POST["address"]),
                "city" => trim($_POST["city"]),
                "region" => trim($_POST["region"]),
                "postal_code" => trim($_POST["postal_code"]),
                "card_number" => trim($_POST["card_number"]),
                "nameoncard" => trim($_POST["nameoncard"]),
                "mmyy" => trim($_POST["mmyy"]),
                "cvv" => trim($_POST["cvv"]),
            ];
            $result = $this->order->create($data);
            $result ?
                HTTP::redirect("/") :
                HTTP::redirect("/users/checkout");
        }
    }
}