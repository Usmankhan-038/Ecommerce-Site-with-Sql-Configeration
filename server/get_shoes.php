<?php

include('connection.php');


$stmt = $conn->prepare("SELECT * FROM products where product_category=1 LIMIT 4 ");

$stmt->execute();


$shoes_products=$stmt->get_result();

?>