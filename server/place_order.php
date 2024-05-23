<?php
session_start();
include('connection.php');
// If user is not logged in
if (!isset($_SESSION['logged_in'])) {
    header('location: ../shooping-cart.php?message=Please Login or Register to Place an Order');
    exit;

    // If user is logged in
} else {
    if (isset($_POST['checkout'])) {
        // 1. Get user info and save to the database
        $member_id = $_SESSION['member_id'];
        $total_price = $_POST['total_amount'];
        $order_date = date('Y-m-d');
        $status = "Belum Lunas";

        //Tanggal Kembali
        $return_date = $_POST['return_date'];

        //Dibuat Session
        $_SESSION['total_amount'] = $total_price;
        $_SESSION['return_date'] = $return_date;

        $query_orders = "INSERT INTO transaksi (ID_Member, Total_Harga, Tanggal_transaksi, Status_Pembayaran) 
                    VALUES (?, ?, ?, ?)";

        $stmt_orders = $conn->prepare($query_orders);
        $stmt_orders->bind_param('iiss', $member_id, $total_price, $order_date, $status);
        $stmt_status = $stmt_orders->execute();

        if (!$stmt_status) {
            header('location: ../index.php');
            exit;
        }

        // 2. Issue new order and store order info to the database
        $id_transaksi = $stmt_orders->insert_id;

        // 3. Get products from the cart
        foreach ($_SESSION['cart'] as $key => $value) {
            $books = $_SESSION['cart'][$key];
            $book_id = $books['book_id'];
            $order_date = date('Y-m-d');

            // 4. Store each single item to the order item in database
            $query_order_items = "INSERT INTO sewa (ID_Member, ID_Buku, Tanggal_Pinjam, Tanggal_Kembali) 
                        VALUES (?, ?, ?, ?)";

            $stmt_order_items = $conn->prepare($query_order_items);
            $stmt_order_items->bind_param('isss', $member_id, $book_id, $order_date, $return_date);
            $stmt_order_items->execute();

            // 4.2 Update status ketersediaan buku
            $query_update = "UPDATE buku SET Status = 'Tidak Tersedia' WHERE ID_Buku = '$book_id'";
            $result_update = mysqli_query($conn, $query_update);
        }

        // 5. Remove everything from cart --> delay until payment is done
        unset($_SESSION['cart']);

        $_SESSION['id_transaksi'] = $id_transaksi;

        // 6. Inform user whether everyhting is fine or there is a problem
        header('location: ../payment.php?order_status="placed"');
    }
}
