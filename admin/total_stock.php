<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}


$query = "
    SELECT p.product_id, p.product_name, p.stock, c.category_name 
    FROM products p 
    INNER JOIN categories c ON p.product_category = c.category_id
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Total Stock</title>
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
        .btn-blue {
            background-color: #007bff;
            border-color: #007bff;
            padding: 5px 10px;
            margin: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-blue:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            color: #333;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 4px;
            transition: background-color 0.3s, color 0.3s;
        }
        .pagination a.active, .pagination a:hover {
            background-color: #fb774b;
            color: white;
            border: 1px solid #fb774b;
        }
        .pagination a.disabled {
            color: #ccc;
            pointer-events: none;
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
            <li><a href="create_notification.php" class="side_bar_menu">Create Notification</a></li>
            <li><a href="admin_account.php" class="side_bar_menu">Account</a></li>
        </ul>
    </aside>
    <main>
        <h1 class="header Text">Total Stock</h1>
        <table>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Stock</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['product_id']; ?></td>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo $row['category_name']; ?></td>
                <td><?php echo $row['stock']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </main>
</body>
</html>
