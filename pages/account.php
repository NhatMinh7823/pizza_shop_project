<?php
if (isset($_POST['logout'])) {
  // Destroy session to log out the user
  session_unset();
  session_destroy();
  // Redirect to the home page but with a URL parameter to show the modal
  header("Location: /index.php?page=home&logout=success");
  exit();
}
// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_email'])) {
  header("Location: /index.php?page=login");
  exit();
}


?>

<!-- Profile Section -->
<div class="container mx-auto mt-10 p-8 bg-white shadow-lg rounded-lg max-w-lg">
  <h2 class="text-3xl font-bold text-center mb-6">Profile</h2>

  <div class="space-y-4">
    <div class="flex items-center space-x-3">
      <i class="fas fa-user text-xl"></i>
      <div>
        <p class="font-bold text-gray-700">Name</p>
        <p><?= htmlspecialchars($_SESSION['user_name']) ?></p>
      </div>
    </div>

    <div class="flex items-center space-x-3">
      <i class="fas fa-envelope text-xl"></i>
      <div>
        <p class="font-bold text-gray-700">Email</p>
        <p><?= htmlspecialchars($_SESSION['user_email']) ?></p>
      </div>
    </div>

    <!-- Lịch sử đơn hàng -->
    <h3 class="text-2xl font-bold text-center mt-6">Order History</h3>
    <div class="mt-4">
      <?php
      // Lấy user_id từ session
      $user_id = $_SESSION['user_id'];

      // Truy vấn đơn hàng từ bảng orders
      $query_orders = "SELECT * FROM orders WHERE user_id = :id";
      $stmt_orders = $conn->prepare($query_orders);
      $stmt_orders->bindParam(':id', $user_id, PDO::PARAM_INT);
      $stmt_orders->execute();
      $orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);

      // Kiểm tra nếu có kết quả trả về
      if (count($orders) > 0):
      ?>
        <ul class="list-disc pl-5">
          <?php foreach ($orders as $order): ?>
            <li>
              <strong>Order ID:</strong> <?= $order['id'] ?><br>
              <strong>Total:</strong> $<?= number_format($order['total'], 2) ?><br>
              <strong>Payment Method:</strong> <?= ucfirst($order['payment_method']) ?><br>
              <strong>Status:</strong> <?= ucfirst($order['status']) ?><br>
              <strong>Address:</strong> <?= htmlspecialchars($order['address']) ?><br>
              <strong>Order Datetime:</strong> <?= $order['created_at'] ?><br>

              <!-- Truy vấn chi tiết đơn hàng từ bảng order_items -->
              <?php
              $query_order_items = "SELECT * FROM order_items WHERE order_id = :order_id";
              $stmt_items = $conn->prepare($query_order_items);
              $stmt_items->bindParam(':order_id', $order['id'], PDO::PARAM_INT);
              $stmt_items->execute();
              $order_items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);
              ?>
              <table class="table-auto w-full text-left mt-2">
                <thead>
                  <tr>
                    <th class="px-2 py-1">Product Name</th>
                    <th class="px-2 py-1">Quantity</th>
                    <th class="px-2 py-1">Price</th>
                    <th class="px-2 py-1">Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($order_items as $item): ?>
                    <tr>
                      <td class="border px-2 py-1"><?= htmlspecialchars($item['product_id']) ?></td>
                      <td class="border px-2 py-1"><?= $item['quantity'] ?></td>
                      <td class="border px-2 py-1">$<?= number_format($item['price'], 2) ?></td>
                      <td class="border px-2 py-1">$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </li>
            <hr class="my-4">
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p>No orders found.</p>
      <?php endif; ?>
    </div>

    <!-- Logout Button -->
    <form method="POST" id="logout-form" class="flex justify-center">
      <button type="submit" name="logout"
        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200">
        Logout
      </button>
    </form>
  </div>
</div>