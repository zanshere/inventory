<?php
session_start();
require_once '../../includes/connect.php';
include '../../functions/errorControllers.php';

// Ambil data inventaris
$query = "SELECT * FROM inventory";
$result = $conn->query($query);
$items = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Inventori</title>
  <link rel="shortcut icon" href="assets/images/box_icon_126533.ico" type="image/x-icon">
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <!-- DataTables Buttons CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  
  <!-- DataTables Buttons JS -->
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
  
  <style>
    .swal2-popup {
      background: #1F2937 !important;
      color: white !important;
    }
    .swal2-input, .swal2-select {
      background: #374151 !important;
      color: white !important;
    }
  </style>
</head>
<body class="bg-gray-900 text-white min-h-screen">
  <?php include '../../includes/header.php'; ?>

  <div class="container mx-auto px-4 py-8">
    <div class="bg-gray-800 rounded-xl p-6 shadow-2xl">
      <h1 class="text-3xl font-bold mb-6 text-center">Manajemen Inventory</h1>

      <?php if (isset($_SESSION['alert'])): ?>
        <script>
          Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: '<?= $_SESSION['alert'] ?>',
            background: '#1F2937'
          });
        </script>
        <?php unset($_SESSION['alert']); ?>
      <?php endif; ?>

      <div class="overflow-x-auto rounded-lg">
        <table id="inventoryTable" class="w-full">
          <thead class="bg-gray-700">
            <tr>
              <th class="p-4 text-center">ID</th>
              <th class="p-4 text-center">Nama Barang</th>
              <th class="p-4 text-center">Kategori</th>
              <th class="p-4 text-center">Stok</th>
              <th class="p-4 text-center">Harga</th>
              <th class="p-4 text-center">Supplier</th>
              <th class="p-4 text-center">Tanggal Masuk</th>
            </tr>
          </thead>
          <tbody class="bg-gray-900/50">
            <?php foreach ($items as $item): ?>
              <tr class="<?= $item['stok'] < 10 ? 'bg-red-900/20' : '' ?> hover:bg-gray-700/50 transition-colors">
                <td class="p-3 text-center"><?= $item['id'] ?></td>
                <td class="p-3 text-center"><?= htmlspecialchars($item['nama_barang']) ?></td>
                <td class="p-3 text-center"><?= htmlspecialchars($item['kategori']) ?></td>
                <td class="p-3 text-center"><?= $item['stok'] ?></td>
                <td class="p-3 text-center">Rp<?= number_format($item['harga'], 0, ',', '.') ?></td>
                <td class="p-3 text-center"><?= htmlspecialchars($item['supplier']) ?></td>
                <td class="p-3 text-center"><?= date('d/m/Y', strtotime($item['tanggal_masuk'])) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</body>
</html>
