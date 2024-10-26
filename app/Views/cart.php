<?php

require_once __DIR__ . '/../shared/header.php';
require_once __DIR__ . '/../shared/navbar.php';

// Lấy danh sách sản phẩm trong giỏ hàng từ Controller
$cartController = new \App\Controllers\CartController($conn);
$user_id = $_SESSION['user_id'] ?? null;

if ($user_id) {
    $cartItems = $cartController->viewCart($user_id);
} else {
    header("Location: /index.php?page=login");
    exit();
}
?>

<h1 class="text-center mt-4">Your Cart</h1>

<div class="container">
    <?php if (!empty($cartItems)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td>
                            <img src="/images/<?= htmlspecialchars($item['image']) ?>"
                                alt="<?= htmlspecialchars($item['name']) ?>" width="50">
                            <?= htmlspecialchars($item['name']) ?>
                        </td>
                        <td>$<?= htmlspecialchars($item['price']) ?></td>
                        <td>
                            <form method="POST" action="/index.php?page=cart&action=update">
                                <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1">
                                <button type="submit" name="update" class="btn btn-primary">Update</button>
                            </form>
                        </td>
                        <td>$<?= htmlspecialchars($item['price'] * $item['quantity']) ?></td>
                        <td>
                            <a href="/index.php?page=cart&action=delete&cart_id=<?= $item['id'] ?>"
                                class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-center mt-4">
            <a href="/index.php?page=checkout" class="btn btn-success">Proceed to Checkout</a>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            <p>Your cart is empty. Why not check out our delicious pizzas?</p>
            <a href="/index.php?page=products" class="btn btn-primary mt-3">Go to Products</a>
        </div>
    <?php endif; ?>
</div>

<?php
require_once __DIR__ . '/../shared/footer.php';
?>
