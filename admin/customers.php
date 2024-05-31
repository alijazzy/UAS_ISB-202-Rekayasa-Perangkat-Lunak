<?php
include('../server/connection.php');
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
}
?>

<?php include('layouts/header.php'); ?>


<?php
$query = "SELECT * FROM member";

$stmt_member = $conn->prepare($query);
$stmt_member->execute();
$Members = $stmt_member->get_result();
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Member</h1>
    <nav class="mt-4 rounded" aria-label="breadcrumb">
        <ol class="breadcrumb px-3 py-2 rounded mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Member</li>
        </ol>
    </nav>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold" style="color: #FA9828">Member</h6>
        </div>

        <!-- Alert Start -->
        <?php if (isset($_GET["success"]) && $_GET["success"] == true) : ?>
            <div id="alert" class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                <?php echo $_GET['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($_GET["success"]) && $_GET["success"] == false) : ?>
            <div id="alert" class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                <?php echo $_GET['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <!-- Alert End-->

        <div class="card-body">
            <div class="container-fluid border-bottom">
                <div class="row my-5">
                    <?php foreach ($Members as $member) { ?>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 bg-light shadow-sm">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <div class="profile-image mb-3">
                                        <img class="rounded-circle object-fit-cover" title="Image_Member" src="<?php echo '../img/profile/' . $member['Poto_Member']; ?>" alt="" width="130px" height="130px">
                                    </div>
                                    <h5 class="card-title mb-1"><?php echo $member['Nama_member']; ?></h5>
                                    <p class="card-text mb-2"><?php echo $member['Alamat']; ?></p>
                                    <p class="card-text mb-2"><?php echo $member['Email']; ?></p>
                                    <p class="card-text mb-3"><?php echo $member['Nomor_Telepon']; ?></p>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete<?= $member['ID_Member'] ?>" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Delete Start -->
                        <div class="modal fade" id="modalDelete<?= $member['ID_Member'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabelDelete" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content bg-blackness">
                                    <div class="modal-body text-dark text-center">
                                        <div class="text-end mb-3">
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="d-flex justify-content-center my-3">
                                            <h1 class="exclamation text-danger"><i class="fas fa-exclamation"></i></h1>
                                        </div>
                                        <h4 class="mb-3">Are you sure you want to delete this Member?</h4>
                                        <h6 class="text-dark-emphasis"><?php echo $member['Nama_member'] ?></h6>
                                        <div class="mt-4">
                                            <a class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</a>
                                            <a class="btn btn-danger" href="actionDelete.php?ID_Member=<?= $member['ID_Member'] ?>&Poto_Member=<?= $member['Poto_Member'] ?>">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Delete End -->
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../admin/js/bootstrap.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function isLetter(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122)) {
            return false;
        }
        return true;
    }
</script>
<?php include('layouts/footer.php'); ?>