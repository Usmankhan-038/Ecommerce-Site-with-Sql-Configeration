<?php
session_start();
include('connection.php');

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


        $conn->begin_transaction();

        try {

            $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_phone, user_city, user_address, order_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isiisss", $total, $order_status, $user_id, $phone, $city, $address, $order_date);
            $stmt->execute();
            $order_id = $stmt->insert_id;
            $_SESSION['order_id'] = $order_id;

 
            foreach ($_SESSION['cart'] as $key => $value) {
                $product_id = $value['product_id'];
                $product_name = $value['product_name'];
                $product_image = $value['product_image'];
                $product_price = $value['product_price'];
                $product_quantity = $value['product_quantity'];


                $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, user_id, order_date, product_price, product_quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("iissisii", $order_id, $product_id, $product_name, $product_image, $user_id, $order_date, $product_price, $product_quantity);
                $stmt->execute();

  
                $stmtStock = $conn->prepare("UPDATE products SET stock = stock - ? WHERE product_id = ?");
                $stmtStock->bind_param("ii", $product_quantity, $product_id);
                $stmtStock->execute();
            }


            $conn->commit();

            unset($_SESSION['cart']);

            header('location: ../payment.php?order_status=Order placed successfully');
        } catch (Exception $e) {
  
            $conn->rollback();
            header('location: ../checkout.php?message=Something went wrong, please try again.');
        }
    }
}
?>
