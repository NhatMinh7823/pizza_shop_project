<?php

class Order
{
    private $conn;
    private $table = 'orders';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create a new order
    public function createOrder($user_id, $total, $payment_method, $address)
    {
        $query = "INSERT INTO " . $this->table . " (user_id, total, payment_method, address) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id, $total, $payment_method, $address]);

        // Return the last inserted order ID
        return $this->conn->lastInsertId();
    }

    // Add an item to an order
    public function addOrderItem($order_id, $product_id, $quantity, $price)
    {
        $query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$order_id, $product_id, $quantity, $price]);
    }
    public function getOrderDetails($order_id, $user_id)
    {
        // Fetch order details
        $query = "SELECT * FROM orders WHERE id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$order_id, $user_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            return null; // If no order is found, return null
        }

        // Fetch order items and group them by product_id
        $query = "SELECT oi.product_id, p.name, p.image, SUM(oi.quantity) as quantity, oi.price 
              FROM order_items oi
              JOIN products p ON oi.product_id = p.id
              WHERE oi.order_id = ?
              GROUP BY oi.product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$order_id]);
        $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $order['items'] = $orderItems; // Attach items to the order array

        return $order;
    }


}