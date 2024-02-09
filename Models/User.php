<?php

namespace App\Models;

include(__DIR__ . "/../vendor/autoload.php");

use App\Database;
use App\Helpers\HTML;
use PDOException;

class User
{
    public array $profile;
    public string $name;
    public string $email;
    public string $password;
    public string $new_password;
    public string $confirm_password;
    public $db = null;

    public function __construct(Database $db)
    {
        $this->db = $db->connect();
    }

    public function load(array $data)
    {
        $this->profile = $data["profile"] ?? [];
        $this->name = $data["name"] ?? "";
        $this->email = $data["email"] ?? "";
        $this->password = $data["password"] ?? "";
        $this->new_password = $data["new_password"] ?? "";
        $this->confirm_password = $data["confirm_password"] ?? "";
    }

    public function signup(array $data): ?string
    {
        try {
            session_start();
            $error = [];
            $this->load($data);

            $profile = $data["profile"];
            $name = HTML::purify($this->name);
            $email = HTML::purify($this->email);
            $password = HTML::purify($this->password);
            $hash_password = password_hash($password, PASSWORD_BCRYPT);
            $confirm_password = HTML::purify($this->confirm_password);

            if (isset($profile) && $profile["error"] !== UPLOAD_ERR_NO_FILE) {
                if ($profile["type"] !== "image/jpeg" && $profile["type"] !== "image/png" && $profile["type"] !== "image/gif") {
                    $error[] = "Only JPEG, PNG or GIF images are allowed.";
                } else if ($profile["size"] > 3145728) {
                    $error[] = "Image file size is too large.";
                }

                if ($profile["error"] !== UPLOAD_ERR_OK) {
                    $error[] = "There is a problem while uploading image.";
                }
            }

            if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
                $error[] = "Please fill up all fields.";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)) {
                $error[] = "Email is invalid.";
            }

            if (!empty($password) && strlen($password) < 6) {
                $error[] = "Password must be at least 6 characters.";
            }

            if ($password !== $confirm_password) {
                $error[] = "The two passwords do not match.";
            }

