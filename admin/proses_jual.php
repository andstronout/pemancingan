<?php
require "../config.php";
$id = $_GET["id"];

// $sql_sewa = sql("SELECT * FROM sewa WHERE id_sewa='$id'");
// $sewa = $sql_sewa->fetch_assoc();
// if ($sewa['status'] == 'Belum Diproses') {
//   $aksi = belumProses();
// } elseif ($sewa['status'] == 'In Use') {
//   $aksi = inUse();
// }
$sql = sql("UPDATE jual SET `status` = 'Done' WHERE id_jual='$id'");
echo "<script>
  alert('Berhasil Proses!');
  window.location.href='daftar_jual.php';
</script>";
