<?php
namespace Alex\Eindwerk;
include_once(__DIR__ . '/../vendor/autoload.php');

session_start();

if (isset($_POST['query'])) {
    $query = $_POST['query'];

    // Search products based on the query
    $product = new Product();
    $products = $product->search($query);

    // Return the search results
    echo json_encode(['status' => 'success', 'products' => $products]);
    exit();
}
?>
