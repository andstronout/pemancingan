<?php
session_start();
require "../config.php";
if (!isset($_SESSION["login_owner"])) {
  header("location:../login.php");
}
$now = date("Y-m-d");
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
          <h1 class="m-0">Daftar Lomba</h1>
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
              <button type="submit" class="btn btn-success btn-sm" name="simpan">Simpan</button>
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
          <div class="table-responsive">
            <?php if (isset($sql_produk)) : ?>
              <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th width=5%>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal Transaksi</th>
                    <th>Nomor Bangku</th>
                    <th style="width: 65px;">Berat</th>
                    <th style="width: 130px;">Durasi (Jam/Menit)</th>
                    <th width=12% class="text-center">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($sql_produk as $transaksi) : ?>
                    <tr>
                      <th class="text-center"><?= $no; ?></th>
                      <th class="text-center"><?= $transaksi['nama_user']; ?></th>
                      <th class="text-center"><?= $transaksi['tanggal']; ?></th>
                      <th class="text-center"><?= $transaksi['no_tiket']; ?></th>
                      <th class="text-center"><?= $transaksi['berat']; ?></th>
                      <th class="text-center"><?= $transaksi['durasi']; ?></th>
                      <th class="text-center"><?= $transaksi['status']; ?></th>
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
          title: 'Data Lomba',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6]
          }
        },
        {
          extend: 'pdfHtml5',
          title: 'Data Lomba',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6]
          }
        }
      ]
    });
  });

  // Menggunakan jQuery
  $('#editBerat').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget); // Tombol yang memicu modal
    var id = button.data('id'); // Ambil data-id dari tombol
    var berat = button.data('berat'); // Ambil data-berat dari tombol

    var modal = $(this);
    modal.find('#editId').val(id); // Set nilai input tersembunyi untuk ID
    modal.find('#editBerat').val(berat); // Set nilai input untuk Berat
  });

  // Fungsi untuk pilih check box atau form
  function toggleCheckbox(input) {
    document.getElementById('inlineCheckbox1').checked = false;
    if (input.value) {
      document.getElementById('inlineCheckbox1').disabled = true;
    } else {
      document.getElementById('inlineCheckbox1').disabled = false;
    }
  }

  function toggleInput(checkbox) {
    const input = document.getElementById('durasiInput');
    if (checkbox.checked) {
      input.disabled = true;
      input.value = '';
    } else {
      input.disabled = false;
    }
  }
</script>
</body>

</html>