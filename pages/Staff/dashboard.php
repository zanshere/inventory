<?php
// dashboard.php
session_start(); // Letakkan di paling atas sebelum output apapun

include '../../includes/connect.php';
include '../../functions/isUserBanned.php';
include '../../functions/getSidebarMenu.php';
include '../../functions/errorControllers.php';

// Ambil role dari session
$role = $_SESSION['role'] ?? 'user';

// Generate menu items
$menuItems = getSidebarMenu($role); // <-- AMBIL MENU ITEMS

include '../../includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body>
<!-- Konten utama -->
<div class="ml-64 p-8">
    <h1 class="text-2xl font-bold mb-4">Selamat datang, <?php echo $_SESSION['username']; ?>!</h1>
    <!-- Konten dashboard lainnya -->
</div>
</body>
</html>
