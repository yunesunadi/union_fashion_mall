<?php

namespace App;

include(__DIR__ . "/vendor/autoload.php");

use PDO;
use PDOException;

class Database
{
    private $db;
    public function __construct(
        private string $db_host = "localhost",
        private string $db_username = "root",
        private string $db_name = "union_fashion_mall",
        private string $db_password = "",
    ) {
        $this->db = null;
    }

    public function connect()
    {
        try {
            $this->db = new PDO(
                "mysql:host=$this->db_host;
                dbname=$this->db_name",
                $this->db_username,
                $this->db_password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]
            );
            return $this->db;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}