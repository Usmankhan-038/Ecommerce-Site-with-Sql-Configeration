<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Delete related order items
        $stmt = $conn->prepare("DELETE FROM order_items WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        // Delete related orders
        $stmt = $conn->prepare("DELETE FROM orders WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        // Delete related payments
        $stmt = $conn->prepare("DELETE FROM payments WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        // Delete the user
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        // Commit transaction
        $conn->commit();

        $_SESSION['message'] = "User deleted successfully.";
    } catch (Exception $e) {
        // Rollback transaction if any error occurs
        $conn->rollback();
        $_SESSION['message'] = "Failed to delete user.";
    }

    $conn->close();
    header('Location: customer.php');
    exit();
} else {
    header('Location: customer.php');
    exit();
}
?>
