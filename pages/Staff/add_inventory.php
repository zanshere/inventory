<?php
session_start();
require_once '../../includes/connect.php';
include '../../functions/errorControllers.php';

// Penanganan Penambahan Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'add') {
        $nama_barang = $_POST['nama_barang'];
        $kategori = $_POST['kategori'];
        $stok = $_POST['stok'];
        $harga = $_POST['harga'];
        $supplier = $_POST['supplier'];

        $stmt = $conn->prepare("INSERT INTO inventory (nama_barang, kategori, stok, harga, supplier, tanggal_masuk) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssids", $nama_barang, $kategori, $stok, $harga, $supplier);
        if ($stmt->execute()) {
            $_SESSION['alert'] = "Item berhasil ditambahkan.";
        } else {
            $_SESSION['alert'] = "Gagal menambahkan item.";
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

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
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
      <h1 class="text-3xl font-bold mb-8 text-center">Manajemen Inventory</h1>

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

      <!-- Tombol Tambah Barang -->
      <div class="mb-4 text-center">
        <button onclick="showAddForm()" class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded text-white">Tambah Barang</button>
      </div>

      <div class="overflow-x-auto rounded-lg">
        <table id="inventoryTable" class="w-full">
          <thead class="bg-gray-700">
            <tr>
              <th class="p-4 text-center">No</th>
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

  <script>
    $(document).ready(function() {
      $('#inventoryTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        language: {
          url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        },
        columnDefs: [
          { className: 'dt-center', targets: '_all' }
        ],
        autoWidth: false,
        responsive: true
      });
    });

    // Fungsi untuk menampilkan form tambah barang menggunakan SweetAlert2
    function showAddForm() {
      Swal.fire({
        title: 'Tambah Barang',
        html: `
          <form id="addForm" class="text-left space-y-4">
            <input type="hidden" name="action" value="add">
            
            <div>
              <label class="block mb-2 text-gray-300">Nama Barang</label>
              <input type="text" name="nama_barang" class="w-full p-2 rounded bg-gray-700 text-white" required>
            </div>

            <div>
              <label class="block mb-2 text-gray-300">Kategori</label>
              <select name="kategori" class="w-full p-2 rounded bg-gray-700 text-white">
                <option value="Elektronik">Elektronik</option>
                <option value="Perkakas">Perkakas</option>
                <option value="Bahan">Bahan</option>
              </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block mb-2 text-gray-300">Stok</label>
                <input type="number" name="stok" class="w-full p-2 rounded bg-gray-700 text-white" required>
              </div>
              
              <div>
                <label class="block mb-2 text-gray-300">Harga</label>
                <input type="number" name="harga" class="w-full p-2 rounded bg-gray-700 text-white" required>
              </div>
            </div>

            <div>
              <label class="block mb-2 text-gray-300">Supplier</label>
              <input type="text" name="supplier" class="w-full p-2 rounded bg-gray-700 text-white" required>
            </div>
          </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Tambah Barang',
        cancelButtonText: 'Batal',
        background: '#1F2937',
        confirmButtonColor: '#2563EB',
        cancelButtonColor: '#6B7280',
        focusConfirm: false,
        preConfirm: () => {
          const formData = new FormData(document.getElementById('addForm'));
          const data = Object.fromEntries(formData.entries());
          
          // Validasi: semua kolom harus terisi
          if (!Object.values(data).every(value => value.toString().trim() !== '')) {
            Swal.showValidationMessage('Harap isi semua kolom');
            return false;
          }
          
          // Membuat dan mengirim form secara dinamis
          const form = document.createElement('form');
          form.method = 'POST';
          form.style.display = 'none';
          
          for (const [key, value] of Object.entries(data)) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            form.appendChild(input);
          }
          
          document.body.appendChild(form);
          form.submit();
        }
      });
    }
  </script>
</body>
</html>
