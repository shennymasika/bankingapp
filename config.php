<?php
// $conn = new mysqli("localhost","root","","bank_app");

// if ($conn->connect_error){
//     die("Connection failed:" . $conn->connect_error);
// }
class Database{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "bank_app";

    public $conn;

    public function connect(){
        $this->conn = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database,
        );

        return $this->conn;
    }
}

?>
