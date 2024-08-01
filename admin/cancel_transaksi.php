<?php
require "../config.php";
$id = $_GET["id"];

$sql = sql("UPDATE orders SET `status` = 'Cancel' WHERE id='$id'");
echo "<script>
  alert('Berhasil Cancel Checkin!');
  window.location.href='daftar_transaksi.php';
</script>";
