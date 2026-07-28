<?php

session_start();

if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('login dulu');
            document.location.href = 'login.php';
        </script>";
    exit;
}

if ($_SESSION["level"] != 1 and $_SESSION["level"] != 3) {
    echo "<script>
            alert('Anda tidak punya hak akses');
            document.location.href = 'crud-modal.php';
        </script>";
    exit;
}

$title = 'Data Pegawai';

require_once 'config/app.php';

// Filter dari GET
$nama      = isset($_GET['nama']) ? $_GET['nama'] : '';
$jabatan   = isset($_GET['jabatan']) ? $_GET['jabatan'] : '';
$tgl_awal  = isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '';
$tgl_akhir = isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '';

$query = "SELECT * FROM pegawai WHERE 1=1";
if ($nama != '')     $query .= " AND nama LIKE '%$nama%'";
if ($jabatan != '')  $query .= " AND jabatan LIKE '%$jabatan%'";
if ($tgl_awal != '') $query .= " AND tanggal_masuk >= '$tgl_awal'";
if ($tgl_akhir != '') $query .= " AND tanggal_masuk <= '$tgl_akhir'";
$query .= " ORDER BY id_pegawai DESC";

$data_pegawai = select($query);

if (isset($_GET['hapus'])) {
    if (delete_pegawai((int)$_GET['hapus']) > 0) {
        echo "<script>
                alert('Data Pegawai Berhasil Dihapus');
                document.location.href = 'pegawai.php';
              </script>";
        exit;
    }
}

if (isset($_POST['ubah'])) {
    if (update_pegawai($_POST) > 0) {
        echo "<script>
                alert('Data Pegawai Berhasil Diubah');
                document.location.href = 'pegawai.php';
              </script>";
        exit;
    }
}

include 'layout/header.php';
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-users"></i> Data Pegawai</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Data Pegawai</li>
                    </ol>
                </div>
            </div>

            <!-- Filter Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter mr-1"></i> Filter Data
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form method="get" action="pegawai.php">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="nama" class="form-control" placeholder="Cari Nama..." value="<?= htmlspecialchars($nama); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Jabatan</label>
                                    <input type="text" name="jabatan" class="form-control" placeholder="Cari Jabatan..." value="<?= htmlspecialchars($jabatan); ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Tanggal Awal</label>
                                    <input type="date" name="tgl_awal" class="form-control" value="<?= $tgl_awal; ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" name="tgl_akhir" class="form-control" value="<?= $tgl_akhir; ?>">
                                </div>
                            </div>
                            <div class="col-md-2" style="display: flex; align-items: flex-end;">
                                <div class="form-group w-100">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-search"></i> Tampilkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.card -->

            <!-- Table Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabel Data Pegawai</h3>
                </div>
                <div class="card-body">
                    <table id="pegawaiTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th>Tanggal Masuk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($data_pegawai as $pegawai) : ?>
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
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card -->

        </div>
    </div>
</div>

<?php foreach ($data_pegawai as $pegawai) : ?>
<div class="modal fade" id="modalUbah<?= $pegawai['id_pegawai']; ?>" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title">Edit Data Pegawai</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <input type="hidden" name="id_pegawai" value="<?= $pegawai['id_pegawai']; ?>">
          <div class="form-group"><label>Nama</label><input type="text" name="nama" class="form-control" value="<?= $pegawai['nama']; ?>" required></div>
          <div class="form-group"><label>Jabatan</label><input type="text" name="jabatan" class="form-control" value="<?= $pegawai['jabatan']; ?>" required></div>
          <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" value="<?= $pegawai['email']; ?>" required></div>
          <div class="form-group"><label>Telepon</label><input type="text" name="telepon" class="form-control" value="<?= $pegawai['telepon']; ?>" required></div>
          <div class="form-group"><label>Alamat</label><textarea name="alamat" class="form-control" rows="3" required><?= $pegawai['alamat']; ?></textarea></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" name="ubah" class="btn btn-success">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php endforeach; ?>

<?php include 'layout/footer.php'; ?>
