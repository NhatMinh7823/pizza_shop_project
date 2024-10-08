<?php
require_once '../config.php';
require_once '../controllers/OrderController.php';

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: /index.php?page=login");
  exit();
}

// Initialize OrderController
$orderController = new OrderController($conn);

// Get user_id from session
$user_id = $_SESSION['user_id'];

// Get order_id from the query parameter
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
  $order_id = (int) $_GET['order_id'];
} else {
  echo "Invalid order ID.";
  exit();
}

// Fetch order details using the OrderController
$orderDetails = $orderController->getOrderDetails($order_id, $user_id);
?>

<h1 class="text-center mt-4">Order Confirmation</h1>

<div class="container">
  <?php if ($orderDetails): ?>
    <p>Thank you for your order! Your order ID is <strong>#<?= htmlspecialchars($orderDetails['id']) ?></strong>.</p>
    <p>Status: <strong><?= htmlspecialchars($orderDetails['status']) ?></strong></p>
    <p>Total: <strong>$<?= htmlspecialchars($orderDetails['total']) ?></strong></p>
    <p>Payment Method: <strong><?= htmlspecialchars($orderDetails['payment_method']) ?></strong></p>
    <p>Shipping Address: <strong><?= htmlspecialchars($orderDetails['address']) ?></strong></p>

    <h2 class="mt-4">Order Items</h2>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Product</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orderDetails['items'] as $item): ?>
          <tr>
            <td>
              <img src="/images/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>"
                width="50">
              <?= htmlspecialchars($item['name']) ?>
            </td>
            <td><?= htmlspecialchars($item['quantity']) ?></td>
            <td>$<?= htmlspecialchars($item['price']) ?></td>
            <td>$<?= htmlspecialchars($item['price'] * $item['quantity']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <a href="/index.php?page=home" class="btn btn-primary mt-4">Back to Home</a>
  <?php else: ?>
    <p>Order not found or you are not authorized to view this order.</p>
  <?php endif; ?>
</div>