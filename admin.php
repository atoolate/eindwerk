<?php 
    namespace Alex\Eindwerk;
    include_once(__DIR__ . '/vendor/autoload.php');

    session_start();
    // if is Admin is false, redirect to index.php
    if (!isset($_SESSION['admin'])) {
        header('Location: index.php');
        exit;
    } 

    // Fetch categories from the database
    try {
        $conn = Db::getConnection();
        $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $query = $conn->query("SELECT id, name FROM categories");
        $categories = $query->fetchAll(\PDO::FETCH_ASSOC); // Fetch as an associative array
    } catch (\PDOException $e) {
        echo "Error fetching categories: " . $e->getMessage();
        $categories = []; // Fallback to an empty array to avoid errors in the form
    }
    
    // Add product to database when form is submitted
    if (!empty($_POST)) {
        $product = new Product();
        $product->setTitle($_POST['title']);
        $product->setDescription($_POST['description']);
        $product->setPrice($_POST['price']);
        $product->setCategoryId($_POST['category_id']);
        $product->setStock($_POST['stock']);

        $productId = $product->saveProduct();

        // Save product to database
        if ($productId) {
            echo "Product toegevoegd!";

            // Save images to database using saveProductImages()
            $images = $_FILES['images'];
            $product->saveProductImages($productId, $images);


        } else {
            echo "Er is een fout opgetreden bij het toevoegen van het product.";
        }
    }
    
    


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Lexend+Deca:wght@100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <main>
    
        <h1>Admin Dashboard</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8'); ?></p>
        <a href="logout.php">Logout</a>

        <!-- // form to add products to database (tables: title, description, price, image, category id, stock) -->
        <h2>Add Product</h2>
        <form class="addProduct" action="" method="POST" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" required>
            <label for="description">Description</label>
            <input type="text" name="description" id="description" required>
            <label for="price">Price</label>
            <input type="number" name="price" id="price" min="0" step="0.01" required>
            <label for="image">Image</label>
            <input type="file" name="images[]" id="image" accept="image/*" multiple>
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category['id'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
            </select>
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" min="0" required>
            <button type="submit">Add Product</button>
        </form>
    </main>
    <!-- a script that adds product to database and maps input to tables when submitted -->
    <script>

    </script>
</body>
</html>