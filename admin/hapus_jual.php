<?php
require "../config.php";
$conn = koneksi();

$id = $_GET["id"];

// Buat query untuk mengupdate data produk berdasarkan ID
$query = "DELETE FROM `produk_jual` WHERE id_produk = '$id'";

// Jalankan query dan periksa apakah update berhasil
if (mysqli_query($conn, $query)) {
  echo "<script>alert('Produk berhasil dihapus!'); window.location.href='produk_jual.php';</script>";
}
