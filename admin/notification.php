<?php
// Menggunakan PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Memuat autoload.php dari Composer
require 'E:\Ali\File Compiler\XAMPP\htdocs\Praktikum\Kelompok-2_UAS-RPL\admin\vendor\vendor\autoload.php';

// Memuat file koneksi database
include('../server/connection.php');

// Mendapatkan ID_Member dari request POST
if (!isset($_POST['id_member'])) {
    echo json_encode(['status' => 'error', 'message' => 'Member ID not found.']);
    exit;
}

$id_member = $_POST['id_member'];

// Query untuk mendapatkan data dari tabel sewa dan member berdasarkan ID_Member
$sql = "SELECT member.Nama_member, member.Email, sewa.Tanggal_Pinjam, sewa.Tanggal_Kembali, buku.Judul_Buku 
        FROM sewa 
        JOIN member ON sewa.ID_Member = member.ID_Member
        JOIN buku ON sewa.ID_Buku = buku.ID_Buku
        WHERE member.ID_Member = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Query preparation failed: ' . $conn->error]);
    exit;
}
$stmt->bind_param("i", $id_member);
$stmt->execute();
$result = $stmt->get_result();

$response = [];

// Cek apakah data ditemukan
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Hanya ambil satu hasil
    $nama_member = $row['Nama_member'];
    $email_member = $row['Email'];
    $tanggal_pinjam = $row['Tanggal_Pinjam'];
    $tanggal_kembali = $row['Tanggal_Kembali'];
    $judul_buku = $row['Judul_Buku'];

    // Hitung sisa hari pengembalian atau keterlambatan
    $tanggal_sekarang = new DateTime();
    $tanggal_kembali_dt = new DateTime($tanggal_kembali);
    $interval = $tanggal_sekarang->diff($tanggal_kembali_dt);
    $sisa_hari = $interval->format('%a'); // Mengambil hanya jumlah hari positif
    $is_late = $tanggal_kembali_dt < $tanggal_sekarang;
    $days_late = $is_late ? $sisa_hari : 0;

    // Buat instance PHPMailer
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mifauzi853@gmail.com';
        $mail->Password = 'xiat cgua ewzp tdnu';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Pengaturan penerima email
        $mail->setFrom('pitimoss@gmail.com', 'Pitimoss');
        $mail->addAddress($email_member, $nama_member);

        // Konten email
        $mail->isHTML(true);
        $mail->Subject = 'Book Return Reminder';
        $mail->Body = "
        <html>
        <head>
            <style>
                .email-container {
                    font-family: Arial, sans-serif;
                    color: #333;
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    border: 1px solid #ddd;
                    border-radius: 10px;
                }
                .email-header {
                    background-color: #f7f7f7;
                    padding: 10px 20px;
                    border-bottom: 1px solid #ddd;
                    text-align: center;
                }
                .email-header h1 {
                    margin: 0;
                    font-size: 24px;
                    color: #FA9828;
                }
                .email-body {
                    padding: 20px;
                    line-height: 1.6;
                }
                .email-footer {
                    background-color: #f7f7f7;
                    padding: 10px 20px;
                    border-top: 1px solid #ddd;
                    text-align: center;
                    font-size: 12px;
                }
                .email-footer p {
                    margin: 0;
                }
            </style>
        </head>
        <body>
            <div class='email-container'>
                <div class='email-header'>
                    <h1>Book Return Reminder</h1>
                </div>
                <div class='email-body'>
                    <p>Dear <strong>$nama_member</strong>,</p>
                    <p>Please remember to return the book you borrowed. Here are the details of your loan:</p>
                    <ul>
                        <li><strong>Book Title:</strong> $judul_buku</li>
                        <li><strong>Borrow Date:</strong> $tanggal_pinjam</li>
                        <li><strong>Return Date:</strong> $tanggal_kembali</li>
                    </ul>
                    <p>" . ($is_late ? "You are <strong>$days_late days late</strong> in returning the book." : "Days remaining: <strong>$sisa_hari</strong> days.") . "</p>
                    <p>Thank you for using our services. We hope you enjoyed the book.</p>
                </div>
                <div class='email-footer'>
                    <p>&copy; " . date('Y') . " Pitimoss. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>";

        // Kirim email
        $mail->send();
        $response[] = ['status' => 'success', 'message' => "Notification sent to $email_member"];
    } catch (Exception $e) {
        $response[] = ['status' => 'error', 'message' => "Email could not be sent to $email_member. Error: {$mail->ErrorInfo}"];
    }
} else {
    $response[] = ['status' => 'error', 'message' => 'No data found.'];
}

echo json_encode($response);

// Tutup koneksi
$conn->close();