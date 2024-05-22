<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
}
?>

<?php include('layouts/header.php'); ?>

<?php
$query_products = "SELECT * FROM buku";

$stmt_products = $conn->prepare($query_products);
$stmt_products->execute();
$books = $stmt_products->get_result();

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Books</h1>
    <nav class="mt-4 rounded" aria-label="breadcrumb">
        <ol class="breadcrumb px-3 py-2 rounded mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="products.php">Books</a></li>
            <li class="breadcrumb-item active">Book List</li>
        </ol>
    </nav>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold" style="color: #FA9828">Books</h6>
        </div>
        <div class="card-body">
            <?php if (isset($_GET['success_update_message'])) { ?>
                <div class="alert alert-info" role="alert">
                    <?php if (isset($_GET['success_update_message'])) {
                        echo $_GET['success_update_message'];
                    } ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['fail_update_message'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php if (isset($_GET['fail_update_message'])) {
                        echo $_GET['fail_update_message'];
                    } ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['success_delete_message'])) { ?>
                <div class="alert alert-info" role="alert">
                    <?php if (isset($_GET['success_delete_message'])) {
                        echo $_GET['success_delete_message'];
                    } ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['fail_delete_message'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php if (isset($_GET['fail_delete_message'])) {
                        echo $_GET['fail_delete_message'];
                    } ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['success_create_message'])) { ?>
                <div class="alert alert-info" role="alert">
                    <?php if (isset($_GET['success_create_message'])) {
                        echo $_GET['success_create_message'];
                    } ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['fail_create_message'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php if (isset($_GET['fail_create_message'])) {
                        echo $_GET['fail_create_message'];
                    } ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['image_success'])) { ?>
                <div class="alert alert-info" role="alert">
                    <?php if (isset($_GET['image_success'])) {
                        echo $_GET['image_success'];
                    } ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['image_failed'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php if (isset($_GET['image_failed'])) {
                        echo $_GET['image_failed'];
                    } ?>
                </div>
            <?php } ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Book Cover</th>
                            <th>Book Title</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Year Released</th>
                            <th>Rent Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $buku) { ?>
                            <tr>
                                <td><?php echo $buku['ID_Buku']; ?></td>
                                <td class="text-center"><img title="product_image" src="<?php echo '../img/product/' . $buku['Sampul_Buku']; ?>" style="width: 80px; height: 80px;" /></td>
                                <td><?php echo $buku['Judul_Buku']; ?></td>
                                <td><?php echo $buku['Pengarang']; ?></td>
                                <td><?php echo $buku['Penerbit']; ?></td>
                                <td><?php echo $buku['Kategori_Buku']; ?></td>
                                <td><?php echo $buku['Jenis_Buku']; ?></td>
                                <td><?php echo $buku['Tahun_Terbit']; ?></td>
                                <td><?php echo $buku['Harga_Buku']; ?></td>
                                <td class="text-center">

                                    <a href="edit_book.php?book_id=<?php echo $buku['ID_Buku']; ?>" class="btn btn-info btn-circle">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="delete_book.php?book_id=<?php echo $buku['ID_Buku']; ?>" class="btn btn-danger btn-circle">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End of Main Content -->
<?php include('layouts/footer.php'); ?>