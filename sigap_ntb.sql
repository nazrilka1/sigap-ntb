-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2026 at 08:16 AM
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
  `password` varchar(30) DEFAULT NULL,
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
(1, 'admin12', '12345', 'admin', NULL, 'Administrator Utama', 'admin12@ntb.go.id', '081234567890', '2026-06-13 23:42:28'),
(2, 'dispupr', 'ntb123', 'opd', 1, 'Operator Dinas PUPR', 'dispupr@ntb.go.id', '082345678901', NULL);

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
  `status` enum('menunggu','diproses','selesai','ditolak') NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `id_opd` int(11) DEFAULT NULL,
  `catatan_opd` text DEFAULT NULL,
  `foto_sebelum` varchar(255) DEFAULT NULL,
  `foto_sesudah` varchar(255) DEFAULT NULL,
  `progress_opd` enum('sedang dikerjakan','menunggu konfirmasi','selesai') DEFAULT NULL,
  `keterangan_progress` varchar(50) DEFAULT NULL,
  `judul_laporan` varchar(50) DEFAULT NULL,
  `kode_laporan` varchar(20) DEFAULT NULL,
  `wilayah` enum('kota mataram','kab. lombok barat','kab. lombok tengah','kab. lombok timur','kab. lombok utara','kab. sumbawa','kab. sumbawa barat','kab. bima','kab. dompu','kota Bima') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengaduan`
--

INSERT INTO `pengaduan` (`id_pengaduan`, `nik`, `nama_pelapor`, `alamat`, `jenis_laporan`, `alamat_kejadian`, `deskripsi_laporan`, `bukti_file`, `tanggal_laporan`, `status`, `latitude`, `longitude`, `id_opd`, `catatan_opd`, `foto_sebelum`, `foto_sesudah`, `progress_opd`, `keterangan_progress`, `judul_laporan`, `kode_laporan`, `wilayah`) VALUES
(5, '5668231', 'irlan hadi', 'Bayan', 'pengajuan', 'desa anyar', 'tidak ada lampu', '1781001935_WhatsApp Image 2026-06-05 at 19.56.54.jpeg', '2026-06-09', '', -8.23253206, 116.42555237, 1, NULL, NULL, NULL, 'selesai', 'jalan sudah diperbaiki', 'jalan rusak', '#NTB202606Tue1735', NULL),
(6, '54361641', 'ogi harisman', 'Bayan', 'pengaduan', 'dusun dasan gerisak', 'jalan belum dirabat', '1781173852_Screenshot 2026-05-08 174938.png', '2026-06-11', 'menunggu', -8.58330000, 116.11670000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '#NTB-2026-1987', 'kab. lombok utara');

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
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id_pengaduan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
