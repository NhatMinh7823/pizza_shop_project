<!-- pages/product-detail.php -->
<?php
require_once '../config.php';
require_once '../controllers/cartController.php';
$cartController = new CartController($conn);

// Assume user_id is stored in the session
if (!isset($_SESSION['user_id'])) {
  // Nếu người dùng chưa đăng nhập, chuyển hướng họ đến trang đăng nhập
  header('Location: /index.php?page=login');
  exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute(['id' => $product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $quantity = $_POST['quantity'];
  $cartController->addToCart($user_id, $product_id, $quantity);
  header("Location: /index.php?page=cart");
  exit;
}
?>

<div class="container my-5">
  <h1><?php echo $product['name']; ?></h1>
  <p><?php echo $product['description']; ?></p>
  <h3>$<?php echo $product['price']; ?></h3>
  <form method="POST" action="/index.php?page=product-detail&id=<?php echo $product_id; ?>">
    <div class="form-group">
      <label for="quantity">Quantity:</label>
      <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1">
    </div>
    <button type="submit" class="btn btn-primary">Add to Cart</button>
  </form>
</div>