-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2023 at 09:23 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pendataan_bengkel`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(4) NOT NULL,
  `foto_barang` text NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `remark_barang` text NOT NULL,
  `tanggal_barang` datetime NOT NULL DEFAULT current_timestamp(),
  `maker_barang` int(4) NOT NULL,
  `barang_laporan` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `foto_barang`, `nama_barang`, `jumlah`, `remark_barang`, `tanggal_barang`, `maker_barang`, `barang_laporan`) VALUES
(1, 'kunci_inggris.jpg', 'Kunci Inggris', '0', 'Kunci Inggris adalah suatu istilah yang merujuk kepada kemampuan seseorang dalam berbicara, membaca, menulis, dan memahami bahasa Inggris. Kemampuan ini melibatkan penguasaan tata bahasa, perbendaharaan kata, serta kemampuan berkomunikasi secara efektif dalam bahasa Inggris. Kunci Inggris memiliki peran penting dalam berbagai aspek kehidupan, seperti dalam pendidikan, karier, dan komunikasi lintas budaya di era globalisasi. Penguasaan bahasa Inggris dapat membuka peluang yang lebih luas dalam hal akses ke sumber daya, informasi, dan peluang kerja di tingkat internasional.\n\n\n\n\n', '2023-10-17 09:13:35', 1, '2023-10-18'),
(3, '1697514019_2b4a2fe8c1e472867cc1.png', 'tang', '0', 'Tang adalah peralatan bengkel yang khusus digunakan untuk memegang, memotong, melepas, dan memasang bahan kerja. Jenis tang bermacam-macam, di antaranya tang kombinasi, tang lancip, dan tang potong.', '2023-10-17 10:40:19', 1, '2023-10-18'),
(4, 'bor.png', 'bor', '0', 'Bor adalah sebuah peralatan atau mesin yang digunakan untuk membuat lubang atau menghilangkan material dari suatu permukaan dengan memutar pahat berputar yang tajam. Bor sering digunakan dalam berbagai aplikasi, mulai dari konstruksi hingga perbaikan rumah, serta dalam industri manufaktur. Bor listrik modern umumnya dilengkapi dengan berbagai jenis mata bor yang dapat diganti, memungkinkan pengguna untuk menghasilkan lubang berbeda sesuai dengan kebutuhan. Bor memainkan peran penting dalam berbagai proyek, memungkinkan pengguna untuk dengan cepat dan efisien membuat lubang pada berbagai material seperti kayu, logam, atau beton.', '2023-10-17 10:41:51', 1, '2023-10-18'),
(5, 'baut.png', 'baut', '0', 'Baut adalah suatu jenis paku atau pasak dengan ulir yang digunakan untuk menghubungkan dua atau lebih komponen dengan cara menyesuaikan atau mengencangkan keduanya. Biasanya terbuat dari logam, baut memiliki kepala di satu ujungnya yang digunakan untuk memegang dan memutar baut dengan alat seperti kunci pas atau obeng. Baut sering digunakan dalam berbagai aplikasi, mulai dari konstruksi bangunan dan kendaraan hingga peralatan rumah tangga, dan merupakan elemen kunci dalam memastikan kekokohan dan kestabilan struktur serta komponen yang digabungkan.', '2023-10-17 10:46:26', 1, '2023-10-18'),
(6, '1697545393_5e17a9da0ed6c8d5f7d5.png', 'Kelsey Maclius Clayton', '2', 'Ban mobil adalah salah satu komponen paling krusial dalam kendaraan bermotor, berfungsi sebagai antarmuka antara mobil dan jalan serta memainkan peran penting dalam kenyamanan, keamanan, dan performa kendaraan. Ban mobil terbuat dari campuran karet dan bahan penguat yang dirancang untuk memberikan cengkraman yang baik dengan permukaan jalan, mengurangi getaran, dan menangani beban kendaraan. Profil ban dan tekanan udara yang sesuai adalah faktor kunci dalam stabilitas dan manuverabilitas mobil. Selain itu, ban juga memiliki pola alur yang berbeda untuk kondisi jalan yang beragam, seperti ban musim panas, ban musim dingin, dan ban khusus off-road. Pemeliharaan dan penggantian ban secara teratur sangat penting untuk menjaga keamanan berkendara dan efisiensi bahan bakar.', '2023-10-17 10:58:42', 8, '2023-10-18');

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_barang_keluar` int(4) NOT NULL,
  `id_keluar_barang` int(4) NOT NULL,
  `stok` varchar(255) NOT NULL,
  `remark_keluar` text NOT NULL,
  `tanggal_barang_keluar` datetime NOT NULL DEFAULT current_timestamp(),
  `maker_barang_masuk` int(4) NOT NULL,
  `barang_keluar_laporan` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_barang_keluar`, `id_keluar_barang`, `stok`, `remark_keluar`, `tanggal_barang_keluar`, `maker_barang_masuk`, `barang_keluar_laporan`) VALUES
(3, 6, '2', '~', '2023-10-18 14:17:43', 8, '2023-10-18'),
(7, 6, '1', '1', '2023-10-19 09:05:27', 13, '2023-10-19');

--
-- Triggers `barang_keluar`
--
DELIMITER $$
CREATE TRIGGER `cancel` AFTER DELETE ON `barang_keluar` FOR EACH ROW UPDATE barang SET jumlah = jumlah+old.stok WHERE id_barang = old.id_keluar_barang
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `kurang` AFTER INSERT ON `barang_keluar` FOR EACH ROW UPDATE barang SET jumlah = jumlah-new.stok WHERE id_barang = new.id_keluar_barang
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_barang_masuk` int(4) NOT NULL,
  `id_masuk_barang` int(4) NOT NULL,
  `stok` varchar(255) NOT NULL,
  `harga_beli` text NOT NULL,
  `tanggal_barang_masuk` datetime NOT NULL DEFAULT current_timestamp(),
  `maker_barang_masuk` int(4) NOT NULL,
  `barang_masuk_laporan` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_barang_masuk`, `id_masuk_barang`, `stok`, `harga_beli`, `tanggal_barang_masuk`, `maker_barang_masuk`, `barang_masuk_laporan`) VALUES
(1, 6, '4', '2000000', '2023-10-18 12:38:06', 8, '2023-10-18'),
(4, 6, '1', '50000', '2023-10-20 10:00:55', 8, '2023-10-20');

--
-- Triggers `barang_masuk`
--
DELIMITER $$
CREATE TRIGGER `hapus` AFTER DELETE ON `barang_masuk` FOR EACH ROW update barang set jumlah = jumlah-old.stok WHERE id_barang = old.id_masuk_barang
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `masuk` AFTER INSERT ON `barang_masuk` FOR EACH ROW UPDATE barang SET jumlah= jumlah+new.stok WHERE id_barang=new.id_masuk_barang
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bengkel`
--

