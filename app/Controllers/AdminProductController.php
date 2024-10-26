<?php
require_once '../models/Cart.php';

class CartController
{
  private $cartModel;

  public function __construct($db)
  {
    $this->cartModel = new Cart($db);
  }

  // Lấy danh sách sản phẩm trong giỏ hàng
  public function viewCart($user_id)
  {
    return $this->cartModel->getCartItems($user_id);
  }

  // Thêm sản phẩm vào giỏ hàng
  public function addToCart($user_id, $product_id, $quantity)
  {
    return $this->cartModel->addToCart($user_id, $product_id, $quantity);
  }

  // Cập nhật số lượng sản phẩm trong giỏ hàng
  public function updateCartItem($cart_id, $quantity)
  {
    return $this->cartModel->updateCartItem($cart_id, $quantity);
  }

  // Xóa sản phẩm khỏi giỏ hàng
  public function deleteCartItem($cart_id)
  {
    return $this->cartModel->deleteCartItem($cart_id);
  }

  public function clearCart($user_id)
  {
    $this->cartModel->clearUserCart($user_id);
  }

}
