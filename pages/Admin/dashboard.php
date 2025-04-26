<?php
// dashboard.php
session_start(); // Letakkan di paling atas sebelum output apapun

include '../../includes/connect.php';
include '../../functions/isUserBanned.php';
include '../../functions/getSidebarMenu.php';
include '../../functions/errorControllers.php';

// Generate menu items
$menuItems = getSidebarMenu($role); // <-- AMBIL MENU ITEMS

include '../../includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/git-project/inventory/">
    <!-- Icon Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tailwind CSS -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font -->
    <link rel="stylesheet" href="/assets/CSS/font.css">
    <!-- CSS -->
    <style>
    /* Elemen dengan x-cloak disembunyikan sebelum Alpine aktif */
    [x-cloak] {
        display: none !important;
    }

    body {
        background: linear-gradient(to bottom, #0a192f, #020c1b);
    }

    /* Efek Bintang */
    .stars {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -2;
    }

    .star {
        position: absolute;
        background: white;
        border-radius: 50%;
        animation: twinkle var(--duration) ease-in-out infinite;
    }

    @keyframes twinkle {

        0%,
        100% {
            opacity: 0.3;
        }

        50% {
            opacity: 1;
        }
    }


    .nav-link.active {
        color: white;
        font-weight: bold;
        border-radius: 5px;
    }

    /* Ocean Wave Background */
    .ocean {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        overflow: hidden;
    }

    .wave {
        background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/85486/wave.svg') repeat-x;
        filter: drop-shadow(0 0 5px #01939c);
        position: absolute;
        bottom: 0;
        width: 6400px;
        height: 155px;
        animation: wave 12s cubic-bezier(0.26, 0.45, 0.43, 0.33) infinite;
        /* Animasi diperlambat */
        transform: translate3d(0, 0, 0);
    }

    .wave:nth-of-type(2) {
        bottom: 0;
        animation: wave 12s cubic-bezier(0.26, 0.45, 0.43, 0.33) -.125s infinite, swell 7s ease -1.25s infinite;
        opacity: 0.7;
    }

    @keyframes wave {
        0% {
            margin-left: 0;
        }

        100% {
            margin-left: -1600px;
        }
    }

    @keyframes swell {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    /* Tambahkan ini ke CSS */
    .main-content {
        background-color: rgba(2, 12, 27, 0.9);
        border: 1px solid #2c5364;
        width: 550px;
        /* Ukuran kotak */
        height: 400px;
        /* Ukuran kotak */
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(8px);
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    /* Untuk responsivitas */
    @media (max-width: 640px) {
        .main-content {
            width: 90%;
            height: auto;
            min-height: 400px;
            position: relative;
            top: unset;
            left: unset;
            transform: none;
            margin: 2rem auto;
        }
    }

    @keyframes fadeInBounce {
        0% {
            opacity: 0;
            transform: translateY(20px) scale(0.9);
        }

        60% {
            opacity: 1;
            transform: translateY(-10px) scale(1.05);
        }

        80% {
            transform: translateY(5px) scale(0.98);
        }

        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .animate-bounce-fade {
        animation:
            fadeInBounce 1.2s ease-out forwards;
    }

    [data-aos-delay="200"] {
        transition-delay: 0.2s;
    }
    </style>
</head>

<body class="min-h-screen" x-init="setTimeout(() => {
        const starsContainer = document.querySelector('.stars');
        for(let i = 0; i < 200; i++) {
          const star = document.createElement('div');
          star.className = 'star';
          star.style.left = `${Math.random() * 100}%`;
          star.style.top = `${Math.random() * 100}%`;
          star.style.width = `${Math.random() * 3}px`;
          star.style.height = star.style.width;
          star.style.setProperty('--duration', `${2 + Math.random() * 3}s`);
          starsContainer.appendChild(star);
        }
      }, 100)">

    <!-- Efek Bintang -->
    <div class="stars"></div>

    <!-- Ocean Wave Background -->
    <div class="ocean">
        <div class="wave"></div>
        <div class="wave"></div>
    </div>

    <!-- Ini background biasa -->
    <div class="min-h-screen flex items-center justify-center">
        <!-- Ini card kecil blur -->
        <div
            class="bg-white/10 backdrop-blur-2xl border border-white/30 rounded-2xl shadow-2xl p-10 text-center w-full max-w-md">
            <h1 class="text-3xl font-bold text-white mb-4">
                Welcome, "BLABLABLA PHP"
            </h1>
            <p class="text-white/80 mb-6">
                Saat ini anda dapat mengakses semua fitur di halaman ini
            </p>
        </div>
    </div>

    <script>
    AOS.init({
        once: true, // Animasi hanya sekali
        duration: 1000
    });
    </script>
</body>

</html>