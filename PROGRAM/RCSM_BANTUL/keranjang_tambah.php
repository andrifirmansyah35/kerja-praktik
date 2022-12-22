<?php
session_start();
include "admin/function.php";

// Middleware
if (!isset($_SESSION['login']) || $_SESSION['login'] != "pelangan" || !isset($_SESSION['id_pelangan'])) {
  header('Location: logout.php');
}
//middleware end

if (isset($_POST['jumlah'])) {
  $id_pelangan = $_SESSION['id_pelangan'];
  $id_produk = $_POST['id_produk'];
  $jumlah = $_POST['jumlah'];
  keranjang_tambah($id_pelangan, $id_produk, $jumlah);
  header("Location:keranjang_belanja.php");
} else {
  header("Location:index.php");
}
