<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}


$query = "
    SELECT p.product_id, p.product_name, COUNT(oi.product_id) AS order_count
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    GROUP BY p.product_id
    ORDER BY order_count DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Rankings</title>
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
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #fb774b;
            border: none;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
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
    <a class="navbar-brand" href="dashboard.php" style="text-decoration:none;">
    <img class="logo" src="../assets/imgs/logo.jpg" alt="Logo"/>
    <h2 style="display:inline; color:#fb774b;">RGB</h2>
    <h2 class="brand d-inline-block" style="display:inline;">SPOT</h2>
</a>

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
            <li><a href="customer.php" class="side_bar_menu">Customer</a></li>

            <!-- <li><a href="create_notification.php" class="side_bar_menu">Create Notification</a></li> -->
            <li><a href="admin_account.php" class="side_bar_menu">Account</a></li>
        </ul>
    </aside>
    <main>
        <h1 class="header Text">Product Rankings</h1>
        <table>
            <tr>
                <th>Rank</th>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Order Number</th>
            </tr>
            <?php 
            $rank = 1; // Initialize rank before the loop
            while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $rank++; ?></td> <!-- Increment rank here -->
                <td><?php echo $row['product_id']; ?></td>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo $row['order_count']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </main>
</body>
</html>
