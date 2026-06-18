-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Jun 2026 pada 05.52
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peminjaman_barang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barangs`
--

CREATE TABLE `barangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jurusan_id` bigint(20) UNSIGNED NOT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `stok` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `kondisi` varchar(255) NOT NULL DEFAULT 'baik',
  `keterangan` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `barangs`
--

INSERT INTO `barangs` (`id`, `jurusan_id`, `kategori_id`, `kode_barang`, `nama_barang`, `stok`, `kondisi`, `keterangan`, `foto`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'A1', 'Kamera', 3, '3 Baik', 'DSLR CANON EOS 7D', 'barang/o1KF7JQWEmdsu1mzwa194HYvxfLxcYoFiZ1l5yPR.jpg', '2026-03-18 09:05:14', '2026-06-11 20:29:11'),
(2, 2, 2, 'A5', 'Kunci T', 3, '3 baik', 'kunci T', 'barang/YhjkuERnZssSHJzKiXAeFQzBzptaRxuaQF2z6U3r.png', '2026-03-18 09:07:31', '2026-06-05 02:04:25'),
(3, 4, 1, 'B2', 'Monitor', 1, 'baik', 'monitor komputer', NULL, '2026-04-05 18:52:04', '2026-06-05 00:57:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-kevin ardi setyawn|127.0.0.1', 'i:1;', 1781232072),
('laravel-cache-kevin ardi setyawn|127.0.0.1:timer', 'i:1781232072;', 1781232072);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_peminjamans`
--

CREATE TABLE `detail_peminjamans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `peminjaman_id` bigint(20) UNSIGNED NOT NULL,
  `barang_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detail_peminjamans`
--

INSERT INTO `detail_peminjamans` (`id`, `peminjaman_id`, `barang_id`, `jumlah`, `created_at`, `updated_at`) VALUES
(4, 7, 1, 2, '2026-04-05 18:46:25', '2026-04-05 18:46:25'),
(5, 8, 3, 1, '2026-04-05 19:07:07', '2026-04-05 19:07:07'),
(7, 10, 1, 1, '2026-06-03 23:56:13', '2026-06-03 23:56:13'),
(8, 11, 1, 1, '2026-06-04 02:41:34', '2026-06-04 02:41:34'),
(9, 12, 3, 1, '2026-06-05 00:39:46', '2026-06-05 00:39:46'),
(10, 13, 1, 1, '2026-06-05 01:02:53', '2026-06-05 01:02:53'),
(11, 14, 1, 1, '2026-06-11 20:25:09', '2026-06-11 20:25:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusans`
--

CREATE TABLE `jurusans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jurusans`
--

