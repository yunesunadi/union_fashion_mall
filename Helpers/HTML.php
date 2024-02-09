<?php

namespace App\Helpers;

include(__DIR__ . "/../vendor/autoload.php");

use HTMLPurifier_Config;
use HTMLPurifier;

class HTML
{
    static function purify(string $dirty_html): string
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        return $purifier->purify($dirty_html);
    }

    static function imgsrc(string $image): string
    {
        return "data:image/mime;base64," . base64_encode(file_get_contents("assets/images/$image"));
    }
}