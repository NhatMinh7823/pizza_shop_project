<?php // Start session
if (!isset($_SESSION['user_name'])) {
    header("Location: /index.php?page=login"); // Redirect if not logged in
    exit();
}
?>

<div class="container mx-auto mt-10 p-8 bg-white shadow-lg rounded-lg max-w-lg">
  <h2 class="text-3xl font-bold text-center mb-6">Profile</h2>

  <div class="space-y-4">
    <div class="flex items-center space-x-3">
      <i class="fas fa-user text-xl"></i>
      <div>
        <p class="font-bold text-gray-700">Name</p>
        <p><?= htmlspecialchars($_SESSION['user_name']) ?></p>
      </div>
    </div>

    <div class="flex items-center space-x-3">
      <i class="fas fa-envelope text-xl"></i>
      <div>
        <p class="font-bold text-gray-700">Email</p>
        <p><?= htmlspecialchars($_SESSION['user_email']) ?></p>
      </div>
    </div>

    <!-- Add more user information as needed -->
    
    <a href="/index.php?page=logout" class="block text-center bg-red-500 text-white p-2 rounded-md hover:bg-red-600 transition duration-200">Logout</a>
  </div>
</div>