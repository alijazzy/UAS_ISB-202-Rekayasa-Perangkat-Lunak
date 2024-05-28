<?php
session_start();
include('server/connection.php');

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

if (isset($_GET['logout'])) {
    if (isset($_SESSION['logged_in'])) {
        unset($_SESSION['logged_in']);
        unset($_SESSION['member_id']);
        unset($_SESSION['member_email']);
        unset($_SESSION['member_name']);
        unset($_SESSION['member_photo']);
        unset($_SESSION['cart']);
        header('location: index.php');
        exit;
    }
}

if (isset($_POST['change_password'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_SESSION['member_email'];

    if ($password !== $confirm_password) {
        header('location: account.php?error=Password did not match');
    } else if (strlen($password) < 6) {
        header('location: account.php?error=Password must be at least 6 characters');
    } else {
        $query_change_password = "UPDATE users SET Password = ? WHERE Email = ?";

        $stmt_change_password = $conn->prepare($query_change_password);
        $stmt_change_password->bind_param('ss', md5($password), $email);

        if ($stmt_change_password->execute()) {
            header('location: account.php?success=Password has been updated successfully');
        } else {
            header('location: account.php?error=Could not update password');
        }
    }
}

// Get Orders by User Login
if (isset($_SESSION['logged_in'])) {
    $member_id = $_SESSION['member_id'];

    $query_orders = "SELECT * FROM sewa WHERE id_member = ?";

    $stmt_orders = $conn->prepare($query_orders);
    $stmt_orders->bind_param('i', $member_id);
    $stmt_orders->execute();

    $user_orders = $stmt_orders->get_result();
}

// Cara memperbaiki bug pada $total_bayar saat mengakses halaman account
if (isset($_SESSION['total'])) {
    $total_bayar = $_SESSION['total'];
}
?>

<?php
include('layouts/header.php');
?>

<!-- Your HTML content goes here -->

<nav class="mt-4 rounded" aria-label="breadcrumb">

</nav>

<!-- Breadcrumb Section Begin -->
<nav class="mt-4 rounded" aria-label="breadcrumb">
    <ol class="breadcrumb container px-3 py-2 rounded mb-4">
        <div class="breadcrumb_item">
            <a href="index.php">Home</a>
            <a>></a>
            <span>Account</span>
        </div>
    </ol>
</nav>
<!-- Breadcrumb Section End -->

<!-- Checkout Section Begin -->
<div class="container-sm mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="profile-box shadow-lg">
                <?php if (isset($_GET['message'])) { ?>
                    <div class="alert alert-info mb-4" role="alert">
                        <?php if (isset($_GET['message'])) {
                            echo $_GET['message'];
                        } ?>
                    </div>
                <?php } ?>
                <div class="d-flex align-items-center mb-4">
                    <div class="profile-img mr-4">
                        <img src="<?php echo 'img/profile/' . $_SESSION['member_photo']; ?>" alt="" class="rounded-circle">
                    </div>
                    <div class="profile-info">
                        <h3 class="mb-2"><?php if (isset($_SESSION['member_name'])) {
                                                echo $_SESSION['member_name'];
                                            } ?></h3>
                        <p class="mb-2"><i class="fas fa-map-marker-alt mr-2"></i><?php if (isset($_SESSION['member_address'])) {
                                                                                        echo $_SESSION['member_address'];
                                                                                    } ?></p>
                        <p class="mb-2"><i class="fa fa-envelope mr-2"></i><?php if (isset($_SESSION['member_email'])) {
                                                                                echo $_SESSION['member_email'];
                                                                            } ?></p>
                        <p class="mb-0"><i class="fa fa-phone mr-2"></i><?php if (isset($_SESSION['member_phone'])) {
                                                                            echo $_SESSION['member_phone'];
                                                                        } ?></p>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="#orders" class="btn btn-primary">
                        <i class="fas fa-boxes mr-2"></i>
                        YOUR RENT
                    </a>
                    <a href="index.php" id="logout-btn" class="btn btn-danger">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        LOG OUT
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Checkout Section End -->

<!-- Order History Begin -->
<section id="orders" class="shopping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <div class="alert alert-info" role="alert">
                        <?php if (isset($_GET['payment_message'])) {
                            echo $_GET['payment_message'];
                        } ?>
                    </div>
                    <h2>Your Rent History</h2>
                    <span>***</span>
                </div>
                <div class="shopping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Member ID</th>
                                <th>Book ID</th>
                                <th>Start Date</th>
                                <th>Return Date</th>
                                <th>Penalty</th>
                                <th>Invoice</th>
                                <th>Extend</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($user_orders as $order) {
                                $current_date = date("Y-m-d");
                                $return_date = $order['Tanggal_Kembali'];
                                $penalty = 0;
                                $late_days = 0;

                                if ($current_date > $return_date) {
                                    // Fetch penalty price per day from database
                                    $book_id = $order['ID_Buku'];
                                    $query_penalty = "SELECT harga_denda FROM denda WHERE ID_Buku = ?";
                                    $stmt_penalty = $conn->prepare($query_penalty);
                                    $stmt_penalty->bind_param('i', $book_id);
                                    $stmt_penalty->execute();
                                    $result_penalty = $stmt_penalty->get_result();
                                    $data_penalty = $result_penalty->fetch_assoc();

                                    $penalty_per_day = $data_penalty['harga_denda'];
                                    $late_days = (strtotime($current_date) - strtotime($return_date)) / (60 * 60 * 24);
                                    $penalty = ceil($late_days) * $penalty_per_day;
                                }
                            ?>

                                <tr>
                                    <td class="product__cart__item">
                                        <div class="product__cart__item__text">
                                            <h6><?php echo $order['ID_Sewa']; ?></h6>
                                        </div>
                                    </td>
                                    <td class="product__cart__item">
                                        <div class="product__cart__item__text">
                                            <h6><?php echo $order['ID_Member']; ?></h6>
                                        </div>
                                    </td>
                                    <td class="product__cart__item">
                                        <div class="product__cart__item__text">
                                            <h6><?php echo $order['ID_Buku']; ?></h6>
                                        </div>
                                    </td>
                                    <td class="product__cart__item">
                                        <div class="product__cart__item__text">
                                            <h5><?php echo $order['Tanggal_Pinjam']; ?></h5>
                                        </div>
                                    </td>
                                    <td class="product__cart__item">
                                        <div class="product__cart__item__text">
                                            <h5><?php echo $order['Tanggal_Kembali']; ?></h5>
                                        </div>
                                    </td>
                                    <td class="product__cart__item">
                                        <div class="product__cart__item__text">
                                            <h5><?php echo $penalty > 0 ? 'Rp' . number_format($penalty, 2, ',', '.') : 'No Penalty'; ?></h5>
                                        </div>
                                    </td>
                                    <td class="product__cart__item">
                                        <a href="struk.php?id_sewa=<?php echo $order['ID_Sewa']; ?>">
                                            <button class="btn btn-outline-info">Invoice</button>
                                        </a>
                                    </td>
                                    <td class="cart__price">
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#extendModal" data-order-id="<?php echo $order['ID_Sewa']; ?>" data-return-date="<?php echo $order['Tanggal_Kembali']; ?>" data-book-id="<?php echo $order['ID_Buku']; ?>" data-penalty="<?php echo $penalty; ?>" data-late-days="<?php echo $late_days; ?>">
                                            Extend
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Order History End -->

<!-- Extend Modal Begin -->
<div class="modal fade" id="extendModal" tabindex="-1" role="dialog" aria-labelledby="extendModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="extendModalLabel">Extend Rental Period</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="payment.php?order_status=extend">
                <div class="modal-body">
                    <input type="hidden" id="order_id" name="id_sewa">
                    <input type="hidden" id="book_id" name="book_id">
                    <div class="form-group">
                        <label for="new_return_date" class="col-form-label">New Return Date:</label>
                        <input type="date" class="form-control" id="new_return_date" name="new_return_date" required pattern="\d{4}-\d{2}-\d{2}">
                    </div>
                    <div class="form-group">
                        <label for="additional_price" class="col-form-label">Additional Price:</label>
                        <input type="text" class="form-control" id="additional_price" name="additional_price" readonly>
                    </div>
                    <div class="form-group">
                        <label for="penalty" class="col-form-label">Penalty:</label>
                        <input type="text" class="form-control" id="penalty" name="penalty" readonly>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label for="total_price" class="col-form-label">Total Price:</label>
                            <input type="text" class="form-control" id="total_price" name="total_price" readonly value="<?php echo $total_price_display; ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Extend</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Extend Modal End -->




<!-- Bootstrap core JavaScript-->
<script src="admin/vendor/jquery/jquery.min.js"></script>
<script src="admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="js/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="admin/js/sb-admin-2.min.js"></script>

<script>
    $('#extendModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var orderId = button.data('order-id');
        var returnDate = button.data('return-date');
        var bookId = button.data('book-id');
        var penalty = button.data('penalty');
        var lateDays = button.data('late-days'); // Get late days

        var modal = $(this);
        modal.find('.modal-body #order_id').val(orderId);
        modal.find('.modal-body #book_id').val(bookId);
        modal.find('.modal-body #penalty').val(penalty);
        modal.find('.modal-body #new_return_date').val(returnDate);
        modal.find('.modal-body #additional_price').val(''); // Reset harga tambahan
        modal.find('.modal-body #total_price').val(''); // Reset total price

        // Fetch book price from server
        $.ajax({
            url: 'get_book_price_and_penalty.php',
            method: 'GET',
            data: {
                book_id: bookId
            },
            success: function(response) {
                var data = JSON.parse(response);
                var rentalPricePerDay = data.harga_buku;

                // Add event listener for date change
                modal.find('.modal-body #new_return_date').on('change', function() {
                    var newReturnDate = new Date($(this).val());
                    var currentReturnDate = new Date(returnDate);

                    var additionalPrice = 0;
                    var totalPenalty = penalty;

                    if (newReturnDate > currentReturnDate) {
                        var diffTime = Math.abs(newReturnDate - currentReturnDate);
                        var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                        // Check if the new return date is at least lateDays from the original return date
                        if (diffDays < lateDays) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Invalid Extension Period',
                                text: 'You must extend the rental period for at least ' + lateDays + ' days.',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                modal.find('.modal-body #new_return_date').val(''); // Reset the date input
                            });
                            return;
                        }

                        additionalPrice = diffDays * rentalPricePerDay;

                        // Calculate total price including penalty
                        var totalPrice = additionalPrice + totalPenalty;

                        modal.find('.modal-body #additional_price').val(additionalPrice);
                        modal.find('.modal-body #total_price').val(totalPrice);
                    } else {
                        modal.find('.modal-body #additional_price').val(0);
                        modal.find('.modal-body #total_price').val(totalPenalty);
                    }
                });

                // Trigger change event to calculate the initial price
                modal.find('.modal-body #new_return_date').trigger('change');
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Fetch Error',
                    text: 'Failed to fetch book price.',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
</script>





<?php
include('layouts/footer.php');
?>