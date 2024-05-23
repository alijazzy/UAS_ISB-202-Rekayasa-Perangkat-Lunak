<?php
ob_start();
session_start();
include('layouts/header.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit;
}

if (isset($_GET['rent_id'])) {
    $id_sewa = $_GET['rent_id'];

    $query_delete_sewa = "DELETE FROM sewa WHERE ID_Sewa = ?";

    $stmt_delete_sewa = $conn->prepare($query_delete_sewa);

    $stmt_delete_sewa->bind_param('s', $id_sewa);

    if ($stmt_delete_sewa->execute()) {
        header('location: orders.php?success_delete_message=Rents has been deleted successfully');
        exit;
    } else {
        header('location: orders.php?fail_delete_message=Failed to delete Rents');
        exit;
    }
}

include('layouts/footer.php');
