<?php
session_start();
setlocale(LC_TIME, 'id_ID.utf8');
include "admin/function.php";

// Middleware
if (!isset($_SESSION['login']) || $_SESSION['login'] == "admin" || !isset($_SESSION['id_pelangan'])) {
  header('Location: logout.php');
}
// Middleware End

// Cara cek keterlambatan dan upate strok
$data_pesanan_pelangan = pembelian_daftar_pelangan($_SESSION['id_pelangan']);
pembelian_cek_lambatPembayaran($data_pesanan_pelangan, $_SESSION['id_pelangan']);

$data_pesanan_pelangan = pembelian_daftar_pelangan($_SESSION['id_pelangan']);

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

  <title>RCSM Bantul | Daftar Pesanan</title>
  <link rel="stylesheet" href="asset/style/navbar.css">
</head>

<body class="bg-light">
  <?php include 'menu.php'; ?>
  <div class="spasi-menu" style="height: 100px;"></div>

  <?php //echo "<h1> id_pelangan ${_SESSION['id_pelangan']} </h1>"; 
  ?>
  <?php //var_dump($data_pesanan_pelangan) 
  ?>

  <div class="container mb-5">
    <div class="row mt-2 mt-5">
      <h3 style="color:rgb(235, 78, 104); font-weight: 500">Daftar Pemesanan</h3>
    </div>
    <div class="row mt-4 bg-white">
      <table class="table table-hover">
        <thead>

          <tr>
            <th scope="col">No</th>
            <th scope="col">Paling Lambat Pembayaran</th>
            <th scope="col">Total Pembayaran</th>
            <th scope="col">Status Pembelian</th>
            <th scope="col">Operasi</th>
          </tr>
        </thead>
        <tbody>

          <?php if ($data_pesanan_pelangan) { ?>
            <?php $nomor = 1; ?>
            <?php foreach ($data_pesanan_pelangan as $pesanan) :  ?>
              <?php $syarat_alert_pesanan = ['belum bayar', 'pesanan dikemas', 'pesanan dikirim', 'menungu konfirmasi', 'selesai'] ?>
              <!-- <tr class="</?= ($pesanan['status_pembelian'] == "belum bayar" || $pesanan['status_pembelian'] == "menungu konfirmasi") ? "" : "bg-danger"; ?>"> -->
              <tr class="<?= (!in_array($pesanan['status_pembelian'], $syarat_alert_pesanan)) ? "bg-danger" : ""; ?>">
                <th scope="row"><?= $nomor; ?></th>
                <td><?= date('d M Y', strtotime($pesanan['batas_pembayaran'])); ?></td>
                <td><?= $pesanan['total_pembayaran']; ?></td>
                <td><?= $pesanan['status_pembelian']; ?></td>
                <td>
                  <?php if ($pesanan['status_pembelian'] == 'belum bayar') : ?>
                    <a href="pembayaran.php?pesanan=<?= $pesanan['id_pembelian']; ?>" class="badge badge-success">Bayar</a>
                  <?php endif; ?>
                  <a href="pesanan_detail.php?pesanan=<?= $pesanan['id_pembelian']; ?>" class="badge badge-info">Detail Pesanan</a>

                  <?php $status_pesanan = $pesanan['status_pembelian']; ?>

                  <?php if ($status_pesanan == "belum bayar") { ?>
                    <button type="submit" class="badge badge-danger" data-toggle="modal" data-target="#id_pesanan<?= $pesanan['id_pembelian']; ?>">
                      Batalkan pesanan
                      <!-- </?= $pesanan['id_pembelian']; ?> -->
                    </button>
                  <?php } else if ($status_pesanan == "pemesanan melewati waktu" || $status_pesanan == "pemesanan gagal" || $status_pesanan == "pesanan batal") { ?>

                    <form action="pesanan_hapus.php" class="d-inline-block" method="POST">
                      <input name="id_pembelian" type="hidden" value="<?= $pesanan['id_pembelian']; ?>">
                      <input name="status_pembelian" type="hidden" value="<?= $pesanan['status_pembelian']; ?>">
                      <button class="badge badge-danger">Hapus</button>
                    </form>

                    <!-- <a href="pesanan_hapus.php?pesanan=</?= $pesanan['id_pembelian']; ?>" class="badge badge-danger">Hapus Dalam perbaikan</a> -->

                  <?php } ?>

                </td>
              </tr>
              <?php $nomor++; ?>
            <?php endforeach; ?>
          <?php } else { ?>
            <tr>
              <td colspan="5" class="align-middle text-center align-item-center">
                <p style="color:rgb(250, 90, 110); font-weight: 300" class="mt-2">Pemesanan Kosong</p>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal -->

  <!-- Modal Hapus Pesanan-->
  <?php foreach ($data_pesanan_pelangan as $pesanan) :  ?>
    <div class="modal fade" id="id_pesanan<?= $pesanan['id_pembelian']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Hapus Pesanan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="pesanan_batal.php" method="POST">
              <p>Anda Yakin akan membatalkan pesanan : <?= $pesanan['id_pembelian']; ?></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Kembali</button>
            <input type="hidden" name="id_pembelian" value="<?= $pesanan['id_pembelian']; ?>">
            <input type="hidden" name="status_pembelian" value="<?= $pesanan['status_pembelian']; ?>">
            <button type="submit" class="btn btn-danger">Batalkan Pesanan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach ?>

  <script src=" https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/50cc75fb6a.js" crossorigin="anonymous"></script>
</body>

</html>