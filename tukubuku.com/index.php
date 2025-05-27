<?php
if ($_SERVER['REQUEST_URI'] === '/tukubuku.com/index.php') {
    header('Location: /tukubuku.com/', true, 302);
    exit;
}
?>

<?php
// Start session if it hasn't been started already
session_start();

// Include file koneksi ke database
include "connection/conn.php";

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // Ambil username pengguna dari sesi
    $username = $_SESSION['username'];

    // Query untuk mengambil data pengguna berdasarkan username
    $sql = "SELECT fullname FROM user WHERE (username = '$username' OR email = '$username')";
    $result = mysqli_query($db, $sql);

    // Periksa apakah query berhasil dieksekusi
    if ($result) {
        // Ambil baris hasil query
        $row = mysqli_fetch_assoc($result);
        // Ambil nama lengkap dari hasil query
        $fullname = $row['fullname'];
    } else {
        // Jika query gagal, atur nama lengkap menjadi string kosong
        $fullname = "";
    }
} else {
    // If the user is not logged in, set $fullname to an empty string
    $fullname = "";
}


$query_produk = "SELECT * FROM books ORDER BY publicationdate DESC limit 10";
$result_produk = $db->query($query_produk);

$recent_books = [];

if ($result_produk->num_rows > 0) {
    while ($row = $result_produk->fetch_assoc()) {
        $recent_books[] = $row;
    }
}

$query_book = "SELECT * FROM books ORDER BY publicationdate DESC";
$result_book = $db->query($query_book);

$recent_all_books = [];

if ($result_book->num_rows > 0) {
    while ($row = $result_book->fetch_assoc()) {
        $recent_all_books[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuku Buku</title>
    <link rel="icon" href="https://www.gigaval.com/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #EDEDED;
    }

    .content-container {
        max-width: 92%;
        margin: 5% 4% 2% 4%;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        padding: 20px;
    }

    .biarMepet {
        margin-top: -50px;
    }

    .content {
        display: flex;
        align-items: flex-start;
        gap: 20px;
    }

    h2 {
        color: #000000;
        margin-bottom: 20px;
    }

    .sapa {
        transform: translateY(80px);
        font-size: 30px;
        font-weight: 500;
        text-align: right;
        padding-right: 100px;
        color: #800000;
    }

    .nasiLemak {
        flex: 3;
        border-radius: 10px;
        padding: 16px 16px 10px 16px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        background-color: white;
        padding: 16px;
    }

    .nasiLemaks {
        flex: 1;
        border-radius: 10px;
        padding: 16px 16px 10px 16px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        background-color: white;
    }

    .nasiTangkar {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        height: auto;
    }

    .nasiUduk {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 0px;
        width: 100%;
    }

    .recentBookAdded {
        cursor: pointer;
        border-radius: 10px;
        padding: 6px;
        width: 100%;
        position: relative;
    }

    .boxRBA {
        position: relative;
        text-align: center;
    }

    .coverRBA {
        position: relative;
    }

    .coverRBA img {
        width: 100%;
        height: 229px;
        object-fit: cover;
        /* border-radius: 10px; */

        &:hover {
            filter: brightness(80%);
        }
    }

    .descRBA {
        font-size: 12px;
        position: absolute;
        bottom: 0;
        width: 100%;
        text-align: center;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0));
        color: white;
        padding: 5px 0;
    }

    .titleDBar {
        font-size: 20px;
        font-weight: 600;
        text-transform: uppercase;
        border-bottom: 3px solid #800000;
        text-align: left;
        width: 100%;
    }

    .nasiUduk a {
        text-decoration: none;
    }

    .socialMed {
        height: 40px;
        width: 100%;
        border-radius: 10px;
        place-content: center;
        padding-left: 10px;
        margin-bottom: 8px;
    }

    .socialMed {
        margin: 10px 0px 0px 0px;
        top: 1px;
        font-family: "proxima-nova", sans-serif;
        font-weight: 500;
        font-size: 13px;
        text-transform: uppercase !important;
        letter-spacing: 2px;
        color: #000;
        text-align: left;
        border: 1px solid #fff;
        border-radius: 50px;
        position: relative;
        overflow: hidden !important;
        transition: all 0.3s ease-in-out;
        background: transparent !important;
        z-index: 10;
    }

    .socialMed:hover {
        border: 1px solid #600000;
        color: #fff !important;
    }

    .socialMed::before {
        content: '';
        width: 0%;
        height: 100%;
        display: block;
        background: #800000;
        position: absolute;
        transform: skewX(-20deg);
        left: -10%;
        opacity: 1;
        top: 0;
        z-index: -12;
        transition: all 0.7s cubic-bezier(0.77, 0, 0.175, 1);
        box-shadow: 2px 0px 14px rgba(0, 0, 0, 0.6);
    }

    .socialMed::after {
        content: '';
        width: 0%;
        height: 100%;
        display: block;
        background: #000;
        position: absolute;
        transform: skewX(-20deg);
        left: -10%;
        opacity: 0;
        top: 0;
        z-index: -15;
        transition: all 0.4s cubic-bezier(0.2, 0.95, 0.57, 0.99);
        box-shadow: 2px 0px 14px rgba(0, 0, 0, 0.6);
    }

    .socialMed:hover::before,
    .socialMed:hover::before {
        opacity: 1;
        width: 116%;
    }

    .socialMed:hover::after,
    .socialMed:hover::after {
        opacity: 1;
        width: 120%;
    }

    .populerBook {
        width: 100%;
    }
