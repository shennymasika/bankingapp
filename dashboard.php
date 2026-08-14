<?php
session_start();

require_once 'config.php';
include_once 'includes/header.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

try {

    $stmt = $pdo->prepare("
        SELECT
            u.username,
            u.first_name,
            u.last_name,
            a.account_number,
            a.balance
        FROM users u
        LEFT JOIN account a
            ON u.id = a.user_id
        WHERE u.id = :id
    ");

    $stmt->execute([
        ':id' => $user_id
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found.");
    }

} catch (PDOException $e) {
    die("Database Error: " . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    /*BANKING APP - DASHBOARD*/

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    /* font-family: Arial, Helvetica, sans-serif; */
    background: #466b;
    color: #1f2937;
    min-height: 100vh;
    padding: 40px 20px;
}

/* Dashboard container */

body > h2,
body > p,
body > a,
body > br {
    margin-left: auto;
    margin-right: auto;
}

body > h2 {
    max-width: 700px;
    font-size: 30px;
    margin-bottom: 25px;
    color: #172554;
}

/* Account information */

body > p {
    max-width: 700px;
    background: white;
    padding: 18px 22px;
    margin-bottom: 12px;
    border-radius: 10px;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
}

body > p strong {
    color: #374151;
}

/* Account number */

body > p:first-of-type {
    border-left: 5px solid #2563eb;
}

/* Balance */

body > p:nth-of-type(2) {
    border-left: 5px solid #16a34a;
    font-size: 18px;
}

/* No account message */

body > p[style*="red"] {
    border-left: 5px solid #dc2626;
    color: #dc2626 !important;
    background: #fef2f2;
}

/* Dashboard links */

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
</head>
<body>
    

<h2>Welcome, <?= htmlspecialchars($user['username']) ?></h2>

<?php if ($user['account_number'] === null): ?>

    <p style="color:red;">
        No bank account has been created for this user.
    </p>

<?php else: ?>

    <p>
        <strong>Account Number:</strong>
        <?= htmlspecialchars($user['account_number']) ?>
    </p>

    <p>
        <strong>Current Balance:</strong>
        KSh <?= number_format($user['balance'], 2) ?>
    </p>

<?php endif; ?>

<br>


<a href="deposit.php">Deposit Money</a><br><br>

<a href="transfer.php">Transfer Money</a><br><br>

<a href="logout.php">Logout</a>
</body>
</html>