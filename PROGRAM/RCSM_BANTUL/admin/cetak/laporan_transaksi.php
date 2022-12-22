<?php
session_start();
include('../function.php');
// require_once('function.php');

// Middleware
if (!isset($_SESSION['login']) || $_SESSION['login'] != "admin" || isset($_SESSION['id_pelangan'])) {
  // header('Location: logout_admin.php');
  echo "";
}

if (isset($_SESSION['laporan_tgl1']) and isset($_SESSION['laporan_tgl2'])) {
  date_default_timezone_set('Asia/Jakarta');

  // $bulan = $_SESSION['laporan_bulan'];
  // $tahun = $_SESSION['laporan_tahun'];
  // $pembelian = query_result_array("SELECT * FROM pembelian WHERE bulan_pembayaran = '$bulan' AND tahun_pembayaran = '$tahun'");

  $tgl1 = $_SESSION['laporan_tgl1'];
  $tgl2 = $_SESSION['laporan_tgl2'];


  $pembelian = query_result_array("SELECT * FROM pembelian WHERE tanggal_pembayaran BETWEEN '$tgl1' AND '$tgl2'");


  // $tanggal_produk_terjual = '01-' . $bulan . '-' . $tahun;
  // $bulan_tahun_transaksi = date('M Y', strtotime($tanggal_produk_terjual));
  $bulan_tahun_transaksi = $tgl1 . " sampai " . $tgl2;
}

?>

<?php if (isset($pembelian)) : ?>
  <?php if ($pembelian) { ?>
    <!doctype html>
    <html lang="en">

    <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <!-- Bootstrap CSS -->
      <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous"> -->
      <link rel="stylesheet" href="css/bootstrap.css">
      <title>Laporan Transaksi <?= ($bulan_tahun_transaksi) ? $bulan_tahun_transaksi : ""; ?></title>
      <style>
        @media print {

          #print {
            display: none;
          }

          @page {
            margin-top: 0;
            margin-bottom: 0;
          }
        }
      </style>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    </head>

    <body>
      <!-- Content Header (Page header) -->
      <div class="container-fluid mt-3">
        <div class="row text-center">
          <div class="col">
            <img src="../gambar/LOGO RCSM.png" width="70px" class="d-inline-block">

            <h1>Data Transaksi</h1>
            <h4> <?= $bulan_tahun_transaksi; ?></h4>
            <p>Tanggal Cetak : <?= date('d M Y'); ?></p>
          </div>
        </div>

        <div class="row button-print" id="print">
          <div class="card-body">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
              Print atau Save
            </button>
          </div>
        </div>

        <?php if (isset($pembelian)) { ?>
          <div class="row mt-4">
            <div class="col-12">
              <div class="card">
                <div class="card-body table-responsive p-0">
                  <table class="table table-bordered">
                    <tbody>
                      <?php $nmr = 1; ?>
                      <?php foreach ($pembelian as $p) : ?>
                        <tr class="bg-light">
                          <?php
                          $id_pelangan = $p['id_pelangan'];
                          $data_pelangan = query_result("SELECT * FROM pelangan WHERE id_pelangan = $id_pelangan");
                          ?>
                          <td colspan="3"><strong class="text-primary">Transaksi Oleh : </strong> <?= $data_pelangan['nama'] . " (" . $data_pelangan['email'] . ") -" . $data_pelangan['telp']; ?></td>
                        </tr>
                        <tr>
                          <td><strong>Tanggal Pembayaran</strong> : <?= $p['tanggal_pembayaran']; ?></td>
                          <td colspan="2"><strong>Total Pembayaran :</strong> Rp.<?= $p['total_pembayaran']; ?></td>
                        </tr>
                        <tr>
                          <td><strong>Paket Pengiriman : </strong><?= $p['ekspedisi_paket']; ?>(<?= $p['ekspedisi']; ?>)</td>
                          <td><strong>total berat : </strong><?= $p['berat']; ?>gram</td>
                          <td><strong>biaya pengiriman : </strong>Rp.<?= $p['biaya_pengiriman']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="3" class="text-center bg-light">
                            <strong>---------------------Detail Produk Dibeli---------------------</strong>
                          </td>
                        </tr>

                        <?php $id_pembelian = $p['id_pembelian']; ?>
                        <?php $data_pembelian_detail = query_result_array("SELECT produk.nama,pembelian_detail.jumlah_barang,pembelian_detail.total_harga FROM pembelian_detail 
                                                                        INNER JOIN produk ON pembelian_detail.id_produk=produk.id 
                                                                        WHERE pembelian_detail.id_pembelian = $id_pembelian;"); ?>

                        <?php foreach ($data_pembelian_detail as $d) : ?>
                          <tr>
                            <td><?= $d['nama']; ?></td>
                            <td><?= $d['jumlah_barang']; ?>pcs</td>
                            <td>Rp.<?= $d['total_harga']; ?></td>
                          </tr>
                        <?php endforeach; ?>

                        <?php $nmr++; ?>
                      <?php endforeach; ?>

                    </tbody>
                  </table>
                </div><!-- /.card-body -->
              </div><!-- /.card -->
            </div>
          </div><!-- /.row -->
        <?php }  ?>
      </div>
      <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script> -->
      <script src="js/bootstrap.js"></script>

    </body>
    <script>
      // window.print()

      const buttonPrint = document.querySelector('.button-print');

      buttonPrint.addEventListener('click', function() {
        window.print();
      })
    </script>

    </html>
<?php }
endif; ?>