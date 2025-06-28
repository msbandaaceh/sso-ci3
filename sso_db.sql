-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2025 at 11:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Primary key: (by system)',
  `nip` varchar(20) DEFAULT NULL COMMENT 'NIP(Nomor Induk Pegawai): isian bebas',
  `nama` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'Nama Lengkap (tanpa gelar dan singkatan): isian bebas',
  `nama_gelar` varchar(50) DEFAULT NULL COMMENT 'Nama Lengkap Dengan Gelar: isian bebas',
  `golongan_id` int(11) DEFAULT NULL COMMENT 'ref_pangkat',
  `alamat` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'Keterangan: isian bebas',
  `jabatan_id` int(11) DEFAULT NULL,
  `jk` tinyint(1) DEFAULT NULL,
  `tmt` date DEFAULT NULL COMMENT 'Diisi TMT CPNS untuk PNS dan TMT awal untuk PPPK',
  `foto` text DEFAULT 'assets/dokumen/foto/1.webp',
  `ttd` text DEFAULT NULL,
  `jenis_pegawai` varchar(5) DEFAULT NULL COMMENT '1=Hakim, 2=PNS, 3=PPNPN, 4=Cakim, 5=Operator, 6=PPPK',
  `nohp` varchar(50) DEFAULT NULL,
  `status_pegawai` tinyint(1) DEFAULT 1,
  `diinput_oleh` varchar(30) DEFAULT '' COMMENT 'Diinput Oleh: (by system)',
  `diinput_tanggal` datetime DEFAULT NULL COMMENT 'Diinput Tanggal: (by system)',
  `diperbaharui_oleh` varchar(30) DEFAULT '' COMMENT 'Diperbaharui Oleh: (by system)',
  `diperbaharui_tanggal` datetime DEFAULT NULL COMMENT 'Diperbaharui Tanggal: (by system)'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Referensi Panitera Pengadilan Negeri';

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nip`, `nama`, `nama_gelar`, `golongan_id`, `alamat`, `keterangan`, `jabatan_id`, `jk`, `tmt`, `foto`, `ttd`, `jenis_pegawai`, `nohp`, `status_pegawai`, `diinput_oleh`, `diinput_tanggal`, `diperbaharui_oleh`, `diperbaharui_tanggal`) VALUES
(1, NULL, 'Super Administrator', 'Super Administrator', NULL, NULL, '', 0, NULL, NULL, 'assets/dokumen/foto/1.webp', '', NULL, NULL, 1, 'Super Administrator', NULL, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ref_client_app`
--

