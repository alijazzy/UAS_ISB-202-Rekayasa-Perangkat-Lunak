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

    $sampul_buku = $_FILES['sampul_buku']['tmp_name'];

    $image_name = str_replace(' ', '_', $judul_buku) . ".jpg";

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
        header('location: index.php?success_create_message=Book has been created successfully');
        exit;
    } else {
        header('location: index.php?fail_create_message=Could not create book!');
        exit;
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
            <h6 class="m-0 font-weight-bold text"  style="color: #FA9828">Create Book Data</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form id="create-form" enctype="multipart/form-data" method="POST" action="create_book.php">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>ID_Buku</label>
                                    <input class="form-control" type="text" name="ID_buku">
                                </div>
                                <div class="form-group">
                                    <label>Judul Buku</label>
                                    <input class="form-control" type="text" name="judul_buku">
                                </div>
                                <div class="form-group">
                                    <label>Pengarang</label>
                                    <input class="form-control" type="text" name="pengarang">
                                </div>
                                <div class="form-group">
                                    <label>Penerbit</label>
                                    <input class="form-control" type="text" name="penerbit">
                                </div>
                                <div class="form-group">
                                    <label>Kategori Buku</label>
                                    <input class="form-control" type="text" name="kategori_buku">
                                </div>
                                <div class="form-group">
                                    <label>Jenis Buku</label>
                                    <select class="form-control" name="jenis_buku">
                                        <option value="" disabled selected>Pilih Jenis</option>
                                        <option value="Sejarah">Novel</option>
                                        <option value="Fiksi">Komik</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tahun Terbit</label>
                                    <input class="form-control" type="text" name="tahun_terbit">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Cover Buku</label>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="addImage" name="sampul_buku" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="addImage">Choose file...</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Harga Sewa Buku</label>
                                    <input class="form-control" type="text" name="harga_buku">
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
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