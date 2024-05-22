<?php
include('server/connection.php');

if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    $query = "SELECT buku.harga_buku, denda.harga_denda FROM buku 
              LEFT JOIN denda ON buku.ID_Buku = denda.ID_Buku 
              WHERE buku.ID_Buku = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(['harga_buku' => 0, 'harga_denda' => 0]);
    }
}
