<?php
function koneksi()
{
  $conn = new mysqli('localhost', 'root', '', 'pemancingan') or die('Koneksi Gagal');
  return $conn;
}

function sql($sql)
{
  $conn = koneksi();
  $query = $conn->query($sql) or die(mysqli_error($conn));

  return $query;
}

function login()
{
  $conn = koneksi();
  if (isset($_POST['submit'])) {
    // Ambil dari form
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    // var_dump($email, $password);

    // ambil dari DB
    $sql = $conn->query("SELECT * FROM user WHERE email='$email' AND `password`='$password'");
    $user = $sql->fetch_assoc();
    // var_dump($user);

    if (!empty($user)) {
      if ($user['level'] == 1) {
        $_SESSION['login_pelanggan'] = true;
        $_SESSION['id_pelanggan'] = $user['id_user'];
        header("location:index.php");
      } elseif ($user['level'] == 2) {
        $_SESSION['login_admin'] = true;
        $_SESSION['id_admin'] = $user['id_user'];
        header("location:admin/index.php");
      } else {
        $_SESSION['login_owner'] = true;
        $_SESSION['id_owner'] = $user['id_user'];
        header("location:owner/index.php");
      }
    } else {
      echo "
        <script>
        alert('Email atau Password salah');
        document.location.href = 'login.php';
        </script>
        ";
    }
  }
}

function register()
{
  $conn = koneksi();
  if (isset($_POST["submit"])) {
    $nama_user = $_POST["nama_user"];
    $email = $_POST["email"];
    $nomor_hp = $_POST["nomor_hp"];
    $password = md5($_POST["password"]);
    $sql_user = $conn->query("SELECT email FROM user WHERE email='$_POST[email]'");
    $user = $sql_user->fetch_assoc();
    if (!empty($user)) {
      echo "
            <script>
            alert('Email sudah digunakan');
            document.location.href = 'register.php';
            </script>
            ";
    } else {
      $tambah = $conn->query("INSERT INTO user (nama_user, email, `password`, nomor_hp, `level`) VALUES ('$nama_user','$email','$password','$nomor_hp','1')");
      echo "
            <script>
            alert('Data berhasil Ditambahkan');
            document.location.href = 'login.php';
            </script>
            ";
      return $tambah;
    }
  }
}

function ubahProfil()
{
  $conn = koneksi();
  $id = $_SESSION['id_pelanggan'];
  $nama_pelanggan = $_POST['nama_user'];
  $nomor_hp = $_POST['nomor_hp'];

  if (isset($_POST['submit'])) {
    $update = ("UPDATE user SET nama_user='$nama_pelanggan', nomor_hp='$nomor_hp' WHERE id_user='$id'");
    if ($conn->query($update) == true) {
      echo "
      <script>
      alert('Data Profile berhasil diubah!');
      window.location.href='index.php';
      </script>
      ";
    } else {
      echo '
      <scrpit>
      alert("Data Profile gagal diubah!");
      </scrpit>
      ';
    }
  }
}

function ubahPassword()
{
  if (isset($_POST['submit'])) {
    $conn = koneksi();
    $id = $_SESSION['id_pelanggan'];
    $sql = $conn->query("SELECT * FROM user WHERE id_user='$id'");
    $query = $sql->fetch_assoc();

    $passwordlama = md5($_POST['password_lama']);
    $passwordbaru = md5($_POST['password_baru']);
    $ulang_password = md5($_POST['ulang_password']);

    $update = ("UPDATE user SET `password`='$passwordbaru' WHERE id_user='$id'");
    // var_dump($passwordbaru, $passwordlama, $ulang_password);
    // Check password lama bener ga
    if ($passwordlama !== $query['password']) {
      echo '
      <script>
      alert("Masukan Password lama dengan benar!");
      </script>
      ';
      // Check password baru 2 form sama ga 
    } elseif ($passwordlama == $passwordbaru) {
      echo '
      <script>
      alert("Password tidak boleh sama!");
      </script>
      ';
    } elseif ($passwordbaru !== $ulang_password) {
      echo '
      <script>
      alert("Masukan password baru dengan benar!");
      </script>
      ';
    } elseif ($conn->query($update) == true) {
      echo "
      <script>
      alert('Password berhasil diubah!');
      window.location.href='index.php';
      </script>
      ";
    } else {
      echo '
      <script>
      alert("Password gagal diubah!");
      </script>
      ';
    }
  }
}

// GAKEPAKE !!

