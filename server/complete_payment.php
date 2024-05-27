<?php
session_start();
include('connection.php');

if (isset($_GET['id_transaksi'])) {
    $id_transaksi = $_GET['id_transaksi'];
    $order_status = "LUNAS";
    $kode_unik = $_GET['kode_unik'];

    // Change the order status to paid
    $query_change_order_status = "UPDATE transaksi SET Status_Pembayaran = ?, Kode_Pengambilan = ? WHERE ID_Transaksi = ?";

    $stmt_change_order_status = $conn->prepare($query_change_order_status);
    $stmt_change_order_status->bind_param('ssi', $order_status, $kode_unik, $id_transaksi);
    $stmt_change_order_status->execute();

    // Go to user account
    header('location: ../account.php?payment_message=Paid successfully, thanks for your shopping with us');
} else {
    header('location: ../index.php');
    exit;
}
?>
