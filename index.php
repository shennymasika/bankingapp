<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monetary World Bank</title>
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
     <!-- <script src="https://fontawesome.com" crossorigin="anonymous"></script> -->
</head>
<body>
    <header>
        <nav class="navbar">
            <h2>Monetary World Bank</h2>
            <a href="#"><i class="fa-solid fa-house"></i> Home</a>
            <a href="#"><i class="fa-solid fa-address-card"></i> contacts</a> 
            <a href="#"><i class="fa-solid fa-book"></i>About</a>  
            <a href="login.php" class="loginbtn">Login</a>
        </nav> 
    </header>
    <section class="coverpagecontent">
            <!-- <div class="slideshow1"></div>
            <div class="slideshow2"></div>
            <div class="slideshow3"></div> -->
            <h1>Start Your Banking Journey With Us.</h1>
            <p>We are a new organisation thats aimed at secure banking without complications. We are not like the rest, we are different. Talk of the best interest rates, and well automated operations!</p>
    </section>
    <section class="cards">
        <div class="card">
            <h3>Secure Banking</h3>
            <p>Your funds are protected by modern security technology.</p>
        </div>
        <div class="card">
            <h3>Fast Transactions</h3>
            <p>Transfer money instantly at anytime.</p>
        </div>
        <div class="card">
            <h3>24/7 Customer Support</h3>
            <p>Our customer service team is always ready to help.</p>
        </div>
    </section> 
    <footer>
        <div class="footer-links">
            <h3>Contact Us:</h3>
            <p><i class="fa-solid fa-location-dot"></i> Mombasa, Kenya</p>
            <p><i class="fa-solid fa-address-card"></i> +254731003019</p>
            <p><i class="fa-solid fa-envelope"></i>monetarybank@gmail.com</p>
            <p class="copyright">
            © 2026 Monetary Bank. All Rights Reserved.
            </p>
        </div>

    </footer>
    <script>
        (function(){
            var images = [
                'bankimages/bankbuilding.jpg',
                'bankimages/bankglassbuilding.jpg',
                'bankimages/banksidebar.jpg'
            ];
            var nextimage = 0;
            var el = document.querySelector('.coverpagecontent');
            if (!el) return;
            el.style.backgroundImage = 'url("' + images[0] + '")';
            el.style.opacity = 1;
            el.style.transition = 'opacity 0.5s ease';

            function doSlideshow(){
                el.style.opacity = 0;
                setTimeout(function(){
                    nextimage = (nextimage + 1) % images.length;
                    // nextimage++ % images.length;
                    el.style.backgroundImage = 'url("' + images[nextimage] + '")';
                    el.style.opacity = 1;
                }, 100);
            }

            setInterval(doSlideshow, 5000);
        })();
    </script>
</body>
</html>
