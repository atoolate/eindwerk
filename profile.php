<?php
    namespace Alex\Eindwerk;
    include_once(__DIR__ . '/vendor/autoload.php');

    session_start();

    if (!isset($_SESSION['email'])) {
        echo '<script>alert("Please log in to view your profile.");</script>';
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

    // logic to get orders by user id
    $order = new Order();
    $orders = $order->getOrdersByUserId($_SESSION['user_id']);

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
    
    <title>My Profile</title>
</head>
<body>

    <?php include 'header.php'; ?>

    <main class="profile-wrapper">

        <h1>My Profile</h1>
        <p>Welcome, <?php echo $_SESSION['email'] ?></p>
        
        

        <div class="order-history">
            <!-- order overview -->
            <h2>Order History</h2>

            <?php if ($orders): ?>
                <?php usort($orders, function($a, $b) {
                    return strtotime($b['date']) - strtotime($a['date']);
                }); ?>
                <?php foreach ($orders as $order): ?>
                    <div class="order">
                        <p><strong>Order Date:</strong> <?php echo $order['date'] ?></p>
                        <p><strong>Total Amount:</strong> €<?php echo number_format($order['total_amount'], 2) ?></p>
                        <p><strong>Shipping: </strong><?php echo $order['street']?> </p>
                        <p><strong>Status:</strong> <?php echo $order['status'] ?></p>
                        <table>
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $productNames = OrderItem::getOrderItemNames($order['id']);
                                    $productQuantities = OrderItem::getOrderItemQuantities($order['id']);
                                    if (is_array($productNames) && is_array($productQuantities)) {
                                        foreach ($productNames as $index => $productName) {
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($productName) . '</td>';
                                            echo '<td>' . htmlspecialchars($productQuantities[$index]) . '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="2">No products found</td></tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No orders found.</p>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'newsletter.php'; ?>
    <?php include 'footer.php'; ?>

</body>
</html>