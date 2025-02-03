<?php
include 'connect.php';
require __DIR__ . '/../functions/getSidebarMenu.php';

?>

<!DOCTYPE html>
<html lang="en" class="bg-transparent">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Memastikan Tailwind CSS termuat -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <link rel="shortcut icon" href="assets/Images/box_icon_126533.ico" type="image/x-icon">
</head>
<body class="bg-gradient-to-br from-slate-700 via-slate-500 to-slate-700 min-h-screen" x-data="{ isOpen: false, currentPage: 'home' }">
  
  <!-- Navbar -->
  <nav class="bg-slate-900 shadow-md fixed w-full z-10">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
      <div class="text-2xl font-bold text-white">Inventory</div>
      <button @click="isOpen = !isOpen" class="text-white focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
      </button>
    </div>
  </nav>
  
  <!-- Sidebar -->
  <div x-show="isOpen" 
       x-transition:enter="transition ease-in-out duration-300"
       x-transition:enter-start="transform translate-x-full opacity-0" 
       x-transition:enter-end="transform translate-x-0 opacity-100" 
       x-transition:leave="transition ease-in-out duration-300" 
       x-transition:leave-start="transform translate-x-0 opacity-100" 
       x-transition:leave-end="transform translate-x-full opacity-0"
       class="fixed inset-y-0 right-0 w-64 bg-slate-900 shadow-md h-full p-6 space-y-6 z-20">
       
    <!-- Sidebar Header -->
    <div class="flex justify-between items-center">
      <h2 class="text-lg font-semibold text-white">Menu</h2>
      <button @click="isOpen = false" class="text-white hover:text-gray-300 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>  
    
    <!-- Sidebar Menu -->
    <ul class="space-y-4">
      <?php if(isset($_SESSION['role'])): ?>
        <?php foreach(getSidebarMenu($_SESSION['role']) as $menu): ?>
          <li>
            <a href="<?= htmlspecialchars($menu['link']) ?>" class="text-white hover:text-gray-300 block p-2 rounded-lg hover:bg-slate-800 transition-colors">
              <i class="<?= htmlspecialchars($menu['icon']) ?> mx-2"></i><?= htmlspecialchars($menu['title']) ?>
            </a>
          </li>
        <?php endforeach; ?>
        
        <!-- Logout Menu -->
        <li>
          <a href="/../../git-project/inventory/auth/logout.php" class="text-white hover:text-gray-300 block p-2 rounded-lg hover:bg-slate-800 transition-colors">
            <i class="fi fi-rs-sign-out-alt mx-2"></i>Logout
          </a>
        </li>
      <?php else: ?>
        <li>
          <a href="../../../git-project/inventory/auth/login.php" class="text-white hover:text-gray-300 block p-2 rounded-lg hover:bg-slate-800 transition-colors">
            <i class="fi fi-rs-sign-in-alt mx-2"></i>Login
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
  
</body>
</html>
