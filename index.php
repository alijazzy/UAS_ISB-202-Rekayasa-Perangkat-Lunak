<?php
    include('server/controller_products.php');
    include('layouts/header.php');
?>


<!-- Promo Section Begin -->
<section class="home" id="home">
    <div class="row">
        <div class="content">
            <h3>Welcome To<br><span>Pitimoss Smart Library</span></h3>
            <p>With enormous set of books, explore the magical world of books</p>
            <a href="#"><button class="btn btn" style="background-color: #F3860B; color:white">Rent now</button></a>
        </div>
        <div class="swiper books-slider">
            <div class="swiper-wrapper">
                <a href="book-details.php?id_buku=B05" class="swiper-slide"><img src="/img/product/Laskar Pelangi.jpg" alt=""></a>
                <a href="book-details.php?id_buku=B04" class="swiper-slide"><img src="/img/product/Dune.jpg" alt=""></a>
                <a href="book-details.php?id_buku=B07" class="swiper-slide"><img src="/img/product/bumi manusia.jpg" alt=""></a>
                <a href="#" class="swiper-slide"><img src="/img/product/ayat-ayat cinta.jpg" alt=""></a>
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
            PITIMOSS Fun Library adalah sebuah perpustakaan modern atau lebih akrab dikenal dengan istilah taman bacaan. 
            Didirikan karna kecintaan para pendirinya terhadap dunia baca dan buku agar kecintaan terhadap buku dan kegemaran 
            membaca bisa di tularkan pada semua lapisan masyarakat karena mereka sangat menyadari akan pentingnya kebiasaan 
            membaca dalam meningkatkan kualitas hidup bangsa, khususnya generasi muda. Dengan cara memudahkan akses terhadap 
            koleksi buku yang memadai untuk siapapun tanpa dibatasi usia, golongan, tempat dan lain-lain.
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
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
        </div>
        <div class="facilities-col">
            <img src="img/about/ruang_pajang.jpg">
            <h3>Ruang Pajang</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
        </div>
        <div class="facilities-col">
            <img src="img/about/sewa_buku.jpeg">
            <h3>Penyewaan Buku</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
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
                    <p class="book_price"><?php echo $row['Harga_Buku']?></p>
                    <a href="<?php echo "book-details.php?id_buku=" . $row['ID_Buku']; ?>"><button class="btn btn" style="background-color: #F3860B; color:white">Learn More</button></a>
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
                    <p class="book_price"><?php echo $row['Harga_Buku']?></p>
                    <a href="<?php echo "book-details.php?id_buku=" . $row['ID_Buku']; ?>"><button class="btn btn" style="background-color: #F3860B; color:white">Learn More</button></a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <!-- Comics Featured End -->

    <!-- Banner Section Begin -->
    <!-- <section class="banner spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 offset-lg-4">
                    <div class="banner__item">
                        <div class="banner__item__pic">
                            <img src="img/banner/banner-1.jpg" alt="">
                        </div>
                        <div class="banner__item__text">
                            <h2>Clothing Collections 2030</h2>
                            <a href="#">Shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="banner__item banner__item--middle">
                        <div class="banner__item__pic">
                            <img src="img/banner/banner-2.jpg" alt="">
                        </div>
                        <div class="banner__item__text">
                            <h2>Accessories</h2>
                            <a href="#">Shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="banner__item banner__item--last">
                        <div class="banner__item__pic">
                            <img src="img/banner/banner-3.jpg" alt="">
                        </div>
                        <div class="banner__item__text">
                            <h2>Shoes Spring 2030</h2>
                            <a href="#">Shop now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- Banner Section End -->

    <!-- Categories Section Begin -->
    <!-- <section class="categories spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="categories__text">
                        <h2>Clothings Hot <br /> <span>Shoe Collection</span> <br /> Accessories</h2>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="categories__hot__deal">
                        <img src="img/product-sale.png" alt="">
                        <div class="hot__deal__sticker">
                            <span>Sale Of</span>
                            <h5>$29.99</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1">
                    <div class="categories__deal__countdown">
                        <span>Deal Of The Week</span>
                        <h2>Multi-pocket Chest Bag Black</h2>
                        <div class="categories__deal__countdown__timer" id="countdown">
                            <div class="cd-item">
                                <span>3</span>
                                <p>Days</p>
                            </div>
                            <div class="cd-item">
                                <span>1</span>
                                <p>Hours</p>
                            </div>
                            <div class="cd-item">
                                <span>50</span>
                                <p>Minutes</p>
                            </div>
                            <div class="cd-item">
                                <span>18</span>
                                <p>Seconds</p>
                            </div>
                        </div>
                        <a href="#" class="primary-btn">Shop now</a>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- Categories Section End -->

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
                        <p>Kunjungi instagram kami untuk mendapatkan info terbaru dan menarik terkait ketersediaan buku.</p>
                        <h3>#Salam_Literasi</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Instagram Section End -->

    <!-- Latest Blog Section Begin -->
    <!-- <section class="latest spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Latest News</span>
                        <h2>Fashion New Trends</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="img/blog/blog-1.jpg"></div>
                        <div class="blog__item__text">
                            <span><img src="img/icon/calendar.png" alt=""> 16 February 2020</span>
                            <h5>What Curling Irons Are The Best Ones</h5>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="img/blog/blog-2.jpg"></div>
                        <div class="blog__item__text">
                            <span><img src="img/icon/calendar.png" alt=""> 21 February 2020</span>
                            <h5>Eternity Bands Do Last Forever</h5>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="img/blog/blog-3.jpg"></div>
                        <div class="blog__item__text">
                            <span><img src="img/icon/calendar.png" alt=""> 28 February 2020</span>
                            <h5>The Health Benefits Of Sunglasses</h5>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- Latest Blog Section End -->

<?php 
    include ('layouts/footer.php'); 
?>