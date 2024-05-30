


<?php include('layout/header.php')?>

      <!---Home-->
      <section id="home">
        <div class="container">
            <h5>NEW ARRIVAL</h5>
            <h1><span>Best Prices</span> This Season</h1>
            <p>Eshop offers thebest porducts for the most affordable price </p>
            <button>Shop Now</button>
        </div>
      </section>

<!--Brand-->
<section id="brand" class container>
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
            <img class="img-fluid"src="assets/imgs/1.jpg"/>
            <div class="details">
                <h2>Extremely Awesome Shoes</h2>
                <button class="text-uppercase">Shop Now</button>
            </div>
        </div>

            <!--two-->
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                <img class="img-fluid"src="assets/imgs/2.jpg"/>
                <div class="details">
                    <h2> Awesome Jacket</h2>
                    <button class="text-uppercase">Shop Now</button>
                </div>
            </div>

                <!--three-->
                <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                    <img class="img-fluid"src="assets/imgs/3.jpg"/>
                    <div class="details">
                        <h2>50% Off Watches</h2>
                        <button class="text-uppercase">Shop Now</button>
                    </div>
                </div>

    </div>
</section>

<!---featured-->
<section id="featured" class="my-5 pb-5" >
    <div class="container text-center mt-5 py-5">
        <h3>Our Featured</h3>
        <hr class="mx-auto">
        <p>Here you can check out our featured products</p>
    </div>
    <div class="row mx-auto container-fluid">

    <?php include('server/get_featured_products.php'); ?>


    <?php while($row=$featured_products->fetch_assoc()){?>


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
           <a href="<?php echo "single_product.php?product_id=".$row['product_id'];?>"><button class="buy-btn">Buy Now</button></a>
        </div>
        
        
       <?php } ?> 
    </div>
</section>


<!--BaNNER-->
<section id="banner" class="my-5 pb-5">
    <div class="container">
        <h4>MID SEASON'S SALE</h4>
        <H1>Autum Collection <br> UP to 30% OFF</H1>
        <button class="text-uppercase">shop now</button>
    </div>
</section>


<!--clothes-->

<section id="featured" class="my-5 " >
    <div class="container text-center mt-5 py-5">
        <h3>Dresses & Coats</h3>
        <hr class="mx-auto">
        <p>Here you can check out our featured products</p>
    </div>
   
   
    <div class="row mx-auto container-fluid">
    <?php include('server/gets_coats.php') ?>

<?php while($row=$coats_products->fetch_assoc()){?>
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
          <a href="<?php echo "single_product.php?product_id=".$row['product_id'];?>"><button class="buy-btn">Buy Now</button></a>
        </div>
       <?php }?>
       
      
        
    </div>
</section>

<!--shoes-->
<section id="shoes" class="my-5 " >
    <div class="container text-center mt-5 py-5">
        <h3>Shoes</h3>
        <hr class="mx-auto">
        <p>Here you can check out our featured products</p>
    </div>
    <div class="row mx-auto container-fluid">
    <?php include('server/get_shoes.php') ?>

<?php while($row=$shoes_products->fetch_assoc()){?>
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
          <a href="<?php echo "single_product.php?product_id=".$row['product_id'];?>"><button class="buy-btn">Buy Now</button></a>
        </div>
       <?php }?>
       
      
        
    </div>
</section>
  

<!--watches-->
<section id="watches" class="my-5 " >
    <div class="container text-center mt-5 py-5">
        <h3>Watches</h3>
        <hr class="mx-auto">
        <p>Here you can check out our featured products</p>
    </div>
    <div class="row mx-auto container-fluid">
    <?php include('server/get_watches.php') ?>

    <?php while($row=$watches_products->fetch_assoc()){?>
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
          <a href="<?php echo "single_product.php?product_id=".$row['product_id'];?>"><button class="buy-btn">Buy Now</button></a>
        </div>
       <?php }?>
    </div>
</section>


<!--footer-->
<?php include('layout/footer.php')?>
