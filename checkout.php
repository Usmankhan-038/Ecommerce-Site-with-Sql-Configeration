<?php
session_start();

if(!empty($_SESSION['cart']) && isset($_POST['checkout']))
{
  //let user in
}//send to home page
else
{
    header('location:index.php');
}


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
    <link rel="stylesheet"href="assets/css/style.css"/>
</head>
<body>

    
    
    <!--Navbar-->
    
    <nav class="navbar navbar-expand-lg bg-white py-3 fixed-top">
      <div class="container">
        <img class="logo" src="assets/imgs/logo.jpg"/>
        <h2 class="brand">Orange</h2>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
           
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="shop.html">Shop</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="#">Blog</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="contact.html">Contact Us</a>
            </li>

            <li class="nav-item">
            <a href="cart.html"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
            <a href="account.html"><i class="fa fa-user" aria-hidden="true"></i></a>
          </li>

         
            
           
          </ul>
          
        </div>
      </div>
    </nav>










<!--checkout-->

<section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Check Out</h2>
            <hr class="mx-auto">
            </div>
            <div class="mx-auto container">
                <form id="checkout-form" action="server/place_order.php" method="POST">
                <div class="form-group checkout-small-element">
                    <label>Name</label>
                    <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Name"requiured/>
                
                </div>
                
                    <div class="form-group checkout-small-element">
                        <label>Email</label>
                        <input type="text" class="form-control" id="checkout-email" name="email" placeholder="Email"requiured/>
                    
                    </div>

                    <div class="form-group checkout-small-element">
                        <label>Phone</label>
                        <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="Phone"required/>
                    
                    </div>
                    <div class="form-group checkout-small-element">
                        <label>City</label>
                        <input type="text" class="form-control" id="checkout-city" name="city" placeholder="City"required/>
                    
                    </div>
                    <div class="form-group checkout-large-element">
                      <label>Address</label>
                      <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Address"required/>
                  
                  </div>
                    <div class="form-group checkout-btn-container">
                       <p>Total amount: $ <?php echo $_SESSION['total'];?></p>
                        <input type="submit" class="btn" id="checkout-btn" name="place_order" value="Place Order" />
                    
                    </div>
                   

                </form>
            </div>
      </section>





      <!--footer-->
<footer class="mt-5 py-5">
  <div class="row container mx-auto pt-5">
      <div class="col-lg-3 col-md-6 col-sm-12">
          <img class="logo" src="assets/imgs/logo.jpg"/>
          <p class="pt-3">We provide the best products for the most affordable prices</p>
      </div>
      <div class="footner-one col-lg-3 col-md-6 col-sm-12">
          <h5 class="pb-2">Featured</h5>
          <ul class="text-uppercase">
              <li><a href="#">men</a></li>
              <li><a href="#">women</a></li>
              <li><a href="#">boys</a></li>
              <li><a href="#">girls</a></li>
              <li><a href="#">new arrivals</a></li>
              <li><a href="#">clothes</a></li>

</ul>
      </div>
      <div class="footner-one col-lg-3 col-md-6 col-sm-12">
       <h5 class="pb-2">Contact Us</h5>
       <div>
          <h6 class="text-uppercase">Address</h6>
          <p>1234 Street Name,City</p>
       </div>
       <div>
          <h6 class="text-uppercase">PHONE</h6>
          <p>0300 23234</p>
       </div>
       <div>
          <h6 class="text-uppercase">Email</h6>
          <p>abc@gmail.com</p>
       </div>
          </div>
          <div class="footner-one col-lg-3 col-md-6 col-sm-12">
              <h5 class="pb-2">Instagram</h5>
              <div class="row">
                  <img src="assets/imgs/featured1.jpg" class="img-fluid w-25 h-100 m-2"/>
                  <img src="assets/imgs/featured2.jpg" class="img-fluid w-25 h-100 m-2"/>
                  <img src="assets/imgs/featured3.jpg" class="img-fluid w-25 h-100 m-2"/>
                  <img src="assets/imgs/featured4.jpg" class="img-fluid w-25 h-100 m-2"/>
                  <img src="assets/imgs/clothes1.jpg" class="img-fluid w-25 h-100 m-2"/>
              </div>
          </div>
      </div>



      <div class="copyright mt-5">
          <div class="row container mx-auto">
              <div class="col-lg-3 col-md-5 col-sm-12 mb-4 text-nowrap mb-2">
                  <img src="assets/imgs/payment.jpg"/>
              </div>
              <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
                  <p>eCommerce @ 2025 All the Right Reserved</p>
              </div>
              <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
                  <a href="#"><i class="fab fa-facebook"></i></a>
                  <a href="#"><i class="fab fa-instagram"></i></a>
                  <a href="#"><i class="fab fa-twitter"></i></a>

              </div>
          </div>
      </div>
</footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>  
</body>
</html>