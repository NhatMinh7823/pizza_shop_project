<?php
require_once '../config.php';
require_once '../controllers/ProductController.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: /index.php?page=login");
    exit();
}

$productController = new ProductController($conn);
$categories = $productController->getDistinctCategories();
$product_id = $_GET['id'];
$product = $productController->getProductDetails($product_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_name = $_POST['category_name'];
    $image = $_FILES['image']['name'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $file_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        // Kiểm tra định dạng file ảnh
        if (in_array(strtolower($file_ext), $allowed)) {
            // Đặt tên duy nhất cho ảnh bằng cách sử dụng thời gian và tên gốc
            $image = time() . '_' . $_FILES['image']['name'];

            // Kiểm tra việc tải ảnh lên thư mục
            if (move_uploaded_file($_FILES['image']['tmp_name'], "images/$image")) {
                // Thêm sản phẩm mới
                $productController->updateProduct($product_id, $name, $description, $price, $image, $category_name);
                header("Location: /index.php?page=admin");
                exit();
            } else {
                // Thông báo lỗi nếu không thể tải ảnh lên
                $error = "Failed to upload the image. Please try again.";
            }
        } else {
            $error = "Invalid file format. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    } else {
        $error = "Image upload error. Please try again.";
    }
}
?>

<h1 class="text-center">Edit Product</h1>

<div class="container">
    <form action="/index.php?page=edit&id=<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required><?= htmlspecialchars($product['description']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" class="form-control" value="<?= htmlspecialchars($product['price']) ?>" required>
        </div>
        <div class="form-group">
            <label for="category_name">Category</label>
            <select name="category_name" class="form-control" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['category_name'] ?>"><?= htmlspecialchars($category['category_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="image">Product Image</label>
            <input type="file" name="image" class="form-control">
            <img src="/images/<?= htmlspecialchars($product['image']) ?>"
                             alt="<?= htmlspecialchars($product['name']) ?>" width="100">
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>
