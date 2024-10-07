<?php

class User
{
    private $conn;
    private $table = 'users';

    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Đăng ký người dùng mới
    public function register($name, $email, $password)
    {
        // Mã hóa mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO " . $this->table . " (name, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$name, $email, $hashed_password]);
    }

    // Kiểm tra thông tin đăng nhập
    public function login($email, $password)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kiểm tra mật khẩu
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Trả về thông tin người dùng nếu đăng nhập thành công
        }
        return false; // Sai thông tin đăng nhập
    }

    // Lấy thông tin người dùng dựa trên ID
    public function getUserById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
