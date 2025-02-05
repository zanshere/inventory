<?php

// Memastikan SESSION sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../functions/getSidebarMenu.php';

// Ambil role dari session (default: guest)
$role = $_SESSION['role'] ?? 'guest';

// Jika user belum login, kosongkan menu. Jika sudah login, ambil menu sesuai role akun user.
$menuItems = isset($_SESSION['user_id']) ? getSidebarMenu($role) : [];

// Base URL untuk memastikan path konsisten
define('BASE_URL', 'http://localhost/git-project/inventory'); // Sesuaikan dengan base URL 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Icon Library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Tailwind CSS -->
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
  <!-- Alpine.js -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black min-h-screen" x-data="{ sidebarOpen: false }">

  <!-- Navbar -->
  <nav class="bg-gray-800 p-4 flex justify-between items-center">
    <!-- Logo dan Nama Website -->
    <div class="flex items-center space-x-3">
      <!-- Ganti 'path/to/logo.png' dengan path ke logo Anda -->
      <img src="../assets/Images/logo-removebg.png" alt="Logo" class="w-8 h-8">
      <span class="text-white font-bold text-xl"> Retail Inventory</span>
    </div>
    <!-- Tombol Menu -->
    <button @click="sidebarOpen = true" class="text-white focus:outline-none">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>
  </nav>

  <!-- Sidebar (Offcanvas) -->
  <div x-show="sidebarOpen" class="fixed inset-0 flex z-50">
    <!-- Overlay -->
    <div @click="sidebarOpen = false"
         x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black opacity-50"></div>
    
    <!-- Konten Sidebar - sekarang ditempatkan di sebelah kanan -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="relative bg-gray-800 w-64 h-full p-6 ml-auto">
      <!-- Tombol Tutup Sidebar -->
      <button @click="sidebarOpen = false" class="absolute top-4 left-4 text-gray-400 hover:text-white focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
      
      <!-- Menu Sidebar -->
      <ul class="mt-10 space-y-4">
        <?php if (isset($_SESSION['user_id'])): ?>
          <?php foreach ($menuItems as $item): ?>
            <li>
              <a href="<?= BASE_URL . $item['link'] ?>" 
                 class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 p-3 rounded-lg transition-colors">
                <i class="<?= $item['icon'] ?> w-5 text-center"></i>
                <span><?= $item['title'] ?></span>
              </a>
            </li>
          <?php endforeach; ?>
          <!-- Tampilkan tombol Logout -->
          <li>
            <a href="<?= BASE_URL ?>/auth/logout.php" 
               class="flex items-center space-x-3 text-red-400 hover:bg-gray-700 p-3 rounded-lg transition-colors">
              <i class="fas fa-sign-out-alt w-5 text-center"></i>
              <span>Logout</span>
            </a>
          </li>
        <?php else: ?>
          <!-- Jika belum login, tampilkan menu Login saja -->
          <li>
            <a href="<?= BASE_URL ?>/auth/login.php" 
               class="flex items-center space-x-3 text-green-400 hover:bg-gray-700 p-3 rounded-lg transition-colors">
              <i class="fas fa-sign-in-alt w-5 text-center"></i>
              <span>Login</span>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>

  <!-- Konten Utama -->
  <main class="p-4 mt-4">
    <?php // Tempat untuk menyisipkan konten halaman ?>
  </main>

</body>
</html>
