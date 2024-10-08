<nav class="bg-red-600 text-white shadow-lg navbar">
  <div class="container mx-auto px-4 py-3 flex justify-between items-center">

    <div class="flex items-center space-x-3">
      <img src="/images/logo-removebg.png" alt="Pizza Store" class="h-12 w-12">
      <a href="/index.php?page=home" class="text-2xl font-bold">Pizza Store</a>
    </div>


    <div class="lg:hidden">
      <button id="navbar-toggler" class="text-white focus:outline-none">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </div>


    <div class="hidden lg:flex space-x-8 items-center" id="navbar-menu">
      <a href="/index.php?page=home" class="hover:text-yellow-300 transition duration-300">Home</a>
      <a href="/index.php?page=products" class="hover:text-yellow-300 transition duration-300">Products</a>
      <a href="/index.php?page=cart" class="relative hover:text-yellow-300 transition duration-300">
        <i class="fas fa-shopping-cart"></i> Cart
        <span
          class="bg-yellow-300 text-red-600 font-bold rounded-full text-xs px-2 py-1 absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2">2</span>
      </a>
      <a href="/index.php?page=login" class="hover:text-yellow-300 transition duration-300">Login</a>
      <a href="/index.php?page=contact" class="hover:text-yellow-300 transition duration-300">Contact</a>
    </div>
  </div>


  <div class="lg:hidden hidden" id="mobile-menu">
    <ul class="flex flex-col items-center bg-red-500 py-4 space-y-2">
      <li><a href="/index.php?page=home" class="block px-3 py-2 text-white hover:bg-yellow-400">Home</a></li>
      <li><a href="/index.php?page=products" class="block px-3 py-2 text-white hover:bg-yellow-400">Products</a></li>
      <li><a href="/index.php?page=cart" class="block px-3 py-2 text-white hover:bg-yellow-400">Cart</a></li>
      <li><a href="/index.php?page=login" class="block px-3 py-2 text-white hover:bg-yellow-400">Login</a></li>
      <li><a href="/index.php?page=contact" class="block px-3 py-2 text-white hover:bg-yellow-400">Contact</a></li>
    </ul>
  </div>
</nav>