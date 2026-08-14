<?php
// admin_guard.php

// session_start();
if (session_status() === PHP_SESSION_NONE){
    session_start();
}
require_once 'config.php'; // PDO connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || $user['role'] !== 'admin') {
    http_response_code(403);
    die("Access denied: Admin role required.");
}
?>