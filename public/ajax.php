<?php
session_start();
// Include necessary files
require_once '../config.php';
require_once '../controllers/CartController.php';

// Initialize CartController
$cartController = new CartController($conn);

// Get the user ID if logged in
$user_id = $_SESSION['user_id'] ?? null;

// Determine which action is being performed
$action = isset($_POST['action']) ? $_POST['action'] : null;

// Process the AJAX action
if ($action === 'add_to_cart') {
    if ($user_id) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $success = $cartController->addToCart($user_id, $product_id, $quantity);

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    } else {
        // Return JSON response indicating the user is not logged in
        header('Content-Type: application/json');
        echo json_encode(['loggedIn' => false]);
    }
    exit();
}

// Default response for unknown actions
header('Content-Type: application/json');
echo json_encode(['error' => 'Invalid action']);
exit();
