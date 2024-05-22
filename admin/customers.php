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
                <?php foreach ($Members as $member) { ?>
                    <div class="container-fluid text-dark my-5 d-flex flex-row align-items-center">
                        <div class="p-2 border-dark border border-2 rounded-circle">
                            <img class="rounded-circle object-fit-cover" title="Image_Member" src="<?php echo 'img/' . $member['Poto_Member']; ?>" alt="" width="130px" height="130px">
                        </div>
                        <div class="mx-4 my-0 h-4">
                            <h5 class="my-0">
                                <?php echo $member['Nama_member']; ?>
                            </h5>
                            <h6 class="my-0">
                                <?php echo $member['Alamat']; ?>
                            </h6>
                            <h6 class="my-0">
                                <?php echo $member['Email']; ?>
                            </h6>
                            <h6 class="my-0">
                                <?php echo $member['Nomor_Telepon']; ?>
                            </h6>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $member['ID_Member'] ?>"><i class="fas fa-edit" style="color: #000;"></i></a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete<?= $member['ID_Member'] ?>"><i class="fas fa-trash-alt" style="color: #000;"></i></a>
                        </div>

                        <!-- Modal Delete Start -->
                        <div class="modal fade mt-5 pt-5" id="modalDelete<?= $member['ID_Member'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabelDelete" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content bg-blackness">
                                    <div class="modal-body text-dark text-center">
                                        <div class="text-light text-end">
                                            <a class="btn btn-close text-light" type="button" data-bs-dismiss="modal" aria-label="Close"></a>
                                        </div>
                                        <div class="d-flex justify-content-center my-3">
                                            <h1 class="exclamation"><i class="fas fa-exclamation"></i></h1>
                                        </div>
                                        <div class="my-4">
                                            <h4>Are you sure want to Delete this Member?</h4>
                                            <h6 class="text-dark-emphasis"><?php echo $member['Nama_member'] ?></h6>
                                        </div>
                                        <div class="my-2">
                                            <a class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">Cancel</a>
                                            <a class="btn btn-danger" href="actionDelete.php?ID_Member=<?= $member['ID_Member'] ?>&Poto_Member=<?= $member['Poto_Member'] ?>">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Delete End -->

                        <!-- Modal Edit Start -->
                        <div class="modal fade" id="modalEdit<?= $member['ID_Member'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabelEdit" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content bg-blackness ">
                                    <div class="modal-body text-dark ">
                                        <div class="d-flex justify-content-between mb-4">
                                            <h2 class="modal-title" id="modalLabelEdit">Edit Profile</h2>
                                            <button type="button" class="btn btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="actionEdit.php" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="ID_Member" value="<?= $member['ID_Member'] ?>">
                                            <div class="mb-3">
                                                <label for="Nama_member" class="form-label">Nama</label>
                                                <input type="text" class="form-control" id="Nama_member" name="Nama_member" value="<?= $member['Nama_member'] ?>" onkeypress="return isLetter(event)" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="Alamat" class="form-label">Alamat</label>
                                                <input type="text" class="form-control" id="Alamat" name="Alamat" value="<?= $member['Alamat'] ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="Email" class="form-label">Email address</label>
                                                <input type="email" class="form-control" id="Email" name="Email" value="<?= $member['Email'] ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="Nomor_Telepon" class="form-label">Nomor Telepon</label>
                                                <input type="text" class="form-control" id="Nomor_Telepon" name="Nomor_Telepon" value="<?= $member['Nomor_Telepon'] ?>" minlength="12" maxlength="13" pattern="\d{12,13}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="Password_member" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="Password_member" name="Password_member" value="<?= $member['Password_member'] ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="formFile" class="form-label">Foto Profile</label>
                                                <input class="form-control" type="file" id="Poto_Member" name="Poto_Member">
                                            </div>
                                            <div class="py-2 text-end">
                                                <input type="submit" class="btn btn-light" name="submit_edit" value="Submit">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Edit End -->
                    </div>
                <?php } ?>
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