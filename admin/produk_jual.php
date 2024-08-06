<?php
session_start();
require "../config.php";
if (!isset($_SESSION["login_admin"])) {
  header("location:../login.php");
}

$sql_jual = sql("SELECT * FROM produk_jual");
$no = 1;

if (isset($_POST["simpan"])) {
  $jual = saveJual();
}

if (isset($_POST['edit'])) {

  if (editJual()) {
    echo "<script>alert('Produk berhasil diperbarui!'); window.location.href='produk_jual.php';</script>";
  } else {
    echo "<script>alert('Gagal memperbarui produk.'); window.location.href='produk_jual.php';</script>";
  }
}


include "header.php";
?>

<!-- Konten Utama -->
<div class="content-wrapper">
  <!-- Header Konten -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Produk Jual</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Beranda</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Konten Utama -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="card-body">
          <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#exampleModal">
            Tambah Produk
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
                    <label for="nama_produk">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk" class="form-control mb-2" required placeholder="Masukkan Nama Produk">
                    <label for="harga">Harga Produk</label>
                    <input type="text" name="harga" id="harga" class="form-control" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required placeholder="Masukkan Harga Produk">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  <button type="submit" name="simpan" class="btn btn-primary">Simpan Perubahan</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Tabel Produk -->
          <div class="table-responsive">
            <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th width=5%>No</th>
                  <th>Nama Produk</th>
                  <th>Harga</th>
                  <th style="width: 14%;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($sql_jual as $transaksi) : ?>
                  <tr>
                    <th class="text-center"><?= $no; ?></th>
                    <th><?= $transaksi['nama_produk']; ?></th>
                    <th>Rp. <?= number_format($transaksi['harga']); ?></th>
                    <th>
                      <!-- Tombol untuk memicu modal edit -->
                      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editJual" data-id="<?= $transaksi['id_produk']; ?>" data-nama="<?= $transaksi['nama_produk']; ?>" data-harga="<?= $transaksi['harga']; ?>">
                        Edit
                      </button>
                      <a href="hapus_jual.php?id=<?= $transaksi['id_produk']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Hapus</a>
                    </th>
                  </tr>
                <?php
                  $no++;
                endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editJual" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <input type="hidden" name="id_produk" id="edit-id">
          <label for="nama_produk">Nama Produk</label>
          <input type="text" name="nama_produk" id="edit-nama" class="form-control mb-2" required>
          <label for="harga">Harga Produk</label>
          <input type="text" name="harga" id="edit-harga" class="form-control" onkeypress="return (event.charCode != 8 && event.charCode == 0 || (event.charCode >= 48 && event.charCode <= 57))" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" name="edit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="main-footer">
  <strong>Hak Cipta &copy; 2024 BangJohn Sport Fishing. Semua hak dilindungi.</strong>
</footer>

<!-- SCRIPTS -->
<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>

<!-- ../PLUGINS -->
<script src="../plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="../plugins/raphael/raphael.min.js"></script>
<script src="../plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="../plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE dashboard demo -->
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
          title: 'Data Produk',
          exportOptions: {
            columns: [0, 1, 2, 3]
          }
        },
        {
          extend: 'pdfHtml5',
          title: 'Data Produk',
          exportOptions: {
            columns: [0, 1, 2, 3]
          }
        }
      ]
    });
  });

  // JavaScript untuk mempopulasi modal edit dengan data yang benar
  $('#editJual').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget); // Tombol yang memicu modal
    var id = button.data('id'); // Ambil informasi dari data-* attributes
    var nama = button.data('nama');
    var harga = button.data('harga');

    var modal = $(this);
    modal.find('#edit-id').val(id);
    modal.find('#edit-nama').val(nama);
    modal.find('#edit-harga').val(harga);
  });
</script>