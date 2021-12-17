-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Des 2021 pada 16.17
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `homestead`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul_buku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_sewa` double NOT NULL,
  `stok` int(11) NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pengarang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penerbit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` int(11) NOT NULL,
  `tempat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id`, `kode`, `judul_buku`, `harga_sewa`, `stok`, `gambar`, `pengarang`, `penerbit`, `tahun`, `tempat`, `status`, `created_at`, `updated_at`) VALUES
(7, 'B0003', 'Buku Pedoman', 23000, 100, 'B0003_1639740883.png', 'Hehe', 'Mbuh', 2021, 'Bandung', 'Y', '2021-01-22 07:35:10', '2021-12-17 04:34:43'),
(8, 'B0004', 'Buku Gula', 15000, 100, NULL, 'Bind', 'Kiri', 2021, 'Bandung', 'Y', '2021-01-22 22:50:55', '2021-12-17 04:45:59'),
(10, 'B0006', 'Javascript', 23000, 100, NULL, 'Edo', 'Mibo', 2021, 'Jakarta', 'Y', '2021-01-22 22:51:21', '2021-12-17 04:46:13'),
(16, 'B0012', 'Rekreasi', 43000, 100, NULL, 'Panjul', 'Andi', 2020, 'Bandung', 'Y', '2021-01-22 22:53:00', '2021-01-26 02:23:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Staff', 'Y', '2020-12-23 23:36:06', '2021-01-18 18:44:43'),
(2, 'Non-Staff', 'Y', '2020-12-23 23:36:12', '2021-01-19 02:26:40'),
(3, 'Manager', 'N', '2021-01-19 02:26:35', '2021-02-03 00:17:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kembali`
--

CREATE TABLE `kembali` (
  `id` int(10) UNSIGNED NOT NULL,
  `pinjam_id` int(10) NOT NULL,
  `tgl` date NOT NULL,
  `denda` double NOT NULL,
  `bayar` double NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kembali`
--

INSERT INTO `kembali` (`id`, `pinjam_id`, `tgl`, `denda`, `bayar`, `user_id`, `created_at`, `updated_at`) VALUES
(7, 10, '2021-01-26', 0, 184000, 4, '2021-01-26 11:22:32', '2021-01-26 11:22:32'),
(8, 12, '2021-01-27', 0, 66000, 4, '2021-01-27 01:39:55', '2021-01-27 01:39:55'),
(9, 13, '2021-02-03', 0, 105000, 3, '2021-02-02 23:58:17', '2021-02-02 23:58:17'),
(10, 11, '2021-12-17', 900000, 1235000, 5, '2021-12-17 04:31:32', '2021-12-17 04:31:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `member`
--

CREATE TABLE `member` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `member`
--

INSERT INTO `member` (`id`, `kode`, `kategori_id`, `nama`, `foto`, `alamat`, `hp`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'M0001', 1, 'Bintang Saputra', NULL, 'Pekalongan Bekasi Jakarta', '081513947715', 'bin@gmail.com', 'Y', '2021-01-06 06:25:54', '2021-02-01 00:50:55'),
(2, 'M0002', 2, 'Bulan', 'M0002_1611049005.png', 'JAKARTA BEKASI PEKALONGAN', '0815', 'bulan@gmail.com', 'Y', '2021-01-06 06:26:30', '2021-01-19 02:36:45'),
(3, 'M0003', 1, 'Maman', 'M0003_1610985442.png', 'BANDUNG BEKASI Cikarang', '022', 'maman@yahoo.com', 'Y', '2021-01-11 08:55:08', '2021-01-19 01:41:21'),
(4, 'M0004', 1, 'Iqbal', NULL, 'CENGKARENG', '8342', 'bintangsaputra531@gmail.com', 'N', '2021-01-11 02:13:03', '2021-02-02 22:01:59'),
(5, 'M0005', 2, 'Doni', NULL, 'BANDUNG JABAR', '021799430434', 'warmad@yahoo.co.id', 'Y', '2021-01-11 02:28:16', '2021-02-01 00:50:34'),
(17, 'M0006', 2, 'Gina', 'M0006_1611163945.png', 'Jakarta Raya Bogor', '0923', NULL, 'Y', '2021-01-20 10:32:25', '2021-01-20 10:32:38'),
(18, 'M0007', 1, 'Daniel', 'M0007_1612326997.png', 'Di sini aja', '345', 'bintang@gmail.com', 'Y', '2021-01-20 10:43:02', '2021-02-02 21:36:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2014_10_12_200000_add_two_factor_columns_to_users_table', 2),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 2),
(6, '2020_12_17_104731_create_sessions_table', 2),
(8, '2020_12_18_113344_create_buku_table', 4),
(10, '2020_12_18_111909_create_kategori_table', 6),
(11, '2020_12_18_115438_create_pinjam_table', 7),
(12, '2020_12_18_120109_create_pinjam_detail_table', 8),
(13, '2020_12_18_120329_create_kembali_table', 9),
(14, '2020_12_18_114900_create_member_table', 10),
(15, '2021_01_22_014906_create_pinjam_cart_table', 11);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pinjam`
--

CREATE TABLE `pinjam` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_id` int(10) NOT NULL,
  `tgl` date NOT NULL,
  `duedate` date NOT NULL,
  `total` double NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pinjam`
--

INSERT INTO `pinjam` (`id`, `kode`, `member_id`, `tgl`, `duedate`, `total`, `user_id`, `created_at`, `updated_at`) VALUES
(10, 'P2101-0001', 1, '2021-01-26', '2021-02-02', 184000, 4, '2021-01-26 11:08:36', '2021-01-26 11:08:36'),
(11, 'P2101-0002', 18, '2021-01-26', '2021-02-02', 335000, 4, '2021-01-26 11:24:31', '2021-01-26 11:24:31'),
(12, 'P2101-0003', 3, '2021-01-27', '2021-02-03', 66000, 4, '2021-01-27 01:38:29', '2021-01-27 01:38:29'),
(13, 'P2102-0004', 18, '2021-02-03', '2021-02-10', 105000, 3, '2021-02-02 23:57:42', '2021-02-02 23:57:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pinjam_cart`
--

CREATE TABLE `pinjam_cart` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `buku_id` int(10) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pinjam_cart`
--

INSERT INTO `pinjam_cart` (`id`, `user_id`, `buku_id`, `qty`, `created_at`, `updated_at`) VALUES
(278, 4, 17, 3, '2021-02-07 20:16:21', '2021-02-07 20:18:16'),
(279, 4, 16, 1, '2021-02-07 21:17:57', '2021-02-07 21:17:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pinjam_detail`
--

CREATE TABLE `pinjam_detail` (
  `id` int(10) UNSIGNED NOT NULL,
  `pinjam_id` int(11) NOT NULL,
  `buku_id` int(10) NOT NULL,
  `harga_sewa` double NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pinjam_detail`
--

INSERT INTO `pinjam_detail` (`id`, `pinjam_id`, `buku_id`, `harga_sewa`, `qty`, `created_at`, `updated_at`) VALUES
(16, 10, 7, 23000, 3, '2021-01-26 11:08:37', '2021-01-26 11:08:37'),
(17, 10, 10, 23000, 5, '2021-01-26 11:08:37', '2021-01-26 11:08:37'),
(18, 11, 2, 12000, 5, '2021-01-26 11:24:31', '2021-01-26 11:24:31'),
(19, 11, 11, 40000, 5, '2021-01-26 11:24:31', '2021-01-26 11:24:31'),
(20, 11, 8, 15000, 5, '2021-01-26 11:24:32', '2021-01-26 11:24:32'),
(21, 12, 2, 12000, 3, '2021-01-27 01:38:29', '2021-01-27 01:38:29'),
(22, 12, 8, 15000, 2, '2021-01-27 01:38:30', '2021-01-27 01:38:30'),
(23, 13, 3, 15000, 4, '2021-02-02 23:57:43', '2021-02-02 23:57:43'),
(24, 13, 8, 15000, 3, '2021-02-02 23:57:43', '2021-02-02 23:57:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('QjJyg5VoZg01QiFSC8y9quqQitZJ9lJcUus2gsyb', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiNGpKTk9rNmk5dTQ5M1J3V3lKSkt0VVBCalJuSmI4dTFSSjRGenpNRiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMCRFTThLcGFSUTZxVXRYNmUwbkIxb3cublAyWGtKQTRuakw5aWw2dUtYUFRUczlTT3VMeGU1bSI7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTAkRU04S3BhUlE2cVV0WDZlMG5CMW93Lm5QMlhrSkE0bmpMOWlsNnVLWFBUVHM5U091THhlNW0iO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTYzOTc0MjYzNTt9fQ==', 1639742646);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `created_at`, `updated_at`) VALUES
(5, 'kiritomz', 'admin@email.com', NULL, '$2y$10$EM8KpaRQ6qUtX6e0nB1ow.nP2XkJA4njL9il6uKXPTTs9SOuLxe5m', 'eyJpdiI6Im5Rd0gzbmhJN3hqYnBEYnF2Q0Q0dUE9PSIsInZhbHVlIjoiUGdSTEY3VWk3K0tJTzZGMW1PcDJJSm95MGl5bGgxSjNhWFV0Y21WV2xvOD0iLCJtYWMiOiI5MjUzMmY5NGJlMjI2Nzk4Y2I0Y2U3ZGQ2ZTE2MzU4YTIxNWM0MzE3OTFjMDRiNzU4MTNiNDYyZTg0YjU2NjJmIn0=', 'eyJpdiI6IlphbE1uWWQyWjFmZUs2RTJKTXZwdFE9PSIsInZhbHVlIjoiYzlkR1BIcXQwbDRDZUozSyt2QU9MdEQ5MjlzVXJpbVFBQWJYZTlxV1JVSlUwWEIzRmxtMGdWUUVjRVVXeURIaE1nNUdOdDd6d0s2aU5iZS94Tzd3K2RiamRKdVN3blRMRTFYeElvLzJjVm95WEhVNnkyUXVYTCs5QW5sdnpqNXhUUzVOa2pnRlJFZmJyWExEYUc4SEljbHY5TjNjeFpEdEJCcEVkQ0RLbEdPSUpPUDdpRVhhNWRqcUxSN25TeEludzBtRnhocEUya0RPQ0hDSjVEOFlxWC96QlY4K09GZldlK1ViTG5NdW90b1lqRWQvUDUwQ0o4V3dNZ0ROK1gyYm5HNW5nWGI1UVRiZlNRSWxaVnl0a2c9PSIsIm1hYyI6IjFjNDgzNDAwNTljODNlYTU3MTM0ZWUyNTgxNTA4ZTM4YWFlOWI4ZGFlYzhjMzE5OTIyY2VlNjg1NWJlM2ZkNzYifQ==', NULL, '2021-12-17 04:29:08', '2021-12-17 05:03:56');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kembali`
--
ALTER TABLE `kembali`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pinjam_id` (`pinjam_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`),
  ADD KEY `member_kategori_id_foreign` (`kategori_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `pinjam`
--
ALTER TABLE `pinjam`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`),
  ADD KEY `member_kode` (`member_id`) USING BTREE,
  ADD KEY `users_id` (`user_id`) USING BTREE;

--
-- Indeks untuk tabel `pinjam_cart`
--
ALTER TABLE `pinjam_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `buku_kode` (`buku_id`) USING BTREE;

--
-- Indeks untuk tabel `pinjam_detail`
--
ALTER TABLE `pinjam_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pinjam_kode` (`pinjam_id`) USING BTREE,
  ADD KEY `buku_kode` (`buku_id`) USING BTREE;

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT untuk tabel `kembali`
--
ALTER TABLE `kembali`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `member`
--
ALTER TABLE `member`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pinjam`
--
ALTER TABLE `pinjam`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `pinjam_cart`
--
ALTER TABLE `pinjam_cart`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=282;

--
-- AUTO_INCREMENT untuk tabel `pinjam_detail`
--
ALTER TABLE `pinjam_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `member_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
