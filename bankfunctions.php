<?php

require_once 'config.php';

function loadAccountByNumber(PDO $conn, $accountNumber) {
    $stmt = $conn->prepare(
        "SELECT a.*, ty.account_type
         FROM account a
         JOIN account_type ty ON a.account_typeID = ty.id
         WHERE a.account_number = :num"
    );
    $stmt->execute([':num' => $accountNumber]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) { throw new Exception("Account not found."); }

    if ($row['account_type'] === 'Savings') {
        $account = new Savings($row['account_number'], $row['user_id'], $row['balance']);
    } else if{
        $account = new Current($row['account_number'], $row['user_id'], $row['balance']);
    } else {
        $account = new fixed Deposit($row['account_number'], $row['user_id'], $row['balance']);
    }
    return $account;
}
?>