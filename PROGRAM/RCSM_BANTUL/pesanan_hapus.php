<?php
session_start();
include "admin/function.php";

if (isset($_POST['status_pembelian']) && isset($_POST['id_pembelian'])) {
  $id_pembelian = $_POST['id_pembelian'];
  $status_pembelian = $_POST['status_pembelian'];
  // var_dump($_POST);
  if ($status_pembelian != 'belum bayar' ||  $status_pembelian != 'lunas' || $status_pembelian != 'menungu konfirmasi') {
    query("DELETE FROM pembelian WHERE id_pembelian = $id_pembelian");
    query("DELETE FROM pembelian_detail WHERE id_pembelian = $id_pembelian");
    // echo "<br>ahai<br>";
    // var_dump($_POST);
    header("Location: pesanan_daftar.php");
  } else {
    header("Location: pesanan_daftar.php");
  }
} else {
  header("Location: pesanan_daftar.php");
}
