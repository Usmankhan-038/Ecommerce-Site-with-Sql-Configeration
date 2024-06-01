<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $image2 = $_POST['image2'];
    $image3 = $_POST['image3'];
    $image4 = $_POST['image4'];
    $price = $_POST['price'];
    $special_offer = $_POST['special_offer'];
    $color = $_POST['color'];
    $stock = $_POST['stock'];

    $stmt = $conn->prepare("INSERT INTO products (product_name, product_category, product_description, product_image, product_image2, product_image3, product_image4, product_price, product_special_offer, product_color,stock) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssssissi", $name, $category_id, $description, $image, $image2, $image3, $image4, $price, $special_offer, $color, $stock);
    if ($stmt->execute()) {
        header('Location: product.php');
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
    <title>Add New Product</title>
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
    <main>
        <h1 class="header Text">Add New Product</h1>
        <div class="form-container">
            <form method="POST" action="add_new_product.php">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="category_id">Category:</label>
                <select id="category_id" name="category_id" required>
                    <option value="1">Shoes</option>
                    <option value="2">Coats</option>
                    <option value="3">Watches</option>
                    <option value="4">Bags</option>
                    <option value="5">Jeans</option>
                    <!-- Add other categories as needed -->
                </select>
                
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>
                
                <label for="image">Image 1 URL:</label>
                <input type="text" id="image" name="image" required>
                
                <label for="image2">Image 2 URL:</label>
                <input type="text" id="image2" name="image2">
                
                <label for="image3">Image 3 URL:</label>
                <input type="text" id="image3" name="image3">
                
                <label for="image4">Image 4 URL:</label>
                <input type="text" id="image4" name="image4">
                
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" required>
                
                <label for="special_offer">Special Offer:</label>
                <input type="number" id="special_offer" name="special_offer" required>
                
                <label for="color">Color:</label>
                <input type="text" id="color" name="color" required>

                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" required>
                
                <button type="submit">Add Product</button>
            </form>
        </div>
    </main>
</body>
</html>
