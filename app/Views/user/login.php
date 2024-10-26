<?php $this->layout('shared/layout', ['title' => 'Login']) ?>

<h1 class="text-center text-3xl font-bold mt-10">Login</h1></br>
<div class="container mx-auto max-w-md p-8 bg-white shadow-lg rounded-lg">
    <form method="POST" action="/login">
        <div class="form-group mb-4">
            <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
            <input type="email" name="email" class="form-control w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400" required>
        </div>
        <div class="form-group mb-4">
            <label for="password" class="block text-gray-700 font-bold mb-2">Password:</label>
            <input type="password" name="password" class="form-control w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400" required>
        </div>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger mt-4"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary w-full p-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-md transition duration-200">Login</button>
    </form>
    <p class="text-center mt-6">Don't have an account? <a href="/register" class="text-blue-500 hover:underline">Register here</a></p>
</div></br>
