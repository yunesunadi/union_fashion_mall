<?php

$value = $_GET["controller"];

switch ($value) {
    case "home":
        include("./views/home.php");
        break;
    case "aboutus":
        include("./views/aboutus.php");
        break;
    case "contactus":
        include("./views/contactus.php");
        break;
    case "admin": {
        $controller = "AdminController";
        $model = "Admin";
    }
        break;
    case "products": {
        $controller = "ProductController";
        $model = "Product";
    }
        break;
    case "users": {
        $controller = "UserController";
        $model = "User";
    }
        break;
    case "feedbacks": {
        $controller = "FeedbackController";
        $model = "Feedback";
    }
        break;
    default: {
        include("views/404.php");
        exit();
    }
}

if ($value !== "home" && $value !== "aboutus" && $value !== "contactus") {
    $action = $_GET["action"] ?? "";
    $id = $_GET["id"] ?? "";

    $model_file = "Models/$model.php";
    if (file_exists($model_file) && !is_dir($model_file)) {
        include($model_file);
    } else {
        exit("Model not found -> $model_file");
    }

    $controller_file = "Controllers/$controller.php";
    if (file_exists($controller_file) && !is_dir($controller_file)) {
        include($controller_file);
    } else {
        exit("Controller not found -> $controller_file");
    }
}