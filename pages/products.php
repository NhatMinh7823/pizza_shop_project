<?php
require_once '../config.php';
require_once '../controllers/ProductController.php';
require_once '../controllers/CartController.php';

// Khởi tạo đối tượng Product
$productController = new ProductController($conn);
$cartController = new CartController($conn);

// Assume user_id is stored in the session
// session_start(); // Đảm bảo rằng session được bắt đầu

// if (!isset($_SESSION['user_id'])) {
//     // Nếu người dùng chưa đăng nhập, chuyển hướng họ đến trang đăng nhập
//     header('Location: /index.php?page=login');
//     exit;
// }

// $user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $cartController->addToCart($user_id, $product_id, $quantity);
    header("Location: /index.php?page=products"); // Redirect to avoid form resubmission on refresh
    exit();
}
// Lấy tất cả danh mục sản phẩm
$categories = $productController->getCategories();

// Lấy danh mục người dùng chọn (nếu có)
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

// Nếu người dùng chọn danh mục, hiển thị sản phẩm thuộc danh mục đó
$products = $productController->listProducts($category_id);
?>

<!-- Thanh tiêu đề -->
<h1 class="text-center mt-4 text-3xl font-bold text-gray-800 tracking-wider">Our Pizza Menu</h1>

<!-- Phân loại sản phẩm -->
<div class="text-center mb-4">
    <a href="/index.php?page=products"
        class="btn <?= !$category_id ? 'btn-primary' : 'btn-outline-primary' ?> m-1">All</a>
    <?php foreach ($categories as $category): ?>
        <a href="/index.php?page=products&category_id=<?= $category['id'] ?>"
            class="btn <?= ($category_id == $category['id']) ? 'btn-primary' : 'btn-outline-primary' ?> m-1">
            <?= htmlspecialchars($category['name']) ?>
        </a>
    <?php endforeach; ?>
</div>

<!-- Danh sách sản phẩm -->
<div class="container mx-auto">
    <div class="row">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 col-sm-6 p-4">
                    <div
                        class="card h-full bg-white rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300 ease-in-out">
                        <img class="card-img-top" src="/images/<?= htmlspecialchars($product['image']) ?>"
                            alt="<?= htmlspecialchars($product['name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title text-xl font-bold text-gray-800"><?= htmlspecialchars($product['name']) ?>
                            </h5>
                            <p class="card-text text-gray-600"><?= htmlspecialchars($product['description']) ?></p>
                            <p class="card-text text-danger text-lg font-semibold">$<?= htmlspecialchars($product['price']) ?>
                            </p>
                            <a href="/index.php?page=product-detail&id=<?= $product['id'] ?>" class="btn btn-primary mt-2">View
                                Details</a>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="quantity" value="1"> <!-- Default quantity of 1 -->
                                <button type="submit" name="add_to_cart" class="btn btn-warning mt-2">Add to Cart</button>
                            </form>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-xl text-gray-700">No products found.</p>
        <?php endif; ?>
    </div>
</div>