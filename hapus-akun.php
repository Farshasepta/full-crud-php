<?php

session_start();
// membatasi halaman sebelum login
if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('login dulu');
            document.location.href = 'login.php';
        </script>";
    exit;
}

include 'config/app.php';

// membatasi halaman sesuai user login
if ($_SESSION["level"] != 1) {
    echo "<script>
            alert('Anda tidak punya hak akses');
            document.location.href = 'index.php';
        </script>";
    exit;
}

// menerima id akun yang dipilih pengguna
$id_akun = (int)$_GET['id_akun'];

if(delete_akun($id_akun) > 0) {
    echo "<script>
                alert('Data Akun Berhasil Dihapus');
                document.location.href = 'index.php';
                </script>";
} else {
    echo "<script>
                alert('Data Akun Gagal Dihapus');
                document.location.href = 'index.php';
                </script>";
}
