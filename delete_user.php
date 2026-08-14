<?php
// delete_user_handler.php

session_start();

require_once 'admin_guard.php';
require_once 'config.php';
require_once 'user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin = new Admin($_SESSION['user_id']);
    try {
        $admin->deleteUser($pdo, (int) $_POST['user_id']);
        header("Location: admin_dashboard.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>