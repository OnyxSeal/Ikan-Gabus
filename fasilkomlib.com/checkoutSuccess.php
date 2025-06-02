<?php
session_start();
$total_subtotal = $_GET['total_subtotal'] ?? 0;

if (isset($_SESSION['total_subtotal'])) {
    unset($_SESSION['total_subtotal']); // Hapus nilai dari session setelah digunakan
}

$anjay = 'https://wa.me/6281321412314'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QRIS Payment</title>
    <link rel="icon" href="https://www.gigaval.com/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .content-container {
            margin: 10% 10%;
            display: flex;
            align-items: flex-start;
            gap: 20px;
            max-width: 500px;
        }

        .qris {
            flex: 3;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
        }

        .infoQris {
            flex: 2;
            display: flex;
            flex-direction: column;
            gap: 20px;
            max-width: 200px;
        }

        .infoDQ {
            text-align: justify;
            /* padding: 12px; */
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            border: 1px solid #800000;
        }

        /* pake wangsaff nih */

        a {
            text-decoration: none;
        }

        .contactMe {
            background-color: #25D366;
            color: #fff;
            cursor: pointer;
            text-align: center;
            padding: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            transition: 0.5s ease-in-out;
            border: 1px solid white;

            &:hover {
                border: 1px solid #25D366;
                background-color: white;
                color: #25D366;
            }
        }

        #alertIQ {
            font-size: 14px;
        }

        .alertIQ {
            line-height: 22px;
            padding: 10px;
        }

        .headIQ {
            background-color: #800000;
            color: white;
            width: 100%;
            padding: 8px;
            border-radius: 8px 8px 0 0;
        }

        .content-container h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .content-container p {
            color: #555;
            font-size: 16px;
            /* margin-bottom: 10px; */
        }

        .qr-code img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border: 2px solid #ddd;
            border-radius: 10px;
        }

        .qr-code {
            /* margin-bottom: 20px; */
        }

        #kuduBayar {
            font-size: 36px;
            font-weight: 700;
        }

        #qrisOwner{
            font-size: 14px;
            margin-top: -5px;
            font-weight: 600;
            color: black;
        }

        #infoPrice {
            font-size: 12px;
            color: #800000;
            font-weight: 600;
            background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 1), rgba(0, 0, 0, 0));
            background-position: top;
            background-size: 100% 1px;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body>
    <?php include "layout/naviga.php" ?>
    <div class="content-container">
        <div class="qris">
            <h1>Checkout Success</h1>
            <p>Silahkan scan kode QRIS dibawah ini</p>
            <div class="qr-code">
                <img src="image/qris/QrisRaival1x1.jpg" alt="QRIS Code" />
            </div>
            <p id="qrisOwner">a.n. Raival</p>
            <p>Total yang harus Kamu bayar</p>
            <span id="kuduBayar">Rp<?php echo number_format($total_subtotal, 0, ',', '.'); ?></span>
            <p id="infoPrice">*belum termasuk ongkir</p>
        </div>
        <div class="infoQris">
            <div class="infoDQ">
                <div class="headIQ">
                    <span id="headIQ">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        Info
                    </span>
                </div>
                <div class="alertIQ">
                    <span id="alertIQ">Sebelum melakukan pembayaran, hubungi admin terlebih dahulu untuk mengkonfirmasi
                        pesanan yang akan kamu beli.</span><br>
                    <span id="alertIQ">Mulai dari penentuan alamat, pengecekan estimasi ongkir, hingga pembayaran
                        selesai dilakukan.</span>
                </div>
            </div>
            <a href="" onclick="window.location.href='<?php echo $anjay; ?>'; return false;">
                <div class="contactMe">
                    <i class="fa-brands fa-whatsapp fa-lg"></i>
                    Chat Admin
                </div>
            </a>
        </div>
    </div>
</body>

</html>