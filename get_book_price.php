
<?php
include('server/connection.php');

if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    $query = "SELECT harga_buku FROM buku WHERE ID_Buku = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $book_id);
    $stmt->execute();
    $stmt->bind_result($harga_buku);
    $stmt->fetch();

    echo json_encode(['harga_buku' => $harga_buku]);
    $stmt->close();
}
?>
