<?php
// Sertakan file koneksi
include "../connection/conn.php";

// Define status pengiriman mapping
$statusPengiriman = [
    'nyp' => 'Belum Bayar',
    'pckd' => 'Dikemas',
    'sent' => 'Dikirim',
    'done' => 'Selesai'
];

$offset = 0;
$no = $offset + 1;

// Query untuk mendapatkan pesanan dari tabel orders dan orderdetail
$sql = "SELECT o.orderID, u.username, o.orderDate, SUM(od.subtotal) AS total, od.status
    FROM orders o
    INNER JOIN user u ON o.userID = u.userID
    INNER JOIN orderdetail od ON o.orderID = od.orderID
    WHERE od.status NOT IN ('nyp')
    GROUP BY o.orderID, u.username, o.orderDate, od.status
    ORDER BY o.orderID ASC";
$result = $db->query($sql);

$rows = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $translatedStatus = isset($statusPengiriman[$row['status']]) ? $statusPengiriman[$row['status']] : $row['status'];
        $rows[] = [
            'no' => $no++,
            'orderID' => $row['orderID'],
            'username' => $row['username'],
            'orderDate' => $row['orderDate'],
            'total' => "Rp" . number_format($row['total'], 0, ',', '.'),
            'status' => $translatedStatus
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pengiriman</title>
    <link rel="icon" href="https://www.gigaval.com/favicon.ico">
    <style>
        body {
            background-color: #EDEDED;
        }

        .konten {
            margin: 2% 1% 2% 6.5%;
            background-color: white;
            border-radius: 10px;
            padding: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: none;
            font-size: 13px;
            margin-top: 10px;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: gray;
            color: white;
        }

        .belang:nth-child(even) {
            background-color: rgba(0, 0, 0, 0.1);
        }

        th {
            background-color: #CECFCE;
            color: #000;
            text-align: left;
            border-bottom: 1px solid #800000;
            position: sticky;
            top: 0;
        }

        .titleDBar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1% 0%;
            border-bottom: 1px solid rgba(0, 0, 0, 0.4);
        }

        #title {
            font-size: 24px;
            font-weight: 600;
        }

        .form-control:focus {
            color: #0d6efd;
            border-color: #eee;
            outline: 0;
            box-shadow: none;
            border-bottom: 1px solid rgba(13, 110, 253, 0.5);
        }

        .form-group {
            margin-top: 1rem;
            position: relative;
            margin-bottom: 1.5rem;
            width: 20%;
        }

        .form-control {
            width: 100%;
            height: 35px;
            padding: 0 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
            box-sizing: border-box;
        }

        .form-label {
            position: absolute;
            top: 10px;
            left: 10px;
            color: #aaa;
            font-size: 16px;
            transition: all 0.2s ease;
        }

        .form-control:focus+.form-label,
        .form-control:not(:placeholder-shown)+.form-label {
            top: -10px;
            left: 10px;
            font-size: 12px;
            color: #0d6efd;
            background-color: #fff;
            padding: 0 5px;
        }

        .textcent {
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include "nav.php" ?>
    <?php include "sidebar.php" ?>
    <div class="kontener">
        <div class="konten">
            <div class="titleDBar">
                <span id="title">Daftar Pengiriman</span>
            </div>
            <div class="form-group">
                <input type="text" id="search-box" class="form-control" placeholder=" " />
                <label for="search-box" class="form-label">Search</label>
            </div>
            <table class="table" id="shipping-table">
                <thead>
                    <tr>
                        <th class="textcent">No</th>
                        <th class="orderID">Order ID</th>
                        <th class="buyerName">Pembeli</th>
                        <th>Tanggal Pesanan</th>
                        <th>Total Harga</th>
                        <th>Status Pengiriman</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($rows) > 0) : ?>
                        <?php foreach ($rows as $row) : ?>
                            <tr>
                                <td class='textcent'><?= $row['no']; ?></td>
                                <td class='orderID'><?= $row['orderID']; ?></td>
                                <td class='buyerName'><?= $row['username']; ?></td>
                                <td><?= $row['orderDate']; ?></td>
                                <td><?= $row['total']; ?></td>
                                <td><?= $row['status']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr><td colspan='6'>Tidak ada pengiriman.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

<script>
    const input = document.getElementById('search-box');
    const label = input.nextElementSibling;

    input.addEventListener('focus', function () {
        label.classList.add('active');
    });

    input.addEventListener('blur', function () {
        if (input.value === '') {
            label.classList.remove('active');
        }
    });

    // Pencarian berdasarkan judul
    input.addEventListener('input', function () {
        const searchValue = input.value.toLowerCase();
        const rows = document.querySelectorAll('#shipping-table tbody tr');

        rows.forEach(function (row) {
            const orderID = row.querySelector('.orderID').textContent.toLowerCase();
            const buyerName = row.querySelector('.buyerName').textContent.toLowerCase();
            if (orderID.includes(searchValue) || buyerName.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

</html>