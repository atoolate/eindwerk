<?php
namespace Alex\Eindwerk;
include_once(__DIR__ . '/vendor/autoload.php');

session_start();

// Handle the review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate the input
    $productId = $_POST['product_id'] ?? null;
    $author = $_POST['author'] ?? null;
    $content = $_POST['content'] ?? null;

    if ($productId && $author && $content) {
        try {
            // Create a new review instance
            $review = new Review();
            $review->setProductId($productId);
            $review->setAuthor($author);
            $review->setContent($content);
            $review->setDate(date('Y-m-d H:i:s')); // Use current timestamp

            // Save the review to the database
            $result = $review->saveReview();

            if ($result) {
                echo json_encode(['success' => true, 'review' => ['author' => $author, 'content' => $content]]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to submit review.']);
            }
        } catch (Exception $e) {
            // Log the error and set an error message
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'message' => 'An unexpected error occurred. Please try again.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    }
    exit();
}
