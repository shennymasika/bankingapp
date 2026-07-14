<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit</title>
    <link rel="stylesheet" href="styles/bankstyle.css">
</head>
<body>
    <?php
    require_once "config.php";
    include_once "includes/header.php";
    include_once "user.php";

    // include_once "includes/bankappsidebar.php";

    $account_id = isset($_POST['account_id']) ? $_POST['account_id'] : (isset($_GET['account_id']) ? $_GET['account_id'] : '');
    ?>

    <form action="" method="POST">
        <input type="hidden" name="account_id" value="<?php echo htmlspecialchars($account_id, ENT_QUOTES, 'UTF-8'); ?>">
        <input type="number" step="0.01" min="0.01" name="amount" placeholder="amount" required>
        <button type="submit">Deposit</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $db = new Database();
        $conn = $db->connect();

        $amount_raw = isset($_POST['amount']) ? trim($_POST['amount']) : '';
        $account_id_raw = isset($_POST['account_id']) ? trim($_POST['account_id']) : '';

        $amount = is_numeric($amount_raw) ? (float) $amount_raw : false;
        $account_id = ctype_digit($account_id_raw) ? (int) $account_id_raw : false;

        if ($amount !== false && $amount > 0 && $account_id !== false && $account_id > 0) {
            $stmt = $conn->prepare("UPDATE account SET balance = balance + ? WHERE id = ?");
            $stmt->bind_param("di", $amount, $account_id);

            if ($stmt->execute()) {
                echo "Deposit successful!";
            } else {
                echo "Deposit failed.";
            }
        } else {
            echo "Invalid deposit details.";
        }
    }
    ?>
</body>
</html>