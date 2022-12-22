<?php
session_start();
setlocale(LC_TIME, 'id_ID.utf8');
include "admin/function.php";

// Middleware
if (!isset($_SESSION['login']) || $_SESSION['login'] == "admin" || !isset($_SESSION['id_pelangan'])) {
  header('Location: logout.php');
}
// Middleware End
$id_pelangan = $_SESSION['id_pelangan'];
$data_riwayat = query_result_array("SELECT * FROM pembelian WHERE status_pembelian = 'selesai' AND id_pelangan = $id_pelangan ORDER BY id_pembelian DESC");

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

  <title>RCSM Bantul | Daftar Riwayat Pesanan</title>
  <link rel="stylesheet" href="asset/style/navbar.css">
</head>

<body class="bg-light">
  <?php include 'menu.php'; ?>
  <div class="spasi-menu" style="height: 100px;"></div>

  <div class="container mb-5">
    <div class="row mt-2 mt-5">
      <h3 style="color:rgb(235, 78, 104); font-weight: 500">Daftar Riwayat Pesanan</h3>
    </div>
    <div class="row mt-4 bg-white">
      <table class="table table-hover">
        <thead>

          <tr>
            <th scope="col">No</th>
            <th scope="col">Tanggal Pembayaran</th>
            <th scope="col">Total Pembayaran</th>
            <th scope="col">cek detail pesanan</th>
          </tr>
        </thead>
        <tbody>
          <?php $nomor = 1; ?>
          <?php if ($data_riwayat) { ?>
            <?php foreach ($data_riwayat as $data) : ?>
              <tr>
                <td><?= $nomor; ?></td>
                <td><?= $data['tanggal_pembayaran']; ?></td>
                <td>Rp.<?= $data['total_pembayaran']; ?></td>
                <td>
                  <a href="pesanan_detail.php?pesanan=<?= $data['id_pembelian']; ?>" class="badge badge-info">Detail Pesanan</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php } else { ?>
            <tr>
              <td colspan="4" class="text-center">Kosong</td>
            </tr>
          <?php } ?>

        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal -->

  <!-- Modal Hapus Pesanan-->


  <script src=" https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/50cc75fb6a.js" crossorigin="anonymous"></script>
</body>

</html>