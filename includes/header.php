<?php




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black min-h-screen" x-data="{ isOpen: false, currentPage: 'home' }">
<nav class="bg-white bg-opacity-30 backdrop-blur-md shadow-md fixed w-full z-10">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <!-- Logo -->
        <div class="text-2xl font-bold text-gray-100">Inventory</div>

        <!-- Hamburger Menu -->
        <button @click="isOpen = !isOpen" class="text-gray-100 focus:outline-none">
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
    class="fixed inset-y-0 right-0 w-64 bg-white bg-opacity-50 backdrop-blur-md shadow-md h-full p-6 space-y-6 z-20">
    <!-- Sidebar Content -->
    <div class="flex justify-between items-center ">
        <h2 class="text-lg font-semibold text-gray-900">Menu</h2>
        <button @click="isOpen = false" class="text-gray-900 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <ul class="space-y-4">
        <li><a href="#" @click.prevent="currentPage = 'home'; isOpen = false" class="text-gray-900 hover:text-gray-600">Home</a></li>
        <li><a href="#" @click.prevent="currentPage = 'about'; isOpen = false" class="text-gray-900 hover:text-gray-600">About</a></li>
        <li><a href="#" @click.prevent="currentPage = 'products'; isOpen = false" class="text-gray-900 hover:text-gray-600">Products</a></li>
        <li><a href="#" @click.prevent="currentPage = 'inventory'; isOpen = false" class="text-gray-900 hover:text-gray-600">Inventory</a></li>
        <li><a href="#" @click.prevent="currentPage = 'orders'; isOpen = false" class="text-gray-900 hover:text-gray-600">Orders</a></li>
        <li><a href="#" @click.prevent="currentPage = 'customers'; isOpen = false" class="text-gray-900 hover:text-gray-600">Customers</a></li>
        <li><a href="#" @click.prevent="currentPage = 'contact'; isOpen = false" class="text-gray-900 hover:text-gray-600">Contact Us</a></li>
        <li><a href="#" @click.prevent="currentPage = 'faq'; isOpen = false" class="text-gray-900 hover:text-gray-600">FAQs</a></li>
        <li><a href="#" @click.prevent="currentPage = 'control_account'; isOpen = false" class="text-gray-900 hover:text-gray-600">Control Account</a></li>
    </ul>
</div>

</body>
</html>