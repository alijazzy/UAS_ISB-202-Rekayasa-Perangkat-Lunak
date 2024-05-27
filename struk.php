<?php
    include('server/connection.php');

    if (isset($_GET['id_sewa'])) {
        $book_id = $_GET['id_buku'];

        $query = "SELECT * FROM buku WHERE ID_Buku = '$book_id'";

        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        $judul = $row['Judul_Buku'];
        $pengarang = $row['Pengarang'];
        $penerbit = $row['Penerbit'];
        $genre = $row['Kategori_Buku'];
        $jenis = $row['Jenis_Buku'];
        $tahun = $row['Tahun_Terbit'];
        $harga = $row['Harga_Buku'];
        $sampul = $row['Sampul_Buku'];
        $desc  = $row['Deskripsi'];
        $status = $row['Status'];

    } else {
        // no product id was given
        header('location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>

    <link rel="stylesheet" href="css/styleStruk.css" type="text/css">
    <link rel="icon" href="img/icon/pitimoss_logo.png" type="image/png">
</head>
<body>
<div id="invoice-POS">
    <div id="top" class="clearfix">
        <div class="logo-container">
            <div class="logo"></div>
        </div>
    </div><!--End InvoiceTop-->
  
  <div id="mid">
    <div class="info">
      <h2>Member Info</h2>
      <p>
        <span class="label">Address:</span> street city, state 0000<br>
        <span class="label">Email:</span> JohnDoe@gmail.com<br>
        <span class="label">Phone:</span> 555-555-5555<br>
        </p>
    </div>
  </div><!--End Invoice Mid-->
  
  <div id="bot">
    <div id="table">
      <table>
        <tr class="tabletitle">
          <td class="item"><h2>Book</h2></td>
          <td class="Rate"><h2>Rent Price</h2></td>
        </tr>

        <tr class="service">
          <td class="tableitem"><p class="itemtext">Communication</p></td>
          <td class="tableitem"><p class="itemtext">$375.00</p></td>
        </tr>

        <tr class="tabletitle">
          <td class="Rate"><h2>Tax</h2></td>
          <td class="payment"><h2>$419.25</h2></td>
        </tr>

        <tr class="tabletitle">
          <td class="Rate"><h2>Total</h2></td>
          <td class="payment"><h2>$3,644.25</h2></td> 
        </tr>
      </table>
    </div><!--End Table-->

    <div id="legalcopy">
      <p class="legal"><strong>Thank you for your business!</strong> Book retrieval is expected within 24 hours; please take your book that time. The invoice will be cancelled.</p>
    </div>
  </div><!--End InvoiceBot-->
</div><!--End Invoice-->

</body>
</html>