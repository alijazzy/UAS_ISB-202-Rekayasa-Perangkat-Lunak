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
        if (move_uploaded_file($_FILES['Poto_Member']['tmp_name'], $target_file)) {
            // Hapus foto lama jika ada
            $query_select_photo = "SELECT Poto_Member FROM member WHERE ID_Member = ?";
            $result_select_photo = $conn->prepare($query_select_photo);
            $result_select_photo->bind_param('i', $id);
            $result_select_photo->execute();
            $row = $result_select_photo->get_result()->fetch_assoc();
            $old_photo = $row['Poto_Member'];

            if ($old_photo && file_exists("img/" . $old_photo)) {
                unlink("img/" . $old_photo);
            }

            $query_update = "UPDATE member SET 
                Nama_member = ?, 
                Alamat = ?, 
                Email = ?, 
                Nomor_Telepon = ?, 
                Password_member = ?, 
                Poto_Member = ? 
                WHERE ID_Member = ?";

            $result_update = $conn->prepare($query_update);
            if ($result_update !== false) {
                $result_update->bind_param(
                    'ssssssi',
                    $nama,
                    $alamat,
                    $email,
                    $nomor,
                    $pass,
                    $photo,
                    $id
                );
                if ($result_update->execute()) {
                    $success = true;
                    header("Location: customers.php?success=$success&message=Member Updated!");
                    exit();
                } else {
                    $success = false;
                    header("Location: customers.php?success=$success&error=Failed to Update!");
                    exit();
                }
            } else {
                // Handle the error, e.g., log it or display an error message to the user
                echo "Error preparing the SQL statement.";
            }
        } else {
            // Handle the file upload error
            echo "Error uploading the file.";
        }
    } else {
        // Jika tidak ada file yang diupload, update tanpa mengubah foto
        $query_update = "UPDATE member SET 
            Nama_member = ?, 
            Alamat = ?, 
            Email = ?, 
            Nomor_Telepon = ?, 
            Password_member = ? 
            WHERE ID_Member = ?";

        $result_update = $conn->prepare($query_update);
        if ($result_update !== false) {
            $result_update->bind_param(
                'sssssi',
                $nama,
                $alamat,
                $email,
                $nomor,
                $pass,
                $id
            );
            if ($result_update->execute()) {
                $success = true;
                header("Location: customers.php?success=$success&message=Member Updated!");
                exit();
            } else {
                $success = false;
                header("Location: customers.php?success=$success&error=Failed to Update!");
                exit();
            }
        } else {
            // Handle the error, e.g., log it or display an error message to the user
            echo "Error preparing the SQL statement.";
        }
    }
}