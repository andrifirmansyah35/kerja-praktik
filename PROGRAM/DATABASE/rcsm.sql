-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2022 at 06:36 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rcsm`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(5) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `nama_lengkap` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'ahsyandri@gmail.com', '$2y$10$TycqO8ASVmZuUrXgji6rdu2hxD36TKGaGs55F/yrK63XMDYApvji.', 'Andri Firmansyah Putra'),
(2, 'AdminRCSMBantul', '$2y$10$Snnqhf/5DM8t0nltYEWXsuKD9lwWjHfM12uBRQyihXKc9SXJBHDFW', 'andri firmansyah putra');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama`) VALUES
(2, 'kulit kepala dan rambut '),
(9, 'anti aging'),
(18, 'perawatan kulit'),
(19, 'jerawat dan blemish'),
(26, 'perangkat kecantikan');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `id_pelangan` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `jumlah_barang` int(11) DEFAULT NULL,
  `total_harga` bigint(20) DEFAULT NULL,
  `status_barang` enum('tersedia','stok tidak tersedia') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pelangan`
--

CREATE TABLE `pelangan` (
  `id_pelangan` int(11) NOT NULL,
  `nama` varchar(90) DEFAULT NULL,
  `telp` varchar(14) DEFAULT NULL,
  `email` varchar(90) DEFAULT NULL,
  `paswd` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelangan`
--

INSERT INTO `pelangan` (`id_pelangan`, `nama`, `telp`, `email`, `paswd`) VALUES
(1, 'Andri Firmansyah Putr haha', '0896323111', 'ahsyandri@gmail.com', '$2y$10$9Q/ByER/XHe24jHl9g6Z..ESmhei06wJ1SrCQAyz0V0MzPQfF2zA6'),
(2, 'Vinda Rismaputria', '089632311271', 'vinduy@gmail.com', '$2y$10$9Q/ByER/XHe24jHl9g6Z..ESmhei06wJ1SrCQAyz0V0MzPQfF2zA6'),
(14, 'levi_king', '089632311271', 'levi@gmail.com', '$2y$10$xAvEUe7x4vqcoIaVjhTiceCpCAjY810h5w05aL4GJAh07Fd7/lnHm'),
(15, 'eni rohmani', '089633211178', 'enirohmani@gmail.com', '$2y$10$TVdefVwYhcd64lo5b8V8eeE9qc/CSb1LXcwPoJExcDzuIqF3NxSgi'),
(16, 'Dwi Agus', '089644321172', 'dwiagus@gmail.com', '$2y$10$1Jno2PvgUfAFlVsuOen4OuwWOIm4MBaB8wlKxRCc9cCUnucTU41Am');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `id_pelangan` int(11) DEFAULT NULL,
  `ekspedisi` varchar(255) NOT NULL,
  `ekspedisi_kota` varchar(255) NOT NULL,
  `ekspedisi_paket` varchar(255) NOT NULL,
  `berat` int(11) NOT NULL,
  `biaya_pengiriman` bigint(20) DEFAULT NULL,
  `total_pembayaran` bigint(20) DEFAULT NULL,
  `alamat_pengiriman` varchar(255) NOT NULL,
  `bukti_pembayaran` varchar(60) DEFAULT NULL,
  `batas_pembayaran` date DEFAULT NULL,
  `tanggal_pembayaran` date DEFAULT NULL,
  `status_pembelian` enum('belum bayar','menungu konfirmasi','selesai','pemesanan melewati waktu','pemesanan gagal','pesanan batal','pesanan dikemas','pesanan dikirim') DEFAULT NULL,
  `bulan_pembayaran` varchar(2) DEFAULT NULL,
  `tahun_pembayaran` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `id_pelangan`, `ekspedisi`, `ekspedisi_kota`, `ekspedisi_paket`, `berat`, `biaya_pengiriman`, `total_pembayaran`, `alamat_pengiriman`, `bukti_pembayaran`, `batas_pembayaran`, `tanggal_pembayaran`, `status_pembelian`, `bulan_pembayaran`, `tahun_pembayaran`) VALUES
