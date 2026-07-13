<?php
class User {
    private $id;
    private $username;
    private $passwordHash;
    public $firstName;
    public $lastName;
    public $email;

    public function __construct($username, $firstName = null, $lastName = null, $email = null) {
        $this->username  = $username;
        $this->firstName = $firstName;
        $this->lastName  = $lastName;
        $this->email     = $email;
    }

    public function setPassword($plainPassword) {
        $this->passwordHash = password_hash($plainPassword, PASSWORD_DEFAULT);
    }

    public function verifyPassword($plainPassword) {
        return password_verify($plainPassword, $this->passwordHash);
    }

    public function register(PDO $conn) {
        $stmt = $conn->prepare(
            "INSERT INTO users (username, password, first_name, last_name, email)
             VALUES (:username, :password, :first_name, :last_name, :email)"
        );
        $stmt->execute([
            ":username"   => $this->username,
            ":password"   => $this->passwordHash,
            ":first_name" => $this->firstName,
            ":last_name"  => $this->lastName,
            ":email"      => $this->email,
        ]);
        $this->id = $conn->lastInsertId();
        return $this->id;
    }

    public function getId() {
        return $this->id;
    }
}
?>
