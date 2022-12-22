<?php
session_start();
include "admin/function.php";
$data = false;
if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];
    if (getByIDProduk($id_produk) > 0) {
        $detail_produk = getByIDProduk($id_produk);
        $data = true;
    } else {
        echo "<h1>Data Tidak Ada</h1>";
        $data = false;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title><?= $namaProduk = (isset($detail_produk) ? $detail_produk['nama'] : "Detail"); ?></title>
    <link rel="stylesheet" href="asset/style/detail.css">
    <link rel="stylesheet" href="asset/style/navbar.css">
</head>

<body>
    <?php include 'menu.php'; ?>
    <div class="spasi-menu" style="height: 100px;"></div>


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container">
                <div class="row mb-2 mt-4">
                    <div class="col-sm-6">
                        <h4 style="color:rgb(235, 78, 104); font-weight: 400"><?= $judul = ($data) ? "Detail Produk" : "Produk Tidak Ditemukan"; ?></h4>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>


        <?php if ($data) : ?>
            <!-- Main content -->
            <section class=" container">
                <!-- Default box -->
                <div class="card card-solid">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <h3 class="d-inline-block d-sm-none" style="text-transform: capitalize;"><?= $detail_produk['nama']; ?></h3>
                                <div class="col-sm-12">
                                    <img src="admin/gambar/<?= $detail_produk['gambar']; ?>" class="col-12" alt="Product Image">
                                    <!-- <h3 class="my-3">LOWA Men’s Renegade GTX Mid Hiking Boots Review</h3>
                                <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terr.</p> -->

                                </div>
                            </div>
                            <div class="col-6 col-sm-6">
                                <h3 class="my-3"><?= $detail_produk['nama']; ?></h3>
                                <p><?= $detail_produk['deskripsi']; ?></p>
                                <hr>
                                <div class="bg-gray py-2 mt-4 ml-2">
                                    <h3 class="mb-1">
                                        Rp <?= number_format($detail_produk['harga'], 0, ",", "."); ?>
                                    </h3>
                                    <p>Stock : <?= $detail_produk['stok']; ?> </p>
                                </div>
                                <?php if (isset($_SESSION['id_pelangan'])) : ?>
                                    <div class="mt-2">
                                        <form action="keranjang_tambah.php" method="POST">
                                            <div class="form-group">
                                                <input type="hidden" name="id_produk" value="<?= $_GET['id']; ?>">
                                                <input type="hidden" name="harga" value="<?= $detail_produk['harga']; ?>">
                                                <div class="input-group">
                                                    <input type="number" class="form-control" min="1" name="jumlah" max="<?= $detail_produk["stok"]; ?>" placeholder="Masukkan Banyak Pesanan" value="1">
                                                    <div class="input-group-btn">
                                                        <button type="submit" class="btn btn btn-danger" name="beli">Tambah Keranjang</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </section>
            <!-- /.content -->
        <?php endif; ?>
    </div>
    <!-- /.content-wrapper -->

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>