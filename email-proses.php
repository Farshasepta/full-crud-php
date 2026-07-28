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
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port       = 587;

if (isset($_POST['kirim'])) {
    // recipients
    $mail->setForm('farshasepta064@gmail.com', 'farshaSepta080609');
    $mail->addAddress($_POST['email_penerima']);
    $mail->addReplyTo('farshasepta064@gmail.com', 'farshaSepta080609');

    $mail->Subject = $_POST['subject'];
    $mail->Body = $_POST['pesan'];

    if ($mail->send()) {
        echo "<script>
                alert('Email Berhasil Dikirimkan');
                document.location.href = 'email.php'
            </script>";
    } else {
         echo "<script>
                alert('Email Gagal Dikirimkan');
                document.location.href = 'email.php'
            </script>";
    }

    exit();
}