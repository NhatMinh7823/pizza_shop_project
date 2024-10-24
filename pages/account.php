<?php
require_once '../config.php'; // Kết nối CSDL
require_once '../controllers/OrderController.php'; // Controller xử lý đơn hàng

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user_name'])) {
  header("Location: /index.php?page=login");
  exit();
}

// Lấy thông tin người dùng từ session
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
$user_role = $_SESSION['user_role'];

// Khởi tạo OrderController
$orderController = new OrderController($conn);

// Lấy danh sách đơn hàng của người dùng
$orderItems = $orderController->getOrdersByUserId($user_id);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_panel'])) {
  if ($user_role === 'admin') {
    header("Location: /index.php?page=admin"); // Điều hướng đến trang quản lý sản phẩm
    exit();
  }
}
?>

<h1 class="text-center mt-4">Your Profile</h1>

<div class="container">
  <!-- Hiển thị thông tin tên và email -->
  <div class="card mb-4">
    <div class="card-body">
      <h5 class="card-title">Name: <?= htmlspecialchars($user_name) ?></h5>
      <h5 class="card-title">Email: <?= htmlspecialchars($user_email) ?></h5>
    </div>
  </div>

  <!-- Thêm nút kiểm tra vai trò admin -->
  <?php if ($user_role === 'admin'): ?>
    <form method="POST" action="/index.php?page=account">
      <button type="submit" name="admin_panel" class="btn btn-warning">Admin Panel</button>
    </form>
  <?php endif; ?>

  <!-- Hiển thị danh sách đơn hàng -->
  <?php if (!empty($orderItems)): ?>
    <h2 class="text-center mt-4">Your Orders</h2>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Product Name</th> <!-- Thêm cột tên sản phẩm -->
          <th>Quantity</th> <!-- Thêm cột số lượng -->
          <th>Price</th> <!-- Thêm cột giá -->
          <th>Total</th>
          <th>Payment Method</th>
          <th>Status</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orderItems as $order): ?>
          <tr>
            <td><?= htmlspecialchars($order['order_id']) ?></td> <!-- Sử dụng order_id mới -->
            <td><?= htmlspecialchars($order['product_name']) ?></td> <!-- Hiển thị tên sản phẩm -->
            <td><?= htmlspecialchars($order['quantity']) ?></td> <!-- Hiển thị số lượng -->
            <td>$<?= number_format($order['price'], 2) ?></td> <!-- Hiển thị giá -->
            <td>$<?= number_format($order['price'] * $order['quantity'], 2) ?></td> <!-- Tính tổng giá -->
            <td><?= htmlspecialchars(ucfirst($order['payment_method'])) ?></td>
            <td><?= htmlspecialchars(ucfirst($order['status'])) ?></td>
            <td><?= htmlspecialchars($order['created_at']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-info text-center">
      <p>You haven't placed any orders yet.</p>
      <a href="/index.php?page=products" class="btn btn-primary mt-3">Go to Products</a>
    </div>
  <?php endif; ?>

</div>

<!-- Logout Button -->
<form method="POST" class="text-center mt-4">
  <button type="submit" name="logout" class="btn btn-danger">Logout</button>
</form>