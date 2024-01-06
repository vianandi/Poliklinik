-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Jan 2024 pada 06.57
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `poliklinik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_poli`
--

CREATE TABLE `daftar_poli` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_pasien` int(11) UNSIGNED NOT NULL,
  `id_jadwal` int(11) UNSIGNED NOT NULL,
  `keluhan` text NOT NULL,
  `no_antrian` int(11) UNSIGNED NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftar_poli`
--

INSERT INTO `daftar_poli` (`id`, `id_pasien`, `id_jadwal`, `keluhan`, `no_antrian`, `tanggal`) VALUES
(1, 9, 6, 'Mata Merah ', 1, '2023-12-30 03:00:13'),
(2, 9, 6, 'Mata Merah', 2, '2023-12-30 03:01:19'),
(3, 10, 9, 'Gigi berlubang', 1, '2023-12-30 03:32:48'),
(4, 10, 1, 'Mata Sharingan', 1, '2023-12-30 03:33:43'),
(5, 10, 9, 'Ggi Berlubang', 2, '2023-12-30 03:52:11'),
(6, 14, 9, 'Gigi rontok', 3, '2023-12-30 03:54:42'),
(7, 14, 1, 'Tidak bisa keluar sharingan', 2, '2023-12-31 05:17:24'),
(8, 15, 1, 'Mata kiri terasa sakit dan merah.', 3, '2023-12-31 05:32:30'),
(9, 15, 9, 'Gigi berlubang', 4, '2024-01-02 02:10:01'),
(10, 9, 5, 'Mata bengkak', 1, '2024-01-02 02:13:46'),
(11, 10, 8, 'Mata merah dan sakit.', 1, '2024-01-02 06:25:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_periksa`
--

CREATE TABLE `detail_periksa` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_periksa` int(11) UNSIGNED NOT NULL,
  `id_obat` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_periksa`
--

INSERT INTO `detail_periksa` (`id`, `id_periksa`, `id_obat`) VALUES
(1, 1, 5),
(2, 2, 14);

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `id_poli` int(11) UNSIGNED NOT NULL,
  `nip` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dokter`
--

INSERT INTO `dokter` (`id`, `nama`, `alamat`, `no_hp`, `id_poli`, `nip`, `password`) VALUES
(11, 'Dr Vian', 'Jl. Sempalan', '085483446785', 3, '2001359094084', '$2y$10$z/Hj49/CqCk1dpbT7ghZE.BNo2JVoB8GlgtXblKNydpr6d4VcHANC'),
(12, 'Dr Strange', 'Neptunus', '085483446782', 3, '200313244634', '$2y$10$MRfwEftLuWXvIilUJZrEouerSeuumDVSBQM1O2E1zRCHZsRJ8l6XW'),
(13, 'Dr Beatrix', 'Merkurius', '085362738785', 1, '2005367874289', '$2y$10$FqCT8NTbig2KnJIQj5s1uuxHSYHYSUgmJsIV3K6uf5o2As1qX2Mx6'),
(15, 'Dr Brok', 'Venus', '085362738781', 3, '2009359094081', '$2y$10$QwfMVWsSvavJvv8h0axDDuum5bFb1vAEwhs/tVfYFzzIcoFL4mWtm');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_periksa`
--

CREATE TABLE `jadwal_periksa` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_dokter` int(11) UNSIGNED NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal_periksa`
--

INSERT INTO `jadwal_periksa` (`id`, `id_dokter`, `hari`, `jam_mulai`, `jam_selesai`) VALUES
(1, 11, 'Selasa', '08:59:43', '10:59:43'),
(2, 12, 'Rabu', '22:29:00', '23:29:00'),
(3, 12, 'Kamis', '23:47:00', '03:47:00'),
(4, 12, 'Sabtu', '08:00:00', '11:00:00'),
(5, 11, 'Jumat', '03:00:00', '05:00:00'),
(6, 12, 'Kamis', '08:00:00', '11:00:00'),
(7, 12, 'Jumat', '08:00:00', '11:00:00'),
(8, 11, 'Jumat', '08:00:00', '11:00:00'),
(9, 13, 'Jumat', '08:00:00', '10:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE `obat` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_obat` varchar(50) NOT NULL,
  `kemasan` varchar(35) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`id`, `nama_obat`, `kemasan`, `harga`) VALUES
(5, 'Xanax', 'Strip', 25000),
(8, 'Paramex', 'Strip', 35500),
(9, 'Albendazol tablet 400mg', 'Kotak 5 x 6 tablet', 16470),
(10, 'Alopurinol tablet 100mg', 'Kotak 10 x 10 tablet', 17820),
(11, 'Alopurinol tablet 300mg', 'Kotak 3 x 10 tablet', 9923),
(12, 'Alprazolam tablet 0,5 mg', 'Kotak 10 x 10 tablet', 78975),
(13, 'Alprazolam tablet 1 mg', 'Kotak 10 x 10 tablet', 121500),
(14, 'Ibuprofen tablet 400 mg', 'Kotak 10 x 10 tablet', 27680),
(15, 'Ambroxol tablet 30 mg', 'Kotak 10 x 10 tablet', 16884),
(16, 'Amilorida tablet 5 mg (HCl)', 'Kotak 10 x 10 tablet', 11906),
(17, 'Aminofilin tablet 150 mg', 'Botol 1000 tablet', 58757),
(18, 'Amlodipin tablet 10 mg', 'Kotak 3 x 10 tablet', 68580),
(19, 'Amoksisilin kapsul 250 mg', 'Kotak 10 x 10 kapsul', 38799),
(20, 'Ampisilin kaplet 250 mg', 'Kotak 10 x 10 kaplet', 36315),
(21, 'Betahistin Mesilat tablet 6 mg', 'Kotak 3 x 10 tablet', 37422),
(22, 'Bisoprolol tablet 5 mg', 'Kotak 3 x 10 tablet', 94028),
(23, 'Cetirizine tablet 10 mg', 'Kotak 3 x 10 tablet', 13365),
(24, 'Cisapride tablet 10 mg', 'Kotak 10 x 10 tablet', 183398),
(25, 'Dapson tablet 100 mg', 'Botol 1000 tablet', 42525),
(26, 'Diazepam tablet 2 mg', 'Botol 100 tablet', 4307),
(27, 'Diazepam tablet 2 mg', 'Botol 1000 tablet', 42822),
(28, 'Efedrin tablet 25 mg (HCl)', 'Botol 250 tablet', 17300),
(29, 'Eritromisin kapsul 250 mg', 'Kotak 10 x 10 tablet', 68040),
(30, 'Etoposid kapsul 100 mg', 'Botol 10 kapsul', 94238),
(31, 'Famotidine tablet 40 mg', 'Kotak 5 x 10 tablet', 11948),
(32, 'Fenilbutason tablet 200 mg', 'Kotak 15 x 10 tablet', 19643),
(33, 'Fenobarbital tablet 30 mg', 'Kotak 10 x 10 tablet', 8762),
(34, 'Gemfibrozil kapsul 300 mg', 'Kotak 12 x 10 kapsul', 47115),
(35, 'Glimepiride tablet 1 mg', 'Kotak 5 x 10 tablet', 51305),
(36, 'Gliquidon tablet 30 mg', 'Kotak 10 x 10 tablet', 87114),
(37, 'Haloperidol tablet 5 mg', 'Kotak 10 x 10 tablet', 16509),
(38, 'Haloperidol tablet 2 mg', 'Kotak 10 x 10 tablet', 12859),
(39, 'Hidroklorotiazida tablet 25 mg', 'Botol 1000 tablet', 49005),
(40, 'Indometasin kapsul 25 mg', 'Kotak 10 x 10 tablet', 5347),
(41, 'Isoniazid tablet 100 mg', 'Kotak 10 x 10 tablet', 5940),
(42, 'Itrakonazol kapsul 100 mg', 'Kotak 3 x 10 kapsul', 58482),
(43, 'Kalium Diklofenak tablet 25 mg', 'Kotak 5 x 10 tablet', 26382),
(44, 'Kalsium Karbonat tablet 500 mg', 'Botol 100 tablet', 5835),
(45, 'Kaptopril tablet 25 mg', 'Kotak 6 x 10 tablet', 11613),
(46, 'Levamisol tablet 50 mg', 'Botol 25 tablet', 3983),
(47, 'Levofloksasin tablet 500 mg', 'Kotak 5 x 10 tablet', 77873),
(48, 'Linkomisin kapsul 500 mg', 'Kotak 5 x 10 tablet', 43875),
(49, 'Mebendazol tablet 100 mg', 'Kotak 5 x 6 tablet', 8775),
(50, 'Meloksikam tablet 15 mg', 'Kotak 5 x 10 tablet', 80933),
(51, 'Metformin HCl tablet 500 mg', 'Kotak 10 x 10 tablet', 24503),
(52, 'Natrium Bikarbonat tablet 500 mg', 'Botol 1000 tablet', 19305),
(53, 'Natrium Diklofenak tablet 50 mg', 'Kotak 5 x 10 tablet', 14693),
(54, 'Nevirapin tablet 200 mg', 'Botol 60 tablet', 211613),
(55, 'Ofloxacin tablet 200 mg', 'Kotak 5 x 10 tablet', 39832),
(56, 'Omeprazol kapsul 20 mg', 'Botol 7 kapsul', 7271),
(57, 'Oseltamivir 75 mg', 'Kotak 10', 175500),
(58, 'Papaverin tablet 40 mg', 'Botol 1000 tablet', 134325),
(59, 'Parasetamol tablet 500 mg', 'Kotak 10 x 10 tablet', 14175),
(60, 'Perfenazin tablet 4 mg (HCl)', 'Botol 100 tablet', 7425),
(61, 'Ranitidin tablet 150 mg', 'Kotak 3 x 10 tablet', 8910),
(62, 'Reserpin tablet 0,25 mg', 'Botol 1000 tablet', 118800),
(63, 'Risperidon tablet 1 mg', 'Kotak 5 x 10 tablet', 126968),
(64, 'Sefadroksil kapsul 250 mg', 'Kotak 3 x 10 kapsul', 18025),
(65, 'Sefadroksil kapsul 500 mg', 'Kotak 10 x 10 kapsul', 113400),
(66, 'Sefaklor kapsul 500 mg', 'Kotak 3 x 10 kapsul', 88455),
(67, 'Tamoksifen tablet 20 mg', 'Botol 30 tablet', 52838),
(68, 'Teofilin tablet 150 mg', 'Kotak 10 x 10 tablet', 7339),
(69, 'Tetrasiklin kapsul 250 mg', 'Kotak 10 x 10 tablet', 18900),
(70, 'Valproat tablet 150 mg', 'Botol 50 tablet', 15922),
(71, 'Verapamil tablet 80 mg (HCl)', 'Kotak 10 x 10 tablet', 47540),
(72, 'Vitamin B Kompleks tablet', 'Botol 1000 tablet', 29970),
(73, 'Zidovudin 300 mg + Lamivudine 150 mg', 'Botol 60 tablet', 252450),
(74, 'Zidovudin tablet 100 mg', 'Botol 60 tablet', 76849),
(75, 'Zinc tablet 20 mg', 'Kotak 10 x 10 tablet', 64125);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_ktp` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `no_rm` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id`, `nama`, `alamat`, `no_ktp`, `no_hp`, `no_rm`) VALUES
(9, 'Dean', 'Merkurius', '3319657182987776', '085483446785', '202312-001'),
(10, 'Vian', 'Mars', '3319657182987778', '085362738781', '202312-002'),
(14, 'Sir Pai', 'Jupiter', '3319657182987772', '085483446781', '202312-003'),
(15, 'Sir V', 'Mars', '3319657182987773', '085483446783', '202312-004');

