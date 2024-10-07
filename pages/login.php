<?php
require_once '../config.php';
require_once '../controllers/UserController.php';

// Khởi tạo UserController
$userController = new UserController($conn);

$error = '';

// Xử lý khi người dùng gửi biểu mẫu đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Kiểm tra đăng nhập
  $user = $userController->login($email, $password);
  if ($user) {
    // Đăng nhập thành công
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    header("Location: /index.php?page=home"); // Điều hướng về trang chủ
    exit();
  } else {
    // Thông tin đăng nhập sai
    $error = "Invalid email or password.";
  }
}
?>

<h1 class="text-center">Login</h1>

<div class="container">
  <form method="POST" action="/index.php?page=login">
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <button type="submit" class="btn btn-primary">Login</button>
  </form>
  <p>Don't have an account? <a href="/index.php?page=register">Register here</a></p>
</div>