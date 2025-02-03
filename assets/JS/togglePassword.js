// Ambil elemen input dan tombol toggle
const passwordInput = document.getElementById('password');
const togglePasswordText = document.getElementById('togglePasswordText');

// Event listener pada tombol toggle
togglePasswordText.addEventListener('click', function () {
  // Dapatkan elemen ikon dan teks di dalam tombol
  const icon = this.querySelector('i');
  const text = this.querySelector('span');
  
  // Toggle tipe input dan ubah ikon serta teksnya
  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    icon.className = 'fa-regular fa-eye-slash mr-2'; // Ubah ikon ke mata tertutup
    text.textContent = 'Hide Password';
  } else {
    passwordInput.type = 'password';
    icon.className = 'fa-regular fa-eye mr-2'; // Ubah ikon ke mata terbuka
    text.textContent = 'Show Password';
  }
});