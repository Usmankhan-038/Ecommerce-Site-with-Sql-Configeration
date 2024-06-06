<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}


$order_id = isset($_GET['id']) ? $_GET['id'] : '';
$order = null;

if ($order_id) {
    $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_cost = $_POST['order_cost'];
    $order_status = $_POST['order_status'];
    $user_id = $_POST['user_id'];
    $user_phone = $_POST['user_phone'];
    $user_city = $_POST['user_city'];
    $user_address = $_POST['user_address'];

    $stmt = $conn->prepare("UPDATE orders SET order_cost = ?, order_status = ?, user_id = ?, user_phone = ?, user_city = ?, user_address = ? WHERE order_id = ?");
    $stmt->bind_param("dsiissi", $order_cost, $order_status, $user_id, $user_phone, $user_city, $user_address, $order_id);
    if ($stmt->execute()) {
        header('Location: orders.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Order</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container input, .form-container textarea, .form-container select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-container button {
            background-color: #fb774b;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #fff;
            color: #fb774b;
            border: 1px solid #fb774b;
            transition: 0.2s;
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
    <img class="logo" src="../assets/imgs/logo.png" alt="Logo"/>
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
        <h1 class="header Text">Edit Order</h1>
        <?php if ($order) { ?>
        <div class="form-container">
            <form method="POST" action="">
                <label for="order_cost">Order Cost:</label>
                <input type="number" id="order_cost" name="order_cost" step="0.01" value="<?php echo htmlspecialchars($order['order_cost']); ?>" required>
                
                <label for="order_status">Order Status:</label>
                <input type="text" id="order_status" name="order_status" value="<?php echo htmlspecialchars($order['order_status']); ?>" required>
                
                <label for="user_id">User ID:</label>
                <input type="number" id="user_id" name="user_id" value="<?php echo htmlspecialchars($order['user_id']); ?>" required>
                
                <label for="user_phone">User Phone:</label>
                <input type="number" id="user_phone" name="user_phone" value="<?php echo htmlspecialchars($order['user_phone']); ?>" required>
                
                <label for="user_city">User City:</label>
                <input type="text" id="user_city" name="user_city" value="<?php echo htmlspecialchars($order['user_city']); ?>" required>
                
                <label for="user_address">User Address:</label>
                <textarea id="user_address" name="user_address" required><?php echo htmlspecialchars($order['user_address']); ?></textarea>
                
                <button type="submit">Update Order</button>
            </form>
        </div>
        <?php } else { ?>
        <p>Order not found.</p>
        <?php } ?>
    </main>
</body>
</html>
