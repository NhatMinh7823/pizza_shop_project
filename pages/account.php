<?php
if (isset($_POST['logout'])) {
  // Destroy session to log out the user
  session_unset();
  session_destroy();
  // Redirect to the home page but with a URL parameter to show the modal
  header("Location: /index.php?page=home&logout=success");
  exit();
}
// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_email'])) {
  header("Location: /index.php?page=login");
  exit();
}


?>

<!-- Profile Section -->
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

    <!-- Logout Button -->
    <form method="POST" id="logout-form">
      <button type="submit" name="logout"
        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200">
        Logout
      </button>
    </form>
  </div>
</div>

