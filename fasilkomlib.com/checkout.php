<?php
session_start();
include_once "connection/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selected_items'])) {
    $selected_items = json_decode($_POST['selected_items'], true);

    if (!empty($selected_items)) {
        $placeholders = implode(',', array_fill(0, count($selected_items), '?'));
        $query = "SELECT b.bookID, b.title, b.cover, b.price, c.quantity, (b.price * c.quantity) AS subtotal 
                  FROM books b
                  INNER JOIN cart c ON b.bookID = c.bookID
                  WHERE b.bookID IN ($placeholders)";
        $stmt = $db->prepare($query);

        $types = str_repeat('i', count($selected_items));
        $stmt->bind_param($types, ...$selected_items);
        $stmt->execute();
        $result = $stmt->get_result();

        $total_subtotal = 0;
        $items = [];

        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
            $total_subtotal += $row['subtotal'];
        }
        $stmt->close();
        ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Checkout</title>
            <style>
                body {
                    background-color: #EDEDED;
                }

                .checkout-container {
                    width: 90%;
                    max-width: 90%;
                    margin: 8% 5%;
                }

                .konten {
                    display: flex;
                    align-items: flex-start;
                    gap: 20px;
                }

                .coBarang {
                    flex: 3;
                }

                .checkout-item {
                    margin-bottom: 10px;
                    display: flex;
                    flex-direction: row;
                    background-color: white;
                    padding: 12px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }

                .checkout-item img {
                    max-width: 100px;
                    max-height: 100px;
                }

                .descCO {
                    width: 100%;
                    margin-left: 10px;
                    display: flex;
                    flex-direction: column;
                }

                .descItem {
                    width: 100%;
                    display: flex;
                    flex-direction: row;
                    justify-content: space-between;
                }

                .total-subtotal {
                    position: fixed;
                    bottom: 0;
                    margin-top: 20px;
                    font-weight: bold;
                }

                .cart-header {
                    align-items: center;
                    margin-bottom: 20px;
                    border-bottom: 1px solid #ddd;
                    padding-bottom: 10px;
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

                #stItem {
                    text-align: right;
                }

                #subTotal {
                    text-align: right;
                }
            </style>
        </head>

        <body>
            <?php include "layout/naviga.php" ?>
            <div class="checkout-container">
                <div class="cart-header">
                    <div class="actBack">
                        <a href="carts.php">
                            <i class="fa fa-angle-left"></i>&emsp;Kembali
                        </a>
                    </div>
                    <h1>Checkout</h1>
                </div>
                <div class="konten">
                    <div class="coBarang">
                        <?php
                        foreach ($items as $item) {
                            ?>
                            <div class='checkout-item'>
                                <img src='../seller.tukubuku.com/dashboard/listgambar/<?php echo $item['cover']; ?>'
                                    alt='Book Image'>
                                <div class="descCO">
                                    <h3><?php echo $item['title']; ?></h3>
                                    <div class="descItem">
                                        <span>Rp<?php echo number_format($item['price'], 0, ',', '.'); ?></span>
                                        <span>x<?php echo $item['quantity']; ?></span>
                                    </div>
                                    <span id="stItem">Rp<?php echo number_format($item['subtotal'], 0, ',', '.'); ?></span>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="cart-summary">
                        <h2>Ringkasan Belanja</h2>
                        <p>Total Belanja
                            <span id="subTotal">Rp<?php echo number_format($total_subtotal, 0, ',', '.'); ?></span>
                        </p>
                        <form action="checkoutLast.php" method="post" id="checkout-form">
                            <input type="hidden" name="total_subtotal" value="<?php echo $total_subtotal; ?>">
                            <input type="hidden" name="selected_items" value='<?php echo json_encode($items); ?>'>
                            <button type="submit">Checkout</button>
                        </form>
                    </div>
                </div>
            </div>
        </body>

        </html>
        <?php
    } else {
        echo "No items selected.";
    }
} else {
    echo "Invalid request.";
}
?>