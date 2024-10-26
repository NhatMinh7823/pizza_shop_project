<?php $this->layout('shared/layout', ['title' => 'Register']) ?>

<h1 class="text-center text-3xl font-bold mt-10">Register</h1></br>
<div class="container mx-auto max-w-md p-8 bg-white shadow-lg rounded-lg">
    <form method="POST" action="<?= url('/register') ?>">
        <div class="form-group mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Name:</label>
            <input type="text" name="name" class="form-control w-full p-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="form-group mb-4">
            <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
            <input type="email" name="email" class="form-control w-full p-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="form-group mb-4">
            <label for="password" class="block text-gray-700 font-bold mb-2">Password:</label>
            <input type="password" name="password" class="form-control w-full p-2 border border-gray-300 rounded-md"
                required>
        </div>
        <div class="form-group mb-4">
            <label for="confirm_password" class="block text-gray-700 font-bold mb-2">Confirm Password:</label>
            <input type="password" name="confirm_password"
                class="form-control w-full p-2 border border-gray-300 rounded-md" required>
        </div>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger mt-4"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <button type="submit"
            class="btn btn-primary w-full p-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-md transition duration-200">Register</button>
    </form>
    <p class="text-center mt-6">Already have an account? <a href="<?= url('/login') ?>"
            class="text-blue-500 hover:underline">Login here</a></p>
</div></br>

