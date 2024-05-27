<?php
session_start();
    include('connection.php');
if(isset($_POST['place_order']))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $city=$_POST['city'];
    $address=$_POST['address'];
    $total=$_SESSION['total'];
    $order_status ="on_hold";
    $user_id=1;
    $order_date=date("Y-m-d H:i:s");
    $stmt = $conn->prepare("INSERT INTO orders (order_cost,order_status,user_id,user_phone,user_city,user_address,order_date) 
    VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("isiisss",$total,$order_status, $user_id,$phone,$city,$address,$order_date);
    $stmt->execute();
    $order_id=$stmt->insert_id;
    // foreach($_SESSION['cart'] as $key => $value)
    // {
    //     $product_id=$value['product_id'];
    //     $product_name=$value['product_name'];
    //     $product_price=$value['product_price'];
    //     $product_quantity=$value['product_quantity'];
    //     $stmt = $conn->prepare("INSERT INTO order_items (order_id,product_id,product_name,product_price,product_quantity) VALUES (?,?,?,?,?)");
    //     $stmt->bind_param("iisdi",$order_id,$product_id,$product_name,$product_price,$product_quantity);
    //     $stmt->execute();
    // }
    // unset($_SESSION['cart']);
    // header('location:order_success.php');
}
else
{
    header('location:index.php');
}

?>