<?php
session_start();
include('../function.php');
// require_once('function.php');

// Middleware
if (!isset($_SESSION['login']) || $_SESSION['login'] != "admin" || isset($_SESSION['id_pelangan'])) {
  echo "";
}
// Middleware

if (@$_SESSION['laporan_tgl1'] && @$_SESSION['laporan_tgl2']) {

  $tgl1 = $_SESSION['laporan_tgl1'];
  $tgl2 = $_SESSION['laporan_tgl2'];


  $penjualan = query_result_array("SELECT produk.nama,SUM(pembelian_detail.jumlah_barang) AS jumlah_terjual
                                              FROM pembelian_detail 
                                              LEFT JOIN produk ON pembelian_detail.id_produk = produk.id 
                                              LEFT JOIN pembelian ON pembelian_detail.id_pembelian = pembelian.id_pembelian
                                              WHERE pembelian.status_pembelian = 'selesai' AND
                                              tanggal_pembayaran BETWEEN '$tgl1' AND '$tgl2' 
                                              GROUP BY produk.nama
                                              ORDER BY jumlah_terjual DESC");

  $profit = query_result("SELECT SUM(pembelian_detail.keuntungan_perproduk) AS profit_bulanan
  FROM pembelian_detail 
  LEFT JOIN produk ON pembelian_detail.id_produk = produk.id 
  LEFT JOIN pembelian ON pembelian_detail.id_pembelian = pembelian.id_pembelian
  WHERE pembelian.status_pembelian = 'selesai' AND
  tanggal_pembayaran BETWEEN '$tgl1' AND '$tgl2' ")['profit_bulanan'];

  date_default_timezone_set('Asia/Jakarta');
} else {
  echo "";
}
?>

<?php if (isset($penjualan)) : ?>
  <?php if ($penjualan) { ?>
    <!doctype html>
    <html lang="en">

    <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
      <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
      <title>Laporan Penjualan</title>
      <style>
        @media print {
          .button-print {
            display: none;
          }

          @page {
            margin-top: 0;
            margin-bottom: 0;
          }

          body {
            padding-top: 72px;
            padding-bottom: 72px;
          }
        }
      </style>
    </head>

    <body>
      <!-- Content Header (Page header) -->
      <div class="container-fluid">
        <div class="row text-center">
          <div class="col">

            <img src="../gambar/LOGO RCSM.png" width="70px" class="d-inline-block">
            <h1>Data Penjualan Produk </h1>
            <h3><?= @$tgl1 ?> --- <?= @$tgl2; ?></h3>
            <p>Tanggal Cetak : <?= date('d M Y'); ?></p>

          </div>
        </div>
        <div class="row button-print">
          <div class="card-body">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
              Print or Save
            </button>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-sm-12">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body table-responsive p-0">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama produk</th>
                          <th>Jumlah</th>
                          <!-- <th>Aksi</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (@$penjualan) { ?>
                          <?php $nmr = 1; ?>
                          <?php foreach ($penjualan as $p) : ?>
                            <tr>
                              <td><?= $nmr; ?></td>
                              <td><?= $p['nama']; ?></td>
                              <td><?= $p['jumlah_terjual']; ?></td>
                            </tr>
                            <?php $nmr++; ?>
                          <?php endforeach; ?>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div><!-- /.card-body -->
                </div><!-- /.card -->
              </div>
            </div><!-- /.row -->
            <?php if (isset($penjualan)) : ?>
              <div class="row">
                <div class="col-md-12">
                  <div class="alert alert-success">
                    <h4><strong>Profit</strong> : Rp <?= $profit; ?></h4>
                  </div>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
      <!-- <script src="js/bootstrap.js"></script> -->

    </body>
    <script>
      window.print()

      const buttonPrint = document.querySelector('.button-print');

      buttonPrint.addEventListener('click', function() {
        window.print();
      })
    </script>

    </html>
<?php }
endif; ?>