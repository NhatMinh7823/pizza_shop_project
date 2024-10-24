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
        // Mã hóa mật khẩu đã được thực hiện trước khi gọi hàm này
        $query = "INSERT INTO " . $this->table . " (name, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$name, $email, $password]);
    }

    // Kiểm tra thông tin đăng nhập
    public function login($email)
    {
        // Truy vấn người dùng theo email
        $query = "SELECT * FROM " . $this->table . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về thông tin người dùng để xác thực
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
