<!-- admin_dashboard.php -->
<?php
session_start();

require_once 'admin_guard.php';
require_once 'config.php';      // PDO connection
require_once 'user.php';
include_once 'transaction.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("location: login.php");
    exit();
}

$admin = new Admin($_SESSION['user_id']);

$users = $admin->getAllUsers($pdo);
$transactions = $admin->getAllTransactions($pdo);
?>

<h2>All Users</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Action</th>
    </tr>

    <?php foreach ($users as $u): ?>

    <tr>
        <td><?= htmlspecialchars($u['id']) ?></td>
        <td><?= htmlspecialchars($u['username']) ?></td>
        <td><?= htmlspecialchars($u['first_name'] . ' ' . $u['last_name']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= htmlspecialchars($u['role']) ?></td>

        <td>
            <form action="delete_user.php" method="POST"
                  onsubmit="return confirm('Delete this user?');">

                <input type="hidden" name="user_id"
                       value="<?= htmlspecialchars($u['id']) ?>">

                <button type="submit">Delete</button>

            </form>
        </td>
    </tr>

    <?php endforeach; ?>

</table>

<br><br>
<a href="open_account.php">Open New Account</a><br><br>

<h2>All Transactions</h2>

<table border="1">

<tr>
    <th>Reference</th>
    <th>Account</th>
    <th>To Account</th>
    <th>Type</th>
    <th>Amount</th>
    <th>Date</th>
</tr>

<?php foreach ($transactions as $t): ?>

<tr>

    <td><?= htmlspecialchars($t['reference']) ?></td>

    <td><?= htmlspecialchars($t['account_id']) ?></td>

    <td><?= htmlspecialchars($t['to_account_id'] ?? '-') ?></td>

    <td><?= htmlspecialchars($t['transaction_type']) ?></td>

    <td><?= number_format($t['amount'], 2) ?></td>

    <td><?= htmlspecialchars($t['transaction_date']) ?></td>

</tr>

<?php endforeach; ?>

</table>