</style>

<body>
    <?php include "layout/naviga.php" ?>
    <div class="sapa">
        <?php if ($fullname !== ""): ?>
            <span class="sapa">
                <p>Selamat datang, <?php echo $fullname; ?>!</p>
            </span>
        <?php else: ?>
            <span class="sapa">
                <p>Selamat datang</p>
            </span>
        <?php endif; ?>
    </div>
    <div class="content-container">
        <div class="content">
            <!-- Pembungkus Terbaru -->
            <div class="nasiLemak">
                <!-- Isi Terbaru -->
                <div class="nasiTangkar">
                    <div class="titleDBar">
                        <span id="titleTB">terbaru</span>
                    </div>
                    <div class="nasiUduk">
                        <?php foreach ($recent_books as $book): ?>
                            <div class="recentBookAdded">
                                <div class="boxRBA">
                                    <a href="book.php?id=<?php echo $book['bookID']; ?>">
                                        <div class="coverRBA">
                                            <img src="../seller.tukubuku.com/dashboard/listgambar/<?php echo $book['cover']; ?>"
                                                alt="<?php echo $book['title']; ?>">
                                            <div class="descRBA">
                                                <span id="titleRBA"><b><?php echo $book['title']; ?></b></span><br>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="nasiLemaks">
                <div class="nasiTangkar">
                    <div class="titleDBar">
                        <span id="titleTB">ikuti kami</span>
                    </div>
                    <div class="nasiUduk">
                        <a href="https://www.instagram.com/vall.rar" target="_b">
                            <div class="socialMed instagram">
                                <i class="fa-brands fa-instagram"></i> Instagram
                            </div>
                        </a>
                        <a href="https://github.com/OnyxSeal" target="_b">
                            <div class="socialMed github">
                                <i class="fa-brands fa-github"></i> Github
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="content-container biarMepet">
        <div class="content">
            <div class="nasiLemak">
                <div class="nasiTangkar">
                    <div class="titleDBar">
                        <span id="titleTB">daftar buku</span>
                    </div>
                    <div class="nasiUduk">
                        <?php foreach ($recent_all_books as $book): ?>
                            <div class="recentBookAdded">
                                <div class="boxRBA">
                                    <a href="book.php?id=<?php echo $book['bookID']; ?>">
                                        <div class="coverRBA">
                                            <img src="../seller.tukubuku.com/dashboard/listgambar/<?php echo $book['cover']; ?>"
                                                alt="<?php echo $book['title']; ?>">
                                            <div class="descRBA">
                                                <span id="titleRBA"><b><?php echo $book['title']; ?></b></span><br>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include "layout/footer.php" ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const scrollPosition = localStorage.getItem('scrollPosition');
        if (scrollPosition) {
            window.scrollTo(0, parseInt(scrollPosition, 10)); // Ubah posisi scroll ke yang disimpan
            localStorage.removeItem('scrollPosition'); // Hapus setelah digunakan
        }
    });
</script>

</html>