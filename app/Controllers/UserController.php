<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Order;

class UserController extends Controller
{
  protected $userModel;
  protected $orderModel;
  public function __construct($conn)
  {
    parent::__construct();
    $this->userModel = new User($conn);
    $this->orderModel = new Order($conn);
  }

  public function showLoginForm()
  {
    $this->sendPage('user/login', [
      'error' => $_SESSION['error'] ?? null
    ]);
    unset($_SESSION['error']);
  }

  public function login()
  {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Thực hiện đăng nhập
    if ($this->userModel->attemptLogin($email, $password)) {
      // Lấy thông tin người dùng
      $user = $this->userModel->getUserByEmail($email);

      // Thiết lập thông tin người dùng vào session
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_name'] = $user['name'];
      $_SESSION['user_email'] = $user['email'];
      $_SESSION['user_role'] = $user['role'];
      $_SESSION['user_phone'] = $user['phone'];
      $_SESSION['user_address'] = $user['address'];
      // Điều hướng về trang chủ
      header('Location: /');
      exit;
    } else {
      // Lưu lỗi vào session nếu đăng nhập không thành công
      $_SESSION['error'] = "Email hoặc mật khẩu không đúng.";
      header('Location: /login');
      exit;
    }
  }
  // public function account()
  // {
  //   if (!isset($_SESSION['user_id'])) {
  //     header('Location: ' . url('/login'));
  //     exit;
  //   }

  //   $this->sendPage('user/account', [
  //     'user_name' => $_SESSION['user_name'],
  //     'user_email' => $_SESSION['user_email'],
  //     'user_role' => $_SESSION['user_role'],
  //   ]);
  // }
  public function account()
  {
    if (!isset($_SESSION['user_id'])) {
      header('Location: ' . url('/login'));
      exit;
    }

    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $user_email = $_SESSION['user_email'];
    $user_role = $_SESSION['user_role'];
    $user_phone = $_SESSION['user_phone'] ?? 'Chưa thêm';
    $user_address = $_SESSION['user_address'] ?? 'Chưa thêm';

    // Lấy lịch sử đơn hàng của người dùng
    $orderHistory = $this->orderModel->getUserOrders($user_id);

    $this->sendPage('user/account', [
      'user_name' => $user_name,
      'user_email' => $user_email,
      'user_role' => $user_role,
      'user_phone' => $user_phone,
      'user_address' => $user_address,
      'orderHistory' => $orderHistory
    ]);
  }
  public function showRegisterForm()
  {
    $this->sendPage('user/register', [
      'error' => $_SESSION['error'] ?? null
    ]);
    unset($_SESSION['error']);
  }

  public function register()
  {
    $data = [
      'name' => $_POST['name'],
      'email' => $_POST['email'],
      'password' => $_POST['password'],
      'confirm_password' => $_POST['confirm_password']
    ];

    // Kiểm tra mật khẩu và mật khẩu xác nhận
    if ($data['password'] !== $data['confirm_password']) {
      $_SESSION['error'] = 'Password and Confirm Password do not match.';
      header('Location: ' . url('/register'));
      exit;
    }

    // Mã hóa mật khẩu và lưu vào cơ sở dữ liệu
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

    if ($this->userModel->create($data)) {
      $_SESSION['success'] = 'Registration successful! Please log in.';
      header('Location: ' . url('/login'));
      exit;
    } else {
      $_SESSION['error'] = 'Registration failed. Please try again.';
      header('Location: ' . url('/register'));
      exit;
    }
  }
  public function logout()
  {
    // Hủy tất cả các session
    session_unset();
    session_destroy();

    // Điều hướng về trang đăng nhập
    header('Location: ' . url('/login'));
    exit();
  }

}
