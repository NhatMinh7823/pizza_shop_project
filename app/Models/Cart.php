<?php

namespace App\Models;

use PDO;

class Cart
{
    private $conn;
    private static $table = 'cart';
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Lấy tất cả các sản phẩm trong giỏ hàng của người dùng
    public function getCartItems($user_id)
    {
        $query = "SELECT c.id, c.product_id, c.quantity, p.name, p.price, p.image 
                  FROM cart c
                  JOIN products p ON c.product_id = p.id 
                  WHERE c.user_id = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCartItemsForCheckout($user_id)
    {
        $sql = "SELECT c.product_id, c.quantity, p.name, p.price, (c.quantity * p.price) AS total_price 
                FROM " . self::$table . " c
                JOIN products p ON c.product_id = p.id
                WHERE c.user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($user_id, $product_id, $quantity)
    {
        $query = "INSERT INTO cart (user_id, product_id, quantity) 
                  VALUES (:user_id, :product_id, :quantity)
                  ON DUPLICATE KEY UPDATE quantity = quantity + :quantity";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCartItem($cart_id, $quantity)
    {
        $query = "UPDATE cart SET quantity = :quantity WHERE id = :cart_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function deleteCartItem($cart_id)
    {
        $query = "DELETE FROM cart WHERE id = :cart_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Xóa toàn bộ giỏ hàng của người dùng
    public function clearUserCart($user_id)
    {
        $query = "DELETE FROM cart WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
