<?php 
    namespace Alex\Eindwerk;
    include_once(__DIR__ . '/vendor/autoload.php');

?><header>
        <section class="notifications">
            <h3>📦 FREE shipping on orders over €50 📦</h3>
        </section>
        <nav class="navbar">
                <div class="navbar-links">
                    <a class="navbar-a" href="index.php">Home</a>
                    <a class="navbar-a" href="catalog.php">Shop</a>
                </div>
                <a href="index.php"><img id="logo" src="./images/xDbrewery-logo.png" alt="logo"></a>
                <div class="navbar-user">
                    <a class="navbar-a" id="cart" href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                    <?php if (isset($_SESSION['email'])): ?>
                        <div class="profile-dropdown">
                            <a class="navbar-a" id="profile-dropdown" href="#">
                                <span class="user-email"><?php echo htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <i class="fa-solid fa-user"></i>
                            </a>
                            <div id="logout-menu" class="hidden">
                                <a id="logout" href="logout.php">Logout?</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a class="navbar-a" href="login.php">Login</a>
                    <?php endif; ?>

                </div>
        </nav>
        <script>
            const logoutMenu = document.querySelector('#logout-menu');
            const dropdown = document.querySelector('#profile-dropdown');
            dropdown.addEventListener('click', () => {
                logoutMenu.classList.toggle('show');
            });

            document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target) && !logoutMenu.contains(e.target)) {
                logoutMenu.classList.remove('show');
            }
        });
        </script>
</header>