<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

$product_id = isset($_GET['id']) ? $_GET['id'] : '';
$product = null;

if ($product_id) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
}

$categories = [];
$stmt = $conn->prepare("SELECT category_id, category_name FROM categories");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $special_offer = $_POST['special_offer'];
    $color = isset($_POST['color']) ? $_POST['color'] : ''; 
    $stock = $_POST['stock'];

    $image = $_POST['image'] ?: $product['product_image'];
    $image2 = $_POST['image2'] ?: $product['product_image2'];
    $image3 = $_POST['image3'] ?: $product['product_image3'];
    $image4 = $_POST['image4'] ?: $product['product_image4'];

    $conn->query("SET SESSION sql_log_bin = 0");

    $stmt = $conn->prepare("UPDATE products SET product_name = ?, product_category = ?, product_description = ?, product_image = ?, product_image2 = ?, product_image3 = ?, product_image4 = ?, product_price = ?, product_special_offer = ?, product_color = ?, stock = ? WHERE product_id = ?");
    $stmt->bind_param("sssssssdssii", $name, $category, $description, $image, $image2, $image3, $image4, $price, $special_offer, $color, $stock, $product_id);

    if ($stmt->execute()) {
        echo "Product updated successfully.";
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
    <script>
        function validateForm() {
            var description = document.getElementById("description").value;
            var wordCount = description.split(/\s+/).length;

            if (wordCount > 60) {
                alert("Description should not exceed 60 words.");
                return false;
            }

            return true;
        }
    </script>
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
        <h1 class="header Text">Edit Product</h1>
        <?php if ($product) { ?>
            <div class="form-container">
                <form method="POST" action="" onsubmit="return validateForm()">
                    <label for="name">Product Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
                    
                    <label for="category">Category:</label>
                    <select id="category" name="category" required>
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?php echo $category['category_id']; ?>" <?php echo $category['category_id'] == $product['product_category'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['category_name']); ?>
                            </option>
                        <?php } ?>
                    </select>
                    
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required><?php echo htmlspecialchars($product['product_description']); ?></textarea>
                    
                    <label for="image">Image 1 Name:</label>
                    <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($product['product_image']); ?>" required>
                    
                    <label for="image2">Image 2 Name:</label>
                    <input type="text" id="image2" name="image2" value="<?php echo htmlspecialchars($product['product_image2']); ?>" required>
                    
                    <label for="image3">Image 3 Name:</label>
                    <input type="text" id="image3" name="image3" value="<?php echo htmlspecialchars($product['product_image3']); ?>" required>
                    
                    <label for="image4">Image 4 Name:</label>
                    <input type="text" id="image4" name="image4" value="<?php echo htmlspecialchars($product['product_image4']); ?>" required>
                    
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