            $query = "SELECT * FROM users WHERE email=:email";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ":email" => $email,
            ]);
            if ($statement->fetch()) {
                $error[] = "Email is already existed.";
            }

            $_SESSION["error"] = $error;

            if (count($error) === 0) {
                if (isset($profile) && $profile["error"] !== UPLOAD_ERR_NO_FILE) {
                    move_uploaded_file($profile["tmp_name"], __DIR__ . "/../assets/images/profiles/" . $profile["name"]);
                    $profile_photo = $profile["name"];
                } else {
                    $profile_photo = "default_profile.jpg";
                }

                $query = "INSERT INTO users (profile, name, email, password, created_at) VALUES (:profile, :name, :email, :password, NOW())";
                $statement = $this->db->prepare($query);
                $statement->execute([
                    ":profile" => $profile_photo,
                    ":name" => $name,
                    ":email" => $email,
                    ":password" => $hash_password,
                ]);
                $_SESSION["success"] = "Sign up successfully. Please login.";
            }

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function update(array $data): bool|null
    {
        try {
            session_start();
            $auth = $_SESSION["user"];
            $id = $auth->id;
            $isUpdated = false;
            $error = [];
            $this->load($data);

            if ($data["action"] === "edit_profile") {
                $profile = $data["profile"];
                $name = HTML::purify($this->name);
                $email = HTML::purify($this->email);

                if (isset($profile) && $profile["error"] !== UPLOAD_ERR_NO_FILE) {
                    if ($profile["type"] !== "image/jpeg" && $profile["type"] !== "image/png" && $profile["type"] !== "image/gif") {
                        $error[] = "Only JPEG, PNG or GIF images are allowed.";
                    } else if ($profile["size"] > 3145728) {
                        $error[] = "Image file size is too large.";
                    }

                    if ($profile["error"] !== UPLOAD_ERR_OK) {
                        $error[] = "There is a problem while uploading image.";
                    }
                }

                if (empty($name) || empty($email)) {
                    $error[] = "Please fill up all fields.";
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)) {
                    $error[] = "Email is invalid.";
                }

                $_SESSION["error"] = $error;

                if (count($error) === 0) {
                    if (isset($profile) && $profile["error"] !== UPLOAD_ERR_NO_FILE) {
                        move_uploaded_file($profile["tmp_name"], __DIR__ . "/../assets/images/profiles/" . $profile["name"]);
                        $profile_photo = $profile["name"];

                        $statement = $this->db->prepare("UPDATE users SET profile=:profile, updated_at=NOW() WHERE id=:id");
                        $statement->execute([
                            ":profile" => $profile_photo,
                            ":id" => $id,
                        ]);
                    }

                    $query = "UPDATE users SET name=:name, email=:email, updated_at=NOW() WHERE id=:id";
                    $statement = $this->db->prepare($query);
                    $statement->execute([
                        ":name" => $name,
                        ":email" => $email,
                        ":id" => $id,
                    ]);

                    $query = "SELECT * FROM users WHERE id=:id";
                    $statement = $this->db->prepare($query);
                    $statement->execute([
                        ":id" => $id,
                    ]);
                    $user = $statement->fetch();

                    $_SESSION["user"] = $user;
                    $_SESSION["success"] = "Profile is updated successfully.";

                    if ($statement->rowCount()) {
                        $isUpdated = true;
                    }
                }
            } else if ($data["action"] === "change_password") {
                $password = HTML::purify($this->password);
                $new_password = HTML::purify($this->new_password);
                $hash_password = password_hash($new_password, PASSWORD_BCRYPT);
                $confirm_password = HTML::purify($this->confirm_password);

                if (empty($password) || empty($new_password) || empty($confirm_password)) {
                    $error[] = "Please fill up all fields.";
                }

                if (!empty($new_password) && strlen($new_password) < 6) {
                    $error[] = "New password must be at least 6 characters.";
                }

                if ($new_password !== $confirm_password) {
                    $error[] = "The two new passwords do not match.";
                }

                if (!empty($password) && !password_verify($password, $auth->password)) {
                    $error[] = "Old password is incorrect.";
                }

                $_SESSION["error"] = $error;

                if (count($error) === 0) {
                    $statement = $this->db->prepare("UPDATE users SET password=:password, updated_at=NOW() WHERE id=:id");
                    $statement->execute([
                        ":password" => $hash_password,
                        ":id" => $id,
                    ]);

                    $query = "SELECT * FROM users WHERE id=:id";
                    $statement = $this->db->prepare($query);
                    $statement->execute([
                        ":id" => $id,
                    ]);
                    $user = $statement->fetch();

                    $_SESSION["user"] = $user;
                    $_SESSION["success"] = "Password is updated successfully.";

                    if ($statement->rowCount()) {
                        $isUpdated = true;
                    }
                }
            }

            return $isUpdated;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function login(array $data): bool|null
    {
        try {
            session_start();
            $error = [];
            $isCorrect = false;
            $this->load($data);

            $email = HTML::purify($this->email);
            $password = HTML::purify($this->password);

            if (empty($email) || empty($password)) {
                $error[] = "Please fill up all fields.";
            }

            $query = "SELECT * FROM users WHERE email=:email";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ":email" => $email,
            ]);
            $user = $statement->fetch();

            if (password_verify($password, $user->password)) {
                $_SESSION["user"] = $user;
                $_SESSION["success"] = "Login successfully.";
                $isCorrect = true;
            } else {
                if (!empty($email) && !empty($password)) {
                    $error[] = "Wrong username and password.";
                    $isCorrect = false;
                }
            }

            $_SESSION["error"] = $error;

            return $isCorrect;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function cart(array $data)
    {
        try {
            session_start();

            if (!isset($_SESSION["cart"])) {
                $_SESSION["cart"] = [];
            }

            $statement = $this->db->prepare("SELECT * FROM products WHERE id=:id");
            $statement->execute([
                "id" => $data["id"]
            ]);
            $product = $statement->fetch();

            if (isset($_SESSION["cart"][$data["id"]])) {
                $_SESSION["cart"][$data["id"]]["qty"] = $_SESSION["cart"][$data["id"]]["qty"] + $data["qty"];
            } else {
                $_SESSION["cart"][$data["id"]] = [
                    "id" => $product->id,
                    "code" => $product->code,
                    "image" => $product->image,
                    "name" => $product->name,
                    "details" => $product->details,
                    "price" => $product->price,
                    "stock" => $product->stock,
                    "category_id" => $product->category_id,
                    "qty" => $data["qty"],
                ];
            }

            $_SESSION["success"] = "Product is inserted into cart successfully.";
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function wishlist(array $data)
    {
        try {
            $user_id = $data["user_id"];
            $product_id = $data["product_id"];
            $status = $data["status"];

            $statement = $this->db->prepare("SELECT * FROM wishlists WHERE user_id=:user_id AND product_id=:product_id");
            $statement->execute([
                "user_id" => $user_id,
                "product_id" => $product_id,
            ]);
            $wishlist = $statement->fetch();

            if (!$wishlist) {
                $statement = $this->db->prepare("INSERT INTO wishlists (user_id, product_id, status, created_at) VALUES (:user_id, :product_id, :status, NOW())");
                $statement->execute([
                    ":user_id" => $user_id,
                    ":product_id" => $product_id,
                    ":status" => $status,
                ]);
            } else {
                if ($wishlist->status == 1) {
                    $statement = $this->db->prepare("UPDATE wishlists SET status=0,
                    updated_at=NOW() WHERE user_id=:user_id AND product_id=:product_id");
                    $statement->execute([
                        "user_id" => $user_id,
                        "product_id" => $product_id,
                    ]);
                } else {
                    $statement = $this->db->prepare("UPDATE wishlists SET status=1,
                    updated_at=NOW() WHERE user_id=:user_id AND product_id=:product_id");
                    $statement->execute([
                        "user_id" => $user_id,
                        "product_id" => $product_id,
                    ]);
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getWishlistProductByUser(): array|bool|null
    {
        try {
            session_start();
            $auth = $_SESSION["user"];
            $user_id = $auth->id;
            $statement = $this->db->prepare("SELECT * FROM wishlists LEFT JOIN products ON products.id=wishlists.product_id WHERE wishlists.user_id=:user_id AND wishlists.status=1");
            $statement->execute([
                "user_id" => $user_id,
            ]);
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getAll(): ?array
    {
        try {
            $statement = $this->db->query("SELECT * FROM users ORDER BY id DESC");
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getFilteredUsers(string $value): ?array
    {
        try {
            $result = [];

            if ($value) {
                $search_value = urldecode($value);
                $statement = $this->db->prepare("SELECT * FROM users WHERE email LIKE :keyword ORDER BY id DESC");
                $statement->execute([
                    "keyword" => "%$search_value%"
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