<?php
session_start();
require "config.php";
$ubahPassword = ubahPassword();
if (!isset($_SESSION['login_pelanggan'])) {
  header("location:login.php");
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
            <h1 class="mb-0">Ubah Password</h1>
            <p class="mb-0 text-white"><a href="index.php" class="text-white">Home</a> > Ubah Password</p>
          </div>
        </div>
      </div>
    </div>
  </div>



  <div class="untree_co-section">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <form action="" method="post" class="contact-form mb-3" data-aos="fade-up" data-aos-delay="200">
            <div class="form-group">
              <label class="text-black" for="password">Password Lama</label>
              <input type="password" class="form-control" id="password" name="password_lama" placeholder="Masukan Password">
            </div>
            <div class="form-group">
              <label class="text-black" for="password">Password Baru</label>
              <input type="password" class="form-control" id="password" name="password_baru" placeholder="Masukan Password">
            </div>
            <div class="form-group">
              <label class="text-black" for="password">Ulangi Password</label>
              <input type="password" class="form-control" id="password" name="ulang_password" placeholder="Masukan Password">
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
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