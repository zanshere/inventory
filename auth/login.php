<?php
session_start();
include '../includes/connect.php';
include '../functions/isUserBanned.php';
include '../functions/incrementFailedAttempts.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifier = $_POST['identifier']; // Bisa berupa username atau email
    $password = $_POST['password'];

    // Cek apakah pengguna sedang diban karena login gagal (system ban)
    $bannedUntil = isUserBanned($conn, $identifier);
    if ($bannedUntil) {
        // Hitung sisa waktu ban dalam detik
        $remainingTime = strtotime($bannedUntil) - time();
        $_SESSION['ban_remaining'] = $remainingTime;
        $_SESSION['login_status'] = 'banned';
        $_SESSION['login_message'] = 'Kamu telah diban oleh sistem selama 5 menit karena gagal melakukan login lebih dari 5 kali.';
        header('Location: login.php');
        exit();
    }

    // Proses login normal
    $query = "SELECT * FROM users WHERE username = '$identifier' OR email = '$identifier'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Cek apakah akun dinonaktifkan oleh admin
        if ($user['is_active'] == 0) {
            $_SESSION['login_status'] = 'error';
            $_SESSION['login_message'] = 'Akun anda telah dinonaktifkan oleh admin.';
            header('Location: login.php');
            exit();
        }

        // Cek apakah akun disuspend oleh admin
        if ($user['suspend_until'] && strtotime($user['suspend_until']) > time()) {
            $_SESSION['login_status'] = 'error';
            $_SESSION['login_message'] = 'Akun anda telah disuspend oleh admin hingga ' . date("d-m-Y H:i:s", strtotime($user['suspend_until'])) . '. Hubungi admin untuk info lebih lanjut.';
            header('Location: login.php');
            exit();
        }

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Reset failed_attempts jika login berhasil
            $resetAttemptsQuery = "UPDATE users SET failed_attempts = 0 WHERE username = '$identifier' OR email = '$identifier'";
            $conn->query($resetAttemptsQuery);

            // Simpan data user ke session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            $_SESSION['login_status'] = 'success';
            $_SESSION['login_message'] = 'Hello ' . $user['username'] . ', You Will Be Directed To ' . ucfirst($user['role']) . ' Dashboard';
        } else {
            // Password salah, tambah failed_attempts
            incrementFailedAttempts($conn, $identifier);

            $checkAttemptsQuery = "SELECT failed_attempts FROM users WHERE username = '$identifier' OR email = '$identifier'";
            $resultAttempts = $conn->query($checkAttemptsQuery);
            if ($resultAttempts->num_rows > 0) {
                $row = $resultAttempts->fetch_assoc();
                if ($row['failed_attempts'] >= 5) {
                    $_SESSION['login_status'] = 'banned';
                    $_SESSION['login_message'] = 'Kamu telah diban oleh sistem selama 5 menit karena gagal melakukan login lebih dari 5 kali.';
                    $banDuration = 5 * 60; // 5 menit dalam detik
                    $_SESSION['ban_remaining'] = $banDuration;
                } else {
                    $_SESSION['login_status'] = 'error';
                    $_SESSION['login_message'] = 'Password salah! Percobaan gagal: ' . $row['failed_attempts'];
                }
            }
            header('Location: login.php');
            exit();
        }
    } else {
        // Username/email tidak terdaftar, increment failed_attempts
        incrementFailedAttempts($conn, $identifier);

        $checkAttemptsQuery = "SELECT failed_attempts FROM users WHERE username = '$identifier' OR email = '$identifier'";
        $resultAttempts = $conn->query($checkAttemptsQuery);
        if ($resultAttempts->num_rows > 0) {
            $row = $resultAttempts->fetch_assoc();
            if ($row['failed_attempts'] >= 5) {
                $_SESSION['login_status'] = 'banned';
                $_SESSION['login_message'] = 'Kamu telah diban oleh sistem selama 5 menit karena gagal melakukan login lebih dari 5 kali.';
                $banDuration = 5 * 60;
                $_SESSION['ban_remaining'] = $banDuration;
            } else {
                $_SESSION['login_status'] = 'error';
                $_SESSION['login_message'] = 'Username atau email tidak terdaftar! Percobaan gagal: ' . $row['failed_attempts'];
            }
        }
        header('Location: login.php');
        exit();
    }

    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
      <!-- Logo atau Icon -->
      <div class="flex justify-center mb-4">
        <div class="bg-indigo-500 text-white p-4 rounded-full shadow-md">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 1.104-.897 2-2 2s-2-.896-2-2m6 0c0 1.104.897 2 2 2s2-.896 2-2m-7 4c0 2.21-2.015 4-4.5 4S3 17.21 3 15V5c0-2.21 2.015-4 4.5-4S12 2.79 12 5v4z" />
          </svg>
        </div>
      </div>

      <!-- Title -->
      <h5 class="mb-2 text-center text-2xl font-bold text-gray-800">Hello There!</h5>
      <p class="mb-6 text-center text-sm font-bold text-gray-800">Please log in to access the page</p>

      <!-- Form -->
      <form action="login.php" method="POST">
        <div class="mb-4">
          <label for="identifier" class="block text-sm font-bold text-gray-700">Username atau Email</label>
          <input type="text" 
                 class="mt-1 block w-full border border-gray-300 rounded-lg p-2 focus:ring-indigo-500 focus:border-indigo-500" 
                 name="identifier" 
                 placeholder="Username atau Email" 
                 required>
        </div>
                
        <!-- Container Password Input dan Toggle -->
        <div class="mb-4">
          <label for="password" class="block text-sm font-bold text-gray-700">Password</label>
          <input type="password"
                 id="password"
                 name="password"
                 placeholder="Password Here"
                 class="mt-1 block w-full border border-gray-300 rounded-lg p-2 focus:ring-indigo-500 focus:border-indigo-500"
                 required>
                
          <!-- Tombol Toggle (ikon + teks) di bawah input, sejajar kiri -->
          <button type="button" 
                  id="togglePasswordText" 
                  class="mt-2 flex items-center text-left text-indigo-500 focus:outline-none">
            <i class="fa-regular fa-eye mr-2"></i>
            <span>Show Password</span>
          </button>
        </div>

        <div class="flex justify-between items-center mb-6">
          <p class="text-sm text-gray-700">
            Don't have an account? <a href="register.php" class="text-indigo-500 hover:underline font-semibold">Create</a>
          </p>
        </div>
                
        <button type="submit" 
                class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 mb-4 rounded-lg transition duration-300 ease-in-out">
          Confirm
        </button>

        <a href="../index.php" 
          class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out block text-center focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2">
            Back
        </a>
      </form>
    </div>
  </div>
    
  <!-- Tampilkan pesan status login -->
  <?php if (isset($_SESSION['login_status'])): ?>
    <script>
      // Fungsi untuk memformat waktu (detik) menjadi format mm:ss
      function formatTime(seconds) {
          let m = Math.floor(seconds / 60);
          let s = seconds % 60;
          return (m < 10 ? '0' + m : m) + ':' + (s < 10 ? '0' + s : s);
      }

      <?php if ($_SESSION['login_status'] == 'banned'): 
          $banRemaining = isset($_SESSION['ban_remaining']) ? (int) $_SESSION['ban_remaining'] : 0;
      ?>
          let banTime = <?php echo $banRemaining; ?>;
          Swal.fire({
              icon: 'error',
              title: 'Dilarang',
              html: 'Kamu telah diban oleh sistem selama 5 menit karena gagal melakukan login lebih dari 5 kali.<br>Silahkan coba lagi dalam <span id="countdown">' + formatTime(banTime) + '</span>.',
              allowOutsideClick: false,
              allowEscapeKey: false,
              showConfirmButton: false,
              timer: banTime * 1000,
              didOpen: () => {
                  const countdownEl = Swal.getHtmlContainer().querySelector('#countdown');
                  let timeLeft = banTime;
                  const interval = setInterval(() => {
                      timeLeft--;
                      countdownEl.textContent = formatTime(timeLeft);
                      if (timeLeft <= 0) {
                          clearInterval(interval);
                      }
                  }, 1000);
              }
          }).then(() => {
              window.location.href = 'login.php';
          });
      <?php else: ?>
          Swal.fire({
              icon: '<?php echo $_SESSION['login_status']; ?>',
              title: '<?php echo $_SESSION['login_status'] == 'success' ? 'Berhasil' : 'Gagal'; ?>',
              text: '<?php echo $_SESSION['login_message']; ?>'
          }).then((result) => {
              <?php if ($_SESSION['login_status'] == 'success'): ?>
                  <?php if ($_SESSION['role'] == 'admin'): ?>
                      window.location.href = '../pages/Admin/dashboard.php';
                  <?php elseif ($_SESSION['role'] == 'staff'): ?>
                      window.location.href = '../pages/Staff/dashboard.php';
                  <?php else: ?>
                      window.location.href = '../pages/User/dashboard.php';
                  <?php endif; ?>
              <?php else: ?>
                  window.location.href = 'login.php';
              <?php endif; ?>
          });
      <?php endif; ?>
    </script>
    <?php
      unset($_SESSION['login_status']);
      unset($_SESSION['login_message']);
      unset($_SESSION['ban_remaining']);
    ?>
  <?php endif; ?>
  <!-- Toggle Password Script -->
  <script src="../assets/JS/togglePassword.js"></script>
</body>
</html>
