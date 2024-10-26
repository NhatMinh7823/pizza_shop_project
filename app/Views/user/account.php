<?php $this->layout('shared/layout', ['title' => 'Product']) ?>

<div class="container mx-auto my-5">
    <h1 class="text-3xl font-bold text-center mb-4">Account Information</h1>
    <div class="text-center">
        <p><strong>Name:</strong> <?= htmlspecialchars($user_name) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user_email) ?></p>
        <p><strong>Role:</strong> <?= htmlspecialchars($user_role) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($user_phone ?? 'Người dùng chưa thêm') ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($user_address ?? 'Người dùng chưa thêm') ?></p>
    </div>
    
    <?php if ($user_role === 'admin'): ?>
        <div class="text-center mt-5">
            <a href="<?= url('/admin/products') ?>" class="btn btn-primary">Admin Panel</a>
        </div>
    <?php endif; ?>
</div>
