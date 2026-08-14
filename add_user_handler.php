<!-- adduserhandler.php -->
<?php
session_start();

require_once 'admin_guard.php';
require_once 'config.php';   // Your PDO connection
require_once 'user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $admin = new Admin($_SESSION['user_id']);

    $admin->addUser(
        $pdo,
        $_POST['username'],
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['email'],
        $_POST['password'],
        $_POST['role']
    );

    header("Location: admin_dashboard.php");
    exit();
}