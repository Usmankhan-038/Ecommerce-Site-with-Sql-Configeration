<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Fetch admin details
$stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Account</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: .5rem;
        }
        .form-group input {
            width: 100%;
            padding: .5rem;
            margin-bottom: .5rem;
            box-sizing: border-box;
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
        </ul>
    </aside>
    <main class="container">
        <h1 class="header Text">Admin Account</h1>
        <div class="form-group">
            <label for="admin_id">Admin ID</label>
            <input type="text" id="admin_id" value="<?php echo $admin['admin_id']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="admin_name">Name</label>
            <input type="text" id="admin_name" value="<?php echo $admin['admin_name']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="admin_email">Email</label>
            <input type="email" id="admin_email" value="<?php echo $admin['admin_email']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="admin_password">Password</label>
            <input type="password" id="admin_password" value="<?php echo $admin['admin_password']; ?>" readonly>
            <button type="button" class="btn" onclick="togglePassword()">Show Password</button>
        </div>
        <h2>Change Password</h2>
        <form action="change_admin_password.php" method="post">
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn">Change Password</button>
        </form>
    </main>
    <script>
        function togglePassword() {
            var passwordField = document.getElementById('admin_password');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
            } else {
                passwordField.type = 'password';
            }
        }
    </script>
</body>
</html>
