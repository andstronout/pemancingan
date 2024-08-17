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
          <h1 class="m-0">Daftar Pemenang Lomba</h1>
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
              <label for="">Tanggal</label>
              <input type="date" class="form-control" name="ts_awal" required>
            </div>
            <div class="col-auto mt-4">
              <button type="submit" class="btn btn-primary btn-sm" name="simpan_tanggal">Simpan</button>
              <a href="daftar_pemenang.php" class="btn btn-outline-success text-white btn-sm">Reset</a>
            </div>
          </form>
          <?php
          if (isset($_POST['simpan_tanggal'])) {
            $_SESSION["sawal"] = $_POST["ts_awal"];
            $sql_pemenang = sql("SELECT * FROM pemenang INNER JOIN user ON pemenang.id_user=user.id_user
    WHERE pemenang.tanggal_lomba ='$_SESSION[sawal]' 
    ORDER BY pemenang.tanggal_lomba;
    ");
          } else {
            $sql_pemenang = sql("SELECT * FROM pemenang INNER JOIN user ON pemenang.id_user=user.id_user
    ORDER BY `pemenang`.`tanggal_lomba` DESC");
          }
          ?>

          <br>

          <div class="table-responsive">
            <?php if (isset($sql_pemenang)) : ?>
              <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th class="text-center" width=5%>No</th>
                    <th>Tanggal</th>
                    <th>Nama Pemenang</th>
                    <th>Juara </th>
                    <th>Berat</th>
                    <th>Durasi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($sql_pemenang as $row) : ?>
                    <tr>
                      <th class="text-center"><?= $no; ?></th>
                      <td><?= $row['tanggal_lomba']; ?></td>
                      <td><?= $row['nama_user']; ?></td>
                      <td><?= $row['juara']; ?></td>
                      <td><?= $row['berat']; ?></td>
                      <td><?= $row['durasi']; ?></td>
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
          title: 'Data Pemenang Lomba',
          exportOptions: {
            columns: [0, 1, 2, 3, 4]
          }
        },
        {
          extend: 'pdfHtml5',
          title: 'Data Pemenang Lomba',
          exportOptions: {
            columns: [0, 1, 2, 3, 4]
          }
        }
      ]
    });
  });
</script>
</body>

</html>