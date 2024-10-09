<?php
ob_start();
session_start();

// Include file cấu hình (kết nối database)
require_once '../config.php';
// Kiểm tra nếu bấm đăng xuất
if (isset($_POST['logout'])) {
    // Destroy session to log out the user
    session_unset();
    session_destroy();
    // Redirect to the home page but with a URL parameter to show the modal
    header("Location: /index.php?page=home&logout=success");
    exit();
}
// Include các phần như header
require_once '../includes/header.php';
require_once '../views/partials/navbar.php';


// Routing đơn giản thông qua tham số "page"
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Điều hướng tới các trang khác nhau
switch ($page) {
    case 'home':
        include '../pages/home.php';
        break;
    case 'products':
        include '../pages/products.php';
        break;
    case 'product-detail':
        include '../pages/product-detail.php';
        break;
    case 'cart':
        include '../pages/cart.php';
        break;
    case 'checkout':
        include '../pages/checkout.php';
        break;
    case 'login':
        include '../pages/login.php';
        break;
    case 'account':
        include '../pages/account.php';
        break;
    case 'contact':
        include '../pages/contact.php';
        break;
    case 'register':
        include '../pages/register.php';
        break;
    case 'order-success':
        include '../pages/order-success.php';
        break;
    default:
        include '../pages/404.php'; // Trang lỗi 404
        break;
}

require_once '../includes/footer.php';
ob_end_flush();  