<?php
// Koneksi database (sesuaikan dengan konfigurasi Anda)
session_start();
include '../../includes/connect.php';
include '../../functions/errorControllers.php';

// Handle filter tanggal
$start_date = $_GET['start_date'] ?? date('Y-m-01');
$end_date = $_GET['end_date'] ?? date('Y-m-t');
$search = $_GET['search'] ?? '';
// Query data transaksi
$query = "SELECT * FROM item_transactions 
          WHERE (transaction_date BETWEEN ? AND ?) 
          AND item_name LIKE ? 
          ORDER BY transaction_date DESC";
$stmt = $conn->prepare($query);
$search_term = "%$search%";
$stmt->bind_param("sss", $start_date, $end_date, $search_term);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-900 text-white"> <!-- Ubah latar belakang dan teks menjadi putih -->
    <!-- Header -->
    <?php include '../../includes/header.php'; ?>
    <!-- SweetAlert SESSION -->
    <?php if (isset($_SESSION['alert'])): ?> 
        <script> Swal.fire({ icon: 'success', title: 'Berhasil', text: <?= json_encode($_SESSION['alert']) ?> });</script>
    <?php unset($_SESSION['alert']); ?> 
    <?php endif; ?>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4 text-gray-200"> <!-- Ubah warna teks judul -->
            <i class="fas fa-boxes mr-2"></i>Laporan Keluar Masuk Barang
        </h1>
        <!-- Filter Section -->
        <div class="bg-gray-800 p-4 rounded-lg shadow mb-4"> <!-- Ubah latar belakang filter -->
            <form method="GET" class="flex flex-wrap gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-400">Tanggal Mulai</label> <!-- Ubah warna label -->
                    <input type="date" name="start_date" value="<?= $start_date ?>" 
                           class="mt-1 p-2 border rounded-md bg-gray-700 text-white"> <!-- Ubah input -->
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="<?= $end_date ?>" 
                           class="mt-1 p-2 border rounded-md bg-gray-700 text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400">Cari Barang</label>
                    <input type="text" name="search" value="<?= $search ?>" 
                           class="mt-1 p-2 border rounded-md bg-gray-700 text-white" placeholder="Nama barang...">
                </div>
                <button type="submit" 
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                <button type="button" onclick="resetFilter()"
                        class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                    <i class="fas fa-sync mr-2"></i>Reset
                </button>
            </form>
        </div>
        <!-- Tabel Laporan -->
        <div class="bg-gray-800 rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700"> <!-- Ubah latar belakang header tabel -->
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            <i class="fas fa-calendar mr-2"></i>Tanggal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            <i class="fas fa-cube mr-2"></i>Nama Barang
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            <i class="fas fa-exchange-alt mr-2"></i>Jenis
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            <i class="fas fa-user mr-2"></i>Staff
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            <i class="fas fa-hashtag mr-2"></i>Jumlah
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            <i class="fas fa-tools mr-2"></i>Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700"> <!-- Ubah latar belakang body tabel -->
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-300"><?= $row['transaction_date'] ?></td> <!-- Ubah warna teks -->
                        <td class="px-6 py-4 whitespace-nowrap text-gray-300"><?= $row['item_name'] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if ($row['type'] == 'New'): ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-700 text-green-200">
                                    <i class="fas fa-plus mr-1"></i>Baru
                                </span>
                            <?php elseif ($row['type'] == 'Plus'): ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-700 text-blue-200">
                                    <i class="fas fa-arrow-up mr-1"></i>Tambah
                                </span>
                            <?php elseif ($row['type'] == 'Min'): ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-700 text-yellow-200">
                                    <i class="fas fa-arrow-down mr-1"></i>Kurang
                                </span>
                            <?php elseif ($row['type'] == 'Out'): ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-700 text-red-200">
                                    <i class="fas fa-trash-alt mr-1"></i>Habis
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-300"><?= $row['staff_name'] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-300"><?= $row['quantity'] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button onclick="confirmDelete(<?= $row['id'] ?>)" 
                                    class="text-red-400 hover:text-red-300">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
    function resetFilter() {
        window.location.search = '';
    }
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete_transaction.php',
                    method: 'POST',
                    data: {id: id},
                    success: function(response) {
                        if(response.success) {
                            Swal.fire(
                                'Terhapus!',
                                'Data berhasil dihapus.',
                                'success'
                            ).then(() => location.reload());
                        } else {
                            Swal.fire(
                                'Gagal!',
                                response.message,
                                'error'
                            );
                        }
                    }
                });
            }
        });
    }
    </script>
</body>
</html>