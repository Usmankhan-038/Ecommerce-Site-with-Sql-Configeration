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
            <a class="nav-link" href="index.html">Home</a>
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

      <!--Account-->
      <section class="my-5 py-5">
        <div class="row container mx-auto">
            <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
                <h3 class="font-weight-bold">Account info</h3>
                <hr class="mx-auto">
                <div class="account-info">
                <p>Name <span>John</span></p>
                <p>Email <span>john@gmail.com</span></p>
                <p><a href="" id="orders-btn">Your orders</a></p>
                <p><a href="" id="logout-btn">Logout</a></p>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-md-12">
                <form id="account-form">
                    <h3>Change Password</h3>
                    <hr class="mx-auto">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" id="account-password" name="password" placeholder="Password" required/>

                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" id="account-password-confirm" name="confirmpassword" placeholder="Password" required/>

                    </div>
                    <div class="form-group">
                        <input type="submit" value="Change Password" class="btn" id="change-pass-btn">
                    </div>
                </form>
            </div>
        </div>
      </section>

<!--Orders-->
<section class="orders container my-5 py-3">
    <div class="container mt-2">
        <h2 class="font-weight-bold text-center">Your Orders</h2>
        <hr class="mx-auto">
    </div>
    
    <table class="mt-5 pt-5">
        <tr>
            <th>Product</th>
            <th>Date</th>
            

        </tr>
        <tr>
            <td>
                
               <div class="product-info">
                <img src="assets/imgs/featured1.jpg" alt="">
                <div>
                    <p class="mt-3">White Shoes</p>
                </div>
               </div> 

            </td>

           <td>
            <span>2036-5-8</span>

           </td>

            
            
        </tr>

        

        

    </table>



    
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