# Retail Inventory

**Retail Inventory** adalah sistem manajemen inventaris yang dirancang untuk membantu pengguna dalam mengelola produk, pengguna, dan laporan secara efisien. Website ini dibangun menggunakan PHP Native, Tailwind CSS, SweetAlert, dan Alpine.js.

## Teknologi

Proyek ini menggunakan teknologi berikut:
- **PHP Native**: Untuk logika backend.
- **Tailwind CSS**: Framework CSS untuk tampilan responsif.
- **SweetAlert**: Digunakan untuk menampilkan notifikasi dengan tampilan menarik.
- **Alpine.js**: Digunakan untuk interaktivitas frontend.

## Struktur Direktori

Berikut adalah struktur direktori dari proyek ini:

/inventori-dashboard
│
├── /assets
│   ├── /css          
│   ├── /js           
│   └── /images       
│
├── /functions
│   ├── getSidebarMenu.php
│   ├── isUserBanned.php
│   └── incrementFailedAttempts.php
│
├── /includes         
│   ├── db_connect.php
│   └── footer.php
    └── header.php
│
├── /pages            
│   ├── /admin       
│   │   ├── dashboard.php
│   │   ├── manage_users.php
│   │   ├── manage_inventory.php
│   │   └── reports.php
│   │
│   ├── /staff        
│   │   ├── dashboard.php
│   │   ├── view_inventory.php
│   │   └── add_inventory.php
│   │
│   └── /user        
│       ├── dashboard.php
│       └── view_inventory.php
│
├── /auth             
│   ├── login.php
│   ├── register.php
│   └── logout.php
│
├── index.php         
└── .htaccess         


## Anggota Tim

Proyek ini dikerjakan oleh tiga anggota dengan peran berikut:
- **Muhammad Fauzan** => Fullstack Developer
- **Deta Alfan Setyavic** => Frontend Developer
- **Muhammad Raihan Ramadhan** => Frontend Developer

## LICENSE

Proyek ini menggunakan **Apache 2.0 License**. Anda dapat melihat detail lisensinya pada file [LICENSE](LICENSE).

## Instalasi

Untuk menginstal dan menjalankan proyek ini di lingkungan lokal, ikuti langkah-langkah berikut:

1. Clone repositori ini:
    <code>git clone https://github.com/zanshere/inventory.git</code>

2. Pastikan Anda memiliki PHP dan server lokal seperti XAMPP atau Laragon yang telah terpasang di mesin Anda.

3. Pindah ke direktori proyek:
    <code>cd inventory</code>


4. Import database menggunakan file SQL yang ada di direktori `sql`.

5. Jalankan server lokal Anda dan buka browser untuk mengakses aplikasi.

---

Jika Anda memiliki pertanyaan atau masukan, jangan ragu untuk menghubungi kami!

