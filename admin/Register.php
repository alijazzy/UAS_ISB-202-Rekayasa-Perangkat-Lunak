<?php
session_start();
include('../server/connection.php');

// if (isset($_SESSION['logged_in'])) {
//     header('location: index.php');
//     exit;
// }

if (isset($_POST['register_btn'])) {
    // Periksa apakah data dari kedua form sudah terisi
    if (isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['address'], $_POST['phone'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];

        // Foto Profile
        $photo = $_FILES['photo']['tmp_name'];
        $photo_name = $_FILES['photo']['name'];
        $photo_extension = pathinfo($photo_name, PATHINFO_EXTENSION);

        // Membuat nama file baru dengan penambahan timestamp untuk menghindari konflik
        $safe_photo_name = pathinfo($photo_name, PATHINFO_FILENAME);
        $safe_photo_name = preg_replace('/[^a-zA-Z0-9-_]/', '_', $safe_photo_name);
        $new_photo_name = $safe_photo_name . '_' . time() . '.' . $photo_extension;
        $photo_destination = "../img/profile/" . $new_photo_name;

        // Cek apakah file berhasil diupload
        if (move_uploaded_file($photo, $photo_destination)) {
            // Cek apakah email sudah terdaftar sebelumnya
            $query_check_user = "SELECT COUNT(*) FROM member WHERE Email = ?";
            $stmt_check_user = $conn->prepare($query_check_user);
            $stmt_check_user->bind_param('s', $email);
            $stmt_check_user->execute();
            $stmt_check_user->bind_result($num_rows);
            $stmt_check_user->fetch();
            $stmt_check_user->close();

            // Jika ada email yang sama
            if ($num_rows !== 0) {
                header('location: Register.php?error=User with this email already exists');
                exit;
            }

            // Simpan data user ke database
            $query_save_user = "INSERT INTO member (Nama_Member, Email, Password, Alamat, Nomor_Telepon, Poto_Member) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_save_user = $conn->prepare($query_save_user);
            $stmt_save_user->bind_param('ssssss', $username, $email, $password, $address, $phone, $photo_name);

            if ($stmt_save_user->execute()) {
                $_SESSION['user_email'] = $email;
                $_SESSION['logged_in'] = true;
                header('location: login.php?register_success=You registered successfully!');
                exit;
            } else {
                header('location: Register.php?error=Could not create an account at the moment');
                exit;
            }
        } else {
            header('location: Register.php?error=Failed to upload photo');
            exit;
        }
    } else {
        // Jika ada data yang kosong, arahkan kembali ke halaman register dengan pesan galat
        header('location: Register.php?error=Please fill in all the fields');
        exit;
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
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/styleRegister.css" rel="stylesheet">


</head>

<body>
<div class="row no-gutters">
    <div class="col-md-6 no-gutters">
        <div class="leftside"></div>
    </div>
    <div class="col-md-6 no-gutters d-flex justify-content-center align-items-center">
        <div class="form-outer">
            <div class="rightside" style="margin-top: 200px;">
                <div class="text-start mb-10">
                    <p class="mb-4" style="text-align: center; font-size: 20px; font-weight: bold;">
                        PITIMOSS Smart Library
                        <br>
                        <span style="background: linear-gradient(to left, #F3860B 0%, #FFD80C 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            <span id="kt_landing_hero_text">Bukalah pikiranmu, lewat website kami</span>
                        </span>
                    </p>
                    <p class="mb-4" style="font-size:12px; text-align: center; color: black;"><b>Isi form di bawah untuk mendaftar</b></p>
                </div>
                <div class="container">
                    <form id="registerForm" method="POST" action="Register.php" enctype="multipart/form-data">
                        <div id="form0">
                            <!-- Form bagian pertama -->
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control form-control-user" name="username" placeholder="Enter Username">
                            </div>
                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="text" class="form-control form-control-user" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address">
                            </div>
                            <div class="form-group">
                                <label for="Password">Password</label>
                                <input type="password" class="form-control form-control-user" name="password" placeholder="Enter your Password">
                            </div>
                            <div class="btn-box d-flex justify-content-end">
                                <button type="button" id="Next1">Next</button>
                            </div>
                        </div>
                        
                        <div id="form1" style="display: none;">
                            <!-- Form bagian kedua -->
                            <div class="form-group">
                                <label for="Alamat">Alamat</label>
                                <input type="text" class="form-control form-control-user" name="address" placeholder="Enter Address">
                            </div>
                            <div class="form-group">
                                <label for="Phone Number">Phone Number</label>
                                <input type="text" class="form-control form-control-user" name="phone" placeholder="Enter Phone Number">
                            </div>
                            <div class="form-group">
                                <label for="Photo">Foto Profile</label>
                                <input type="file" class="form-control-file" name="photo" required>
                            </div>
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
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<script>
    var form0 = document.getElementById("form0");
    var form1 = document.getElementById("form1");

    var Next1 = document.getElementById("Next1");
    var Previous1 = document.getElementById("Previous1");

    Next1.onclick = function() {
        form0.style.display = "none";
        form1.style.display = "block";
    }

    Previous1.onclick = function() {
        form0.style.display = "block";
        form1.style.display = "none";
    }
</script>
</body>
</html> 