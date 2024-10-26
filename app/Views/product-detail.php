<?php $this->layout('shared/layout', ['title' => 'Product']) ?>

<div class="container my-5">
  <?php if (isset($product)): ?>
    <div class="row">
      <!-- Hình ảnh sản phẩm -->
      <div class="col-md-6">
        <img src="/images/<?= htmlspecialchars($product['image']) ?>"
          alt="<?= htmlspecialchars($product['name']) ?>"
          class="w-3/5 h-auto mx-auto object-cover rounded-lg transition duration-500 ease-in-out transform hover:rotate-12 hover:scale-110">
      </div>

      <!-- Thông tin sản phẩm -->
      <div class="col-md-6">
        <h1 class="display-4 font-weight-bold"><?= htmlspecialchars($product['name']) ?></h1>

        <?php if (isset($product['discount']) && !empty($product['discount'])): ?>
          <p class="text-muted">
            <del>$<?= htmlspecialchars($product['price']) ?></del>
          </p>
          <p class="text-danger h4">
            $<?= htmlspecialchars($product['discount']) ?>
            <span class="small">(Discounted)</span>
          </p>
          <p class="text-muted">
            Discount ends at: <?= htmlspecialchars($product['discount_end_time']) ?>
          </p>
        <?php else: ?>
          <p class="text-success h4">
            $<?= htmlspecialchars($product['price']) ?>
          </p>
        <?php endif; ?>

        <p class="my-4"><?= htmlspecialchars($product['description']) ?></p>

        <!-- Thêm vào giỏ hàng -->
        <form action="<?= url('/cart/add') ?>" method="POST">
          <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">

          <label for="quantity" class="font-weight-bold">Quantity:</label>
          <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control mb-3 w-25">

          <button type="submit" class="btn btn-primary btn-lg">Add to Cart</button>
        </form>
      </div>
    </div>
  <?php else: ?>
    <p class="text-center text-danger mt-5">Product not found.</p>
  <?php endif; ?>
</div>