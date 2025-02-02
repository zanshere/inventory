<?php

    // Fungsi untuk menambah jumlah percobaan gagal
function incrementFailedAttempts($conn, $identifier) {
    // Cek apakah pengguna sedang diban
    if (isUserBanned($conn, $identifier)) {
        return; // Jangan tambahkan failed_attempts jika pengguna sedang diban
    }

    $query = "UPDATE users SET failed_attempts = failed_attempts + 1 WHERE username = '$identifier' OR email = '$identifier'";
    $conn->query($query);

    // Jika percobaan gagal lebih dari 5 kali, ban pengguna selama 5 menit
    $checkAttemptsQuery = "SELECT failed_attempts FROM users WHERE username = '$identifier' OR email = '$identifier'";
    $result = $conn->query($checkAttemptsQuery);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['failed_attempts'] >= 5) {
            $banUntil = date('Y-m-d H:i:s', strtotime('+5 minutes')); // Durasi ban 5 menit
            $banQuery = "UPDATE users SET banned_until = '$banUntil' WHERE username = '$identifier' OR email = '$identifier'";
            $conn->query($banQuery);
        }
    }
}

?>