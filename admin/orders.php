<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit;
}

include('layouts/header.php');
include('../server/connection.php'); // Pastikan path ini benar

$query_orders = "SELECT s.ID_Sewa, s.ID_Member, m.Nama_Member, s.ID_Buku, b.Judul_Buku, s.Tanggal_Pinjam, s.Tanggal_Kembali 
                 FROM sewa s 
                 JOIN member m ON s.ID_Member = m.ID_Member 
                 JOIN buku b ON s.ID_Buku = b.ID_Buku 
                 ORDER BY s.Tanggal_Pinjam DESC";

$stmt_orders = $conn->prepare($query_orders);
if (!$stmt_orders) {
    die("Query preparation failed: " . $conn->error);
}

$stmt_orders->execute();
$rents = $stmt_orders->get_result();
if (!$rents) {
    die("Query execution failed: " . $stmt_orders->error);
}
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
                    <?php echo $_GET['success_status']; ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['fail_status'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_GET['fail_status']; ?>
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
                        <?php while ($rent = $rents->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $rent['ID_Sewa']; ?></td>
                                <td><?php echo $rent['ID_Member']; ?></td>
                                <td><?php echo $rent['Nama_Member']; ?></td>
                                <td><?php echo $rent['ID_Buku']; ?></td>
                                <td><?php echo $rent['Judul_Buku']; ?></td>
                                <td><?php echo $rent['Tanggal_Pinjam']; ?></td>
                                <td><?php echo $rent['Tanggal_Kembali']; ?></td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-danger btn-circle delete-rent" data-id="<?php echo $rent['ID_Sewa']; ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    <button class="btn btn-warning btn-circle notify-btn" data-id-member="<?php echo $rent['ID_Member']; ?>">
                                        <i class="fas fa-bell"></i>
                                    </button>
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

<!-- jQuery is required for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.notify-btn').on('click', function() {
            var idMember = $(this).data('id-member');
            $.ajax({
                url: 'notification.php', // Pastikan path ini benar
                method: 'POST',
                data: {
                    id_member: idMember
                },
                dataType: 'json',
                success: function(response) {
                    if (Array.isArray(response)) {
                        response.forEach(function(res) {
                            if (res.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: res.message,
                                    showConfirmButton: false,
                                    timer: 2500
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: res.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Unexpected response format.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error: ' + error,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });
    });
</script>

<script>
    // Select all delete-rent buttons
    document.querySelectorAll('.delete-rent').forEach(item => {
        item.addEventListener('click', event => {
            event.preventDefault();
            const sewaId = item.getAttribute('data-id');

            // Show SweetAlert2 confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, redirect to delete_rents.php with rent_id
                    window.location.href = `delete_rents.php?rent_id=${sewaId}`;
                }
            });
        });
    });
</script>