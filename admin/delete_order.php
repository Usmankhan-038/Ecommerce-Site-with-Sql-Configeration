<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $order_id = $_GET['id'];

    // Prepare and execute the SQL query to delete the order
    $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        // Order deleted successfully, redirect to the orders page
        header('Location: orders.php');
        exit();
    } else {
        // Error occurred while deleting the order
        echo "Error deleting order.";
    }

    $stmt->close();
} else {
    // No order ID provided, handle this scenario as per your requirement
    echo "No order ID provided.";
}
?>
