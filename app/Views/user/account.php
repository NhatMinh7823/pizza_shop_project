<?php $this->layout('shared/layout', ['title' => 'Account']) ?>

<div class="container mx-auto my-5">
    <h1 class="text-center text-3xl font-bold mt-4 text-gray-800">Account Information</h1>
    
    <!-- Thông tin người dùng -->
    <div class="bg-white shadow-md rounded p-6 mt-6">
        <p><strong>Name:</strong> <?= htmlspecialchars($user_name) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user_email) ?></p>
        <p><strong>Role:</strong> <?= htmlspecialchars($user_role) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($user_phone) ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($user_address) ?></p>
        
        <!-- Nút Admin Panel nếu là admin -->
        <?php if ($user_role === 'admin'): ?>
            <a href="<?= url('/admin/products') ?>" class="btn btn-primary mt-3">Admin Panel</a>
        <?php endif; ?>
    </div>

    <!-- Lịch sử đơn hàng -->
    <h2 class="text-2xl font-bold mt-8 text-gray-800">Order History</h2>
    <?php if (!empty($orderHistory)): ?>
        <div class="bg-white shadow-md rounded p-6 mt-4">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">Order ID</th>
                        <th class="p-2 border">Total</th>
                        <th class="p-2 border">Payment Method</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Address</th>
                        <th class="p-2 border">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderHistory as $order): ?>
                        <tr>
                            <td class="p-2 border"><?= htmlspecialchars($order['order_id']) ?></td>
                            <td class="p-2 border">$<?= htmlspecialchars($order['total']) ?></td>
                            <td class="p-2 border"><?= htmlspecialchars($order['payment_method']) ?></td>
                            <td class="p-2 border"><?= htmlspecialchars($order['status']) ?></td>
                            <td class="p-2 border"><?= htmlspecialchars($order['address']) ?></td>
                            <td class="p-2 border"><?= htmlspecialchars($order['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="mt-4 text-gray-600">No orders found.</p>
    <?php endif; ?>
</div>
