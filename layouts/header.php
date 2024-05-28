<?php
$kurs_dollar = 15502;

function setRupiah($price)
{
    $result = "Rp" . number_format($price, 0, ',', '.');
    return $result;
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pitimoss Smart Library</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <link rel="icon" href="img/icon/pitimoss_logo.png" type="image/png">
</head>

<body>
    <section class="header">
        <nav>

            <div class="logo">
                <img src="../img/pitimosLogo.png" class="object-fit">
            </div>

            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../about.php">About Us</a></li>
                <li><a href="../Featured.php">Featured</a></li>
                <li><a href="../books.php">Books</a></li>
            </ul>

            <div class="social_icon">
                <a href="../account.php"><img src="img/icon/user.png" alt=""></a>
                <a href="../shopping-cart.php"><img src="img/icon/cart.png" alt=""></a>
            </div>

        </nav>
    </section>
    </header>