<?php

namespace App\Controllers;

include(__DIR__ . "/../vendor/autoload.php");
use App\Helpers\HTTP;
use App\Database;
use App\Models\Feedback;

$feedback_controller = new FeedbackController;

switch ($action) {
    case "create":
        $feedback_controller->create();
        break;
    default:
        exit("Unknown action -> $action");
}

class FeedbackController
{
    public Feedback $feedback;

    public function __construct()
    {
        $this->feedback = new Feedback(new Database);
    }

    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = [
                "name" => trim($_POST["name"]),
                "email" => trim($_POST["email"]),
                "phone_no" => trim($_POST["phone_no"]),
                "subject" => trim($_POST["subject"]),
                "detailed_message" => trim($_POST["detailed_message"]),
            ];
            $this->feedback->create($data);
            HTTP::redirect("/contactus");
        }
    }
}