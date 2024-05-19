<?php
    include('server/connection.php');

    $booksPerPage = 10;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $offset = ($page - 1) * $booksPerPage;

    $totalBooksQuery = "SELECT COUNT(*) as total FROM buku";
    $totalBooksResult = $conn->query($totalBooksQuery);
    $totalBooksRow = $totalBooksResult->fetch_assoc();
    $totalBooks = $totalBooksRow['total'];

    $totalPages = ceil($totalBooks / $booksPerPage);

    $start = $offset + 1;
    $end = min(($offset + $booksPerPage), $totalBooks);

    if (isset($_POST['cari'])) {
        $keyword = ucfirst(strtolower($_POST['keyword']));
        if(!empty($_POST['kategori'])){
            $category = $_POST['kategori'];
            $query = "SELECT * FROM buku WHERE kategori_buku = '$category' AND (Judul_Buku LIKE '%$keyword%' OR Pengarang LIKE '%$keyword%')";
            $bookResult = $conn->query($query);
            $books = [];
            while ($row = $bookResult->fetch_assoc()) {
                $books[] = $row;
            }
        } else{
            //Get products by search
            $query = "SELECT * FROM buku WHERE Judul_Buku LIKE '%$keyword%' OR Pengarang LIKE '%$keyword%'";
            $bookResult = $conn->query($query);
            $books = [];
            while ($row = $bookResult->fetch_assoc()) {
                $books[] = $row;
            }
        }
    } else {
        //Get all products
        $query = "SELECT * FROM buku LIMIT $booksPerPage OFFSET $offset";
        $bookResult = $conn->query($query);
        $books = [];
        while ($row = $bookResult->fetch_assoc()) {
            $books[] = $row;
        }
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
    <form method="POST" action="books.php">
        <div class="inner-form">
        <div class="input-field first-wrap">
            <div class="input-select flex">
            <select class="choices-single-default" name="kategori">
                <option placeholder="">Category</option>
                <?php foreach ($categories as $category) : ?>
                <option><?php echo $category?></option>
                <?php endforeach; ?>
            </select>
            </div>
        </div>
        <div class="input-field second-wrap">
            <input id="search" name="keyword" type="text" placeholder="Enter Keywords?" />
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
            <h5>Showing <strong><?= $start; ?>-<?= $end; ?></strong> out of <strong><?= $totalBooks; ?></strong> books</h5>
        </div>
    </div>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php foreach ($books as $book) : ?>
                <div class="col mb-4">
                    <div class="card h-100 border-0 shadow book-card">
                        <img src="img/product/<?= $book["Sampul_Buku"]; ?>" class="card-img-top fixed-size" alt="...">
                        <div class="card-body">
                            <h5 class="card-title text-truncate"><?= $book["Judul_Buku"]; ?></h5>
                            <span class="badge bg-warning"><?= $book["Kategori_Buku"]; ?></span>
                            <h6>Rp <?= number_format($book["Harga_Buku"]); ?></h6>
                            <p class="card-text text-truncate"><?= $book["Pengarang"]; ?></p>
                            <a href="<?php echo "book-details.php?id_buku=" . $book['ID_Buku']; ?>" class="btn btn-primary btn-sm">Book Details</a>
                            <a href="buy.php?id=<?= $book["ID_Buku"]; ?>" class="btn btn-outline-info btn-sm">Rent Now</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination Links -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    <!-- Display Book End -->

<?php
    include('layouts/footer.php');
?>