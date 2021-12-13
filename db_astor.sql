-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2021 at 08:51 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_astor`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi_hrd`
--

CREATE TABLE `absensi_hrd` (
  `id_absensihrd` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `tglawal_absensihrd` date NOT NULL,
  `tglakhir_absensihrd` date NOT NULL,
  `file_absensihrd` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `aplikasi`
--

CREATE TABLE `aplikasi` (
  `aplikasi_id` int(11) NOT NULL,
  `nama_aplikasi` varchar(225) NOT NULL,
  `v_aplikasi` varchar(20) NOT NULL,
  `id_hidden` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aplikasi`
--

INSERT INTO `aplikasi` (`aplikasi_id`, `nama_aplikasi`, `v_aplikasi`, `id_hidden`) VALUES
(0, 'Aplikasi Admin', '1.0.0', 1),
(1, 'Surat', '1.29.12', 1),
(2, 'Sinar', '1.0.0', 1),
(3, 'KUI', '1.0.0', 1),
(4, 'HRD', '1.0.0', 1),
(5, 'ARC', '1.0.0', 1),
(6, 'Career Center', '1.0.0', 1),
(7, 'Konseling', '1.0.0', 1),
(8, 'Inbis', '1.0.0', 1),
(9, 'LPMI', '1.0.0', 1),
(10, 'Dashboard', '1.0.0', 1),
(11, 'SImaka Fo', '2.4.12', 1),
(12, 'Simaka Akademik', '2.0.0', 1),
(13, 'Simaka Dosen', '1.0.0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `asuransi`
--

CREATE TABLE `asuransi` (
  `id_asuransi` int(11) NOT NULL,
  `ket_asuransi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detail_asuransi`
--

CREATE TABLE `detail_asuransi` (
  `id` int(11) NOT NULL,
  `id_asuransi` int(11) NOT NULL,
  `id_detail_asuransi` int(11) NOT NULL,
  `status_detail_asuransi` int(1) NOT NULL,
  `masaaktif_detail_asuransi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `divisi_id` int(11) NOT NULL,
  `divisi_name` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`divisi_id`, `divisi_name`) VALUES
(1, 'UPT-SI / Server');

-- --------------------------------------------------------

--
-- Table structure for table `hidden`
--

CREATE TABLE `hidden` (
  `id_hidden` int(1) NOT NULL,
  `ket_hidden` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hidden`
--

INSERT INTO `hidden` (`id_hidden`, `ket_hidden`) VALUES
(0, 'Hidden'),
(1, 'View');

-- --------------------------------------------------------

--
-- Table structure for table `izin_hrd`
--

CREATE TABLE `izin_hrd` (
  `id_izin` int(10) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  `lama_izin` varchar(100) NOT NULL,
  `alasan` text NOT NULL,
  `acc1` int(10) NOT NULL,
  `acc2` int(10) NOT NULL,
  `status_izin` int(2) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `izin_hrd`
--

INSERT INTO `izin_hrd` (`id_izin`, `id_user`, `tgl_mulai`, `tgl_akhir`, `lama_izin`, `alasan`, `acc1`, `acc2`, `status_izin`, `tgl_dibuat`) VALUES
(31, 246, '2021-12-13', '2021-12-15', '1', 'alasan tok', 1, 1, 1, '2021-12-13 01:40:29'),
(32, 246, '2021-12-14', '2021-12-17', '2', 'alasan tok', 1, 1, 1, '2021-12-13 01:41:03');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_hrd`
--

CREATE TABLE `jadwal_hrd` (
  `id_jadwal` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `hari` int(11) NOT NULL,
  `jam` varchar(225) NOT NULL,
  `absen_tempat` varchar(225) DEFAULT NULL,
  `status_jadwal` int(11) NOT NULL,
  `id_struktural` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jadwal_hrd`
--

INSERT INTO `jadwal_hrd` (`id_jadwal`, `id_user`, `hari`, `jam`, `absen_tempat`, `status_jadwal`, `id_struktural`) VALUES
(257, 102, 1, '08:00 - 16:00', 'Kampus 2', 3, 0),
(260, 68, 1, '08:00 - 16:00', 'Kampus 1', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jenjang`
--

CREATE TABLE `jenjang` (
  `id_jenjang` int(11) NOT NULL,
  `keterangan_jenjang` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `level_id` int(11) NOT NULL,
  `level_name` varchar(50) NOT NULL,
  `id_hidden` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`level_id`, `level_name`, `id_hidden`) VALUES
(0, 'Admin', 1),
(1, 'Rektorat', 1),
(2, 'Lembaga', 1),
(3, 'F. Teknik & Desain', 1),
(4, 'F. Ekonomi & Bisnis', 1),
(5, 'test', 1),
(6, 'LPMI', 1),
(7, 'LP2M', 1),
(8, 'LPKD', 1),
(9, 'KUI', 1),
(10, 'USP', 1),
(11, 'INBIS', 1),
(17, 'Pasca Sarjana', 1),
(18, 'KUI App', 1),
(19, 'HRD Admin', 1),
(20, 'ARC app', 1),
(21, 'Career Center App', 1),
(22, 'Fasilitas', 1),
(23, 'FO', 1),
(24, 'HRD dosen', 1),
(25, 'HRD', 1),
(26, 'Akademik', 1),
(27, 'FO Admin', 1),
(28, 'Dosen', 1);

-- --------------------------------------------------------

--
-- Table structure for table `level_detail`
--

CREATE TABLE `level_detail` (
  `id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `id_urt` int(11) NOT NULL,
  `grub_id` int(11) NOT NULL,
  `id_hidden` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level_detail`
--

INSERT INTO `level_detail` (`id`, `level_id`, `id_urt`, `grub_id`, `id_hidden`) VALUES
(1, 0, 1, 0, 1),
(112, 6, 11, 2, 1),
(112, 7, 12, 3, 1),
(112, 8, 13, 4, 1),
(112, 9, 14, 5, 1),
(112, 10, 15, 6, 1),
(112, 11, 16, 7, 1),
(120, 0, 18, 0, 1),
(137, 3, 22, 8, 1),
(121, 4, 26, 12, 1),
(124, 17, 29, 15, 1),
(22, 0, 58, 0, 1),
(69, 5, 60, 16, 1),
(94, 18, 61, 17, 1),
(109, 18, 63, 17, 1),
(7, 1, 66, 1, 1),
(7, 5, 67, 16, 1),
(147, 18, 68, 17, 1),
(22, 1, 70, 1, 1),
(2, 1, 78, 1, 1),
(2, 18, 79, 17, 1),
(2, 5, 80, 16, 1),
(2, 10, 81, 6, 1),
(5, 1, 83, 1, 1),
(92, 1, 86, 1, 1),
(2, 8, 88, 4, 1),
(218, 18, 94, 17, 1),
(2, 17, 95, 15, 1),
(92, 22, 96, 21, 1),
(120, 5, 121, 16, 1),
(43, 19, 129, 23, 1),
(88, 19, 130, 23, 1),
(68, 19, 134, 24, 1),
(102, 19, 135, 25, 1),
(120, 19, 137, 26, 1),
(92, 25, 139, 27, 1),
(2, 25, 140, 27, 1),
(2, 19, 142, 18, 1),
(92, 19, 143, 18, 1),
(82, 19, 144, 18, 1),
(236, 1, 145, 1, 1),
(2, 3, 149, 8, 1),
(2, 26, 150, 28, 1),
(35, 23, 154, 22, 1),
(73, 23, 156, 22, 1),
(100, 23, 158, 22, 1),
(120, 23, 160, 22, 1),
(2, 23, 162, 29, 1),
(116, 23, 163, 29, 1),
(51, 23, 164, 29, 1),
(89, 23, 165, 29, 1),
(52, 18, 166, 17, 1),
(144, 28, 167, 30, 1),
(122, 28, 168, 30, 1),
(2, 28, 169, 30, 1),
(68, 28, 170, 30, 1),
(61, 28, 171, 30, 1),
(244, 28, 172, 30, 1),
(245, 28, 173, 30, 1),
(246, 19, 175, 26, 1),
(247, 19, 176, 23, 1),
(105, 19, 178, 24, 1),
(80, 19, 179, 31, 1),
(122, 19, 180, 32, 1),
(8, 19, 181, 33, 1),
(7, 19, 182, 33, 1),
(6, 19, 183, 34, 1);

-- --------------------------------------------------------

--
-- Table structure for table `loglogin_fo`
--

CREATE TABLE `loglogin_fo` (
  `id_loglogin` int(11) NOT NULL,
  `ket_loglogin` varchar(255) NOT NULL,
  `tgl_loglogin` varchar(255) NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loglogin_fo`
--

INSERT INTO `loglogin_fo` (`id_loglogin`, `ket_loglogin`, `tgl_loglogin`, `id_admin`) VALUES
(1, 'Login APP FO pada hari Wednesday jam 04:14:29 ', '2021-09-22', 2),
(2, 'Login APP FO pada hari Wednesday jam 04:19:32 ', '2021-09-22', 2),
(3, 'Login APP FO pada hari Wednesday jam 09:08:46 ', '2021-09-22', 2),
(4, 'Login APP FO pada hari Wednesday jam 09:16:11 ', '2021-09-22', 2),
(5, 'Login APP FO pada hari Thursday jam 08:20:01 ', '2021-09-23', 89),
(6, 'Login APP FO pada hari Thursday jam 08:30:06 ', '2021-09-23', 35),
(7, 'Login APP FO pada hari Thursday jam 08:33:08 ', '2021-09-23', 116),
(8, 'Login APP FO pada hari Thursday jam 08:37:12 ', '2021-09-23', 35),
(9, 'Login APP FO pada hari Thursday jam 09:45:22 ', '2021-09-23', 2),
(10, 'Login APP FO pada hari Thursday jam 09:47:39 ', '2021-09-23', 2),
(11, 'Login APP FO pada hari Thursday jam 09:48:41 ', '2021-09-23', 2),
(12, 'Login APP FO pada hari Thursday jam 09:57:28 ', '2021-09-23', 2),
(13, 'Login APP FO pada hari Thursday jam 10:10:10 ', '2021-09-23', 116),
(14, 'Login APP FO pada hari Thursday jam 10:22:47 ', '2021-09-23', 2),
(15, 'Login APP FO pada hari Thursday jam 10:46:51 ', '2021-09-23', 2),
(16, 'Login APP FO pada hari Thursday jam 10:47:07 ', '2021-09-23', 2),
(17, 'Login APP FO pada hari Thursday jam 11:11:10 ', '2021-09-23', 73),
(18, 'Login APP FO pada hari Thursday jam 11:27:40 ', '2021-09-23', 2),
(19, 'Login APP FO pada hari Thursday jam 02:31:51 ', '2021-09-23', 2),
(20, 'Login APP FO pada hari Thursday jam 06:40:53 ', '2021-09-23', 2),
(21, 'Login APP FO pada hari Thursday jam 06:44:09 ', '2021-09-23', 2),
(22, 'Login APP FO pada hari Friday jam 08:44:28 ', '2021-09-24', 2),
(23, 'Login APP FO pada hari Friday jam 09:36:57 ', '2021-09-24', 2),
(24, 'Login APP FO pada hari Friday jam 10:21:47 ', '2021-09-24', 2),
(25, 'Login APP FO pada hari Friday jam 10:36:18 ', '2021-09-24', 2),
(26, 'Login APP FO pada hari Friday jam 11:01:41 ', '2021-09-24', 2),
(27, 'Login APP FO pada hari Friday jam 02:24:13 ', '2021-09-24', 2),
(28, 'Login APP FO pada hari Friday jam 03:21:38 ', '2021-09-24', 2),
(29, 'Login APP FO pada hari Friday jam 03:32:14 ', '2021-09-24', 2),
(30, 'Login APP FO pada hari Saturday jam 09:15:59 ', '2021-09-25', 2),
(31, 'Login APP FO pada hari Saturday jam 11:47:21 ', '2021-09-25', 2),
(32, 'Login APP FO pada hari Saturday jam 03:47:02 ', '2021-09-25', 2),
(33, 'Login APP FO pada hari Monday jam 09:35:20 ', '2021-09-27', 2),
(34, 'Login APP FO pada hari Monday jam 11:06:12 ', '2021-09-27', 2),
(35, 'Login APP FO pada hari Monday jam 02:11:37 ', '2021-09-27', 2),
(36, 'Login APP FO pada hari Monday jam 03:11:04 ', '2021-09-27', 2),
(37, 'Login APP FO pada hari Monday jam 08:02:19 ', '2021-09-27', 2),
(38, 'Login APP FO pada hari Tuesday jam 08:26:05 ', '2021-09-28', 2),
(39, 'Login APP FO pada hari Tuesday jam 09:30:40 ', '2021-09-28', 2),
(40, 'Login APP FO pada hari Tuesday jam 10:42:33 ', '2021-09-28', 2),
(41, 'Login APP FO pada hari Tuesday jam 11:16:15 ', '2021-09-28', 51),
(42, 'Login APP FO pada hari Tuesday jam 11:17:53 ', '2021-09-28', 116),
(43, 'Login APP FO pada hari Tuesday jam 11:18:37 ', '2021-09-28', 2),
(44, 'Login APP FO pada hari Tuesday jam 11:18:44 ', '2021-09-28', 89),
(45, 'Login APP FO pada hari Tuesday jam 11:19:30 ', '2021-09-28', 100),
(46, 'Login APP FO pada hari Tuesday jam 11:29:43 ', '2021-09-28', 35),
(47, 'Login APP FO pada hari Tuesday jam 11:37:38 ', '2021-09-28', 2),
(48, 'Login APP FO pada hari Wednesday jam 08:49:59 ', '2021-09-29', 2),
(49, 'Login APP FO pada hari Wednesday jam 09:30:49 ', '2021-09-29', 2),
(50, 'Login APP FO pada hari Wednesday jam 09:40:10 ', '2021-09-29', 2),
(51, 'Login APP FO pada hari Wednesday jam 01:45:09 ', '2021-09-29', 2),
(52, 'Login APP FO pada hari Thursday jam 08:59:17 ', '2021-09-30', 2),
(53, 'Login APP FO pada hari Thursday jam 09:30:43 ', '2021-09-30', 2),
(54, 'Login APP FO pada hari Thursday jam 10:59:20 ', '2021-09-30', 2),
(55, 'Login APP FO pada hari Thursday jam 04:26:07 ', '2021-09-30', 73),
(56, 'Login APP FO pada hari Thursday jam 04:26:39 ', '2021-09-30', 35),
(57, 'Login APP FO pada hari Thursday jam 04:29:13 ', '2021-09-30', 89),
(58, 'Login APP FO pada hari Thursday jam 04:33:47 ', '2021-09-30', 89),
(59, 'Login APP FO pada hari Friday jam 09:05:47 ', '2021-10-01', 2),
(60, 'Login APP FO pada hari Friday jam 09:27:36 ', '2021-10-01', 2),
(61, 'Login APP FO pada hari Friday jam 03:07:30 ', '2021-10-01', 2),
(62, 'Login APP FO pada hari Friday jam 09:03:49 ', '2021-10-08', 2),
(63, 'Login APP FO pada hari Friday jam 09:16:18 ', '2021-10-08', 2),
(64, 'Login APP FO pada hari Friday jam 09:16:40 ', '2021-10-08', 2),
(65, 'Login APP FO pada hari Friday jam 09:19:11 ', '2021-10-08', 2),
(66, 'Login APP FO pada hari Friday jam 09:21:06 ', '2021-10-08', 120),
(67, 'Login APP FO pada hari Friday jam 09:21:10 ', '2021-10-08', 2),
(68, 'Login APP FO pada hari Friday jam 01:14:26 ', '2021-10-08', 116),
(69, 'Login APP FO pada hari Friday jam 02:47:14 ', '2021-10-08', 2),
(70, 'Login APP FO pada hari Friday jam 03:01:48 ', '2021-10-08', 2),
(71, 'Login APP FO pada hari Friday jam 03:02:55 ', '2021-10-08', 2),
(72, 'Login APP FO pada hari Friday jam 03:22:44 ', '2021-10-08', 2),
(73, 'Login APP FO pada hari Monday jam 08:21:35 ', '2021-10-11', 2),
(74, 'Login APP FO pada hari Tuesday jam 09:29:15 ', '2021-10-12', 2),
(75, 'Login APP FO pada hari Tuesday jam 02:23:04 ', '2021-10-12', 2),
(76, 'Login APP FO pada hari Tuesday jam 05:21:47 ', '2021-10-12', 89),
(77, 'Login APP FO pada hari Tuesday jam 06:45:01 ', '2021-10-12', 2),
(78, 'Login APP FO pada hari Wednesday jam 10:08:55 ', '2021-10-13', 2),
(79, 'Login APP FO pada hari Thursday jam 10:07:51 ', '2021-10-14', 2),
(80, 'Login APP FO pada hari Thursday jam 11:35:35 ', '2021-10-14', 2),
(81, 'Login APP FO pada hari Thursday jam 11:42:16 ', '2021-10-14', 2),
(82, 'Login APP FO pada hari Thursday jam 04:38:14 ', '2021-10-14', 2),
(83, 'Login APP FO pada hari Friday jam 09:36:47 ', '2021-10-15', 2),
(84, 'Login APP FO pada hari Friday jam 10:51:38 ', '2021-10-15', 2),
(85, 'Login APP FO pada hari Saturday jam 09:24:27 ', '2021-10-16', 2),
(86, 'Login APP FO pada hari Thursday jam 11:49:19 ', '2021-10-21', 2),
(87, 'Login APP FO pada hari Thursday jam 11:02:41 ', '2021-10-28', 2),
(88, 'Login APP FO pada hari Monday jam 08:40:00 ', '2021-11-01', 2),
(89, 'Login APP FO pada hari Monday jam 02:29:16 ', '2021-11-01', 116),
(90, 'Login APP FO pada hari Monday jam 02:38:54 ', '2021-11-01', 116),
(91, 'Login APP FO pada hari Monday jam 02:47:00 ', '2021-11-01', 116),
(92, 'Login APP FO pada hari Wednesday jam 08:35:19 ', '2021-11-03', 2),
(93, 'Login APP FO pada hari Wednesday jam 11:15:42 ', '2021-11-03', 2),
(94, 'Login APP FO pada hari Wednesday jam 01:12:09 ', '2021-11-03', 116),
(95, 'Login APP FO pada hari Wednesday jam 03:48:37 ', '2021-11-03', 51),
(96, 'Login APP FO pada hari Wednesday jam 06:50:33 ', '2021-11-03', 51),
(97, 'Login APP FO pada hari Wednesday jam 06:51:01 ', '2021-11-03', 51),
(98, 'Login APP FO pada hari Wednesday jam 06:53:57 ', '2021-11-03', 51),
(99, 'Login APP FO pada hari Thursday jam 09:17:20 ', '2021-11-04', 2),
(100, 'Login APP FO pada hari Thursday jam 01:59:44 ', '2021-11-04', 2),
(101, 'Login APP FO pada hari Thursday jam 02:11:23 ', '2021-11-04', 2),
(102, 'Login APP FO pada hari Thursday jam 02:13:08 ', '2021-11-04', 2),
(103, 'Login APP FO pada hari Thursday jam 06:53:24 ', '2021-11-04', 2),
(104, 'Login APP FO pada hari Friday jam 09:47:09 ', '2021-11-05', 2),
(105, 'Login APP FO pada hari Friday jam 09:47:09 ', '2021-11-05', 2),
(106, 'Login APP FO pada hari Friday jam 09:47:10 ', '2021-11-05', 2),
(107, 'Login APP FO pada hari Monday jam 09:45:08 ', '2021-11-08', 2),
(108, 'Login APP FO pada hari Monday jam 11:02:41 ', '2021-11-08', 2),
(109, 'Login APP FO pada hari Monday jam 03:18:33 ', '2021-11-08', 2),
(110, 'Login APP FO pada hari Thursday jam 03:07:06 ', '2021-11-11', 2),
(111, 'Login APP FO pada hari Friday jam 01:45:41 ', '2021-11-12', 2),
(112, 'Login APP FO pada hari Saturday jam 07:56:39 ', '2021-11-13', 51),
(113, 'Login APP FO pada hari Saturday jam 11:24:51 ', '2021-11-13', 2),
(114, 'Login APP FO pada hari Saturday jam 02:04:23 ', '2021-11-13', 2),
(115, 'Login APP FO pada hari Monday jam 09:49:52 ', '2021-11-15', 2),
(116, 'Login APP FO pada hari Monday jam 09:50:31 ', '2021-11-15', 2),
(117, 'Login APP FO pada hari Monday jam 10:28:21 ', '2021-11-15', 2),
(118, 'Login APP FO pada hari Monday jam 03:37:56 ', '2021-11-15', 2),
(119, 'Login APP FO pada hari Monday jam 05:23:39 ', '2021-11-15', 51),
(120, 'Login APP FO pada hari Tuesday jam 08:54:32 ', '2021-11-16', 2),
(121, 'Login APP FO pada hari Tuesday jam 09:51:10 ', '2021-11-16', 2),
(122, 'Login APP FO pada hari Tuesday jam 09:54:16 ', '2021-11-16', 2),
(123, 'Login APP FO pada hari Tuesday jam 02:24:09 ', '2021-11-16', 116),
(124, 'Login APP FO pada hari Tuesday jam 02:43:16 ', '2021-11-16', 2),
(125, 'Login APP FO pada hari Wednesday jam 10:43:18 ', '2021-11-17', 2),
(126, 'Login APP FO pada hari Wednesday jam 10:56:35 ', '2021-11-17', 116),
(127, 'Login APP FO pada hari Wednesday jam 12:13:16 ', '2021-11-17', 116),
(128, 'Login APP FO pada hari Wednesday jam 01:04:05 ', '2021-11-17', 116),
(129, 'Login APP FO pada hari Thursday jam 09:12:02 ', '2021-11-18', 2),
(130, 'Login APP FO pada hari Thursday jam 09:43:37 ', '2021-11-18', 2),
(131, 'Login APP FO pada hari Thursday jam 01:56:09 ', '2021-11-18', 116),
(132, 'Login APP FO pada hari Friday jam 09:11:41 ', '2021-11-19', 2),
(133, 'Login APP FO pada hari Monday jam 11:09:05 ', '2021-11-22', 2),
(134, 'Login APP FO pada hari Monday jam 12:14:35 ', '2021-11-22', 2),
(135, 'Login APP FO pada hari Monday jam 03:40:38 ', '2021-11-22', 89),
(136, 'Login APP FO pada hari Tuesday jam 08:16:50 ', '2021-11-23', 116),
(137, 'Login APP FO pada hari Tuesday jam 08:36:32 ', '2021-11-23', 116),
(138, 'Login APP FO pada hari Tuesday jam 08:37:44 ', '2021-11-23', 116),
(139, 'Login APP FO pada hari Tuesday jam 09:08:20 ', '2021-11-23', 116),
(140, 'Login APP FO pada hari Tuesday jam 10:37:59 ', '2021-11-23', 2),
(141, 'Login APP FO pada hari Tuesday jam 10:42:16 ', '2021-11-23', 2),
(142, 'Login APP FO pada hari Tuesday jam 10:51:10 ', '2021-11-23', 2),
(143, 'Login APP FO pada hari Tuesday jam 11:23:33 ', '2021-11-23', 2),
(144, 'Login APP FO pada hari Tuesday jam 01:29:41 ', '2021-11-23', 2),
(145, 'Login APP FO pada hari Tuesday jam 01:39:13 ', '2021-11-23', 2),
(146, 'Login APP FO pada hari Tuesday jam 01:43:07 ', '2021-11-23', 2),
(147, 'Login APP FO pada hari Tuesday jam 02:02:29 ', '2021-11-23', 2),
(148, 'Login APP FO pada hari Tuesday jam 02:19:32 ', '2021-11-23', 2),
(149, 'Login APP FO pada hari Tuesday jam 02:42:41 ', '2021-11-23', 116),
(150, 'Login APP FO pada hari Tuesday jam 02:56:53 ', '2021-11-23', 2),
(151, 'Login APP FO pada hari Tuesday jam 03:04:05 ', '2021-11-23', 2),
(152, 'Login APP FO pada hari Tuesday jam 03:08:35 ', '2021-11-23', 2),
(153, 'Login APP FO pada hari Tuesday jam 03:34:07 ', '2021-11-23', 2),
(154, 'Login APP FO pada hari Wednesday jam 07:46:55 ', '2021-11-24', 116),
(155, 'Login APP FO pada hari Wednesday jam 09:47:06 ', '2021-11-24', 2),
(156, 'Login APP FO pada hari Wednesday jam 10:55:06 ', '2021-11-24', 2),
(157, 'Login APP FO pada hari Wednesday jam 11:01:54 ', '2021-11-24', 2),
(158, 'Login APP FO pada hari Wednesday jam 02:25:17 ', '2021-11-24', 2),
(159, 'Login APP FO pada hari Wednesday jam 02:32:30 ', '2021-11-24', 2),
(160, 'Login APP FO pada hari Wednesday jam 02:53:17 ', '2021-11-24', 2),
(161, 'Login APP FO pada hari Thursday jam 08:33:37 ', '2021-11-25', 2),
(162, 'Login APP FO pada hari Thursday jam 09:34:19 ', '2021-11-25', 2),
(163, 'Login APP FO pada hari Thursday jam 10:36:58 ', '2021-11-25', 2),
(164, 'Login APP FO pada hari Thursday jam 02:33:22 ', '2021-11-25', 73),
(165, 'Login APP FO pada hari Thursday jam 02:35:18 ', '2021-11-25', 35),
(166, 'Login APP FO pada hari Thursday jam 02:43:02 ', '2021-11-25', 89),
(167, 'Login APP FO pada hari Friday jam 10:02:26 ', '2021-11-26', 2),
(168, 'Login APP FO pada hari Friday jam 02:11:27 ', '2021-11-26', 2),
(169, 'Login APP FO pada hari Friday jam 02:11:46 ', '2021-11-26', 73),
(170, 'Login APP FO pada hari Friday jam 02:54:39 ', '2021-11-26', 2),
(171, 'Login APP FO pada hari Friday jam 06:44:37 ', '2021-11-26', 2),
(172, 'Login APP FO pada hari Friday jam 06:46:18 ', '2021-11-26', 2),
(173, 'Login APP FO pada hari Saturday jam 09:59:54 ', '2021-11-27', 2),
(174, 'Login APP FO pada hari Saturday jam 10:01:40 ', '2021-11-27', 51),
(175, 'Login APP FO pada hari Saturday jam 10:05:21 ', '2021-11-27', 116),
(176, 'Login APP FO pada hari Saturday jam 10:18:07 ', '2021-11-27', 2),
(177, 'Login APP FO pada hari Saturday jam 11:30:58 ', '2021-11-27', 2),
(178, 'Login APP FO pada hari Saturday jam 11:45:12 ', '2021-11-27', 2),
(179, 'Login APP FO pada hari Saturday jam 11:46:02 ', '2021-11-27', 2),
(180, 'Login APP FO pada hari Saturday jam 01:43:51 ', '2021-11-27', 2),
(181, 'Login APP FO pada hari Sunday jam 10:11:08 ', '2021-11-28', 89),
(182, 'Login APP FO pada hari Monday jam 09:41:06 ', '2021-11-29', 2),
(183, 'Login APP FO pada hari Monday jam 09:43:26 ', '2021-11-29', 2),
(184, 'Login APP FO pada hari Monday jam 10:27:46 ', '2021-11-29', 2),
(185, 'Login APP FO pada hari Monday jam 10:28:18 ', '2021-11-29', 2),
(186, 'Login APP FO pada hari Monday jam 11:12:33 ', '2021-11-29', 2),
(187, 'Login APP FO pada hari Monday jam 11:31:00 ', '2021-11-29', 89),
(188, 'Login APP FO pada hari Monday jam 01:23:54 ', '2021-11-29', 2),
(189, 'Login APP FO pada hari Monday jam 01:49:58 ', '2021-11-29', 2),
(190, 'Login APP FO pada hari Monday jam 01:50:45 ', '2021-11-29', 2),
(191, 'Login APP FO pada hari Monday jam 01:52:45 ', '2021-11-29', 2),
(192, 'Login APP FO pada hari Monday jam 01:53:45 ', '2021-11-29', 2),
(193, 'Login APP FO pada hari Monday jam 02:03:49 ', '2021-11-29', 2),
(194, 'Login APP FO pada hari Monday jam 02:14:29 ', '2021-11-29', 2),
(195, 'Login APP FO pada hari Monday jam 02:14:55 ', '2021-11-29', 2),
(196, 'Login APP FO pada hari Monday jam 02:21:51 ', '2021-11-29', 116),
(197, 'Login APP FO pada hari Tuesday jam 07:51:40 ', '2021-11-30', 89),
(198, 'Login APP FO pada hari Thursday jam 10:15:43 ', '2021-12-02', 2),
(199, 'Login APP FO pada hari Thursday jam 10:16:01 ', '2021-12-02', 2),
(200, 'Login APP FO pada hari Thursday jam 10:42:28 ', '2021-12-02', 2),
(201, 'Login APP FO pada hari Friday jam 09:03:03 ', '2021-12-03', 2),
(202, 'Login APP FO pada hari Friday jam 09:08:57 ', '2021-12-03', 2),
(203, 'Login APP FO pada hari Friday jam 09:18:06 ', '2021-12-03', 2),
(204, 'Login APP FO pada hari Friday jam 09:22:43 ', '2021-12-03', 2),
(205, 'Login APP FO pada hari Friday jam 09:47:47 ', '2021-12-03', 2),
(206, 'Login APP FO pada hari Saturday jam 10:04:07 ', '2021-12-04', 2),
(207, 'Login APP FO pada hari Saturday jam 10:15:27 ', '2021-12-04', 2),
(208, 'Login APP FO pada hari Saturday jam 12:39:30 ', '2021-12-04', 89),
(209, 'Login APP FO pada hari Saturday jam 01:45:17 ', '2021-12-04', 2),
(210, 'Login APP FO pada hari Saturday jam 02:00:09 ', '2021-12-04', 2),
(211, 'Login APP FO pada hari Monday jam 07:01:06 ', '2021-12-06', 100),
(212, 'Login APP FO pada hari Monday jam 09:51:58 ', '2021-12-06', 116),
(213, 'Login APP FO pada hari Monday jam 10:07:08 ', '2021-12-06', 51),
(214, 'Login APP FO pada hari Monday jam 11:17:24 ', '2021-12-06', 2),
(215, 'Login APP FO pada hari Tuesday jam 10:04:11 ', '2021-12-07', 2),
(216, 'Login APP FO pada hari Wednesday jam 09:56:42 ', '2021-12-08', 2),
(217, 'Login APP FO pada hari Wednesday jam 10:05:31 ', '2021-12-08', 2),
(218, 'Login APP FO pada hari Wednesday jam 10:29:21 ', '2021-12-08', 2),
(219, 'Login APP FO pada hari Wednesday jam 10:32:18 ', '2021-12-08', 2),
(220, 'Login APP FO pada hari Thursday jam 09:44:54 ', '2021-12-09', 2),
(221, 'Login APP FO pada hari Thursday jam 09:48:36 ', '2021-12-09', 2),
(222, 'Login APP FO pada hari Thursday jam 10:04:21 ', '2021-12-09', 2),
(223, 'Login APP FO pada hari Thursday jam 11:29:38 ', '2021-12-09', 2),
(224, 'Login APP FO pada hari Thursday jam 03:09:25 ', '2021-12-09', 2),
(225, 'Login APP FO pada hari Thursday jam 03:37:13 ', '2021-12-09', 89),
(226, 'Login APP FO pada hari Thursday jam 04:09:44 ', '2021-12-09', 89);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` varchar(11) NOT NULL,
  `menu_name` varchar(50) NOT NULL,
  `link` varchar(100) NOT NULL,
  `sub_menu_id` varchar(11) NOT NULL,
  `aplikasi_id` int(11) NOT NULL,
  `idm` enum('grup','sub') NOT NULL,
  `id_hidden` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_name`, `link`, `sub_menu_id`, `aplikasi_id`, `idm`, `id_hidden`) VALUES
('SG001', 'Surat Masuk', '#', '', 1, 'grup', 1),
('SG002', 'Surat Keluar', '#', '-', 1, 'grup', 1),
('SG003', 'Setting', '#', '-', 1, 'grup', 1),
('SG004', 'PMB', '#', '', 11, 'grup', 1),
('SG005', 'Pengaturan', '#', '', 11, 'grup', 1),
('SG006', 'Data Pegawai', '#', '', 4, 'grup', 1),
('SG007', 'Absensi', '#', '', 4, 'grup', 1),
('SG008', 'Izin Kerja', '#', '', 4, 'grup', 1),
('SG009', 'Lembur Kerja', '#', '', 4, 'grup', 1),
('SG010', 'Jadwal Kerja', '#', '', 4, 'grup', 1),
('SG011', 'Dosen', '#', '', 4, 'grup', 1),
('SG012', 'Karyawan', '#', '', 4, 'grup', 1),
('SG013', 'Kaprodi', '#', '', 4, 'grup', 1),
('SG014', 'Dekan', '#', '', 4, 'grup', 1),
('SG015', 'Transaksi', '#', '', 11, 'grup', 1),
('SG016', 'Mahasiswa', '#', '', 11, 'grup', 1),
('SG017', 'Pembayaran', '#', '', 11, 'grup', 1),
('SG018', 'Koordinator Divisi', '#', '', 4, 'grup', 1),
('SG019', 'Izin Pegawai', '#', '', 4, 'grup', 1),
('SSG001', 'Terima Surat', 'terimasurat', 'SG001', 1, 'sub', 1),
('SSG002', 'Distrribusi Surat', 'distribusisurat', 'SG001', 1, 'sub', 1),
('SSG003', 'Buat Surat', 'suratk', 'SG002', 1, 'sub', 1),
('SSG004', 'Surat Emergensi', 'bemergency', 'SG002', 1, 'sub', 1),
('SSG005', 'History Surat Keluar', 'hsuratkeluar/0', 'SG002', 1, 'sub', 1),
('SSG006', 'Daftar Jenis Surat', 'djenis', 'SG003', 1, 'sub', 1),
('SSG007', 'Tambah Jenis Surat', 'tjenis', 'SG003', 1, 'sub', 1),
('SSG008', 'List PMB', 'tabelpmb', 'SG004', 11, 'sub', 1),
('SSG009', 'Tambah PMB', 'tambahpmb', 'SG004', 11, 'sub', 1),
('SSG010', 'Pengaturan Periode', 'settingperiode', 'SG005', 11, 'sub', 1),
('SSG011', 'Pengaturan PMB', 'settingbiayapmb', 'SG005', 11, 'sub', 1),
('SSG012', 'Pengaturan DPP', 'settingdpp', 'SG005', 11, 'sub', 1),
('SSG013', 'Pengaturan Potongan', 'settingpotongan', 'SG005', 11, 'sub', 1),
('SSG014', 'Data jadwal karyawan', 'jadwal', 'SG010', 4, 'sub', 1),
('SSG015', 'Data jadwal dosen ', 'dosJadwal', 'SG010', 4, 'sub', 1),
('SSG016', 'Buat & lihat jadwal', 'detTampil', 'SG011', 4, 'sub', 1),
('SSG017', 'Buat & lihat izin', 'buatizinDosen', 'SG011', 4, 'sub', 1),
('SSG018', 'Lembur', 'dsLembur', 'SG011', 4, 'sub', 0),
('SSG019', 'Lihat jadwal', 'jadKaryawan', 'SG012', 4, 'sub', 1),
('SSG020', 'Karyawan dan dosen', 'datPeg', 'SG006', 4, 'sub', 1),
('SSG021', 'Data Dosen', 'datDos', 'SG006', 4, 'sub', 0),
('SSG022', 'Data absensi', 'absensi', 'SG007', 4, 'sub', 1),
('SSG023', 'Data izin karyawan', 'izinKaryawan', 'SG008', 4, 'sub', 1),
('SSG024', 'Data izin dosen', 'izinDosen', 'SG008', 4, 'sub', 1),
('SSG025', 'Lembur Karyawan', 'lemburKary', 'SG009', 4, 'sub', 1),
('SSG026', 'Lembur Dosen', 'lemburDos', 'SG009', 4, 'sub', 1),
('SSG027', 'Permohonan jadwal dosen', 'pengajuanKaprodi', 'SG013', 4, 'sub', 1),
('SSG028', 'Permohonan izin dosen', 'permohonanKaprodizin', 'SG013', 4, 'sub', 1),
('SSG029', 'Permohonan jadwal dosen', 'pengajuanDekan', 'SG014', 4, 'sub', 1),
('SSG030', 'Pengaturan Biaya', 'pengaturanbiaya', 'SG005', 11, 'sub', 1),
('SSG031', 'Daftar Ulang', 'daftarulang', 'SG004', 11, 'sub', 1),
('SSG032', 'Transaksi Mahasiswa', 'transaksi', 'SG015', 11, 'sub', 1),
('SSG033', 'List Mahasiswa', 'mahasiswa', 'SG016', 11, 'sub', 1),
('SSG034', 'Grup Setting Biaya', 'pengaturanplot', 'SG005', 11, 'sub', 1),
('SSG035', 'Pembayaran Mahasiswa', 'pembayaranMhs', 'SG017', 11, 'sub', 1),
('SSG036', 'Buat & lihat izin', 'buatIzin', 'SG008', 4, 'sub', 1),
('SSG037', 'Permohonan izin', 'pengajuanIzin', 'SG008', 4, 'sub', 1),
('SSG038', 'Permohonan izin anggota', 'izinAnggota', 'SG018', 4, 'sub', 1),
('SSG039', 'Permohonan izin dosen', 'permohonanDekanizin', 'SG014', 4, 'sub', 1),
('SSG040', 'Buat & lihat izin', 'buatizinKaryawan', 'SG012', 4, 'sub', 1),
('SSG041', 'Permohonan izin pegawai', 'permohonanIzinPegawai', 'SG019', 4, 'sub', 1);

-- --------------------------------------------------------

--
-- Table structure for table `req_api`
--

CREATE TABLE `req_api` (
  `ReqApi_id` int(11) NOT NULL,
  `ReqApi_key` longtext NOT NULL,
  `ReqApi_hit` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `req_api`
--

INSERT INTO `req_api` (`ReqApi_id`, `ReqApi_key`, `ReqApi_hit`, `name`) VALUES
(1, 'ZhSaMNJDvmIlQCtYqurMDSpsmxhy1qlt', 0, 'API'),
(2, 'N5DoPQvfGnV7m/jLpswgSJMpZ1ezSiw0', 1, 'API Join Surat'),
(3, 'ZFZRM1IwbzFRMVV2ZEdONFoxcFpTRXBTTTNWcU5GQmtSa3g1UVN0dU5rWTJjM01yZDBjMlFqZFFWVDA9', 0, 'Dashboard'),
(4, 'ZhSaMNJDvmIlQCtYqurMDSpsmxhy1qlt', 0, '----'),
(5, '123', 0, 'akadmeik'),
(6, 'c3kk3h4b18nknt4wu', 1, 'Buku Tamu');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pendidikan`
--

CREATE TABLE `riwayat_pendidikan` (
  `id` int(11) NOT NULL,
  `id_riwayat_pendidikan` int(11) NOT NULL,
  `id_jenjang` int(11) NOT NULL,
  `thnmasuk_riwayat_pendidikan` int(4) NOT NULL,
  `thnkeluar_riwayat_pendidikan` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rule`
--

CREATE TABLE `rule` (
  `id_rule` bigint(11) NOT NULL,
  `aplikasi_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `id_hidden` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rule`
--

INSERT INTO `rule` (`id_rule`, `aplikasi_id`, `level_id`, `id_hidden`) VALUES
(36, 1, 1, 1),
(37, 1, 3, 1),
(38, 1, 4, 1),
(39, 1, 6, 1),
(40, 1, 7, 1),
(41, 1, 8, 1),
(42, 1, 9, 1),
(43, 1, 10, 1),
(44, 1, 11, 1),
(50, 1, 17, 1),
(53, 1, 5, 1),
(55, 3, 18, 1),
(56, 4, 19, 1),
(57, 11, 23, 1),
(58, 4, 24, 1),
(60, 1, 22, 1),
(61, 1, 25, 1),
(62, 12, 26, 1),
(63, 11, 27, 1),
(64, 13, 28, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rule2`
--

CREATE TABLE `rule2` (
  `id_rule2` int(11) NOT NULL,
  `menu_id` varchar(11) NOT NULL,
  `grub_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rule2`
--

INSERT INTO `rule2` (`id_rule2`, `menu_id`, `grub_id`) VALUES
(211, 'SG001', 1),
(212, 'SSG001', 1),
(213, 'SSG002', 1),
(224, 'SG002', 1),
(225, 'SSG003', 1),
(226, 'SSG004', 1),
(227, 'SSG005', 1),
(228, 'SG003', 1),
(229, 'SSG006', 1),
(230, 'SSG007', 1),
(231, 'SG001', 2),
(232, 'SSG001', 2),
(233, 'SSG002', 2),
(234, 'SG002', 2),
(235, 'SSG003', 2),
(236, 'SSG004', 2),
(237, 'SSG005', 2),
(238, 'SG003', 2),
(239, 'SSG006', 2),
(240, 'SSG007', 2),
(241, 'SG001', 3),
(242, 'SSG001', 3),
(243, 'SSG002', 3),
(244, 'SG002', 3),
(245, 'SSG003', 3),
(246, 'SSG004', 3),
(247, 'SSG005', 3),
(248, 'SG003', 3),
(249, 'SSG006', 3),
(250, 'SSG007', 3),
(251, 'SG001', 4),
(252, 'SSG001', 4),
(253, 'SSG002', 4),
(254, 'SG002', 4),
(255, 'SSG003', 4),
(256, 'SSG004', 4),
(257, 'SSG005', 4),
(258, 'SG003', 4),
(259, 'SSG006', 4),
(260, 'SSG007', 4),
(261, 'SG001', 5),
(262, 'SSG001', 5),
(263, 'SSG002', 5),
(264, 'SG002', 5),
(265, 'SSG003', 5),
(266, 'SSG004', 5),
(267, 'SSG005', 5),
(268, 'SG003', 5),
(269, 'SSG006', 5),
(270, 'SSG007', 5),
(271, 'SG001', 6),
(272, 'SSG001', 6),
(273, 'SSG002', 6),
(274, 'SG002', 6),
(275, 'SSG003', 6),
(276, 'SSG004', 6),
(277, 'SSG005', 6),
(278, 'SG003', 6),
(279, 'SSG006', 6),
(280, 'SSG007', 6),
(281, 'SG001', 7),
(282, 'SSG001', 7),
(283, 'SSG002', 7),
(284, 'SG002', 7),
(285, 'SSG003', 7),
(286, 'SSG004', 7),
(287, 'SSG005', 7),
(288, 'SG003', 7),
(289, 'SSG006', 7),
(290, 'SSG007', 7),
(291, 'SG001', 8),
(292, 'SSG001', 8),
(293, 'SSG002', 8),
(294, 'SG002', 8),
(295, 'SSG003', 8),
(296, 'SSG004', 8),
(297, 'SSG005', 8),
(298, 'SG003', 8),
(299, 'SSG006', 8),
(300, 'SSG007', 8),
(331, 'SG001', 12),
(332, 'SSG001', 12),
(333, 'SSG002', 12),
(334, 'SG002', 12),
(335, 'SSG003', 12),
(336, 'SSG004', 12),
(337, 'SSG005', 12),
(338, 'SG003', 12),
(339, 'SSG006', 12),
(340, 'SSG007', 12),
(361, 'SG001', 15),
(362, 'SSG001', 15),
(363, 'SSG002', 15),
(364, 'SG002', 15),
(365, 'SSG003', 15),
(366, 'SSG004', 15),
(367, 'SSG005', 15),
(368, 'SG003', 15),
(369, 'SSG006', 15),
(370, 'SSG007', 15),
(417, 'SG001', 21),
(418, 'SSG001', 21),
(419, 'SSG002', 21),
(420, 'SG002', 21),
(421, 'SSG003', 21),
(422, 'SSG004', 21),
(423, 'SSG005', 21),
(424, 'SG003', 21),
(425, 'SSG006', 21),
(426, 'SSG007', 21),
(427, 'SG004', 22),
(428, 'SSG008', 22),
(429, 'SSG009', 22),
(440, 'SG001', 16),
(441, 'SSG001', 16),
(442, 'SSG002', 16),
(443, 'SG002', 16),
(444, 'SSG003', 16),
(445, 'SSG004', 16),
(446, 'SG002', 16),
(447, 'SSG005', 16),
(448, 'SSG003', 16),
(449, 'SSG004', 16),
(450, 'SSG005', 16),
(485, 'SG011', 23),
(486, 'SSG016', 23),
(487, 'SSG017', 23),
(488, 'SSG018', 23),
(499, 'SG006', 18),
(500, 'SSG020', 18),
(501, 'SSG021', 18),
(502, 'SG007', 18),
(503, 'SSG022', 18),
(510, 'SG010', 18),
(511, 'SSG014', 18),
(512, 'SSG015', 18),
(534, 'SG011', 24),
(535, 'SSG016', 24),
(536, 'SSG017', 24),
(537, 'SSG018', 24),
(538, 'SG013', 24),
(539, 'SSG027', 24),
(540, 'SSG028', 24),
(541, 'SG011', 25),
(542, 'SSG016', 25),
(543, 'SSG017', 25),
(544, 'SSG018', 25),
(548, 'SG014', 25),
(549, 'SSG029', 25),
(550, 'SG012', 26),
(551, 'SSG019', 26),
(554, 'SG001', 27),
(555, 'SSG001', 27),
(556, 'SSG002', 27),
(557, 'SG002', 27),
(558, 'SSG003', 27),
(559, 'SSG004', 27),
(560, 'SSG005', 27),
(561, 'SG003', 27),
(562, 'SSG006', 27),
(563, 'SSG007', 27),
(564, 'SG004', 29),
(565, 'SSG008', 29),
(566, 'SSG009', 29),
(567, 'SSG031', 29),
(576, 'SG016', 22),
(577, 'SSG033', 22),
(578, 'SG005', 29),
(579, 'SSG010', 29),
(580, 'SSG011', 29),
(581, 'SSG012', 29),
(582, 'SSG013', 29),
(583, 'SSG030', 29),
(584, 'SSG034', 29),
(585, 'SG016', 29),
(586, 'SSG033', 29),
(593, 'SG008', 18),
(594, 'SSG023', 18),
(595, 'SSG024', 18),
(596, 'SG017', 29),
(597, 'SSG035', 29),
(598, 'SG018', 25),
(599, 'SSG038', 25),
(600, 'SG012', 31),
(601, 'SSG019', 31),
(602, 'SSG040', 31),
(603, 'SG018', 31),
(604, 'SSG038', 31),
(605, 'SG011', 32),
(606, 'SSG016', 32),
(607, 'SSG017', 32),
(608, 'SSG018', 32),
(609, 'SG018', 32),
(610, 'SSG038', 32),
(611, 'SG019', 33),
(612, 'SSG041', 33),
(613, 'SG019', 34),
(614, 'SSG041', 34);

-- --------------------------------------------------------

--
-- Table structure for table `struktural`
--

CREATE TABLE `struktural` (
  `id` int(11) NOT NULL,
  `id_rektor` int(11) NOT NULL,
  `rektor_id` varchar(20) NOT NULL,
  `ketkode_rektor` varchar(255) NOT NULL,
  `rektor_name` varchar(255) NOT NULL,
  `nidn_rektor` varchar(50) NOT NULL,
  `level_id` int(11) NOT NULL,
  `p1_rekto` text NOT NULL,
  `p2_rekto` text NOT NULL,
  `id_hidden` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `struktural`
--

INSERT INTO `struktural` (`id`, `id_rektor`, `rektor_id`, `ketkode_rektor`, `rektor_name`, `nidn_rektor`, `level_id`, `p1_rekto`, `p2_rekto`, `id_hidden`) VALUES
(1, 0, 'peg', 'pegawai', 'pegawai', '09', 0, 'a', 'a', 1),
(6, 1, 'R.0', 'Rektor', 'Risa Santoso, B.A, M. Ed', '0727109203', 1, '01-01-2020', '01-01-2025', 1),
(7, 2, 'R.1', 'Wakil Rektor I', 'Dr. Fathorrahman, S.E., M.M.', '0720097401', 1, '01-01-2020', '01-01-2025', 1),
(8, 3, 'R.2', 'Wakil Rektor II', 'Dr. Tin Agustina Karnawati, S.E., M.M.', '0617086601', 1, '01-01-2020', '01-01-2025', 1),
(9, 4, 'R.3', 'Wakil Rektor III', 'Muhammad Rofiq, S.T., M.T.', '0719117902', 1, '01-01-2020', '01-01-2025', 1),
(10, 5, 'R.4', 'Wakil Rektor IV', 'Ir. Teguh Widodo, M.M.', '0701046504', 1, '01-01-2020', '01-01-2025', 1),
(30, 6, 'LPMI', 'Ketua LPMI', 'Danang Arbian Sulistyo, S.ST', '0708058501', 6, '2020-11-30', '2020-11-30', 1),
(42, 7, 'LP2M', 'Ketua LP2M', 'Dr. Ike Kusdyah R., SE, MM', '0703117101', 7, '2020-11-30', '2020-11-30', 1),
(74, 8, 'LPKD', 'Ketua LPKD', 'Lia Farokhah, S.Kom, M.Eng', '0710089002', 8, '2020-11-30', '2020-12-12', 0),
(94, 9, 'KUI', 'Ketua KUI', 'Nur Lailatul Aqromi, SS, MA', '0716068801', 9, '2020-11-30', '2020-12-12', 1),
(97, 10, 'INBIS', 'Ketua INBIS', 'Puji Subekti, S.Si, M.Si', '0708028801', 11, '2020-11-30', '2020-12-12', 1),
(88, 11, 'FEB', 'Dekan FEB', 'Murtianingsih, SE, MM', '0712087803', 4, '2020-11-30', '2020-12-12', 1),
(18, 12, 'USP', 'Ketua USP', 'Adriani Kala\'lembang, S.Kom, MM', '0720039001', 10, '2020-11-30', '2020-12-12', 1),
(102, 13, 'FTD', 'Dekan FTD', 'Rina Dewi Indahsari, S.Kom, M.Kom', '0730128201', 3, '2020-11-30', '2020-12-12', 1),
(68, 14, 'FTD', 'Kaprodi TI', 'Jaenal Arifin, S.Kom, MM, M.Kom', '0709117502', 3, '2020-12-02', '2025-12-02', 0),
(61, 15, 'FTD', 'Kaprodi DKV', 'Handry Rochmad Dwi Happy, S.Sn, M.Sn', '0725088706', 3, '2020-12-03', '2025-12-03', 0),
(105, 16, 'FTD', 'Kaprodi SK', 'Samsul Arifin, S.ST, M.Kom', '0711108601', 3, '2020-12-03', '2025-12-03', 0),
(71, 17, 'FEB', 'Kaprodi Akuntansi', 'Justita Dura, SE, M.Ak', '0703038701', 4, '2020-12-03', '2025-12-03', 0),
(77, 18, 'FEB', 'Kaprodi Manajemen', 'Lussia Mariesti Andriany, SE, MM', '0711038801', 4, '2020-12-03', '2025-12-03', 0),
(46, 19, 'S2-MM', 'Direktur Pascasarjana', 'Dr. Yunus Handoko, SE, MM', '0728126904', 17, '2020-12-03', '2025-12-03', 1),
(41, 20, 'S2-MM', 'Wakil Direktur Pascasarjana', 'Dr. H.M. Bukhori, SE,S.Ag, MM', '0701027102', 17, '2020-12-03', '2025-12-03', 1),
(43, 21, 'S2-MM', 'Kaprodi Pascasarjana', 'Dr. Theresia Pradiani, SE, MM', '0519097202', 17, '2020-12-03', '2025-12-03', 1),
(139, 114, 'LPMI', 'Sekretaris LPMI', 'Yudistira Arya Sapoetra, S.Kom, MM', '0704088601', 6, '2020-12-17', '2025-12-17', 1),
(21, 119, 'LPMI', 'Anggota LPMI', 'Ahmad Nizar Yogatama, SE, MM', '0716019002', 6, '2020-12-17', '2025-12-17', 1),
(54, 120, 'LPMI', 'LPMI Tingkat FTD', 'Fadli Almuini Ahda, S.Kom, M.Kom', '0716088603', 6, '2020-12-17', '2025-12-17', 1),
(145, 121, 'LPMI', 'LPMI Tingkat FEB', 'Wa Ode Irma Sari, S.Ak., M.SA', '', 6, '2020-12-17', '2025-12-17', 1),
(75, 122, 'LP2M', 'Ketua Bidang Penelitian', 'Lilis Widayanti, S.Pd, M.Pd', '0712068904', 7, '2020-12-17', '2025-12-17', 1),
(134, 123, 'LP2M', 'Ketua Bidang Pengabdian', 'Widya Adhariyanty Rahayu, S.Pd, M.Pd', '0724078801', 7, '2020-12-17', '2025-12-17', 1),
(20, 124, 'LP2M', 'Ketua Bidang Publikasi', 'Agus Purnomo Sidi, S.Sos, MM', '0710087902', 7, '2020-12-17', '2025-12-17', 1),
(87, 125, 'LPKD', 'Sekretaris LPKD', 'Mulyaningtyas, SE, M.Ak', '0727077405', 8, '2020-12-17', '2025-12-17', 0),
(109, 126, 'KUI', 'Sekretaris KUI', 'Siti Nurul Afiyah, S.Si, M.Si', '0710118801', 9, '2020-12-17', '2025-12-17', 1),
(25, 127, 'USP', 'Sekretaris USP', 'Azwar Riza Habibi, S.Si, M.Si', '0702088902', 10, '2020-12-17', '2025-12-17', 1),
(84, 128, 'INBIS', 'Sekretaris INBIS', 'Mega Mirasaputri Cahyanti, SE., MM., M.Sc', '0715069001', 11, '2020-12-17', '2025-12-17', 1),
(142, 129, 'INBIS', 'Anggota INBIS', 'Abdulloh Eizzi Irsyada, S.Kom, M.Ds', '0703069102', 11, '2020-12-17', '2025-12-17', 1),
(141, 132, 'LP2M', 'Pimpinan Redaksi JITIKA', 'Abd Hadi, S.Kom, M.Kom', '0727078810', 7, '2020-12-22', '2025-12-22', 1),
(142, 134, 'LP2M', 'Pimpinan redaksi JESKOVSIA', 'Abdulloh Eizzi Irsyada, S.Kom, M.Ds', '0703069102', 7, '2020-12-22', '2025-12-22', 1),
(20, 135, 'LP2M', 'Pimpinan redaksi JIBEKA', 'Agus Purnomo Sidi, S.Sos, MM', '0710087902', 7, '2020-12-22', '2025-12-22', 1),
(21, 136, 'LP2M', 'Pimpinan redaksi JPM', 'Ahmad Nizar Yogatama, SE, MM', '0716019002', 7, '2020-12-22', '2025-12-22', 1),
(68, 137, 'KP-INF', 'Kaprodi TI', 'Jaenal Arifin, S.Kom, MM, M.Kom .', '0709117502', 3, '2021-02-10', '2025-02-10', 1),
(61, 138, 'KP-DKV', 'Kaprodi DKV', 'Handry Rochmad Dwi Happy, S.Sn, M.Sn', '0725088706', 3, '2021-02-10', '2025-02-10', 1),
(105, 139, 'KP-SK', 'Kaprodi SK', 'Samsul Arifin, S.ST, M.Kom', '0711108601', 3, '2021-02-10', '2025-02-10', 1),
(71, 141, 'KP-AK', 'Kaprodi Akuntansi', 'Justita Dura, SE, M.Ak', '0703038701', 4, '2021-02-10', '2025-02-10', 1),
(77, 142, 'KP-PMB', 'Kaprodi Bisnis Manajemen', 'Lussia Mariesti Andryani, SE, MM', '0711038801', 4, '2021-02-10', '2025-02-10', 1),
(7, 143, 'SENAT', 'Ketua Senat', 'Dr. Fathorrahman, S.E., M.M.', '0720097401', 1, '2021-02-10', '2025-02-10', 1),
(8, 144, 'SENAT', 'Sekretaris Senat', 'Dr. Tin Agustina Karnawati, S.E., M.M.', '0617086601', 1, '2021-02-10', '2025-02-10', 1),
(87, 145, 'LPKD', 'Ketua LPKD', 'Mulyaningtyas, SE, M.Ak', '0727077405', 8, '2021-03-17', '2025-03-17', 1),
(76, 146, 'LPKD', 'Sekretaris LPKD', 'Lukman Hakim, S.Si, M.Si', '0712068904', 8, '2021-03-17', '2025-03-17', 1),
(82, 147, 'HRD', 'HRD', 'Mahindra Mandala Putra, SH', '', 25, '2021-05-08', '2030-05-08', 1),
(82, 148, 'Fasilitas', 'Fasilitas', 'Mahindra Mandala Putra, SH', '', 22, '2021-05-08', '2030-05-08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_entity`
--

CREATE TABLE `user_entity` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `user_name` varchar(225) NOT NULL,
  `user_password` longtext NOT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `tgl_keluar` date DEFAULT NULL,
  `user_pass_def` longtext DEFAULT NULL,
  `alamat` varchar(225) DEFAULT NULL,
  `alamat_sekarang` varchar(255) DEFAULT NULL,
  `no_hp` varchar(14) DEFAULT NULL,
  `tempat` varchar(225) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` int(2) DEFAULT NULL,
  `nidn` varchar(50) DEFAULT NULL,
  `no_ktp` varchar(20) DEFAULT NULL,
  `status_nikah` int(11) DEFAULT NULL,
  `posisi1` varchar(50) DEFAULT NULL,
  `posisi2` varchar(50) DEFAULT NULL,
  `jabatan` varchar(225) DEFAULT NULL,
  `koordinator` int(2) NOT NULL,
  `jurusan_dosen` varchar(225) DEFAULT NULL,
  `status_dosen` varchar(225) DEFAULT NULL,
  `kode_dosen` varchar(225) NOT NULL,
  `bpjs_kesehatan` int(1) DEFAULT NULL,
  `masa_aktif_kesehatan` date DEFAULT NULL,
  `bpjs_ketenagakerjaan` int(1) DEFAULT NULL,
  `masa_aktif_ketenagakerjaan` date DEFAULT NULL,
  `jenjang` varchar(255) DEFAULT NULL,
  `foto` longtext DEFAULT NULL,
  `id_hidden` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_entity`
--

INSERT INTO `user_entity` (`id`, `user_id`, `user_name`, `user_password`, `tgl_masuk`, `tgl_keluar`, `user_pass_def`, `alamat`, `alamat_sekarang`, `no_hp`, `tempat`, `tanggal_lahir`, `jenis_kelamin`, `nidn`, `no_ktp`, `status_nikah`, `posisi1`, `posisi2`, `jabatan`, `koordinator`, `jurusan_dosen`, `status_dosen`, `kode_dosen`, `bpjs_kesehatan`, `masa_aktif_kesehatan`, `bpjs_ketenagakerjaan`, `masa_aktif_ketenagakerjaan`, `jenjang`, `foto`, `id_hidden`) VALUES
(1, 'admin', 'UPTSI', 'U0ZCTU1tUjVORkI1VTNsME16bGFWbUpMT0U1RVdrTktNRmt4V0dZNWJtWmhieTg1U0ZwbmJWbEVNRDA9', '2021-01-27', NULL, '4514expert', '', '', '12345678901', '', NULL, 0, '00112313', '0', 0, 'Karyawan', NULL, 'Programmer', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(2, 'usertester', 'user haiyo', 'TTNselExZ3hZbGxaY0VSTE1rZGpNU3MyY1ZWT1NFRXpUWGxxY0VSd2NrMWFNak5qT1RNemVUTnVRVDA9', '2021-02-15', NULL, '4514expert', 'kota Malang', 'malang', '1234', 'Malang 4', NULL, 1, '012', '1234', 0, 'Dosen LB', 'UPT-SI s', 'staff ', 0, 'p', 'p', 'KDUser01p', 0, '2021-01-15', 1, '2021-04-14', 'S1', '1618551389.jpg', 1),
(5, 'adminrektoratasia', 'adminrektoratasia', 'WmxNdmFTdFdOelUyWld4NE5XTlNMelpaVjNsSllWZG1TM0Z0UVUxS2MwaEVjbkptUW5Vd1QydGthejA9', '2021-01-27', NULL, 'rektorat4514', '', '', '0', '', NULL, 0, '0032312312', '0', 0, 'Karyawan', 'Admin Rektorat', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(6, '1000', 'Risa Santoso, B.A, M. Ed', 'Ym01cFFYQjRZMFI1ZEhCRVEyMXVLMFUwZGtkQ05rUmFaVmszUXk5amVXSlJjazFyZGtFNWJHVlBRVDA9', '2021-02-03', NULL, 'pvSur9hK', '', '', '0', '', NULL, 0, '0727109203', '0', 0, 'Dosen FEB', 'Rektorat', 'Rektor', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(7, '1002', 'Dr. Fathorrahman, S.E., M.M.', 'TUc5MGJHeDBhbXBzVVc0clJuTTFjMHAxTUdwRWVUWnBUMGMzU1ZKRlJIaGhUM2xJZFd4alFXeFhjejA9', '2021-03-05', NULL, 'WDre2j4f', '', '', '0', '', NULL, 0, '0720097401', '0', 0, 'Dosen FEB', 'Rektorat', 'Wakil Rektor I', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(8, '1007', 'Dr. Tin Agustina Karnawati, S.E., M.M.', 'VVhsalpUQTJWQzlPY0d4dU5reFpSSFpyZVRsUlkyRnFiRGRyYURCcWMwWnVZMUYxVlZSU0wxZEtiejA9', '2021-01-27', NULL, 'WDsEZP6z', '', '', '0', '', NULL, 0, '0617086601', '0', 0, 'Dosen FEB', 'Rektorat', 'Wakil Rektor II', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(9, '1010', 'Muhammad Rofiq, S.T., M.T.', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, '8NngJedg', '', '', '0', '', NULL, 0, '0719217902', '0', 0, 'Dosen FTD', 'Rektorat', 'Wakil Rektor III', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(10, '1003', 'Ir. Teguh Widodo,M.M.', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'CEBfmq3t', '', '', '0', '', NULL, 0, '0701046504', '0', 0, 'Dosen FEB', 'Rektorat', 'Wakil Rektor IV', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(17, '1027', 'Aditya Hermawan, SE Ak, MSA', 'Y0dGemMzZHZjbVE9', '2021-01-27', '1001-01-01', '0s1jxWC2', '-', '-', '0', '-', '2021-12-11', 0, '0710108203', '0', 0, 'Dosen FEB', '-', '', 0, 'Akuntansi', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 2', '', 1),
(18, '3222', 'Adriani Kala\'lembang, S.Kom, MM', 'Y0dGemMzZHZjbVE9', '2021-03-13', NULL, 'yCGChjy9', '', '', '0', '', NULL, 0, '0720039001', '0', 0, 'Dosen FTD', 'USP', 'Kepala USP', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(19, '3202', 'Agung Basuki', 'YVRaV2NYZHBjMEpJTUM4eWVYRkNRbWhxUlZFMmVEUnlZa2RDYzFKeE9GcDJTbVZNT1RONlZ6bERNRDA9', '2015-05-01', NULL, 'kcRef8FX', 'Jl. Sawojajar XVII B/59 RT 1 RW 4 Kel. Sawojajar Kec. Kedungkandang Malang', 'Jl. Sawojajar XVII B/59 RT 1 RW 4 Kel. Sawojajar Kec. Kedungkandang Malang', '081615620035', 'Malang', '1977-03-06', 0, '', '3573030603770010', 0, 'Karyawan', 'Security', '', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'SMA', '', 1),
(20, '3219', 'Agus Purnomo Sidi, S.Sos, MM', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'CxhrK5Fz', '-', '-', '0', '-', '2021-09-30', 0, '0710087902', '0', 0, 'Dosen FEB', 'LP2M', 'Sekprodi Profesional Bisnis Manajemen', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 2', '', 1),
(21, '3216', 'Ahmad Nizar Yogatama, SE, MM', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, '6Hg5HprC', '', '', '0', '', NULL, 0, '0716019002', '0', 0, 'Dosen FEB', 'LPMI', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(22, 'wildan', 'Ahmad Wildam Yanuar Ishaq, S.Kom', 'VTJaaVozbGtiRmhMU0VGeWQxaHBPRWhKZVU5U01IZFRaa3BrUVc0clUxaExkMXBJU1RkRE0yZ3daejA9', '2021-02-11', NULL, 'wildanmanis', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'UPT-SI', 'Programmer', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(23, '3228', 'Ahmadi, SE', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, '9Jnf9AqQ', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Marketing', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(24, '3095', 'Aris Prasteyo', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'HTYrxqD4', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Office Boy', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(25, '3213', 'Azwar Riza Habibi, S.Si, M.Si', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'jdXnSf77', '', '', '0', '', NULL, 0, '0702088902', '0', 0, 'Dosen FTD', 'USP', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(26, '1011', 'Bambang Tri Wahjo Utomo, S.Kom', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, '9xKH3rW3', '', '', '0', '', NULL, 0, '0724067203', '0', 0, 'Dosen FTD', '', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(27, '1012', 'Broto Poernomo Tri Prasetyo, S.Kom, M.Kom', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'CW1pceQp', '', '', '0', '', NULL, 0, '0713068102', '0', 0, 'Dosen FTD', '', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(28, '1029', 'Budi Santoso, B.Eng', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'uu6VFA7G', '', '', '0', '', NULL, 0, '0708117301', '0', 0, 'Dosen FTD', 'HAKI', 'Kepala HAKI', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(29, '3094', 'Candra Prasetyo', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'tW6eeK9B', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Office Boy', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(30, '3227', 'Danang Arbian Sulistyo, S.ST', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'NzCc4B7W', '', '', '0', '', NULL, 0, '0708058501', '0', 0, 'Dosen FTD', 'LPMI', 'Kepala LPMI', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(31, '9803', 'Dendik Wahyu Prasongko, S.Kom', 'Y0dGemMzZHZjbVE9', '2021-01-27', '1001-01-01', 'w1WXAbxY', 'DS KUNJANG KEC KUNJANG KAB KEDIRI', 'JL BENDUNGAN SUTAMI 334/1A LOWOKWARU ', '089609425027', 'KEDIRI', '1995-05-24', 0, '', '3506212405950001', 0, 'Karyawan', 'UPT-SI', 'Sistem Informasi', 0, 'null', 'null', '', 2, '2021-03-07', 1, '2021-07-15', 'Strata 1', '', 1),
(32, '3710', 'Devy Lelyana Ratnasari', 'U1RSTE4xVkJLMVozVjNWc1NUTnZNRVpqU1ZkMk5HWkpPRE5JYzJaUVRYSkVSVEZvTVRkMGEzaHZZejA9', '2021-01-27', NULL, 'jwTRVE2M', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Kemahasiswaan', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(33, '1053', 'Dewi Wahyuni, A.Md', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'Yf3h3yT1', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'BAA', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(34, '3056', 'Didik Purwanto', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'xmvzC1uE', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Office Boy', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(35, '3121', 'Dinasti Mahachakri Laksono Suryo Putri, SH', 'TVU1T2RqQlBSVWcxVTFaNWNHWnpaMHRxVFZsYVVqUnZXWE5oVGxkRFNHdFdWa2czY1VKTFoyUmxVVDA9', '2021-01-27', NULL, 'tbCEH2a7', '', '', '0', 'Kediri', '1984-10-04', 1, '', '0', 2, 'Karyawan', 'Front Office', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(36, '3721', 'Dinda Rachman Permatasari, S.Psi', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'W6jACpX1', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Admin Rektorat', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 0),
(37, '3718', 'Doni Ssetiawan', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, '19NRhNTN', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan ', 'Security', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(38, '1071', 'Donny Poeryan Setyawan', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'M1nss3nj', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Marketing', '', 1, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(39, '1006', 'Dr. Agus Rahman Alamsyah, S.Pd, MM', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, '6u6JucfM', '', '', '0', '', NULL, 0, '0708087803', '0', 0, 'Dosen FEB', 'Pasca Sarjana', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(41, '1023', 'Dr. H.M. Bukhori, SE,S.Ag, MM', 'Y0dGemMzZHZjbVE9', '2021-01-27', '1001-01-01', 'CbuBeVw3', '-', '-', '0', '-', '2021-12-11', 0, '0701027102', '0', 0, 'Dosen FEB', 'Pasca Sarjana', '', 0, 'Magister Management', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 3', '', 1),
(42, '1038', 'Dr. Ike Kusdyah R., SE, MM', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'GxaxJ623', '', '', '0', '', NULL, 0, '0703117101', '0', 0, 'Dosen FEB', 'LP2M', 'Kepala LP2M', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(43, '3097', 'Dr. Theresia Pradini, SE, MM', 'Y214dGJXVkJlRlZZVlZkUmNIVjFWa05XYWxwcVVsaEtPVkYxVW5ST1dHUXdWbHB1TW1WSk1FUnliejA9', '2021-01-27', NULL, '7Ym93uUS', '', '', '0', '', NULL, 0, '0519097202', '0', 0, 'Dosen FEB', 'Pasca Sarjana', 'Kaprodi S2 MM', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(45, '1036', 'Dr. Widi Dewi Ruspitasari, SE, MM', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'Hs1Uz2e3', '', '', '0', '', NULL, 0, '0703088103', '0', 0, 'Dosen FEB', '', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(46, '1001', 'Dr. Yunus Handoko, SE, MM', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'r40ZkMkq', '', '', '0', '', NULL, 0, '0728126904', '0', 0, 'Dosen FEB', 'Pasca Sarjana', 'Direktur Pascasarjana', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(47, '1056', 'Dwi Anggih Yosepta, S.Kom', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'pfmZsSY7', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'BAA', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(48, '1093', 'Dwi Rudijanto', 'Y0dGemMzZHZjbVE9', '2021-01-27', '1001-01-01', '0YY6tsQ2', '-', '-', '0', '-', '2021-12-12', 0, '', '0', 0, 'Karyawan', 'Office Boy', '', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'SMA', '', 1),
(49, '3711', 'El Salwa Sabila', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'U5XPaEcK', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'MDS', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(50, '3031', 'Endri Wibowo', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'KHRwK3PY', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Office Boy', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(51, '3113', 'RISTI', 'YVdoMk1razNOMlJUV25WdWVtWjZaak5FYjNSYU1tVkJZMWwyWVdacGJWcEpkSEpNYzJoRGNHaFNiejA9', '2021-01-27', NULL, '3528DfZf', '', '', '85755111905', 'Malang', '1991-12-25', 1, '', '0', 0, 'Karyawan', 'Front Office', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(52, '1068', 'Ervina Yuli Estutik, SE', 'TnpoMWFHdHBaRVpFTUdoWFRqTnVUVkZ6TldFeGJUSjFjVFZMVkVRMVlVdGtlV1JrUzBsbU9FZFZNRDA9', '2021-01-27', '1001-01-01', 'u0b8MNWR', '-', '-', '0', '-', '2021-12-13', 0, '', '0', 0, 'Karyawan', 'MDS', '', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 1', '', 1),
(53, '3099', 'Fabianus Vesalius Lawalu, S.Pt', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'B37fKKvX', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Security', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(54, '3080', 'Fadhli Almu Iini Ahda, S.Kom, M.Kom', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, '0ej3M0ZZ', '', '', '0', '', NULL, 0, '0716088603', '0', 0, 'Dosen FTD', 'LPMI', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(55, '4012', 'Fadilla Cahnyaningtyas, SE, MSA', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'PKvj48QA', '', '', '0', '', NULL, 0, '0723108801', '0', 0, 'Dosen FEB', 'Prodi', 'Sekprodi Akuntansi', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(56, '3209', 'Faldi Hendrawam, S.Pd, MA', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, '7qz6sNxX', '', '', '0', '', NULL, 0, '0726038704', '0', 0, 'Dosen FTD', 'Prodi', 'Sekprodi Desain Komunikasi Visual', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(57, '3072', 'Feri Slamet Budiyono', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'Z84EH3By', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Office Boy', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(58, '4005', 'Fransiska Sisilia Mukti, ST, MT', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'vcpR4ZDY', '', '', '0', '', NULL, 0, '0728099004', '0', 0, 'Dosen FTD', 'UPT-NET', 'Kabag. UPT-Net', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(59, '1046', 'H. Zainul Muchlas, SE, MM', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, '86Rx2ahc', '', '', '0', '', NULL, 0, '0729095501', '0', 0, 'Dosen FEB', '', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(60, '1094', 'Handoko', 'Y0dGemMzZHZjbVE9', '2021-01-27', '1001-01-01', 'Wu4subWB', '-', '-', '0', '-', '2021-12-12', 0, '', '0', 0, 'Karyawan', 'Office Boy', 'Karyawan Umum', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'SMA', '', 1),
(61, '3224', 'Handry Rochmad Dwi Happy, S.Sn, M.Sn', 'VTNRMFYwdEVhRFJ5VVVJNWJXMWFNMUZTYTBGcU0wbFdVVU5oUmpsMGJGcFJLelZLV2tselRWVnlORDA9', '2021-01-27', NULL, 'kd4ACtyk', '', '', '0', '', NULL, 0, '0725088706', '0', 0, 'Dosen FTD', 'Prodi', 'Kaprodi Desain Komunikasi Visual', 0, '', '', 'HAN01', NULL, NULL, NULL, NULL, '', '', 1),
(62, '1078', 'Hariyono M Irsyad', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'hJgf43Bq', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Security', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(63, '1114', 'Helmy Sundoro', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'XH2pmpRR', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Marketing', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(64, '3096', 'I Gusti Ngurah Ketut Atmajaya', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, '9hRjRUxt', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Teknisi', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(65, '3034', 'Imam Khambali', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'KvPYpK53', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Office Boy', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(66, '3720', 'Indra Gunawan', 'Y0dGemMzZHZjbVE9', '2021-03-12', NULL, 'mDd4ZacM', 'Tempat', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'MDS', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(67, '3203', 'Iqbal Khodami', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, '4mezs54P', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Security', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(68, '1013', 'Jaenal Arifin, S.Kom, MM, M.Kom .', 'VEdwRFNuWXhObmhHVGt4WFdtOWtURU5UUVdGeE5rTXJTRUpXVFhWaFNtbGhUalU0T1RaaFRXWnJNRDA9', '2021-01-27', NULL, '4Jp5EEUp', 'keperluan test', 'keperluan test', '0', 'keperluan test', '2021-07-23', 0, '0709117502', '0', 0, 'Dosen FTD', 'Prodi', 'Kaprodi Teknik Informatika', 0, 'Teknik Informatika', 'Full', 'JAE01', 0, '1001-01-01', 0, '1001-01-01', 'Strata 2', '', 1),
(69, '3722', 'Jhonathan Afrizal', 'YWpkNk9HWkdLMDVKVTJsd2NuWktURlJHY0VwWU5XMW1NRlJHYXpSWk5VZG5hamg0UzNaek1FcEpSVDA9', '2020-08-01', NULL, '6ecFaxM6', 'Bali', 'Malang', '83111038848', 'Probolinggo', '2001-06-16', 0, '', '3573041606010011', 1, 'Karyawan', 'UPT-SI', 'Programmer', 0, '', '', '', 0, '1001-01-01', 0, '1001-01-01', 'SMA', '', 1),
(70, '3719', 'Joko Purnomo', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'Wuf49QXk', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Security', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(71, '3214', 'Justita Dura, SE, M.Ak', 'WmpSa01tVlZXalF3T1hVd2VFWnRUVXRPWkZObWEwRlFRMHBzV205eU9ITk9lRlJ3VGtseVlUZzNiejA9', '2021-01-27', NULL, '4B2pc9ps', '', '', '0', '', NULL, 0, '0703038701', '0', 0, 'Dosen FEB', 'Prodi', 'Kaprodi Akuntansi', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(72, '1091', 'Kuncoro', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'wCZrN3gB', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Security', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(73, '3715', 'Lailla Dwi Riski', 'VkVjck9FZHNVbGwyYTBvemR6SjFjVTV2ZFVkR1QzSXZVbmRvYm5kcU5YUktjbXhYUkcxYVIyd3JORDA9', '2021-01-27', NULL, 'CDrWraT8', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Front Office', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(74, '3223', 'Lia Farokhah, S.Kom, M.Eng', 'UlU5dVZWTkVja040YldwbGRVNU1aeko1YzFsalprZzBlVmc0WkhGMFluZFpaamg1SzBWMlNXcG9PRDA9', '2021-02-18', NULL, '2nzQ8w2M', '', '', '0', '', NULL, 0, '0710089002', '0', 0, 'Dosen FTD', 'LPKD', 'Kepala LPKD', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(75, '3221', 'Lilis Widyanti, S.Pd, M.Pd', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, ' jPm87dwP', '', '', '0', '', NULL, 0, '0712068904', '0', 0, 'Dosen FTD', 'LP2M', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(76, '3205', 'Lukman Hakim, S.Si, M.Si', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'bacduH8T', '', '', '0', '', NULL, 0, '0712068904', '0', 0, 'Dosen FTD', 'Kemahasiswaan', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(77, '3067', 'Lussia Mariesti Andryani, SE, MM', 'VWpJeFVrODJZMmgzWkUxYVkyVnZjREp2YVRWRmQyTklSVE51UlVJeGNXRkhjVlU0TDJoR2NVaHlPRDA9', '2021-01-27', NULL, 'HDTz0cJb', '-', '-', '0', '-', '2021-09-30', 0, '0711038801', '0', 0, 'Dosen FEB', 'Prodi', '', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 2', '', 1),
(78, '4018', 'M. Zamroni', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'vR0qPCSy', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Office Boy', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(79, '3069', 'Machrus Arifianto, SS', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'fCj528Pb', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Marketing', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(80, '1049', 'Magdalena Retno Saraswati, S.TP', 'YnpkblkwcFBOM1J2VTJORVFrTkZSREpVWms5MloxSjFWbEZJZUN0RVEySjNWbkZtVFZGSlpFOHlNRDA9', '2021-01-27', NULL, 'fCj528Pb', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'BAA', '', 1, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(81, '3407', 'Mahendra Eko Priyantono', 'UlhOU2NXWmpObFZXZUdObmVtdEdVaTgyS3psWFYyVkRURkZGT1dNeGJGa3paRWwyV0ZOSVFXbzBiejA9', '2021-01-27', NULL, '0vC2TyUX', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Security', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(82, '3409', 'Mahindra Mandala Putra, SH', 'T1UwMVkyWkdiVGxtUjA1Q05IQTNNMU5FY1VOdFVYWjBUM05VT1dWRGRWSldWWFJrTVVSME9FUTBPRDA9', '2015-06-01', '1001-01-01', '52YvGtSH', 'Jl pringgodani I Klodran, Colomadu, Kab. Karanganyar, Jawa Tengah', 'Jl. Ikan Tombro Timur, Perum Istana cakalang Kav.42, Polowijwn, Blimbing , Kota Malang, Jawa Timur', '081326668815', 'Trenggalek', '1993-03-03', 0, '', '3313120303930001', 0, 'Karyawan', 'HRD & Sarpras', 'Kepala Sarpras/Kepala HRD', 0, 'null', 'null', '', 1, '1001-01-01', 1, '1001-01-01', 'Strata 1', '', 1),
(83, '9015', 'Mariana Puspa Dewi, SE, M.I.Kom', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'vsHA6arZ', '', '', '0', '', NULL, 0, '0709107502', '0', 0, 'Dosen FEB', 'LP2M', 'Jurnal', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(84, '3124', 'Mega Mirasaputri Cahyanti, SE., MM., M.Sc', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, '4wZZwh4k', '', '', '0', '', NULL, 0, '0715069001', '0', 0, 'Dosen FEB', 'INBIS', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(85, '1070', 'Moh. Zainuddin, S.Si, M.Kom', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'u2eFzkw8', '', '', '0', '', NULL, 0, '0725077105', '0', 0, 'Dosen FTD', 'HAKI', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(86, '3226', 'Mufidatul Islamiyah, S.Si, M.T', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'tZk8HMsS', '', '', '0', '', NULL, 0, '0710108604', '0', 0, 'Dosen FTD', 'Prodi', 'Sekprodi Sistem Komputer', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(87, '4019', 'Mulyaningtyas, SE, M.Ak', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'X1mpEb83', '', '', '0', '', NULL, 0, '0727077405', '0', 0, 'Dosen FEB', 'LPKD', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(88, '1028', 'Murtianingsih, SE, MM', 'U20xU1ZGbEJSV3BrWTFwUVJIbHRUVTFSY0ZWck0xZ3ZNRkIwVlRGRVkydFBla2x4WkRSS1pqSkVVVDA9', '2021-01-27', '1001-01-01', '3w9kQxn4', '-', '-', '0', '-', '2021-12-13', 0, '0712087803', '0', 0, 'Dosen FEB', 'Dekanat', 'Dekan Fakultas Ekonomi Bisnis', 1, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 2', '', 1),
(89, '3402', 'Niken Saktya Wulandari, SH', 'TjJ0NFZraFVNamhuWVhjclZsZDJibk5WU25oT0t6UXpjVVYzVG1sWGFEVmhNbkF5TlVjdlpXVnBSVDA9', '2021-01-27', NULL, '0rpVXZk5', '', '', '08223383276', 'Malang', '1993-10-01', 1, '', '0', 0, 'Karyawan', 'Front Office', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(90, '1058', 'Ninik Kustiari, SE', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, '3x87ZkbK', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'BAU', '', 1, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(91, '4004', 'Novan Styawan, SE', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'JVfrk53C', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Marketing', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(92, '4021', 'Novi Tiyasari, SE', 'WmpSbFYySXJVRFl2ZFdrck5XUTRhbEZGVTBwSGIwMUJjVlJsY1ZwcVZYSmhkMlJhTlZOMlRHRXdNRDA9', '2017-09-14', '1001-01-01', '8dBfjE4l', 'Jl. Sukun Gempol No 27 RT 03 RW 09 Malang', 'Jl. Candi Badut No 24 RT 02 RW 02 Malang', '081333990114', 'Malang', '1990-11-04', 1, '', '3573054411900004', 0, 'Karyawan', 'Rektorat', 'Admin WR2', 0, 'null', 'null', '', 2, '1001-01-01', 0, '1001-01-01', 'Strata 1', '1618902112.jpg', 1),
(93, '1113', 'Nur Elif, SE', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'o2qQmCaw', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Marketing', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(94, '1045', 'Nur Lailatul Aqromi, SS, MA', 'ZDJkU1VrNXJWazQwV0Vaa2JIaEhNMDk1VUZOdWFWcENUR2dyWVM5R2FGRkpSMUJwT0ZoVlpXTldZejA9', '2021-02-18', NULL, '9tr2QBEN', '', '', '0', '', NULL, 0, '0716068801', '0', 0, 'Dosen FTD', 'KUI', 'Kepala KUI', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(95, '4016', 'Patricia Restanancy, SP', 'YWtabFdYaEZTMkpoWVhCUk5EUkhTVE5aVFVGTk1HVmlSRGhRY21KblEwNWpTVXBuU1VObGRrSjVORDA9', '2021-02-27', NULL, 'nIsy9Uw8', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Admin Rektorat', 'Admin Rektorat', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 0),
(96, '3084', 'Pipit Rosita Andarsari, SE., MM', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'ukLl1Of3', '', '', '0', '', NULL, 0, '0718017802', '0', 0, 'Dosen FEB', '', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(97, '3112', 'Puji Subekti, S.Si, M.Si', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'NP8SJRYX', '', '', '0', '', NULL, 0, '0708028801', '0', 0, 'Dosen FTD', 'INBIS', 'Kepala Inkubator', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(98, '3403', 'Rakhmawati Indriani, S.Pd', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'Xz4do8VJ', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'BAA', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(99, '3714', 'Retno Cindy Rofiqoh, S.IP', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'rUn6WzBE', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan ', 'Pustakawan', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(100, '3105', 'Retno Handayani, A.Md', 'VWpSaVEzWlljRWR1YzFONGFEWkhZWFpvWlRWSFJEZHhNbUpzY3paa05WTjBiMVpxYWxaVmNqQlJRVDA9', '2021-01-27', NULL, 'OgE6cipY', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Front Office', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(101, '1039', 'Rifki Hanif, SE, MM', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'KT5Ff7IG', '-', '-', '0', '-', '2021-09-30', 0, '0718108301', '0', 0, 'Dosen FEB', 'Prodi', 'Kaprodi Profesional Bisnis Manajemen', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 2', '', 1),
(102, '1030', 'Rina Dewi Indahasari S.Kom, M.Kom', 'UmpONlUyeGlibE51UVU5RlpGSXlZMlJCVGs4NVFWVjRiMHhaWlRGd2QweEhOM0ZFV1doMU1qaHFhejA9', '2021-01-27', '1001-01-01', 'lMhvmTcz', '-', '-', '0', '-', '2021-12-10', 0, '0730128201', '0', 0, 'Dosen FTD', 'Dekanat', 'Dekan Fakultas Teknologi & Desain', 1, 'Teknik Informatika', 'Full', '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 2', '', 1),
(103, '1100', 'Rudianto', 'Y0dGemMzZHZjbVE9', '2021-01-27', '1001-01-01', 'vIYmsCON', '-', '-', '0', '-', '2021-12-12', 0, '', '0', 0, 'Karyawan', 'Office Boy', '', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'SMA', '', 1),
(104, '4023', 'Sabrina Ayu Primasti, S.AP', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'Qc1mCvlP', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Pustakawan', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(105, '1033', 'Samsul Arifin, S.ST, M.Kom', 'WWpZME16WXdiVEZtVkRaWWRHSkZjWHBDYlU5WFUzQlNXSEpqWW1OVVNXVTRZMnRwT1hOMmFsUmtZejA9', '2021-01-27', NULL, 'v9JTq00K', '', '', '0', '', NULL, 0, '0711108601', '0', 0, 'Dosen FTD', 'Prodi', 'Kaprodi Sistem Komputer', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(106, '1059', 'Satria Arik Cahyono, S.Kom', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, '7RDT5gv4', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Marketing', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(107, '3090', 'Setyorini, S.Kom, MM', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'j35GVDFS', '', '', '0', '', NULL, 0, '0723048704', '0', 0, 'Dosen FTD', 'Career Center', 'Kepala Pusat Karir', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(109, '1042', 'Siti Nurul Afiyah, S.Si, M.Si', 'VW10R2RDOHdWbkJIUldwdVVWSkdhMFJzVm5OVWJYbGhUbVZQYTBjNWRXdERlV050WWtnMU9URnVSVDA9', '2021-02-03', '2021-01-27', 'acXYr01V', '', '', '0', '', NULL, 0, '0710118801', '0', 0, 'Dosen FTD', 'KUI', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(110, '9804', 'Slamet Efendi', 'Y0dGemMzZHZjbVE9', '2021-01-27', '2021-01-27', '8QkBzARQ', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Driver', 'Driver', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(111, '3120', 'Sri Anggraini Kusuma Dewi, SH, M.Hum', 'Y0dGemMzZHZjbVE9', '2021-01-27', '2021-01-27', '80A4fhDw', '', '', '0', '', NULL, 0, '0723097504', '0', 0, 'Dosen FTD', '', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(112, '9801', 'Sri Puji Rahayu', 'YW5OSFpIUkRkVmhhZUdNMlduaElPSGRuVG1sV2VHODVXV0V3TlhOMFlpdFVPR0owVGxWSVFYcE5UVDA9', '2018-01-08', '2021-01-27', 'e9QUrFyg', 'Ds. Ngasem RT 4 RW 1 Kel. Ngasem Kec. Ngasem Kab. Kediri', 'Jl. Bendungan Jatiluhur No 24 B Kec. Lowokwaru Kota Malang', '085881894947', 'Kediri', '1998-11-01', 1, '', '3506255101980002', 1, 'Karyawan', 'Lembaga', '', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 1', '', 1),
(113, '1111', 'Suasdi, ST', 'ZFhkc1pXZHhaMlpYTVV0MlZVMU5Xa040TjNSSldIRkpiRTVOWVROQ1NsWjJVM0ZNTkZVeVpFWkRZejA9', '2021-02-11', '2021-01-27', 'E4wDhY7g', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Teknisi', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(114, '3111', 'Suastika Yulia Riska, S.Pd, M.Kom', 'Y0dGemMzZHZjbVE9', '2021-01-27', '2021-01-27', 'FwpF6ewM', '', '', '0', '', NULL, 0, '0712079001', '0', 0, 'Dosen FTD', 'Prodi', 'Sekprodi Teknik Informatika', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(115, '1099', 'Sucipto', 'Y0dGemMzZHZjbVE9', '2021-01-27', '2021-01-27', 'Eqbye8dk', '-', '-', '0', '-', '2021-12-12', 0, '', '0', 0, 'Karyawan', 'Office Boy', '', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'SMA', '', 1),
(116, '3061', 'Sumaningdyahs Woro Pembayun, SE', 'WXpJd1JURTRNV1YyTTJaTk9FRkJXSGRpYW0xbGREZERaM2RZTkU0eVRtbE9iemRsYVhFcmVFUlhVVDA9', '2021-01-27', '2021-01-27', 'RGxKgA7K', '', '', '81805128389', 'Malang', '1989-11-20', 1, '', '0', 0, 'Karyawan', 'Front Office', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(117, '1004', 'Sunu Jatmika, S.Kom, M.Kom', 'Y0dGemMzZHZjbVE9', '2021-01-27', '2021-01-27', 'nA2jM3Qv', '', '', '0', '', NULL, 0, '0721127002', '0', 0, 'Dosen FTD', 'TIP', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(118, '3408', 'Sutrisno', 'Y0dGemMzZHZjbVE9', '2021-01-27', '2021-01-27', 'j59zVy2Y', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Driver', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(119, '3110', 'Syaiful Bahri, SE., MSA', 'Y0dGemMzZHZjbVE9', '2021-01-27', '2021-01-27', '2MwKt1WX', '', '', '0', '', NULL, 0, '0718027801', '0', 0, 'Dosen FEB', 'Dekan', 'Wakil Dekan FEB', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(120, '3723', 'Taricha Alifya Januarni', 'UlVSNVlrSnRSbkZ3U0ZCMVRtMVBhREZRVlM5cWFrZERTM1ZKZEhadmQxQktNekpKTHpSME1XSnhZejA9', '2020-08-01', '1001-01-01', '97XhKn8X', 'Jl.Irian no 46A Kota Blitar', '', '089603502912', 'Blitar', '2001-01-02', 1, '', '3572014201010005', 1, 'Karyawan', 'UPT-SI', 'Programmer', 0, NULL, '', '', 0, '1001-01-01', 0, '1001-01-01', 'SMA', '', 1),
(121, '1124', 'Tissa Fajar Wienjaya, S.Kom', 'Wld0a1dVdHpUbXBuTkV4NVNDdEtOSGxCWmpkaWVIUmFXWFZuUzFaaE5HNURkVmdyYW5KeUwzTnJUVDA9', '2021-01-27', '2021-01-27', '2zeBDcV3', '-', '-', '0', '-', '2021-12-12', 0, '', '0', 0, 'Karyawan', 'Dekanat', 'Admin FEB', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 1', '', 1),
(122, '1009', 'Titania Dwi Andini, S.Kom, M.Kom', 'ZFZsR01tRnBiRXhNYzNJMmVFaENReXR5YTNSNkwwdHNhWGN3YjBwNlExSndjblJCZFM4MFppdHBjejA9', '2021-01-27', '1001-01-01', '2QEPXJhd', '-', '-', '0', '-', '2021-08-04', 1, '0718047701', '0', 0, 'Dosen FTD', 'UPT-SI', 'KaBag.Produksi', 1, 'Teknik Informatika', 'Full', 'TIT01', 0, '1001-01-01', 0, '1001-01-01', 'Strata 2', '', 1),
(123, '3081', 'Tri Wahyuni, S.Pd, M.Pd', 'Y0dGemMzZHZjbVE9', '2021-01-27', '2021-01-27', 'RbQd4HxK', '', '', '0', '', NULL, 0, '0726018303', '0', 0, 'Dosen FTD', 'Konselor', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(124, '4020', 'Tri Nanda Sagita Rachma, SP', 'T0ZabFpsbGhjMHhLWWs1WGIyTXZiMVJ3YTBkdVZrZDRPRXBZV1ZVck5VWk1UREJHTjBnMFpHdzBkejA9', '2017-09-14', '2021-01-27', 'x6ffP7XN', 'Dsn Urung-urung RT 17 RW 2 Kel. Jatijejer Kec. Trawas Kab. Mojokerto', 'Dsn Urung-urung RT 17 RW 2 Kel. Jatijejer Kec. Trawas Kab. Mojokerto', '085755101074', 'Malang', '1993-12-16', 1, '', '3507185612930001', 0, 'Karyawan', 'Pasca Sarjana', 'Admin', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 1', '', 1),
(125, '1079', 'Umar Sony, S.Sos', 'Y0dGemMzZHZjbVE9', '2006-09-01', '2021-01-27', 'yQZbQX56', 'Jl. Simpang Setaman I/24 RT 6 RW 15 Kel. Lowokwaru Kec. Lowokwaru Malang', 'Jl. Simpang Setaman I/24 RT 6 RW 15 Kel. Lowokwaru Kec. Lowokwaru Malang', '081904682718', 'Malang', '1975-05-08', 0, '', '3573050805750003', 0, 'Karyawan', 'Security', '', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 1', '', 1),
(126, '1057', 'Viryal Afaf Vairuz Baha, S.Kom', 'Y0dGemMzZHZjbVE9', '2010-11-16', NULL, 'Vi012859au', 'Jl. Raya RT 9 RW 2 Kel. Sempalwadak Kec. Bululawang Malang', 'Jl. Raya RT 9 RW 2 Kel. Sempalwadak Kec. Bululawang Malang', '081939893966', 'Mojokerto', '1989-04-24', 0, '', '3516092404890001', 0, 'Karyawan', 'BAA', '', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 1', '', 1),
(127, '1043', 'Vivi Aida Fitria, S.Si, M.Si', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'xXEAN88g', '', '', '0', '', NULL, 0, '0712068602', '0', 0, 'Dosen FTD', 'Dekan', 'Wakil Dekan FTD', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(128, '3215', 'Vivia Maya Rafica, SE, MM', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'WcX5K8GK', '', '', '0', '', NULL, 0, '0730078701', '0', 0, 'Dosen FEB', '', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(130, '3401', 'Wahyudi Nurul Aziz', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'nFUPh1FS', 'Jl. Dusun Karangduren RT 4 RW 2 Kel. Karangduren Kec. Pakisaji Malang', 'Jl. Dusun Karangduren RT 4 RW 2 Kel. Karangduren Kec. Pakisaji Malang', '082233699192', 'Malang', '1982-07-19', 0, '', '3573021907820004', 0, 'Karyawan', 'MDS', 'Staf Design', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'SMA', '', 1),
(131, '3126', 'Wahyudi Tri Susilo', 'Y0dGemMzZHZjbVE9', '2015-04-01', NULL, '3MrAcWaG', 'Jl. Sumberayu 42 RT 27 RW 4 Kel. Karangkates Kec. Sumberpucung Malang', 'Jl. Sumberayu 42 RT 27 RW 4 Kel. Karangkates Kec. Sumberpucung Malang', '089631666961', 'Malang', '1984-08-22', 0, '', '3573012208840003', 0, 'Karyawan', 'Security', '', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'SMA', '', 1),
(132, '1015', 'Warna Agung Cahyono, S.Kom', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, '8VFA5JjU', '', '', '0', '', NULL, 0, '0726108006', '0', 0, 'Dosen FTD', '', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(133, '3211', 'Widya Dewi Anjaningrum, S.Si, MM', 'Y0dGemMzZHZjbVE9', '2021-03-12', NULL, 'FRhtmQ5R', 'Tempat', '', '0', '', NULL, 0, '0710068206', '0', 0, 'Dosen FTD', 'ARC', 'Ketua ARC', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(134, '3114', 'Widya Adhariyanti Rahayu, S.Pd, M.Pd', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'Q5u8VHBS', '', '', '0', '', NULL, 0, '0724078801', '0', 0, 'Dosen FTD', 'LP2M', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(135, '3713', 'Winda Nur Maida, SE', 'Y0dGemMzZHZjbVE9', '2019-08-01', '1001-01-01', 'jgEWf8S1', 'Pondok Trosobo Indah B-15 RT 1 RW 8 Kel. Trosobo Kec. Taman Kab. Sidoarjo', 'Pondok Trosobo Indah B-15 RT 1 RW 8 Kel. Trosobo Kec. Taman Kab. Sidoarjo', '081235870670', 'Malang', '1990-04-09', 1, '', '3515134904900003', 1, 'Karyawan', 'BAA', 'Staf BAA', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 1', '', 1),
(136, '3411', 'Yohanes Nugraha, S.Kom', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'AXhxF9HX', '', '', '0', '', NULL, 0, '', '0', 0, 'Karyawan', 'Marketing', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(137, '1062', 'Yosepthin Tri Puriyanti, A.Md', 'YlV0MlZrRnVXa1ZHVlM5a05scEJTVVV6YjBOUU5tMUpaVlZCTDFGRlZuRklkRkI2UVV0UmJFVjVZejA9', '2011-10-01', '1001-01-01', 'CQz9V1va', 'Jl. Ikan Nus II/17 Kav 12 RT 8 RW 2 Kel. Tunjungsekar Kec. Lowokwaru Malang', 'Perum Bumi Mondoroko Raya Blok AK 11', '087859898852', 'Malang', '1988-02-15', 1, '', '3573015502880001', 0, 'Karyawan', 'Dekanat', '', 0, 'null', 'null', '', 1, '1001-01-01', 1, '1001-01-01', 'Diploma 3', '', 1),
(138, '1096', 'Yudianto', 'Y0dGemMzZHZjbVE9', '2008-08-01', NULL, 'nP3fwZra', 'Karangrejo Selatan RT 13 RW 9 Kel. Purworejo Kec. Donomulyo Malang', 'Jl. Borobudur No. 21 Malang', '081553475411', 'Blitar', '1987-02-07', 0, '', '3505180702870001', 0, 'Karyawan', 'Marketing', '', 0, NULL, '', '', 1, '1001-01-01', 1, '1001-01-01', 'SMA', '', 1),
(139, '3207', 'Yudistira Arya Sapoetra, S.Kom, MM', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'TE1nvuYj', '', '', '0', '', NULL, 0, '0704088601', '0', 0, 'Dosen FTD', 'LPMI', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(140, '4013', 'Abdul Aziz Muslim, S.Psi, M.Psi', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, 'DA0SJ4ct', '', '', '0', '', NULL, 0, '0709108904', '0', 0, 'Dosen FEB', 'Konselor', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(141, '9807', 'Abd Hadi, S.Kom, M.Kom', 'Y0dGemMzZHZjbVE9', '2021-03-10', NULL, '2u4PwTsg', '', '', '0', '', NULL, 0, '0727078810', '0', 0, 'Dosen FTD', 'LP2M', 'Pengelola JITIKA', 0, '', '', '', NULL, NULL, NULL, NULL, '', '', 1),
(142, '9806', 'Abdulloh Eizzi Irsyada, S.Kom, M.Ds', 'Y0dGemMzZHZjbVE9', '2021-01-27', NULL, '2qrXvgWH', '', '', '0', '', NULL, 0, '0703069102', '0', 0, 'Dosen FTD', 'INBIS', 'Pengelola JESKOV', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(143, '3098', 'Achmad Isman', 'Y0dGemMzZHZjbVE9', '2014-07-15', NULL, 'xcPvN2ZH', 'Jl. Gajayana No. 599 RT 1 RW 2 Kel. Dinoyo Kec. Lowokwaru Malang', 'Jl. Gajayana No. 599 RT 1 RW 2 Kel. Dinoyo Kec. Lowokwaru Malang', '082139889111', 'Malang', '1985-10-17', 0, '', '3507251710850003', 0, 'Karyawan', 'Security', '', 0, NULL, '', '', 1, '1001-01-01', 1, '1001-01-01', 'SMA', '', 1),
(144, '1016', 'Achmad Noercholis, ST, MT', 'V1U1bWVTdGFSbVZyV1hkQmMxWlNNV2h5V0ZZeVdVdFJZV3N5TkhScGMyTjVMMUVyVjFaUlNERmpTVDA9', '2021-01-27', NULL, '83PK58bU', '', '', '0', '', NULL, 0, '0707058303', '0', 0, 'Dosen FTD', 'UPT-SI', 'KaBag.Research and Development', 0, NULL, '', 'ACH01', NULL, NULL, NULL, NULL, NULL, '', 1),
(145, '3728', 'Wa Ode Irma Sari, S.Ak., M.SA', '', '2021-01-27', NULL, '', '', '', '0', '', NULL, 0, '', '0', 0, 'Dosen FEB', '', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(147, '3732', 'Dzikrullah Akbar', 'WnpseWFVRXZOMGwwVVVSTGVWVlRlV3hUUld4Q2VrcEZaMjAxU3psNE1uQllXVUZoTW5wR2NGRXJaejA9', '2020-08-01', '1001-01-01', '45Feb2145', 'Jl. Pangeran Diponegoro Gang 1 No 12 Tamanan', 'malang', '08974680033', 'Sidoarjo', '1999-11-27', 0, '', '0', 1, 'Karyawan', 'UPT-SI', '', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'SMA', '1633661873.jpg', 1),
(149, '3712', 'Syaldhy Yuka Novaldy', 'TkRoTllYSXlNVFE0', '2019-08-01', '2021-01-27', '48Mar2148', 'Jl. Trunojoyo GG III C RT 4 RW 2 Kel. Kolor Kec. Sumenep Kab. Sumenep', 'Jl. Trunojoyo GG III C RT 4 RW 2 Kel. Kolor Kec. Sumenep Kab. Sumenep', '082338483561', 'Sumenep', '1995-11-01', 0, '', '3529010111950001', 1, 'Karyawan', 'Digital Learning', '', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 1', '', 1),
(150, '3725', 'R.B Hendy Try Pranegara', 'TVRGTllYSXlNVEV4', '2020-10-01', NULL, '11Mar2111', 'Perum Puri Jepun Permai I no. 6 RT04 RW05, Kel. Jepun, Kec. Tulungagung', 'Perumahan Graha Falisha No.1 Jl. Terusan Setia Budi Kel. Sumbersuko Kec. Tajinan Kab. Malang', '085258724910', 'Tulungagung', '1993-09-19', 0, '', '3504011909930000', 1, 'Karyawan', 'Digital Learning', '', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 1', '', 1),
(152, '3727', 'Ditya Wardana, S.ST, M.S.A', 'TWpsTllYSXlNVEk1', '2021-03-12', NULL, '29Mar2129', 'Tempat', '', '0', '', NULL, 0, '', '0', 0, 'Dosen FTD', 'Career Center', '', 0, 'Sistem Komputer', '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(153, '3726', 'Layly Dwi Rohmatunnisa', 'TURWTllYSXlNVEEx', '2021-03-12', NULL, '05Mar2105', 'Tempat', '', '0', '', NULL, 0, '', '0', 0, 'Dosen FEB', 'Dosen Akuntansi', '', 0, NULL, '', '', NULL, NULL, NULL, NULL, NULL, '', 1),
(154, 'pkl', 'pkl', 'ZW10UkwzbHBaemRSVWpsSkwxSndjR2szYVdwSFNHaGxjWGsxVFZkalUxUkZkMUI2Um1wRU5WWXZWVDA9', '2021-03-16', NULL, '31Mar2131', 'Tempat', 'Tempat', '1234', 'Malang', '2021-04-15', 0, '', '1234', 1, 'Magang', '', '', 0, NULL, '', '', 2, '2021-04-15', 2, '2021-04-15', 'Strata 1', '1618372397.jpg', 1),
(218, 'humas@asia.ac.id', 'mds', 'ZWtkeVdHRklURkpKTUVoQk5rTndObGhwU0U1TVZEUkxjbGd4ZHpoT01WUjRUR1p2UzJwbkt6ZENNRDA9', '2021-04-21', NULL, '29Apr2129', 'lantai 2', 'lantai 2', '0', 'malang', '2021-04-21', 0, '', '0', 1, 'Karyawan', NULL, '', 0, NULL, '', '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 1', '', 1),
(219, '3729', 'Hironimus Hari Kurniawan, SE, MM', 'TkRKS2RXNHlNVFF5', '2021-03-01', NULL, '42Jun2142', 'Jl. Danau Matana I/F2 B-6 RT.009/RW.012 Kel. Sawojajar Kec. Kedungkandang Kota Malang', 'Jl. Danau Matana I/F2 B-6 RT.009/RW.012 Kel. Sawojajar Kec. Kedungkandang Kota Malang', '', 'Malang', '1987-09-30', 0, '0730098705', '3573013009870001', 0, 'Dosen FEB', '', '', 0, NULL, NULL, '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 2', '', 1),
(235, '3731', 'Nicholaus Wayong Kabelen, S.Sn., M.Sn', 'TkRoQmRXY3lNVFE0', '2021-08-01', NULL, '48Aug2148', '1', '1', '1', '1', '2021-08-24', 0, '', '1', 0, 'Dosen FTD', '', 'Dosen DKV', 0, '', '', '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 2', '', 1),
(236, '9809', 'Ratna Putri Nilasari,SE', 'WkRGNlMxSllUMlp0VDNoaFpYVjZWMUF6VFd0dFkyOXZPVVIwTW1FcmN6QldaUzh6UldOdVVHWXhiejA9', '2017-02-25', NULL, '27Aug2127', 'Jl. Kutisari Indah Utara II/86 RT 04 RW 06 Kel. Kutisari Kec. Tenggilis Mejoyo Surabaya', 'Jl. danau Bratan Timur VI C20', '081231557737', 'Madiun', '1988-04-05', 1, '', '3520114504880001', 0, 'Sam Design', '', 'Staff Rektorat', 0, '', '', '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 1', '', 1),
(237, '3733', 'Sindy Nur Fitriyah', 'YVRBNFVVUmlaWEpZSzJOUFJrRnBjRTl3VEN0UGVtNWplalF5WkdncmNHVlpMMkpLZWpSdWRrMUNSVDA9', '2021-08-01', NULL, '23Sep2123', 'Ds. Kapuran Kec. Wonosari Kab. Bondowoso', 'Malang', '085729749003', 'Bondowoso', '1999-01-30', 1, '', '3511147001990002', 1, 'Karyawan', '', 'Admin Pascasarjana', 0, '', '', '', 0, '1001-01-01', 0, '1001-01-01', 'SMA', '', 1),
(238, '3734', 'Reza Ramadhania, S.Sos', 'V0RRMFNWbDNSV2t5ZEVWd1ZHOHZNRkpaVWxaR1RtTkNWa3BsWTJwQk9IUkxXbVZGYTJZNVdFWTNSVDA9', '2021-08-01', NULL, '32Sep2132', '--', 'Perumahan Taman Indah Soekarno Hatta No 85 Malang', '085655807520', 'Sidoarjo', '1998-01-16', 1, '', '0', 1, 'Karyawan', 'Rektorat', 'Staff Rektorat', 0, 'null', 'null', '', 0, '1001-01-01', 0, '1001-01-01', 'Strata 1', '', 1),
(242, '3746', 'Ida Nuryana, S.E., M.M.', 'TURGUFkzUXlNVEF4', '2021-10-01', NULL, '01Oct2101', 'Jl. Urea No 4 Rt08 Rw 20 Kelurahan Purwantoro Kecamatan Blimbing Malang', 'Jl. Urea No 4 Rt08 Rw 20 Kelurahan Purwantoro Kecamatan Blimbing Malang', '0', 'Malang', '1963-05-30', 1, '0730056303', '0', 0, 'Dosen FEB', '', 'Dosen', 0, 'Manajemen', 'Semi', '0', 0, '1001-01-01', 0, '1001-01-01', 'Strata 2', '', 1),
(243, '3745', 'YOGI WIDYA SAKA WARSAA, S.Sn, M.Sn', 'TURoUFkzUXlNVEE0', '2021-10-01', NULL, '08Oct2108', 'Jl. Sawojajar GAng Vb No 46 Malang', 'Jl. Sawojajar GAng Vb No 46 Malang', '081222505059', 'Pasuruan', '1993-03-30', 0, '00', '0', 1, 'Dosen FTD', '', 'Dosen', 0, 'DKV', 'Semi', '0', 0, '1001-01-01', 0, '1001-01-01', 'Strata 2', '', 1),
(244, 'Tengky Bagoes', 'Tengky Bagoes', 'Y0ZoUU5XbENjWFJaYTJaVWQzZHNja3h3Y25sRkwxTXJRelZuVDJob01ERndWMGM0U0VvM1FtVTBaejA9', NULL, NULL, 'NTdOb3YyMTU3', 'j', 'j', '', 'Blitar', '2021-11-18', 0, '0', '0', 0, 'Dosen LB', '', '', 0, '', '', 'TNK01', NULL, NULL, NULL, NULL, 'Strata 2', NULL, 1),
(245, 'elfa', 'elfa', 'TkU0MFMzRkdRbVpsY1hWeWRsaEhWMkoyZHpsMVpFMVZWbGcwYUVKWGJXWlJTVmxZWjJ0aU5DdFVPRDA9', NULL, NULL, 'MjZOb3YyMTI2', 'a', 'a', '', 'Blitar', '2021-11-18', 1, '0', '0', 0, 'Dosen LB', '', '', 0, '', '', 'ELF01', NULL, NULL, NULL, NULL, 'Strata 2', NULL, 1),
(246, 'testStaff', 'tesStaff', 'U1haVFlrVk5hakZaVlhWWVJ6aGtVa296U210SVEybFFiWGRsWW1wemRWSmllRGhSYkdrdlMxWTRZejA9', '2021-11-25', '1001-01-01', '18Nov2118', 'alamat', 'alamat', '08974680033', 'Malang', '2021-11-25', 0, '', '123456789', 1, 'Karyawan', 'Office Boy', 'test', 1, 'null', 'null', '0', 0, '1001-01-01', 0, '1001-01-01', 'SD', '', 1),
(247, 'tesDosen', 'tesDosen', 'YUc1eGMyaEdUbTlXUmtnMFJTczJVMmxMYWpka01HWmFUMGRTYjBOc1owTm9ibUptVGtWblJVNUxUVDA9', '2021-11-25', '1001-01-01', '06Nov2106', 'alamat', 'alamat', '08974680033', 'Malang', '2021-11-25', 0, '0727078810', '123456789', 1, 'Dosen FTD', '-', '', 0, 'Teknik Informatika', 'Full', '0', 0, '1001-01-01', 0, '1001-01-01', 'SD', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_grub`
--

CREATE TABLE `user_grub` (
  `grub_id` int(11) NOT NULL,
  `nama_grup` varchar(225) NOT NULL,
  `level_id` int(11) NOT NULL,
  `id_hidden` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_grub`
--

INSERT INTO `user_grub` (`grub_id`, `nama_grup`, `level_id`, `id_hidden`) VALUES
(0, 'Admin Astor', 0, 1),
(1, 'Admin Rektorat', 1, 1),
(2, 'Admin Lembaga', 6, 1),
(3, 'Admin Lembaga2', 7, 1),
(4, 'Admin Lembaga3', 8, 1),
(5, 'Admin Lembaga4', 9, 1),
(6, 'Admin Lembaga5', 10, 1),
(7, 'Admin Lembaga6', 11, 1),
(8, 'Admin FTD', 3, 1),
(12, 'Admin FEB', 4, 1),
(15, 'Admin Pasca Sarjana', 17, 1),
(16, 'percobaan', 5, 1),
(17, 'Admin App KUI', 18, 1),
(18, 'Admin HRD app', 19, 1),
(19, 'Admin ARC', 20, 1),
(20, 'Admin Career Center', 21, 1),
(21, 'Admin Fasilitas', 22, 1),
(22, 'Front Office', 23, 1),
(23, 'HRD Dosen', 19, 1),
(24, 'HRD Kaprodi', 19, 1),
(25, 'HRD Dekan', 19, 1),
(26, 'HRD Karyawan', 19, 1),
(27, 'HRD sipa', 25, 1),
(28, 'Admin Akademik', 26, 1),
(29, 'FO Admin', 23, 1),
(30, 'Dosen', 28, 1),
(31, 'HRD Karyawan & koordinator divisi', 19, 1),
(32, 'HRD Dosen & koordinator divisi', 19, 1),
(33, 'HRD WR', 19, 1),
(34, 'HRD Rektor', 19, 1);

-- --------------------------------------------------------

--
-- Table structure for table `versi`
--

CREATE TABLE `versi` (
  `id_versi` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `aplikasi_id` int(11) NOT NULL,
  `v_versi` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `versi`
--

INSERT INTO `versi` (`id_versi`, `id`, `aplikasi_id`, `v_versi`) VALUES
(1, 2, 1, '1.29.12'),
(2, 5, 1, '1.29.12'),
(3, 112, 1, '1.29.12'),
(4, 137, 1, '1.29.12'),
(5, 121, 1, '1.29.12'),
(6, 124, 1, '1.29.12'),
(7, 69, 1, '1.0.0'),
(8, 95, 1, '1.0.0'),
(9, 92, 1, '1.0.0'),
(10, 148, 1, '1.29.12'),
(11, 120, 1, '1.0.0'),
(12, 236, 1, '1.29.12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi_hrd`
--
ALTER TABLE `absensi_hrd`
  ADD PRIMARY KEY (`id_absensihrd`),
  ADD KEY `id_user` (`id`);

--
-- Indexes for table `aplikasi`
--
ALTER TABLE `aplikasi`
  ADD PRIMARY KEY (`aplikasi_id`),
  ADD KEY `id_hidden` (`id_hidden`);

--
-- Indexes for table `asuransi`
--
ALTER TABLE `asuransi`
  ADD PRIMARY KEY (`id_asuransi`);

--
-- Indexes for table `detail_asuransi`
--
ALTER TABLE `detail_asuransi`
  ADD PRIMARY KEY (`id_detail_asuransi`),
  ADD KEY `id` (`id`),
  ADD KEY `id_asuransi` (`id_asuransi`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`divisi_id`);

--
-- Indexes for table `hidden`
--
ALTER TABLE `hidden`
  ADD PRIMARY KEY (`id_hidden`);

--
-- Indexes for table `izin_hrd`
--
ALTER TABLE `izin_hrd`
  ADD PRIMARY KEY (`id_izin`);

--
-- Indexes for table `jadwal_hrd`
--
ALTER TABLE `jadwal_hrd`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_struktural` (`id_struktural`);

--
-- Indexes for table `jenjang`
--
ALTER TABLE `jenjang`
  ADD PRIMARY KEY (`id_jenjang`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`level_id`),
  ADD KEY `id_hidden` (`id_hidden`);

--
-- Indexes for table `level_detail`
--
ALTER TABLE `level_detail`
  ADD PRIMARY KEY (`id_urt`),
  ADD KEY `user_id` (`level_id`),
  ADD KEY `user_id_4` (`level_id`),
  ADD KEY `user_id_5` (`level_id`),
  ADD KEY `user_id_6` (`level_id`),
  ADD KEY `user_id_7` (`level_id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_hidden` (`id_hidden`),
  ADD KEY `grub_id` (`grub_id`),
  ADD KEY `id_hidden_2` (`id_hidden`),
  ADD KEY `id_hidden_3` (`id_hidden`);

--
-- Indexes for table `loglogin_fo`
--
ALTER TABLE `loglogin_fo`
  ADD PRIMARY KEY (`id_loglogin`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`),
  ADD KEY `level_id` (`aplikasi_id`),
  ADD KEY `id_hidden` (`id_hidden`);

--
-- Indexes for table `req_api`
--
ALTER TABLE `req_api`
  ADD PRIMARY KEY (`ReqApi_id`);

--
-- Indexes for table `riwayat_pendidikan`
--
ALTER TABLE `riwayat_pendidikan`
  ADD PRIMARY KEY (`id_riwayat_pendidikan`),
  ADD KEY `id` (`id`),
  ADD KEY `id_jenjang` (`id_jenjang`);

--
-- Indexes for table `rule`
--
ALTER TABLE `rule`
  ADD PRIMARY KEY (`id_rule`),
  ADD KEY `level_id` (`id_rule`,`aplikasi_id`),
  ADD KEY `menu_id` (`aplikasi_id`),
  ADD KEY `level_id_3` (`level_id`),
  ADD KEY `level_id_4` (`level_id`),
  ADD KEY `aplikasi_id` (`aplikasi_id`);

--
-- Indexes for table `rule2`
--
ALTER TABLE `rule2`
  ADD PRIMARY KEY (`id_rule2`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `menu_id_2` (`menu_id`),
  ADD KEY `grub_id` (`grub_id`);

--
-- Indexes for table `struktural`
--
ALTER TABLE `struktural`
  ADD PRIMARY KEY (`id_rektor`),
  ADD KEY `id_hidden` (`id_hidden`),
  ADD KEY `id` (`id`),
  ADD KEY `level_id` (`level_id`);

--
-- Indexes for table `user_entity`
--
ALTER TABLE `user_entity`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `id_hidden` (`id_hidden`);

--
-- Indexes for table `user_grub`
--
ALTER TABLE `user_grub`
  ADD PRIMARY KEY (`grub_id`),
  ADD KEY `level_id` (`level_id`);

--
-- Indexes for table `versi`
--
ALTER TABLE `versi`
  ADD PRIMARY KEY (`id_versi`),
  ADD KEY `id` (`id`,`aplikasi_id`),
  ADD KEY `aplikasi_id` (`aplikasi_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi_hrd`
--
ALTER TABLE `absensi_hrd`
  MODIFY `id_absensihrd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `izin_hrd`
--
ALTER TABLE `izin_hrd`
  MODIFY `id_izin` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `jadwal_hrd`
--
ALTER TABLE `jadwal_hrd`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=267;

--
-- AUTO_INCREMENT for table `jenjang`
--
ALTER TABLE `jenjang`
  MODIFY `id_jenjang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `level_detail`
--
ALTER TABLE `level_detail`
  MODIFY `id_urt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `loglogin_fo`
--
ALTER TABLE `loglogin_fo`
  MODIFY `id_loglogin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- AUTO_INCREMENT for table `req_api`
--
ALTER TABLE `req_api`
  MODIFY `ReqApi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rule`
--
ALTER TABLE `rule`
  MODIFY `id_rule` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `rule2`
--
ALTER TABLE `rule2`
  MODIFY `id_rule2` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=615;

--
-- AUTO_INCREMENT for table `struktural`
--
ALTER TABLE `struktural`
  MODIFY `id_rektor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `user_entity`
--
ALTER TABLE `user_entity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;

--
-- AUTO_INCREMENT for table `versi`
--
ALTER TABLE `versi`
  MODIFY `id_versi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi_hrd`
--
ALTER TABLE `absensi_hrd`
  ADD CONSTRAINT `absensi_hrd_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user_entity` (`id`);

--
-- Constraints for table `aplikasi`
--
ALTER TABLE `aplikasi`
  ADD CONSTRAINT `aplikasi_ibfk_1` FOREIGN KEY (`id_hidden`) REFERENCES `hidden` (`id_hidden`);

--
-- Constraints for table `detail_asuransi`
--
ALTER TABLE `detail_asuransi`
  ADD CONSTRAINT `detail_asuransi_ibfk_2` FOREIGN KEY (`id_asuransi`) REFERENCES `asuransi` (`id_asuransi`),
  ADD CONSTRAINT `detail_asuransi_ibfk_3` FOREIGN KEY (`id`) REFERENCES `user_entity` (`id`);

--
-- Constraints for table `jadwal_hrd`
--
ALTER TABLE `jadwal_hrd`
  ADD CONSTRAINT `jadwal_hrd_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user_entity` (`id`),
  ADD CONSTRAINT `jadwal_hrd_ibfk_2` FOREIGN KEY (`id_struktural`) REFERENCES `struktural` (`id_rektor`);

--
-- Constraints for table `level`
--
ALTER TABLE `level`
  ADD CONSTRAINT `level_ibfk_1` FOREIGN KEY (`id_hidden`) REFERENCES `hidden` (`id_hidden`);

--
-- Constraints for table `level_detail`
--
ALTER TABLE `level_detail`
  ADD CONSTRAINT `level_detail_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user_entity` (`id`);

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`aplikasi_id`) REFERENCES `aplikasi` (`aplikasi_id`),
  ADD CONSTRAINT `menu_ibfk_2` FOREIGN KEY (`id_hidden`) REFERENCES `hidden` (`id_hidden`);

--
-- Constraints for table `riwayat_pendidikan`
--
ALTER TABLE `riwayat_pendidikan`
  ADD CONSTRAINT `riwayat_pendidikan_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user_entity` (`id`),
  ADD CONSTRAINT `riwayat_pendidikan_ibfk_2` FOREIGN KEY (`id_jenjang`) REFERENCES `jenjang` (`id_jenjang`);

--
-- Constraints for table `rule`
--
ALTER TABLE `rule`
  ADD CONSTRAINT `rule_ibfk_1` FOREIGN KEY (`aplikasi_id`) REFERENCES `aplikasi` (`aplikasi_id`),
  ADD CONSTRAINT `rule_ibfk_2` FOREIGN KEY (`level_id`) REFERENCES `level` (`level_id`);

--
-- Constraints for table `rule2`
--
ALTER TABLE `rule2`
  ADD CONSTRAINT `rule2_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`),
  ADD CONSTRAINT `rule2_ibfk_3` FOREIGN KEY (`grub_id`) REFERENCES `user_grub` (`grub_id`);

--
-- Constraints for table `struktural`
--
ALTER TABLE `struktural`
  ADD CONSTRAINT `struktural_ibfk_2` FOREIGN KEY (`id_hidden`) REFERENCES `hidden` (`id_hidden`),
  ADD CONSTRAINT `struktural_ibfk_3` FOREIGN KEY (`level_id`) REFERENCES `level` (`level_id`),
  ADD CONSTRAINT `struktural_ibfk_4` FOREIGN KEY (`id`) REFERENCES `user_entity` (`id`);

--
-- Constraints for table `user_entity`
--
ALTER TABLE `user_entity`
  ADD CONSTRAINT `user_entity_ibfk_1` FOREIGN KEY (`id_hidden`) REFERENCES `hidden` (`id_hidden`);

--
-- Constraints for table `user_grub`
--
ALTER TABLE `user_grub`
  ADD CONSTRAINT `user_grub_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `level` (`level_id`);

--
-- Constraints for table `versi`
--
ALTER TABLE `versi`
  ADD CONSTRAINT `versi_ibfk_2` FOREIGN KEY (`aplikasi_id`) REFERENCES `aplikasi` (`aplikasi_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;