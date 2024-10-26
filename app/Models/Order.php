<?php

class Order
{
    private $conn;
    private $table = 'orders';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Tạo đơn hàng mới
    public function createOrder($user_id, $total, $payment_method, $address)
    {
        $query = "INSERT INTO orders (user_id, total, payment_method, address, status) VALUES (?, ?, ?, ?, 'pending')";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id, $total, $payment_method, $address]);

        return $this->conn->lastInsertId(); // Trả về order_id vừa tạo
    }

    // Thêm sản phẩm vào đơn hàng
    public function addOrderItem($order_id, $product_id, $quantity, $price)
    {
        $query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$order_id, $product_id, $quantity, $price]);
    }

    // Lấy thông tin chi tiết đơn hàng
    public function getOrderDetails($order_id, $user_id)
    {
        $query = "SELECT * FROM orders WHERE id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$order_id, $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về thông tin đơn hàng

        // Nếu cần lấy thông tin sản phẩm trong đơn hàng, nên thực hiện một truy vấn khác từ bảng order_items
    }

    public function getOrdersByUserId($user_id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

