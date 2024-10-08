<?php
require_once '../config.php';
require_once '../controllers/ProductController.php';

// Khởi tạo ProductController
$productController = new ProductController($conn);

// Lấy ID sản phẩm từ URL
$product_id = isset($_GET['id']) ? $_GET['id'] : null;
$product = $productController->getProductDetails($product_id);

// Kiểm tra nếu sản phẩm không tồn tại
if (!$product) {
    echo "<h1 class='text-center mt-5'>Product not found</h1>";
    exit();
}
?>

<div class="container my-5">
    <div class="row">
        <!-- Hình ảnh sản phẩm -->
        <div class="col-md-6">
            <img src="/images/<?php echo htmlspecialchars($product['image']); ?>" class="img-fluid rounded-lg shadow-lg" alt="<?php echo htmlspecialchars($product['name']); ?>">
        </div>

        <!-- Chi tiết sản phẩm -->
        <div class="col-md-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-3"><?php echo htmlspecialchars($product['name']); ?></h1>
            <p class="text-lg text-gray-600 mb-3"><?php echo htmlspecialchars($product['description']); ?></p>
            <h3 class="text-2xl font-semibold text-danger mb-4">$<?php echo htmlspecialchars($product['price']); ?></h3>

            <!-- Form thêm vào giỏ hàng -->
            <form method="POST" class="add-to-cart-form" style="display:inline;">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <div class="form-group mb-4">
                    <label for="quantity" class="text-lg font-semibold">Quantity:</label>
                    <input type="number" class="form-control w-25" id="quantity" name="quantity" value="1" min="1">
                </div>
                <button type="button" class="btn btn-primary add-to-cart-button">Add to Cart</button>
            </form>
        </div>
    </div>

    <!-- Sản phẩm liên quan ngẫu nhiên -->
    <div class="related-products mt-5">
        <h2 class="text-center text-2xl font-bold text-gray-800">You May Also Like</h2>
        <div class="row">
            <?php
            $relatedProducts = $productController->getRandomProducts(3); // Lấy 3 sản phẩm ngẫu nhiên
            foreach ($relatedProducts as $relatedProduct):
            ?>
                <div class="col-md-4 col-sm-6 p-4">
                    <div class="card h-full bg-white rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300 ease-in-out">
                        <img class="card-img-top" src="/images/<?php echo htmlspecialchars($relatedProduct['image']); ?>"
                             alt="<?php echo htmlspecialchars($relatedProduct['name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title text-xl font-bold text-gray-800"><?php echo htmlspecialchars($relatedProduct['name']); ?></h5>
                            <p class="card-text text-danger font-semibold">$<?php echo htmlspecialchars($relatedProduct['price']); ?></p>
                            <a href="/index.php?page=product-detail&id=<?php echo $relatedProduct['id']; ?>" class="btn btn-primary mt-2">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
