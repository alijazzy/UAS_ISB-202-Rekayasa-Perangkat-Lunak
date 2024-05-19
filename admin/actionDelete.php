<?php
include('../server/connection.php');

$id = $_GET['ID_Member'];
$photo = $_GET['Poto_Member'];

// Query Delete Data 
$query1 = "DELETE FROM sewa WHERE ID_Member = '$id'";
$result1 = mysqli_query($conn, $query1);
$query2 = "DELETE FROM transaksi WHERE ID_Member = '$id'";
$result2 = mysqli_query($conn, $query2);
$query3 = "DELETE FROM member WHERE ID_Member = '$id'";
$result3 = mysqli_query($conn, $query3);

if ($result3) {
  // Delete the file
  $path = "img/" . $photo;

  if (file_exists($path)) {
    if (unlink($path)) {
      $success = true;
      header("location:customers.php?success=$success&message=Member Deleted!");
      exit();
    } else {
      $success = false;
      header("location:customers.php?success=$success&error=Failed to delete photo!");
      exit();
    }
  } else {
    $success = false;
    header("location:customers.php?success=$success&error=Photo not found!");
    exit();
  }
} else {
  $success = false;
  header("location:customers.php?success=$success&error=Failed to delete member: " . mysqli_error($conn));
  exit();
}
?>