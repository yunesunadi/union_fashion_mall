<?php

namespace App\Helpers;

class HTTP
{
    static string $folder = "/union_fashion_mall";

    static function redirect(string $url, string $query = "")
    {
        $full_url = static::$folder . $url;
        if ($query)
            $full_url .= "?$query";
        header("Location: $full_url");
        exit();
    }

    static function link(string $url): string
    {
        return static::$folder . $url;
    }

    static function sortByLink(string $value): string
    {
        if (isset($_GET["category"]) || isset($_GET["gender"]) || isset($_GET["search"])) {
            $urlParts = parse_url($_SERVER["REQUEST_URI"]);
            $query = isset($urlParts["query"]) ? $urlParts["query"] : "";
            parse_str($query, $queryParams);
            $queryParams["sortby"] = $value;
            $newQuery = http_build_query($queryParams);
            $newUrl = $urlParts["path"] . "?" . $newQuery;
        } else {
            $newUrl = static::$folder . "/products/filter?sortby=" . $value;
        }

        return $newUrl;
    }
}