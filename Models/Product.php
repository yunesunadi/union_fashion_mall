<?php

namespace App\Models;

include(__DIR__ . "/../vendor/autoload.php");

use App\Database;
use PDOException;
use App\Helpers\HTML;

class Product
{
    public string $code;
    public array $image;
    public string $name;
    public string $details;
    public string $price;
    public int $stock;
    public int $category_id;
    public $db = null;

    public function __construct(Database $db)
    {
        $this->db = $db->connect();
    }

    public function load(array $data)
    {
        $this->code = $data["code"] ?? "";
        $this->image = $data["image"] ?? [];
        $this->name = $data["name"] ?? "";
        $this->details = $data["details"] ?? "";
        $this->price = $data["price"] ?? 0;
        $this->stock = (int) $data["stock"] ?? 0;
        $this->category_id = (int) $data["category_id"] ?? 0;
    }

    public function getAll(): ?array
    {
        try {
            $statement = $this->db->query("SELECT * FROM products");
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getProductById(string $id): ?object
    {
        try {
            $statement = $this->db->prepare("SELECT * FROM products WHERE id=:id");
            $statement->execute([
                "id" => $id
            ]);
            return $statement->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getFilteredProducts(array $data): ?array
    {
        try {
            $result = [];

            if ($data["category_id"]) {
                $statement = $this->db->prepare("SELECT * FROM products WHERE category_id=:category_id");

                if ($data["sortby"]) {
                    if ($data["sortby"] === "alphabetical") {
                        $statement = $this->db->prepare("SELECT * FROM products WHERE category_id=:category_id ORDER by name ASC");
                    } else if ($data["sortby"] === "htol") {
                        $statement = $this->db->prepare("SELECT * FROM products WHERE category_id=:category_id ORDER by price DESC");
                    } else if ($data["sortby"] === "ltoh") {
                        $statement = $this->db->prepare("SELECT * FROM products WHERE category_id=:category_id ORDER by price ASC");
                    }
                }

                $statement->execute([
                    "category_id" => $data["category_id"]
                ]);
                $result = $statement->fetchAll();
            }

            if ($data["gender"]) {
                if ($data["gender"] === "female") {
                    $statement = $this->db->query("SELECT * FROM products WHERE category_id in (1, 3)");

                    if ($data["sortby"]) {
                        if ($data["sortby"] === "alphabetical") {
                            $statement = $this->db->query("SELECT * FROM products WHERE category_id in (1, 3) ORDER by name ASC");
                        } else if ($data["sortby"] === "htol") {
                            $statement = $this->db->query("SELECT * FROM products WHERE category_id in (1, 3) ORDER by price DESC");
                        } else if ($data["sortby"] === "ltoh") {
                            $statement = $this->db->query("SELECT * FROM products WHERE category_id in (1, 3) ORDER by price ASC");
                        }
                    }
                } else {
                    $statement = $this->db->query("SELECT * FROM products WHERE category_id in (2, 4)");

                    if ($data["sortby"]) {
                        if ($data["sortby"] === "alphabetical") {
                            $statement = $this->db->query("SELECT * FROM products WHERE category_id in (2, 4) ORDER by name ASC");
                        } else if ($data["sortby"] === "htol") {
                            $statement = $this->db->query("SELECT * FROM products WHERE category_id in (2, 4) ORDER by price DESC");
                        } else if ($data["sortby"] === "ltoh") {
                            $statement = $this->db->query("SELECT * FROM products WHERE category_id in (2, 4) ORDER by price ASC");
                        }
                    }
                }

                $result = $statement->fetchAll();
            }

            if ($data["search"]) {
                $search_value = $data["search"];
                $statement = $this->db->prepare("SELECT * FROM products WHERE name LIKE :keyword");

                if ($data["sortby"]) {
                    if ($data["sortby"] === "alphabetical") {
                        $statement = $this->db->prepare("SELECT * FROM products WHERE name LIKE :keyword ORDER by name ASC");
                    } else if ($data["sortby"] === "htol") {
                        $statement = $this->db->prepare("SELECT * FROM products WHERE name LIKE :keyword ORDER by price DESC");
                    } else if ($data["sortby"] === "ltoh") {
                        $statement = $this->db->prepare("SELECT * FROM products WHERE name LIKE :keyword ORDER by price ASC");
                    }
                }

                $statement->execute([
                    "keyword" => "%$search_value%"
                ]);
                $result = $statement->fetchAll();
            }

            if ($data["sortby"] && !$data["category_id"] && !$data["gender"] && !$data["search"]) {
                if ($data["sortby"] === "alphabetical") {
                    $statement = $this->db->query("SELECT * FROM products ORDER by name ASC");
                } else if ($data["sortby"] === "htol") {
                    $statement = $this->db->query("SELECT * FROM products ORDER by price DESC");
                } else if ($data["sortby"] === "ltoh") {
                    $statement = $this->db->query("SELECT * FROM products ORDER by price ASC");
                } else if ($data["sortby"] === "default") {
                    $statement = $this->db->query("SELECT * FROM products");
                }

                $result = $statement->fetchAll();
            }

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getCategories(): ?array
    {
        try {
            $statement = $this->db->query("SELECT * FROM categories");
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getWishlistByUserId(): array|bool|null
    {
        try {
            if (!isset($_SESSION))
                session_start();

            if (isset($_SESSION["user"])) {
                $auth = $_SESSION["user"];
                $user_id = $auth->id;
                $statement = $this->db->prepare("SELECT * FROM wishlists WHERE user_id=:user_id");
                $statement->execute([
                    "user_id" => $user_id,
                ]);
                return $statement->fetchAll();
            }

            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function create(array $data): ?string
    {
        try {
            session_start();
            $error = [];
            $this->load($data);

            $image = $data["image"];
            $code = HTML::purify($this->code);
            $name = HTML::purify($this->name);
            $details = HTML::purify($this->details);
            $price = HTML::purify($this->price);
            $stock = HTML::purify($this->stock);
            $category_id = HTML::purify($this->category_id);

            if (isset($image) && $image["error"] !== UPLOAD_ERR_NO_FILE) {
                if ($image["type"] !== "image/jpeg" && $image["type"] !== "image/png" && $image["type"] !== "image/gif") {
                    $error[] = "Only JPEG, PNG or GIF images are allowed.";
                } else if ($image["size"] > 3145728) {
                    $error[] = "Image file size is too large.";
                }

                if ($image["error"] !== UPLOAD_ERR_OK) {
                    $error[] = "There is a problem while uploading image.";
                }
            }

            if (empty($code) || empty($name) || empty($details) || empty($price) || empty($stock) || empty($category_id)) {
                $error[] = "Please fill up all fields.";
            }

            if (!empty($price) && !is_numeric($price)) {
                $error[] = "Price must be a number.";
            }

            $_SESSION["error"] = $error;

            if (count($error) === 0) {
                if (isset($image) && $image["error"] !== UPLOAD_ERR_NO_FILE) {
                    move_uploaded_file($image["tmp_name"], __DIR__ . "/../assets/images/products/" . $image["name"]);
                    $image_photo = $image["name"];
                } else {
                    $image_photo = "default_product.png";
                }

                $query = "INSERT INTO products (code, image, name, details, price, stock, category_id, created_at) VALUES (:code, :image, :name, :details, :price, :stock, :category_id, NOW())";
                $statement = $this->db->prepare($query);
                $statement->execute([
                    ":code" => $code,
                    ":image" => $image_photo,
                    ":name" => $name,
                    ":details" => $details,
                    ":price" => $price,
                    ":stock" => $stock,
                    ":category_id" => $category_id,
                ]);
                $_SESSION["success"] = "Product is created successfully.";
            }

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function update(array|string $data): bool|object|null
    {
        try {
            if (is_array($data)) {
                session_start();
                $error = [];
                $isUpdated = false;
                $this->load($data);

                $id = $data["id"];
                $image = $data["image"];
                $code = HTML::purify($this->code);
                $name = HTML::purify($this->name);
                $details = HTML::purify($this->details);
                $price = HTML::purify($this->price);
                $stock = HTML::purify($this->stock);
                $category_id = HTML::purify($this->category_id);

                if (isset($image) && $image["error"] !== UPLOAD_ERR_NO_FILE) {
                    if ($image["type"] !== "image/jpeg" && $image["type"] !== "image/png" && $image["type"] !== "image/gif") {
                        $error[] = "Only JPEG, PNG or GIF images are allowed.";
                    } else if ($image["size"] > 3145728) {
                        $error[] = "Image file size is too large.";
                    }

                    if ($image["error"] !== UPLOAD_ERR_OK) {
                        $error[] = "There is a problem while uploading image.";
                    }
                }

                if (empty($code) || empty($name) || empty($details) || empty($price) || empty($category_id)) {
                    $error[] = "Please fill up all fields.";
                }

                if (!empty($price) && !is_numeric($price)) {
                    $error[] = "Price must be a number.";
                }

                $_SESSION["error"] = $error;

                if (count($error) === 0) {
                    if (isset($image) && $image["error"] !== UPLOAD_ERR_NO_FILE) {
                        move_uploaded_file($image["tmp_name"], __DIR__ . "/../assets/images/products/" . $image["name"]);
                        $image_photo = $image["name"];

                        $statement = $this->db->prepare("UPDATE products SET image=:image, updated_at=NOW() WHERE id=:id");
                        $statement->execute([
                            ":image" => $image_photo,
                            ":id" => $id,
                        ]);

                        if ($statement->rowCount()) {
                            $isUpdated = true;
                        }
                    }

                    $query = "UPDATE products SET code=:code, name=:name, details=:details, price=:price, stock=:stock, category_id=:category_id, updated_at=NOW() WHERE id=:id";
                    $statement = $this->db->prepare($query);
                    $statement->execute([
                        ":code" => $code,
                        ":name" => $name,
                        ":details" => $details,
                        ":price" => $price,
                        ":stock" => $stock,
                        ":category_id" => $category_id,
                        ":id" => $id,
                    ]);

                    $_SESSION["success"] = "Product is updated successfully.";

                    if ($statement->rowCount()) {
                        $isUpdated = true;
                    }
                }

                return $isUpdated;
            } else {
                $query = "SELECT * FROM products WHERE id=:id";
                $statement = $this->db->prepare($query);
                $statement->execute(["id" => $data]);
                return $statement->fetch();
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function insertWishlist(string $id)
    {
        try {
            session_start();
            $auth = $_SESSION["user"];
            $user_id = $auth->id;

            $statement = $this->db->prepare("SELECT * FROM wishlists WHERE user_id=:user_id AND product_id=:product_id");
            $statement->execute([
                "user_id" => $user_id,
                "product_id" => $id,
            ]);
            $wishlist = $statement->fetch();

            if (!$wishlist) {
                $statement = $this->db->prepare("INSERT INTO wishlists (user_id, product_id, status, created_at) VALUES (:user_id, :product_id, :status, NOW())");
                $statement->execute([
                    ":user_id" => $user_id,
                    ":product_id" => $id,
                    ":status" => 0,
                ]);
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function delete(string $id): ?int
    {
        try {
            session_start();
            $query = "DELETE FROM products WHERE id=:id";
            $statement = $this->db->prepare($query);
            $statement->execute(["id" => $id]);
            $_SESSION["success"] = "Product is deleted successfully.";

            return $statement->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getAvailableProducts(): ?array
    {
        try {
            $statement = $this->db->query("SELECT * FROM products WHERE stock <> 0");
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getSoldoutProducts(): ?array
    {
        try {
            $statement = $this->db->query("SELECT * FROM products WHERE stock = 0");
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getFilteredAvailableProductsAdmin(string $value): ?array
    {
        try {
            $result = [];

            if ($value) {
                $statement = $this->db->prepare("SELECT * FROM products WHERE stock <> 0 AND name LIKE :keyword");
                $statement->execute([
                    "keyword" => "%$value%"
                ]);
                $result = $statement->fetchAll();
            }

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getFilteredSoldoutProductsAdmin(string $value): ?array
    {
        try {
            $result = [];

            if ($value) {
                $statement = $this->db->prepare("SELECT * FROM products WHERE stock = 0 AND name LIKE :keyword");
                $statement->execute([
                    "keyword" => "%$value%"
                ]);
                $result = $statement->fetchAll();
            }

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
}