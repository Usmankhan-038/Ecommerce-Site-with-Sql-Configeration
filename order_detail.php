<?php
session_start();
include('server/connection.php');

if (isset($_POST['order-details-btn']) && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $order_detail = $stmt->get_result();

    $order_total_price = calculateTotalOrderPrice($order_detail);
    $_SESSION['order_id'] = $order_id;
    $_SESSION['total'] = $order_total_price;
    $_SESSION['order_status'] = $order_status;
    $_SESSION['order_price'] = $order_total_price;

} else {
    header('Location: account.php');
    exit();
}

function calculateTotalOrderPrice($order_detail) {
    $total = 0;
    while ($row = $order_detail->fetch_assoc()) {
        $total += $row['product_quantity'] * $row['product_price'];
    }
    return $total;
}
?>

<?php include('layout/header.php'); ?>

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
        <?php
        // Reset the pointer and fetch the results again for display
        $stmt->execute();
        $order_detail = $stmt->get_result();
        while ($row = $order_detail->fetch_assoc()) { ?>
            <tr>
                <td>
                    <div class="product-info">
                        <img src="assets/imgs/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>">
                        <div>
                            <p class="mt-3"><?php echo $row['product_name']; ?></p>
                        </div>
                    </div>
                </td>
                <td>
                    <span>$ <?php echo $row['product_price']; ?></span>
                </td>
                <td>
                    <span><?php echo $row['product_quantity']; ?></span>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php if ($order_status == "Not Paid") { ?>
        <form style="float:right;" method="POST" action="payment.php">
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
            <input type="hidden" name="order_total_price" value="<?php echo $order_total_price; ?>">
            <input type="hidden" name="order_status" value="<?php echo $order_status; ?>">
            <input type="submit" name="order_pay_btn" class="btn btn-primary" value="Pay Now">
        </form>
    <?php } ?>
</section>

<?php include('layout/footer.php'); ?>
