<?php
    namespace Alex\Eindwerk;
    include_once(__DIR__ . '/vendor/autoload.php');
    
    session_start();
    
    // Ensure the cart is initialized
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo '<script>alert("Your cart is empty. Add items before proceeding to checkout.");</script>';
        echo '<script>window.location.href = "catalog.php";</script>';
        exit;
    }
    
    // If the user is not logged in, redirect them to login
    if (!isset($_SESSION['email'])) {
        echo '<script>alert("Please log in to proceed.");</script>';
        echo '<script>window.location.href = "login.php";</script>';
        exit;
    }
    
    // Retrieve user details
    $userDetails = User::getUserByEmail($_SESSION['email']);
    if (!$userDetails) {
        echo '<script>alert("Unable to retrieve user details. Please contact support.");</script>';
        exit;
    }
    
    $_SESSION['user_id'] = $userDetails['id']; // Store user ID in the session
    
    // Process the checkout form

    if (isset($_POST['checkout'])) {
        // Validate and sanitize inputs
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $street = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_STRING);
        $postal_code = filter_input(INPUT_POST, 'postal_code', FILTER_SANITIZE_STRING);
        $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
    
        if ($firstname && $lastname && $email && $street && $postal_code && $country) {
            // Create a new order
            $order = new Order();
            $order->setUserId($_SESSION['user_id'])
                ->setFirstname($firstname)
                ->setLastname($lastname)
                ->setEmail($email)
                ->setStreet($street)
                ->setPostalCode($postal_code)
                ->setCountry($country)
                ->setTotalAmount(array_sum(array_map(fn($cartItem) => $cartItem['price'] * $cartItem['quantity'], $_SESSION['cart'])))
                ->setStatus('pending')
                ->setOrderDate(date('Y-m-d H:i:s'));

    
            if ($order->saveOrder()) {
                // Create order items
                foreach ($_SESSION['cart'] as $cartItem) {
                    $orderItem = new OrderItem();
                    $orderItem->setOrderId($order->getOrderId())
                        ->setProductId($cartItem['product_id'])
                        ->setQuantity($cartItem['quantity'])
                        ->setPrice($cartItem['price']);
    
                    $orderItem->saveOrderItems($order->getOrderId(), $cartItem['product_id'], $cartItem['quantity'], $cartItem['price']);
                }
    
                // Clear the cart
                $_SESSION['cart'] = [];
    
                echo '<script>alert("Order placed successfully. Thank you for shopping with us!");</script>';
                echo '<script>window.location.href = "catalog.php";</script>';
                exit;
            } else {
                echo '<script>alert("Failed to place order. Please try again.");</script>';
            }
        } else {
            echo '<script>alert("Invalid checkout data. Please try again.");</script>';
        }
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
    
    <title>Checkout</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <h1>Checkout</h1>
    <main class="checkout-wrapper">
        
        <div class="checkout-info">
            <form action="checkout.php" method="post" class="checkout-form">
                <!-- firstname -->
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" required>

                <!-- lastname -->
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" required>

                <!-- email -->
                <label for="email">Email:</label>
                <!-- if email is set in session, auutomatically fill out here -->
                <input type="email" id="email" name="email" value="<?php echo $_SESSION['email']; ?>" required>

                <!-- Street + number -->
                <label for="street">Street + Number:</label>
                <input type="text" id="street" name="street" placeholder="Koekoekstraat 70" required>

                <!-- postal code -->
                <label for="postal_code">Postal Code:</label>
                <input type="text" id="postal_code" name="postal_code" placeholder="9090" required>

                <!-- country -->
                <label for="country">Country:</label>
                <input type="text" id="country" name="country" required>

                <!-- submit order -->
                <button type="submit" name="checkout">Submit Order</button>

            </form>
        </div>

        <!-- show order overview -->
        <div class="checkout-order">
            <div class="order-items">
                <h2>Your Order</h2>
                <?php foreach ($_SESSION['cart'] as $cartItem): ?>
                    <div class="order-item">
                        <h3><?php echo htmlspecialchars($cartItem['title']); ?></h3>
                        <p><strong>Quantity:</strong> <?php echo htmlspecialchars($cartItem['quantity']); ?></p>
                        <p><strong>Price per item:</strong> €<?php echo number_format($cartItem['price'], 2); ?></p>                   
                    </div>
                <?php endforeach; ?>     
            </div>
            <div class="checkout-total">
                <h2>Total: €<?php echo number_format(array_sum(array_map(fn($cartItem) => $cartItem['price'] * $cartItem['quantity'], $_SESSION['cart'])), 2); ?></h2>
            </div>  
        </div>
                
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>


