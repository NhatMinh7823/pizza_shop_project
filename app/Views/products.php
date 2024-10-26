<?php $this->layout('shared/layout', ['title' => 'Product']) ?>

<div class="container my-5">
    <h1 class="text-center mt-4">Our Pizza Menu</h1>

    <!-- Phần danh mục sản phẩm -->
    <div class="text-center mb-4">
    <a href="/products" class="btn <?= !$selectedCategory ? 'btn-primary' : 'btn-outline-primary' ?> m-1">All</a>
        <?php foreach ($categories as $category): ?>
            <a href="/products/<?= urlencode($category['category_name']) ?>"
                class="btn <?= ($selectedCategory == $category['category_name']) ? 'btn-primary' : 'btn-outline-primary' ?> m-1">
                <?= htmlspecialchars($category['category_name']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Phần danh sách sản phẩm -->
    <div class="row">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card h-100">
                        <img src="/images/<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                            <p class="card-text"><strong>Price: $<?= htmlspecialchars($product['price']) ?></strong></p>
                            <a href="/product-detail/<?= $product['id'] ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No products found.</p>
        <?php endif; ?>
    </div>
</div>


