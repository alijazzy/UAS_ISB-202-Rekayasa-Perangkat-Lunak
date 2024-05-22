<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['sewa'])) {
    if (isset($_SESSION['cart'])) {
        $products_array_ids = array_column($_SESSION['cart'], "book_id");
        if (!in_array($_POST['book_id'], $products_array_ids)) {
            $book_id = $_POST['book_id'];

            $product_array = array(
                'book_id' => $_POST['book_id'],
                'book_title' => $_POST['book_title'],
                'book_price' => $_POST['book_price'],
                'book_image' => $_POST['book_image'],
                'book_type' => $_POST['book_type'],
                'product_quantity' => 1 // Set product quantity to 1
            );

            $_SESSION['cart'][$book_id] = $product_array;
        } else {
            echo '<script>alert("Product was already added to the cart")</script>';
        }
    } else {
        $book_id = $_POST['book_id'];
        $book_title = $_POST['book_title'];
        $book_price = $_POST['book_price'];
        $book_image = $_POST['book_image'];
        $book_type = $_POST['book_type'];

        $product_array = array(
            'book_id' => $book_id,
            'book_title' => $book_title,
            'book_price' => $book_price,
            'book_image' => $book_image,
            'book_type' => $book_type,
            'product_quantity' => 1 // Set product quantity to 1
        );

        $_SESSION['cart'][$book_id] = $product_array;
    }

    // Calculate total
    calculateTotalCart();
} else if (isset($_POST['remove_product'])) {
    $book_id = $_POST['book_id'];
    unset($_SESSION['cart'][$book_id]);
    // Calculate total
    calculateTotalCart();
} else if (isset($_POST['edit_quantity'])) {
    // We get the id from the form
    $book_id = $_POST['book_id'];
    // Set product quantity to 1, as we only have one book available
    $product_quantity = 1;

    // We get product array from the session
    $product_array = $_SESSION['cart'][$book_id];

    // Update the product quantity
    $product_array['product_quantity'] = $product_quantity;

    // Return array back its place
    $_SESSION['cart'][$book_id] = $product_array;

    // Calculate total
    calculateTotalCart();
}

function calculateTotalCart()
{
    $total_price = 0;
    $total_quantity = 0;

    foreach ($_SESSION['cart'] as $key => $value) {
        $price = $value['book_price'];
        $quantity = $value['product_quantity'];

        $total_price += ($price * $quantity);
        $total_quantity += $quantity;
    }

    $_SESSION['total'] = $total_price;
    $_SESSION['quantity'] = $total_quantity;
}

include('layouts/header.php');
?>

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="shopcart-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Shopping Cart</h4>
                    <div class="breadcrumb__links">
                        <a href="index.php">Home</a>
                        <a href="books.php">Books</a>
                        <span>Shopping Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<section class="h-300 gradient-custom">
    <div class="detil_produk py-5">
        <div class="row d-flex justify-content-center my-4">
            <div class="col-md-8">
                <div class="shopping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Sub Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($_SESSION['cart'])) { ?>
                                <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                                    <tr>
                                        <td class="product__cart__item">
                                            <div class="product__cart__item__pic">
                                                <img src="img/product/<?php echo $value['book_image']; ?>" alt="">
                                            </div>
                                            <div class="product__cart__item__text">
                                                <h6><?php echo $value['book_title']; ?></h6>
                                                <h5><?php echo $value['book_price']; ?></h5>
                                            </div>
                                        </td>
                                        <td class="quantity__item">
                                            <div class="quantity">
                                                <h6><strong><?php echo $value['book_type']; ?></strong></h6>
                                            </div>
                                        </td>
                                        <td class="cart__price">
                                            <span><?php echo $value['book_price']; ?></span>
                                        </td>
                                        <form method="POST" action="shopping-cart.php">
                                            <td style="text-align: center; vertical-align: middle;">
                                                <input type="hidden" name="book_id" value="<?php echo $value['book_id'] ?>">
                                                <button type="submit" class="btn btn-danger" name="remove_product"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </form>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <form id="checkout-form" method="POST">
                            <div class="form-group">
                                <label for="new_return_date" class="col-form-label">Choose Return Date:</label>
                                <input type="date" class="form-control" id="new_return_date" name="new_return_date" required pattern="\d{4}-\d{2}-\d{2}">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mb-4 mb-lg-0">
                    <div class="card-body">
                        <p><strong>We accept</strong></p>
                        <img class="me-2" width="45px" src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/visa.svg" alt="Visa" />
                        <img class="me-2" width="45px" src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/amex.svg" alt="American Express" />
                        <img class="me-2" width="45px" src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/mastercard.svg" alt="Mastercard" />
                        <img class="me-2" width="49px" src="img/shopping-cart/paypal.png" alt="" />
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0">Your Orders</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0"><strong>Book Title</strong></li>
                            <?php if (isset($_SESSION['cart'])) { ?>
                                <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                        <?php echo $value['book_title']; ?>
                                        <span><?php echo 'Rp. ' . number_format($value['book_price']); ?></span>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                            <div class="border-separator"></div>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                <strong>Return Date</strong>
                                <span id="return_date"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                <strong>Total Days</strong>
                                <span id="total_days"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                <div>
                                    <strong>Total Amount</strong>
                                </div>
                                <span><strong id="total_amount"></strong></span>
                            </li>
                        </ul>

                        <form id="checkoutForm" method="POST" action="server/place_order.php">
                            <input type="hidden" name="return_date" id="hidden_return_date">
                            <input type="hidden" name="total_amount" id="hidden_total_amount">
                            <button type="submit" class="btn btn-lg btn-block" style="background-color:#F3860B;color:white" name="checkout">
                                Checkout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bootstrap core JavaScript-->
<script src="admin/vendor/jquery/jquery.min.js"></script>
<script src="admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="js/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="admin/js/sb-admin-2.min.js"></script>

<script>
    document.getElementById('new_return_date').addEventListener('change', function() {
        const returnDate = new Date(this.value);
        const today = new Date();
        const diffTime = returnDate - today;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        if (diffDays > 0) {
            let totalAmount = 0;
            const bookPrices = [];
            <?php if (isset($_SESSION['cart'])) { ?>
                <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                    bookPrices.push(<?php echo $value['book_price']; ?>);
                <?php } ?>
            <?php } ?>

            bookPrices.forEach(price => {
                totalAmount += price * diffDays;
            });

            document.getElementById('return_date').innerText = this.value;
            document.getElementById('total_days').innerText = diffDays + ' days';
            document.getElementById('total_amount').innerText = 'Rp. ' + totalAmount.toLocaleString();
            document.getElementById('hidden_return_date').value = this.value;
            document.getElementById('hidden_total_amount').value = totalAmount;
        } else {
            document.getElementById('return_date').innerText = '';
            document.getElementById('total_days').innerText = '';
            document.getElementById('total_amount').innerText = '';
            document.getElementById('hidden_return_date').value = '';
            document.getElementById('hidden_total_amount').value = '';
        }
    });
</script>

<?php
include('layouts/footer.php');
?>