-- --------------------------------------------------------

--
-- Struktur dari tabel `periksa`
--

CREATE TABLE `periksa` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_daftar_poli` int(11) UNSIGNED NOT NULL,
  `tgl_periksa` datetime NOT NULL,
  `catatan` text NOT NULL,
  `biaya_periksa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `periksa`
--

INSERT INTO `periksa` (`id`, `id_daftar_poli`, `tgl_periksa`, `catatan`, `biaya_periksa`) VALUES
(1, 7, '2024-01-01 03:22:47', 'Minum obat 3x sehari', 175000),
(2, 10, '2024-01-02 03:24:06', 'Minum obat 3x sehari', 177680);

-- --------------------------------------------------------

--
-- Struktur dari tabel `poli`
--

CREATE TABLE `poli` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_poli` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `poli`
--

INSERT INTO `poli` (`id`, `nama_poli`, `keterangan`) VALUES
(1, 'Gigi', 'Poliklinik Gigi'),
(3, 'Mata', 'Poliklinik Mata'),
(5, 'Anak', 'Poliklinik Anak'),
(6, 'THT', 'Poliklinik THT'),
(7, 'Jantung', 'Poliklinik Jantung');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`, `role`) VALUES
(1, 'vian', 'vian', '$2y$10$4Lf39WK3B1FE24kkpXieC.WFlXCc9u9Hed3WZ/jqHIhUA2BegWOUW', 1),
(6, 'admin', 'admin', '$2y$10$x9DUll82zt3c85rdnU8G9uFhGKqCIHBW4tsx1wXyFm5gIIS9yUydq', 0),
(7, 'Andi', 'vian admin', '$2y$10$8fGUq8MQDN15vQ7nBT6AUOa.u6o/mPsbeoVcOnfZWKIa2ATKwk70C', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pasien_daftar_poli` (`id_pasien`),
  ADD KEY `fk_daftar_jadwal_periksa` (`id_jadwal`);

--
-- Indeks untuk tabel `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detail_periksa` (`id_periksa`),
  ADD KEY `fk_detail_periksa_obat` (`id_obat`);

--
-- Indeks untuk tabel `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dokter_poli` (`id_poli`);

--
-- Indeks untuk tabel `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dokter_jadwal_periksa` (`id_dokter`);

--
-- Indeks untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `periksa`
--
ALTER TABLE `periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_periksa_daftar_poli` (`id_daftar_poli`);

--
-- Indeks untuk tabel `poli`
--
ALTER TABLE `poli`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `daftar_poli`
--
ALTER TABLE `daftar_poli`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `detail_periksa`
--
ALTER TABLE `detail_periksa`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT untuk tabel `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `periksa`
--
ALTER TABLE `periksa`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `poli`
--
ALTER TABLE `poli`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD CONSTRAINT `fk_daftar_jadwal_periksa` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_periksa` (`id`),
  ADD CONSTRAINT `fk_pasien_daftar_poli` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`);

--
-- Ketidakleluasaan untuk tabel `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD CONSTRAINT `fk_detail_periksa` FOREIGN KEY (`id_periksa`) REFERENCES `periksa` (`id`),
  ADD CONSTRAINT `fk_detail_periksa_obat` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`);

--
-- Ketidakleluasaan untuk tabel `dokter`
--
ALTER TABLE `dokter`
  ADD CONSTRAINT `fk_dokter_poli` FOREIGN KEY (`id_poli`) REFERENCES `poli` (`id`);

--
-- Ketidakleluasaan untuk tabel `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD CONSTRAINT `fk_dokter_jadwal_periksa` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`);

--
-- Ketidakleluasaan untuk tabel `periksa`
--
ALTER TABLE `periksa`
  ADD CONSTRAINT `fk_periksa_daftar_poli` FOREIGN KEY (`id_daftar_poli`) REFERENCES `daftar_poli` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
