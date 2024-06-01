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

    // Check the status of the book
    $query_check_status = "SELECT Status FROM buku WHERE ID_Buku = ?";
    $stmt_check_status = $conn->prepare($query_check_status);
    $stmt_check_status->bind_param('s', $id_buku);
    $stmt_check_status->execute();
    $result_check_status = $stmt_check_status->get_result();

    if ($result_check_status->num_rows > 0) {
        $book_status = $result_check_status->fetch_assoc()['Status'];

        if ($book_status == 'Tidak Tersedia') {
            header('location: books.php?fail_delete_message=The book cannot be deleted because it is currently rented');
            exit;
        } else {
            $query_delete_denda = "DELETE FROM denda WHERE ID_BUKU = ?";
            $stmt_delete_denda = $conn->prepare($query_delete_denda);
            $stmt_delete_denda->bind_param('s', $id_buku);

            if ($stmt_delete_denda->execute()) {
                $query_delete_buku = "DELETE FROM buku WHERE ID_Buku = ?";
                $stmt_delete_buku = $conn->prepare($query_delete_buku);
                $stmt_delete_buku->bind_param('s', $id_buku);

                if ($stmt_delete_buku->execute()) {
                    header('location: books.php?success_delete_message=Book has been deleted successfully');
                    exit;
                } else {
                    header('location: books.php?fail_delete_message=Failed to delete book');
                    exit;
                }
            } else {
                header('location: books.php?fail_delete_message=Failed to delete fine');
                exit;
            }
        }
    } else {
        header('location: books.php?fail_delete_message=Book not found');
        exit;
    }
}

include('layouts/footer.php');