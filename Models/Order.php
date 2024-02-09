<?php

namespace App\Models;

include(__DIR__ . "/../vendor/autoload.php");

use App\Database;
use PDOException;
use App\Helpers\HTML;

class Order
{
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $phone_no;
    public string $address;
    public string $city;
    public string $region;
    public string $postal_code;
    public string $card_number;
    public string $nameoncard;
    public string $mmyy;
    public string $cvv;
    public array $shipping_information;
    public array $payment_method;
    public array $cart;
    public int $user_id;
    public int $status;
    public $db = null;

    public function __construct(Database $db)
    {
        $this->db = $db->connect();
    }

    public function load(array $data)
    {

        $this->first_name = $data["first_name"] ?? "";
        $this->last_name = $data["last_name"] ?? "";
        $this->email = $data["email"] ?? "";
        $this->phone_no = $data["phone_no"] ?? "";
        $this->address = $data["address"] ?? "";
        $this->city = $data["city"] ?? "";
        $this->region = $data["region"] ?? "";
        $this->postal_code = $data["postal_code"] ?? "";
        $this->card_number = $data["card_number"] ?? "";
        $this->nameoncard = $data["nameoncard"] ?? "";
        $this->mmyy = $data["mmyy"] ?? "";
        $this->cvv = $data["cvv"] ?? "";
        $this->shipping_information = $data["shipping_information"] ?? [];
        $this->payment_method = $data["payment_method"] ?? [];
        $this->cart = $data["cart"] ?? [];
        $this->user_id = (int) $data["user_id"] ?? 0;
        $this->status = (int) $data["status"] ?? -1;
    }

