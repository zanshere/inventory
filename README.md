# 🛍️ Retail Inventory Bases PHP 

**Retail Inventory** adalah sistem manajemen inventaris yang dirancang untuk membantu pengelolaan produk, pengguna, dan laporan secara efisien. Dibangun dengan teknologi modern dan antarmuka yang user-friendly.

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat&logo=php) ![Tailwind](https://img.shields.io/badge/Tailwind_CSS-3.3.2-06B6D4?style=flat&logo=tailwind-css) ![Alpine.js](https://img.shields.io/badge/Alpine.js-3.12.0-8BC0D0?style=flat&logo=alpine.js) ![SweetAlert](https://img.shields.io/badge/SweetAlert-2.1.2-FF0000?style=flat&logo=javascript)

## 🛠️ Teknologi

Teknologi utama yang digunakan:
- 🐘 **PHP Native** v8.0+ (Backend)
- 🎨 **Tailwind CSS** v3.3 (Styling)
- 🔔 **SweetAlert2** (Notifikasi Interaktif)
- ⚡ **Alpine.js** v3.12 (Interaktivitas Frontend)
- 🗃️ **MySQL** (Database)

## 📂 Struktur Direktori

```bash
/inventori-dashboard
│
├── 📁 assets
│   ├── 📁 css        # File CSS kustom
│   ├── 📁 js         # File JavaScript
│   └── 📁 images     # Aset gambar
│
├── 📁 functions      # Fungsi utilitas
│   ├── getSidebarMenu.php
│   ├── isUserBanned.php
│   └── ...
│
├── 📁 includes       # File inklusi global
│   ├── db_connect.php
│   ├── header.php
│   └── footer.php
│
├── 📁 pages          # Halaman berdasarkan role
│   ├── 📁 admin      # Dashboard admin
│   ├── 📁 staff      # Dashboard staff
│   └── 📁 user       # Dashboard pengguna
│
├── 📁 auth           # Sistem autentikasi
│   ├── login.php
│   ├── register.php
│   └── logout.php
│
├── 📄 index.php      # Entry point aplikasi
└── 📄 .htaccess      # Konfigurasi server
```

# 📦 Inventory Management System

## 👥 Tim Pengembang
| Anggota | Peran | Kontribusi Utama |
|---------|------|------------------|
| **Muhammad Fauzan** | 👨💻 Fullstack Dev | Arsitektur Sistem, Backend |
| **Deta Alfan Setyavic** | 🎨 Frontend Dev | UI/UX Design |
| **Muhammad Raihan Ramadhan** | 🎨 Frontend Dev | Implementasi Responsif |

## 📜 Lisensi
Proyek ini dilisensikan di bawah **Apache License 2.0**.

## 🚀 Instalasi

### Prasyarat:
- **PHP** ≥ 8.0
- **MySQL** ≥ 5.7
- **Web Server** (Apache/Nginx)

### Langkah-langkah:

#### 📦 Clone repositori
```bash
git clone https://github.com/zanshere/inventory.git
cd inventory
```

#### 🔧 Setup database
1. Import file SQL dari direktori `sql/`
2. Konfigurasi koneksi database di `includes/db_connect.php`

#### 🌐 Jalankan aplikasi
1. Pindahkan folder proyek ke direktori web server.
2. Buka di browser: [http://localhost/inventory](http://localhost/inventory)

## ❓ Bantuan
Untuk pertanyaan atau masukan, silakan hubungi:
📧 **tim@retail-inventory.com**

**Selamat Mengelola Inventaris! 🚀📊**