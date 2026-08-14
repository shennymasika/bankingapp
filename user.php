<?php

class User
{
    protected $id;
    protected $username;
    protected $passwordHash;
    protected $firstName;
    protected $lastName;
    protected $email;


    public function __construct($username, $firstName = null, $lastName = null, $email = null)
    {
        $this->username  = $username;
        $this->firstName = $firstName;
        $this->lastName  = $lastName;
        $this->email     = $email;
    }

    public function setPassword($plainPassword)
    {
        $this->passwordHash = password_hash($plainPassword, PASSWORD_DEFAULT);
    }

    public function verifyPassword($plainPassword)
    {
        return password_verify($plainPassword, $this->passwordHash);
    }

    public function register(PDO $conn)
    {
        $stmt = $conn->prepare("
            INSERT INTO users
            (username, password, first_name, last_name, email)
            VALUES
            (:username, :password, :first_name, :last_name, :email)
        ");

        $stmt->execute([
            ':username'   => $this->username,
            ':password'   => $this->passwordHash,
            ':first_name' => $this->firstName,
            ':last_name'  => $this->lastName,
            ':email'      => $this->email
        ]);

        $this->id = $conn->lastInsertId();

        return $this->id;
    }

    public function getId()
    {
        return $this->id;
    }
}

class Admin extends User
{

    public function getAllUsers(PDO $conn)
    {
        $stmt = $conn->query("
            SELECT id,
                   username,
                   first_name,
                   last_name,
                   email,
                   role,
                   created_at
            FROM users
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllTransactions(PDO $conn)
    {
        $stmt = $conn->query("
            SELECT
                transaction_id,
                account_id,
                to_account_id,
                transaction_type,
                amount,
                description,
                reference,
                transaction_date
            FROM transaction
            ORDER BY transaction_date DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addUser(
        PDO $conn,
        $username,
        $firstName,
        $lastName,
        $email,
        $password,
        $role
    )
    {

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("
            INSERT INTO users
            (
                username,
                password,
                first_name,
                last_name,
                email,
                role
            )
            VALUES
            (
                :username,
                :password,
                :first_name,
                :last_name,
                :email,
                :role
            )
        ");

        $stmt->execute([
            ':username'   => $username,
            ':password'   => $hash,
            ':first_name' => $firstName,
            ':last_name'  => $lastName,
            ':email'      => $email,
            ':role'       => $role
        ]);

        return $conn->lastInsertId();
    }

    public function deleteUser(PDO $conn, $userId)
    {

        if ($userId == $_SESSION['user_id']) {
            throw new Exception("You cannot delete your own admin account.");
        }

        $stmt = $conn->prepare("
            DELETE FROM users
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $userId
        ]);
    }
}

?>