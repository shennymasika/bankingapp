<?php
//database connection
require_once "config.php";
include_once 'includes/header.php';
include_once 'includes/bankappsidebar.php';


$message = "";

//handle from submission

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $firstName = $_POST['first_name'];
    $lastName  = $_POST['last_name'];
    $email     = $_POST['email'];
    $password  = $_POST['password'];

    //validation that all fields are filled out before completeing registration

    $db = new Database();
    $conn = $db->connect();

    if (empty($username) || empty($firstName) || empty($lastName) || empty($email) || empty($password)){
        $message = "All fields are required!";
    } else{

    /*Hash password - this replaces the MD5 hashing we were using before,providing better security
    by using a stronger hashing algorithm and adding a unique salt to each password.*/
    $hashedPassword = password_hash($password,PASSWORD_DEFAULT);

    /*Use prepared statement to prevent SQL injection (SQL injection is a security vulnerability that allows
    attackers to manipulate SQL queries by injecting malicious input.Prepared statements help mitigate the risk
    by separating SQL code from user input)*/
    $stmt = $conn->prepare("INSERT INTO users (username, first_name, last_name, email, password)VALUES (?,?,?,?,?)");
    /*Blind parameters to the prepared statement. The "sssss" string indicates that all five parameters are strings.*/
    $stmt->bind_param("sssss", $username,$firstName,$lastName,$email,$hashedPassword);
    if ($stmt->execute()){
        $message = "✅ Registration successful!";
    }else{
        $message = "❌ Error:".$stmt->error;
    }

    $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Banking System - Register</title>
    <link rel="stylesheet" href="styles/bankstyle.css">
</head>
<body>
    <!-- <h2>Bank Account Registration</h2> -->
    <p style="color:green;"><?php echo $message;?></p>

    <form method="POST" action="">
        <label>Username:</label><br>
        <input type="text" name="username"><br><br>

        <label>First Name:</label><br>
        <input type="text" name="first_name"><br><br>

        <label>Last Name</label><br>
        <input type="text" name="last_name"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email"><br><br>

        <label>Password:</label><br>
        <input type="password" name="password"><br><br>

        <button type="submit">Register</button>
</form>
<?php
include_once 'includes/footer.php'
?>
</body>
</html>