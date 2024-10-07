<?php
if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php"); // Điều hướng về trang đăng nhập
  exit();
}
?>
<div class="container my-5">
  <h1>Checkout</h1>
  <form method="POST" action="/index.php?page=checkout">
    <div class="form-group">
      <label for="name">Full Name:</label>
      <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="form-group">
      <label for="address">Address:</label>
      <input type="text" class="form-control" id="address" name="address" required>
    </div>
    <div class="form-group">
      <label for="payment_method">Payment Method:</label>
      <select class="form-control" id="payment_method" name="payment_method" required>
        <option value="credit_card">Credit Card</option>
        <option value="paypal">PayPal</option>
        <option value="cash_on_delivery">Cash on Delivery</option>
      </select>
    </div>
    <button type="submit" class="btn btn-success">Place Order</button>
  </form>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config.php';

    // Lưu đơn hàng vào cơ sở dữ liệu
    $name = $_POST['name'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];
    $total = array_sum(array_map(function($item) {
        return $item['price'] * $item['quantity'];
    }, $_SESSION['cart']));

    $stmt = $conn->prepare("INSERT INTO orders (user_id, total, payment_method, address) VALUES (:user_id, :total, :payment_method, :address)");
    $stmt->execute([
        'user_id' => $_SESSION['user_id'],
        'total' => $total,
        'payment_method' => $payment_method,
        'address' => $address
    ]);

    // Xóa giỏ hàng sau khi đặt hàng thành công
    unset($_SESSION['cart']);

    echo "<p>Order placed successfully!</p>";
}
?>