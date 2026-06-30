<?php
session_start(); #start the sesson to access user data. This should be at the very top of
#the file before any HTML or output sent to the browser.
include 'config.php'; #check if user is logged in
include_once 'header.php';
include_once 'bankappsidebar.php';

#if the request method is POST,it means the form has been submitted and we 
#need to process the transfer
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # get from data and sender ID from the session to perform the transfer
    $to_user = $_POST['to_user'];
    $amount = $_POST['amount'];
    $from_id = $_SESSION['user_id'];

    //get sender balance
    $sender = $conn->query("SELECT * FROM users WHERE id=$from_id")->fetch_assoc();

    if ($sender['balance'] >= $amount) {

        //Deduct sender
        $conn->query("UPDATE users SET balance = balance - $amount WHERE id=$from_id");

        //add receiver
        $conn->query("UPDATE users SET balance = balance + $amount WHERE username='$to_user'");

        echo "Transfer successfull !";
    } else{
        echo "insufficient balance !";
    }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bankingapp - Transfer</title>
    <link rel="stylesheet" href="styles/bankstyle.css">
</head>
<body>
    <form method="POST">
        <input type="text" name="to_user" placeholder="Receiver Username"><br>
        <input type="number" name="amount" placeholder="amount"><br>
        <button type="submit">Send</button>
    </form>
</body>
</html>
