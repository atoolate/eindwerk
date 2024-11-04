<?php 

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <title>All beers</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="catalogus-header">
            <span class="route-url">Home / Shop All</span>
            <h1>Shop all</h1>
        </div>

        <section class="products">
            <div class="products-header">
                <h3 class="total-items">100 Items</h3>
                <div id="style">
                    <a class="dropdown" href="#">
                        <p>Style</p>
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>
                </div>
                <div id="strength">
                    <a class="dropdown" href="#">
                        <p>Strength</p>
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>
                </div>
                <!-- eventueel nog sorteren en andere weergave bij bouwen -->
            </div>
            <div class="products-grid">
                <article class="product-card">
                    <div class="product-content">
                        <a class="product-image-wrapper" href="#">
                            <img class="product-image" src="images/funkynebula.webp" alt="Funky Nebula IPA">
                        </a>
                        <div class="product-details">
                            <h3 class="product-title">Funky Nebula IPA</h3>
                            <p class="product-keywords">Taste the cosmos.</p>
                            <div class="product-specifications">
                                <p>5.4%</p>
                                <p class="specification-middle">IPA</p>
                                <p>330ml</p>
                            </div>
                        </div>
                        <div class="product-buttons">
                            <p class="product-price">€2,50 per can</p>
                            <a class="cta" href="#">Options</a>
                            <a class="cta" href="#">Details</a>
                        </div>
                        

                    </div>
                </article>
            </div>
        </section>

    </main>


    <!-- <?php include 'footer.php'; ?> -->
</body>
</html>