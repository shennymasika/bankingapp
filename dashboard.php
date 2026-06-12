<?php
session_start(); #start the session to access the user data. This should be at the verry top
#of the file before any HTML or output is sent to the browser.

include 'config.php'; #checks if user is logged in

if(!isset($_SESSION['user_id'])) {#if user_id is not set in the session, 
#it means the user is not logged in.
    header("Location: login.php"); #Redirect user to the login page.
    exit(); #Exit the script to prevent further execution.
}

#Get the user ID from the session to fetch user data from the database.
$user_id = $_SESSION['user_id'];
# Execute a SQL query te select all columns from the 'users' table where the 'id'
#matches the user ID from the session.
$result = $conn->query("SELECT * FROM users WHERE id=$user_id");
#Fetch the result as an associative array and store it in the $user
#variable for later use in displaying user information on the dashboard.
$user = $result->fetch_assoc();
?>

<h2>Welcome, <?php echo $user['username']; ?></h2>
<!-- displays a welcome message with the users username, which is 
retrieved from the $user associative array. The balance is displayed within a <p>
HTML tag and formatted as currency within a dollar sign -->
<p>Balance: $<?php echo $user['balance'];?></p>
<p>Balance: $<?php echo $user['balance']; ?></p> <!--
Display the user's current balance, which is also retrieved from the $user associative array.
The balance is displayed within a <p> HTML tag and formatted as currency with a dollar sign.-->

<a href="transfer.php">Transfer Money</a> <!--Provide a link to the transfer page 
where the user can initiate a money transfer.
 The link is created using an <a> HTML tag, and it points to 'transfer.php'.-->
<a href="logout.php">Logout</a> <!--Provide a link to log out of the dashboard. 
The link is created using an <a> HTML tag, and it points to 'logout.php', 
which will handle the logout process by destroying the session 
and redirecting the user to the login page.-->
 

   