<?php
include 'connection/conn.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $bookID = $data['bookID'];
    $quantity = $data['quantity'];

    $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

    if ($username) {
        // Query to get userID based on username or email
        $query_user = "SELECT userID FROM user WHERE username = ? OR email = ?";
        $stmt_user = $db->prepare($query_user);
        $stmt_user->bind_param('ss', $username, $username);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();

        if ($result_user && $result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc();
            $user_id = $user['userID'];

            // Query to update quantity in the cart
            $query_update = "
                UPDATE cart c
                JOIN books b ON c.bookID = b.bookID
                SET c.quantity = ?, c.subtotal = ? * b.price
                WHERE c.bookID = ? AND c.userID = ?
            ";
            $stmt_update = $db->prepare($query_update);
            $stmt_update->bind_param('iiii', $quantity, $quantity, $bookID, $user_id);

            if ($stmt_update->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to update quantity.']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'User not found.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'User is not logged in.']);
    }
}
?>