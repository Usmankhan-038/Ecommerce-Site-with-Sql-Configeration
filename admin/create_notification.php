<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Handle adding new notification
if (isset($_POST['add_notification'])) {
    $product_name = $_POST['product_name'];
    $message = $_POST['message'];

    // Get product ID from product name
    $stmt = $conn->prepare("SELECT product_id FROM products WHERE product_name = ?");
    $stmt->bind_param("s", $product_name);
    $stmt->execute();
    $stmt->bind_result($product_id);
    $stmt->fetch();
    $stmt->close();

    if ($product_id) {
        $stmt = $conn->prepare("INSERT INTO notifications (product_id, message) VALUES (?, ?)");
        $stmt->bind_param("is", $product_id, $message);
        if ($stmt->execute()) {
            $success_message = "Notification added successfully!";
        } else {
            $error_message = "Failed to add notification.";
        }
    } else {
        $error_message = "Product not found.";
    }
}

// Handle deleting notification
if (isset($_GET['delete_id'])) {
    $notification_id = $_GET['delete_id'];

    $stmt = $conn->prepare("DELETE FROM notifications WHERE notification_id = ?");
    $stmt->bind_param("i", $notification_id);
    if ($stmt->execute()) {
        $success_message = "Notification deleted successfully!";
    } else {
        $error_message = "Failed to delete notification.";
    }
}

// Fetch notifications
$stmt = $conn->prepare("SELECT notifications.*, products.product_name FROM notifications INNER JOIN products ON notifications.product_id = products.product_id");
$stmt->execute();
$notifications = $stmt->get_result();

// Fetch products for dropdown
$product_stmt = $conn->prepare("SELECT product_name FROM products");
$product_stmt->execute();
$product_result = $product_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Notifications</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            text-align: left;
            padding: 12px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            color: #fff;
            background-color: #fb774b;
            padding: 10px 15px;
            margin: 5px;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #fff;
            color: #fb774b;
            transition: 0.2s;
        }
        .btn-blue {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 15px;
            margin: 5px;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
        }
        .btn-blue:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn1 {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #fb774b;
            border: none;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn1:hover {
            background-color: #fff;
            color: #fb774b;
            transition: 0.2s;
        }
        .form-container {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
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
            <input type="submit" class="sign_out btn1" value="Sign out" name="sign_out">
        </a>
    </nav>
    <aside>
        <ul>
            <li><a href="dashboard.php" class="side_bar_menu">Dashboard</a></li>
            <li><a href="orders.php" class="side_bar_menu">Orders</a></li>
            <li><a href="product.php" class="side_bar_menu">Products</a></li>
            <li><a href="add_new_product.php" class="side_bar_menu">Add Products</a></li>
            <li><a href="admin_account.php" class="side_bar_menu">Account</a></li>
            <li><a href="create_notification.php" class="side_bar_menu">Notifications</a></li>
        </ul>
    </aside>
    <main>
        <h1 class="header Text">Notifications</h1>
        <?php if (isset($success_message)) { echo "<p style='color:green;'>$success_message</p>"; } ?>
        <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>

        <button class="btn1" onclick="document.getElementById('addNotificationForm').style.display='block'">Add Notification</button>

        <div id="addNotificationForm" style="display:none;">
            <h2>Add Notification</h2>
            <form action="create_notification.php" method="POST" class="form-container">
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <select name="product_name" id="product_name" required>
                        <?php while ($product = $product_result->fetch_assoc()) { ?>
                            <option value="<?php echo $product['product_name']; ?>"><?php echo $product['product_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea name="message" id="message" required></textarea>
                </div>
               <button type="submit" name="add_notification" class="btn1">Add</button>
            </form>
        </div>

        <table>
            <tr>
                <th>Notification ID</th>
                <th>Product Name</th>
                <th>Message</th>
                <th>Timestamp</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php while ($row = $notifications->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['notification_id']; ?></td>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo $row['message']; ?></td>
                <td><?php echo $row['timestamp']; ?></td>
                <td><a href="edit_notification.php?id=<?php echo $row['notification_id']; ?>" class="btn btn-blue">Edit</a></td>
                <td><a href="create_notification.php?delete_id=<?php echo $row['notification_id']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this notification?');">Delete</a></td>
            </tr>
            <?php } ?>
        </table>
    </main>
</body>
</html>
