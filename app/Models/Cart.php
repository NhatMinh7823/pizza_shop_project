<?php

namespace App\Models;

use PDO;

class Cart
{
    private PDO $conn;
    private string $table = 'cart';

    private int $id;
    private int $user_id;
    private int $product_id;
    private int $quantity;
    private string $created_at;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    // Lấy tất cả sản phẩm trong giỏ hàng của người dùng
    public function getCartItems(int $user_id): array
    {
        $query = "SELECT c.id, c.product_id, c.quantity, p.name, p.price, p.image 
                  FROM " . $this->table . " c 
                  JOIN products p ON c.product_id = p.id 
                  WHERE c.user_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(int $user_id, int $product_id, int $quantity): bool
    {
        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $query = "SELECT id FROM " . $this->table . " WHERE user_id = ? AND product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id, $product_id]);

        if ($stmt->rowCount() > 0) {
            // Nếu sản phẩm đã có, tăng số lượng
            $query = "UPDATE " . $this->table . " SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$quantity, $user_id, $product_id]);
        } else {
            // Nếu sản phẩm chưa có, thêm mới vào giỏ hàng
            $query = "INSERT INTO " . $this->table . " (user_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$user_id, $product_id, $quantity]);
        }
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCartItem(int $cart_id, int $quantity): bool
    {
        $query = "UPDATE " . $this->table . " SET quantity = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$quantity, $cart_id]);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function deleteCartItem(int $cart_id): bool
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$cart_id]);
    }

    // Xóa toàn bộ giỏ hàng của người dùng
    public function clearUserCart(int $user_id): bool
    {
        $query = "DELETE FROM " . $this->table . " WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$user_id]);
    }
}
