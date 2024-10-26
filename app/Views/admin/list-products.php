<?php $this->layout('shared/layout', ['title' => 'List Product']) ?>
<h1 class="text-center">Product Management</h1>
<div class="text-right mb-4">
    <a href="<?= url('/admin/products/add') ?>" class="btn btn-success">Add New Product</a>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['id']) ?></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['description']) ?></td>
                <td><?= htmlspecialchars($product['price']) ?></td>
                <td><?= htmlspecialchars($product['category_name']) ?></td>
                <td>
                    <a href="<?= url('/admin/products/edit/' . $product['id']) ?>" class="btn btn-primary">Edit</a>
                    <form action="<?= url('/admin/products/delete/' . $product['id']) ?>" method="POST" style="display:inline;">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
