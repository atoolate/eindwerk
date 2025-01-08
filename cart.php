<?php
namespace Alex\Eindwerk;
include_once(__DIR__ . '/vendor/autoload.php');

session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
    // inputs from the form
    $title = $_POST['title'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    
    $withGlass = isset($_POST['withGlass']) ? 1 : 0; // Default to 0 if not selected


    if ($title && $product_id && $quantity && $price) {
        $cartItem = [
            'title' => $title,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'price' => $price,
            'withGlass' => $withGlass
        ];

        $_SESSION['cart'][] = $cartItem;
    } else {
        error_log("Invalid cart item data: " . json_encode($_POST));
        echo '<script>alert("Invalid cart item data. Please try again.");</script>';
    }
}

if (isset($_POST['delete'])) {
    array_splice($_SESSION['cart'], $_POST['delete'], 1);
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
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <title>Your Cart</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="cart-wrapper">
        <h1>Your Cart</h1>
        <div class="cart-items">
            <?php foreach ($_SESSION['cart'] as $key => $cartItem): ?>
                <div class="cart-item-wrapper">
                    <div class="cart-item">
                        <h2><?php echo htmlspecialchars($cartItem['title']); ?></h2>
                        <p><strong>Quantity:</strong> <?php echo htmlspecialchars($cartItem['quantity']); ?></p>
                        <p><strong>Price per item:</strong> €<?php echo number_format($cartItem['price'], 2); ?></p>
                        <p><strong>Total:</strong> €<?php echo number_format($cartItem['price'] * $cartItem['quantity'], 2); ?></p>
                        <?php if ($cartItem['withGlass']): ?>
                            <p><strong>With Glass:</strong> Yes</p>
                        <?php endif; ?>
                    </div>
                    <!-- delete item from cart -->
                    <form action="cart.php" method="post" class="delete-form">
                        <input type="hidden" name="delete" value="<?php echo $key; ?>">
                        <!-- delete trash icon -->
                        <button type="submit" class="delete-button">
                            Remove Product
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
        
        <hr>

        <p>
            <strong>Total:</strong> €
            <?php echo number_format(array_sum(array_map(function($cartItem) {
                return $cartItem['price'] * $cartItem['quantity'];
                }, $_SESSION['cart'])), 2); ?>
        </p>

        <hr>

        <a href="checkout.php" class="btn-primary">Proceed to Checkout</a>
        <a href="catalog.php" class="btn-secondary">Continue Shopping</a>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
