<?php
ob_start();
session_start();
include('layouts/header.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit;
}

if (isset($_POST['create_btn'])) {
    $ID_buku = $_POST['ID_buku'];
    $judul_buku = $_POST['judul_buku'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $kategori_buku = $_POST['kategori_buku'];
    $jenis_buku = $_POST['jenis_buku'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $harga_buku = $_POST['harga_buku'];
    $status = $_POST['status'];

    // Cek apakah harga buku negatif atau bukan angka
    if (!is_numeric($harga_buku)) {
        $error_message = "Book prices must be numbers!";
    } elseif ($harga_buku < 0) {
        $error_message = "The book price cannot be negative!";
    } else {
        $sampul_buku = $_FILES['sampul_buku']['tmp_name'];
        $image_name = str_replace(' ', '_', $judul_buku) . ".jpg";

        // Check if ID_Buku already exists
        $query_check_id = "SELECT * FROM buku WHERE ID_Buku = ?";
        $stmt_check_id = $conn->prepare($query_check_id);
        $stmt_check_id->bind_param('s', $ID_buku);
        $stmt_check_id->execute();
        $result_check_id = $stmt_check_id->get_result();

        if ($result_check_id->num_rows > 0) {
            // ID_Buku already exists
            $error_message = "Book ID has been used";
        } else {
            // Upload gambar
            move_uploaded_file($sampul_buku, '../img/product/' . $image_name);

            $query_insert_book = "INSERT INTO buku (ID_Buku, Judul_Buku, Pengarang, Penerbit, Kategori_Buku, 
                Jenis_Buku, Tahun_Terbit, Sampul_Buku, Harga_Buku, Status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt_insert_book = $conn->prepare($query_insert_book);
            $stmt_insert_book->bind_param(
                'ssssssssss',
                $ID_buku,
                $judul_buku,
                $pengarang,
                $penerbit,
                $kategori_buku,
                $jenis_buku,
                $tahun_terbit,
                $image_name,
                $harga_buku,
                $status
            );

            if ($stmt_insert_book->execute()) {
                $_SESSION['success_create_message'] = "Book Has Created";
                header('location: create_book.php');
                exit;
            } else {
                $error_message = "Could not create book!";
            }
        }
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Create Book Data</h1>
    <nav class="mt-4 rounded" aria-label="breadcrumb">
        <ol class="breadcrumb px-3 py-2 rounded mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="products.php">Books</a></li>
            <li class="breadcrumb-item active">Create Book Data</li>
        </ol>
    </nav>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text" style="color: #FA9828">Create Book Data</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <?php if (isset($error_message)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                    <?php } ?>
                    <?php if (isset($_SESSION['success_create_message'])) { ?>
                        <div class="alert alert-success" role="alert">
                            <?php 
                            echo $_SESSION['success_create_message']; 
                            unset($_SESSION['success_create_message']); // Hapus pesan setelah ditampilkan
                            ?>
                        </div>
                    <?php } ?>
                    <form id="create-form" enctype="multipart/form-data" method="POST" action="create_book.php">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>ID_Buku</label>
                                    <input class="form-control" type="text" name="ID_buku" required>
                                </div>
                                <div class="form-group">
                                    <label>Judul Buku</label>
                                    <input class="form-control" type="text" name="judul_buku" required>
                                </div>
                                <div class="form-group">
                                    <label>Pengarang</label>
                                    <input class="form-control" type="text" name="pengarang" required>
                                </div>
                                <div class="form-group">
                                    <label>Penerbit</label>
                                    <input class="form-control" type="text" name="penerbit" required>
                                </div>
                                <div class="form-group">
                                    <label>Kategori Buku</label>
                                    <input class="form-control" type="text" name="kategori_buku" required>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Buku</label>
                                    <select class="form-control" name="jenis_buku" required>
                                        <option value="" disabled selected>Pilih Jenis</option>
                                        <option value="Sejarah">Novel</option>
                                        <option value="Fiksi">Komik</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tahun Terbit</label>
                                    <input class="form-control" type="text" name="tahun_terbit" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Cover Buku</label>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="addImage" name="sampul_buku" aria-describedby="inputGroupFileAddon01" required>
                                            <label class="custom-file-label" for="addImage">Choose file...</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Harga Sewa Buku</label>
                                    <input class="form-control" type="text" name="harga_buku" required>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status" required>
                                        <option value="" disabled selected>Pilih Status</option>
                                        <option value="Tersedia">Tersedia</option>
                                        <option value="Tidak Tersedia">Tidak Tersedia</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="m-t-20 text-right">
                            <a href="books.php" class="btn btn-danger">Cancel <i class="fas fa-undo"></i></a>
                            <button type="submit" class="btn btn-primary submit-btn" name="create_btn">Create <i class="fas fa-save"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include('layouts/footer.php'); ?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script to update the custom file input label -->
<script>
    document.querySelector('.custom-file-input').addEventListener('change', function (e) {
        var fileName = document.getElementById("addImage").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });

    <?php if (isset($error_message)) { ?>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '<?php echo $error_message; ?>',
    });
    <?php } ?>
</script>
