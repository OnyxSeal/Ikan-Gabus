<?php
session_start();
include "../connection/conn.php";

// Pagination variables
$limit = 10; // Number of entries to show in a page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number
$offset = ($page - 1) * $limit; // Calculate offset for SQL query

try {
    // Count total records
    $countQuery = "SELECT COUNT(*) AS total FROM orderdetail";
    $countResult = $db->query($countQuery);
    $totalRows = $countResult->fetch_assoc()['total'];
    $totalPages = ceil($totalRows / $limit);

    // Fetch records with pagination
    $tampilkanBuku = "SELECT od.*, b.title, u.username, o.orderDate, 
                        od.status AS status
                    FROM orderdetail od 
                    INNER JOIN orders o ON od.orderID = o.orderID 
                    INNER JOIN books b ON od.bookID = b.bookID 
                    INNER JOIN user u ON o.userID = u.userID
                    ORDER BY od.orderdetID ASC
                    LIMIT $limit OFFSET $offset";
    $hasilTampil = $db->query($tampilkanBuku);
    $rows = []; // Initialize an array to store the rows

    if ($hasilTampil) {
        // Fetch data into $rows array
        while ($row = $hasilTampil->fetch_assoc()) {
            $rows[] = $row; // Append each row to the $rows array
        }

        // Check if any rows were fetched
        if (empty($rows)) {
            $message = "Tidak ada pesanan.";
        }
    } else {
        $message = "Query execution failed.";
    }
} catch (Exception $e) {
    $message = "Error: " . $e->getMessage();
}

// Daftar status list
$options = [
    'nyp' => 'Belum Bayar',
    'pckd' => 'Dikemas',
    'sent' => 'Dikirim',
    'done' => 'Selesai'
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_id"])) {
    $delete_id = $_POST["delete_id"];

    // Begin a transaction
    $db->begin_transaction();

    // Query to delete from orderhistory table
    $query_hapus_orderhistory = "DELETE FROM orderhistory WHERE orderID = ?";
    $stmt_hapus_orderhistory = $db->prepare($query_hapus_orderhistory);
    $stmt_hapus_orderhistory->bind_param("i", $delete_id);

    // Query to delete from orderdetail table
    $query_hapus_orderdetail = "DELETE FROM orderdetail WHERE orderID = ?";
    $stmt_hapus_orderdetail = $db->prepare($query_hapus_orderdetail);
    $stmt_hapus_orderdetail->bind_param("i", $delete_id);

    // Query to delete from orders table
    $query_hapus_orders = "DELETE FROM orders WHERE orderID = ?";
    $stmt_hapus_orders = $db->prepare($query_hapus_orders);
    $stmt_hapus_orders->bind_param("i", $delete_id);

    // Execute the delete queries
    if ($stmt_hapus_orderhistory->execute() && $stmt_hapus_orderdetail->execute() && $stmt_hapus_orders->execute()) {
        // Commit the transaction if all queries are successful
        $db->commit();
        echo "<script>alert('Berhasil menghapus pesanan.');</script>";
        // Redirect to refresh the page after deletion
        header("Location: pesanan.php");
        exit();
    } else {
        // Rollback the transaction if any query fails
        $db->rollback();
        echo "Error: " . $db->error;
    }
}
?>

<?php
include "../connection/conn.php";

