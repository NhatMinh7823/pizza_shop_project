<?php $this->layout('shared/layout', ['title' => 'Checkout']) ?>

<div class="container mx-auto my-5">
    <h1 class="text-2xl font-bold mb-4">Checkout</h1>

    <div class="bg-white shadow-md rounded p-4 mb-6">
        <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
        <ul>
            <?php foreach ($cartItems as $item): ?>
                <li class="flex justify-between">
                    <span><?= htmlspecialchars($item['name']) ?> x <?= $item['quantity'] ?></span>
                    <span>$<?= htmlspecialchars($item['total_price']) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
        <hr class="my-4">
        <div class="flex justify-between font-semibold">
            <span>Total:</span>
            <span>$<?= htmlspecialchars($total) ?></span>
        </div>
    </div>

    <form action="/place-order" method="POST">
        <div class="mb-4">
            <label for="address" class="block font-semibold">Shipping Address:</label>
            <textarea name="address" id="address" rows="3" class="w-full border rounded p-2" required></textarea>
        </div>
        <div class="mb-4">
            <label for="payment_method" class="block font-semibold">Payment Method:</label>
            <select name="payment_method" id="payment_method" class="w-full border rounded p-2" required>
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
                <option value="cash_on_delivery">Cash on Delivery</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Place Order</button>
    </form>
</div>
