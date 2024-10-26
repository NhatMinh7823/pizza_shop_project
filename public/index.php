<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Bramus\Router\Router;
use League\Plates\Engine;
use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Controllers\CartController;
use App\Controllers\UserController;
use App\Controllers\OrderController;

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload Composer
require_once __DIR__ . '/../config/config.php'; // Load config database
require_once __DIR__ . '/../app/functions.php';
// Bắt đầu session
session_start();
$templates = new Engine(__DIR__ . '/../app/Views');
// Khởi tạo Router
$router = new Router();

// Route cho trang chủ
$router->get('/', function () {
    $controller = new ProductController();
    $controller->showHomePage();
});
$router->get('/home', function () {
    $controller = new ProductController();
    $controller->showHomePage();
});
// Route cho sản phẩm
$router->get('/products', function () {
    $controller = new ProductController();
    $controller->showProductsPage();
});

$router->get('/products/([^/]+)', function ($category_name) {
    $controller = new ProductController();
    $controller->showProductsPage($category_name);
});
$router->get('/product-detail/(\d+)', function ($productId) {
    $controller = new ProductController();
    $controller->showProductDetail($productId);
});
// Route cho đăng nhập
$router->get('/login', function () use ($conn) {
    $controller = new UserController($conn);
    $controller->showLoginForm();
});

$router->post('/login', function () use ($conn) {
    $controller = new UserController($conn);
    $controller->login();
});

$router->get('/register', function () use ($conn) {
    $controller = new UserController($conn);
    $controller->showRegisterForm();
});

$router->post('/register', function () use ($conn) {
    $controller = new UserController($conn);
    $controller->register();
});
$router->get('/account', function () use ($conn) {
    $controller = new UserController($conn);
    $controller->account();
});
$router->post('/logout', function () {
    $controller = new UserController($conn);
    $controller->logout();
});
$router->get('/admin/products', function () {
    $controller = new ProductController();
    $controller->listProducts();
});
// Route cho admin
$router->get('/admin/products/add', function () {
    $controller = new ProductController();
    $controller->addProduct();
});
$router->post('/admin/products/add', function () {
    $controller = new ProductController();
    $controller->addProduct();
});
$router->get('/admin/products/edit/(\d+)', function ($id) {
    $controller = new ProductController();
    $controller->editProduct($id);
});
$router->post('/admin/products/edit/(\d+)', function ($id) {
    $controller = new ProductController();
    $controller->editProduct($id);
});
$router->post('/admin/products/delete/(\d+)', function ($id) {
    $controller = new ProductController();
    $controller->deleteProduct($id);
});


// Route cho cart
$router->get('/cart', function () use ($conn) {
    $controller = new CartController($conn);
    $controller->index();
});

$router->post('/cart/add', function () use ($conn) {
    $controller = new CartController($conn);
    $controller->addToCart();
});

$router->post('/cart/update', function () use ($conn) {
    $controller = new CartController($conn);
    $controller->updateCartItem();
});

$router->post('/cart/delete', function () use ($conn) {
    $controller = new CartController($conn);
    $controller->deleteCartItem();
});

// Route cho cart
// $router->get('/checkout', function () use ($conn) {
//     $controller = new OrderController($conn);
//     $controller->checkout();
// });

// $router->post('/checkout', function () use ($conn) {
//     $controller = new OrderController($conn);
//     $controller->placeOrder();
// });

// $router->get('/order-success', function () {
//     $controller = new OrderController(null);
//     $controller->orderSuccess();
// });
$router->post('/place-order', function () use ($conn) {
    $controller = new OrderController($conn);
    $controller->placeOrder();
});
$router->get('/checkout', function () use ($conn) {
    $orderController = new OrderController($conn);
    $orderController->checkout();
});

$router->post('/place-order', function () use ($conn) {
    $orderController = new OrderController($conn);
    $orderController->placeOrder();
});

$router->get('/order-success', function () use ($conn) {
    $orderController = new OrderController($conn);
    $orderController->orderSuccess();
});

// Chạy Router
$router->run();
