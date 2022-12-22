<?php
session_start();
include "admin/function.php";

// var_dump($_POST);
// Middleware
if (!isset($_SESSION['login']) || $_SESSION['login'] == "admin" || !isset($_SESSION['id_pelangan'])) {
  header('Location: logout.php');
}
// Middleware end


echo "<br>";

if (isset($_POST) && isset($_SESSION)) {
  var_dump($_POST);
  $id_ongkir = $_POST['id_ongkir'];
  $alamat_pengiriman = htmlspecialchars($_POST['alamat_pengiriman']);
  $berat = $_POST['berat_pesanan'];
  $total_pembayaran = $_POST['total_pembayaran'];
  $biaya_kirim = $_POST['biaya_pengiriman'];
  // tambahan
  $ekspedisi_kota = $_POST['nama_kota'];
  $ekspedisi = $_POST['nama_ekspedisi']; //tiki,jne,dll
  $ekspedisi_paket = $_POST['nama_paket']; //tiki,jne,dll


  $id_pelangan = $_SESSION['id_pelangan'];

  if (!isset($alamat_pengiriman) || !isset($berat) || !isset($biaya_kirim) || !isset($total_pembayaran) || !isset($_SESSION['id_pelangan'])) {
    // header("Location: keranjang_belanja.php");
    echo "<h1>Kelengkapan Data CekOut Tidak Komplit</h1>";
  } else {
    echo "<h1>Semua Data Koplit</h1>";

    if (cekout_cekStockKeranjang($id_pelangan) == "ada barang keranjang tidak tersedia") {
      echo "<script>
              alert('Barang Yang Anda beli ada yang tidak Tersedia')
              alert('Anda Dapat Menghapus barang dikeranjang anda')
              </script>";
      echo "<h1>Ada data yang tidak ada</h1>";
    } else {
      //menyimpan barang
      echo "Barang Akan Disimpan"; //-----------------------------------
      // 1. menyimpan pembelian -------------------------
      pembelian_simpan($_SESSION['id_pelangan'], $id_ongkir, $biaya_kirim, $alamat_pengiriman, $berat, $total_pembayaran, $ekspedisi, $ekspedisi_kota, $ekspedisi_paket);
      header("Location: pesanan_daftar.php");
    }
  }
}
