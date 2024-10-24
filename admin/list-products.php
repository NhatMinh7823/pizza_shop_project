<?php
require_once '../config.php';
require_once '../controllers/ProductController.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: /index.php?page=login");
    exit();
}

$productController = new ProductController($conn);

// Lấy danh sách sản phẩm
$products = $productController->listProducts();
?>

<h1 class="text-center">Product Management</h1>

<div class="container">
    <a href="/index.php?page=add" class="btn btn-success mb-3">Add New Product</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['id']) ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['price']) ?></td>
                    <td><?= htmlspecialchars($product['category_name']) ?></td>
                    <td>
                        <a href="/index.php?page=edit&id=<?= $product['id'] ?>" class="btn btn-warning">Edit</a>
                        <a href="/index.php?page=delete&id=<?= $product['id'] ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>