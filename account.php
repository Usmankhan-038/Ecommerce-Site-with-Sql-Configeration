<?php
include('server/connection.php');
session_start();

if(!isset($_SESSION['logged_in']))
{
    header('Location:login.php');
    exit;
}

if(isset($_GET['logout']))
{
    if(isset($_SESSION['logged_in']))
    {
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        header('location: login.php');
    }
}

if(isset($_POST['change_password']))
{

    $password=$_POST['password'];
    $confirmpassword=$_POST['confirmpassword'];
    if($password!=$confirmpassword)
    {
        header('location:account.php?error=Password don\'t match');
    }
    else if(strlen($password)<6)
    {
        header('location:account.php?error=Password must be at least 6 characters');
    }
    else
    {
        $stmt = $conn->prepare("UPDATE users SET user_password=? WHERE user_email=?");
        $stmt->bind_param('ss',md5($password),$_SESSION['user_email']);
        if($stmt->execute())
        {
            header('location:account.php?message=Password changed successfully');
        }
        else
        {
            header('location:account.php?error=Something went wrong');
        }
    }

}


if(isset($_SESSION['logged_in']))
{
    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=?");
    $stmt->bind_param('i',$_SESSION['user_id']);
    $stmt->execute();
    $orders = $stmt->get_result();
   // $orders = $result->fetch_all(MYSQLI_ASSOC);
}
else
{
    header('location:login.php');
}

?>
<?php include('layout/header.php')?>

      <!--Account-->
      <section class="my-5 py-5">
        <div class="row container mx-auto">
            <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
            <p class="text-center" style="color:green;"><?php if(isset($_GET['register_success'])){echo $_GET['register_success'];} ?></p>
            <p class="text-center" style="color:green;"><?php if(isset($_GET['login_success'])){echo $_GET['login_success'];} ?></p>

                <h3 class="font-weight-bold">Account info</h3>
                <hr class="mx-auto">
                <div class="account-info">
                <p>Name <span><?php if(isset($_SESSION['user_name'])){ echo $_SESSION['user_name'];}?></span></p>
                <p>Email <span><?php if(isset($_SESSION['user_email'])){ echo $_SESSION['user_email'];}?></span></p>
                <p><a href="#orders" id="orders-btn">Your orders</a></p>
                <p><a href="account.php?logout=1" id="logout-btn">Logout</a></p>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-md-12">
                <form id="account-form" method="POST" action="account.php">
                    <p class="text-center" style="color:red;"><?php if(isset($_GET['error'])){echo $_GET['error'];} ?></p>
                    <p class="text-center" style="color:green;"><?php if(isset($_GET['message'])){echo $_GET['message'];} ?></p>

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
                        <input type="submit" value="Change Password" class="btn" id="change-pass-btn" name="change_password">
                    </div>
                </form>
            </div>
        </div>
      </section>

<!--Orders-->
<section class="orders container my-5 py-3" id="orders">
    <div class="container mt-2">
        <h2 class="font-weight-bold text-center">Your Orders</h2>
        <hr class="mx-auto">
    </div>
    
    <table class="mt-5 pt-5">
        <tr>
            <th>Order ID</th>
            <th>Order cost</th>
            <th>Order Status</th>
            <th>Date</th>
            <th>Order Detail</th>
            

        </tr>
        <?php while($row=$orders->fetch_assoc()) {?>
        <tr>
        <td>
                <span><?php echo $row['order_id']?></span>
        </td>
        <td>
                <span><?php echo $row['order_cost']?></span>

        </td>
        <td>
                <span><?php echo $row['order_status']?></span>

        </td>
        <td>
                <span><?php echo $row['order_date']?></span>

        </td>
        <td>
        <form action="order_detail.php" method="POST">
            <input type="hidden" value="<?php echo $row['order_status'];?>" name="order_status">
            <input type="hidden" value="<?php echo $row['order_id']; ?>" name="order_id">
            <input type="submit" class="btn order-details-btn" value="Detail" name="order-details-btn">
        </form>
        </td>

            
            
        </tr>

        <?php } ?>

        

    </table>



    
</section>











      <!--footer-->
      <?php include('layout/footer.php')?>
