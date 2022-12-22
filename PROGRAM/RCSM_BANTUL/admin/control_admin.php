<?php


if (!isset($_GET['page'])) {
    include 'home.php';
} else if ($_GET['page'] == "kategori") {                   //1.kategori produk
    include 'control/produk/kategori.php';
} else if ($_GET['page'] == "kategoriubah") {
    include 'control/produk/kategori_ubah.php';
} else if ($_GET['page'] == "kategorihapus") {
    include 'control/produk/kategori_hapus.php';
} else if ($_GET['page'] == "produk") {                     //2.produk
    include 'control/produk/produk.php';
} else if ($_GET['page'] == "produkdetail") {                     //2.produk
    include 'control/produk/produk_detail.php';
} else if ($_GET['page'] == "produkhapus") {
    include 'control/produk/produk_hapus.php';
} else if ($_GET['page'] == "produktambah") {
    include 'control/produk/produk_tambah.php';
} else if ($_GET['page'] == "produkubah") {
    include 'control/produk/produk_ubah.php';
} else if ($_GET['page'] == "pembelian_konfirmasi") { //------------(5) Pembelian 
    include 'control/pembelian/pembayaran_konfirmasi.php';
} else if ($_GET['page'] == "pembayaran_konfirmasi_detail") {
    include 'control/pembelian/pembayaran_konfirmasi_detail.php';
} else if ($_GET['page'] == "pembelian_dikemas") {
    include 'control/pembelian/pembelian_dikemas.php';
} else if ($_GET['page'] == "pembelian_dikirim") {
    include 'control/pembelian/pembelian_dikirim.php';
} else if ($_GET['page'] == "laporan_pelangan") {  //---------------(6)laporan
    include 'control/laporan/laporan_pelangan.php';
} else if ($_GET['page'] == "penjualan_produk") {
    include 'control/laporan/laporan_penjualan.php';
} else if ($_GET['page'] == "penjualan_produk_bulanan") {
    include 'control/laporan/laporan_penjualan_bulanan.php';
} else if ($_GET['page'] == "transaksi_pembelian") {
    include 'control/laporan/laporan_transaksi.php';
} else if ($_GET['page'] == "logout") {
    include 'logout_admin.php';
}
