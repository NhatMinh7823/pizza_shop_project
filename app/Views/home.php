<?php $this->layout('shared/layout', ['title' => 'Home']) ?>
<div class="container my-5">
  <div class="jumbotron text-center bg-info text-white">
    <h1 class="display-4">Welcome to MinhToan Pizza Store!</h1>
    <p class="lead">Delicious pizzas made with the finest ingredients. Order now!</p>
    <a class="btn btn-primary btn-lg" href="/products" role="button">Go shopping now</a>
  </div>

  <!-- Phần sản phẩm giảm giá -->
  <h2 class="text-center my-5 font-bold">Special Discount Offer</h2>
  <?php if (!empty($discountProduct)): ?>
    <?php foreach ($discountProduct as $product): ?>
      <div class="card mb-4">
        <div class="row no-gutters">
          <div class="col-md-4">
            <img src="/images/<?= htmlspecialchars($product['image']); ?>" class="card-img"
              alt="<?= htmlspecialchars($product['name']); ?>">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
              <p class="card-text"><?= htmlspecialchars($product['description']); ?></p>
              <strong>Discounted Price: $<?= htmlspecialchars($product['discount']); ?></strong>
              <a href="/product-detail/<?= $product['id']; ?>" class="btn btn-danger">Buy now</a>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p class="text-center">No discount products available.</p>
  <?php endif; ?>

  <h2 class="text-center my-5 font-bold">Featured Pizzas</h2>
  <div class="row">
    <?php foreach ($randomProducts as $product): ?>
      <div class="col-md-4">
        <div class="card">
          <img src="/images/<?= htmlspecialchars($product['image']); ?>" class="card-img-top"
            alt="<?= htmlspecialchars($product['name']); ?>">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
            <p class="card-text"><?= htmlspecialchars($product['description']); ?></p>
            <a href="/product-detail/<?= $product['id']; ?>" class="btn btn-primary">View Details</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
