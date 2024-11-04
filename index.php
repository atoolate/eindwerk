<?php 

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>xD Brewery</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <section class="hero">
            <div class="hero-text">
                <h1>Beer for all</h1>
                <a class="cta" href="catalog.php">Shop All Beer</a>
            </div>
        </section>

        <section class="slider-wrapper" id="collections-slider">
            <div class="slider">
                <div class="collection">
                    <a href="#">
                        <div class="collection-img" src="./images/hero-test.webp" alt="Best Sellers"></div>
                        <h3>Best Sellers</h3>
                    </a>
                </div>
                <div class="collection">
                    <a href="#">
                        <div class="collection-img" src="./images/hero-test.webp" alt="Best Sellers"></div>
                        <h3>Mixed Pack</h3>
                    </a>
                </div>
                <div class="collection">
                    <a href="#">
                        <div class="collection-img" src="./images/hero-test.webp" alt="Best Sellers"></div>
                        <h3>Lager</h3>
                    </a>
                </div>
                <div class="collection">
                    <a href="#">
                        <div class="collection-img" src="./images/hero-test.webp" alt="Best Sellers"></div>
                        <h3>IPA</h3>
                    </a>
                </div>
                <div class="collection">
                    <a href="#">
                        <div class="collection-img" src="./images/hero-test.webp" alt="Best Sellers"></div>
                        <h3>Non-Alcohol</h3>
                    </a>
                </div>
                <div class="collection">
                    <a href="#">
                        <div class="collection-img" src="./images/hero-test.webp" alt="Best Sellers"></div>
                        <h3>Limited Edition</h3>
                    </a>
                </div>
            </div>
        </section>

    </main>
    
    <?php include 'newsletter.php'; ?>

    <?php include 'footer.php'; ?>
   
</body>
</html>