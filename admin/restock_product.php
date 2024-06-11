<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $conn->begin_transaction();

    try {
        // Update the stock in products table
        $stmt = $conn->prepare("UPDATE products SET stock = stock + ? WHERE product_id = ?");
        $stmt->bind_param("ii", $quantity, $product_id);
        $stmt->execute();
        $stmt->close();

        // Insert or update the restock status in product_restock table
        $stmt = $conn->prepare("
            INSERT INTO product_restock (product_id, restocked) VALUES (?, 1)
            ON DUPLICATE KEY UPDATE restocked = 1
        ");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $stmt->close();

        $conn->commit();

        $_SESSION['message'] = "Product restocked successfully.";
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['message'] = "Failed to restock product.";
    }

    $conn->close();
    header('Location: out_of_stock.php?message=Successful restock');
    exit();
} else {
    header('Location: out_of_stock.php?message=Product isn\'t restocked');
    exit();
}
?>
