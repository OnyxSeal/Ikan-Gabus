<?php
include_once 'connection/conn.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: sign.php');
    exit;
}

$username = $_SESSION['username'] ?? '';

$user_id = null;
$result_cart = false;

if ($username) {
    $query_user = "SELECT userID FROM users WHERE username = ? OR email = ? LIMIT 1";
    $stmt_user = $db->prepare($query_user);
    $stmt_user->bind_param('ss', $username, $username);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user && $result_user->num_rows > 0) {
        $user = $result_user->fetch_assoc();
        $user_id = $user['userID'];

        $query_cart = "
            SELECT bnn.bmarksID, b.bookID, b.title, b.cover
            FROM bookmarks bnn
            JOIN books b ON bnn.bookID = b.bookID
            WHERE bnn.userID = ?
            ORDER BY bnn.book_at DESC
        ";
        $stmt_cart = $db->prepare($query_cart);
        $stmt_cart->bind_param('i', $user_id);
        $stmt_cart->execute();
        $result_cart = $stmt_cart->get_result();
    } else {
        echo "User not found.";
        exit;
    }
} else {
    echo "User is not logged in.";
    exit;
}

// Delete bookmark handling
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = (int) $_POST['delete_id'];

    $query_delete_cart = "DELETE FROM bookmarks WHERE bmarksID = ?";
    $stmt_delete = $db->prepare($query_delete_cart);
    $stmt_delete->bind_param('i', $delete_id);

    if ($stmt_delete->execute()) {
        header('Location: carts.php');
        exit;
    } else {
        echo "Failed to delete bookmark.";
    }

    $stmt_delete->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bookmark</title>
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .content-container {
            max-width: 90%;
            margin: 8% 5%;
        }
        .cart-header {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .actBack a {
            color: black;
            text-decoration: none;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        .actBack a:hover {
            color: #800000;
        }
        .actBack a .fa-angle-left {
            margin-right: 8px;
            transition: margin 0.3s ease;
        }
        .actBack:hover .fa-angle-left {
            margin-left: 5px;
            margin-right: 13px;
        }
        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .cart-item {
            display: flex;
            background-color: #fff;
            padding: 15px;
            border-radius: 10px;
            align-items: center;
            gap: 15px;
            box-shadow: 0 1px 3px rgb(0 0 0 / 0.1);
        }
        .cart-item img {
            width: 60px;
            height: 90px;
            object-fit: cover;
            border-radius: 4px;
            box-shadow: rgba(0,0,0,0.1) 0px 1px 3px;
        }
        .cart-item-info {
            flex: 1;
        }
        .cart-item-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .cart-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .cart-actions button {
            background: none;
            border: none;
            cursor: pointer;
            color: #333;
            font-size: 18px;
            transition: color 0.3s ease;
        }
        .cart-actions button:hover {
            color: #800000;
        }
        .empty-cart {
            text-align: center;
            font-size: 18px;
            color: #555;
            margin-top: 30px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
    <?php include "layout/naviga.php"; ?>

    <div class="content-container">
        <div class="cart-header">
            <div class="actBack">
                <a href="index.php">
                    <i class="fa fa-angle-left"></i> Kembali
                </a>
            </div>
            <h1>Bookmark</h1>
        </div>

        <div class="cart-items">
            <?php if ($result_cart && $result_cart->num_rows > 0): ?>
                <?php while ($row = $result_cart->fetch_assoc()): ?>
                    <div class="cart-item">
                        <img src="../admin.fasilkomlib.com/dashboard/listgambar/<?php echo htmlspecialchars($row['cover']); ?>" alt="Book Cover" />
                        <div class="cart-item-info">
                            <div class="cart-item-title"><?php echo htmlspecialchars($row['title']); ?></div>
                        </div>
                        <div class="cart-actions">
                            <button title="Favorite (Belum aktif)">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                            <form method="post" style="display:inline;" onsubmit="return confirm('Yakin hapus buku <?php echo addslashes(htmlspecialchars($row['title'])); ?>?');">
                                <input type="hidden" name="delete_id" value="<?php echo (int)$row['bmarksID']; ?>" />
                                <button type="submit" title="Hapus Bookmark">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="empty-cart">
                    Bookmark kamu kosong. <br />
                    <i class="fa-solid fa-bookmark fa-2xl"></i>
                </p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>