<?php
require_once '../config.php';
require_once '../controllers/UserController.php';

// Khởi tạo UserController
$userController = new UserController($conn);

$error = '';
$success = '';

// Xử lý khi người dùng gửi biểu mẫu đăng ký
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra xem mật khẩu và xác nhận mật khẩu có khớp không
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Đăng ký người dùng
        if ($userController->register($name, $email, $password)) {
            $success = "Registration successful. You can now login.";
            header('Location: /index.php?page=login');
            exit;
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<h1 class="text-center text-3xl font-bold mt-10">Register</h1></br>
<div class="container mx-auto max-w-md p-8 bg-white shadow-lg rounded-lg">
    <form method="POST" action="/index.php?page=register">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary w-full p-2 bg-blue-500 hover:bg-blue-200 text-white font-bold rounded-md transition duration-50">Register</button>
    </form>
    <p class="text-center mt-6">Already have an account? <a href="/index.php?page=login" class="text-blue-500 hover:underline">Login here</a></p>
</div></br>