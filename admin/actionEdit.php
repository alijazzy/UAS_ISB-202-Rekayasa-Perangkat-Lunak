<?php
include('../server/connection.php');

if (isset($_POST['submit_edit'])) {
    $id = $_POST['ID_Member'];
    $nama = $_POST['Nama_member'];
    $alamat = $_POST['Alamat'];
    $email = $_POST['Email'];
    $nomor = $_POST['Nomor_Telepon'];
    $pass = $_POST['Password_member'];
    $photo = $_FILES['Poto_Member']['name'];

    // Cek apakah ada file yang diupload
    if ($_FILES['Poto_Member']['size'] > 0) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["Poto_Member"]["name"]);

        // Pindahkan file baru ke folder
        move_uploaded_file($_FILES['Poto_Member']['tmp_name'], $target_file);

        // Hapus foto lama jika ada
        $query_select_photo = "SELECT Poto_Member FROM member WHERE ID_Member = '$id'";
        $result_select_photo = mysqli_query($conn, $query_select_photo);
        $row = mysqli_fetch_assoc($result_select_photo);
        $old_photo = $row['Poto_Member'];

        $query_update = "UPDATE member SET 
            Nama_member='$nama', 
            Alamat='$alamat', 
            Email='$email', 
            Nomor_Telepon='$nomor', 
            Password_Member='$pass', 
            Poto_Member='$photo' 
            WHERE ID_Member='$id'";

        $result_update = mysqli_query($conn, $query_update);

        // Hapus foto lama jika berhasil mengupdate dengan foto baru
        if ($result_update && file_exists("img/" . $old_photo)) {
            unlink("img/" . $old_photo);
        }
    } else {
        // Jika tidak ada file yang diupload, update tanpa mengubah foto
        $query_update = "UPDATE member SET 
            Nama_member='$nama', 
            Alamat='$alamat', 
            Email='$email', 
            Nomor_Telepon='$nomor', 
            Password_Member='$pass' 
            WHERE ID_Member='$id'";
        $result_update = mysqli_query($conn, $query_update);
    }

    if ($result_update) {
        $success = true;
        header("Location: customers.php?success=$success&message=Member Updated!");
        exit();
    } else {
        $success = false;
        header("Location: customers.php?success=$success&error=Failed to Update!");
        exit();
    }
}
?>