function pemesanan()
{
  $conn = koneksi();

  if (isset($_POST["submit"])) {
    $id_pelanggan = $_SESSION["id_pelanggan"];
    $status = 'Booking';
    $id_jadwal = $_GET["id_jadwal"];
    $tanggal = $_GET["tanggal"];

    // Periksa apakah tanggal sudah ada di pesanan
    $stmt = $conn->prepare("SELECT * FROM pesanan WHERE id_jadwal = ? AND tanggal = ?");
    $stmt->bind_param("ss", $id_jadwal, $tanggal);
    $stmt->execute();
    $result = $stmt->get_result();
    $cari_tanggal = $result->fetch_assoc();
    $stmt->close();

    $sumber = $_FILES['bukti_bayar']['tmp_name'];
    $target = 'images/bukti_bayar/';
    $nama_bukti_bayar = $_FILES['bukti_bayar']['name'];
    $file_type = $_FILES['bukti_bayar']['type'];
    $file_error = $_FILES['bukti_bayar']['error'];

    // Validasi file upload
    if ($file_error > 0) {
      echo "<script>alert('Bukti Bayar Tidak Boleh Kosong!');</script>";
      return false;
    } elseif ($file_type != 'image/jpg' && $file_type != 'image/png' && $file_type != 'image/jpeg') {
      echo "<script>alert('Silahkan Upload Bukti Bayar Dengan Benar!');</script>";
      return false;
    } elseif ($cari_tanggal) {
      echo "<script>alert('Lapangan tidak tersedia!');</script>";
      return false;
    } else {
      if (move_uploaded_file($sumber, $target . $nama_bukti_bayar)) {
        $stmt = $conn->prepare("INSERT INTO pesanan (id_pelanggan, tanggal, id_jadwal, bukti_bayar, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $id_pelanggan, $tanggal, $id_jadwal, $nama_bukti_bayar, $status);

        if ($stmt->execute()) {
          echo "<script>
                  alert('Pesanan Anda Berhasil!');
                  window.location.href='index.php';
                </script>";
          $stmt->close();
          return true;
        } else {
          echo "<script>alert('Pesanan Gagal!');</script>";
          $stmt->close();
          return false;
        }
      } else {
        echo "<script>alert('Gagal mengupload bukti bayar!');</script>";
        return false;
      }
    }
  }
}

// ATAS GAKEPAKE !!

// Fungsi untuk mendapatkan jumlah pemancing pada tanggal tertentu
function booking($tanggal)
{
  $conn = koneksi();
  $stmt = $conn->prepare("SELECT jumlah_pemancing FROM bookings WHERE tanggal = ?");
  $stmt->bind_param("s", $tanggal);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($jumlah_pemancing);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $jumlah_pemancing;
  } else {
    $stmt->close();
    $stmt = $conn->prepare("INSERT INTO bookings (tanggal, jumlah_pemancing) VALUES (?, 0)");
    $stmt->bind_param("s", $tanggal);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    return 0;
  }
}

// Fungsi untuk mendapatkan data user dari database
function getUserData($userId)
{
  $conn = koneksi();
  $stmt = $conn->prepare("SELECT nama_user, email FROM user WHERE id_user = ?");
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $result = $stmt->get_result();
  $userData = $result->fetch_assoc();
  $stmt->close();
  $conn->close();
  return $userData;
}

// Fungsi untuk menyimpan pemesanan tiket ke database
function saveOrder($userId, $tanggal, $bukti_transfer)
{
  $conn = koneksi();

  // Mendapatkan jumlah pemancing saat ini
  $jumlah_pemancing = booking($tanggal);

  // Menambahkan pemancing baru
  $stmt = $conn->prepare("UPDATE bookings SET jumlah_pemancing = jumlah_pemancing + 1 WHERE tanggal = ?");
  $stmt->bind_param("s", $tanggal);
  $stmt->execute();
  $stmt->close();

  // Menentukan nomor tiket berdasarkan jumlah pemancing
  $no_tiket = $jumlah_pemancing + 1;

  // Menyimpan pesanan tiket
  $stmt = $conn->prepare("INSERT INTO orders (id_pelanggan, tanggal, no_tiket, bukti_transfer, `status`) VALUES (?, ?, ?, ?, 'belum diproses')");
  $stmt->bind_param("isis", $userId, $tanggal, $no_tiket, $bukti_transfer);
  $stmt->execute();
  $stmt->close();

  $conn->close();
}

function saveBerat()
{
  $berat = $_POST["berat"];
  $durasi = $_POST["durasi"];
  $id = $_POST["id"];

  $conn = koneksi();

  if ($conn) {
    // Menggunakan prepared statement untuk menghindari SQL Injection
    $stmt = $conn->prepare("UPDATE orders SET berat = $berat, durasi= $durasi WHERE id = $id");
    if ($stmt->execute()) {
      echo "<script>
                  alert('Berhasil Diubah!');
                  window.location.href='daftar_lomba.php';
                </script>";
    } else {
      echo "<script>
                  alert('Pesanan Anda Gagal!');
                  window.location.href='daftar_lomba.php';
                </script>";
    }
  }
}

function saveJual()
{
  $nama_produk = $_POST["nama_produk"];
  $harga = $_POST["harga"];
  $conn = koneksi();
  if (isset($_POST["simpan"])) {
    $stmt = $conn->prepare("INSERT INTO produk_jual (nama_produk, harga) VALUES ('$nama_produk','$harga' )");

    if ($stmt->execute()) {
      echo "<script>
              alert('Berhasil Ditambahkan!');
              window.location.href='produk_jual.php';
            </script>";
      $stmt->close();
      return true;
    } else {
      echo "<script>alert('Gagal Ditambahkan!');</script>";
      $stmt->close();
      return false;
    }
  }
}


