<?php
// Mulai sesi jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Hubungkan ke database
include_once 'connection/conn.php';

// Ambil query dari form pencarian
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Cegah injeksi SQL
$query = htmlspecialchars($query);

// Buat SQL query
$sql = "SELECT bookID, title, cover FROM books WHERE title LIKE ?";
$stmt = $db->prepare($sql);
$searchQuery = '%' . $query . '%';
$stmt->bind_param('s', $searchQuery);
$stmt->execute();
$result = $stmt->get_result();

// Tampilkan hasil pencarian

$query_produk = "SELECT * FROM books";
$result_produk = $db->query($query_produk);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian untuk "<?php echo $query; ?>"</title>
    <link rel="icon" href="https://www.gigaval.com/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background-color: #F5F5F5;
            font-family: Arial, sans-serif;
        }

        .content-container {
            max-width: 90%;
            margin: 8% 5%;
        }

        .cart-header {
            border-bottom: 1px solid #ddd;
            margin-bottom: 30px;
        }

        .konten {
            display: flex;
            align-items: flex-start;
            gap: 20px;
        }

        .actBack a {
            color: black;
            text-decoration: none;
            transition: all 1s ease-in-out;
        }

        .actBack a .fa-angle-left {
            transition: margin 0.5s ease-in-out;
        }

        .actBack:hover .fa-angle-left {
            margin-left: 5px;
            margin-right: -5px;
            transition: margin 0.5s ease-in-out;
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
            max-width: 160px;
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
            border: 1px solid #071982;
            color: #80ffd3 !important;
        }

        .socialMed::before {
            content: '';
            width: 0%;
            height: 100%;
            display: block;
            background: #071982;
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
            background: #80ffd3;
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
    </style>
</head>

<body>
    <?php include "layout/naviga.php" ?>
    <div class="content-container">
        <div class="cart-header">
            <div class="actBack">
                <a href="index.php">
                    <i class="fa fa-angle-left"></i>&emsp;Kembali
                </a>
            </div>
            <h1>Hasil pencarian "<?php echo $query ?>"</h1>
        </div>
        <div class="konten">
            <div class="nasiLemak">
                <div class="nasiTangkar">
                    <div class="nasiUduk">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($book = $result->fetch_assoc()): ?>
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
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>Tidak ada buku dengan kata kunci <?php echo $query ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="nasiLemaks">
                <div class="nasiTangkar">
                    <div class="titleDBar">
                        <span id="titleTB">Ikuti Gwejh</span>
                    </div>
                    <div class="nasiUduk">
                        <a href="https://www.instagram.com/vall.rar" target="_b">
                            <div class="socialMed instagram">
                                <i class="fa-brands fa-instagram"></i> Instagram
                            </div>
                        </a>
                        <a href="">
                            <div class="socialMed twitter">
                                <i class="fa-brands fa-x-twitter"></i> Twitter
                            </div>
                        </a>
                        <a href="">
                            <div class="socialMed github">
                                <i class="fa-brands fa-github"></i> Github
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


</html>

<?php
// Tutup koneksi
$stmt->close();
$db->close();
?>