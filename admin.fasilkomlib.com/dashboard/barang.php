<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Sertakan file koneksi
include_once "../connection/conn.php";

// Proses Hapus Produk
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']); // Sanitasi input

    // Query untuk mendapatkan data gambar
    $query_gambar = "SELECT cover FROM books WHERE bookID = ?";
    $stmt_gambar = $db->prepare($query_gambar);
    $stmt_gambar->bind_param("i", $delete_id);
    $stmt_gambar->execute();
    $result_gambar = $stmt_gambar->get_result();
    if ($result_gambar->num_rows > 0) {
        $row = $result_gambar->fetch_assoc();
        $image_data = $row['cover'];

        // Hapus file gambar jika ada
        if (!empty($image_data) && file_exists($image_data)) {
            unlink($image_data);
        }
    } else {
        echo "File gambar tidak ditemukan.";
    }

    // Query untuk menghapus produk dari database
    $query_hapus = "DELETE FROM books WHERE bookID = ?";
    $stmt_hapus = $db->prepare($query_hapus);
    $stmt_hapus->bind_param("i", $delete_id);
    if ($stmt_hapus->execute()) {
        echo "Produk berhasil dihapus.";
    } else {
        echo "Error: " . $stmt_hapus->error;
    }
}

// Query untuk mendapatkan daftar produk
$query_produk = "SELECT * FROM books";
$result_produk = $db->query($query_produk);

$offset = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Buku</title>
    <style>
        body {
            background-color: #EDEDED;
        }

        .nasiLemak {
            margin: 2% 1% 2% 6.5%;
        }

        .titPage {
            background-color: white;
            height: auto;
            padding: 16px;
            padding-top: 40px;
            border-radius: 10px
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

        .inputs {
            position: relative;
        }

        .inputs i {
            position: absolute;
            top: 14px;
            left: 4px;
            color: #b8b9bc;
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

        /* Button Tambah */
        .btn-success {
            cursor: pointer;
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn-success:hover {
            color: #fff;
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-success:focus,
        .btn-success.focus {
            color: #fff;
            background-color: #218838;
            border-color: #1e7e34;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.5);
        }

        .btn-success:active,
        .btn-success.active,
        .show>.btn-success.dropdown-toggle {
            color: #fff;
            background-color: #1e7e34;
            border-color: #1c7430;
        }

        .btn-success:active:focus,
        .btn-success.active:focus,
        .show>.btn-success.dropdown-toggle:focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.5);
        }

        .btn-success.disabled,
        .btn-success:disabled {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
        }

        .tBar {
            right: 20px;
        }

        .table {
            width: 100%;
            font-size: 12px;
            border-collapse: collapse;
        }

        .belang:nth-child(even) {
            background-color: rgba(111, 111, 111, 0.1);
        }

        th,
        td {
            padding: 5px;
        }

        .sinops {
            text-align: justify;
            display: block;
            max-width: 220px;
            max-height: 76px;
            overflow: hidden;
            transition: max-height 0.5s ease;
        }

        .sinops.expanded {
            max-height: 500px;
        }

        th {
            background-color: #CECFCE;
            color: fff;
            text-align: left;
            border-bottom: 1px solid #800000;
            position: sticky;
            top: 0;
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
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
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

        .btn-edit.disabled,
        .btn-edit:disabled {
            color: #212529;
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .max-w-10 {
            max-width: 10px;
        }

        .max-w-100 {
            max-width: 100px;
        }

        .max-w-150 {
            max-width: 150px;
        }
    </style>
</head>

<body>
    <?php include "nav.php" ?>
    <?php include "sidebar.php" ?>
    <div class="nasiLemak">
        <div class="titPage">
            <div class="titleDBar">
                <span id="title">Daftar Buku</span>
                <a href="barangtambah.php">
                    <button class="btn-success tBar">
                        <i class="fa-solid fa-plus"></i> Tambah Buku
                    </button>
                </a>
            </div>
            <div class="form-group">
                <input type="text" id="search-box" class="form-control" placeholder=" " />
                <label for="search-box" class="form-label">Search</label>
            </div>
            <table class="table">
                <thead>
                    <tr class="tHead">
                        <th class="textcent">No</th>
                        <th class="max-w-150">Judul</th>
                        <th>Sinopsis</th>
                        <th>Penulis</th>
                        <th>ISBN</th>
                        <th class="max-w-100">Genre</th>
                        <th>Jumlah Halaman</th>
                        <th>Bahasa</th>
                        <th>Gambar</th>
                        <th>File PDF</th>
                        <th>Edit/Hapus</th>
                    </tr>
                </thead>
                <tbody id="product-list">
                    <?php $no = $offset + 1; ?>
                    <?php while ($row = $result_produk->fetch_assoc()): ?>
                        <tr class="belang">
                            <td class="textcent"><?php echo $no++; ?></td>
                            <td class="product-title"><?php echo $row['title']; ?></td>
                            <td>
                                <span class="sinops"
                                    id="sinops-<?php echo $row['bookID']; ?>"><?php echo $row['sinopsis']; ?></span>
                                <button class="read-more" data-target="sinops-<?php echo $row['bookID']; ?>">Read
                                    More</button>
                            </td>
                            <td><?php echo $row['author']; ?></td>
                            <td><?php echo $row['isbn']; ?></td>
                            <td><?php echo $row['genre']; ?></td>
                            <td><?php echo $row['numberofpage']; ?></td>
                            <td><?php echo $row['language']; ?></td>
                            <td>
                                <?php if (!empty($row['cover'])): ?>
                                    <img src="listgambar/<?php echo $row['cover']; ?>" alt="Gambar Produk"
                                        style="max-width: 60px; max-height: 60px;">
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($row['pdfbook']) { ?>
                                    <a href="listpdf/<?= $row['pdfbook'] ?>" target="_blank">
                                        Lihat PDF
                                    </a>
                                <?php } else { ?>
                                    <span style="color:gray;">Tidak ada</span>
                                <?php } ?>
                            </td>

                            <td>
                                <form action='barangedit.php' method='get' style='display:inline;'>
                                    <input type='hidden' name='edit_id' value='<?php echo $row['bookID']; ?>'>
                                    <button type='submit' class="btn-edit">
                                        <i class='fa-solid fa-pen-to-square'></i>
                                    </button>
                                </form>
                                <form action="barang.php" method="post" style="display:inline;"
                                    onsubmit="return confirm('Yakin hapus buku <?php echo $row['title']; ?>?')">
                                    <input type="hidden" name="delete_id" value="<?php echo $row['bookID']; ?>">
                                    <button type="submit" class="btn-hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>

                            </td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
                const rows = document.querySelectorAll('#product-list tr');

                rows.forEach(function (row) {
                    const titleCell = row.querySelector('.product-title');
                    const titleText = titleCell.textContent.toLowerCase();
                    if (titleText.includes(searchValue)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // readmore readless abangku
            const buttons = document.querySelectorAll('.read-more');

            buttons.forEach(function (button) {
                button.addEventListener('click', function () {
                    const targetId = button.getAttribute('data-target');
                    const targetElement = document.getElementById(targetId);

                    if (targetElement.classList.contains('expanded')) {
                        targetElement.classList.remove('expanded');
                        button.textContent = 'Read More';
                    } else {
                        targetElement.classList.add('expanded');
                        button.textContent = 'Read Less';
                    }
                });
            });
        });
    </script>
</body>

</html>