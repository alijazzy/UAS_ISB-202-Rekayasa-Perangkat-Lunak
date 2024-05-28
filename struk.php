<?php
include('server/connection.php');
session_start(); // Ensure you start the session to use session variables

if (isset($_GET['id_sewa'])) {
    $id_sewa = $_GET['id_sewa'];

    // Get the transaction ID
    $query = "SELECT ID_Transaksi, Tanggal_Kembali FROM sewa WHERE ID_Sewa = '$id_sewa'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $id_transaksi = $row['ID_Transaksi'];

        // Fetch book and rent price details
        $query_struk = "SELECT Judul_Buku, Harga_Buku FROM buku b JOIN sewa s ON b.ID_Buku = s.ID_Buku WHERE s.ID_Transaksi = '$id_transaksi'";
        $result2 = mysqli_query($conn, $query_struk);

        // Fetch transaction details
        $query_transaksi = "SELECT * FROM transaksi WHERE ID_Transaksi = '$id_transaksi'";
        $result_transaksi = mysqli_query($conn, $query_transaksi);
        $row_transaksi = mysqli_fetch_assoc($result_transaksi);

        // Fetch member details
        $id_member = $_SESSION['member_id'];
        $query_member = "SELECT * FROM member WHERE ID_Member = '$id_member'";
        $result3 = mysqli_query($conn, $query_member);
        $rowm = mysqli_fetch_assoc($result3);
    } else {
        // Redirect if no valid transaction found
        header('location: index.php');
        exit();
    }
} else {
    // Redirect if no rental id provided
    header('location: index.php');
    exit();
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
                <span class="label"><strong>Address:</strong></span> <?php echo $rowm['Alamat']; ?><br>
                <span class="label"><strong>Email:</strong></span> <?php echo $rowm['Email']; ?><br>
                <span class="label"><strong>Phone:</strong></span> <?php echo $rowm['Nomor_Telepon']; ?><br>
                <span class="label"><strong>Transaction Date:</strong></span> <?php echo $row_transaksi['Tanggal_transaksi']; ?><br>
            </p>
            <h2><strong>INVOICE NUMBER: </strong><span><?php echo $row_transaksi['Kode_Pengambilan']; ?></span></h2>
        </div>
    </div><!--End Invoice Mid-->
  
    <div id="bot">
        <div id="table">
            <table>
                <tr class="tabletitle">
                    <td class="item"><h2>Book</h2></td>
                    <td class="Rate"><h2>Rent Price</h2></td>
                </tr>

                <?php while($row2 = mysqli_fetch_assoc($result2)): ?>
                <tr class="service">
                    <td class="tableitem"><p class="itemtext"><?php echo $row2['Judul_Buku']; ?></p></td>
                    <td class="tableitem"><p class="itemtext"><?php echo 'Rp. ' . number_format($row2['Harga_Buku']); ?></p></td>
                </tr>
                <?php endwhile; ?>

                <tr class="tabletitle">
                    <td class="Rate"><h2>Return Date</h2></td>
                    <td class="payment"><h2><?php echo $row['Tanggal_Kembali']; ?></h2></td>
                </tr>

                <tr class="tabletitle">
                    <td class="Rate"><h2>Total Rent</h2></td>
                    <td class="payment"><h2><?php echo 'Rp. ' . number_format($row_transaksi['Total_harga']); ?></h2></td> 
                </tr>
            </table>
        </div><!--End Table-->

        <div id="legalcopy">
            <p class="legal"><strong>Thank you for your business!</strong> Book retrieval is expected within 24 hours; please take your book on that time period, or else the invoice will be cancelled.</p>
        </div>
    </div><!--End InvoiceBot-->
</div><!--End Invoice-->
<div class="button-container">
    <button onclick="window.location.href='account.php'" class="btn btn-primary">Back to Account</button>
   </div>
</body>
</html>
