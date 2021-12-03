-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2021 at 11:53 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `c8`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `IdBarang` int(10) NOT NULL,
  `NamaBarang` varchar(50) NOT NULL,
  `Harga` int(7) NOT NULL,
  `Stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`IdBarang`, `NamaBarang`, `Harga`, `Stok`) VALUES
(1, 'PES', 5000, 8),
(12, 'Joystick', 10000, 8),
(500, 'Play Station', 100000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `NotaNo` int(11) NOT NULL,
  `IdBarang` int(11) NOT NULL,
  `banyak` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`NotaNo`, `IdBarang`, `banyak`, `jumlah`) VALUES
(1, 1, 1, 5000),
(1, 500, 1, 100000);

-- --------------------------------------------------------

--
-- Table structure for table `kasir`
--

CREATE TABLE `kasir` (
  `IdKasir` int(5) NOT NULL,
  `NamaKasir` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kasir`
--

INSERT INTO `kasir` (`IdKasir`, `NamaKasir`) VALUES
(1, 'Budi'),
(2, 'Vi'),
(3, 'Jayce');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `NIK` int(20) NOT NULL,
  `NamaPelanggan` varchar(50) NOT NULL,
  `Alamat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`NIK`, `NamaPelanggan`, `Alamat`) VALUES
(30032, 'Erikk', 'yaaa'),
(300303323, 'felix', 'yaaa'),
(300323333, 'Viktor', 'Zaun'),
(2147483647, 'Dorry', 'GG');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `NotaNo` int(11) NOT NULL,
  `NIK` int(20) NOT NULL,
  `TanggalAmbil` date NOT NULL,
  `TanggalKembali` date NOT NULL,
  `IdKasir` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`NotaNo`, `NIK`, `TanggalAmbil`, `TanggalKembali`, `IdKasir`) VALUES
(1, 2147483647, '2021-11-28', '2021-11-29', 1),
(2, 2147483647, '2021-11-29', '2021-11-30', 1),
(3, 300303323, '2021-11-30', '2021-12-01', 2),
(4, 300323333, '2021-11-30', '2021-12-01', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`IdBarang`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`NotaNo`,`IdBarang`),
  ADD KEY `FK_detail2` (`IdBarang`);

--
-- Indexes for table `kasir`
--
ALTER TABLE `kasir`
  ADD PRIMARY KEY (`IdKasir`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`NIK`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`NotaNo`),
  ADD KEY `FkTransaksi` (`NIK`),
  ADD KEY `FK_Kasir` (`IdKasir`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `NotaNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `FK_detail` FOREIGN KEY (`NotaNo`) REFERENCES `transaksi` (`NotaNo`),
  ADD CONSTRAINT `FK_detail2` FOREIGN KEY (`IdBarang`) REFERENCES `barang` (`IdBarang`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `FK_Kasir` FOREIGN KEY (`IdKasir`) REFERENCES `kasir` (`IdKasir`),
  ADD CONSTRAINT `FkTransaksi` FOREIGN KEY (`NIK`) REFERENCES `pelanggan` (`NIK`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
