<?php
ob_start();
session_start();
include('layouts/header.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit;
}

if (isset($_GET['book_id'])) {
    $id_buku = $_GET['book_id'];

    $query_delete_buku = "DELETE FROM buku WHERE ID_Buku = ?";

    $stmt_delete_buku = $conn->prepare($query_delete_buku);

    $stmt_delete_buku->bind_param('s', $id_buku);

    if ($stmt_delete_buku->execute()) {
        header('location: products.php?success_delete_message=Book has been deleted successfully');
        exit;
    } else {
        header('location: products.php?fail_delete_message=Failed to delete book');
        exit;
    }
}

include('layouts/footer.php');