CREATE TABLE `ref_client_app` (
  `id` int(11) NOT NULL,
  `nama_app` text NOT NULL,
  `deskripsi` text NOT NULL,
  `created_on` datetime NOT NULL,
  `created_by` text NOT NULL,
  `modified_on` datetime DEFAULT NULL,
  `modified_by` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ref_client_app`
--

INSERT INTO `ref_client_app` (`id`, `nama_app`, `deskripsi`, `created_on`, `created_by`, `modified_on`, `modified_by`) VALUES
(1, 'HADIR-IN', 'Sistem Informasi Manajemen Presensi Pegawai', '2025-06-18 08:17:32', 'Super Administrator', NULL, NULL),
(2, 'PAYLINK', 'Sistem Informasi Manajemen Gaji Pegawai', '2025-06-18 08:26:26', 'Super Administrator', NULL, NULL),
(3, 'SIAS', 'Sistem Informasi Arsip dan Surat', '2025-06-19 04:55:05', 'Super Administrator', NULL, NULL),
(4, 'SEUDATI', 'Sistem Elektronik Untuk Administrasi Izin dan Cuti', '2025-06-19 04:55:05', 'Super Administrator', NULL, NULL),
(5, 'AGAM', 'Sistem Informasi Agenda Rapat Mahkamah', '2025-06-19 04:56:20', 'Super Administrator', NULL, NULL),
(6, 'E-GUEST', 'Elektronik Guest Book', '2025-06-19 04:56:20', 'Super Administrator', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ref_group_jabatan`
--

CREATE TABLE `ref_group_jabatan` (
  `id` tinyint(1) NOT NULL,
  `group_jabatan` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ref_group_jabatan`
--

INSERT INTO `ref_group_jabatan` (`id`, `group_jabatan`) VALUES
(1, 'Hakim'),
(2, 'PNS'),
(3, 'Honorer'),
(4, 'Calon Hakim'),
(5, 'Operator'),
(6, 'PPPK');

-- --------------------------------------------------------

--
-- Table structure for table `ref_jabatan`
--

CREATE TABLE `ref_jabatan` (
  `id` tinyint(4) NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL,
  `struktural` enum('0','1') NOT NULL COMMENT '1=struktural, 0=bukan struktural',
  `hapus` enum('0','1') NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT NULL,
  `created_by` text DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `modified_by` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ref_jabatan`
--

INSERT INTO `ref_jabatan` (`id`, `nama_jabatan`, `struktural`, `hapus`, `created_on`, `created_by`, `modified_on`, `modified_by`) VALUES
(1, 'KETUA', '1', '0', NULL, NULL, '2025-06-20 16:28:00', 'Super Administrator'),
(2, 'WAKIL KETUA', '1', '0', NULL, NULL, NULL, NULL),
(3, 'HAKIM', '0', '0', NULL, NULL, NULL, NULL),
(4, 'PANITERA', '1', '0', NULL, NULL, NULL, NULL),
(5, 'SEKRETARIS', '1', '0', NULL, NULL, NULL, NULL),
(6, 'PANITERA MUDA GUGATAN', '1', '0', NULL, NULL, NULL, NULL),
(7, 'PANITERA MUDA PERMOHONAN', '1', '0', NULL, NULL, NULL, NULL),
(8, 'PANITERA MUDA JINAYAT', '1', '0', NULL, NULL, NULL, NULL),
(9, 'PANITERA MUDA HUKUM', '1', '0', NULL, NULL, NULL, NULL),
(10, 'KEPALA SUB BAGIAN UMUM DAN KEUANGAN', '1', '0', NULL, NULL, NULL, NULL),
(11, 'KEPALA SUB BAGIAN KEPEGAWAIAN', '1', '0', NULL, NULL, NULL, NULL),
(12, 'KEPALA SUB BAGIAN PTIP', '1', '0', NULL, NULL, NULL, NULL),
(13, 'PANITERA PENGGANTI', '0', '0', NULL, NULL, NULL, NULL),
(14, 'JURUSITA', '0', '0', NULL, NULL, NULL, NULL),
(15, 'JURUSITA PENGGANTI', '0', '0', NULL, NULL, NULL, NULL),
(16, 'PRANATA KOMPUTER AHLI PERTAMA', '0', '0', NULL, NULL, NULL, NULL),
(17, 'ARSIPARIS TERAMPIL', '0', '0', NULL, NULL, NULL, NULL),
(18, 'PUSTAKAWAN', '0', '0', NULL, NULL, NULL, NULL),
(19, 'BENDAHARA', '0', '0', NULL, NULL, NULL, NULL),
(20, 'PRANATA KEUANGAN APBN MAHIR', '0', '0', NULL, NULL, NULL, NULL),
(21, 'KLEREK - PENELAAH TEKNIS KEBIJAKAN', '0', '0', NULL, NULL, NULL, NULL),
(30, 'PRAMUBAKTI', '0', '0', NULL, NULL, NULL, NULL),
(25, 'OPERATOR - PENATA LAYANAN OPERASIONAL', '0', '0', NULL, NULL, NULL, NULL),
(26, 'KLEREK - ANALIS PERKARA PERADILAN', '0', '0', NULL, NULL, NULL, NULL),
(27, 'OPERATOR - TEKNISI SARANA DAN PRASARANA', '0', '0', NULL, NULL, NULL, NULL),
(28, 'KLEREK - PENGOLAH DATA DAN INFORMASI', '0', '0', NULL, NULL, NULL, NULL),
(29, 'KLEREK - PENGELOLA PENANGANAN PERKARA', '0', '0', NULL, NULL, NULL, NULL),
(31, 'SATPAM', '0', '0', NULL, NULL, NULL, NULL),
(32, 'PENGEMUDI', '0', '0', NULL, NULL, NULL, NULL),
(33, 'PETUGAS SURAT', '0', '0', NULL, NULL, NULL, NULL),
(34, 'PETUGAS PRESENSI', '0', '0', NULL, NULL, NULL, NULL),
(35, 'PETUGAS PENGGAJIAN', '0', '0', NULL, NULL, NULL, NULL),
(0, 'Super Administrator', '0', '1', NULL, NULL, '2025-06-20 16:33:08', 'Super Administrator'),
(37, 'ANALIS PENGELOLAAN KEUANGAN APBN AHLI MUDA', '0', '0', NULL, NULL, NULL, NULL),
(38, 'PRANATA KEUANGAN APBN PENYELIA', '0', '0', NULL, NULL, NULL, NULL),
(39, 'KLEREK - DOKUMENTALIS HUKUM', '0', '0', NULL, NULL, NULL, NULL),
(42, 'PRANATA PERADILAN', '0', '1', '2025-06-20 16:18:28', 'Super Administrator', '2025-06-20 16:34:47', 'Super Administrator'),
(43, 'PRANATA PERADILAN', '0', '1', '2025-06-20 16:18:51', 'Super Administrator', '2025-06-20 16:33:48', 'Super Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `ref_pangkat`
--

CREATE TABLE `ref_pangkat` (
  `id` int(11) NOT NULL,
  `golongan` varchar(20) NOT NULL,
  `pangkat` varchar(30) NOT NULL,
  `hapus` enum('0','1') NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT NULL,
  `created_by` text DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `modified_by` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ref_pangkat`
--

INSERT INTO `ref_pangkat` (`id`, `golongan`, `pangkat`, `hapus`, `created_on`, `created_by`, `modified_on`, `modified_by`) VALUES
(1, 'I/a', 'JURU MUDA', '0', NULL, NULL, '2025-06-20 17:42:02', 'Super Administrator'),
(2, 'I/b', 'JURU MUDA TINGKAT I', '0', NULL, NULL, NULL, NULL),
(3, 'I/c', 'JURU', '0', NULL, NULL, NULL, NULL),
(4, 'I/d', 'JURU TINGKAT I', '0', NULL, NULL, NULL, NULL),
(5, 'II/a', 'PENGATUR MUDA', '0', NULL, NULL, NULL, NULL),
(6, 'II/b', 'PENGATUR MUDA TINGKAT I', '0', NULL, NULL, NULL, NULL),
(7, 'II/c', 'PENGATUR', '0', NULL, NULL, NULL, NULL),
(8, 'II/d', 'PENGATUR TINGKAT I', '0', NULL, NULL, NULL, NULL),
(10, 'III/a', 'PENATA MUDA', '0', NULL, NULL, NULL, NULL),
(11, 'III/b', 'PENATA MUDA TINGKAT I', '0', NULL, NULL, NULL, NULL),
(12, 'III/c', 'PENATA', '0', NULL, NULL, NULL, NULL),
(13, 'III/d', 'PENATA TINGKAT I', '0', NULL, NULL, NULL, NULL),
(14, 'IV/a', 'PEMBINA', '0', NULL, NULL, NULL, NULL),
(15, 'IV/b', 'PEMBINA TINGKAT I', '0', NULL, NULL, NULL, NULL),
(16, 'IV/c', 'PEMBINA UTAMA MUDA', '0', NULL, NULL, NULL, NULL),
(17, 'IV/d', 'PEMBINA UTAMA MADYA', '0', NULL, NULL, NULL, NULL),
(18, 'IV/e', 'PEMBINA UTAMA', '0', NULL, NULL, NULL, NULL),
(99, 'Pegawai Tidak Tetap', 'PEGAWAI TIDAK TETAP (PTT)', '0', NULL, NULL, NULL, NULL),
(100, 'I', 'GOLONGAN I', '0', NULL, NULL, NULL, NULL),
(101, 'II', 'GOLONGAN II', '0', NULL, NULL, NULL, NULL),
(102, 'III', 'GOLONGAN III', '0', NULL, NULL, NULL, NULL),
(103, 'IV', 'GOLONGAN IV', '0', NULL, NULL, NULL, NULL),
(104, 'V', 'GOLONGAN V', '0', NULL, NULL, NULL, NULL),
(105, 'VI', 'GOLONGAN VI', '0', NULL, NULL, NULL, NULL),
(106, 'VII', 'GOLONGAN VII', '0', NULL, NULL, NULL, NULL),
(107, 'VIII', 'GOLONGAN VIII', '0', NULL, NULL, NULL, NULL),
(108, 'add', 'ASDAWD', '1', '2025-06-20 17:42:10', 'Super Administrator', '2025-06-20 17:42:17', 'Super Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `ref_plh`
--

CREATE TABLE `ref_plh` (
  `id` tinyint(4) NOT NULL,
  `nama` text NOT NULL,
  `pegawai_id` int(11) DEFAULT NULL,
  `plh_id_jabatan` tinyint(4) NOT NULL,
  `created_on` datetime NOT NULL,
  `created_by` text NOT NULL,
  `modified_on` datetime NOT NULL,
  `modified_by` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ref_plh`
--

INSERT INTO `ref_plh` (`id`, `nama`, `pegawai_id`, `plh_id_jabatan`, `created_on`, `created_by`, `modified_on`, `modified_by`) VALUES
(1, 'Plh Ketua', NULL, 1, '2024-09-23 11:35:04', 'Super Administrator', '2025-06-19 15:12:50', 'Super Administrator'),
(2, 'Plh Panitera', NULL, 4, '2024-09-23 11:35:04', 'Super Administrator', '2025-06-12 11:01:22', 'Plh/Plt KEPALA SUB BAGIAN KEPEGAWAIAN'),
(3, 'Plh Sekretaris', NULL, 5, '2024-09-23 11:35:20', 'Super Administrator', '2025-06-10 12:13:29', 'Plh/Plt KEPALA SUB BAGIAN KEPEGAWAIAN'),
(4, 'Plh Panitera Muda Gugatan', NULL, 6, '2024-09-23 11:35:20', 'Super Administrator', '2024-09-25 14:55:25', 'Super Administrator'),
(5, 'Plh Panitera Muda Permohonan', NULL, 7, '2024-09-23 11:35:49', 'Super Administrator', '2024-09-23 11:35:49', ''),
(6, 'Plh Panitera Muda Jinayat', NULL, 8, '2024-09-23 11:35:49', 'Super Administrator', '2024-09-23 11:35:49', ''),
(7, 'Plh Panitera Muda Hukum', NULL, 9, '2024-09-23 11:36:07', 'Super Administrator', '2024-09-23 11:36:07', ''),
(8, 'Plh Kepala Sub Bagian PTIP', NULL, 12, '2024-09-23 11:36:07', 'Super Administrator', '2025-06-22 05:39:40', 'Super Administrator'),
(9, 'Plh Kepala Sub Bagian Kepegawaian', NULL, 11, '2024-09-23 11:36:24', 'Super Administrator', '2025-04-09 08:04:07', 'Super Administrator'),
(10, 'Plh Kepala Sub Bagian Umum Keuangan', NULL, 10, '2024-09-23 11:36:24', 'Super Administrator', '2025-06-22 05:39:16', 'Super Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `sys_audittrail`
--

CREATE TABLE `sys_audittrail` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Primary key: (by system)',
  `datetime` datetime NOT NULL COMMENT 'Waktu Aktifitas: (by system)',
  `ipaddress` varchar(15) NOT NULL DEFAULT '' COMMENT 'Alamat IP: (by system)',
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT 'Username: (by system)',
  `tablename` varchar(250) NOT NULL DEFAULT '' COMMENT 'Nama Tabel: (by system)',
  `action` varchar(250) NOT NULL DEFAULT '' COMMENT 'Aktifitas: (by system)',
  `title` varchar(500) NOT NULL DEFAULT '' COMMENT 'Keterangan Aktifitas: (by system)',
  `description` longtext DEFAULT NULL COMMENT 'Informasi detil Aktifitas: (by system)'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Data Audittrail';

--
-- Dumping data for table `sys_audittrail`
--

INSERT INTO `sys_audittrail` (`id`, `datetime`, `ipaddress`, `username`, `tablename`, `action`, `title`, `description`) VALUES
(1, '2025-06-23 12:46:53', '127.0.0.1', '199203312020121005', 'register_presensi', 'UPDATE', 'Data Aplikasi HADIR-IN', 'Update Jam Masuk Presensi Pegawai [No Id=<b>23</b>]<br />Update jam masuk <b>register_presensi</b>]');

-- --------------------------------------------------------

--
-- Table structure for table `sys_config`
--

CREATE TABLE `sys_config` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Primari Key',
  `category` varchar(50) NOT NULL DEFAULT 'System' COMMENT 'Kategori Konfigurasi',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT 'Nama Konfigurasi',
  `value` varchar(255) DEFAULT NULL,
  `ordering` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Urutan'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Data Konfigurasi Sistem';

--
-- Dumping data for table `sys_config`
--

INSERT INTO `sys_config` (`id`, `category`, `name`, `value`, `ordering`) VALUES
(1, 'system', 'SiteName', 'LITERASI', 0),
(2, 'system', 'SiteTitle', 'APLIKASI INTERNAL TERINTEGRASI', 0),
(3, 'system', 'KodePN', '401591', 0),
(4, 'system', 'NamaPN', 'MAHKAMAH SYARIYAH BANDA ACEH', 0),
(5, 'system', 'AlamatPN', 'Jl. RSUD MEURAXA, Gp. MIBO, Kec. BANDA RAYA, BANDA ACEH', 0),
(6, 'system', 'KetuaPNNama', NULL, 0),
(7, 'system', 'KetuaPNNIP', NULL, 0),
(8, 'system', 'WakilKetuaPNNama', NULL, 0),
(9, 'system', 'WakilKetuaPNNIP', NULL, 0),
(10, 'system', 'PanNama', NULL, 0),
(11, 'system', 'PanNIP', NULL, 0),
(12, 'system', 'SekNama', NULL, 0),
(13, 'system', 'SekNIP', NULL, 0),
(14, 'system', 'FotoSatker', 'pintu_aceh.webp', 0),
(15, 'system', 'KopSatker', 'kop-fit.webp', 0),
(16, 'system', 'ZonaWaktu', NULL, 0),
(17, 'system', 'NamaPT', 'MAHKAMAH SYARIYAH ACEH', 0),
(18, 'system', 'AlamatPT', 'Jln. T. Nyak Arief - Komplek Keistimewaan Aceh Banda Aceh 23242', 0),
(19, 'system', 'VersiAplikasi', '1.0', 0),
(20, 'system', 'IDPN', '762', 0),
(21, 'System', 'IDPT', '60', 0),
(22, 'System', 'LogoPN', 'logo.webp', 0),
(23, 'System', 'KodeSurat', 'W1-A1', 0),
(24, 'System', 'FormatAgendaSurat', 'NMR_AGENDA/TAHUN_AGENDA', 0),
(25, 'System', 'FormatSuratKeterangan', '#NMR_SK#/SK/HK/#BLN#/#THN#/#KD_PN#', 0),
(26, 'System', 'KodePerkara', 'MS.Bna', 0),
(27, 'System', 'NamaKotaKab', '', 0),
(28, 'System', 'FormatRegisterPenyitaan', '#NMR_SK#/Pen.Pid/#THN#/#KD_PN#', 0),
(29, 'System', 'JamKerjaRamadhan', '0', 0),
(30, 'Presensi', 'JamMulaiApelPagi', '08:00', 0),
(31, 'Presensi', 'JamSelesaiApelPagi', '09:00', 0),
(32, 'Presensi', 'JamMulaiApelSore', '16:45', 0),
(33, 'Presensi', 'JamSelesaiApelSore', '19:00', 0),
(34, 'Presensi', 'IPKantor', '103.106.145.104', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sys_users`
--

CREATE TABLE `sys_users` (
  `userid` int(11) NOT NULL COMMENT 'UserId: (by system)',
  `pegawai_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT 'Nama User: isian bebas',
  `password` varchar(100) NOT NULL DEFAULT '' COMMENT 'Password: sudah di-encript',
  `old_password` varchar(400) NOT NULL DEFAULT '' COMMENT 'Password Lama: menggunakan separator semicolon (by system)',
  `atasan_id` int(11) DEFAULT NULL COMMENT 'Atasan Langsung',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT 'Alamat Email: format email',
  `alternative_email` varchar(255) NOT NULL DEFAULT '' COMMENT 'Alamat Email Alternatif: menggunakan separator semicolon',
  `allow_concurrent_login` tinyint(1) NOT NULL DEFAULT -1 COMMENT 'Diperbolehkan Login Bersamaan: Pilihan (-1=global; 0=single login 1=multiple login)',
  `has_change_password` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Sudah Ganti Password: 0=belum 1=sudah (by system)',
  `enable_change_password` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Diperbolehkan Ganti Password: pilihan 0=Tidak; 1=Ya',
  `last_change_password` datetime DEFAULT NULL COMMENT 'Waktu Terakhir Ganti Password: (by system)',
  `attemp_count` int(11) NOT NULL DEFAULT 0 COMMENT 'Jumlah Kesalahan Password',
  `attemp_time` datetime DEFAULT NULL COMMENT 'Waktu Terakhir Kesalahan Password',
  `last_login` datetime DEFAULT NULL COMMENT 'Tanggal Terakhir Login: (by system)',
  `block` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Blok User: pilihan 0=Tidak; 1=ya',
  `activation` varchar(100) NOT NULL DEFAULT '' COMMENT 'kode aktivasi',
  `code_activation` varchar(100) DEFAULT NULL COMMENT 'kode aktivasi',
  `params` text NOT NULL COMMENT 'parameter lain',
  `created_by` varchar(30) DEFAULT NULL COMMENT 'Diinput Oleh: (by system)',
  `created_on` datetime DEFAULT NULL COMMENT 'Diinput Tanggal: (by system)',
  `modified_by` varchar(30) DEFAULT NULL COMMENT 'Diperbaharui oleh: (by system)',
  `modified_on` datetime DEFAULT NULL COMMENT 'Diperbaharui Tanggal: (by system)',
  `ip_add` varchar(16) DEFAULT NULL COMMENT 'Alamat IP Device',
  `token_pres` varchar(100) DEFAULT NULL COMMENT 'Token Kunci Device Presensi'
) ENGINE=MyISAM AVG_ROW_LENGTH=372 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Data User';

--
-- Dumping data for table `sys_users`
--

INSERT INTO `sys_users` (`userid`, `pegawai_id`, `fullname`, `username`, `password`, `old_password`, `atasan_id`, `email`, `alternative_email`, `allow_concurrent_login`, `has_change_password`, `enable_change_password`, `last_change_password`, `attemp_count`, `attemp_time`, `last_login`, `block`, `activation`, `code_activation`, `params`, `created_by`, `created_on`, `modified_by`, `modified_on`, `ip_add`, `token_pres`) VALUES
(1, 1, 'Super Administrator', 'admin', 'd96683df9b4dc1d5869000e159ecf959', '9e24d23de65f136b32ef8ffaad9d2086;9e24d23de65f136b3', 0, 'mskotabandaaceh@gmail.com', '', -1, 0, 1, NULL, 0, NULL, '2025-06-24 10:32:16', 0, 'b1a9d413781b40e7961c8c48a024f24e', '504996f145394801bc14a143164308bf', '', NULL, NULL, 'Super Administrator', '2025-06-20 08:11:56', NULL, 'e60ac6a33d2879a2742b2d25958a4b7b');

-- --------------------------------------------------------

--
-- Table structure for table `sys_user_online`
--

CREATE TABLE `sys_user_online` (
  `id` bigint(20) NOT NULL COMMENT 'SessionId (by system)',
  `userid` int(10) UNSIGNED NOT NULL COMMENT 'UserId: merujuk ke tabel sys_users ke kolom userid (by system)',
  `host_address` varchar(50) NOT NULL DEFAULT '' COMMENT 'Alamat IP (by system)',
  `login_time` timestamp NULL DEFAULT current_timestamp() COMMENT 'Waktu login (by system)',
  `user_agent` varchar(255) NOT NULL DEFAULT '' COMMENT 'Jenis browser (by system)',
  `uri` varchar(1024) NOT NULL DEFAULT '' COMMENT 'Alamat URL (by system)',
  `current_page` varchar(50) NOT NULL DEFAULT '' COMMENT 'Halaman saat ini (by system)',
  `last_visit` datetime DEFAULT NULL COMMENT 'Terakhir Berkunjung (by system)',
  `data` text DEFAULT NULL COMMENT 'Data Lain (by system)'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Data User Yang Sedang Online';

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_pegawai`
-- (See below for the actual view)
--
CREATE TABLE `v_pegawai` (
`id` int(10) unsigned
,`nip` varchar(20)
,`nama` varchar(50)
,`alamat` varchar(255)
,`nama_gelar` varchar(50)
,`gol_id` int(11)
,`ket` varchar(255)
,`golongan` varchar(20)
,`pangkat` varchar(30)
,`jab_id` int(11)
,`jk` tinyint(1)
,`nama_jabatan` varchar(100)
,`id_grup` varchar(5)
,`grup_jabatan` varchar(50)
,`foto` text
,`ttd` text
,`tmt` date
,`nohp` varchar(50)
,`status_pegawai` tinyint(1)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_plh`
-- (See below for the actual view)
--
CREATE TABLE `v_plh` (
`id` tinyint(4)
,`nama` text
,`pegawai_id` int(11)
,`nama_pegawai` varchar(50)
,`jabatan` varchar(100)
,`plh_id_jabatan` tinyint(4)
,`nama_jabatan` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_users`
-- (See below for the actual view)
--
CREATE TABLE `v_users` (
`userid` int(11)
,`pegawai_id` int(11)
,`fullname` varchar(255)
,`nama` varchar(50)
,`nip` varchar(20)
,`nohp` varchar(50)
,`jab_id` int(11)
,`jabatan` varchar(100)
,`id_grup` varchar(5)
,`grup_jabatan` varchar(50)
,`foto` text
,`ttd` text
,`tmt` date
,`jk` tinyint(1)
,`atasan_id` int(11)
,`atasan_jabatan` varchar(100)
,`nama_atasan_no_gelar` varchar(50)
,`nip_atasan` varchar(20)
,`nama_atasan` varchar(50)
,`id_jab_atasan` int(11)
,`jabatan_atasan` varchar(100)
,`hp_atasan` varchar(50)
,`username` varchar(30)
,`password` varchar(100)
,`email` varchar(100)
,`alternative_email` varchar(255)
,`last_login` datetime
,`block` tinyint(1)
,`activation` varchar(100)
,`code_activation` varchar(100)
,`status_pegawai` tinyint(1)
,`ip` varchar(16)
,`token` varchar(100)
);

-- --------------------------------------------------------

--
-- Structure for view `v_pegawai`
--
DROP TABLE IF EXISTS `v_pegawai`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pegawai`  AS SELECT `pegawai`.`id` AS `id`, `pegawai`.`nip` AS `nip`, `pegawai`.`nama` AS `nama`, `pegawai`.`alamat` AS `alamat`, `pegawai`.`nama_gelar` AS `nama_gelar`, `pegawai`.`golongan_id` AS `gol_id`, `pegawai`.`keterangan` AS `ket`, `ref_pangkat`.`golongan` AS `golongan`, `ref_pangkat`.`pangkat` AS `pangkat`, `pegawai`.`jabatan_id` AS `jab_id`, `pegawai`.`jk` AS `jk`, `ref_jabatan`.`nama_jabatan` AS `nama_jabatan`, `pegawai`.`jenis_pegawai` AS `id_grup`, `ref_group_jabatan`.`group_jabatan` AS `grup_jabatan`, `pegawai`.`foto` AS `foto`, `pegawai`.`ttd` AS `ttd`, `pegawai`.`tmt` AS `tmt`, `pegawai`.`nohp` AS `nohp`, `pegawai`.`status_pegawai` AS `status_pegawai` FROM (((`pegawai` left join `ref_pangkat` on(`pegawai`.`golongan_id` = `ref_pangkat`.`id`)) left join `ref_jabatan` on(`pegawai`.`jabatan_id` = `ref_jabatan`.`id`)) left join `ref_group_jabatan` on(`pegawai`.`jenis_pegawai` = `ref_group_jabatan`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_plh`
--
DROP TABLE IF EXISTS `v_plh`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_plh`  AS SELECT `pl`.`id` AS `id`, `pl`.`nama` AS `nama`, `pl`.`pegawai_id` AS `pegawai_id`, `p`.`nama_gelar` AS `nama_pegawai`, `p`.`nama_jabatan` AS `jabatan`, `pl`.`plh_id_jabatan` AS `plh_id_jabatan`, `j`.`nama_jabatan` AS `nama_jabatan` FROM ((`ref_plh` `pl` left join `v_pegawai` `p` on(`pl`.`pegawai_id` = `p`.`id`)) left join `ref_jabatan` `j` on(`pl`.`plh_id_jabatan` = `j`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_users`
--
DROP TABLE IF EXISTS `v_users`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_users`  AS SELECT `u`.`userid` AS `userid`, `u`.`pegawai_id` AS `pegawai_id`, `u`.`fullname` AS `fullname`, `p`.`nama` AS `nama`, `p`.`nip` AS `nip`, `p`.`nohp` AS `nohp`, `p`.`jab_id` AS `jab_id`, `p`.`nama_jabatan` AS `jabatan`, `p`.`id_grup` AS `id_grup`, `p`.`grup_jabatan` AS `grup_jabatan`, `p`.`foto` AS `foto`, `p`.`ttd` AS `ttd`, `p`.`tmt` AS `tmt`, `p`.`jk` AS `jk`, `u`.`atasan_id` AS `atasan_id`, `j`.`nama_jabatan` AS `atasan_jabatan`, `pe`.`nama` AS `nama_atasan_no_gelar`, `pe`.`nip` AS `nip_atasan`, `pe`.`nama_gelar` AS `nama_atasan`, `pe`.`jab_id` AS `id_jab_atasan`, `pe`.`nama_jabatan` AS `jabatan_atasan`, `pe`.`nohp` AS `hp_atasan`, `u`.`username` AS `username`, `u`.`password` AS `password`, `u`.`email` AS `email`, `u`.`alternative_email` AS `alternative_email`, `u`.`last_login` AS `last_login`, `u`.`block` AS `block`, `u`.`activation` AS `activation`, `u`.`code_activation` AS `code_activation`, `p`.`status_pegawai` AS `status_pegawai`, `u`.`ip_add` AS `ip`, `u`.`token_pres` AS `token` FROM (((`sys_users` `u` left join `v_pegawai` `p` on(`p`.`id` = `u`.`pegawai_id`)) left join `v_pegawai` `pe` on(`pe`.`jab_id` = `u`.`atasan_id` and `pe`.`status_pegawai` = 1)) left join `ref_jabatan` `j` on(`j`.`id` = `u`.`atasan_id`)) WHERE `u`.`userid` is not null ORDER BY `p`.`jab_id` ASC, `p`.`id_grup` ASC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `nama` (`nama`),
  ADD KEY `nama_gelar` (`nama_gelar`),
  ADD KEY `diinput_tanggal` (`diinput_tanggal`),
  ADD KEY `diperbaharui_tanggal` (`diperbaharui_tanggal`);

--
-- Indexes for table `ref_client_app`
--
ALTER TABLE `ref_client_app`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_group_jabatan`
--
ALTER TABLE `ref_group_jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_jabatan`
--
ALTER TABLE `ref_jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_pangkat`
--
ALTER TABLE `ref_pangkat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_plh`
--
ALTER TABLE `ref_plh`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_audittrail`
--
ALTER TABLE `sys_audittrail`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `sys_config`
--
ALTER TABLE `sys_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `sys_users`
--
ALTER TABLE `sys_users`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `username_2` (`username`);

--
-- Indexes for table `sys_user_online`
--
ALTER TABLE `sys_user_online`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary key: (by system)', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ref_client_app`
--
ALTER TABLE `ref_client_app`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ref_group_jabatan`
--
ALTER TABLE `ref_group_jabatan`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ref_jabatan`
--
ALTER TABLE `ref_jabatan`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `ref_pangkat`
--
ALTER TABLE `ref_pangkat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `ref_plh`
--
ALTER TABLE `ref_plh`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sys_audittrail`
--
ALTER TABLE `sys_audittrail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary key: (by system)', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sys_config`
--
ALTER TABLE `sys_config`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primari Key', AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `sys_users`
--
ALTER TABLE `sys_users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'UserId: (by system)', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sys_user_online`
--
ALTER TABLE `sys_user_online`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'SessionId (by system)';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
