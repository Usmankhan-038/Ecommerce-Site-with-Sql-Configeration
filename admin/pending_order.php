<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Fetch orders with status 'Not Paid'
$query = "
    SELECT o.order_id, o.order_date, u.user_name, p.product_name, SUM(oi.product_quantity) as total_quantity, o.order_cost AS total_price
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN users u ON o.user_id = u.user_id
    JOIN products p ON oi.product_id = p.product_id
    WHERE o.order_status = 'Not Paid'
    GROUP BY o.order_id, p.product_name
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Not Paid Orders</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            color: #fff;
            background-color: #fb774b;
            padding: 5px 10px;
            margin: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background-color: #fff;
            color: #fb774b;
            transition: 0.2s;
        }
    </style>
</head>
<body>
    <nav>
        <div>RGB SPOT</div>
        <a href="logout.php?logout=1" class="logout">
            <input type="submit" class="sign_out btn" value="Sign out" name="sign_out">
        </a>
    </nav>
    <aside>
        <ul>
            <li><a href="dashboard.php" class="side_bar_menu">Dashboard</a></li>
            <li><a href="orders.php" class="side_bar_menu">Orders</a></li>
            <li><a href="product.php" class="side_bar_menu">Products</a></li>
            <li><a href="add_new_product.php" class="side_bar_menu">Add Products</a></li>
            <li><a href="admin_account.php" class="side_bar_menu">Account</a></li>
            <li><a href="categories.php" class="side_bar_menu">Categories</a></li>
        </ul>
    </aside>
    <main>
        <h1 class="header Text">Not Paid Orders</h1>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Customer Name</th>
                <th>Product Name</th>
                <th>Total Quantity</th>
                <th>Total Price</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['order_id']; ?></td>
                <td><?php echo $row['order_date']; ?></td>
                <td><?php echo $row['user_name']; ?></td>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo $row['total_quantity']; ?></td>
                <td><?php echo $row['total_price']; ?></td>
                <td>Not Paid</td>
            </tr>
            <?php } ?>
        </table>
    </main>
</body>
</html>