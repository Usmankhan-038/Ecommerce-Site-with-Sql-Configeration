<?php
session_start();
include('connection.php');

// Enable error reporting for debugging
// It's recommended to disable error reporting in a production environment
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['logged_in'])) {
    header('location: ../checkout.php?message=Please Login/register to place an Order');
    exit;
} else {
    if (isset($_POST['place_order'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $total = $_SESSION['total'];
        $order_status = "Not Paid";
        $user_id = $_SESSION['user_id'];
        $order_date = date("Y-m-d H:i:s");

        // Start transaction
        $conn->begin_transaction();

        try {
            // Insert order
            $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_phone, user_city, user_address, order_date) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("isiisss", $total, $order_status, $user_id, $phone, $city, $address, $order_date);
            $stmt->execute();
            $order_id = $stmt->insert_id;
            $_SESSION['order_id'] = $order_id;

            // Insert order items
            foreach ($_SESSION['cart'] as $key => $value) {
                $product = $_SESSION['cart'][$key];
                $product_id = $value['product_id'];
                $product_name = $value['product_name'];
                $product_image = $product['product_image'];
                $product_price = $value['product_price'];
                $product_quantity = $value['product_quantity'];

                // Check if the product_id exists in the products table
                $stmt_check = $conn->prepare("SELECT product_id FROM products WHERE product_id = ?");
                $stmt_check->bind_param("i", $product_id);
                $stmt_check->execute();
                $result_check = $stmt_check->get_result();

                if ($result_check->num_rows > 0) {
                    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, user_id, order_date, product_price, product_quantity) VALUES (?,?,?,?,?,?,?,?)");
                    $stmt->bind_param("iissisii", $order_id, $product_id, $product_name, $product_image, $user_id, $order_date, $product_price, $product_quantity);
                    $stmt_status = $stmt->execute();

                    if (!$stmt_status) {
                        // Log the error
                        error_log("Failed to insert order item for product_id: $product_id");
                        // Rollback transaction if insert fails
                        $conn->rollback();
                        header('location:../index.php?message=Order placement failed');
                        exit;
                    }
                } else {
                    // Log the invalid product ID
                    error_log("Invalid product ID: $product_id");
                    // Rollback transaction if product_id does not exist
                    $conn->rollback();
                    header('location:../index.php?message=Invalid product ID');
                    exit;
                }
            }

            // Commit transaction
            $conn->commit();

            // Unset the cart session
            unset($_SESSION['cart']);

            header('location:../payment.php?order_status=Order placed successfully');
        } catch (Exception $e) {
            // Log the exception
            error_log("Exception occurred: " . $e->getMessage());
            // Rollback transaction if any exception occurs
            $conn->rollback();
            header('location:../index.php?message=Order placement failed');
            exit;
        }
    }
}
?>
