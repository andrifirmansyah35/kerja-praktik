<?php
session_start();
include "admin/function.php";

// $_POST['id_keranjang'] = 38;
// echo "id keranjang : $_POST[id_keranjang]";
echo "<br>";
if (isset($_POST['id_keranjang'])) {
  if (keranjangGetByID($_POST['id_keranjang']) > 0) {
    $detail_keranjang = keranjangGetByID($_POST['id_keranjang']);
    // var_dump($detail_keranjang);
    echo "<br>";
    echo "<br>";
    $produk_keranjang = getByIDProduk($detail_keranjang['id_produk']);
    // var_dump($produk_keranjang);
  }
} else {
  header('Location: keranjang_belanja.php');
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <title>Ubah Data Keranjang</title>
  <link rel="stylesheet" href="asset/style/navbar.css">
  <link rel="stylesheet" href="asset/style/keranjang.css">
  <link rel="stylesheet" href="asset/style/detail.css">
</head>

<body>
  <?php include "menu.php"; ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container">
        <div class="row mb-2 mt-5">
          <div class="col-sm-6">
            <h4 style="color:rgb(235, 78, 104); font-weight: 400">Ubah Produk : <p class="ml-1" style="color: black; display:inline-block"><?= $produk_keranjang['nama']; ?></p>
            </h4>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class=" container">
      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-6">
              <h3 class="d-inline-block d-sm-none" style="text-transform: capitalize;"><?= $produk_keranjang['nama']; ?></h3>
              <div class="col-sm-12">
                <img src="admin/gambar/<?= $produk_keranjang['gambar']; ?>" class="col-12" alt="Product Image">
                <!-- <h3 class="my-3">LOWA Men’s Renegade GTX Mid Hiking Boots Review</h3>
                                <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terr.</p> -->

              </div>
            </div>
            <div class="col-6 col-sm-6">
              <h3 class="my-3"><?= $produk_keranjang['nama']; ?></h3>
              <p><?= $produk_keranjang['deskripsi']; ?></p>
              <hr>
              <div class="bg-gray py-2 mt-4 ml-2">
                <h3 class="mb-1">
                  Rp <?= number_format($produk_keranjang['harga'], 0, ",", "."); ?>
                </h3>
                <p>Stock : <?= $produk_keranjang['stok']; ?> </p>
              </div>
              <div class="mt-2">
                <form action="keranjang_update.php" method="POST">
                  <div class="form-group">
                    <input type="hidden" name="id_keranjang" value="<?= $_POST['id_keranjang']; ?>">
                    <input type="hidden" name="id_produk" value="<?= $produk_keranjang['id']; ?>">
                    <input type="hidden" name="harga_produk" value="<?= $produk_keranjang['harga']; ?>">
                    <div class="input-group">
                      <input type="number" class="form-control" min="1" name="jumlah" max="<?= $produk_keranjang["stok"]; ?>" value="<?= $detail_keranjang['jumlah_barang']; ?>">
                      <div class="input-group-btn">
                        <button type="submit" class="btn btn btn-danger" name="beli">Ubah</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>