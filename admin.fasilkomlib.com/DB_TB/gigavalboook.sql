-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2024 at 03:50 PM
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
-- Database: `gigavalboook`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` int(10) NOT NULL,
  `profile_picture` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `usradm` varchar(15) NOT NULL,
  `pwadm` varchar(20) NOT NULL,
  `nohpadm` int(20) NOT NULL,
  `position` varchar(15) NOT NULL,
  `created at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `profile_picture`, `fullname`, `email`, `usradm`, `pwadm`, `nohpadm`, `position`, `created at`) VALUES
(1, 'default_profile.png', 'Raival Ganteng', 'raivalm@gmail.com', 'raival', '123', 2147483647, '', '2024-06-03 17:29:00');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `bookID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `sinopsis` varchar(1500) NOT NULL,
  `isbn` varchar(30) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `quantityavail` int(5) NOT NULL,
  `publisher` varchar(50) NOT NULL,
  `numberofpage` varchar(4) NOT NULL,
  `publicationdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `language` varchar(50) DEFAULT NULL,
  `cover` varchar(100) NOT NULL,
  `postby` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`bookID`, `title`, `author`, `sinopsis`, `isbn`, `genre`, `price`, `quantityavail`, `publisher`, `numberofpage`, `publicationdate`, `language`, `cover`, `postby`) VALUES