(42, 2, 'tiki', 'Kulon Progo', 'REG(4 hari) Rp.13000', 735, 13000, 763000, 'Glagah', '61f20a95c70a2.png', '2021-11-03', '2021-11-03', 'selesai', '11', '2021'),
(43, 2, 'pos', 'Kulon Progo', 'Express Next Day Barang(1 HARI hari) Rp.90000', 8560, 90000, 3072000, 'kadipaten pantehan', '61f2135454ca1.jpg', '2021-11-04', '2021-11-04', 'selesai', '11', '2021'),
(44, 1, 'pos', 'Kulon Progo', 'Paket Kilat Khusus(2 HARI hari) Rp.7000', 490, 7000, 507000, 'Mrisisi ', '61f350a7dec20.png', '2021-12-03', '2021-12-03', 'selesai', '12', '2021'),
(45, 1, 'pos', 'Gunung Kidul', 'Express Next Day Barang(1 HARI hari) Rp.10000', 610, 10000, 574000, 'Mendayu kidol RT2 Kalimoyo', '61f3539adb754.jpg', '2022-01-16', '2021-12-15', 'selesai', '12', '2021'),
(47, 2, 'tiki', 'Gunung Kidul', 'ECO(4 hari) Rp.7000', 240, 7000, 231000, 'Mrisi RT 11 Tirtonirmolo Kasihan Bantul', '61fcc8f42eb21.jpg', '2022-01-18', '2021-12-18', 'selesai', '12', '2021'),
(48, 2, 'tiki', 'Kulon Progo', 'REG(4 hari) Rp.13000', 375, 13000, 355000, 'Magetan RT11 Kulon Progo', '61fd06cb5cb62.jpg', '2022-02-05', '2022-02-04', 'selesai', '02', '2022'),
(49, 15, 'tiki', 'Gunung Kidul', 'REG(2 hari) Rp.11000', 820, 11000, 1171000, 'Menekan RT 5 Gunung Kidul', '61fdc4df011e5.jpg', '2022-02-06', '2022-02-05', 'selesai', '02', '2022'),
(50, 15, 'jne', 'Bantul', 'CTC(1-2 hari) Rp.6000', 150, 6000, 360000, 'Mrisi RT 11 Kasihan Bantul', '61fdd2b553709.png', '2022-01-06', '2022-01-05', 'selesai', '01', '2022'),
(51, 15, 'tiki', 'Bantul', 'REG(2 hari) Rp.11000', 360, 11000, 347000, 'Sengotan RT5 ', NULL, '2022-02-06', NULL, 'belum bayar', NULL, NULL),
(52, 15, 'pos', 'Bantul', 'Paket Kilat Khusus(2 HARI hari) Rp.7000', 240, 7000, 231000, 'Sewon permai ', NULL, '2022-02-06', NULL, 'pesanan batal', NULL, NULL),
(53, 2, 'pos', 'Bantul', 'Pos Instan Barang(0 HARI hari) Rp.12000', 308, 12000, 775995, 'Mrisi RT 11 Tirtonirmolo', '61fde5c0dbfbe.jpg', '2022-02-06', '2022-02-05', 'selesai', '02', '2022'),
(54, 2, 'pos', 'Sleman', 'Paket Kilat Khusus(3 HARI hari) Rp.7000', 375, 7000, 337000, 'UTY', NULL, '2022-02-06', NULL, 'pesanan batal', NULL, NULL),
(55, 1, 'tiki', 'Yogyakarta', 'ECO(4 hari) Rp.7000', 800, 7000, 137000, 'Moyudan RT 5 ', '61fe513dec007.jpg', '2022-02-06', '2022-02-05', 'pesanan dikirim', '02', '2022');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_detail`
--

CREATE TABLE `pembelian_detail` (
  `id_detail_pembelian` int(11) NOT NULL,
  `id_pelangan` int(11) DEFAULT NULL,
  `id_pembelian` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `harga` bigint(20) NOT NULL,
  `jumlah_barang` int(11) DEFAULT NULL,
  `total_harga` bigint(20) DEFAULT NULL,
  `keuntungan_perproduk` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian_detail`
--

INSERT INTO `pembelian_detail` (`id_detail_pembelian`, `id_pelangan`, `id_pembelian`, `id_produk`, `harga`, `jumlah_barang`, `total_harga`, `keuntungan_perproduk`) VALUES
(64, 2, 42, 1, 200000, 3, 600000, 573000),
(65, 2, 42, 6, 50000, 3, 150000, 15000),
(66, 2, 43, 15, 8000, 4, 32000, 12000),
(67, 2, 43, 29, 2950000, 1, 2950000, 550000),
(68, 1, 44, 1, 200000, 2, 400000, 382000),
(69, 1, 44, 6, 50000, 2, 100000, 10000),
(70, 1, 45, 6, 112000, 3, 150000, 133500),
(71, 1, 45, 1, 114000, 2, 400000, 201418),
(72, 1, 46, 15, 8000, 2, 16000, 6000),
(73, 2, 47, 6, 112000, 2, 224000, 89000),
(74, 2, 48, 1, 114000, 3, 342000, 302127),
(75, 15, 49, 7, 65000, 2, 130000, 25200),
(76, 15, 49, 19, 1030000, 1, 1030000, 140005),
(77, 15, 50, 26, 177000, 2, 354000, 66000),
(78, 15, 51, 6, 112000, 3, 336000, 133500),
(79, 15, 52, 6, 112000, 2, 224000, 89000),
(80, 2, 53, 6, 112000, 2, 224000, 89000),
(81, 2, 53, 21, 539995, 1, 539995, 89995),
(82, 2, 54, 1, 110000, 3, 330000, 120000),
(83, 1, 55, 7, 65000, 2, 130000, 25200);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `nama` varchar(75) DEFAULT NULL,
  `harga_beli` bigint(20) NOT NULL,
  `harga` bigint(13) DEFAULT NULL,
  `profit` bigint(18) NOT NULL,
  `gambar` varchar(100) DEFAULT NULL,
  `stok` int(15) DEFAULT NULL,
  `deskripsi` varchar(1000) DEFAULT NULL,
  `berat` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `id_kategori`, `nama`, `harga_beli`, `harga`, `profit`, `gambar`, `stok`, `deskripsi`, `berat`) VALUES
