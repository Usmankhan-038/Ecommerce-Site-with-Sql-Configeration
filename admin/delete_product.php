<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];


    $conn->begin_transaction();

    try {

        $stmt1 = $conn->prepare("DELETE FROM order_items WHERE product_id = ?");
        $stmt1->bind_param("i", $product_id);
        $stmt1->execute();


        $stmt2 = $conn->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt2->bind_param("i", $product_id);
        $stmt2->execute();


        $conn->commit();

        $_SESSION['message'] = "Product deleted successfully.";
    } catch (mysqli_sql_exception $exception) {

        $conn->rollback();

        $_SESSION['message'] = "Failed to delete product: " . $exception->getMessage();
    }

    header('Location: product.php');
    exit();
} else {
    $_SESSION['message'] = "Invalid product ID.";
    header('Location: product.php');
    exit();
}
?>
