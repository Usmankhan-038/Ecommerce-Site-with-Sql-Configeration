<?php
session_start(); // Start the session
include('server/connection.php');

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result();

    // Fetch related products (for simplicity, fetching 4 random products)
    $related_stmt = $conn->prepare("SELECT * FROM products WHERE product_id != ? ORDER BY RAND() LIMIT 4");
    $related_stmt->bind_param("i", $product_id);
    $related_stmt->execute();
    $related_products = $related_stmt->get_result();
} else {
    header("Location: shop.php");
    exit();
}
?>
<?php include('layout/header.php'); ?>

<!--single-product-->
<section class="container single-product my-5 pt-5">
    <div class="row mt-5">
        <?php while ($row = $product->fetch_assoc()) { ?>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <img class="img-fluid w-100 pb-1" src="assets/imgs/<?php echo $row['product_image4']; ?>" id="mainImg"/>
                <div class="small-img-group">
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image3']; ?>" width="100%" class="small-img"/>
                    </div>
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image4']; ?>" width="100%" class="small-img"/>
                    </div>
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image4']; ?>" width="100%" class="small-img"/>
                    </div>
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image2']; ?>" width="100%" class="small-img"/>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12">
                <h3 class="py-4"><?php echo $row['product_name']; ?></h3>
                <h2><?php echo $row['product_price']; ?></h2>

                <?php if (isset($_SESSION['logged_in'])) { ?>
                    <form id="add-to-cart-form" action="cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $row['product_image2']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">
                        <input type="hidden" id="stock_quantity" name="stock_quantity" value="<?php echo $row['stock']; ?>">
                        
                        <?php if ($row['stock'] > 0) { ?>
                            <input type="number" id="product_quantity" name="product_quantity" value="1" min="1" max="<?php echo $row['stock']; ?>"/>
                            <button class="buy-btn" type="submit" name="add_to_cart">Add To Cart</button>
                        <?php } else { ?>
                            <button class="buy-btn" type="button" disabled>Out of Stock</button>
                        <?php } ?>
                    </form>
                <?php } else { ?>
                    <button class="buy-btn" onclick="window.location.href='login.php'">Login to Add to Cart</button>
                <?php } ?>
                
                <div id="error-message" style="color: red; display: none;">Quantity exceeds available stock.</div>

                <h4 class="mt-5 mb-5">Product Details</h4>
                <span><?php echo $row['product_description']; ?></span>
            </div>
        <?php } ?>
    </div>
</section>

<!--related products-->
<section id="related-products" class="my-5 pb-5">
    <div class="container text-center mt-5 py-5">
        <h3>Our Related Products</h3>
        <hr class="mx-auto">
    </div>
    <div class="row mx-auto container-fluid">
        <?php while ($related_row = $related_products->fetch_assoc()) { ?>
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/<?php echo $related_row['product_image2']; ?>"/>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"><?php echo $related_row['product_name']; ?></h5>
                <h4 class="p-price"><?php echo $related_row['product_price']; ?></h4>
                <?php if ($related_row['stock'] == 0 || $related_row['stock'] == null) { ?>
                                    <p class="text-danger">Out of Stock</p>
                                <?php } else { ?>
                                    <a class="btn buy-btn" href="<?php echo "single_product.php?product_id=" . htmlspecialchars($related_row['product_id']); ?>">Buy Now</a>
                                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>

<!--FOOTER-->
<footer class="mt-5 py-5">
    <div class="container">
        <div class="row mx-auto pt-5">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <img class="logo" src="assets/imgs/logo.jpg" alt="Logo"/>
                <p class="pt-3">We provide the best products for the most affordable prices</p>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <h5 class="pb-2" style="background-color: transparent;color:white;">Quick Links</h5>
                <ul class="text-uppercase">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <h5 class="pb-2" style="background-color: transparent;color:white;">Contact Us</h5>
                <div>
                    <h6 class="text-uppercase">Address</h6>
                    <p>Bahria University,islamabad</p>
                </div>
                <div>
                    <h6 class="text-uppercase">Phone</h6>
                    <p>0306 6000006</p>
                </div>
                <div>
                    <h6 class="text-uppercase">Email</h6>
                    <p>usman@gmail.com</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <h5 class="pb-2" style="background-color: transparent;color:white">Follow Us</h5>
                <div>
                    <a href="#"><i class="fab fa-facebook fa-lg mx-2" style="color: #3b5998;"></i></a>
                    <a href="#"><i class="fab fa-instagram fa-lg mx-2" style="color: #e4405f;"></i></a>
                    <a href="#"><i class="fab fa-twitter fa-lg mx-2" style="color: #55acee;"></i></a>
                </div>
            </div>
        </div>

        <div class="copyright mt-5">
            <div class="row container mx-auto">
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <img src="assets/imgs/payment.jpg" alt="Payment Methods" class="img-fluid"/>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <p class="text-center">RGBSPOT @ 2024 All Rights Reserved</p>
                </div>
               
            </div>
        </div>
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>  
<script>
    var mainImg = document.getElementById("mainImg");
    var smallImg = document.getElementsByClassName("small-img");

    for (var i = 0; i < smallImg.length; i++) {
        smallImg[i].onclick = function() {
            mainImg.src = this.src;
        }
    }

    document.getElementById("add-to-cart-form").onsubmit = function(event) {
        var stockQuantity = parseInt(document.getElementById("stock_quantity").value);
        var productQuantity = parseInt(document.getElementById("product_quantity").value);
        if (productQuantity > stockQuantity) {
            document.getElementById("error-message").style.display = "block";
            event.preventDefault(); // Prevent form submission
        }
    }
</script>
</body>
</html>
