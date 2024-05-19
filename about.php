<?php
include('layouts/header.php');
?>

<body>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">About Us</h1>
        <nav class="mt-4 rounded" aria-label="breadcrumb">
            <ol class="breadcrumb px-3 py-2 rounded mb-4">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">About Us</li>
            </ol>
        </nav>
        <!-- Page Heading End-->

        <!-- Card About Strat-->

        <!-- Carousel Strat-->
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/blog/blog-6.jpg" class="d-block" width="100%" height="300px" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="img/blog/blog-7.jpg" class="d-block" width="100%" height="300px" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="img/blog/blog-8.jpg" class="d-block" width="100%" height="300px" alt="...">
                </div>
            </div>
        </div>
        <!-- Carousel End-->
        <br>
        <br>

        <!-- Card Fitur Strat-->
        <div class="card mb-5 border-0">
            <div class="card-group justify-content-md-center">
                <div class="card mb-3 border-0" style="max-width: 300px;">
                    <div class="card text-center border-0" style="width: auto;">
                        <img src="img/product/Ronggeng Dukuh Paruk.jpg" class="img-fluid rounded-circle" style="width: 150px; height: 150px; align-self: center;">
                        <div class="card-body">
                            <h4 class="card-text">List Book</h4>
                            <p class="card-text">Explore our book collection and discover a fascinating world of knowledge. Check out our book list now!</p>
                            <a href="#" class="btn btn-primary">Go to lits Book</a>
                        </div>
                    </div>
                </div>
                <div class="card mb-3 border-0" style="max-width: 300px;">
                    <div class="card text-center border-0" style="width: auto;">
                        <img src="img/product/Putri Kedua.jpg" class="img-fluid rounded-circle" style="width: 150px; height: 150px; align-self: center;">
                        <div class="card-body">
                            <h4 class="card-title">Recommend Book</h4>
                            <p class="card-text">Check out this week's recommended books! Explore captivating stories and expand your reading list. Don't miss out!</p>
                            <a href="#" class="btn btn-primary">Go to Recomend Book</a>
                        </div>
                    </div>
                </div>
                <div class="card mb-3 border-0" style="max-width: 300px;">
                    <div class="card text-center border-0" style="width: auto;">
                        <img src="img/book2.PNG" class="img-fluid rounded-circle" style="width: 150px; height: 150px; align-self: center;">
                        <div class="card-body">
                            <h4 class="card-title">Check Out</h4>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go to Check Out</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card Fitur End-->

            <div class="card-body">
                <hr>
                <div class="row p-5">
                    <div class="col-md-7 align-self-center">
                        <h2>ABOUT PITIMOSS </h2>
                        <h4 class="text-secondary">"We are not just renting books, we are building a reading culture for the children of our nation."</h4>
                        <br>
                        <p class="text-secondary">
                            PITIMOSS Fun Library, also known as a reading park, was founded with a passion for books and a mission
                            to promote reading among all segments of society. It offers affordable and accessible books to people of all ages,
                            backgrounds, and locations. Established in 2003, PITIMOSS has grown rapidly through continuous innovation and the use
                            of modern technology.It aims to make reading a widely embraced and cost-effective habit.
                        </p>
                    </div>
                    <div class="col-md-5">
                        <img src="img/loginbg.png" width="500" height="500">
                    </div>
                </div>
                <hr>
                <div class="row p-5">
                    <div class="col-md-5">
                        <img src="img/book1.PNG" width="500" height="500">
                    </div>
                    <div class="col-md-7 align-self-center">
                        <h2>THE PIONEERS</h2>
                        <h4 class="text-secondary">"Making Reading a Pleasurable and Affordable Habit."</h4>
                        <br>
                        <p class="text-secondary">
                            PITIMOSS was founded by four close friends with diverse academic backgrounds, based on a foundation of kinship and consensus,
                            driven by modern management principles and professionalism. The founders are Yosrizal Sandra, Yusra Hamdi, Andi Sinaga, and Yulio Ferinaldo.
                        </p>
                    </div>
                </div>
                <hr>
                <div class="row p-5">
                    <div class="col-md-7 align-self-center">
                        <h2>THE CONCEPT</h2>
                        <h4 class="text-secondary">"Where Books Come Alive, and Readers Find Home."</h4>
                        <br>
                        <p class="text-secondary">
                        PITIMOSS is not just a reading park; it is an entertaining and comfortable haven with friendly and family-like service, 
                        making it a second home for book lovers. We constantly innovate in every aspect to ensure that PITIMOSS remains an integral part of the 
                        lives of book enthusiasts. Step into PITIMOSS and embark on a captivating literary journey where imagination knows no bounds. 
                        Let the pages come alive and the stories transport you to new worlds. Experience the joy of reading in a vibrant and welcoming atmosphere. 
                        Join us at PITIMOSS and let your love for books thrive in a place that feels like home.
                    </div>
                    <div class="col-md-5">
                        <img src="img/about/pitimoss-fun-library.jpg" width="500" height="500">
                    </div>
                </div>
            </div>
        </div>
        <!-- Card About End-->


    </div>
</body>
<?php
include('layouts/footer.php');
?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="js/bootstrap.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>