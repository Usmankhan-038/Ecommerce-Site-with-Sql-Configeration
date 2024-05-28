<?php
include('server/connection.php');

if(isset($_POST['order-details-btn']) && isset($_POST['order_id']))
{
    $order_id=$_POST['order_id'];
    $order_status=$_POST['order_status'];
    $stmt=$conn->prepare("SELECT * FROM order_items WHERE order_id=?");
    $stmt->bind_param('i',$order_id);
    $stmt->execute();
    $order_detail=$stmt->get_result();
   
   
}
else
{

   //header('location:account.php');
}


?>

<?php include('layout/header.php')?>


<section class="orders container my-5 py-3" id="orders">
    <div class="container mt-2">
        <h2 class="font-weight-bold text-center">Your Order</h2>
        <hr class="mx-auto">
    </div>
    
    <table class="mt-5 pt-5 mx-auto">
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>

            

        </tr>
        <?php while($row = $order_detail->fetch_assoc()) { ?>
            <tr>
                <td>
                    <div class="product-info">
                        <img src="assets/imgs/<?php echo $row['product_image'] ?>" >
                        <div>
                            <p class="mt-3"><?php echo $row['product_name'] ?></p>
                        </div>
                    </div>
                </td>
                <td>
                    <span>$ <?php echo $row['product_price'] ?></span>
                </td>
                <td>
                    <span><?php echo $row['product_qunatity'] ?></span>
                </td>
              
                
            </tr>
        <?php } ?>
        

    </table>

    <?php
if($order_status="Not Paid") {?>
<form style="float:right;">
<input type="submit" class="btn btn-primary" value="Pay Now">
</form>
<?php
}
?>

    
</section>

<?php include('layout/footer.php')?>
