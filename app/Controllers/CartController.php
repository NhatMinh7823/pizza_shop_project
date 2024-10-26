<?php

namespace App\Controllers;

use App\Models\Cart;

class CartController extends Controller
{
    protected $cartModel;

    public function __construct($conn)
    {
        parent::__construct();
        $this->cartModel = new Cart($conn);
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . url('/login'));
            exit;
        }

        $cartItems = $this->cartModel->getCartItems($_SESSION['user_id']);
        $_SESSION['cart_count'] = $this->calculateTotalQuantity($cartItems); // Cập nhật tổng số lượng sản phẩm
        $this->sendPage('cart', ['cartItems' => $cartItems]);
    }

    public function addToCart()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . url('/login'));
            exit;
        }

        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'] ?? 1;

        // Thêm sản phẩm vào giỏ hàng
        $this->cartModel->addToCart($_SESSION['user_id'], $product_id, $quantity);

        // Cập nhật tổng số lượng sản phẩm trong giỏ hàng
        $cartItems = $this->cartModel->getCartItems($_SESSION['user_id']);
        $_SESSION['cart_count'] = $this->calculateTotalQuantity($cartItems);

        header('Location: ' . url('/cart'));
        exit;
    }

    public function updateCartItem()
    {
        $cart_id = $_POST['cart_id'];
        $quantity = $_POST['quantity'];

        $this->cartModel->updateCartItem($cart_id, $quantity);

        // Cập nhật tổng số lượng sản phẩm trong giỏ hàng
        $cartItems = $this->cartModel->getCartItems($_SESSION['user_id']);
        $_SESSION['cart_count'] = $this->calculateTotalQuantity($cartItems);

        header('Location: ' . url('/cart'));
        exit;
    }

    public function deleteCartItem()
    {
        $cart_id = $_POST['cart_id'];

        $this->cartModel->deleteCartItem($cart_id);

        // Cập nhật tổng số lượng sản phẩm trong giỏ hàng
        $cartItems = $this->cartModel->getCartItems($_SESSION['user_id']);
        $_SESSION['cart_count'] = $this->calculateTotalQuantity($cartItems);

        header('Location: ' . url('/cart'));
        exit;
    }

    private function calculateTotalQuantity($cartItems)
    {
        $totalQuantity = 0;
        foreach ($cartItems as $item) {
            $totalQuantity += $item['quantity']; // Giả sử mỗi mục có thuộc tính 'quantity'
        }
        return $totalQuantity;
    }
}
