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
    return $this->userModel->register($name, $email, $password);
  }

  // Xử lý đăng nhập
  public function login($email, $password)
  {
    return $this->userModel->login($email, $password);
  }

  // Lấy thông tin người dùng theo ID
  public function getUserById($id)
  {
    return $this->userModel->getUserById($id);
  }
}
