<?php
// File: header.php

// HAPUS session_start() di sini karena sudah dipanggil di dashboard.php
include_once '../functions/getSidebarMenu.php'; 
include_once __DIR__ . '../functions/getSidebarMenu.php';

$role = $_SESSION['role'] ?? null;
$menuItems = is_string($role) ? getSidebarMenu($role) : [];


?>

<!DOCTYPE html>
<html lang="en" class="bg-transparent">
<head>
  <!-- ... bagian head tetap sama ... -->
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black min-h-screen" x-data="{ isOpen: false, currentPage: 'home' }">
  
  <!-- Navbar (tetap sama) -->
  
  <!-- Sidebar -->
  <div x-show="isOpen" x-transition:enter="transition ease-in-out duration-300"
    x-transition:enter-start="transform translate-x-full opacity-0" 
    x-transition:enter-end="transform translate-x-0 opacity-100" 
    x-transition:leave="transition ease-in-out duration-300" 
    x-transition:leave-start="transform translate-x-0 opacity-100" 
    x-transition:leave-end="transform translate-x-full opacity-0"
    class="fixed inset-y-0 right-0 w-64 bg-white h-full p-6 space-y-6 z-20">
    
    <div class="flex justify-between items-center">
      <!-- ... bagian tombol close tetap sama ... -->
    </div>
    
    <ul class="space-y-2">
      <?php if(!isset($_SESSION['user_id'])): ?>
        <!-- Menu guest tetap sama -->
      <?php else: ?>
        <!-- Tambahkan pengecekan isset() -->
        <?php if(isset($menuItems) && is_array($menuItems) && count($menuItems) > 0): ?>
        <?php foreach($menuItems as $item): ?>
            <li>
            <a href="<?= htmlspecialchars($item['link']) ?>" class="flex items-center space-x-2 text-gray-700 hover:bg-gray-100 p-2 rounded">
                <i class="<?= htmlspecialchars($item['icon']) ?>"></i>
                <span><?= htmlspecialchars($item['title']) ?></span>
            </a>
            </li>
        <?php endforeach; ?>
        <?php else: ?>
        <li class="text-red-500">Menu tidak tersedia</li>
        <?php endif; ?>


        <!-- Logout -->
        <li>
          <a href="../../inventory/auth/logout.php" class="flex items-center space-x-2 text-red-600 hover:bg-gray-100 p-2 rounded">
            <i class="fi fi-rs-sign-out"></i>
            <span>Logout</span>
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
  
</body>
</html>