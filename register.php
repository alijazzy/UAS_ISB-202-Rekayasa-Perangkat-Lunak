<?php
session_start();
include('server/connection.php');

if (isset($_SESSION['logged_in'])) {
    header('location: account.php');
    exit;
}

if (isset($_POST['register_btn'])) {
    // Ensure all required fields are filled
    if (isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['address'], $_POST['phone'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        
        // Handle the file upload
        $photo_temp = $_FILES['photo']['tmp_name']; // Foto sementara
        $photo_name = $_FILES['photo']['name']; // Nama foto asli

        // Ambil ekstensi file
        $photo_extension = pathinfo($photo_name, PATHINFO_EXTENSION);

        // Ganti nama file dengan nama username (tanpa spasi dan karakter khusus) + ekstensi file
        $new_photo_name = $username . '.' . $photo_extension;

        // Tentukan path baru untuk menyimpan foto
        $path = "img/profile/" . $new_photo_name;

        if (move_uploaded_file($photo_temp, $path)) {
            // Cek apakah email atau nomor telepon sudah terdaftar sebelumnya
            $query_check_user = "SELECT COUNT(*) FROM member WHERE Email = ? OR Nomor_Telepon = ?";
            $stmt_check_user = $conn->prepare($query_check_user);
            $stmt_check_user->bind_param('ss', $email, $phone);
            $stmt_check_user->execute();
            $stmt_check_user->bind_result($num_rows);
            $stmt_check_user->fetch();
            $stmt_check_user->close();

            // Jika ada email atau nomor telepon yang sama
            if ($num_rows !== 0) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'User already exists',
                            text: 'A user with this email or phone number already exists.'
                        });
                    });
                </script>";
            } else {
                // Simpan data user ke database
                $query_save_user = "INSERT INTO member (Nama_Member, Email, Password_Member, Alamat, Nomor_Telepon, Poto_Member) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt_save_user = $conn->prepare($query_save_user);
                $stmt_save_user->bind_param('ssssss', $username, $email, $password, $address, $phone, $new_photo_name);

                if ($stmt_save_user->execute()) {
                    $new_member_id = $stmt_save_user->insert_id;
                    
                    $_SESSION['member_email'] = $email;
                    $_SESSION['logged_in'] = true;
                    $_SESSION['member_id'] = $new_member_id;
                    $_SESSION['member_address'] = $address;
                    $_SESSION['member_phone'] = $phone;
                    $_SESSION['member_photo'] = $new_photo_name;
                    header('location: login.php?register_success=You registered successfully!');
                    exit;
                } else {
                    echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Registration Failed',
                                text: 'Could not create an account at the moment. Please try again later.'
                            });
                        });
                    </script>";
                }
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Upload Error',
                        text: 'Could not upload profile picture. Please try again.'
                    });
                });
            </script>";
        }
    } else {
        // Jika ada data yang kosong, arahkan kembali ke halaman register dengan pesan galat
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Incomplete Form',
                    text: 'Please fill in all the fields.'
                });
            });
        </script>";
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

    <title>Pitimoss - Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="admin/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="admin/css/styleRegister.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
    <link rel="icon" href="img/icon/pitimoss_logo.png" type="image/png">

</head>

<body>
<div class="row no-gutters vh-100">
    <div class="col-md-6 no-gutters">
        <div class="leftside h-100"></div>
    </div>
    <div class="col-md-6 no-gutters d-flex justify-content-center align-items-center">
        <div class="form-outer" style="padding-top: 200px;"> <!-- Added padding-top to move the form down -->
            <div class="rightside d-flex flex-column justify-content-center align-items-center w-100 h-100">
                <div class="text-start mb-10 text-center">
                    <p class="mb-4" style="font-size: 20px; font-weight: bold;">
                        PITIMOSS Smart Library
                        <br>
                        <span style="background: linear-gradient(to left, #F3860B 0%, #FFD80C 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            <span id="kt_landing_hero_text">Bukalah pikiranmu, lewat website kami</span>
                        </span>
                    </p>
                    <p class="mb-4" style="font-size:12px; color: black;"><b>Isi form di bawah untuk mendaftar</b></p>
                </div>
                <div class="container">
                    <form id="registerForm" method="POST" action="Register.php" enctype="multipart/form-data">
                        <div id="form0">
                            <!-- Form bagian pertama -->
                            <label for="username">Username</label>
                            <input type="text" class="form-control form-control-user" name="username" placeholder="Enter Username" required>
                            
                            <label for="Email">Email</label>
                            <input type="email" class="form-control form-control-user" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address" required>
                            
                            <label for="Password">Password</label>
                            <input type="password" class="form-control form-control-user" name="password" placeholder="Enter your Password" required minlength="8">
                            
                            <div class="btn-box d-flex justify-content-end">
                                <button type="button" id="Next1">Next</button>
                            </div>
                        </div>
                        
                        <div id="form1" style="display: none;">
                            <!-- Form bagian kedua -->
                            <label for="Alamat">Alamat</label>
                            <input type="text" class="form-control form-control-user" name="address" placeholder="Enter Address" required>
                            
                            <label for="Phone Number">Phone Number</label>
                            <input type="text" class="form-control form-control-user" name="phone" placeholder="Enter Phone Number" required>
                            
                            <label for="Photo">Foto Profile</label>
                            <input type="file" class="form-control-file" name="photo" required>
                            
                            <div class="btn-box d-flex justify-content-between">
                                <button type="button" id="Previous1">Previous</button>
                                <button type="submit" name="register_btn">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="admin/vendor/jquery/jquery.min.js"></script>
<script src="admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="admin/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="admin/js/sb-admin-2.min.js"></script>

<script>
    var form0 = document.getElementById("form0");
    var form1 = document.getElementById("form1");

    var Next1 = document.getElementById("Next1");
    var Previous1 = document.getElementById("Previous1");

    Next1.onclick = function() {
        var username = document.getElementsByName("username")[0].value;
        var email = document.getElementsByName("email")[0].value;
        var password = document.getElementsByName("password")[0].value;

        if (username === "" || email === "" || password === "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in all the fields.'
            });
        } else if (!email.endsWith('@gmail.com')) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Email',
                text: 'Please use an email address that ends with @gmail.com.'
            });
        } else if (password.length < 8) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Password must be at least 8 characters long.'
            });
        } else {
            form0.style.display = "none";
            form1.style.display = "block";
        }
    }

    Previous1.onclick = function() {
        form0.style.display = "block";
        form1.style.display = "none";
    }
</script>
</body>
</html>
