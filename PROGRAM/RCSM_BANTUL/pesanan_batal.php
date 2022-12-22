<?php
session_start();
include "admin/function.php";

// var_dump($_POST);

if (!isset($_SESSION['id_pelangan']) || !isset($_POST['id_pembelian']) || !isset($_POST['status_pembelian'])) {
  echo "<script>
    alert('Data Pesanan Tidak Ada')
    document.location.href = 'pesanan_daftar.php'
  </script>";
}

if ($_POST['status_pembelian'] != "belum bayar") {
  echo "<script>
    alert('pembatalan pesanan hanya pada pesanan yang belum dibayar')
    document.location.href = 'pesanan_daftar.php'
  </script>";
  // header('Location: pesanan_daftar.php');
} else {
  $id_pembelian = $_POST['id_pembelian'];
  $id_pelangan = $_SESSION['id_pelangan'];
  pesanan_batal($_SESSION['id_pelangan'], $_POST['id_pembelian']);
  query("UPDATE pembelian SET status_pembelian = 'pesanan batal' WHERE id_pembelian = $id_pembelian AND id_pelangan = $id_pelangan");
  header('location: pesanan_daftar.php');
}

header('location: pesanan_daftar.php');
