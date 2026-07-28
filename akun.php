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

$title = 'Data Akun';

require_once 'config/app.php';

// tampil seluruh data
$data_akun = select("SELECT * FROM akun");

// tampil data berdasarkan user login
$id_akun = $_SESSION['id_akun'];
$data_bylogin = select("SELECT * FROM akun WHERE id_akun = $id_akun");

// jika tombol tambah di tekan
if (isset($_POST['tambah'])) {
    if (create_akun($_POST) > 0) {
        echo "<script>
                alert('Data Akun Berhasil Ditambahkan');
                document.location.href = 'akun.php';
            </script>";
    } else {
        echo "<script>
                alert('Data Akun Gagal Ditambahkan');
                document.location.href = 'akun.php';
            </script>";
    }
}

// jika tombol ubah di tekan
if (isset($_POST['ubah'])) {
    if (update_akun($_POST) > 0) {
        echo "<script>
                alert('Data Akun Berhasil Diubah');
                document.location.href = 'akun.php';
            </script>";
    } else {
        echo "<script>
                alert('Data Akun Gagal Diubah');
                document.location.href = 'akun.php';
            </script>";
    }
}

include 'layout/header.php';
?>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><i class="nav-icon fas fa-user-cog"></i> Data Akun</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Data Akun</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tabel Data Akun</h3>
                <div class="card-tools">
                  <?php if ($_SESSION['level'] == 1) : ?>
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">
                    <i class="fas fa-plus"></i> Tambah
                  </button>
                  <?php endif; ?>
                </div>
              </div>
              <div class="card-body">
                <table id="akunTable" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Username</th>
                      <th>Email</th>
                      <th>Password</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1; ?>
                    <?php if ($_SESSION['level'] == 1) : ?>
                      <?php foreach ($data_akun as $akun) : ?>
                        <tr>
                          <td><?= $no++; ?></td>
                          <td><?= $akun['nama']; ?></td>
                          <td><?= $akun['username']; ?></td>
                          <td><?= $akun['email']; ?></td>
                          <td>Password Ter-enkripsi</td>
                          <td class="text-center">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalUbah<?= $akun['id_akun']; ?>">
                              <i class="fas fa-edit"></i> Ubah
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapus<?= $akun['id_akun']; ?>">
                              <i class="fas fa-trash"></i> Hapus
                            </button>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <?php foreach ($data_bylogin as $akun) : ?>
                        <tr>
                          <td><?= $no++; ?></td>
                          <td><?= $akun['nama']; ?></td>
                          <td><?= $akun['username']; ?></td>
                          <td><?= $akun['email']; ?></td>
                          <td>Password Ter-enkripsi</td>
                          <td class="text-center">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalUbah<?= $akun['id_akun']; ?>">
                              <i class="fas fa-edit"></i> Ubah
                            </button>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="modalTambahLabel">Tambah Akun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required minlength="6">
          </div>
          <div class="form-group">
            <label for="level">Level</label>
            <select name="level" id="level" class="form-control" required>
              <option value="">-- Pilih Level --</option>
              <option value="1">Admin</option>
              <option value="2">Operator Barang</option>
              <option value="3">Operator Mahasiswa</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php foreach ($data_akun as $akun) : ?>
<!-- Modal Hapus -->
<div class="modal fade" id="modalHapus<?= $akun['id_akun']; ?>" tabindex="-1" aria-labelledby="modalHapusLabel<?= $akun['id_akun']; ?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title" id="modalHapusLabel<?= $akun['id_akun']; ?>">Hapus Akun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Yakin ingin menghapus akun <strong><?= $akun['nama']; ?></strong>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <a href="hapus-akun.php?id_akun=<?= $akun['id_akun']; ?>" class="btn btn-danger">Hapus</a>
      </div>
    </div>
  </div>
</div>

<!-- Modal Ubah -->
<div class="modal fade" id="modalUbah<?= $akun['id_akun']; ?>" tabindex="-1" aria-labelledby="modalUbahLabel<?= $akun['id_akun']; ?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title" id="modalUbahLabel<?= $akun['id_akun']; ?>">Ubah Akun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <input type="hidden" name="id_akun" value="<?= $akun['id_akun']; ?>">
          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="<?= $akun['nama']; ?>" required>
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="<?= $akun['username']; ?>" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= $akun['email']; ?>" required>
          </div>
          <div class="form-group">
            <label for="password">Password <small>(Kosongkan jika tidak diubah)</small></label>
            <input type="password" name="password" id="password" class="form-control" minlength="6">
          </div>
          <?php if ($_SESSION['level'] == 1) : ?>
          <div class="form-group">
            <label for="level">Level</label>
            <select name="level" id="level" class="form-control" required>
              <?php $level = $akun['level']; ?>
              <option value="1" <?= $level == '1' ? 'selected' : '' ?>>Admin</option>
              <option value="2" <?= $level == '2' ? 'selected' : '' ?>>Operator Barang</option>
              <option value="3" <?= $level == '3' ? 'selected' : '' ?>>Operator Mahasiswa</option>
            </select>
          </div>
          <?php else : ?>
          <input type="hidden" name="level" value="<?= $akun['level']; ?>">
          <?php endif; ?>
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
