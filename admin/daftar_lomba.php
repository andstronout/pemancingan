<?php
session_start();
require "../config.php";
if (!isset($_SESSION["login_admin"])) {
  header("location:../login.php");
}
$now = date("Y-m-d");
$sql_user = sql("SELECT * FROM user WHERE `level`='1'");
$no = 1;

if (isset($_POST["input"])) {
  if (!empty($_POST["durasi"])) {
    $saveberat = saveBerat();
  } else {
    echo "<script>alert('Berat dan durasi tidak boleh kosong!');</script>";
  }
}

if (isset($_POST["ubahBerat"])) {
  $saveberat = saveBerat();
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
          <h1 class="m-0">Kelola Lomba</h1>
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
              <label for="">Cari Tanggal</label>
              <input type="date" class="form-control mb-2" name="t_awal">
              <button type="submit" class="btn btn-success btn-sm" name="simpan">Cari</button>
              <button type="submit" class="btn btn-outline-danger btn-sm" name="reset">Reset Tanggal</button>
            </div>
            <div class="col-auto mt-4">
            </div>
          </form>
          <?php
          if (isset($_POST['simpan']) && !empty($_POST['t_awal'])) {
            $_SESSION["awal"] = $_POST["t_awal"];
            $sql_produk = sql("SELECT * FROM orders 
                INNER JOIN user ON orders.id_pelanggan=user.id_user WHERE tanggal='$_SESSION[awal]' AND `status` IN ('Fishing', 'Done')
                ORDER BY tanggal
                ");
          } elseif (isset($_POST['reset'])) {
            unset($_SESSION["awal"]);
          } elseif (isset($_SESSION["awal"])) {
            $sql_produk = sql("SELECT * FROM orders 
                INNER JOIN user ON orders.id_pelanggan=user.id_user WHERE tanggal='$_SESSION[awal]' AND `status` IN ('Fishing', 'Done')
                ORDER BY tanggal
                ");
          }
          ?>
          <br>
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#exampleModal">
            Cari Pemenang
          </button>

          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Cari Pemenang</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  Pilih tanggal
                  <form action="proses_pemenang.php" method="post">
                    <input type="date" class="form-control" name="caritanggal" id="" required>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" name="cari" class="btn btn-primary" onclick="return confirm('Apakah semua pemancing sudah done?')">Cari</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <?php if (isset($sql_produk)) : ?>
              <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th width=5%>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal Transaksi</th>
                    <th>Nomor Tiket</th>
                    <th style="width: 65px;">Berat</th>
                    <th style="width: 130px;">Durasi (Jam/Menit)</th>
                    <th width=12% class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($sql_produk as $transaksi) : ?>
                    <tr>
                      <th class="text-center"><?= $no++; ?></th>
                      <th><?= $transaksi['nama_user']; ?></th>
                      <th><?= $transaksi['tanggal']; ?></th>
                      <th><?= $transaksi['no_tiket']; ?></th>

                      <td class="text-center">
                        <form action="" method="post">
                          <input type="hidden" name="id" value="<?= $transaksi['id']; ?>">

                          <!-- Menampilkan input jika berat kosong -->
                          <?php if (empty($transaksi['berat'])) { ?>
                            <input type="number" name="berat" step="0.01" min="0" style="width: 70%;"> Kg
                          <?php } else { ?>
                            <?= $transaksi['berat']; ?> Kg
                          <?php } ?>
                      </td>

                      <td class="text-center">
                        <!-- Menampilkan input jika durasi kosong -->
                        <?php if (empty($transaksi['durasi'])) { ?>
                          <input type="number" name="durasi" step="0.01" min="0" style="width: 40%; margin-right:7px;" required> Jam/Menit
                        <?php } else { ?>
                          <?= $transaksi['durasi']; ?>
                        <?php } ?>
                      </td>

                      <td class="text-center">
                        <!-- Menampilkan tombol GO jika salah satu dari berat atau durasi kosong -->
                        <?php if (empty($transaksi['berat']) || empty($transaksi['durasi'])) { ?>
                          <button class="btn btn-sm btn-warning" type="submit" name="input">GO</button>
                        <?php } else { ?>
                          <?= $transaksi['status']; ?>
                        <?php } ?>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach ?>
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
        extend: 'pdfHtml5',
        text: 'Cetak Form', // Ubah teks tombol di sini
        className: 'btn btn-warning',
        title: 'Form Pemancingan <?= $_SESSION["awal"]; ?>',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5]
        },
        customize: function(doc) {
          // Loop through the table body content
          for (var i = 1; i < doc.content[1].table.body.length; i++) {
            // Kosongkan kolom 4 dan 5
            doc.content[1].table.body[i][4].text = '';
            doc.content[1].table.body[i][5].text = '';
          }
        }
      }]
    });
  });
</script>
</body>

</html>