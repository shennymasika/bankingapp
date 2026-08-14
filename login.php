<?php

session_start();

require_once 'config.php';
require_once 'user.php';

include_once 'includes/header.php';
// include_once 'includes/bankappsidebar.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {

        $message = "Please enter your username and password.";

    } else {

        try {

            // Find the user using PDO
            $stmt = $pdo->prepare("
                SELECT id, username, password, role
                FROM users
                WHERE username = :username
                LIMIT 1
            ");

            $stmt->execute([
                ':username' => $username
            ]);

            // Get the user from the database
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check that the user exists and password is correct
            if ($user && password_verify($password, $user['password'])) {

                // Store user information in the session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Redirect according to role
                if ($user['role'] === 'admin') {

                    header("Location: admin_dashboard.php");
                    exit();

                } elseif ($user['role'] === 'teller') {

                    header("Location: teller_dashboard.php");
                    exit();

                } else {

                    header("Location: dashboard.php");
                    exit();
                }

            } else {

                $message = "❌ Invalid username or password.";

            }

        } catch (PDOException $e) {

            $message = "Database Error: " . $e->getMessage();

        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Bankingapp - Login</title>

    <link rel="stylesheet"
          href="styles/bankstyle.css">

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

<h2>Login</h2>

<?php if (!empty($message)): ?>

    <p style="color:red;">
        <?= htmlspecialchars($message) ?>
    </p>

<?php endif; ?>

<form method="POST">

    <input
        type="text"
        name="username"
        placeholder="Username"
        required
    >

    <br><br>

    <input
        type="password"
        name="password"
        placeholder="Password"
        required
    >

    <br><br>

    <button type="submit">
        Login
    </button>
    

</form>
<a href="index.php">Back</a>

<?php include_once 'includes/footer.php'; ?>

</body>
</html>