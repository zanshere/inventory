<?php

    // Fungsi untuk memeriksa apakah pengguna sedang diban
function isUserBanned($conn, $identifier) {
    $query = "SELECT banned_until, failed_attempts FROM users WHERE username = '$identifier' OR email = '$identifier'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['banned_until']) {
            // Cek apakah waktu ban sudah berlalu
            if (strtotime($row['banned_until']) > time()) {
                return $row['banned_until']; // Kembalikan waktu ban jika masih berlaku
            } else {
                // Reset status ban jika waktu ban sudah berlalu
                $resetQuery = "UPDATE users SET banned_until = NULL, failed_attempts = 0 WHERE username = '$identifier' OR email = '$identifier'";
                $conn->query($resetQuery);
                return false; // Pengguna tidak diban
            }
        }
    }
    return false; // Pengguna tidak diban
}

?>