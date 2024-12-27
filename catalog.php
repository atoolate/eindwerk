<?php 
    namespace Alex\Eindwerk;
    include_once(__DIR__ . '/vendor/autoload.php');
    session_start();

    // Get all products
    $product = new Product();
    $products = $product->getAll(); 
    $products = $product->getAllWithData();

    // Get all categories
    $category = new Category();
    $categories = $category->getAll();

    // display products if search query is set
    if (isset($_GET['query'])) {
        $products = $product->search($_GET['query']);
    }
    else {
        $products = $product->getAllWithData();
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
    
    <title>All beers</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="catalogus-header">
            <span class="route-url">Home / Shop All</span>
            <h1>Shop all</h1>
        </div>

        <div class="shipping-disclaimer">
                <h2>Free Standard Delivery</h2>
                <p>When you spend over €50</p>
        </div>


        <section class="products">
            <div class="products-header">
                <h3 class="total-items"><?php echo Product::getTotalAmount(); ?> Items</h3>
                <div class="dropdown" id="style">
                    <a href="#" class="dropdown-title">
                        <p>Style</p>
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>
                    <ul class="dropdown-content hidden">
                        <li id="All">All</li>
                        <?php foreach($categories as $category): ?>
                            <li id="<?php echo $category['id'] ?>"><?php echo $category['name']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <!-- search bar -->
                <form action="catalog.php" method="GET" class="search-bar">
                    <input type="text" name="query" placeholder="Search products..." required>
                </form>

            </div>

            <div class="products-grid">
                <!-- foreach loop over de producten -->                 
                <?php foreach($products as $product): ?>
                    
                    <article class="product-card" data-category-id="<?php echo $product['category_id'] ?>">
                        <div class="product-content">
                            <span class="product-tag hidden">Best Seller</span>
                            <a class="product-image-wrapper" href="productpage.php">
                                <img class="product-image" src="<?php echo $product['images'] ?>" alt="<?php echo $product['title'] ?>">
                            </a>
                            <div class="product-details">
                                <h3 class="product-title"> <?php echo $product['title']?> </h3>
                                <p class="product-keywords"><?php echo $product['tagline'] ?></p>
                                <div class="product-specifications">
                                    <p class="specifications-outside"><?php echo $product['alcohol'] ?>%</p>
                                    <p class="specification-middle"><?php echo $product['category_name']; ?></p>
                                    <p class="specifications-outside"><?php echo $product['volume'] ?>ml</p>
                                </div>
                            </div>
                            <div class="product-cta">
                                <p class="product-price">From <span id="price-unit">€<?php echo $product['price'] ?></span> per can</p>
                                <div class="product-btns">
                                    <a class="btn-primary" href="productpage.php?id=<?php echo $product['id']; ?>">Buy Now</a>

                                </div>
                            </div>
                        </div>
                    </article>
                <?php  endforeach;?>
            </div>

        </section>
    </main>

    <?php include 'newsletter.php'; ?>

    <?php include 'footer.php'; ?>

    <script src="js/filter.js"></script>
</body>
</html>