<?php
session_start();
include "../connection/conn.php";

// Check if edit_id parameter is set
if (isset($_GET["edit_id"])) {
    $edit_id = $_GET["edit_id"];

    // Fetch data for the selected order
    $query = "SELECT od.*, b.title, u.username, oh.orderhistID
              FROM orderdetail od
              INNER JOIN orders o ON od.orderID = o.orderID
              INNER JOIN books b ON od.bookID = b.bookID
              INNER JOIN user u ON o.userID = u.userID
              LEFT JOIN (
                  SELECT orderhistID, orderID
                  FROM orderhistory
                  WHERE orderID = ?
                  ORDER BY orderhistID DESC
                  LIMIT 1
              ) oh ON o.orderID = oh.orderID
              WHERE od.orderID = ?
              ORDER BY od.orderdetID ASC";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $edit_id, $edit_id); // Bind the edit_id parameter twice as integer
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    // Check if order exists
    if (!$order) {
        echo "Pesanan tidak ditemukan.";
        exit();
    }

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize input
        $status = $_POST["status"];
        $orderdetID = $order['orderdetID'];

        // Update status in orderhistory table
        $update_query = "UPDATE orderdetail SET status = ? WHERE orderdetID = ?";
        $stmt_update = $db->prepare($update_query);
        $stmt_update->bind_param("si", $status, $orderdetID);
        if ($stmt_update->execute()) {
            echo "<script>alert('Status pesanan berhasil diperbarui.');</script>";
            header("Location: pesanan.php");
            exit();
        } else {
            echo "Error: " . $stmt_update->error;
        }
    }
} else {
    echo "Parameter edit_id tidak tersedia.";
    exit();
}

// Daftar status list
$options = [
    'nyp' => 'Belum Bayar',
    'pckd' => 'Dikemas',
    'sent' => 'Dikirim',
    'done' => 'Selesai'
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pesanan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="icon" href="https://www.gigaval.com/favicon.ico">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-top: 0;
            color: #333;
        }

        .order-details {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .order-details h3 {
            margin-top: 0;
            color: #555;
        }

        .order-details p {
            margin: 5px 0;
            color: #777;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        select,
        button {
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
            width: 100%;
            max-width: 300px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
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
    </style>
</head>

<body>
    <div class="container">
        <div class="actBack">
            <a href="javascript:history.back()">
                <i class="fa fa-angle-left"></i>&emsp;Kembali
            </a>
        </div>
        <h2>Edit Pesanan</h2>
        <div class="order-details">
            <h3>Detail Pesanan</h3>
            <p><strong>Judul Buku:</strong> <?php echo $order['title']; ?></p>
            <p><strong>Jumlah:</strong> <?php echo $order['quantity']; ?></p>
            <p><strong>Subtotal:</strong> Rp<?php echo number_format($order['subtotal'], 0, ',', '.'); ?></p>
            <p><strong>Pembeli:</strong> <?php echo $order['username']; ?></p>
            <p><strong>Status:</strong> <?php echo $options[$order['status']]; ?></p>
        </div>
        <form method="post">
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="nyp" <?php echo ($order['status'] == 'nyp') ? 'selected' : ''; ?>>Belum Bayar</option>
                <option value="pckd" <?php echo ($order['status'] == 'pckd') ? 'selected' : ''; ?>>Dikemas</option>
                <option value="sent" <?php echo ($order['status'] == 'sent') ? 'selected' : ''; ?>>Dikirim</option>
                <option value="done" <?php echo ($order['status'] == 'done') ? 'selected' : ''; ?>>Selesai</option>
            </select>
            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>

</html>