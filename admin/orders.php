<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
}
?>

<?php include('layouts/header.php'); ?>

<?php
$query_orders = "SELECT s.ID_Sewa, s.ID_Member, m.Nama_Member, s.ID_Buku, b.Judul_Buku, s.Tanggal_Pinjam, s.Tanggal_Kembali FROM sewa s JOIN member m ON s.ID_Member = m.ID_Member JOIN buku b ON s.ID_Buku = b.ID_Buku
ORDER BY s.Tanggal_Pinjam DESC";

$stmt_orders = $conn->prepare($query_orders);
$stmt_orders->execute();
$rents = $stmt_orders->get_result();
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Rents</h1>
    <nav class="mt-4 rounded" aria-label="breadcrumb">
        <ol class="breadcrumb px-3 py-2 rounded mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Rents</li>
        </ol>
    </nav>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold" style="color: #FA9828">Rents</h6>
        </div>
        <div class="card-body">
            <?php if (isset($_GET['success_status'])) { ?>
                <div class="alert alert-info" role="alert">
                    <?php if (isset($_GET['success_status'])) {
                        echo $_GET['success_status'];
                    } ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['fail_status'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php if (isset($_GET['fail_status'])) {
                        echo $_GET['fail_status'];
                    } ?>
                </div>
            <?php } ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Rent ID</th>
                            <th>Member ID</th>
                            <th>Member Name</th>
                            <th>Book ID</th>
                            <th>Book Title</th>
                            <th>Rent Date</th>
                            <th>Rent Due</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($rents as $rent) { ?>
                            <tr>
                                <td><?php echo $rent['ID_Sewa']; ?></td>
                                <td><?php echo $rent['ID_Member']; ?></td>
                                <td><?php echo $rent['Nama_Member']; ?></td>
                                <td><?php echo $rent['ID_Buku']; ?></td>
                                <td><?php echo $rent['Judul_Buku']; ?></td>
                                <td><?php echo $rent['Tanggal_Pinjam']; ?></td>
                                <td><?php echo $rent['Tanggal_Kembali']; ?></td>
                                <td class="text-center">
                                    <a href="edit_order.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-info btn-circle">
                                        <i class="fas fa-edit"></i>
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
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include('layouts/footer.php'); ?>