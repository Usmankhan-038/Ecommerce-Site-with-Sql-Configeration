<?php
session_start();

if(isset($_POST['order_pay_btn']))
{
   $order_status= $_POST['order_status'];
    $order_total_price=$_POST['order_total_price'];
}
?>





<?php include('layout/header.php')?>

<!--Payment-->

<section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Payment</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container text-center">
            <?php if(isset($_SESSION['total'])) {?>
            <p>Total Payment: $ <?php echo $_SESSION['total'];?></p> <?php } ?>
            <?php if(isset($_POST['order_status']) && $_POST['order_status']== "Not Paid" && $_SESSION['total'] != 0) { ?>
            <input class="btn btn-primary" type="submit" value="Pay Now"/>   <?php } else { ?>
                <p>You don't have an order</p> 
                <?php } ?>

                <p><?php if(isset($_GET['order_status'])) {echo $_GET['order_status'];}?></p>
                <?php if(isset($_POST['order_status']) && $_POST['order_status']== "Not Paid") { ?>
            <input class="btn btn-primary" type="submit" value="Pay Now"/>   <?php } ?>
            
        </div>
</section>



<?php include('layout/footer.php')?>
