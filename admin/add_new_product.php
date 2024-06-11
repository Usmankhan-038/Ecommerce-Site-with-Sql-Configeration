<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $category_id = trim($_POST['category_id']);
    $description = trim($_POST['description']);
    $image = trim($_POST['image']);
    $image2 = trim($_POST['image2']);
    $image3 = trim($_POST['image3']);
    $image4 = trim($_POST['image4']);
    $price = trim($_POST['price']);
    $special_offer = trim($_POST['special_offer']);
    $color = trim($_POST['color']);
    $stock = trim($_POST['stock']);

    // Validate inputs
    $errors = [];

    // Check for empty fields
    if (empty($name) || empty($category_id) || empty($description) || empty($image) || empty($image2) || empty($image3) || empty($image4) || empty($price) || empty($special_offer) || empty($color) || empty($stock)) {
        $errors[] = "All fields are required.";
    }

    // Check image names end with .jpg
    if (!preg_match('/\.jpg$/', $image) || !preg_match('/\.jpg$/', $image2) || !preg_match('/\.jpg$/', $image3) || !preg_match('/\.jpg$/', $image4)) {
        $errors[] = "All image names must end with .jpg";
    }

    // Check description word count
    if (str_word_count($description) > 60) {
        $errors[] = "Description should not exceed 60 words.";
    }

    // Check price is positive
    if (!is_numeric($price) || $price <= 0) {
        $errors[] = "Price should be a positive number.";
    }

    // Check stock is non-negative
    if (!is_numeric($stock) || $stock < 0) {
        $errors[] = "Stock should be a non-negative integer.";
    }

    // Check special offer is non-negative
    if (!is_numeric($special_offer) || $special_offer < 0) {
        $errors[] = "Special offer should be a non-negative integer.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO products (product_name, product_category, product_description, product_image, product_image2, product_image3, product_image4, product_price, product_special_offer, product_color, stock) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisssssissi", $name, $category_id, $description, $image, $image2, $image3, $image4, $price, $special_offer, $color, $stock);
        if ($stmt->execute()) {
            header('Location: product.php');
            exit();
        } else {
            $errors[] = "Error: " . $stmt->error;
        }
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
        .error {
            color: red;
            margin: 10px 0;
        }
    </style>
    <script>
        function validateForm() {
            var name = document.getElementById("name").value.trim();
            var category_id = document.getElementById("category_id").value.trim();
            var description = document.getElementById("description").value.trim();
            var image = document.getElementById("image").value.trim();
            var image2 = document.getElementById("image2").value.trim();
            var image3 = document.getElementById("image3").value.trim();
            var image4 = document.getElementById("image4").value.trim();
            var price = document.getElementById("price").value.trim();
            var special_offer = document.getElementById("special_offer").value.trim();
            var color = document.getElementById("color").value.trim();
            var stock = document.getElementById("stock").value.trim();
            var errors = [];

            if (!name || !category_id || !description || !image || !image2 || !image3 || !image4 || !price || !special_offer || !color || !stock) {
                errors.push("All fields are required.");
            }

            if (!/\.jpg$/.test(image) || !/\.jpg$/.test(image2) || !/\.jpg$/.test(image3) || !/\.jpg$/.test(image4)) {
                errors.push("All image names must end with .jpg");
            }

            var wordCount = description.split(/\s+/).length;
            if (wordCount > 60) {
                errors.push("Description should not exceed 60 words.");
            }

            if (!isFinite(price) || price <= 0) {
                errors.push("Price should be a positive number.");
            }

            if (!isFinite(stock) || stock < 0) {
                errors.push("Stock should be a non-negative integer.");
            }

            if (!isFinite(special_offer) || special_offer < 0) {
                errors.push("Special offer should be a non-negative integer.");
            }

            if (errors.length > 0) {
                alert(errors.join("\n"));
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
            <li><a href="create_notification.php" class="side_bar_menu">Notifications</a></li>
            <li><a href="customer.php" class="side_bar_menu">Customer</a></li>

            <!-- <li><a href="create_notification.php" class="side_bar_menu">Create Notification</a></li> -->
            <li><a href="admin_account.php" class="side_bar_menu">Account</a></li>
        </ul>
    </aside>
    <main>
        <h1 class="header Text">Add New Product</h1>
        <div class="form-container">
            <?php if (!empty($errors)) { ?>
                <div class="error">
                    <?php foreach ($errors as $error) { ?>
                        <p><?php echo $error; ?></p>
                    <?php } ?>
                </div>
            <?php } ?>
            <form method="POST" action="add_new_product.php" onsubmit="return validateForm()">
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
                
                <label for="image">Image 1 Name:</label>
                <input type="text" id="image" name="image" required>
                
                <label for="image2">Image 2 Name:</label>
                <input type="text" id="image2" name="image2" required>
                
                <label for="image3">Image 3 Name:</label>
                <input type="text" id="image3" name="image3" required>
                
                <label for="image4">Image 4 Name:</label>
                <input type="text" id="image4" name="image4" required>
                
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
