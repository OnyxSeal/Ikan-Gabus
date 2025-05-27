<?php
include 'connection/conn.php';
session_start();

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $query_produk = "SELECT * FROM books WHERE bookID = $book_id";
    $result_produk = $db->query($query_produk);

    if ($result_produk->num_rows > 0) {
        $book = $result_produk->fetch_assoc();
        $book['price'] = number_format($book['price'], 0, ',', '.');
        $isOutOfStock = $book['quantityavail'] == 0;
        $initialSubtotal = $isOutOfStock ? '-' : (int) str_replace(['Rp', '.'], '', $book['price']);
    } else {
        echo "Buku tidak ditemukan.";
        exit;
    }
} else {
    echo "ID buku tidak ditemukan.";
    exit;
}

if (isset($_POST['add_to_cart']) && isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $quantity = $_POST['quantity']; // Ambil jumlah dari formulir

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    } else {
        echo "Session username not set.<br>";
        exit;
    }

    // Ambil informasi buku dari database
    $query_produk = "SELECT * FROM books WHERE bookID = $book_id";
    $result_produk = $db->query($query_produk);

    if ($result_produk->num_rows > 0) {
        $book = $result_produk->fetch_assoc();
        $price = (int) str_replace(['Rp', '.'], '', $book['price']); // Hilangkan 'Rp' dan '.'
        $subtotal = ($price * $quantity) / 100;

        // Ambil userID berdasarkan username dari sesi
        $query_user = "SELECT userID FROM user WHERE username = '$username' OR email = '$username'";
        $result_user = $db->query($query_user);

        if ($result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc();
            $user_id = $user['userID'];

            // Check if the book is already in the cart
            $check_cart_query = "SELECT * FROM cart WHERE userID = $user_id AND bookID = $book_id";
            $result_cart = $db->query($check_cart_query);

            if ($result_cart->num_rows > 0) {
                // If the book is already in the cart, update the quantity
                $cart_item = $result_cart->fetch_assoc();
                $new_quantity = $cart_item['quantity'] + $quantity;
                $new_subtotal = $new_quantity * $price;
                $update_cart_query = "UPDATE cart SET quantity = $new_quantity, subTotal = $new_subtotal WHERE userID = $user_id AND bookID = $book_id";
                if ($db->query($update_cart_query)) {
                    echo "Book quantity updated in cart successfully.";
                } else {
                    echo "Error updating cart: " . $db->error;
                }
            } else {
                // If the book is not in the cart, insert a new entry
                $insert_cart_query = "INSERT INTO cart (userID, bookID, quantity, subTotal) VALUES ($user_id, $book_id, $quantity, $subtotal)";
                if ($db->query($insert_cart_query)) {
                    echo "Book added to cart successfully.";
                } else {
                    echo "Error: " . $db->error;
                }
            }
        } else {
            echo "Error: User not found.";
        }
    } else {
        echo "Error: Book not found.";
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku</title>
    <link rel="icon" href="https://www.gigaval.com/favicon.ico">
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

    #priceBD {
        font-size: 36px;
        font-weight: 600;
    }

    #priceBDST {
        text-align: right;
        font-size: 18px;
        font-weight: 500;
    }

    .quantity-input {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quantity-input input {
        width: 45px !important;
        height: 30px;
        text-align: center;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 0 5px;
    }

    .quantity-input button {
        width: 30px;
        height: 30px;
        border: none;
        background-color: #ddd;
        font-size: 20px;
        border-radius: 5px;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .quantity-input button:hover {
        background-color: #ccc;
    }

    .quantity-input button:disabled {
        cursor: not-allowed;
        background-color: #eee;

        &:hover {
            background-color: #fff !important;
        }
    }

    .quantity-input .input-group {
        display: flex;
        align-items: center;
        gap: 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
        padding: 3px;
    }

    .quantity-input .input-group input {
        width: 35px;
        height: 25px;
        border: none;
        text-align: center;
        font-size: 16px;
        padding: 0 5px;
    }

    .quantity-input .input-group button {
        width: 25px;
        height: 25px;
        border: none;
        background-color: #f1f1f1;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.1s ease, box-shadow 0.1s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);

        &:hover {
            background-color: #ddd;
        }
    }

    .quantity:focus {
        outline: none;
    }


    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }


    .minus-btn,
    .plus-btn {
        color: #800000;
    }

    .minus-btn:disabled,
    .plus-btn:disabled {
        cursor: not-allowed !important;
        opacity: 40%;
    }

    .subTotal {
        display: grid;
        grid-template-columns: 2fr 1fr;
        align-items: center;
        margin: 16px 0px;
    }

    .plusKeranjang button {
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
</style>

<body>
    <?php include "layout/naviga.php" ?>
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
                                <img src="../seller.tukubuku.com/dashboard/listgambar/<?php echo $book['cover']; ?>"
                                    alt="<?php echo $book['title']; ?>">
                            </div>
                            <div class="descBD">
                                <span id="titleBD"><b><?php echo $book['title']; ?></b></span><br>
                                <span id="authorBD">Author: <?php echo $book['author']; ?></span><br>
                                <span id="priceBD">Rp<?php echo $book['price']; ?></span>
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
                    <div class="titleDBar">
                        <span id="titleTB">Atur jumlah dan catatan</span>
                    </div>
                    <div class="bookDetail">
                        <div class="boxBD mb-3">
                            <div class="descBD">
                                <!-- HTML -->
                                <div class="quantity-input mb-3">
                                    <?php if ($isOutOfStock): ?>
                                        <div class="input-group">
                                            <button class="minus-btn disabled" disabled>-</button>
                                            <input type="number" value="0" min="0" class="quantity" disabled>
                                            <button class="plus-btn disabled" disabled>+</button>
                                        </div>
                                        <p>Stok: <span id="sH">Habis</span></p>
                                    <?php else: ?>
                                        <div class="input-group">
                                            <button class="minus-btn">-</button>
                                            <input type="number" value="1" min="1" class="quantity">
                                            <button class="plus-btn">+</button>
                                        </div>
                                        <p>Stok: <span class="stock"><?php echo $book['quantityavail']; ?></span></p>
                                    <?php endif; ?>
                                </div>
                                <div class="subTotal">
                                    <span>Subtotal</span>
                                    <span
                                        id="priceBDST"><?php echo $initialSubtotal === '-' ? '<b>-</b>' : 'Rp' . number_format($initialSubtotal, 0, ',', '.'); ?></span>
                                </div>
                                <?php if (!$isOutOfStock): ?>
                                    <?php if (isset($_SESSION['username'])): ?>
                                        <form method="post" action="book.php?id=<?php echo $book_id; ?>">
                                            <input type="hidden" name="quantity" value="1" class="quantity-hidden">
                                            <div class="plusKeranjang">
                                                <button type="submit" name="add_to_cart">+ Keranjang</button>
                                            </div>
                                        </form>
                                    <?php else: ?>
                                        <div class="plusKeranjang">
                                            <button onclick="window.location.href='sign.php'">+ Keranjang</button>
                                        </div>
                                    <?php endif; ?>
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

    const minusBtn = document.querySelector('.minus-btn');
    const plusBtn = document.querySelector('.plus-btn');
    const quantityInput = document.querySelector('.quantity');
    const hiddenQuantityInput = document.querySelector('.quantity-hidden');
    const stockElement = document.querySelector('.stock');
    const subtotalElement = document.querySelector('#priceBDST');

    let quantity = 1;
    const stock = parseInt(stockElement?.textContent || '0');
    const basePrice = parseInt(subtotalElement.textContent.replace(/\D/g, ''));

    function updateHiddenQuantity() {
        hiddenQuantityInput.value = quantity;
    }

    function updateSubtotal() {
        if (stock === 0) {
            subtotalElement.innerHTML = `<b>-</b>`;
        } else {
            const subtotal = basePrice * quantity;
            subtotalElement.innerHTML = `<b>Rp${subtotal.toLocaleString('id-ID')}</b>`;
        }
    }

    function toggleButtons() {
        if (quantity === 1 || stock === 0) {
            minusBtn.disabled = true;
            minusBtn.classList.add('disabled');
            minusBtn.style.cursor = 'not-allowed';
        } else {
            minusBtn.disabled = false;
            minusBtn.classList.remove('disabled');
            minusBtn.style.cursor = 'pointer';
        }

        if (quantity === stock || stock === 0) {
            plusBtn.disabled = true;
            plusBtn.classList.add('disabled');
            plusBtn.style.cursor = 'not-allowed';
        } else {
            plusBtn.disabled = false;
            plusBtn.classList.remove('disabled');
            plusBtn.style.cursor = 'pointer';
        }

        quantityInput.disabled = stock === 0;
    }

    if (stock === 0) {
        subtotalElement.innerHTML = `<b>-</b>`;
        minusBtn.disabled = true;
        plusBtn.disabled = true;
        quantityInput.disabled = true;
        document.querySelector('.plusKeranjang button').style.display = 'none';
    } else {
        minusBtn.addEventListener('click', () => {
            if (quantity > 0) {
                quantity--;
                quantityInput.value = quantity;
                updateSubtotal();
                toggleButtons();
                updateHiddenQuantity();
            }
        });

        plusBtn.addEventListener('click', () => {
            if (quantity < stock) {
                quantity++;
                quantityInput.value = quantity;
                updateSubtotal();
                toggleButtons();
                updateHiddenQuantity();
            }
        });

        quantityInput.addEventListener('input', () => {
            quantity = parseInt(quantityInput.value);
            if (isNaN(quantity) || quantity < 1) {
                quantity = 1;
                quantityInput.value = quantity;
            } else if (quantity > stock) {
                quantity = stock;
                quantityInput.value = quantity;
            }
            updateSubtotal();
            toggleButtons();
            updateHiddenQuantity();
        });

        updateSubtotal();
        toggleButtons();
        updateHiddenQuantity();
    }

</script>

</html>