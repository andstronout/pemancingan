<?php
session_start();
require "../config.php";
if (!isset($_SESSION["login_admin"])) {
  header("location:../login.php");
}

$sql_user = sql("SELECT * FROM user WHERE `level`='1'");
$no = 1;
$sql_produk = sql("SELECT * FROM produk_jual");
$now = date('Y-m-d');

if (isset($_POST["simpan"])) {
  $jual = savedaftarJual();
}

include "header.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Penjualan Barang</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row">
        <!-- Content Row -->
        <!-- Data Table -->
        <div class="card-body">
          <form class="row g-3" action="" method="post">
            <div class="col-auto">
              <label for="">Dari Tanggal</label>
              <input type="date" class="form-control" name="ts_awal" required>
            </div>
            <div class="col-auto">
              <label for="">Ke Tanggal</label>
              <input type="date" class="form-control" name="ts_akhir" required>
            </div>
            <div class="col-auto mt-4">
              <button type="submit" class="btn btn-primary btn-sm" name="simpan_tanggal">Cari</button>
              <a href="daftar_sewa.php" class="btn btn-outline-success text-white btn-sm">Reset</a>
            </div>
          </form>
          <?php
          if (isset($_POST['simpan_tanggal'])) {
            $_SESSION["sawal"] = $_POST["ts_awal"];
            $_SESSION["sakhir"] = $_POST["ts_akhir"];
            $sql_jual = sql("SELECT * FROM jual INNER JOIN produk_jual ON jual.id_produk=produk_jual.   id_produk  WHERE jual.tanggal BETWEEN '$_SESSION[sawal]' AND '$_SESSION[sakhir]' ORDER BY jual.tanggal");
          } else {
            $sql_jual = sql("SELECT * FROM jual  INNER JOIN produk_jual ON jual.id_produk=produk_jual.   id_produk ORDER BY `jual`.`tanggal` DESC");
          }
          ?>
          <br>
          <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#exampleModal">
            Tambah Jual
          </button>

          <!-- Modal Tambah Produk -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="" method="post">
                    <label for="nama_penyewa">Nama Penyewa</label>
                    <input type="text" name="nama_user" id="nama_penyewa" class="form-control mb-2" required placeholder="Masukkan Nama Penyewa">
                    <label for="harga">Jenis Produk</label>
                    <select class="form-select" aria-label="Default select example" name="id_produk">
                      <option disabled>- Pilih Jenis Produk -</option>
                      <?php foreach ($sql_produk as $produk) : ?>
                        <option value="<?= $produk['id_produk']; ?>"><?= $produk['nama_produk']; ?></option>
                      <?php endforeach ?>
                    </select>
                    <label for="harga">Tanggal Beli</label>
                    <input type="date" name="tanggal" class="form-control" id="tanggal" value="<?= $now; ?>">
                    <label for="no_tiket">Nomor Bangku</label>
                    <input type="text" name="no_tiket" id="no_tiket" class="form-control mb-2" required placeholder="Masukkan Nomor Bangku">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  <button type="submit" name="simpan" class="btn btn-primary">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <?php if (isset($sql_jual)) : ?>
              <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th width=5%>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal Transaksi</th>
                    <th>Nomor Bangku</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($sql_jual as $transaksi) : ?>
                    <tr>
                      <th class="text-center"><?= $no; ?></th>
                      <th><?= $transaksi['nama_user']; ?></th>
                      <th><?= $transaksi['tanggal']; ?></th>
                      <th><?= $transaksi['no_tiket']; ?></th>
                      <th><?= $transaksi['nama_produk']; ?></th>
                      <th>Rp. <?= number_format($transaksi['harga']); ?></th>
                      <th class="text-center">
                        <?php if ($transaksi['status'] == 'Belum Diproses') { ?>
                          <a href="proses_jual.php?id=<?= $transaksi['id_jual']; ?>" class="btn btn-info btn-sm" onclick="return confirm('Are you sure?')">
                            <span class="text">Belum Diproses</span>
                          </a>
                        <?php } elseif ($transaksi['status'] == 'In Use') { ?>
                          <a href="proses_jual.php?id=<?= $transaksi['id_jual']; ?>" class="btn btn-primary btn-sm" onclick="return confirm('Are you sure?')">
                            <span class="text">In Use</span>
                          </a>
                        <?php } else { ?>
                          <span><?= $transaksi['status']; ?></span>
                        <?php } ?>
                      </th>
                    </tr>
                  <?php
                    $no++;
                  endforeach ?>
                </tbody>
              </table>
            <?php else : ?>
              <p class="text-center">Tidak ada data untuk ditampilkan</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- Main Footer -->
<footer class="main-footer">
  <strong>Copyright &copy; 2024 BangJohn Sport Fishing Copyright</strong>
  All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>

<!-- PAGE ../PLUGINS -->
<!-- jQuery Mapael -->
<script src="../plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="../plugins/raphael/raphael.min.js"></script>
<script src="../plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="../plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../dist/js/pages/dashboard2.js"></script>

<!-- Datatables -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/datatables.min.js"></script>

<script>
  $(document).ready(function() {
    $('#myTable').DataTable({
      dom: 'Bfrtip',
      buttons: [{
          extend: 'excelHtml5',
          title: 'Data Pelanggan',
          exportOptions: {
            columns: [0, 1, 2, 3]
          }
        },
        {
          extend: 'pdfHtml5',
          title: 'Data Pelanggan',
          exportOptions: {
            columns: [0, 1, 2, 3]
          }
        }
      ]
    });
  });
</script>
</body>

</html>