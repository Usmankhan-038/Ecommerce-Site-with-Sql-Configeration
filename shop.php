<?php
include('server/connection.php');

if(isset($_POST['search'])) {
    $category=$_POST['category'];
    $price=$_POST['price'];
    $stmt = $conn->prepare("SELECT * FROM products where product_category=? and product_price<=? ");
    $stmt->bind_param("si",$category,$price);
    $stmt->execute();
    $products=$stmt->get_result();
} else {
    $stmt = $conn->prepare("SELECT * FROM products");
    $stmt->execute();
    $products=$stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .product img {
            width: 100%;
            height: auto;
            box-sizing: border-box;
            object-fit: cover;
        }
        .pagination a {
            color: coral;
        }
        .pagination li:hover a {
            color: #fff;
            background-color: coral;
        }
        .navbar-nav .nav-link {
            color: black;
        }
        .navbar-nav .nav-link:hover {
            color: gray;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white py-3 fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img class="logo" src="assets/imgs/logo.jpg" alt="Logo"/>
                <h2 class="brand d-inline-block">Orange</h2>
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
                        <a class="nav-link" href="#">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
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
                            <div class="form-check">
                                <input type="radio" class="form-check-input" value="shoes" name="category" id="category_one">
                                <label for="flexRadioDefault1" class="form-check-label">shoes</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" value="coats" name="category" id="category_one">
                                <label for="flexRadioDefault2" class="form-check-label">coats</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" value="watches" name="category" id="category_one">
                                <label for="flexRadioDefault2" class="form-check-label">watches</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" value="bags" name="category" id="category_one">
                                <label for="flexRadioDefault2" class="form-check-label">bags</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mx-auto container mt-5">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <p>Price</p>
                            <input type="range" class="form-range w-100" min="1" max="1000" id="customRange2" name="price" value="100">
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
                            <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image2'] ?>"/>
                            <div class="star">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h5 class="p-name"><?php echo $row['product_name'] ?></h5>
                            <h4 class="p-price"><?php echo $row['product_price'] ?></h4>
                            <a class="btn buy-btn" href="<?php echo "single_product.php?product_id=".$row['product_id']; ?>">Buy Now</a>
                        </div>
                    <?php } ?>
                </div>

                <nav aria-label="Page navigation example">
                    <ul class="pagination mt-5">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </section>
        </div>
    </div>
</div>

<?php include('layout/footer.php')?>
</body>
</html>
