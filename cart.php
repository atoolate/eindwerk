<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $cartItem = [
        'title' => $_POST['title'],
        'quantity' => $_POST['quantity'],
        'price' => $_POST['price'],           
    ];

    $_SESSION['cart'][] = $cartItem;
}

var_dump($_SESSION['cart']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <!-- Preconnect for Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <title>Your Cart</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="cart-wrapper">
        <h1>Your Cart</h1>
        <div class="cart-items">
            <?php foreach ($_SESSION['cart'] as $cartItem): ?>
                <div class="cart-item">
                    <h2><?php echo htmlspecialchars($cartItem['title']); ?></h2>
                    <p><strong>Quantity:</strong> <?php echo htmlspecialchars($cartItem['quantity']); ?></p>
                    <p><strong>Price per item:</strong> €<?php echo number_format($cartItem['price'], 2); ?></p>
                    <p><strong>Total:</strong> €<?php echo number_format($cartItem['price'] * $cartItem['quantity'], 2); ?></p>
                    <hr>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="checkout.php" class="btn-primary">Proceed to Checkout</a>
        <a href="catalog.php" class="btn-secondary">Continue Shopping</a>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
