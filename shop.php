<?php
include('server/connection.php');

$products = [];
$total_records = 0;
$selected_category = "all";  // Default value for category
$selected_price = 100;  // Default value for price

if (isset($_POST['search'])) {
    $selected_category = $_POST['category'];
    $selected_price = $_POST['price'];
    $page_no = 1; // Reset to page 1 for new search
} else {
    if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
        $page_no = $_GET['page_no'];
    } else {
        $page_no = 1;
    }

    if (isset($_GET['category'])) {
        $selected_category = $_GET['category'];
    }

    if (isset($_GET['price'])) {
        $selected_price = $_GET['price'];
    }
}

$sql_count = "SELECT COUNT(*) AS total_records FROM products INNER JOIN categories ON products.product_category = categories.category_id";
$sql_products = "SELECT products.*, categories.category_name FROM products INNER JOIN categories ON products.product_category = categories.category_id";
$conditions = [];
$params = [];
$types = "";

if ($selected_category !== "all") {
    $conditions[] = "categories.category_name = ?";
    $params[] = $selected_category;
    $types .= "s";
}

if ($selected_price) {
    $conditions[] = "products.product_price <= ?";
    $params[] = $selected_price;
    $types .= "i";
}

if (!empty($conditions)) {
    $sql_count .= " WHERE " . implode(" AND ", $conditions);
    $sql_products .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($sql_count);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$stmt->bind_result($total_records);
$stmt->store_result();
$stmt->fetch();

$total_records_per_page = 8;
$offset = ($page_no - 1) * $total_records_per_page;
$total_no_of_pages = ceil($total_records / $total_records_per_page);

$sql_products .= " LIMIT ?, ?";
$params[] = $offset;
$params[] = $total_records_per_page;
$types .= "ii";

$stmt2 = $conn->prepare($sql_products);
$stmt2->bind_param($types, ...$params);
$stmt2->execute();
$products = $stmt2->get_result();
?>

<?php
session_start();


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/style.css"/>
    <style>
        .navbar-nav .nav-link {
            color: black;
        }
        .navbar-nav .nav-link:hover {
            color: gray;
        }
        .cart_quantity
{
    background-color: #fb774b;
    color: white;
    padding: 2px 5px;
    border-radius: 50%;
    margin: -2px;
    
    font-size: 12px;
}
    </style>
</head>
<body>

    <!--Navbar-->
    <nav class="navbar navbar-expand-lg bg-white py-3 fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img class="logo" src="assets/imgs/logo.jpg" alt="Logo"/>
                <h2 style="display:inline; color:#fb774b">RGB</h2>
                <h2 class="brand d-inline-block" style="display:inline">SPOT</h2>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        <span class="cart_quantity"><?php if(isset($_SESSION['quantity']) && $_SESSION['quantity']!=0){echo $_SESSION['quantity'];}?></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="account.php"><i class="fa fa-user" aria-hidden="true"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

  

<div class="container my-5 py-5">
    <div class="row">
        <!-- Search Section -->
        <div class="col-lg-3 col-md-4 col-sm-12">
            <section id="search" class="my-5 py-5">
                <div class="container">
                    <p>Search Product</p>
                    <hr>
                </div>
                <form action="shop.php" method="POST">
                    <div class="row mx-auto container">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <p>Category</p>
                            <?php
                            $category_stmt = $conn->prepare("SELECT * FROM categories");
                            $category_stmt->execute();
                            $categories = $category_stmt->get_result();
                            ?>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" value="all" name="category" id="category_all" <?php if($selected_category == 'all') echo 'checked'; ?>>
                                <label for="category_all" class="form-check-label">All</label>
                            </div>
                            <?php while($category = $categories->fetch_assoc()) { ?>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" value="<?php echo htmlspecialchars($category['category_name']); ?>" name="category" id="category_<?php echo htmlspecialchars($category['category_name']); ?>" <?php if($selected_category == $category['category_name']) echo 'checked'; ?>>
                                    <label for="category_<?php echo htmlspecialchars($category['category_name']); ?>" class="form-check-label"><?php echo htmlspecialchars($category['category_name']); ?></label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="row mx-auto container mt-5">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <p>Price</p>
                            <input type="range" class="form-range w-100" min="1" max="1000" id="customRange2" name="price" value="<?php echo $selected_price; ?>">
                            <div class="d-flex justify-content-between">
                                <span>1</span>
                                <span>1000</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group my-3">
                        <input type="submit" name="search" value="Search" class="btn btn-primary w-100">
                    </div>
                </form>
            </section>
        </div>

        <!-- Products Section -->
        <div class="col-lg-9 col-md-8 col-sm-12">
            <section id="featured" class="my-5 py-5">
                <div class="container">
                    <h3>Our Products</h3>
                    <hr>
                    <p>Here you can check out our featured products</p>
                </div>
                <div class="row mx-auto container">
                    <?php while($row = $products->fetch_assoc()) { ?>
                        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                            <img class="img-fluid mb-3" src="assets/imgs/<?php echo htmlspecialchars($row['product_image2']); ?>"/>
                            <div class="star">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h5 class="p-name"><?php echo htmlspecialchars($row['product_name']); ?></h5>
                            <h4 class="p-price"><?php echo htmlspecialchars($row['product_price']); ?></h4>
                            <?php if ($row['stock'] == 0 || $row['stock'] == null) { ?>
                                <p class="text-danger">Out of Stock</p>
                            <?php } else { ?>
                                <a class="btn buy-btn" href="<?php echo "single_product.php?product_id=" . htmlspecialchars($row['product_id']); ?>">Buy Now</a>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>

                <nav aria-label="Page navigation example">
                    <ul class="pagination mt-5 mx-auto">
                        <li class="page-item <?php if($page_no <= 1){ echo 'disabled';}?>">
                            <a class="page-link" href="<?php if($page_no > 1){ echo '?page_no='.($page_no-1).'&category='.$selected_category.'&price='.$selected_price;} else { echo '#'; } ?>">Previous</a>
                        </li>
                        <?php for ($i = 1; $i <= $total_no_of_pages; $i++) { ?>
                            <li class="page-item <?php if($page_no == $i){ echo 'active';}?>">
                                <a class="page-link" href="?page_no=<?php echo $i; ?>&category=<?php echo $selected_category; ?>&price=<?php echo $selected_price; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php } ?>
                        <li class="page-item <?php if($page_no >= $total_no_of_pages){ echo 'disabled';}?>">
                            <a class="page-link" href="<?php if($page_no < $total_no_of_pages){ echo '?page_no='.($page_no+1).'&category='.$selected_category.'&price='.$selected_price;} else { echo '#'; } ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            </section>
        </div>
    </div>
</div>

<?php include('layout/footer.php'); ?>
</body>
</html>
