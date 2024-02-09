<?php

namespace App\Models;

include(__DIR__ . "/../vendor/autoload.php");

use App\Database;
use PDOException;
use App\Helpers\HTML;

class Feedback
{
    public string $name;
    public string $email;
    public string $phone_no;
    public string $subject;
    public string $detailed_message;
    public $db = null;

    public function __construct(Database $db)
    {
        $this->db = $db->connect();
    }

    public function load(array $data)
    {

        $this->name = $data["name"] ?? "";
        $this->email = $data["email"] ?? "";
        $this->phone_no = $data["phone_no"] ?? "";
        $this->subject = $data["subject"] ?? "";
        $this->detailed_message = $data["detailed_message"] ?? "";
    }

    public function create(array $data): ?string
    {
        try {
            session_start();
            $error = [];
            $this->load($data);

            $name = HTML::purify($this->name);
            $email = HTML::purify($this->email);
            $phone_no = HTML::purify($this->phone_no);
            $subject = HTML::purify($this->subject);
            $detailed_message = HTML::purify($this->detailed_message);

            if (empty($name) || empty($email) || empty($phone_no) || empty($subject) || empty($detailed_message)) {
                $error[] = "Please fill up all fields.";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)) {
                $error[] = "Email is invalid.";
            }

            if (!is_numeric($phone_no) && !empty($phone_no)) {
                $error[] = "Phone number is invalid.";
            }

            $_SESSION["error"] = $error;

            if (count($error) === 0) {
                $query = "INSERT INTO feedbacks (name, email, phone_no, subject, detailed_message, created_at) VALUES (:name, :email, :phone_no, :subject, :detailed_message, NOW())";
                $statement = $this->db->prepare($query);
                $statement->execute([
                    ":name" => $name,
                    ":email" => $email,
                    ":phone_no" => $phone_no,
                    ":subject" => $subject,
                    ":detailed_message" => $detailed_message,
                ]);
                $_SESSION["success"] = "You've sent feedback successfully.";
            }

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getAll(): ?array
    {
        try {
            $statement = $this->db->query("SELECT * FROM feedbacks ORDER BY id DESC");
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
}