<?php

include('connection.php');


$stmt = $conn->prepare("SELECT * FROM products where product_category='watches' LIMIT 4 ");

$stmt->execute();


$watches_products=$stmt->get_result();

?>