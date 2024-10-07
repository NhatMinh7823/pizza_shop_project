<?php // controllers/orderController.php
session_start();
include('../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $address = $_POST['address'];
  $payment_method = $_POST['payment_method'];
  $cartItems = $_SESSION['cart'];
  $total = array_sum(array_map(function($item) {
    return $item['quantity'] * $item['price'];
  }, $cartItems));

  // Lưu đơn hàng vào database
  $stmt = $conn->prepare("INSERT INTO orders (name, address, payment_method, total) VALUES (:name, :address, :payment_method, :total)");
  $stmt->execute([
    'name' => $name,
    'address' => $address,
    'payment_method' => $payment_method,
    'total' => $total
  ]);

  // Xóa giỏ hàng sau khi đặt hàng thành công
  unset($_SESSION['cart']);
  header('Location: ../pages/order-success.php');
}