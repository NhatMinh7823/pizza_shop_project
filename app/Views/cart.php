<?php $this->layout('shared/layout', ['title' => 'Cart']) ?>

<div class="container mx-auto my-5 px-4">
    <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Your Cart</h1>
    <?php if (!empty($cartItems)): ?>
        <div class="flex justify-center">
            <div class="grid gap-4 w-3/5">
                <?php foreach ($cartItems as $item): ?>
                    <div class="flex items-center justify-between p-6 border border-gray-200 rounded-lg shadow-lg bg-white">
                        <!-- Hình ảnh sản phẩm -->
                        <img src="/images/<?= htmlspecialchars($item['image']) ?>"
                            alt="<?= htmlspecialchars($item['name']) ?>"
                            class="mx-auto object-cover rounded-lg transition duration-500 ease-in-out transform hover:rotate-12 hover:scale-110" width="50">

                        <!-- Thông tin sản phẩm -->
                        <div class="flex-1 flex flex-col ml-4">
                            <span class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($item['name']) ?></span>
                            <span class="text-gray-600 mt-1">$<?= htmlspecialchars($item['price']) ?></span>
                            <div class="flex items-center mt-1">
                                <span class="text-gray-800 font-bold">Total: </span>
                                <span class="text-red-600 font-bold ml-1">$<?= number_format($item['price'] * $item['quantity'], 2) ?></span> <!-- Thêm margin-left cho khoảng cách -->
                            </div>
                        </div>

                        <!-- Form cập nhật số lượng và nút Update -->
                        <form action="<?= url('/cart/update') ?>" method="POST" class="flex items-center space-x-2">
                            <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                            <input type="number" name="quantity" value="<?= $item['quantity'] ?>"
                                min="1" class="w-16 h-10 text-center border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded shadow hover:bg-blue-600 transition duration-300">Update</button>
                        </form>

                        <!-- Form xóa sản phẩm và nút Remove -->
                        <form action="<?= url('/cart/delete') ?>" method="POST" class="ml-2">
                            <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded shadow hover:bg-red-600 transition duration-300">Delete</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Hiển thị tổng giá giỏ hàng -->
        <div class="text-center font-bold text-lg mt-4" style="margin-left: 500px;">
            <span>Total Price: </span>
            <span class="text-red-600">$<?= number_format(array_sum(array_map(function ($item) {
                                            return $item['price'] * $item['quantity'];
                                        }, $cartItems)), 2) ?></span>
        </div>

        <!-- Nút chuyển tới thanh toán -->
        <div class="text-center mt-2">
            <a href="<?= url('/checkout') ?>"
                class="inline-block px-6 py-3 bg-green-500 text-white font-semibold rounded shadow-lg hover:bg-green-600 transition duration-300">
                Proceed to Checkout
            </a>
        </div>
    <?php else: ?>
        <p class="text-center text-gray-600 mt-8">Your cart is empty.</p>
    <?php endif; ?>
</div>