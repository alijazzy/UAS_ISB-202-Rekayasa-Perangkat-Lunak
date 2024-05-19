<?php
    include('server/connection.php');

    // Number of books to display per page
    $booksPerPage = 10;

    // Get the current page number from the URL, default to 1 if not set
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    // Calculate the offset for the SQL query
    $offset = ($page - 1) * $booksPerPage;

    // Fetch the total number of books
    $totalBooksQuery = "SELECT COUNT(*) as total FROM buku";
    $totalBooksResult = $conn->query($totalBooksQuery);
    $totalBooksRow = $totalBooksResult->fetch_assoc();
    $totalBooks = $totalBooksRow['total'];

    // Calculate the total number of pages
    $totalPages = ceil($totalBooks / $booksPerPage);

    // Fetch books for the current page
    $query = "SELECT * FROM buku LIMIT $booksPerPage OFFSET $offset";
    $bookResult = $conn->query($query);
    $books = [];
    while ($row = $bookResult->fetch_assoc()) {
        $books[] = $row;
    }

    // Calculate the current range of books being displayed
    $start = $offset + 1;
    $end = min(($offset + $booksPerPage), $totalBooks);

    if (isset($_POST['search']) && isset($_POST['product_category'])) {
        //Get all products by category
        $category = $_POST['product_category'];
        $query_products = "SELECT * FROM buku WHERE kategori_buku = ?";
        $stmt_products = $conn->prepare($query_products);
        $stmt_products->bind_param('s', $category);
        $stmt_products->execute();
        $products = $stmt_products->get_result();
    } else {
        //Get all products
        $query_products = "SELECT * FROM buku";
        $stmt_products = $conn->prepare($query_products);
        $stmt_products->execute();
        $products = $stmt_products->get_result();
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
                            <a href="<?php echo "book-details.php?id_buku=" . $book['ID_Buku']; ?>" class="btn btn-primary btn-sm">Detail Buku</a>
                            <a href="buy.php?id=<?= $book["ID_Buku"]; ?>" class="btn btn-outline-info btn-sm">Beli Sekarang</a>
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

    <!-- Shop Section Begin -->
    <!-- <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <div class="shop__sidebar__search">
                            <form action="#">
                                <input type="text" placeholder="Search...">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="shop__sidebar__accordion">
                            <form method="POST" action="shop.php">
                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-heading">
                                            <a data-toggle="collapse" data-target="#collapseOne">Categories</a>
                                        </div>
                                        <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="shop__sidebar__categories">
                                                    <ul class="nice-scroll">
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="sepatu" 
                                                                    name="product_category" id="category_one " 
                                                                    <?php if (isset($product_category) && $product_category == 'sepatu') 
                                                                    { 
                                                                        echo 'checked'; 
                                                                    } ?>>
                                                                <label class="form-check-label" for="product_category">Sepatu</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="jaket" 
                                                                    name="product_category" id="category_one " 
                                                                    <?php if (isset($product_category) && $product_category == 'jaket') 
                                                                    { 
                                                                        echo 'checked'; 
                                                                    } ?>>
                                                                <label class="form-check-label" for="product_category">Jaket</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="kaos" 
                                                                    name="product_category" id="category_one " 
                                                                    <?php if (isset($product_category) && $product_category == 'kaos') 
                                                                    { 
                                                                        echo 'checked'; 
                                                                    } ?>>
                                                                <label class="form-check-label" for="product_category">Kaos</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="sepatu" 
                                                                    name="product_category" id="category_one " 
                                                                    <?php if (isset($product_category) && $product_category == 'sepatu') 
                                                                    { 
                                                                        echo 'checked'; 
                                                                    } ?>>
                                                                <label class="form-check-label" for="product_category">Sepatu</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="syal" 
                                                                    name="product_category" id="category_one " 
                                                                    <?php if (isset($product_category) && $product_category == 'syal') 
                                                                    { 
                                                                        echo 'checked'; 
                                                                    } ?>>
                                                                <label class="form-check-label" for="product_category">Syal</label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <button class="btn btn-secondary" onClick="history.go(0);">
                                                <i class="fa fa-refresh"></i>
                                            </button>
                                            <input type="submit" class="btn btn-primary" name="search" value="Search" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="shop__product__option">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__left">
                                    <p>Showing 1–12 of 126 results</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__right">
                                    <p>Sort by Price:</p>
                                    <select>
                                        <option value="">Low To High</option>
                                        <option value="">$0 - $55</option>
                                        <option value="">$55 - $100</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <?php while ($row = $products->fetch_assoc()) { ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" 
                                data-setbg="img/product/<?php echo $row['product_image1']; ?>">
                                    <ul class="product__hover">
                                        <li><a href="#"><img src="img/icon/heart.png" alt=""></a></li>
                                        <li><a href="#"><img src="img/icon/compare.png" alt=""> <span>Compare</span></a>
                                        </li>
                                        <li><a href="#"><img src="img/icon/search.png" alt=""></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><?php echo $row['product_name']; ?></h6>
                                    <h5><?php echo $row['product_brand']; ?></h5>
                                    <a href="<?php echo "shop-details.php?product_id=" . $row['product_id']; ?>" 
                                    class="add-cart">+ Add To Cart</a>
                                    <div class="rating">
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                    </div>
                                    <h5><?php echo setRupiah($row['product_price'] * $kurs_dollar); ?></h5>
                                    <div class="product__color__select">
                                        <label for="pc-4">
                                            <input type="radio" id="pc-4">
                                        </label>
                                        <label class="active black" for="pc-5">
                                            <input type="radio" id="pc-5">
                                        </label>
                                        <label class="grey" for="pc-6">
                                            <input type="radio" id="pc-6">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="product__pagination">
                                <a class="active" href="#">1</a>
                                <a href="#">2</a>
                                <a href="#">3</a>
                                <span>...</span>
                                <a href="#">21</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- Shop Section End -->

<?php
    include('layouts/footer.php');
?>