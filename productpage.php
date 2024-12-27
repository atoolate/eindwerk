<?php 
    namespace Alex\Eindwerk;
    include_once(__DIR__ . '/vendor/autoload.php');


    session_start();

    $productId = $_GET['id'] ?? null;

    if ($productId) {
        $product = Product::getById($productId); // Fetch the product using its ID

        // Get price per can using the product object
        $pricePerCan = $product['price'];

        // Define quantity options
        $quantities = [4, 12, 24, 48];

        // Define discount multipliers based on quantity
        // Example: Higher quantities have progressively greater discounts
        $discounts = [
            4 => 1,        // No discount for 4 cans
            12 => 0.95,    // 5% discount for 12 cans
            24 => 0.90,    // 10% discount for 24 cans
            48 => 0.85     // 15% discount for 48 cans
        ];

        // Calculate total prices with discounts
        $pricingOptions = [];
        foreach ($quantities as $quantity) {
            $discountMultiplier = $discounts[$quantity]; // Get the discount for the quantity
            $discountedPricePerCan = $pricePerCan * $discountMultiplier; // Apply the discount
            $totalPrice = $discountedPricePerCan * $quantity; // Calculate total price

            $pricingOptions[] = [
                'quantity' => $quantity,
                'total_price' => $totalPrice,
                'price_per_can' => $discountedPricePerCan
            ];
        }

        if (!$product) {
            // Handle case where the product doesn't exist
            header("Location: catalog.php"); // Redirect back to catalog
            exit();
        }
    } else {
        // Redirect if no ID is provided
        header("Location: catalog.php");
        exit();
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <!-- Preconnect for Google Fonts (only include once) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Page-specific stylesheet -->
    <link rel="stylesheet" href="detail.css">

    <title><?php echo $product['title'] ?></title>
</head>

<body>
    <?php include 'header.php'; ?>

    <main class="product-wrapper">
        <div class="product-image-wrapper">
            <img class="product-detail-image" src="<?php echo $product['images'] ?>" alt="<?php echo $product['title'] ?>">
            <!-- add image selectors here -->
        </div>
        <div class="product-details">
            <h1><?php echo $product['title'] ?></h1>
            <p class="product-tagline"><?php echo $product['tagline'] ?></p>
            <p class="product-description"><?php echo $product['description'] ?></p>

            <div class="product-specifications-grid">
                <div class="specifications-alcohol">
                    <p class="grid-label">Alcohol</p>
                    <p><?php echo $product['alcohol'] ?>%</p>
                </div>
                <div class="specifications-style">
                    <p class="grid-label">Style</p>
                    <p><?php echo $product['category_name'] ?></p>
                </div>
                <div class="specifications-volume">
                    <p class="grid-label">Volume</p>
                    <p><?php echo $product['volume'] ?>cl</p>
                </div>
            </div>
            <section class="order-configurator">
                <div class="quantity-selector-wrapper">
                        <div class="quantity-selector">

                            
                            <div class="quantity-row">
                                <div class="quantity-details">
                                    <p class="quantity">Quantity</p>
                                    <div class="quantity-price">
                                        <p class="price">€<?php echo number_format($pricePerCan, 2); ?></p>
                                        <p class="price-per-item">€<?php echo number_format($pricePerCan, 2); ?> per beer</p>
                                    </div>
                                </div>
                                <div class="quantity-controls">
                                    <button class="decrement">-</button>
                                    <span class="quantity-value">1</span>
                                    <button class="increment">+</button>
                                </div>
                            </div>
                

                        </div>
                </div>

                    <!-- a div where users can select if they want a glass with their order, only for limited products -->
                    <?php if (Category::hasGlassOption($product['category_id'])) : ?>
                        <div class="glass-selector">
                            <input type="checkbox" id="glass" name="glass" value="glass">
                            <label for="glass">With Limited Edition <?php echo $product['title'] ?> Glass</label>
                        </div>
                    <?php endif; ?>

                    <!-- <a href="#" class="btn-primary" id="add-to-cart">
                        <p>Add to cart</p> 
                        <p class="total-price">€0.00</p>
                    </a> -->

                    <form method="POST" action="cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                        <input type="hidden" name="title" value="<?php echo htmlspecialchars($product['title'], ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                        <input type="hidden" name="selected_package" id="selected-package" value="">
                        <input type="hidden" name="quantity" value="1" id="quantity-input">
                        <!-- disable button if quantity is 0 -->
                        <button type="submit" class="btn-primary" id="add-to-cart" name="add_to_cart">
                            <p>Add to cart</p> 
                            <p class="total-price">€0.00</p>
                        </button>
                    </form>
            </section>
            
        </div>
    </main>

    <?php include 'newsletter.php'; ?>

    <?php include 'footer.php'; ?>


    <script src="js/quantitySelector.js"></script>

    <script src="js/priceCalculator.js"></script>

</body>
</html>