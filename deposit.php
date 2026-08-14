<?php

session_start();

require_once "config.php";
require_once "transaction.php";

include_once 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);

    if ($amount === false || $amount <= 0) {

        $message = "Invalid deposit amount.";

    } else {

        try {

            $pdo->beginTransaction();

            // Find the logged-in user's account
            $stmt = $pdo->prepare("
                SELECT id, balance
                FROM account
                WHERE user_id = :user_id
                AND status = 'active'
                LIMIT 1
            ");

            $stmt->execute([
                ':user_id' => $user_id
            ]);

            $account = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$account) {

                throw new Exception("No active bank account found.");

            }

            // Update balance
            $stmt = $pdo->prepare("
                UPDATE account
                SET balance = balance + :amount
                WHERE id = :account_id
            ");

            $stmt->execute([
                ':amount' => $amount,
                ':account_id' => $account['id']
            ]);

            // Record transaction
            $transaction = new Transaction(
                $account['id'],
                Transaction::DEPOSIT,
                $amount,
                'Cash deposit'
            );

            $reference = $transaction->save($pdo);

            // Finish transaction
            $pdo->commit();

            $message = "Deposit successful! Reference: " . $reference;

        } catch (Exception $e) {

            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            $message = "Deposit failed: " . $e->getMessage();
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

    <title>Deposit</title>

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

<h2>Deposit Money</h2>

<?php if ($message): ?>

    <p>
        <?= htmlspecialchars($message) ?>
    </p>

<?php endif; ?>

<form method="POST">

    <input
        type="number"
        name="amount"
        step="0.01"
        min="0.01"
        placeholder="Amount"
        required
    >

    <button type="submit">
        Deposit
    </button>

</form>

<br>

<a href="dashboard.php">Back</a>

<?php include_once 'includes/footer.php'; ?>

</body>
</html>