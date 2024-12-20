<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}


$selected_category = isset($_GET['category']) ? $_GET['category'] : '';
$selected_price = isset($_GET['price']) ? $_GET['price'] : '';


$page_no = isset($_GET['page_no']) && $_GET['page_no'] != "" ? $_GET['page_no'] : 1;


$stmt = $conn->prepare("SELECT COUNT(*) AS total_records FROM products");
$stmt->execute();
$stmt->bind_result($total_records);
$stmt->store_result();
$stmt->fetch();

$total_records_per_page = 10;
$offset = ($page_no - 1) * $total_records_per_page;
$total_no_of_pages = ceil($total_records / $total_records_per_page);


$stmt2 = $conn->prepare("
    SELECT products.*, categories.category_name 
    FROM products 
    INNER JOIN categories ON products.product_category = categories.category_id 
    LIMIT ?, ?
");
$stmt2->bind_param("ii", $offset, $total_records_per_page);
$stmt2->execute();
$products = $stmt2->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
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
        .btn1 {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #fb774b;
            border: none;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }
        .btn1:hover {
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
            <input type="submit" class="sign_out btn1" value="Sign out" name="sign_out">
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
        <h1 class="header Text">Products</h1>
        <table>
            <tr>
                <th>Product ID</th>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Product Offer</th>
                <th>Product Category</th>
                <th>Product Color</th>
                <th>Edit</th>    
                <th>Delete</th>
            </tr>
            <?php while ($row = $products->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['product_id']; ?></td>
                <td><img src="../assets/imgs/<?php echo $row['product_image']; ?>" style="width: 70px; height:70px;"></td>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo $row['product_price']; ?></td>
                <td><?php echo $row['product_special_offer']; ?></td>
                <td><?php echo $row['category_name']; ?></td>
                <td><?php echo $row['product_color']; ?></td>
                <td><a href="edit_product.php?id=<?php echo $row['product_id']; ?>" class="btn btn-blue">Edit</a></td>
                <td><a href="delete_product.php?id=<?php echo $row['product_id']; ?>" class="btn">Delete</a></td>
            </tr>
            <?php } ?>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination mt-5 mx-auto">
                <li class="page-item <?php if ($page_no <= 1) { echo 'disabled'; } ?>">
                    <a class="page-link" href="<?php if ($page_no > 1) { echo '?page_no=' . ($page_no - 1) . '&category=' . $selected_category . '&price=' . $selected_price; } else { echo '#'; } ?>">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $total_no_of_pages; $i++) { ?>
                    <li class="page-item <?php if ($page_no == $i) { echo 'active'; } ?>">
                        <a class="page-link" href="?page_no=<?php echo $i; ?>&category=<?php echo $selected_category; ?>&price=<?php echo $selected_price; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
                <li class="page-item <?php if ($page_no >= $total_no_of_pages) { echo 'disabled'; } ?>">
                    <a class="page-link" href="<?php if ($page_no < $total_no_of_pages) { echo '?page_no=' . ($page_no + 1) . '&category=' . $selected_category . '&price=' . $selected_price; } else { echo '#'; } ?>">Next</a>
                </li>
            </ul>
        </nav>
    </main>
</body>
</html>
