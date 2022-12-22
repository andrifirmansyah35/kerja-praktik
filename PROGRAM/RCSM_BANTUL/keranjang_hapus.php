<?php
session_start();
include "admin/function.php";

@$id_pelangan = $_SESSION['id_pelangan'];
@$id_produk = $_POST['id_produk'];

if (isset($id_pelangan) and isset($id_produk)) {
  keranjang_hapus($id_pelangan, $id_produk);
  header("Location:keranjang_belanja.php");
} else {
  header("Location:index.php");
}
