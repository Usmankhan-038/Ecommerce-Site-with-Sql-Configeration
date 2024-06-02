<?php
session_start();
include('server/connection.php');

if (isset($_POST['add_to_cart'])) {
    if (isset($_SESSION['cart'])) {
        $product_array_id = array_column($_SESSION['cart'], 'product_id');
        if (!in_array($_POST['product_id'], $product_array_id)) {
            $count = count($_SESSION['cart']);
            $product_array = array(
                'product_id' => $_POST['product_id'],
                'product_name' => $_POST['product_name'],
                'product_price' => $_POST['product_price'],
                'product_image' => $_POST['product_image'],
                'product_quantity' => $_POST['product_quantity']
            );
            $_SESSION['cart'][$count] = $product_array;
        } else {
            echo '<script>alert("Product is already added to cart")</script>';
        }
    } else {
        $product_array = array(
            'product_id' => $_POST['product_id'],
            'product_name' => $_POST['product_name'],
            'product_price' => $_POST['product_price'],
            'product_image' => $_POST['product_image'],
            'product_quantity' => $_POST['product_quantity']
        );
        $_SESSION['cart'][0] = $product_array;
    }
} else if (isset($_POST['remove_product'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['product_id'] == $_POST['product_id']) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }
} else if (isset($_POST['edit'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['product_id'] == $_POST['product_id']) {
            $_SESSION['cart'][$key]['product_quantity'] = $_POST['product_quantity'];
        }
    }
}

function calculateTotalCart() {
    $total = 0;
    $total_quantity = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $value) {
            $total += $value['product_quantity'] * $value['product_price'];
            $total_quantity += $value['product_quantity'];
        }
    }
    $_SESSION['total'] = $total;
    $_SESSION['quantity'] = $total_quantity;
}

calculateTotalCart();
?>

<?php include('layout/header.php') ?>

<!-- Cart -->
<section class="cart container my-5 py-5">
    <div class="container mt-5">
        <h2 class="font-weight-bold">Your Cart</h2>
        <hr>
    </div>
    <table class="mt-5 pt-5">
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
        <?php if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $value) { ?>
                <tr>
                    <td>
                        <div class="product-info">
                            <img src="assets/imgs/<?php echo $value['product_image']; ?>" />
                            <div>
                                <p><?php echo $value['product_name']; ?></p>
                                <small><span>$</span><?php echo $value['product_price']; ?></small>
                                <br>
                                <form method="POST" action="cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>" />
                                    <input type="submit" name="remove_product" class="remove-btn" value="Remove" />
                                </form>
                            </div>
                        </div>
                    </td>
                    <td>
                        <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>" />
                            <input type="number" name="product_quantity" value="<?php echo $value['product_quantity']; ?>" min="1" />
                            <input type="submit" name="edit" class="edit-btn" value="Edit" />
                        </form>
                    </td>
                    <td>
                        <span>$</span>
                        <span class="product-price"><?php echo $value['product_quantity'] * $value['product_price']; ?></span>
                    </td>
                </tr>
        <?php }
        } ?>
    </table>
    <div class="cart-total">
        <table>
            <tr>
                <td>Total</td>
                <td><span>$</span><?php echo $_SESSION['total']; ?></td>
            </tr>
        </table>
    </div>
    <div class="checkout-container">
        <form method="POST" action="checkout.php">
            <input type="submit" class="btn checkout-btn" value="Checkout" name="checkout">
        </form>
    </div>
</section>

<!-- Footer -->
<?php include('layout/footer.php') ?>
