-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2026 at 07:18 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel12_e_commerce_rk`
--

-- --------------------------------------------------------

--
-- Table structure for table `cabangs`
--

CREATE TABLE `cabangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_cabang` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cabangs`
--

INSERT INTO `cabangs` (`id`, `kode_cabang`, `nama`, `alamat`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'S01', 'Ratu Komputer Serang', 'Jl. Ciwaru Raya No.Rt.04/16, Cipare, Kota Serang', 'Cabang Pusat', '2025-11-22 09:51:17', '2025-11-22 09:51:17'),
(2, 'B01', 'Ratu Komputer Bogor', 'Ruko Villa Indah Pajajaran, Kota Bogor', 'Cabang Bogor', '2025-11-22 09:51:18', '2025-11-22 09:51:18');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `foto` varchar(255) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `id_produk`, `foto`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 6, 'gallery-images/zPDHYPwt1kOtOdbFkLsq0I5ctlYmARD3GjMqewi6.png', 'Foto 1', '2025-11-23 05:03:52', '2025-11-23 23:05:26'),
(5, 2, 'gallery-images/qWOJpv98p2Udp8fNWlY1x2Z0aWg9tZdzJAzL7Cjy.png', 'Intel box', '2025-11-23 05:23:16', '2025-11-23 05:23:16'),
(6, 2, 'gallery-images/dk8kkIBt3nBatgpWYLSnZVCJfkVKL1A4UGLUz2mb.png', NULL, '2026-04-18 20:35:20', '2026-04-18 21:16:58');

-- --------------------------------------------------------

--
-- Table structure for table `heroes`
--

CREATE TABLE `heroes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_hero` varchar(255) DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `link` varchar(255) NOT NULL DEFAULT '#',
  `status` enum('aktif','nonaktif','promo','laris') NOT NULL DEFAULT 'nonaktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `heroes`
--

