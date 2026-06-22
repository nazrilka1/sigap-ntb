-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2026 at 09:09 AM
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
-- Database: `sigap_ntb`
--

-- --------------------------------------------------------

--
-- Table structure for table `opd`
--

CREATE TABLE `opd` (
  `id_opd` int(11) NOT NULL,
  `nama_opd` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `opd`
--

INSERT INTO `opd` (`id_opd`, `nama_opd`) VALUES
(1, 'Dinas PUPR'),
(2, 'Dinas Perhubungan');

-- --------------------------------------------------------

--
-- Table structure for table `operator`
--

CREATE TABLE `operator` (
  `id` int(3) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(30) DEFAULT NULL,
  `id_opd` int(11) DEFAULT NULL,
  `nama_lengkap` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `nomor_telpon` varchar(20) DEFAULT NULL,
  `login_terakhir` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `operator`
--

INSERT INTO `operator` (`id`, `username`, `password`, `role`, `id_opd`, `nama_lengkap`, `email`, `nomor_telpon`, `login_terakhir`) VALUES
(1, 'admin12', '$2y$10$M84q3L43PMVGbaUhx9/2DOU1CckkTddR6QMIfjkVxb7PA9zhDbz7C', 'admin', NULL, 'Administrator Utama', 'admin12@ntb.go.id', '081234567890', '2026-06-22 14:48:33'),
(2, 'dispupr', '$2y$10$cjkrC.1F92R31sqygso71.WxqvyrB0.55FSf8J63Hw7A00GJBAxXy', 'opd', 1, 'Operator Dinas PUPR', 'dispupr@ntb.go.id', '082345678901', '2026-06-22 13:53:51'),
(5, 'dishub', '$2y$10$HmjlsSb0vdt9doXcS4nloOczQLJBC7opwqUF64lhcreYw.Mwtj7ba', 'opd', 2, 'Operator Dinas Perhubungan', 'dishub@ntb.go.id', '082345678901', NULL),
(6, 'admin34', '$2y$10$MvFFqdp4f.kx3sn0E/K3WO8OVLMVfPgjGaTJvb0R2xeqNg8SDGVXS', 'admin', NULL, 'Administrator', 'admin2@ntb.go.id', '082345676854', NULL),
(7, 'admin56', '$2y$10$U7QUwkzbSxQb2T7NONrRCOaK5WZidj9rSMkMeuHxcxgdfu8.1HU5i', 'admin', NULL, 'Administrator2', 'admin3@ntb.go.id', '082345676854', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id_pengaduan` int(5) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama_pelapor` varchar(50) NOT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `jenis_laporan` varchar(100) NOT NULL,
  `alamat_kejadian` text NOT NULL,
  `deskripsi_laporan` text NOT NULL,
  `bukti_file` varchar(255) NOT NULL,
  `tanggal_laporan` date DEFAULT NULL,
  `status` enum('menunggu','disetujui','ditolak') DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `id_opd` int(11) DEFAULT NULL,
  `catatan_opd` text DEFAULT NULL,
  `foto_sesudah` varchar(255) DEFAULT NULL,
  `progress_opd` enum('menunggu','sedang dikerjakan','selesai') DEFAULT NULL,
  `keterangan_progress` varchar(50) DEFAULT NULL,
  `judul_laporan` varchar(50) DEFAULT NULL,
  `kode_laporan` varchar(20) DEFAULT NULL,
  `wilayah` enum('kota mataram','kab. lombok barat','kab. lombok tengah','kab. lombok timur','kab. lombok utara','kab. sumbawa','kab. sumbawa barat','kab. bima','kab. dompu','kota Bima') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengaduan`
--

INSERT INTO `pengaduan` (`id_pengaduan`, `nik`, `nama_pelapor`, `alamat`, `jenis_laporan`, `alamat_kejadian`, `deskripsi_laporan`, `bukti_file`, `tanggal_laporan`, `status`, `latitude`, `longitude`, `id_opd`, `catatan_opd`, `foto_sesudah`, `progress_opd`, `keterangan_progress`, `judul_laporan`, `kode_laporan`, `wilayah`) VALUES
(7, '5208041546588426', 'nazril', 'lotim', 'pengaduan', 'rumbuk', 'naslfhjlasjfp;jasfjasjf', '1781924878_a0270213cedf8055.png', '2026-06-20', 'disetujui', -8.68596100, 116.12257004, 1, NULL, '1781943847_6a15beffaefef30e.png', 'sedang dikerjakan', 'nkahidhiahdo', 'nkahidhiahdo', '#NTB-2026-1008', 'kab. lombok timur');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `opd`
--
ALTER TABLE `opd`
  ADD PRIMARY KEY (`id_opd`);

--
-- Indexes for table `operator`
--
ALTER TABLE `operator`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_opd` (`id_opd`);

--
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD UNIQUE KEY `kode_laporan` (`kode_laporan`),
  ADD KEY `id_opd` (`id_opd`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `opd`
--
ALTER TABLE `opd`
  MODIFY `id_opd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `operator`
--
ALTER TABLE `operator`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id_pengaduan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `operator`
--
ALTER TABLE `operator`
  ADD CONSTRAINT `operator_ibfk_1` FOREIGN KEY (`id_opd`) REFERENCES `opd` (`id_opd`);

--
-- Constraints for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD CONSTRAINT `pengaduan_ibfk_1` FOREIGN KEY (`id_opd`) REFERENCES `opd` (`id_opd`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
