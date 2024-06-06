<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Fetch total products
$stmt = $conn->prepare("SELECT COUNT(*) AS total_products FROM products");
$stmt->execute();
$stmt->bind_result($total_products);
$stmt->fetch();
$stmt->close();

// Fetch total categories
$stmt = $conn->prepare("SELECT COUNT(*) AS total_categories FROM categories");
$stmt->execute();
$stmt->bind_result($total_categories);
$stmt->fetch();
$stmt->close();

// Fetch total orders
$stmt = $conn->prepare("SELECT COUNT(*) AS total_orders FROM orders");
$stmt->execute();
$stmt->bind_result($total_orders);
$stmt->fetch();
$stmt->close();

// Fetch completed orders (paid orders)
$stmt = $conn->prepare("SELECT COUNT(*) AS completed_orders FROM orders WHERE order_status = 'paid'");
$stmt->execute();
$stmt->bind_result($completed_orders);
$stmt->fetch();
$stmt->close();

// Fetch pending orders (not paid)
$stmt = $conn->prepare("SELECT COUNT(*) AS pending_orders FROM orders WHERE order_status != 'paid'");
$stmt->execute();
$stmt->bind_result($pending_orders);
$stmt->fetch();
$stmt->close();

// Fetch total stock from products
$stmt = $conn->prepare("SELECT SUM(stock) AS total_stock FROM products");
$stmt->execute();
$stmt->bind_result($total_stock);
$stmt->fetch();
$stmt->close();

// Fetch highest selling product
$stmt = $conn->prepare("SELECT product_id, COUNT(*) AS total_sold FROM order_items GROUP BY product_id ORDER BY total_sold DESC LIMIT 1");
$stmt->execute();
$stmt->bind_result($highest_selling_product_id, $highest_selling_product_count);
$stmt->fetch();
$stmt->close();

// Fetch product details for highest selling product
$stmt = $conn->prepare("SELECT product_name FROM products WHERE product_id = ?");
$stmt->bind_param("i", $highest_selling_product_id);
$stmt->execute();
$stmt->bind_result($highest_selling_product_name);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <style>
        .dashboard-section {
            display: inline-block;
            width: calc(33% - 40px); /* Three boxes per row with margins */
            margin: 20px;
            padding: 20px;
            background-color: #f2f2f2;
            text-align: center;
            cursor: pointer;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .dashboard-section:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            background-color: #fb774b;
            color: #fff;
        }
        .dashboard-section h2 {
            font-size: 2rem;
            margin: 0;
        }
        .dashboard-section p {
            font-size: 1.2rem;
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
        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .dashboard-section {
                width: calc(50% - 40px); /* Two boxes per row with margins */
            }
        }
        @media (max-width: 768px) {
            .dashboard-section {
                width: calc(100% - 40px); /* One box per row with margins */
            }
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
        <h1 class="header Text">Dashboard</h1>
        <div class="dashboard-section" onclick="window.location.href='product.php'">
            <h2><?php echo $total_products; ?></h2>
            <p>Products</p>
        </div>
        <div class="dashboard-section" onclick="window.location.href='total_category.php'">
            <h2><?php echo $total_categories; ?></h2>
            <p>Categories</p>
        </div>
        <div class="dashboard-section" onclick="window.location.href='pending_order.php?status=pending'">
            <h2><?php echo $pending_orders; ?></h2>
            <p>Pending Orders</p>
        </div>
        <div class="dashboard-section" onclick="window.location.href='completed_order.php?status=completed'">
            <h2><?php echo $completed_orders; ?></h2>
            <p>Completed Orders</p>
        </div>
        <div class="dashboard-section" onclick="window.location.href='total_stock.php'">
            <h2><?php echo is_null($total_stock) ? '0' : $total_stock; ?></h2>
            <p>Total Stock</p>
        </div>
        <div class="dashboard-section" onclick="window.location.href='highest_order.php?id=<?php echo $highest_selling_product_id; ?>'">
            <h2><?php echo $highest_selling_product_name; ?></h2>
            <p>Highest Selling Product</p>
        </div>
    </main>
</body>
</html>
