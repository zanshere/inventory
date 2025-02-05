<?php
session_start();
include '../../includes/connect.php';
include '../../functions/isUserBanned.php';
$sidebarContent = '
    <ul class="space-y-4">
        <li>
            <a href="#" @click.prevent="currentPage = \'customers\'; isOpen = false" class="text-gray-900 hover:text-gray-600 flex items-center">
                <span class="material-icons mr-2">home</span>
                Home
            </a>
        </li>
        <li>
            <a href="#" @click.prevent="currentPage = \'customers\'; isOpen = false" class="text-gray-900 hover:text-gray-600 flex items-center">
                <span class="material-icons mr-2">add_inventory</span>
                Add Inventory
            </a>
        </li>
        <li>
            <a href="#" @click.prevent="currentPage = \'control_account\'; isOpen = false" class="text-gray-900 hover:text-gray-600 flex items-center">
                <span class="material-icons mr-2">list_alt</span>
                View Inventory
            </a>
        </li>
    </ul>
';
include '../../includes/header.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body>
<main class="pt-20 px-4">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold text-white mt-12">Halaman Staff</h1>
        <div x-show="currentPage === 'home'">Add Inventory</div>
        <div x-show="currentPage === 'inventory'">View Inventory</div>
        <div x-show="currentPage === 'orders'">Konten Orders</div>
    </div>
</main>
</body>
</html>