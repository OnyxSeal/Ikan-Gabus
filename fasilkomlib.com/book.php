<?php
include_once 'connection/conn.php';
session_start();

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $query_produk = "SELECT * FROM books WHERE bookID = $book_id";
    $result_produk = $db->query($query_produk);

    if ($result_produk->num_rows > 0) {
        $book = $result_produk->fetch_assoc();
    } else {
        echo "Buku tidak ditemukan.";
        exit;
    }
} else {
    echo "ID buku tidak ditemukan.";
    exit;
}

if (isset($_POST['add_to_cart']) && isset($_GET['id'])) {
    $book_id = (int)$_GET['id'];

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    } else {
        echo "Session username not set.<br>";
        exit;
    }

    $query_produk = "SELECT * FROM books WHERE bookID = $book_id";
    $result_produk = $db->query($query_produk);

    if ($result_produk->num_rows > 0) {
        $book = $result_produk->fetch_assoc();

        $query_user = "SELECT userID FROM users WHERE username = '$username' OR email = '$username'";
        $result_user = $db->query($query_user);

        if ($result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc();
            $user_id = $user['userID'];

            $check_cart_query = "SELECT * FROM bookmarks WHERE userID = $user_id AND bookID = $book_id";
            $result_cart = $db->query($check_cart_query);

            if ($result_cart->num_rows > 0) {
                $_SESSION['success_message'] = "Buku sudah ada di bookmark!";
                header("Location: book.php?id=$book_id");
                exit;
            } else {
                $insert_cart_query = "INSERT INTO bookmarks (userID, bookID) VALUES ($user_id, $book_id)";
                if ($db->query($insert_cart_query)) {
                    $_SESSION['success_message'] = "Buku berhasil ditambahkan ke bookmark!";
                    header("Location: book.php?id=$book_id");
                    exit;
                } else {
                    echo "Gagal menambahkan ke bookmark.";
                }
            }
        } else {
            echo "Error: User not found.";
        }
    } else {
        echo "Error: Book not found.";
    }
}

// martabak spesial
$filenameFromDB = $book['pdfbook'];

// Cek jika pdfbook tidak kosong
if (!empty($filenameFromDB)) {
    // Ambil nama sampai sebelum tanda "_" ytta
    $mainName = strstr($filenameFromDB, '_', true);
} else {
    $mainName = ''; // fallback aman cuiy
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku</title>

    <!-- LottieFiles -->
    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.3.0/dist/dotlottie-wc.js" type="module"></script>
</head>

<style>
    body {
        background-color: #EDEDED;
    }

    .content-container {
        max-width: 92%;
        margin: 5% 4% 2% 4%;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        padding: 20px;
    }

    .content {
        display: flex;
        align-items: flex-start;
        gap: 20px;
    }

    .nasiLemak {
        flex: 3;
        border-radius: 10px;
        padding: 16px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        background-color: white;
    }

    .nasiLemaks {
        flex: 1;
        border-radius: 10px;
        padding: 16px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        background-color: white;
    }

    .nasiTangkar {
        background-color: white;
        padding: 16px;
        border-radius: 10px;
    }

    .titleDBar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1% 0%;
        border-bottom: 2px solid rgba(128, 0, 0, 0.4);
        margin-bottom: 10px;
    }

    #titleTB {
        font-size: 24px;
        font-weight: 600;
        line-height: 28px;
    }

    .boxBD {
        display: flex;
        align-items: flex-start;
        gap: 30px;
        border-bottom: 1px solid black;
        padding: 16px 0px;
    }

    .coverBD{
        box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
    }

    .coverBD img {
        flex: 1;
        width: 276px;
        height: 411px;
        object-fit: cover;
    }

    .coverBD img:hover {
        filter: brightness(80%);
    }

    .descBD {
        flex: 2;
    }

    #titleBD {
        font-size: 36px;
        line-height: 40px;
    }

    .plusBookMarks button,
    .dld button {
        margin: 8px 0;
        width: 100%;
        height: 36px;
        font-size: 18px;
        color: white;
        background-color: #800000;
        border-radius: 6px;

        &:hover {
            cursor: pointer;
            background-color: #900000;
        }

        &:active {
            transform: translateY(2px);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }
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

    .fullDescBD {
        display: flex;
        flex-direction: column;
    }

    #deskripsi {
        border-bottom: 1px solid rgba(128, 0, 0, 0.5);
        width: 18%;
    }

    #fullDescBD {
        text-align: justify;
        resize: none;
        border: none;
        height: 140px;
        max-width: 100%;
        padding: 2px 1px;
        selected: #800000;

        &:focus {
            outline: none;
        }
    }

    #sH {
        color: pink;
    }

    .line {
        border-bottom: 1px solid rgba(128, 0, 0, 0.5);
    }

    .mb-3 {
        margin-bottom: 6px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg);}
        100% { transform: rotate(360deg);}
    }
    .spinner {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #800000;
        border-radius: 50%;
        width: 16px;
        height: 16px;
        animation: spin 1s linear infinite;
        display: inline-block;
        vertical-align: middle;
        margin-left: 8px;
    }


    .notifSuccess {
        position: fixed;
        top: 0;
        left: 50%;
        transform: translateX(-50%) translateY(-100%);
        background-color: #28a745;
        color: white;
        padding: 12px 20px;
        border-radius: 6px;
        box-shadow: 0 0 10px rgba(0,0,0,0.2);
        z-index: 999;
        font-size: 16px;
        animation: slideDownFadeOut 4s forwards;
    }

    @keyframes slideDownFadeOut {
        0% {
            opacity: 0;
            transform: translateX(-50%) translateY(-100%);
        }
        10% {
            opacity: 1;
            transform: translateX(-50%) translateY(70px);
        }
        80% {
            opacity: 1;
            transform: translateX(-50%) translateY(70px);
        }
        100% {
            opacity: 0;
            transform: translateX(-50%) translateY(-100%);
        }
    }


