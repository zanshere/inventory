<?php
session_start();
include '../includes/connect.php';

// Fungsi untuk memeriksa apakah pengguna sedang diban
function isUserBanned($conn, $email) {
    $query = "SELECT banned_until FROM users WHERE email = '$email'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['banned_until'] && strtotime($row['banned_until']) > time()) {
            return true; // Pengguna masih diban
        }
    }
    return false; // Pengguna tidak diban
}

// Fungsi untuk menambah jumlah percobaan gagal
function incrementFailedAttempts($conn, $email) {
    $query = "UPDATE users SET failed_attempts = failed_attempts + 1 WHERE email = '$email'";
    $conn->query($query);

    // Jika percobaan gagal lebih dari 5 kali, ban pengguna selama 15 menit
    $checkAttemptsQuery = "SELECT failed_attempts FROM users WHERE email = '$email'";
    $result = $conn->query($checkAttemptsQuery);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['failed_attempts'] >= 5) {
            $banUntil = date('Y-m-d H:i:s', strtotime('+5 minutes'));
            $banQuery = "UPDATE users SET banned_until = '$banUntil' WHERE email = '$email'";
            $conn->query($banQuery);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $name = $_POST['full_name'];

    // Cek apakah pengguna sedang diban
    if (isUserBanned($conn, $email)) {
        $_SESSION['register_status'] = 'error';
        $_SESSION['register_message'] = 'Anda terlalu banyak meng input error, Anda di Banned oleh sistem selama 15 Menit.';
        header('Location: register.php');
        exit();
    }

    // Cek apakah email sudah terdaftar
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $checkEmailResult = $conn->query($checkEmailQuery);

    if ($checkEmailResult->num_rows > 0) {
        incrementFailedAttempts($conn, $email); // Tambah percobaan gagal
        $_SESSION['register_status'] = 'error';
        $_SESSION['register_message'] = 'Email sudah terdaftar!';
        header('Location: register.php');
        exit();
    }

    // Cek apakah password kurang dari 5 karakter
    if (strlen($password) < 5) {
        incrementFailedAttempts($conn, $email); // Tambah percobaan gagal
        $_SESSION['register_status'] = 'error';
        $_SESSION['register_message'] = 'Password harus minimal 5 karakter!';
        header('Location: register.php');
        exit();
    }

    // Hash password sebelum disimpan ke database
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Query untuk insert data ke database
    $sql = "INSERT INTO users (username, password, email, full_name, failed_attempts) VALUES ('$username', '$hashedPassword', '$email', '$name', 0)";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['register_status'] = 'success';
        $_SESSION['register_message'] = 'Registrasi berhasil!';
    } else {
        $_SESSION['register_status'] = 'error';
        $_SESSION['register_message'] = 'Terjadi kesalahan: ' . $conn->error;
    }

    // Redirect kembali ke halaman register
    header('Location: register.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- TailwindCSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- CSS -->
     <link rel="stylesheet" href="../assets/CSS/font.css">
     <!-- Icon -->
    <link rel="shortcut icon" href="../assets/Images/box_icon_126533.ico" type="image/x-icon">
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md fade-in">
        <div class="bg-white shadow-xl rounded-lg p-8 border border-gray-300">
            <!-- Logo or Icon (Optional) -->
            <div class="flex justify-center mb-4">
                <div class="bg-indigo-500 text-white p-4 rounded-full shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 1.104-.897 2-2 2s-2-.896-2-2m6 0c0 1.104.897 2 2 2s2-.896 2-2m-7 4c0 2.21-2.015 4-4.5 4S3 17.21 3 15V5c0-2.21 2.015-4 4.5-4S12 2.79 12 5v4z" />
                    </svg>
                </div>
            </div>

            <!-- Title -->
            <h5 class="mb-6 text-center text-2xl font-bold text-gray-800">Hello There!</h5>

            <!-- Form -->
            <form action="" method="POST">
                <input type="hidden" name="action" value="register">

                <div class="mb-4">
                    <label for="username" class="block text-sm font-bold text-gray-700">Username</label>
                    <input type="text" class="mt-1 block w-full border border-gray-300 rounded-lg p-2 focus:ring-indigo-500 focus:border-indigo-500" name="username" placeholder="Your Username" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-bold text-gray-700">Password</label>
                    <input type="password" id="password" class="mt-1 block w-full border border-gray-300 rounded-lg p-2 focus:ring-indigo-500 focus:border-indigo-500" name="password" placeholder="Password Here" required>

                    <!-- Toggle Button (Icon + Text) -->
                    <button type="button" id="togglePasswordText" class="mt-2 flex items-center text-left text-indigo-500 focus:outline-none">
                        <i class="fa-regular fa-eye mr-2"></i>
                        <span>Show Password</span>
                    </button>
                </div>

                <div class="mb-4">
                    <label for="full_name" class="block text-sm font-bold text-gray-700">Full Name</label>
                    <input type="text" class="mt-1 block w-full border border-gray-300 rounded-lg p-2 focus:ring-indigo-500 focus:border-indigo-500" name="full_name" placeholder="John Doe" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-bold text-gray-700">Email Address</label>
                    <input type="email" class="mt-1 block w-full border border-gray-300 rounded-lg p-2 focus:ring-indigo-500 focus:border-indigo-500" name="email" placeholder="name@example.com" required>
                </div>

                <div class="flex justify-between items-center mb-6">
                    <p class="text-sm text-gray-700">
                        Already have an account? <a href="login.php" class="text-indigo-500 hover:underline font-semibold">Login</a>
                    </p>
                </div>

                <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                    Confirm
                </button>
            </form>
        </div>
    </div>

    <script>
        // Cek session untuk menampilkan SweetAlert
        <?php if (isset($_SESSION['register_status'])): ?>
            const status = "<?php echo $_SESSION['register_status']; ?>";
            const message = "<?php echo $_SESSION['register_message']; ?>";

            if (status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: message,
                }).then(() => {
                    window.location.href = 'login.php'; // Redirect ke halaman login
                });
            } else if (status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: message,
                });
            }

            // Hapus session setelah menampilkan pesan
            <?php unset($_SESSION['register_status']); ?>
            <?php unset($_SESSION['register_message']); ?>
        <?php endif; ?>
    </script>
    <!-- Toggle Password -->
    <script src="../assets/JS/togglePassword.js"></script>
</body>
</html>