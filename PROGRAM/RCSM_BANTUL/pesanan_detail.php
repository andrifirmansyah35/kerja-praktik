<?php
session_start();
include "admin/function.php";

if (isset($_GET['pesanan']) && isset($_SESSION['id_pelangan'])) {
  $id_pembelian = $_GET['pesanan'];
  $id_pelangan = $_SESSION['id_pelangan'];
  $data_pembelian = pembelian_pelangan_info($id_pelangan, $id_pembelian);

  if ($data_pembelian) {
    // $data_pembelian_ongkir  = pembelian_ongkir($data_pembelian['id_ongkir']);
    // $data_pembelian_ongkir = "$data_pembelian_ongkir[provinsi] $data_pembelian_ongkir[kota] - $data_pembelian_ongkir[harga]";

    $pembelian_detail_produk = pembelian_detailProduk($id_pelangan, $id_pembelian);
  }
  // $data_pembelian_detail = pembelian_pelangan_detail_info($id_pelangan, $id_pembelian);
} else {
  header("Location: pesanan_daftar.php");
}

if (isset($_POST['kofirmasi_pengiriman'])) {
  // var_dump($_POST);
  $id_pelangan = $_POST['id_pelangan'];
  $id_pembelian = $_POST['id_pembelian'];
  query("UPDATE pembelian SET status_pembelian = 'selesai' WHERE id_pelangan = $id_pelangan AND id_pembelian = $id_pembelian");
  //refresh page
  $data_pembelian = pembelian_pelangan_info($id_pelangan, $id_pembelian);
  $pembelian_detail_produk = pembelian_detailProduk($id_pelangan, $id_pembelian);
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

  <title>RCSM Bantul</title>
  <link rel="stylesheet" href="asset/style/navbar.css">
</head>

<body class="bg-light">
  <?php include 'menu.php'; ?>

  <div class="spasi-menu" style="height: 100px;"></div>


  <div class="container mb-5">

    <div class="row mt-2 mt-5 ml-2">
      <h3 style="color:rgb(235, 78, 104); font-weight: 500">Detail Pemesanan</h3>
    </div>

    <div class="row ml-2 mt-1 mb-4">
      <a href="pesanan_daftar.php" class="text-danger font-weight-light"><i class="fas fa-arrow-left mr-2"></i>Daftar Pesanan Anda</a>
    </div>

    <?php if ($data_pembelian) { ?>
      <div class="row mt-2">
        <div class="col-md-8">
          <div class="card bg-white rounded-0">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-box mr-2"></i>Informasi pesanan</h5>
              <hr>
              <p class="card-text" style="margin-top: 10px;"><?= $data_pembelian['nama']; ?> - <?= $data_pembelian['telp']; ?></p>
              <p class="font-weight-light" style="margin-top: -10px;"><?= $data_pembelian['email']; ?></p>

              <div class="form-group">
                <label class="text-secondary">Tanggal Pembelian</label>
                <input type="text" class="form-control" disabled value="<?= date('d M Y', strtotime($data_pembelian['batas_pembayaran'] . '-1 day')) ?>">
              </div>

              <div class="form-group">
                <label class="text-secondary">Berat</label>
                <input type="text" class="form-control" disabled value="<?= $data_pembelian['berat']; ?> gram">
              </div>

              <div class="form-group">
                <label class="text-secondary">Ekspedisi Pengiriman Kota</label>
                <input type="text" class="form-control" disabled value="<?= $data_pembelian['ekspedisi_kota']; ?>">
              </div>

              <div class="form-group">
                <label class="text-secondary">Pilihan Paket Pengiriman dan Harga</label>
                <input type="text" class="form-control" disabled value="<?= $data_pembelian['ekspedisi_paket']; ?>">
              </div>

              <div class="form-group">
                <label class="text-secondary">Alamat Lengkap</label>
                <textarea class="form-control" rows="3" disabled placeholder="Jalan-RT-RW-Kota-Kabupaten-Provinsi" name="alamat_pengiriman" value><?= $data_pembelian['alamat_pengiriman']; ?></textarea>
              </div>

            </div>
          </div>

          <div class="card bg-white rounded-0 mt-3">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-shopping-cart mr-2 mb-2"></i>Pesanan</h5>
              <div class="table-responsive">
                <table class="table align-middle">
                  <thead>
                    <?php $total_Harga_barang = 0; ?>
                    <?php foreach ($pembelian_detail_produk as $produk) : ?>
                      <tr class="pt-2">
                        <!-- <td>id_produk : </?= $produk['id_produk']; ?></td> -->
                        <td scope="col" class="align-middle pt-3"><img src="admin/gambar/<?= $produk['gambar']; ?>" alt="" width="100px"></td>
                        <td scope="col" class="align-middle"><?= $produk['nama']; ?></td>
                        <td scope="col" class="align-middle"><?= $produk['jumlah_barang']; ?> pcs</td>
                        <td scope="col" class="align-middle">
                          <h5 class="">RP <?= $produk['total_harga']; ?></h5>
                          <?php $total_Harga_barang += $produk['total_harga']; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card bg-danger rounded-0">
            <div class="card-body">

              <?php if ($data_pembelian['status_pembelian'] == 'pesanan dikirim') :  ?>
                <h5 class="card-title text-white"><i class="fas fa-truck mr-2"></i></i>Konfirmasi Pengiriman</h5>
                <hr style="background-color: white;">
                <form action="" method="POST">
                  <input type="hidden" name="id_pembelian" value="<?= $id_pembelian; ?>">
                  <input type="hidden" name="id_pelangan" value="<?= $id_pelangan; ?>">
                  <button class="btn btn-success w-100 mb-3 text-white" type="submit" name="kofirmasi_pengiriman"><strong>Pesanan Diterima</strong></button>
                </form>
                <p class="text-white fs-6 text" style="margin: -10px 0 15px 0;">*Pernyataan bahwa barang telah diterima</p>
              <?php endif; ?>

              <h5 class="card-title text-white"><i class="fas fa-money-bill-wave mr-2 text-white"></i>Rincian Pesanan</h5>
              <hr style="background-color: white;">
              <ul class="list-group">
                <li class="d-flex justify-content-between align-items-center">
                  <p class="text-white">Total Harga Barang</p>
                  <span>
                    <p class="text-white" style="font-size: 15px;">Rp <?= $total_Harga_barang; ?>
                  </span></p>
                  </span>
                </li>
                <li class="d-flex justify-content-between align-items-center" style="margin-top: -10px;">
                  <p class="text-white">Ongkos Kirim</p>
                  <span>
                    <p class="text-white" style="font-size: 15px;">Rp <?= $data_pembelian['biaya_pengiriman']; ?></p>
                  </span>
                </li>
                <li class="d-flex justify-content-between align-items-center">
                  <h5 class="text-white">Total Pembayaran</h5>
                  <span>
                    <h5 class="text-white">Rp <?= $data_pembelian['total_pembayaran']; ?></h5>
                  </span>
                </li>
              </ul>

              <?php if ($data_pembelian['status_pembelian'] == "belum bayar") : ?>
                <h5 class="card-title text-white mt-4"><i class="fas fa-university text-white mr-2"></i>Via Pembayaran</h5>
                <hr style="background-color: white;">
                <div class="alert alert-info w-100" style="cursor: default;">
                  <p><strong>BANK BRI</strong> 187-129128-128 <br>AN. Tri Martiwi</p>
                </div>
                <a href="pembayaran.php?pesanan=<?= $_GET['pesanan']; ?>" class="btn btn-success d-inline-block w-100 font-weight-bold mt-1">
                  <h5>bayar sekarang</h5>
                </a>
              <?php endif; ?>

              <h5 class="card-title text-white mt-4"><i class="fas fa-archive text-white mr-2"></i>Status Pembelian</h5>
              <hr style="background-color: white;">
              <div class="btn bg-white w-100 font-weight-bold text-danger" style="cursor: default;">
                <h5><?= $data_pembelian['status_pembelian']; ?></h5>
              </div>

              <?php $syarat_tampil_gambar = ['menungu konfirmasi', 'pesanan dikemas', 'pesanan dikirim', 'pesanan dikirim', 'selesai'] ?>
              <?php if (in_array($data_pembelian['status_pembelian'], $syarat_tampil_gambar)) : ?>
                <h5 class="card-title text-white mt-4"> <i class="fas fa-money-check-alt mr-2"></i></i>Bukti Pembayaran</h5>
                <hr style="background-color: white;">
                <img src="admin/gambar_transaksi/<?= $data_pembelian['bukti_pembayaran']; ?>" class="img-fluid" alt="Bukti Pembayaran : <?= $data_pembelian['bukti_pembayaran']; ?>">
              <?php endif; //bukti bayar 
              ?>

            </div>
            </ul>
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