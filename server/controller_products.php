<?php
    include('connection.php');

    $query_books = "SELECT * FROM buku WHERE Jenis_Buku = 'Novel' LIMIT 8";

    $stmt_books = $conn->prepare($query_books);

    $stmt_books->execute();

    $fav_books = $stmt_books->get_result();

    $query_comics = "SELECT * FROM buku WHERE Jenis_Buku = 'Komik' LIMIT 8";

    $stmt_comics = $conn->prepare($query_comics);

    $stmt_comics->execute();

    $fav_comics = $stmt_comics->get_result();
    
?>


