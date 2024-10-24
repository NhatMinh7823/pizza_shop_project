<?php
require_once '../models/User.php';

class UserController
{
  private $userModel;

  public function __construct($db)
  {
    $this->userModel = new User($db);
  }

  // Xử lý đăng ký
  public function register($name, $email, $password)
  {
    // Mã hóa mật khẩu trước khi lưu vào database
    return $this->userModel->register($name, $email, password_hash($password, PASSWORD_DEFAULT));
  }

  // Xử lý đăng nhập
  public function login($email, $password)
  {
    // Lấy thông tin người dùng từ database
    $user = $this->userModel->login($email);

    // Kiểm tra nếu thông tin người dùng tồn tại và mật khẩu đúng
    if ($user && password_verify($password, $user['password'])) {
      // Lưu thông tin người dùng vào session
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_name'] = $user['name'];
      $_SESSION['user_role'] = $user['role']; // Lưu vai trò của người dùng (admin/customer)
      $_SESSION['user_email'] = $user['email'];
      return true;
    }
    return false;
  }

  // Lấy thông tin người dùng theo ID
  public function getUserById($id)
  {
    return $this->userModel->getUserById($id);
  }
}
