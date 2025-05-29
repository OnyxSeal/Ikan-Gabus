<?php
session_start();
include_once "connection/conn.php";

// Hapus nilai total_subtotal dari session
unset($_SESSION['total_subtotal']);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['total_subtotal']) && isset($_POST['selected_items'])) {
    $total_subtotal = $_POST['total_subtotal'];
    $_SESSION['total_subtotal'] = $total_subtotal; // Menyimpan nilai total_subtotal dalam session
    $selected_items = json_decode($_POST['selected_items'], true);

    // Assuming you have a logged-in user
    $username = $_SESSION['username'] ?? '';
    $user_id = null;

    if ($username) {
        $query_user = "SELECT userID FROM user WHERE username = ? OR email = ?";
        $stmt_user = $db->prepare($query_user);
        $stmt_user->bind_param('ss', $username, $username);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();

        if ($result_user && $result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc();
            $user_id = $user['userID'];
        } else {
            echo "User not found.";
            exit;
        }
    } else {
        echo "User is not logged in.";
        exit;
    }

    // Start a transaction
    $db->begin_transaction();

    try {
        // Insert each order and its details
        $query_orders = "INSERT INTO orders (userID, totalAmount) VALUES (?, ?)";
        $stmt_orders = $db->prepare($query_orders);

        $query_orderdetail = "INSERT INTO orderdetail (orderID, userID, bookID, quantity, subtotal, status) VALUES (?, ?, ?, ?, ?, 'nyp')";
        $stmt_orderdetail = $db->prepare($query_orderdetail);

        $query_update_books = "UPDATE books SET quantityavail = quantityavail - ? WHERE bookID = ?";
        $stmt_update_books = $db->prepare($query_update_books);

        foreach ($selected_items as $item) {
            // Insert order for each item
            $stmt_orders->bind_param('id', $user_id, $item['subtotal']);
            $stmt_orders->execute();

            // Get the last inserted order ID
            $order_id = $db->insert_id;

            // Insert order detail
            $stmt_orderdetail->bind_param('iiids', $order_id, $user_id, $item['bookID'], $item['quantity'], $item['subtotal']);
            $stmt_orderdetail->execute();

            // Update book quantity
            $stmt_update_books->bind_param('ii', $item['quantity'], $item['bookID']);
            $stmt_update_books->execute();
        }

        // Insert into orderhistory table using total_subtotal
        $query_orderhistory = "INSERT INTO orderhistory (userID, orderID, totalAmount) VALUES (?, ?, ?)";
        $stmt_orderhistory = $db->prepare($query_orderhistory);
        $stmt_orderhistory->bind_param('iid', $user_id, $order_id, $total_subtotal);
        $stmt_orderhistory->execute();

        // Delete items from cart
        $query_delete_cart = "DELETE FROM cart WHERE userID = ? AND bookID = ?";
        $stmt_delete_cart = $db->prepare($query_delete_cart);
        foreach ($selected_items as $item) {
            $stmt_delete_cart->bind_param('ii', $user_id, $item['bookID']);
            $stmt_delete_cart->execute();
        }

        // Commit the transaction
        $db->commit();

        // Redirect to a success page to prevent form resubmission
        header("Location: checkoutSuccess.php?total_subtotal=$total_subtotal");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction if something failed
        $db->rollback();
        echo "Failed to complete the order. Please try again.";
    } finally {
        // Close all prepared statements if they are initialized
        if (isset($stmt_orders))
            $stmt_orders->close();
        if (isset($stmt_orderdetail))
            $stmt_orderdetail->close();
        if (isset($stmt_update_books))
            $stmt_update_books->close();
        if (isset($stmt_orderhistory))
            $stmt_orderhistory->close();
        if (isset($stmt_delete_cart))
            $stmt_delete_cart->close();
        if (isset($stmt_user))
            $stmt_user->close();
        $db->close();
    }
} else {
    echo "Invalid request.";
}
?>