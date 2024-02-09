<?php

namespace App;

require_once(__DIR__ . "/mvc.php");

class Router
{
    function render(string $file, string $title, $params = [])
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        $folder = strtolower($_GET["controller"]);
        $view_file = "views/$folder/$file.php";
        if (file_exists($view_file) && !is_dir($view_file)) {
            $view = $view_file;
            include("index.php");
        } else {
            exit("View not found -> $view_file");
        }
    }
}