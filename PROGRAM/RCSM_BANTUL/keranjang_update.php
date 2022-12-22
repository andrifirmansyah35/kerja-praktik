<?php
session_start();
include "admin/function.php";

var_dump($_POST);
@$id_keranjang = $_POST['id_keranjang'];
// @$id_produk = $_POST['id_']
@$jumlah_barang = $_POST['jumlah'];
@$harga_barang = $_POST['harga_produk'];

if (isset($id_keranjang) && isset($jumlah_barang) && isset($harga_barang)) {
  keranjang_update($id_keranjang, $jumlah_barang, $harga_barang);
} else {
  header("Location: keranjang_belanja.php");
}

header("Location: keranjang_belanja.php");
