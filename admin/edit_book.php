<?php
ob_start();
session_start();
include('layouts/header.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit;
}

if (isset($_GET['book_id']) && !empty($_GET['book_id'])) {
    $id_buku = $_GET['book_id'];

    $query_select_book = "SELECT * FROM buku WHERE ID_Buku = ?";
    $stmt_select_book = $conn->prepare($query_select_book);
    $stmt_select_book->bind_param('s', $id_buku);
    $stmt_select_book->execute();
    $result = $stmt_select_book->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        header('location: books.php?error_message=Book not found');
        exit;
    }
} else {
    header('location: books.php?error_message=Invalid request');
    exit;
}

if (isset($_POST['modify_btn'])) {
    $judul_buku = $_POST['judul_buku'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $kategori_buku = $_POST['kategori_buku'];
    $jenis_buku = $_POST['jenis_buku'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $harga_buku = $_POST['harga_buku'];
    $status = $_POST['status'];

    // Validasi harga buku
    if (!is_numeric($harga_buku)) {
        $error_message = "Book prices must be numbers!";
    } elseif ($harga_buku < 0) {
        $error_message = "The book price cannot be negative!";
    } else {
        if ($_FILES['sampul_buku']['size'] > 0) {
            $sampul_buku = $_FILES['sampul_buku']['tmp_name'];
            $image_name = str_replace(' ', '', $judul_buku) . ".jpg";
            move_uploaded_file($sampul_buku, '../img/product/' . $image_name);
        } else {
            $image_name = $book['Sampul_Buku'];
        }

        $query_update_book = "UPDATE buku SET Judul_Buku = ?, Pengarang = ?, Penerbit = ?, 
                              Kategori_Buku = ?, Jenis_Buku = ?, Tahun_Terbit = ?, 
                              Sampul_Buku = ?, Harga_Buku = ?, Status = ?
                              WHERE ID_Buku = ?";

        $stmt_update_book = $conn->prepare($query_update_book);

        $stmt_update_book->bind_param(
            'sssssssdss',
            $judul_buku,
            $pengarang,
            $penerbit,
            $kategori_buku,
            $jenis_buku,
            $tahun_terbit,
            $image_name,
            $harga_buku,
            $status,
            $id_buku
        );

        if ($stmt_update_book->execute()) {
            header('location: books.php?success_modify_message=Book has been modified successfully');
            exit;
        } else {
            $error_message = "Could not modify book";
        }
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Modify Book Data</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text" style="color: #FA9828">Modify Book Data</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <?php if (isset($error_message)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                    <?php } ?>
                    <form id="modify-form" enctype="multipart/form-data" method="POST" action="edit_book.php?book_id=<?php echo $id_buku; ?>">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Judul Buku</label>
                                    <input class="form-control" type="text" name="judul_buku" value="<?php echo $book['Judul_Buku']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Pengarang</label>
                                    <input class="form-control" type="text" name="pengarang" value="<?php echo $book['Pengarang']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Penerbit</label>
                                    <input class="form-control" type="text" name="penerbit" value="<?php echo $book['Penerbit']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Kategori Buku</label>
                                    <input class="form-control" type="text" name="kategori_buku" value="<?php echo $book['Kategori_Buku']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Buku</label>
                                    <select class="form-control" name="jenis_buku" required>
                                        <option value="Sejarah" <?php echo ($book['Jenis_Buku'] == 'Sejarah') ? 'selected' : ''; ?>>Novel</option>
                                        <option value="Fiksi" <?php echo ($book['Jenis_Buku'] == 'Fiksi') ? 'selected' : ''; ?>>Komik</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tahun Terbit</label>
                                    <input class="form-control" type="text" name="tahun_terbit" value="<?php echo $book['Tahun_Terbit']; ?>" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Cover Buku</label>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="addImage" name="sampul_buku" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="addImage" id="addImageLabel">Choose file...</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Harga Sewa Buku</label>
                                    <input class="form-control" type="text" name="harga_buku" value="<?php echo $book['Harga_Buku']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status" required>
                                        <option value="Tersedia" <?php echo ($book['Status'] == 'Tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                                        <option value="Tidak Tersedia" <?php echo ($book['Status'] == 'Tidak Tersedia') ? 'selected' : ''; ?>>Tidak Tersedia</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="m-t-20 text-right">
                            <a href="products.php" class="btn btn-danger">Cancel <i class="fas fa-undo"></i></a>
                            <button type="submit" class="btn btn-primary submit-btn" name="modify_btn">Modify <i class="fas fa-save"></i></button>
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
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("addImage").files[0].name;
        var nextSibling = document.getElementById("addImageLabel");
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