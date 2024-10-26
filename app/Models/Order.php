<?php

namespace App\Models;

use PDO;

class Order
{
    private $conn;
    private static $table = 'orders';

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function createOrder($user_id, $total, $address, $payment_method, $cartItems)
    {
        $this->conn->beginTransaction();
        try {
            $order_id = time() + rand(1000, 9999);

            foreach ($cartItems as $item) {
                $sql = "INSERT INTO " . self::$table . " (order_id, user_id, total, payment_method, address, product_id, product_name, quantity, price)
                        VALUES (:order_id, :user_id, :total, :payment_method, :address, :product_id, :product_name, :quantity, :price)";
                $stmt = $this->conn->prepare($sql);

                $stmt->execute([
                    ':order_id' => $order_id,
                    ':user_id' => $user_id,
                    ':total' => $total,
                    ':payment_method' => $payment_method,
                    ':address' => $address,
                    ':product_id' => $item['product_id'],
                    ':product_name' => $item['name'],
                    ':quantity' => $item['quantity'],
                    ':price' => $item['price']
                ]);
            }

            $this->conn->commit();
            return true;
        } catch (\PDOException $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }
    public function getUserOrders($user_id)
    {
        $sql = "SELECT order_id, total, payment_method, status, address, created_at 
                FROM " . self::$table . " 
                WHERE user_id = :user_id 
                GROUP BY order_id 
                ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
