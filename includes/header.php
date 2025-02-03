<?php
include 'connect.php';
// Buat disini

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="assets/Images/box_icon_126533.ico" type="image/x-icon"> 
</head>
<body class="bg-gradient-to-br from-slate-700 via-slate-500 to-slate-700 min-h-screen" x-data="{ isOpen: false, currentPage: 'home' }">
<nav class="bg-slate-800/90 backdrop-blur-md shadow-md fixed w-full z-10 border-b border-slate-700">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <!-- Logo -->
        <div class="text-2xl font-bold text-slate-100">Inventory</div>
        <!-- Hamburger Menu -->
        <button @click="isOpen = !isOpen" class="text-slate-200 hover:text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>
</nav>

<!-- Sidebar -->
<div x-show="isOpen" x-transition:enter="transition ease-in-out duration-300"
    x-transition:enter-start="transform translate-x-full opacity-0" 
    x-transition:enter-end="transform translate-x-0 opacity-100" 
    x-transition:leave="transition ease-in-out duration-300" 
    x-transition:leave-start="transform translate-x-0 opacity-100" 
    x-transition:leave-end="transform translate-x-full opacity-0"
    class="fixed inset-y-0 right-0 w-64 bg-slate-800/95 backdrop-blur-lg shadow-xl h-full p-6 space-y-6 z-20 border-l border-slate-700">
    
    <!-- Sidebar Content -->
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-semibold text-slate-100">Menu</h2>
        <button @click="isOpen = false" class="text-slate-300 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <ul class="space-y-4">
        <li><a href="#" class="text-slate-300 hover:text-white">Home</a></li>
        <li><a href="#" class="text-slate-300 hover:text-white">About</a></li>
        <li><a href="#" class="text-slate-300 hover:text-white">Products</a></li>
        <li><a href="#" class="text-slate-300 hover:text-white">Inventory</a></li>
        <li><a href="#" class="text-slate-300 hover:text-white">Orders</a></li>
        <li><a href="#" class="text-slate-300 hover:text-white">Customers</a></li>
        <li><a href="#" class="text-slate-300 hover:text-white">Contact Us</a></li>
        <li><a href="#" class="text-slate-300 hover:text-white">FAQs</a></li>
        <li><a href="#" class="text-slate-300 hover:text-white">Control Account</a></li>
    </ul>
</div>

</body>
</html>