INSERT INTO `heroes` (`id`, `kode_hero`, `judul`, `foto`, `deskripsi`, `link`, `status`, `created_at`, `updated_at`) VALUES
(1, 'TH1', 'Test1', 'hero-images/jWu7KgcK0HYairyWSBdI7mjgCz1VSCi6BbK0rNwT.jpg', 'Test pertama', '#', 'aktif', '2025-11-23 01:56:42', '2025-11-23 01:56:42'),
(2, 'TH2', 'Test2', 'hero-images/aOd3oo0imfP4cs1G3XqCyH9lpBQnUZo8akKmnyqh.jpg', 'Mouse baru', '#', 'aktif', '2025-11-23 02:09:35', '2025-11-23 02:09:35'),
(4, 'TH3', 'Test3', 'hero-images/5kvfPTNpF7bbYD24mK5KWH0KbBSJaanb5eEhomTk.png', 'Ini ehmmm. apa yaah', '#', 'aktif', '2025-11-23 02:24:04', '2025-11-23 02:24:04'),
(5, 'TH4', 'Test4', 'hero-images/IxeA2cSzpWjNfgRhx2c9XA8vxU7W0URObXvHrdwr.png', 'Wuhuuu', 'HTTPS', 'laris', '2025-11-23 02:26:46', '2026-04-18 21:22:55'),
(6, 'TH5', 'Test5', 'hero-images/SgLYmgjrZPgeCAkSXYRlrzRCwWXuLg0mKKZmAMvt.jpg', 'Jualan laptop', '#', 'promo', '2025-11-23 02:27:48', '2025-11-23 02:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategoris`
--

INSERT INTO `kategoris` (`id`, `nama`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'Processor', 'icons/6gLK7Y7UqYlUMOwSvrxeVJojODd1E31OpUJTu2Sf.png', '2025-11-22 09:51:18', '2025-11-23 05:33:35'),
(2, 'Motherboard', 'icons/BnkTRJdbeptuYBlHqO2g7y3snU9RUmkd0ly8OqI3.png', '2025-11-22 09:51:18', '2025-11-23 05:33:52'),
(3, 'RAM', 'icons/B9Figx3ychspE4guS6BPog1Hwv23zidibAR7nkvU.png', '2025-11-22 09:51:18', '2025-11-23 05:34:15'),
(4, 'Casing', 'icons/tLFXWfoAgashNAacS2HDEroehQs1LcDvTTIXLE2h.png', '2025-11-22 09:51:18', '2025-11-23 05:35:38'),
(5, 'SSD', 'icons/JRDhKxFTBUWjrbTGPRKqTv3BEi1tuIEwJlTk2h7C.png', '2025-11-22 09:51:18', '2026-04-18 19:56:08'),
(6, 'HDD', 'icons/msMquqyOF50BP9lP0fo8y9wxwwx63pVBEeSIVpAY.png', '2025-11-22 09:51:18', '2026-04-18 20:00:21'),
(7, 'VGA', 'vga.png', '2025-11-22 09:51:18', '2025-11-22 09:51:18'),
(8, 'PSU', 'psu.png', '2025-11-22 09:51:18', '2025-11-22 09:51:18'),
(9, 'Mouse', 'mouse.png', '2025-11-22 09:51:18', '2025-11-22 09:51:18'),
(10, 'Keyboard', 'icons/J2D9xW6ULG67bAOiDFs6u3NxEUKTPve42dhKIysD.png', '2025-11-22 09:51:18', '2025-11-23 05:51:53'),
(11, 'Monitor', 'monitor.png', '2025-11-22 09:51:18', '2025-11-22 09:51:18'),
(12, 'Cooler Fan', 'cooler fan.png', '2025-11-22 09:51:18', '2025-11-22 09:51:18'),
(13, 'Laptop', 'icons/iOs1936XubAhxnJh6Kx5nlE6e5HfcFAjbcxxOQCb.png', '2025-11-23 05:36:12', '2025-11-23 05:36:12'),
(14, 'Bingung', 'icons/d2MjlR5WjvBEikbMVrW5DV5YZSRoRSDI7ApOJDp8.png', '2025-11-23 05:38:12', '2025-11-23 05:38:12');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_11_22_104215_create_cabangs_table', 1),
(4, '2025_11_22_104215_create_kategoris_table', 1),
(5, '2025_11_22_104216_create_heroes_table', 1),
(6, '2025_11_22_104216_create_produks_table', 1),
(7, '2025_11_22_104217_create_galleries_table', 1),
(8, '2025_11_22_104217_create_rakit_pcs_table', 1),
(9, '2025_12_31_000000_create_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `produks`
--

CREATE TABLE `produks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_produk` varchar(255) NOT NULL,
  `id_cabang` bigint(20) UNSIGNED NOT NULL,
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produks`
--

INSERT INTO `produks` (`id`, `kode_produk`, `id_cabang`, `id_kategori`, `nama`, `deskripsi`, `harga`, `stok`, `foto`, `created_at`, `updated_at`) VALUES
(2, 'BRG002', 2, 1, 'INTEL CORE I5 13400', 'Description: Intel UHD Graphics    Class: Desktop    Socket: FCLGA1700    Total Cores: 10 Cores, 16 Threads    Performance Cores: 6 Cores, 12 Threads, 2.5 GHz Base, 4.6 GHz Turbo    Efficient Cores: 4 Cores, 4 Threads, NA Base, 3.3 GHz Turbo    Typical TDP: 65 W    Cache Size: L1: 864 KB, L2: 9.5 MB, L3: 20 MB    Other names: 13th Gen Intel(R) Core(TM) i5-13400', 3700000, 10, 'produk-images/7i7IEAKhIXIT7velTCpNnEBGHBgiag0rzok2d9LK.png', '2025-11-22 16:34:36', '2025-11-22 20:56:38'),
(4, 'BRG006', 1, 2, 'ASUS ROG Strix B760-F Gaming WiFi', 'CPU  - Intel Socket LGA1700 for 13th Gen Intel Core & 12th Gen Intel Core, Pentium Gold and Celeron Processors    Chipset  - Intel B760 Chipset    Memory  - 4 x DIMM slots, Max. 128GB, DDR5 7800+(OC)/7600(OC)/7400(OC)/7200(OC)/7000(OC)/6800(OC)/6600(OC)/6400(OC)/ 6200(OC)/6000(OC)/5800(OC)/5600/5400/5200/5000/4800 Non-ECC, Un-buffered Memory*  - Dual Channel Memory Architecture  - Supports Intel Extreme Memory Profile (XMP)  - OptiMem II', 4749000, 10, 'produk-images/74MzMNCGpyXMUsasJSFPk9p0pEhTKeBCOqMMhJSK.jpg', '2025-11-22 20:29:47', '2025-11-22 21:28:44'),
(6, 'BRG007', 1, 7, 'VGA Card MSI GeForce RTX 3050 VENTUS 2X 6G OC - 6GB GDDR6', 'The Ultimate Play Seri GeForce RTX 30 dengan teknologi Ray Tracing, NVIDIA DLSS dan NVIDIA Reflex    GeForce RTX 3050 6GB tidak memerlukan Konektor Daya Tambahan    GeForce RTX 3050 6GB adalah upgrade hebat bagi para gamer GeForce GTX 1650 dan GTX 1050 untuk meningkatkan ke RTX. Dengan Resolusi Super DLSS, RTX 3050 6GB bekerja hingga 4x lebih cepat dibandingkan pendahulunya dengan anggaran daya yang sama di berbagai game populer.', 3293000, 20, 'produk-images/03d1IIRW0euNCwsxTHwBPpy08datvX14vG5SQdZD.jpg', '2025-11-22 21:37:02', '2025-11-23 23:03:41'),
(8, 'BRG077', 2, 13, 'Thinkpad X270 Intel i7', 'Ini latop badak, kesukaan Dihar', 2500000, 1, 'produk-images/PBTrlguZ2k2rsBLM0aYttZe5TYCbwQ1CuFD48pq3.png', '2025-11-23 05:40:21', '2025-11-23 05:40:21'),
(9, 'BRG013', 2, 13, 'Lenovo LOQ Essential 15IAX9E | I5 12450HX RTX3050 12GB 512GB W11 OHS', 'LENOVO LOQ ESSENTIAL 15 I5 12450HX RTX3050 6GB/ 12GB 512GB W11+OHS 15.6FHD 144HZ 100SRGB BLIT 2Y+ADP GRY -8UID\r\n\r\nSKU : 83LK00B7ID\r\n\r\n• Spesifikasi\r\n- Processor : Intel Core i5-12450HX, 8C (4P + 4E) / 12T, P-core up to 4.4GHz, E-core up to 3.1GHz, 12MB\r\n- Graphics : NVIDIA GeForce RTX 3050 6GB GDDR6, Boost Clock 1432MHz, TGP 65W, 142 AI TOPS\r\n- Memory :1x 12GB SO-DIMM DDR5-4800\r\n- Storage : 512GB SSD M.2 2242 PCIe 4.0x4 NVMe\r\n- Display : 15.6\" FHD (1920x1080) IPS 300nits Anti-glare, 100% sRGB, 144Hz\r\n- Battery : Integrated 57Wh\r\n- Camera : HD 720p with Privacy Shutter\r\n- Keyboard : Backlit, English\r\n- Bundled Software : Office Home 2024\r\n- Operating System : Windows 11 Home\r\n- WLAN + Bluetooth : Wi-Fi 6, 802.11ax 2x2 + BT5.2\r\n\r\n• Standart Port :\r\n- 2x USB-A (USB 5Gbps / USB 3.2 Gen 1)\r\n- 1x USB-C (USB 5Gbps / USB 3.2 Gen 1), with USB PD 3.0 and DisplayPort 1.2\r\n- 1x HDMI 1.4\r\n- 1x Headphone / microphone combo jack (3.5mm)\r\n- 1x SD card reader\r\n- 1x Power connector\r\n\r\n• Dimensions(W X D X H) : 314.4 x 222.1 x 16.9-17.9 mm\r\n• Berat : 1.39 kg', 10000000, 5, 'produk-images/xNTUMoILRk04ewnNlzCbxNIXUIa1RA5mujpYB4om.png', '2025-11-23 06:19:57', '2025-11-23 06:19:57'),
(11, 'T90', 2, 1, 'Test gambar besar', NULL, 9000, 10, 'produk-images/KitjBmMZXCF2B5XB9MwUhKYQDgaZ4rnVm0giAQvc.png', '2026-04-18 20:11:58', '2026-04-18 21:23:41');

-- --------------------------------------------------------

--
-- Table structure for table `rakit_pcs`
--

CREATE TABLE `rakit_pcs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_rakitan` varchar(255) NOT NULL,
  `processor` varchar(255) DEFAULT NULL,
  `motherboard` varchar(255) DEFAULT NULL,
  `ram` varchar(255) DEFAULT NULL,
  `casing` varchar(255) DEFAULT NULL,
  `ssd` varchar(255) DEFAULT NULL,
  `hdd` varchar(255) DEFAULT NULL,
  `vga` varchar(255) DEFAULT NULL,
  `psu` varchar(255) DEFAULT NULL,
  `mouse` varchar(255) DEFAULT NULL,
  `keyboard` varchar(255) DEFAULT NULL,
  `monitor` varchar(255) DEFAULT NULL,
  `coolerfan` varchar(255) DEFAULT NULL,
  `total_harga` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rakit_pcs`
--

INSERT INTO `rakit_pcs` (`id`, `kode_rakitan`, `processor`, `motherboard`, `ram`, `casing`, `ssd`, `hdd`, `vga`, `psu`, `mouse`, `keyboard`, `monitor`, `coolerfan`, `total_harga`, `created_at`, `updated_at`) VALUES
(2, 'RK-XV2QK24', '-', 'ASUS ROG Strix B760-F Gaming WiFi (x5)', '-', '-', '-', '-', 'VGA Card MSI GeForce RTX 3050 VENTUS 2X 6G OC - 6GB GDDR6 (x5)', '-', '-', '-', '-', '-', 40210000, '2025-11-24 01:19:01', '2025-11-24 01:19:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_admin` varchar(255) DEFAULT NULL,
  `id_cabang` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `jk` enum('L','P') DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `no_telfon` varchar(255) DEFAULT NULL,
  `role` enum('admin','super_admin','owner') NOT NULL DEFAULT 'admin',
  `alamat` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `kode_admin`, `id_cabang`, `name`, `email`, `jk`, `password`, `jabatan`, `no_telfon`, `role`, `alamat`, `foto`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'K002', 1, 'Beti Putri', 'mrsbest@gmail.com', 'P', '$2y$12$rr.ha5Nk7ohoWldekv6fLe/hcMybnmpAT//vaw9GNktgpqKydrCUq', 'MANAGER', '082186407595', 'super_admin', 'Griya Danakarya\r\nKavling K', NULL, NULL, '2025-11-22 09:51:18', '2025-11-22 22:20:12'),
(4, 'RK1', 1, 'Rijaludin', 'ratukomputer@gmail.com', 'L', '$2y$12$MbOSPTTLluecqlLn.qFpBuO9POBNXXkGpxdeyO2gLMJt5cNX1rK4K', 'CEO', '087773599434', 'owner', 'Jl. Ciwaru Raya No.Rt.04/16, Cipare, Kec. Serang, Kota Serang, Banten 42117', NULL, NULL, '2025-11-22 09:51:19', '2025-11-22 09:51:19'),
(5, 'T-001', 2, 'Izdihar Izzan Wibowo', 'izzan4izdihar@gmail.com', 'L', '$2y$12$HK2XVuB/zVOOYt3gyylPPODm1lpIFr1nKFhFrLfjxVxzklQMQb0K2', 'PROJECT MANAGER', '085774690939', 'super_admin', 'Jl. Gempol 1 No.40B, RT.6/RW.2, Ceger, Kec. Cipayung, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13820', 'fotos/r75rto19qQ1M7IHUwdxej9YSsFDkCKPFaJ7uHUOB.png', NULL, '2025-11-22 23:08:43', '2025-11-23 00:09:25'),
(6, 'T-002', 1, 'Jihan Bunga Firdaus', 'jihanbunga@apps.ipb.ac.id', 'P', '$2y$12$VLCgGdygRqPPQB6svfDqv.I9iRahdQTxEODwmREdo3uHhMwGdLVVO', 'MANAGER', '+62 856-9226-1460', 'super_admin', 'Jl. Sancang Dalam No.26, RT.01/RW.07, Babakan, Kecamatan Bogor Tengah, Kota Bogor, Jawa Barat 16128', 'fotos/NsSWluEMSldPAsziWzgiC8BAamr7AsO1aTHYLh6t.png', NULL, '2025-11-22 23:16:45', '2025-11-22 23:16:45'),
(7, 'T-003', 1, 'Riki Bonardo', '202912ricky@apps.ipb.ac.id', 'L', '$2y$12$VbHZ/3kAmE/N.9AqenUrOeXJtOkWjXDUl3Y2UCFw4xcMWn3SD9sfi', 'STAFF', '+62 895-3365-51525', 'admin', 'MMCM+883, Jl. Tekno Widya, Ciater, Kec. Serpong, Kota Tangerang Selatan, Banten 15326', 'fotos/VmczYZA03dSlFrR1v9jqNtpbjaepaT1V83wdNyTR.jpg', NULL, '2025-11-22 23:21:59', '2025-11-22 23:26:02'),
(8, 'T-004', 2, 'Raihan Alma Putra', 'raihanalma@apps.ipb.ac.id', 'L', '$2y$12$FgW7cBtY4RQc.0cpQGeHI.Aom/ELZgaiae4hEyheht7xmUIDTXkCK', 'STAFF', '+62 812-8709-4218', 'admin', 'Jl. Siliwangi No.43, RT.01/RW.03, Sukasari, Kec. Bogor Tim., Kota Bogor, Jawa Barat 16142', 'fotos/K4tE2IPsJWdyE6pvuZ65NC4qpemCdrwfhttYdEJo.jpg', NULL, '2025-11-22 23:26:45', '2025-11-22 23:26:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cabangs`
--
ALTER TABLE `cabangs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cabangs_kode_cabang_unique` (`kode_cabang`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galleries_id_produk_foreign` (`id_produk`);

--
-- Indexes for table `heroes`
--
ALTER TABLE `heroes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produks`
--
ALTER TABLE `produks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produks_id_cabang_foreign` (`id_cabang`),
  ADD KEY `produks_id_kategori_foreign` (`id_kategori`);

--
-- Indexes for table `rakit_pcs`
--
ALTER TABLE `rakit_pcs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rakit_pcs_kode_rakitan_unique` (`kode_rakitan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_id_cabang_foreign` (`id_cabang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cabangs`
--
ALTER TABLE `cabangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `heroes`
--
ALTER TABLE `heroes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `produks`
--
ALTER TABLE `produks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rakit_pcs`
--
ALTER TABLE `rakit_pcs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `galleries`
--
ALTER TABLE `galleries`
  ADD CONSTRAINT `galleries_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `produks`
--
ALTER TABLE `produks`
  ADD CONSTRAINT `produks_id_cabang_foreign` FOREIGN KEY (`id_cabang`) REFERENCES `cabangs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `produks_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategoris` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_id_cabang_foreign` FOREIGN KEY (`id_cabang`) REFERENCES `cabangs` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
