-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2022 at 05:40 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `catatan_kasir`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `harga_beli` int(11) DEFAULT NULL,
  `harga_jual` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `picture` varchar(200) DEFAULT NULL,
  `satuan` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `name`, `harga_beli`, `harga_jual`, `stok`, `deskripsi`, `picture`, `satuan`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Gula pasir', 5000, 6000, 50, 'Gula pasir murni Dan manis', '1654517578592.bmp', 'Kg', 80, '2022-06-06 12:12:58', '2022-06-06 12:12:58', NULL),
(2, 'Plastik', 1000, 1500, 51, 'plastik kresek', '1654517602817.bmp', 'Pcs', 80, '2022-06-06 12:13:22', '2022-06-06 13:24:39', NULL),
(3, 'rumah', 100000, 150000, 10, 'dddd', '1654517630067.bmp', 'Pcs', 80, '2022-06-06 12:13:50', '2022-06-06 12:14:54', '2022-06-06 12:14:54'),
(4, 'Gula pasir Gulaku', 3000, 7000, 30, 'Gula pasir murni merk gulaku', '1654517578592.bmp', 'Kg', 80, '2022-06-06 12:12:58', '2022-06-06 12:12:58', NULL),
(5, 'Plastik Impor belanda', 2000, 4000, 15, 'plastik kresek impor jerman', '1654517602817.bmp', 'Pcs', 80, '2022-06-06 12:13:22', '2022-06-06 13:17:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hutang`
--

CREATE TABLE `hutang` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pelanggan_id` int(11) NOT NULL,
  `pelanggan_type` enum('guest','registered','saya') NOT NULL,
  `hutang` int(11) NOT NULL,
  `status` enum('lunas','belum lunas') NOT NULL DEFAULT 'belum lunas',
  `hutang_type` enum('pelanggan','saya') NOT NULL DEFAULT 'pelanggan',
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hutang`
--

INSERT INTO `hutang` (`id`, `user_id`, `pelanggan_id`, `pelanggan_type`, `hutang`, `status`, `hutang_type`, `deskripsi`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 80, 1, 'registered', 10000, 'lunas', 'pelanggan', '', '2022-06-12 03:15:34', '2022-06-14 15:05:22', NULL),
(2, 80, 0, 'guest', 5000, 'belum lunas', 'pelanggan', NULL, '2022-06-12 03:21:06', '2022-06-12 03:21:06', NULL),
(4, 80, 0, 'guest', 12000, 'belum lunas', 'saya', 'Makan di kantin', '2022-06-14 03:35:38', '2022-06-12 03:35:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2021_02_23_021334__table_user_', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `name`, `phone`, `alamat`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Grace', '08292727272', 'Small Heath', 80, '2022-06-06 13:38:18', '2022-06-06 13:38:18', NULL),
(2, 'Johnny Dogs', '08929292', 'Birmingham', 80, '2022-06-12 04:19:59', '2022-06-12 04:19:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_by` int(10) NOT NULL DEFAULT 1,
  `updated_by` int(10) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'web_name', 'Nyantri Aplikasi Pesantren', 1, 1, NULL, NULL),
(2, 'web_url', 'https://nyantri.net/', 1, 1, NULL, NULL),
(3, 'web_description', 'Aplikasi Pesanren #1 Indonesia', 1, 1, NULL, NULL),
(4, 'web_keyword', 'Aplikasi Pesantrem', 1, 1, NULL, NULL),
(5, 'web_owner', 'Vicky', 1, 1, NULL, NULL),
(6, 'email', 'tapisdev@gmail.com', 1, 1, NULL, NULL),
(7, 'telephone', '089662240052', 1, 1, NULL, NULL),
(8, 'fax', '-', 1, 1, NULL, NULL),
(9, 'address', 'jakarta, Indonesia', 1, 1, NULL, NULL),
(12, 'facebook', '-', 1, 1, NULL, NULL),
(13, 'twitter', '-', 1, 1, NULL, NULL),
(14, 'instagram', '-', 1, 1, NULL, NULL),
(15, 'youtube', '-', 1, 1, NULL, NULL),
(16, '_token', 'TIIZQ6zHSyGHntAhtgJP5WP0cFFRMTexZZnf7dfH', 1, 1, NULL, NULL),
(17, 'logo', 'img/1616861409198.jpg', 1, 1, NULL, NULL),
(18, 'favicon', 'img/1616861409204.jpg', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pelanggan_id` int(11) DEFAULT NULL,
  `pelanggan_type` enum('guest','registered') DEFAULT 'guest',
  `total_bayar` int(11) DEFAULT NULL,
  `total_untung` int(11) DEFAULT NULL,
  `status_pembayaran` enum('lunas','hutang') NOT NULL DEFAULT 'lunas',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `user_id`, `pelanggan_id`, `pelanggan_type`, `total_bayar`, `total_untung`, `status_pembayaran`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 80, 0, 'guest', 30000, 5000, 'lunas', '2022-06-11 03:14:55', '2022-06-12 03:14:56', NULL),
(4, 80, 1, 'registered', 8000, 4000, 'lunas', '2022-06-12 03:46:50', '2022-06-12 03:46:50', NULL),
(5, 80, 2, 'registered', 7500, 1500, 'lunas', '2022-06-12 04:20:18', '2022-06-12 04:20:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pelanggan_id` int(11) DEFAULT NULL,
  `transaksi_id` int(11) DEFAULT NULL,
  `barang_id` int(11) DEFAULT NULL,
  `untung` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`id`, `user_id`, `pelanggan_id`, `transaksi_id`, `barang_id`, `untung`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 80, 0, 3, 1, 5000, 30000, '2022-06-12 03:14:55', '2022-06-12 03:14:55'),
(2, 80, 1, 4, 5, 4000, 8000, '2022-06-12 03:46:50', '2022-06-12 03:46:50'),
(3, 80, 2, 5, 1, 1000, 6000, '2022-06-12 04:20:18', '2022-06-12 04:20:18'),
(4, 80, 2, 5, 2, 500, 1500, '2022-06-12 04:20:18', '2022-06-12 04:20:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_umkm` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_user` enum('user','admin') COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `nama_umkm`, `alamat`, `phone`, `token`, `remember_token`, `jenis_user`, `created_at`, `updated_at`, `deleted_at`) VALUES
(26, 'shelby@gmail.com', '$2y$10$BZ8jA9ZtmfRxp2zBxXBaGuWp7ZAhVl.pJNxnIVTVFnF.TNLMYbCOW', 'Thomas Shelby', 'Shelby Company Ltd.', 'Small heath, Birmingham', '081222344463', 'qoMBnW1AQpthMcoIjUzcUJ3ZKN9RJdA7zOvEssDEs8d1P9mKwSFGJsAF3Ivt3Ksc1qhx6BXb5swvmu7K', '', 'user', '2021-03-17 10:30:50', '2021-03-17 10:34:05', NULL),
(46, 'super@gmail.com', '$2y$10$1qZzCfm0vYLAivPeJdDZ0.oAeCROXA5YMMtTCgtb2aQn6oMV7461m', 'Super Admin Nyantri', NULL, '-', '089662240052', 'PfKg6c47dQCPEj8xYSKsHudLdDdVB0qsoRY1MdPnz3MllESu3AIQny84duXinFf0St18O3u9HNS4jhPV', '', 'admin', '2021-03-27 15:24:30', '2021-04-05 03:30:13', NULL),
(80, 'arthur@gmail.com', '$2y$10$Hdjj31njrWsVurvhPU9ffOsG9lMQNcu6DDmQ9oPHTP3MWq0L6AW6e', 'Arthur', 'Garrison', 'Birmingham', '0812345678', 'ZgyU9Zs099hWysHn9Jql91Ned09KPirdp5LoRtuX1y3M3h4pLYChoGYedJLXNkC3WLOBgAZXM6SLs0c1', NULL, 'user', '2022-05-30 16:13:36', '2022-06-14 13:33:33', NULL),
(83, 'john@gmail.com', '$2y$10$jcuMCk5lzdGKopiFp28GOeS2WCfJaWalGTof/vJCwI8YHBy9jn4y.', 'John', 'The Garrison', 'Birmingham', '0812345678', NULL, NULL, 'user', '2022-05-30 16:20:47', '2022-05-30 16:48:10', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hutang`
--
ALTER TABLE `hutang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hutang`
--
ALTER TABLE `hutang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
