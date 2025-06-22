-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2025 at 05:56 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--
-- Error reading structure for table perpus.admin: #1932 - Table 'perpus.admin' doesn't exist in engine
-- Error reading data for table perpus.admin: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `perpus`.`admin`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--
-- Error reading structure for table perpus.anggota: #1932 - Table 'perpus.anggota' doesn't exist in engine
-- Error reading data for table perpus.anggota: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `perpus`.`anggota`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `daftar_buku`
--

CREATE TABLE `daftar_buku` (
  `id_buku` int(11) NOT NULL,
  `judul` varchar(200) DEFAULT NULL,
  `pengarang` varchar(100) DEFAULT NULL,
  `tahun_terbit` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daftar_buku`
--

INSERT INTO `daftar_buku` (`id_buku`, `judul`, `pengarang`, `tahun_terbit`, `stok`) VALUES
(1, 'kasta sang mahasiswa', 'el the jongs', 2023, 5),
(2, 'Laskar Pelangi', 'Andrea Hirata', 2005, 10),
(3, 'Negeri 5 Menara', 'Ahmad Fuadi', 2009, 7),
(4, 'Bumi', 'Tere Liye', 2014, 8),
(5, 'Ayat-Ayat Cinta', 'Habiburrahman El Shirazy', 2004, 6),
(6, 'Perahu Kertas', 'Dee Lestari', 2008, 9),
(7, 'Dilan 1990', 'Pidi Baiq', 2014, 12),
(8, 'Ronggeng Dukuh Paruk', 'Ahmad Tohari', 1982, 5),
(9, 'Sang Pemimpi', 'Andrea Hirata', 2006, 7),
(10, 'Rantau 1 Muara', 'Ahmad Fuadi', 2013, 4),
(11, 'Hujan', 'Tere Liye', 2016, 11);

-- --------------------------------------------------------

--
-- Table structure for table `daftar_pengembalian`
--
-- Error reading structure for table perpus.daftar_pengembalian: #1932 - Table 'perpus.daftar_pengembalian' doesn't exist in engine
-- Error reading data for table perpus.daftar_pengembalian: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `perpus`.`daftar_pengembalian`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `daftar_pinjaman`
--
-- Error reading structure for table perpus.daftar_pinjaman: #1932 - Table 'perpus.daftar_pinjaman' doesn't exist in engine
-- Error reading data for table perpus.daftar_pinjaman: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `perpus`.`daftar_pinjaman`' at line 1

--
-- Triggers `daftar_pinjaman`
--
DELIMITER $$
CREATE TRIGGER `kembalikan_stok_setelah_delete` AFTER DELETE ON `daftar_pinjaman` FOR EACH ROW BEGIN
    UPDATE daftar_buku
    SET stok = stok + 1
    WHERE id_buku = OLD.id_buku;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daftar_buku`
--
ALTER TABLE `daftar_buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daftar_buku`
--
ALTER TABLE `daftar_buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
