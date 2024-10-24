<?php
require_once '../models/Order.php';

class OrderController
{
  private $orderModel;

  public function __construct($db)
  {
    $this->orderModel = new Order($db);
  }

  // Tạo đơn hàng mới
  public function createOrder($user_id, $total, $payment_method, $address)
  {
    return $this->orderModel->createOrder($user_id, $total, $payment_method, $address);
  }

  // Thêm sản phẩm vào đơn hàng
  public function addOrderItem($order_id, $product_id, $quantity, $price)
  {
    $this->orderModel->addOrderItem($order_id, $product_id, $quantity, $price);
  }

  public function getOrderDetails($order_id, $user_id)
  {
    return $this->orderModel->getOrderDetails($order_id, $user_id);
  }

  public function getOrdersByUserId($user_id)
  {
    return $this->orderModel->getOrdersByUserId($user_id);
  }
}
