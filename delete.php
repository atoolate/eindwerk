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

// Delete the product from the database
try {
    $conn = Db::getConnection();
    $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
    $stmt->bindValue(':id', $productId, \PDO::PARAM_INT);
    $stmt->execute();

    // Check if the product was successfully deleted
    if ($stmt->rowCount() > 0) {
        $message = "Product successfully deleted.";
    } else {
        $message = "Failed to delete product. Product may not exist.";
    }
} catch (\PDOException $e) {
    $message = "Error deleting product: " . $e->getMessage();
}

// Redirect back to admin page with a success or error message
header("Location: admin.php?message=" . urlencode($message));
exit;
