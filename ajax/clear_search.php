<?php
namespace Alex\Eindwerk;
include_once(__DIR__ . '/../vendor/autoload.php');

session_start();

if (isset($_POST['clear'])) {
    // Clear the search query from the session or any other necessary cleanup
    unset($_SESSION['search_query']);

    // Get all products
    $product = new Product();
    $products = $product->getAllWithData();

    // Return the updated products list
    echo json_encode(['status' => 'success', 'products' => $products]);
    exit();
}
?>
