<?php $this->layout('shared/layout', ['title' => 'Edit Product']) ?>
<h1 class="text-center">Edit Product</h1>
<form action="<?= url('/admin/products/edit/' . $product['id']) ?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Product Name</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" class="form-control" required><?= htmlspecialchars($product['description']) ?></textarea>
    </div>
    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" name="price" class="form-control" value="<?= htmlspecialchars($product['price']) ?>" required>
    </div>
    <div class="form-group">
        <label for="category_name">Category</label>
        <select name="category_name" class="form-control" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category['category_name']) ?>" <?= $product['category_name'] == $category['category_name'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['category_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="image">Product Image</label>
        <input type="file" name="image" class="form-control">
        <img src="/images/<?= htmlspecialchars($product['image']) ?>" alt="Current Image" class="mt-2" width="150">
    </div>
    <button type="submit" class="btn btn-primary">Update Product</button>
</form>

