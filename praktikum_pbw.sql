-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2026 at 12:48 AM
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
-- Database: `praktikum_pbw`
--

-- --------------------------------------------------------

--
-- Table structure for table `publikasi`
--

CREATE TABLE `publikasi` (
  `no` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `tanggal_rilis` date NOT NULL,
  `sampul` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publikasi`
--

INSERT INTO `publikasi` (`no`, `judul`, `tanggal_rilis`, `sampul`) VALUES
(1, 'Pengeluaran untuk Konsumsi Penduduk Papua Tengah Tahun 2025', '2026-09-01', 'cover1.webp'),
(2, 'Pengeluaran untuk Konsumsi Penduduk Papua Pegunungan Tahun 2025', '2026-09-01', 'cover2.webp'),
(3, 'Indikator Pendidikan Provinsi Papua Tengah Tahun 2025', '2026-08-28', 'cover3.webp'),
(4, 'Statistik Ekspor Impor Provinsi Papua 2025', '2026-07-30', 'cover4.webp'),
(5, 'Provinsi Papua Tengah Dalam Angka 2026', '2026-02-27', 'cover5.webp');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`) VALUES
('admin', '$2y$12$w8gJgUpKSjOLntFt5lwkJO9IuOssu16tdRcRVarWs1BFBLx/t4MBe');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `publikasi`
--
ALTER TABLE `publikasi`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `publikasi`
--
ALTER TABLE `publikasi`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
