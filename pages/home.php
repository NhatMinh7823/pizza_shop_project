<?php
// Kết nối database và nạp model Product
require_once '../config.php';
require_once '../models/Product.php';

// Khởi tạo đối tượng Product
$productModel = new Product($conn);

// Lấy 3 sản phẩm ngẫu nhiên
$randomProducts = $productModel->getRandomProducts(3);

// Lấy 1 sản phẩm giảm giá có thời gian còn lại
$discountProduct = $productModel->getDiscountProduct();
?>

<div class="container my-5">
  <!-- Phần jumbotron chào mừng -->
  <div class="jumbotron text-center bg-info text-white">
    <h1 class="display-4">Welcome to MinhToan Pizza Store !</h1>
    <p class="lead">Delicious pizzas made with the finest ingredients. Order now!</p></br>
    <a class="btn btn-primary btn-lg" href="/index.php?page=products" role="button">Go shopping now</a>
  </div>

  <!-- Phần sản phẩm giảm giá -->
  <h2 class="text-center my-5 font-bold">Special Discount Offer</h2>
  <?php foreach ($discountProduct as $product): ?>
    <div class="card mb-4">
      <div class="row no-gutters">
        <div class="col-md-4">
          <div style="display: flex; justify-content: center; align-items: center;">
            <img src="/images/<?php echo htmlspecialchars($product['image']); ?>"
              class="card-img" style="width: 55%; height: auto;"
              alt="<?php echo htmlspecialchars($product['name']); ?>">
          </div>
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title"><?php echo $product['name']; ?></h5>
            <p class="card-text"><?php echo $product['description']; ?></p>
            <p class="card-text">
              <small class="text-muted">Original Price: $<?php echo $product['price']; ?></small><br>
              <strong>Discounted Price: $<?php echo $product['discount']; ?></strong>
            </p>
            <p class="card-text text-danger" id="discount-timer">Limited Time Offer!</p></br>
            <a href="/index.php?page=product-detail&id=<?php echo $product['id']; ?>" class="btn btn-danger">Buy now</a>
            <script>
              // JavaScript cho đếm ngược thời gian khuyến mãi
              function countdownTimer(endTime) {
                var countDownDate = new Date(endTime).getTime();

                var x = setInterval(function() {
                  var now = new Date().getTime();
                  var distance = countDownDate - now;

                  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                  document.getElementById("discount-timer").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";

                  if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("discount-timer").innerHTML = "EXPIRED";
                  }
                }, 1000);
              }

              countdownTimer('<?php echo $discountProduct['discount_end_time']; ?>');
            </script>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>

  <!-- Phần hiển thị 3 pizza ngẫu nhiên -->
  <h2 class="text-center my-5 font-bold">Featured Pizzas</h2>
  <div class="row">
    <?php foreach ($randomProducts as $product): ?>
      <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card">
          <img src="/images/<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo $product['name']; ?></h5>
            <p class="card-text"><?php echo $product['description']; ?></p>
            <a href="/index.php?page=product-detail&id=<?php echo $product['id']; ?>"
              class="btn btn-primary btn-block">View Details</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<div id="logout-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
  <div class="bg-white shadow-lg rounded-lg max-w-md p-6 text-center">
    <h2 class="text-2xl font-bold mb-4">Bạn đã đăng xuất thành công!</h2>
    <p class="mb-6 text-gray-600">Nếu muốn đặt hàng, xin hãy Đăng nhập hoặc Đăng ký.</p>
    <div class="flex justify-center space-x-4">
      <a href="/index.php?page=login"
        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Đăng nhập</a>
      <a href="/index.php?page=home"
        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200">Tiếp tục ở trang chủ</a>
    </div>
  </div>
</div>