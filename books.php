<?php
session_start();
include('server/connection.php');

// Cek sesi login
$is_logged_in = isset($_SESSION['logged_in']);

$booksPerPage = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $booksPerPage;

$keyword = isset($_GET['keyword']) ? ucfirst(strtolower(trim($_GET['keyword']))) : '';
$category = isset($_GET['kategori']) ? $_GET['kategori'] : '';

$conditions = [];
if (!empty($category)) {
    $conditions[] = "kategori_buku = '$category'";
}
if (!empty($keyword)) {
    $conditions[] = "(Judul_Buku LIKE '%$keyword%' OR Pengarang LIKE '%$keyword%')";
}

$whereClause = '';
if (!empty($conditions)) {
    $whereClause = 'WHERE ' . implode(' AND ', $conditions);
}

// Hitung total buku sesuai kriteria pencarian
$totalBooksQuery = "SELECT COUNT(*) as total FROM buku $whereClause";
$totalBooksResult = $conn->query($totalBooksQuery);
$totalBooksRow = $totalBooksResult->fetch_assoc();
$totalBooks = $totalBooksRow['total'];

$totalPages = ceil($totalBooks / $booksPerPage);

$start = $offset + 1;
$end = min(($offset + $booksPerPage), $totalBooks);

$query = "SELECT * FROM buku $whereClause LIMIT $booksPerPage OFFSET $offset";
$bookResult = $conn->query($query);

$books = [];
while ($row = $bookResult->fetch_assoc()) {
    $books[] = $row;
}

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
            <span>Books</span>
        </div>
    </ol>
</nav>
<!-- Breadcrumb Section End -->

<!-- Search Bar Begin -->
<div class="container s003">
    <form id="searchForm" method="GET" action="books.php">
        <div class="inner-form">
            <div class="input-field first-wrap">
                <div class="input-select">
                    <select class="choices-single-default" name="kategori" onchange="document.getElementById('searchForm').submit()">
                        <option value="">Category</option>
                        <?php foreach ($categories as $cat) : ?>
                            <option value="<?php echo $cat; ?>" <?php echo ($cat == $category) ? 'selected' : ''; ?>><?php echo $cat; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="input-field second-wrap">
                <input id="search" name="keyword" type="text" placeholder="Enter Keywords?" value="<?= htmlspecialchars($keyword); ?>" />
            </div>
            <div class="input-field third-wrap">
                <button class="btn-search" type="submit" name="cari">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </div>
    </form>
</div>
<!-- Search Bar End -->

<!-- Display Book Begin -->
<div class="container mb-5">
    <div class="row">
        <div class="col-12 mb-4">
            <?php if (!empty($keyword)): ?>
                <h5>Showing results for "<strong><?= htmlspecialchars($keyword); ?></strong>"</h5>
            <?php elseif (!empty($category)): ?>
                <h5>Showing results for "<strong><?= htmlspecialchars($category); ?></strong>"</h5>
            <?php else: ?>
                <h5>Showing <strong><?= $start; ?>-<?= $end; ?></strong> out of <strong><?= $totalBooks; ?></strong> books</h5>
            <?php endif; ?>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-md-4 g-4">
    <?php if (empty($books)): ?>
            <div class="col-10">
                <p class="text-center">No results found for your search.</p>
            </div>
        <?php else: ?>
        <?php foreach ($books as $book) : ?>
            <div class="col mb-4">
                <div class="card h-100 border-0 shadow book-card">
                    <img src="img/product/<?= $book["Sampul_Buku"]; ?>" class="card-img-top fixed-size" alt="...">
                    <div class="card-body">
                        <h5 class="card-title text-truncate"><?= $book["Judul_Buku"]; ?></h5>
                        <span class="badge bg-warning"><?= $book["Kategori_Buku"]; ?></span>
                        <h6>Rp <?= number_format($book["Harga_Buku"]); ?></h6>
                        <p class="card-text text-truncate"><?= $book["Pengarang"]; ?></p>
                        <a href="<?php echo "book-details.php?id_buku=" . $book['ID_Buku']; ?>" class="btn btn-outline-info btn-sm">Book Details</a>
                        <form method="POST" action="shopping-cart.php" class="d-inline">
                            <input type="hidden" name="book_id" value="<?= $book["ID_Buku"]; ?>">
                            <input type="hidden" name="book_title" value="<?= $book["Judul_Buku"]; ?>">
                            <input type="hidden" name="book_price" value="<?= $book["Harga_Buku"]; ?>">
                            <input type="hidden" name="book_image" value="<?= $book["Sampul_Buku"]; ?>">
                            <input type="hidden" name="book_type" value="<?= $book["Jenis_Buku"]; ?>">
                            <input type="hidden" name="book_genre" value="<?= $book["Kategori_Buku"]; ?>">
                            <input type="hidden" name="product_quantity" value="1">
                            <?php if ($is_logged_in): ?>
                                <?php if ($book['Status'] == 'Tersedia'): ?>
                                    <button type="submit" class="btn btn-outline btn-sm" name="sewa" style="background-color:#F3860B;color:white">Rent Now</button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-outline-danger btn-sm">Unavailable</button>
                                <?php endif; ?>
                            <?php else: ?>
                                <button type="button" class="btn btn-outline btn-sm" data-toggle="modal" data-target="#loginModal" style="background-color:#F3860B;color:white">Rent Now</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Pagination Links -->
    <?php if ($totalBooks > $booksPerPage): ?>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page - 1; ?>&kategori=<?= urlencode($category); ?>&keyword=<?= urlencode($keyword); ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?= $i; ?>&kategori=<?= urlencode($category); ?>&keyword=<?= urlencode($keyword); ?>"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page + 1; ?>&kategori=<?= urlencode($category); ?>&keyword=<?= urlencode($keyword); ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>
<!-- Display Book End -->

<!-- Login Modal -->
<div class="modal fade mt-5 pt-5" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabelDelete" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-blackness">
            <div class="modal-body text-dark text-center">
                <div class="text-light text-end">
                    <a class="btn btn-close text-light" type="button" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
            <div class="d-flex justify-content-center my-3">
                <h1 class="exclamation"><i class="fas fa-exclamation"></i></h1>
            </div>
            <div class="my-4">
                <h4>To rent a book you have to login first!</h4>
            </div>
            <div class="my-2">
                <a class="btn btn-light" data-dismiss="modal" aria-label="Close">Dismiss</a>
                <a class="btn btn" href="login.php?" style="background-color: #F3860B; color:white">Login</a>
            </div>
        </div>
    </div>
</div>
</div>

<?php
include('layouts/footer.php');
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rentButtons = document.querySelectorAll('.rent-now');
        rentButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                if (!<?php echo json_encode($is_logged_in); ?>) {
                    event.preventDefault();
                    var myModal = new bootstrap.Modal(document.getElementById('loginModal'));
                    myModal.show();
                }
            });
        });
    });

    // JavaScript untuk mereset form setelah dikirimkan
    document.getElementById('searchForm').addEventListener('submit', function() {
        setTimeout(function() {
            document.getElementById('searchForm').reset();
        }, 10);
    });
</script>