</style>

<body>
    <?php include "layout/naviga.php" ?>

    <!-- notif bookmark -->
    <?php if (isset($_SESSION['success_message'])): ?>
    <div class="notifSuccess" id="notifSuccess">
        <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
    </div>
    <?php endif; ?>

    <!-- baris mulai ui -->
    <div class="content-container">
        <div class="content">
            <div class="nasiLemak">
                <div class="nasiTangkar">
                    <div class="actBack">
                        <a href="javascript:void(0);" onclick="goBack()">
                            <i class="fa fa-angle-left"></i>&emsp;Kembali
                        </a>
                    </div>
                    <div class="titleDBar">
                        <span id="titleTB">Detail Buku</span>
                    </div>
                    <div class="bookDetail">
                        <div class="boxBD">
                            <div class="coverBD">
                                <img src="../admin.fasilkomlib.com/dashboard/listgambar/<?php echo $book['cover']; ?>"
                                    alt="<?php echo $book['title']; ?>">
                            </div>
                            <div class="descBD">
                                <span id="titleBD"><b><?php echo $book['title']; ?></b></span><br>
                                <span id="authorBD">Author: <?php echo $book['author']; ?></span><br>
                                <div class="mb-3"></div>

                                <div class="fullDescBD">
                                    <span id="deskripsi">Deskripsi</span>
                                    <textarea name="" id="fullDescBD"
                                        readonly><?php echo $book['sinopsis']; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nasiLemaks">
                <div class="nasiTangkar">
                    <div class="bookDetail">
                        <div class="boxBD mb-3">
                            <div class="descBD">
                                <?php if (isset($_SESSION['username'])): ?>
                                        <form method="post" action="book.php?id=<?php echo $book_id; ?>">
                                            <div class="plusBookMarks">
                                                <button type="submit" name="add_to_cart">+ Bookmark</button>
                                            </div>
                                        </form>
                                        <div class="dld">
                                            <a id="downloadLink" href="https://ln.run/<?php echo htmlspecialchars($mainName); ?>">
                                                <button id="downloadBtn" type="button">
                                                    <i class="fa-solid fa-download"></i> Download
                                                </button>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div class="plusBookMarks">
                                            <button onclick="window.location.href='sign.php'">+ Bookmark</button>
                                        </div>
                                        <div class="dld">
                                                <button onclick="window.location.href='sign.php'">Download</button>
                                        </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</body>
<script>
    function goBack() {
        window.history.back();
    }

    document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('downloadBtn');
    const link = document.getElementById('downloadLink');

    btn.addEventListener('click', function () {
        if (btn.disabled) return;
        btn.disabled = true;

        // Tampilkan spinner
        btn.innerHTML = `Mengunduh... <span class="spinner"></span>`;

        // Simulasi waktu download
        setTimeout(() => {
        // Bagian ini ganti isi tombol dengan animasi dotlottie + teks
        btn.innerHTML = `
            <dotlottie-wc 
            src="https://lottie.host/b8675cad-763a-43a7-bb61-87861ce3d543/S8ycXnGDdv.lottie"
            autoplay 
            style="width: 24px; height: 24px; display: inline-block; vertical-align: middle;">
            </dotlottie-wc>
            <span style="margin-left: 8px;">Download Selesai</span>
        `;

        // Trigger unduh
        link.click();
        }, 3000);
    });
    });

</script>

</html>