<?php
require 'Database.php';
require 'User.php';
require 'Account.php';
require 'SavingsAccount.php';
require 'CurrentAccount.php';
require 'Transaction.php';

$db = new Database();    // constructor opens PDO (PHP Data Objects (PDO) connection
$conn = $db->conn;

// 1. Register a customer
$user = new User('Shenny.masika', 'Shenny', 'Masika', 'shennymasika200@gmail.com');
$user->setPassword('SecurePass123');
$userId = $user->register($conn);

// 2. Open two accounts (inheritance in action)
$savings = new SavingsAccount('SA-0001', $userId, 5000.00);
$current = new CurrentAccount('CA-0001', $userId, 2000.00);

// 3. Deposit into savings
$savings->deposit(1500.00);
echo "Savings balance: " . $savings->getBalance() . "\n"; // 6500.00

// 4. Transfer from savings to current (polymorphic withdraw/deposit calls)
$reference = transferFunds($conn, $savings, $current, 1000.00, 'Move to current for bills');
echo "Transfer complete. Reference: $reference\n";

// 5. Apply interest (each account type behaves differently — polymorphism)
echo "Savings interest earned: " . $savings->applyInterest() . "\n";
echo "Current interest earned: " . $current->applyInterest() . "\n"; // 0, current accounts earn none

// $db goes out of scope here -> __destruct() closes the connection automatically
?>
