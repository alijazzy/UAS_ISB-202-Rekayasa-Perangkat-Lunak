<?php
include('layouts/header.php');
?>
<!-- Begin Page Content -->

    <!-- Page Heading -->
    <nav class="mt-4 rounded" aria-label="breadcrumb">
        <ol class="breadcrumb container px-3 py-2 rounded mb-4">
            <div class="breadcrumb_item">
                <a href="index.php">Home</a>
                <a>></a>
                <span>About Us</span>
            </div>
        </ol>
    </nav>

    <!-- Carousel Strat-->
    <div class="container mb-5">
    <div class="jumbotron p-3 p-md-5 text-white rounded" style="background-image: url('img/about/about.JPG'); background-size: cover;">
        <div class="col-md-6 px-0">
            <h1 class="display-4 font-italic">Pitimoss Smart Library</h1>
            <p class="lead my-3">With enormous set of books, explore the magical world of books</p>
        </div>
    </div>
    <!-- Carousel End-->
    <br>
    <br>

    <!-- Card about Strat-->
        <!-- Page fitur End-->
        <div class="row mb-2 ">
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                        <strong class="d-inline-block mb-2 text-primary">collection</strong>
                        <h3 class="mb-0">
                            <a class="text-dark" href="books.php">List Book</a>
                        </h3>
                        <div class="mb-1 text-muted">Now</div>
                        <p class="card-text mb-auto">Explore our book collection and discover a fascinating world of knowledge. Check out our book list now!</p>
                        <a href="books.php">Go to list Book</a>
                    </div>
                    <img class="card-img-right flex-auto d-none d-md-block" src="img/instagram/instagram-1.jpg" alt="Card image cap" style="width: 200px; height: 250px;">
                </div>
            </div>
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                        <strong class="d-inline-block mb-2 text-success">recommended</strong>
                        <h3 class="mb-0">
                            <a class="text-dark" href="index.php">Recomend Book</a>
                        </h3>
                        <div class="mb-1 text-muted">Now</div>
                        <p class="card-text mb-auto">Check out this week's recommended books! Explore captivating stories and expand your reading list. Don't miss out!</p>
                        <a href="index.php">Go to Recomendation</a>
                    </div>
                    <img class="card-img-right flex-auto d-none d-md-block" src="img/instagram/instagram-3.jpg" alt="Card image cap" style="width: 200px; height: 250px;" </div>
                </div>
            </div>
        </div>
        <!-- Card Profile Strat-->
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
                    <img src="img/about/pintu_masuk.jpg" width="500" height="500">
                </div>
            </div>
            <hr>
            <div class="row p-5">
                <div class="col-md-5">
                    <img src="img/loginbg.png" width="500" height="500">
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
                    <img src="img/about/ruang_pajang.jpg" width="500" height="500">
                </div>
            </div>
        </div>
        <!-- Card Profile End-->
    </div>
    <!-- Card About End-->
<?php
include('layouts/footer.php');
?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="js/bootstrap.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>