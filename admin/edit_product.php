<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Fetch product details
$product_id = isset($_GET['id']) ? $_GET['id'] : '';
$product = null;

if ($product_id) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $special_offer = $_POST['special_offer'];
    $color = $_POST['color'];
    $stock = $_POST['stock'];
    
    // Assuming images are updated or retained as is if not provided
    $image = $_POST['image'] ?: $product['product_image'];
    $image2 = $_POST['image2'] ?: $product['product_image2'];
    $image3 = $_POST['image3'] ?: $product['product_image3'];
    $image4 = $_POST['image4'] ?: $product['product_image4'];

    // Disable binary logging for this session
    $conn->query("SET SESSION sql_log_bin = 0");

    $stmt = $conn->prepare("UPDATE products SET product_name = ?, product_category = ?, product_description = ?, product_image = ?, product_image2 = ?, product_image3 = ?, product_image4 = ?, product_price = ?, product_special_offer = ?, product_color = ?, stock = ? WHERE product_id = ?");
    $stmt->bind_param("sssssssdsiii", $name, $category, $description, $image, $image2, $image3, $image4, $price, $special_offer, $color, $stock, $product_id);
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
    <title>Edit Product</title>
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
            <li><a href="add_new_product.php" class="side_bar_menu">Add new Products</a></li>
            <li><a href="account.php" class="side_bar_menu">Account</a></li>
            <li><a href="help.php" class="side_bar_menu">Help</a></li>
        </ul>
    </aside>
    <main>
        <h1 class="header Text">Edit Product</h1>
        <?php if ($product) { ?>
        <div class="form-container">
            <form method="POST" action="">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
                
                <label for="category">Category:</label>
                <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($product['product_category']); ?>" required>
                
                <label for="description">Description:</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($product['product_description']); ?></textarea>
                
                <label for="image">Image 1 URL:</label>
                <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($product['product_image']); ?>">
                
                <label for="image2">Image 2 URL:</label>
                <input type="text" id="image2" name="image2" value="<?php echo htmlspecialchars($product['product_image2']); ?>">
                
                <label for="image3">Image 3 URL:</label>
                <input type="text" id="image3" name="image3" value="<?php echo htmlspecialchars($product['product_image3']); ?>">
                
                <label for="image4">Image 4 URL:</label>
                <input type="text" id="image4" name="image4" value="<?php echo htmlspecialchars($product['product_image4']); ?>">
                
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($product['product_price']); ?>" required>
                
                <label for="special_offer">Special Offer:</label>
                <input type="number" id="special_offer" name="special_offer" value="<?php echo htmlspecialchars($product['product_special_offer']); ?>" required>
                
                <label for="color">Color:</label>
                <input type="text" id="color" name="color" value="<?php echo htmlspecialchars($product['product_color']); ?>" required>

                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required>
                
                <button type="submit">Update Product</button>
            </form>
        </div>
        <?php } else { ?>
        <p>Product not found.</p>
        <?php } ?>
    </main>
</body>
</html>
