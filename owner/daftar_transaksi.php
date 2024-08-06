<?php
session_start();
require "../config.php";
if (!isset($_SESSION["login_owner"])) {
  header("location:../login.php");
}

$sql_user = sql("SELECT * FROM user WHERE `level`='1'");
$no = 1;

include "header.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Check In Lomba</h1>
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
              <input type="date" class="form-control mb-2" name="t_hadir">
              <button type="submit" class="btn btn-success btn-sm" name="simpan">Simpan</button>
              <button type="submit" class="btn btn-outline-danger btn-sm" name="reset">Reset Tanggal</button>
            </div>
            <div class="col-auto mt-4">
            </div>
          </form>
          <?php
          if (isset($_POST['simpan']) && !empty($_POST['t_hadir'])) {
            $_SESSION["hadir"] = $_POST["t_hadir"];
            $sql_produk = sql("SELECT * FROM orders 
                INNER JOIN user ON orders.id_pelanggan=user.id_user WHERE tanggal='$_SESSION[hadir]'
                ORDER BY tanggal
                ");
          } elseif (isset($_POST['reset'])) {
            unset($_SESSION["hadir"]);
          } elseif (isset($_SESSION["hadir"])) {
            $sql_produk = sql("SELECT * FROM orders 
                INNER JOIN user ON orders.id_pelanggan=user.id_user WHERE tanggal='$_SESSION[hadir]'
                ORDER BY tanggal
                ");
          }
          ?>
          <br>
          <div class="table-responsive">
            <?php if (isset($sql_produk)) : ?>
              <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th width=5%>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal Transaksi</th>
                    <th>Nomor Tiket</th>
                    <th>Bukti Bayar</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($sql_produk as $transaksi) : ?>
                    <tr>
                      <th class="text-center"><?= $no; ?></th>
                      <th><?= $transaksi['nama_user']; ?></th>
                      <th><?= $transaksi['tanggal']; ?></th>
                      <th><?= $transaksi['no_tiket']; ?></th>
                      <th>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#lihatbuktiModal<?= $transaksi['id'] ?>">
                          Lihat Bukti
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="lihatbuktiModal<?= $transaksi['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Bukti Pembayaran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="card bg-dark text-white">
                                  <img src="../<?= $transaksi['bukti_transfer']; ?>" class="card-img" alt="...">
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </th>
                      <th class="text-center">
                        <?php if ($transaksi['status'] == 'belum diproses') { ?>
                          <a href="proses_transaksi.php?id=<?= $transaksi['id']; ?>" class="btn btn-info btn-sm" onclick="return confirm('Are you sure?')" style="margin-right: 10px;">
                            <span class="text">Check In</span>
                          </a>
                          <a href="cancel_transaksi.php?id=<?= $transaksi['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                            <span class="text">Cancel</span>
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