INSERT INTO `jurusans` (`id`, `kode`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'TSM', 'Teknik Sepeda Motor', '2026-03-18 03:29:01', '2026-03-18 03:29:01'),
(2, 'TKR', 'Teknik Kendaraan Ringan', '2026-03-18 03:29:01', '2026-03-18 03:29:01'),
(3, 'ANM', 'Animasi', '2026-03-18 03:29:01', '2026-03-18 03:29:01'),
(4, 'DKV', 'Desain Komunikasi Visual', '2026-03-18 03:29:01', '2026-03-18 03:29:01'),
(5, 'KKBT', 'Kriya Kreatif Batik dan Tekstil', '2026-03-18 03:29:01', '2026-03-18 03:29:01'),
(6, 'KKLP', 'Kriya Kreatif Logam dan Perhiasan', '2026-03-18 03:29:01', '2026-03-18 03:29:01'),
(7, 'KKR', 'Kriya Kreatif Kayu dan Rotan', '2026-03-18 03:29:01', '2026-03-18 03:29:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jurusan_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategoris`
--

INSERT INTO `kategoris` (`id`, `jurusan_id`, `nama`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 4, 'Elektronik', 'kamera dll', '2026-03-18 09:04:45', '2026-03-18 09:04:45'),
(2, 2, 'Alat perkakas', 'kunci', '2026-03-18 09:06:26', '2026-03-18 09:06:26'),
(4, 4, 'Hardware', 'Perangkat komputer', '2026-03-18 22:35:16', '2026-03-18 22:35:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_18_000001_create_jurusans_table', 1),
(5, '2026_03_18_000002_add_fields_to_users_table', 1),
(6, '2026_03_18_083053_create_kategoris_table', 1),
(7, '2026_03_18_083054_create_barangs_table', 1),
(8, '2026_03_18_083055_create_peminjamans_table', 1),
(9, '2026_03_18_083056_create_detail_peminjamans_table', 1),
(10, '2026_03_19_122941_add_foto_to_barangs_table', 2),
(11, '2026_06_04_084503_add_foto_to_users_table', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjamans`
--

CREATE TABLE `peminjamans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_peminjaman` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jurusan_tujuan_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('menunggu','dipinjam','dikembalikan','ditolak') NOT NULL DEFAULT 'menunggu',
  `tanggal_pinjam` date NOT NULL,
  `tanggal_rencana_kembali` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `alasan_penolakan` text DEFAULT NULL,
  `foto_peminjaman` varchar(255) DEFAULT NULL,
  `foto_pengembalian` varchar(255) DEFAULT NULL,
  `petugas_peminjaman_id` bigint(20) UNSIGNED DEFAULT NULL,
  `petugas_pengembalian_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_keterlambatan` enum('belum_kembali','tepat_waktu','terlambat') NOT NULL DEFAULT 'belum_kembali',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `peminjamans`
--

INSERT INTO `peminjamans` (`id`, `no_peminjaman`, `user_id`, `jurusan_tujuan_id`, `status`, `tanggal_pinjam`, `tanggal_rencana_kembali`, `tanggal_kembali`, `alasan_penolakan`, `foto_peminjaman`, `foto_pengembalian`, `petugas_peminjaman_id`, `petugas_pengembalian_id`, `status_keterlambatan`, `created_at`, `updated_at`) VALUES
(7, 'PJM-20260406-0001', 12, 4, 'dikembalikan', '2026-04-06', '2026-04-06', '2026-04-06', NULL, 'peminjaman/KIe0Ck7owBTECDT5SVShKdwP3uLJPLljg7rnLOBu.png', 'pengembalian/seLD190VozfF4Ot6hXuq6HAxFQA6XiKw90T9YNMt.png', 1, 1, 'tepat_waktu', '2026-04-05 18:46:25', '2026-04-05 18:55:18'),
(8, 'PJM-20260406-0002', 12, 4, 'dikembalikan', '2026-04-06', '2026-04-06', '2026-06-04', NULL, 'peminjaman/Z9gmV0ONZHSIIFXHsmRMRZQkwZsQOsxv3mfXTFwT.png', 'pengembalian/j9rKmhW2Es3RQnngaGxH4TJofRmVp0uBKybbiIRw.png', 1, 1, 'terlambat', '2026-04-05 19:07:07', '2026-06-04 00:02:15'),
(10, 'PJM-20260604-0003', 15, 4, 'dikembalikan', '2026-06-04', '2026-06-04', '2026-06-04', NULL, 'peminjaman/x9JmONpQD9CoYVQHy0HyVe3IUeJgIiH00fYKJOM3.png', 'pengembalian/TBGs8CAoHbDP0QememNQcTh0QOq7P0om4Z29gQp4.png', 1, 3, 'tepat_waktu', '2026-06-03 23:56:13', '2026-06-04 02:58:15'),
(11, 'PJM-20260604-0004', 16, 4, 'dikembalikan', '2026-06-04', '2026-06-04', '2026-06-04', NULL, 'peminjaman/I19dQuSNaUnHXt7cvbJ6bBFsBofSCDXSR0PlzAA9.jpg', 'pengembalian/QLqmIcQcsgWbogDPPbyFsWfv8mgR815Lfr10kqbt.png', 3, 3, 'tepat_waktu', '2026-06-04 02:41:34', '2026-06-04 02:46:16'),
(12, 'PJM-20260605-0005', 15, 4, 'dikembalikan', '2026-06-05', '2026-06-05', '2026-06-05', NULL, 'peminjaman/hhL5yOncnRAWEAtbIzzlwdiC8f4anmMZrHZNuH68.png', 'pengembalian/lZeq34u5XfYSefRkgJir0q48KkYF9NRvlQGTsQIx.png', 1, 1, 'tepat_waktu', '2026-06-05 00:39:45', '2026-06-05 00:57:03'),
(13, 'PJM-20260605-0006', 15, 4, 'dikembalikan', '2026-06-05', '2026-06-05', '2026-06-05', NULL, 'peminjaman/e6rqgzoglboGFOEylVPxNUL19y3Zvlo9Ajs3ibmu.png', 'pengembalian/v9Xwr0PGENuCC718PJ7NKyy0F6G5DcOShP74wS57.png', 1, 1, 'tepat_waktu', '2026-06-05 01:02:53', '2026-06-05 01:07:51'),
(14, 'PJM-20260612-0007', 2, 4, 'dikembalikan', '2026-06-12', '2026-06-12', '2026-06-12', NULL, 'peminjaman/OJJmbgYWyXTkd9sAWzxNmrAgU7ffGF4R7WofloYT.png', 'pengembalian/AO21WRlIe1cYI5Bl3Ca7ANb9HBBi9cyCw8eSbur6.png', 3, 3, 'tepat_waktu', '2026-06-11 20:25:09', '2026-06-11 20:29:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('bgc8s3ltzyixUKBMLpIdLCqiwvn0mPIy95uZof5M', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJRclZZWUx5QTJETXc5TXR5UTl5a0Z6R3g0WHdBTUZSdlRrdVJmUTdrIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2Rhc2hib2FyZFwvc3RhdHMiLCJyb3V0ZSI6ImRhc2hib2FyZC5zdGF0cyJ9LCJ1cmwiOnsiaW50ZW5kZWQiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvZGFzaGJvYXJkXC9zdGF0cyJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', 1781663282),
('qEcgQEn8uHnsMwZSMJrHNneUePJAHEoltCRIG0EF', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJjd3ZYY21RRFU5UGdKYzV2UmFVUWY1VVBTdmpsODY3Wm1HWHB0NW0wIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2Rhc2hib2FyZFwvc3RhdHMifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9kYXNoYm9hcmRcL3N0YXRzIiwicm91dGUiOiJkYXNoYm9hcmQuc3RhdHMifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1781658968),
('qOnbvdztJiw2KhiDdQAU9e6wn1Wb0nkMtD3vvaq3', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJBZ3kzRnRVbDQycnRQQ245OXpoamlxeThCT3pyanRnMGlXYU5EbVBqIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1781658978),
('vn6ZNEZE6cnHg7Bux87RnHzbK1ASVqxhWfU3avGY', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJodDF0OWt3S3lMcEdGa2dOUkVjd3I3NFdNZDlNQkxFWHFRZXJCTm1lIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2Rhc2hib2FyZFwvc3RhdHMifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1781658976),
('zC3NgndekjaLVGZ2MqWWqBAmjoLpoQcPAyAB3I46', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJHaEVTd2p5QWh2TmZFV3pzT0Q0TEJ5ejJHaVNlaGt2b2hMajAxd0hIIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2Rhc2hib2FyZFwvc3RhdHMifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9kYXNoYm9hcmRcL3N0YXRzIiwicm91dGUiOiJkYXNoYm9hcmQuc3RhdHMifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1781658959);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jurusan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `role` enum('superadmin','admin_jurusan','peminjam') NOT NULL DEFAULT 'peminjam',
  `jenis_pengguna` enum('siswa','guru') DEFAULT NULL,
  `asal_kelas_jabatan` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `profile_photo_path` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `jurusan_id`, `name`, `email`, `no_hp`, `role`, `jenis_pengguna`, `asal_kelas_jabatan`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `profile_photo_path`) VALUES
(1, NULL, 'Superadmin', 'superadmin@gmail.com', '081234567890', 'superadmin', NULL, 'Superadmin Sistem', NULL, '$2y$12$ZL5GNQDOduIi.PsQLHjDMee/eZJ4xpb06ZWlMapyxUfiUQi0j3J3e', NULL, '2026-03-18 03:29:02', '2026-03-18 10:56:36', NULL),
(2, 4, 'Kevin Ardi Setyawan', 'kevinardisetyawan02@gmail.com', '085764425294', 'peminjam', 'guru', 'Magang', NULL, '$2y$12$uU.rgIkiBABpTgA4.uugrOomzhXkj0TNEJpvb9O0E16lerUZiRZwq', NULL, '2026-03-18 04:20:33', '2026-06-11 20:43:53', 'profile-photos/YZya22l4dFpWkHoyamx2lMg7jVcHcoLwLqkxFMPf.jpg'),
(3, 4, 'Admin DKV', 'admin.dkv@gmail.com', '081234567890', 'admin_jurusan', NULL, 'Admin Jurusan Desain Komunikasi Visual', NULL, '$2y$12$HpUocjg5TQLyGp.fijrogeXiL/4XKPlkg29jC9gZecGnk7nlg14gm', NULL, '2026-03-18 10:56:37', '2026-03-18 11:13:33', NULL),
(4, 1, 'Admin TSM', 'admin.tsm@gmail.com', '081234567890', 'admin_jurusan', NULL, 'Admin Jurusan Teknik Sepeda Motor', NULL, '$2y$12$PNqsLFkqhfBA3ZYeXKK4du9fYEOxuoxZVQQK3rjG/68nIUNRGJrbK', NULL, '2026-03-18 11:13:32', '2026-03-18 11:13:32', NULL),
(5, 2, 'Admin TKR', 'admin.tkr@gmail.com', '081234567890', 'admin_jurusan', NULL, 'Admin Jurusan Teknik Kendaraan Ringan', NULL, '$2y$12$1Ntp8JrFPxKSZuq8dkPqcuW8xPCzjL9.ez0i3nMYVg9fbbDglwEBC', NULL, '2026-03-18 11:13:33', '2026-03-18 11:13:33', NULL),
(6, 3, 'Admin ANM', 'admin.anm@gmail.com', '081234567890', 'admin_jurusan', NULL, 'Admin Jurusan Animasi', NULL, '$2y$12$U70XijiUIYYCvT.N1hEG/eey6145L1xipK9vmkQ62gwPnAG17xwiy', NULL, '2026-03-18 11:13:33', '2026-03-18 11:13:33', NULL),
(7, 5, 'Admin KKBT', 'admin.kkbt@gmail.com', '081234567890', 'admin_jurusan', NULL, 'Admin Jurusan Kriya Kreatif Batik dan Tekstil', NULL, '$2y$12$qgIAXhgLmgFTihwrsr202engMKx43UlK7KWP2e0rmvY0l.lYC.RbC', NULL, '2026-03-18 11:13:34', '2026-03-18 11:13:34', NULL),
(8, 6, 'Admin KKLP', 'admin.kklp@gmail.com', '081234567890', 'admin_jurusan', NULL, 'Admin Jurusan Kriya Kreatif Logam dan Perhiasan', NULL, '$2y$12$lJcNlFCuL2RIFyknbG3eqeF5hLiweFdyilXvbPH2fQf5XAyeKI97K', NULL, '2026-03-18 11:13:34', '2026-03-18 11:13:34', NULL),
(9, 7, 'Admin KKR', 'admin.kkr@gmail.com', '081234567890', 'admin_jurusan', NULL, 'Admin Jurusan Kriya Kreatif Kayu dan Rotan', NULL, '$2y$12$ISehKyL8gfBFilZxl2/cX.y.FLqbjr2bUFBpkPS2hZ03pvkbznWEa', NULL, '2026-03-18 11:13:34', '2026-03-18 11:13:34', NULL),
(10, 2, 'Adam Makmur', 'adammakmur123@gmail.com', '081234567890', 'peminjam', 'siswa', 'X TKR 1', NULL, '$2y$12$iz5CHaE8Slu0/0X9P3lSz.SrTo/rw5Dz1tDuFuP.jLDJH9mEcOCqO', NULL, '2026-03-18 22:37:34', '2026-03-18 22:37:34', NULL),
(12, 4, 'Dayat', 'dayat@gmail.com', '081234567890', 'peminjam', 'siswa', 'X DKV 1', NULL, '$2y$12$COA7khywuFE026d3xgPeQ.bTIHn5Mf8hwKcFdzzSleIXdlg1l9Exi', NULL, '2026-04-05 18:42:57', '2026-04-05 18:42:57', NULL),
(13, 4, 'bagus', 'bagus@gmail.com', '085764425294', 'peminjam', 'siswa', 'X DKV 1', NULL, '$2y$12$9WkMygIYSX//jXWaQdmWvOwW3XlxzFtdhftRcSTd2xuqGeIe9fwle', NULL, '2026-04-18 09:30:00', '2026-05-21 09:23:37', NULL),
(15, 7, 'Rizki Sanjaya', 'rizkysanjaya@gmail.com', '081234567890', 'peminjam', 'siswa', 'X DPK 1', NULL, '$2y$12$fJkTA9xTCdlRjTKsVq94WuT89Y/KwIfuoQZ9uKEAGFQbMQdY1X8.C', NULL, '2026-06-03 23:43:58', '2026-06-03 23:43:58', NULL),
(16, 4, 'Kevin Ardi Setyawan', 'kevinardisetyawan57@gmail.com', '085764425294', 'peminjam', 'siswa', 'X DKV 2', NULL, '$2y$12$sT5zLlH.YKRKogPPgvQcrO8zH8gI9bjT5sVHOsMciKBYRUxpt9iqO', NULL, '2026-06-04 02:20:08', '2026-06-04 02:22:22', 'profile-photos/emAEEXzhETmk6PeEngUk4JTpIuKemutqLzK10GXb.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barangs`
--
ALTER TABLE `barangs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barangs_kode_barang_unique` (`kode_barang`),
  ADD KEY `barangs_jurusan_id_foreign` (`jurusan_id`),
  ADD KEY `barangs_kategori_id_foreign` (`kategori_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `detail_peminjamans`
--
ALTER TABLE `detail_peminjamans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_peminjamans_peminjaman_id_foreign` (`peminjaman_id`),
  ADD KEY `detail_peminjamans_barang_id_foreign` (`barang_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jurusans`
--
ALTER TABLE `jurusans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jurusans_kode_unique` (`kode`);

--
-- Indeks untuk tabel `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategoris_jurusan_id_foreign` (`jurusan_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `peminjamans_no_peminjaman_unique` (`no_peminjaman`),
  ADD KEY `peminjamans_user_id_foreign` (`user_id`),
  ADD KEY `peminjamans_jurusan_tujuan_id_foreign` (`jurusan_tujuan_id`),
  ADD KEY `peminjamans_petugas_peminjaman_id_foreign` (`petugas_peminjaman_id`),
  ADD KEY `peminjamans_petugas_pengembalian_id_foreign` (`petugas_pengembalian_id`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_jurusan_id_foreign` (`jurusan_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barangs`
--
ALTER TABLE `barangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `detail_peminjamans`
--
ALTER TABLE `detail_peminjamans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jurusans`
--
ALTER TABLE `jurusans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `peminjamans`
--
ALTER TABLE `peminjamans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barangs`
--
ALTER TABLE `barangs`
  ADD CONSTRAINT `barangs_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `barangs_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_peminjamans`
--
ALTER TABLE `detail_peminjamans`
  ADD CONSTRAINT `detail_peminjamans_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_peminjamans_peminjaman_id_foreign` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjamans` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kategoris`
--
ALTER TABLE `kategoris`
  ADD CONSTRAINT `kategoris_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusans` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD CONSTRAINT `peminjamans_jurusan_tujuan_id_foreign` FOREIGN KEY (`jurusan_tujuan_id`) REFERENCES `jurusans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjamans_petugas_peminjaman_id_foreign` FOREIGN KEY (`petugas_peminjaman_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `peminjamans_petugas_pengembalian_id_foreign` FOREIGN KEY (`petugas_pengembalian_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `peminjamans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusans` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
