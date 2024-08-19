-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 19, 2024 at 05:33 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pemancingan`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah_pemancing` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `tanggal`, `jumlah_pemancing`) VALUES
(1, '2024-07-05', 0),
(2, '2024-07-04', 0),
(3, '2024-07-18', 0),
(4, '2024-07-19', 25),
(5, '2024-07-27', 2),
(6, '2024-07-12', 0),
(7, '2024-07-07', 0),
(8, '2024-07-17', 1),
(9, '2024-07-20', 0),
(10, '2024-07-30', 11),
(11, '2024-07-22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `jual`
--

CREATE TABLE `jual` (
  `id_jual` int NOT NULL,
  `id_produk` int NOT NULL,
  `tanggal` date NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jual`
--

INSERT INTO `jual` (`id_jual`, `id_produk`, `tanggal`, `nama_user`, `status`) VALUES
(1, 1, '2024-07-30', 'Rahmat', 'Done'),
(2, 4, '2024-08-04', 'Azis', 'Done'),
(3, 9, '2024-08-05', 'Azis', 'Done');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `id_pelanggan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tanggal` date NOT NULL,
  `no_tiket` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `berat` decimal(10,2) DEFAULT NULL,
  `durasi` decimal(10,2) DEFAULT NULL,
  `bukti_transfer` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `id_pelanggan`, `tanggal`, `no_tiket`, `berat`, `durasi`, `bukti_transfer`, `status`) VALUES
(1, '2', '2024-07-27', '1', 3.00, NULL, 'Bukti transfer.jpeg', 'Cancel'),
(2, '2', '2024-07-27', '2', 5.00, NULL, 'Bukti transfer.jpeg', 'Fishing'),
(3, '3', '2024-07-17', '1', NULL, NULL, 'Bukti transfer.jpeg', 'Fishing'),
(4, '3', '2024-07-30', '1', 5.40, 2.56, 'Bukti transfer.jpeg', 'Fishing'),
(5, '4', '2024-07-30', '2', 5.43, 4.34, 'Bukti transfer.jpeg', 'Fishing'),
(6, '5', '2024-07-30', '3', 5.43, 4.67, 'Bukti transfer.jpeg', 'Fishing'),
(7, '6', '2024-07-30', '4', 5.00, 5.00, 'Bukti transfer.jpeg', 'Done'),
(8, '7', '2024-07-30', '5', 6.32, 5.00, 'Bukti transfer.jpeg', 'Done'),
(9, '8', '2024-07-30', '6', 3.00, 5.00, 'Bukti transfer.jpeg', 'Fishing'),
(10, '9', '2024-07-30', '7', 2.01, 5.00, 'Bukti transfer.jpeg', 'Fishing'),
(11, '10', '2024-07-30', '8', 4.32, 5.00, 'Bukti transfer.jpeg', 'Fishing'),
(12, '11', '2024-07-30', '9', 2.56, 5.00, 'Bukti transfer.jpeg', 'Fishing'),
(13, '12', '2024-07-30', '10', 4.90, 5.00, 'Bukti transfer.jpeg', 'Fishing'),
(14, '13', '2024-07-30', '11', 3.30, 5.00, 'Bukti transfer.jpeg', 'Fishing'),
(15, '3', '2024-07-31', '1', 5.40, 2.56, 'Bukti transfer.jpeg', 'Done'),
(16, '4', '2024-07-31', '2', 5.43, 4.34, 'Bukti transfer.jpeg', 'Done'),
(17, '5', '2024-07-31', '3', 5.43, 4.67, 'Bukti transfer.jpeg', 'Done'),
(18, '6', '2024-07-31', '4', 5.00, 5.00, 'Bukti transfer.jpeg', 'Done'),
(19, '7', '2024-07-31', '5', 4.43, 5.00, 'Bukti transfer.jpeg', 'Done'),
(20, '8', '2024-07-31', '6', 5.00, 5.00, 'Bukti transfer.jpeg', 'Done'),
(21, '9', '2024-07-31', '7', 5.00, 5.00, 'Bukti transfer.jpeg', ''),
(22, '10', '2024-07-31', '8', 6.00, 5.00, 'Bukti transfer.jpeg', 'Done'),
(23, '11', '2024-07-31', '9', 1.00, 5.00, 'Bukti transfer.jpeg', 'Done'),
(24, '12', '2024-07-31', '10', 5.86, 5.00, 'Bukti transfer.jpeg', 'Done'),
(25, '13', '2024-07-31', '11', NULL, NULL, 'Bukti transfer.jpeg', 'Cancel');

-- --------------------------------------------------------

--
-- Table structure for table `pemenang`
--

CREATE TABLE `pemenang` (
  `id_lomba` int NOT NULL,
  `tanggal_lomba` date NOT NULL,
  `id_user` int NOT NULL,
  `juara` int NOT NULL,
  `berat` decimal(10,2) NOT NULL,
  `durasi` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pemenang`
--

INSERT INTO `pemenang` (`id_lomba`, `tanggal_lomba`, `id_user`, `juara`, `berat`, `durasi`) VALUES
(4, '2024-07-31', 6, 1, 5.00, 3.60),
(5, '2024-07-31', 3, 2, 4.00, 5.00),
(6, '2024-07-31', 7, 3, 3.00, 5.00),
(8, '2024-07-30', 4, 1, 5.43, 4.34),
(9, '2024-07-30', 5, 2, 5.43, 4.67),
(10, '2024-07-30', 3, 3, 5.40, 2.56);

-- --------------------------------------------------------

--
-- Table structure for table `produk_jual`
--

CREATE TABLE `produk_jual` (
  `id_produk` int NOT NULL,
  `nama_produk` varchar(25) NOT NULL,
  `harga` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk_jual`
--

INSERT INTO `produk_jual` (`id_produk`, `nama_produk`, `harga`) VALUES
(1, 'Pelet Cacing', 10000),
(2, 'Pelet Susu', 20000),
(3, 'Pelet Atom', 20000),
(4, 'Essence Premium', 45000),
(9, 'Kopi Hitam', 5000);

-- --------------------------------------------------------

--
-- Table structure for table `produk_sewa`
--

CREATE TABLE `produk_sewa` (
  `id_produk` int NOT NULL,
  `nama_produk` varchar(25) NOT NULL,
  `harga` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk_sewa`
--

INSERT INTO `produk_sewa` (`id_produk`, `nama_produk`, `harga`) VALUES
(1, 'Joran Pancing Standar', 50000),
(3, 'Joran Pancing Premium', 75000),
(5, 'Bangku Santai', 50000);

-- --------------------------------------------------------

--
-- Table structure for table `sewa`
--

CREATE TABLE `sewa` (
  `id_sewa` int NOT NULL,
  `id_produk` int NOT NULL,
  `tanggal` date NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sewa`
--

INSERT INTO `sewa` (`id_sewa`, `id_produk`, `tanggal`, `nama_user`, `status`) VALUES
(5, 1, '2024-07-30', 'Candra', 'Done'),
(6, 3, '2024-08-02', 'Andri Hidayat', 'Done'),
(7, 1, '2024-08-04', 'Azis', 'Done'),
(8, 5, '2024-08-05', 'Azis', 'Done');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `email` varchar(20) NOT NULL,
  `nomor_hp` varchar(20) NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `level` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `email`, `nomor_hp`, `password`, `level`) VALUES
(1, 'Admin', 'admin@pancing.com', '0', '7815696ecbf1c96e6894b779456d330e', 2),
(2, 'Andri', 'asd@asd.com', '123123', '7815696ecbf1c96e6894b779456d330e', 1),
(3, 'Desty Nurfadilah', 'desti@asd.com', '08123321123', '7815696ecbf1c96e6894b779456d330e', 1),
(4, 'Agus', 'agus@asd.com', '081234567890', '7815696ecbf1c96e6894b779456d330e', 1),
(5, 'Budi', 'budi@asd.com', '081234567891', '7815696ecbf1c96e6894b779456d330e', 1),
(6, 'Candra', 'candra@asd.com', '081234567892', '7815696ecbf1c96e6894b779456d330e', 1),
(7, 'Dewi', 'dewi@asd.com', '081234567893', '7815696ecbf1c96e6894b779456d330e', 1),
(8, 'Eka', 'eka@asd.com', '081234567894', '7815696ecbf1c96e6894b779456d330e', 1),
(9, 'Fajar', 'fajar@asd.com', '081234567895', '7815696ecbf1c96e6894b779456d330e', 1),
(10, 'Gita', 'gita@asd.com', '081234567896', '7815696ecbf1c96e6894b779456d330e', 1),
(11, 'Hadi', 'hadi@asd.com', '081234567897', '7815696ecbf1c96e6894b779456d330e', 1),
(12, 'Indah', 'indah@asd.com', '081234567898', '7815696ecbf1c96e6894b779456d330e', 1),
(13, 'Joko', 'joko@asd.com', '081234567899', '7815696ecbf1c96e6894b779456d330e', 1),
(14, 'Owner', 'owner@pancing.com', '0', '7815696ecbf1c96e6894b779456d330e', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jual`
--
ALTER TABLE `jual`
  ADD PRIMARY KEY (`id_jual`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pemenang`
--
ALTER TABLE `pemenang`
  ADD PRIMARY KEY (`id_lomba`);

--
-- Indexes for table `produk_jual`
--
ALTER TABLE `produk_jual`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `produk_sewa`
--
ALTER TABLE `produk_sewa`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `sewa`
--
ALTER TABLE `sewa`
  ADD PRIMARY KEY (`id_sewa`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jual`
--
ALTER TABLE `jual`
  MODIFY `id_jual` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `pemenang`
--
ALTER TABLE `pemenang`
  MODIFY `id_lomba` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `produk_jual`
--
ALTER TABLE `produk_jual`
  MODIFY `id_produk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `produk_sewa`
--
ALTER TABLE `produk_sewa`
  MODIFY `id_produk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sewa`
--
ALTER TABLE `sewa`
  MODIFY `id_sewa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
