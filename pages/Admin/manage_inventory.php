<?php
session_start();
include '../../includes/connect.php';
include '../../functions/isUserBanned.php';
include '../../functions/errorControllers.php';


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include '../../includes/header.php'; ?>

<div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 shadow-lg">
        <h1 class="text-2xl font-bold text-white mb-6 text-center">Manajemen Inventory</h1>
        
        <div class="overflow-x-auto">
          <table class="w-full text-white border-collapse">
            <thead class="bg-white/20">
              <tr>
                <th class="p-3 text-left rounded-tl-xl">No</th>
                <th class="p-3 text-left">Nama Barang</th>
                <th class="p-3 text-left">Jenis Barang</th>
                <th class="p-3 text-left">Stok</th>
                <th class="p-3 text-left">Tanggal Masuk</th>
                <th class="p-3 text-left rounded-tr-xl">Aksi</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                    <td class= "p-3"></td>
                    <td class= "p-3"></td>
                    <td class= "p-3"></td>
                    <td class= "p-3"></td>
                    <td class= "p-3"></td>
                    <td class= "p-3"></td>
                </tr>
            </tbody>
</body>
</html>