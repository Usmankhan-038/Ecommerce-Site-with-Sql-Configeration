<?php
include('server/connection.php');
session_start();
if(isset($_GET['order_id']))
{


    $order_id=$_GET['order_id'];
    $order_status = "Paid";
    $total_amount=0;
    $total_amount=$_SESSION['order_price'];
    $user_id=$_SESSION['user_id'];
    $payment_date=date('Y-m-d H:i:s');
    $stmt = $conn->prepare("UPDATE orders SET order_status=? WHERE order_id=?");
    $stmt->bind_param('si',$order_status,$order_id);
    $stmt->execute();
    $stmt1 = $conn->prepare("INSERT INTO payments (order_id, user_id, total_amount, order_status, payment_date) VALUES (?, ?, ?, ?, ?)");
    $stmt1->bind_param("iiiss", $order_id, $user_id, $total_amount, $order_status, $payment_date);
    $stmt1->execute();
    header("location: account.php?payment_message=Paid successfully, thanks for your shopping with us");
}
else
{
    header("location: index.php");
    exit;
}

// $order_status = "Paid";
// $order_total_price = $_SESSION['total'];
// $order_id=$_POST['order_id'];
// $stmt = $conn->prepare("UPDATE orders SET order_status=? WHERE order_id=?");
// $stmt->bind_param("si", $order_status, $order_id);
// $stmt->execute();
// $_SESSION['order_status'] = $order_status;
// header('location:complete_payment.php?order_status=Order Paid Successfully,order_id='.$order_id);
// exit();
// }


?>