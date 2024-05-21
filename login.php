<?php
session_start();
include('./server/connection.php');

if (isset($_SESSION['logged_in'])) {
    header('location: account.php');
    exit;
}

$error_message = '';

if (isset($_POST['login_btn'])) {
    $input = $_POST['email'];
    $password = $_POST['password'];

    // Error handling for empty fields
    if (empty($input)) {
        $error_message = 'Email or phone number cannot be empty';
    } else if (empty($password)) {
        $error_message = 'Password cannot be empty';
    } else {
        $query = "SELECT ID_Member, Nama_member, Alamat, Email, Nomor_Telepon, Password, Poto_Member FROM member WHERE (Email = ? OR Nomor_Telepon = ?) AND Password = ? LIMIT 1";

        $stmt_login = $conn->prepare($query);
        $stmt_login->bind_param('sss', $input, $input, $password);

        if ($stmt_login->execute()) {
            $stmt_login->bind_result($member_id, $member_name, $member_address, $member_email, $member_phone, $member_password, $member_photo);
            $stmt_login->store_result();

            if ($stmt_login->num_rows() == 1) {
                $stmt_login->fetch();

                $_SESSION['member_id'] = $member_id;
                $_SESSION['member_name'] = $member_name;
                $_SESSION['member_address'] = $member_address;
                $_SESSION['member_email'] = $member_email;
                $_SESSION['member_phone'] = $member_phone;
                $_SESSION['member_photo'] = $member_photo;
                $_SESSION['logged_in'] = true;

                header('location: account.php?message=Logged in successfully');
                exit;
            } else {
                $error_message = 'Invalid email, phone number, or password';
            }
        } else {
            $error_message = 'Something went wrong!';
        }
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
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="admin/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="admin/css/styleLogin.css" rel="stylesheet">
    <link rel="icon" href="../img/icon/pitimoss_logo.png" type="image/png">
</head>

<body>
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
                            <p class="mb-4" style="font-size:12px;text-align: center;color: black"><b>Gunakan akun untuk member dan admin👋</b></p>
                        </div>
                        <?php if (!empty($error_message)) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $error_message; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="exampleInputEmail" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address or Phone Number...">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <p>Haven't got an account yet? <a href="register.php">Register here</a></p>
                        </div>
                        <input type="submit" class="btn btn btn-block" name="login_btn" value="Login" style="background-color: #F3860B; color:white" />
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6 no-gutters">
            <div class="rightside"></div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="admin/vendor/jquery/jquery.min.js"></script>
    <script src="admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="admin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="admin/js/sb-admin-2.min.js"></script>
</body>

</html>