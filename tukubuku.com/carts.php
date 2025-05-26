<?php
include 'connection/conn.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: sign.php');
    exit;
}

$username = $_SESSION['username'] ?? '';

if ($username) {
    $query_user = "SELECT userID FROM user WHERE username = ? OR email = ?";
    $stmt_user = $db->prepare($query_user);
    $stmt_user->bind_param('ss', $username, $username);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user && $result_user->num_rows > 0) {
        $user = $result_user->fetch_assoc();
        $user_id = $user['userID'];

        $query_cart = "
            SELECT c.cartID, b.bookID, b.title, b.cover, b.price, c.quantity, b.quantityavail
            FROM cart c
            JOIN books b ON c.bookID = b.bookID
            WHERE c.userID = ?
            GROUP BY c.cartID, b.bookID, b.title, b.cover, b.price, c.quantity, b.quantityavail
            ORDER BY c.enteredON DESC;
        ";
        $stmt_cart = $db->prepare($query_cart);
        $stmt_cart->bind_param('i', $user_id);
        $stmt_cart->execute();
        $result_cart = $stmt_cart->get_result();
    } else {
        echo "User not found.";
        $result_cart = false;
    }
} else {
    echo "User is not logged in.";
    $result_cart = false;
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $cartID = $_POST['delete_id'];

    $query_delete_cart = "DELETE FROM cart WHERE cartID = ?";
    $stmt_delete = $db->prepare($query_delete_cart);
    $stmt_delete->bind_param('i', $cartID);

    if ($stmt_delete->execute()) {
        header('Location: carts.php');
    } else {
        echo "Failed to delete cart item.";
    }

    $stmt_delete->close();
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_quantity'])) {
    $bookID = $_POST['bookID'];
    $quantity = $_POST['quantity'];

    $query_stock = "SELECT stock FROM books WHERE bookID = ?";
    $stmt_stock = $db->prepare($query_stock);
    $stmt_stock->bind_param('i', $bookID);
    $stmt_stock->execute();
    $result_stock = $stmt_stock->get_result();
    $stock = $result_stock->fetch_assoc()['stock'];

    if ($quantity > $stock) {
        $quantity = $stock;
    }

    $query_update = "UPDATE cart SET quantity = ? WHERE bookID = ? AND userID = ?";
    $stmt_update = $db->prepare($query_update);
    $stmt_update->bind_param('iii', $quantity, $bookID, $_SESSION['userID']);

    if ($stmt_update->execute()) {
        echo json_encode(['success' => true, 'quantity' => $quantity, 'max_stock' => $stock]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update quantity.']);
    }
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>
    <link rel="icon" href="https://www.gigaval.com/favicon.ico">
    <style>
        /* Global Styles */
        body {
            background-color: #F5F5F5;
            font-family: Arial, sans-serif;
        }

        .content-container {
            max-width: 90%;
            margin: 8% 5%;
        }

        .konten {
            display: flex;
            align-items: flex-start;
            gap: 20px;
        }

        /* Cart Items Section */
        .cart-items {
            flex: 3;
        }

        .cart-header {
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .cart-item {
            display: flex;
            background-color: white;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-radius: 10px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }

        /* .pilSem {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .pilSemBox {
            display: flex;
            align-items: center;
        } */

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item img {
            width: 59px;
            height: 89px;
            margin-right: 20px;
            object-fit: cover;
            box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;
        }

        .cart-item-info {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .cart-item-title {
            font-size: 16px;
            font-weight: bold;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
        }

        .cart-item-quantity input {
            width: 40px;
            text-align: center;
            margin: 0 10px;
        }

        .cart-item-price {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .cart-actions {
            display: flex;
            align-items: center;
        }

        .cart-actions button {
            background: none;
            border: none;
            cursor: pointer;
            color: #333;
            margin-left: 10px;
        }

        .cart-actions button:hover {
            color: #800000;
        }

        .cart-summary {
            position: sticky;
            top: 80px;
            flex: 1;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .cart-summary h2 {
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: bold;
        }

        .cart-summary p {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
            margin: 10px 0;
        }

        .cart-summary button {
            width: 100%;
            padding: 8px;
            background-color: #800000;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .cart-summary button:hover {
            background-color: #600000;
        }

        .empty-cart {
            display: flex;
            justify-content: center;
            flex-direction: column;
            gap: 20px;
            text-align: center;
            font-size: 18px;
            color: #555;
        }

        .kananSaja {
            display: flex;
            flex-direction: column;
            text-align: right;
            gap: 10px;
        }

        .oregTempe {
            display: flex;
            flex-direction: row;
            gap: 20px;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }

        .cart-item-quantity input {
            width: 20px;
            height: 10px;
            border: none;
            text-align: center;
            font-size: 12px;
            font-weight: 500;
        }

        .cart-item-quantity button {
            width: 30px;
            height: 30px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.1s ease, box-shadow 0.1s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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

        .item-checkbox {
            cursor: pointer;
            height: 22px;
            width: 22px;
            margin: 10px;
        }

        .delete-button {
            display: none;
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

        .quantity:focus {
            outline: none;
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
            <h1>Keranjang</h1>
        </div>
        <div class="konten">
            <div class="cart-items">
                <div class="pilSem">
                    <div class="pilSemBox">
                        <input type="hidden" class="item-checkbox" data-price="0">
                        <!-- <span>Pilih semua</span> -->
                    </div>
                    <!-- <button class="delete-button">Hapus</button> -->
                </div>
                <?php if ($result_cart && $result_cart->num_rows > 0): ?>
                    <?php while ($row = $result_cart->fetch_assoc()): ?>
                        <div class="cart-item">
                            <input type="checkbox" class="item-checkbox" data-price="<?php echo $row['price']; ?>"
                                name="item-id-<?php echo $row['cartID']; ?>" value="<?php echo $row['bookID']; ?>">
                            <img src="../seller.tukubuku.com/dashboard/listgambar/<?php echo $row['cover']; ?>" alt="Book Image">
                            <div class="cart-item-info">
                                <div class="cart-item-title"><?php echo htmlspecialchars($row['title']); ?></div>
                            </div>
                            <div class="kananSaja">
                                <div class="cart-item-original-price">Rp
                                    <?php echo number_format($row['price'], 0, ',', '.'); ?>
                                    <input type="hidden" class="cart-item-subtotal">
                                </div>
                                <div class="oregTempe">
                                    <div class="cart-actions">
                                        <button><i class="fa-regular fa-heart fa-lg"></i></button>
                                        <form action="" method="post" style="display:inline;"
                                            onsubmit="return confirm('Yakin hapus buku <?php echo $row['title']; ?>?')">
                                            <input type="hidden" name="delete_id" value="<?php echo $row['cartID']; ?>">
                                            <button type="submit" class="trash-button"><i
                                                    class="fa-solid fa-trash-can fa-lg"></i></button>
                                        </form>
                                    </div>
                                    <div class="cart-item-quantity">
                                        <button class="minus-btn" data-book-id="<?php echo $row['bookID']; ?>">-</button>
                                        <input type="number" class="quantity"
                                            value="<?php echo htmlspecialchars($row['quantity']); ?>" min="1"
                                            max="<?php echo $row['quantityavail']; ?>">
                                        <button class="plus-btn" data-book-id="<?php echo $row['bookID']; ?>">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="empty-cart">Keranjang Kamu kosong.
                        <span>
                            <i class="fa-solid fa-cart-shopping fa-2xl"></i>
                        </span>
                    </p>

                <?php endif; ?>
            </div>
            <div class="cart-summary">
                <h2>Ringkasan Belanja</h2>
                <p>Total <span id="total-price">
                        <div class="cart-item-subtotal"></div>
                    </span></p>
                <form action="checkout.php" method="post" id="checkout-form">
                    <input type="hidden" name="selected_items" id="selected-items">
                    <button type="submit">Beli</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.querySelector('.pilSem input');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');

            selectAllCheckbox.addEventListener('change', function () {
                const isChecked = this.checked;
                itemCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                updateTotal();
                toggleDeleteButton();
            });

            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const allChecked = [...itemCheckboxes].every(checkbox => checkbox.checked);
                    selectAllCheckbox.checked = allChecked;
                    updateTotal();
                    toggleDeleteButton();
                });
            });

            function toggleDeleteButton() {
                const checkedItems = document.querySelectorAll('.item-checkbox:checked');
                const deleteButton = document.querySelector('.delete-button');
                deleteButton.style.display = checkedItems.length > 0 ? 'block' : 'none';
            }

            function updateTotal() {
                let total = 0;
                const itemCheckboxes = document.querySelectorAll('.item-checkbox:checked');

                itemCheckboxes.forEach(checkbox => {
                    const quantity = checkbox.closest('.cart-item').querySelector('.quantity').value;
                    const subtotal = parseFloat(checkbox.getAttribute('data-price')) * quantity;
                    total += subtotal;
                });

                const totalPriceElement = document.getElementById('total-price');
                totalPriceElement.textContent = total > 0 ? 'Rp ' + total.toLocaleString('id-ID') : '-';
            }

            const debounce = (func, delay) => {
                let timeoutId;
                return (...args) => {
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(() => func(...args), delay);
                };
            };

            document.querySelectorAll('.cart-item').forEach(item => {
                const minusBtn = item.querySelector('.minus-btn');
                const plusBtn = item.querySelector('.plus-btn');
                const quantityInput = item.querySelector('.quantity');
                const subtotalElement = item.querySelector('.cart-item-subtotal');
                let quantity = parseInt(quantityInput.value);
                const stock = parseInt(quantityInput.getAttribute('max')) || 100;
                const basePrice = parseFloat(item.querySelector('.cart-item-original-price').textContent.replace(/[^0-9]/g, ''));

                function updateSubtotal() {
                    const subtotal = basePrice * quantity;
                    subtotalElement.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
                }

                function toggleButtons() {
                    minusBtn.disabled = quantity === 1;
                    plusBtn.disabled = quantity === stock;
                }

                const updateDatabase = debounce((bookID, quantity) => {
                    fetch('cartsupdate.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ bookID: bookID, quantity: quantity })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Quantity updated successfully');
                            } else {
                                console.error('Failed to update quantity');
                            }
                        });
                }, 500);

                minusBtn.addEventListener('click', () => {
                    if (quantity > 1) {
                        quantity--;
                        quantityInput.value = quantity;
                        updateSubtotal();
                        toggleButtons();
                        updateDatabase(minusBtn.dataset.bookId, quantity);
                        updateTotal();
                    }
                });

                plusBtn.addEventListener('click', () => {
                    if (quantity < stock) {
                        quantity++;
                        quantityInput.value = quantity;
                        updateSubtotal();
                        toggleButtons();
                        updateDatabase(plusBtn.dataset.bookId, quantity);
                        updateTotal();
                    }
                });

                quantityInput.addEventListener('input', () => {
                    quantity = parseInt(quantityInput.value);
                    if (isNaN(quantity) || quantity < 1) {
                        quantity = 1;
                    } else if (quantity > stock) {
                        quantity = stock;
                    }
                    quantityInput.value = quantity;
                    updateSubtotal();
                    toggleButtons();
                    updateDatabase(quantityInput.dataset.bookId, quantity);
                    updateTotal();
                });

                updateSubtotal();
                toggleButtons();
            });

            document.querySelectorAll('.minus-btn, .plus-btn, .quantity').forEach(element => {
                element.addEventListener('change', updateTotal);
            });

            updateTotal();
        });



        document.addEventListener('DOMContentLoaded', function () {
            const checkoutForm = document.getElementById('checkout-form');
            const selectedItemsInput = document.getElementById('selected-items');
            const checkboxes = document.querySelectorAll('.item-checkbox');

            checkoutForm.addEventListener('submit', function (event) {
                event.preventDefault();
                const selectedItems = [];

                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedItems.push(checkbox.value);
                    }
                });

                selectedItemsInput.value = JSON.stringify(selectedItems);
                checkoutForm.submit();
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const checkoutButton = document.getElementById('checkout-button');
            const selectCheckboxes = document.querySelectorAll('.select-checkbox');
            const checkoutForm = document.getElementById('checkout-form');
            const selectedItemsInput = document.getElementById('selected-items');

            function updateCheckoutButtonState() {
                const anyChecked = Array.from(selectCheckboxes).some(checkbox => checkbox.checked);
                checkoutButton.disabled = !anyChecked;
            }

            selectCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateCheckoutButtonState);
            });

            checkoutForm.addEventListener('submit', function (e) {
                e.preventDefault();

                const selectedItems = Array.from(selectCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                selectedItemsInput.value = JSON.stringify(selectedItems);

                if (selectedItems.length > 0) {
                    e.target.submit();
                }
            });

            // Initial state update
            updateCheckoutButtonState();
        });
    </script>

</body>

</html>