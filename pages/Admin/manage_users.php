<?php
session_start();
require_once '../../includes/connect.php';

// Tangani aksi form (update, suspend, deactivate/activate, delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'update') {
        // Ambil data dari form edit
        $user_id   = $_POST['user_id'];
        $username  = $_POST['username'];
        $full_name = $_POST['full_name'];
        $email     = $_POST['email'];
        $role      = $_POST['role'];
        $password  = trim($_POST['password']);

        if (!empty($password)) {
            // Jika password diisi, hash dan update password juga
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET username = ?, full_name = ?, email = ?, role = ?, password = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $username, $full_name, $email, $role, $hashed_password, $user_id);
        } else {
            // Jika password kosong, jangan diupdate
            $stmt = $conn->prepare("UPDATE users SET username = ?, full_name = ?, email = ?, role = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $username, $full_name, $email, $role, $user_id);
        }
        if ($stmt->execute()) {
            $_SESSION['alert'] = "Data user berhasil diperbarui.";
        } else {
            $_SESSION['alert'] = "Gagal memperbarui data user.";
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } elseif ($action === 'suspend') {
        // Proses suspend user dengan menghitung waktu suspend
        $user_id  = $_POST['user_id'];
        $duration = intval($_POST['duration']);
        $unit     = $_POST['unit'];
        $suspend_until = null;

        switch ($unit) {
            case 'minutes':
                $suspend_until = date("Y-m-d H:i:s", time() + ($duration * 60));
                break;
            case 'hours':
                $suspend_until = date("Y-m-d H:i:s", time() + ($duration * 3600));
                break;
            case 'days':
                $suspend_until = date("Y-m-d H:i:s", time() + ($duration * 86400));
                break;
        }

        $stmt = $conn->prepare("UPDATE users SET suspend_until = ? WHERE id = ?");
        $stmt->bind_param("si", $suspend_until, $user_id);
        if ($stmt->execute()) {
            $_SESSION['alert'] = "User berhasil disuspend hingga $suspend_until.";
        } else {
            $_SESSION['alert'] = "Gagal suspend user.";
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } elseif ($action === 'deactivate') {
        // Nonaktifkan akun (set is_active = 0)
        $user_id = $_POST['user_id'];
        $stmt = $conn->prepare("UPDATE users SET is_active = 0 WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $_SESSION['alert'] = "Akun user telah dinonaktifkan.";
        } else {
            $_SESSION['alert'] = "Gagal menonaktifkan akun.";
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } elseif ($action === 'activate') {
        // Aktifkan kembali akun (set is_active = 1)
        $user_id = $_POST['user_id'];
        $stmt = $conn->prepare("UPDATE users SET is_active = 1 WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $_SESSION['alert'] = "Akun user telah diaktifkan kembali.";
        } else {
            $_SESSION['alert'] = "Gagal mengaktifkan akun.";
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } elseif ($action === 'delete') {
        // Hapus user
        $user_id = $_POST['user_id'];
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $_SESSION['alert'] = "User berhasil dihapus.";
        } else {
            $_SESSION['alert'] = "Gagal menghapus user.";
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Ambil data user
$stmt = $conn->query("SELECT * FROM users");
$users = $stmt->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Pengguna</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Heroicons CDN -->
  <script src="https://unpkg.com/heroicons@2.0.18/dist/heroicons.min.js"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black min-h-screen">

<!-- Header -->
 <?php include '../../includes/header.php';?>

  <div class="container mx-auto p-6">
    <?php if(isset($_SESSION['alert'])): ?>
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: '<?= $_SESSION['alert'] ?>',
          confirmButtonColor: '#3B82F6'
        });
      </script>
      <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>

    <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 shadow-lg">
      <h1 class="text-2xl font-bold text-white mb-6">Manajemen Pengguna</h1>
      
      <div class="overflow-x-auto">
        <table class="w-full text-white border-collapse">
          <thead class="bg-white/20">
            <tr>
              <th class="p-3 text-left rounded-tl-xl">No</th>
              <th class="p-3 text-left">Username</th>
              <th class="p-3 text-left">Nama Lengkap</th>
              <th class="p-3 text-left">Email</th>
              <th class="p-3 text-left">Role</th>
              <th class="p-3 text-left">Status</th>
              <th class="p-3 text-left rounded-tr-xl">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $index => $user): ?>
            <!-- Simpan full_name sebagai data attribute -->
            <tr class="hover:bg-white/5 transition-colors" data-full_name="<?= htmlspecialchars($user['full_name']) ?>">
              <td class="p-3"><?= $index + 1 ?></td>
              <td class="p-3"><?= htmlspecialchars($user['username']) ?></td>
              <td class="p-3"><?= htmlspecialchars($user['full_name']) ?></td>
              <td class="p-3"><?= htmlspecialchars($user['email']) ?></td>
              <td class="p-3"><?= htmlspecialchars($user['role']) ?></td>
              <td class="p-3">
                <?php if ($user['is_active'] == 0): ?>
                  <span class="text-red-500 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 18a8 8 0 100-16 8 8 0 000 16z"/>
                    </svg>
                    Nonaktif
                  </span>
                <?php elseif ($user['suspend_until'] && strtotime($user['suspend_until']) > time()): ?>
                  <span class="text-red-500 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368z"/>
                    </svg>
                    Suspended
                  </span>
                <?php else: ?>
                  <span class="text-green-500 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586l-2.293-2.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/>
                    </svg>
                    Active
                  </span>
                <?php endif; ?>
              </td>
              <td class="p-3">
                <div class="flex flex-wrap gap-2">
                  <button onclick="showEditForm(<?= $user['id'] ?>)" class="bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Edit
                  </button>
                  <button onclick="suspendUser(<?= $user['id'] ?>)" class="bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Suspend
                  </button>
                  <?php if ($user['is_active'] == 1): ?>
                    <button onclick="deactivateUser(<?= $user['id'] ?>)" class="bg-indigo-500 hover:bg-indigo-600 px-3 py-1 rounded flex items-center">
                      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-1.414 1.414M6.343 17.657l-1.414 1.414M18.364 18.364l-1.414-1.414M6.343 6.343L4.93 7.757M12 8v4m0 4h.01"/>
                      </svg>
                      Nonaktif
                    </button>
                  <?php else: ?>
                    <button onclick="activateUser(<?= $user['id'] ?>)" class="bg-green-500 hover:bg-green-600 px-3 py-1 rounded flex items-center">
                      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                      </svg>
                      Aktifkan
                    </button>
                  <?php endif; ?>
                  <button onclick="deleteUser(<?= $user['id'] ?>)" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus
                  </button>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal Edit Form -->
  <div id="editForm" class="fixed inset-0 bg-black/50 hidden items-center justify-center">
    <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 w-full max-w-md">
      <form method="POST" class="space-y-4">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="user_id" id="edit_user_id">
        
        <div>
          <label class="block text-white mb-2">Username</label>
          <input type="text" name="username" id="edit_username" class="w-full bg-white/20 rounded p-2 text-white focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div>
          <label class="block text-white mb-2">Nama Lengkap</label>
          <input type="text" name="full_name" id="edit_full_name" class="w-full bg-white/20 rounded p-2 text-white focus:ring-2 focus:ring-blue-500" required>
        </div>
        
        <div>
          <label class="block text-white mb-2">Email</label>
          <input type="email" name="email" id="edit_email" class="w-full bg-white/20 rounded p-2 text-white focus:ring-2 focus:ring-blue-500" required>
        </div>
        
        <div>
          <label class="block text-white mb-2">Role</label>
          <select name="role" id="edit_role" class="w-full bg-white/20 rounded p-2 text-white focus:ring-2 focus:ring-blue-500">
            <option value="user">User</option>
            <option value="admin">Admin</option>
          </select>
        </div>
        
        <div>
          <label class="block text-white mb-2">Password</label>
          <input type="password" name="password" id="edit_password" placeholder="Kosongkan jika tidak ingin mengubah password" class="w-full bg-white/20 rounded p-2 text-white focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div class="flex justify-end space-x-3">
          <button type="button" onclick="document.getElementById('editForm').style.display = 'none'" class="px-4 py-2 rounded bg-gray-500 hover:bg-gray-600 text-white">
            Batal
          </button>
          <button type="submit" class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-600 text-white">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>


  <script>
    // Tampilkan modal edit dan isi data dari baris tabel
    function showEditForm(userId) {
      const userRow = event.target.closest('tr');
      const cells = userRow.querySelectorAll('td');
      
      document.getElementById('edit_user_id').value = userId;
      document.getElementById('edit_username').value = cells[1].innerText.trim();
      document.getElementById('edit_full_name').value = userRow.dataset.full_name;
      document.getElementById('edit_email').value = cells[3].innerText.trim();
      document.getElementById('edit_role').value = cells[4].innerText.trim();
      document.getElementById('edit_password').value = "";
      
      document.getElementById('editForm').style.display = 'flex';
    }

    // Fungsi suspend user menggunakan SweetAlert2
    function suspendUser(userId) {
      Swal.fire({
        title: 'Suspend User',
        html: `
          <form id="suspendForm" method="POST" class="space-y-4">
            <input type="hidden" name="action" value="suspend">
            <input type="hidden" name="user_id" value="${userId}">
            <div>
              <label class="block text-gray-700 mb-2">Durasi</label>
              <div class="flex space-x-2">
                <input type="number" name="duration" min="1" required class="w-1/2 bg-gray-100 rounded p-2 focus:ring-2 focus:ring-blue-500">
                <select name="unit" class="w-1/2 bg-gray-100 rounded p-2 focus:ring-2 focus:ring-blue-500">
                  <option value="minutes">Menit</option>
                  <option value="hours">Jam</option>
                  <option value="days">Hari</option>
                </select>
              </div>
            </div>
            <div>
              <label class="block text-gray-700 mb-2">Alasan</label>
              <textarea name="reason" required class="w-full bg-gray-100 rounded p-2 focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
          </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Suspend',
        cancelButtonText: 'Batal',
        focusConfirm: false,
        customClass: {
          popup: 'rounded-xl',
          actions: 'space-x-3',
          confirmButton: 'bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded',
          cancelButton: 'bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded'
        },
        preConfirm: () => {
          document.getElementById('suspendForm').submit();
        }
      });
    }

    // Fungsi untuk menonaktifkan akun dengan SweetAlert2
    function deactivateUser(userId) {
      Swal.fire({
        title: 'Nonaktifkan Akun',
        text: 'Apakah Anda yakin ingin menonaktifkan akun ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Nonaktifkan',
        cancelButtonText: 'Batal',
        customClass: {
          confirmButton: 'bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded',
          cancelButton: 'bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          const form = document.createElement('form');
          form.method = 'POST';
          form.action = '';
          
          const actionInput = document.createElement('input');
          actionInput.type = 'hidden';
          actionInput.name = 'action';
          actionInput.value = 'deactivate';
          form.appendChild(actionInput);
          
          const userIdInput = document.createElement('input');
          userIdInput.type = 'hidden';
          userIdInput.name = 'user_id';
          userIdInput.value = userId;
          form.appendChild(userIdInput);
          
          document.body.appendChild(form);
          form.submit();
        }
      });
    }

    // Fungsi untuk mengaktifkan kembali akun dengan SweetAlert2
    function activateUser(userId) {
      Swal.fire({
        title: 'Aktifkan Akun',
        text: 'Apakah Anda yakin ingin mengaktifkan akun ini kembali?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Aktifkan',
        cancelButtonText: 'Batal',
        customClass: {
          confirmButton: 'bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded',
          cancelButton: 'bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          const form = document.createElement('form');
          form.method = 'POST';
          form.action = '';
          
          const actionInput = document.createElement('input');
          actionInput.type = 'hidden';
          actionInput.name = 'action';
          actionInput.value = 'activate';
          form.appendChild(actionInput);
          
          const userIdInput = document.createElement('input');
          userIdInput.type = 'hidden';
          userIdInput.name = 'user_id';
          userIdInput.value = userId;
          form.appendChild(userIdInput);
          
          document.body.appendChild(form);
          form.submit();
        }
      });
    }

    // Fungsi hapus user dengan SweetAlert2
    function deleteUser(userId) {
      Swal.fire({
        title: 'Hapus User',
        text: 'Anda yakin ingin menghapus user ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        customClass: {
          confirmButton: 'bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded',
          cancelButton: 'bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          const form = document.createElement('form');
          form.method = 'POST';
          form.action = '';
          
          const actionInput = document.createElement('input');
          actionInput.type = 'hidden';
          actionInput.name = 'action';
          actionInput.value = 'delete';
          form.appendChild(actionInput);
          
          const userIdInput = document.createElement('input');
          userIdInput.type = 'hidden';
          userIdInput.name = 'user_id';
          userIdInput.value = userId;
          form.appendChild(userIdInput);
          
          document.body.appendChild(form);
          form.submit();
        }
      });
    }
  </script>
</body>
</html>
