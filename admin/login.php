<?php
session_start();
include('../server/connection.php');

if (isset($_SESSION['admin_logged_in'])) {
    header('location: index.php');
    exit;
}

if (isset($_POST['login_btn'])) {
    $input = $_POST['email']; 
    $password = $_POST['password'];

    
    $query = "SELECT ID_Admin, Nama_Admin, Email, Nomor_Telepon, Admin_Password, Poto_Admin FROM admin WHERE (Email = ? OR Nomor_Telepon = ?) AND Admin_Password = ? LIMIT 1";

    $stmt_login = $conn->prepare($query);
    $stmt_login->bind_param('sss', $input, $input, $password); 

    if ($stmt_login->execute()) {
        $stmt_login->bind_result($admin_id, $admin_name, $admin_email, $admin_phone, $admin_password, $admin_photo);
        $stmt_login->store_result();

        if ($stmt_login->num_rows() == 1) {
            $stmt_login->fetch();

            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['admin_name'] = $admin_name;
            $_SESSION['admin_email'] = $admin_email;
            $_SESSION['admin_phone'] = $admin_phone;
            $_SESSION['admin_photo'] = $admin_photo;
            $_SESSION['admin_photo2'] = $admin_photo2;
            $_SESSION['admin_logged_in'] = true;

            header('location: index.php?message=Logged in successfully');
        } else {
            header('location: login.php?error=Could not verify your account');
        }
    } else {
        // Error
        header('location: login.php?error=Something went wrong!');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pitimoss - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/styleLogin.css" rel="stylesheet">
    <link rel="icon" href="../img/icon/pitimoss_logo.png" type="image/png">

</head>

<body >
<div class="row no-gutters">
        <div class="col-md-6 no-gutters">
            <div class="leftside d-flex justify-content-center align-items-center">
                <form class="form w-50" id="login-form" enctype="multipart/form-data" method="POST" action="login.php">
                    <div class="card-body">
                        <div class="text-start mb-10">
                            <p class="mb-4" style="text-align: center;font-size: 20px; font-weight: bold">
                            PITIMOSS Smart Library
                            <br>
                            <span style="background: linear-gradient(to right, #F3860B 0%, #FFD80C 100%);-webkit-background-clip: text;-webkit-text-fill-color: transparent;">
                                <span id="kt_landing_hero_text">Bukalah pikiranmu, lewat website kami</span>
                            </span>
                            </p>
                            <p class="mb-4" style="font-size:12px;text-align: center;color: black"><b>Gunakan
                                akun untuk member dan admin👋</b>
                            </p>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="exampleInputEmail" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address or Phone Number...">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                            </div>
                        </div>
                        <input type="submit" class="btn btn btn-block" name="login_btn" value="Login" style="background-color: #F3860B; color:white"/>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6 no-gutters">
            <div class="rightside"></div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
