<?php
require_once '../config.php'; // Database connection
require_once '../controllers/UserController.php';

// Khởi tạo UserController
$userController = new UserController($conn);

$error = '';

// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION['user_id'])) {
  // Người dùng đã đăng nhập, điều hướng về trang chủ
  header("Location: /index.php?page=home");
  exit();
}

// Xử lý khi người dùng gửi biểu mẫu đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Kiểm tra đăng nhập
  $user = $userController->login($email, $password);

  if ($user) {
    // Đăng nhập thành công
    $_SESSION['user_id'] = $user['id']; // Lưu ID người dùng vào session
    $_SESSION['user_name'] = $user['name']; // Lưu tên người dùng vào session
    $_SESSION['user_email'] = $user['email']; // Lưu tên người dùng vào session
    header("Location: /index.php?page=home"); // Điều hướng về trang chủ
    exit();
  } else {
    // Thông tin đăng nhập sai
    $error = "Invalid email or password.";
  }
}
?>

<!-- Giao diện người dùng -->
<h1 class="text-center text-3xl font-bold mt-10">Login</h1></br>
<!-- <p class="text-center text-xl mb-10 text-gray-600">Xin hãy vui lòng đăng nhập để sử dụng các chức năng mua hàng</p> -->
<div class="container mx-auto max-w-md p-8 bg-white shadow-lg rounded-lg">
  <form method="POST" action="/index.php?page=login">
    <div class="form-group mb-4">
      <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
      <input type="email" name="email" class="form-control w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400" required>
    </div>
    <div class="form-group mb-4">
      <label for="password" class="block text-gray-700 font-bold mb-2">Password:</label>
      <input type="password" name="password" class="form-control w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400" required>
    </div>
    <?php if ($error): ?>
      <div class="alert alert-danger mt-4"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <button type="submit" class="btn btn-primary w-full p-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-md transition duration-200">Login</button>
  </form>
  <p class="text-center mt-6">Don't have an account? <a href="/index.php?page=register" class="text-blue-500 hover:underline">Register here</a></p>
</div></br>