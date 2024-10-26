<?php

namespace App\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;

class OrderController extends Controller
{
  protected $orderModel;
  protected $cartModel;
  protected $productModel;

  public function __construct($conn)
  {
    parent::__construct();
    $this->orderModel = new Order($conn);
    $this->cartModel = new Cart($conn);
    $this->productModel = new Product($conn);
  }

  public function checkout()
  {
    if (!isset($_SESSION['user_id'])) {
      header('Location: /login');
      exit;
    }

    $user_id = $_SESSION['user_id'];
    $cartItems = $this->cartModel->getCartItemsForCheckout($user_id);
    $total = array_sum(array_column($cartItems, 'total_price'));

    $this->sendPage('/checkout', [
      'cartItems' => $cartItems,
      'total' => $total
    ]);
  }

  public function placeOrder()
  {
    if (!isset($_SESSION['user_id'])) {
      header('Location: /login');
      exit;
    }

    $user_id = $_SESSION['user_id'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];
    $cartItems = $this->cartModel->getCartItemsForCheckout($user_id);

    $total = array_sum(array_column($cartItems, 'total_price'));

    try {
      $this->orderModel->createOrder($user_id, $total, $address, $payment_method, $cartItems);
      $this->cartModel->clearUserCart($user_id);

      header('Location: /order-success');
      exit;
    } catch (\Exception $e) {
      echo "Order processing failed: " . $e->getMessage();
    }
  }

  public function orderSuccess()
  {
    $this->sendPage('/order-success');
  }
  
}
