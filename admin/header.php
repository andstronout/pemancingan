<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pemancingan Bang John | Dashboard</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">

  <!-- dataTable URL -->
  <link href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/datatables.min.css" rel="stylesheet" />

  <style>
    body {
      background-color: #636b65 !important;
      /* Abu-abu */
    }

    .content-wrapper {
      background-color: #636b65 !important;
      /* Abu-abu untuk konten utama */
    }
  </style>


</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-user"> Halo Admin</i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="../logout.php" class="dropdown-item">
              <i class="fas fa-arrow-left mr-2"></i> Logout
            </a>
          </div>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">Bang John Sport Fishing</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-header">Tools</li>
            <li class="nav-item">
              <a href="daftar_pelanggan.php" class="nav-link">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>
                  Daftar Pelanggan
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>
                  Lomba
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="daftar_transaksi.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Check In Lomba</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="daftar_lomba.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kelola Lomba</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>
                  Kelola Sewa
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="produk_sewa.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Produk Sewa</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="daftar_sewa.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kelola Sewa</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>
                  Kelola Transaksi
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="produk_jual.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Produk Jual</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="daftar_jual.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kelola Penjualan</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>