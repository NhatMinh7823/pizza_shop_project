<?php $this->layout('shared/layout', ['title' => 'Home']) ?>

<div class="container mx-auto px-12">
  <!-- Jumbotron -->
  <div class="bg-gradient-to-r from-blue-500 to-blue-700 text-white text-center p-10 rounded-2xl shadow-2xl mt-8">
    <h1 class="text-5xl font-extrabold mb-4 drop-shadow-lg">Welcome to Lover's Hub!</h1>
    <p class="mt-2 text-lg font-light">Delicious pizzas made with the finest ingredients. Order now!</p>
    <a href="/products" class="mt-6 inline-block bg-yellow-500 hover:bg-red-600 text-white px-6 py-3 rounded-xl text-lg transition duration-300 transform hover:-translate-y-1 hover:scale-105 shadow-lg">Go shopping now</a>
  </div>

  <!-- Discount Products -->
  <h2 class="text-4xl font-extrabold text-center my-10 text-blue-700 drop-shadow-lg">Special Discount Offer</h2>

  <?php if (!empty($discountProduct)): ?>
    <?php foreach ($discountProduct as $product): ?>
      <div class="relative bg-white rounded-2xl shadow-xl mb-8 p-6 transition-transform transform hover:scale-105 hover:shadow-2xl duration-300">
        <!-- Banner ưu đãi giới hạn -->
        <div class="absolute top-4 left-4 bg-red-500 text-white text-xl font-bold py-1 px-2 rounded-lg">Ưu đãi giới hạn</div>

        <!-- Icon trái tim nổi bật -->
        <div class="absolute top-4 right-4 bg-pink-500 text-white p-1 rounded-full shadow-md">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
            <path d="M3.172 3.172a4 4 0 015.656 0L10 4.344l1.172-1.172a4 4 0 115.656 5.656l-6.83 6.83a1 1 0 01-1.414 0l-6.83-6.83a4 4 0 010-5.656z" />
          </svg>
        </div>

        <div class="flex justify-center">
          <div class="flex-shrink-0 w-1/3 flex justify-center items-center">
            <img src="/images/<?php echo htmlspecialchars($product['image']); ?>"
              class="w-3/5 h-auto mx-auto object-cover rounded-lg transition duration-500 ease-in-out transform hover:rotate-12 hover:scale-110"
              alt="<?php echo htmlspecialchars($product['name']); ?>">
          </div>

          <div class="flex-grow p-4">
            <h5 class="text-3xl font-extrabold text-gray-800 mb-2"><?php echo htmlspecialchars($product['name']); ?></h5>
            <p class="text-gray-700"><?php echo htmlspecialchars($product['description']); ?></p>
            <div class="flex items-center mb-2">
              <span class="text-yellow-500 text-xl">&#9733;&#9733;&#9733;&#9733;&#9734;</span>
              <span class="text-gray-600 ml-2">(120 đánh giá)</span>
            </div>
            <p class="mt-2 mb-2">
              <small class="text-gray-600 line-through">Giá gốc: $<?php echo htmlspecialchars($product['price']); ?></small><br>
              <strong class="text-blue-500 text-2xl font-bold">Giá ưu đãi: </strong>
              <span class="text-red-600 text-3xl font-bold">$<?php echo htmlspecialchars($product['discount']); ?></span>
            </p>

            <!-- Đồng hồ đếm ngược dạng văn bản -->
            <div id="countdown-<?php echo $product['id']; ?>" class="text-center text-lg font-semibold text-red-600 mb-4">Đang tải...</div>

            <form method="POST" action="/index.php?page=cart&action=add" class="add-to-cart-form" style="display:inline;">
              <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']); ?>">
              <input type="hidden" name="quantity" value="1">
              <a href="/product-detail/<?= $product['id']; ?>" class="mt-3 inline-block px-4 py-2 bg-red-600 text-white font-semibold rounded hover:bg-red-700 transition duration-300">Mua ngay</a>
            </form>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p class="text-center text-gray-700">Hiện tại chưa có sản phẩm giảm giá.</p>
  <?php endif; ?>
</div>

<script>
  function startTextCountdown(endTime, elementId) {
    const endTimeMs = new Date(endTime).getTime();

    if (isNaN(endTimeMs)) {
      console.log("Lỗi: Thời gian kết thúc không hợp lệ cho", elementId);
      document.getElementById(elementId).innerText = "Thời gian không hợp lệ";
      return;
    }

    const interval = setInterval(() => {
      const now = new Date().getTime();
      const remainingTime = endTimeMs - now;

      if (remainingTime <= 0) {
        clearInterval(interval);
        document.getElementById(elementId).innerText = "Hết giờ giảm giá!";
        return;
      }

      const hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

      document.getElementById(elementId).innerText = `${hours}h ${minutes}m ${seconds}s`;
    }, 1000);
  }

  <?php foreach ($discountProduct as $product): ?>
    startTextCountdown('<?php echo $product['discount_end_time']; ?>', 'countdown-<?php echo $product['id']; ?>');
  <?php endforeach; ?>
</script>


<!-- Featured Pizzas -->
<h2 class="text-4xl font-extrabold text-center my-10 text-blue-700 drop-shadow-lg">Featured Pizzas</h2>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-6">
  <?php foreach ($randomProducts as $product): ?>
    <div class="bg-white rounded-2xl shadow-lg transition-transform transform hover:scale-105">
      <img src="/images/<?php echo htmlspecialchars($product['image']); ?>"
        class="w-3/5 h-auto mx-auto object-cover rounded-lg transition duration-500 ease-in-out transform hover:rotate-12 hover:scale-110"
        alt="<?php echo htmlspecialchars($product['name']); ?>">
      <div class="p-6">
        <h5 class="text-xl font-bold mb-2 text-center"><?php echo htmlspecialchars($product['name']); ?></h5>
        <p class="card-text text-sm text-gray-600 text-center mb-4"><?php echo htmlspecialchars($product['description']); ?></p>
        <div class="text-center mt-auto mb-2">
          <a href="/product-detail/<?= $product['id']; ?>"
            class="bg-blue-500 text-white px-5 py-2 rounded-lg transition duration-300 hover:bg-green-500 shadow-lg">View Details</a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
</div>


<!-- Logout Modal -->
<div id="logout-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
  <div class="bg-white shadow-2xl rounded-xl max-w-xl w-full p-10 text-center transform scale-95 transition-transform duration-300">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">You have successfully logged out!</h2>
    <p class="mb-8 text-lg text-gray-600">To place orders, please log in or sign up for an account.</p>
    <div class="flex justify-center space-x-14">
      <button type="button" class="bg-blue-500 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:bg-blue-600 hover:shadow-lg transition duration-300 ease-in-out transform hover:scale-105"
        onclick="window.location.href='/login'">Log In</button>
      <button type="button" class="bg-gray-500 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:bg-gray-600 hover:shadow-lg transition duration-300 ease-in-out transform hover:scale-105"
        onclick="window.location.href='/home'">Continue Shopping</button>
    </div>
  </div>
</div>