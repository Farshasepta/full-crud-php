<?php

session_start();

if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('login dulu');
            document.location.href = 'login.php';
        </script>";
    exit;
}

$title = 'Kirim Email';

require_once 'config/app.php';
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
// server settings
$mail->SMTPDebug = 2;
$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'farshasepta064@gmail.com';
$mail->Password   = 'fdnkpasofgflzavw';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;

if (isset($_POST['tambah'])) {
    // recipients
    $mail->setFrom('farshasepta064@gmail.com', 'Admin');
    $mail->addAddress($_POST['email_penerima']);
    $mail->addReplyTo('farshasepta064@gmail.com', 'Admin');

    $mail->Subject = $_POST['subject'];
    $mail->Body    = $_POST['pesan'];

    if ($mail->send()) {
        echo "<script>
                alert('Email Berhasil Dikirimkan');
                document.location.href = 'email.php';
            </script>";
    } else {
        echo "<script>
                alert('Email Gagal Dikirimkan');
                document.location.href = 'email.php';
            </script>";
    }

    exit();
}

include 'layout/header.php';
?>

<div class="content-wrapper">
    <div class="container mt-5">
        <h1><i class="fas fa-envelope"></i> Kirim Email</h1>
        <hr>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="mb-3">
                <label for="email penerima" class="form-label">Email Penerima</label>
                <input type="text" class="form-control" id="email penerima" name="email penerima" placeholder="Email Penerima..." required>
            </div>
            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject..." required>
            </div>
            <div class="mb-3">
                <label for="pesan" class="form-label">Pesan</label>
                <textarea id="pesan" name="pesan" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <button type="submit" name="tambah" class="btn btn-primary" style="float: right;">Kirim</button>
        </form>
    </div>
</div>

<?php include 'layout/footer.php'; ?>'layout/footer.php'; ?>?>