<?php

namespace App\Helpers;

class Auth
{
    static function check(): ?object
    {
        if (!isset($_SESSION))
            session_start();
        return $_SESSION["user"] ?? null;
    }

    static function strictCheck(): object
    {
        if (!isset($_SESSION))
            session_start();

        if (isset($_SESSION["user"])) {
            return $_SESSION["user"];
        } else {
            HTTP::redirect("/");
        }
    }

    static function adminCheck(): ?bool
    {
        if (!isset($_SESSION))
            session_start();
        if (isset($_SESSION["admin_auth"])) {
            return $_SESSION["admin_auth"];
        } else {
            HTTP::redirect("/");
        }
    }
}