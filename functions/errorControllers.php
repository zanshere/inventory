<?php

// Redirect jika tidak login: tampilkan error 403
if (! isset($_SESSION['user_id'])) {
    http_response_code(403);   // Set status HTTP ke 403 Forbidden
    $_GET['code'] = 403;       // Pastikan error.php mengetahui kode error yang diinginkan
    include '../../error.php'; // Sesuaikan path ke file error.php
    exit;                      // Hentikan eksekusi script selanjutnya
}

// Ambil role dari session
$role = $_SESSION['role'] ?? 'user';

?>