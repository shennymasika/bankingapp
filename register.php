<?php
// register.php

require_once "config.php";
include_once 'includes/header.php';
// include_once 'includes/bankappsidebar.php';

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username  = trim($_POST['username']);
    $firstName = trim($_POST['first_name']);
    $lastName  = trim($_POST['last_name']);
    $email     = trim($_POST['email']);
    $password  = $_POST['password'];

    if (
        empty($username) ||
        empty($firstName) ||
        empty($lastName) ||
        empty($email) ||
        empty($password)
    ) {

        $message = "All fields are required!";

    } else {

        try {

            // Start database transaction
            $pdo->beginTransaction();

            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert user
            $stmt = $pdo->prepare("
                INSERT INTO users
                (username, first_name, last_name, email, password)
                VALUES
                (:username, :first_name, :last_name, :email, :password)
            ");

            $stmt->execute([
                ':username'   => $username,
                ':first_name' => $firstName,
                ':last_name'  => $lastName,
                ':email'      => $email,
                ':password'   => $hashedPassword
            ]);

            // Get new user ID
            $user_id = $pdo->lastInsertId();

            // Generate account number
            $accountNumber = rand(100000000000, 999999999999);

            // Default account type
            $accountTypeID = 1;

            // Create bank account
            $stmt = $pdo->prepare("
                INSERT INTO account
                (
                    account_number,
                    account_typeID,
                    balance,
                    user_id,
                    status
                )
                VALUES
                (
                    :account_number,
                    :account_typeID,
                    :balance,
                    :user_id,
                    :status
                )
            ");

            $stmt->execute([
                ':account_number' => $accountNumber,
                ':account_typeID' => $accountTypeID,
                ':balance' => 0.00,
                ':user_id' => $user_id,
                ':status' => 'active'
            ]);

            // Save everything
            $pdo->commit();

            $message = "✅ Registration successful!<br>" .
                        "Your User ID Is: $user_id<br>" .
                        "Your Account Number Is: $accountNumber";

        } catch (PDOException $e) {

            $pdo->rollBack();

            $message = "❌ Error: " . $e->getMessage();

        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Banking System - Register</title>
    <link rel="stylesheet" href="styles/bankstyle.css">
</head>

<body>
        <style>
        body > a {
            display: block;
            width: 700px;
            max-width: 100%;
            margin-top: 15px;
            padding: 15px 20px;
            background: white;
            color: #1d4ed8;
            text-decoration: none;
            font-weight: bold;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.07);
            transition: 0.2s ease;
        }

/* Hover effect */

body > a:hover {
    background: #1d4ed8;
    color: white;
    transform: translateY(-2px);
}

/* Logout */

body > a[href="logout.php"] {
    color: #dc2626;
}

body > a[href="logout.php"]:hover {
    background: #dc2626;
    color: white;
}

/* Mobile */

@media (max-width: 600px) {

    body {
        padding: 25px 15px;
    }

    body > h2 {
        font-size: 24px;
    }

    body > p {
        padding: 15px;
    }

    body > a {
        width: 100%;
    }
}
    </style>

<p style="color:green;">
    <?= $message?>
</p>

<form method="POST">

    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>First Name:</label><br>
    <input type="text" name="first_name" required><br><br>

    <label>Last Name:</label><br>
    <input type="text" name="last_name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Register</button>

</form>
<a href="index.php">Back</a>

<?php include_once 'includes/footer.php'; ?>

</body>
</html>