// Check if edit button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_id"])) {
    $edit_id = $_POST["edit_id"];
    // Redirect to pesananedit.php with edit_id parameter
    header("Location: pesananedit.php?edit_id=$edit_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan</title>
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

        th,
        td {
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

        .textcent {
            text-align: center;
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

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .pagination a {
            margin: 0 5px;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ccc;
            color: #333;
        }

        .pagination a.active {
            background-color: #800000;
            color: white;
            border: 1px solid #800000;
        }

        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }

        /* Button Hapus */
        .btn-hapus {
            cursor: pointer;
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-out, box-shadow 0.15s ease-in-out;
        }

        .btn-hapus:hover {
            color: #fff;
            background-color: #c82333;
            border-color: #bd2130;
        }

        .btn-hapus:focus,
        .btn-hapus.focus {
            color: #fff;
            background-color: #c82333;
            border-color: #bd2130;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.5);
        }

        .btn-hapus:active,
        .btn-hapus.active,
        .show>.btn-hapus.dropdown-toggle {
            color: #fff;
            background-color: #bd2130;
            border-color: #b21f2d;
        }

        .btn-hapus:active:focus,
        .btn-hapus.active:focus,
        .show>.btn-hapus.dropdown-toggle:focus {
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.5);
        }

        .btn-hapus.disabled,
        .btn-hapus:disabled {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        /* Button Edit */
        .btn-edit {
            cursor: pointer;
            color: #212529;
            background-color: #ffc107;
            border-color: #ffc107;
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.25rem 0.5rem;
            /* Lebih kecil dari ukuran standar */
            font-size: 0.875rem;
            /* Ukuran font lebih kecil */
            line-height: 1.5;
            border-radius: 0.2rem;
            /* Lebih kecil dari ukuran standar */
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn-edit:hover {
            color: #212529;
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .btn-edit:focus,
        .btn-edit.focus {
            color: #212529;
            background-color: #e0a800;
            border-color: #d39e00;
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.5);
        }

        .btn-edit:active,
        .btn-edit.active,
        .show>.btn-edit.dropdown-toggle {
            color: #212529;
            background-color: #d39e00;
            border-color: #c69500;
        }

        .btn-edit:active:focus,
        .btn-edit.active:focus,
        .show>.btn-edit.dropdown-toggle:focus {
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.5);
        }
    </style>
</head>

<body>
    <?php include "nav.php" ?>
    <?php include "sidebar.php" ?>
    <div class="kontener">
        <div class="konten">
            <div class="titleDBar">
                <span id="title">Daftar Pesanan</span>
            </div>
            <div class="form-group">
                <input type="text" id="search-box" class="form-control" placeholder=" " />
                <label for="search-box" class="form-label">Search</label>
            </div>
            <?php if (!empty($message)): ?>
                <p><?php echo $message; ?></p>
            <?php else: ?>
                <table id="order-table">
                    <thead>
                        <tr>
                            <th class="textcent">No</th>
                            <th>Judul</th>
                            <th>Jumlah</th>
                            <th>Subtotal(Rp)</th>
                            <th>Pembeli</th>
                            <th>Masuk Pada</th>
                            <th>Status</th>
                            <th>Edit/Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = $offset + 1; ?>
                        <?php foreach ($rows as $row): ?>
                            <tr class="belang">
                                <td class="textcent"><?php echo $no++; ?></td>
                                <td class="product-title"><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                <td><?php echo number_format($row['subtotal'], 0, ',', '.'); ?></td>
                                <td class="buyerName"><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['orderDate']); ?></td>
                                <td><?php echo $options[$row['status']]; ?></td>
                                <td>
                                    <form action='pesananedit.php' method='get' style='display:inline;'>
                                        <input type='hidden' name='edit_id' value='<?php echo $row['orderID']; ?>'>
                                        <button type='submit' class="btn-edit">
                                            <i class='fa-solid fa-pen-to-square'></i>
                                        </button>
                                    </form>
                                    <form action="pesanan.php" method="post" style="display:inline;"
                                        onsubmit="return confirm('Yakin hapus pesanan buku yang berjudul <?php echo $row['title'];?> milik <?php echo $row['username']; ?>?')">
                                        <input type="hidden" name="delete_id" value="<?php echo $row['orderID']; ?>">
                                        <button type="submit" class="btn-hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>"
                            class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

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
            const rows = document.querySelectorAll('#order-table tbody tr');

            rows.forEach(function (row) {
                const buyerName = row.querySelector('.buyerName').textContent.toLowerCase();
                const titleText = row.querySelector('.product-title').textContent.toLocaleLowerCase();
                if (titleText.includes(searchValue) || buyerName.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>