(1, 'Jujutsu Kaisen 0', 'Gege Akutami', 'Yuta Okkotsu seorang siswa SMA yang menginginkan hukuman mati untuk dirinya sendiri. Dia menderita karena Rika - roh pendendam yang menghantuinya. Namun, Satoru Gojo, seorang guru di “Akademi Jujutsu” - sekolah para shaman, meyakinkan Okkotsu untuk pindah ke sekolah tersebut. Inilah prekuel dari JUJUTSU KAISEN!!\r\n\r\nYuji Itadori seorang murid SMA dengan kemampuan atletik yang luar biasa. Kesehariannya adalah menjenguk kakeknya yang terbaring di rumah sakit. Suatu hari, segel \"objek terkutuk\" yang', '9786230034640', 'Manga', 40000.00, 174, '', '200', '2024-06-03 17:35:38', NULL, '[NEW] [Jujutsu Kaisen 0] 2024.06.03 - 07.35.38pm.jpg', 'Raival Ganteng'),
(2, 'Jujutsu Kaisen 1', 'Gege Akutami', 'Yuji Itadori seorang murid SMA dengan kemampuan atletik yang luar biasa. Kesehariannya adalah menjenguk kakeknya yang terbaring di rumah sakit. Suatu hari, segel \"objek terkutuk\" yang berada di sekolahnya terlepas, monster-monster pun mulai bermunculan. Yuji menyusup ke dalam gedung sekolah demi menolong senior di klubnya, akan tetapi...!?', '9786230022180', 'Manga', 40000.00, 154, '', '200', '2024-06-03 17:38:23', NULL, '[NEW] [Jujutsu Kaisen Vol.01] 2024.06.03 - 07.38.23pm.jpeg', 'Raival Ganteng'),
(3, 'Jujutsu Kaisen 2', 'Gege Akutami', 'Komik Jujutsu Kaisen 2 karya Gege Akutami menjadi salah satu komik yang wajib untuk diikuti. Sebuah kutukan yang menyerupai janin tiba-tiba muncul di lapas anak pria. Itadori dan murid tahun pertama lainnya diutus untuk menyelamatkan orang-orang yang masih berada di lapas tersebut. Akan tetapi, janin yang telah bermetamorfosis menjadi kutukan tingkat tinggi itu melancarkan serangannya sehingga Itadori dkk berada dalam bahaya. Itadori kemudian bertukar dengan Sukuna untuk mengalahkan kutukan ters', '9786230024399', 'Manga', 40000.00, 187, '', '200', '2024-06-03 17:42:40', NULL, '[NEW] [Jujutsu Kaisen 2] 2024.06.03 - 07.42.40pm.jpg', 'Raival Ganteng'),
(4, 'Jujutsu Kaisen 03', 'Gege Akutami', 'Jujutsu Kaisen adalah manga Jepang yang ditulis dan diilustrasikan sendiri oleh Gege Akutami. Jujutsu Kaisen dirilis pertama kali pada bulan Maret 2018 ini menceritakan tentang siswa sekolah menengah, Yuji Itadori, saat ia bergabung dengan organisasi rahasia Penyihir Jujutsu untuk membunuh Kutukan kuat bernama Ryomen Sukuna, yang menjadikan Yuji sebagai tuan rumah. Karena sifat jahat Sukuna, semua penyihir diharuskan untuk mengusirnya segera–dalam hal ini, termasuk memburu Yuji Itadori. Tapi set', '9786230024672', 'Manga', 40000.00, 178, '', '200', '2024-06-03 17:44:33', NULL, '[NEW] [Jujutsu Kaisen 03] 2024.06.03 - 07.44.33pm.jpeg', 'Raival Ganteng'),
(5, 'Jujutsu Kaisen 4', 'Gege Akutami', 'Komik Jujutsu Kaisen 4 karya Gege Akutami menjadi salah satu komik yang wajib untuk diikuti. Itadori bertemu Junpei saat sedang menyelidiki kasus pembunuhan yang disebabkan oleh \"kutukan\". Awalnya, Itadori tidak berprasangka apa-apa terhadap Junpei. Dan karena merasa cocok, Itadori malah menjadi akrab dengannya. Tapi, ternyata Junpei \"terpesona\" dengan bujukan Mahito, dan bertikai dengan Itadori. Di tengah pertikaian, Itadori yang merasa terdesak dan ingin mengembalikan Junpei ke sosok sesungguh', '9786230026942', 'Manga', 40000.00, 193, '', '192', '2024-06-03 17:46:50', NULL, '[NEW] [Jujutsu Kaisen 4] 2024.06.03 - 07.46.50pm.jpg', 'Raival Ganteng'),
(6, 'Jujutsu Kaisen 5', 'Gege Akutami', 'Semua orang terkejut ketika mereka mengetahui Itadori masih hidup, tetapi tidak ada waktu untuk reuni yang mengharukan ketika Jujutsu High berada di tengah-tengah persaingan ketat dengan saingan mereka dari Kyoto! Tapi sportifitas yang baik tampaknya tidak ada dalam kartu begitu pihak berwenang memutuskan untuk menghilangkan ancaman Sukuna sekali dan untuk selamanya.\r\n\r\nDalam pergantian peristiwa yang tidak terduga, Aoi sangat menyukai Yuji. Yakin bahwa mereka adalah sahabat, Aoi bahkan melontarkan rencana timnya sendiri untuk membunuh Yuji. Sementara itu, Megumi dan yang lainnya mulai mengejar rival Kyoto mereka untuk melindungi Yuji juga.\r\n\r\nTim Tokyo dapat mengetahui skema Tim Kyoto. Megumi dan Maki kembali untuk melindungi Yuji, menghadapi saingan mereka karena mencoba membunuhnya. Sementara itu, Aoi menyadari potensi Yuji, dan memutuskan untuk membantu membawanya ke level berikutnya.\r\n\r\nSaat duel Yuji dengan Aoi, Todo mencapai klimaksnya, dia belajar apa artinya mencapai potensinya. Dengan keahlian membimbing Aoi, Yuji mulai tumbuh menuju tingkat kekuatan baru. Sementara itu, Mechamaru mendukung Momo dalam konfrontasinya dengan Nobara dan Panda.', '9786230029783', 'Manga', 40000.00, 275, '', '200', '2024-06-03 17:50:52', NULL, '[NEW] [Jujutsu Kaisen 5] 2024.06.03 - 07.50.52pm.jpg', 'Raival Ganteng'),
(7, 'Jujutsu Kaisen 6', 'Gege Akutami', 'Setelah program pertukaran dengan Akademi Jujutsu Kyoto dimulai. Pihak yang duluan menyingkirkan jurei tingkat 2 di area pertandinganlah yang akan jadi pemenangnya. Todo yang gemar berkelahi segera menyerang pihak Tokyo! Saat Todo dan Itadori saling berhadapan, anak-anak Kyoto yang lain ikut mengepung Itadori dengan niat untuk membunuhnya. Rencana tim Kyoto untuk membunuh Itadori berjalan sesuai harapan dengan memanfaatkan program pertukaran. Di sisi lain, Jurei dan Jusoshi yang dipimpin Mahito menyusup masuk ke tempat berlangsungnya acara. Para guru pun bergegas pergi untuk menyelamatkan murid-murid, tapi mereka terhalang oleh Tobari! Sementara itu, Inumaki dan Fushiguro diserang Jurei tingkat tinggi bernama Hanami. Apakah mereka berhasil keluar dari krisis itu!?', '9786230031274', 'Manga', 40000.00, 164, '', '200', '2024-06-03 17:55:58', NULL, '[NEW] [Jujutsu Kaisen 6] 2024.06.03 - 07.55.58pm.jpg', 'Raival Ganteng'),
(8, 'Cantik Itu Luka', 'Eka Kurniawan', 'Hidup di era kolonialisme bagi para wanita dianggap sudah setara seperti hidup di neraka. Terutama bagi para wanita berparas cantik yang menjadi incaran tentara penjajah untuk melampiaskan hasrat mereka. Itu lah takdir miris yang dilalui Dewi Ayu, demi menyelamatkan hidupnya sendiri Dewi harus menerima paksaan menjadi pelacur bagi tentara Belanda dan Jepang selama masa kedudukan mereka di Indonesia.\r\n\r\nKecantikan Dewi tidak hanya terkenal dikalangan para penjajah saja, seluruh desa pun mengakui pesona parasnya itu. Namun bagi Dewi, kecantikannya ini seperti kutukan, kutukan yang membuat hidupnya sengsara, dan kutukan yang mengancam takdir keempat anak perempuannya yang ikut mewarisi genetik cantiknya.\r\n\r\nTapi tidak dengan satu anak terakhir Dewi, si Cantik, yang lahir dengan kondisi buruk rupa. Tak lama setelah mendatangkan Cantik ke dunia, Dewi harus berpulang. Tapi di satu sore, dua puluh satu tahun kemudian, Dewi kembali, bangkit dari kuburannya. Kebangkitannya menguak kutukan dan tragedi keluarga.\r\n\r\nBagaimana takdir yang akan menghampiri si Cantik? Apa yang membuat Dewi harus kembali ke dunia bak neraka ini? Ungkap rahasia dibalik misteri kisah masa kolonial dalam novel Cantik Itu Luka karya Eka Kurniawan.', 'SCOOPG148465', 'Novel', 163900.00, 228, '', '520', '2024-06-03 17:59:24', NULL, '[NEW] [Novel Cantik Itu Luka] 2024.06.03 - 07.59.24pm.jpg', 'Raival Ganteng'),
(9, 'Cantik Itu Luka (Edisi 20 Tahun)', 'Eka Kurniawan', 'Usia 20 tahun termasuk waktu yang panjang bagi sebuah novel bisa eksis di tengah-tengah industri perbukuan Indonesia. Tak banyak buku yang terus dicetak ulang hingga 20 tahun sejak pertama kali terbit, kecuali beberapa buku novel yang menjadi kanon sastra Indonesia.\r\n\r\nNovel karya Eka Kurniawan, “Cantik Itu Luka”, mampu mencapai usia panjang itu. Terhitung 20 tahun sejak terbit perdana tahun 2002, novel ini hingga kini masih dikenal, masih eksis dan dibicarakan oleh para pembaca sastra Indonesia. Alasan itu pula agaknya yang membuat buku ini dicetak ulang oleh Gramedia Pustaka Utama di tahun ini.\r\n\r\nNovel “Cantik Itu Luka” adalah karya novel pertama Eka Kurniawan yang diterbitkan. Karya ini pertama kali diterbitkan oleh Akademi Kebudayaan Yogyakarta bersama Penerbit Jendela tahun 2002, sebelum akhirnya beralih ke Gramedia untuk cetakan kedua pada tahun 2004 silam.\r\n\r\nBuku novel ini adalah penerima penghargaan World Readers pada tahun 2016, dan yang juga mengantarkan penulisnya menerima penghargaan internasional di Belanda, yaitu Prince Clause Awards tahun 2018.\r\n\r\nPenghargaan-penghargaan itu tak lepas dari masifnya dan meluasnya distribusi novel “Cantik Itu Luka” dari masa ke masa. Novel ini berhasil menjadi best seller yang diterjemahkan ke lebih dari 34 bahasa, di antaranya bahasa Inggris, Jepang, Prancis, Denmark, Yunani, Kora serta Tiongkok. Popularitas yang melejitkan nama Eka Kurniawan di arus utama sastra Indonesia.', '9786020366517', 'Novel', 178000.00, 273, '', '512', '2024-06-03 18:01:52', NULL, '[NEW] [Cantik Itu Luka (Edisi 20 Tahun)] 2024.06.03 - 08.01.52pm.jpg', 'Raival Ganteng'),
(10, 'Gadis Kretek', 'Ratih Kumala', 'Pak Raja sekarat. Dalam menanti ajal, ia memanggil satu nama perempuan yang bukan istrinya; Jeng Yah. Tiga anaknya, pewaris Kretek Djagad Raja, dimakan gundah. Sang ibu pun terbakar cemburu terlebih karena permintaan terakhir suaminya ingin bertemu Jeng Yah. Maka berpacu dengan malaikat maut, Lebas, Karim, dan Tegar, pergi ke pelosok Jawa untuk mencari Jeng Yah, sebelum ajal menjemput sang Ayah.\r\n\r\nPerjalanan itu bagai napak tilas bisnis dan rahasia keluarga. Lebas, Karim, dan Tegar bertemu dengan pelinting tua dan menguak asal-usul Kretek Djagad Raja hingga menjadi kretek nomor 1 di Indonesia. Lebih dari itu, ketiganya juga mengetahui kisah cinta ayah mereka dengar; Jeng Yah, yang ternyata adalah pemilik Kretek Gadis, kretek lokal Kota M yang terkenal pada zamannya.\r\n\r\nApakah Lebas, Karim, dan Tegar akhirnya berhasil menemukan Jeng Yah?', '9789792281415', 'Novel', 75000.00, 763, '', '288', '2024-06-03 18:09:16', NULL, '[NEW] [Gadis Kretek] 2024.06.03 - 08.09.16pm.jpg', 'Raival Ganteng'),
(11, 'Gadis Kretek (Sampul Netflix)', 'Ratih Kumala', 'Pak Raja sekarat. Dalam menanti ajal, ia memanggil satu nama perempuan yang bukan istrinya; Jeng Yah. Tiga anaknya, pewaris Kretek Djagad Raja, dimakan gundah. Sang ibu pun terbakar cemburu terlebih karena permintaan terakhir suaminya ingin bertemu Jeng Yah. Maka berpacu dengan malaikat maut, Lebas, Karim, dan Tegar, pergi ke pelosok Jawa untuk mencari Jeng Yah, sebelum ajal menjemput sang Ayah. Perjalanan itu bagai napak tilas bisnis dan rahasia keluarga. Lebas, Karim, dan Tegar bertemu dengan pelinting tua dan menguak asal-usul Kretek Djagad Raja hingga menjadi kretek nomor 1 di Indonesia. Lebih dari itu, ketiganya juga mengetahui kisah cinta ayah mereka dengar; Jeng Yah, yang ternyata adalah pemilik Kretek Gadis, kretek lokal Kota M yang terkenal pada zamannya. Apakah Lebas, Karim, dan Tegar akhirnya berhasil menemukan Jeng Yah?\r\n\r\nGadis Kretek tidak sekadar bercerita tentang cinta dan pencarian jati diri para tokohnya. Dengan latar Kota M, Kudus, Jakarta, dari periode penjajahan Belanda hingga kemerdekaan, Gadis Kretek akan membawa pembaca berkenalan dengan perkembangan industri kretek di Indonesia. Kaya akan wangi tembakau. Sarat dengan aroma cinta.', '9789792281415', 'Novel', 75000.00, 448, '', '288', '2024-06-03 18:11:04', NULL, '[NEW] [Gadis Kretek (Sampul Netflix)] 2024.06.03 - 08.11.04pm.jpg', 'Raival Ganteng'),
(12, 'The Ballad of Songbirds & Snakes', 'Suzanne Collins', 'Ambisi mendorongnya. Kompetisi menggerakkannya. Namun, kekuasaan ada harganya. Pagi hari menjelang dimulainya Hunger Games Kesepuluh, Coriolanus Snow yang berusia 18 tahun bersiap-siap menjadi mentor. Keluarga Snow yang dulunya jaya kini jatuh miskin. Nasib mereka bergantung pada kemampuan Coriolanus untuk menebar pesona dan mengalahkan siswa-siswa lain untuk menjadi mentor peserta yang akan memenangkan Hunger Games. Keberuntungan sepertinya tidak berpihak pada Coriolanus. Dia mendapat peserta perempuan dari Distrik 12, distrik yang dipandang sebelah mata. Takdir Corioanus dan sang peserta bertaut---setiap keputusan yang diambilnya bisa menentukan kemenangan atau kekalahan, keberhasilan atau kegagalan.\r\n\r\nDi dalam arena, para peserta berjuang sampai mati. Di luar arena, Coriolanus mulai jatuh hati pada gadis yang dimentorinya… dan dia rela berbuat apa saja, bahkan melanggar peraturan, demi bertahan hidup dan memperoleh kejayaannya. Prolog: Coriolanus mencemplungkan segenggam kubis ke panci berisi air mendidih dan bersumpah akan ada hari ia takkan makan sayuran itu lagi. Tapi bukan hari ini. Ia butuh menyantap semangkuk besar makanan berwarna pucat itu dan meminum kuahnya sampai tetes terakhir, agar perutnya tidak keroncongan selama upacara pemungutan. Ini salah satu tindakan yang dilakukan Coriolanus untuk berjaga-jaga dan menutupi kenyataan tentang keluarganya, yang meskipun tinggal di gedung apartemen paling mewah, sama miskinnya dengan gembel yang tinggal di distrik. Pada ', '9786020674292', 'Novel', 149000.00, 241, '', '656', '2024-06-03 18:15:26', NULL, '[NEW] [The Ballad of Songbirds & Snakes] 2024.06.03 - 08.15.26pm.jpg', 'Raival Ganteng'),
(13, 'Sebuah Seni untuk Bersikap Bodo Amat (edisi handy)', 'Mark Manson', 'Mark Manson adalah satu dari sedikit pengarang yang bukunya setia menemani para pembaca di Indonesia dan seluruh dunia. Telah terjual lebih dari 400.000 eksemplar di Indonesia, Anda pasti tidak asing dengan Sebuah Seni untuk Bersikap Bodo Amat dan Segala-galanya Ambyar.\r\n\r\nSebuah Seni untuk Bersikap Bodo Amat adalah buku fenomenal yang menjadi panduan pengembangan diri saat ini. Isinya sangat relevan dan konteksual dengan fenomena-fenomena sosial zaman ini, ketika banyak orang mudah terseret arus konsumerisme, gemar mencari validasi semu, dan mudah kesepian di tengah hingar bingar dunia. Sebuah Seni untuk Bersikap Bodo Amat (Subtle Art of Not Giving A F*ck) menuntun ke jalan self-healing tanpa ada sedikit pun kesan menggurui.\r\n\r\nEdisi handy ini hadir dengan sampul yang ringan dan kemasan yang lebih dinamis, serta enak digenggam. Ini akan memudahkan Anda untuk membawa-bawanya dalam perjalanan. Anda bisa leluasa untuk membacanya di taman, café, stasiun, atau di tempat umum lainnya.', '9786020528540', 'Self-help', 78000.00, 184, '', '256', '2024-06-03 18:18:34', NULL, '[NEW] [Sebuah Seni untuk Bersikap Bodo Amat (edisi handy)] 2024.06.03 - 08.18.34pm.png', 'Raival Ganteng'),
(14, 'The Ink Black Heart', 'Robert Galbraith', 'Ketika Edie Ledwell, dalam keadaan panik dan awut-awutan, muncul di kantor biro detektif serta meminta berbicara dengannya, Robin Ellacott tidak yakin bagaimana harus menangani situasi tersebut. Edie, kokreator kartun populer The Ink Black Heart, dipersekusi oleh sosok online misterius yang menggunakan nama samaran Anomie. Dia ingin mengetahui identitas Anomie yang sebenarnya. Robin memutuskan bahwa biro detektif mereka tidak dapat membantu Edie---dan Robin tidak memikirkannya lagi hingga beberapa hari kemudian dia membaca berita mengejutkan bahwa Edie Ledwell telah dibunuh di Highgate Cemetery, lokasi The Ink Black Heart. Robin dan partner bisnisnya, Cormoran Strike, terseret dalam upaya keras mengungkap identitas sejati Anomie. Namun, dunia daring yang kompleks dan ruwet penuh nama alias, sementara kepentingan bisnis serta konflik keluarga mesti dihadapi, Strike dan Robin terlibat kasus yang menguji kemampuan deduksi mereka… dan mengancam keberlangsungan hidup serta penghidupan mereka. Misteri yang cerdas dan menegangkan. The Ink Black Heart adalah karya Robert Galbraith yang membuktikan kekuatan, keterampilan, dan kecerdikannya. Robert Galbraith adalah nama alias J.K. Rowling, pengarang serial HARRY POTTER. THE INK BLACK HEART adalah buku keenam dari serial detektif Cormoran Strike. Film serialnya ditayangkan di HBO Go dengan judul seri C.B. STRIKE. Selling Point: Robert Galbraith adalah nama alias J.K. Rowling, pengarang serial HARRY POTTER. THE INK BLACK HEART adalah buk', '9786020671741', 'Novel', 369000.00, 139, '', '1072', '2024-06-03 18:20:25', NULL, '[NEW] [The Ink Black Heart] 2024.06.03 - 08.20.25pm.jpg', 'Raival Ganteng'),
(15, 'The Mountain Is You', 'Brianna Wiest', 'Buku The Mountain Is You karya Brianna Wiest membahas tentang sabotase diri, yaitu perilaku ketika seseorang secara sadar atau tidak sadar melakukan hal-hal yang menghambatnya untuk mencapai tujuan. Brianna Wiest menjelaskan bahwa sabotase diri adalah masalah yang umum dialami oleh banyak orang, dan dapat disebabkan oleh berbagai faktor, seperti ketakutan, ketidakpercayaan diri, dan trauma masa lalu.\r\nBuku ini terdiri atas empat bagian. Bagian pertama membahas tentang apa itu sabotase diri dan mengapa kita melakukannya. Bagian kedua membahas tentang berbagai bentuk sabotase diri. Bagian ketiga membahas tentang bagaimana cara mengatasi sabotase diri. Bagian keempat membahas tentang bagaimana cara membangun diri yang tangguh.\r\nBuku The Mountain Is You adalah buku yang bermanfaat untuk siapa saja yang ingin memahami dan mengatasi sabotase diri. Buku ini ditulis dengan gaya yang mudah dipahami dan dengan contoh dalam kehidupan sehari-hari. Buku ini juga memberikan motivasi untuk membangun diri yang tangguh, sehingga Anda dapat mencapai tujuan Anda.', '9786236083697', 'Self-help', 119000.00, 163, '', '280', '2024-06-03 18:27:03', NULL, '[NEW] [The Mountain Is You] 2024.06.03 - 08.27.03pm.jpg', 'Raival Ganteng'),
(16, 'Think and Grow Rich', 'Napoleon Hill', 'Buku ini berisi rahasia menghasilkan uang yang bisa mengubah hidup Anda. Think and Grow Rich, berdasarkan Hukum Kesuksesan penulis yang terkenal, mewakili kebijaksanaan suling dari orang-orang terkemuka yang kaya raya dan berprestasi. Formula ajaib Andrew Carnegie untuk sukses menjadi inspirasi langsung bagi buku ini. Carnegie mendemonstrasikan kekokohannya ketika kepelatihannya membawa keberuntungan bagi para pemuda yang telah dia ungkapkan rahasianya. Buku ini akan mengajari Anda rahasia itu--dan rahasia orang hebat lainnya seperti dia. Ini akan menunjukkan kepada Anda tidak hanya apa yang harus dilakukan tetapi juga bagaimana melakukannya. Jika Anda mempelajari dan menerapkan teknik-teknik dasar sederhana yang diungkapkan di sini, Anda akan menguasai rahasia kesuksesan sejati dan abadi--dan Anda mungkin mendapatkan apapun yang Anda inginkan dalam hidup!\r\n\r\nBuku ini ditulis oleh Napoleon Hill (lahir di Pound, Virginia, 26 Oktober 1883 – 8 November 1970) adalah seorang penulis Amerika Serikat. Ia dianggap luas sebagai salah satu penulis buku bertopik kesuksesan terhebat. Bukunya yang paling terkenal,Think and Grow Rich (1937), adalah salah satu buku terlaris sepanjang masa.', '9780449214923', 'Self-help', 155000.00, 159, '', '256', '2024-06-03 18:32:25', NULL, '[NEW] [Think and Grow Rich] 2024.06.03 - 08.32.25pm.jpg', 'Raival Ganteng'),
(17, 'Laut Bercerita', 'Leila S. Chudori', 'Laut Bercerita, novel terbaru Leila S. Chudori, bertutur tentang kisah keluarga yang kehilangan, sekumpulan sahabat yang merasakan kekosongan di dada, sekelompok orang yang gemar menyiksa dan lancar berkhianat, sejumlah keluarga yang mencari kejelasan makam anaknya, dan tentang cinta yang tak akan luntur.', 'SCOOPG143505', 'Novel', 115000.00, 135, '', '394', '2024-06-03 18:36:54', NULL, '[NEW] [Laut Bercerita] 2024.06.03 - 08.36.54pm.png', 'Raival Ganteng'),
(18, 'Home Sweet Loan', 'Almira Bastari', 'Empat orang yang berteman sejak SMA bekerja di perusahaan yang sama meski beda nasib. Di usia 31 tahun, mereka berburu rumah idaman yang minimal nyerempet Jakarta. Kaluna, pegawai Bagian Umum, yang gajinya tak pernah menyentuh dua digit. Gadis ini bekerja sampingan sebagai model bibir, bermimpi membeli rumah demi keluar dari situasi tiga kepala keluarga yang bertumpuk di bawah satu atap. Di tengah perjuangannya menabung, Kaluna dirongrong oleh kekasihnya untuk pesta pernikahan mewah.\r\n\r\nSelain itu, ada juga masalah hutang keluarganya. Masalah-masalah ini menjadikan Kaluna merasa menjadi rakyat jelata saja tidak cukup membuat kepalanya mumet luar biasa. Tanisha, ibu satu anak yang menjalani Long Distance Marriage, mencari rumah murah dekat MRT yang juga bisa menampung mertuanya.\r\n\r\nKamamiya, yang berambisi menjadi selebgram, mencari apartemen cantik untuk diunggah ke media sosial demi memenuhi gengsinya agar bisa menikah dengan pria kaya. Danan, anak tunggal tanpa beban yang akhirnya berpikir untuk berhenti hura-hura, dan membeli aset agar bisa pensiun dengan tenang. Apakah keempat sahabat ini berhasil menemukan rumah yang mampu mereka cicil? Dan apakah Kaluna bisa membentuk keluarga yang ia impikan?', '9786020658049', 'Novel', 94000.00, 181, '', '312', '2024-06-03 18:38:33', NULL, '[NEW] [Home Sweet Loan] 2024.06.03 - 08.38.33pm.jpg', 'Raival Ganteng');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `bookID` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `subTotal` decimal(15,2) NOT NULL,
  `enteredOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartID`, `userID`, `bookID`, `quantity`, `subTotal`, `enteredOn`) VALUES
