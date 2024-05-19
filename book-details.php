<?php
    include('server/connection.php');

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
                <button type="submit" class="btn-add-to-cart"><i class="fa-solid fa-cart-shopping"></i>Add to cart</button>            
            </div>
        </div>
    </section>

<?php
    include('layouts/footer.php');
?>