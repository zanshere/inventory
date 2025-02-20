<?php
session_start();
include '../../includes/connect.php';
include '../../functions/isUserBanned.php';
include '../../functions/errorControllers.php';

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