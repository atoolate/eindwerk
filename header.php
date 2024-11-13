<?php 
    namespace Alex\Eindwerk;
    include_once(__DIR__ . '/vendor/autoload.php');

?><header>
        <section class="notifications">
            <h3>📦 FREE shipping on orders over €50 📦</h3>
        </section>
        <nav class="navbar">
                <div class="navbar-links">
                    <a class="cta" href="index.php">Home</a>
                    <a class="cta" href="catalog.php">Shop</a>
                </div>
                <a href="#"><img id="logo" src="./images/xDbrewery-logo.png" alt="logo"></a>
                <div class="navbar-user">
                    <a class="cta" id="cart" href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                    <?php if (isset($_SESSION['email'])): ?>
                        <a class="cta" href="#">
                            <span class="user-email"><?php echo $user_email ?></span>
                            <i class="fa-solid fa-user"></i>
                        </a>
                        <a class="cta" href="logout.php">Logout</a>
                    <?php else: ?>
                        <a class="cta" href="login.php">Login</a>
                    <?php endif; ?>

                </div>
        </nav>
</header>