<?php $this->layout('shared/layout', ['title' => 'Product']) ?>

<div class="container mx-auto my-8">
    <!-- Tiêu đề menu -->
    <h1 class="text-center text-5xl font-extrabold mb-6 text-blue-700 drop-shadow-lg">Our Pizza Menu</h1>

    <!-- Phần danh mục sản phẩm -->
    <div class="text-center mt-10 mb-10 space-x-4">
        <a href="/products" class="px-4 py-2 rounded-lg <?= !$selectedCategory ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-800' ?> hover:bg-red-700 hover:text-white transition duration-300 text-lg font-semibold shadow-lg">All</a>
        <?php foreach ($categories as $category): ?>
            <a href="/products/<?= urlencode($category['category_name']) ?>" class="px-4 py-2 rounded-lg <?= ($selectedCategory == $category['category_name']) ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-800' ?> hover:bg-red-700 hover:text-white transition duration-300 text-lg font-semibold shadow-lg">
                <?= htmlspecialchars($category['category_name']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Phần danh sách sản phẩm -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="relative bg-white rounded-2xl shadow-xl p-5 hover:shadow-2xl transition-transform transform hover:scale-105 duration-300">
                    <img src="/images/<?= htmlspecialchars($product['image']) ?>"
                        class="w-3/5 h-auto mx-auto object-cover rounded-lg transition duration-500 ease-in-out transform hover:rotate-12 hover:scale-110"
                        alt="<?= htmlspecialchars($product['name']) ?>">
                    <div class="text-center">
                        <h5 class="text-2xl font-extrabold text-gray-800 mb-2"><?= htmlspecialchars($product['name']) ?></h5>
                        <p class="text-gray-600 mb-4"><?= htmlspecialchars($product['description']) ?></p>
                        <p class="text-blue-500 font-bold text-xl mb-4">Price: <span class="text-red-600">$<?= htmlspecialchars($product['price']) ?></span></p>

                        <!-- Nút Add to Cart và Xem chi tiết -->
                        <div class="flex justify-center items-center space-x-2 mt-4">
                            <a href="/product-detail/<?= $product['id'] ?>" class="px-3 py-1 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 transition duration-300 text-sm">View Details</a>
                            <form method="POST" action="/cart/add">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="px-3 py-1 bg-green-500 text-white font-semibold rounded hover:bg-green-600 transition duration-300 text-sm">Add to Cart</button>
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