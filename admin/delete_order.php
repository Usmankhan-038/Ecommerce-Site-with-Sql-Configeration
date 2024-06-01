<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Delete from order_items table first
        $stmt1 = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
        $stmt1->bind_param("i", $order_id);
        $stmt1->execute();

        // Delete from payments table next
        $stmt2 = $conn->prepare("DELETE FROM payments WHERE order_id = ?");
        $stmt2->bind_param("i", $order_id);
        $stmt2->execute();

        // Delete from orders table last
        $stmt3 = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
        $stmt3->bind_param("i", $order_id);
        $stmt3->execute();

        // Commit transaction
        $conn->commit();

        $_SESSION['message'] = "Order deleted successfully.";
    } catch (mysqli_sql_exception $exception) {
        // Rollback transaction
        $conn->rollback();

        $_SESSION['message'] = "Failed to delete order: " . $exception->getMessage();
    }

    header('Location: orders.php');
    exit();
} else {
    $_SESSION['message'] = "Invalid order ID.";
    header('Location: orders.php');
    exit();
}
?>
