<?php
require "../config.php";
$id = $_GET["id"];

$sql = sql("UPDATE orders SET `status` = 'Fishing' WHERE id='$id'");
echo "<script>
  alert('Berhasil Proses Checkin!');
  window.location.href='daftar_transaksi.php';
</script>";