function editJual()
{
  $conn = koneksi();

  $id = $_POST['id_produk'];
  $nama = $_POST['nama_produk'];
  $harga = $_POST['harga'];

  // Buat query untuk mengupdate data produk berdasarkan ID
  $query = "UPDATE produk_jual SET nama_produk = '$nama', harga = $harga WHERE id_produk = '$id'";

  // Jalankan query dan periksa apakah update berhasil
  if (mysqli_query($conn, $query)) {
    return true;
  } else {
    // Menangani error jika terjadi kesalahan saat menjalankan query
    error_log('Query error: ' . mysqli_error($conn));
    return false;
  }
}

function saveSewa()
{
  $nama_produk = $_POST["nama_produk"];
  $harga = $_POST["harga"];
  $conn = koneksi();
  if (isset($_POST["simpan"])) {
    $stmt = $conn->prepare("INSERT INTO produk_sewa (nama_produk, harga) VALUES ('$nama_produk','$harga' )");

    if ($stmt->execute()) {
      echo "<script>
              alert('Berhasil Ditambahkan!');
              window.location.href='produk_sewa.php';
            </script>";
      $stmt->close();
      return true;
    } else {
      echo "<script>alert('Gagal Ditambahkan!');</script>";
      $stmt->close();
      return false;
    }
  }
}


function editSewa()
{
  $conn = koneksi();

  $id = $_POST['id_produk'];
  $nama = $_POST['nama_produk'];
  $harga = $_POST['harga'];

  // Buat query untuk mengupdate data produk berdasarkan ID
  $query = "UPDATE produk_sewa SET nama_produk = '$nama', harga = $harga WHERE id_produk = '$id'";

  // Jalankan query dan periksa apakah update berhasil
  if (mysqli_query($conn, $query)) {
    return true;
  } else {
    // Menangani error jika terjadi kesalahan saat menjalankan query
    error_log('Query error: ' . mysqli_error($conn));
    return false;
  }
}

function savedaftarSewa()
{
  $id_produk = $_POST["id_produk"];
  $tanggal = $_POST["tanggal"];
  $nama_user = $_POST["nama_user"];
  $conn = koneksi();
  if (isset($_POST["simpan"])) {
    $stmt = $conn->prepare("INSERT INTO sewa (id_produk, tanggal, nama_user, `status`) VALUES ('$id_produk','$tanggal', '$nama_user', 'Belum Diproses' )");

    if ($stmt->execute()) {
      echo "<script>
              alert('Berhasil Ditambahkan!');
              window.location.href='daftar_sewa.php';
            </script>";
      $stmt->close();
      return true;
    } else {
      echo "<script>alert('Gagal Ditambahkan!');</script>";
      $stmt->close();
      return false;
    }
  }
}

function inUse()
{
  $conn = koneksi();
  $id = $_GET["id"];

  $stmt = $conn->prepare("UPDATE sewa SET `status` = 'Done' WHERE id_sewa='$id'");
  //   echo "<script>
  //   alert('Berhasil Proses!');
  //   window.location.href='daftar_sewa.php';
  // </script>";
  if ($stmt->execute()) {
    echo "<script>
          alert('Berhasil Ditambahkan!');
          window.location.href='daftar_sewa.php';
        </script>";
    $stmt->close();
    return true;
  } else {
    echo "<script>alert('Gagal Ditambahkan!');</script>";
    $stmt->close();
    return false;
  }
}
function belumProses()
{
  $conn = koneksi();
  $id = $_GET["id"];

  $stmt = $conn->prepare("UPDATE sewa SET `status` = 'In Use' WHERE id_sewa='$id'");
  //   echo "<script>
  //   alert('Berhasil Proses!');
  //   window.location.href='daftar_sewa.php';
  // </script>";
  if ($stmt->execute()) {
    echo "<script>
          alert('Berhasil Ditambahkan!');
          window.location.href='daftar_sewa.php';
        </script>";
    $stmt->close();
    return true;
  } else {
    echo "<script>alert('Gagal Ditambahkan!');</script>";
    $stmt->close();
    return false;
  }
}

function savedaftarJual()
{
  $id_produk = $_POST["id_produk"];
  $tanggal = $_POST["tanggal"];
  $nama_user = $_POST["nama_user"];
  $conn = koneksi();
  if (isset($_POST["simpan"])) {
    $stmt = $conn->prepare("INSERT INTO jual (id_produk, tanggal, nama_user, `status`) VALUES ('$id_produk','$tanggal', '$nama_user', 'Belum Diproses' )");

    if ($stmt->execute()) {
      echo "<script>
              alert('Berhasil Ditambahkan!');
              window.location.href='daftar_jual.php';
            </script>";
      $stmt->close();
      return true;
    } else {
      echo "<script>alert('Gagal Ditambahkan!');</script>";
      $stmt->close();
      return false;
    }
  }
}
