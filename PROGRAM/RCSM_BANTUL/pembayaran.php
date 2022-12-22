<?php
session_start();
include "admin/function.php";
if (!isset($_GET['pesanan']) || !isset($_SESSION['id_pelangan']) || $_GET['pesanan'] == "") {
  header("location: pesanan_daftar.php");
}

if (isset($_GET['pesanan']) && isset($_SESSION['id_pelangan'])) {
  $id_pembelian = $_GET['pesanan'];
  $id_pelangan = $_SESSION['id_pelangan'];
  $data_pembelian = pembelian_pelangan_info($id_pelangan, $id_pembelian);

  if (!$data_pembelian || $data_pembelian['status_pembelian'] != 'belum bayar') {
    // $data_pembelian_ongkir  = pembelian_ongkir($data_pembelian['id_ongkir']);
    // $data_pembelian_ongkir = "$data_pembelian_ongkir[provinsi] $data_pembelian_ongkir[kota] - $data_pembelian_ongkir[harga]";
    // $pembelian_detail_produk = pembelian_detailProduk($id_pelangan, $id_pembelian);
    header("Location: pesanan_daftar.php");
  }
}

if (isset($_POST['transaksi_pembayaran'])) {
  if (transaksi_pembayaran($_POST)) {
    echo "
    <script>
    alert('transaksi selesai harap menunggu bukti pembayaran terkonfirmasi')
    window.location.replace('pesanan_daftar.php')
    </script>";
  } else {
    echo "
    <script>
    alert('Bukti Konfirmasi Anda tidak valid')
    window.location.replace('pesanan_daftar.php')
    </script>";
  }
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

  <title>Transaksi Pembayaran </title>
  <link rel="stylesheet" href="asset/style/navbar.css">
</head>

<body class="bg-light">
  <?php include 'menu.php'; ?>

  <div class="spasi-menu" style="height: 100px;"></div>


  <div class="container mb-5">

    <div class="row mt-2 mt-5 ml-2">
      <h3 style="color:rgb(235, 78, 104); font-weight: 500">Transaksi Pembayaran</h3>
    </div>

    <div class="row ml-2 mt-1 mb-4">
      <a href="pesanan_daftar.php" class="text-danger font-weight-light"><i class="fas fa-arrow-left mr-2"></i>Daftar Pesanan Anda</a>
    </div>

    <div class="row">
      <?php
      ?>
    </div>
    <?php if ($data_pembelian) { ?>
      <div class="row mt-2">

        <div class="col-md-6 offset-md-1">
          <div class="card bg-white rounded-0">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-money-check-alt mr-2"></i>Upload Pengiriman Bukti Pembayaran</h5>
              <hr>

              <p class="alert alert-primary">
                <strong>BANK BRI</strong> 187-129128-128 Sdri. Tri Martiwi
              </p>
              <div class="form-group">

                <form method="POST" enctype="multipart/form-data">
                  <!-- <label class="text-secondary">Upload Disini</label> -->
                  <input type="file" name="gambar" class="form-control" required>
                  <small class="form-text text-info">
                    *upload gambar hanya mendukung format(png,jpg,jpeg)
                  </small>
                  <input type="hidden" name="id_pembelian" value="<?= $data_pembelian['id_pembelian']; ?>">
                  <input type="hidden" name="id_pelangan" value="<?= $data_pembelian['id_pelangan']; ?>">
              </div>


              <button type="submit" name="transaksi_pembayaran" class="btn btn-success w-100"><strong>Kirim</strong></button>
              </form>
            </div>
          </div>
        </div>

        <div class="col-md-5">
          <div class="card bg-white rounded-0">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-box mr-2"></i>Informasi pesanan</h5>
              <hr>
              <a href="pesanan_detail.php?pesanan=<?= $data_pembelian['id_pembelian']; ?>" class="badge badge-primary">Lihat Detail Pesanan</a>

              <p class="card-text" style="margin-top: 10px;"><?= $data_pembelian['nama']; ?> - <?= $data_pembelian['telp']; ?></p>
              <p class="font-weight-light" style="margin-top: -10px;"><?= $data_pembelian['email']; ?></p>

              <div class="form-group">
                <label class="text-secondary">Total Tagihan</label>
                <input type="text" class="form-control" disabled value="Rp.<?= $data_pembelian['total_pembayaran']; ?>">
              </div>

              <div class="form-group">
                <label class="text-secondary">Tanggal Pembelian</label>
                <input type="text" class="form-control" disabled value="<?= date('d M Y', strtotime($data_pembelian['batas_pembayaran'] . '-1 day')) ?>">
              </div>

              <div class="form-group">
                <label class="text-secondary">Alamat pengiriman</label>
                <textarea class="form-control" rows="3" disabled placeholder="Jalan-RT-RW-Kota-Kabupaten-Provinsi" name="alamat_pengiriman" value><?= $data_pembelian['alamat_pengiriman']; ?></textarea>
              </div>
            </div>
          </div>
        </div>



      </div>


    <?php } else { ?>
      <div class="row mt-2">
        <div class="col-md-12">
          <div class="card bg-white rounded-0">
            <div class="card-body p-5">
              <h3 class="card-title text-center"><i class="fas fa-box mr-4"></i>Pesanan Kosong</h3>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
  </div>


  <script src=" https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/50cc75fb6a.js" crossorigin="anonymous"></script>
</body>

</html>