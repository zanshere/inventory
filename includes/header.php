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
  <base href="/git-project/inventory/">
  <!-- Icon Library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Tailwind CSS -->
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
  <!-- Alpine.js -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <!-- Font -->
  <link rel="stylesheet" href="assets/CSS/font.css">
  <!-- CSS -->
  <style>
    /* Elemen dengan x-cloak disembunyikan sebelum Alpine aktif */
    [x-cloak] { display: none !important; }

    .nav-link.active {
      color: white;
      font-weight: bold;
      border-radius: 5px;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black min-h-screen" 
      x-data="{ sidebarOpen: false }">
  <!-- Navbar -->
  <nav class="bg-gray-800 p-4 flex justify-between items-center">
    <!-- Logo dan Nama Website -->
    <div class="flex items-center space-x-1">
      <img src="/assets/images/Logo.png" alt="Logo" class="w-10 h-10">
      <span class="text-white font-bold text-xl">Retail Inventory</span>
    </div>
    <!-- Tombol Menu -->
    <button @click="sidebarOpen = !sidebarOpen" class="text-white focus:outline-none">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>
  </nav>

  <!-- Container Sidebar: Hanya tampil ketika sidebarOpen true -->
  <div x-show="sidebarOpen" x-cloak class="fixed inset-0 flex justify-end z-50">
    <!-- Overlay dengan transisi opacity -->
    <div @click="sidebarOpen = false"
         x-show="sidebarOpen"
         x-transition:enter="transition ease-in-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-50"
         x-transition:leave="transition ease-in-out duration-300"
         x-transition:leave-start="opacity-50"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black"></div>

    <!-- Konten Sidebar dengan transisi slide dari kanan -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition transform ease-in-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition transform ease-in-out duration-300"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="relative bg-gray-800 w-64 h-full p-6">
      
      <!-- Tombol Tutup Sidebar -->
      <button @click="sidebarOpen = false" class="absolute top-4 left-4 text-gray-400 hover:text-white focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>

      <!-- Menu Sidebar -->
      <ul class="mt-10 space-y-4">
        <?php if (isset($_SESSION['user_id'])): ?>
          <?php foreach ($menuItems as $item): ?>
            <li>
              <a href="<?= BASE_URL . $item['link'] ?>" 
                 class="nav-link flex items-center space-x-3 text-gray-400 hover:text-white p-3 rounded-lg transition-colors">
                <i class="<?= $item['icon'] ?> w-5 text-center"></i>
                <span><?= $item['title'] ?></span>
              </a>
            </li>
          <?php endforeach; ?>
          <!-- Logout -->
          <li>
            <a href="<?= BASE_URL ?>/auth/logout.php" 
               class="flex items-center space-x-3 text-red-600 hover:text-red-400 p-3 rounded-lg transition-colors">
              <i class="fas fa-sign-out-alt w-5 text-center"></i>
              <span>Logout</span>
            </a>
          </li>
        <?php else: ?>
          <!-- Login -->
          <li>
            <a href="<?= BASE_URL ?>/auth/login.php" 
               class="flex items-center space-x-3 text-green-600 hover:text-green-400 p-3 rounded-lg transition-colors">
              <i class="fas fa-sign-in-alt w-5 text-center"></i>
              <span>Login</span>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>

  <!-- JavaScript untuk aktifkan class 'active' pada link sidebar -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const navLinks = document.querySelectorAll(".nav-link");
      const currentPath = window.location.pathname.replace(/\/$/, "");
      navLinks.forEach(link => {
          const linkPath = new URL(link.href).pathname.replace(/\/$/, "");
          if (linkPath === currentPath) {
              link.classList.add("active");
          } else {
              link.classList.remove("active");
          }
      });
    });
  </script>
</body>
</html>