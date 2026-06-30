<?php
session_start();
include_once 'config.php';
include_once 'includes/header.php';
include_once 'includes/bankappsidebar.php';


if($_SERVER['REQUEST_METHOD'] =='POST'){
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
    }
    else{
        echo "Invalid login";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bankingapp - login</title>
     <link rel="stylesheet" href="styles/bankstyle.css">
</head>
<body>
 <form method = "POST">
    <input type="text" name="username" placeholder="Username"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <button type="submit">login</button>
 </form> 
 <?php
 include_once 'includes/footer.php';
 ?>
</body>
</html>
