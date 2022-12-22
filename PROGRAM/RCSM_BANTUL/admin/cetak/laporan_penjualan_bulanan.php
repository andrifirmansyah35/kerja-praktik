<?php
session_start();
include('../function.php');
// require_once('function.php');

// Middleware
if (!isset($_SESSION['login']) || $_SESSION['login'] != "admin" || isset($_SESSION['id_pelangan'])) {
  echo "";
}
// Middleware

if (@$_SESSION['tahun_laporan_penjualan']) {
  $tahun_laporan_penjualan = $_SESSION['tahun_laporan_penjualan'];
  $bulan_tahun_laporan_penjualan = query_result_array("SELECT bulan_pembayaran,tahun_pembayaran FROM pembelian WHERE tahun_pembayaran = '$tahun_laporan_penjualan' GROUP BY bulan_pembayaran;");
  date_default_timezone_set('Asia/Jakarta');
} else {
  echo "";
}
?>

<?php if (isset($bulan_tahun_laporan_penjualan)) : ?>
  <?php if ($bulan_tahun_laporan_penjualan) { ?>
    <!doctype html>
    <html lang="en">

    <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
      <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
      <title>Laporan Penjualan bulanan <?= @$_SESSION['tahun_laporan_penjualan']; ?></title>
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
            <h1>Data Penjualan Perbulan <?= $tahun_laporan_penjualan; ?></h1>
            <h3></h3>
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
        <div class="row">
          <div class="col-sm-12">
            <?php if (@$tahun_laporan_penjualan) : ?>
              <div class="card">
                <div class="card-body table-responsive p-0">
                  <table class="table table-bordered">
                    <?php foreach ($bulan_tahun_laporan_penjualan as $bulan) : ?>
                      <tr>
                        <td colspan="3">Penjualan : <?= date('F', mktime(0, 0, 0, $bulan['bulan_pembayaran'], 10)); ?> <?= $_SESSION['tahun_laporan_penjualan']; ?></td>
                      </tr>
                      <?php
                      $penjualan = produk_terjual($bulan['bulan_pembayaran'], $_SESSION['tahun_laporan_penjualan']);
                      ?>
                      <?php $nmr = 1; ?>
                      <?php foreach ($penjualan as $p) : ?>
                        <tr>
                          <td><?= $nmr; ?></td>
                          <td><?= $p['nama']; ?></td>
                          <td><?= $p['jumlah_terjual']; ?>pcs</td>
                        </tr>
                        <?php $nmr++; ?>
                      <?php endforeach; ?>
                      <tr>
                        <td>Profit : </td>
                        <td><strong>Rp.<?= profit_penjualan($bulan['bulan_pembayaran'], $_SESSION['tahun_laporan_penjualan'])['profit_bulanan']; ?></strong></td>
                      </tr>
                    <?php endforeach; ?>
                  </table>
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