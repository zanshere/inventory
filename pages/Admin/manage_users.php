<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin User Control</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .action-table {
            transition: all 0.3s ease;
        }
        
        .fixed-column {
            min-width: 200px;
            position: sticky;
            left: 0;
            z-index: 1;
            background: white;
        }
    </style>
</head>
<body class="bg-gray-100 p-8">
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-6">User Management</h1>

        <!-- User Table -->
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider fixed-column">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap fixed-column">1</td>
                        <td class="px-6 py-4 whitespace-nowrap">John Doe</td>
                        <td class="px-6 py-4 whitespace-nowrap">john@example.com</td>
                        <td class="px-6 py-4 whitespace-nowrap">User</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button onclick="showEditForm()" class="text-blue-500 hover:text-blue-700 mr-2">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="suspendUser()" class="text-yellow-500 hover:text-yellow-700 mr-2">
                                <i class="fas fa-lock"></i>
                            </button>
                            <button onclick="deleteUser()" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Edit Form Table (Initially Hidden) -->
        <div id="editForm" class="bg-white rounded-lg shadow mt-4 overflow-x-auto hidden">
            <table class="w-full">
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 fixed-column">Edit User</td>
                        <td class="px-6 py-4">
                            <input type="text" class="border rounded p-2 w-full" placeholder="Nama">
                        </td>
                        <td class="px-6 py-4">
                            <input type="email" class="border rounded p-2 w-full" placeholder="Email">
                        </td>
                        <td class="px-6 py-4">
                            <select class="border rounded p-2 w-full">
                                <option>User</option>
                                <option>Admin</option>
                            </select>
                        </td>
                        <td class="px-6 py-4">
                            <button onclick="saveChanges()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mr-2">
                                Simpan
                            </button>
                            <button onclick="cancelEdit()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                                Batal
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function showEditForm() {
            document.getElementById('editForm').classList.remove('hidden');
        }

        function cancelEdit() {
            document.getElementById('editForm').classList.add('hidden');
        }

        function saveChanges() {
            cancelEdit();
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Perubahan data telah disimpan',
                confirmButtonColor: '#3B82F6'
            });
        }

        function suspendUser() {
            Swal.fire({
                title: 'Suspend User',
                html: `
                    <div class="text-left">
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Durasi Suspend</label>
                            <select id="suspendDuration" class="border rounded p-2 w-full">
                                <option value="1">1 Hari</option>
                                <option value="3">3 Hari</option>
                                <option value="7">7 Hari</option>
                                <option value="30">30 Hari</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Alasan</label>
                            <textarea id="suspendReason" class="border rounded p-2 w-full" rows="3"></textarea>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Suspend',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#F59E0B',
                preConfirm: () => {
                    return {
                        duration: document.getElementById('suspendDuration').value,
                        reason: document.getElementById('suspendReason').value
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: 'User Disuspend!',
                        text: `Akun akan aktif kembali dalam ${result.value.duration} hari`,
                        confirmButtonColor: '#3B82F6'
                    });
                }
            });
        }

        function deleteUser() {
            Swal.fire({
                title: 'Hapus User?',
                text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: 'User telah berhasil dihapus',
                        confirmButtonColor: '#3B82F6'
                    });
                }
            });
        }
    </script>
</body>
</html>