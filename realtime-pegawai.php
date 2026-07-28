<?php

include 'config/app.php';

$nama      = isset($_GET['nama']) ? $_GET['nama'] : '';
$jabatan   = isset($_GET['jabatan']) ? $_GET['jabatan'] : '';
$tgl_awal  = isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '';
$tgl_akhir = isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '';

$query = "SELECT * FROM pegawai WHERE 1=1";

if ($nama != '') {
    $query .= " AND nama LIKE '%$nama%'";
}
if ($jabatan != '') {
    $query .= " AND jabatan LIKE '%$jabatan%'";
}
if ($tgl_awal != '') {
    $query .= " AND tanggal_masuk >= '$tgl_awal'";
}
if ($tgl_akhir != '') {
    $query .= " AND tanggal_masuk <= '$tgl_akhir'";
}

$query .= " ORDER BY id_pegawai DESC";

$data_pegawai = select($query);

$no = 1;
foreach ($data_pegawai as $pegawai) :
?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $pegawai['nama']; ?></td>
        <td><?= $pegawai['jabatan']; ?></td>
        <td><?= $pegawai['email']; ?></td>
        <td><?= $pegawai['telepon']; ?></td>
        <td><?= $pegawai['alamat']; ?></td>
        <td><?= $pegawai['tanggal_masuk'] ? date('d/m/Y', strtotime($pegawai['tanggal_masuk'])) : '-'; ?></td>
        <td class="text-center">
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalUbah<?= $pegawai['id_pegawai']; ?>">
                <i class="fas fa-edit"></i> Edit
            </button>
            <a href="?hapus=<?= $pegawai['id_pegawai']; ?>" class="btn btn-danger btn-sm"
               onclick="return confirm('Yakin ingin menghapus data <?= $pegawai['nama']; ?>?')">
                <i class="fas fa-trash"></i> Hapus
            </a>
        </td>
    </tr>
<?php endforeach; ?>
