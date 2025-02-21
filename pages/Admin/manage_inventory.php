<?php
session_start();
require_once '../../includes/connect.php';
include '../../functions/errorControllers.php';

// ---------------------
// Penanganan CRUD
// ---------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    // Update Item
    if ($action === 'update') {
        $item_id = $_POST['item_id'];
        $nama_barang = $_POST['nama_barang'];
        $kategori = $_POST['kategori'];
        $stok = $_POST['stok'];
        $harga = $_POST['harga'];
        $supplier = $_POST['supplier'];

        $stmt = $conn->prepare("UPDATE inventory SET 
            nama_barang = ?, 
            kategori = ?, 
            stok = ?, 
            harga = ?, 
            supplier = ? 
            WHERE id = ?");
        $stmt->bind_param("ssidsi", $nama_barang, $kategori, $stok, $harga, $supplier, $item_id);
        if ($stmt->execute()) {
            $_SESSION['alert'] = "Item berhasil diperbarui.";
        } else {
            $_SESSION['alert'] = "Gagal memperbarui item.";
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;

    // Hapus Item
    } elseif ($action === 'delete') {
        $item_id = $_POST['item_id'];
        $stmt = $conn->prepare("DELETE FROM inventory WHERE id = ?");
        $stmt->bind_param("i", $item_id);
        if ($stmt->execute()) {
            $_SESSION['alert'] = "Item berhasil dihapus.";
        } else {
            $_SESSION['alert'] = "Gagal menghapus item.";
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
  <!-- SweetAlert2 -->
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
              <th class="p-4 text-center">Aksi</th>
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
                <td class="p-3 text-center">
                  <div class="flex justify-center space-x-2">
                    <button onclick="showEditForm(<?= $item['id'] ?>)" 
                      class="bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-lg transition-colors">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="deleteItem(<?= $item['id'] ?>)" 
                      class="bg-red-500 hover:bg-red-600 px-3 py-2 rounded-lg transition-colors">
                      <i class="fas fa-trash"></i>
                    </button>
                    <button id="saveDataBtn" onclick="showSaveOptions()" class="bg-indigo-500 hover:bg-indigo-600 px-3 py-2 rounded-lg transition-color"><i class="fas fa-download"></i></button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    // Inisialisasi DataTable dengan tombol ekspor (Buttons) yang disembunyikan
    let table;
    $(document).ready(function() {
      table = $('#inventoryTable').DataTable({
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
        responsive: true,
        // Sembunyikan tombol bawaan DataTable
        initComplete: function () {
          $(this.api().buttons().container()).hide();
        }
      });
    });

    // Fungsi untuk menampilkan SweetAlert dengan opsi ekspor
    function showSaveOptions() {
      Swal.fire({
        title: 'Simpan Data',
        html: `
          <div class="flex justify-around mt-4">
            <button id="excelBtn" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Excel</button>
            <button id="pdfBtn" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">PDF</button>
            <button id="csvBtn" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">CSV</button>
            <button id="printBtn" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Print</button>
          </div>
        `,
        showConfirmButton: false,
        background: '#1F2937'
      });

      const popup = Swal.getPopup();
      popup.querySelector('#excelBtn').addEventListener('click', () => exportTable('excel'));
      popup.querySelector('#pdfBtn').addEventListener('click', () => exportTable('pdf'));
      popup.querySelector('#csvBtn').addEventListener('click', () => exportTable('csv'));
      popup.querySelector('#printBtn').addEventListener('click', () => exportTable('print'));
    }

    // Fungsi untuk memicu tombol ekspor DataTable sesuai format
    function exportTable(format) {
      let buttonIndex;
      switch (format) {
        case 'csv':
          buttonIndex = 1;
          break;
        case 'excel':
          buttonIndex = 2;
          break;
        case 'pdf':
          buttonIndex = 3;
          break;
        case 'print':
          buttonIndex = 4;
          break;
        default:
          return;
      }
      table.button(buttonIndex).trigger();
      Swal.close();
    }

    // Fungsi Edit: Memperbaiki pencarian item berdasarkan ID dengan perbandingan numerik
    function showEditForm(itemId) {
      const items = <?= json_encode($items) ?>;
      const item = items.find(i => parseInt(i.id) === parseInt(itemId));
      if (!item) {
        console.error("Item tidak ditemukan untuk id " + itemId);
        return;
      }
      
      Swal.fire({
        title: 'EDIT BARANG',
        html: `
          <form id="editForm" class="text-left space-y-4">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="item_id" value="${itemId}">
            
            <div>
              <label class="block mb-2 text-gray-300">Nama Barang</label>
              <input type="text" name="nama_barang" value="${item.nama_barang}"
                class="w-full p-2 rounded bg-gray-700 text-white" required>
            </div>

            <div>
              <label class="block mb-2 text-gray-300">Kategori</label>
              <select name="kategori" class="w-full p-2 rounded bg-gray-700 text-white">
                <option value="Elektronik" ${item.kategori === 'Elektronik' ? 'selected' : ''}>Elektronik</option>
                <option value="Perkakas" ${item.kategori === 'Perkakas' ? 'selected' : ''}>Perkakas</option>
                <option value="Bahan" ${item.kategori === 'Bahan' ? 'selected' : ''}>Bahan</option>
              </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block mb-2 text-gray-300">Stok</label>
                <input type="text" type="numeric" name="stok" value="${item.stok}"
                  class="w-full p-2 rounded bg-gray-700 text-white" required>
              </div>
              
              <div>
                <label class="block mb-2 text-gray-300">Harga</label>
                <input type="text" type="numeric" name="harga" value="${item.harga}"
                  class="w-full p-2 rounded bg-gray-700 text-white" required>
              </div>
            </div>

            <div>
              <label class="block mb-2 text-gray-300">Supplier</label>
              <input type="text" name="supplier" value="${item.supplier}"
                class="w-full p-2 rounded bg-gray-700 text-white" required>
            </div>
          </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Simpan Perubahan',
        cancelButtonText: 'Batal',
        background: '#1F2937',
        confirmButtonColor: '#2563EB',
        cancelButtonColor: '#6B7280',
        focusConfirm: false,
        preConfirm: () => {
          const formData = new FormData(document.getElementById('editForm'));
          const data = Object.fromEntries(formData.entries());
          
          // Validasi: Pastikan semua kolom terisi
          if (!Object.values(data).every(value => value.toString().trim() !== '')) {
            Swal.showValidationMessage('Harap isi semua kolom');
            return false;
          }

          // Submit form secara dinamis
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

    // Fungsi untuk menghapus item dengan SweetAlert2
    function deleteItem(itemId) {
      Swal.fire({
        title: 'HAPUS BARANG?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2563EB',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        background: '#1F2937'
      }).then((result) => {
        if (result.isConfirmed) {
          const form = document.createElement('form');
          form.method = 'POST';
          form.innerHTML = `
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="item_id" value="${itemId}">
          `;
          document.body.append(form);
          form.submit();
        }
      });
    }
  </script>
</body>
</html>
