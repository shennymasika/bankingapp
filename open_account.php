<?php
session_start();

require_once "config.php";
include_once "includes/header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION['user_id'];
    $accountTypeID = (int)$_POST['account_type'];

    try {

        // Check if the user already has an account
        $stmt = $pdo->prepare("
            SELECT id
            FROM account
            WHERE user_id = :user_id
        ");

        $stmt->execute([
            ':user_id' => $user_id
        ]);

        if ($stmt->fetch()) {

            $message = "You already have a bank account.";

        } else {

            // Generate a unique 12-digit account number
            do {

                $accountNumber = mt_rand(100000000, 999999999)
                               . mt_rand(100, 999);

                $check = $pdo->prepare("
                    SELECT id
                    FROM account
                    WHERE account_number = :account_number
                ");

                $check->execute([
                    ':account_number' => $accountNumber
                ]);

            } while ($check->fetch());

            // Create account
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

            $message = "Account created successfully!<br>
                        Account Number: <strong>$accountNumber</strong>";

        }

    } catch (PDOException $e) {

        $message = "Error: " . $e->getMessage();

    }

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Open Bank Account</title>

<link rel="stylesheet" href="styles/bankstyle.css">

</head>

<body>

<h2>Open a Bank Account</h2>

<p style="color:green;">
<?= $message ?>
</p>

<form method="POST">

<label>Select Account Type</label>

<br><br>

<select name="account_type" required>

    <option value="">-- Select --</option>

    <option value="1">Current Account</option>

    <option value="2">Savings Account</option>

    <option value="3">Fixed Deposit</option>

    <option value="4">Money Market</option>

</select>

<br><br>

<button type="submit">

Create Account

</button>

</form>

</body>

</html>