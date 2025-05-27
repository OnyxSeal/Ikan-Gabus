-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2024 at 03:16 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlinebookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `bookID` int(11) NOT NULL,
  `Title` varchar(200) DEFAULT NULL,
  `Author` varchar(50) DEFAULT NULL,
  `sinopsis` varchar(700) DEFAULT NULL,
  `ISBN` varchar(20) DEFAULT NULL,
  `Genre` varchar(50) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `QuantityAvail` int(5) DEFAULT NULL,
  `publisher` varchar(50) DEFAULT NULL,
  `NumberOfPage` varchar(4) DEFAULT NULL,
  `PublicationDate` date DEFAULT NULL,
  `language` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`bookID`, `Title`, `Author`, `sinopsis`, `ISBN`, `Genre`, `Price`, `QuantityAvail`, `publisher`, `NumberOfPage`, `PublicationDate`, `language`) VALUES
(1, 'One Piece 88', 'Eiichiro Oda ', 'Luffy bentrok dengan Katakuri dari Tiga Komandan, tapi semua serangannya berhasil ditepis dan menghadapi situasi buntu!! Meskipun begitu, demi mencegah Katakuri mendatangi teman-temannya, dia mencegatnya dan menantangnya bertarung sekuat tenaga! Inilah kisah petualangan di lautan, One Piece!!', '9786020497013', 'manga, petualangan, fantasi', 25600.00, 100, 'Elex Media Komputindo', '192', '2019-04-16', 'Indonesia'),
(2, 'Atomic Habits: Perubahan Kecil yang Memberikan Hasil Luar Biasa', 'James Clear', 'Dalam buku ini James Clear, seorang penulis sekaligus pembicara yang sangat terkenal akan topik \'habit\' memaparkan bahwa pada hakikatnya sebuah perubahan kecil (Atomic Habit) sering dianggap remeh, sebenarnya akan memberikan hasil yang sangat menjanjikan dalam hidup. Yang dipandang penting dalam perubahan perilaku bukan satu persen perbaikan tunggal, melainkan ribuan perbaikan atau sekumpulan atomic habits yang saling bertumpuk dan menjadi unit dasar dalam suatu sistem yang penting.', ' 9786020633176', 'Pengembangan diri, Kebiasaan, Pengendalian Diri', 102400.00, 200, 'Jakarta : Gramedia Pustaka Utama., 2019', '352', '2023-01-17', 'English'),
(3, 'Filosofi Teras', 'Henry Manampiring', 'Lebih dari 2.000 tahun lalu, sebuah mazhab filsafat menemukan akar masalah dan juga solusi dari banyak emosi negatif. Stoisisme, atau Filosofi Teras, adalah filsafat Yunani-Romawi kuno yang bisa membantu kita mengatasi emosi negatif dan menghasilkan mental yang tangguh dalam menghadapi naik-turunnya kehidupan. Jauh dari kesan filsafat sebagai topik berat dan mengawang-awang, Filosofi Teras justru bersifat praktis dan relevan dengan kehidupan Generasi Milenial dan Gen-Z masa kini.', 'SCOOPG168985', 'Self development, filsafat', 79000.00, 50, 'Penerbit Buku Kompas', '346', '2018-12-18', 'Indonesia'),
(4, 'The Psychology of Money (hard cover)', 'Morgan Housel', 'Kesuksesan dalam mengelola uang tidak selalu tentang apa yang Anda ketahui. Ini tentang bagaimana Anda berperilaku. Dan perilaku sulit untuk diajarkan, bahkan kepada orang yang sangat pintar sekalipun. Seorang genius yang kehilangan kendali atas emosinya bisa mengalami bencana keuangan. Sebaliknya, orang biasa tanpa pendidikan finansial bisa kaya jika mereka punya sejumlah keahlian terkait perilaku yang tak berhubungan dengan ukuran kecerdasan formal.', '9786026486646', 'Non-fiction / Self improvement', 90000.00, 60, 'Penerbit Baca', '268', '2021-12-28', 'Indonesia'),
(5, 'Sebuah Seni untuk Bersikap Bodo Amat (hard cover)', 'Mark Manson', 'Selama beberapa tahun belakangan, Mark Manson—melalui blognya yang sangat populer—telah membantu mengoreksi harapan-harapan delusional kita, baik mengenai diri kita sendiri maupun dunia. Ia kini menuangkan buah pikirnya yang keren itu di dalam buku hebat ini.\r\n“Dalam hidup ini, kita hanya punya kepedulian dalam jumlah yang terbatas. Makanya, Anda harus bijaksana dalam menentukan kepedulian Anda.” ', '9786020528571', 'self improvement', 94400.00, 30, 'Gramedia Widiasarana Indonesia', '256', '2022-03-08', 'Indonesia'),
(6, 'Me Before You (cover Baru)', 'Jojo Moyes', 'sebuah novel bergenre romantis yang ditulis oleh Jojo Moyes. Novel ini pertama kali diterbitkan pada tanggal 5 Januari 2012 di Inggris. Sebuah sekuel yang berjudul After You kemudian dirilis pada tanggal 29 September 2015 melalui Pamela Dorman Books. Novel Sebelum Mengenalmu (Me Before You) - Cover Baru ini menceritakan mengenai Louisa (Lou) Clark yang mengetahui banyak hal. Dirinya tahu berapa langkah atau jarak yang dibutuhkan di antara halte bus dengan rumahnya. Lou tahu bahwa dirinya suka sekali bekerja di kedai kopi yang bernama Buttered Bun, dan dirinya juga tahu bahwa mungkin dia tidak begitu mencintai pacarnya yang bernama Patrick.', '0670026603', 'roman, fiksi', 247000.00, 0, NULL, '480', NULL, 'English'),
(7, 'Gadis Kretek', 'Ratih Kumala', 'Pak Raja sekarat. Dalam menanti ajal, ia memanggil satu nama perempuan yang bukan istrinya; Jeng Yah. Tiga anaknya, pewaris Kretek Djagad Raja, dimakan gundah. Sang ibu pun terbakar cemburu terlebih karena permintaan terakhir suaminya ingin bertemu Jeng Yah. Maka berpacu dengan malaikat maut, Lebas, Karim, dan Tegar, pergi ke pelosok Jawa untuk mencari Jeng Yah, sebelum ajal menjemput sang Ayah.', '9789792281415', 'Fiksi', 75000.00, 15, 'Gramedia Pustaka Utama', '288', '2019-07-07', 'Indonesia'),
(8, 'Jakarta Sebelum Pagi', 'Ziggy Zeszyazeoviennazabrizkie', 'Jakarta Sebelum Pagi adalah sebuah novel yang ditulis oleh Ziggy Zezsyazeoviennazabrizkie. Novel ini menceritakan tentang kisah Emina yang terus diteror oleh Stalker. Ia terus menerus mendapatkan kiriman bunga di apartemennya. Emina yang curiga akhirnya menelusuri jejak stalker ini dan mendapati seorang gadis kecil misterius di toko bunga, kamar apartemen sebelah tanpa suara, dan setumpuk surat cinta berisi kisah yang terlewat di hadapan bangunan-bangunan tua Kota Jakarta. Apa hubungannya hal-hal ini dengan stalker yang terus meneror Emina? Akankah Emina mendapatkan petunjuk?', '9786023758432', 'Fiksi', 110000.00, 0, ' Gramedia Pustaka Utama', '280', '2022-09-21', 'Indonesia'),
(9, 'Semua Ikan di Langit (Edisi Revisi)', 'Ziggy Zeszyazeoviennazabrizkie', 'Saya, bus Damri yang tak pernah bosan dengan pekerjaan sehari-harinya yaitu berkeliling kota melalui trayek Dipatiukur-Leuwipanjang, suatu hari diajak ikan julung-julung untuk menemani \"\"Beliau\r\nberjalan-jalan.\r\n\r\nMulai dari zaman sekarang hingga awal mula dan akhir suatu dunia. Trayek baru yang dikunjungi Saya menjadi angkasa luas yang melintasi dimensi ruang dan waktu.', ' 9786023758067', 'Fiksi, sastra', 98000.00, 25, ' Gramedia Widiasarana Indonesia', '220', '2022-09-19', 'Indonesia'),
(10, 'Kita Pergi Hari Ini', 'Ziggy Zezsyazeoviennazabrizkie', 'Mi dan Ma dan Mo tidak pernah melihat kucing seperti Nona Gigi. Tentu saja, mereka sudah pernah melihat kucing biasa. Tapi Nona Gigi adalah Kucing Luar Biasa. Kucing Luar Biasa berarti kucing yang di luar kebiasaan. Nona Gigi adalah Cara Lain yang dinantikan oleh Bapak dan Ibu Mo untuk menjaga Mi, Ma, dan Mo ketika keduanya keluar rumah mencari uang. Sebab di Kota Suara, semua uang yang tersedia di dasar laut sudah diambil oleh para perompak, uang di bawah tanah diambil oleh para perampok, dan uang di ranting pohon diambil oleh pengusaha kayu yang jahat.', NULL, 'fiksi', 88000.00, 80, 'Gramedia Pustaka Utama', '192', '2021-10-25', 'Indonesia'),
(11, 'Pretty Little Liars', 'Sara Shepard', '\"Everyone has something to hide especially high school juniors spencer, aria, emily, and hanna.\r\nSpencer covets her sister\'s boyfriend. Aria\'s fantasizing about her English teacher. Emily\'s crushing on the new girl at school. Hanna uses some ugly tricks to stay beautiful.\r\nBut they\'ve all kept an even secret since their friend Alison vanished.\r\nHow do I know? Because I know about the bad girls they were, the naughty girls they are, and all the dirty secrets they\'ve kept. And guess what? I\'m telling.\"', '9780061975561', 'Fiksi, Misteri', 119000.00, 300, 'sinar star book', '378', '2014-10-13', 'English'),
(12, 'Little Women', 'Louisa May Alcott', 'Diterbitkan pada abad ke-19, novel ini disebut sebagai karya paling realistis di antara novel-novel sejenis yang lebih menawarkan mimpi dan idealisme. Lewat Little Women, Louisa May Alcott menyuratkan kebahagiaan dalam kesederhanaan, dan menunjukkan bahwa rumah mungil pun dapat menjadi istana indah dengan kehadiran orang-orang tercinta.', '9786024021689', 'fiksi', 79000.00, 115, 'Indonesia', '436', '2020-01-13', 'Indonesia'),
(13, 'It Ends With Us', 'Colleen Hoover', 'Semua bermula dari pertemuan tak sengaja di sebuah rooftop. Lily berusaha menenangkan diri setelah kematian ayahnya dan Ryle, dokter neurosurgeon tampan, mengaku sedang menepi dari tekanan pekerjaan. Sebagai dua orang asing yang tidak berencana bertemu lagi, mereka merasa nyaman saling berbagi kejujuran telanjang—cerita tentang luka masa lalu dan segala hal yang tidak pernah dibagi pada orang terdekat.', NULL, 'Fiksi, Roman', 245000.00, 15, NULL, '386', '2016-08-02', 'English'),
(14, 'The Power Of Habit', 'Charles Duhigg', 'Travis, seorang pemuda broken home dengan orang tua pecandu obat, berkali-kali dipecat dari pekerjaan karena tidak bisa mengendalikan emosi. Namun sesudah menjalani pelatihan pegawai Starbucks yang mengajarkan kekuatan tekad, Travis kini sukses menjadi manajer dua cabang kafe terkenal itu.\r\nSeorang CEO baru memegang salah satu perusahaan raksasa Amerika. Perintah pertamanya adalah menumbuhkan kepedulian keselamatan kerja-dan hasilnya saham perusahaan itu, Alcoa, menjadi salah satu yang berkinerja terbaik di Dow Jones.', '9786024241391', 'Psikologi', 90000.00, 100, ' Kepustakaan Populer Gramedia', '392', '2019-08-11', 'Indonesia'),
(15, 'How To Respect Myself: Seni Menghargai Diri Sendiri', 'YOON HONG GYUN', 'Buku “How To Respect Myself — Seni Menghargai Diri Sendiri” ini akan membahas tentang bagaimana cara Anda menjaga dan mencintai diri sendiri, yang merupakan metode pelatihan mandiri untuk harga diri ala dokter kejiwaan ‘dr. Yoon si Penjawab’.', '9786237100331', 'selflove', 99000.00, 55, 'Kawah Media', '356', '2020-02-24', 'Indonesia');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE `orderdetail` (
  `orderdetID` int(11) NOT NULL,
  `OrderID` int(11) DEFAULT NULL,
  `BookID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderhistory`
--

CREATE TABLE `orderhistory` (
  `orderhistID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `orderDate` date DEFAULT NULL,
  `totalAmount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(10) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `orderDate` date DEFAULT NULL,
  `totalAmount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentId` int(11) NOT NULL,
  `orderID` int(11) DEFAULT NULL,
  `paymentDate` date DEFAULT NULL,
  `paymentAmount` decimal(10,2) DEFAULT NULL,
  `paymentMethod` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `password` varchar(20) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `firstName` varchar(20) DEFAULT NULL,
  `lastName` varchar(200) DEFAULT NULL,
  `address` varchar(60) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`bookID`);

--
-- Indexes for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`orderdetID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `BookID` (`BookID`);

--
-- Indexes for table `orderhistory`
--
ALTER TABLE `orderhistory`
  ADD PRIMARY KEY (`orderhistID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentId`),
  ADD KEY `orderID` (`orderID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `bookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orderdetail`
--
ALTER TABLE `orderdetail`
  MODIFY `orderdetID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderhistory`
--
ALTER TABLE `orderhistory`
  MODIFY `orderhistID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `orderdetail_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`orderID`),
  ADD CONSTRAINT `orderdetail_ibfk_2` FOREIGN KEY (`BookID`) REFERENCES `books` (`bookID`);

--
-- Constraints for table `orderhistory`
--
ALTER TABLE `orderhistory`
  ADD CONSTRAINT `orderhistory_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
