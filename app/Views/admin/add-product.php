<?php $this->layout('shared/layout', ['title' => 'Add Product']) ?>
<h1 class="text-center">Add New Product</h1>
<form action="<?= url('/admin/products/add') ?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Product Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" class="form-control" required></textarea>
    </div>
    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" name="price" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="category_name">Category</label>
        <select name="category_name" class="form-control" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category['category_name']) ?>"><?= htmlspecialchars($category['category_name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="image">Product Image</label>
        <input type="file" name="image" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Product</button>
</form>

