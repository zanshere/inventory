-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 19 Feb 2025 pada 10.52
-- Versi server: 9.2.0
-- Versi PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventory`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `failed_attempts` int DEFAULT '0',
  `banned_until` datetime DEFAULT NULL,
  `suspend_until` datetime DEFAULT NULL,
  `role` enum('admin','staff','user') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(1) DEFAULT '1'
) ;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `full_name`, `failed_attempts`, `banned_until`, `suspend_until`, `role`, `created_at`, `is_active`) VALUES
(1, 'admin', '$2a$12$8rsJGxWbISklitcWmDGOZOG9SR5UNJutI.1ErewxlU32vv2pU2RKq', 'admin@gmail.com', 'Admin', 0, NULL, NULL, 'admin', '2025-02-04 17:09:53', 1),
(3, 'staff', '$2y$10$V491cNvH6yF/gVqYw/Fiwu/QrL43iX8GWUmnjSSz2dDabYzJRqs8C', 'staff@gmail.com', 'Staff', 0, NULL, '2025-02-19 10:19:39', 'staff', '2025-02-17 15:46:43', 1),
(4, 'user', '$2y$10$g5yjpUIAwKci0sa587Vk4OlNtADdKy0BLPpI4d0PQPBAMEhBreC76', 'user@gmail.com', 'User', 0, NULL, NULL, 'user', '2025-02-19 10:27:55', 1),
(5, 'zanshere', '$2y$10$q5Ro3VCIHcZBlLfSDDsBm.TBzzMfG1YnFNt3gnwRshXtMoeisshu6', 'fauzan224321@gmail.com', 'Muhammad Fauzan', 0, NULL, NULL, 'user', '2025-02-19 10:48:16', 1),
(6, 'Mojangs', '$2y$10$J0ihp7KWf8ZWbpWS/I.EsuYYIOxWOmkuVULUPEzZ9zkMIJYvKRhmG', 'rektword@gmail.com', 'Rozan Fathin Yafi', 0, NULL, NULL, 'user', '2025-02-19 10:48:39', 1),
(7, 'Kurogane', '$2y$10$rTIXLqgkmPyu4JzRMlX1MuML45qNLrwTC9fSU6ejFlQdqDh1bBbR6', 'itsryuzen1@gmail.com', 'Hikaru Kurogane', 0, NULL, NULL, 'user', '2025-02-19 10:48:57', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `created_at` (`created_at`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
