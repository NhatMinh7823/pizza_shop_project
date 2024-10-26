<nav class="bg-red-600 text-white shadow-lg navbar">
  <div class="container mx-auto px-4 py-3 flex justify-between items-center">

    <!-- Logo and Brand Name -->
    <div class="flex items-center space-x-3">
      <img src="/images/logo-removebg.png" alt="Pizza Store" class="h-12 w-12">
      <a href="<?= url('/home') ?>" class="text-3xl font-bold">Pizza Store</a>
    </div>

    <!-- Mobile Menu Button -->
    <div class="lg:hidden">
      <button id="navbar-toggler" class="text-white focus:outline-none">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </div>

    <!-- Navbar Links for Desktop -->
    <div class="hidden lg:flex space-x-8 items-center" id="navbar-menu">
      <a href="<?= url('/home') ?>" class="hover:text-yellow-300 transition duration-300">Home</a>
      <a href="<?= url('/products') ?>" class="hover:text-yellow-300 transition duration-300">Products</a>
      <?php
      // Đảm bảo rằng biến này được thiết lập từ phiên trước đó
      $cartItemCount = $_SESSION['cart_count'] ?? 0;
      ?>

      <a href="<?= url('/cart') ?>" class="relative hover:text-yellow-300 transition duration-300">
        <i class="fas fa-shopping-cart"></i> Giỏ hàng
        <span class="bg-yellow-300 text-red-600 font-bold rounded-full text-xs px-2 py-1 absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2">
          <?= $cartItemCount ?>
        </span>
      </a>


      <?php if (isset($_SESSION['user_name'])): ?>
        <!-- User is logged in -->
        <div class="relative">
          <button class="flex items-center space-x-2 hover:text-yellow-300 transition duration-300 focus:outline-none" id="user-dropdown-toggle">
            <i class="fas fa-user"></i>
            <span><?= htmlspecialchars($_SESSION['user_name']) ?></span>
          </button>
          <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white text-black rounded-lg shadow-lg">
            <a href="<?= url('/account') ?>" class="block px-4 py-2 hover:bg-gray-200">Profile</a>
            <form method="POST" action="<?= url('/logout') ?>">
              <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-200">Logout</button>
            </form>
          </div>
        </div>
      <?php else: ?>
        <!-- User is not logged in -->
        <a href="<?= url('/login') ?>" class="hover:text-yellow-300 transition duration-300">Login</a>
      <?php endif; ?>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div class="lg:hidden hidden" id="mobile-menu">
    <ul class="flex flex-col items-center bg-red-500 py-4 space-y-2">
      <li><a href="<?= url('/home') ?>" class="block px-3 py-2 text-white hover:bg-yellow-400">Home</a></li>
      <li><a href="<?= url('/products') ?>" class="block px-3 py-2 text-white hover:bg-yellow-400">Products</a></li>
      <li><a href="<?= url('/cart') ?>" class="block px-3 py-2 text-white hover:bg-yellow-400">Cart</a></li>
      <li><a href="<?= url('/contact') ?>" class="block px-3 py-2 text-white hover:bg-yellow-400">Contact</a></li>
      <?php if (isset($_SESSION['user_name'])): ?>
        <button class="block px-3 py-2 text-white hover:bg-yellow-400" id="mobile-user-dropdown-toggle">
          <i class="fas fa-user"></i>
          <span><?= htmlspecialchars($_SESSION['user_name']) ?></span>
        </button>
        <div id="mobile-user-dropdown" class="hidden">
          <a href="<?= url('/account') ?>" class="block px-3 py-2 text-white hover:bg-yellow-400">Profile</a>
          <form method="POST" action="<?= url('/logout') ?>">
            <button type="submit" class="block w-full text-left px-3 py-2 text-white hover:bg-yellow-400">Logout</button>
          </form>
        </div>
      <?php else: ?>
        <li><a href="<?= url('/login') ?>" class="block px-3 py-2 text-white hover:bg-yellow-400">Login</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>