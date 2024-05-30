<?php
    include('server/controller_products.php');
    include('layouts/header.php');
?>


<!-- Promo Section Begin -->
<section class="home" id="home">
    <div class="row">
        <div class="content">
            <h3 >Welcome To<br><span>Pitimoss Smart Library</span></h3>
            <p>With enormous set of books, explore the magical world of books</p>
            <a href="books.php"><button class="btn btn" style="background-color: #F3860B; color:white">Rent now</button></a>
        </div>
        <div class="swiper books-slider">
            <div class="swiper-wrapper">
                <a href="book-details.php?id_buku=B05" class="swiper-slide"><img src="/img/product/Laskar Pelangi.jpg" alt=""></a>
                <a href="book-details.php?id_buku=B04" class="swiper-slide"><img src="/img/product/Dune.jpg" alt=""></a>
                <a href="book-details.php?id_buku=B07" class="swiper-slide"><img src="/img/product/bumi manusia.jpg" alt=""></a>
                <a href="book-details.php?id_buku=B03" class="swiper-slide"><img src="/img/product/Metamorfosis.jpg" alt=""></a>
                <a href="book-details.php?id_buku=B02" class="swiper-slide"><img src="/img/product/Haji Murad.jpg" alt=""></a>
            </div>
        </div>
    </div>
</section>
<!-- Promo Section End -->
<!-- About us section Begin-->
<div class="about">

        <div class="about_image">
            <img src="img/about/about.jpg">
        </div>
        <div class="about_tag">
            <h1>About Us</h1>
            <p>
            PITIMOSS Fun Library is a modern library or more familiarly known as a "Taman Bacaan". 
            It was founded because of the founder's love for the world of reading and books to encourage a love for books and reading
            hobbies to be transmitted to all levels of society, because they are very aware of the importance of habits 
            reading in improving the quality of life of the nation, especially the younger generation. By making it easier to access 
            an adequate collection of books for anyone without restrictions on age, class, place and so on.
            </p>
            <a href="about.php" class="about_btn">Learn More</a>
        </div>

    </div>
<!-- About us section End -->

<!-- Facilities Section Begin -->
<section class="facilities">
    <h1>Our Facilities</h1>
    <p>Some of our facilities we can offer for you</p>

    <div class="row">
        <div class="facilities-col">
            <img src="img/about/ruang_baca.png">
            <h3>Ruang Baca</h3>
            <p class="about_story">Designed for maximum comfort, our Reading Room is an oasis for book lovers. 
                Enjoy the tranquil and conducive atmosphere, perfect for immersing yourself in the pages of a book or spending time with your favorite magazines. 
                Comfortable seating and proper lighting enhance your reading experience.</p>
        </div>
        <div class="facilities-col">
            <img src="img/about/ruang_pajang.jpg">
            <h3>Ruang Pajang</h3>
            <p class="about_story">Explore the world through our extensive book collection. 
                Our Display Area showcases a wide range of titles and genres for you to choose from. 
                From captivating fiction to educational non-fiction, each book becomes a new window to knowledge and inspiration.</p>
        </div>
        <div class="facilities-col">
            <img src="img/about/sewa_buku.jpeg">
            <h3>Penyewaan Buku</h3>
            <p class="about_story">Experience the freedom to bring home inspiration. With our Book Rental service, you can enjoy selected books without having to purchase them. 
                Choose, borrow, and read at home at a very affordable cost. The easy rental process and continuously updated collection make every visit refreshing.</p>
        </div>
    </div>
</section>
    <!-- Facilities Section End -->

<!-- Books Featured Begin -->
<div class="featured_boks">
        <h1>Featured Books</h1>
        <div class="featured_book_box">
        <?php while($row = $fav_books->fetch_assoc()) { ?>
            <div class="card featured_book_card">
                <div class="featurde_book_img">
                    <img src="img/product/<?php echo $row['Sampul_Buku']; ?>">
                </div>

                <div class="featurde_book_tag">
                    <h2 class="text-truncate"><?php echo $row['Judul_Buku']?></h2>
                    <p class="writer"><?php echo $row['Pengarang']?></p>
                    <p class="kategori"><?php echo $row['Kategori_Buku']?></p>
                    <p class="book_price"><?php echo "Rp. " . number_format($row['Harga_Buku']);?></p>
                    <a href="<?php echo "book-details.php?id_buku=" . $row['ID_Buku']; ?>"><button class="btn btn" style="background-color: #F3860B; color:white">Details</button></a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <!-- Books Featured End -->

    <!-- Comics Featured Begin -->
    <div class="featured_boks">
        <h1>Featured Comics</h1>
        <div class="featured_book_box">
        <?php while($row = $fav_comics->fetch_assoc()) { ?>
            <div class="card featured_book_card">
                <div class="featurde_book_img">
                    <img src="img/product/<?php echo $row['Sampul_Buku']; ?>">
                </div>

                <div class="featurde_book_tag">
                    <h2><?php echo $row['Judul_Buku']?></h2>
                    <p class="writer"><?php echo $row['Pengarang']?></p>
                    <p class="kategori"><?php echo $row['Kategori_Buku']?></p>
                    <p class="book_price"><?php echo "Rp. " . number_format($row['Harga_Buku']);?></p>
                    <a href="<?php echo "book-details.php?id_buku=" . $row['ID_Buku']; ?>"><button class="btn btn" style="background-color: #F3860B; color:white">Details</button></a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <!-- Comics Featured End -->

    <!-- Instagram Section Begin -->
    <section class="instagram spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="instagram__pic">
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-1.jpg"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-2.jpg"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-3.jpg"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-4.jpg"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-5.jpg"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-6.jpg"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="instagram__text">
                        <h2>Instagram</h2>
                        <p>Visit our Instagram to get the latest and interesting information regarding our book collections.</p>
                        <h3>#Salam_Literasi</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Instagram Section End -->

<?php 
    include ('layouts/footer.php'); 
?>