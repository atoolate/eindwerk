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
                        <span class="product-tag hidden">Best Seller</span>
                        <a class="product-image-wrapper" href="productpage.php">
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
                        <div class="product-cta">
                            <p class="product-price">From <span id="price-unit">€1,90</span> per can</p>
                            <div class="product-btns">
                                <!-- met javascript hoeveelheid scherm popup -->
                                <a class="btn-primary" href="#">Options</a>
                                <a class="btn-secondary" href="productpage.php">Details</a>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="product-card">
                    <div class="product-content">
                        <span class="product-tag hidden">Best Seller</span>
                        <a class="product-image-wrapper" href="productpage.php">
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
                        <div class="product-cta">
                            <p class="product-price">From <span id="price-unit">€1,90</span> per can</p>
                            <div class="product-btns">
                                <!-- met javascript hoeveelheid scherm popup -->
                                <a class="btn-primary" href="#">Options</a>
                                <a class="btn-secondary" href="productpage.php">Details</a>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="product-card">
                    <div class="product-content">
                        <span class="product-tag hidden">Best Seller</span>
                        <a class="product-image-wrapper" href="productpage.php">
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
                        <div class="product-cta">
                            <p class="product-price">From <span id="price-unit">€1,90</span> per can</p>
                            <div class="product-btns">
                                <!-- met javascript hoeveelheid scherm popup -->
                                <a class="btn-primary" href="#">Options</a>
                                <a class="btn-secondary" href="productpage.php">Details</a>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="product-card">
                    <div class="product-content">
                        <span class="product-tag hidden">Best Seller</span>
                        <a class="product-image-wrapper" href="productpage.php">
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
                        <div class="product-cta">
                            <p class="product-price">From <span id="price-unit">€1,90</span> per can</p>
                            <div class="product-btns">
                                <!-- met javascript hoeveelheid scherm popup -->
                                <a class="btn-primary" href="#">Options</a>
                                <a class="btn-secondary" href="productpage.php">Details</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <div class="shipping-disclaimer">
                <h2>Free Standard Delivery</h2>
                <p>When you spend over €50</p>
            </div>
            <div class="products-grid">
                <article class="product-card">
                    <div class="product-content">
                        <span class="product-tag hidden">Best Seller</span>
                        <a class="product-image-wrapper" href="productpage.php">
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
                        <div class="product-cta">
                            <p class="product-price">From <span id="price-unit">€1,90</span> per can</p>
                            <div class="product-btns">
                                <!-- met javascript hoeveelheid scherm popup -->
                                <a class="btn-primary" href="#">Options</a>
                                <a class="btn-secondary" href="productpage.php">Details</a>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="product-card">
                    <div class="product-content">
                        <span class="product-tag hidden">Best Seller</span>
                        <a class="product-image-wrapper" href="productpage.php">
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
                        <div class="product-cta">
                            <p class="product-price">From <span id="price-unit">€1,90</span> per can</p>
                            <div class="product-btns">
                                <!-- met javascript hoeveelheid scherm popup -->
                                <a class="btn-primary" href="#">Options</a>
                                <a class="btn-secondary" href="productpage.php">Details</a>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="product-card">
                    <div class="product-content">
                        <span class="product-tag hidden">Best Seller</span>
                        <a class="product-image-wrapper" href="productpage.php">
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
                        <div class="product-cta">
                            <p class="product-price">From <span id="price-unit">€1,90</span> per can</p>
                            <div class="product-btns">
                                <!-- met javascript hoeveelheid scherm popup -->
                                <a class="btn-primary" href="#">Options</a>
                                <a class="btn-secondary" href="productpage.php">Details</a>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="product-card">
                    <div class="product-content">
                        <span class="product-tag hidden">Best Seller</span>
                        <a class="product-image-wrapper" href="productpage.php">
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
                        <div class="product-cta">
                            <p class="product-price">From <span id="price-unit">€1,90</span> per can</p>
                            <div class="product-btns">
                                <!-- met javascript hoeveelheid scherm popup -->
                                <a class="btn-primary" href="#">Options</a>
                                <a class="btn-secondary" href="productpage.php">Details</a>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="product-card">
                    <div class="product-content">
                        <span class="product-tag hidden">Best Seller</span>
                        <a class="product-image-wrapper" href="productpage.php">
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
                        <div class="product-cta">
                            <p class="product-price">From <span id="price-unit">€1,90</span> per can</p>
                            <div class="product-btns">
                                <!-- met javascript hoeveelheid scherm popup -->
                                <a class="btn-primary" href="#">Options</a>
                                <a class="btn-secondary" href="productpage.php">Details</a>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="product-card">
                    <div class="product-content">
                        <span class="product-tag hidden">Best Seller</span>
                        <a class="product-image-wrapper" href="productpage.php">
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
                        <div class="product-cta">
                            <p class="product-price">From <span id="price-unit">€1,90</span> per can</p>
                            <div class="product-btns">
                                <!-- met javascript hoeveelheid scherm popup -->
                                <a class="btn-primary" href="#">Options</a>
                                <a class="btn-secondary" href="productpage.php">Details</a>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="product-card">
                    <div class="product-content">
                        <span class="product-tag hidden">Best Seller</span>
                        <a class="product-image-wrapper" href="productpage.php">
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
                        <div class="product-cta">
                            <p class="product-price">From <span id="price-unit">€1,90</span> per can</p>
                            <div class="product-btns">
                                <!-- met javascript hoeveelheid scherm popup -->
                                <a class="btn-primary" href="#">Options</a>
                                <a class="btn-secondary" href="productpage.php">Details</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>
    </main>

    <?php include 'newsletter.php'; ?>

    <?php include 'footer.php'; ?>
</body>
</html>