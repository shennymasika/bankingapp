<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <link rel="stylesheet" href="styles/bankstyle.css">
</head>
<body>
    <button id="toggleBtn">Menu</button>
    <section class="Menu" id="Menu">
        <button class="close_button" id="closeBtn">X</button>
        <p>Dashboard</p>
        <nav>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
            <a href="transfer.php">Transfer</a>
            <a href="transfer.php">Deposit</a>
        </nav>

    </section>
    <script>
        const btn =document.getElementById("toggleBtn");
        const Menu=document.getElementById("Menu");

         btn.addEventListener('click', () =>{
            Menu.classList.toggle('is-open');
        });
        closeBtn.addEventListener('click', () =>{
            Menu.classList.remove('is-open');
        });
    </script>
</body>
</html>