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

// membatasi halaman seusai user login
if ($_SESSION["level"] != 1 and $_SESSION["level"] != 2) {
    echo "<script>
            alert('PERHATIAN anda tidak punya hak akses');
            document.location.href = 'crud-modal.php';
        </script>";
    exit;
}

$title = 'Data Barang';

require_once 'config/app.php';

$tgl_awal  = '';
$tgl_akhir = '';

// pagination
$jumlahDataPerhalaman = 5;
$halamanAktif = (isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1);
$awalData     = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;

if(isset($_POST['filter'])) {
  $tgl_awal  = strip_tags($_POST['tgl_awal']);
  $tgl_akhir = strip_tags($_POST['tgl_akhir']);

  $tgl_awal_full  = $tgl_awal . " 00:00:00";
  $tgl_akhir_full = $tgl_akhir . " 23:59:59";

  $jumlahData    = count(select("SELECT * FROM barang WHERE tanggal BETWEEN '$tgl_awal_full' AND '$tgl_akhir_full'"));
  $jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);

  $data_barang = select("SELECT * FROM barang WHERE tanggal BETWEEN '$tgl_awal_full' AND '$tgl_akhir_full' ORDER BY id_barang DESC LIMIT $awalData, $jumlahDataPerhalaman");
} else {
  $jumlahData    = count(select("SELECT * FROM barang"));
  $jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);

  $data_barang = select("SELECT * FROM barang ORDER BY id_barang DESC LIMIT $awalData, $jumlahDataPerhalaman");
}
include 'layout/header.php';


?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3>150</h3>
                <p>New Orders</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>
                <p>Bounce Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>
                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>
                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        <!-- /.row -->

        <!-- Data Barang -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Barang</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalFilter">
                    <i class="fas fa-filter"></i> Filter Data
                  </button>
                  <a href="tambah-barang.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
                </div>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Jumlah</th>
                      <th>Harga</th>
                      <th>Barcode</th>
                      <th>Tanggal</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($data_barang as $barang) : ?>
                      <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $barang['nama']; ?></td>
                        <td><?= $barang['jumlah']; ?></td>
                        <td>Rp. <?= number_format($barang['harga'], 0, ',', '.'); ?></td>
                        <td class="text-center">
                          <img alt="barcode" src="barcode.php?codetype=Code128&size=15&text=<?= $barang['barcode']; ?>&print=true" />
                        </td>
                        <td><?= date("d/m/Y | H:i:s", strtotime($barang['tanggal'])); ?></td>
                        <td width="15%" class="text-center">
                          <a href="ubah-barang.php?id_barang=<?= $barang['id_barang']; ?>" class="btn btn-success btn-sm">Edit</a>
                          <a href="hapus-barang.php?id_barang=<?= $barang['id_barang']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Data Barang Akan Dihapus?');">Hapus</a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                
                <div class="mt-2 justify-content-end d-flex">
                  <nav aria-label="Page navigation example">
                    <ul class="pagination">
                      <?php if ($halamanAktif > 1) : ?>
                        <li class="page-item">
                          <a class="page-link" href="?halaman=<?= $halamanAktif - 1 ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                          </a>
                        </li>
                      <?php endif; ?>

                      <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                        <?php if ($i == $halamanAktif) : ?>
                          <li class="page-item active"><span class="page-link"><?= $i; ?></span></li>
                        <?php else : ?>
                          <li class="page-item"><a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
                        <?php endif; ?>
                      <?php endfor; ?>

                      <?php if ($halamanAktif < $jumlahHalaman) : ?>
                        <li class="page-item">
                          <a class="page-link" href="?halaman=<?= $halamanAktif + 1 ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                          </a>
                        </li>
                      <?php endif; ?>
                    </ul>
                  </nav>
                </div>
                
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <!-- Modal Filter -->
  <div class="modal fade" id="modalFilter" tabindex="-1" aria-labelledby="modalFilterLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title" id="modalFilterLabel"><i class="fas fa-filter"></i> Filter Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <div class="form-group">
              <label for="tgl_awal">Tanggal Awal</label>
              <input type="date" name="tgl_awal" id="tgl_awal" class="form-control" value="<?= $tgl_awal; ?>">
            </div>
            <div class="form-group">
              <label for="tgl_akhir">Tanggal Akhir</label>
              <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" value="<?= $tgl_akhir; ?>">
            </div>
          </div>
          <div class="modal-footer">
            <a href="index.php" class="btn btn-secondary">Reset</a>
            <button type="submit" name="filter" class="btn btn-success"><i class="fas fa-search"></i> Tampilkan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<?php include 'layout/footer.php'; ?>