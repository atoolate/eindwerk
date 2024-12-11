<?php 
namespace Alex\Eindwerk;
include_once(__DIR__ . '/vendor/autoload.php');

session_start();

// Check if the user is an admin
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}

// Check if the product ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid product ID.");
}

$productId = intval($_GET['id']);

// Fetch product details
try {
    $conn = Db::getConnection();
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->bindValue(':id', $productId, \PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(\PDO::FETCH_ASSOC);

    if (!$product) {
        die("Product not found.");
    }

    // Fetch categories for dropdown
    $categoriesStmt = $conn->query("SELECT id, name FROM categories");
    $categories = $categoriesStmt->fetchAll(\PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    die("Error fetching product or categories: " . $e->getMessage());
}

// Update product details on form submission
if (!empty($_POST)) {
    try {
        $stmt = $conn->prepare("
            UPDATE products 
            SET title = :title, 
                description = :description, 
                price = :price, 
                category_id = :category_id, 
                stock = :stock, 
                alcohol = :alcohol, 
                volume = :volume, 
                tagline = :tagline 
            WHERE id = :id
        ");
        $stmt->bindValue(':title', $_POST['title'], \PDO::PARAM_STR);
        $stmt->bindValue(':description', $_POST['description'], \PDO::PARAM_STR);
        $stmt->bindValue(':price', $_POST['price'], \PDO::PARAM_STR);
        $stmt->bindValue(':category_id', $_POST['category_id'], \PDO::PARAM_INT);
        $stmt->bindValue(':stock', $_POST['stock'], \PDO::PARAM_INT);
        $stmt->bindValue(':alcohol', $_POST['alcohol'], \PDO::PARAM_STR);
        $stmt->bindValue(':volume', $_POST['volume'], \PDO::PARAM_STR);
        $stmt->bindValue(':tagline', $_POST['tagline'], \PDO::PARAM_STR);
        $stmt->bindValue(':id', $productId, \PDO::PARAM_INT);
        $stmt->execute();

        // check if the product was sucessfully updated
        if ($stmt->rowCount() > 0) {
            $message = "Product successfully updated.";
        } else {
            $message = "Failed to update product. Product may not exist.";
        }

        // redirect to admin page with a success message
        header('Location: admin.php?message=' . urlencode($message));
        exit;

    } catch (\PDOException $e) {
        die("Error updating product: " . $e->getMessage());
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Lexend+Deca:wght@100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <main>
        <h1>Edit Product</h1>
        <form class="admin-form" id="editProduct" action="edit.php?id=<?php echo $productId; ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $productId; ?>">

            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($product['title'], ENT_QUOTES, 'UTF-8'); ?>" required>

            <label for="description">Description</label>
            <input type="text" name="description" id="description" value="<?php echo htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8'); ?>" required>

            <label for="price">Price</label>
            <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8'); ?>" min="0" step="0.01" required>

            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo htmlspecialchars($category['id'], ENT_QUOTES, 'UTF-8'); ?>" 
                        <?php echo $category['id'] == $product['category_id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" value="<?php echo htmlspecialchars($product['stock'], ENT_QUOTES, 'UTF-8'); ?>" min="0" required>

            <label for="alcohol">Alcohol Percentage</label>
            <input type="number" name="alcohol" id="alcohol" value="<?php echo htmlspecialchars($product['alcohol'], ENT_QUOTES, 'UTF-8'); ?>" min="0" step="0.01" required>

            <label for="volume">Volume (in Cl)</label>
            <input type="number" name="volume" id="volume" value="<?php echo htmlspecialchars($product['volume'], ENT_QUOTES, 'UTF-8'); ?>" min="0" step="0.01" required>

            <label for="tagline">Tagline</label>
            <input type="text" name="tagline" id="tagline" value="<?php echo htmlspecialchars($product['tagline'], ENT_QUOTES, 'UTF-8'); ?>" required>

            <button class="cta" type="submit">Save Changes</button>
        </form>
        <a href="admin.php" class="back-link">Back to Admin Dashboard</a>
    </main>

    <script src="js/adminPopups.js"></script>
</body>
</html>
