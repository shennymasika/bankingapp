<?php

class Database
{
    private $host = "localhost";
    private $dbname = "bank_app";
    private $username = "root";
    private $password = "";

    public $conn;

    public function connect()
    {
        try {

            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $this->conn;

        } catch (PDOException $e) {

            die("Database Connection Failed: " . $e->getMessage());

        }
    }

    public function __destruct()
    {
        $this->conn = null;
    }
}

$db = new Database();
$pdo = $db->connect();

?>