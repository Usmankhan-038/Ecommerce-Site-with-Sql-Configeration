<?php
session_start();
include('server/connection.php');

// Update order status when the payment button is clicked
if (isset($_POST['payment_btn'])) {
    $order_status = "Paid";
    $order_total_price = $_SESSION['total'];
    $order_id=$_POST['order_id'];
    $stmt = $conn->prepare("UPDATE orders SET order_status=? WHERE order_id=?");
    $stmt->bind_param("si", $order_status, $order_id);
    $stmt->execute();
    $_SESSION['order_status'] = $order_status;
    header('location:complete_payment.php?order_status=Order Paid Successfully,order_id='.$order_id);
    exit();
}

// Ensure order status is fetched correctly
if (isset($_POST['order_pay_btn'])) {
    $order_status = $_POST['order_status'];
    $order_total_price = $_POST['order_total_price'];
    $_SESSION['order_status'] = $order_status;
}

?>

<?php include('layout/header.php') ?>

<!--Payment-->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Payment</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container text-center">
        <p><?php if (isset($_GET['order_status'])) { echo $_GET['order_status']; } ?></p>
        <?php if (isset($_SESSION['total'])) { ?>
            <?php $order_id =$_POST['order_id']; ?>
            <p>Total Payment: $ <?php echo $_SESSION['total']; ?></p>
        <?php } ?>

        <form action="payment.php" method="POST">
            <?php if (isset($_SESSION['total']) && $_SESSION['total'] != 0 && isset($_SESSION['order_status']) && $_SESSION['order_status'] != "Paid") { ?>
                <?php $order_id =$_SESSION['order_id']; ?>
                <input class="btn btn-primary" type="submit" value="Pay Now" name="payment_btn" />
            <?php } else { ?>
                <p>You don't have an order</p>
            <?php } ?>
        </form>
    </div>
</section>

<?php include('layout/footer.php') ?>
