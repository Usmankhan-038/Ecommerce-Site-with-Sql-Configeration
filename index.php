<?php include('layout/header.php')?>
<!-- JavaScript to load and display notifications -->
<script>
// document.addEventListener('DOMContentLoaded', function() {
//     fetchNotifications();

//     function fetchNotifications() {
//         fetch('server/get_notification.php')
//             .then(response => {
//                 if (!response.ok) {
//                     throw new Error('Network response was not ok');
//                 }
//                 return response.text();
//             })
//             .then(data => {
//                 const notifications = data.split('\n').filter(Boolean);
//                 if (notifications.length) {
//                     displayNotifications(notifications);
//                 } else {
//                     console.error('No notifications found');
//                     checkCartQuantity();
//                 }
//             })
//             .catch(error => console.error('Error fetching notifications:', error));
//     }

//     function displayNotifications(notifications) {
//         let currentIndex = 0;

//         function showNotification() {
//             if (currentIndex < notifications.length) {
//                 let notification = notifications[currentIndex].split('::');
//                 let notificationId = notification[0];
//                 let message = notification[1];
//                 window.alert(message);
//                 markNotificationAsSeen(notificationId);
//                 currentIndex++;
//                 setTimeout(showNotification, 3600000); // Show next notification in 1 hour
//             }
//         }

//         showNotification();
//     }

//     function markNotificationAsSeen(notificationId) {
//         fetch('server/mark_notification_seen.php', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/x-www-form-urlencoded'
//             },
//             body: `notification_id=${notificationId}`
//         })
//         .then(response => {
//             if (!response.ok) {
//                 throw new Error('Network response was not ok');
//             }
//             return response.text();
//         })
//         .then(data => console.log(data))
//         .catch(error => console.error('Error marking notification as seen:', error));
//     }

//     function checkCartQuantity() {
//         fetch('server/get_cart_quantity.php')
//             .then(response => {
//                 if (!response.ok) {
//                     throw new Error('Network response was not ok');
//                 }
//                 return response.text();
//             })
//             .then(quantity => {
//                 if (parseInt(quantity) > 0) {
//                     window.alert('Please Checkout from your cart. You have ' + quantity + ' items.');
//                 }
//             })
//             .catch(error => console.error('Error fetching cart quantity:', error));
//     }
// });

</script>
<!---Home-->
<section id="home">
    <div class="container">
        <h5 style="color:white">NEW ARRIVAL</h5>
        <h1 style="color:white"><span>Best Prices</span> This Season</h1>
        <p style="color:white"> RGBSPOT offers the best products for the most affordable price</p>
        <a href="#featured"><button>Shop Now</button></a>
    </div>
</section>

<!-- Notifications
<section id="notifications" class="container">
    <div id="notification-content" class="text-center">
        <h3>Notifications</h3>
        <hr class="mx-auto">
        <p>Here you can check out our latest notifications</p>
    </div>
</section> -->

<!--Brand-->
<section id="brand" class="container">
    <div class="row">
        <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand 1.jpg"/>
        <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand 2.jpg"/>
        <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand 3.jpg"/>
        <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand 4.jpg"/>
    </div>
</section>

<!---NEW-->
<section id="new" class="w-100">
    <div class="row p-0 m-0">
        <!--one-->
        <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
            <img class="img-fluid" src="assets/imgs/1.jpg"/>
            <div class="details">
                <h2>Extremely Awesome Shoes</h2>
               <a href="shop.php"><button class="text-uppercase">Shop Now</button></a> 
            </div>
        </div>

        <!--two-->
        <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
            <img class="img-fluid" src="assets/imgs/2.jpg"/>
            <div class="details">
                <h2> Awesome Jacket</h2>
                <a href="shop.php"><button class="text-uppercase">Shop Now</button></a> 
            </div>
        </div>

        <!--three-->
        <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
            <img class="img-fluid" src="assets/imgs/3.jpg"/>
            <div class="details">
                <h2>50% Off Watches</h2>
                <a href="shop.php"><button class="text-uppercase">Shop Now</button></a> 
            </div>
        </div>
    </div>
</section>

<!---featured-->
<section id="featured" class="my-5 pb-5">
    <div class="container text-center mt-5 py-5">
        <h3>Our Featured</h3>
        <hr class="mx-auto">
        <p>Here you can check out our featured products</p>
    </div>
    <div class="row mx-auto container-fluid">
        <?php include('server/get_featured_products.php'); ?>
        <?php while($row=$featured_products->fetch_assoc()){ ?>
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image2']; ?>"/>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                <h4 class="p-price">$ <?php echo $row['product_price']; ?></h4>
                <?php if ($row['stock'] == 0 || $row['stock'] == null) { ?>
                    <button class="buy-btn" disabled>Out of Stock</button>
                <?php } else { ?>
                    <a href="<?php echo "single_product.php?product_id=".$row['product_id']; ?>"><button class="buy-btn">Buy Now</button></a>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>

<!--BaNNER-->
<section id="banner" class="my-5 pb-5">
    <div class="container">
        <h4 style="color:white">MID SEASON'S SALE</h4>
        <H1 >Autum Collection <br> UP to 30% OFF</H1>
        <button class="text-uppercase">shop now</button>
    </div>
</section>

<!--clothes-->
<section id="featured" class="my-5">
    <div class="container text-center mt-5 py-5">
        <h3>Dresses & Coats</h3>
        <hr class="mx-auto">
        <p>Here you can check out our featured products</p>
    </div>

    <div class="row mx-auto container-fluid">
        <?php include('server/gets_coats.php') ?>
        <?php while($row=$coats_products->fetch_assoc()){ ?>
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image2']; ?>"/>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
                <?php if ($row['stock'] == 0 || $row['stock'] == null) { ?>
                    <button class="buy-btn" disabled>Out of Stock</button>
                <?php } else { ?>
                    <a href="<?php echo "single_product.php?product_id=".$row['product_id']; ?>"><button class="buy-btn">Buy Now</button></a>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>

<!--shoes-->
<section id="shoes" class="my-5">
    <div class="container text-center mt-5 py-5">
        <h3>Shoes</h3>
        <hr class="mx-auto">
        <p>Here you can check out our featured products</p>
    </div>
    <div class="row mx-auto container-fluid">
        <?php include('server/get_shoes.php') ?>
        <?php while($row=$shoes_products->fetch_assoc()){ ?>
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image2']; ?>"/>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
                <?php if ($row['stock'] == 0 || $row['stock'] == null) { ?>
                    <button class="buy-btn" disabled>Out of Stock</button>
                <?php } else { ?>
                    <a href="<?php echo "single_product.php?product_id=".$row['product_id']; ?>"><button class="buy-btn">Buy Now</button></a>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>

<!--watches-->
<section id="watches" class="my-5">
    <div class="container text-center mt-5 py-5">
        <h3>Watches</h3>
        <hr class="mx-auto">
        <p>Here you can check out our featured products</p>
    </div>
    <div class="row mx-auto container-fluid">
        <?php include('server/get_watches.php') ?>
        <?php while($row=$watches_products->fetch_assoc()){ ?>
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image2']; ?>"/>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
                <?php if ($row['stock'] == 0 || $row['stock'] == null) { ?>
                    <button class="buy-btn" disabled>Out of Stock</button>
                <?php } else { ?>
                    <a href="<?php echo "single_product.php?product_id=".$row['product_id']; ?>"><button class="buy-btn">Buy Now</button></a>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>

<?php include('layout/footer.php') ?>
