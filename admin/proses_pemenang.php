<?php
session_start();
require "../config.php";
if (!isset($_SESSION["login_admin"])) {
  header("location:../login.php");
}
$sql_user = sql("SELECT * FROM user WHERE `level`='1'");
$no = 1;

$tanggal = $_POST["caritanggal"];
// // 
// // NANTI PAKE YANG INI
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

$juara = [];
$nama = [];
$berat = [];
$durasi = [];

while ($hasil = $sql_produk->fetch_assoc()) {
  $juara[] = $hasil['id_pelanggan'];
  $nama[] = $hasil['nama_user'];
  $berat[] = $hasil['berat'];
  $durasi[] = $hasil['durasi'];
}

$juara1 = $juara[0] ?? null;
$juara2 = $juara[1] ?? null;
$juara3 = $juara[2] ?? null;

$berat1 = $berat[0] ?? null;
$berat2 = $berat[1] ?? null;
$berat3 = $berat[2] ?? null;

$durasi1 = $durasi[0] ?? null;
$durasi2 = $durasi[1] ?? null;
$durasi3 = $durasi[2] ?? null;

$hadiah1 = 2000000;
$hadiah2 = 1500000;
$hadiah3 = 1000000;

// Query untuk memeriksa apakah tanggal sudah ada di tabel pemenang
$sql_cari = sql("SELECT * FROM pemenang WHERE tanggal_lomba = '$tanggal'");

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
          <?php
          if (count($juara) > 0) {
            if ($sql_cari->num_rows > 0) {
              // Tanggal sudah ada, tampilkan data yang ada
              $sql_join = sql(
                "SELECT p.*, 
                        u1.nama_user AS nama_juara1, 
                        u2.nama_user AS nama_juara2, 
                        u3.nama_user AS nama_juara3 
                 FROM pemenang p
                 INNER JOIN user u1 ON p.juara1 = u1.id_user
                 INNER JOIN user u2 ON p.juara2 = u2.id_user
                 INNER JOIN user u3 ON p.juara3 = u3.id_user
                 WHERE p.tanggal_lomba = '$tanggal'"
              );
              $cari = $sql_join->fetch_assoc();
          ?>
              <!-- echo "Tanggal Lomba: " . $cari['tanggal_lomba'] . "<br>";
              echo "Juara 1: " . $cari['nama_juara1'] . " (Berat: " . $cari['berat1'] . ", Durasi: " . $cari['durasi1'] . ")<br>";
              echo "Juara 2: " . $cari['nama_juara2'] . " (Berat: " . $cari['berat2'] . ", Durasi: " . $cari['durasi2'] . ")<br>";
              echo "Juara 3: " . $cari['nama_juara3'] . " (Berat: " . $cari['berat3'] . ", Durasi: " . $cari['durasi3'] . ")<br>"; ?> -->
              <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width=5%>Juara</th>
                      <th>Nama Pelanggan</th>
                      <th>Tanggal Transaksi</th>
                      <th>Berat</th>
                      <th>Durasi</th>
                      <th>Hadiah</th>
                    </tr>
                  </thead>
                  <tr>
                    <td>1</td>
                    <td><?= $cari['nama_juara1']; ?></td>
                    <td><?= $cari['tanggal_lomba']; ?></td>
                    <td><?= $cari['berat1']; ?></td>
                    <td><?= $cari['durasi1']; ?></td>
                    <td>Rp. <?= number_format($hadiah1); ?></td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td><?= $cari['nama_juara2']; ?></td>
                    <td><?= $cari['tanggal_lomba']; ?></td>
                    <td><?= $cari['berat2']; ?></td>
                    <td><?= $cari['durasi2']; ?></td>
                    <td>Rp. <?= number_format($hadiah2); ?></td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td><?= $cari['nama_juara3']; ?></td>
                    <td><?= $cari['tanggal_lomba']; ?></td>
                    <td><?= $cari['berat3']; ?></td>
                    <td><?= $cari['durasi3']; ?></td>
                    <td>Rp. <?= number_format($hadiah3); ?></td>
                  </tr>
                  <tbody>
                  </tbody>
                </table>
              </div>
          <?php
            } else {
              // Tanggal belum ada, masukkan data baru
              $sql_insert = sql(
                "INSERT INTO pemenang (tanggal_lomba, juara1, berat1, durasi1, juara2, berat2, durasi2, juara3, berat3, durasi3) 
                 VALUES ('$tanggal', '$juara1', '$berat1', '$durasi1', '$juara2', '$berat2', '$durasi2', '$juara3', '$berat3', '$durasi3')"
              );
              if ($sql_insert) {
                echo "Data berhasil dimasukkan:<br>";
                echo "Juara 1: ID $juara1, Berat $berat1, Durasi $durasi1<br>";
                echo "Juara 2: ID $juara2, Berat $berat2, Durasi $durasi2<br>";
                echo "Juara 3: ID $juara3, Berat $berat3, Durasi $durasi3<br>";
              } else {
                echo "Gagal memasukkan data.";
              }
            }
          } else {
            echo "<p class='text-center'>Tidak ada data untuk ditampilkan</p><br>";
          }
          ?>
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