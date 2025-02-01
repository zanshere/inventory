<?php
require '../includes/connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    try {
        // Catat waktu logout ke database
        $query = "UPDATE logs SET action = 'logout', action_details = 'logout account', action_time = NOW() WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            // Hapus semua data sesi
            session_unset();

            // Simpan pesan logout di sesi
            $_SESSION['logout_message'] = 'Anda telah berhasil logout.';

            // Hancurkan sesi
            if (session_destroy()) {
                // Redirect ke halaman login
                header("Location: login.php");
                exit();
            } else {
                throw new Exception("Gagal menghapus sesi.");
            }
        } else {
            throw new Exception("Gagal mencatat aktivitas logout.");
        }
    } catch (Exception $e) {
        // Tangani error
        error_log($e->getMessage());
        $_SESSION['error_message'] = 'Terjadi kesalahan saat logout. Silakan coba lagi.';
        header("Location: login.php");
        exit();
    }
} else {
    // Jika tidak ada sesi user_id, redirect ke halaman login
    header("Location: login.php");
    exit();
}
?>