CREATE TABLE `bengkel` (
  `id_bengkel` int(4) NOT NULL,
  `nama_bengkel` text NOT NULL,
  `no_bengkel` varchar(20) NOT NULL,
  `alamat_bengkel` text NOT NULL,
  `tanggal_bengkel` datetime NOT NULL DEFAULT current_timestamp(),
  `maker_bengkel` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bengkel`
--

INSERT INTO `bengkel` (`id_bengkel`, `nama_bengkel`, `no_bengkel`, `alamat_bengkel`, `tanggal_bengkel`, `maker_bengkel`) VALUES
(3, 'Sun Jaya Motor', '08117033168', 'Ruko Golden Land, Blk. L Jl. Golden Land No.8, Taman Baloi, Kec. Batam Kota, Kota Batam, Kepulauan Riau 29432', '2023-10-18 18:57:08', 8),
(4, 'Auto Star Batam - Car Repair Shop', '082172655688', '4335+96H, Jl. Pemuda, Baloi Permai, Kec. Batam Kota, Kota Batam, Kepulauan Riau 29444', '2023-10-18 18:58:19', 8);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_service`
--

CREATE TABLE `invoice_service` (
  `id_invoice` int(4) NOT NULL,
  `id_kendaraan_invoice` int(4) NOT NULL,
  `harga_invoice` text NOT NULL,
  `remark` text NOT NULL,
  `bukti_pembayaran` text NOT NULL,
  `metode_pembayaran` varchar(100) NOT NULL,
  `status_invoice` varchar(20) NOT NULL,
  `tanggal_invoice` datetime NOT NULL DEFAULT current_timestamp(),
  `maker_invoice` int(4) NOT NULL,
  `maker_invoice_kendaraan` int(4) NOT NULL,
  `invoice_laporan` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_service`
--

INSERT INTO `invoice_service` (`id_invoice`, `id_kendaraan_invoice`, `harga_invoice`, `remark`, `bukti_pembayaran`, `metode_pembayaran`, `status_invoice`, `tanggal_invoice`, `maker_invoice`, `maker_invoice_kendaraan`, `invoice_laporan`) VALUES
(1, 1, '500000', '~', '1697861292_30e2d033b545c99c5cd2.png', 'Bank Transfer / Virtual Account', 'Paid Off', '2023-10-21 08:55:48', 12, 12, '2023-10-21'),
(5, 2, '2500000', '~', '1697868402_d40ccf3d5c25e61c24f0.jpg', 'Cash', 'Paid Off', '2023-10-21 13:01:50', 12, 12, '2023-10-21');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(4) NOT NULL,
  `id_user_karyawan` int(4) NOT NULL,
  `nip` int(16) NOT NULL,
  `nama_karyawan` varchar(200) NOT NULL,
  `jk_karyawan` varchar(10) NOT NULL,
  `ttl_karyawan` varchar(200) NOT NULL,
  `tanggal_karyawan` datetime NOT NULL DEFAULT current_timestamp(),
  `maker_karyawan` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `id_user_karyawan`, `nip`, `nama_karyawan`, `jk_karyawan`, `ttl_karyawan`, `tanggal_karyawan`, `maker_karyawan`) VALUES
(1, 1, 123456789, 'Norman Ang', 'Male', 'Batam, 28 October 2006', '2023-10-16 20:18:47', 1),
(3, 8, 112345678, 'Asep Sumanto', 'Male', 'Singapore, 28 October 2004', '2023-10-16 21:13:39', 1),
(7, 13, 1122345678, 'Octarianto Lika Ng', 'Male', 'Batam, 29 October 2005', '2023-10-17 08:30:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id_kendaraan` int(4) NOT NULL,
  `foto_kendaraan` text NOT NULL,
  `id_service_bengkel` int(4) NOT NULL,
  `merk_kendaraan` varchar(255) NOT NULL,
  `plat_kendaraan` varchar(10) NOT NULL,
  `service_kendaraan` text NOT NULL,
  `tanggal_service` datetime NOT NULL DEFAULT current_timestamp(),
  `status_kendaraan` varchar(20) NOT NULL,
  `tanggal_kendaraan` datetime NOT NULL DEFAULT current_timestamp(),
  `maker_kendaraan` int(4) NOT NULL,
  `vm_laporan` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kendaraan`
--

INSERT INTO `kendaraan` (`id_kendaraan`, `foto_kendaraan`, `id_service_bengkel`, `merk_kendaraan`, `plat_kendaraan`, `service_kendaraan`, `tanggal_service`, `status_kendaraan`, `tanggal_kendaraan`, `maker_kendaraan`, `vm_laporan`) VALUES
(1, 'service.jpeg', 4, 'ferrari spider 488 ', 'BP 89 YN', 'Routine Service', '2023-10-21 00:00:00', 'Already Serviced', '2023-10-20 18:28:29', 12, '2023-10-21'),
(2, 'service.jpeg', 4, 'Mercedes-Benz GLC', 'bp 01 nn', 'Car AC Maintenance', '2023-10-21 15:00:00', 'Already Serviced', '2023-10-21 12:57:42', 12, '2023-10-21');

-- --------------------------------------------------------

--
-- Table structure for table `log_activity`
--

CREATE TABLE `log_activity` (
  `id_log` int(4) NOT NULL,
  `id_user_log` int(4) NOT NULL,
  `activity` text NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `log_activity`
--

INSERT INTO `log_activity` (`id_log`, `id_user_log`, `activity`, `datetime`) VALUES
(1, 8, 'Log out on the system with ID  ', '2023-10-18 20:21:26'),
(2, 1, 'Login on the system with ID 1 ', '2023-10-18 20:21:34'),
(3, 1, 'Add Employee Accounts By Name 1 ', '2023-10-18 20:29:40'),
(4, 1, 'Reset Employee Account Password With ID 15 ', '2023-10-18 20:29:44'),
(5, 1, 'Add Employee Accounts By Name 1 ', '2023-10-18 20:29:52'),
(6, 1, 'Delete Employee Account With ID 15 ', '2023-10-18 20:30:10'),
(7, 1, 'Edit Employee Account By Name Octarianto Lika Ng with ID 13 ', '2023-10-18 20:31:21'),
(8, 1, 'Reset User Account Password With ID 12 ', '2023-10-18 20:32:58'),
(9, 1, 'Delete User Account With ID 28 ', '2023-10-18 20:52:35'),
(10, 1, 'Add Data Workshop By Name 1 ', '2023-10-18 20:58:35'),
(11, 1, 'Edit Data Workshop With ID 6 ', '2023-10-18 20:58:41'),
(12, 1, 'Delete Data Workshop With ID 6 ', '2023-10-18 20:58:43'),
(13, 1, 'Log out on the system with ID  ', '2023-10-18 21:01:25'),
(14, 8, 'Login on the system with ID 8 ', '2023-10-18 21:01:35'),
(15, 8, 'Add Data Items By Name 12 ', '2023-10-18 21:01:50'),
(16, 8, 'Edit Data Items With ID 9 ', '2023-10-18 21:01:57'),
(17, 8, 'Delete Data Items With ID 9 ', '2023-10-18 21:02:01'),
(18, 8, 'Add Data Incoming Items With ID 1 ', '2023-10-18 21:02:49'),
(19, 8, 'Delete Data Incoming Items With ID 3 ', '2023-10-18 21:02:53'),
(20, 8, 'Add Data Outbound Items With ID 6 ', '2023-10-18 21:04:00'),
(21, 8, 'Delete Data Outbound Items With ID 6 ', '2023-10-18 21:04:03'),
(22, 8, 'Delete Data Outbound Items With ID 4 ', '2023-10-18 21:04:04'),
(23, 8, 'Log out on the system with ID  ', '2023-10-18 21:05:06'),
(24, 13, 'Login on the system with ID 13 ', '2023-10-18 21:05:15'),
(25, 13, 'Add Data Outbound Items With ID 6 ', '2023-10-18 21:05:27'),
(26, 13, 'Log out on the system with ID  ', '2023-10-18 21:05:37'),
(27, 8, 'Login on the system with ID 8 ', '2023-10-18 21:05:47'),
(28, 8, 'Displays Items Data Reports In Print Format ', '2023-10-18 21:10:21'),
(29, 8, 'Displays Items Data Reports In Print Format ', '2023-10-18 21:10:39'),
(30, 8, 'Displays Items Data Reports In Print Format ', '2023-10-18 21:13:47'),
(31, 8, 'Displays Items Data Reports In PDF Format ', '2023-10-18 21:15:00'),
(32, 8, 'Displays Items Data Reports In Excel Format ', '2023-10-18 21:15:09'),
(33, 8, 'Displays Incoming Items Data Reports In Print Format ', '2023-10-18 21:15:29'),
(34, 8, 'Displays Incoming Items Data Reports In PDF Format ', '2023-10-18 21:15:33'),
(35, 8, 'Displays Incoming Items Data Reports In Excel Format ', '2023-10-18 21:15:35'),
(36, 8, 'Displays Outbound Items Data Reports In Print Format ', '2023-10-18 21:15:45'),
(37, 8, 'Displays Outbound Items Data Reports In PDF Format ', '2023-10-18 21:15:49'),
(38, 8, 'Displays Outbound Items Data Reports In Excel Format ', '2023-10-18 21:15:51'),
(39, 13, 'Login on the system with ID 13 ', '2023-10-18 21:16:40'),
(40, 13, 'Displays Outbound Items Data Reports In Print Format ', '2023-10-18 21:16:47'),
(41, 8, 'Log out on the system with ID  ', '2023-10-18 21:32:10'),
(42, 1, 'Login on the system with ID 1 ', '2023-10-18 22:09:26'),
(43, 1, 'Log out on the system with ID  ', '2023-10-18 22:47:10'),
(44, 8, 'Login on the system with ID 8 ', '2023-10-18 22:47:20'),
(45, 13, 'Login on the system with ID 13 ', '2023-10-18 22:52:07'),
(46, 8, 'Log out on the system with ID  ', '2023-10-18 23:18:13'),
(47, 1, 'Login on the system with ID 1 ', '2023-10-18 23:18:21'),
(48, 1, 'Log out on the system with ID  ', '2023-10-18 23:18:32'),
(49, 8, 'Login on the system with ID 8 ', '2023-10-18 23:18:54'),
(50, 8, 'Log out on the system with ID  ', '2023-10-18 23:52:29'),
(51, 1, 'Login on the system with ID 1 ', '2023-10-19 00:50:55'),
(52, 1, 'Log out on the system with ID  ', '2023-10-19 01:16:17'),
(53, 8, 'Login on the system with ID 8 ', '2023-10-19 02:19:06'),
(54, 8, 'Displays Items Data Reports In Print Format ', '2023-10-19 02:19:25'),
(55, 8, 'Displays Items Data Reports In PDF Format ', '2023-10-19 02:27:17'),
(56, 1, 'Login on the system with ID 1 ', '2023-10-19 21:43:15'),
(57, 1, 'Log out on the system with ID  ', '2023-10-19 21:43:52'),
(58, 8, 'Login on the system with ID 8 ', '2023-10-19 21:44:42'),
(59, 8, 'Edit Data Items With ID 6 ', '2023-10-19 21:59:51'),
(60, 8, 'Add Data Incoming Items With ID 6 ', '2023-10-19 22:00:55'),
(61, 8, 'Add Data Outbound Items With ID 6 ', '2023-10-19 22:01:19'),
(62, 8, 'Delete Data Outbound Items With ID 8 ', '2023-10-19 22:02:34'),
(63, 8, 'Log out on the system with ID  ', '2023-10-19 22:14:39'),
(64, 8, 'Login on the system with ID 8 ', '2023-10-20 05:01:57'),
(65, 8, 'Log out on the system with ID  ', '2023-10-20 05:07:50'),
(66, 12, 'Login on the system with ID  ', '2023-10-20 05:08:01'),
(67, 12, 'Log out on the system with ID  ', '2023-10-20 05:08:46'),
(68, 12, 'Login on the system with ID  ', '2023-10-20 05:08:56'),
(69, 12, 'Log out on the system with ID  ', '2023-10-20 05:43:52'),
(70, 12, 'Login on the system with ID  ', '2023-10-20 06:05:43'),
(71, 12, 'Add Data Vehicle Maintenance By Name ferrari spider 488  ', '2023-10-20 06:28:29'),
(72, 12, 'Log out on the system with ID  ', '2023-10-20 06:41:27'),
(73, 12, 'Login on the system with ID  ', '2023-10-20 07:43:29'),
(74, 8, 'Login on the system with ID 8 ', '2023-10-20 09:03:51'),
(75, 8, 'Log out on the system with ID  ', '2023-10-20 09:18:44'),
(76, 13, 'Login on the system with ID 13 ', '2023-10-20 09:18:56'),
(77, 12, 'Log out on the system with ID  ', '2023-10-20 09:32:20'),
(78, 13, 'Log out on the system with ID  ', '2023-10-20 09:40:00'),
(79, 8, 'Login on the system with ID 8 ', '2023-10-20 09:40:12'),
(80, 8, 'Login on the system with ID 8 ', '2023-10-20 09:42:20'),
(81, 8, 'Edit Data Vehicle Maintenance Approved With ID 1 ', '2023-10-20 09:44:14'),
(82, 8, 'Log out on the system with ID  ', '2023-10-20 09:44:59'),
(83, 13, 'Login on the system with ID 13 ', '2023-10-20 09:45:08'),
(84, 13, 'Edit Data Vehicle Maintenance Already Serviced With ID 1 ', '2023-10-20 09:45:30'),
(85, 13, 'Log out on the system with ID  ', '2023-10-20 09:45:44'),
(86, 8, 'Login on the system with ID 8 ', '2023-10-20 09:45:53'),
(87, 8, 'Log out on the system with ID  ', '2023-10-20 09:56:35'),
(88, 8, 'Login on the system with ID 8 ', '2023-10-20 10:01:49'),
(89, 8, 'Login on the system with ID 8 ', '2023-10-20 20:27:54'),
(90, 8, 'Add Invoice Vehicle Maintenance Data By Name 1 ', '2023-10-20 20:55:48'),
(91, 8, 'Add Data Invoice Vehicle Maintenance By Name 1 ', '2023-10-20 21:34:33'),
(92, 8, 'Delete Data Invoice Vehicle Maintenance With ID 2 ', '2023-10-20 21:34:36'),
(93, 12, 'Login on the system with ID  ', '2023-10-20 21:35:09'),
(94, 8, 'Log out on the system with ID  ', '2023-10-20 21:44:27'),
(95, 8, 'Login on the system with ID 8 ', '2023-10-20 21:44:51'),
(96, 12, 'Log out on the system with ID  ', '2023-10-20 21:45:00'),
(97, 12, 'Login on the system with ID  ', '2023-10-20 21:45:08'),
(98, 12, 'Log out on the system with ID  ', '2023-10-20 21:48:04'),
(99, 12, 'Login on the system with ID  ', '2023-10-20 21:48:11'),
(100, 8, 'Add Data Invoice Vehicle Maintenance By Name 1 ', '2023-10-20 22:06:05'),
(101, 8, 'Delete Data Invoice Vehicle Maintenance With ID 3 ', '2023-10-20 22:06:24'),
(102, 8, 'Add Data Invoice Vehicle Maintenance By Name 1 ', '2023-10-20 22:06:30'),
(103, 12, 'Log out on the system with ID  ', '2023-10-20 22:12:13'),
(104, 12, 'Login on the system with ID  ', '2023-10-20 22:12:24'),
(105, 8, 'Log out on the system with ID  ', '2023-10-20 22:24:06'),
(106, 12, 'Log out on the system with ID  ', '2023-10-20 22:24:37'),
(107, 12, 'Login on the system with ID  ', '2023-10-20 22:41:21'),
(108, 8, 'Login on the system with ID 8 ', '2023-10-20 22:55:26'),
(109, 12, 'Pay Service Vehicle Maintenance Bill With ID 1 ', '2023-10-20 23:07:11'),
(110, 12, 'Pay Service Vehicle Maintenance Bill With ID 1 ', '2023-10-20 23:07:30'),
(111, 12, 'Pay Service Vehicle Maintenance Bill With ID 1 ', '2023-10-20 23:08:12'),
(112, 8, 'Log out on the system with ID  ', '2023-10-20 23:16:28'),
(113, 13, 'Login on the system with ID 13 ', '2023-10-20 23:16:35'),
(114, 8, 'Login on the system with ID 8 ', '2023-10-20 23:19:26'),
(115, 8, 'Displays Items Data Reports In Print Format ', '2023-10-20 23:19:36'),
(116, 12, 'Displays Vehicle Maintenance Data Reports In Print Format ', '2023-10-20 23:36:44'),
(117, 12, 'Displays Vehicle Maintenance Data Reports In Print Format ', '2023-10-20 23:37:18'),
(118, 12, 'Displays Vehicle Maintenance Data Reports In Print Format ', '2023-10-20 23:37:32'),
(119, 12, 'Displays Vehicle Maintenance Data Reports In PDF Format ', '2023-10-20 23:37:45'),
(120, 12, 'Displays Vehicle Maintenance Data Reports In Excel Format ', '2023-10-20 23:37:51'),
(121, 12, 'Displays Vehicle Maintenance Data Reports In Excel Format ', '2023-10-20 23:39:03'),
(122, 12, 'Displays Vehicle Maintenance Data Reports In Print Format ', '2023-10-20 23:45:12'),
(123, 12, 'Displays Vehicle Maintenance Data Reports In Print Format ', '2023-10-20 23:45:29'),
(124, 12, 'Displays Vehicle Maintenance Data Reports In PDF Format ', '2023-10-20 23:46:30'),
(125, 12, 'Displays Vehicle Maintenance Data Reports In PDF Format ', '2023-10-20 23:46:36'),
(126, 12, 'Displays Vehicle Maintenance Data Reports In Excel Format ', '2023-10-20 23:47:33'),
(127, 12, 'Displays Vehicle Maintenance Data Reports In Excel Format ', '2023-10-20 23:47:49'),
(128, 12, 'Displays Vehicle Maintenance Data Reports In Excel Format ', '2023-10-20 23:47:56'),
(129, 8, 'Login on the system with ID 8 ', '2023-10-20 23:48:27'),
(130, 8, 'Displays Vehicle Maintenance Data Reports In Print Format ', '2023-10-20 23:48:34'),
(131, 8, 'Displays Vehicle Maintenance Data Reports In PDF Format ', '2023-10-20 23:48:39'),
(132, 12, 'Log out on the system with ID  ', '2023-10-20 23:58:11'),
(133, 8, 'Login on the system with ID 8 ', '2023-10-21 00:29:18'),
(134, 8, 'Log out on the system with ID  ', '2023-10-21 00:39:23'),
(135, 8, 'Login on the system with ID 8 ', '2023-10-21 00:42:09'),
(136, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:43:54'),
(137, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:44:15'),
(138, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:45:06'),
(139, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:45:20'),
(140, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:45:54'),
(141, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:46:04'),
(142, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:46:09'),
(143, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:46:18'),
(144, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:47:30'),
(145, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:47:47'),
(146, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:49:05'),
(147, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:49:16'),
(148, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:49:33'),
(149, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:49:40'),
(150, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:49:44'),
(151, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:49:57'),
(152, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:50:03'),
(153, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:50:12'),
(154, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:50:25'),
(155, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:50:32'),
(156, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:51:22'),
(157, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 00:51:55'),
(158, 12, 'Login on the system with ID  ', '2023-10-21 00:56:36'),
(159, 12, 'Add Data Vehicle Maintenance By Name Mercedes-Benz GLC ', '2023-10-21 00:57:42'),
(160, 8, 'Edit Data Vehicle Maintenance Approved With ID 2 ', '2023-10-21 01:00:52'),
(161, 12, 'Log out on the system with ID  ', '2023-10-21 01:01:00'),
(162, 13, 'Login on the system with ID 13 ', '2023-10-21 01:01:09'),
(163, 13, 'Edit Data Vehicle Maintenance Already Serviced With ID 2 ', '2023-10-21 01:01:16'),
(164, 13, 'Log out on the system with ID  ', '2023-10-21 01:01:19'),
(165, 8, 'Login on the system with ID 8 ', '2023-10-21 01:01:27'),
(166, 8, 'Add Data Invoice Vehicle Maintenance By Name 2 ', '2023-10-21 01:01:50'),
(167, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 01:02:08'),
(168, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 01:04:23'),
(169, 8, 'Log out on the system with ID  ', '2023-10-21 01:04:31'),
(170, 12, 'Login on the system with ID  ', '2023-10-21 01:04:38'),
(171, 12, 'Pay Service Vehicle Maintenance Bill With ID 5 ', '2023-10-21 01:06:42'),
(172, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 01:06:51'),
(173, 8, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 01:07:20'),
(174, 8, 'Displays Invoice Data Reports In PDF Format ', '2023-10-21 01:15:27'),
(175, 8, 'Displays Invoice Data Reports In Excel Format ', '2023-10-21 01:15:37'),
(176, 8, 'Log out on the system with ID  ', '2023-10-21 01:26:37'),
(177, 8, 'Login on the system with ID 8 ', '2023-10-21 01:27:00'),
(178, 8, 'Edit password with ID 8 ', '2023-10-21 01:30:11'),
(179, 8, 'Log out on the system with ID  ', '2023-10-21 01:30:11'),
(180, 8, 'Login on the system with ID 8 ', '2023-10-21 01:30:18'),
(181, 8, 'Edit password with ID 8 ', '2023-10-21 01:30:46'),
(182, 8, 'Log out on the system with ID  ', '2023-10-21 01:30:46'),
(183, 8, 'Login on the system with ID 8 ', '2023-10-21 01:30:55'),
(184, 8, 'Log out on the system with ID  ', '2023-10-21 01:31:04'),
(185, 12, 'Login on the system with ID  ', '2023-10-21 01:31:13'),
(186, 12, 'Edit Profile  ', '2023-10-21 01:41:12'),
(187, 12, 'Log out on the system with ID  ', '2023-10-21 01:41:12'),
(188, 12, 'Login on the system with ID  ', '2023-10-21 01:41:21'),
(189, 12, 'Edit Profile  ', '2023-10-21 01:41:49'),
(190, 12, 'Log out on the system with ID  ', '2023-10-21 01:41:49'),
(191, 12, 'Login on the system with ID  ', '2023-10-21 01:42:00'),
(192, 12, 'Edit Profile  ', '2023-10-21 01:42:09'),
(193, 12, 'Log out on the system with ID  ', '2023-10-21 01:42:09'),
(194, 12, 'Login on the system with ID  ', '2023-10-21 01:42:18'),
(195, 12, 'Edit Profile  ', '2023-10-21 01:42:32'),
(196, 12, 'Log out on the system with ID  ', '2023-10-21 01:42:32'),
(197, 12, 'Login on the system with ID  ', '2023-10-21 01:42:45'),
(198, 12, 'Edit Profile  ', '2023-10-21 01:42:52'),
(199, 12, 'Log out on the system with ID  ', '2023-10-21 01:42:52'),
(200, 12, 'Login on the system with ID  ', '2023-10-21 01:43:00'),
(201, 12, 'Edit Profile  ', '2023-10-21 01:44:18'),
(202, 12, 'Log out on the system with ID  ', '2023-10-21 01:44:18'),
(203, 12, 'Login on the system with ID  ', '2023-10-21 01:44:32'),
(204, 12, 'Displays Vehicle Maintenance Data Reports In Print Format ', '2023-10-21 01:44:43'),
(205, 12, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 01:44:50'),
(206, 12, 'Log out on the system with ID  ', '2023-10-21 01:44:56'),
(207, 12, 'Login on the system with ID  ', '2023-10-21 01:45:53'),
(208, 12, 'Displays Invoice Data Reports In Print Format ', '2023-10-21 01:46:01'),
(209, 12, 'Log out on the system with ID  ', '2023-10-21 01:57:33');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(4) NOT NULL,
  `id_user_pengguna` int(4) DEFAULT NULL,
  `nik` int(20) NOT NULL,
  `nama_pengguna` varchar(200) NOT NULL,
  `jk_pengguna` varchar(100) NOT NULL,
  `ttl_pengguna` varchar(200) NOT NULL,
  `no_telp_pengguna` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `tanggal_pengguna` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `id_user_pengguna`, `nik`, `nama_pengguna`, `jk_pengguna`, `ttl_pengguna`, `no_telp_pengguna`, `alamat`, `tanggal_pengguna`) VALUES
(2, 12, 1234567890, 'Jofinson Lim', 'Data has not been filled in', 'brunei, 10 october 2005', '080000000000', 'Data has not been filled in', '2023-10-16 21:28:33');

-- --------------------------------------------------------

--
-- Table structure for table `settings_website`
--

CREATE TABLE `settings_website` (
  `id_settings` int(4) NOT NULL,
  `foto` text NOT NULL,
  `text` text NOT NULL,
  `login` text NOT NULL,
  `nama_website` text NOT NULL,
  `dipakai` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings_website`
--

INSERT INTO `settings_website` (`id_settings`, `foto`, `text`, `login`, `nama_website`, `dipakai`) VALUES
(1, '1697610032_2e702b30c180fe77a357.png', 'text.png', 'bengkel.png', 'Workshop Data Collection Application', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(4) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` int(1) NOT NULL,
  `foto` text NOT NULL,
  `tanggal_user` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `level`, `foto`, `tanggal_user`) VALUES
(1, 'Admin', '3dcf34a6023633a0d92521ec9c8d5ae4', 1, '', '2023-10-16'),
(8, 'Manager', '3dcf34a6023633a0d92521ec9c8d5ae4', 2, '1697869643_82fbb13dc49740abdcaf.jpg', '2023-10-16'),
(12, 'Jofinson', '3dcf34a6023633a0d92521ec9c8d5ae4', 4, '1697870552_00e271f469feb0728528.jpeg', '2023-10-16'),
(13, 'Employee', '3dcf34a6023633a0d92521ec9c8d5ae4', 3, '', '2023-10-17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD UNIQUE KEY `BARANG` (`nama_barang`);

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_barang_keluar`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`);

--
-- Indexes for table `bengkel`
--
ALTER TABLE `bengkel`
  ADD PRIMARY KEY (`id_bengkel`),
  ADD UNIQUE KEY `NO_BENGKEL` (`no_bengkel`),
  ADD UNIQUE KEY `NAMA_BENGKEL` (`nama_bengkel`) USING HASH;

--
-- Indexes for table `invoice_service`
--
ALTER TABLE `invoice_service`
  ADD PRIMARY KEY (`id_invoice`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`),
  ADD UNIQUE KEY `NIP` (`nip`);

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id_kendaraan`);

--
-- Indexes for table `log_activity`
--
ALTER TABLE `log_activity`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `NIK` (`nik`);

--
-- Indexes for table `settings_website`
--
ALTER TABLE `settings_website`
  ADD PRIMARY KEY (`id_settings`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `USERNAME_ACC` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id_barang_keluar` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id_barang_masuk` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bengkel`
--
ALTER TABLE `bengkel`
  MODIFY `id_bengkel` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `invoice_service`
--
ALTER TABLE `invoice_service`
  MODIFY `id_invoice` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id_kendaraan` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `log_activity`
--
ALTER TABLE `log_activity`
  MODIFY `id_log` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `settings_website`
--
ALTER TABLE `settings_website`
  MODIFY `id_settings` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
