<?php
require_once '../config.php';
require_once '../controllers/ProductController.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: /index.php?page=login");
    exit();
}

$productController = new ProductController($conn);
$product_id = $_GET['id'];

// Xóa sản phẩm
$productController->deleteProduct($product_id);

header("Location: /index.php?page=admin");
exit();
