<?php
session_start();
include('server/connection.php');

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

// Memastikan data yang diperlukan ada dalam sesi
if (isset($_SESSION['id_sewa']) && isset($_SESSION['book_id']) && isset($_SESSION['new_return_date'])) {
    $id_sewa = $_SESSION['id_sewa'];
    $book_id = $_SESSION['book_id'];
    $new_return_date = $_SESSION['new_return_date'];

    // Mengambil data tanggal kembali sewa dari database
    $query_sewa = "SELECT Tanggal_Kembali, ID_transaksi FROM sewa WHERE ID_Sewa = ?";
    $stmt_sewa = $conn->prepare($query_sewa);
    $stmt_sewa->bind_param('i', $id_sewa);
    $stmt_sewa->execute();
    $result_sewa = $stmt_sewa->get_result();

    $sewa = $result_sewa->fetch_assoc();

    if (!$sewa) {
        header('location: account.php?error=Failed to fetch sewa data');
        exit;
    }

    $old_return_date = new DateTime($sewa['Tanggal_Kembali']);
    $new_return_date_obj = new DateTime($new_return_date);

    if ($new_return_date_obj <= $old_return_date) {
        header('location: account.php?error=New return date must be later than the old return date');
        exit;
    }

    $interval = $old_return_date->diff($new_return_date_obj);
    $days_extended = $interval->days;

    // Mengambil data harga buku dari database
    $query_buku = "SELECT Harga_Buku FROM buku WHERE ID_Buku = ?";
    $stmt_buku = $conn->prepare($query_buku);
    $stmt_buku->bind_param('s', $book_id);
    $stmt_buku->execute();
    $result_buku = $stmt_buku->get_result();
    $buku = $result_buku->fetch_assoc();

    if (!$buku) {
        header('location: account.php?error=Failed to fetch buku data');
        exit;
    }

    $harga_buku = $buku['Harga_Buku'];

    // Menghitung biaya tambahan berdasarkan jumlah hari perpanjangan
    $additional_cost = $days_extended * $harga_buku;

    // Memperbarui tanggal kembali di tabel sewa
    $query_update_sewa = "UPDATE sewa SET Tanggal_Kembali = ? WHERE ID_Sewa = ?";
    $stmt_update_sewa = $conn->prepare($query_update_sewa);
    $stmt_update_sewa->bind_param('si', $new_return_date, $id_sewa);
    if (!$stmt_update_sewa->execute()) {
        header('location: account.php?error=Failed to update sewa');
        exit;
    }

    // Perbarui total harga di tabel transaksi untuk transaksi tertentu
    $query_update_transaksi = "UPDATE transaksi SET Total_harga = Total_harga + ? WHERE ID_transaksi = ?";
    $stmt_update_transaksi = $conn->prepare($query_update_transaksi);
    $stmt_update_transaksi->bind_param('di', $additional_cost, $sewa['ID_transaksi']);
    if (!$stmt_update_transaksi->execute()) {
        header('location: account.php?error=Failed to update transaksi');
        exit;
    }

    // Redirect ke halaman akun dengan pesan sukses
    header('location: account.php?success=Return date extended successfully');
    exit;
} else {
    // Jika data sesi tidak ditemukan, arahkan kembali dengan pesan kesalahan
    header('location: account.php?error=Invalid request');
    exit;
}