(1, 18, 'ageLOC® Y-Span ubah', 70000, 110000, 40000, '61f1815304577.png', 90, 'Suplemen revolusioner yang dirancang untuk meningkatkan durasi kemudaan Anda - tahun-tahun di mana Anda dapat menikmati hidup dengan lebih aktif, energik dan sehat.', 125),
(6, 2, 'nilion repear', 67500, 112000, 44500, '61f1817e52a7f.png', 90, 'Bayangkan ', 120),
(7, 2, 'lithimium regen', 52400, 65000, 12600, '61f181a294936.png', 71, ' iHIUHA iag gIG  yufA  ', 400),
(15, 2, 'produk revisii', 5000, 8000, 3000, '61f2268ed31bf.png', 8, 'Produk ini adalah produk kw jangan dibeli', 2000),
(17, 9, 'Nu Skin 180°® Face Wash', 450000, 530000, 80000, '61f16d993685a.png', 20, 'Nu Skin 180°® Face Wash mengandung 10 persen Vitamin C aktif yang efektif, menjadikan produk ini sebagai salah satu pembersih anti penuaan yang luar biasa. Tingkat konsentrat Vitamin C dalam produk ini menjadi senjata yang kuat dalam menghadapi berbagai tanda penuaan. Selain mengatasi noda-noda penuaan dan perubahan warna pada kulit, formula krim ini juga membantu mendukung produksi kolagen untuk menghilangkan garis-garis halus dan kerut. Rawat kulit Anda dengan Nu Skin 180°® Face Wash untuk kulit wajah yang segar, bersih, dan tampak lebih muda.', 24),
(18, 9, ' Nu Skin 180° Skin Mist', 420000, 505000, 85000, '61f16e7643cad.png', 8, 'Kulit cantik hari ini untuk kulit yang lebih sehat di esok hari. Mengandung di-peptide dan tri-peptide yang dapat membantu mengurangi terbentuknya kerutan dan kulit kendur di masa dating. Ekstrak jamur secara eksklusif memperbaiki dan mengencangkan pori –pori, menyejukkan dengan HMW complex untuk menenagkan dan melindungi kulit.', 100),
(19, 9, ' Nu Skin 180° AHA Facial Peel', 889995, 1030000, 140005, '61f176f540709.png', 4, 'Menghapus kesuraman kulit menua dalam hitungan menit. Dengan memanfaatkan 10% larutan lacticacid, formula yang telah terbukti secara ilmiah ini menghilangkan penampakan dari penuaan dan kerusakan yang diakibatkan oleh paparan sinar matahari. Sangat efektif membantu menstimulasi pembaruan sel serta memperkuat sintesis kolagen untuk meghasilkan kulit yang lebih halus dan terlihat lebih muda.', 20),
(20, 9, 'Tru Face Revealing Gel', 423998, 524000, 100002, '61f1789aba01c.png', 11, 'Melawan tanda-tanda penuaan tanpa iritasi. Mengandung polyhydroxy acids(PHAs) yang efektif seperti alpha hydroxyl acids (AHAs) tradisional – gel ini membantu merangsang pembaruan sel untuk memperbaiki rona dan tekstur kulit, mencerahkan serta memperbaiki ukuran pori – pori.', 18),
(21, 2, 'ageLOC Nutriol Scalp &amp; Hair Shampoo', 450000, 539995, 89995, '61f1799a7d1b8.png', 12, 'Membantu membersihkan rambut dan kulit kepala dengan kandungan Scalp- and Hair-Loving Protein Blend yang membantu menutrisi dan meningkatkan tampilan rambut yang lebih tebal dan sehat.', 68),
(22, 2, 'Epoch Ava puhi moni', 170000, 220000, 50000, '61f17a2ee1db9.png', 6, 'Dengan salah satu kandungan zingiber zerumbet juice untuk membersihkan dan melembutkan rambut. Gunakan setiap hari sebagai perawatan menyeluruh untuk melembutkan rambut yang kering, kaku atau kasar.', 62),
(23, 18, 'Nutricentials HydraClean', 185000, 265000, 80000, '61f17b3a71fa5.png', 6, 'Membantu membersihkan, melembabkan, dan melindungi kulit Anda. Pembersih bebas sabun ini mengangkat kotoran, minyak berlebih, dan riasan — sekaligus melindungi kelembaban alami kulit Anda.', 114),
(24, 18, 'Nutricentials Spa Day Creamy Hydrating', 285000, 353994, 68994, '61f17bce3865d.png', 5, 'Spa-day-in-a-tube yang menutrisi ini diformula dengan campuran tumbuhan bioadaptive serta ekstrak kaktus dan pinus untuk membantu kulit tetap lembab dan bercahaya. Plus, formula yang menghidrasi mengikat kelembaban pada kulit, mengurangi tampilan kulit kering dan membuat kulit tampak bercahaya. Gunakan kapan pun kulit Anda membutuhkan “me time” yang melembabkan.vitamin D untuk nutrisi tulang.', 41),
(25, 18, 'Nutricentials Micellar Beauty', 320000, 394000, 74000, '61f17ccebe6d3.png', 6, 'Adalah air pembersih yang didukung oleh micelles, dikenal dengan manfaat pembersihannya yang cepat, nyaman, dan efektif. Nutricentials day away micellar beauty water menghadirkan pengalaman klasik ini ke tingkat yang benar-benar baru dengan formula bersih yang mencakup pelembab alami seperti sodium pca, gliserin, dan propanediol untuk menjaga kulit tetap lembut, halus, dan terhidrasi.', 170),
(26, 19, 'Epoch® Blemish Treatment', 144000, 177000, 33000, '61f17d92e2009.png', 4, 'Membantu mengurangi ketidaknyamanan karena jerawat dan melembutkan kulit. Oleskan pada bagian wajah yang berjerawat dengan cukup tebal, lakukan hingga 3 kali sehari. Karena perawatan ini mungkin menyebabkan kulit menjadi kering, maka mulailah dengan 1 kali sehari terlebih dahulu, lalu secara bertahap tingkatkan 2-3 kali sehari sesuai kebutuhan. Apabila terjadi kekeringan kulit atau kulit mengelupas, kurangi pemakaian menjadi 1-2 kali sehari.', 75),
(27, 19, 'LumiSpa® Cleanser', 488000, 540000, 52000, '61f17e52b2ab6.png', 17, 'Pembersih wajah yang diformulasi khusus untuk kulit berjerawat, untuk merawat dan membersihkan kulit agar sehat, lembut dan tampak bersinar. ageLOC Lumispa Activating Cleanser For Blemish Prone Skin efektif digunakan bersama dengan perangkat ageLOC LumiSpa.', 55),
(28, 26, 'ageLOC Galvanic Body Spa', 4100000, 5049996, 949996, '61f1806a485d3.png', 4, 'Isi Paket:\r\n\r\n1 (satu) Galvanic Body Spa ageLOC\r\n1 (satu) ageLOC Galvanic Body Shaping Gel\r\n1 (satu) ageLOC Dermatic Effects\r\n1 (satu) ageLOC Sponsoring Flyer', 760),
(29, 26, 'ageLOC® LumiSpa® Normal Pack', 2400000, 2950000, 550000, '61f180fb0b15b.png', 1, 'ageLOC LumiSpa dengan teknologi eksklusif micropulse oscillation, bekerja membersihkan pori-pori untuk mengangkat kotoran, minyak, make up, polusi, dan racun. Memberi manfaat seketika untuk kulit lebih lembut dan halus setelah satu kali pemakaian. Manfaat LumiSpa meningkat seiring waktu bila digunakan konsisten selama 2 menit, 2 kali sehari.\r\n\r\n \r\n\r\nIsi Paket:\r\n\r\n1 (satu) unit ageLOC LumiSpa\r\n1 (satu) ageLOC LumiSpa Activating Cleanser (Normal/Combo)\r\n \r\n\r\nManfaat Produk: Untuk merawat dan membersihkan kulit agar sehat, lembut dan tampak bersinar\r\n\r\nCatatan: Ganti kepala perangkat ageLOC LumiSpa setiap 3 (tiga) bulan sekali secara berkala agar pembersihan wajah tetap optimal.', 560),
(30, 9, 'Coba tambah', 20000, 30000, 10000, '61fdcd1fc4fef.png', 4, 'Display menambahkan data', 1000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`);

--
-- Indexes for table `pelangan`
--
ALTER TABLE `pelangan`
  ADD PRIMARY KEY (`id_pelangan`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indexes for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD PRIMARY KEY (`id_detail_pembelian`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `pelangan`
--
ALTER TABLE `pelangan`
  MODIFY `id_pelangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  MODIFY `id_detail_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
