<?php
session_start();
?>

<?php
include('layouts/header.php');
?>

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Check Out</h4>
                    <div class="breadcrumb__links">
                        <a href="index.php">Home</a>
                        <a href="books.php">Books</a>
                        <a href="shopping-cart.php">Shopping Cart</a>
                        <span>Payment</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <div class="row">
                <div class="col-lg-8 col-md-6">
                    <div class="checkout__input">
                        <h6 class="coupon__code"><span><i class="fa-solid fa-calendar"></i></span>
                        <?php if (isset($_GET['order_status']) && $_GET['order_status'] == "extend") { ?>
                            Return Date: <span><?php echo $_SESSION['new_return_date']; ?></span>
                        <?php } else { ?>
                            Return Date: <span><?php echo $_SESSION['return_date']; ?></span>
                        <?php } ?>
                        </h6>

                        <?php if (isset($_GET['order_status']) && $_GET['order_status'] == "extend") { ?>
                            <?php 
                            $amount = $_POST['total_price']; 
                            $id_sewa = $_POST['id_sewa']; 
                            $book_id = $_POST['book_id']; 
                            $new_return_date = $_POST['new_return_date']; 
                            ?>
                            <h6 class="checkout__title">TOTAL PAYMENT: <?php echo "Rp. " . number_format($amount); ?></h6>
                            <div id="paypal-button-container"></div>
                        <?php } else if (isset($_SESSION['total_amount']) && $_SESSION['total_amount'] != 0) { ?>
                            <?php 
                            $amount = strval($_SESSION['total_amount']); 
                            $id_transaksi = $_SESSION['id_transaksi']; 
                            ?>
                            <h6 class="checkout__title">TOTAL PAYMENT: <?php echo "Rp. " . number_format($_SESSION['total_amount']); ?></h6>
                            <div id="paypal-button-container"></div>
                        <?php } else { ?>
                            <p>You don't have an order</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Checkout Section End -->

<!-- Replace "test" with your own sandbox Business account app client ID -->
<script src="https://www.paypal.com/sdk/js?client-id=AZc7gISngCVfWIqTNzlMZRSCsd7cte4sTB4ZrK7JEJHUGO9CEALMKj4mzo5ZIe2i6DRAiOhJouUWqxXF&currency=USD"></script>

<script>
    paypal.Buttons({
        // Sets up the transaction when a payment button is clicked
        createOrder: (data, actions) => {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?php echo $amount; ?>' // Can also reference a variable or function
                    }
                }]
            });
        },
        // Finalize the transaction after payer approval
        onApprove: (data, actions) => {
            return actions.order.capture().then(function(orderData) {
                // Successful capture! For dev/demo purposes:
                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                const transaction = orderData.purchase_units[0].payments.captures[0];
                alert('Transaction ' + transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                // Redirect to complete_payment.php with id_transaksi
                <?php if (isset($_GET['order_status']) && $_GET['order_status'] == 'extend') { 
                    $_SESSION['id_sewa'] = $id_sewa;
                    $_SESSION['book_id'] = $book_id;
                    $_SESSION['new_return_date'] = $new_return_date;
                    ?>
                    window.location.href = "extend-rental.php";
                <?php } else { ?>
                    window.location.href = "server/complete_payment.php?id_transaksi=" + <?php echo $id_transaksi; ?>
                    + "&kode_unik=" + transaction.id;
                <?php } ?>
            });
        }
    }).render('#paypal-button-container');
</script>

<?php
include('layouts/footer.php');
?>
