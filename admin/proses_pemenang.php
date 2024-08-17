<?php
session_start();
require "../config.php";
if (!isset($_SESSION["login_admin"])) {
  header("location:../login.php");
}
$sql_user = sql("SELECT * FROM user WHERE `level`='1'");
$no = 1;

$tanggal = $_POST["caritanggal"];

// Query untuk memeriksa apakah tanggal sudah ada di tabel pemenang
$sql_cari = sql("SELECT * FROM pemenang INNER JOIN user ON pemenang.id_user = user.id_user WHERE tanggal_lomba = '$tanggal'");

include "header.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Pemenang Lomba</h1>
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
          <div class="table-responsive">
            <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th width=5%>Juara</th>
                  <th>Nama Pelanggan</th>
                  <th>Tanggal Transaksi</th>
                  <th>Berat</th>
                  <th>Durasi</th>
                </tr>
              </thead>
              <?php
              if ($sql_cari->num_rows > 0) {
                foreach ($sql_cari as $cari) { ?>
                  <tr>
                    <td><?= $cari['juara']; ?></td>
                    <td><?= $cari['nama_user']; ?></td>
                    <td><?= $cari['tanggal_lomba']; ?></td>
                    <td><?= $cari['berat']; ?></td>
                    <td><?= $cari['durasi']; ?></td>
                  </tr>

              <?php
                }
              } else {
                // Jika data belum ada, ambil 3 data teratas dari tabel orders
                $sql_produk = sql(
                  "SELECT * 
       FROM orders 
       INNER JOIN user ON orders.id_pelanggan = user.id_user 
       WHERE `status` = 'Fishing' 
         AND tanggal = '$tanggal' 
         AND orders.berat IS NOT NULL 
       ORDER BY `orders`.`berat` DESC, `orders`.`durasi` ASC 
       LIMIT 3"
                );

                $id_user = [];
                $nama = [];
                $berat = [];
                $durasi = [];

                while ($hasil = $sql_produk->fetch_assoc()) {
                  $id_user[] = $hasil['id_pelanggan'];
                  $nama[] = $hasil['nama_user'];
                  $berat[] = $hasil['berat'];
                  $durasi[] = $hasil['durasi'];
                }

                // Memasukkan data ke tabel pemenang dan menampilkan hasilnya
                if (count($id_user) > 0) {
                  foreach ($id_user as $key => $id) {
                    $rank = $key + 1;

                    // Query untuk memasukkan data ke dalam tabel pemenang
                    $sql_insert = sql(
                      "INSERT INTO pemenang (tanggal_lomba, id_user, juara, berat, durasi) 
               VALUES ('$tanggal', '$id', '$rank', '{$berat[$key]}', '{$durasi[$key]}')"
                    );

                    // Cek apakah query berhasil
                    if ($sql_insert) {
                      echo "<tr>
                      <td>$rank</td>
                      <td>{$nama[$key]}</td>
                      <td>$tanggal</td>
                      <td>{$berat[$key]}</td>
                      <td>{$durasi[$key]}</td>
                    </tr>";
                    } else {
                      echo "Gagal memasukkan data juara " . $rank . " ke dalam tabel pemenang.<br><br>";
                    }
                  }
                } else {
                  echo "Tidak ada data yang ditemukan untuk tanggal: $tanggal.";
                }
              }
              ?>
            </table>
          </div>

          <a href="daftar_lomba.php" class="btn btn-sm btn-success mt-3">Kembali Ke Daftar Lomba</a>
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
<script src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-html5-2.3.6/b-print-2.3.6/datatables.min.js"></script>

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