<?php
session_start();
require_once 'admin_guard.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
</head>
<body>

<form action="add_user_handler.php" method="POST">

    <input type="text" name="username" placeholder="Username" required>
    <input type="text" name="first_name" placeholder="First Name" required>
    <input type="text" name="last_name" placeholder="Last Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Temporary Password" required>

    <select name="role">
        <option value="customer">Customer</option>
        <option value="teller">Teller</option>
        <option value="admin">Admin</option>
    </select>

    <button type="submit">Add User</button>

</form>

</body>
</html>