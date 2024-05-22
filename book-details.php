<?php
    session_start();
    include('server/connection.php');

    $is_logged_in = isset($_SESSION['logged_in']);

    if (isset($_GET['id_buku'])) {
        $book_id = $_GET['id_buku'];

        $query = "SELECT * FROM buku WHERE ID_Buku = '$book_id'";

        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        $judul = $row['Judul_Buku'];
        $pengarang = $row['Pengarang'];
        $penerbit = $row['Penerbit'];
        $genre = $row['Kategori_Buku'];
        $jenis = $row['Jenis_Buku'];
        $tahun = $row['Tahun_Terbit'];
        $harga = $row['Harga_Buku'];
        $sampul = $row['Sampul_Buku'];
        $desc  = $row['Deskripsi'];
        $status = $row['Status'];

    } else {
        // no product id was given
        header('location: index.php');
    }
?>
<?php
    include('layouts/header.php');
?>

    <nav class="mt-4 rounded" aria-label="breadcrumb">
        <ol class="breadcrumb container px-3 py-2 rounded mb-4">
            <div class="breadcrumb_item">
                <a href="index.php">Home</a>
                <a>></a>
                <a href="books.php">Books</a>
                <a>></a>
                <span><?php echo $judul?></span>
            </div>
        </ol>
    </nav>

    <section class="details section--lg">
        <div class="details__container container grid">
            <div class="details__group">
                <img src="img/product/<?php echo $sampul?>" alt="" class="details__img">
            </div>
            <div class="details__group">
                 <h3 class="details__title"><?php echo $judul?></h3>
                 <p style="color: #F3860B">Category <span style="color: black"><?php echo $jenis?></span></p>

                 <div class="details__price flex">
                    <span class="new__price">Rp. <?php echo $harga?></span>
                 </div>

                <p class="short__description">
                <?php echo $desc?>
                </p>

                <ul class="product__list">
                    <li class="list__item flex">
                        <span class="info"><strong>Author </strong></span>
                        <span class="info"><strong>Publisher </strong></span>
                    </li>
                    <li class="list__item flex">
                        <span class="info"><?php echo $pengarang?></span>
                        <span class="info"><?php echo $penerbit?></span>
                    </li>
                    <li class="list__item flex">
                        <span class="info"><strong>Year Released</strong></span>
                        <span class="info"><strong>Genre </strong></span>
                    </li>
                    <li class="list__item flex">
                        <span class="info"><?php echo $tahun?></span>
                        <span class="info"><?php echo $genre?></span>
                    </li>
                </ul>
                <?php if ($status == 'Tersedia'): ?>
                    <?php if ($is_logged_in): ?>
                        <form method="POST" action="shopping-cart.php" class="d-inline">
                            <input type="hidden" name="book_id" value="<?= $book_id; ?>">
                            <input type="hidden" name="book_title" value="<?= $judul; ?>">
                            <input type="hidden" name="book_price" value="<?= $harga; ?>">
                            <input type="hidden" name="book_image" value="<?= $sampul; ?>">
                            <input type="hidden" name="book_type" value="<?= $jenis; ?>">
                            <input type="hidden" name="product_quantity" value="1">
                            <button type="submit" class="btn-add-to-cart" name="sewa"><i class="fa-solid fa-cart-shopping"></i>Add to cart</button>
                        </form>
                    <?php else: ?>
                        <button type="button" class="btn-add-to-cart" data-toggle="modal" data-target="#loginModal"><i class="fa-solid fa-cart-shopping"></i>Add to cart</button>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="books.php">
                        <button type="button" class="btn btn-outline-danger button-icon"><i class="fa-solid fa-circle-exclamation"></i>Unavailable</button>
                    </a>
                <?php endif; ?>            
            </div>
        </div>
    </section>

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