    public function create(array $data): ?bool
    {
        try {
            session_start();
            $error = [];
            $isInserted = false;
            $isUpdated = false;
            $this->load($data);
            $auth = $_SESSION["user"];
            $user_id = $auth->id;

            $first_name = HTML::purify($this->first_name);
            $last_name = HTML::purify($this->last_name);
            $email = HTML::purify($this->email);
            $phone_no = HTML::purify($this->phone_no);
            $address = HTML::purify($this->address);
            $city = HTML::purify($this->city);
            $region = HTML::purify($this->region);
            $postal_code = HTML::purify($this->postal_code);
            $card_number = HTML::purify($this->card_number);
            $nameoncard = HTML::purify($this->nameoncard);
            $mmyy = HTML::purify($this->mmyy);
            $cvv = HTML::purify($this->cvv);

            if (empty($first_name) || empty($last_name) || empty($email) || empty($phone_no) || empty($address) || empty($city) || empty($region) || empty($postal_code) || empty($card_number) || empty($nameoncard) || empty($mmyy) || empty($cvv)) {
                $error[] = "Please fill up all fields.";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)) {
                $error[] = "Email is invalid.";
            }

            if (!is_numeric($phone_no) && !empty($phone_no)) {
                $error[] = "Phone number is invalid.";
            }

            if (!is_numeric($postal_code) && !empty($postal_code)) {
                $error[] = "Postal code is invalid.";
            }

            if (!is_numeric($card_number) && !empty($card_number)) {
                $error[] = "Card number is invalid.";
            }

            if (!is_numeric($cvv) && !empty($cvv)) {
                $error[] = "CVV is invalid.";
            }

            $_SESSION["error"] = $error;

            if (count($error) === 0) {
                $shipping_information = [
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "email" => $email,
                    "phone_no" => $phone_no,
                    "address" => $address,
                    "city" => $city,
                    "region" => $region,
                    "postal_code" => $postal_code,
                ];

                $payment_method = [
                    "card_number" => $card_number,
                    "nameoncard" => $nameoncard,
                    "mmyy" => $mmyy,
                    "cvv" => $cvv,
                ];

                $query = "INSERT INTO orders (shipping_information, payment_method, cart, user_id, `status`, created_at) VALUES (:shipping_information, :payment_method, :cart, :user_id, :status, NOW())";
                $statement = $this->db->prepare($query);
                $statement->execute([
                    ":shipping_information" => json_encode($shipping_information, true),
                    ":payment_method" => json_encode($payment_method, true),
                    ":cart" => json_encode($_SESSION["cart"], true),
                    ":user_id" => $user_id,
                    ":status" => 0,
                ]);
                if ($this->db->lastInsertId()) {
                    $isInserted = true;
                }

                $statement = $this->db->query("SELECT * FROM products");
                $products = $statement->fetchAll();

                foreach ($_SESSION["cart"] as $cart) {
                    foreach ($products as $product) {
                        if ($cart["id"] == $product->id && $product->stock > 0) {
                            $updated_stock = $product->stock - $cart["qty"];

                            $statement = $this->db->prepare("UPDATE products SET stock=:stock, updated_at=NOW() WHERE id=:id");
                            $statement->execute([
                                ":stock" => $updated_stock,
                                ":id" => $product->id,
                            ]);

                            if ($statement->rowCount()) {
                                $isUpdated = true;
                            }
                        }
                    }
                }

                $_SESSION["success"] = "You've ordered items successfully.";
                unset($_SESSION["cart"]);
            }

            return $isInserted && $isUpdated;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getAllById(): ?array
    {
        try {
            session_start();
            $auth = $_SESSION["user"];
            $user_id = $auth->id;
            $statement = $this->db->prepare("SELECT * FROM orders WHERE user_id=:user_id ORDER BY id DESC");
            $statement->execute([
                "user_id" => $user_id
            ]);
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getAllByStatus(string $status): ?array
    {
        try {
            session_start();
            $auth = $_SESSION["user"];
            $user_id = $auth->id;
            if ($status === "all") {
                $statement = $this->db->prepare("SELECT * FROM orders WHERE user_id=:user_id ORDER BY id DESC");
                $statement->execute([
                    "user_id" => $user_id
                ]);
            } else if ($status == 0) {
                $statement = $this->db->prepare("SELECT * FROM orders WHERE status=:status AND user_id=:user_id ORDER BY id DESC");
                $statement->execute([
                    "status" => $status,
                    "user_id" => $user_id
                ]);
            } else if ($status == 1) {
                $statement = $this->db->prepare("SELECT * FROM orders WHERE status=:status AND user_id=:user_id ORDER BY id DESC");
                $statement->execute([
                    "status" => $status,
                    "user_id" => $user_id
                ]);
            }
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getAllByIdAdmin(): ?array
    {
        try {
            $statement = $this->db->query("SELECT * FROM orders ORDER BY id DESC");
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getAllByStatusAdmin(string $status): ?array
    {
        try {
            if ($status === "all") {
                $statement = $this->db->query("SELECT * FROM orders ORDER BY id DESC");
            } else if ($status == 0) {
                $statement = $this->db->prepare("SELECT * FROM orders WHERE status=:status ORDER BY id DESC");
                $statement->execute([
                    "status" => $status,
                ]);
            } else if ($status == 1) {
                $statement = $this->db->prepare("SELECT * FROM orders WHERE status=:status ORDER BY id DESC");
                $statement->execute([
                    "status" => $status,
                ]);
            }
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function change_progressing(string $id): ?int
    {
        try {
            session_start();
            $statement = $this->db->prepare("UPDATE orders SET status=:status, updated_at=NOW() WHERE id=:id");
            $statement->execute([
                ":status" => 0,
                ":id" => $id,
            ]);
            $_SESSION["success"] = "Order status is changed successfully.";
            return $statement->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function change_shipped(string $id): ?int
    {
        try {
            session_start();
            $statement = $this->db->prepare("UPDATE orders SET status=:status, updated_at=NOW() WHERE id=:id");
            $statement->execute([
                ":status" => 1,
                ":id" => $id,
            ]);
            $_SESSION["success"] = "Order status is changed successfully.";
            return $statement->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getHistoryByUserAdmin(string $user_id): ?array
    {
        try {
            $statement = $this->db->prepare("SELECT * FROM orders WHERE user_id=:user_id ORDER BY id DESC");
            $statement->execute([
                ":user_id" => $user_id,
            ]);
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getHistoryByStatusAdmin(array $data): ?array
    {
        $user_id = $data["user_id"];
        $status = $data["status"];

        try {
            if ($status === "all") {
                $statement = $this->db->prepare("SELECT * FROM orders WHERE user_id=:user_id ORDER BY id DESC");
                $statement->execute([
                    "user_id" => $user_id,
                ]);
            } else if ($status == 0) {
                $statement = $this->db->prepare("SELECT * FROM orders WHERE user_id=:user_id AND status=:status ORDER BY id DESC");
                $statement->execute([
                    "user_id" => $user_id,
                    "status" => $status,
                ]);
            } else if ($status == 1) {
                $statement = $this->db->prepare("SELECT * FROM orders WHERE user_id=:user_id AND status=:status ORDER BY id DESC");
                $statement->execute([
                    "user_id" => $user_id,
                    "status" => $status,
                ]);
            }
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
}