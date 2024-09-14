<?php
session_start();
require "config.php";

if (!isset($_SESSION['login_pelanggan'])) {
  header("location:login.php");
}
$sql_lomba = sql("SELECT * FROM orders WHERE id_pelanggan = '$_SESSION[id_pelanggan]'");

function cekJuara($id_user, $tanggal_lomba)
{
  // Cek apakah user tersebut sudah menjadi juara
  $sql_juara = sql("SELECT juara FROM pemenang WHERE id_user = '$id_user' AND tanggal_lomba = '$tanggal_lomba'");

  if ($sql_juara->num_rows > 0) {
    $juara = $sql_juara->fetch_assoc();
    return "Juara " . $juara['juara'];
  }

  // Tambahkan pengecekan jika status pesanan masih belum diproses berdasarkan id_pelanggan dan tanggal_lomba
  $sql_status = sql("SELECT `status` FROM orders WHERE id_pelanggan = '$id_user' AND tanggal = '$tanggal_lomba' AND `status` = 'belum diproses'");

  if ($sql_status->num_rows > 0) {
    return "Booking";
  }

  $sql_status = sql("SELECT `status` FROM orders WHERE id_pelanggan = '$id_user' AND tanggal = '$tanggal_lomba' AND `status` = 'Cancel'");

  if ($sql_status->num_rows > 0) {
    return "Canceled";
  }

  // Jika tidak menjadi juara dan tidak dalam status booking
  return "Peserta";
}




?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="favicon.png">

  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap4" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Source+Serif+Pro:wght@400;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/jquery.fancybox.min.css">
  <link rel="stylesheet" href="fonts/icomoon/style.css">
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="css/daterangepicker.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/style.css">

  <title>Pemancingan Bang John</title>
</head>

<body>


  <div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header">
      <div class="site-mobile-menu-close">
        <span class="icofont-close js-menu-toggle"></span>
      </div>
    </div>
    <div class="site-mobile-menu-body"></div>
  </div>

  <div class="hero hero-inner" style="height: 5px;">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mx-auto text-center">
          <div class="intro-wrap">
            <h1 class="mb-0">Riwayat Lomba</h1>
          </div>
        </div>
      </div>
    </div>
  </div>



  <div class="untree_co-section">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <!-- ISI CONTENT -->
        <div class="container-fluid py-5">
          <div class="container mb-5">
            <div class="row g-5">
              <div class="col-md-12 px-5 newsletter-text wow fadeIn" data-wow-delay="0.5s">
                <div class="row">
                  <div class="col">
                    <h3 class=" mb-4">Riwayat Lomba</h3>
                  </div>
                </div>
                <div class="row d-flex align-item-center">
                  <div class="col-3">
                    <h5 class="">Tanggal Lomba</h5>
                  </div>
                  <div class="col-3">
                    <h5 class="">Nomor Bangku</h5>
                  </div>
                  <div class="col-3">
                    <h5 class="">Bukti Bayar</h5>
                  </div>
                  <div class="col-3">
                    <h5 class="">Status</h5>
                  </div>
                </div>
                <?php while ($lomba = $sql_lomba->fetch_assoc()) { ?>
                  <div class="row mt-5">
                    <div class="col-lg-3">
                      <h5 class=""> <?= $lomba['tanggal']; ?></h5>
                    </div>
                    <div class="col-lg-3">
                      <h5 class=""> <?= $lomba['no_tiket']; ?></h5>
                    </div>
                    <div class="col-lg-3">
                      <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#lihatbuktiModal<?= $lomba['id'] ?>">
                        Lihat Bukti
                      </button>

                      <!-- Modal -->
                      <div class="modal fade" id="lihatbuktiModal<?= $lomba['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Bukti Bayar</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="card bg-dark text-white">
                                <img src="images/bukti_bayar/<?= $lomba['bukti_transfer']; ?>" class="card-img" alt="...">
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      </h5>
                    </div>
                    <div class="col-lg-3">
                      <h5 class=""><?= cekJuara($_SESSION['id_pelanggan'], $lomba['tanggal']); ?></h5>
                    </div>
                  </div>
                  </form>
                <?php } ?>
              </div>
            </div>
          </div>
          <a href="index.php" class="btn btn-sm btn-primary">Halaman Utama</a>
          <!-- Newsletter End -->
        </div>
      </div>
    </div>

    <div id="overlayer"></div>
    <div class="loader">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/daterangepicker.js"></script>

    <script src="js/typed.js"></script>

    <script src="js/custom.js"></script>

</body>

</html>