(6, 1, 10, 4, 30000000.00, '2024-06-03 19:00:41'),
(13, 1, 17, 2, 230000.00, '2024-06-05 14:09:12');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE `orderdetail` (
  `orderdetID` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `bookID` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `subtotal` int(11) NOT NULL,
  `status` enum('nyp','pckd','sent','done') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderdetail`
--

INSERT INTO `orderdetail` (`orderdetID`, `orderID`, `userID`, `bookID`, `quantity`, `subtotal`, `status`) VALUES
(1, 1, 1, 14, 4, 1476000, 'nyp'),
(2, 2, 1, 14, 2, 738000, 'done'),
(3, 3, 1, 16, 3, 465000, 'pckd'),
(4, 4, 1, 17, 1, 115000, 'sent'),
(6, 6, 2, 11, 5, 375000, 'pckd'),
(8, 8, 2, 16, 2, 310000, 'nyp');

-- --------------------------------------------------------

--
-- Table structure for table `orderhistory`
--

CREATE TABLE `orderhistory` (
  `orderhistID` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `orderDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `totalAmount` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderhistory`
--

INSERT INTO `orderhistory` (`orderhistID`, `orderID`, `userID`, `orderDate`, `totalAmount`) VALUES
(1, 1, 1, '2024-06-03 18:50:20', 1476000.00),
(2, 2, 1, '2024-06-03 18:59:30', 738000.00),
(5, 8, 2, '2024-06-04 05:09:05', 310000.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `orderDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `totalAmount` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderID`, `userID`, `orderDate`, `totalAmount`) VALUES
(1, 1, '2024-06-03 18:50:20', 1476000.00),
(2, 1, '2024-06-03 18:59:30', 738000.00),
(3, 1, '2024-06-04 02:14:19', 465000.00),
(4, 1, '2024-06-04 02:14:19', 115000.00),
(6, 2, '2024-06-04 03:42:48', 375000.00),
(8, 2, '2024-06-04 05:09:05', 310000.00);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `gender` enum('Laki-laki','Perempuan') NOT NULL,
  `ttl` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `status` enum('Lainnya','Siswa','Mahasiswa','Pekerja','Ibu_Rumah_Tangga') NOT NULL,
  `bio` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `socmed` varchar(30) DEFAULT NULL,
  `address` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `avatar`, `fullname`, `gender`, `ttl`, `email`, `username`, `password`, `status`, `bio`, `phone`, `socmed`, `address`) VALUES
(1, '[Raival Ganteng]  2024.06.03 - 06.59.00pm.jpg', 'Raival Ganteng', 'Laki-laki', NULL, 'raivalm@gmail.com', 'raival', '123', 'Mahasiswa', 'Capek euy mang hayang duit 1 milyar anjay', '081321412314', ' ', 'Galaxy Bima Sakti'),
(2, '[Gigaval]  2024.06.04 - 06.19.40am.jpg', 'Gigaval', 'Laki-laki', NULL, 'gigaval@gmail.com', 'gigaval', '123', 'Mahasiswa', 'Sate maranggih', '098080808080', ' ', 'Galaxy Bima Sakti');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`bookID`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `bookID` (`bookID`);

--
-- Indexes for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`orderdetID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `bookID` (`bookID`);

--
-- Indexes for table `orderhistory`
--
ALTER TABLE `orderhistory`
  ADD PRIMARY KEY (`orderhistID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `bookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orderdetail`
--
ALTER TABLE `orderdetail`
  MODIFY `orderdetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orderhistory`
--
ALTER TABLE `orderhistory`
  MODIFY `orderhistID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`bookID`) REFERENCES `books` (`bookID`);

--
-- Constraints for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `orderdetail_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`),
  ADD CONSTRAINT `orderdetail_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `orderdetail_ibfk_3` FOREIGN KEY (`bookID`) REFERENCES `books` (`bookID`);

--
-- Constraints for table `orderhistory`
--
ALTER TABLE `orderhistory`
  ADD CONSTRAINT `orderhistory_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`),
  ADD CONSTRAINT `orderhistory_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
