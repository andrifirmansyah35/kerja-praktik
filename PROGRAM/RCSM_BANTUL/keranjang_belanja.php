<?php
session_start();
include "admin/function.php";

if ($_SESSION['login'] != 'pelangan') {
  header("Location: logout.php");
}

if (!isset($_SESSION['id_pelangan']) && !$_SESSION['login'] == 'pelangan') {
  header('Location:index.php');
} else if (isset($_SESSION['id_pelangan']) && $_SESSION['login'] == 'pelangan') {
  $dataKategori = kategori("SELECT * FROM kategori");
  $dataKeranjang = keranjang($_SESSION['id_pelangan']);
}

$keranjang_valid = true;
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

  <title>RCSM Bantul</title>
  <link rel="stylesheet" href="asset/style/navbar.css">
  <link rel="stylesheet" href="asset/style/keranjang.css">
</head>

<body>
  <?php include 'menu.php'; ?>
  <div class="spasi-menu" style="height: 100px;"></div>
  <div class="container">
    <div class="row mt-5">
      <h3 style="color:rgb(235, 78, 104); font-weight: 400">Keranjang Belanja</h3>

    </div>
    <div class="row mt-4">

      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th scope="col">Produk</th>
              <th scope="col">Berat</th>
              <th scope="col">Harga</th>
              <th scope="col">Jumlah</th>
              <th scope="col">Total</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($dataKeranjang) { ?>
              <?php $total_belanja = 0; ?>
              <?php foreach ($dataKeranjang as $p) : ?>
                <tr class="<?= ($p['status_barang'] == 'stok tidak tersedia' ? "bg-secondary  text-white" : "") ?>">
                  <td class="d-flex align-items-center">
                    <img src="admin/gambar/<?= $p['gambar']; ?>" width="120px" class="d-block">
                    <p class="ml-2"><?= $p['nama']; ?> (status:<?= $p['status_barang']; ?>)</p>
                    <?php if ($p['status_barang'] == "stok tidak tersedia") {
                      $keranjang_valid = false;
                    } ?>
                  </td>
                  <td class="align-middle"><?= $p['berat'] * $p['jumlah_barang']; ?></td>
                  <td class="align-middle"><?= $p['harga']; ?></td>
                  <td class="align-middle"><?= $p['jumlah_barang']; ?>
                    <form action="keranjang_ubah.php" class="d-inline-block" method="POST">
                      <input type="hidden" name="id_keranjang" value="<?= @$p['id_keranjang']; ?>">
                      <?php if ($p['status_barang'] == "tersedia") { ?>
                        <button type="submit" class="btn btn-outline-info btn-sm rounded-0 ml-1">Ubah</button>
                      <?php } ?>
                    </form>
                  </td>
                  <?php $total_harga = $p['harga'] * $p['jumlah_barang']; ?>
                  <td class="align-middle"><?= $total_harga; ?></td>
                  <td class="align-middle">
                    <form action="keranjang_hapus.php" class="d-inline-block" method="POST">
                      <input type="hidden" name="id_produk" value="<?= @$p['id']; ?>">
                      <button type="submit" class="btn <?= ($p['status_barang'] == 'stok tidak tersedia' ? "btn-danger" : "btn-outline-danger") ?> btn-sm rounded-0">Hapus</button>
                    </form>
                  </td>
                </tr>
                <?php $total_belanja += $total_harga; ?>
              <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="table-responsive">
        <table class="table">
          <tbody>
            <tr class="">
              <th class="align-middle mt-2">
                <h2>Total Belanja </h2>
              </th>
              <th class="align-middle" colspan="2">
                <h2>Rp<?= $total_belanja; ?></h2>
              </th>
              <td colspan="5" class="align-middle">
                <form action="cekout.php" class="d-inline-block w-100" method="POST">
                  <input type="hidden" name="cekout" value="<?= true; ?>">
                  <button class="btn btn-danger w-100 rounded-0" type="submit" <?php if (!$keranjang_valid) {
                                                                                  echo "disabled";
                                                                                } ?>>
                    CekOut Sekarang
                  </button>
                </form>
              </td>
            </tr>
            <tr>
              <?php if (!$keranjang_valid) { ?>
                <td colspan="6"><span style="color: red;">*Barang dari keranjang anda tidak tersedia anda dapat menghapus dari daftar keranjang anda</span></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
      </div>
    <?php } else { ?>
      <tr>
        <td colspan="5" class="align-middle text-center">
          <p style="color:rgb(250, 90, 110); font-weight: 300">Keranjang Kosong</p>
        </td>
      </tr>
    <?php } ?>
    </div>
  </div>


  <script src=" https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>

</html>