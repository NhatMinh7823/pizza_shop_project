<?php
if (!isset($_SESSION['user_id'])) {
  header("Location: /index.php?page=login"); // Điều hướng về trang đăng nhập
  exit();
}

require_once '../config.php';
require_once '../controllers/CartController.php';
require_once '../controllers/OrderController.php';

// Initialize controllers
$cartController = new CartController($conn);
$orderController = new OrderController($conn);

// Get user_id from session
$user_id = $_SESSION['user_id'];

// Get cart items for the user
$cartItems = $cartController->viewCart($user_id);
if (empty($cartItems)) {
  // Redirect to cart page with an error message
  header("Location: /index.php?page=cart&error=empty");
  exit();
}

// Calculate total amount
$totalAmount = 0;
foreach ($cartItems as $item) {
  $totalAmount += $item['price'] * $item['quantity'];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
  $address = $_POST['address'];
  $payment_method = $_POST['payment_method'];

  // Tạo đơn hàng và nhận order_id
  $order_id = $orderController->createOrder($user_id, $totalAmount, $payment_method, $address);

  if ($order_id) {
    // Thêm các sản phẩm vào đơn hàng sau khi order_id đã được tạo
    foreach ($cartItems as $item) {
      if (!isset($item['product_id']) || empty($item['product_id'])) {
        echo "Product ID is missing or invalid for an item!";
        exit();
      }

      // Thêm từng sản phẩm vào đơn hàng
      $orderController->addOrderItem($order_id, $item['product_id'], $item['quantity'], $item['price']);
    }

    // Xóa giỏ hàng sau khi đã đặt hàng thành công
    $cartController->clearCart($user_id);

    // Điều hướng đến trang thành công
    header("Location: /index.php?page=order-success&order_id=$order_id");
    exit();
  } else {
    echo "Failed to create order. Please try again.";
    exit();
  }
}
?>

<h1 class="text-center mt-4">Checkout</h1>

<div class="container">
  <form method="POST" action="/index.php?page=checkout">
    <h2>Billing Details</h2>
    <div class="form-group">
      <label for="address">Address</label>
      <textarea name="address" id="address" class="form-control" required></textarea>
    </div>
    <h2>Payment Method</h2>
    <div class="form-group">
      <select name="payment_method" class="form-control" required>
        <option value="credit_card">Credit Card</option>
        <option value="paypal">PayPal</option>
        <option value="cash_on_delivery">Cash on Delivery</option>
      </select>
    </div>
    <h3>Total Amount: $<?= number_format($totalAmount, 2) ?></h3>
    <button type="submit" name="checkout" class="btn btn-success">Place Order</button>
  </form>
</div>
