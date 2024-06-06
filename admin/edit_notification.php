<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Fetch the notification details for editing
if (isset($_GET['id'])) {
    $notification_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT notifications.*, products.product_name FROM notifications INNER JOIN products ON notifications.product_id = products.product_id WHERE notification_id = ?");
    $stmt->bind_param("i", $notification_id);
    $stmt->execute();
    $notification = $stmt->get_result()->fetch_assoc();
}

// Handle updating the notification
if (isset($_POST['update_notification'])) {
    $notification_id = $_POST['notification_id'];
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
        $stmt = $conn->prepare("UPDATE notifications SET product_id = ?, message = ? WHERE notification_id = ?");
        $stmt->bind_param("isi", $product_id, $message, $notification_id);
        if ($stmt->execute()) {
            $success_message = "Notification updated successfully!";
        } else {
            $error_message = "Failed to update notification.";
        }
    } else {
        $error_message = "Product not found.";
    }
}

// Fetch products for dropdown
$product_stmt = $conn->prepare("SELECT product_name FROM products");
$product_stmt->execute();
$product_result = $product_stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Notification</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <style>
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
            <!-- <li><a href="create_notification.php" class="side_bar_menu">Create Notification</a></li> -->
            <li><a href="admin_account.php" class="side_bar_menu">Account</a></li>

        </ul>
    </aside>
    <main>
        <h1 class="header Text">Edit Notification</h1>
        <?php if (isset($success_message)) { echo "<p style='color:green;'>$success_message</p>"; } ?>
        <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>

        <?php if (isset($notification)) { ?>
        <div class="form-container">
            <form action="edit_notification.php?id=<?php echo $notification['notification_id']; ?>" method="POST">
                <input type="hidden" name="notification_id" value="<?php echo $notification['notification_id']; ?>">
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <select name="product_name" id="product_name" required>
                        <?php while ($product = $product_result->fetch_assoc()) { ?>
                            <option value="<?php echo $product['product_name']; ?>" <?php echo $product['product_name'] == $notification['product_name'] ? 'selected' : ''; ?>><?php echo $product['product_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea name="message" id="message" required><?php echo $notification['message']; ?></textarea>
                </div>
                <button type="submit" name="update_notification" class="btn1">Update</button>
            </form>
        </div>
        <?php } else { ?>
            <p>Notification not found.</p>
        <?php } ?>
    </main>
</body>
</html>
