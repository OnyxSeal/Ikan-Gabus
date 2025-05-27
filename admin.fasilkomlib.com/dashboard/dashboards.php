<!-- redirect -->
<?php
$currentLocation = $_SERVER['REQUEST_URI'];
// gambar
if (strpos($currentLocation, 'edit') !== false || strpos($currentLocation, 'orderstatus') !== false) {
    $ppurl = '../../image/profile/';
} else {
    $ppurl = '../image/profile/';
}
?>


<?php
include_once "../connection/conn.php";

$queryProdukTerbaru = "SELECT title, cover FROM books ORDER BY publicationdate DESC LIMIT 6";
$resultProdukTerbaru = $db->query($queryProdukTerbaru);

$produkTerbaru = array();
while ($row = $resultProdukTerbaru->fetch_assoc()) {
    $produk = array(
        'title' => $row['title'],
        'cover' => $row['cover']
    );
    $produkTerbaru[] = $produk;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<style>
    /* main content */
    .main-content {
        padding: 20px;
        margin-top: 20px;
        margin-left: 10px;
        transition: margin-left 0.3s ease;
        padding: 20px;
        color: #800000;
        z-index: 999;
    }

    .main-content h2 {
        color: #800000;
        /* Ubah warna teks */
        background-color: beige;
        /* Tambahkan warna latar belakang teks */
        text-align: center;
        padding: 10px 20px;
        /* Tambahkan padding agar teks tidak terlalu rapat dengan latar belakang */
        border-radius: 10px;
    }

    .maincontent {
        padding: 10px 40px;
        background: rgba(223, 194, 194, 0.6);
        border-radius: 50px;
    }

    /* Background Gambar */
    body {
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        /* Prevent horizontal scroll */
    }

    .footer {
        background-color: #333;
        color: #fff;
        text-align: center;
        padding: 20px 0;
        position: fixed;
        bottom: 0;
        width: 100%;
    }

    .row {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        justify-content: space-around;
    }

    .card {
        width: 250px;
        height: 300px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        padding: 10px;
        align-items: center;
    }

    .kotak {
        /* width: 100%; */
        max-width: 100%;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        justify-content: center;
    }

    .card-img-top {
        border-radius: 10px;
        width: 100%;
        height: 70%;
        object-fit: cover;
    }

    .card-body {
        padding: 10px;
        text-align: center;
    }

    .card-title {
        font-size: 1rem;
        color: #800000;
    }
    .name{
        text-transform: capitalize;
    }
</style>

<body>
    <?php include "nav.php" ?>
    <?php include "sidebar.php" ?>
    <div class="main-content">
        <h2>Buku Terbaru</h2>
        <div class="kotak">
            <div class="kotak">
                <?php foreach ($produkTerbaru as $produk) { ?>
                    <div class="card">
                        <img src="listgambar/<?php echo $produk['cover'] ?>" class="card-img-top"
                            alt="<?php echo $produk['title']; ?>" style="max-width: 200px; max-height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $produk['title']; ?></h5>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Scripts -->
</body>

</html>