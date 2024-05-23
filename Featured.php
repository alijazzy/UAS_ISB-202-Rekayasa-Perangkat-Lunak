<?php
include('server/connection.php');

//Get Book by category novel
$query_novel = "SELECT * FROM sewa JOIN buku ON sewa.ID_Buku = buku.ID_Buku WHERE buku.Jenis_Buku = 'Novel'";

$stmt_novel = $conn->prepare($query_novel);
$stmt_novel->execute();
$Novel = $stmt_novel->get_result();

//Get Book by category Comic
$query_komik = "SELECT * FROM sewa JOIN buku ON sewa.ID_Buku = buku.ID_Buku WHERE buku.Jenis_Buku = 'Komik'";

$stmt_komik = $conn->prepare($query_komik);
$stmt_komik->execute();
$Komik = $stmt_komik->get_result();

// Mengambil kategori buku pada database
$query_books = "SELECT DISTINCT Kategori_Buku FROM buku";

$stmt_books = $conn->prepare($query_books);
$stmt_books->execute();
$book_categ = $stmt_books->get_result();

$categories = [];
while ($row = $book_categ->fetch_assoc()) {
    $categories[] = $row['Kategori_Buku'];
}
?>

<?php
include('layouts/header.php');
?>
<!-- Breadcrumb Section Begin -->
<nav class="mt-4 rounded" aria-label="breadcrumb">
    <ol class="breadcrumb container px-3 py-2 rounded mb-4">
        <div class="breadcrumb_item">
            <a href="index.php">Home</a>
            <a>></a>
            <span>Featured</span>
        </div>
    </ol>
</nav>
<!-- Breadcrumb Section End -->

<!-- Display Book Begin -->
<div class="container mb-5">
    <!-- Featured Book Begin -->
    <div class="grid gap-3 p-4">
        <h2>Recomended Books</h2>
        <div class="row row-cols-1 row-cols-md-4 g-4 p-4">
            <?php foreach ($Novel as $novel) : ?>
                <div class="col mb-4">
                    <div class="card h-100 border-0 shadow book-card">
                        <img src="img/product/<?= $novel["Sampul_Buku"]; ?>" class="card-img-top fixed-size" alt="...">
                        <div class="card-body">
                            <h5 class="card-title text-truncate"><?= $novel["Judul_Buku"]; ?></h5>
                            <span class="badge bg-warning"><?= $novel["Kategori_Buku"]; ?></span>
                            <h6>Rp <?= number_format($novel["Harga_Buku"]); ?></h6>
                            <p class="card-text text-truncate"><?= $novel["Pengarang"]; ?></p>
                            <a href="<?php echo "book-details.php?id_buku=" . $novel['ID_Buku']; ?>" class="btn btn-primary btn-sm">Book Details</a>
                            <a href="buy.php?id=<?= $novel["ID_Buku"]; ?>" class="btn btn-outline-info btn-sm">Rent Now</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Featured Book End-->

    <!-- Featured Komik Begin -->
    <div class="grid gap-3 p-4">
        <h2>Recomended Comics</h2>
        <div class="row row-cols-1 row-cols-md-4 g-4 p-4">
            <?php foreach ($Komik as $komik) : ?>
                <div class="col mb-4">
                    <div class="card h-100 border-0 shadow book-card">
                        <img src="img/product/<?= $komik["Sampul_Buku"]; ?>" class="card-img-top fixed-size" alt="...">
                        <div class="card-body">
                            <h5 class="card-title text-truncate"><?= $komik["Judul_Buku"]; ?></h5>
                            <span class="badge bg-warning"><?= $komik["Kategori_Buku"]; ?></span>
                            <h6>Rp <?= number_format($komik["Harga_Buku"]); ?></h6>
                            <p class="card-text text-truncate"><?= $komik["Pengarang"]; ?></p>
                            <a href="<?php echo "book-details.php?id_buku=" . $komik['ID_Buku']; ?>" class="btn btn-primary btn-sm">Book Details</a>
                            <a href="buy.php?id=<?= $komik["ID_Buku"]; ?>" class="btn btn-outline-info btn-sm">Rent Now</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Featured Komik End-->

</div>
<!-- Display Book End -->