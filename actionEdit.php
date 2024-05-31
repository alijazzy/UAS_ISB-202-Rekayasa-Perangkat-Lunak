<?php
session_start();
include('server/connection.php');

$member_id = $_SESSION['member_id'];

if (isset($_POST['submit_edit'])) {
    $id = $_POST['ID_Member'];
    $nama = $_POST['Nama_member'];
    $alamat = $_POST['Alamat'];
    $email = $_POST['Email'];
    $nomor = $_POST['Nomor_Telepon'];
    $pass = $_POST['Password_member'];
    $photo = $_FILES['Poto_Member']['name'];

    // Check if a file is uploaded
    if ($_FILES['Poto_Member']['size'] > 0) {
        $target_dir = "img/profile/";
        $target_file = $target_dir . basename($_FILES["Poto_Member"]["name"]);

        // Move the new file to the folder
        if (move_uploaded_file($_FILES['Poto_Member']['tmp_name'], $target_file)) {
            // Delete the old photo if it exists
            $query_select_photo = "SELECT Poto_Member FROM member WHERE ID_Member = ?";
            $result_select_photo = $conn->prepare($query_select_photo);
            $result_select_photo->bind_param('i', $member_id);
            $result_select_photo->execute();
            $row = $result_select_photo->get_result()->fetch_assoc();
            $old_photo = $row['Poto_Member'];

            if ($old_photo && file_exists("img/profile/" . $old_photo)) {
                unlink("img/profile/" . $old_photo);
            }

            $query_update = "UPDATE member SET Nama_member = ?, Alamat = ?, Email = ?, Nomor_Telepon = ?, Password_member = ?, Poto_Member = ? WHERE ID_Member = ?";
            $result_update = $conn->prepare($query_update);

            if ($result_update !== false) {
                $result_update->bind_param('ssssssi', $nama, $alamat, $email, $nomor, $pass, $photo, $id);

                if ($result_update->execute()) {
                    $success = true;
                    header("Location: account.php?success=$success&message=Member Updated!");
                    exit();
                } else {
                    $success = false;
                    header("Location: account.php?success=$success&error=Failed to Update!");
                    exit();
                }
            } else {
                echo "Error preparing the SQL statement.";
            }
        } else {
            echo "Error uploading the file.";
        }
    } else {
        // If no file is uploaded, update without changing the photo
        $query_update = "UPDATE member SET Nama_member = ?, Alamat = ?, Email = ?, Nomor_Telepon = ?, Password_member = ? WHERE ID_Member = ?";
        $result_update = $conn->prepare($query_update);

        if ($result_update !== false) {
            $result_update->bind_param('sssssi', $nama, $alamat, $email, $nomor, $pass, $id);

            if ($result_update->execute()) {
                $success = true;
                header("Location: account.php?success=$success&message=Member Updated!");
                exit();
            } else {
                $success = false;
                header("Location: account.php?success=$success&error=Failed to Update!");
                exit();
            }
        } else {
            echo "Error preparing the SQL statement.";
        }
    }
}
